<?php

/**
 * home actions.
 *
 * @package    sf_sandbox
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class homeActions extends sfActions
{

    public function executeMaintenance()
    {

    }

    public function executeDoSubmitQuestionnaire()
    {
        $mlmMemberQuestionnair = new MlmMemberQuestionnaire();
        $mlmMemberQuestionnair->setMemberId($this->getRequestParameter('memberId'));
        $mlmMemberQuestionnair->setQ1($this->getRequestParameter('q1'));
        $mlmMemberQuestionnair->setQ2($this->getRequestParameter('q2'));
        $mlmMemberQuestionnair->setQ3($this->getRequestParameter('q3'));
        $mlmMemberQuestionnair->setQ4($this->getRequestParameter('q4'));
        $mlmMemberQuestionnair->setQ5($this->getRequestParameter('q5'));
        $mlmMemberQuestionnair->setQ6($this->getRequestParameter('q6'));
        $mlmMemberQuestionnair->setQ7($this->getRequestParameter('q7'));
        $mlmMemberQuestionnair->setQ8($this->getRequestParameter('q8'));
        $mlmMemberQuestionnair->setS1($this->getRequestParameter('s1'));
        $mlmMemberQuestionnair->setS2($this->getRequestParameter('s2'));
        $mlmMemberQuestionnair->setS3($this->getRequestParameter('s3'));
        $mlmMemberQuestionnair->setStatusCode(Globals::STATUS_ACTIVE);
        $mlmMemberQuestionnair->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Thank you for the submission. Have a good day!"));
        return $this->redirect('/home/memberRegistration');
    }

    public function executeQuestionnaire()
    {

    }

    public function executeMemberRegistration()
    {
        $this->getUser()->setCulture("cn");
    }

    public function executeDoMemberRegistration()
    {
        $mlmMemberApplication = new MlmMemberApplication();
        $mlmMemberApplication->setFullName($this->getRequestParameter('fullname'));
        $mlmMemberApplication->setEmail($this->getRequestParameter('email'));
        $mlmMemberApplication->setContact($this->getRequestParameter('contactNumber'));
        $mlmMemberApplication->setQq($this->getRequestParameter('qq'));
        $mlmMemberApplication->setCountry($this->getRequestParameter('country'));
        $mlmMemberApplication->setGender($this->getRequestParameter('gender'));
        $mlmMemberApplication->setDob($this->getRequestParameter('dob'));
        $mlmMemberApplication->setStatusCode(Globals::STATUS_ACTIVE);
        $mlmMemberApplication->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlmMemberApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlmMemberApplication->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your application submit successfully. We will call u back in the soonest time."));

        $this->memberId = $mlmMemberApplication->getMemberId();
        $this->setTemplate("questionnaire");
        //return $this->redirect('/home/questionnaire');
    }

    /* ***********************************************************************
   *    ~ HTML ~
   * **********************************************************************/
    public function executeForgetPassword()
    {
        if ($this->getRequestParameter('email') && $this->getRequestParameter('username')) {
            $email = $this->getRequestParameter('email');
            $username = $this->getRequestParameter('username');

            $this->email = $email;
            $this->username = $username;

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $username);
            $c->add(MlmDistributorPeer::EMAIL, $email);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $existDistributor = MlmDistributorPeer::doSelectOne($c);

            if ($existDistributor) {
                $c = new Criteria();
                $c->add(AppUserPeer::USERNAME, $username);
                $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
                $c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $existUser = AppUserPeer::doSelectOne($c);

                if ($existUser) {
                    /****************************/
                    /*****  Send email **********/
                    /****************************/
                    $password = $existUser->getUserpassword();
                    $password2 = $existUser->getUserpassword2();

                    $subject = "Maxim Trader - Account Password Retrieval";
                    $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $existDistributor->getFullName()), 'email') . ",<p><p>
                    <p>" . $this->getContext()->getI18N()->__("On our record, you have requested to retrieve your forgotten password. Your account(s) detail together with the password is listed below.", null, 'email') . "</p>
                    <p><br><b>" . $this->getContext()->getI18N()->__("Username", null) . ": " . $username . "</b>
                    <br><b>" . $this->getContext()->getI18N()->__("Account Password", null) . ": " . $password . "</b>
                    <br><b>" . $this->getContext()->getI18N()->__("Security Password", null) . ": " . $password2 . "</b>
                    <p><br>" . $this->getContext()->getI18N()->__("If you do not requested for this password retrieval, you can simply ignore this email since only you will receive this email. For more information, please contact us.", null, 'email') . "</p>
                    <p><a href='http://partner.maximtrader.com' target='_blank'>http://partner.maximtrader.com</a>";

                    $body = "<table width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#939393' align='center'>
	<tbody>
		<tr>
			<td style='padding:20px 0px'>
				<table width='606' cellspacing='0' cellpadding='0' border='0' align='center' style='background:white;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
							<td colspan='2'>
								<a target='_blank' href='http://www.maximtrader.com'><img width='606' height='115' border='0' src='http://partner.maximtrader.com/images/email/banner.png' alt='Maxim Trader'></a></td>
						</tr>

						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
																	Dear <strong>" . $existDistributor->getFullName() . "</strong>,<br>
																	<br>" . $this->getContext()->getI18N()->__("Username", null) . ": <b>" . $username . "</b>
                                                                    <br>" . $this->getContext()->getI18N()->__("Account Password", null) . ": <b>" . $password . "</b>
                                                                    <br>" . $this->getContext()->getI18N()->__("Security Password", null) . ": <b>" . $password2 . "</b>
                                                                    <br><br>" . $this->getContext()->getI18N()->__("If you do not requested for this password retrieval, you can simply ignore this email since only you will receive this email. For more information, please contact us.", null, 'email') . "
																</font>
																<br>
																<br>
																<br>
																<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:17px'>
																Forex, spread bets and CFDs are leveraged products. They may not be suitable for you as they carry a high degree of risk to your capital and you can lose more than your initial investment. You should ensure you understand all of the risks.
																</font>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>

						<tr>
							<td width='606' style='font-size:0;line-height:0' bgcolor='#0080C8'>
							<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'>
							</td>
						</tr>
						<tr>
							<td width='606' style='font-size:0;line-height:0' colspan='2'>
								<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'>
							</td>
						</tr>

						<tr>
							<td width='606' style='padding:15px 15px 0px;color:rgb(153,153,153);font-size:11px' colspan='2' align='right'>
							<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
								<em>
									Best Regards,<br>
									<strong>Maxim Trader</strong><br>
									E mail : admin@maximtrader.com
								</em>
							</font>
							<br>
							<a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>
							<br>
						</tr>

						<tr>
							<td width='606' style='padding:5px 15px 20px;color:rgb(153,153,153);font-size:11px' colspan='2'>
							<p align='justify'>
								<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
									Maxim Trader is managed by Maxim Capital Limited which is authorised and regulated in the New Zealand by the Financial Services Provider. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (+64) 93791159, Email cs@maximtrader.com
									<br><br>Maxim Capital Limited is a subsidiary of Royale Group Holding Inc. a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
								</font>
							</p>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>";
                    $sendMailService = new SendMailService();
                    $sendMailService->sendForgetPassword($existDistributor, $subject, $body);

                    $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Password already sent to your email account. Please check your inbox."));
                } else {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Email is not matching to your username."));
                }
            } else {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Email is not matching to your username."));
            }
            return $this->redirect('/home/forgetPassword');
        }
    }

    public function executeRss()
    {
    }

    public function executeMaximExecutor()
    {
    }

    public function executeLogin2()
    {
    }

    public function executeRegister()
    {
    }

    public function executeRegister2()
    {
    }

    public function executeCompany()
    {
    }

    public function executeContactUs()
    {
    }

    public function executeIndex()
    {
    }

    public function executeIndex2()
    {
    }

    public function executeInvestment()
    {
    }

    public function executeMarketNews()
    {
    }

    /* ***********************************************************************
   *    ~ END HTML END ~
   * **********************************************************************/
    public function executeLogin()
    {
        //$this->getUser()->setCulture("en");
        $dateUtil = new DateUtil();
        /*if ($dateUtil->checkDateIsWithinRange(date("Y-m-d").' 00:00:00', date("Y-m-d").' 01:00:00', date("Y-m-d G:i:s"))) {
            return $this->redirect('home/maintenance');
        }*/

        if ($this->getUser()->hasCredential(array(Globals::PROJECT_NAME . Globals::ROLE_DISTRIBUTOR), false)) {
            return $this->redirect('home/index');
        }
        $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 2));

        // Concatenate the random string onto the random numbers
        // The font 'Anorexia' doesn't have a character for '8', so the numbers will only go up to 7
        // '0' is left out to avoid confusion with 'O'
        $str = rand(1, 7) . rand(1, 7) . $char;
        $this->getUser()->setAttribute(Globals::SYSTEM_CAPTCHA_ID, $str);

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SERVER_MAINTAIN);
        $this->appSetting = AppSettingPeer::doSelectOne($c);
    }

    public function executeRedirectToBackend()
    {

    }

    public function executeLogout()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE) {
            $existUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN_ID));

            if ($existUser) {
                $this->getUser()->clearCredentials();
                $this->getUser()->getAttributeHolder()->clear();

                $c = new Criteria();
                $c->add(MlmAdminPeer::USER_ID, $existUser->getUserId());
                $existAdmin = MlmAdminPeer::doSelectOne($c);

                $this->getUser()->clearCredentials();
                $this->getUser()->setAuthenticated(true);
                $this->getUser()->addCredential(Globals::PROJECT_NAME . $existAdmin->getAdminRole());
                $this->getUser()->addCredential(Globals::PROJECT_NAME . "dashboard");

                //var_dump($existAdmin->getAdminRole());

                $c = new Criteria();
                $c->add(AppUserRolePeer::ROLE_CODE, $existAdmin->getAdminRole());
                $exist = AppUserRolePeer::doSelectOne($c);
                if ($exist) {
                    $userAccessArr = $this->findUserAccessRole($exist->getRoleId());
                    foreach ($userAccessArr as $userAccess) {
                        $this->getUser()->addCredential(Globals::PROJECT_NAME . $userAccess);
                        //var_dump($userAccess);
                    }
                }
                //exit();
                $this->getUser()->setAttribute(Globals::SESSION_ADMINID, $existAdmin->getAdminId());
                $this->getUser()->setAttribute(Globals::SESSION_USERID, $existUser->getUserId());
                $this->getUser()->setAttribute(Globals::SESSION_USERNAME, $existUser->getUsername());
                $this->getUser()->setAttribute(Globals::SESSION_USERTYPE, $existAdmin->getAdminRole());

                return $this->redirect('home/redirectToBackend');
                //}
            }
        }

        $this->getUser()->clearCredentials();
        $this->getUser()->getAttributeHolder()->clear();
        return $this->redirect('home/login');
    }

    public function executeDoLogin()
    {
        $dateUtil = new DateUtil();
        /*if ($dateUtil->checkDateIsWithinRange(date("Y-m-d").' 00:00:00', date("Y-m-d").' 01:00:00', date("Y-m-d G:i:s"))) {
            return $this->redirect('home/maintenance');
        }*/
        if ($this->getRequestParameter('doAction') == "lang") {
            $c = new Criteria();
            $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SERVER_MAINTAIN);
            $this->appSetting = AppSettingPeer::doSelectOne($c);

            //$this->getUser()->setCulture($this->getRequestParameter('lang'));
            $this->username = $this->getRequestParameter('username');
            $this->userpassword = $this->getRequestParameter('userpassword');

            $this->setTemplate("login");
            //return $this->redirect('home/login');
        } else {
            $existUser = null;
            if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_DEV && $this->getRequestParameter('username') == "" && $this->getRequestParameter('userpassword') == "") {
                // ******************* uncomment for testing purpose ****************
                $existUser = AppUserPeer::retrieveByPk(3);
            } else {
                if ($this->getUser()->getAttribute(Globals::LOGIN_RETRY) >= 3) {
                    require_once('recaptchalib.php');
                    $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
                    $resp = recaptcha_check_answer($privatekey,
                                                   $_SERVER["REMOTE_ADDR"],
                                                   $_POST["recaptcha_challenge_field"],
                                                   $_POST["recaptcha_response_field"]);

                    if (!$resp->is_valid) {
                        $this->setFlash('errorMsg', "The CAPTCHA wasn't entered correctly. Go back and try it again.");
                        return $this->redirect('home/login');
                    }
                }

                $username = trim($this->getRequestParameter('username'));
                $password = trim($this->getRequestParameter('userpassword'));

                if ($username == '' || $password == '') {
                    $this->getUser()->setAttribute(Globals::LOGIN_RETRY, $this->getUser()->getAttribute(Globals::LOGIN_RETRY) + 1);

                    $this->setFlash('errorMsg', "Invalid username or password.");
                    return $this->redirect('home/login');
                }

                $this->getUser()->getAttributeHolder()->clear();

                /*	    user      	*/
                $array = explode(',', Globals::STATUS_ACTIVE . "," . Globals::STATUS_PENDING);
                //                $array = explode(',', Globals::STATUS_ACTIVE);
                $c = new Criteria();
                $c->add(AppUserPeer::USERNAME, $username);
                $c->add(AppUserPeer::USERPASSWORD, $password);
                $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
                $c->add(AppUserPeer::STATUS_CODE, $array, Criteria::IN);
                $existUser = AppUserPeer::doSelectOne($c);

            }

            if ($existUser) {
                $c = new Criteria();
                $c->add(MlmDistributorPeer::USER_ID, $existUser->getUserId());
                $existDist = MlmDistributorPeer::doSelectOne($c);

                /*$c = new Criteria();
                $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $existDist->getDistributorId());
                $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $distributors = MlmDistributorPeer::doSelect($c);

                if (count($distributors) > 0) {*/
                $this->getUser()->setAuthenticated(true);
                $this->getUser()->addCredential(Globals::PROJECT_NAME . $existUser->getUserRole());

                $this->getUser()->setAttribute(Globals::SESSION_DISTID, $existDist->getDistributorId());
                $this->getUser()->setAttribute(Globals::SESSION_DISTCODE, $existDist->getDistributorCode());
                $this->getUser()->setAttribute(Globals::SESSION_USERID, $existUser->getUserId());
                $this->getUser()->setAttribute(Globals::SESSION_USERNAME, $existUser->getUsername());
                $this->getUser()->setAttribute(Globals::SESSION_NICKNAME, $existDist->getNickname());
                $this->getUser()->setAttribute(Globals::SESSION_USERTYPE, $existUser->getUserRole());
                $this->getUser()->setAttribute(Globals::SESSION_USERSTATUS, $existUser->getStatusCode());

                $existUser->setLastLoginDatetime(date("Y/m/d h:i:s A"));
                $existUser->save();
                return $this->redirect('home/index');
                //return $this->redirect('member/summary');
                //}
            }

            $this->getUser()->setAttribute(Globals::LOGIN_RETRY, $this->getUser()->getAttribute(Globals::LOGIN_RETRY) + 1);

            $this->setFlash('errorMsg', "Invalid username or password.");
            return $this->redirect('home/login');
        }

    }

    public function executeVerifyExternalLogin()
    {
        $loginSuccess = false;

        $username = trim($this->getRequestParameter('username'));
        $password = trim($this->getRequestParameter('userpassword'));

        if ($username == '' || $password == '') {
            $loginSuccess = false;
        } else {
            /*	    user      	*/
            //$array = explode(',', Globals::STATUS_ACTIVE . "," . Globals::STATUS_PENDING);
            $array = explode(',', Globals::STATUS_ACTIVE);
            $c = new Criteria();
            $c->add(AppUserPeer::USERNAME, $username);
            //$c->add(AppUserPeer::USERPASSWORD, $password);
            $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
            $c->add(AppUserPeer::STATUS_CODE, $array, Criteria::IN);
            $existUser = AppUserPeer::doSelectOne($c);

            if ($existUser) {
                $md5password = md5($existUser->getUserpassword());
                //var_dump($md5password);
                if ($md5password == $password) {
                    $c = new Criteria();
                    $c->add(MlmDistributorPeer::USER_ID, $existUser->getUserId());
                    $existDist = MlmDistributorPeer::doSelectOne($c);

                    if ($existDist) {
                        $loginSuccess = true;
                    } else {
                        $loginSuccess = false;
                    }
                }
            } else {
                $loginSuccess = false;
            }
        }

        $arr = array(
            'loginSuccess' => $loginSuccess
        );
        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeLoginSecurity()
    {
        $this->setFlash('errorMsg', "Login required. This page is not public.");
        return $this->redirect('home/login');
    }

    public function executeLanguage()
    {
        $this->getUser()->setCulture($this->getRequestParameter('lang'));
        $this->redirect($this->getRequest()->getReferer());
    }

    public function executeUpdateMenuIdx()
    {
        $this->getUser()->setAttribute(Globals::SESSION_MENU_IDX, $this->getRequestParameter('menuIdx'));
        return sfView::HEADER_ONLY;
    }

    public function executeLoadDatatableLanguagePack()
    {
        if ($this->getUser()->getCulture() == "cn") {
            echo '{
                "sProcessing":   "处理中...",
                "sLengthMenu":   "显示 _MENU_ 项结果",
                "sZeroRecords":  "没有匹配结果",
                "sInfo":         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix":  "",
                "sSearch":       "搜索:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "首页",
                    "sPrevious": "上页",
                    "sNext":     "下页",
                    "sLast":     "末页"
                }
            }';
        } else {
            echo '{}';
        }
        return sfView::HEADER_ONLY;
    }
}
