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
    public function executeTestMd5()
    {
        //$url = urlencode('{"transactionCode":"ff1fcc223640acfea3b8d2c559d2b647","paymentDate":"20150425","paymentTime":"043957","amount":3200,"aaData":[{"productId":"P0123456789","productName":"POLILEX","price":300,"qty":10,"total":3000},{"productId":"P2222222222","productName":"LEXLIPO","price":100,"qty":2,"total":200}]}');
        //var_dump($url);

        var_dump(md5("q=checkout&a=MYLEXIN".date("Ymd")));
        var_dump(md5("q=enquirybalance&a=MYLEXIN".date("Ymd")));
        exit();
    }
    public function executeTestJsonEncode()
    {
        $arr = array();
        $arr[] = array(
            "productId" => "P0123456789",
            "productName" => "POLILEX",
            "price" => 300,
            "qty" => 10,
            "total" => 3000
        );
        $arr[] = array(
            "productId" => "P2222222222",
            "productName" => "LEXLIPO",
            "price" => 100,
            "qty" => 2,
            "total" => 200
        );
        $output = array(
            "transactionCode" => "ff1fcc223640acfea3b8d2c559d2b647",
            "paymentDate" => "20150425",
            "paymentTime" => "043957",
            "amount" => 3200,
            "aaData" => $arr
        );

        echo json_encode($output);
        exit();
        //var_dump(json_decode($json, true));
    }
    public function executeTestJsonDecode()
    {

        $json = '{"transactionToken":"ff1fcc223640acfea3b8d2c559d2b647","paymentDate":"20150425","paymentTime":"043957","amount":3200,"aaData":[{"productId":"P0123456789","productName":"POLILEX","price":300,"qty":10,"total":3000},{"productId":"P2222222222","productName":"LEXLIPO","price":100,"qty":2,"total":200}]}';
        $json = '{"transactionToken":"ff1fcc223640acfea3b8d2c559d2b647","paymentDate":"20150425","paymentTime":"043957","amount":3200,"aaData":[{"productId":"P0123456789","productName":"POLILEX","price":300,"qty":10,"total":3000},{"productId":"P2222222222","productName":"LEXLIPO","price":100,"qty":2,"total":200}]}';
        $arr = json_decode($json);
        var_dump($arr->{"[transactionToken]"});
        var_dump($arr->{"paymentDate"});
        var_dump($arr->{"amount"});
        var_dump($arr->{"aaData"});
        exit();
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
    public function executeCheckout()
    {
        $result = "FAIL";
        $msg = "";

        $data = $this->getRequestParameter('data');
        $arr = json_decode($data);

        $transactionToken = $arr->{"transactionToken"};

        $c = new Criteria();
        $c->add(ApiTransactionPeer::STATUS_CODE, "ACTIVE");
        $c->add(ApiTransactionPeer::TOKEN, $transactionToken);
        $apiTransaction = ApiTransactionPeer::doSelectOne($c);

        if (!$apiTransaction) {
            $msg = "INVALID TOKEN";
        } else {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::USER_ID, $apiTransaction->getUserId());
            $existDist = MlmDistributorPeer::doSelectOne($c);

            $rtBalance = $this->getAccountLedgerBalance($existDist->getDistributorId(), Globals::ACCOUNT_TYPE_RT);

            $amount = $arr->{"amount"};

            if ($rtBalance < $amount) {
                $msg = "Insufficient RT.";
            } else {
                $result = "SUCCESS";

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RT);
                $mlm_account_ledger->setDistId($existDist->getDistributorId());
                $mlm_account_ledger->setTransactionType("MYLEXIN");
                //$mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")");
                $mlm_account_ledger->setRemark("");
                $mlm_account_ledger->setInternalRemark("ID: ".$transactionToken);
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($amount);
                $mlm_account_ledger->setBalance($rtBalance - $amount);
                $mlm_account_ledger->setCreatedBy(0);
                $mlm_account_ledger->setUpdatedBy(0);
                $mlm_account_ledger->save();

                $apiTransaction->setRefId($mlm_account_ledger->getAccountId());
                $apiTransaction->setRefType("ACCOUNT LEDGER");
            }

            $output = array(
                "transactionToken" => $transactionToken,
                "result" => $result,
                "msg" => $msg
            );

            $responseData = json_encode($output);

            $apiTransaction->setRequestData($data);
            $apiTransaction->setResponseData($responseData);
            $apiTransaction->setStatusCode("COMPLETE");


            $apiTransactionNew = new ApiTransaction();
            $apiTransactionNew->setAccessIp($apiTransaction->getAccessIp());
            $apiTransactionNew->setUserId($apiTransaction->getUserId());
            $apiTransactionNew->setTransactionAction($apiTransaction->getTransactionAction());
            $apiTransactionNew->setTransactionData($apiTransaction->getTransactionData());
            $apiTransactionNew->setRemark($apiTransaction->getRemark());
            $apiTransactionNew->setStatusCode($apiTransaction->getStatusCode());
            $apiTransactionNew->setToken($apiTransaction->getToken());
            $apiTransactionNew->setCreatedBy($apiTransaction->getCreatedBy());
            $apiTransactionNew->setUpdatedBy($apiTransaction->getUpdatedBy());
            $apiTransactionNew->setCreatedOn($apiTransaction->getCreatedOn());
            $apiTransactionNew->setRequestData($apiTransaction->getRequestData());
            $apiTransactionNew->setResponseData($apiTransaction->getResponseData());
            $apiTransactionNew->setRefId($apiTransaction->getRefId());
            $apiTransactionNew->setRefType($apiTransaction->getRefType());
            $apiTransactionNew->save();
            //var_dump($apiTransaction);
            $apiTransaction->delete();
        }

        $this->transactionToken = $transactionToken;
        $this->result = $result;
        $this->msg = $msg;
        $this->setTemplate("checkoutRedirect");
    }

    public function executeDoLogin()
    {
        $existUser = null;
        $username = trim($this->getRequestParameter('username'));
        $password = trim($this->getRequestParameter('userpassword'));
        $q = trim($this->getRequestParameter('q'));  // q = doaction
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
            $apiTransaction->setTransactionAction(strtoupper($q));
            $apiTransaction->setTransactionData("USERNAME:".$username.", PASSEWORD:".$password.", Q:".$q.", A:".$a);
            $apiTransaction->setRemark("");
            if (strtoupper($q) == "CHECKOUT") {
                $apiTransaction->setStatusCode("ACTIVE");
            } else if (strtoupper($q) == "ENQUIRYBALANCE") {
                $apiTransaction->setStatusCode("COMPLETE");
            }
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
