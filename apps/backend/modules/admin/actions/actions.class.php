<?php

/**
 * admin actions.
 *
 * @package    sf_sandbox
 * @subpackage admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class adminActions extends sfActions
{
    /** ******************************************************
     * Package
     *******************************************************/
    public function executePackageList()
    {
        $this->mlm_packages = MlmPackagePeer::doSelect(new Criteria());
    }

    public function executePackageCreate()
    {
        $this->mlm_package = new MlmPackage();

        $this->setTemplate('packageEdit');
    }

    public function executePackageEdit()
    {
        $this->mlm_package = MlmPackagePeer::retrieveByPk($this->getRequestParameter('package_id'));
        $this->forward404Unless($this->mlm_package);
    }

    public function executePackageUpdate()
    {
        if (!$this->getRequestParameter('package_id')) {
            $mlm_package = new MlmPackage();
        }
        else
        {
            $mlm_package = MlmPackagePeer::retrieveByPk($this->getRequestParameter('package_id'));
            $this->forward404Unless($mlm_package);
        }

        $mlm_package->setPackageId($this->getRequestParameter('package_id'));
        $mlm_package->setPackageName($this->getRequestParameter('package_name'));
        $mlm_package->setPrice($this->getRequestParameter('price'));
        $mlm_package->setCommission($this->getRequestParameter('commission'));
        $mlm_package->setPips($this->getRequestParameter('pips'));
        $mlm_package->setGeneration($this->getRequestParameter('generation'));
        $mlm_package->setPips2($this->getRequestParameter('pips2'));
        $mlm_package->setGeneration2($this->getRequestParameter('generation2'));
        $mlm_package->setPublicPurchase($this->getRequestParameter('public_purchase'));
        $mlm_package->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
        $mlm_package->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
        $mlm_package->save();

        $this->setFlash('successMsg', "Update successfully");
        return $this->redirect('admin/packageEdit?package_id=' . $mlm_package->getPackageId());
    }

    /** ******************************************************
     * Executes index action
     *******************************************************/
    public function executeIndex()
    {
    }

    public function executeDashboard()
    {
        $companyEpoint = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
        $totalActiveMember = $this->getTotalMember(Globals::STATUS_ACTIVE, null);
        $totalPendingMember = $this->getTotalMember(Globals::STATUS_PENDING, null);
        $reloadMt4Fund = $this->getTotalReloadMt4Fund(Globals::STATUS_PENDING);
        $mt4Withdrawal = $this->getTotalMt4Withdrawal(Globals::STATUS_PENDING);
        $referralBonus = $this->getTotalRefferalBonus(Globals::STATUS_PENDING);

        /*$c = new Criteria();
        $packages = MlmPackagePeer::doSelect($c);
        $packageArray = array();
        $count = 0;
        foreach ($packages as $package) {
            $packageArray[$count]["package"] = $package;
            $packageArray[$count]["total"] = $this->getTotalMember(null, $package->getPackageId());
            $count++;
        }*/

        $this->companyEpoint = $companyEpoint;
        $this->totalActiveMember = $totalActiveMember;
        $this->totalPendingMember = $totalPendingMember;
        //$this->packageArray = $packageArray;
        $this->reloadMt4Fund = $reloadMt4Fund;
        $this->mt4Withdrawal = $mt4Withdrawal;
        $this->referralBonus = $referralBonus;
    }

    public function executeUserList()
    {
    }

    public function executeAp()
    {
        $apService = new ApService();
        $apService->constructAp();

        echo "SUCCESS";
        return sfView::HEADER_ONLY;
    }

    public function executeDoSaveUser()
    {
        $userId = $this->getRequestParameter('userId');
        $userName = $this->getRequestParameter('userName');
        $userPassword = $this->getRequestParameter('userPassword');
        $status = $this->getRequestParameter('status');
        $role = $this->getRequestParameter('role');

        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $userName);
        if (isset($userId) && trim($userId) != '') {
            $c->add(AppUserPeer::USER_ID, $userId, Criteria::NOT_EQUAL);
        }

        $exist = AppUserPeer::doSelectOne($c);
        if ($exist) {
            $output = array(
                "error" => true,
                "errorMsg" => "Username already exist."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        if (isset($userId) && trim($userId) != '') {
            $tbl_user = AppUserPeer::retrieveByPk($userId);
            if (!isset($tbl_user)) {
                $output = array(
                    "error" => true,
                    "errorMsg" => "Serious Problem happen in server."
                );
                echo json_encode($output);
                return sfView::HEADER_ONLY;
            }

            $c = new Criteria();
            $c->add(MlmAdminPeer::USER_ID, $userId);
            $tbl_admin = MlmAdminPeer::doSelectOne($c);
            if (!isset($tbl_user)) {
                $output = array(
                    "error" => true,
                    "errorMsg" => "Serious Problem happen in server."
                );
                echo json_encode($output);
                return sfView::HEADER_ONLY;
            }
        } else {
            $tbl_admin = new MlmAdmin();
            $tbl_user = new AppUser();

            $tbl_admin->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
            $tbl_admin->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
        }
        $tbl_user->setUsername($userName);
        $tbl_user->setKeepPassword($userPassword);
        $tbl_user->setUserpassword($userPassword);
        $tbl_user->setKeepPassword2($userPassword);
        $tbl_user->setUserpassword2($userPassword);
        $tbl_user->setUserRole(Globals::ROLE_ADMIN);
        $tbl_user->setStatusCode($status);
        $tbl_user->save();

        $userId = $tbl_user->getUserId();

        $tbl_admin->setAdminCode($userName);
        $tbl_admin->setUserId($userId);
        $tbl_admin->setStatusCode($status);
        $tbl_admin->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
        $tbl_admin->setAdminRole($role);
        $tbl_admin->save();

        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeChangePassword()
    {
        if ($this->getRequestParameter('oldPassword')) {
            $c = new Criteria();
            $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
            $exist = AppUserPeer::doSelectOne($c);

            if ($exist->getUserpassword() <> $this->getRequestParameter('oldPassword')) {
                $this->setFlash('errorMsg', "Invalid password");
            } else {
                $exist->setUserpassword($this->getRequestParameter('newPassword'));
                $exist->save();
                $this->setFlash('successMsg', "Password updated");
            }
        }
    }

    public function executeFetchRole()
    {
        $c = new Criteria();
        $c->add(AppUserRolePeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->addAscendingOrderByColumn(AppUserRolePeer::ROLE_CODE);
        $appUserRoles = AppUserRolePeer::doSelect($c);

        foreach ($appUserRoles as $appUserRole) {
            $arr[] = $appUserRole->getRoleCode();
        }
        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeUserRole()
    {
        $query = "SELECT userAccess.access_code, userAccess.menu_label, userAccess.parent_id
                    , userAccess.status_code, userAccess.tree_seq, userAccess.tree_level
                FROM app_user_access userAccess
                     WHERE userAccess.status_code = 'ACTIVE' ORDER BY userAccess.tree_seq";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $rs = $statement->executeQuery();

        $idx = 0;
        $resultArr = array();
        while ($rs->next()) {
            $arr = $rs->getRow();
            $resultArr[$idx] = $arr;
            $idx++;
        }
        $this->resultArr = $resultArr;
    }

    public function executeFetchUserAccessRole()
    {
        $roleId = $this->getRequestParameter('roleId');
        if (!isset($roleId))
            $roleId = 0;

        $userAccessArr = $this->findUserAccessRole($roleId);

        echo json_encode($userAccessArr);

        return sfView::HEADER_ONLY;
    }

    public function executeDoSaveRole()
    {
        $roleId = $this->getRequestParameter('roleId');
        $roleCode = $this->getRequestParameter('roleCode');
        $roleDesc = $this->getRequestParameter('roleDesc');
        $status = $this->getRequestParameter('status');
        $roleCodeSelected = $this->getRequestParameter('roleCodeSelected');

        $roleCodeArr = explode("|||", $roleCodeSelected);

        $c = new Criteria();
        $c->add(AppUserRolePeer::ROLE_CODE, $roleCode);
        if (isset($roleId) && trim($roleId) != '') {
            $c->add(AppUserRolePeer::ROLE_ID, $roleId, Criteria::NOT_EQUAL);
        }

        $exist = AppUserRolePeer::doSelectOne($c);
        if ($exist) {
            $output = array(
                "error" => true,
                "errorMsg" => "Role Code already exist."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        if (isset($roleId) && trim($roleId) != '') {
            $appUserRole = AppUserRolePeer::retrieveByPk($roleId);
            if (!isset($appUserRole)) {
                $output = array(
                    "error" => true,
                    "errorMsg" => "Serious Problem happen in server."
                );
                echo json_encode($output);
                return sfView::HEADER_ONLY;
            }

            $c = new Criteria();
            $c->add(AppUserRolePeer::ROLE_ID, $roleId);
            $appUserRole = AppUserRolePeer::doSelectOne($c);
            if (!isset($appUserRole)) {
                $output = array(
                    "error" => true,
                    "errorMsg" => "Serious Problem happen in server."
                );
                echo json_encode($output);
                return sfView::HEADER_ONLY;
            }
        } else {
            $appUserRole = new AppUserRole();
            $appUserRole->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
        }

        $appUserRole->setRoleCode($roleCode);
        $appUserRole->setRoleDesc($roleDesc);
        $appUserRole->setStatusCode($status);

        $appUserRole->save();

        if (isset($roleId) && trim($roleId) != '') {
            $query = "DELETE FROM app_user_role_access WHERE role_id =" . $roleId;
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $statement->executeQuery();
        }
        foreach ($roleCodeArr as $accessCode) {
            $app_user_role_access = new AppUserRoleAccess();
            $app_user_role_access->setAccessCode($accessCode);
            $app_user_role_access->setRoleId($roleId);
            $app_user_role_access->save();
        }

        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeLogin()
    {
    }

    public function executeDoLogin()
    {
        $existUser = null;
        if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_DEV && $this->getRequestParameter('modlgn_username') == "" && $this->getRequestParameter('modlgn_passwd') == "") {
            // ******************* uncomment for testing purpose ****************
            $existUser = AppUserPeer::retrieveByPk(1);
        } else {
            $username = trim($this->getRequestParameter('modlgn_username'));
            $password = trim($this->getRequestParameter('modlgn_passwd'));

            if ($username == '' || $password == '') {
                $this->setFlash('errorMsg', "Invalid username or password.");
                return $this->redirect('admin/login');
            }

            require_once('recaptchalib.php');
            $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
            $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

            if (!$resp->is_valid) {
                $this->setFlash('errorMsg', "The CAPTCHA wasn't entered correctly. Go back and try it again.");
                return $this->redirect('admin/login');
            }

            $this->getUser()->getAttributeHolder()->clear();

            /*	    user      	*/
            $c = new Criteria();
            $c->add(AppUserPeer::USERNAME, $username);
            $c->add(AppUserPeer::USERPASSWORD, $password);
            $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_ADMIN);
            $c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $existUser = AppUserPeer::doSelectOne($c);
        }

        if ($existUser) {
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

            return $this->redirect('admin/dashboard');
        }

        $this->setFlash('errorMsg', "Invalid username or password.");
        return $this->redirect('admin/login');
    }

    public function executeLoginSecurity()
    {
        $this->setFlash('errorMsg', "Login required. This page is not public.");
        return $this->redirect('admin/login');
    }

    public function executeLogout()
    {
        $this->getUser()->clearCredentials();
        $this->getUser()->getAttributeHolder()->clear();
        return $this->redirect('admin/login');
    }

    public function executeUpdateMenuIdx()
    {
        $this->getUser()->setAttribute(Globals::SESSION_ADMIN_MENU_IDX, $this->getRequestParameter('menuIdx'));
        return sfView::HEADER_ONLY;
    }

    /* ***********************************************
   *      Application Setting
   * ************************************************/
    public function executeApplicationSetting()
    {
        $this->app_settings = AppSettingPeer::doSelect(new Criteria());
    }

    public function executeApplicationSettingUpdate()
    {
        $app_settings = AppSettingPeer::doSelect(new Criteria());
        foreach ($app_settings as $app_setting):
            $app_setting->setSettingValue($this->getRequestParameter($app_setting->getSettingParameter()));
            $app_setting->save();
        endforeach;
        $this->setFlash('successMsg', "Update successfully");

        return $this->redirect('admin/applicationSetting');
    }

    // #####################################
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

    function getAccountBalance($distributorId, $accountType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_account_ledger WHERE dist_id = " . $distributorId . " AND account_type = '" . $accountType . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getTotalMember($statusCode, $rankId)
    {
        $c = new Criteria();
        if ($statusCode != null) {
            $c->add(MlmDistributorPeer::STATUS_CODE, $statusCode);
        }
        if ($rankId != null) {
            $c->add(MlmDistributorPeer::RANK_ID, $rankId);
        }
        $totalNetworks = MlmDistributorPeer::doCount($c);

        return $totalNetworks;
    }

    function getTotalReloadMt4Fund($statusCode)
    {
        $c = new Criteria();
        if ($statusCode != null) {
            $c->add(MlmMt4ReloadFundPeer::STATUS_CODE, $statusCode);
        }
        $totalNetworks = MlmMt4ReloadFundPeer::doCount($c);

        return $totalNetworks;
    }

    function getTotalMt4Withdrawal($statusCode)
    {
        $c = new Criteria();
        if ($statusCode != null) {
            $c->add(MlmMt4WithdrawPeer::STATUS_CODE, $statusCode);
        }
        $totalNetworks = MlmMt4WithdrawPeer::doCount($c);

        return $totalNetworks;
    }

    function getTotalRefferalBonus($statusCode)
    {
        $c = new Criteria();
        if ($statusCode != null) {
            $c->add(MlmDistCommissionLedgerPeer::STATUS_CODE, $statusCode);
        }
        $totalNetworks = MlmDistCommissionLedgerPeer::doCount($c);

        return $totalNetworks;
    }
}
