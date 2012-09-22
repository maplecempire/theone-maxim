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
    public function executeIndex()
    {
        $subject = $this->getContext()->getI18N()->__("Maxim Trader Accounts Team", null, 'email');
        $text_body = "Dear " . "<tester full name>" . ",
            <p>
            <p>
            Congratulations! Your live trading account with Maxim Trader
            has been activated! Please find the details of your trading account as
            per below :
            <p>
            <p>
            Live MT4 Trading Account ID : <mt4 account id><p>
            Live MT4 Trading Account password : <mt4 password><p>
            <p>
            <p>
            The Login ID and Password is strictly confidential and should not be
            disclosed to anyone. Should someone with access to your password wish,
            all of your account information can be changed. You will be held
            liable for any activity that may occur as a result of you losing your
            password. Therefore, if you feel that your password has been
            compromised, you should immediately contact us by email to
            cs@maximtrader.com to rectify the situation.<p>
            We look forward to your custom in the near future. Should you have any
            queries, please do not hesitate to get back to us.
            <p>
            --
            <p>
            Best Regards,
            <p>
            Maxim Trader
            <p>
            E mail : admin@maximtrader.com";

        $body = "<br><table width='600' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' bgcolor='#FFFFFF' style='BORDER-COLLAPSE: collapse'>".
        //$body .= "<br><table width='500' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' bgcolor='#B5BE02' style='BORDER-COLLAPSE: collapse'>".
             "  <tr>".
             "    <td><table width='600' border='0' cellspacing='0' cellpadding='0'>".
             "      <tr>".
//             "        <td height='22' bgcolor='#9A1532'><table width='500' border='0' cellspacing='0' cellpadding='0'>".
             "        <td height='22' bgcolor='#B5BE02'><table width='600' border='0' cellspacing='0' cellpadding='0'>".
             "          <tr>".
             "            <td><span style='font-family: Arial, Verdana; font-size: 11px; font-weight: normal; color: #FFFFFF; font-weight: bold;'>&nbsp;&nbsp;&nbsp;Maxim Partner </span></td>".
             "            <td><div align='right' style='font-family: Arial, Verdana; font-size: 11px; font-weight: normal; color: #FFFFFF;'><em>Consortium by Maxim Trader&nbsp;&nbsp;&nbsp;</em></div></td>".
             "          </tr>".
             "        </table></td>".
             "      </tr>".
             "      <tr>".
             "        <td><table width='560' border='0' align='center' cellpadding='0' cellspacing='0'>".
             "          <tr>".
             "            <td>&nbsp;</td>".
             "          </tr>".
             /*"          <tr>".
             "            <td style='font-family: Arial, Verdana;font-size: 11px;font-weight: normal;color: #000000;'><strong>Maxim Trader Accounts Team</strong></td>".
             "          </tr>".*/
             "          <tr>".
             "            <td style='font-family: Arial, Verdana;font-size: 11px;font-weight: normal;color: #000000;'><img src='http://partner.maximtrader.com/css/maxim/banner/line.jpg' width='560' height='2px'></td>".
             "          </tr>".
             "          <tr>".
             "            <td style='font-family: Arial, Verdana;font-size: 11px;font-weight: normal;color: #000000;'>&nbsp;</td>".
             "          </tr>".
             "          <tr>".
             "            <td style='font-family: Arial, Verdana;font-size: 11px;font-weight: normal;color: #000000;'>
             Dear " . "<tester full name>" . ",
            <p>
            <p>
            Congratulations! Your live trading account with Maxim Trader
            has been activated! Please find the details of your trading account as
            per below :
            <p>
            <p>
            Live MT4 Trading Account ID : <mt4 account id><p>
            Live MT4 Trading Account password : <mt4 password><p>
            <p>
            <p>
            The Login ID and Password is strictly confidential and should not be
            disclosed to anyone. Should someone with access to your password wish,
            all of your account information can be changed. You will be held
            liable for any activity that may occur as a result of you losing your
            password. Therefore, if you feel that your password has been
            compromised, you should immediately contact us by email to
            cs@maximtrader.com to rectify the situation.<p>
            We look forward to your custom in the near future. Should you have any
            queries, please do not hesitate to get back to us.
            <p>
            --
            <p>
            Best Regards,
            <p>
            Maxim Trader
            <p>
            E mail : admin@maximtrader.com
             </td>".
             "          </tr>".
             "          <tr>".
             "            <td>&nbsp;</td>".
             "          </tr>".
             "          <tr>".
             "            <td><table width='560' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000' style='BORDER-COLLAPSE: collapse'>".
             "              <tr>".
             "                <td bgcolor='#CCCCCC'><table width='560' border='0' cellspacing='0' cellpadding='0'>".
             "                  <tr>".
             "                    <td>&nbsp;</td>".
             "                  </tr>".
             "                  <tr>".
             "                    <td><table width='520' border='0' align='center' cellpadding='0' cellspacing='0'>".
             "                      <tr>".
             "                        <td style='font-family: Arial, Verdana;font-size: 11px;font-weight: normal;color: #000000;'><strong>To reply to this message, follow the link below::</strong></td>".
             "                      </tr>".
             "                      <tr>".
             "                        <td style='font-family: Arial, Verdana;font-size: 11px;font-weight: normal;color: #000000;'><a href='mailto:cs@maximtrader.com'>cs@maximtrader.com</a></td>".
             "                      </tr>".
             "                    </table></td>".
             "                  </tr>".
             "                  <tr>".
             "                    <td>&nbsp;</td>".
             "                  </tr>".
             "                </table></td>".
             "              </tr>".
             "            </table></td>".
             "          </tr>".
             "          <tr>".
             "            <td>&nbsp;</td>".
             "          </tr>".
             "          <tr>".
             "            <td><img src='http://partner.maximtrader.com/css/maxim/banner/line.jpg' width='560' height='2px'></td>".
             "          </tr>".
             "        </table></td>".
             "      </tr>".
             "      <tr>".
             "        <td height='30'><div align='center' style='font-family: Arial, Verdana;font-size: 11px;font-weight: normal;color: #000000;'>Copyright @ Maxim Partner </div></td>".
             "      </tr>".
             "    </table></td>".
             "  </tr>".
             "</table>";

        error_reporting(E_STRICT);

        date_default_timezone_set(date_default_timezone_get());

        include_once('class.phpmailer.php');
        $mail = new PHPMailer();

        if (Mails::EMAIL_SMTP == true) {
            $mail->IsSMTP();
            $mail->Port = Mails::EMAIL_PORT;
            $mail->SMTPDebug = 1; // telling the class to use SMTP
            $mail->SMTPAuth = true; // telling the class to use SMTP
            $mail->SMTPSecure = "ssl"; // telling the class to use SMTP
            $mail->Username = Mails::EMAIL_SENDER;
            $mail->Password = Mails::EMAIL_PASSWORD;
        } else {
            $mail->IsMail();
            $mail->Sender = Mails::EMAIL_SENDER;
        }

        $mail->Host = Mails::EMAIL_HOST; // SMTP server
        $mail->From = Mails::EMAIL_FROM_NOREPLY;
        $mail->FromName = Mails::EMAIL_FROM_NOREPLY_NAME;
        $mail->Subject = $subject;
        $mail->CharSet="utf-8";

        //$text_body = $body;

        $mail->Body = $body;
        $mail->AltBody = $text_body;
        $mail->AddAddress("r9jason@gmail.com", "tester");
        $mail->AddBCC("r9projecthost@gmail.com", "jason");

        if (!$mail->Send()) {
            echo $mail->ErrorInfo;
        }

        //$sendMailService = new SendMailService();
        //$sendMailService->testSendMail();
        /* ********* */
        /*error_reporting(E_STRICT);

        date_default_timezone_set(date_default_timezone_get());

        include_once('class.phpmailer.php');
        var_dump("0");
        $mail = new PHPMailer();
        var_dump("1");
        if (Mails::EMAIL_SMTP == true) {
            $mail->IsSMTP();
            $mail->Port = Mails::EMAIL_PORT;
            $mail->SMTPDebug = 1; // telling the class to use SMTP
            $mail->SMTPAuth = true; // telling the class to use SMTP
            $mail->SMTPSecure = "ssl"; // telling the class to use SMTP
            $mail->Username = Mails::EMAIL_SENDER;
            $mail->Password = Mails::EMAIL_PASSWORD;
        } else {
            $mail->IsMail();
            $mail->Sender = Mails::EMAIL_SENDER;
        }
        var_dump("2");

        $mail->Host = Mails::EMAIL_HOST;
        $mail->From = Mails::EMAIL_FROM;
        $mail->FromName = Mails::EMAIL_FROM_NAME;

        var_dump("3");
        $mail->Subject = "Test Send Email Globals";
        $mail->CharSet="utf-8";

        $body = "Dear tester,<p><p>

        <p>Your Testing has been successfully</p>

        <p>Thank you</p>";

        $text_body = $body;

        $mail->Body = $body;
        $mail->AltBody = $text_body;
        $mail->AddAddress(Mails::EMAIL_TEST_MAIL, "test");
        $mail->AddBCC(Mails::EMAIL_BCC, Mails::EMAIL_BCC_NAME);

        if (!$mail->Send()) {
            echo $mail->ErrorInfo;
        } else {
            var_dump("done");
        }*/
    }
}
