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
        $doAction = $this->getRequestParameter('doAction');

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
        $distDebitBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT);

        if ($companyEPointBalance < $epointAmount && $doAction == "transfer") {
            $output = array(
                "error" => true,
                "errorMsg" => "Insufficient e-Point."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        if ($doAction == "debit") {
            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_DEBIT);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DEBIT);
            $mlm_account_ledger->setRollingPoint("Y");
            $mlm_account_ledger->setRemark("");
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($epointAmount);
            $mlm_account_ledger->setBalance($distDebitBalance + $epointAmount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_EPOINT);
        } else {
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
            $mlm_account_ledger->setRollingPoint("Y");
            $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " COMPANY");
            $mlm_account_ledger->setCredit($epointAmount);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_EPOINT);
        }

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
            $longString = $longString . "<tr class='odd'>
                <td align='center'>" . $month[$i] . "</td>
                <td align='right'>" . number_format($this->getPipsBonusDetailByMonth($distDB->getDistributorId(), $i, date('Y'), null), 2) . "</td>
                </tr>";
        }
        echo json_encode($longString);
        return sfView::HEADER_ONLY;
    }

    public function executePipsBonusDetail()
    {
        $query = "SELECT month_traded, year_traded, file_id
	                FROM mlm_pip_csv where status_code = '" . Globals::STATUS_PIPS_CSV_SUCCESS . "' group by month_traded, year_traded, file_id";

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
            $bonusArr[$idx]['FUND'] = $this->getFundManagementBonusDetailByMonth(null, $resultArr['month_traded'], $resultArr['year_traded'], $resultArr['file_id']);
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

            $mt4Withdrawal = MlmMt4WithdrawPeer::retrieveByPk($this->getRequestParameter('withdraw_id'));
            $this->forward404Unless($mt4Withdrawal);

            if ($mt4Withdrawal->getStatusCode() == Globals::STATUS_PENDING) {
                // ******** once mt4 withdrawal has been approved at backend,
                //          the fund will be credited into ecash wallet **********
                if (Globals::STATUS_COMPLETE == $statusCode && $mt4Withdrawal->getStatusCode() == Globals::STATUS_PENDING) {
                    $maintenanceBalance = $this->getAccountBalance($mt4Withdrawal->getDistId(), Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $mt4WithdrawalAmount = $mt4Withdrawal->getAmountRequested();
                    $tbl_account_ledger = new MlmAccountLedger();
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $tbl_account_ledger->setDistId($mt4Withdrawal->getDistId());
                    $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MT4_WITHDRAWAL);
                    $tbl_account_ledger->setRemark("Withdrawal Amount:" . $mt4Withdrawal->getAmountRequested() . ", ID:" . $mt4Withdrawal->getWithdrawId());
                    $tbl_account_ledger->setCredit($mt4WithdrawalAmount);
                    $tbl_account_ledger->setDebit(0);
                    $tbl_account_ledger->setBalance($maintenanceBalance + $mt4WithdrawalAmount);
                    $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->save();

                    $this->revalidateAccount($mt4Withdrawal->getDistId(), Globals::ACCOUNT_TYPE_MAINTENANCE);

                    $mt4Withdrawal->setStatusCode(Globals::STATUS_COMPLETE);
                } else {
                    $mt4Withdrawal->setStatusCode(Globals::STATUS_REJECT);
                }
                $mt4Withdrawal->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mt4Withdrawal->setRemarks($remarks);
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

                    if ($mt4Withdrawal->getStatusCode() == Globals::STATUS_PENDING) {

                        if (Globals::STATUS_COMPLETE == $statusCode && $mt4Withdrawal->getStatusCode() == Globals::STATUS_PENDING) {
                            $maintenanceBalance = $this->getAccountBalance($mt4Withdrawal->getDistId(), Globals::ACCOUNT_TYPE_MAINTENANCE);
                            $mt4WithdrawalAmount = $mt4Withdrawal->getAmountRequested();
                            $tbl_account_ledger = new MlmAccountLedger();
                            $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                            $tbl_account_ledger->setDistId($mt4Withdrawal->getDistId());
                            $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MT4_WITHDRAWAL);
                            $tbl_account_ledger->setRemark("Withdrawal Amount:" . $mt4Withdrawal->getAmountRequested() . ", ID:" . $mt4Withdrawal->getWithdrawId());
                            $tbl_account_ledger->setCredit($mt4WithdrawalAmount);
                            $tbl_account_ledger->setDebit(0);
                            $tbl_account_ledger->setBalance($maintenanceBalance + $mt4WithdrawalAmount);
                            $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $tbl_account_ledger->save();

                            $this->revalidateAccount($mt4Withdrawal->getDistId(), Globals::ACCOUNT_TYPE_MAINTENANCE);

                            $mt4Withdrawal->setStatusCode(Globals::STATUS_COMPLETE);
                        } else {
                            $mt4Withdrawal->setStatusCode(Globals::STATUS_REJECT);
                        }
                        $mt4Withdrawal->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
                        if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                            $mt4Withdrawal->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                        }
                        $mt4Withdrawal->save();
                    }
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
                    if (Globals::STATUS_COMPLETE == $statusCode && $mlm_dist_epoint_purchase->getStatusCode() != Globals::STATUS_COMPLETE) {
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

            /*if ($this->getRequestParameter('distMt4AccountId', "") != "") {
                $mlm_dist_mt4 = MlmDistMt4Peer::retrieveByPk($this->getRequestParameter('distMt4AccountId'));*/
            $tbl_distributor = MlmDistributorPeer::retrieveByPk($packageUpgradeHistory->getDistId());

            /*if ($mlm_dist_mt4) {
              //$mlm_dist_mt4->setDistId($packageUpgradeHistory->getDistId());
              $mlm_dist_mt4->setMt4UserName($this->getRequestParameter('mt4Id'));
              $mlm_dist_mt4->setMt4Password($this->getRequestParameter('mt4Password'));
              //$mlm_dist_mt4->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
              $mlm_dist_mt4->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
              $mlm_dist_mt4->save();
          } else {*/
            if ($statusCode == Globals::STATUS_COMPLETE && $this->getRequestParameter('mt4Id') != "" && $packageUpgradeHistory->getStatusCode() == Globals::STATUS_ACTIVE) {
                $c = new Criteria();
                $c->add(MlmDistMt4Peer::MT4_USER_NAME, $this->getRequestParameter('mt4Id'));
                $mlmDistMt4DB = MlmDistMt4Peer::doSelectOne($c);

                if (!$mlmDistMt4DB) {
                    $mlm_dist_mt4 = new MlmDistMt4();
                    $mlm_dist_mt4->setDistId($packageUpgradeHistory->getDistId());
                    $mlm_dist_mt4->setMt4UserName($this->getRequestParameter('mt4Id'));
                    $mlm_dist_mt4->setMt4Password($this->getRequestParameter('mt4Password'));
                    $mlm_dist_mt4->setRankId($packageUpgradeHistory->getPackageId());
                    $mlm_dist_mt4->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_dist_mt4->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_dist_mt4->save();

                    $packageDB = MlmPackagePeer::retrieveByPK($packageUpgradeHistory->getPackageId());
                    /* ****************************************************
                   * ROI Divident
                   * ***************************************************/
                    $dateUtil = new DateUtil();
                    $currentDate = $dateUtil->formatDate("Y-m-d", $packageUpgradeHistory->getCreatedOn()) . " 00:00:00";
                    $currentDate_timestamp = strtotime($currentDate);
                    //$dividendDate = $dateUtil->addDate($currentDate, 30, 0, 0);
                    $dividendDate = strtotime("+1 months", $currentDate_timestamp);

                    $mlm_roi_dividend = new MlmRoiDividend();
                    $mlm_roi_dividend->setDistId($packageUpgradeHistory->getDistId());
                    $mlm_roi_dividend->setIdx(1);
                    $mlm_roi_dividend->setMt4UserName($this->getRequestParameter('mt4Id'));
                    //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                    $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                    $mlm_roi_dividend->setFirstDividendDate(date("Y-m-d h:i:s", $dividendDate));
                    $mlm_roi_dividend->setPackageId($packageDB->getPackageId());
                    $mlm_roi_dividend->setPackagePrice($packageDB->getPrice());
                    $mlm_roi_dividend->setRoiPercentage($packageDB->getMonthlyPerformance());
                    //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                    //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                    $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                    $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->save();

                    $subject = "Your live trading account with Maxim Trader has been activated 您的马胜交易户口已被激活";

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
                                                                    Dear <strong>" . $tbl_distributor->getFullName() . "</strong>,<br><br>
                                                                    Congratulations! Your live trading account with Maxim Trader
                                                                    has been activated! Please find the details of your trading account as
                                                                    per below :<br><br>
                                                                    Live MT4 Trading Account ID : <strong>" . $this->getRequestParameter('mt4Id') . "</strong><br><br>
                                                                    Live MT4 Trading Account password : <strong>" . $this->getRequestParameter('mt4Password') . "</strong><br><br>
                                                                    The Login ID and Password is strictly confidential and should not be
                                                                    disclosed to anyone. Should someone with access to your password wish,
                                                                    all of your account information can be changed. You will be held
                                                                    liable for any activity that may occur as a result of you losing your
                                                                    password. Therefore, if you feel that your password has been
                                                                    compromised, you should immediately contact us by email to
                                                                    <strong>cs@maximtrader.com</strong> to rectify the situation.<br><br>
                                                                    We look forward to your custom in the near future. Should you have any
                                                                    queries, please do not hesitate to get back to us.<br>
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
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
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
												亲爱的 <strong>" . $tbl_distributor->getFullName() . "</strong>,<br><br>
												恭喜您！您的马胜交易户口已被激活！以下是您的交易帐户的详细资料：
												<br><br>
												MT4交易户口登录ID : <strong>" . $this->getRequestParameter('mt4Id') . "</strong><br><br>
												MT4交易户口密码 : <strong>" . $this->getRequestParameter('mt4Password') . "</strong><br><br>
												登录ID和密码必须是严格保密及不应该向任何人透露。如果有人盗用了您的密码，
                                                您的帐户资料是有机会被篡改。您将必须承担任何可能发生的结果如果您遗失了你的密码。
                                                因此，如果您觉得您的密码不安全，您应该立即电邮联系我们
												<strong>cs@maximtrader.com</strong>以纠正这种情况.<br><br>
												如果您有任何疑问，请不要犹豫立即联络我们。
												<br>
											</font>
											<br>
																<br>
																<br>
																<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:17px'>
																买外汇或者期货都是一种杠杆投资。他们可能不适合您，因为他们具有很高的风险，您可能会失去您最初的投资资金，所以您必须确保你了解所有的风险。
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
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='http://partner.maximtrader.com/download/demoMt4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
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
																<td style='font-size:0;line-height:0'><a href='http://partner.maximtrader.com' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-access_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
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
                    $sendMailService->sendMail($tbl_distributor->getEmail(), $tbl_distributor->getFullName(), $subject, $body);
                }
            }
            /*}
            }*/

            $packageUpgradeHistory->setMt4UserName($this->getRequestParameter('mt4Id'));
            $packageUpgradeHistory->setMt4Password($this->getRequestParameter('mt4Password'));
            $packageUpgradeHistory->setRemarks($remarks);
            $packageUpgradeHistory->setStatusCode($statusCode);
            $packageUpgradeHistory->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

            $packageUpgradeHistory->save();

            /*$tbl_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));
            $mt4UsernameStr = "";
            $mt4PasswordStr = "";

            if ($this->getRequestParameter('mt4_user_name')) {
                if ($tbl_distributor->getMt4UserName() != null) {
                    $mt4UsernameStr .= ",";
                }
                $mt4UsernameStr .= $this->getRequestParameter('mt4_user_name');
            }

            if ($this->getRequestParameter('mt4_password')) {
                if ($tbl_distributor->getMt4Password() != null) {
                    $mt4PasswordStr .= ",";
                }
                $mt4PasswordStr .= $this->getRequestParameter('mt4_password');
            }

            $tbl_distributor->setMt4UserName($mt4UsernameStr);
            $tbl_distributor->setMt4Password($mt4PasswordStr);
            $tbl_distributor->save();*/

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

    /* ****************************************
     *     Ecash Withdrawal
     * *****************************************/
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
                    $refundEcash = $mlm_ecash_withdraw->getDeduct();
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
                    $mlm_account_ledger->setRemark("REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")");
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

    public function executeEcashWithdrawalEdit()
    {
        $this->mlm_ecash_withdraw = MlmEcashWithdrawPeer::retrieveByPk($this->getRequestParameter('withdrawId'));
        $this->forward404Unless($this->mlm_ecash_withdraw);
    }

    public function executeUpdateWithdrawal()
    {
        $mlm_ecash_withdraw = MlmEcashWithdrawPeer::retrieveByPk($this->getRequestParameter('withdraw_id'));
        $this->forward404Unless($mlm_ecash_withdraw);

        $statusCode = $this->getRequestParameter('status_code');

        $mlm_ecash_withdraw->setStatusCode($statusCode);
        $mlm_ecash_withdraw->setRemarks($this->getRequestParameter('remarks'));
        $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

        if (Globals::WITHDRAWAL_PAID == $statusCode || Globals::WITHDRAWAL_REJECTED == $statusCode)
            $mlm_ecash_withdraw->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

        $mlm_ecash_withdraw->save();

        if (Globals::WITHDRAWAL_REJECTED == $statusCode) {
            $refundEcash = $mlm_ecash_withdraw->getDeduct();
            $distId = $mlm_ecash_withdraw->getDistId();
            /******************************/
            /*  Account
            /******************************/
            $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
            $mlm_account_ledger->setRemark("REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")");
            $mlm_account_ledger->setCredit($refundEcash);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($distAccountEcashBalance + $refundEcash);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
        }

        $this->setFlash('successMsg', "Update successfully");
        return $this->redirect('finance/ecashWithdrawal');
    }

    /* ****************************************
     *     CP3 Withdrawal
     * *****************************************/
    public function executeCp3Withdrawal()
    {
        if ($this->getRequestParameter('withdrawStatus') && $this->getRequestParameter('withdrawId')) {
            $arr = $this->getRequestParameter('withdrawId');
            $statusCode = $this->getRequestParameter('withdrawStatus');

            for ($i = 0; $i < count($arr); $i++) {
                $mlm_ecash_withdraw = MlmCp3WithdrawPeer::retrieveByPk($arr[$i]);
                $this->forward404Unless($mlm_ecash_withdraw);

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                //$mlm_ecash_withdraw->setRemarks($this->getRequestParameter('remarks'));
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                if (Globals::WITHDRAWAL_PAID == $statusCode || Globals::WITHDRAWAL_REJECTED == $statusCode)
                    $mlm_ecash_withdraw->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                $mlm_ecash_withdraw->save();

                if (Globals::WITHDRAWAL_REJECTED == $statusCode) {
                    $refundEcash = $mlm_ecash_withdraw->getDeduct();
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
                    $mlm_account_ledger->setRemark("REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")");
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
            return $this->redirect('finance/cp3Withdrawal');
        }
    }

    public function executeCp3WithdrawalEdit()
    {
        $this->mlm_ecash_withdraw = MlmCp3WithdrawPeer::retrieveByPk($this->getRequestParameter('withdrawId'));
        $this->forward404Unless($this->mlm_ecash_withdraw);
    }

    public function executeUpdateCp3Withdrawal()
    {
        $mlm_ecash_withdraw = MlmCp3WithdrawPeer::retrieveByPk($this->getRequestParameter('withdraw_id'));
        $this->forward404Unless($mlm_ecash_withdraw);

        $statusCode = $this->getRequestParameter('status_code');

        $mlm_ecash_withdraw->setStatusCode($statusCode);
        $mlm_ecash_withdraw->setRemarks($this->getRequestParameter('remarks'));
        $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

        if (Globals::WITHDRAWAL_PAID == $statusCode || Globals::WITHDRAWAL_REJECTED == $statusCode)
            $mlm_ecash_withdraw->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

        $mlm_ecash_withdraw->save();

        if (Globals::WITHDRAWAL_REJECTED == $statusCode) {
            $refundEcash = $mlm_ecash_withdraw->getDeduct();
            $distId = $mlm_ecash_withdraw->getDistId();
            /******************************/
            /*  Account
            /******************************/
            $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
            $mlm_account_ledger->setRemark("REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")");
            $mlm_account_ledger->setCredit($refundEcash);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($distAccountEcashBalance + $refundEcash);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
        }

        $this->setFlash('successMsg', "Update successfully");
        return $this->redirect('finance/cp3Withdrawal');
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
            $query = $query . " AND bonus.dist_id = " . $distributorId;
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
            $query = $query . " AND bonus.dist_id = " . $distributorId;
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

    function getFundManagementBonusDetailByMonth($distributorId, $month, $year, $fileId)
    {
        //$dateUtil = new DateUtil();

        //$d = $dateUtil->getMonth($month, $year);
        //$firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        //$lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE csv.file_id = " . $fileId
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_FUND_MANAGEMENT . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
        //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($distributorId != null) {
            $query = $query . " AND bonus.dist_id = " . $distributorId;
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