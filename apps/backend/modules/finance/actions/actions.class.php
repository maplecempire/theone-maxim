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
    public function executeDebitAccountManagement()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);
        $this->dists = MlmDistributorPeer::doSelect($c);

        $c = new Criteria();
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $this->packages = MlmPackagePeer::doSelect($c);
    }

    public function executeDoUpdateDebitAccount()
    {
        $distId = $this->getRequestParameter('distId');
        $walletType = $this->getRequestParameter('walletType');
        $amount = $this->getRequestParameter('amount');
        $externalRemark = $this->getRequestParameter('externalRemark');
        $internalRemark = $this->getRequestParameter('internalRemark');
        $packageId = $this->getRequestParameter('packageId');
        $debitUpgraded = $this->getRequestParameter('debitUpgraded');

        $accountBalance = $this->getAccountBalance($distId, $walletType);
        $distDB = MlmDistributorPeer::retrieveByPK($distId);
        $packageDB = MlmPackagePeer::retrieveByPK($packageId);

        $amount = $packageDB->getPrice();

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($distId);
        $mlm_account_ledger->setAccountType($walletType);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DEBIT_ACCOUNT);
        $mlm_account_ledger->setRemark($externalRemark);
        $mlm_account_ledger->setInternalRemark($internalRemark);
        $mlm_account_ledger->setCredit($amount);
        $mlm_account_ledger->setDebit(0);
        $mlm_account_ledger->setBalance($accountBalance + $amount);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        if ("Y" == $debitUpgraded) {

        } else {
            $distDB->setRankId($packageId);
        }
        $distDB->setDebitAccount("Y");
        $distDB->setDebitRankId($packageId);
        $distDB->setDebitStatusCode(Globals::STATUS_ACTIVE);
        $distDB->setHideGenealogy($this->getRequestParameter('toHideGenealogy'), 'Y');
        $distDB->save();

        return sfView::HEADER_ONLY;
    }
    public function executeDoUpdateWallet()
    {
        $distId = $this->getRequestParameter('distId');
        $walletType = $this->getRequestParameter('walletType');
        $amount = $this->getRequestParameter('amount');
        $externalRemark = $this->getRequestParameter('externalRemark');
        $internalRemark = $this->getRequestParameter('internalRemark');
        $creditDebit = $this->getRequestParameter('creditDebit');

        $accountBalance = $this->getAccountBalance($distId, $walletType);

        if ($creditDebit == "CREDIT") {
            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType($walletType);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ADVANCE);
            $mlm_account_ledger->setRemark($externalRemark);
            $mlm_account_ledger->setInternalRemark($internalRemark);
            $mlm_account_ledger->setCredit($amount);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($accountBalance + $amount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();
        } else {
            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType($walletType);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ADJUSTMENT);
            $mlm_account_ledger->setRemark($externalRemark);
            $mlm_account_ledger->setInternalRemark($internalRemark);
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($amount);
            $mlm_account_ledger->setBalance($accountBalance - $amount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();
        }

        return sfView::HEADER_ONLY;
    }

    public function executeDoBackendAction()
    {
        return sfView::HEADER_ONLY;
    }

    function executeDeductDebitCardActivate()
    {
        $str = '328,61,60,138,91,99,98,258,257,240,43,325,143,638,518,117,889,925,918,917,922,966,970,203,731,589';

        $memberArrs = explode(",", $str);
        for ($y = 0; $y < count($memberArrs); $y++) {
            $pointAvailable = $this->getAccountBalance($memberArrs[$y], Globals::ACCOUNT_TYPE_EPOINT);
            $ecashAvailable = $this->getAccountBalance($memberArrs[$y], Globals::ACCOUNT_TYPE_ECASH);

            print_r($memberArrs[$y].":".$pointAvailable.":".$ecashAvailable);
            print_r("<br>");
            if ($pointAvailable >= 50) {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setDistId($memberArrs[$y]);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_APPLY_DEBIT_CARD);
                $mlm_account_ledger->setRemark("ACTIVATE DEBIT CARD");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit(50);
                $mlm_account_ledger->setBalance($pointAvailable - 50);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();
            } else if ($ecashAvailable >= 50) {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setDistId($memberArrs[$y]);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_APPLY_DEBIT_CARD);
                $mlm_account_ledger->setRemark("ACTIVATE DEBIT CARD");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit(50);
                $mlm_account_ledger->setBalance($ecashAvailable - 50);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();
            } else {
                print_r($memberArrs[$y]."<==========================================");
                print_r("<br>");
            }
        }
    }

    /* ****************************************
     *     Rolling Point
     * *****************************************/
    public function executeTransferRollingPoint()
    {
    }
    public function executeDebitRollingPoint()
    {
    }
    public function executeRecallRollingPoint()
    {
    }
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
        $internalRemark = $this->getRequestParameter('internalRemark', '');

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

        if ($companyEPointBalance < $epointAmount && ($doAction == "transfer" || $doAction == "epoint")) {
            $output = array(
                "error" => true,
                "errorMsg" => "Insufficient e-Point."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        if ($doAction == "debit") {
            $distDebitBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT);

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_DEBIT);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DEBIT);
            $mlm_account_ledger->setRollingPoint("Y");
            $mlm_account_ledger->setRemark("");
            $mlm_account_ledger->setInternalRemark($internalRemark);
            $mlm_account_ledger->setCredit($epointAmount);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($distDebitBalance + $epointAmount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_DEBIT);
        } else if ($doAction == "epoint") {
            $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
            $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $existDist->getDistributorCode() . " (" . $existDist->getFullName() . ")");
            $mlm_account_ledger->setInternalRemark($internalRemark);
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
            $mlm_account_ledger->setInternalRemark($internalRemark);
            $mlm_account_ledger->setCredit($epointAmount);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_EPOINT);

        } else if ($doAction == "transfer") {
            $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_RP);

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_RP_TRANSFER_TO);
            $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_RP_TRANSFER_TO . " " . $existDist->getDistributorCode() . " (" . $existDist->getFullName() . ")");
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($epointAmount);
            $mlm_account_ledger->setBalance($companyEPointBalance - $epointAmount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
            $mlm_account_ledger->setRollingPoint("Y");
            $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_RP_TRANSFER_FROM . " COMPANY");
            $mlm_account_ledger->setInternalRemark($internalRemark);
            $mlm_account_ledger->setCredit($epointAmount);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_RP);
        } else if ($doAction == "RECALL") {
            $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_RP);

            if ($distEPointBalance >= $epointAmount) {
                $epointAmount = $epointAmount * -1;

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_RP_RECALL);
                $mlm_account_ledger->setRollingPoint("Y");
                $mlm_account_ledger->setRemark("");
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit($epointAmount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_RP);
            }
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

                    $distDB = MlmDistributorPeer::retrieveByPK($packageUpgradeHistory->getDistId());
                    $userDB = AppUserPeer::retrieveByPK($distDB->getUserId());

                    $mlmPackageContract = new MlmPackageContract();
                    $mlmPackageContract->setDistId($packageUpgradeHistory->getDistId());
                    $mlmPackageContract->setFullName($distDB->getFullName());
                    $mlmPackageContract->setUsername($userDB->getUsername());
                    $mlmPackageContract->setMt4Id($mlm_roi_dividend->getMt4UserName());
                    $mlmPackageContract->setPackagePrice($packageDB->getPrice());
                    $mlmPackageContract->setSignDateDay(date("d"));
                    $mlmPackageContract->setSignDateMonth(date("F"));
                    $mlmPackageContract->setSignDateYear(date("Y"));
                    $mlmPackageContract->setInitialSignature($distDB->getSignName());
                    $mlmPackageContract->setDistMt4Id($mlm_dist_mt4->getMt4Id());
                    $mlmPackageContract->setStatusCode(Globals::STATUS_ACTIVE);
                    $mlmPackageContract->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageContract->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageContract->save();

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
                                                                    <strong>support@maximtrader.com</strong> to rectify the situation.<br><br>
                                                                    We look forward to your custom in the near future. Should you have any
                                                                    queries, please do not hesitate to get back to us.<br>
                                                                </font>
																<br>

												<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
                                                Note: Trading credit of 70% from initial deposit will only be utilized for self trading with a variable of approximately 5%. The remaining 30% cannot be used as trading margin and the amount is to strictly WITHHOLD for fund management program.
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
																<td style='font-size:0;line-height:0'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform3.gif' width='85' height='60'></td>
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
												<strong>support@maximtrader.com</strong>以纠正这种情况.<br><br>
												如果您有任何疑问，请不要犹豫立即联络我们。
												<br>
												<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
                                                会员账户中只有70%的初始投资及与之等额的MT4交易点数（附+-5%变化），才能用于会员自主交易. 剩余的初始资金的30%必须严格用于公司常规基金管理计划. 该规定所有会员均需遵守.
                                                </font>
                                                <br>
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
																<td style='font-size:0;line-height:0'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform3.gif' width='85' height='60'></td>
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
									Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9379 1159 Tel (Dial within NZ): 09 379 1159, Email support@maximtrader.com
									<br><br>Maxim Capital Limited is a subsidiary of Royale Group Holding Inc. a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9379 1159 电话(新西兰): 09 379 1159
