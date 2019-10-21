<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */





/************************************************
 *  PHP Mailer
 ************************************************/
    require PATH_LIBRARY.'mail/PHPMailer-master/src/Exception.php';
    require PATH_LIBRARY.'mail/PHPMailer-master/src/PHPMailer.php';
    require PATH_LIBRARY.'mail/PHPMailer-master/src/SMTP.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    /**
     * If using gmail, please allow less secure app @link https://myaccount.google.com/lesssecureapps
     * @return PHPMailer
     * @param bool $exception
     *
    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
     *
     *
     */
    function mailer_config($exception = false){
        $mail = new \PHPMailer\PHPMailer\PHPMailer($exception);
        $mail->SMTPDebug = 0; //$exception? 0: 2
        $mail->isSMTP();
        $mail->Host = Config1::MAIL_HOST;//'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = Config1::MAIL_EMAIL;//'samtax01@gmail.com';
        $mail->Password = Config1::MAIL_PASSWORD;//'....';
        $mail->SMTPSecure = config('MAIL_SMTP_ENCRYPTION', 'tls');
        $mail->Port = Config1::MAIL_PORT;
        return $mail; // - //$mail->send();
    }


    function mailer_send_mail_to_list($toUserEmail_and_UserName_keyValue = [], $subject, $htmlMessageContent, $attachmentPath = null, $fromEmail = null, $fromUserName_orCompanyName = null, $exception = false, $mailer_config_instance = null){
        $mail = $mailer_config_instance? $mailer_config_instance: mailer_config($exception);                              // Passing `true` enables exceptions

        try {
            $result = '';
            ob_start();
                //Recipients
                $noReplyMail = explode('//', Url1::getSiteMainAddress())[1];
                $noReplyMail = 'no-reply'.'@'.(String1::contains('.', $noReplyMail)? $noReplyMail: $noReplyMail.'.com');
                $mail->setFrom(($fromEmail? $fromEmail: $noReplyMail), ($fromUserName_orCompanyName? $fromUserName_orCompanyName: Config1::APP_TITLE));
                $mail->addReplyTo(($fromEmail? $fromEmail: $noReplyMail), ($fromUserName_orCompanyName? $fromUserName_orCompanyName: Config1::APP_TITLE));

                foreach ($toUserEmail_and_UserName_keyValue as $email=>$userName) {
                    $email1 = is_numeric($email)? $userName: $email;
                    $userName1 = is_numeric($email)? Form1::extractUserName($userName, false): $userName;
                    $mail->addAddress($email1, $userName1);     // Add a recipient
                }

                //Attachments
                if($attachmentPath) $mail->addAttachment($attachmentPath, 'Attachment File');
                //Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $htmlMessageContent;
                $mail->AltBody = Html1::removeTag($htmlMessageContent);
                $status = $mail->send();
                $mail->ClearAddresses();
                if(!$status) return ResultStatus1::falseMessage('Message Sending Failed!, Due to Error: '.$mail->ErrorInfo);
            $result = ob_get_contents();
            ob_end_clean();
            if($exception && $result) dd( $result, 'Mail Status' );
            return ResultStatus1::make($status,$status? 'Message has been sent': 'Message could not be sent. Error is : '.$mail->ErrorInfo, null);
        } catch (Exception $e) {
            return ResultStatus1::falseMessage('Message could not be sent. Error is : '.$mail->ErrorInfo);
        }
    }


