<?php

/**
 * zMail actions.
 *
 * @package    sf_sandbox
 * @subpackage zMail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class zMailActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    /* ********* */

        error_reporting(E_STRICT);

        date_default_timezone_set(date_default_timezone_get());
        var_dump("init1");
        include_once('class.phpmailer.php');
        var_dump("init2");
        $mail = new PHPMailer();
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPDebug = 1; // telling the class to use SMTP
        $mail->SMTPAuth = true; // telling the class to use SMTP
        $mail->SMTPSecure = Mails::EMAIL_SMTP_SECURE; // telling the class to use SMTP
        $mail->Host = Mails::EMAIL_HOST; // SMTP server
        $mail->Port = Mails::EMAIL_PORT; // SMTP server
        $mail->Username = Mails::EMAIL_SENDER;
        $mail->Password = Mails::EMAIL_PASSWORD;
        $mail->From = Mails::EMAIL_FROM;
        $mail->FromName = Mails::EMAIL_FROM_NAME;

        $mail->Subject = "Registration email notification";
        var_dump("init3");
        $body = "Dear <jason>,<p><p>

        <p>Your registration request has been successfully sent to Maple Grow International Group</p>

        <p>User ID: </p>";

        $text_body = $body;

        $mail->Body = $body;
        $mail->AltBody = $text_body;
        $mail->AddAddress("r9jason@gmail.com", "test");
        var_dump("ready");
        if (!$mail->Send()) {
            echo $mail->ErrorInfo;
        } else {
            var_dump("done");
        }
  }
}
