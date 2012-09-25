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
    /* ***********************************************************************
     *    ~ HTML ~
     * **********************************************************************/
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

    public function executeLogout()
    {
        $this->getUser()->getAttributeHolder()->clear();
        return $this->redirect('home/login');
    }

    public function executeDoLogin()
    {
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
                //if ($this->getUser()->getAttribute(Globals::LOGIN_RETRY) >= 3) {
                    require_once('recaptchalib.php');
                    $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
                    $resp = recaptcha_check_answer ($privatekey,
                                                    $_SERVER["REMOTE_ADDR"],
                                                    $_POST["recaptcha_challenge_field"],
                                                    $_POST["recaptcha_response_field"]);

                    if (!$resp->is_valid) {
                        $this->setFlash('errorMsg', "The CAPTCHA wasn't entered correctly. Go back and try it again.");
                        return $this->redirect('home/login');
                    }
                //}

                $username = trim($this->getRequestParameter('username'));
                $password = trim($this->getRequestParameter('userpassword'));

                if ($username == '' || $password == '') {
                    $this->setFlash('errorMsg', "Invalid username or password.");
                    return $this->redirect('home/login');
                }

                $this->getUser()->getAttributeHolder()->clear();

                /*	    user      	*/
                //$array = explode(',', Globals::STATUS_ACTIVE . "," . Globals::STATUS_PENDING);
                $array = explode(',', Globals::STATUS_ACTIVE);
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
