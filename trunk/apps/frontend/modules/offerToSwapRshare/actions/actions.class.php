<?php

/**
 * offerToSwapRshare actions.
 *
 * @package    sf_sandbox
 * @subpackage offerToSwapRshare
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class offerToSwapRshareActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
        $this->distributorDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->mt4Ids = $this->getFetchMt4List($this->getUser()->getAttribute(Globals::SESSION_DISTID), "");
        $this->mt4Balance = 0;
        $this->remainingRoiAmount = 0;
        $this->cp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->cp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->totalRshare = 0;
        $this->roiRemainingMonth = 0;
        $this->roiPercentage = 0;
    }

    public function executeConfirmation()
    {
        $this->distributorDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->mt4Id = $this->getRequestParameter('mt4Id');

        if (!$this->mt4Id) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }
        $this->mt4Ids = $this->getFetchMt4List($this->getUser()->getAttribute(Globals::SESSION_DISTID), $this->getRequestParameter('mt4Id'));
        $this->mt4Balance = 0;
        $this->remainingRoiAmount = 0;

        $mt4UserName = $this->getRequestParameter('mt4Id');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        if (count($this->mt4Ids) <= 0) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }

        $mt4Balance = $this->getMt4Balance($distId, $mt4UserName);
        $roiArr = $this->getRoiInformation($distId, $mt4UserName);

        $roiPercentage = $roiArr['roi_percentage'];
        $roiRemainingMonth = 18 - $roiArr['idx'];
        $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

        $this->mt4Balance = $mt4Balance;
        $this->remainingRoiAmount = $remainingRoiAmount;

        $this->convertedCp2 = $this->getRequestParameter('convertedCp2', 0);
        $this->convertedCp3 = $this->getRequestParameter('convertedCp3', 0);

        $this->convertedCp2 = str_replace(",", "", $this->convertedCp2);
        $this->convertedCp3 = str_replace(",", "", $this->convertedCp3);

        $this->cp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->cp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->roiRemainingMonth = $roiRemainingMonth;
        $this->roiPercentage = $roiPercentage;

        //var_dump($this->convertedCp2);
        //var_dump($this->cp2Balance);
        //exit();
        if ($this->convertedCp2 > $this->cp2Balance) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Insufficient CP2 Balance."));
            return $this->redirect('/offerToSwapRshare/index');
        }
        if ($this->convertedCp3 > $this->cp3Balance) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Insufficient CP2 Balance."));
            return $this->redirect('/offerToSwapRshare/index');
        }

        $totalAmountConverted = $mt4Balance + ($mt4Balance * $roiRemainingMonth * $roiPercentage / 100);
        $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted + $this->convertedCp2 + $this->convertedCp3;
        $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

        $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
        $this->totalRshare = round($totalRshare);

        $this->signature = $this->getRequestParameter('txtSignature');
    }

    public function executeDoSave()
    {
        $this->distributorDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->mt4Id = $this->getRequestParameter('mt4Id');

        if (!$this->mt4Id) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }
        $this->mt4Ids = $this->getFetchMt4List($this->getUser()->getAttribute(Globals::SESSION_DISTID), $this->getRequestParameter('mt4Id'));
        $this->mt4Balance = 0;
        $this->remainingRoiAmount = 0;

        $mt4UserName = $this->getRequestParameter('mt4Id');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        if (count($this->mt4Ids) <= 0) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }

        $mt4Balance = $this->getMt4Balance($distId, $mt4UserName);
        $roiArr = $this->getRoiInformation($distId, $mt4UserName);

        $roiPercentage = $roiArr['roi_percentage'];
        $roiRemainingMonth = 18 - $roiArr['idx'];
        $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

        $this->mt4Balance = $mt4Balance;
        $this->remainingRoiAmount = $remainingRoiAmount;

        $this->convertedCp2 = $this->getRequestParameter('convertedCp2', 0);
        $this->convertedCp3 = $this->getRequestParameter('convertedCp3', 0);

        $this->convertedCp2 = str_replace(",", "", $this->convertedCp2);
        $this->convertedCp3 = str_replace(",", "", $this->convertedCp3);

        $this->cp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->cp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->roiRemainingMonth = $roiRemainingMonth;
        $this->roiPercentage = $roiPercentage;

        //var_dump($this->convertedCp2);
        //var_dump($this->cp2Balance);
        //exit();
        if ($this->convertedCp2 > $this->cp2Balance) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Insufficient CP2 Balance."));
            return $this->redirect('/offerToSwapRshare/index');
        }
        if ($this->convertedCp3 > $this->cp3Balance) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Insufficient CP2 Balance."));
            return $this->redirect('/offerToSwapRshare/index');
        }

        $totalAmountConverted = $mt4Balance + ($mt4Balance * $roiRemainingMonth * $roiPercentage / 100);
        $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted + $this->convertedCp2 + $this->convertedCp3;
        $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

        $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
        $this->totalRshare = round($totalRshare);

        $this->signature = $this->getRequestParameter('txtSignature');

        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            $sss_application = new SssApplication();
            $sss_application->setDistId($distId);
            $sss_application->setDividendId($roiArr['devidend_id']);
            $sss_application->setMt4UserName($mt4UserName);
            $sss_application->setCp2Balance($this->convertedCp2);
            $sss_application->setCp3Balance($this->convertedCp3);
            $sss_application->setMt4Balance($this->mt4Balance);
            $sss_application->setRoiRemainingMonth($roiRemainingMonth);
            $sss_application->setRoiPercentage($roiPercentage);
            $sss_application->setShareValue(0.8);
            $sss_application->setTotalShareConverted($totalRshare);
            $sss_application->setRemarks("");
            $sss_application->setStatusCode("PENDING");
            $sss_application->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sss_application->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sss_application->save();

            if ($this->convertedCp2 > 0) {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($distId);
                $tbl_account_ledger->setTransactionType("SSS");
                $tbl_account_ledger->setRemark("SUPER SHARE SWAP");
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($this->convertedCp2);
                $tbl_account_ledger->setBalance($this->cp2Balance - $this->convertedCp2);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setRefererId($sss_application->getSssId());
                $tbl_account_ledger->setRefererType("SSS");
                $tbl_account_ledger->save();
            }

            if ($this->convertedCp3 > 0) {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $tbl_account_ledger->setDistId($distId);
                $tbl_account_ledger->setTransactionType("SSS");
                $tbl_account_ledger->setRemark("SUPER SHARE SWAP");
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($this->convertedCp3);
                $tbl_account_ledger->setBalance($this->cp3Balance - $this->convertedCp3);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setRefererId($sss_application->getSssId());
                $tbl_account_ledger->setRefererType("SSS");
                $tbl_account_ledger->save();
            }

            $query = "UPDATE mlm_roi_dividend SET status_code = 'SSS' WHERE status_code = 'PENDING' AND dist_id = " . $distId;
            $query = $query . " AND mt4_user_name = ?";
            $query = $query . " AND updated_on = ?";
            $query = $query . " AND updated_by = ?";
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $statement->set(1, $mt4UserName);
            $statement->set(2, date('Y-m-d H:i:s'));
            $statement->set(3, $this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $statement->executeUpdate();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your application has been submitted and pending for approval."));
        return $this->redirect('/offerToSwapRshare/index');
    }

    public function executeSwapNote()
    {
    }

    function getFetchMt4List($distId, $mt4UserName)
    {
        $query = "SELECT distinct dist_id, mt4_user_name
	        FROM mlm_roi_dividend WHERE idx >= 12 and idx <= 18 AND status_code = 'PENDING'
	        AND dist_id = " . $distId;
        //var_dump($query);

        if ($mt4UserName != "") {
            $query = $query . " AND mt4_user_name = ?";
        }
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        if ($mt4UserName != "") {
            $statement->set(1, $mt4UserName);
        }
        $resultset = $statement->executeQuery();
        //exit();
        $arr = array();
        while ($resultset->next()) {
            $arrResult = $resultset->getRow();

            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $arrResult['mt4_user_name']);
            $c->add(MlmRoiDividendPeer::IDX, 11);
            $c->add(MlmRoiDividendPeer::STATUS_CODE, "SUCCESS");
            $existRoi = MlmRoiDividendPeer::doSelectOne($c);

            //var_dump($existRoi);
            //exit();
            if (!$existRoi) {
                continue;
            }

            $arr[] = $arrResult['mt4_user_name'];
        }
        return $arr;
    }

    function getRoiInformation($distId, $mt4UserName)
    {
        $query = "SELECT devidend_id, dist_id, mt4_user_name, idx, account_ledger_id, dividend_date, package_id, package_price, roi_percentage, mt4_balance, dividend_amount, remarks, exceed_dist_id, exceed_roi_percentage, exceed_dividend_amount, status_code, created_by, created_on, updated_by, updated_on, first_dividend_date
	                FROM mlm_roi_dividend WHERE mt4_user_name = ? AND status_code = 'PENDING' AND dist_id = ? ORDER BY idx limit 1 ";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $mt4UserName);
        $statement->set(2, $distId);
        $resultset = $statement->executeQuery();
        //exit();
        $arr = array();
        while ($resultset->next()) {
            $arr = $resultset->getRow();
        }
        return $arr;
    }

    public function executeEnquiryMt4Balance()
    {
        $mt4Id = $this->getRequestParameter('mt4Id');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);

        $arr = array();
        if ($mt4Id) {
            $mt4Balance = $this->getMt4Balance($distId, $mt4Id);
            $roiArr = $this->getRoiInformation($distId, $mt4Id);

            $roiPercentage = $roiArr['roi_percentage'];
            $roiRemainingMonth = 18 - $roiArr['idx'];
            $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;
            //var_dump($remainingRoiAmount);
            $arr = array(
                'mt4Balance' => $mt4Balance
            , 'remainingRoiAmount' => $remainingRoiAmount
            , 'roiRemainingMonth' => $roiRemainingMonth
            , 'roiPercentage' => $roiPercentage
            );
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    function getMt4Balance($distributorId, $mt4Username)
    {
        $arr = array();

        $mt4request = new CMT4DataReciver;
        $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

        $params = array();
        $params['login'] = $mt4Username;

        $answer = $mt4request->MakeRequest("getaccountbalance", $params);
        //if ($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID) == 263646) {
        //    var_dump($answer);
        //var_dump("<br>");
        //var_dump("<br>");
        //var_dump($answer['balance']);
        //    exit();
        //}
        //$packagePrice = $answer['balance'];
        $packagePrice = null;
        if ($answer == null || is_numeric($answer['balance']) == false) {
            //var_dump($answer);
            //var_dump($mt4UserName);
            //var_dump($packagePrice);
            //var_dump("<br>");
            //var_dump(is_numeric($packagePrice));
        } else {
            //$arr = array();
            //$arr['mt4_credit'] = $answer['balance'];
            //$arr['traded_datetime'] = date("Y-m-d h:i:s");
            //return $arr['mt4_credit'];
            $packagePrice = $answer['balance'];
        }

        $mt4request->CloseConnection();
        /*$query = "SELECT credit_id, dist_id, mt4_user_name, mt4_credit, traded_datetime, created_by, created_on, updated_by, updated_on
          	FROM mlm_daily_dist_mt4_credit WHERE dist_id = ".$distributorId. " AND mt4_user_name = '".$mt4Username ."' ORDER BY traded_datetime DESC LIMIT 1";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            return $arr;
        }
        */
        return $packagePrice;
    }

    function getAccountBalance($distributorId, $accountType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_account_ledger WHERE dist_id = ? AND account_type = ?";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $distributorId);
        $statement->set(2, $accountType);
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