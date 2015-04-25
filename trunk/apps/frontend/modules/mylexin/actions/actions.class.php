<?php

/**
 * mylexin actions.
 *
 * @package    sf_sandbox
 * @subpackage mylexin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class mylexinActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeTest()
    {

        $output = array();
        //var_dump(date("Ymd"));
//        var_dump(md5("q=checkout&a=MYLEXIN".date("Ymd")));
//        exit();
//        $json = '{"userId":2,"userName":"demo123","fullname":"demo123","nickname":"demo123"}';

//        $arr = json_decode($json);
//        var_dump($arr->{"userId"});
//        var_dump($arr->{"userName"});
//        var_dump($arr['userId']);
//        var_dump($arr['userName']);
        exit();
        //var_dump(json_decode($json, true));
    }
    public function executeIndex()
    {
        $this->doAction = trim($this->getRequestParameter('q'));
        $this->token = trim($this->getRequestParameter('a'));

        $signatureString = "q=".$this->getRequestParameter('q')."&a=MYLEXIN";
        $signatureString = md5($signatureString.date("Ymd"));

        if ($this->token == $signatureString) {
            $this->doAction = trim($this->getRequestParameter('q'));
        } else {
            echo "error code";
            return sfView::HEADER_ONLY;
        }
    }
    public function executeCheckOut()
    {


        return $this->redirect('mylexin/index?q=checkout&a=');
    }

    public function executeDoLogin()
    {
        $existUser = null;
        $username = trim($this->getRequestParameter('username'));
        $password = trim($this->getRequestParameter('userpassword'));
        $q = trim($this->getRequestParameter('q'));
        $a = trim($this->getRequestParameter('a'));

        if ($username == '' || $password == '') {
            $this->setFlash('warningMsg', "Invalid username or password.");
            return $this->redirect('mylexin/index?q='.$q."&a=".$a);
        }

        /*require_once('recaptchalib.php');
        $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
        $resp = recaptcha_check_answer($privatekey,
                                       $_SERVER["REMOTE_ADDR"],
                                       $_POST["recaptcha_challenge_field"],
                                       $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {
            $this->setFlash('errorMsg', "The CAPTCHA wasn't entered correctly.");
            return $this->redirect('mylexin/index');
        }*/

        $array = explode(',', Globals::STATUS_ACTIVE);
        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $username);
        $c->add(AppUserPeer::USERPASSWORD, $password);
        $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
        $c->add(AppUserPeer::STATUS_CODE, $array, Criteria::IN);
        $existUser = AppUserPeer::doSelectOne($c);

        if ($existUser) {
            if ($existUser->getUserId() == 306853 ||
                    $existUser->getUserId() == 330812 ||
                    $existUser->getUserId() == 278592 ||
                    $existUser->getUserId() == 283117 ||
                    $existUser->getUserId() == 283124 ||
                    $existUser->getUserId() == 292178 ||
                    $existUser->getUserId() == 322763 ||
                    $existUser->getUserId() == 323061 ||
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

                return $this->redirect('mylexin/index?q='.$q."&a=".$a);
            }

            $c = new Criteria();
            $c->add(MlmDistributorPeer::USER_ID, $existUser->getUserId());
            $existDist = MlmDistributorPeer::doSelectOne($c);

            //$existUser->setLastLoginDatetime(date("Y/m/d h:i:s A"));
            //$existUser->setAccessIp($this->getRequest()->getHttpHeader('addr', 'remote'));
            //$existUser->save();

            $appLoginLog = new AppLoginLog();
            $appLoginLog->setAccessIp($this->getRequest()->getHttpHeader('addr', 'remote'));
            $appLoginLog->setUserId($existUser->getUserId());
            $appLoginLog->setRemark("MYLEXIN");
            $appLoginLog->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $appLoginLog->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $appLoginLog->save();

            $apiTransaction = new ApiTransaction();
            $apiTransaction->setAccessIp($this->getRequest()->getHttpHeader('addr', 'remote'));
            $apiTransaction->setUserId($existUser->getUserId());
            $apiTransaction->setTransactionAction("CHECKOUT");
            $apiTransaction->setTransactionData("USERNAME:".$username.", PASSEWORD:".$password.", Q:".$q.", A:".$a);
            $apiTransaction->setRemark("");
            $apiTransaction->setStatusCode("ACTIVE");
            $apiTransaction->setToken("");
            $apiTransaction->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $apiTransaction->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $apiTransaction->save();

            $transactionToken = $apiTransaction->getTransactionId()."MYLEXIN";
            $transactionToken = md5($transactionToken);
            $apiTransaction->setToken($transactionToken);
            $apiTransaction->save();

            /*$arr = array(
                'transactionToken' => $transactionToken
            );

            $result = json_encode($arr);*/
            $this->transactionToken = $transactionToken;
            $this->userId = $existUser->getUserName();
            $this->rtBalance = $this->getAccountLedgerBalance($existDist->getDistributorId(), Globals::ACCOUNT_TYPE_RT);
            $this->setTemplate("redirect");
        } else {
            $this->setFlash('errorMsg', "Invalid username or password.");
            return $this->redirect('mylexin/index?q='.$q."&a=".$a);
        }
    }

    function getAccountLedgerBalance($distributorId, $accountType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_account_ledger WHERE dist_id = " . $distributorId . " AND account_type = '" . $accountType . "'";
        if ($date != null) {
            $query .= " AND created_on <= '" . $date . " 23:59:59'";
        }
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
}
