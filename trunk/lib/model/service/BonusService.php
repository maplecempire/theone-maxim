<?php

/**
 *
 *
 *
 * @package lib.model
 * @author r9jason
 */
class BonusService
{
    function hideGenealogy()
    {
        if ($_SERVER['SERVER_NAME'] == "partner.maximtrader.com") {
            return true;
        } else {
            return false;
        }
    }
    function checkDebitAccount($distId)
    {
        $isDebit = false;

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distId);
        $c->add(MlmDistributorPeer::DEBIT_ACCOUNT, "Y");
        $c->add(MlmDistributorPeer::DEBIT_STATUS_CODE, Globals::STATUS_ACTIVE);
        $distDB = MlmDistributorPeer::doSelectOne($c);

        if ($distDB) {
            $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);

            if ($distAccountEcashBalance <= 0) {
                $distDB->setPackagePurchaseFlag(Globals::YES);
                $distDB->setActiveDatetime(date("Y/m/d h:i:s A"));
                $distDB->setDebitStatusCode(Globals::STATUS_COMPLETE);
                $distDB->save();
            } else {
                $isDebit = true;
            }
        }

        return $isDebit;
    }
    function contraDebitAccount($distId, $debitAccountRemark, $deductAmount)
    {
        $con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
        try {
            $con->begin();

            $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);
            $distAccountDebitBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);

            $distDB = MlmDistributorPeer::retrieveByPK($distId);

            $isFound = false;
            $pos = strrpos($distDB->getPlacementTreeStructure(), "|261469|");
            if ($pos === false) { // note: three equal signs
                $pos = strrpos($distDB->getTreeStructure(), "|261469|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $isFound = true;
                }
            } else {
                $isFound = true;
            }

            $totalDebit = 0;
            $completeStatus = false;
            if ($distDB->getDebitRankId() >= 3 || $isFound) {
                $totalDebit = $deductAmount / 2;

                if ($distAccountDebitBalance > $totalDebit) {

                } else {
                    $totalDebit = $distAccountDebitBalance;

                    $completeStatus = true;
                }
            } else {
                if ($distAccountDebitBalance > $distAccountEcashBalance) {
                    $totalDebit = $distAccountEcashBalance;
                } else {
                    $totalDebit = $distAccountDebitBalance;

                    $completeStatus = true;
                }
            }

            if ($completeStatus && $totalDebit > 0) {
                $distDB->setPackagePurchaseFlag("Y");
                $distDB->setActiveDatetime(date("Y/m/d h:i:s A"));
                $distDB->setDebitStatusCode(Globals::STATUS_COMPLETE);
                $distDB->save();

                /******************************/
                /*  Direct Sponsor Bonus
                /******************************/
                $mlm_distributor = $distDB;
                $sponsorId = $mlm_distributor->getDistributorId();
                $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getUplineDistId());
                $uplineDistId = $mlm_distributor->getUplineDistId();

                $uplinePosition = $mlm_distributor->getPlacementPosition();

                $packageDB = MlmPackagePeer::retrieveByPK($mlm_distributor->getDebitRankId());
                $packagePrice = $packageDB->getPrice();
                $pairingPoint = $packagePrice * Globals::PAIRING_POINT_BV;
                $pairingPointActual = $packagePrice;
                /**************************************/
                /*  Direct REFERRAL Bonus For Upline
                /**************************************/
                if ($uplineDistDB) {
                    $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                    $directSponsorPercentage = $uplineDistPackage->getCommission();
                    $directSponsorBonusAmount = $directSponsorPercentage * $packagePrice / 100;
                    $totalBonusPayOut = $directSponsorPercentage;

                    $firstForDRB = true;
                    while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                        $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($uplineDistId);
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                        $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $mlm_distributor->getDistributorCode() . ")");
                        $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                        $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                        $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                        $mlm_account_ledger->save();

                        $this->mirroringAccountLedger($mlm_account_ledger, "93");

                        if ($this->checkDebitAccount($uplineDistId) == true) {
                            $debitAccountRemark = "PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $mlm_distributor->getDistributorCode() . ")";
                            $this->contraDebitAccount($uplineDistId, $debitAccountRemark, $directSponsorBonusAmount);
                        }
                        //var_dump($bonusService->checkDebitAccount($uplineDistId));
                        //exit();
                        $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                        /******************************/
                        /*  Commission
                        /******************************/
                        $c = new Criteria();
                        $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                        $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                        $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                        $commissionBalance = 0;
                        if (!$sponsorDistCommissionDB) {
                            $sponsorDistCommissionDB = new MlmDistCommission();
                            $sponsorDistCommissionDB->setDistId($uplineDistId);
                            $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                            $sponsorDistCommissionDB->setCreatedBy(Globals::SYSTEM_USER_ID);
                            $sponsorDistCommissionDB->setUpdatedBy(Globals::SYSTEM_USER_ID);
                        } else {
                            $commissionBalance = $sponsorDistCommissionDB->getBalance();
                        }
                        $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                        $sponsorDistCommissionDB->setUpdatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistCommissionDB->save();

                        $c = new Criteria();
                        $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                        $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                        $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                        $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                        $dsbBalance = 0;
                        if ($sponsorDistCommissionLedgerDB)
                            $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                        $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                        $sponsorDistCommissionledger->setDistId($uplineDistId);
                        $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                        $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_REGISTER);
                        $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                        $sponsorDistCommissionledger->setDebit(0);
                        $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                        $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                        if ($firstForDRB == true) {
                            $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                            $firstForDRB = false;
                        } else {
                            $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                        }
                        $sponsorDistCommissionledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistCommissionledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistCommissionledger->save();

                        $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                        //var_dump("==>1");
                        //var_dump("totalBonusPayOut=".$totalBonusPayOut);
                        if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT && $uplineDistDB) {
                            //var_dump("==>2");
                            $checkCommission = true;
                            $uplineDistId = $uplineDistDB->getUplineDistId();
                            while ($checkCommission == true) {
                                //var_dump("==>3**".$uplineDistId);
                                $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                                //var_dump("==>3$$".$uplineDistId);
                                if (!$uplineDistDB) {
                                    break;
                                }

                                if ($uplineDistDB->getIsIb() == Globals::YES) {
                                    /*if ($uplineDistDB->getIbRankId() != null) {
                                        $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                                    } else {
                                        $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                    }*/
                                    $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                                } else {
                                    $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                    $directSponsorPercentage = $uplineDistPackage->getCommission();
                                }
                                if ($directSponsorPercentage > $totalBonusPayOut) {
                                    //var_dump("==>6");
                                    $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                                    $totalBonusPayOut += $directSponsorPercentage;
                                    if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                        //var_dump("==>7");
                                        $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                                    }
                                } else {
                                    //var_dump("==>8");
                                    $uplineDistId = $uplineDistDB->getUplineDistId();
                                    continue;
                                }

                                $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
                                $checkCommission == false;
                                break;
                                //var_dump("==>9");
                            }
                        } else {
                            break;
                            //var_dump("==>^^");
                        }
                    }
                }

                if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
                    while ($level < 200) {
                        //var_dump($uplineDistDB->getUplineDistId());
                        //var_dump($uplineDistDB->getUplineDistCode());
                        print_r("<br>");
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
                            $sponsorDistPairingDB->setCreatedBy(Globals::SYSTEM_USER_ID);
                        } else {
                            $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                            $rightBalance = $sponsorDistPairingDB->getRightBalance();
                        }
                        $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
                        $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
                        $sponsorDistPairingDB->setUpdatedBy(Globals::SYSTEM_USER_ID);
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
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                        $sponsorDistPairingledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistPairingledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistPairingledger->save();

                        $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                        if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                            break;
                        }

                        $uplinePosition = $uplineDistDB->getPlacementPosition();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                        $level++;
                    }
                }

                $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);
                $distAccountDebitBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);
            }

            if ($totalDebit > 0) {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DEBIT_ACCOUNT);
                $mlm_account_ledger->setRemark("DEBITED TO DEBIT ACCOUNT");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($totalDebit);
                $mlm_account_ledger->setBalance($distAccountEcashBalance - $totalDebit);
                $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "94");

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ECASH_DEBIT);
                $mlm_account_ledger->setRemark($debitAccountRemark);
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($totalDebit);
                $mlm_account_ledger->setBalance($distAccountDebitBalance - $totalDebit);
                $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "95");
            }

            $con->commit();

        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return true;
    }
    function contraDebitAccountByEpoint($distId, $debitAccountRemark, $deductAmount)
    {
        $con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
        try {
            $con->begin();

            $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);
            $distAccountDebitBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);

            $distDB = MlmDistributorPeer::retrieveByPK($distId);
            print_r("DistId " . $distId . "<br>");
            print_r("epoint: " . $distAccountEcashBalance . "<br>");
            $totalDebit = 0;
            $completeStatus = false;
            /*if ($distDB->getDebitRankId() >= 3) {
                $totalDebit = $deductAmount / 2;

                if ($distAccountDebitBalance > $totalDebit) {

                } else {
                    $totalDebit = $distAccountDebitBalance;

                    $completeStatus = true;
                }
            } else {*/
                if ($distAccountDebitBalance > $distAccountEcashBalance) {
                    $totalDebit = $distAccountEcashBalance;
                } else {
                    $totalDebit = $distAccountDebitBalance;

                    $completeStatus = true;
                }
            //}

            if ($completeStatus && $totalDebit > 0) {
                $distDB->setPackagePurchaseFlag("Y");
                $distDB->setActiveDatetime(date("Y/m/d h:i:s A"));
                $distDB->setDebitStatusCode(Globals::STATUS_COMPLETE);
                $distDB->save();

                /******************************/
                /*  Direct Sponsor Bonus
                /******************************/
                $mlm_distributor = $distDB;
                $sponsorId = $mlm_distributor->getDistributorId();
                $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getUplineDistId());
                $uplineDistId = $mlm_distributor->getUplineDistId();

                $uplinePosition = $mlm_distributor->getPlacementPosition();

                $packageDB = MlmPackagePeer::retrieveByPK($mlm_distributor->getDebitRankId());
                $packagePrice = $packageDB->getPrice();
                $pairingPoint = $packagePrice * Globals::PAIRING_POINT_BV;
                $pairingPointActual = $packagePrice;
                /**************************************/
                /*  Direct REFERRAL Bonus For Upline
                /**************************************/
                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                $directSponsorPercentage = $uplineDistPackage->getCommission();
                $directSponsorBonusAmount = $directSponsorPercentage * $packagePrice / 100;
                $totalBonusPayOut = $directSponsorPercentage;

                $firstForDRB = true;
                while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                    $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($uplineDistId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                    $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $mlm_distributor->getDistributorCode() . ")");
                    $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                    $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                    $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                    $mlm_account_ledger->save();

                    $this->mirroringAccountLedger($mlm_account_ledger, "96");

                    if ($this->checkDebitAccount($uplineDistId) == true) {
                        $debitAccountRemark = "PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $mlm_distributor->getDistributorCode() . ")";
                        $this->contraDebitAccount($uplineDistId, $debitAccountRemark, $directSponsorBonusAmount);
                    }
                    //var_dump($bonusService->checkDebitAccount($uplineDistId));
                    //exit();
                    $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                    /******************************/
                    /*  Commission
                    /******************************/
                    $c = new Criteria();
                    $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                    $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                    $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                    $commissionBalance = 0;
                    if (!$sponsorDistCommissionDB) {
                        $sponsorDistCommissionDB = new MlmDistCommission();
                        $sponsorDistCommissionDB->setDistId($uplineDistId);
                        $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                        $sponsorDistCommissionDB->setCreatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistCommissionDB->setUpdatedBy(Globals::SYSTEM_USER_ID);
                    } else {
                        $commissionBalance = $sponsorDistCommissionDB->getBalance();
                    }
                    $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                    $sponsorDistCommissionDB->setUpdatedBy(Globals::SYSTEM_USER_ID);
                    $sponsorDistCommissionDB->save();

                    $c = new Criteria();
                    $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                    $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                    $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                    $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                    $dsbBalance = 0;
                    if ($sponsorDistCommissionLedgerDB)
                        $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                    $sponsorDistCommissionledger->setDistId($uplineDistId);
                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_REGISTER);
                    $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                    $sponsorDistCommissionledger->setDebit(0);
                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                    $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                    if ($firstForDRB == true) {
                        $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                        $firstForDRB = false;
                    } else {
                        $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                    }
                    $sponsorDistCommissionledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                    $sponsorDistCommissionledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                    $sponsorDistCommissionledger->save();

                    $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                    //var_dump("==>1");
                    //var_dump("totalBonusPayOut=".$totalBonusPayOut);
                    if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT && $uplineDistDB) {
                        //var_dump("==>2");
                        $checkCommission = true;
                        $uplineDistId = $uplineDistDB->getUplineDistId();
                        while ($checkCommission == true) {
                            //var_dump("==>3**".$uplineDistId);
                            $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                            //var_dump("==>3$$".$uplineDistId);
                            if (!$uplineDistDB) {
                                break;
                            }

                            if ($uplineDistDB->getIsIb() == Globals::YES) {
                                /*if ($uplineDistDB->getIbRankId() != null) {
                                    $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                                } else {
                                    $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                }*/
                                $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                            } else {
                                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                $directSponsorPercentage = $uplineDistPackage->getCommission();
                            }
                            if ($directSponsorPercentage > $totalBonusPayOut) {
                                //var_dump("==>6");
                                $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                                $totalBonusPayOut += $directSponsorPercentage;
                                if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                    //var_dump("==>7");
                                    $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                                }
                            } else {
                                //var_dump("==>8");
                                $uplineDistId = $uplineDistDB->getUplineDistId();
                                continue;
                            }

                            $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
                            $checkCommission == false;
                            break;
                            //var_dump("==>9");
                        }
                    } else {
                        break;
                        //var_dump("==>^^");
                    }
                }

                if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
                    while ($level < 200) {
                        //var_dump($uplineDistDB->getUplineDistId());
                        //var_dump($uplineDistDB->getUplineDistCode());
                        print_r("<br>");
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
                            $sponsorDistPairingDB->setCreatedBy(Globals::SYSTEM_USER_ID);
                        } else {
                            $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                            $rightBalance = $sponsorDistPairingDB->getRightBalance();
                        }
                        $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
                        $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
                        $sponsorDistPairingDB->setUpdatedBy(Globals::SYSTEM_USER_ID);
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
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                        $sponsorDistPairingledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistPairingledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                        $sponsorDistPairingledger->save();

                        $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                        if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                            break;
                        }

                        $uplinePosition = $uplineDistDB->getPlacementPosition();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                        $level++;
                    }
                }

                $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_EPOINT);
                $distAccountDebitBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);
            }

            if ($totalDebit > 0) {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DEBIT_ACCOUNT);
                $mlm_account_ledger->setRemark("DEBITED TO DEBIT ACCOUNT");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($totalDebit);
                $mlm_account_ledger->setBalance($distAccountEcashBalance - $totalDebit);
                $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "97");

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($distId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ECASH_DEBIT);
                $mlm_account_ledger->setRemark($debitAccountRemark);
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($totalDebit);
                $mlm_account_ledger->setBalance($distAccountDebitBalance - $totalDebit);
                $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
                $mlm_account_ledger->save();

                $this->mirroringAccountLedger($mlm_account_ledger, "98");
            }

            $con->commit();

        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return true;
    }

    function doCalculateSpecialBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_SPECIAL_BONUS . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
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
    function doCalculateFundManagementBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_FUND_MANAGEMENT . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
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
    function doCalculatePipsRebateBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_CREDIT_REFUND . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
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
    function doCalculateGenerationBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_PIPS_BONUS . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
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
    function doCalculateGrb($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_GDB . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
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
    function doCalculateDrb($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_DRB . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
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
    function doCountrySales($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL, dist.country FROM mlm_dist_commission_ledger ledger
            LEFT JOIN mlm_distributor dist ON dist.distributor_id = ledger.dist_id";

        $query .= " WHERE ledger.commission_type = '" . Globals::COMMISSION_TYPE_DRB . "'";
        $query .= " AND ledger.created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND ledger.created_on <= '" . $queryDate . " 23:59:59' GROUP BY dist.country";
        //var_dump($query);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $countrySales = "";
        while ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                $country = $arr["country"];
                if ($arr["country"] == "Korea South") {
                    $country = "Korea";
                }
                $countrySales .= $country.":".number_format($arr["SUB_TOTAL"] * 10,0)."<br>";
            } else {
                $countrySales .= "";
            }
        }
        return $countrySales;
    }
    function doCalculatePackage($queryDate)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $mlm_packages = MlmPackagePeer::doSelect($c);

        $resultArr = array();
        $count = 0;
        foreach ($mlm_packages as $package) {
            $resultArr[$count]["packageId"] = $package->getPackageId();
            $resultArr[$count]["name"] = $package->getPackageName();
            $resultArr[$count]["price"] = $package->getPrice();

            $totalPurchasePackage = $this->doTotalPurchasePackage($queryDate, $package->getPackageId());
            $totalUpgradePackage = $this->doTotalUpgradePackage($queryDate, $package->getPackageId());
            $resultArr[$count]["qty"] = $totalPurchasePackage + $totalUpgradePackage;
            $count++;
        }

        return $resultArr;
    }
    function doCalculateTotalSales($queryDate)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $mlm_packages = MlmPackagePeer::doSelect($c);

        $resultArr = array();
        $count = 0;
        $totalSales = 0;
        foreach ($mlm_packages as $package) {
            $resultArr[$count]["packageId"] = $package->getPackageId();
            $resultArr[$count]["name"] = $package->getPackageName();
            $resultArr[$count]["price"] = $package->getPrice();

            $totalPurchasePackage = $this->doTotalPurchasePackage($queryDate, $package->getPackageId());
            $totalUpgradePackage = $this->doTotalUpgradePackage($queryDate, $package->getPackageId());
            $resultArr[$count]["qty"] = $totalPurchasePackage + $totalUpgradePackage;

            $totalSales += ($totalPurchasePackage + $totalUpgradePackage) * $package->getPrice();
            $count++;
        }

        return $totalSales;
    }
    function doTotalPurchasePackage($queryDate, $packageId)
    {
        $query = "select count(rank_id) as SUB_TOTAL from mlm_distributor
                    where rank_id = ".$packageId;

        $query .= " AND loan_account = 'N'";
        $query .= " AND active_datetime >= '" . $queryDate . " 00:00:00'";
        $query .= " AND active_datetime <= '" . $queryDate . " 23:59:59'";
        $query .= " group by rank_id";
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
    function doTotalUpgradePackage($queryDate, $packageId)
    {
        $query = "select count(package_id) as SUB_TOTAL from mlm_package_upgrade_history
                    where package_id = ".$packageId;

        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        $query .= " group by package_id";
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
            $tbl_account->setCreatedBy(Globals::SYSTEM_USER_ID);
            $tbl_account->setUpdatedBy(Globals::SYSTEM_USER_ID);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
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
            $tbl_account->setCreatedBy(Globals::SYSTEM_USER_ID);
            $tbl_account->setUpdatedBy(Globals::SYSTEM_USER_ID);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
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

    function mirroringAccountLedger($mlmAccountLedger, $internalRemark)
    {
        $log_account_ledger = new LogAccountLedger();
        $log_account_ledger->setAccountId($mlmAccountLedger->getAccountId());
        $log_account_ledger->setAccessIp($this->getCustormerIpaddress());
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

    function getCustormerIpaddress()
    {
        if (isset ($_SERVER)) {
            if (isset ($_SERVER ['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER ['HTTP_X_FORWARDED_FOR']);

                foreach ($arr as $ip) {
                    $ip = trim($ip);

                    if ($ip != 'unknown') {
                        $realip = $ip;

                        break;
                    }
                }
            } elseif (isset ($_SERVER ['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER ['HTTP_CLIENT_IP'];
            } else {
                if (isset ($_SERVER ['REMOTE_ADDR'])) {
                    $realip = $_SERVER ['REMOTE_ADDR'];
                } else {
                    $realip = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }

        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty ($onlineip [0]) ? $onlineip [0] : '0.0.0.0';
        return $realip;
    }
}
