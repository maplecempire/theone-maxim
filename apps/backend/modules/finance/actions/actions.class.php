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
    public function executeRevertCp3Withdrawal()
    {
        $cp3IdArray = explode(',', "19760,19801,22980,23037,23038,23041,23043,23045,23047");
        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::WITHDRAW_ID, $cp3IdArray, Criteria::IN);
        $c->add(MlmCp3WithdrawPeer::STATUS_CODE, Globals::WITHDRAWAL_REJECTED);
        $mlmCp3Withdrawals = MlmCp3WithdrawPeer::doSelect($c);

        foreach ($mlmCp3Withdrawals as $mlm_ecash_withdraw) {
            print_r("<br>".$mlm_ecash_withdraw->getDistId());
            $remark = "";

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();
                print_r("<br>".$remark);
                $statusCode = Globals::WITHDRAWAL_REJECTED ;

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
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoRejectJapanCp3Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectJapanCp3Withdrawal()
    {
        $cp3IdArray = explode(',', "142,15");
        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::LEADER_DIST_ID, $cp3IdArray, Criteria::IN);
        $c->add(MlmCp3WithdrawPeer::STATUS_CODE, Globals::WITHDRAWAL_PENDING);
        $mlmCp3Withdrawals = MlmCp3WithdrawPeer::doSelect($c);

        $count = count($mlmCp3Withdrawals);
        print_r("<br>".$count);
        foreach ($mlmCp3Withdrawals as $mlm_ecash_withdraw) {
            print_r("<br>".$count--.":".$mlm_ecash_withdraw->getDistId());
            $remark = "";

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();
                print_r("<br>".$remark);
                $statusCode = Globals::WITHDRAWAL_REJECTED ;

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                $mlm_ecash_withdraw->setRemarks($remark);
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoRejectJapanCp3Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectJapanCp2Withdrawal()
    {
        $cp3IdArray = explode(',', "142,15");
        $c = new Criteria();
        $c->add(MlmEcashWithdrawPeer::LEADER_DIST_ID, $cp3IdArray, Criteria::IN);
        $c->add(MlmEcashWithdrawPeer::STATUS_CODE, Globals::WITHDRAWAL_PENDING);
        $mlmCp3Withdrawals = MlmEcashWithdrawPeer::doSelect($c);

        $count = count($mlmCp3Withdrawals);
        print_r("<br>".$count);
        foreach ($mlmCp3Withdrawals as $mlm_ecash_withdraw) {
            print_r("<br>".$count--.":".$mlm_ecash_withdraw->getDistId());
            $remark = "";

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();
                $statusCode = Globals::WITHDRAWAL_REJECTED ;

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                $mlm_ecash_withdraw->setRemarks($remark);
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoRejectJapanCp2Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectTwosasaCp3Withdrawal()
    {
        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::LEADER_DIST_ID, 595);
        $c->add(MlmCp3WithdrawPeer::STATUS_CODE, Globals::WITHDRAWAL_PENDING);
        $mlmCp3Withdrawals = MlmCp3WithdrawPeer::doSelect($c);

        foreach ($mlmCp3Withdrawals as $mlm_ecash_withdraw) {
            print_r("<br>".$mlm_ecash_withdraw->getDistId());
            $remark = "PLEASE REFER TO UPPER SUPREME MEMBER. UPPER MEMBER REQUEST TO SWAP SSS<br>如有疑虑, 请联系您的推荐人。推荐人要求特别SSS股票转换.";

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();
                print_r("<br>".$remark);
                $statusCode = Globals::WITHDRAWAL_REJECTED ;

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                $mlm_ecash_withdraw->setRemarks($remark);
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoRejectLocalBankCp2Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectTwosasaCp2Withdrawal()
    {
        $cp3IdArray = explode(',', "9999999");
        $c = new Criteria();
        $c->add(MlmEcashWithdrawPeer::LEADER_DIST_ID, $cp3IdArray, Criteria::IN);
        $c->add(MlmEcashWithdrawPeer::STATUS_CODE, Globals::WITHDRAWAL_PENDING);
        $mlmCp3Withdrawals = MlmEcashWithdrawPeer::doSelect($c);

        foreach ($mlmCp3Withdrawals as $mlm_ecash_withdraw) {
            print_r("<br>".$mlm_ecash_withdraw->getDistId());
            $remark = "";

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();
                print_r("<br>".$remark);
                $statusCode = Globals::WITHDRAWAL_REJECTED ;

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                $mlm_ecash_withdraw->setRemarks($remark);
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoRejectLocalBankCp2Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectLocalBankCp2Withdrawal()
    {
        $cp3IdArray = explode(',', "10810,10823,10839,10873,10880,10881,10899,10903,10931,10955,10959,10989,11012,11013,11015,11025,11033,11066,11068,11070,11085,11087,11099,11100,11115,11120,11125,11132");

        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::WITHDRAW_ID, $cp3IdArray, Criteria::IN);
        $mlmCp3Withdrawals = MlmCp3WithdrawPeer::doSelect($c);

        foreach ($mlmCp3Withdrawals as $mlm_ecash_withdraw) {
            print_r("<br>".$mlm_ecash_withdraw->getDistId());
            $remark = "WITHDRAWAL MUST SUBMIT WITHIN 1st WEEK OF MONTH";

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();
                print_r("<br>".$remark);
                $statusCode = Globals::WITHDRAWAL_REJECTED ;

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                $mlm_ecash_withdraw->setRemarks($remark);
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoRejectLocalBankCp2Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectDoubleSubmitedCp2Withdrawal()
    {
        $statusCodeArr = array(Globals::WITHDRAWAL_PENDING);

        $c = new Criteria();
        $c->add(MlmEcashWithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
        $mlm_ecash_withdraws = MlmEcashWithdrawPeer::doSelect($c);
        //var_dump($mlm_ecash_withdraws);
        foreach ($mlm_ecash_withdraws as $mlm_ecash_withdraw) {
            $query = "SELECT count(*) as _count
                FROM mlm_ecash_withdraw
                    where created_on >= '2015-01-01 00:00:00' AND created_on < '2015-01-08 00:00:00' AND dist_id = ".$mlm_ecash_withdraw->getDistId()
                . " AND status_code IN ('PENDING','PROCESSING', 'PAID')";

            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $resultset = $statement->executeQuery();

            if ($resultset->next()) {
                $arr = $resultset->getRow();

                $totalCount = $arr['_count'];
                print_r("<br>".$mlm_ecash_withdraw->getDistId().":".$totalCount);
                $remark = "WITHDRAWAL CAN ONLY BE SUBMITTED ONCE A MONTH";
                if ($totalCount > 0) {
                    $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
                    try {
                        $con->begin();
                        print_r("<br>".$remark);
                        $statusCode = Globals::WITHDRAWAL_REJECTED ;

                        $mlm_ecash_withdraw->setStatusCode($statusCode);
                        $mlm_ecash_withdraw->setRemarks($remark);
                        $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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

                            $this->mirroringAccountLedger($mlm_account_ledger, "34X");

                            //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                        }
                        $con->commit();
                    } catch (PropelException $e) {
                        $con->rollback();
                        throw $e;
                    }
                }
            }
        }

        print_r("<br>executeAutoRejectDoubleSubmitedCp2Withdrawal Done");
        return sfView::HEADER_ONLY;
    }

    public function executeAutoRejectDoubleSubmitedCp3Withdrawal()
    {
        $statusCodeArr = array(Globals::WITHDRAWAL_PENDING);

        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
        $mlm_ecash_withdraws = MlmCp3WithdrawPeer::doSelect($c);
        //var_dump($mlm_ecash_withdraws);
        foreach ($mlm_ecash_withdraws as $mlm_ecash_withdraw) {
            $query = "SELECT count(*) as _count
                FROM mlm_cp3_withdraw
                    where created_on >= '2015-01-01 00:00:00' AND created_on < '2015-01-08 00:00:00' AND dist_id = ".$mlm_ecash_withdraw->getDistId()
                . " AND status_code IN ('PENDING','PROCESSING', 'PAID')";

            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $resultset = $statement->executeQuery();

            if ($resultset->next()) {
                $arr = $resultset->getRow();

                $totalCount = $arr['_count'];
                print_r("<br>".$mlm_ecash_withdraw->getDistId().":".$totalCount);
                $remark = "WITHDRAWAL CAN ONLY BE SUBMITTED ONCE A MONTH";
                if ($totalCount > 0) {
                    $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
                    try {
                        $con->begin();
                        print_r("<br>".$remark);
                        $statusCode = Globals::WITHDRAWAL_REJECTED ;

                        $mlm_ecash_withdraw->setStatusCode($statusCode);
                        $mlm_ecash_withdraw->setRemarks($remark);
                        $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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

                            $this->mirroringAccountLedger($mlm_account_ledger, "34X");

                            //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                        }
                        $con->commit();
                    } catch (PropelException $e) {
                        $con->rollback();
                        throw $e;
                    }
                }
            }
        }

        print_r("<br>executeAutoRejectDoubleSubmitedCp2Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectInvalidIaccountCp2Withdrawal()
    {
        $query = "SELECT cp2.`withdraw_id`,
            cp2.`dist_id`,
            dist.iaccount,
            cp2.`deduct`,
            cp2.`amount`,
            cp2.`bank_in_to`,
            cp2.`status_code`,
            cp2.`approve_reject_datetime`,
            cp2.`remarks`,
            cp2.`created_by`,
            cp2.`created_on`,
            cp2.`updated_by`,
            cp2.`updated_on`,
            cp2.`leader_dist_id`
             FROM maxim.mlm_ecash_withdraw cp2
                left join mlm_distributor dist ON dist.distributor_id = cp2.dist_id
            where cp2.status_code = 'PENDING' AND cp2.bank_in_to = 'I-ACCOUNT' and dist.iaccount not Like '111%'";

        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            print_r($arr['withdraw_id']."<br>");
            $statusCodeArr = array(Globals::WITHDRAWAL_PENDING);
            $remark = "INVALID i-Account Number";
            $c = new Criteria();
            $c->add(MlmEcashWithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
            $c->add(MlmEcashWithdrawPeer::WITHDRAW_ID, $arr['withdraw_id']);
            $mlm_ecash_withdraw = MlmEcashWithdrawPeer::doSelectOne($c);

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();

                $statusCode = Globals::WITHDRAWAL_REJECTED ;

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                $mlm_ecash_withdraw->setRemarks($remark);
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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

                    $this->mirroringAccountLedger($mlm_account_ledger, "34V");

                    //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoCp3Withdrawal Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoRejectInvalidIaccountCp3Withdrawal()
    {
        $query = "SELECT cp2.`withdraw_id`,
            cp2.`dist_id`,
            dist.iaccount,
            cp2.`deduct`,
            cp2.`amount`,
            cp2.`bank_in_to`,
            cp2.`status_code`,
            cp2.`approve_reject_datetime`,
            cp2.`remarks`,
            cp2.`created_by`,
            cp2.`created_on`,
            cp2.`updated_by`,
            cp2.`updated_on`,
            cp2.`leader_dist_id`
             FROM maxim.mlm_cp3_withdraw cp2
                left join mlm_distributor dist ON dist.distributor_id = cp2.dist_id
            where cp2.status_code = 'PENDING' AND cp2.bank_in_to = 'I-ACCOUNT' and dist.iaccount not Like '111%'";

        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            print_r($arr['withdraw_id']."<br>");
            $statusCodeArr = array(Globals::WITHDRAWAL_PENDING);
            $remark = "INVALID i-Account Number";
            $c = new Criteria();
            $c->add(MlmCp3WithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
            $c->add(MlmCp3WithdrawPeer::WITHDRAW_ID, $arr['withdraw_id']);
            $mlm_ecash_withdraw = MlmCp3WithdrawPeer::doSelectOne($c);

            $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
            try {
                $con->begin();

                $statusCode = Globals::WITHDRAWAL_REJECTED ;

                $mlm_ecash_withdraw->setStatusCode($statusCode);
                $mlm_ecash_withdraw->setRemarks($remark);
                $mlm_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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

                    $this->mirroringAccountLedger($mlm_account_ledger, "34VV");

                    //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("<br>executeAutoCp3Withdrawal Done");
        return sfView::HEADER_ONLY;
    }

    public function executeRemoveDuplicate()
    {
        $query = "SELECT count(dist_id), dist_id FROM maxim.mlm_account_ledger
            where transaction_type IN ('FUND MANAGEMENT')
                and created_on >= '2014-04-23 00:00:00'
                and created_on <= '2014-04-23 23:59:59' group by dist_id order by 1 desc";

        $query = "SELECT count(*) as _count, mt4_user_name, idx FROM maxim.mlm_roi_dividend group by mt4_user_name, idx
            having _count > 1
            order by 1 desc";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
            $resultArr = $resultset->getRow();

            print_r("<br>".$resultArr['mt4_user_name'].":".$resultArr['idx']);
            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $resultArr['mt4_user_name']);
            $c->add(MlmRoiDividendPeer::IDX, $resultArr['idx']);
            $mlmRoiDividend = MlmRoiDividendPeer::doSelectOne($c);

            if ($mlmRoiDividend) {
                $mlmRoiDividend->setDistId($mlmRoiDividend->getDistId() * -1);
                $mlmRoiDividend->save();
            } else {
                print_r("<br>====================".$resultArr['mt4_user_name'].":".$resultArr['idx']);
            }
        }

        print_r("<br>Reset Report Done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateProductPurchase()
    {
        if ($this->getRequestParameter('status_code') && $this->getRequestParameter('history_id')) {
            $historyId = $this->getRequestParameter('history_id');
            $statusCode = $this->getRequestParameter('status_code');

            $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
            try {
                $con->begin();

                $mlmProductPurchaseHistory = MlmProductPurchaseHistoryPeer::retrieveByPk($historyId);
                $this->forward404Unless($mlmProductPurchaseHistory);

                $mlmProductPurchaseHistory->setStatusCode($statusCode);
                $mlmProductPurchaseHistory->setRemarks($this->getRequestParameter('remarks'));
                $mlmProductPurchaseHistory->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

                if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode)
                    $mlmProductPurchaseHistory->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                $mlmProductPurchaseHistory->save();

                if (Globals::STATUS_REJECT == $statusCode) {
                    $refundEcash = $mlmProductPurchaseHistory->getTotalAmount();
                    $distId = $mlmProductPurchaseHistory->getDistId();
                    /******************************/
                    /*  Account
                    /******************************/
                    $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
                    $mlm_account_ledger->setRemark("REFUND (REFERENCE ID " . $mlmProductPurchaseHistory->getHistoryId() . ")");
                    $mlm_account_ledger->setCredit($refundEcash);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distAccountEcashBalance + $refundEcash);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->mirroringAccountLedger($mlm_account_ledger, "1");
                    //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            $this->setFlash('successMsg', "Update successfully");
            return $this->redirect('finance/productPurchaseEdit?purchaseId='.$historyId);
        }
    }
    public function executeProductPurchaseEdit()
    {
        $mlmProductPurchaseHistory = MlmProductPurchaseHistoryPeer::retrieveByPk($this->getRequestParameter('purchaseId'));
        $this->forward404Unless($mlmProductPurchaseHistory);

        $c = new Criteria();
        $c->add(MlmProductPurchaseHistoryDetailPeer::HISTORY_ID, $mlmProductPurchaseHistory->getHistoryId());
        $mlmProductPurchaseHistoryDetails = MlmProductPurchaseHistoryDetailPeer::doSelect($c);

        $this->mlmProductPurchaseHistory = $mlmProductPurchaseHistory;
        $this->mlmProductPurchaseHistoryDetails = $mlmProductPurchaseHistoryDetails;
    }
    public function executeProductPurchase()
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

                        $this->mirroringAccountLedger($mlm_account_ledger, "2");
                        //$this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

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

                        $this->mirroringAccountLedger($mlm_account_ledger, "3");

                        //$this->revalidateAccount($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
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

                        $this->setFlash('errorMsg', "Insufficient CP1.");
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
    public function executeCp3Transfer()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);
        $this->dists = MlmDistributorPeer::doSelect($c);
    }
    public function executeDebitAccountManagement()
    {
        /*$c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);
        $this->dists = MlmDistributorPeer::doSelect($c);*/

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

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();

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

            $this->mirroringAccountLedger($mlm_account_ledger, "4");

            if ("Y" == $debitUpgraded) {

            } else {
                $distDB->setRankId($packageId);
            }
            $distDB->setDebitAccount("Y");
            $distDB->setDebitRankId($packageId);
            $distDB->setDebitStatusCode(Globals::STATUS_ACTIVE);
            $distDB->setHideGenealogy($this->getRequestParameter('toHideGenealogy'), 'Y');
            $distDB->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
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

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();
            if ($creditDebit == "CREDIT") {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType($walletType);

    //            if ($walletType == "MAINTENANCE") {
    //                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM_COMPANY);
    //            } else {
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ADVANCE);
    //            }
                $mlm_account_ledger->setRemark($externalRemark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit($amount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($accountBalance + $amount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "5");
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

                $this->mirroringAccountLedger($mlm_account_ledger, "6");
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return sfView::HEADER_ONLY;
    }

    public function executeDoBackendAction()
    {
        return sfView::HEADER_ONLY;
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

    public function executeEnquiryCP()
    {
        $distId = $this->getRequestParameter('distId');

        $cp1 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);
        $cp2 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);
        $cp3 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
        $rp = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_RP);

        $arr = "";
        $arr = array(
            'cp1' => $cp1,
            'cp2' => $cp2,
            'cp3' => $cp3,
            'rp' => $rp
        );

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executeEnquiryMt4Balance()
    {
        $noticeId = $this->getRequestParameter('noticeId');

        $existNotificationOfMaturity = NotificationOfMaturityPeer::retrieveByPK($noticeId);

        $arr = array();
        if ($existNotificationOfMaturity) {

            $existDist = MlmDistributorPeer::retrieveByPK($existNotificationOfMaturity->getDistId());
            if ($existDist) {
                $distId = $existNotificationOfMaturity->getDistId();
                //$cp1 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);
                //$cp2 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);
                //$cp3 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                $cp1 = 0;
                $cp2 = 0;
                $cp3 = 0;
                $mt4Balance = $this->getMt4Balance($distId, $existNotificationOfMaturity->getMt4UserName());

                $arr = array(
                    'cp1' => $cp1,
                    'cp2' => $cp2,
                    'cp3' => $cp3,
                    'mt4Balance' => $mt4Balance,
                    'remark' => $existDist->getRemark(),
                    'principle_return' => $existDist->getPrincipleReturn()
                );
            }
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executeEnquiryMt4BalanceAndCP()
    {
        $noticeId = $this->getRequestParameter('noticeId');

        $existNotificationOfMaturity = NotificationOfMaturityPeer::retrieveByPK($noticeId);

        $arr = array();
        if ($existNotificationOfMaturity) {

            $existDist = MlmDistributorPeer::retrieveByPK($existNotificationOfMaturity->getDistId());
            if ($existDist) {
                $distId = $existNotificationOfMaturity->getDistId();
                $cp1 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);
                $cp2 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);
                $cp3 = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                $mt4Balance = $this->getMt4Balance($distId, $existNotificationOfMaturity->getMt4UserName());

                $arr = array(
                    'cp1' => $cp1,
                    'cp2' => $cp2,
                    'cp3' => $cp3,
                    'mt4Balance' => $mt4Balance,
                    'remark' => $existDist->getRemark(),
                    'principle_return' => $existDist->getPrincipleReturn()
                );
            }
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executeDoEpointTransfer()
    {
        $distId = $this->getRequestParameter('distId');
        $epointAmount = $this->getRequestParameter('epointAmount');
        $doAction = $this->getRequestParameter('doAction');
        $internalRemark = $this->getRequestParameter('internalRemark', '');
        $transactionType = $this->getRequestParameter('doTransactionType', '');
        $remark = $this->getRequestParameter('remark', Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " COMPANY");

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
                "errorMsg" => "Insufficient CP1."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();

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

                $this->mirroringAccountLedger($mlm_account_ledger, "7");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_DEBIT);
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

                $this->mirroringAccountLedger($mlm_account_ledger, "8");

                //$this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType($transactionType);
                $mlm_account_ledger->setRollingPoint("N");
                $mlm_account_ledger->setRemark($remark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit($epointAmount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "9");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_EPOINT);

            } else if ($doAction == "ecash") {
                $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setTransactionType($transactionType);
                $mlm_account_ledger->setRollingPoint("N");
                $mlm_account_ledger->setRemark($remark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit($epointAmount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "10a");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

            } else if ($doAction == "transfer_cp3") {
                $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $mlm_account_ledger->setTransactionType($transactionType);
                $mlm_account_ledger->setRollingPoint("N");
                $mlm_account_ledger->setRemark($remark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit($epointAmount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distEPointBalance + $epointAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "10");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

            } else if ($doAction == "deduct_epoint") {
                $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType($transactionType);
                $mlm_account_ledger->setRollingPoint("N");
                $mlm_account_ledger->setRemark($remark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($epointAmount);
                $mlm_account_ledger->setBalance($distEPointBalance - $epointAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "11");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_EPOINT);

            } else if ($doAction == "deduct_cp2") {
                $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setTransactionType($transactionType);
                $mlm_account_ledger->setRollingPoint("N");
                $mlm_account_ledger->setRemark($remark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($epointAmount);
                $mlm_account_ledger->setBalance($distEPointBalance - $epointAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "12");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);

            } else if ($doAction == "deduct_cp3") {
                $distEPointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $mlm_account_ledger->setTransactionType($transactionType);
                $mlm_account_ledger->setRollingPoint("N");
                $mlm_account_ledger->setRemark($remark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($epointAmount);
                $mlm_account_ledger->setBalance($distEPointBalance - $epointAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "13");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

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

                $this->mirroringAccountLedger($mlm_account_ledger, "14");

                //$this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

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

                $this->mirroringAccountLedger($mlm_account_ledger, "15");

                //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_RP);
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

                    $this->mirroringAccountLedger($mlm_account_ledger, "16");

                    //$this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_RP);
                }
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeDoOnHoldAccount()
    {
        $noticeId = $this->getRequestParameter('noticeId');
        $loanAccount = $this->getRequestParameter('loanAccount');
        $cp3Amount = $this->getRequestParameter('cp3Amount');
        $internalRemark = $this->getRequestParameter('internalRemark', '');
        $remark = $this->getRequestParameter('remark', Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " COMPANY");

        $existNotificationOfMaturity = NotificationOfMaturityPeer::retrieveByPK($noticeId);
        if (!$existNotificationOfMaturity) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Action."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $existDist = MlmDistributorPeer::retrieveByPK($existNotificationOfMaturity->getDistId());
        if (!$existDist) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Member Id."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $distId = $existNotificationOfMaturity->getDistId();
        $con = Propel::getConnection(MlmMt4WithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

            $existDist->setCloseAccount("Y");
            //$existDist->setSecondtimeRenewal("Y");
            $existDist->save();

            //$existNotificationOfMaturity->setMt4Balance($cp3Amount);
            $existNotificationOfMaturity->setRemark($remark);
            $existNotificationOfMaturity->setInternalRemark($internalRemark);
            $existNotificationOfMaturity->setStatusCode(Globals::STATUS_MATURITY_ON_HOLD);
            //$existNotificationOfMaturity->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            $existNotificationOfMaturity->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $existNotificationOfMaturity->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeDoRenewAccount()
    {
        $noticeId = $this->getRequestParameter('noticeId');
        $loanAccount = $this->getRequestParameter('loanAccount');
        $cp3Amount = $this->getRequestParameter('cp3Amount');
        $internalRemark = $this->getRequestParameter('internalRemark', '');
        $remark = $this->getRequestParameter('remark', Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " COMPANY");

        $existNotificationOfMaturity = NotificationOfMaturityPeer::retrieveByPK($noticeId);
        if (!$existNotificationOfMaturity) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Action."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $existDist = MlmDistributorPeer::retrieveByPK($existNotificationOfMaturity->getDistId());
        if (!$existDist) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Member Id."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $distId = $existNotificationOfMaturity->getDistId();
        $con = Propel::getConnection(MlmMt4WithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

            if ($loanAccount == "Y") {
                $internalRemark .= " (LOAN ACCOUNT)";
            } else {
                // ROI ++++++++++++++++++++++++++++++
                $c = new Criteria();
                $c->add(MlmRoiDividendPeer::DIST_ID, $existNotificationOfMaturity->getDistId());
                $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $existNotificationOfMaturity->getMt4UserName());
                $c->add(MlmRoiDividendPeer::STATUS_CODE, Globals::DIVIDEND_STATUS_SUCCESS);
                $totalRecords = MlmRoiDividendPeer::doCount($c);

                if ($totalRecords != 18) {
                    $output = array(
                        "error" => true,
                        "errorMsg" => "Total ROI Records is not 18."
                    );
                    echo json_encode($output);
                    return sfView::HEADER_ONLY;
                }

                $c = new Criteria();
                $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $existNotificationOfMaturity->getMt4UserName());
                $c->addDescendingOrderByColumn(MlmRoiDividendPeer::IDX);
                $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

                if ($mlmRoiDividendDB && $totalRecords < Globals::DIVIDEND_TIMES_ENTITLEMENT_36) {
                    $idx = $mlmRoiDividendDB->getIdx() + 1;
                    for ($i = $idx; $i <= Globals::DIVIDEND_TIMES_ENTITLEMENT_36; $i++) {
                        $firstDividendTime = strtotime($mlmRoiDividendDB->getFirstDividendDate());

                        $monthAdded = $idx - 1;
                        $dividendDate = strtotime("+".$monthAdded." months", $firstDividendTime);

                        $mlm_roi_dividend = new MlmRoiDividend();
                        $mlm_roi_dividend->setDistId($mlmRoiDividendDB->getDistId());
                        $mlm_roi_dividend->setMt4UserName($mlmRoiDividendDB->getMt4UserName());
                        $mlm_roi_dividend->setIdx($idx);
                        //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                        $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                        $mlm_roi_dividend->setFirstDividendDate($mlmRoiDividendDB->getFirstDividendDate());
                        $mlm_roi_dividend->setPackageId($mlmRoiDividendDB->getPackageId());
                        $mlm_roi_dividend->setPackagePrice($mlmRoiDividendDB->getPackagePrice());
                        $mlm_roi_dividend->setRoiPercentage($mlmRoiDividendDB->getRoiPercentage());
                        $mlm_roi_dividend->setExceedDistId($mlmRoiDividendDB->getExceedDistId());
                        $mlm_roi_dividend->setExceedRoiPercentage($mlmRoiDividendDB->getExceedRoiPercentage());
                        //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                        //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                        $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                        $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->save();

                        $idx = $idx + 1;
                    }
                }

                // store pairing point ++++++++++++++++++++++++++++++
                //$uplinePosition = $existDist->getPlacementPosition();
                //$uplineDistDB = MlmDistributorPeer::retrieveByPk($existDist->getTreeUplineDistId());

                /*$dateUtil = new DateUtil();

                $sponsoredDistributorCode = $existDist->getDistributorCode();
                $pairingPoint = $mlmRoiDividendDB->getPackagePrice();
                $pairingPointActual = $mlmRoiDividendDB->getPackagePrice();
                $exp_date = "2014-08-01 ";
                $todays_date = $dateUtil->formatDate("Y-m-d", $mlmRoiDividendDB->getDividendDate());
                $today = strtotime($todays_date);
                $expiration_date = strtotime($exp_date);
                //if ()
                if ($expiration_date > $today) {

                } else {
                    $pairingPoint = $mlmRoiDividendDB->getPackagePrice() * Globals::PAIRING_POINT_BV;
                }
                $level = 0;
                while ($level < 200) {
                    //var_dump($uplineDistDB->getUplineDistId());
                    //var_dump($uplineDistDB->getUplineDistCode());
                    //print_r("<br>");
                    $c = new Criteria();
                    $c->add(MlmDistPairingPeer::DIST_ID, $uplineDistDB->getDistributorId());
                    $sponsorDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                    $addToLeft = 0;
                    $addToRight = 0;
                    $leftBalance = 0;
                    $rightBalance = 0;
                    if (!$sponsorDistPairingDB) {
                        $sponsorDistPairingDB = new MlmDistPairing();
                        $sponsorDistPairingDB->setDistId($uplineDistDB->getDistributorId());

                        $packageDB = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                        if (!$packageDB) {
                            $output = array(
                                "error" => true,
                                "errorMsg" => "Invalid Rank Id."
                            );
                            echo json_encode($output);
                            return sfView::HEADER_ONLY;
                        }

                        $sponsorDistPairingDB->setLeftBalance($leftBalance);
                        $sponsorDistPairingDB->setRightBalance($rightBalance);
                        $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                        $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    } else {
                        $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                        $rightBalance = $sponsorDistPairingDB->getRightBalance();
                    }
                    $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
                    $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
                    $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistPairingDB->save();

                    $c = new Criteria();
                    $c->add(MlmDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                    $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                    $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
                    $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

                    $legBalance = 0;
                    if ($sponsorDistPairingLedgerDB) {
                        $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                    }

                    $sponsorDistPairingledger = new MlmDistPairingLedger();
                    $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                    $sponsorDistPairingledger->setLeftRight($uplinePosition);
                    $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                    $sponsorDistPairingledger->setCredit($pairingPoint);
                    $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                    $sponsorDistPairingledger->setDebit(0);
                    $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                    $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") [MATURITY]");
                    $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistPairingledger->save();

                    $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                    if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                        break;
                    }

                    $uplinePosition = $uplineDistDB->getPlacementPosition();
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                    $level++;
                }*/
            }
            //$existDist->setEmailStatus();
            $existDist->setCloseAccount("N");
            $existDist->setSecondtimeRenewal("Y");
            $existDist->save();

            //$existNotificationOfMaturity->setMt4Balance($cp3Amount);
            $existNotificationOfMaturity->setRemark($remark);
            $existNotificationOfMaturity->setInternalRemark($internalRemark);
            $existNotificationOfMaturity->setEmailStatus("PAIRING");
            $existNotificationOfMaturity->setStatusCode(Globals::STATUS_MATURITY_SUCCESS);
            //$existNotificationOfMaturity->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            $existNotificationOfMaturity->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $existNotificationOfMaturity->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeDoCloseAccount()
    {
        $noticeId = $this->getRequestParameter('noticeId');
        $cp3Amount = $this->getRequestParameter('cp3Amount');
        $internalRemark = $this->getRequestParameter('internalRemark', '');
        $remark = $this->getRequestParameter('remark', "CLOSE MT4");

        $existNotificationOfMaturity = NotificationOfMaturityPeer::retrieveByPK($noticeId);
        if (!$existNotificationOfMaturity) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Action."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $existDist = MlmDistributorPeer::retrieveByPK($existNotificationOfMaturity->getDistId());
        if (!$existDist) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Member Id."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $distId = $existNotificationOfMaturity->getDistId();
        $con = Propel::getConnection(MlmMt4WithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

            /*$c = new Criteria();
            $c->add(MlmRoiDividendPeer::DIST_ID, $distId);
            $c->add(MlmRoiDividendPeer::STATUS_CODE, Globals::DIVIDEND_STATUS_PENDING);
            $mlm_roi_dividendDB = MlmRoiDividendPeer::doSelectOne($c);

            if ($mlm_roi_dividendDB) {
                $existDist->setCloseAccount("N");
            } else {*/
                $existDist->setCloseAccount("Y");
            //}
            $existDist->setSecondtimeRenewal("N");
            $existDist->save();

            $existNotificationOfMaturity->setMt4Balance($cp3Amount);
            $existNotificationOfMaturity->setRemark($remark);
            $existNotificationOfMaturity->setInternalRemark($internalRemark);
            $existNotificationOfMaturity->setStatusCode(Globals::STATUS_MATURITY_WITHDRAW);
            $existNotificationOfMaturity->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            $existNotificationOfMaturity->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $existNotificationOfMaturity->save();

            if ($cp3Amount > 0) {
                $distAccountCp3Balance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MATURITY);
                $mlm_account_ledger->setRollingPoint("N");
                $mlm_account_ledger->setRemark($remark);
                $mlm_account_ledger->setInternalRemark($internalRemark);
                $mlm_account_ledger->setCredit($cp3Amount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distAccountCp3Balance + $cp3Amount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "17");

                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeDoCloseAccountForLoanAccount()
    {
        $noticeId = $this->getRequestParameter('noticeId');
        $cp3Amount = $this->getRequestParameter('cp3Amount');
        $internalRemark = $this->getRequestParameter('internalRemark', '');
        $remark = $this->getRequestParameter('remark', "CLOSE MT4");

        $existNotificationOfMaturity = NotificationOfMaturityPeer::retrieveByPK($noticeId);
        if (!$existNotificationOfMaturity) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Action."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $existDist = MlmDistributorPeer::retrieveByPK($existNotificationOfMaturity->getDistId());
        if (!$existDist) {
            $output = array(
                "error" => true,
                "errorMsg" => "Invalid Member Id."
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }
        $distId = $existNotificationOfMaturity->getDistId();
        $con = Propel::getConnection(MlmMt4WithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

            $existNotificationOfMaturity->setMt4Balance($cp3Amount);
            $existNotificationOfMaturity->setRemark($remark);
            $existNotificationOfMaturity->setInternalRemark($internalRemark.", CLOSE ACCOUNT FOR LOAN ACCOUNT");
            $existNotificationOfMaturity->setStatusCode(Globals::STATUS_MATURITY_WITHDRAW);
            $existNotificationOfMaturity->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            $existNotificationOfMaturity->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $existNotificationOfMaturity->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
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

                            $this->mirroringAccountLedger($tbl_account_ledger, "18");

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

            //$mt4ReloadFund = MlmMt4ReloadFundPeer::retrieveByPk($this->getRequestParameter('reload_id'));
            //$this->forward404Unless($mt4ReloadFund);

            $statusCodeArr = array(Globals::WITHDRAWAL_PENDING, Globals::WITHDRAWAL_PROCESSING);

            $c = new Criteria();
            $c->add(MlmMt4ReloadFundPeer::RELOAD_ID, $this->getRequestParameter('reload_id'));
            $c->add(MlmMt4ReloadFundPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
            $mt4ReloadFund = MlmMt4ReloadFundPeer::doSelectOne($c);

            if (!$mt4ReloadFund) {
                $this->setFlash('errorMsg', "Invalid Action");
                return $this->redirect('finance/reloadMt4Fund');
            }

            $mt4ReloadFund->setRemarks($remarks);
            $mt4ReloadFund->setStatusCode($statusCode);
            $mt4ReloadFund->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (Globals::STATUS_COMPLETE == $statusCode || Globals::STATUS_REJECT == $statusCode) {
                $mt4ReloadFund->setApproveRejectDatetime(date("Y/m/d h:i:s A"));

                if (Globals::STATUS_REJECT == $statusCode) {
                    $refundEpoint = $mt4ReloadFund->getAmount();
                    $distId = $mt4ReloadFund->getDistId();
                    /******************************/
                    /*  Account
                    /******************************/
                    $distAccountEpointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
                    $mlm_account_ledger->setRemark("MT4 REFUND (REFERENCE ID " . $mt4ReloadFund->getReloadId() . ")");
                    $mlm_account_ledger->setCredit($refundEpoint);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distAccountEpointBalance + $refundEpoint);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->mirroringAccountLedger($mlm_account_ledger, "19");

                    $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
                }
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

                    if (Globals::STATUS_REJECT == $statusCode) {
                        $refundEpoint = $mt4ReloadFund->getAmount();
                        $distId = $mt4ReloadFund->getDistId();
                        /******************************/
                        /*  Account
                        /******************************/
                        $distAccountEpointBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($distId);
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REFUND);
                        $mlm_account_ledger->setRemark("MT4 REFUND (REFERENCE ID " . $mt4ReloadFund->getReloadId() . ")");
                        $mlm_account_ledger->setCredit($refundEpoint);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distAccountEpointBalance + $refundEpoint);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->mirroringAccountLedger($mlm_account_ledger, "20");

                        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
                    }
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

                        $this->mirroringAccountLedger($mlm_account_ledger, "21");

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

                        $this->mirroringAccountLedger($mlm_account_ledger, "22");

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

                        $this->setFlash('errorMsg', "Insufficient CP1.");
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

                        $this->mirroringAccountLedger($mlm_account_ledger, "23");

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

                        $this->mirroringAccountLedger($mlm_account_ledger, "24");

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

                        $this->setFlash('errorMsg', "Insufficient CP1.");
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

                    $this->mirroringAccountLedger($mlm_account_ledger, "25");

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

                    $this->mirroringAccountLedger($mlm_account_ledger, "26");

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

                $this->setFlash('errorMsg', "Insufficient CP1.");
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

                        $this->mirroringAccountLedger($mlm_account_ledger, "27");

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

                        $this->mirroringAccountLedger($mlm_account_ledger, "28");

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

                    $this->setFlash('errorMsg', "Insufficient CP1.");
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
									Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
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
                    $leaderArrs = explode(",", Globals::GROUP_LEADER);
                    $isAmz001 = false;
                    for ($i = 0; $i < count($leaderArrs); $i++) {
                        $pos = strrpos($tbl_distributor->getTreeStructure(), "|".$leaderArrs[$i]."|");
                        if ($pos === false) { // note: three equal signs

                        } else {
                            if ($leaderArrs[$i] == 1458) {
                                $isAmz001 = true;
                            }
                        }
                    }

                    $sendMailService = new SendMailService();

                    if ($isAmz001) {
                        $dist = MlmDistributorPeer::retrieveByPK(1458);
                        $sendMailService->sendMail($tbl_distributor->getEmail(), $tbl_distributor->getFullName(), $subject, $body, $sendFrom=Mails::EMAIL_SENDER, $dist->getEmail());
                    } else {
                        $sendMailService->sendMail($tbl_distributor->getEmail(), $tbl_distributor->getFullName(), $subject, $body);
                    }
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

            $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
            try {
                $con->begin();

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

                        $this->mirroringAccountLedger($mlm_account_ledger, "29");

                        $bonusService = new BonusService();
                        if ($bonusService->checkDebitAccount($distId) == true) {
                            $debitAccountRemark = "REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")";
                            $bonusService->contraDebitAccount($distId, $debitAccountRemark, $refundEcash);
                        }
                        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
                    }

                }

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
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
        $statusCodeArr = array(Globals::WITHDRAWAL_PENDING, Globals::WITHDRAWAL_PROCESSING);

        $c = new Criteria();
        $c->add(MlmEcashWithdrawPeer::WITHDRAW_ID, $this->getRequestParameter('withdraw_id'));
        $c->add(MlmEcashWithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
        $mlm_ecash_withdraw = MlmEcashWithdrawPeer::doSelectOne($c);

        if (!$mlm_ecash_withdraw) {
            $this->setFlash('errorMsg', "Invalid Action");
            return $this->redirect('finance/ecashWithdrawal');
        }

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();
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

                $this->mirroringAccountLedger($mlm_account_ledger, "30");

                $bonusService = new BonusService();
                if ($bonusService->checkDebitAccount($distId) == true) {
                    $debitAccountRemark = "REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")";
                    $bonusService->contraDebitAccount($distId, $debitAccountRemark, $refundEcash);
                }
                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $this->setFlash('successMsg', "Update successfully");
        return $this->redirect('finance/ecashWithdrawal');
    }

    public function executeRejectCp2Withdrawal()
    {
        $statusCodeArr = array(Globals::WITHDRAWAL_PAID);

        $c = new Criteria();
        $c->add(MlmEcashWithdrawPeer::WITHDRAW_ID, $this->getRequestParameter('withdraw_id'));
        $c->add(MlmEcashWithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
        $mlm_ecash_withdraw = MlmEcashWithdrawPeer::doSelectOne($c);

        if (!$mlm_ecash_withdraw) {
            $this->setFlash('errorMsg', "Invalid Action");
            return $this->redirect('finance/ecashWithdrawal');
        }

        $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
        try {
            $con->begin();

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

                $this->mirroringAccountLedger($mlm_account_ledger, "31");

                $bonusService = new BonusService();
                if ($bonusService->checkDebitAccount($distId) == true) {
                    $debitAccountRemark = "REFUND (REFERENCE ID " . $mlm_ecash_withdraw->getWithdrawId() . ")";
                    $bonusService->contraDebitAccount($distId, $debitAccountRemark, $refundEcash);
                }
                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
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
                $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
                try {
                    $con->begin();
                    //$mlm_ecash_withdraw = MlmCp3WithdrawPeer::retrieveByPk($arr[$i]);
                    $statusCodeArr = array(Globals::WITHDRAWAL_PENDING, Globals::WITHDRAWAL_PROCESSING);

                    $c = new Criteria();
                    $c->add(MlmCp3WithdrawPeer::WITHDRAW_ID, $arr[$i]);
                    $c->add(MlmCp3WithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
                    $mlm_ecash_withdraw = MlmCp3WithdrawPeer::doSelectOne($c);
                    if (!$mlm_ecash_withdraw) {
                        //$this->setFlash('errorMsg', "Invalid Action");
                        //return $this->redirect('finance/cp3Withdrawal');
                        continue;
                    }

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

                        $this->mirroringAccountLedger($mlm_account_ledger, "32");

                        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                    }
                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
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
        //$mlm_ecash_withdraw = MlmCp3WithdrawPeer::retrieveByPk($this->getRequestParameter('withdraw_id'));
        //$this->forward404Unless($mlm_ecash_withdraw);

        $statusCodeArr = array(Globals::WITHDRAWAL_PENDING, Globals::WITHDRAWAL_PROCESSING);

        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::WITHDRAW_ID, $this->getRequestParameter('withdraw_id'));
        $c->add(MlmCp3WithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
        $mlm_ecash_withdraw = MlmCp3WithdrawPeer::doSelectOne($c);

        if (!$mlm_ecash_withdraw) {
            $this->setFlash('errorMsg', "Invalid Action");
            return $this->redirect('finance/cp3Withdrawal');
        }

        $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

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

                $this->mirroringAccountLedger($mlm_account_ledger, "33");

                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $this->setFlash('successMsg', "Update successfully");
        return $this->redirect('finance/cp3Withdrawal');
    }
    public function executeRejectCp3Withdrawal()
    {
        //$mlm_ecash_withdraw = MlmCp3WithdrawPeer::retrieveByPk($this->getRequestParameter('withdraw_id'));
        //$this->forward404Unless($mlm_ecash_withdraw);

        $statusCodeArr = array(Globals::WITHDRAWAL_PAID);

        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::WITHDRAW_ID, $this->getRequestParameter('withdraw_id'));
        $c->add(MlmCp3WithdrawPeer::STATUS_CODE, $statusCodeArr, Criteria::IN);
        $mlm_ecash_withdraw = MlmCp3WithdrawPeer::doSelectOne($c);

        if (!$mlm_ecash_withdraw) {
            $this->setFlash('errorMsg', "Invalid Action");
            return $this->redirect('finance/cp3Withdrawal');
        }

        $con = Propel::getConnection(MlmCp3WithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

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

                $this->mirroringAccountLedger($mlm_account_ledger, "34");

                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
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

            $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
            try {
                $con->begin();
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

                $this->mirroringAccountLedger($tbl_account_ledger, "35");

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }

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

            $con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
            try {
                $con->begin();
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

                $this->mirroringAccountLedger($mlm_account_ledger, "36");

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

                $this->mirroringAccountLedger($tbl_account_ledger, "37");

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
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

    function getMt4Balance($distributorId, $mt4Username)
    {
        $arr = array();

        $mt4request = new CMT4DataReciver;
        $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

        $params = array();
        $params['login'] = $mt4Username;

        $answer = $mt4request->MakeRequest("getaccountbalance", $params);
        //var_dump($answer['balance']);
        //exit();
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

    public function executeCp3WithdrawalListInDetail3()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/xls');
        $response->setHttpHeader('Content-Type', 'application/force-download', TRUE);
        $response->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
        $response->setHttpHeader('Content-Type', 'application/download', TRUE);
        $response->setHttpHeader('Content-Type', 'charset=UTF-8', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=withdrawal_list.xls', TRUE);
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Encoding', 'UTF-8', TRUE);

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
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
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
        $response->setHttpHeader('Content-Type', 'charset=UTF-8', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=cp3_withdrawal_list.xls', TRUE);
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Encoding', 'UTF-8', TRUE);

        $response->sendHttpHeaders();

        $query = "SELECT dist.tree_structure, withdraw.withdraw_id,withdraw.dist_id
                    ,dist.distributor_code,dist.full_name,withdraw.deduct,withdraw.amount,withdraw.bank_in_to
                    ,accountLedger._ecash,withdraw.status_code,withdraw.created_on,dist.ic
                    ,dist.email,dist.contact,leader.distributor_code as leader_code,dist.bank_name
                    ,dist.bank_branch_name,dist.bank_acc_no,dist.bank_holder_name,dist.bank_swift_code
                    ,dist.visa_debit_card,pack.package_name,withdraw.remarks,dist.country
                    ,dist.moneytrac_customer_id,dist.moneytrac_username
                    ,dist.address, dist.address2, dist.city, dist.state, dist.postcode
                    ,dist.file_proof_of_residence, dist.file_nric, dist.file_bank_pass_book, dist.iaccount, dist.bank_account_currency
            FROM mlm_cp3_withdraw withdraw
                LEFT JOIN mlm_distributor dist ON withdraw.dist_id = dist.distributor_id
                LEFT JOIN mlm_distributor leader ON withdraw.leader_dist_id = leader.distributor_id

                LEFT JOIN mlm_package pack ON pack.package_id = dist.rank_id
                LEFT JOIN
            (
            SELECT SUM(credit-debit) AS _ecash, dist_id
                FROM mlm_account_ledger accountLedger WHERE account_type = 'MAINTENANCE' GROUP BY dist_id
            ) accountLedger ON accountLedger.dist_id = withdraw.dist_id
                WHERE 1=1 ";

        $query = "SELECT dist.tree_structure, withdraw.withdraw_id,withdraw.dist_id
                    ,dist.distributor_code,dist.full_name,withdraw.deduct,withdraw.amount,withdraw.bank_in_to
                    ,withdraw.status_code,withdraw.created_on,dist.ic
                    ,dist.email,dist.contact,leader.distributor_code as leader_code,dist.bank_name
                    ,dist.bank_branch_name,dist.bank_acc_no,dist.bank_holder_name,dist.bank_swift_code
                    ,dist.visa_debit_card,pack.package_name,withdraw.remarks,dist.country
                    ,dist.moneytrac_customer_id,dist.moneytrac_username
                    ,dist.address, dist.address2, dist.city, dist.state, dist.postcode
                    ,dist.file_proof_of_residence, dist.file_nric, dist.file_bank_pass_book, dist.iaccount, dist.bank_account_currency
            FROM mlm_cp3_withdraw withdraw
                LEFT JOIN mlm_distributor dist ON withdraw.dist_id = dist.distributor_id
                LEFT JOIN mlm_distributor leader ON withdraw.leader_dist_id = leader.distributor_id

                LEFT JOIN mlm_package pack ON pack.package_id = dist.rank_id
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

        if ($this->getRequestParameter('dateFrom') != "") {
            $query .= " AND date_format(withdraw.created_on, '%Y-%m-%d') >= '" . $this->getRequestParameter('dateFrom') . "'";
        }

        if ($this->getRequestParameter('dateTo') != "") {
            $query .= " AND date_format(withdraw.created_on, '%Y-%m-%d') <= '" . $this->getRequestParameter('dateTo') . "'";
        }
        

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $rs = $statement->executeQuery();

        $xlsRow = 1;

        /*$export_data = preg_split("/\n/", $tsv_data);
        foreach($export_data as &$row) {
            $row = preg_split("/\t/", $row);
        }

        include("includes/PHPExcel.php");
        include('includes/PHPExcel/Writer/Excel5.php');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $row = '1';
        $col = "A";
        foreach($export_data as $row_cells) {
            if(!is_array($row_cells)) { continue; }
                foreach($row_cells as $cell) {
                    $sheet->setCellValue($col.$row, $cell);
                    $col++;
                }
            $row += 1;
            $col = "A";
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');*/

        include("PHPExcel.php");
        include('PHPExcel/Writer/Excel5.php');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $row = '1';
        $col = "A";

        $sheet->setCellValue("A".$xlsRow, "ID");
        $sheet->setCellValue("B".$xlsRow, "Member ID");
        $sheet->setCellValue("C".$xlsRow, "Name");
        $sheet->setCellValue("D".$xlsRow, "Withdraw");
        $sheet->setCellValue("E".$xlsRow, "Withdraw after Deduction");
//        $sheet->setCellValue("F".$xlsRow, "CP3 in wallet");
        $sheet->setCellValue("G".$xlsRow, "Status");
        $sheet->setCellValue("H".$xlsRow, "Date");
        $sheet->setCellValue("I".$xlsRow, "IC");
        $sheet->setCellValue("J".$xlsRow, "Email");
        $sheet->setCellValue("K".$xlsRow, "Contact No");
        $sheet->setCellValue("L".$xlsRow, "Leader Code");
        $sheet->setCellValue("M".$xlsRow, "Credit To");
        $sheet->setCellValue("N".$xlsRow, "Bank Name");
        $sheet->setCellValue("O".$xlsRow, "Bank Branch Name");
        $sheet->setCellValue("P".$xlsRow, "Bank Account No");
        $sheet->setCellValue("Q".$xlsRow, "Bank Holder Name");
        $sheet->setCellValue("R".$xlsRow, "Bank Swift Code");
        $sheet->setCellValue("S".$xlsRow, "Visa Debit Card");
        $sheet->setCellValue("T".$xlsRow, "Money Trac Customer ID");
        $sheet->setCellValue("U".$xlsRow, "Money Trac Username");
        $sheet->setCellValue("V".$xlsRow, "Rank Code");
        $sheet->setCellValue("W".$xlsRow, "Remarks");
        $sheet->setCellValue("X".$xlsRow, "Address");
        $sheet->setCellValue("Y".$xlsRow, "Address 2");
        $sheet->setCellValue("Z".$xlsRow, "City");
        $sheet->setCellValue("AA".$xlsRow, "State");
        $sheet->setCellValue("AB".$xlsRow, "Postcode");
        $sheet->setCellValue("AC".$xlsRow, "Country");
        $sheet->setCellValue("AD".$xlsRow, "Proof of Residence Uploaded");
        $sheet->setCellValue("AE".$xlsRow, "Nric Uploaded");
        $sheet->setCellValue("AF".$xlsRow, "Bank Pass Book");
        $sheet->setCellValue("AG".$xlsRow, "i-Account");
        $sheet->setCellValue("AH".$xlsRow, "Bank Account Currency");

        $xlsRow = 2;
        while ($rs->next()) {
            $arr = $rs->getRow();
            $arrs[] = $arr;
            $columnIdx = 0;

            $sheet->setCellValue("A".$xlsRow, $arr['withdraw_id']);
            $sheet->setCellValue("B".$xlsRow, $arr['distributor_code']);
            $sheet->setCellValue("C".$xlsRow, $arr['full_name']);
            $sheet->setCellValue("D".$xlsRow, $arr['deduct']);
            $sheet->setCellValue("E".$xlsRow, $arr['amount']);
//            $sheet->setCellValue("F".$xlsRow, $arr['_ecash']);
            $sheet->setCellValue("G".$xlsRow, $arr['status_code']);
            $sheet->setCellValue("H".$xlsRow, $arr['created_on']);
            $sheet->setCellValue("I".$xlsRow, $arr['ic']);
            $sheet->setCellValue("J".$xlsRow, $arr['email']);
            $sheet->setCellValue("K".$xlsRow, $arr['contact']);
            $sheet->setCellValue("L".$xlsRow, $arr['leader_code']);
            $sheet->setCellValue("M".$xlsRow, $arr['bank_in_to']);
            $sheet->setCellValue("N".$xlsRow, $arr['bank_name']);
            $sheet->setCellValue("O".$xlsRow, $arr['bank_branch_name']);
            //$sheet->setCellValue("O".$xlsRow, $arr['bank_acc_no']);
            $sheet->setCellValueExplicit("P".$xlsRow, $arr['bank_acc_no'], PHPExcel_Cell_DataType::TYPE_STRING);

            $sheet->setCellValue("Q".$xlsRow, $arr['bank_holder_name']);
            $sheet->setCellValue("R".$xlsRow, $arr['bank_swift_code']);
            //$sheet->setCellValue("S".$xlsRow, $arr['visa_debit_card']);
            $sheet->setCellValueExplicit("S".$xlsRow, $arr['visa_debit_card'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("T".$xlsRow, $arr['moneytrac_customer_id'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("U".$xlsRow, $arr['moneytrac_username'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValue("V".$xlsRow, $arr['package_name']);
            $sheet->setCellValue("W".$xlsRow, $arr['remarks']);
            $sheet->setCellValue("X".$xlsRow, $arr['address']);
            $sheet->setCellValue("Y".$xlsRow, $arr['address2']);
            $sheet->setCellValue("Z".$xlsRow, $arr['city']);
            $sheet->setCellValue("AA".$xlsRow, $arr['state']);
            $sheet->setCellValue("AB".$xlsRow, $arr['postcode']);
            $sheet->setCellValue("AC".$xlsRow, $arr['country']);
            $sheet->setCellValue("AD".$xlsRow, $arr['file_proof_of_residence'] == "" ? "N" : "Y");
            $sheet->setCellValue("AE".$xlsRow, $arr['file_nric'] == "" ? "N" : "Y");
            $sheet->setCellValue("AF".$xlsRow, $arr['file_bank_pass_book'] == "" ? "N" : "Y");
            $sheet->setCellValue("AG".$xlsRow, $arr['iaccount']);
            $sheet->setCellValue("AH".$xlsRow, $arr['bank_account_currency']);

            //$sheet->setCellValue("A".$xlsRow, $arr['withdraw_id']);
            //$row += 1;
            //$col = "A";

            $xlsRow++;
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        return sfView::HEADER_ONLY;
    }

    public function executeMt4WithdrawalListInDetail()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/xls');
        $response->setHttpHeader('Content-Type', 'application/force-download', TRUE);
        $response->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
        $response->setHttpHeader('Content-Type', 'application/download', TRUE);
        $response->setHttpHeader('Content-Type', 'charset=UTF-8', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=mt4_withdrawal_list.xls', TRUE);
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Encoding', 'UTF-8', TRUE);

        $response->sendHttpHeaders();

        $query = "SELECT withdraw.withdraw_id,dist.distributor_code,withdraw.mt4_user_name
            ,dist.full_name,withdraw.currency_code,withdraw.amount_requested,withdraw.handling_fee
            ,withdraw.grand_amount,withdraw.payment_type,withdraw.status_code,dist.bank_name,dist.bank_branch_name,dist.bank_acc_no
            ,dist.bank_holder_name,dist.bank_swift_code,dist.visa_debit_card,withdraw.remarks,withdraw.created_on
            ,dist.tree_structure,dist.ic,dist.email,dist.contact
                FROM mlm_mt4_withdraw withdraw
        LEFT JOIN mlm_distributor dist ON withdraw.dist_id = dist.distributor_id   WHERE 1=1  ";

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

        /*$export_data = preg_split("/\n/", $tsv_data);
        foreach($export_data as &$row) {
            $row = preg_split("/\t/", $row);
        }

        include("includes/PHPExcel.php");
        include('includes/PHPExcel/Writer/Excel5.php');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $row = '1';
        $col = "A";
        foreach($export_data as $row_cells) {
            if(!is_array($row_cells)) { continue; }
                foreach($row_cells as $cell) {
                    $sheet->setCellValue($col.$row, $cell);
                    $col++;
                }
            $row += 1;
            $col = "A";
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');*/

        include("PHPExcel.php");
        include('PHPExcel/Writer/Excel5.php');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $row = '1';
        $col = "A";

        $sheet->setCellValue("A".$xlsRow, "ID");
        $sheet->setCellValue("B".$xlsRow, "Member ID");
        $sheet->setCellValue("C".$xlsRow, "MT4");
        $sheet->setCellValue("D".$xlsRow, "Full Name");
        $sheet->setCellValue("E".$xlsRow, "Amount Requested (USD)");
        $sheet->setCellValue("F".$xlsRow, "Handling Fee (USD)");
        $sheet->setCellValue("G".$xlsRow, "Grand Amount (USD)");
        $sheet->setCellValue("H".$xlsRow, "Payment Type");
        $sheet->setCellValue("I".$xlsRow, "Status");
        $sheet->setCellValue("J".$xlsRow, "Bank Name");
        $sheet->setCellValue("K".$xlsRow, "Bank Branch Name");
        $sheet->setCellValue("L".$xlsRow, "Bank Account No");
        $sheet->setCellValue("M".$xlsRow, "Bank Holder Name");
        $sheet->setCellValue("N".$xlsRow, "Bank Swift Code");
        $sheet->setCellValue("O".$xlsRow, "Visa Debit Card");
        $sheet->setCellValue("P".$xlsRow, "Remarks");
        $sheet->setCellValue("Q".$xlsRow, "Date");
        $sheet->setCellValue("R".$xlsRow, "IC");
        $sheet->setCellValue("S".$xlsRow, "Email");
        $sheet->setCellValue("T".$xlsRow, "Contact No");
        $sheet->setCellValue("U".$xlsRow, "Leader Code");

        $xlsRow = 2;
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        while ($rs->next()) {
            $arr = $rs->getRow();
            $arrs[] = $arr;
            $columnIdx = 0;

            $paymentType = $arr['payment_type'] == null ? "" : $arr['payment_type'];
            if ($paymentType == "VISA") {
                $paymentType = "VISA Cash Card";
            } elseif ($paymentType == "BANK") {
                $paymentType = "Local Bank Transfer";
            }

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $sheet->setCellValue("A".$xlsRow, $arr['withdraw_id']);
            $sheet->setCellValue("B".$xlsRow, $arr['distributor_code']);
            $sheet->setCellValue("C".$xlsRow, $arr['mt4_user_name']);
            $sheet->setCellValue("D".$xlsRow, $arr['full_name']);
//            $sheet->setCellValue("E".$xlsRow, $arr['currency_code']);
            $sheet->setCellValue("E".$xlsRow, $arr['amount_requested']);
            $sheet->setCellValue("F".$xlsRow, $arr['handling_fee']);
            $sheet->setCellValue("G".$xlsRow, $arr['grand_amount']);
            $sheet->setCellValue("H".$xlsRow, $paymentType);
            $sheet->setCellValue("I".$xlsRow, $arr['status_code']);
            $sheet->setCellValue("J".$xlsRow, $arr['bank_name']);
            $sheet->setCellValue("K".$xlsRow, $arr['bank_branch_name']);
            $sheet->setCellValueExplicit("L".$xlsRow, $arr['bank_acc_no'], PHPExcel_Cell_DataType::TYPE_STRING);

            $sheet->setCellValue("M".$xlsRow, $arr['bank_holder_name']);
            $sheet->setCellValue("N".$xlsRow, $arr['bank_swift_code']);
            $sheet->setCellValueExplicit("O".$xlsRow, $arr['visa_debit_card'], PHPExcel_Cell_DataType::TYPE_STRING);

            $sheet->setCellValue("P".$xlsRow, $arr['remarks']);
            $sheet->setCellValue("Q".$xlsRow, $arr['created_on']);

            $sheet->setCellValue("R".$xlsRow, $arr['ic']);
            $sheet->setCellValue("S".$xlsRow, $arr['email']);

            $sheet->setCellValueExplicit("T".$xlsRow, $arr['contact'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValue("U".$xlsRow, $leader);

            //$sheet->setCellValue("A".$xlsRow, $arr['withdraw_id']);
            //$row += 1;
            //$col = "A";

            $xlsRow++;
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        return sfView::HEADER_ONLY;
    }

    public function executeCp2WithdrawalListInDetail()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/xls');
        $response->setHttpHeader('Content-Type', 'application/force-download', TRUE);
        $response->setHttpHeader('Content-Type', 'application/octet-stream', TRUE);
        $response->setHttpHeader('Content-Type', 'application/download', TRUE);
        $response->setHttpHeader('Content-Type', 'charset=UTF-8', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=cp2_withdrawal_list.xls', TRUE);
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Encoding', 'UTF-8', TRUE);

        $response->sendHttpHeaders();

        $query = "SELECT dist.tree_structure, withdraw.withdraw_id,withdraw.dist_id
                ,dist.distributor_code,dist.full_name,withdraw.deduct,withdraw.amount,withdraw.bank_in_to
                ,accountLedger._ecash,withdraw.status_code,withdraw.created_on,dist.ic
                ,dist.email,dist.contact,leader.distributor_code as leader_code,dist.bank_name
                ,dist.bank_branch_name,dist.bank_acc_no,dist.bank_holder_name,dist.bank_swift_code
                ,dist.visa_debit_card,pack.package_name,withdraw.remarks,dist.country
                ,dist.moneytrac_customer_id,dist.moneytrac_username
                ,dist.address, dist.address2, dist.city, dist.state, dist.postcode
                ,dist.file_proof_of_residence, dist.file_nric, dist.file_bank_pass_book, dist.iaccount, dist.bank_account_currency
            FROM mlm_ecash_withdraw withdraw
                LEFT JOIN mlm_distributor dist ON withdraw.dist_id = dist.distributor_id
                LEFT JOIN mlm_distributor leader ON withdraw.leader_dist_id = leader.distributor_id

                LEFT JOIN mlm_package pack ON pack.package_id = dist.rank_id
                LEFT JOIN
            (
            SELECT SUM(credit-debit) AS _ecash, dist_id
                FROM mlm_account_ledger accountLedger WHERE account_type = 'MAINTENANCE' GROUP BY dist_id
            ) accountLedger ON accountLedger.dist_id = withdraw.dist_id
                WHERE 1=1 ";


        $query = "SELECT dist.tree_structure, withdraw.withdraw_id,withdraw.dist_id
                ,dist.distributor_code,dist.full_name,withdraw.deduct,withdraw.amount,withdraw.bank_in_to
                ,withdraw.status_code,withdraw.created_on,dist.ic
                ,dist.email,dist.contact,leader.distributor_code as leader_code,dist.bank_name
                ,dist.bank_branch_name,dist.bank_acc_no,dist.bank_holder_name,dist.bank_swift_code
                ,dist.visa_debit_card,pack.package_name,withdraw.remarks,dist.country
                ,dist.moneytrac_customer_id,dist.moneytrac_username
                ,dist.address, dist.address2, dist.city, dist.state, dist.postcode
                ,dist.file_proof_of_residence, dist.file_nric, dist.file_bank_pass_book, dist.iaccount, dist.bank_account_currency
            FROM mlm_ecash_withdraw withdraw
                LEFT JOIN mlm_distributor dist ON withdraw.dist_id = dist.distributor_id
                LEFT JOIN mlm_distributor leader ON withdraw.leader_dist_id = leader.distributor_id

                LEFT JOIN mlm_package pack ON pack.package_id = dist.rank_id
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

        if ($this->getRequestParameter('dateFrom') != "") {
            $query .= " AND date_format(withdraw.created_on, '%Y-%m-%d') >= '" . $this->getRequestParameter('dateFrom') . "'";
        }

        if ($this->getRequestParameter('dateTo') != "") {
            $query .= " AND date_format(withdraw.created_on, '%Y-%m-%d') <= '" . $this->getRequestParameter('dateTo') . "'";
        }

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $rs = $statement->executeQuery();

        $xlsRow = 1;

        /*$export_data = preg_split("/\n/", $tsv_data);
        foreach($export_data as &$row) {
            $row = preg_split("/\t/", $row);
        }

        include("includes/PHPExcel.php");
        include('includes/PHPExcel/Writer/Excel5.php');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $row = '1';
        $col = "A";
        foreach($export_data as $row_cells) {
            if(!is_array($row_cells)) { continue; }
                foreach($row_cells as $cell) {
                    $sheet->setCellValue($col.$row, $cell);
                    $col++;
                }
            $row += 1;
            $col = "A";
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');*/

        include("PHPExcel.php");
        include('PHPExcel/Writer/Excel5.php');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $row = '1';
        $col = "A";

        $sheet->setCellValue("A".$xlsRow, "ID");
        $sheet->setCellValue("B".$xlsRow, "Member ID");
        $sheet->setCellValue("C".$xlsRow, "Name");
        $sheet->setCellValue("D".$xlsRow, "Withdraw");
        $sheet->setCellValue("E".$xlsRow, "Withdraw after Deduction");
//        $sheet->setCellValue("F".$xlsRow, "CP3 in wallet");
        $sheet->setCellValue("G".$xlsRow, "Status");
        $sheet->setCellValue("H".$xlsRow, "Date");
        $sheet->setCellValue("I".$xlsRow, "IC");
        $sheet->setCellValue("J".$xlsRow, "Email");
        $sheet->setCellValue("K".$xlsRow, "Contact No");
        $sheet->setCellValue("L".$xlsRow, "Leader Code");
        $sheet->setCellValue("M".$xlsRow, "Credit To");
        $sheet->setCellValue("N".$xlsRow, "Bank Name");
        $sheet->setCellValue("O".$xlsRow, "Bank Branch Name");
        $sheet->setCellValue("P".$xlsRow, "Bank Account No");
        $sheet->setCellValue("Q".$xlsRow, "Bank Holder Name");
        $sheet->setCellValue("R".$xlsRow, "Bank Swift Code");
        $sheet->setCellValue("S".$xlsRow, "Visa Debit Card");
        $sheet->setCellValue("T".$xlsRow, "Money Trac Customer ID");
        $sheet->setCellValue("U".$xlsRow, "Money Trac Username");
        $sheet->setCellValue("V".$xlsRow, "Rank Code");
        $sheet->setCellValue("W".$xlsRow, "Remarks");
        $sheet->setCellValue("X".$xlsRow, "Address");
        $sheet->setCellValue("Y".$xlsRow, "Address 2");
        $sheet->setCellValue("Z".$xlsRow, "City");
        $sheet->setCellValue("AA".$xlsRow, "State");
        $sheet->setCellValue("AB".$xlsRow, "Postcode");
        $sheet->setCellValue("AC".$xlsRow, "Country");
        $sheet->setCellValue("AD".$xlsRow, "Proof of Residence Uploaded");
        $sheet->setCellValue("AE".$xlsRow, "Nric Uploaded");
        $sheet->setCellValue("AF".$xlsRow, "Bank Pass Book");
        $sheet->setCellValue("AG".$xlsRow, "i-Account");
        $sheet->setCellValue("AH".$xlsRow, "Bank Account Currency");

        $xlsRow = 2;
        while ($rs->next()) {
            $arr = $rs->getRow();
            $arrs[] = $arr;
            $columnIdx = 0;

            $sheet->setCellValue("A".$xlsRow, $arr['withdraw_id']);
            $sheet->setCellValue("B".$xlsRow, $arr['distributor_code']);
            $sheet->setCellValue("C".$xlsRow, $arr['full_name']);
            $sheet->setCellValue("D".$xlsRow, $arr['deduct']);
            $sheet->setCellValue("E".$xlsRow, $arr['amount']);
//            $sheet->setCellValue("F".$xlsRow, $arr['_ecash']);
            $sheet->setCellValue("G".$xlsRow, $arr['status_code']);
            $sheet->setCellValue("H".$xlsRow, $arr['created_on']);
            $sheet->setCellValue("I".$xlsRow, $arr['ic']);
            $sheet->setCellValue("J".$xlsRow, $arr['email']);
            $sheet->setCellValue("K".$xlsRow, $arr['contact']);
            $sheet->setCellValue("L".$xlsRow, $arr['leader_code']);
            $sheet->setCellValue("M".$xlsRow, $arr['bank_in_to']);
            $sheet->setCellValue("N".$xlsRow, $arr['bank_name']);
            $sheet->setCellValue("O".$xlsRow, $arr['bank_branch_name']);
            //$sheet->setCellValue("O".$xlsRow, $arr['bank_acc_no']);
            $sheet->setCellValueExplicit("P".$xlsRow, $arr['bank_acc_no'], PHPExcel_Cell_DataType::TYPE_STRING);

            $sheet->setCellValue("Q".$xlsRow, $arr['bank_holder_name']);
            $sheet->setCellValue("R".$xlsRow, $arr['bank_swift_code']);
            //$sheet->setCellValue("S".$xlsRow, $arr['visa_debit_card']);
            $sheet->setCellValueExplicit("S".$xlsRow, $arr['visa_debit_card'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("T".$xlsRow, $arr['moneytrac_customer_id'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("U".$xlsRow, $arr['moneytrac_username'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValue("V".$xlsRow, $arr['package_name']);
            $sheet->setCellValue("W".$xlsRow, $arr['remarks']);
            $sheet->setCellValue("X".$xlsRow, $arr['address']);
            $sheet->setCellValue("Y".$xlsRow, $arr['address2']);
            $sheet->setCellValue("Z".$xlsRow, $arr['city']);
            $sheet->setCellValue("AA".$xlsRow, $arr['state']);
            $sheet->setCellValue("AB".$xlsRow, $arr['postcode']);
            $sheet->setCellValue("AC".$xlsRow, $arr['country']);
            $sheet->setCellValue("AD".$xlsRow, $arr['file_proof_of_residence'] == "" ? "N" : "Y");
            $sheet->setCellValue("AE".$xlsRow, $arr['file_nric'] == "" ? "N" : "Y");
            $sheet->setCellValue("AF".$xlsRow, $arr['file_bank_pass_book'] == "" ? "N" : "Y");
            $sheet->setCellValue("AG".$xlsRow, $arr['iaccount']);
            $sheet->setCellValue("AH".$xlsRow, $arr['bank_account_currency']);
            //$sheet->setCellValue("A".$xlsRow, $arr['withdraw_id']);
            //$row += 1;
            //$col = "A";

            $xlsRow++;
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
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

    function revalidatePairing($distributorId, $leftRight)
    {
        $c = new Criteria();
        $c->add(MlmDistPairingPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistPairingPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistPairing();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setLeftBalance(0);
            $tbl_account->setRightBalance(0);
            $tbl_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->save();
        }
    }

    function mirroringAccountLedger($mlmAccountLedger, $internalRemark)
    {
        $log_account_ledger = new LogAccountLedger();
        $log_account_ledger->setAccountId($mlmAccountLedger->getAccountId());
        $log_account_ledger->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
        $log_account_ledger->setDistId($mlmAccountLedger->getDistId());
        $log_account_ledger->setAccountType($mlmAccountLedger->getAccountType());
        $log_account_ledger->setTransactionType($mlmAccountLedger->getTransactionType());
        $log_account_ledger->setRemark($mlmAccountLedger->getRemark());
        $log_account_ledger->setInternalRemark($internalRemark);
        $log_account_ledger->setCredit($mlmAccountLedger->getCredit());
        $log_account_ledger->setDebit($mlmAccountLedger->getDebit());
        $log_account_ledger->setBalance($mlmAccountLedger->getBalance());
        $log_account_ledger->setCreatedBy($mlmAccountLedger->getCreatedBy());
        $log_account_ledger->setUpdatedBy($mlmAccountLedger->getUpdatedBy());
        $log_account_ledger->save();
    }
}