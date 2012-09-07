<?php

/**
 * finance actions.
 *
 * @package    sf_sandbox
 * @subpackage finance
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class financeActions extends sfActions
{
    /* ****************************************
     *     Epoint Transfer
     * *****************************************/
    public function executeEpointTransfer()
    {
    }
    public function executeDoEpointTransfer()
    {
        $distId = $this->getRequestParameter('distId');
        $epointAmount = $this->getRequestParameter('epointAmount');

        $existDist = MlmDistributorPeer::retrieveByPK($distId);
        if (!$existDist) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Member Id."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        $companyEPointBalance = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
        $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);

        if ($companyEPointBalance < $epointAmount) {
            $output = array(
                "error" => true,
                "errorMsg" => "Insufficient e-Point."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
        $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $existDist->getDistributorCode() . " (" . $existDist->getFullName() . ")");
        $mlm_account_ledger->setCredit(0);
        $mlm_account_ledger->setDebit($epointAmount);
        $mlm_account_ledger->setBalance($companyEPointBalance - $epointAmount);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($distId);
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
        $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " COMPANY");
        $mlm_account_ledger->setCredit($epointAmount);
        $mlm_account_ledger->setDebit(0);
        $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_EPOINT);

        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }
    /* ****************************************
     *     pipsBonus
     * *****************************************/
    public function executePipsBonusDetailByDist()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));
        $this->forward404Unless($distDB);
        $joinDate = $distDB->getActiveDatetime();
        $joinMonth = date('m', strtotime($joinDate));
        $joinYear = date('Y', strtotime($joinDate));

        $currentMonth = date('m');
        $currentYear = date('Y');

        $anode = array();

        $idx = 0;

        $month = array();
        $month["1"] = "January";
        $month["2"] = "February";
        $month["3"] = "March";
        $month["4"] = "April";
        $month["5"] = "May";
        $month["6"] = "June";
        $month["7"] = "July";
        $month["8"] = "August";
        $month["9"] = "September";
        $month["10"] = "October";
        $month["11"] = "November";
        $month["12"] = "December";

        $longString = "";
        for ($i = intval($joinMonth); $i <= intval($currentMonth); $i++) {
            $longString = $longString ."<tr class='odd'>
                <td align='center'>".$month[$i]."</td>
                <td align='right'>".number_format($this->getPipsBonusDetailByMonth($distDB->getDistributorId(), $i, date('Y'), null), 2)."</td>
                </tr>";
        }
        echo json_encode($longString);
        return sfView::HEADER_ONLY;
    }
    public function executePipsBonusDetail()
    {
        $query = "SELECT month_traded, year_traded, file_id
	                FROM mlm_pip_csv where status_code = '".Globals::STATUS_PIPS_CSV_SUCCESS."' group by month_traded, year_traded, file_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $arr = array();
        $bonusArr = array();
        $idx = 0;
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
            $resultArr = $resultset->getRow();
            $bonusArr[$idx]['PIPS'] = $this->getPipsBonusDetailByMonth(null, $resultArr['month_traded'], $resultArr['year_traded'], $resultArr['file_id']);
            $bonusArr[$idx]['CREDIT'] = $this->getCreditRefundBonusDetailByMonth(null, $resultArr['month_traded'], $resultArr['year_traded'], $resultArr['file_id']);
            $idx++;
        }
        $this->arr = $arr;
        $this->bonusArr = $bonusArr;
    }
    /* ****************************************
     *     Mt4Withdrawal
     * *****************************************/
    public function executeMt4WithdrawalEdit()
    {
        $mt4Withdraw = MlmMt4WithdrawPeer::retrieveByPk($this->getRequestParameter('upgradeId'));
        $this->forward404Unless($mt4Withdraw);

        $this->mt4Withdraw = $mt4Withdraw;
    }
    public function executeUpdateMt4Withdrawal()
    {
        $statusCode = $this->getRequestParameter('status_code');
        $remarks = $this->getRequestParameter('remarks');

        $con = Propel::getConnection(MlmMt4WithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

            $mt4Withdraw = MlmMt4WithdrawPeer::retrieveByPk($this->getRequestParameter('withdraw_id'));
            $this->forward404Unless($mt4Withdraw);

            $mt4Withdraw->setRemarks($remarks);
            $mt4Withdraw->setStatusCode($statusCode);
            $mt4Withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                $mt4Withdraw->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            }

            $mt4Withdraw->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return $this->redirect('finance/mt4Withdrawal');
    }
    public function executeMt4Withdrawal()
    {
        if ($this->getRequestParameter('upgradeStatus') && $this->getRequestParameter('upgradeId')) {
            $error = false;
            $arr = $this->getRequestParameter('upgradeId');
            $statusCode = $this->getRequestParameter('upgradeStatus');

            $con = Propel::getConnection(MlmMt4WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $mt4Withdrawal = MlmMt4WithdrawPeer::retrieveByPk($arr[$i]);
                    $this->forward404Unless($mt4Withdrawal);

                    $mt4Withdrawal->setStatusCode($statusCode);
                    $mt4Withdrawal->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                    if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                        $mt4Withdrawal->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                    }
                    $mt4Withdrawal->save();
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/mt4Withdrawal');
        }
    }
    /* ****************************************
     *     ReloadMt4Fund
     * *****************************************/
    public function executeReloadMt4FundEdit()
    {
        $mt4ReloadFund = MlmMt4ReloadFundPeer::retrieveByPk($this->getRequestParameter('upgradeId'));
        $this->forward404Unless($mt4ReloadFund);

        $this->mt4ReloadFund = $mt4ReloadFund;
    }
    public function executeUpdateReloadMt4Fund()
    {
        $statusCode = $this->getRequestParameter('status_code');
        $remarks = $this->getRequestParameter('remarks');

        $con = Propel::getConnection(MlmMt4ReloadFundPeer::DATABASE_NAME);
        try {
            $con->begin();

            $mt4ReloadFund = MlmMt4ReloadFundPeer::retrieveByPk($this->getRequestParameter('reload_id'));
            $this->forward404Unless($mt4ReloadFund);

            $mt4ReloadFund->setRemarks($remarks);
            $mt4ReloadFund->setStatusCode($statusCode);
            $mt4ReloadFund->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                $mt4ReloadFund->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            }

            $mt4ReloadFund->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return $this->redirect('finance/reloadMt4Fund');
    }
    public function executeReloadMt4Fund()
    {
        if ($this->getRequestParameter('upgradeStatus') && $this->getRequestParameter('upgradeId')) {
            $error = false;
            $arr = $this->getRequestParameter('upgradeId');
            $statusCode = $this->getRequestParameter('upgradeStatus');

            $con = Propel::getConnection(MlmMt4ReloadFundPeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $mt4ReloadFund = MlmMt4ReloadFundPeer::retrieveByPk($arr[$i]);
                    $this->forward404Unless($mt4ReloadFund);

                    $mt4ReloadFund->setStatusCode($statusCode);
                    $mt4ReloadFund->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                    if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                        $mt4ReloadFund->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                    }

                    $mt4ReloadFund->save();
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/reloadMt4Fund');
        }
    }

    /* ****************************************
     *     ReferralBonus
     * *****************************************/
    public function executeReferralBonusEdit()
    {
        $distCommissionLedger = MlmDistCommissionLedgerPeer::retrieveByPk($this->getRequestParameter('upgradeId'));
        $this->forward404Unless($distCommissionLedger);

        $this->distCommissionLedger = $distCommissionLedger;
    }
    public function executeUpdateReferralBonus()
    {
        $statusCode = $this->getRequestParameter('status_code');
        $remarks = $this->getRequestParameter('remark');

        $con = Propel::getConnection(MlmMt4ReloadFundPeer::DATABASE_NAME);
        try {
            $con->begin();

            $distCommissionLedger = MlmDistCommissionLedgerPeer::retrieveByPk($this->getRequestParameter('commission_id'));
            $this->forward404Unless($distCommissionLedger);

            $distCommissionLedger->setRemark($remarks);
            $distCommissionLedger->setStatusCode($statusCode);
            $distCommissionLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

            $distCommissionLedger->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return $this->redirect('finance/referralBonus');
    }
    public function executeReferralBonus()
    {
        if ($this->getRequestParameter('upgradeStatus') && $this->getRequestParameter('upgradeId')) {
            $error = false;
            $arr = $this->getRequestParameter('upgradeId');
            $statusCode = $this->getRequestParameter('upgradeStatus');

            $con = Propel::getConnection(MlmDistCommissionLedgerPeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $distCommissionLedger = MlmDistCommissionLedgerPeer::retrieveByPk($arr[$i]);
                    $this->forward404Unless($distCommissionLedger);

                    $distCommissionLedger->setStatusCode($statusCode);
                    $distCommissionLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                    $distCommissionLedger->save();
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/referralBonus');
        }
    }

    public function executeEpointPurchase()
    {
        if ($this->getRequestParameter('purchaseStatus') && $this->getRequestParameter('purchaseId')) {
            $error = false;
            $arr = $this->getRequestParameter('purchaseId');
            $statusCode = $this->getRequestParameter('purchaseStatus');

            $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $mlm_dist_epoint_purchase = MlmDistEpointPurchasePeer::retrieveByPk($arr[$i]);
                    $this->forward404Unless($mlm_dist_epoint_purchase);

                    $totalEpoint = $mlm_dist_epoint_purchase->getAmount();

                    $dist = MlmDistributorPeer::retrieveByPK($mlm_dist_epoint_purchase->getDistId());
                    $this->forward404Unless($dist);
                    /* ***********************************
                     *   Company Account
                     * ************************************/
                    $companyEpoint = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
                    $distEpoint = $this->getAccountBalance($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
                    //var_dump($companyEpoint);
                    //var_dump($totalEpoint);
                    //exit();
                    if ($companyEpoint >= $totalEpoint) {
                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                        $mlm_account_ledger->setRemark("EPOINT PURCHASE (" . $dist->getDistributorCode() . ")");
                        $mlm_account_ledger->setCredit(0);
                        $mlm_account_ledger->setDebit($totalEpoint);
                        $mlm_account_ledger->setBalance($companyEpoint - $totalEpoint);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($dist->getDistributorId());
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                        $mlm_account_ledger->setRemark("");
                        $mlm_account_ledger->setCredit($totalEpoint);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distEpoint + $totalEpoint);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->revalidateAccount($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
                        /* ***********************************
                       *   e-Point
                       * ************************************/
                        $mlm_dist_epoint_purchase->setStatusCode($statusCode);
                        //$mlm_ecash_withdraw->setRemarks($this->getRequestParameter('remarks'));
                        $mlm_dist_epoint_purchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                        if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                            $mlm_dist_epoint_purchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                            if (Globals::STATUS_COMPLETE == $statusCode) {
                                $mlm_dist_epoint_purchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
                            }
                        }

                        $mlm_dist_epoint_purchase->save();
                    } else {
                        $error = true;

                        $this->setFlash('errorMsg', "Insufficient e-Point.");
                    }
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/epointPurchase');
        }
    }

    /* ****************************************
     *     PackagePurchase
     * *****************************************/
    public function executePackagePurchase()
    {
        if ($this->getRequestParameter('purchaseStatus') && $this->getRequestParameter('purchaseId')) {
            $error = false;
            $arr = $this->getRequestParameter('purchaseId');
            $statusCode = $this->getRequestParameter('purchaseStatus');

            $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $mlm_dist_epoint_purchase = MlmDistEpointPurchasePeer::retrieveByPk($arr[$i]);
                    $this->forward404Unless($mlm_dist_epoint_purchase);

                    $totalEpoint = $mlm_dist_epoint_purchase->getAmount();

                    $dist = MlmDistributorPeer::retrieveByPK($mlm_dist_epoint_purchase->getDistId());
                    $this->forward404Unless($dist);
                    /* ***********************************
                     *   Company Account
                     * ************************************/
                    $companyEpoint = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
                    $distEpoint = $this->getAccountBalance($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
                    //var_dump($companyEpoint);
                    //var_dump($totalEpoint);
                    //exit();
                    if ($companyEpoint >= $totalEpoint) {
                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                        $mlm_account_ledger->setRemark("EPOINT PURCHASE (" . $dist->getDistributorCode() . ")");
                        $mlm_account_ledger->setCredit(0);
                        $mlm_account_ledger->setDebit($totalEpoint);
                        $mlm_account_ledger->setBalance($companyEpoint - $totalEpoint);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($dist->getDistributorId());
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                        $mlm_account_ledger->setRemark("");
                        $mlm_account_ledger->setCredit($totalEpoint);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distEpoint + $totalEpoint);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->revalidateAccount($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
                        /* ***********************************
                       *   e-Point
                       * ************************************/
                        $mlm_dist_epoint_purchase->setStatusCode($statusCode);
                        //$mlm_ecash_withdraw->setRemarks($this->getRequestParameter('remarks'));
                        $mlm_dist_epoint_purchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                        if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                            $mlm_dist_epoint_purchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                            if (Globals::STATUS_COMPLETE == $statusCode) {
                                $mlm_dist_epoint_purchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
                            }
                        }

                        $mlm_dist_epoint_purchase->save();
                    } else {
                        $error = true;

                        $this->setFlash('errorMsg', "Insufficient e-Point.");
                    }
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/epointPurchase');
        }
    }

    public function executePackagePurchaseEdit()
    {
        $mlm_dist_epoint_purchase = MlmDistEpointPurchasePeer::retrieveByPk($this->getRequestParameter('purchaseId'));
        $this->forward404Unless($mlm_dist_epoint_purchase);

        $this->mlm_dist_epoint_purchase = $mlm_dist_epoint_purchase;
    }

    public function executeUpdatePackagePurchase()
    {
        $statusCode = $this->getRequestParameter('status_code');

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();

            $mlm_dist_epoint_purchase = MlmDistEpointPurchasePeer::retrieveByPk($this->getRequestParameter('purchase_id'));
            $this->forward404Unless($mlm_dist_epoint_purchase);

            $totalEpoint = $mlm_dist_epoint_purchase->getAmount();

            $dist = MlmDistributorPeer::retrieveByPK($mlm_dist_epoint_purchase->getDistId());
            $this->forward404Unless($dist);
            /* ***********************************
             *   Company Account
             * ************************************/
            $companyEpoint = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
            $distEpoint = $this->getAccountBalance($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);

            //var_dump($companyEpoint);
            //var_dump($totalEpoint);
            //exit();
            if ($companyEpoint >= $totalEpoint) {
                if (Globals::STATUS_COMPLETE == $statusCode) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                    $mlm_account_ledger->setRemark("EPOINT PURCHASE (" . $dist->getDistributorCode() . ")");
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($totalEpoint);
                    $mlm_account_ledger->setBalance($companyEpoint - $totalEpoint);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($dist->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                    $mlm_account_ledger->setRemark("");
                    $mlm_account_ledger->setCredit($totalEpoint);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distEpoint + $totalEpoint);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
                }
                /* ***********************************
               *   e-Point
               * ************************************/
                $mlm_dist_epoint_purchase->setStatusCode($statusCode);
                $mlm_dist_epoint_purchase->setRemarks($this->getRequestParameter('remarks'));
                $mlm_dist_epoint_purchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                    $mlm_dist_epoint_purchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                    if (Globals::STATUS_COMPLETE == $statusCode) {
                        $mlm_dist_epoint_purchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
                    }
                }

                $mlm_dist_epoint_purchase->save();
            } else {
                $error = true;

                $this->setFlash('errorMsg', "Insufficient e-Point.");
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        if ($error == false)
            $this->setFlash('successMsg', "Update successfully");
        return $this->redirect('finance/epointPurchase');
    }

    public function executePackageUpgradeHistory()
    {
        if ($this->getRequestParameter('upgradeStatus') && $this->getRequestParameter('upgradeId')) {
            $error = false;
            $arr = $this->getRequestParameter('upgradeId');
            $statusCode = $this->getRequestParameter('upgradeStatus');

            $con = Propel::getConnection(MlmPackageUpgradeHistoryPeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $packageUpgradeHistory = MlmPackageUpgradeHistoryPeer::retrieveByPk($arr[$i]);
                    $this->forward404Unless($packageUpgradeHistory);

                    $packageUpgradeHistory->setStatusCode($statusCode);
                    $packageUpgradeHistory->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                    $packageUpgradeHistory->save();
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/packageUpgradeHistory');
        }
    }

    public function executeUpdatePurchaseEPoint()
    {
        $statusCode = $this->getRequestParameter('status_code');

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();

            $mlm_dist_epoint_purchase = MlmDistEpointPurchasePeer::retrieveByPk($this->getRequestParameter('purchase_id'));
            $this->forward404Unless($mlm_dist_epoint_purchase);

            $totalEpoint = $mlm_dist_epoint_purchase->getAmount();

            if (Globals::STATUS_REJECT == $statusCode) {
                $mlm_dist_epoint_purchase->setStatusCode($statusCode);
                $mlm_dist_epoint_purchase->setRemarks($this->getRequestParameter('remarks'));
                $mlm_dist_epoint_purchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mlm_dist_epoint_purchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                $mlm_dist_epoint_purchase->save();
            } else {
                $dist = MlmDistributorPeer::retrieveByPK($mlm_dist_epoint_purchase->getDistId());
                $this->forward404Unless($dist);
                /* ***********************************
               *   Company Account
               * ************************************/
                $companyEpoint = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
                $distEpoint = $this->getAccountBalance($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);

                //var_dump($companyEpoint);
                //var_dump($totalEpoint);
                //exit();
                if ($companyEpoint >= $totalEpoint) {
                    if (Globals::STATUS_COMPLETE == $statusCode) {
                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                        $mlm_account_ledger->setRemark("EPOINT PURCHASE (" . $dist->getDistributorCode() . ")");
                        $mlm_account_ledger->setCredit(0);
                        $mlm_account_ledger->setDebit($totalEpoint);
                        $mlm_account_ledger->setBalance($companyEpoint - $totalEpoint);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($dist->getDistributorId());
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                        $mlm_account_ledger->setRemark("");
                        $mlm_account_ledger->setCredit($totalEpoint);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distEpoint + $totalEpoint);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->revalidateAccount($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
                    }
                    /* ***********************************
                   *   e-Point
                   * ************************************/
                    $mlm_dist_epoint_purchase->setStatusCode($statusCode);
                    $mlm_dist_epoint_purchase->setRemarks($this->getRequestParameter('remarks'));
                    $mlm_dist_epoint_purchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                    if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                        $mlm_dist_epoint_purchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                        if (Globals::STATUS_COMPLETE == $statusCode) {
                            $mlm_dist_epoint_purchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
                        }
                    }

                    $mlm_dist_epoint_purchase->save();
                } else {
                    $error = true;

                    $this->setFlash('errorMsg', "Insufficient e-Point.");
                }
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        if ($error == false)
            $this->setFlash('successMsg', "Update successfully");
        return $this->redirect('finance/epointPurchase');
    }

    public function executeUpdatePackageUpgrade()
    {
        $statusCode = $this->getRequestParameter('status_code');
        $remarks = $this->getRequestParameter('remarks');

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();

            $packageUpgradeHistory = MlmPackageUpgradeHistoryPeer::retrieveByPk($this->getRequestParameter('upgrade_id'));
            $this->forward404Unless($packageUpgradeHistory);

            $packageUpgradeHistory->setRemarks($remarks);
            $packageUpgradeHistory->setStatusCode($statusCode);
            $packageUpgradeHistory->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

            $packageUpgradeHistory->save();

            $mlm_dist_mt4 = new MlmDistMt4();
            $mlm_dist_mt4->setDistId($packageUpgradeHistory->getDistId());
            $mlm_dist_mt4->setMt4UserName($this->getRequestParameter('mt4Id'));
            $mlm_dist_mt4->setMt4Password($this->getRequestParameter('mt4Password'));
            $mlm_dist_mt4->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_dist_mt4->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_dist_mt4->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return $this->redirect('finance/packageUpgradeHistory');
    }

    public function executePackageUpgradeHistoryEdit()
    {
        $packageUpgradeHistory = MlmPackageUpgradeHistoryPeer::retrieveByPk($this->getRequestParameter('upgradeId'));
        $this->forward404Unless($packageUpgradeHistory);

        $this->packageUpgradeHistory = $packageUpgradeHistory;
    }

    public function executeEpointPurchaseEdit()
    {
        $mlm_dist_epoint_purchase = MlmDistEpointPurchasePeer::retrieveByPk($this->getRequestParameter('purchaseId'));
        $this->forward404Unless($mlm_dist_epoint_purchase);

        $this->mlm_dist_epoint_purchase = $mlm_dist_epoint_purchase;
    }

    public function executeEPointTransaction()
    {
    }

    public function executeEcashWithdrawal()
    {
        if ($this->getRequestParameter('withdrawStatus') && $this->getRequestParameter('withdrawId')) {
            $arr = $this->getRequestParameter('withdrawId');
            $statusCode = $this->getRequestParameter('withdrawStatus');

            for ($i = 0; $i < count($arr); $i++) {
                $mlm_ecash_withdraw = MlmEcashWithdrawPeer::retrieveByPk($arr[$i]);
                $this->forward404Unless($mlm_ecash_withdraw);

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                //$mlm_ecash_withdraw->setRemarks($this->getRequestParameter('remarks'));
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                if (Globals::WITHDRAWAL_PAID == $statusCode || Globals::WITHDRAWAL_REJECTED == $statusCode)
                    $mlm_ecash_withdraw->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                $mlm_ecash_withdraw->save();

                if (Globals::WITHDRAWAL_REJECTED == $statusCode) {
                    $refundEcash = $mlm_ecash_withdraw->getAmount();
                    $distId = $mlm_ecash_withdraw->getDistId();
                    /******************************/
                    /*  Account
                    /******************************/
                    $c = new Criteria();
                    $c->add(MlmAccountLedgerPeer::DIST_ID, $distId);
                    $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
                    $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
                    $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);

                    $this->forward404Unless($accountLedgerDB);
                    $distAccountEcashBalance = $accountLedgerDB->getBalance();

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
                    $mlm_account_ledger->setRemark("REFUND FOR WITHDRAW ID " . $mlm_ecash_withdraw->getWithdrawId());
                    $mlm_account_ledger->setCredit($refundEcash);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distAccountEcashBalance + $refundEcash);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
                }
            }
            $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/ecashWithdrawal');
        }
    }

    public function executeECashTransaction()
    {
    }

    public function executePipsCalculator()
    {
        $anode = array();
        if ($this->getRequestParameter('total_amount') <> "" && $this->getRequestParameter('sponsorId') <> "") {
            $totalAmount = $this->getRequestParameter('total_amount');
            $distributorCode = $this->getRequestParameter('sponsorId');

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distributorCode);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $existDistributor = MlmDistributorPeer::doSelectOne($c);

            if ($existDistributor) {
                $index = 0;
                /*$affectedDistributorPackageDB = MlmPackagePeer::retrieveByPK($existDistributor->getRankId());
                $anode[$index]["distId"] = $existDistributor->getDistributorId();
                $anode[$index]["distCode"] = $existDistributor->getDistributorCode();
                $anode[$index]["treeLevel"] = $existDistributor->getTreeLevel();
                $anode[$index]["treeStructure"] = $existDistributor->getTreeStructure();
                $anode[$index]["packageId"] = $affectedDistributorPackageDB->getPackageId();
                $anode[$index]["packageName"] = $affectedDistributorPackageDB->getPackageName();
                $anode[$index]["pipsAmount"] = $affectedDistributorPackageDB->getPips() * $totalAmount;
                $index++;*/

                $treeLevel = $existDistributor->getTreeLevel();
                $treeStructure = $existDistributor->getTreeStructure();
                $affectedDistributorArrs = explode("|", $treeStructure);

                for ($y = count($affectedDistributorArrs); $y > 0; $y--) {
                    if ($affectedDistributorArrs[$y] == "") {
                        continue;
                    }
                    $affectedDistributorId = $affectedDistributorArrs[$y];
                    $c = new Criteria();
                    $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $affectedDistributorId, Criteria::EQUAL);
                    $affectedDistributor = MlmDistributorPeer::doSelectOne($c);

                    $affectedDistributorTreeLevel = $affectedDistributor->getTreeLevel();
                    $affectedDistributorPackageDB = MlmPackagePeer::retrieveByPK($affectedDistributor->getRankId());
                    if ($affectedDistributorPackageDB) {
                        $generation = $affectedDistributorPackageDB->getGeneration();

                        $isEntitled = false;
                        if ($generation == null) {
                            $isEntitled = true;
                        } else {
                            if (($treeLevel - $affectedDistributorTreeLevel) <= $generation) {
                                $isEntitled = true;
                            }
                        }

                        if ($isEntitled) {
                            $anode[$index]["distId"] = $affectedDistributor->getDistributorId();
                            $anode[$index]["distCode"] = $affectedDistributor->getDistributorCode();
                            $anode[$index]["treeLevel"] = $affectedDistributor->getTreeLevel();
                            $anode[$index]["treeStructure"] = $affectedDistributor->getTreeStructure();
                            $anode[$index]["packageId"] = $affectedDistributorPackageDB->getPackageId();
                            $anode[$index]["packageName"] = $affectedDistributorPackageDB->getPackageName();
                            $anode[$index]["pipsAmount"] = $affectedDistributorPackageDB->getPips() * $totalAmount;
                            $index++;
                        }
                    }
                }
            }
        }
        $this->anode = $anode;
    }

    public function executeDailyBonus()
    {
        if ($this->getRequestParameter('date_from') <> "" || $this->getRequestParameter('date_to') <> "") {
            $query = "SELECT b.f_id,b.f_code,b.f_name,SUM(a.f_dsb) AS f_dsb, SUM(a.f_gdb) AS f_gdb, SUM(a.f_gap) AS f_gap, SUM(a.f_elb) AS f_elb, SUM(a.f_wpb) AS f_wpb, SUM(a.f_dsb+a.f_gdb+a.f_gap+a.f_elb+a.f_wpb) AS f_total FROM tbl_member_comm_sum a INNER JOIN tbl_distributor b ON b.f_id=a.f_dist_id WHERE 1";
            if ($this->getRequestParameter('date_from') <> "") {
                $query .= " AND f_bonus_date>='" . $this->getRequestParameter('date_from') . "'";
                $this->date_from = $this->getRequestParameter('date_from');
            }
            if ($this->getRequestParameter('date_to') <> "") {
                $query .= " AND f_bonus_date<='" . $this->getRequestParameter('date_to') . "'";
                $this->date_to = $this->getRequestParameter('date_to');
            }
            $query .= " GROUP BY f_dist_id";
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $this->rs = $statement->executeQuery();
        }
    }

    public function executeAdvanceEpoint()
    {
    }

    public function executeDoAdvanceEpoint()
    {
        if ($this->getRequestParameter('total_epoint') > 0) {
            // ******** Company Account **********
            $companyEPointBalance = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
            $epointAdvance = $this->getRequestParameter('total_epoint');

            // ******** From Account Ledger [company] **********
            $tbl_account_ledger = new MlmAccountLedger();
            $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
            $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ADVANCE);
            $tbl_account_ledger->setRemark("");
            $tbl_account_ledger->setCredit($epointAdvance);
            $tbl_account_ledger->setDebit(0);
            $tbl_account_ledger->setBalance($companyEPointBalance + $epointAdvance);
            $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger->save();

            $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

            $this->setFlash('successMsg', "Advance Payment Success.");
            return $this->redirect('/finance/advanceEpoint');
        }
    }

    public function executeAdvanceEcash()
    {
        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('total_ecash') > 0) {
            // ******** Company Account **********
            $c = new Criteria();
            $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
            $c->addAnd(MlmAccountPeer::DIST_ID, Globals::SYSTEM_COMPANY_DIST_ID);
            $companyAccount = MlmAccountPeer::doSelectOne($c);

            $fromBalance = $companyAccount->getBalance();
            $ecashAdvance = $this->getRequestParameter('total_ecash');

            // ******** To Account [distributor] **********
            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('sponsorId'));
            $existDist = MlmDistributorPeer::doSelectOne($c);

            $c = new Criteria();
            $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
            $c->addAnd(MlmAccountPeer::DIST_ID, $existDist->getDistributorId());
            $toAccount = MlmAccountPeer::doSelectOne($c);
            $this->forward404Unless($toAccount);
            $toId = $existDist->getDistributorId();

            $c = new Criteria();
            $c->add(MlmAccountLedgerPeer::DIST_ID, $toId);
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
            $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
            $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
            $this->forward404Unless($accountLedgerDB);
            $toBalance = $accountLedgerDB->getBalance();

            // ******** To Account Ledger [distributor] **********
            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
            $mlm_account_ledger->setDistId($toId);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ADVANCE);
            $mlm_account_ledger->setRemark("Advance");
            $mlm_account_ledger->setCredit($ecashAdvance);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($toBalance + $ecashAdvance);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_ECASH);

            // ******** From Account Ledger [company] **********
            $tbl_account_ledger = new MlmAccountLedger();
            $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
            $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
            $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ADVANCE);
            $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_ADVANCE . " " . $existDist->getDistributorCode());
            $tbl_account_ledger->setCredit(0);
            $tbl_account_ledger->setDebit($ecashAdvance);
            $tbl_account_ledger->setBalance($fromBalance - $ecashAdvance);
            $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger->save();

            $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);

            $this->setFlash('successMsg', "Transfer success");
            return $this->redirect('/finance/advanceEcash');
        }
    }

    public function executeVerifySponsorId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            if ($existUser->getDistributorId() <> $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
                $arr = array(
                    'userId' => $existUser->getDistributorId(),
                    'userName' => $existUser->getDistributorCode(),
                    'fullname' => $existUser->getFullName(),
                    'nickname' => $existUser->getNickname()
                );
            }
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    /************************************************************************************************************************
     * function
     ************************************************************************************************************************/
    function revalidateAccount($distributorId, $accountType)
    {
        $balance = $this->getAccountBalance($distributorId, $accountType);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, $accountType);
        $c->add(MlmAccountPeer::DIST_ID, $distributorId);
        $tbl_account = MlmAccountPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmAccount();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setAccountType($accountType);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
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

    function getCommissionBalance($distributorId, $commissionType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger WHERE dist_id = " . $distributorId . " AND commission_type = '" . $commissionType . "'";

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

    function getPipsBonusDetailByMonth($distributorId, $month, $year, $fileId)
    {
        //$dateUtil = new DateUtil();

        //$d = $dateUtil->getMonth($month, $year);
        //$firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        //$lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE csv.file_id = " . $fileId
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_PIPS_BONUS . "'"
                 . " AND bonus.transaction_type = '" . Globals::COMMISSION_LEDGER_PIPS_GAIN . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);
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

    function getCreditRefundBonusDetailByMonth($distributorId, $month, $year, $fileId)
    {
        //$dateUtil = new DateUtil();

        //$d = $dateUtil->getMonth($month, $year);
        //$firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        //$lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE csv.file_id = " . $fileId
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_CREDIT_REFUND . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);
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