<?php


class Inbox extends Model1 implements Model1ActionInterface {

    static $APP_CONFIG = [
        "MAX_CHAT_COUNT"=>15,
        "SPAM_REPORT_ID"=>2,
        "CHAT_DEPARTMENT_USER_ID_LIST"=>[
            1=>'Report Bug',
            2=>'General Support',
            3=>'Technical Issue'
        ],
    ];



    // track info
    public $id = 0;
    public $user_id = 0;
    public $to_user_id = 0;
    public $track_id = '';

    // message info
    public $subject = "";
    public $message = "";
    public $attachment = "";

    // report to admin
    public $flag_spam = false;
    public $as_read = false;
    public $deleted_by_user_id = 0;






    /**
     * Unique Chat Id Generator
     * @param array $userIdList
     * @return integer
     */
    protected static function makeTrackId(array $userIdList = []){
        return implode(',', Math1::sortNumbers($userIdList, SORT_ASC));
    }



    /**
     * An init message must be sent to the partner to initialize a conversation track_id
     * @param $to_user_id
     * @param User $userInfo
     * @return string
     */
    protected static function makeTrackIdAndInitMessage($to_user_id, $userInfo = null){
        // user info
        $userInfo = $userInfo?? Auth1::user(true);
        $isMeAdmin = self::getIfModerator($userInfo->id);
        if($to_user_id < 1) return null;
        // make track id and init message
        $track_id = self::makeTrackId([$to_user_id, $userInfo->id]);
        if(!self::exists(['track_id'=>$track_id])){
            $initMessage = "Message From ".($isMeAdmin? "Site Moderator (#$userInfo->id)": "$userInfo->full_name($userInfo->user_name), with phone number : $userInfo->phone_number and email : $userInfo->email");
            Inbox::insert([
                'message'=>$initMessage,
                'user_id'=> $userInfo->id,
                'to_user_id'=>$to_user_id,
                'track_id'=>$track_id,
                'as_read'=>1,
            ]);
        }
        return $track_id;
    }





    /**
     * Send a message from Form
     * @param $to_user_id
     * @param null $message
     * @param bool $redirectToInbox
     * @param bool $sendMail
     * @param null $userInfo
     * @return null
     */
    static function processSendMessage($to_user_id = null, $message = null, $redirectToInbox = true, $sendMail=false, $userInfo = null){
        //return true;
        $userInfo = $userInfo && $userInfo->id >0? $userInfo: Auth1::user();
        if(!$userInfo ) return null;

        $track_id = self::makeTrackIdAndInitMessage(self::request()->to_user_id, $userInfo);
        if(empty($track_id)) return Session1::setStatus("failed", 'Error #121, Cannot send message to this user', 'error');
        $result  = Inbox::insert([
            'message'=> self::request()->message,
            'user_id'=> $userInfo->id,
            'to_user_id'=>self::request()->to_user_id,
            'track_id'=>$track_id,
            'as_read'=>0,
        ]);
        if($result && isset($_FILES['attachment']['tmp_name']) && !empty($_FILES['attachment']['tmp_name']))
            $result->update(['attachment'=>$result->uploadFile($_FILES['attachment'])]);
        if($sendMail) {
            $toUserMail = User::getField($to_user_id, 'email', null);
            Session1::setStatusFrom(exUrl1::sendMail($toUserMail, "New Message from ".Config1::APP_TITLE, $message));
        }
        return $redirectToInbox? redirect(url('inbox')."?track_id=$track_id", ["Successful", 'Message Sent ', 'success']): ResultObject1::trueData("Successful");
    }


    /**
     * Link to a  conversation  (track_id)
     * @param int $to_user_id
     * @param null $userInfo
     * @return string
     */
    static function getMessageLink($to_user_id = null, $userInfo = null){
        // user info
        $userInfo = $userInfo?? Auth1::user(true);
        return url('inbox')."?track_id=".self::makeTrackId([$to_user_id, $userInfo->id]);
    }



