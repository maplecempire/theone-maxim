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
    public function executeDoTesting()
    {
        $c = new Criteria();
//        $c->add(SssApplicationPeer::SSS_ID, 2210);
//        $c->add(SssApplicationPeer::DIST_ID, 2210);
        //$c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_PENDING);
//        $c->add(SssApplicationPeer::SWAP_TYPE, "SES");
        //$c->setLimit(30);
//        $sssApplication = SssApplicationPeer::doSelectOne($c);
        $sssApplication = SssApplicationPeer::retrieveByPK(9999992214);

        var_dump($sssApplication);

        if ($sssApplication->getSwapType() == "SES") {
            $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);

            $pairingBonusAmount = $sssApplication->getTotalShareConverted();
            $ecashBalance = $this->getAccountBalance($sssApplication->getDistId(), Globals::ACCOUNT_TYPE_RT);

            $tbl_account_ledger2 = new MlmAccountLedger();
            $tbl_account_ledger2->setAccountType(Globals::ACCOUNT_TYPE_RT);
            $tbl_account_ledger2->setDistId($sssApplication->getDistId());
            $tbl_account_ledger2->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SWAP_SSS);
            $tbl_account_ledger2->setCredit($pairingBonusAmount);
            $tbl_account_ledger2->setDebit(0);
            $tbl_account_ledger2->setRemark("");
            $tbl_account_ledger2->setBalance($ecashBalance);
            $tbl_account_ledger2->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger2->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger2->save();

            $dist = MlmDistributorPeer::retrieveByPk($sssApplication->getDistId());

            $bal = $dist->getRtwallet() + $pairingBonusAmount;
            $gg_member_rtwallet_record = new GgMemberRtwalletRecord();
            $gg_member_rtwallet_record->setUid($sssApplication->getDistId());
            $gg_member_rtwallet_record->setActionType('SWAP SES from Maxim');
            $gg_member_rtwallet_record->setType('c');
            $gg_member_rtwallet_record->setAmount($pairingBonusAmount);
            $gg_member_rtwallet_record->setBal($bal);
            $gg_member_rtwallet_record->setDescr("");
            $gg_member_rtwallet_record->setCdate(date('Y-m-d H:i:s'));
            $gg_member_rtwallet_record->save();

            $dist->setRtwallet($bal);
            $dist->save();
            $sssApplication->save();
        }

        print_r("done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateRWallet()
    {
        $this->updateRwallet($this->getRequestParameter('q'));

        print_r("done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdatePairingCreatedDate()
    {
        // update RT from CP2
        $query = "SELECT SUM(credit - debit) as _total, dist_id FROM mlm_account_ledger WHERE transaction_type = 'GDB SSS'
                    AND account_type = 'RT'
                  GROUP BY dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $distId = $arr['dist_id'];
            $totalAmount = $arr['_total'];

            $dist = MlmDistributorPeer::retrieveByPk($distId);
            $bal = $dist->getRtwallet() + $totalAmount;
            $gg_member_rtwallet_record = new GgMemberRtwalletRecord();
            $gg_member_rtwallet_record->setUid($distId);
            $gg_member_rtwallet_record->setActionType('GDB SSS from Maxim');
            $gg_member_rtwallet_record->setType('c');
            $gg_member_rtwallet_record->setAmount($totalAmount);
            $gg_member_rtwallet_record->setBal($bal);
            $gg_member_rtwallet_record->setDescr("GROUP PAIRING BONUS AMOUNT");
            $gg_member_rtwallet_record->setCdate(date('Y-m-d H:i:s'));
            $gg_member_rtwallet_record->save();

            $dist->setRtwallet($bal);
            $dist->save();
        }

        print_r("done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdatePairingCreatedDate_ORI()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_SUCCESS);
        $sssApplications = SssApplicationPeer::doSelect($c);

        /******************************/
        /*  store Pairing points
        /******************************/
        $totalCount = count($sssApplications);
        print_r("<br>".$totalCount);
        foreach ($sssApplications as $sssApplication) {
            $distributorDB = MlmDistributorPeer::retrieveByPK($sssApplication->getDistId());
            print_r("<br>".$totalCount--);
            $query = "UPDATE sss_dist_pairing_ledger SET created_on = '" .$sssApplication->getCreatedOn()."' WHERE remark LIKE '%".$distributorDB->getDistributorCode()."%' AND credit_actual = ".$sssApplication->getTotalAmountConvertedWithCp2cp3();
            //var_dump($query);
            //exit();
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $statement->executeQuery();
        }

        print_r("done");
        return sfView::HEADER_ONLY;
    }

    public function executeCorrectRwallet()
    {
        $query = "SELECT count(*),uid FROM gg_member_rwallet_record where action_type = 'SSS' group by uid
                having count(*) > 1";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //exit();
        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $distId = $arr['uid'];

            $c = new Criteria();
            $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_SUCCESS);
            $c->add(SssApplicationPeer::DIST_ID, $distId);
            $sssApplications = SssApplicationPeer::doSelect($c);

            $c = new Criteria();
            $c->add(GgMemberRwalletRecordPeer::UID, $distId);
            $c->add(GgMemberRwalletRecordPeer::ACTION_TYPE, "SSS");
            $ggMemberRwalletRecords = GgMemberRwalletRecordPeer::doSelect($c);

            $idx = 0;
            foreach ($sssApplications as $sssApplication) {
                $ggIdx = 0;
                foreach ($ggMemberRwalletRecords as $ggMemberRwalletRecord) {
                    if ($idx == $ggIdx) {
                        $ggMemberRwalletRecord->setAmount($sssApplication->getTotalShareConverted());
                        $ggMemberRwalletRecord->save();
                    }
                    $ggIdx++;
                }
                $idx++;
            }
            $this->updateRwallet($distId);
        }

        print_r("done");
        return sfView::HEADER_ONLY;
    }
    public function executeCorrectRwallet_ori()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_SUCCESS);
        $sssApplications = SssApplicationPeer::doSelect($c);

        /******************************/
        /*  store Pairing points
        /******************************/
        $totalCount = count($sssApplications);
        print_r("<br>".$totalCount);
        foreach ($sssApplications as $sssApplication) {
            print_r("<br>".$totalCount--);
            $distributorDB = MlmDistributorPeer::retrieveByPK($sssApplication->getDistId());
            $distId = $distributorDB->getDistributorId();
            $mt4Balance = $sssApplication->getMt4balance();
            // $roiRemainingMonth = $sssApplication->getRoiRemainingMonth();
            $roiArr = $this->getRoiInformation($sssApplication->getDistId(), $sssApplication->getMt4UserName());
            $roiRemainingMonth = 0;
            if ($roiArr == null) {
                continue;
            }
            var_dump($roiArr);
            if ($roiArr['idx'] <= 18) {
                $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
            } else {
                $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
            }
            $roiPercentage = $sssApplication->getRoiPercentage();

            $convertedCp2 = $sssApplication->getCp2Balance();
            $convertedCp3 = $sssApplication->getCp3Balance();

            $totalAmountConverted = $mt4Balance + ($mt4Balance * $roiRemainingMonth * $roiPercentage / 100);
            $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted + $convertedCp2 + $convertedCp3;
            $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

            $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
            $totalRshare = round($totalRshare);

            $sssApplication->setTotalShareConverted($totalRshare);
            $sssApplication->save();

            $c = new Criteria();
            $c->add(GgMemberRwalletRecordPeer::UID, $distId);
            $c->add(GgMemberRwalletRecordPeer::ACTION_TYPE, "SSS");
            $ggMemberRwalletRecord = GgMemberRwalletRecordPeer::doSelectOne($c);

            $ggMemberRwalletRecord->setAmount($totalRshare);
            $ggMemberRwalletRecord->save();

            print_r("<br>".$distributorDB->getDistributorId());
            $this->updateRwallet($distId);
        }

        print_r("done");
        return sfView::HEADER_ONLY;
    }
    public function executeReport()
    {
        print_r("Total: ".number_format($this->totalCountOfSss($this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo','')), 2));
        print_r("<br>Mt4: ".number_format($this->totalSumOfSss("mt4_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo','')), 2));
        print_r("<br>CP2: ".number_format($this->totalSumOfSss("cp2_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo','')), 2));
        print_r("<br>CP3: ".number_format($this->totalSumOfSss("cp3_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo','')), 2));
        print_r("<br>R-Share Converted: ".number_format($this->totalSumOfSss("total_share_converted", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo','')), 2));

        return sfView::HEADER_ONLY;
    }
    public function executeDailyBonus()
    {
        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        $fromAbfx = "N";
        try {
            $con->begin();

            print_r("Start<br>");
            $c = new Criteria();
            $c->add(MlmDailyBonusLogPeer::BONUS_TYPE, Globals::DAILY_BONUS_LOG_TYPE_DAILY_SSS);
            $c->addDescendingOrderByColumn(MlmDailyBonusLogPeer::BONUS_DATE);
            $mlmDailyBonusLogDB = MlmDailyBonusLogPeer::doSelectOne($c);
            print_r("Fetch Daily Bonus Log<br>");

            $dateUtil = new DateUtil();
            $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"));
            print_r("currentDate=".$currentDate."<br>");

            if ($mlmDailyBonusLogDB) {
                $bonusDate = $dateUtil->formatDate("Y-m-d", $mlmDailyBonusLogDB->getBonusDate());
                print_r("bonusDate=".$bonusDate."<br>");
                $level = 0;
                while ($level < 1) {
                    if ($bonusDate == $currentDate) {
                        print_r("break<br>");
                        break;
                    }

                    $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($bonusDate)));
                    print_r("level start :".$level."<br><br>");
                    $query = "SELECT distinct dist_id FROM sss_dist_pairing_ledger WHERE created_on >= '".$yesterday." 00:00:00' AND created_on < '".$bonusDate." 00:00:00'";
                    print_r("<br><br><br> :".$query."<br><br>");
                    $connection = Propel::getConnection();
                    $statement = $connection->prepareStatement($query);
                    $resultset = $statement->executeQuery();
                    $resultArray = array();
                    $count = 0;
                    while ($resultset->next()) {
                        $arr = $resultset->getRow();
                        $dist = MlmDistributorPeer::retrieveByPK($arr['dist_id']);

                        if (!$dist) {
                            continue;
                        }

                        $c = new Criteria();
                        $c->add(MlmDistPairingPeer::DIST_ID, $dist->getDistributorId());
                        $mlmDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                        if (!$mlmDistPairingDB)
                            continue;

                        $distId = $mlmDistPairingDB->getDistId();
                        $packageDB = MlmPackagePeer::retrieveByPK($dist->getRankId());

                        $flushLimit = $packageDB->getDailyMaxPairing();
                        $legFlushLimit = $packageDB->getDailyMaxPairing() * 10;
                        print_r("DistId ".$distId."<br>");
                        $leftBalance = $this->findPairingLedgersBonus($distId, Globals::PLACEMENT_LEFT, $bonusDate);
                        $rightBalance = $this->findPairingLedgersBonus($distId, Globals::PLACEMENT_RIGHT, $bonusDate);

                        if ($leftBalance > 0 && $rightBalance > 0) {
                            print_r("Start Calculate bonus:".$bonusDate."<br>");
                            // requery for paring ledger

                            // start paring bonus
                            //$distributorDB = MlmDistributorPeer::retrieveByPK($distId);
                            $pairingPercentage = $packageDB->getPairingBonus();
                            $dailyMaxPairing = $packageDB->getDailyMaxPairing();
                            if ($flushLimit != $dailyMaxPairing) {
                                $mlmDistPairingDB->setFlushLimit($dailyMaxPairing);
                                $mlmDistPairingDB->save();

                                $flushLimit = $dailyMaxPairing;
                                $legFlushLimit = $flushLimit * 10;
                            }

                            $minBalance = $leftBalance;
                            $leftPairedPoint = $leftBalance;
                            $rightPairedPoint = $rightBalance;
                            if ($rightBalance < $leftBalance) {
                                $minBalance = $rightBalance;
                            }
                            print_r("leftBalance ".$leftBalance."<br>");
                            print_r("rightBalance ".$rightBalance."<br>");
                            print_r("minBalance ".$minBalance."<br>");
                            if ($leftBalance > 0 && $rightBalance > 0) {
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_LEFT, $minBalance, "PAIRED (" . $bonusDate . ")");
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_RIGHT, $minBalance, "PAIRED (" . $bonusDate . ")");

                                $pairingBonusAmount = $minBalance * $pairingPercentage / 100;
                                print_r("pairingBonusAmount =".$pairingBonusAmount."<br>");
                                $flushAmount = 0;
                                if ($pairingBonusAmount > $flushLimit) {
                                    $flushAmount = $pairingBonusAmount - $flushLimit;
                                }

                                /******************************/
                                /*  Commission
                                /******************************/
                                $c = new Criteria();
                                $c->add(MlmDistCommissionPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB_SSS);
                                $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                                $commissionBalance = 0;
                                if (!$sponsorDistCommissionDB) {
                                    $sponsorDistCommissionDB = new MlmDistCommission();
                                    $sponsorDistCommissionDB->setDistId($distId);
                                    $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_GDB_SSS);
                                    $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                } else {
                                    $commissionBalance = $sponsorDistCommissionDB->getBalance();
                                }
                                $sponsorDistCommissionDB->setBalance($commissionBalance + $pairingBonusAmount);
                                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionDB->save();

                                $c = new Criteria();
                                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB_SSS);
                                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                                $gdbBalance = 0;
                                if ($sponsorDistCommissionLedgerDB)
                                    $gdbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                                /******************************/
                                /*  Account
                                /******************************/
                                $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_RT);

                                // pairing amount
                                $ecashBalance = $distAccountEcashBalance + $pairingBonusAmount;
                                /*$mlm_account_ledger = new MlmAccountLedger();
                                $mlm_account_ledger->setDistId($distId);
                                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RT);
                                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB_SSS);
                                $mlm_account_ledger->setRemark("GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")");
                                $mlm_account_ledger->setCredit($pairingBonusAmount);
                                $mlm_account_ledger->setDebit(0);
                                $mlm_account_ledger->setBalance($ecashBalance);
                                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->save();

                                $this->mirroringAccountLedger($mlm_account_ledger, "75 SSS");*/

                                if ($dist && $dist->getCloseAccount() == "Y") {
                                    /*$mlm_account_ledger = new MlmAccountLedger();
                                    $mlm_account_ledger->setDistId($distId);
                                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RT);
                                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB_SSS);
                                    $mlm_account_ledger->setRemark("COMMISSION NOT ENTITLED DUE TO ACCOUNT CLOSED");
                                    $mlm_account_ledger->setCredit(0);
                                    $mlm_account_ledger->setDebit($pairingBonusAmount);
                                    $mlm_account_ledger->setBalance($ecashBalance - $pairingBonusAmount);
                                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->save();

                                    $this->mirroringAccountLedger($mlm_account_ledger, "76 SSS");*/
                                } else {
                                    //commission
                                    $commissionBalance = $gdbBalance + $pairingBonusAmount;

                                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                    $sponsorDistCommissionledger->setDistId($distId);
                                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB_SSS);
                                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                    $sponsorDistCommissionledger->setCredit($pairingBonusAmount);
                                    $sponsorDistCommissionledger->setDebit(0);
                                    $sponsorDistCommissionledger->setBalance($commissionBalance);
                                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                    $sponsorDistCommissionledger->setRemark("GROUP PAIRING AMOUNT (" . $bonusDate . ")");
                                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->save();

                                    // flush amount
                                    if ($flushAmount != 0) {
                                        $ecashBalance = $ecashBalance - $flushAmount;
                                        /*$mlm_account_ledger = new MlmAccountLedger();
                                        $mlm_account_ledger->setDistId($distId);
                                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RT);
                                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB_SSS);
                                        $mlm_account_ledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                        $mlm_account_ledger->setCredit(0);
                                        $mlm_account_ledger->setDebit($flushAmount);
                                        $mlm_account_ledger->setBalance($ecashBalance);
                                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                        $mlm_account_ledger->save();

                                        $this->mirroringAccountLedger($mlm_account_ledger, "77 SSS");*/

                                        $commissionBalance = $commissionBalance - $flushAmount;
                                        $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                        $sponsorDistCommissionledger->setDistId($distId);
                                        $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB_SSS);
                                        $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                        $sponsorDistCommissionledger->setCredit(0);
                                        $sponsorDistCommissionledger->setDebit($flushAmount);
                                        $sponsorDistCommissionledger->setBalance($commissionBalance);
                                        $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                        $sponsorDistCommissionledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                        $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                        $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                        $sponsorDistCommissionledger->save();

                                        $pairingBonusAmount = $pairingBonusAmount - $flushAmount;
                                    }
                                }

                                if ($dist && $dist->getCloseAccount() == "Y") {

                                } else {
                                    $tbl_account_ledger2 = new MlmAccountLedger();
                                    $tbl_account_ledger2->setAccountType(Globals::ACCOUNT_TYPE_RT);
                                    $tbl_account_ledger2->setDistId($distId);
                                    $tbl_account_ledger2->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB_SSS);
                                    $tbl_account_ledger2->setCredit($pairingBonusAmount);
                                    $tbl_account_ledger2->setDebit(0);
                                    $tbl_account_ledger2->setRemark("GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")");
                                    $tbl_account_ledger2->setBalance($ecashBalance);
                                    $tbl_account_ledger2->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $tbl_account_ledger2->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $tbl_account_ledger2->save();

                                    $dist = MlmDistributorPeer::retrieveByPk($distId);
                                    $bal = $dist->getRtwallet() + $pairingBonusAmount;
                                    $gg_member_rtwallet_record = new GgMemberRtwalletRecord();
                                    $gg_member_rtwallet_record->setUid($distId);
                                    $gg_member_rtwallet_record->setActionType('GDB SSS from Maxim');
                                    $gg_member_rtwallet_record->setType('c');
                                    $gg_member_rtwallet_record->setAmount($pairingBonusAmount);
                                    $gg_member_rtwallet_record->setBal($bal);
                                    $gg_member_rtwallet_record->setDescr("GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")");
                                    $gg_member_rtwallet_record->setCdate(date('Y-m-d H:i:s'));
                                    $gg_member_rtwallet_record->save();

                                    $dist->setRtwallet($bal);
                                    $dist->save();

                                    $this->mirroringAccountLedger($tbl_account_ledger2, "65 SSS");
                                }
                            }
                        }
                    }

                    $bonusDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate($bonusDate, 1, 0, 0));
                    $mlm_daily_bonus_log = new MlmDailyBonusLog();
                    $mlm_daily_bonus_log->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                    $mlm_daily_bonus_log->setBonusType(Globals::DAILY_BONUS_LOG_TYPE_DAILY_SSS);
                    $mlm_daily_bonus_log->setBonusDate($bonusDate);
                    $mlm_daily_bonus_log->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_daily_bonus_log->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_daily_bonus_log->save();
                    $level++;
                }

                $subject = "SSS bonusDate=".$bonusDate."::".$this->getRequestParameter('q');
                $body = "SSS bonusDate=".$bonusDate."::".$this->getRequestParameter('q');
                $sendMailService = new SendMailService();
                $sendMailService->sendMailReport("r9jason@gmail.com", "jason", $subject, $body, Mails::EMAIL_SENDER);
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeCorrectRoi()
    {
        $query = "SELECT count(*), mt4_user_name, idx, dist_id FROM mlm_roi_dividend
            group by mt4_user_name, idx, dist_id having count(*) > 1";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $arr['mt4_user_name']);
            $c->add(MlmRoiDividendPeer::IDX, $arr['idx']);
            $c->add(MlmRoiDividendPeer::DIST_ID, $arr['dist_id']);
            $mlmRoiDividend = MlmRoiDividendPeer::doSelectOne($c);

            if ($mlmRoiDividend) {
                print_r("<br>".$arr['mt4_user_name']);
                $mlmRoiDividend->delete();
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoTestDisabledMt4()
    {
        $mt4request = new CMT4DataReciver;
        $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

        $mt4Id = "6000113";

        $params['array'] = array();
        $params['login'] = $mt4Id;
        var_dump($params);
        $answer = $mt4request->MakeRequest("getaccountinfo", $params);
        var_dump($answer);
        print_r("<br><br>");
        if ($answer['result'] != 1) {
            var_dump("<br>error:".$answer["reason"]);
            return sfView::HEADER_ONLY;
        } else {
            $comment = $answer["comment"];
            if ($comment != "") {
                $comment .= ";";
            }
            $comment = $comment . "20150528: Disabled (SSS)";
            $params['comment'] = $comment;
            $params['enable'] = "0";  // 1 = enabled, 0 = disabled
            $answer = $mt4request->MakeRequest("modifyaccount", $params);
            //print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$packagePrice.".</p>";
            if ($answer['result'] != 1) {
                var_dump("<br>error:".$answer["reason"]);
                return sfView::HEADER_ONLY;
            } else {

            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoDisabledMt4AndCheckForMaturity()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_PENDING);
        $c->setLimit(30);
        $sssApplications = SssApplicationPeer::doSelect($c);

        foreach ($sssApplications as $sssApplication) {
            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();
                $mt4Id = $sssApplication->getMt4UserName();

                $array = explode(',', Globals::STATUS_MATURITY_PENDING.",".Globals::STATUS_MATURITY_CLIENT_WITHDRAW.",".Globals::STATUS_MATURITY_WITHDRAW.",".Globals::STATUS_MATURITY_ON_HOLD);

                $c = new Criteria();
                $c->add(NotificationOfMaturityPeer::MT4_USER_NAME, $mt4Id);
                $c->add(NotificationOfMaturityPeer::STATUS_CODE, $array, Criteria::IN);
                $notificationOfMaturity = NotificationOfMaturityPeer::doSelectOne($c);

                if ($notificationOfMaturity) {
                    $notificationStatus = $notificationOfMaturity->getStatusCode();
                    $notificationOfMaturity->setInternalRemark("STATUS: ".$notificationStatus);
                    $notificationOfMaturity->setStatusCode("SSS");
                    $notificationOfMaturity->save();

                    if ($notificationStatus == Globals::STATUS_MATURITY_WITHDRAW) {
                        $remark = $sssApplication->getRemarks();
                        if ($remark != ""){
                            $remark .= "; ";
                        }
                        $remark .= date('Y-m-d H:i:s') .": Notification of Maturity already withdrawn.";
                        $sssApplication->setRemarks($remark);
                        $sssApplication->setStatusCode(Globals::STATUS_SSS_ERROR);
                        $sssApplication->save();
                    }
                }

                // disabled MT4
                $mt4request = new CMT4DataReciver;
                $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

                $params['array'] = array();
                $params['login'] = $mt4Id;
                var_dump($params);
                $answer = $mt4request->MakeRequest("getaccountinfo", $params);
                var_dump($answer);
                print_r("<br><br>");
                if ($answer['result'] != 1) {
                    var_dump("<br>error:".$answer["reason"]);
                    //return sfView::HEADER_ONLY;
                    $remark = $sssApplication->getRemarks();
                    if ($remark != ""){
                        $remark .= "; ";
                    }
                    //$remark .= date('Y-m-d H:i:s') .": MT4 Account not exist.";
                    $sssApplication->setRemarks($remark);
                    //$sssApplication->setStatusCode("ERROR");
                    $sssApplication->save();
                } else {
                    $comment = $answer["comment"];
                    $mt4Enable = $answer["enable"];
                    $mt4Balance = $answer["balance"];
                    if ($comment != "") {
                        $comment .= ";";
                    }
                    if ($mt4Enable == "1") {
                        $comment = $comment . date('Y-m-d H:i:s').": Disabled (SSS)";
                        $params['comment'] = $comment;
                        $params['enable'] = "0";  // 1 = enabled, 0 = disabled
                        $answer = $mt4request->MakeRequest("modifyaccount", $params);
                        //print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$packagePrice.".</p>";
                        if ($answer['result'] != 1) {
                            var_dump("<br>error:".$answer["reason"]);
                            $remark = $sssApplication->getRemarks();
                            if ($remark != ""){
                                $remark .= "; ";
                            }
                            $remark .= date('Y-m-d H:i:s') .": MT4 Account cannot be disabled.";
                            $sssApplication->setRemarks($remark);
                            $sssApplication->setStatusCode(Globals::STATUS_SSS_ERROR);
                            $sssApplication->save();
                        } else {
                            $sssApplication->setMt4Balance($mt4Balance);
                            if ($sssApplication->getSwapType() == "SES") {
                                $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);

                                $pairingBonusAmount = $sssApplication->getTotalShareConverted();
                                $ecashBalance = $this->getAccountBalance($sssApplication->getDistId(), Globals::ACCOUNT_TYPE_RT);

                                $tbl_account_ledger2 = new MlmAccountLedger();
                                $tbl_account_ledger2->setAccountType(Globals::ACCOUNT_TYPE_RT);
                                $tbl_account_ledger2->setDistId($sssApplication->getDistId());
                                $tbl_account_ledger2->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SWAP_SSS);
                                $tbl_account_ledger2->setCredit($pairingBonusAmount);
                                $tbl_account_ledger2->setDebit(0);
                                $tbl_account_ledger2->setRemark("");
                                $tbl_account_ledger2->setBalance($ecashBalance + $pairingBonusAmount);
                                $tbl_account_ledger2->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $tbl_account_ledger2->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $tbl_account_ledger2->save();

                                $dist = MlmDistributorPeer::retrieveByPk($sssApplication->getDistId());

                                $bal = $dist->getRtwallet() + $pairingBonusAmount;
                                $gg_member_rtwallet_record = new GgMemberRtwalletRecord();
                                $gg_member_rtwallet_record->setUid($sssApplication->getDistId());
                                $gg_member_rtwallet_record->setActionType('SWAP SES from Maxim');
                                $gg_member_rtwallet_record->setType('c');
                                $gg_member_rtwallet_record->setAmount($pairingBonusAmount);
                                $gg_member_rtwallet_record->setBal($bal);
                                $gg_member_rtwallet_record->setDescr("");
                                $gg_member_rtwallet_record->setCdate(date('Y-m-d H:i:s'));
                                $gg_member_rtwallet_record->save();

                                $dist->setRtwallet($bal);
                                $dist->save();
                            } else {
                                $sssApplication->setStatusCode(Globals::STATUS_SSS_PAIRING);
                            }
                            $sssApplication->save();
                        }
                    } else {
                        $remark = $sssApplication->getRemarks();
                        if ($remark != ""){
                            $remark .= "; ";
                        }
                        $remark .= date('Y-m-d H:i:s') .": MT4 Account disabled.";
                        $sssApplication->setRemarks($remark);
                        $sssApplication->setStatusCode(Globals::STATUS_SSS_ERROR);
                        $sssApplication->save();
                    }
                }

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoGeneratePairingPoint()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_PAIRING);
        $c->setLimit(30);
        $sssApplications = SssApplicationPeer::doSelect($c);

        /******************************/
        /*  store Pairing points
        /******************************/
        print_r("<br>".count($sssApplications));
        foreach ($sssApplications as $sssApplication) {
            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();
                $distributorDB = MlmDistributorPeer::retrieveByPK($sssApplication->getDistId());
                $mt4Balance = $sssApplication->getMt4balance();
                // $roiRemainingMonth = $sssApplication->getRoiRemainingMonth();
                $roiArr = $this->getRoiInformation($sssApplication->getDistId(), $sssApplication->getMt4UserName());
                $roiRemainingMonth = 0;
                if ($roiArr == null) {
                    continue;
                }
                $entitledPairing = true;
                if ($roiArr['idx'] <= 18) {
                    $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
                } else {
                    $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
                }
                if ($roiArr['idx'] <= 12) {
                    $entitledPairing = false;
                }
                $roiPercentage = $sssApplication->getRoiPercentage();

                $convertedCp2 = $sssApplication->getCp2Balance();
                $convertedCp3 = $sssApplication->getCp3Balance();

                $totalAmountConverted = $mt4Balance + ($mt4Balance * $roiRemainingMonth * $roiPercentage / 100);
                $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted + $convertedCp2 + $convertedCp3;
                $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

                $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
                $totalRshare = round($totalRshare);

                $totalAmountConvertedWithCp2Cp3 = $sssApplication->getTotalShareConverted() * $sssApplication->getShareValue();

                $sssApplication->setTotalShareConverted($totalRshare);
                $sssApplication->setTotalAmountConvertedWithCp2cp3($totalAmountConvertedWithCp2Cp3);
                $sssApplication->save();

                $mlm_distributor = $distributorDB;
                $uplinePosition = $mlm_distributor->getPlacementPosition();
                $pairingPoint = $totalAmountConvertedWithCp2Cp3 * Globals::PAIRING_POINT_BV;
                $pairingPointActual = $totalAmountConvertedWithCp2Cp3;

                print_r("<br>".$distributorDB->getDistributorId());

                if ($entitledPairing == false) {
                    $pairingPointActual = $mt4Balance + $convertedCp2 + $convertedCp3;
                    $pairingPoint = $pairingPointActual * Globals::PAIRING_POINT_BV;
                }
                if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
                    while ($level < 400) {
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
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                return $this->redirect('/offerToSwapRshare/index');
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
                        $c->add(SssDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                        $c->add(SssDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                        $c->addDescendingOrderByColumn(SssDistPairingLedgerPeer::CREATED_ON);
                        $sponsorDistPairingLedgerDB = SssDistPairingLedgerPeer::doSelectOne($c);

                        $legBalance = 0;
                        if ($sponsorDistPairingLedgerDB) {
                            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                        }

                        //if ($uplineDistDB->getRankId() > 0) {
                        $sponsorDistPairingledger = new SssDistPairingLedger();
                        $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                        $sponsorDistPairingledger->setLeftRight($uplinePosition);
                        $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                        $sponsorDistPairingledger->setCredit($pairingPoint);
                        $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                        $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->save();
                        //}

                        if ($uplineDistDB->getDistributorId() == 254837) {
                            // 340121	LV2015-A
                            // 340122	LV2015-B
                            // 346119	LV2015-C
                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340121);
                            $sponsorDistPairingledger->setLeftRight("LEFT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #AA5168");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340122);
                            $sponsorDistPairingledger->setLeftRight("LEFT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #AA5168");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(346119);
                            $sponsorDistPairingledger->setLeftRight("LEFT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #AA5168");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();
                        } else if ($uplineDistDB->getDistributorId() == 274048) {
                            // 340121	LV2015-A
                            // 340122	LV2015-B
                            // 346121	LV2015-D
                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340121);
                            $sponsorDistPairingledger->setLeftRight("RIGHT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #gyps0123");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340122);
                            $sponsorDistPairingledger->setLeftRight("RIGHT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #gyps0123");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(346121);
                            $sponsorDistPairingledger->setLeftRight("RIGHT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #gyps0123");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();
                        }

                        if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                            break;
                        }

                        $uplinePosition = $uplineDistDB->getPlacementPosition();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                        $level++;
                    }
                    // **tips worlspeace sales link kashventure and eesiang01
                    // **tips 558 kashventure
                    // **tips kashventure sales entitled for  after 124	MaxProLtd1 to 132	MaxProLtd6   & worldpeace
                    $pos = strrpos($mlm_distributor->getPlacementTreeStructure(), "|558|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        // **tips 879 eesiang01 :: worldpeace downline eesiang01 not maxproltd6 but for chris5 (globalchina)
                        /*$pos2 = strrpos($mlm_distributor->getPlacementTreeStructure(), "|879|");
                      if ($pos2 === false) { // note: three equal signs

                      } else {*/
                        $level = 0;
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk(557);
                        $uplinePosition = Globals::PLACEMENT_LEFT;
                        $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();

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
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                return $this->redirect('/offerToSwapRshare/index');
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
                        $c->add(SssDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                        $c->add(SssDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                        $c->addDescendingOrderByColumn(SssDistPairingLedgerPeer::CREATED_ON);
                        $sponsorDistPairingLedgerDB = SssDistPairingLedgerPeer::doSelectOne($c);

                        $legBalance = 0;
                        if ($sponsorDistPairingLedgerDB) {
                            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                        }

                        $sponsorDistPairingledger = new SssDistPairingLedger();
                        $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                        $sponsorDistPairingledger->setLeftRight($uplinePosition);
                        $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                        $sponsorDistPairingledger->setCredit($pairingPoint);
                        $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") [kashventure]");
                        $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->save();
                        //}
                    }
                }

                /*$c = new Criteria();
                $c->addDescendingOrderByColumn(GgMemberRwalletRecordPeer::CDATE);
                $ggMemberRwalletRecordDB = GgMemberRwalletRecordPeer::doSelectOne($c);*/

                $rwalletBalance = $distributorDB->getRwallet();
                /*if ($ggMemberRwalletRecordDB) {
                    $rwalletBalance = $ggMemberRwalletRecordDB->getBal();
                }*/
                $rwalletBalance = $rwalletBalance + $totalRshare;
                // credited S4
                $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                $ggMemberRwalletRecord->setUid($sssApplication->getDistId());
                $ggMemberRwalletRecord->setAid(0);
                $ggMemberRwalletRecord->setActionType("SSS");
                $ggMemberRwalletRecord->setType("credit");
                $ggMemberRwalletRecord->setAmount($totalRshare);
                $ggMemberRwalletRecord->setBal($rwalletBalance);
                $ggMemberRwalletRecord->setDescr("Super Share Swap");
                $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                $ggMemberRwalletRecord->save();

                if ($distributorDB) {
                    $distributorDB->setRwallet($rwalletBalance);
                    $distributorDB->save();
                }

                $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);
                $sssApplication->save();

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeList()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->sssApplications = SssApplicationPeer::doSelect($c);
    }
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

        $page = $this->getRequestParameter('q','');
        if ($page == "ses") {
            $this->setTemplate("ses");
        }
    }

    public function executeConfirmation()
    {
        $this->distributorDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->mt4Id = $this->getRequestParameter('mt4Id');

        if (!$this->mt4Id) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err804:Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }
        $this->mt4Ids = $this->getFetchMt4List($this->getUser()->getAttribute(Globals::SESSION_DISTID), $this->getRequestParameter('mt4Id'));
        $this->mt4Balance = 0;
        $this->remainingRoiAmount = 0;

        $mt4UserName = $this->getRequestParameter('mt4Id');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        if (count($this->mt4Ids) <= 0) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err805:Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }

        $mt4Balance = $this->getMt4Balance($distId, $mt4UserName);
        $roiArr = $this->getRoiInformation($distId, $mt4UserName);

        $roiPercentage = $roiArr['roi_percentage'];
        $roiRemainingMonth = 0;

        if ($roiArr['idx'] <= 18) {
            $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
        } else {
            $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
        }
        /*if ($roiRemainingMonth >= 10) {
            $roiPercentage = 0;
        }*/
        $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

        $this->swapToRt = $this->getRequestParameter('swapToRt');
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
        if ($this->swapToRt == "Y") {
            $totalRshare = $totalAmountConvertedWithCp2Cp3;
        }

        $this->totalRshare = round($totalRshare);

        $this->signature = $this->getRequestParameter('txtSignature');

        if ($this->swapToRt == "Y") {
            $this->setTemplate("sesConfirmation");
        }
    }

    public function executeDoSave()
    {
        $this->distributorDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->mt4Id = $this->getRequestParameter('mt4Id');

        if (!$this->mt4Id) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err801:Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }
        $this->mt4Ids = $this->getFetchMt4List($this->getUser()->getAttribute(Globals::SESSION_DISTID), $this->getRequestParameter('mt4Id'));
        $this->mt4Balance = 0;
        $this->remainingRoiAmount = 0;

        $mt4UserName = $this->getRequestParameter('mt4Id');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        if (count($this->mt4Ids) <= 0) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err802:Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }

        $mt4Balance = $this->getMt4Balance($distId, $mt4UserName);
//        $mt4Balance = 5000;
        $roiArr = $this->getRoiInformation($distId, $mt4UserName);

        if ($mt4Balance == null) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err803:Invalid Action."));
            return $this->redirect('/offerToSwapRshare/index');
        }

        $roiPercentage = $roiArr['roi_percentage'];
        $roiRemainingMonth = 0;
        if ($roiArr['idx'] <= 18) {
            $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
        } else {
            $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
        }
        $remarks = "";
        /*if ($roiRemainingMonth >= 10) {
            $remarks = "ROI:".$roiPercentage."%";
            $roiPercentage = 0;
        }*/
        $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

        $this->swapToRt = $this->getRequestParameter('swapToRt');
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
        if ($this->swapToRt == "Y") {
            $roiRemainingMonth = 0;
        }
        $totalAmountConverted = $mt4Balance + ($mt4Balance * $roiRemainingMonth * $roiPercentage / 100);
        $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted + $this->convertedCp2 + $this->convertedCp3;
        $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

        $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
        if ($this->swapToRt == "Y") {
            $totalRshare = $totalAmountConvertedWithCp2Cp3;
        }
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
            $sss_application->setRemarks($remarks);
            $sss_application->setSignature($this->signature);
            $sss_application->setStatusCode(Globals::STATUS_SSS_PENDING);
            if ($this->swapToRt == "Y") {
                $sss_application->setSwapType("SES");
            }
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
                if ($this->swapToRt == "Y") {
                    $tbl_account_ledger->setRefererType("SES");
                    $tbl_account_ledger->setTransactionType("SES");
                    $tbl_account_ledger->setRemark("SUPER E-SHARE SWAP");
                }
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
                if ($this->swapToRt == "Y") {
                    $tbl_account_ledger->setRefererType("SES");
                    $tbl_account_ledger->setTransactionType("SES");
                    $tbl_account_ledger->setRemark("SUPER E-SHARE SWAP");
                }
                $tbl_account_ledger->save();
            }

            $roiStatus = "SSS";
            if ($this->swapToRt == "Y") {
                $roiStatus = "SES";
            }

            $query = "UPDATE mlm_roi_dividend SET status_code = '".$roiStatus."', updated_on = ?, updated_by = ?  WHERE status_code = 'PENDING' AND dist_id = " . $distId;
            $query = $query . " AND mt4_user_name = ?";
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $statement->set(1, date('Y-m-d H:i:s'));
            $statement->set(2, $this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $statement->set(3, $mt4UserName);
            $statement->executeUpdate();

            /******************************/
            /*  store Pairing points
            /******************************/
            $skipThis = true;
            if ($skipThis == false) {
                $mlm_distributor = $this->distributorDB;
                $uplinePosition = $mlm_distributor->getPlacementPosition();
                $pairingPoint = $totalAmountConvertedWithCp2Cp3 * Globals::PAIRING_POINT_BV;
                $pairingPointActual = $totalAmountConvertedWithCp2Cp3;

                if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
                    while ($level < 400) {
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
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                return $this->redirect('/offerToSwapRshare/index');
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
                        $c->add(SssDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                        $c->add(SssDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                        $c->addDescendingOrderByColumn(SssDistPairingLedgerPeer::CREATED_ON);
                        $sponsorDistPairingLedgerDB = SssDistPairingLedgerPeer::doSelectOne($c);

                        $legBalance = 0;
                        if ($sponsorDistPairingLedgerDB) {
                            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                        }

                        //if ($uplineDistDB->getRankId() > 0) {
                        $sponsorDistPairingledger = new SssDistPairingLedger();
                        $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                        $sponsorDistPairingledger->setLeftRight($uplinePosition);
                        $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                        $sponsorDistPairingledger->setCredit($pairingPoint);
                        $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                        $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->save();
                        //}

                        if ($uplineDistDB->getDistributorId() == 254837) {
                            // 340121	LV2015-A
                            // 340122	LV2015-B
                            // 346119	LV2015-C
                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340121);
                            $sponsorDistPairingledger->setLeftRight("LEFT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #AA5168");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340122);
                            $sponsorDistPairingledger->setLeftRight("LEFT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #AA5168");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(346119);
                            $sponsorDistPairingledger->setLeftRight("LEFT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #AA5168");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();
                        } else if ($uplineDistDB->getDistributorId() == 274048) {
                            // 340121	LV2015-A
                            // 340122	LV2015-B
                            // 346121	LV2015-D
                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340121);
                            $sponsorDistPairingledger->setLeftRight("RIGHT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #gyps0123");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(340122);
                            $sponsorDistPairingledger->setLeftRight("RIGHT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #gyps0123");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();

                            $sponsorDistPairingledger = new SssDistPairingLedger();
                            $sponsorDistPairingledger->setDistId(346121);
                            $sponsorDistPairingledger->setLeftRight("RIGHT");
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($pairingPoint);
                            $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($pairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") #gyps0123");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();
                        }

                        if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                            break;
                        }

                        $uplinePosition = $uplineDistDB->getPlacementPosition();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                        $level++;
                    }
                    // **tips worlspeace sales link kashventure and eesiang01
                    // **tips 558 kashventure
                    // **tips kashventure sales entitled for  after 124	MaxProLtd1 to 132	MaxProLtd6   & worldpeace
                    $pos = strrpos($mlm_distributor->getPlacementTreeStructure(), "|558|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        // **tips 879 eesiang01 :: worldpeace downline eesiang01 not maxproltd6 but for chris5 (globalchina)
                        /*$pos2 = strrpos($mlm_distributor->getPlacementTreeStructure(), "|879|");
                      if ($pos2 === false) { // note: three equal signs

                      } else {*/
                        $level = 0;
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk(557);
                        $uplinePosition = Globals::PLACEMENT_LEFT;
                        $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();

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
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                return $this->redirect('/offerToSwapRshare/index');
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
                        $c->add(SssDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                        $c->add(SssDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                        $c->addDescendingOrderByColumn(SssDistPairingLedgerPeer::CREATED_ON);
                        $sponsorDistPairingLedgerDB = SssDistPairingLedgerPeer::doSelectOne($c);

                        $legBalance = 0;
                        if ($sponsorDistPairingLedgerDB) {
                            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                        }

                        $sponsorDistPairingledger = new SssDistPairingLedger();
                        $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                        $sponsorDistPairingledger->setLeftRight($uplinePosition);
                        $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                        $sponsorDistPairingledger->setCredit($pairingPoint);
                        $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") [kashventure]");
                        $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->save();
                        //}
                    }
                }
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your application has been submitted and pending for approval."));
        if ($this->swapToRt == "Y") {
            return $this->redirect('/offerToSwapRshare/index?q=ses');
        }
        return $this->redirect('/offerToSwapRshare/index');
    }

    public function executeSwapNote()
    {
    }
    public function executeMemberList()
    {
    }
    public function executeDownlineMemberList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $sColumns = " distinct ".$sColumns;

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = " FROM mlm_roi_dividend roi
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = roi.dist_id   ";

        /******   total records  *******/
        $sWhere = "  WHERE roi.status_code = 'PENDING' AND dist.leader_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        /******   total filtered records  *******/

        $totalRecords = $this->getTotalRecordsFromRoiTable($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalFilteredRecords = $totalRecords;

        /******   sorting  *******/
        $sOrder = "ORDER BY ";
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] . "
                    " . mysql_real_escape_string($this->getRequestParameter('sSortDir_' . $i)) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") {
            $sOrder = "";
        }

        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

