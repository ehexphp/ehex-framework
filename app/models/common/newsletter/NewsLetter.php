<?php

/**
 * @backupGlobals disabled
 */
class NewsLetter extends Model1 implements Model1ActionInterface {

    public $id = 0;
    public $title = '';
    public $subject = '';
    public $body = null;

    public $as_sent = false;
    public $send_at = null;
    public $is_active = false;




    static function sendMail(){
        $mailSubscriberList = [];
        foreach (NewsLetterSubscriber::selectMany( true, '', ['email', 'full_name']) as $keyMail) $mailSubscriberList[$keyMail['email']] = $keyMail['full_name'];

        $mailContent = exMail1::getTemplate('layouts.emails.welcome', [
            'email'=>'#',
            'title'=>$_REQUEST['title'],
            'subject'=>$_REQUEST['subject'],
            'message'=>$_REQUEST['body'],
            'action_link'=>'http://kingscab.ng',
        ]);

        //$mailList = ['samsoniyanu@hotmail.com'=>'samusini hotmail', 'samsoniyanu@icloud.com'=>'samusini apple'];
        $result  = mailer_send_mail_to_list($mailSubscriberList, old('title'), $mailContent, null, null, 'KingsCab', false);
        if($result) {
            Session1::setStatus('Mail Sent', 'Last Mail Sent');
            self::insertOrUpdate(array_merge($_REQUEST, ['as_sent'=>1]));
        }
        else Session1::setStatus('Mail Sending Failed', 'Could not Send Last Mail, Please Resend');
    }


    /**
     * @return mixed|Xcrud
     */
    static function manage(){
        return self::xcrud()
            ->columns('updated_at, created_at, id', true)
            ->fields('created_at, updated_at', true)
            ->button(url('/newsletter/edit/{id}'), 'Edit', 'icon-pencil')
            ->unset_title();
    }


    /**
     * @return mixed|array
     */
    static function getMenuList() {
        return Auth1::isAdmin()? [
            'Newsletter'=>[
                url('/newsletter/create')=>'<i class="fa fa-book"></i><span> Send Newsletter</span>',
            ]
        ]: [];
    }

    static function onRoute($route){
        if(Auth1::isAdmin()){
            $route->view('/newsletter/create', 'pages.common.newsletter.admin.edit');
            $route->get('/newsletter/edit/?', function($id){ return view('pages.common.newsletter.admin.edit', ['id'=>$id]); });
        }
        $route->view('/newsletter', 'pages.common.newsletter.index');
    }

    /**
     * Dashboard Menu
     * @return array
     */
    static function getDashboard() { return []; }

    /**
     * Save  Model Information
     * @param $id
     */
    static function processSave($id = null) {
        $result = self::insert(request(['is_active']));
        if($result)  {
            Session1::setStatus('Action Successful', 'Mail Saved');

            // Send Mail
            if($result->is_active)  return self::sendMail();
        }
        else return Session1::setStatus('Failed', $result->getMessage(), 'error');
    }

}