    /**
     * Get All Conversation Unique Track Id
     * @param int $userId
     * @return array
     */
    static function getUserConversationTrackIdList($userId){
        return (self::selectManyAsList("WHERE NOT deleted_by_user_id = '$userId' AND (user_id = '$userId' OR to_user_id = '$userId') group by track_id order by track_id desc", 'track_id'));
    }

    /**
     * Get All Conversation Unique Track Id
     * @param int $userId
     * @param bool $groupCount
     * @return int
     */
    static function getUserUnreadMessagesCount($userId, $groupCount = true){
        $groupBy = $groupCount? " group by track_id ": "";
        return self::count("WHERE NOT deleted_by_user_id = '$userId' AND (to_user_id = '$userId' AND as_read = 0) $groupBy ");
    }



    /**
     * Get All Conversation Info
     * @param int $track_id
     * @return mixed
     */
    static function getTrackIdConversationList($track_id){
        return self::selectMany(false, "WHERE track_id = '$track_id' order by id asc"); //MAX(id) as
    }

    /**
     * Get Last Single Conversation Info
     * @param int $track_id
     * @return mixed
     */
    static function getTrackIdLastConversation($track_id){
        return @self::selectMany(false, "WHERE track_id = '$track_id' order by id desc limit 1", [])[0]; //MAX(id) as
    }

    /**
     * Delete message for user or for all
     * @param int $track_id
     * @param int $user_id
     * @param bool $redirect
     * @return mixed
     */
    static function deleteConversationForUser($track_id, $user_id = null, $redirect = true){
        $track_id = String1::replaceMany($track_id, '--', ','); // for CLF comma separated param transfer
        if(!self::isUserAuthorizedInConversation($track_id)) return $redirect? redirect_back(['Permission Failed', 'You have no permission to do this', 'error']): "";

        $user_id = empty($user_id)? Auth1::id(): $user_id;
        $initialDeletedBy = self::find($track_id, 'track_id', '', ['deleted_by_user_id'], false)['deleted_by_user_id'];
        if($initialDeletedBy > 0 && $initialDeletedBy != $user_id){
            $idList = self::selectManyAsList(" WHERE track_id='$track_id' ", ['id']);
            for ($i=0; $i<count($idList); $i++) Inbox::deleteBy($idList[$i]['id']);
            $result = "Message Deleted Completely";
        } else
            $result = self::updateMany(['deleted_by_user_id'=>$user_id], ['track_id'=>$track_id])? "Message Deleted": "Failed to Delete";
        return $redirect? redirect(url('/inbox'), ["Action Successful", $result, 'success']): "";
    }

    static function deleteAllConversationForUser($user_id = null){
        $user_id = empty($user_id)? Auth1::id(): $user_id;
        foreach (self::getUserConversationTrackIdList($user_id) as $track_id)
            self::deleteConversationForUser($track_id, $user_id);
    }


    /**
     * Is User Id Exists in TrackID
     * @param int $track_id
     * @param int|null $userId
     * @return mixed
     */
    static function isUserAuthorizedInConversation($track_id, int $userId = null){
        $userId = $userId?? Auth1::id();
        return in_array($userId, explode(',', $track_id)) || isset(self::$APP_CONFIG['CHAT_DEPARTMENT_USER_ID_LIST'][$userId]);
    }






    //=============================================================== UTIL HELPER

    /**
     * @param self $instance
     * @param int $count
     * @return mixed
     */
    static function makeConversationSummary($instance, $count = 50) {
        return String1::getSomeText(strip_tags($instance['subject']).' '.strip_tags($instance['message']), $count);
    }

    static function getConversationPartnerInfo($inboxInstance, $userId = null) {
        $userId = $userId? $userId: Auth1::id();

        $senderId = ($inboxInstance['user_id'] == $userId)? $inboxInstance['to_user_id']: $inboxInstance['user_id'];
        if(self::getIfModerator($senderId)) $senderFullName = "Moderator (".self::getIfModerator($senderId).")";
        else {
            $name = User::getField($senderId, 'full_name', "Unknown User #$senderId");
            $senderFullName = strpos($name, 'admin' ) > -1 ? $name."(likely Scam)": $name;
        }
        return [
          'id'=>  $senderId  ,
          'full_name'=>  $senderFullName,
          'html'=>  "",
        ];
    }
    static function getTrackIdPartnerInfo($track_id, $userId = null) {
        $ids = array_flip(explode(',', $track_id));
        unset($ids[$userId?? Auth1::id()]);
        $senderId = isset(array_keys($ids)[0])? array_keys($ids)[0]: -1;
        $full_name = self::getIfModerator($senderId)? "Moderator (".self::getIfModerator($senderId).")":  User::getField($senderId, 'full_name', "Unknown User #$senderId");
        return [
            'id'=>  $senderId,
            'full_name'=> $full_name,
            'html'=>  "",
        ];
    }