//        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $remark = $resultArr['remark'];

            $arr[] = array(
                $resultArr['dist_id'] == null ? "" : $resultArr['dist_id'],
                $resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['contact'] == null ? "" : $resultArr['contact'],
                $resultArr['email'] == null ? "" : $resultArr['email']
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    function getFetchMt4List($distId, $mt4UserName)
    {
        // FROM mlm_roi_dividend WHERE idx > 0 and idx <= 18 AND status_code = 'PENDING'
        $query = "SELECT distinct dist_id, mt4_user_name
	        FROM mlm_roi_dividend WHERE idx > 0 AND status_code = 'PENDING'
	        AND dist_id = " . $distId ;


        if ($mt4UserName != "") {
            $query = $query . " AND mt4_user_name = ?";
        }

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        if ($mt4UserName != "") {
            $statement->set(1, $mt4UserName);
        }
        $resultset = $statement->executeQuery();
        //var_dump($query);
        //exit();
        $arr = array();
        while ($resultset->next()) {
            $arrResult = $resultset->getRow();

            /*$c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $arrResult['mt4_user_name']);
            $c->add(MlmRoiDividendPeer::IDX, 9);
            $c->add(MlmRoiDividendPeer::STATUS_CODE, "SUCCESS");
            $existRoi = MlmRoiDividendPeer::doSelectOne($c);*/

            //var_dump($existRoi);
            //exit();
            /*if (!$existRoi) {
                continue;
            }*/

            $arr[] = $arrResult['mt4_user_name'];
        }
        return $arr;
    }

    function getRoiInformation($distId, $mt4UserName)
    {
        $query = "SELECT devidend_id, dist_id, mt4_user_name, idx, account_ledger_id, dividend_date, package_id, package_price, roi_percentage, mt4_balance, dividend_amount, remarks, exceed_dist_id, exceed_roi_percentage, exceed_dividend_amount, status_code, created_by, created_on, updated_by, updated_on, first_dividend_date
	                FROM mlm_roi_dividend WHERE mt4_user_name = ? AND status_code IN ('PENDING','SSS') AND dist_id = ? ORDER BY idx limit 1 ";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $mt4UserName);
        $statement->set(2, $distId);
        $resultset = $statement->executeQuery();
        //exit();
        $arr = null;
        if ($resultset->next()) {
            $arr = array();
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
            $roiRemainingMonth = 0;
            if ($roiArr['idx'] <= 18) {
                $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
            } else {
                $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
            }
            /*if ($roiRemainingMonth >= 10) {
                $roiPercentage = 0;
            }*/
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

    function getTotalRecordsFromRoiTable($distId)
    {
        $query = "SELECT count(*) AS _TOTAL FROM
        (
        SELECT distinct roi.dist_id, roi.mt4_user_name, dist.full_name, dist.contact, dist.email
            FROM mlm_roi_dividend roi
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = roi.dist_id
        WHERE roi.status_code = 'PENDING' AND dist.leader_id = ".$distId."
            ) roi_table";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $count = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["_TOTAL"] != null) {
                $count = $arr["_TOTAL"];
            } else {
                $count = 0;
            }
        }
        return $count;
    }
    function totalCountOfSss($dateFrom, $dateTo)
    {
        $query = "SELECT count(*) as _TOTAL FROM sss_application WHERE status_code not IN ('REJECTED','ERROR')";

        if ($dateFrom != null) {
            $query .= " AND created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != null) {
            $query .= " AND created_on <= '".$dateTo." 23:59:59'";
        }

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $count = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["_TOTAL"] != null) {
                $count = $arr["_TOTAL"];
            } else {
                $count = 0;
            }
        }
        return $count;
    }
    function totalSumOfSss($fieldName, $dateFrom, $dateTo)
    {
        $query = "SELECT SUM(".$fieldName.") as _TOTAL FROM sss_application WHERE status_code not IN ('REJECTED','ERROR')";

        if ($dateFrom != null) {
            $query .= " AND created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != null) {
            $query .= " AND created_on <= '".$dateTo." 23:59:59'";
        }

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $count = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["_TOTAL"] != null) {
                $count = $arr["_TOTAL"];
            } else {
                $count = 0;
            }
        }
        return $count;
    }

    function isSssGdbIssue($distId, $currentDate)
    {
        $query = "SELECT count(account_id) as _COUNT
          	FROM mlm_account_ledger WHERE dist_id = ".$distId.
                 " AND transaction_type = 'GDB' AND created_on > '".$currentDate." 00:00:00'";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //exit();
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr['_COUNT'] > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    function queryPairedDistributor($distId, $currentDate)
    {
        $query = "SELECT count(account_id) as _COUNT
          	FROM mlm_account_ledger WHERE dist_id = ".$distId.
                 " AND transaction_type = 'GDB' AND created_on > '".$currentDate." 00:00:00'";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //exit();
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr['_COUNT'] > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    function updateRwallet($distId)
    {
        $c = new Criteria();
        $c->add(GgMemberRwalletRecordPeer::UID, $distId);
        $c->addAscendingOrderByColumn(GgMemberRwalletRecordPeer::CDATE);
        $ggMemberRwalletRecords = GgMemberRwalletRecordPeer::doSelect($c);

        $balance = 0;
        foreach ($ggMemberRwalletRecords as $ggMemberRwalletRecord) {
            print_r("======================================================");
            print_r("dist code=".$distId);
            print_r("<br>");
            //var_dump($ggMemberRwalletRecord);
            if ($ggMemberRwalletRecord->getType() == "c" || $ggMemberRwalletRecord->getType() == "credit") {
                $balance = $balance + $ggMemberRwalletRecord->getAmount();
            } else if ($ggMemberRwalletRecord->getType() == "debit") {
                $balance = $balance - $ggMemberRwalletRecord->getAmount();
            }
            $ggMemberRwalletRecord->setBal($balance);
            $ggMemberRwalletRecord->save();
            print_r("balance=".$balance);
            print_r("<br>");
        }
        $distributorDB = MlmDistributorPeer::retrieveByPK($distId);
        $distributorDB->setRwallet($balance);
        $distributorDB->save();

        return sfView::HEADER_ONLY;
    }

    function findPairingLedgersBonus($distributorId, $position, $date)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        //var_dump($yesterday);
        //exit();
        $totalCredit = $this->getPairingSumCredit($distributorId, $position, $yesterday);
        $totalDebit = $this->getPairingSumDebit($distributorId, $position, null);

        if ($totalCredit > $totalDebit) {
            return $totalCredit - $totalDebit;
        } else {
            return 0;
        }
    }

    function getPairingSumCredit($distributorId, $position, $date)
    {
        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM sss_dist_pairing_ledger WHERE dist_id = ? "
                 . " AND left_right = ?";

        if ($date != null) {
            $query .= " AND created_on <= ?";
        }

        //var_dump($query."<br>");
        //var_dump($date."<br><br>");
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $distributorId);
        $statement->set(2, $position);

        if ($date != null) {
            $statement->set(3, $date . " 23:59:59");
        }
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

    function getPairingSumDebit($distributorId, $position, $date)
    {
        $query = "SELECT SUM(debit) AS SUB_TOTAL FROM sss_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'";

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
    
    function updateDistPairingLeader($distId, $position, $debit, $remark="PAIRED", $transactionType=Globals::PAIRING_LEDGER_PAIRED)
    {
        $legBalance = $this->findPairingLedgers($distId, $position, null);
        // update pairing balance
        $distPairingledger = new SssDistPairingLedger();
        $distPairingledger->setDistId($distId);
        $distPairingledger->setLeftRight($position);
        $distPairingledger->setTransactionType($transactionType);
        $distPairingledger->setCredit(0);
        $distPairingledger->setDebit($debit);
        $distPairingledger->setBalance($legBalance - $debit);
        $distPairingledger->setRemark($remark);
        $distPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->save();
    }
    
    function findPairingLedgers($distributorId, $position, $date, $pageDirection = "")
    {
        $tableName = "sss_dist_pairing_ledger";

        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM ".$tableName." WHERE dist_id = ? "
                 . " AND left_right = ?";

        if ($date != null) {
            $query .= " AND created_on <= ?";
        }
        //var_dump("<br><br>".$query);
        //var_dump("<br><br>".$date);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $distributorId);
        $statement->set(2, $position);

        if ($date != null) {
            $statement->set(3, $date . " 23:59:59");
        }
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
        $log_account_ledger->setRefererId($mlmAccountLedger->getRefererId());
        $log_account_ledger->setRefererType($mlmAccountLedger->getRefererType());
        $log_account_ledger->setCreatedBy($mlmAccountLedger->getCreatedBy());
        $log_account_ledger->setUpdatedBy($mlmAccountLedger->getUpdatedBy());
        $log_account_ledger->save();
    }

    function revalidateCommission($distributorId, $commissionType)
    {
        $balance = $this->getCommissionBalance($distributorId, $commissionType);

        $c = new Criteria();
        $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, $commissionType);
        $c->add(MlmDistCommissionPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistCommissionPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistCommission();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setCommissionType($commissionType);
            $tbl_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
    }

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
}