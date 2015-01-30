<?php

/**
 * business actions.
 *
 * @package    sf_sandbox
 * @subpackage business
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class businessActions extends sfActions
{
    public function executeDoCorrectRP()
    {
        $queryDate = "2014-11-30";
        $distArray = explode(',', "57");

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distArray, Criteria::IN);
        $mlmDistributors = MlmDistributorPeer::doSelect($c);

        foreach ($mlmDistributors as $distDB) {
            $totalRpCredit = $this->getAccountLedgerCreditBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RP, $queryDate);
            $totalRpDebit = $this->getAccountLedgerDebitBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RP, $queryDate);
            print_r("<br>".$distDB->getDistributorId());
            $c = new Criteria();
            $c->add(MlmAccountLedgerPeer::DIST_ID, $distDB->getDistributorId());
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, "RP");
            $c->add(MlmAccountLedgerPeer::TRANSACTION_TYPE, "CLOSING");
            $mlm_account_ledger = MlmAccountLedgerPeer::doSelectOne($c);

            if ($mlm_account_ledger) {
                $mlm_account_ledger->setCredit($totalRpCredit);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($totalRpCredit);
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                if ($totalRpDebit > 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($totalRpDebit);
                    $mlm_account_ledger->setBalance($totalRpCredit - $totalRpDebit);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoCorrectPairingPoint()
    {
        return sfView::HEADER_ONLY;
        $queryDate = "2014-11-30";
        $distArray = explode(',', "15,57,60,61,71,104,115,124,135,142,143,164,203,237,240,349,481,564,595,665,682,715,763,831,1077,1561,1797,1802,1982,2290,126269,254828,255019,255607,255709,256078,256205,256508,257749,260249,264845,265720,268743,270596,272708,273056,273166,276789,291665,295337,296707,296708,296709");

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distArray, Criteria::IN);
        $mlmDistributors = MlmDistributorPeer::doSelect($c);

        foreach ($mlmDistributors as $distDB) {
            $totalRpCredit = $this->getAccountLedgerCreditBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RP, $queryDate);
            $totalRpDebit = $this->getAccountLedgerDebitBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RP, $queryDate);
            print_r("<br>".$distDB->getDistributorId());
            $c = new Criteria();
            $c->add(MlmAccountLedgerPeer::DIST_ID, $distDB->getDistributorId());
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, "RP");
            $c->add(MlmAccountLedgerPeer::TRANSACTION_TYPE, "CLOSING");
            $mlm_account_ledger = MlmAccountLedgerPeer::doSelectOne($c);

            if ($mlm_account_ledger) {
                $mlm_account_ledger->setCredit($totalRpCredit);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($totalRpCredit);
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                if ($totalRpDebit > 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($totalRpDebit);
                    $mlm_account_ledger->setBalance($totalRpCredit - $totalRpDebit);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeArchivePairing()
    {
        $this->executeDoArchivePairing();
        $this->executeDoArchivePairing();
        $this->executeDoArchivePairing();
        $this->executeDoArchivePairing();
        $this->executeDoArchivePairing();
        $this->executeDoArchivePairing();
        $this->executeDoArchivePairing();
        $this->executeDoArchivePairing();

        return sfView::HEADER_ONLY;
    }

    public function executeDoArchiveAccount()
    {
        $c = new Criteria();
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, 161);
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        if ($this->getRequestParameter('q')) {
            $c->add(MlmDistributorPeer::FROM_ABFX, $this->getRequestParameter('q'));
        }
        $c->setLimit(5000);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = 0;
        foreach ($distDBs as $distDB) {
            $idx++;

            /*if ($distDB->getDistributorId() == 1) {
                continue;
            }*/
            /*if ($idx > 10) {
                break;
            }*/

            $queryDate = "2014-11-30";
            $totalCp2 = $this->getAccountLedgerBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH, $queryDate);
            $totalCp3 = $this->getAccountLedgerBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_MAINTENANCE, $queryDate);
            $totalRt = $this->getAccountLedgerBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RT, $queryDate);
            $totalCp1 = $this->getAccountLedgerBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT, $queryDate);
            $totalDebitAccount = $this->getAccountLedgerBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT, $queryDate);
            $totalDebit = $this->getAccountLedgerBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_DEBIT, $queryDate);
            $totalRpCredit = $this->getAccountLedgerCreditBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RP, $queryDate);
            $totalRpDebit = $this->getAccountLedgerDebitBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RP, $queryDate);

            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();

                print_r("<br>".$distDB->getDistributorId().":".$totalCp2.":".$totalCp3.":".$totalRt.":".$totalCp1.":".$totalDebitAccount.":".$totalDebit.":".$totalRpCredit.":".$totalRpDebit);
                $this->removeAccountLedger($distDB->getDistributorId(), $queryDate);

                if ($totalCp2 <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit($totalCp2);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($totalCp2);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                if ($totalCp3 <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit($totalCp3);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($totalCp3);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                if ($totalRt <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit($totalRt);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($totalRt);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                if ($totalCp1 <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit($totalCp1);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($totalCp1);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                if ($totalDebitAccount <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit($totalDebitAccount);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($totalDebitAccount);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                if ($totalDebit <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_DEBIT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit($totalDebit);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($totalDebit);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                if ($totalRpCredit <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit($totalRpCredit);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($totalRpCredit);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                if ($totalRpDebit <> 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CLOSING);
                    $mlm_account_ledger->setRemark("CLOSING ".$queryDate);
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($totalRpDebit);
                    $mlm_account_ledger->setBalance($totalRpCredit - $totalRpDebit);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
                $distDB->setBkkStatus("COMPLETE");
                $distDB->save();

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("executeDoArchiveAccount Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDoArchivePairing()
    {
        $c = new Criteria();
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, 161);
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        if ($this->getRequestParameter('q')) {
            $c->add(MlmDistributorPeer::FROM_ABFX, $this->getRequestParameter('q'));
        }
        $c->setLimit(1000);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = 0;
        foreach ($distDBs as $distDB) {
            $idx++;

            /*if ($distDB->getDistributorId() == 1) {
                continue;
            }*/
            /*if ($idx > 10) {
                break;
            }*/
            $queryDate = "2015-01-31";
            $totalLeft = $this->getPairingSumCredit($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, $queryDate);
            $totalRight = $this->getPairingSumCredit($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, $queryDate);
            $totalLeftActual = $this->getPairingSumCreditActual($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, $queryDate);
            $totalRightActual = $this->getPairingSumCreditActual($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, $queryDate);
            $totalLeftPaired = $this->getPairingSumDebit($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, $queryDate);
            $totalRightPaired = $this->getPairingSumDebit($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, $queryDate);

            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();

                print_r("<br>".$distDB->getDistributorId().":".$totalLeft.":".$totalRight.":".$totalLeftPaired.":".$totalRightPaired);
                $this->removePairing($distDB->getDistributorId(), $queryDate);

                $sponsorDistPairingledger = new MlmDistPairingLedger();
                $sponsorDistPairingledger->setDistId($distDB->getDistributorId());
                $sponsorDistPairingledger->setLeftRight(Globals::PLACEMENT_LEFT);
                $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                $sponsorDistPairingledger->setCredit($totalLeft);
                $sponsorDistPairingledger->setCreditActual($totalLeftActual);
                $sponsorDistPairingledger->setDebit(0);
                $sponsorDistPairingledger->setBalance($totalLeft);
                $sponsorDistPairingledger->setRemark("CLOSING ".$queryDate);
                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->save();

                $sponsorDistPairingledger = new MlmDistPairingLedger();
                $sponsorDistPairingledger->setDistId($distDB->getDistributorId());
                $sponsorDistPairingledger->setLeftRight(Globals::PLACEMENT_RIGHT);
                $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                $sponsorDistPairingledger->setCredit($totalRight);
                $sponsorDistPairingledger->setCreditActual($totalRightActual);
                $sponsorDistPairingledger->setDebit(0);
                $sponsorDistPairingledger->setBalance($totalRight);
                $sponsorDistPairingledger->setRemark("CLOSING ".$queryDate);
                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->save();

                $sponsorDistPairingledger = new MlmDistPairingLedger();
                $sponsorDistPairingledger->setDistId($distDB->getDistributorId());
                $sponsorDistPairingledger->setLeftRight(Globals::PLACEMENT_LEFT);
                $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_PAIRED);
                $sponsorDistPairingledger->setCredit(0);
                $sponsorDistPairingledger->setCreditActual(0);
                $sponsorDistPairingledger->setDebit($totalLeftPaired);
                $sponsorDistPairingledger->setBalance($totalLeft - $totalLeftPaired);
                $sponsorDistPairingledger->setRemark("CLOSING ".$queryDate);
                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->save();

                $sponsorDistPairingledger = new MlmDistPairingLedger();
                $sponsorDistPairingledger->setDistId($distDB->getDistributorId());
                $sponsorDistPairingledger->setLeftRight(Globals::PLACEMENT_RIGHT);
                $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_PAIRED);
                $sponsorDistPairingledger->setCredit(0);
                $sponsorDistPairingledger->setCreditActual(0);
                $sponsorDistPairingledger->setDebit($totalRightPaired);
                $sponsorDistPairingledger->setBalance($totalRight - $totalRightPaired);
                $sponsorDistPairingledger->setRemark("CLOSING ".$queryDate);
                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->save();

                $distDB->setBkkStatus("COMPLETE");
                $distDB->save();

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("executeDoArchivePairing Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDoArchiveCp1()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->setLimit(1000);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = 0;
        foreach ($distDBs as $distDB) {
            $idx++;

            if ($idx > 10) {
                break;
            }
            $totalLeft = $this->getPairingBalance($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $totalRight = $this->getPairingBalance($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();

                $query = "delete from mlm_dist_pairing_ledger where dist_id = ".$distDB->getDistributorId();

                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);

                $resultset = $statement->executeQuery();

                $sponsorDistPairingledger = new MlmDistPairingLedger();
                $sponsorDistPairingledger->setDistId($distDB->getDistributorId());
                $sponsorDistPairingledger->setLeftRight(Globals::PLACEMENT_LEFT);
                $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_CLOSING);
                $sponsorDistPairingledger->setCredit($totalLeft);
                $sponsorDistPairingledger->setCreditActual($totalLeft);
                $sponsorDistPairingledger->setDebit(0);
                $sponsorDistPairingledger->setBalance($totalLeft);
                $sponsorDistPairingledger->setRemark("CLOSING 2014-09-06");
                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->save();

                $sponsorDistPairingledger = new MlmDistPairingLedger();
                $sponsorDistPairingledger->setDistId($distDB->getDistributorId());
                $sponsorDistPairingledger->setLeftRight(Globals::PLACEMENT_RIGHT);
                $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_CLOSING);
                $sponsorDistPairingledger->setCredit($totalRight);
                $sponsorDistPairingledger->setCreditActual($totalRight);
                $sponsorDistPairingledger->setDebit(0);
                $sponsorDistPairingledger->setBalance($totalRight);
                $sponsorDistPairingledger->setRemark("CLOSING 2014-09-06");
                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->save();

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }
    }
    public function executeCreateEmptyAccount()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|256559|%", Criteria::LIKE);
        $c->addAscendingOrderByColumn(MlmDistributorPeer::PLACEMENT_TREE_LEVEL);
        $mlmDistributors = MlmDistributorPeer::doSelect($c);

        $count = 0;
        foreach ($mlmDistributors as $mlmDistributor) {
            print_r($count . "<br>");
            $appUserDB = AppUserPeer::retrieveByPK($mlmDistributor->getUserId());

            $appUser = new AppUser();
            $appUser->setUsername($appUserDB->getUsername()."_");
            $appUser->setKeepPassword($appUserDB->getKeepPassword());
            $appUser->setUserpassword($appUserDB->getUserpassword());
            $appUser->setKeepPassword2($appUserDB->getKeepPassword2());
            $appUser->setUserpassword2($appUserDB->getUserpassword2());
            $appUser->setUserRole($appUserDB->getUserRole());
            $appUser->setStatusCode("BLOCKED");
            $appUser->setLastLoginDatetime($appUserDB->getLastLoginDatetime());
            $appUser->setCreatedBy($appUserDB->getCreatedBy());
            $appUser->setCreatedOn($appUserDB->getCreatedOn());
            $appUser->setUpdatedBy($appUserDB->getUpdatedBy());
            $appUser->setUpdatedOn($appUserDB->getUpdatedOn());
            $appUser->setFromAbfx($appUserDB->getFromAbfx());
            $appUser->setRemark($appUserDB->getRemark().", ORI MOVE UNDER MaximChina2 (NICHOLES)");
            $appUser->save();

            $placementUplineDistDB = null;
            if ($count == 0) {
                $placementUplineDistId = 264495;
                $placementUplineDistDB = MlmDistributorPeer::retrieveByPK($placementUplineDistId);
            } else {
                $placementUplineDistDB = MlmDistributorPeer::retrieveByPK($mlmDistributor->getTreeUplineDistId());

                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $placementUplineDistDB->getDistributorCode()."_");
                $placementUplineDistDB = MlmDistributorPeer::doSelectOne($c);
            }

            $mlm_distributor = new MlmDistributor();
            $mlm_distributor->setDistributorCode($mlmDistributor->getDistributorCode()."_");
            $mlm_distributor->setUserId($appUser->getUserId());
            $mlm_distributor->setStatusCode("BLOCKED");
            $mlm_distributor->setFullName($mlmDistributor->getFullName());
            $mlm_distributor->setNickname($mlmDistributor->getNickname());
            $mlm_distributor->setIc($mlmDistributor->getIc());
            $mlm_distributor->setCountry($mlmDistributor->getCountry());
            $mlm_distributor->setAddress($mlmDistributor->getAddress());
            $mlm_distributor->setAddress2($mlmDistributor->getAddress2());
            $mlm_distributor->setCity($mlmDistributor->getCity());
            $mlm_distributor->setState($mlmDistributor->getState());
            $mlm_distributor->setPostcode($mlmDistributor->getPostcode());
            $mlm_distributor->setEmail($mlmDistributor->getEmail());
            $mlm_distributor->setAlternateEmail($mlmDistributor->getAlternateEmail());
            $mlm_distributor->setContact($mlmDistributor->getContact());
            $mlm_distributor->setGender($mlmDistributor->getGender());
            $mlm_distributor->setDob($mlmDistributor->getDob());
            $mlm_distributor->setBankName($mlmDistributor->getBankName());
            $mlm_distributor->setBankBranchName($mlmDistributor->getBankBranchName());
            $mlm_distributor->setBankAddress($mlmDistributor->getBankAddress());
            $mlm_distributor->setBankAccNo($mlmDistributor->getBankAccNo());
            $mlm_distributor->setBankHolderName($mlmDistributor->getBankHolderName());
            $mlm_distributor->setBankSwiftCode($mlmDistributor->getBankSwiftCode());
            $mlm_distributor->setVisaDebitCard($mlmDistributor->getVisaDebitCard());
            $mlm_distributor->setEzyCashCard($mlmDistributor->getEzyCashCard());
            $mlm_distributor->setTreeLevel($mlmDistributor->getTreeLevel());
            $mlm_distributor->setTreeStructure($mlmDistributor->getTreeStructure());
            $mlm_distributor->setInitRankId($mlmDistributor->getInitRankId());
            $mlm_distributor->setInitRankCode($mlmDistributor->getInitRankCode());
            $mlm_distributor->setUplineDistId($mlmDistributor->getUplineDistId());
            $mlm_distributor->setUplineDistCode($mlmDistributor->getUplineDistCode());
            $mlm_distributor->setTreeUplineDistId($placementUplineDistDB->getDistributorId());
            $mlm_distributor->setTreeUplineDistCode($placementUplineDistDB->getDistributorCode());
            $mlm_distributor->setTotalLeft($mlmDistributor->getTotalLeft());
            $mlm_distributor->setTotalRight($mlmDistributor->getTotalRight());
            $mlm_distributor->setPlacementPosition($mlmDistributor->getPlacementPosition());
            $mlm_distributor->setPlacementDatetime($mlmDistributor->getPlacementDatetime());
            $mlm_distributor->setRankId($mlmDistributor->getRankId());
            $mlm_distributor->setRankCode($mlmDistributor->getRankCode());
            $mlm_distributor->setActiveDatetime($mlmDistributor->getActiveDatetime());
            $mlm_distributor->setActivatedBy($mlmDistributor->getActivatedBy());
            $mlm_distributor->setLeverage($mlmDistributor->getLeverage());
            $mlm_distributor->setSpread($mlmDistributor->getSpread());
            $mlm_distributor->setDepositCurrency($mlmDistributor->getDepositCurrency());
            $mlm_distributor->setDepositAmount($mlmDistributor->getDepositAmount());
            $mlm_distributor->setSignName($mlmDistributor->getSignName());
            $mlm_distributor->setSignDate($mlmDistributor->getSignDate());
            $mlm_distributor->setTermCondition($mlmDistributor->getTermCondition());
            $mlm_distributor->setIbCommission($mlmDistributor->getIbCommission());
            $mlm_distributor->setIsIb($mlmDistributor->getIsIb());
            $mlm_distributor->setCreatedBy($mlmDistributor->getCreatedBy());
            $mlm_distributor->setCreatedOn($mlmDistributor->getCreatedOn());
            $mlm_distributor->setUpdatedBy($mlmDistributor->getUpdatedBy());
            $mlm_distributor->setUpdatedOn($mlmDistributor->getUpdatedOn());
            $mlm_distributor->setPackagePurchaseFlag($mlmDistributor->getPackagePurchaseFlag());
            $mlm_distributor->setFileBankPassBook($mlmDistributor->getFileBankPassBook());
            $mlm_distributor->setFileProofOfResidence($mlmDistributor->getFileProofOfResidence());
            $mlm_distributor->setFileNric($mlmDistributor->getFileNric());
            $mlm_distributor->setExcludedStructure($mlmDistributor->getExcludedStructure());
            $mlm_distributor->setProductMte($mlmDistributor->getProductMte());
            $mlm_distributor->setProductFxgold($mlmDistributor->getProductFxgold());
            $mlm_distributor->setRemark($mlmDistributor->getRemark());
            $mlm_distributor->setLoanAccount($mlmDistributor->getLoanAccount());
            $mlm_distributor->setSelfRegister($mlmDistributor->getSelfRegister());
            $mlm_distributor->setDebitAccount($mlmDistributor->getDebitAccount());
            $mlm_distributor->setDebitRankId($mlmDistributor->getDebitRankId());
            $mlm_distributor->setDebitStatusCode($mlmDistributor->getDebitStatusCode());
            $mlm_distributor->setHideGenealogy($mlmDistributor->getHideGenealogy());
            $mlm_distributor->setFromAbfx($mlmDistributor->getFromAbfx());
            $mlm_distributor->setAbfxUserId($mlmDistributor->getAbfxUserId());
            $mlm_distributor->setAbfxRef($mlmDistributor->getAbfxRef());
            $mlm_distributor->setAbfxUpline1($mlmDistributor->getAbfxUpline1());
            $mlm_distributor->setAbfxPosition($mlmDistributor->getAbfxPosition());
            $mlm_distributor->setAbfxRemark($mlmDistributor->getAbfxRemark());
            $mlm_distributor->setAbfxEwallet($mlmDistributor->getAbfxEwallet());
            $mlm_distributor->setAbfxEpoint($mlmDistributor->getAbfxEpoint());
            $mlm_distributor->setAbfxPairingLeft($mlmDistributor->getAbfxPairingLeft());
            $mlm_distributor->setAbfxPairingRight($mlmDistributor->getAbfxPairingRight());
            $mlm_distributor->setMigratedStatus($mlmDistributor->getMigratedStatus());
            $mlm_distributor->setMigratedPlacementStatus($mlmDistributor->getMigratedPlacementStatus());
            $mlm_distributor->setMigrateRetry($mlmDistributor->getMigrateRetry());
            $mlm_distributor->setNomineeName($mlmDistributor->getNomineeName());
            $mlm_distributor->setNomineeIc($mlmDistributor->getNomineeIc());
            $mlm_distributor->setNomineeRelationship($mlmDistributor->getNomineeRelationship());
            $mlm_distributor->setNomineeContactno($mlmDistributor->getNomineeContactno());
            $mlm_distributor->setNewActivityFlag($mlmDistributor->getNewActivityFlag());
            $mlm_distributor->setNewReportFlag($mlmDistributor->getNewReportFlag());
            $mlm_distributor->setQ3Champions($mlmDistributor->getQ3Champions());
            $mlm_distributor->setQ3Datetime($mlmDistributor->getQ3Datetime());

            $mlm_distributor->save();

            $mlm_distributor->setPlacementTreeLevel($placementUplineDistDB->getPlacementTreeLevel() + 1);
            $mlm_distributor->setPlacementTreeStructure($placementUplineDistDB->getPlacementTreeStructure()."|".$mlm_distributor->getDistributorId()."|");
            $mlm_distributor->save();

            $leftOnePlacement = $this->getPairingBalance($mlmDistributor->getDistributorId(), Globals::PLACEMENT_LEFT);
            $rightTwoPlacement = $this->getPairingBalance($mlmDistributor->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $mlmDistPairingLedger = new MlmDistPairingLedger();
            $mlmDistPairingLedger->setDistId($mlm_distributor->getDistributorId());
            $mlmDistPairingLedger->setLeftRight("LEFT");
            $mlmDistPairingLedger->setTransactionType("REGISTER");
            $mlmDistPairingLedger->setCredit($leftOnePlacement);
            $mlmDistPairingLedger->setDebit(0);
            $mlmDistPairingLedger->setBalance($leftOnePlacement);
            $mlmDistPairingLedger->setRemark("");
            $mlmDistPairingLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistPairingLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistPairingLedger->save();

            $mlmDistPairingLedger = new MlmDistPairingLedger();
            $mlmDistPairingLedger->setDistId($mlm_distributor->getDistributorId());
            $mlmDistPairingLedger->setLeftRight("RIGHT");
            $mlmDistPairingLedger->setTransactionType("REGISTER");
            $mlmDistPairingLedger->setCredit($rightTwoPlacement);
            $mlmDistPairingLedger->setDebit(0);
            $mlmDistPairingLedger->setBalance($rightTwoPlacement);
            $mlmDistPairingLedger->setRemark("");
            $mlmDistPairingLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistPairingLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistPairingLedger->save();

            $count++;
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeManualInsertPips()
    {
        //        $mlm_distributor = MlmDistributorPeer::retrieveByPk(257750);
        //        $mlm_distributor = MlmDistributorPeer::retrieveByPk(257751);
        //$mlm_distributor = MlmDistributorPeer::retrieveByPk(255838);
        $mlm_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('q'));
        $uplinePosition = $mlm_distributor->getPlacementPosition();
        $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());

        $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
        $pairingPoint = $this->getRequestParameter('point') * Globals::PAIRING_POINT_BV;
        $pairingPointActual = $this->getRequestParameter('point');
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
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                    return $this->redirect('/member/memberRegistration');
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
            if ($uplineDistDB->getRankId() > 0) {
                $sponsorDistPairingledger = new MlmDistPairingLedger();
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

                //$this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);
            }

            if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                break;
            }

            $uplinePosition = $uplineDistDB->getPlacementPosition();
            $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
            $level++;
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeIndex()
    {
        return $this->redirect('/member/summary');

        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "leo_group_list.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $counter = 0;
        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = 1; $x <= $totalRow; $x++) {
            $counter++;
            print_r("===>user name:".$data->val($x, "A")."<br>");
            $userName = trim($data->val($x, "A"));
            //$password = rand(10000000, 99999999);
            $password = "abcd1234";
            $fullName = $data->val($x, "B");
            $uplineDistCode = trim($data->val($x, "C"));
            $placementDistCode = trim($data->val($x, "D"));
            $email = $data->val($x, "E");
            $status = $data->val($x, "F");

            if ($status == "COMPLETE") {
                continue;
            }
            print_r("===>placementDistCode:".$placementDistCode."<br>");
            $arr = explode(' ', $placementDistCode);
            $placementDistCode = trim($arr[0]);
            $placementPositionStr = trim($arr[1]);
            $placementPosition = "";
            print_r("===>placementPosition:".$placementPositionStr."<br>");

            if ($placementPositionStr == "(L)") {
                $placementPosition = "LEFT";
            } else if ($placementPositionStr == "(R)") {
                $placementPosition = "RIGHT";
            } else {
                print_r("===>left right wrong:".$counter.":".$userName.":".$placementPositionStr."<br>");
                break;
            }

            $treeUplineDistDB = null;
            if ($placementDistCode == "") {
                print_r("==placement code empty=>".$counter.":".$userName.":".$placementDistCode."<br>");
                break;
            } else {
                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $placementDistCode);
                $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|263774|%", Criteria::LIKE);
                $treeUplineDistDB = MlmDistributorPeer::doSelectOne($c);

                if (!$treeUplineDistDB) {
                    print_r("==placement code not exist=>".$counter.":".$userName.":".$placementDistCode."<br>");
                    break;
                }

                $c = new Criteria();
                $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_CODE, $placementDistCode);
                $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $placementPosition);
                $placementAvailable = MlmDistributorPeer::doSelectOne($c);

                if ($placementAvailable) {
                    print_r("==placement position not available=>".$counter.":".$userName.":".$placementDistCode.":".$placementPosition."<br>");
                    break;
                }
            }

            $c = new Criteria();
            $c->add(AppUserPeer::USERNAME, $userName);
            $exist = AppUserPeer::doSelectOne($c);

            if ($exist) {
                print_r("=username exist==>".$counter.":".$userName."<br>");
                break;
            }

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
            $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%|263774|%", Criteria::LIKE);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

            if (!$uplineDistDB) {
                print_r("===>invalid referrer:".$counter.":".$userName.":".$uplineDistCode."<br>");
                break;
            }

            $uplineDistId = $uplineDistDB->getDistributorId();
            $treeLevel = $uplineDistDB->getTreeLevel() + 1;
            $packageDB = MlmPackagePeer::retrieveByPK(3);
            $con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
            try {
                $con->begin();

                $app_user = new AppUser();
                $app_user->setUsername($userName);
                $app_user->setKeepPassword($password);
                $app_user->setUserpassword($password);
                $app_user->setKeepPassword2($password);
                $app_user->setUserpassword2($password);
                $app_user->setUserRole(Globals::ROLE_DISTRIBUTOR);
                $app_user->setStatusCode(Globals::STATUS_ACTIVE);
                $app_user->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $app_user->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $app_user->save();

                $mlm_distributor = new MlmDistributor();
                $mlm_distributor->setDistributorCode($userName);
                $mlm_distributor->setUserId($app_user->getUserId());
                $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_distributor->setFullName($fullName);
                $mlm_distributor->setNickname($userName);
                //$mlm_distributor->setIc($this->getRequestParameter('ic'));
                $mlm_distributor->setCountry('China (PRC)');
                //$mlm_distributor->setAddress($this->getRequestParameter('address'));
                //$mlm_distributor->setAddress2($this->getRequestParameter('address2'));
                //$mlm_distributor->setCity($this->getRequestParameter('city'));
                //$mlm_distributor->setState($this->getRequestParameter('state'));
                //$mlm_distributor->setPostcode($this->getRequestParameter('zip'));
                $mlm_distributor->setEmail($email);
                //$mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
                //$mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
                //$mlm_distributor->setGender($this->getRequestParameter('gender'));
                /*if ($this->getRequestParameter('dob')) {
                    list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
                    $mlm_distributor->setDob("$y-$m-$d");
                }*/
                //$mlm_distributor->setBankName($this->getRequestParameter('bankName'));
                //$mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccountNo'));
                //$mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));

                $mlm_distributor->setTreeLevel($treeLevel);
                $mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
                $mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());

                //$mlm_distributor->setLeverage($this->getRequestParameter('leverage'));
                //$mlm_distributor->setSpread($this->getRequestParameter('spread'));
                //$mlm_distributor->setDepositCurrency($this->getRequestParameter('deposit_currency'));
                //$mlm_distributor->setDepositAmount($this->getRequestParameter('deposit_amount'));
                $mlm_distributor->setSignName($fullName);
                $mlm_distributor->setSignDate(date("Y/m/d h:i:s A"));
                //$mlm_distributor->setTermCondition($this->getRequestParameter('term_condition'));

                $mlm_distributor->setRankId(3);
                $mlm_distributor->setInitRankId(3);
                $mlm_distributor->setRankCode("Platinum");
                $mlm_distributor->setInitRankCode("Platinum");
                $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_distributor->setPackagePurchaseFlag("N");
                $mlm_distributor->setRemark("loan account");
                //$mlm_distributor->setRemark("loan account, Bandung Case (Steven)");
                $mlm_distributor->setLoanAccount("Y");
                $mlm_distributor->setHideGenealogy("N");

                $mlm_distributor->setActiveDatetime(date("Y/m/d h:i:s A"));
                $mlm_distributor->setActivatedBy($this->getUser()->getAttribute(Globals::SESSION_DISTID));
//                $mlm_distributor->setNomineeName($this->getRequestParameter('nomineeName'));
//                $mlm_distributor->setNomineeIc($this->getRequestParameter('nomineeIc'));
//                $mlm_distributor->setNomineeRelationship($this->getRequestParameter('nomineeRelationship'));
//                $mlm_distributor->setNomineeContactno($this->getRequestParameter('nomineeContactNo'));

                $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_distributor->save();

                $treeStructure = $uplineDistDB->getTreeStructure() . "|" . $mlm_distributor->getDistributorId() . "|";
                $mlm_distributor->setTreeStructure($treeStructure);
                $mlm_distributor->save();

                $sponsorDistPairingDB = MlmDistPairingPeer::retrieveByPK($mlm_distributor->getDistributorId());
                if (!$sponsorDistPairingDB) {
                    $sponsorDistPairingDB = new MlmDistPairing();
                    $sponsorDistPairingDB->setDistId($mlm_distributor->getDistributorId());
                    $sponsorDistPairingDB->setLeftBalance(0);
                    $sponsorDistPairingDB->setRightBalance(0);
                    $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                }
                $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingDB->save();


                $treeStructure = $treeUplineDistDB->getPlacementTreeStructure() . "|" . $mlm_distributor->getDistributorId() . "|";
                $treeLevel = $treeUplineDistDB->getPlacementTreeLevel() + 1;
                $mlm_distributor->setPlacementDatetime(date("Y/m/d h:i:s A"));
                $mlm_distributor->setPlacementPosition($placementPosition);
                //$mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
                //$mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());
                $mlm_distributor->setPlacementTreeStructure($treeStructure);
                $mlm_distributor->setPlacementTreeLevel($treeLevel);
                $mlm_distributor->setTreeUplineDistId($treeUplineDistDB->getDistributorId());
                $mlm_distributor->setTreeUplineDistCode($treeUplineDistDB->getDistributorCode());
                $mlm_distributor->save();

                $con->commit();

            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeIndex2()
    {
        return $this->redirect('/member/summary');

        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "gao_group_90.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $counter = 1;
        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = $totalRow; $x > 0; $x--) {
            $mt4Username = $data->val($x, "A");
            $mt4Password = $data->val($x, "E");
            $email = $data->val($x, "C");
            $fullname = $data->val($x, "B");

            if ($mt4Password == "" || $email == "")
                continue;

            //            $c = new Criteria();
            //            $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Username);
            //            $mlmDistMt4 = MlmDistMt4Peer::doSelectOne($c);

            //            if ($mlmDistMt4) {
            $tmpMt4Account = new TmpMt4Account();
            $tmpMt4Account->setMt4Username($mt4Username);
            $tmpMt4Account->setMt4Password($mt4Password);
            $tmpMt4Account->setFullname($fullname);
            $tmpMt4Account->setEmail($email);
            $tmpMt4Account->setStatusCode(Globals::STATUS_ACTIVE);
            $tmpMt4Account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tmpMt4Account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tmpMt4Account->save();

            $counter++;
            //            } else {
            //                $tmpMt4Account = new TmpMt4Account();
            //                $tmpMt4Account->setMt4Username($mt4Username);
            //                $tmpMt4Account->setMt4Password($mt4Password);
            //                $tmpMt4Account->setFullname($fullname);
            //                $tmpMt4Account->setEmail($email);
            //                $tmpMt4Account->setStatusCode(Globals::STATUS_CANCEL);
            //                $tmpMt4Account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            //                $tmpMt4Account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            //                $tmpMt4Account->save();
            //
            //                print_r($mt4Username);
            //                print_r("<br>");
            //            }
        }
        print_r($totalRow);

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeUpdateDebitCard()
    {
        var_dump("hihi");
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "replacement_card.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $counter = 1;
        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = $totalRow; $x > 0; $x--) {
            $memberId = $data->val($x, "A");
            $visaCardNumber = $data->val($x, "D");

            if ($memberId == "" || $visaCardNumber == "")
                continue;

            $visaCardNumber = str_replace(" ", "", $visaCardNumber);

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $memberId);
            $distributorDB = MlmDistributorPeer::doSelectOne($c);

            if ($distributorDB) {
                $distributorDB->setVisaDebitCard($visaCardNumber);
                $distributorDB->save();

                $title = "We will be sending you the New Maxim Visa Debit card to replace the existing Maxim visa debit card you have <br>我们会寄送新的马胜借记卡，以取代您原有的马胜借记卡";

                $message = "Dear Client,
                <br>
                <br>Thanks for your time and please kindly know that we will be sending you the New Maxim Visa Debit card to replace the existing Maxim visa debit card you have. Please note that you can still use the balance you have on your existing card, yet you won't be able to credit more amount into it.
                <br>
                <br>It will take you about 2 weeks to receive the new card, and once you get it, please keep your PIN number (we won't be keeping the PIN for you), and you are free to use this card. If you have any question regarding and only regarding the debit card, please write to melody@maximtrader.com （English/Chinese) for help.
                <br>
                <br>Thank you very much!
                <br>
                <br>Sincerely
                <br>Maxim Support
                <br>
                <br>************************************************************
                <br>
                <br>尊敬的客户您好！
                <br>
                <br>请留意我们会寄送新的马胜借记卡，以取代您原有的马胜借记卡。
                <br>您依然可以使用您现有的卡上余额，但是请注意您已经不可以再继续往该卡上汇钱。
                <br>
                <br>新卡大概需要2周寄到您的所在地。请妥善保管您的PIN号码（公司不会存档）。之后您可以正常使用该卡。
                <br>如果您有任何关于且只关于借记卡的疑虑，请中文或英文邮件至melody@maximtrader.com。
                <br>
                <br>谢谢！
                <br>客户服务部";

                $mlm_customer_enquiry = new MlmCustomerEnquiry();
                $mlm_customer_enquiry->setDistributorId($distributorDB->getDistributorId());
                //$mlm_customer_enquiry->setContactNo($contactNoEmail);
                $mlm_customer_enquiry->setTitle($title);
                $mlm_customer_enquiry->setAdminUpdated(Globals::TRUE);
                $mlm_customer_enquiry->setDistributorUpdated(Globals::FALSE);
                $mlm_customer_enquiry->setAdminRead(Globals::TRUE);
                $mlm_customer_enquiry->setDistributorRead(Globals::FALSE);
                $mlm_customer_enquiry->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_customer_enquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

                $mlm_customer_enquiry->save();

                $mlm_customer_enquiry_detail = new MlmCustomerEnquiryDetail();
                $mlm_customer_enquiry_detail->setCustomerEnquiryId($mlm_customer_enquiry->getEnquiryId());
                $mlm_customer_enquiry_detail->setMessage($message);
                $mlm_customer_enquiry_detail->setReplyFrom(Globals::ROLE_ADMIN);
                $mlm_customer_enquiry_detail->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_customer_enquiry_detail->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_customer_enquiry_detail->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_customer_enquiry_detail->save();
            } else {
                print_r($memberId."not found========================================<br>");
            }
        }
        print_r($totalRow);

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeCustomerEnquiryList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmCustomerEnquiryPeer::DISTRIBUTOR_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        //$c->addAnd(MlmEcashWithdrawPeer::F_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $totalRecords = MlmCustomerEnquiryPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmEcashWithdrawPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmCustomerEnquiryPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmCustomerEnquiry', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $lastReply = "";
            $read = "";

            if ($result->getAdminUpdated() == "T") {
                $lastReply = "<font style='color:red'>Yes</font>";
            }
            if ($result->getDistributorRead() == "T") {
                $read = "Read";
            } else {
                $read = "Unread";
            }
            $arr[] = array(
                $result->getEnquiryId() == null ? "" : $result->getEnquiryId(),
                $result->getUpdatedOn() == null ? "" : $result->getUpdatedOn(),
                $result->getTitle() == null ? "" : $result->getTitle(),
                $lastReply,
                $read
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

    public function executeIndex_bak()
    {
        $con = Propel::getConnection(MlmEcashWithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();
            $tbl_ecash_withdraw = new MlmEcashWithdraw();
            $tbl_ecash_withdraw->setDistId(0);
            $tbl_ecash_withdraw->setDeduct(0);
            $tbl_ecash_withdraw->setAmount(0);
            $tbl_ecash_withdraw->setStatusCode("12312312312313123123123123123131313213212312312313123");
            $tbl_ecash_withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->save();

            $tbl_ecash_withdraw = new MlmEcashWithdraw();
            $tbl_ecash_withdraw->setDistId(1);
            $tbl_ecash_withdraw->setDeduct(1);
            $tbl_ecash_withdraw->setAmount(1);
            $tbl_ecash_withdraw->setStatusCode(Globals::WITHDRAWAL_PENDING);
            $tbl_ecash_withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->save();

            $distributorDB = MlmDistributorPeer::retrieveByPk(1000);
            $distributorDB->getDistributorCode();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executePinTransactionLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(TblPinPeer::F_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = TblPinPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterPinCode') != "") {
            $c->addAnd(TblPinPeer::F_PIN, "%" . $this->getRequestParameter('filterPinCode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterType') != "") {
            $c->addAnd(TblPinPeer::F_TYPE, "%" . $this->getRequestParameter('filterType') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(TblPinPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = TblPinPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('TblPin', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getFPin() == null ? "" : $result->getFPin(),
                $result->getFCps() == null ? "" : $result->getFCps(),
                $result->getFType() == null ? "" : $result->getFType(),
                $result->getFAction() == null ? "" : $result->getFAction(),
                $result->getFActionDatetime() == null ? "" : $result->getFActionDatetime(),
                $result->getFCreatedDatetime() == null ? "" : $result->getFCreatedDatetime()
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

    public function executePlacementLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM tbl_placement placement
            LEFT JOIN tbl_distributor distributor ON placement.f_dist_id2 = distributor.f_id ";

        /******   total records  *******/
        $sWhere = " WHERE placement.f_dist_id =" . $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistcode') != "") {
            $sWhere .= " AND placement.f_dist_code2 LIKE %" . mysql_real_escape_string($this->getRequestParameter('filterDistcode')) . "%";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterPlacementcode') != "") {
            $sWhere .= " AND placement.f_parentid_code2 LIKE %" . mysql_real_escape_string($this->getRequestParameter('filterPlacementcode')) . "%";
            //$c->addAnd(sfPropelPager::F_PARENTID_CODE2, "%" . $this->getRequestParameter('filterPlacementcode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterPosition') != "") {
            $sWhere .= " AND placement.f_position LIKE %" . mysql_real_escape_string($this->getRequestParameter('filterPosition')) . "%";
            //$c->addAnd(TblPlacementPeer::F_POSITION, "%" . $this->getRequestParameter('filterPosition') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $position = "";
            if ($resultArr['f_position'] <> null && $this->getUser()->getCulture() == "cn") {
                if ("left" == $resultArr['f_position']) {
                    $position = $this->getContext()->getI18N()->__("left");
                } else {
                    $position = $this->getContext()->getI18N()->__("right");
                }
            }
            $arr[] = array(
                $resultArr['f_dist_code2'] == null ? "" : $resultArr['f_dist_code2'],
                $resultArr['f_name'] == null ? "" : $resultArr['f_name'],
                $resultArr['f_parentid_code2'] == null ? "" : $resultArr['f_parentid_code2'],
                $position,
                $resultArr['f_created_datetime'] == null ? "" : $resultArr['f_created_datetime']
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

    public function executeDownlineMemberList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM mlm_distributor ";

        /******   total records  *******/
        $sWhere = " WHERE distributor_id <> " . $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND placement_tree_structure like '%|" . $this->getUser()->getAttribute(Globals::SESSION_DISTID) . "|%'";

        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1458) {
            // hide datoheng group
            $sWhere .= " AND placement_tree_structure not like '%|203|%'";
        }

        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('search_memberId') != "") {
            $sWhere .= " AND distributor_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('search_memberId')) . "%'";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }

        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name']
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

    /************************************/
    /********   FUNCTION        *********/
    /************************************/
    function getTotalRecords($sql)
    {
        $query = "SELECT COUNT(*) AS _TOTAL " . $sql;
        //var_dump($query);
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

    function revalidatePairing($distributorId, $leftRight)
    {
        $balance = $this->getPairingBalance($distributorId, $leftRight);

        $c = new Criteria();
        $c->add(MlmDistPairingPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistPairingPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistPairing();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setLeftBalance(0);
            $tbl_account->setRightBalance(0);
        }
        if (Globals::PLACEMENT_LEFT == $leftRight) {
            $tbl_account->setLeftBalance($balance);
        } else if (Globals::PLACEMENT_RIGHT == $leftRight) {
            $tbl_account->setRightBalance($balance);
        }

        $tbl_account->save();
    }

    function getPairingBalance($distributorId, $leftRight)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId . " AND left_right = '" . $leftRight . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $count = 0;
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

    function getAccountLedgerBalance($distributorId, $accountType, $date)
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

    function getAccountLedgerCreditBalance($distributorId, $accountType, $date)
    {
        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_account_ledger_20141231 WHERE dist_id = " . $distributorId . " AND account_type = '" . $accountType . "'";
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

    function getAccountLedgerDebitBalance($distributorId, $accountType, $date)
    {
        $query = "SELECT SUM(debit) AS SUB_TOTAL FROM mlm_account_ledger_20141231 WHERE dist_id = " . $distributorId . " AND account_type = '" . $accountType . "'";
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
    function getPairingSumCredit($distributorId, $position, $date)
    {
        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger2 WHERE dist_id = " . $distributorId
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

    function getPairingSumCreditActual($distributorId, $position, $date)
    {
        $query = "SELECT SUM(credit_actual) AS SUB_TOTAL FROM mlm_dist_pairing_ledger2 WHERE dist_id = " . $distributorId
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

    function getPairingSumDebit($distributorId, $position, $date)
    {
        $query = "SELECT SUM(debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger2 WHERE dist_id = " . $distributorId
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
    function removePairing($distributorId, $queryDate)
    {
        $query = "delete from mlm_dist_pairing_ledger where dist_id = ".$distributorId . " and created_on <= '".$queryDate . "23:59:59'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);

        $resultset = $statement->executeQuery();
    }
    function removeAccountLedger($distributorId, $queryDate)
    {
        $query = "delete from mlm_account_ledger where dist_id = ".$distributorId . " and created_on <= '".$queryDate . "23:59:59'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);

        $resultset = $statement->executeQuery();
    }
}