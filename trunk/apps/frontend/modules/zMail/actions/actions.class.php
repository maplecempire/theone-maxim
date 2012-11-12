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
        $body = "<table width='600' align='center' cellpadding='0' cellspacing='0' border='0'>
            <tbody>
                <tr>
                    <td valign='top' colspan='3'>
                        <img src='http://partner.maximtrader.com/images/email/file/page-1.png' width='580'>
                    </td>
                </tr>

                <tr>
                    <td valign='top' colspan='3'>
                        <img src='http://partner.maximtrader.com/images/email/file/page-2.png' width='580'>
                    </td>
                </tr>

                <tr>
                    <td valign='top' colspan='3'>
                        <img src='http://partner.maximtrader.com/images/email/file/page-3.png' width='580'>
                    </td>
                </tr>

                <tr>
                    <td valign='top' colspan='3'>
                        <img src='http://partner.maximtrader.com/images/email/file/page-4.png' width='580'>
                    </td>
                </tr>
            </tbody>
        </table>";
        $subject = "Maxim";

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
        $mail->AltBody = $body;
        $mail->AddAddress("r9jason@gmail.com", "tester");
        $mail->AddBCC("r9projecthost@gmail.com", "jason");

        var_dump("hehe");
        if (!$mail->Send()) {
            echo $mail->ErrorInfo;
        }
    }
    public function executeIndex2()
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

        $body = "<table width='800' align='center' cellpadding='0' cellspacing='0' border='0'>
			<tbody><tr>
				<td valign='top' colspan='3'>
					<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tbody><tr>
							<td style='font-size:0;line-height:0' width='201' valign='top'><img src='http://partner.maximtrader.com/images/email/bg-top.png' width='201' height='226'></td>
							<td valign='top' width='551'>
								<table width='100%' cellpadding='0' cellspacing='0' border='0'>
									<tbody><tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='71'></td></tr>
									<tr>
										<td valign='top' style='font-size:0;line-height:0' width='86'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='86' height='1'></td>
										<td valign='top' style='line-height:17px'>
											<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
												Dear <strong>Jason</strong>,<br><br>
                                                Your Demo account will enable you to \"paper trade\", while allowing you to develop and test your trading strategies on the award-winning MetaTrader 4.
                                                <br><br>Your account has been opened for you with the following details:
                                                <br><br>To start trading please download and install MT4.

                                                亲爱的<STRONG>杰森</strong>，<br><br>
                                                你的模拟帐户将使你可以进行“纸上贸易”，使用MetaTrader 4可以允许你开发和测试您的交易策略。
                                                <br><br>如想立刻体验交易，请下载并安装MT4。
											</font>

											<br>
											<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:17px'>
											买外汇或者期货都是一种杠杆投资。他们可能不适合您，因为他们具有很高的风险，您可能会失去您最初的投资资金，所以您必须确保你了解所有的风险。
											</font>
										</td>
									</tr>
									<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody><tr>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														
													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														
													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														
													</td>
													<td style='font-size:0;line-height:0' width='86'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='86' height='1'></td>
													
													
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>MaximTrader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='http://partner.maximtrader.com/download/demoMt4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
													
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>My<br> Account</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='http://partner.maximtrader.com' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-access.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
									</tr>
									<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='32'></td></tr>
									<tr>
										<td valign='top' style='font-size:0;line-height:0' width='86'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='86' height='1'></td>
										<td style='font-size:0;line-height:0' bgcolor='#0080C8'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'></td>
									</tr>
									<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
									<tr>
										<td valign='top' style='line-height:15px;text-align:right' colspan='2' align='right'>
											<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
												<em>
													Best Regards,<br>
													<strong>Maxim Capital Limited</strong><br>
													E mail : admin@maximtrader.com
												</em>
											</font>
										</td>
									</tr>
								</tbody></table>
							</td>
							<td style='font-size:0;line-height:0' width='48'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='48' height='1'></td>
						</tr>
					</tbody></table>
				</td>
			</tr>
			<tr>
				<td style='font-size:0;line-height:0' width='63'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='63' height='1'></td>
				<td valign='top' width='689'>
					<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tbody><tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='28'></td></tr>
						<tr>
							<td align='right' style='text-align:right;font-size:0;line-height:0'>
								<a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>

								<br>
								<p align='justify'>
									<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
											Maxim Trader is managed by Maxim Capital Limited which is authorised and regulated in the New Zealand by the Financial Services Provider. FSP Register number is 252705. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (+64) 93791159
<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									</font>
								</p>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='16'></td></tr>
					</tbody></table>
				</td>
				<td style='font-size:0;line-height:0' width='48'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='48' height='1'></td>
			</tr>
			<tr><td colspan='3' style='font-size:0;line-height:0' bgcolor='#0080C8'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='34'></td></tr>
		</tbody></table>";

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