    /**
     * Attachment For Chat
     * @param $url
     * @return string
     */
    static function renderAttachment($url) {
        if(empty(trim($url))) return "";
        $widget = "";
        $fileName = FileManager1::getFileName($url);
        if(FileManager1::isImageFile($url)) $widget = "<img src='$url' style='width:auto;height:50px;margin:5px;' alt='Attachment'/><br/>";
        return "<a href='$url' target='_blank' class='btn btn-link card' style='width:auto;max-width:150px;overflow: auto'>$widget <span class='badge badge-primary'>$fileName</span><br/> Download Attachment</a><div class='clearfix'></div>";
    }


    /**
     * Is User exists in admin array
     * @param int|null $userId
     * @return mixed
     */
    static function getIfModerator(int $userId = null){ return String1::isset_or(self::$APP_CONFIG['CHAT_DEPARTMENT_USER_ID_LIST'][$userId? $userId: Auth1::id()], false); }




















    /**
     * Dashboard Menu.
     */
    static function getDashboard(){
        return [];
    }





    /**
     * Manage with HtmlForm1 or xcrud.
     */
    static function manage(){
        return new Html1(function(){
            /** @var INT $id */
            $userId = Auth1::id();
            $allMessages = self::getUserConversationTrackIdList($userId);
            if(count($allMessages)>0){
                echo "<table class='table table-striped' style='width: 100%'>";
                foreach ($allMessages as $track_id){
                    $lastConversation = self::getTrackIdLastConversation($track_id);
                    $fromUser = self::getConversationPartnerInfo($lastConversation, $userId);
                    $unread = ($lastConversation['to_user_id'] == $userId) && ($lastConversation['as_read'] == 0);
                    $unread_tag = $unread? 'strong': 'span';
                    echo "<tr>
                        <td><a href='".url("/inbox?track_id=$track_id#last")."'><strong>$fromUser[full_name]</strong><br><i class='fa ".($unread? "fa-eye": "")."'></i> <$unread_tag class='text-muted'>".self::makeConversationSummary($lastConversation)."</$unread_tag></a></td>
                        <td><label class='badge badge-dark  pull-right float-right'>".DateManager1::diffForHumans($lastConversation->updated_at)."</label></td>
                      </tr>";
                }
                echo "</table>";
            }else{
                echo "<h5 class='text-muted m-5 text-center'><i class='fa fa-envelope-open-o'></i> &nbsp;inbox is empty</h5>";
            }

        });
    }



    /**
     * Model Sidebar menu list.
     */
    static function getMenuList() {
        $totalMessageCount = self::getUserUnreadMessagesCount(Auth1::id());
        $totalMessageCountTag = $totalMessageCount>0? '<span class="badge badge-primary">'.$totalMessageCount.'</span>': "";

        return  [
            'Messages'=>[
                url('/inbox')=>"<i class='fa fa-briefcase'></i><span> Inbox $totalMessageCountTag</span>",
            ],
        ];
    }




    /**
     * Model Route List
     * for quick implementation visit
     * @see https://ehex.github.io/ehex-docs/#/BasicUsage?id=model-route-and-menu
     * @param exRoute1 $route
     */
    static function onRoute($route){
        $route->view("inbox", "pages.common.inbox.index");
    }

    /**
     * Save  Model Information
     * for quick implementation visit
     * @see https://ehex.github.io/ehex-docs/#/BasicUsage?id=model-process-save
     * @param $id
     */
    static function processSave($id = null){
        self::processSendMessage(null, null);
    }
}