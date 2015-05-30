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
    public function executeDoGeneratePairingPoint()
    {
        $c = new Criteria();
        //$c->add(SssApplicationPeer::STATUS_CODE, "PAIRING");
        $c->setLimit(1);
        $sssApplications = SssApplicationPeer::doSelect($c);

        /******************************/
        /*  store Pairing points
        /******************************/
        foreach ($sssApplications as $sssApplication) {
            $totalAmountConvertedWithCp2Cp3 = $sssApplication->getTotalShareConverted() * $sssApplication->getShareValue();

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
        $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
        /*if ($roiRemainingMonth >= 10) {
            $roiPercentage = 0;
        }*/
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
        $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
        $remarks = "";
        /*if ($roiRemainingMonth >= 10) {
            $remarks = "ROI:".$roiPercentage."%";
            $roiPercentage = 0;
        }*/
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
            $sss_application->setRemarks($remarks);
            $sss_application->setSignature($this->signature);
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

            $query = "UPDATE mlm_roi_dividend SET status_code = 'SSS', updated_on = ?, updated_by = ?  WHERE status_code = 'PENDING' AND dist_id = " . $distId;
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
        return $this->redirect('/offerToSwapRshare/index');
    }

    public function executeSwapNote()
    {
    }

    function getFetchMt4List($distId, $mt4UserName)
    {
        $query = "SELECT distinct dist_id, mt4_user_name
	        FROM mlm_roi_dividend WHERE idx > 0 and idx <= 18 AND status_code = 'PENDING'
	        AND dist_id = " . $distId;


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
            $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
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
}