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
    public function executeAccountSuspended()
    {
        $username = $this->getRequestParameter('q');

        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $username);
        $c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_SUSPEND);
        $this->existUser = AppUserPeer::doSelectOne($c);

        if (!$this->existUser) {
            return $this->redirect('home/login');
        }
    }
    public function executeUpdatePassword()
    {
//        if ($this->getUser()->hasCredential(array(Globals::PROJECT_NAME . Globals::ROLE_DISTRIBUTOR), false)) {
//            return $this->redirect('home/index');
//        }
//
//        $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 2));
//        $str = rand(1, 7) . rand(1, 7) . $char;
//        $this->getUser()->setAttribute(Globals::SYSTEM_CAPTCHA_ID, $str);
//
//        $c = new Criteria();
//        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SERVER_MAINTAIN);
//        $this->appSetting = AppSettingPeer::doSelectOne($c);
    }
    public function executeDoSuspendUser()
    {
        /*$c = new Criteria();
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|1148|%", Criteria::LIKE);
        $dists = MlmDistributorPeer::doSelect($c);

        $i = 0;
        foreach ($dists as $dist) {
            print_r($i++."<br>");
            $appUser = AppUserPeer::retrieveByPK($dist->getUserId());

            if ($appUser) {
                $appUser->setStatusCode("SUSPEND");
                $appUser->setUserpassword("SUSPENDED");

                $remark = "SUSPENDED DUE TO BOING1491 (CHARLES)";

                if ($appUser->getRemark() != null) {
                    $remark = $appUser->getRemark().",".$remark;
                }
                $appUser->setRemark($remark);
                $appUser->save();
            }
        }*/
        $existUser = AppUserPeer::retrieveByPK(3);
        $result = date("Y-m-d H:i:s") - $existUser->getLastLoginDatetime();
        var_dump($existUser->getLastLoginDatetime());
        var_dump(date("Y-m-d H:i:s"));
        var_dump($result);

        $dateUtil = new DateUtil();
        $diff = abs(strtotime($dateUtil->formatDate("Y-m-d H:i:s", date("Y-m-d H:i:s"))) - strtotime($dateUtil->formatDate("Y-m-d H:i:s", $existUser->getLastLoginDatetime())));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        var_dump($days);
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDownloadFudan()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/docx');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=fudan_university_international_financial_forum.docx', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/fudan_university_international_financial_forum.docx");
        return sfView::NONE;
    }
    public function executeActivities_26062013()
    {
    }
    public function executeActivitiesShanghaiInternationalDinnerGathering()
    {
    }
    public function executeActivitiesBusinessPreview()
    {
    }
    public function executeActivitiesShanghaiFudan()
    {
    }
    public function executeActivitiesShanghaiInvestmentManagement()
    {
    }
    public function executeActivitiesFinancialMarketOutlook()
    {
    }
    public function executeActivities()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB) {
            $distDB->setNewActivityFlag(Globals::NO_N);
            $distDB->save();
        }
    }

    public function executeAnnouncementList()
    {
        $c = new Criteria();
        $c->add(MlmAnnouncementPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->addDescendingOrderByColumn(MlmAnnouncementPeer::CREATED_ON);
        $c->setLimit(10);
        $this->announcements = MlmAnnouncementPeer::doSelect($c);
    }

    public function executeAnnouncement()
    {
        $announcement = MlmAnnouncementPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($announcement);

        $this->announcement = $announcement;
    }

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
        //$this->getUser()->setCulture("cn");
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
//                $c->add(AppUserPeer::USERNAME, $username);
                $c->add(AppUserPeer::USER_ID, $existDistributor->getUserId());
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
									<strong>Maxim Trader Account Opening Team</strong><br>
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
									Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址�?新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12�?�?1套房
<br>电话(国际): (+64) 9925 0379 电话(新西�?: 09 925 0379
<br>邮箱�?support@maximtrader.com
<br><br>马胜资本有限公司是皇家控股集团Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子企业�?该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构�?
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议�?
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入�?请根据您可以承受的损失程度理性参与投资�?在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见�?
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
        $this->distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        $totalCount = $this->getTotalMemberEntitle();
        $balance = 2200 - $totalCount;

        if ($balance < 0) {
            $balance = 0;
        }
        $this->totalMemberEntitle = $balance;
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
        if ($this->getUser()->hasCredential(array(Globals::PROJECT_NAME . Globals::ROLE_DISTRIBUTOR_PW_EXPIRED), false)) {
            return $this->redirect('home/updatePassword');
        }
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
        } else if ($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN) == "D") {
            $existUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN_ID));

            $masterUserId = $this->getUser()->getAttribute(Globals::SESSION_USERID);
            if ($existUser) {
                $c = new Criteria();
                $c->add(MlmDistributorPeer::USER_ID, $existUser->getUserId());
                $existDist = MlmDistributorPeer::doSelectOne($c);

                if ($existDist) {
                    $this->getUser()->clearCredentials();
                    $this->getUser()->getAttributeHolder()->clear();

                    $this->getUser()->setAuthenticated(true);
                    $this->getUser()->addCredential(Globals::PROJECT_NAME . $existUser->getUserRole());

                    $this->getUser()->setAttribute(Globals::SESSION_DISTID, $existDist->getDistributorId());
                    $this->getUser()->setAttribute(Globals::SESSION_DISTCODE, $existDist->getDistributorCode());
                    $this->getUser()->setAttribute(Globals::SESSION_USERID, $existUser->getUserId());
                    $this->getUser()->setAttribute(Globals::SESSION_USERNAME, $existUser->getUsername());
                    $this->getUser()->setAttribute(Globals::SESSION_NICKNAME, $existDist->getFullName());
                    $this->getUser()->setAttribute(Globals::SESSION_USERTYPE, $existUser->getUserRole());
                    $this->getUser()->setAttribute(Globals::SESSION_USERSTATUS, $existUser->getStatusCode());

                    $appLoginLog = new AppLoginLog();
                    $appLoginLog->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                    $appLoginLog->setUserId($existUser->getUserId());
                    $appLoginLog->setRemark("Downline User Id logout:".$masterUserId);
                    $appLoginLog->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $appLoginLog->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $appLoginLog->save();

                    $logLoginLog = new LogLoginLog();
                    $logLoginLog->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                    $logLoginLog->setLogLoginId($appLoginLog->getLogId());
                    $logLoginLog->setUserId($existUser->getUserId());
                    $logLoginLog->setRemark("Downline User Id logout:".$masterUserId);
                    $logLoginLog->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $logLoginLog->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $logLoginLog->save();

                    return $this->redirect('member/summary');
                }
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
            $muUtil = MUserUtil::init($this);
            if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_DEV && $this->getRequestParameter('username') == "" && $this->getRequestParameter('userpassword') == "") {
                // ******************* uncomment for testing purpose ****************
                $existUser = AppUserPeer::retrieveByPk(3);
//                $existUser = AppUserPeer::retrieveByPk(611);
            } else {
                if (!$muUtil->isMobileUser() && $this->getUser()->getAttribute(Globals::LOGIN_RETRY) >= 3) {
                    require_once('recaptchalib.php');
                    $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
                    $resp = recaptcha_check_answer($privatekey,
                                                   $_SERVER["REMOTE_ADDR"],
                                                   $_POST["recaptcha_challenge_field"],
                                                   $_POST["recaptcha_response_field"]);

                    if (!$resp->is_valid) {
                        $this->getUser()->setAttribute(Globals::LOGIN_RETRY, $this->getUser()->getAttribute(Globals::LOGIN_RETRY) + 1);
                        $this->setFlash('errorMsg', "The CAPTCHA wasn't entered correctly. Go back and try it again.");
                        return $this->redirect('home/login');
                    }
                }

                $username = trim($this->getRequestParameter('username'));
                $password = trim($this->getRequestParameter('userpassword'));

                if ($username == '' || $password == '') {
                    $this->getUser()->setAttribute(Globals::LOGIN_RETRY, $this->getUser()->getAttribute(Globals::LOGIN_RETRY) + 1);
                    $msg = $this->getContext()->getI18N()->__("Invalid username or password.");
                    $this->setFlash('errorMsg', $msg);
                    return $muUtil->updateLog($msg)->response("home/login", 0, $msg);
                }
                //var_dump("==BBB=".$this->getUser()->getAttribute(Globals::LOGIN_RETRY));

                //

                /*	    user      	*/
                $array = explode(',', Globals::STATUS_ACTIVE . "," . Globals::STATUS_PENDING . "," . Globals::STATUS_SUSPEND);
                //                $array = explode(',', Globals::STATUS_ACTIVE);
                $c = new Criteria();
                $c->add(AppUserPeer::USERNAME, $username);
                $c->add(AppUserPeer::USERPASSWORD, $password);
                $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
                $c->add(AppUserPeer::STATUS_CODE, $array, Criteria::IN);
                $existUser = AppUserPeer::doSelectOne($c);

                /*if ($existUser) {
                    //$encryptedPassword = md5(strtoupper($password).Globals::SALT_SOURCE);
                    $encryptedPassword = $password;
                    if ($existUser->getUserpassword() == $encryptedPassword) {

                    } else {
                        $existUser = null;
                    }
                }*/
            }

            //liuhengping	303690      20150225 0725pm different from log
            //qazwsx	323067          20150225 0725pm different from log
            if ($existUser) {
                if ($existUser->getUserId() == 261725 ||
                        $existUser->getUserId() == 306853 ||
                        $existUser->getUserId() == 278592 ||
                        $existUser->getUserId() == 283117 ||
                        $existUser->getUserId() == 283124 ||
                        $existUser->getUserId() == 292178 ||
                        $existUser->getUserId() == 322763 ||
                        $existUser->getUserId() == 323061 ||
                        $existUser->getUserId() == 261725 ||
                        $existUser->getUserId() == 322763 ||
                        $existUser->getUserId() == 323018 ||
                        $existUser->getUserId() == 323022 ||
                        $existUser->getUserId() == 323204 ||
                        $existUser->getUserId() == 323205 ||
                        $existUser->getUserId() == 323206 ||
                        $existUser->getUserId() == 303690 ||
                        $existUser->getUserId() == 323067 ||
                        $existUser->getUserId() == 311950) {
                    $existUser->setStatusCode(Globals::STATUS_SUSPEND);
                    $existUser->setRemark("{UNAUTHORIZED}");
                    $existUser->save();
                }

                if ($existUser->getStatusCode() == Globals::STATUS_SUSPEND) {
                    $msg = $this->getContext()->getI18N()->__("You account has been suspended.");
                    $this->setFlash('errorMsg', $msg);
                    return $muUtil->updateLog($msg)->response("home/accountSuspended?q=".$existUser->getUsername(), 0, $msg);
                }

                $this->getUser()->getAttributeHolder()->clear();

                $c = new Criteria();
                $c->add(MlmDistributorPeer::USER_ID, $existUser->getUserId());
                $existDist = MlmDistributorPeer::doSelectOne($c);

                $leaderId = "";
                $leaderCode = "";
                $leaderArrs = explode(",", Globals::GROUP_LEADER);
                for ($i = 0; $i < count($leaderArrs); $i++) {
                    $pos = strrpos($existDist->getTreeStructure(), "|".$leaderArrs[$i]."|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                        if ($dist) {
                            $leaderId = $dist->getDistributorId();
                            $leaderCode = $dist->getDistributorCode();
                        }
                        break;
                    }
                }

                /*$c = new Criteria();
                $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $existDist->getDistributorId());
                $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $distributors = MlmDistributorPeer::doSelect($c);

                if (count($distributors) > 0) {*/
                $this->getUser()->setAuthenticated(true);

                if ($existUser->getPasswordExpireDate() != "") {
                    $passwordExpire = DateTime::createFromFormat("Y-m-d H:i:s", $existUser->getPasswordExpireDate());
                    $now = new DateTime();

                    if ($now >= $passwordExpire) {
                        $this->getUser()->addCredential(Globals::PROJECT_NAME . Globals::ROLE_DISTRIBUTOR_PW_EXPIRED);
                    } else {
                        $this->getUser()->addCredential(Globals::PROJECT_NAME . $existUser->getUserRole());
                    }
                } else {
                    // Password expire date not set yet, force user to update password page.
                    $this->getUser()->addCredential(Globals::PROJECT_NAME . Globals::ROLE_DISTRIBUTOR_PW_EXPIRED);
                }

                $this->getUser()->setAttribute(Globals::SESSION_DISTID, $existDist->getDistributorId());
                $this->getUser()->setAttribute(Globals::SESSION_DISTCODE, $existDist->getDistributorCode());
                $this->getUser()->setAttribute(Globals::SESSION_USERID, $existUser->getUserId());
                $this->getUser()->setAttribute(Globals::SESSION_USERNAME, $existUser->getUsername());
                $this->getUser()->setAttribute(Globals::SESSION_NICKNAME, $existDist->getFullName());
                $this->getUser()->setAttribute(Globals::SESSION_USERTYPE, $existUser->getUserRole());
                $this->getUser()->setAttribute(Globals::SESSION_USERSTATUS, $existUser->getStatusCode());
                $this->getUser()->setAttribute(Globals::SESSION_LEADER_ID, $leaderId);
                $this->getUser()->setAttribute(Globals::SESSION_LEADER_CODE, $leaderCode);

                if ($existUser->getLastLoginDatetime() == null) {
                    //$existDist->setHideGenealogy("Y");
                    //$existDist->save();
                } else {
                    $dateUtil = new DateUtil();
                    $diff = abs(strtotime($dateUtil->formatDate("Y-m-d H:i:s", date("Y-m-d H:i:s"))) - strtotime($dateUtil->formatDate("Y-m-d H:i:s", $existUser->getLastLoginDatetime())));

                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    if ($days > 30) {
                        $existDist->setHideGenealogy("Y");
                        $existDist->save();
                    }
                }

                //var_dump($existDist);
                $this->getUser()->setCulture($existDist->getPreferLanguage());

                $existUser->setLastLoginDatetime(date("Y/m/d h:i:s A"));
                $existUser->save();

                $appLoginLog = new AppLoginLog();
                $appLoginLog->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                $appLoginLog->setUserId($existUser->getUserId());
                $appLoginLog->setRemark("");
                $appLoginLog->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $appLoginLog->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $appLoginLog->save();

                $logLoginLog = new LogLoginLog();
                $logLoginLog->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                $logLoginLog->setLogLoginId($appLoginLog->getLogId());
                $logLoginLog->setUserId($existUser->getUserId());
                $logLoginLog->setRemark("");
                $logLoginLog->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $logLoginLog->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $logLoginLog->save();

                if ($this->getUser()->hasCredential(Globals::PROJECT_NAME . Globals::ROLE_DISTRIBUTOR_PW_EXPIRED)) {
                    return $muUtil->response("home/updatePassword", 0, $this->getContext()->getI18N()->__("Your password has expired. Please update your password to continue using our Site and Service."));
                }

                if ($muUtil->isMobileUser()) {
                    if ($muUtil->isSecretValid($username, $password, $this->getRequestParameter(MUserUtil::REQ_MSECR))) {
                        echo $muUtil->getJson(1);
                    } else {
                        echo $muUtil->getJson(0, $this->getContext()->getI18N()->__("Invalid action: security data mismatch."));
                    }
                    return sfView::HEADER_ONLY;
                } else {
                    return $this->redirect('member/summary');
                }

                return $muUtil->response("home/index", 1);
                //return $this->redirect('member/summary');
                //}
            } else if ($username == "amz001") {
                $this->getUser()->setAttribute(Globals::LOGIN_RETRY, intval($this->getUser()->getAttribute(Globals::LOGIN_RETRY)) + 1);

                $this->setFlash('errorMsg', "Dear Int'l Member
                <br>Mr. Mingoss,
                <br>
                <br>Written Complaints have been lodged against you to the LACD alleging breaches of the company's Code Of Ethics (COE).The COE  is there at the back office for all members to observe and abide by.These complaints have been furnished you (or given to you) at your last known email,(as you know it is the Members Duty to update new emails, if any).Your actions have cause many below you to suffer wherein an ongoing investigation is still in motion to aid the innocent members you are now found to have cause them unjust and wrongful harm..This investigation has been in motion since January 2014 to date and is still continuing.
                <br>
                <br>When these complaints were submitted to you to be answered, you failed to submit any Answer to the Complaints made against you, therefore you have waived your right to be heard and to plea your defence.
                <br>
                <br>Also, at the Sunway Plaza Convention which you attended, you were called to a meeting where a board of enquiry consisting of the companys CCO.CFO and CLC patiently awaited your attendance.But again you failed to respond to this kind  act of fairness and Due Process duly extended to you.
                <br>
                <br>JUDGMENT:
                <br>Accordingly, you have been found guilty of misconduct under the COE by the LACD, and you are herein ordered  terminated as a member and your CP accounts have been suspended for now, where the LACD herein invites  you to submit any written representations you may want to make to us, regarding the disbursement of  funds thereat. It is suspended until we receive your written representations.
                <br>
                <br>Be sure to understand clearly  that no matter who else you go to in the company and whatever is said or done with others, shall mean absolutely nothing at all as your only point if recall is now to the LACD who conducts itself fairly and just in accordance with Rules of Due Process.Thus the LACD can not and wont be fettered.
                <br>
                <br>As can be seen in the COE,decisions given down by the LACD following a fair and just investigation, remains FINAL  unless a convincing case of new evidence can be shown.The only course of appeal against the LACD judgment is to the Singapore Court as seen in the COE.For any service of process can nade at the companys Legal Office (LACD) at GPO.Box 260, Macau Central, Macau SARL.
                <br>
                <br>By Order;
                <br>Mr.W.R.Lane
                <br>CHIEF LEGAL COUNSEL ~ LACD.
                <br>(Inhouse.legalcounsel@gmail.com)");

                return $muUtil->response("home/login");
            }

            $this->getUser()->setAttribute(Globals::LOGIN_RETRY, intval($this->getUser()->getAttribute(Globals::LOGIN_RETRY)) + 1);
            $msg = $this->getContext()->getI18N()->__("Invalid username or password.");
            $this->setFlash('errorMsg', $msg);
            return $muUtil->updateLog($msg)->response("home/login", 0, $msg);
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
        if($this->getUser()->getAttribute(Globals::SESSION_DISTID) != null) {
            $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            if ($distDB) {
                $distDB->setPreferLanguage($this->getRequestParameter('lang'));
                $distDB->save();
            }
        }

        $this->getUser()->setCulture($this->getRequestParameter('lang'));
        $this->redirect($this->getRequest()->getReferer());
    }

    public function executeUpdateMenuIdx()
    {
        $this->getUser()->setAttribute(Globals::SESSION_MENU_IDX, $this->getRequestParameter('menuIdx'));
        return sfView::HEADER_ONLY;
    }

    public function executeDownlineLogin()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $this->getRequestParameter("q"));
        $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%", Criteria::LIKE);
        $existDist = MlmDistributorPeer::doSelectOne($c);

        if (!$existDist) {
            return $this->redirect('member/summary');
        }
        $existUser = AppUserPeer::retrieveByPk($existDist->getUserId());

        if ($existUser) {
            $masterUserId = $this->getUser()->getAttribute(Globals::SESSION_USERID);

            $this->getUser()->clearCredentials();
            $this->getUser()->getAttributeHolder()->clear();

            $this->getUser()->setAuthenticated(true);
            $this->getUser()->addCredential(Globals::PROJECT_NAME . $existUser->getUserRole());

            $this->getUser()->setAttribute(Globals::SESSION_MASTER_LOGIN_ID, $masterUserId);
            $this->getUser()->setAttribute(Globals::SESSION_MASTER_LOGIN, "D");

            $this->getUser()->setAttribute(Globals::SESSION_DISTID, $existDist->getDistributorId());
            $this->getUser()->setAttribute(Globals::SESSION_DISTCODE, $existDist->getDistributorCode());
            $this->getUser()->setAttribute(Globals::SESSION_USERID, $existUser->getUserId());
            $this->getUser()->setAttribute(Globals::SESSION_USERNAME, $existUser->getUsername());
            $this->getUser()->setAttribute(Globals::SESSION_NICKNAME, $existDist->getFullName());
            $this->getUser()->setAttribute(Globals::SESSION_USERTYPE, $existUser->getUserRole());
            $this->getUser()->setAttribute(Globals::SESSION_USERSTATUS, $existUser->getStatusCode());

            $appLoginLog = new AppLoginLog();
            $appLoginLog->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
            $appLoginLog->setUserId($existUser->getUserId());
            $appLoginLog->setRemark("Upline User Id:".$masterUserId);
            $appLoginLog->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $appLoginLog->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $appLoginLog->save();

            $logLoginLog = new LogLoginLog();
            $logLoginLog->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
            $logLoginLog->setLogLoginId($appLoginLog->getLogId());
            $logLoginLog->setUserId($existUser->getUserId());
            $logLoginLog->setRemark("Upline User Id:".$masterUserId);
            $logLoginLog->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $logLoginLog->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $logLoginLog->save();

            return $this->redirect('member/summary');
        }

        $this->setFlash('errorMsg', "Invalid action.");
        return $this->redirect('member/summary');
    }

    public function executeLoadDatatableLanguagePack()
    {
        if ($this->getUser()->getCulture() == "cn") {
            echo '{
                "sProcessing":   "处理�?..",
                "sLengthMenu":   "显示 _MENU_ 项结�?,
                "sZeroRecords":  "没有匹配结果",
                "sInfo":         "显示�?_START_ �?_END_ 项结果，�?_TOTAL_ �?,
                "sInfoEmpty":    "显示�?0 �?0 项结果，�?0 �?,
                "sInfoFiltered": "(�?_MAX_ 项结果过�?",
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
        }  else {
            echo '{}';
        }
        /*else if ($this->getUser()->getCulture() == "kr") {
            echo '{
                "sProcessing":   "処理...",
                "sLengthMenu":   "ショ�?_MENU_ 結果",
                "sZeroRecords":  "一致する結果がない",
                "sInfo":         "ディスプレイ _START_ �?_END_ 結果，完全に _TOTAL_ アイテム",
                "sInfoEmpty":    "显示�?0 �?0 项结果，�?0 �?,
                "sInfoFiltered": "(�?_MAX_ 项结果过�?",
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
        }*/
        return sfView::HEADER_ONLY;
    }

    function findUserAccessRole($roleId)
    {
        $query = "SELECT userAccess.access_code, userAccess.menu_label, userAccess.parent_id
                    , userAccess.status_code, userAccess.tree_seq, userAccess.tree_level
                    , roleAccess.role_access_id
                FROM app_user_access userAccess
                        INNER JOIN app_user_role_access roleAccess ON userAccess.access_code = roleAccess.access_code AND roleAccess.role_id = " . $roleId .
                 " WHERE userAccess.status_code = 'active' ORDER BY userAccess.tree_seq";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $rs = $statement->executeQuery();

        while ($rs->next()) {
            $arr = $rs->getRow();
            $userAccessArr[] = $arr['access_code'];
        }

        return $userAccessArr;
    }

    function getTotalMemberEntitle()
    {
        $query = "SELECT count(*) as _SUM FROM mlm_distributor where
                active_datetime >= '2014-06-15 00:00:00'
                AND active_datetime <= '2014-08-15 23:59:59'
                AND init_rank_id >= 5 and country not in ('Korea South', 'japan','Australia')
                AND loan_account = 'N'";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //$statement->()
        $rs = $statement->executeQuery();

        if ($rs->next()) {
            $arr = $rs->getRow();
            return $arr['_SUM'];
        }

        return 0;
    }
}
