<?php

/**
 * @backupGlobals disabled
 */
class SupportTicket extends Model1 implements Model1ActionInterface{

    public $id = 0;
    public $title = '';
    public $message = null;

    public $user_id = 0;
    public $to_user_id = 0;
    public $as_read = false;
    public $tracker_sort_id = '';   // combine messageID_senderID_receiverID



     static function sendMail(){
    //        $mailSubscriberList = [];
    //        foreach (NewsLetterSubscriber::selectMany( true, '', ['email', 'full_name']) as $keyMail) $mailSubscriberList[$keyMail['email']] = $keyMail['full_name'];
    //
    //        $mailContent = exMail1::getTemplate('layouts.emails.welcome', [
    //            'email'=>'#',
    //            'title'=>$_REQUEST['title'],
    //            'subject'=>$_REQUEST['subject'],
    //            'message'=>$_REQUEST['body'],
    //            'action_link'=>'http://kingscab.ng',
    //        ]);
    //
    //        //$mailList = ['samsoniyanu@hotmail.com'=>'samusini hotmail', 'samsoniyanu@icloud.com'=>'samusini apple'];
    //        $result  = mailer_send_mail_to_list($mailSubscriberList, old('title'), $mailContent, null, null, 'KingsCab', false);
    //        if($result) {
    //            Session1::setStatus('Mail Sent', 'Last Mail Sent');
    //            self::insertOrUpdate(array_merge($_REQUEST, ['as_sent'=>1]));
    //        }
    //        else Session1::setStatus('Mail Sending Failed', 'Could not Send Last Mail, Please Resend');
        }


    /**
     * @return mixed|Xcrud
     */
    static function manage(){
        return self::xcrud()
            ->columns('updated_at, created_at, id', true)
            ->fields('created_at, updated_at', true)
            ->button(url('/inbox/edit/{id}'), 'Edit', 'icon-pencil')
            ->unset_title();
    }

    /**
     * @return mixed|array
     */
    static function onRoute($route){}      static function getMenuList(){
        return Auth1::isAdmin()?  [
            'Messages'=>[ Dashboard::getManageUrl(self::class)=>'<i class="fa fa-info"></i><span> Support Ticket </span>', ],
        ]: [];
    }




    /**
     * Dashboard Menu
     * @return array
     */
    static function getDashboard(){   return []; }

    /**
     * Save New Model Information
     */
    static function processSave($id = null){
        $result = self::insert(request(['is_active']));
        if($result)  {
            Session1::setStatus('Sent Successful', 'Mail Saved');

            // Send Mail
            if($result->is_active)  return self::sendMail();
        }
        else return Session1::setStatus('Failed', $result->getMessage(), 'error');
    }


}