<br>邮箱： support@maximtrader.com
<br><br>马胜金融集团是Royale Group Holding Inc.旗下的子公司。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议。
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入。 请根据您可以承受的损失程度理性参与投资。 在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见。
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

                    $bonusService = new BonusService();
                    if ($bonusService->checkDebitAccount($distId) == true) {
                        $debitAccountRemark = "REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")";
                        $bonusService->contraDebitAccount($distId, $debitAccountRemark, $refundEcash);
                    }
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

            $bonusService = new BonusService();
            if ($bonusService->checkDebitAccount($distId) == true) {
                $debitAccountRemark = "REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")";
                $bonusService->contraDebitAccount($distId, $debitAccountRemark, $refundEcash);
            }
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
                    $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
                    $mlm_account_ledger->setRemark("REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")");
                    $mlm_account_ledger->setCredit($refundEcash);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distAccountEcashBalance + $refundEcash);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
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
            $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($distId);
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
            $mlm_account_ledger->setRemark("REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")");
            $mlm_account_ledger->setCredit($refundEcash);
            $mlm_account_ledger->setDebit(0);
            $mlm_account_ledger->setBalance($distAccountEcashBalance + $refundEcash);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
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
                    $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $affectedDistributorId, Criteria::EQUAL);
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
            $tbl_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
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
    // #####################################
    public function executeCp3WithdrawalListInDetail2()
    {
        /*$response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/xls');
        $response->setHttpHeader('Content-Type', 'application/force-download', TRUE);
        $response->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
        $response->setHttpHeader('Content-Type', 'application/download', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=withdrawal_list.xls', TRUE);
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->sendHttpHeaders();*/

        /*$this->xlsBOF();
        $columnIdx = 0;
        $this->xlsWriteLabel(0, $columnIdx++, "ID");
        $this->xlsWriteLabel(0, $columnIdx++, "Member ID");
        $this->xlsWriteLabel(0, $columnIdx++, "Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Withdraw");
        $this->xlsWriteLabel(0, $columnIdx++, "Withdraw after Deduction");
        $this->xlsWriteLabel(0, $columnIdx++, "CP3 in wallet");
        $this->xlsWriteLabel(0, $columnIdx++, "Status");
        $this->xlsWriteLabel(0, $columnIdx++, "Date");
        $this->xlsWriteLabel(0, $columnIdx++, "IC");
        $this->xlsWriteLabel(0, $columnIdx++, "Email");
        $this->xlsWriteLabel(0, $columnIdx++, "Contact No");
        $this->xlsWriteLabel(0, $columnIdx++, "Leader Code");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Branch Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Account No");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Holder Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Swift Code");
        $this->xlsWriteLabel(0, $columnIdx++, "Visa Debit Card");
        $this->xlsWriteLabel(0, $columnIdx++, "Rank Code");
        $this->xlsWriteLabel(0, $columnIdx++, "Remarks");*/

        $query = "SELECT dist.tree_structure, withdraw.withdraw_id,withdraw.dist_id,dist.distributor_code,dist.full_name,withdraw.deduct,withdraw.amount,accountLedger._ecash,withdraw.status_code,withdraw.created_on,dist.ic,dist.email,dist.contact,leader.distributor_code as leader_code,dist.bank_name,dist.bank_branch_name,dist.bank_acc_no,dist.bank_holder_name,dist.bank_swift_code,dist.visa_debit_card,pack.package_name,withdraw.remarks  FROM mlm_cp3_withdraw withdraw
                LEFT JOIN mlm_distributor dist ON withdraw.dist_id = dist.distributor_id
                LEFT JOIN mlm_distributor leader ON withdraw.leader_dist_id = leader.distributor_id

                LEFT JOIN mlm_package pack ON pack.package_id = dist.rank_id
                LEFT JOIN
            (
            SELECT SUM(credit-debit) AS _ecash, dist_id
                FROM mlm_account_ledger accountLedger WHERE account_type = 'MAINTENANCE' GROUP BY dist_id
            ) accountLedger ON accountLedger.dist_id = withdraw.dist_id
                WHERE 1=1 ";

        if ($this->getRequestParameter('statusCode') != "") {
            $query .= " AND withdraw.status_code = '" . $this->getRequestParameter('statusCode') . "'";
        }

        if ($this->getRequestParameter('filterUsername') != "") {
            $query .= " AND dist.distributor_code LIKE '%" . $this->getRequestParameter('filterUsername') . "%'";
        }

        if ($this->getRequestParameter('filterLeader') != "") {
            $query .= " AND leader.distributor_code LIKE '%" . $this->getRequestParameter('filterLeader') . "%'";
        }
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $rs = $statement->executeQuery();

        $xlsRow = 1;
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $text="column1\tcolumn2\tcolumn3\nfor new line";
        $text="";
        while ($rs->next()) {
            $arr = $rs->getRow();
            $arrs[] = $arr;
            $columnIdx = 0;

            /*$this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['withdraw_id']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['distributor_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['full_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['deduct']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['amount']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['_ecash']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['status_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['created_on']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['ic']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['email']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['contact']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['leader_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_branch_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_acc_no']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_holder_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_swift_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['visa_debit_card']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['package_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['remarks']);*/

            $text .= "".$arr['withdraw_id'];
            $text .= "\t".$arr['distributor_code'];
            $text .= "\t".$arr['full_name'];
            $text .= "\t".$arr['deduct'];
            $text .= "\t".$arr['amount'];
            $text .= "\t".$arr['_ecash'];
            $text .= "\t".$arr['status_code'];
            $text .= "\t".$arr['created_on'];
            $text .= "\t".$arr['ic'];
            $text .= "\t".$arr['email'];
            $text .= "\t".$arr['contact'];
            $text .= "\t".$arr['leader_code'];
            $text .= "\t".$arr['bank_name'];
            $text .= "\t".$arr['bank_branch_name'];
            $text .= "\t".$arr['bank_acc_no'];
            $text .= "\t".$arr['bank_holder_name'];
            $text .= "\t".$arr['bank_swift_code'];
            $text .= "\t".$arr['visa_debit_card'];
            $text .= "\t".$arr['package_name'];
            $text .= "\t".$arr['remarks'];
            $xlsRow++;

            $text .= "\n";
        }
        //$this->xlsEOF();
        //exit();
        //$this->arrs = $arrs;



        $myFile = "export.xls";
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $text);
        fclose($myFile);
        //$filename = sfConfig::get('sf_upload_dir').'/excel/export.xls';
        $filename = $myFile;

        $filename = realpath($filename); //server specific
        $ctype="application/force-download";
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=1, pre-check=1");
        header("Cache-Control: private",false); // required for certain browsers
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=".basename($filename).";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".@filesize($filename));
        @readfile("$filename") or die("File not found.");
        unlink($filename);
        exit();
        return sfView::HEADER_ONLY;
    }

    public function executeCp3WithdrawalListInDetail()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/xls');
        $response->setHttpHeader('Content-Type', 'application/force-download', TRUE);
        $response->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
        $response->setHttpHeader('Content-Type', 'application/download', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=withdrawal_list.xls', TRUE);
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->sendHttpHeaders();

        $this->xlsBOF();
        //$this->xlsCodepage("UTF-8");
        $this->xlsCodepage("65001");
        $columnIdx = 0;
        $this->xlsWriteLabel(0, $columnIdx++, "ID");
        $this->xlsWriteLabel(0, $columnIdx++, "Member ID");
        $this->xlsWriteLabel(0, $columnIdx++, "Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Withdraw");
        $this->xlsWriteLabel(0, $columnIdx++, "Withdraw after Deduction");
        $this->xlsWriteLabel(0, $columnIdx++, "CP3 in wallet");
        $this->xlsWriteLabel(0, $columnIdx++, "Status");
        $this->xlsWriteLabel(0, $columnIdx++, "Date");
        $this->xlsWriteLabel(0, $columnIdx++, "IC");
        $this->xlsWriteLabel(0, $columnIdx++, "Email");
        $this->xlsWriteLabel(0, $columnIdx++, "Contact No");
        $this->xlsWriteLabel(0, $columnIdx++, "Leader Code");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Branch Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Account No");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Holder Name");
        $this->xlsWriteLabel(0, $columnIdx++, "Bank Swift Code");
        $this->xlsWriteLabel(0, $columnIdx++, "Visa Debit Card");
        $this->xlsWriteLabel(0, $columnIdx++, "Rank Code");
        $this->xlsWriteLabel(0, $columnIdx++, "Remarks");

        $query = "SELECT dist.tree_structure, withdraw.withdraw_id,withdraw.dist_id,dist.distributor_code,dist.full_name,withdraw.deduct,withdraw.amount,accountLedger._ecash,withdraw.status_code,withdraw.created_on,dist.ic,dist.email,dist.contact,leader.distributor_code as leader_code,dist.bank_name,dist.bank_branch_name,dist.bank_acc_no,dist.bank_holder_name,dist.bank_swift_code,dist.visa_debit_card,pack.package_name,withdraw.remarks  FROM mlm_cp3_withdraw withdraw
                LEFT JOIN mlm_distributor dist ON withdraw.dist_id = dist.distributor_id
                LEFT JOIN mlm_distributor leader ON withdraw.leader_dist_id = leader.distributor_id

                LEFT JOIN mlm_package pack ON pack.package_id = dist.rank_id
                LEFT JOIN
            (
            SELECT SUM(credit-debit) AS _ecash, dist_id
                FROM mlm_account_ledger accountLedger WHERE account_type = 'MAINTENANCE' GROUP BY dist_id
            ) accountLedger ON accountLedger.dist_id = withdraw.dist_id
                WHERE 1=1 ";

        if ($this->getRequestParameter('statusCode') != "") {
            $query .= " AND withdraw.status_code = '" . $this->getRequestParameter('statusCode') . "'";
        }

        if ($this->getRequestParameter('filterUsername') != "") {
            $query .= " AND dist.distributor_code LIKE '%" . $this->getRequestParameter('filterUsername') . "%'";
        }

        if ($this->getRequestParameter('filterLeader') != "") {
            $query .= " AND leader.distributor_code LIKE '%" . $this->getRequestParameter('filterLeader') . "%'";
        }

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $rs = $statement->executeQuery();

        $xlsRow = 1;
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        while ($rs->next()) {
            $arr = $rs->getRow();
            $arrs[] = $arr;
            $columnIdx = 0;

            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['withdraw_id']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['distributor_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['full_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['deduct']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['amount']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['_ecash']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['status_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['created_on']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['ic']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['email']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['contact']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['leader_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_branch_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_acc_no']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_holder_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['bank_swift_code']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['visa_debit_card']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['package_name']);
            $this->xlsWriteLabel($xlsRow, $columnIdx++, $arr['remarks']);
            $xlsRow++;
        }
        $this->xlsEOF();
//        exit();
        //$this->arrs = $arrs;
        return sfView::HEADER_ONLY;
    }
    /* ****************************
     *  excel start ~
     * *****************************/
    function xlsCodepage($codepage) {
        $record    = 0x0042;    // Codepage Record identifier
        $length    = 0x0002;    // Number of bytes to follow

        $header    = pack('vv', $record, $length);
        $data      = pack('v',  $codepage);

        echo $header , $data;
    }
    function xlsBOF()
    {
        echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
        return;
    }

    function xlsEOF()
    {
        echo pack("ss", 0x0A, 0x00);
        return;
    }

    function xlsWriteNumber($Row, $Col, $Value)
    {
        echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
        echo pack("d", $Value);
        return;
    }

    function xlsWriteLabel($Row, $Col, $Value)
    {
        $L = strlen($Value);
        echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
        echo $Value;
        return;
    }

    /* ****************************
     *  excel end ~
     * *****************************/
}