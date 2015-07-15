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
    public function executeRemoveDuplicateErrorRecord()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_ERROR);
        if ($this->getRequestParameter('q') != "") {
            $c->add(SssApplicationPeer::DIST_ID, $this->getRequestParameter('q'));
        }
        //$c->setLimit(100);
        $sssApplications = SssApplicationPeer::doSelect($c);

        print_r("<br>".count($sssApplications));
        foreach ($sssApplications as $sssApplication) {
            print_r("<br>SSS::: ".$sssApplication->getSssId().", Dist: ".$sssApplication->getDistId().", mt4: ".$sssApplication->getMt4UserName());

            $c = new Criteria();
            $c->add(SssApplicationPeer::MT4_USER_NAME, $sssApplication->getMt4UserName());
            $c->add(SssApplicationPeer::SSS_ID, $sssApplication->getSssId(), Criteria::NOT_EQUAL);
            //$c->add(SssApplicationPeer::STATUS_CODE, "SUCCESS", Criteria::NOT_EQUAL);
            $sssApplicationExist = SssApplicationPeer::doSelectOne($c);

            if ($sssApplicationExist) {
                if ($sssApplicationExist->getTotalShareConverted() == $sssApplication->getTotalShareConverted()) {
                    print_r("<br>need to remove +++++++");
                    $sssApplication->delete();
                } else {
                    print_r("<br>exist but not sames ********");
                }
            } else {
                print_r("not exist");
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeReverseErrorToPairing()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_ERROR);
        if ($this->getRequestParameter('q') != "") {
            $c->add(SssApplicationPeer::DIST_ID, $this->getRequestParameter('q'));
        }
        $c->setLimit(100);
        $sssApplications = SssApplicationPeer::doSelect($c);

        print_r("<br>".count($sssApplications));
        foreach ($sssApplications as $sssApplication) {
            print_r("<br>SSS::: ".$sssApplication->getSssId().", Dist: ".$sssApplication->getDistId().", mt4: ".$sssApplication->getMt4UserName());

            $mt4Balance = $this->getMt4Balance($sssApplication->getDistId(), $sssApplication->getMt4UserName());

            if ($mt4Balance == null) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err803:Invalid Action."));
                return $this->redirect('/offerToSwapRshare/index');
            }

            $roiPercentage = $sssApplication->getRoiPercentage();
            $roiRemainingMonth = $sssApplication->getRoiRemainingMonth();
            $remarks = "";
            $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

            if ($sssApplication->getSwapType() == "SES") {
                $roiRemainingMonth = 0;
            }
            $totalAmountConverted = $mt4Balance + ($mt4Balance * $roiRemainingMonth * $roiPercentage / 100);
            $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted + $this->convertedCp2 + $this->convertedCp3;
            $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

            $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
            if ($sssApplication->getSwapType() == "SES") {
                $totalRshare = $totalAmountConvertedWithCp2Cp3;
            }
            $totalRshare = round($totalRshare);

            if ($sssApplication->getSwapType() == "SES") {
                $sssApplication->setTotalShareConverted($totalRshare);
                $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);

                $pairingBonusAmount = $sssApplication->getTotalShareConverted();
                $ecashBalance = $this->getAccountBalance($sssApplication->getDistId(), Globals::ACCOUNT_TYPE_RT2);

                $tbl_account_ledger2 = new MlmAccountLedger();
                $tbl_account_ledger2->setAccountType(Globals::ACCOUNT_TYPE_RT2);
                $tbl_account_ledger2->setDistId($sssApplication->getDistId());
                $tbl_account_ledger2->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SWAP_SSS);
                $tbl_account_ledger2->setCredit($pairingBonusAmount);
                $tbl_account_ledger2->setDebit(0);
                $tbl_account_ledger2->setRemark("");
                $tbl_account_ledger2->setBalance($ecashBalance + $pairingBonusAmount);
                $tbl_account_ledger2->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger2->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger2->save();

                $c = new Criteria();
                $c->add(GgMemberWalletPeer::UID, $sssApplication->getDistId());
                $ggMemberWallet = GgMemberWalletPeer::doSelectOne($c);

                $balance = 0;
                if (!$ggMemberWallet) {
                    $ggMemberWallet = new GgMemberWallet();
                    $ggMemberWallet->setUid($sssApplication->getDistId());
                    $ggMemberWallet->setRt2wallet(0);
                    $ggMemberWallet->setDescr("");
                    $ggMemberWallet->setCdate(date('Y-m-d H:i:s'));
                    $ggMemberWallet->save();
                }
                $balance = $ggMemberWallet->getRt2wallet() + $pairingBonusAmount;

                $gg_member_rtwallet_record = new GgMemberRt2walletRecord();
                $gg_member_rtwallet_record->setUid($sssApplication->getDistId());
                $gg_member_rtwallet_record->setActionType('SWAP SES from Maxim');
                $gg_member_rtwallet_record->setCredit($pairingBonusAmount);
                $gg_member_rtwallet_record->setDebit(0);
                $gg_member_rtwallet_record->setBalance($balance);
                $gg_member_rtwallet_record->setDescr("");
                $gg_member_rtwallet_record->setCdate(date('Y-m-d H:i:s'));
                $gg_member_rtwallet_record->save();

                $ggMemberWallet->setRt2wallet($balance);
                $ggMemberWallet->save();
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAutoSwapMemberAction()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::SSS_ID, $this->getRequestParameter('id'));
        $c->add(SssApplicationPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $sssApplication = SssApplicationPeer::doSelectOne($c);

        if (!$sssApplication) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Error801: Invalid Action."));
            return $this->redirect('/offerToSwapRshare/list');
        }

        if ($sssApplication->getSwapType() == "ASSS" && ($sssApplication->getStatusCode() == Globals::STATUS_SSS_PAIRING_ASSS || $sssApplication->getStatusCode() == Globals::STATUS_SSS_PENDING)) {

        } else {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Error802: Invalid Action."));
            return $this->redirect('/offerToSwapRshare/list');
        }

        $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

        if ($this->getRequestParameter('doAction') == "confirm") {
            $sssApplication->setClientAction(Globals::STATUS_SSS_CLIENT_ACTION_CONFIRM);
        } else if ($this->getRequestParameter('doAction') == "decline") {
            $sssApplication->setClientAction(Globals::STATUS_SSS_CLIENT_ACTION_DECLINE);
        }
        $sssApplication->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your application has been submitted successfully."));
        return $this->redirect('/offerToSwapRshare/list');
    }
    public function executeDoUpdateAsssPendingToAsssPairing()
    {
        $sssIds = "14248,14405,14546,14561,14567,14708,17084,17089,17223,17461,17465,17485,19162,19335,20534,20536,20669,20671,20673,31256,31367,31616,32849,32850,32983,33008,33010,33284,33289,33382,33418,33506,33523,33548,33563,33577,33746";
        $array = explode(',', $sssIds);

        $c = new Criteria();
        $c->add(SssApplicationPeer::SSS_ID, $array, Criteria::IN);
        $sssApplications = SssApplicationPeer::doSelect($c);

        foreach ($sssApplications as $sssApplication) {
            print_r($sssApplication->getDistId()."<br>");
            //$sssApplication->setStatusCode(Globals::STATUS_SSS_PENDING_ASSS);
            $distributorDB = MlmDistributorPeer::retrieveByPK($sssApplication->getDistId());
            if ($distributorDB) {
                $rwalletBalance = $this->getTotalOfRShare($sssApplication->getDistId());

                $totalRshare = $sssApplication->getTotalShareConverted();
                $rwalletBalance = $rwalletBalance + $totalRshare;
                // credited S4
                $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                $ggMemberRwalletRecord->setUid($sssApplication->getDistId());
                $ggMemberRwalletRecord->setAid(0);
                $ggMemberRwalletRecord->setActionType("SSS");
                $ggMemberRwalletRecord->setType("credit");
                $ggMemberRwalletRecord->setAmount($totalRshare);
                $ggMemberRwalletRecord->setBal($rwalletBalance);
                $ggMemberRwalletRecord->setDescr("Super Share Swap (CP2/CP3), REF:".$sssApplication->getSssId());
                $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                $ggMemberRwalletRecord->save();

                if ($distributorDB) {
                    $distributorDB->setRwallet($rwalletBalance);
                    $distributorDB->save();
                }

                $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);
                $sssApplication->save();
            } else {
                $remark = $sssApplication->getRemarks();
                if ($remark != ""){
                    $remark .= "; ";
                }
                $remark .= date('Y-m-d H:i:s') .": Member ID Invalid.";
                $sssApplication->setRemarks($remark);
                $sssApplication->setStatusCode(Globals::STATUS_SSS_ERROR);
                $sssApplication->save();
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoAutoConvertSSS()
    {
        /*$query = "SELECT distinct roi.mt4_user_name, roi.dist_id FROM mlm_roi_dividend roi
                  WHERE roi.status_code = 'PENDING' AND dist_id IN (270844,270854,270855,270857,270865,270867,271628,271899,271902,271903,271906,271907,271908,271911,271916,272727,273016,273054,273055,274372,274376,274378,274382,275265,275274,275275,275281,275316,275321,275332,275342,275343,275346,275351,275352,275355,275391,275395,275403,275656,277268,277305,277732,277734,277865,278897,278899,278907,278913,278919,278920,279783,280072,283731,284197,284269,284617,285150,285249,285291,285301,286197,286390,286468,287030,287275,287411,287456,287510,287551,287553,287567,287618,287625,287652,287664,287732,287824,287836,287841,287849,287945,288735,289375,289415,289574,289584,290066,290774,291261,291661,291666,291969,292240,292949,293155,293221,293287,294050,294110,294454,294554,294577,294780,294950,295490,295537,296151,296390,296414,296733,296863,296889,296903,296908,296987,297593,297680,297848,298181,298377,298446,299080,299106,299465,300105,300126,300227,300348,300420,300491,300595,300667,300701,300732,300971,300985,301941,301977,302295,302545,302619,302718,302811,303070,303222,303233,303502,303509,303579,303701,303893,304065,304247,304756,305021,305090,305128,305440,305525,305554,305564,305849,305960,305993,305999,306036,306095,306106,306234,306330,306403,306438,306463,306674,306832,306934,307031,307045,307411,307581,307621,308106,308172,308455,308524,309169,309206,309441,310903,310990,311252,311580,311864,311892,311895,312129,312599,312848,312850,312851,312852,312880,313007,313043,313203,313535,314643,314757,315036,315426,315585,316303,317082,317136,317170,317578,318066,318067,318200,318289,318473,318482,318576,318577,318681,318792,319246,319411,319911,320094,320134,320513,320797,322636,322974,322975,323015,323180,323346,323575,323656,323683,323832,323919,324147,324416,324461,324514,324773,324852,324987,325043,325732,325811,326565,326949,327284,327943,328281,328310,328346,328934,329282,329405,330347,330352,330637,331303,331407,331693,331700,332123,332484,332676,332728,333420,333586,334257,334650,334662,334677,334700,334753,335447,335462,335529,335570,335633,335834,336131,336172,336389,336673,337198,337286,337737,337867,338395,339532,339662,340167,340219,340578,340709,342510,343897,343907,343939,344008,346107,348007,348096,348463,348909,349540,349991,350120,350128,350293,352225,352613,354500,354617,354755,354816,355439,356263,356625,357015,357587,358071,358248,358744,359089,359281,359392,359758,360240,360271,360334,360350,360496,360911,361367,361615,361643,361652,361844,362175,362400,362658,362713,362776,362972,363219,364527,365219,365550,366364,366942,367454,367463,367728,368022,368760,370108,370186,370729,371653,372050,373410,373466,376609,377035) LIMIT 50";*/

        $query = "SELECT distinct roi.mt4_user_name, roi.dist_id FROM mlm_roi_dividend roi
                    INNER JOIN  mlm_distributor dist ON roi.dist_id = dist.distributor_id
                AND dist.tree_structure like '%|271054|%'
                  WHERE roi.status_code = 'PENDING' LIMIT 300";

        /*$query = "SELECT distinct roi.mt4_user_name, roi.dist_id FROM mlm_roi_dividend roi
                    INNER JOIN  mlm_distributor dist ON roi.dist_id = dist.distributor_id
                AND dist.leader_id not in (255709,255607,264845,273056,255882,254781,254842,682)
                  WHERE roi.status_code = 'PENDING' LIMIT 300";*/

        /*$query = "SELECT distinct roi.mt4_user_name, roi.dist_id FROM mlm_roi_dividend roi
                    INNER JOIN  mlm_roi_dividend roi2 ON roi.mt4_user_name = roi2.mt4_user_name
                    INNER JOIN  mlm_distributor dist ON roi.dist_id = dist.distributor_id
                AND dist.tree_structure like '%|270844|%'
                    AND roi2.idx = 11 and roi2.status_code =  'SUCCESS'
                WHERE roi.idx >= 12 and roi.status_code = 'PENDING' LIMIT 300";*/

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //exit();
        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $distributorDB = MlmDistributorPeer::retrieveByPK($arr['dist_id']);
            $this->mt4Id = $arr['mt4_user_name'];

            print_r("<br>".$this->mt4Id);

            if (!$this->mt4Id) {
                print_r("err801:Invalid Action.");
                return sfView::HEADER_ONLY;
            }
            $distId = $arr['dist_id'];
            $this->mt4Ids = $this->getFetchMt4List($distId, $this->mt4Id);
            $this->mt4Balance = 0;
            $this->remainingRoiAmount = 0;

            $mt4UserName = $this->mt4Id;

            if (count($this->mt4Ids) <= 0) {
                print_r("err802:Invalid Action.");
                return sfView::HEADER_ONLY;
            }

            $mt4Balance = $this->getMt4Balance($distId, $mt4UserName);
            $roiArr = $this->getRoiInformation($distId, $mt4UserName);

            if ($mt4Balance == null) {
                print_r("err803:Invalid Action.");
                $query = "UPDATE mlm_roi_dividend SET status_code = 'ASSS ERROR', updated_on = ?, updated_by = ?  WHERE status_code = 'PENDING' AND dist_id = " . $distId;
                $query = $query . " AND mt4_user_name = ?";
                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $statement->set(1, date('Y-m-d H:i:s'));
                $statement->set(2, $this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $statement->set(3, $mt4UserName);
                $statement->executeUpdate();
                continue;
                //return sfView::HEADER_ONLY;
            }

            $roiPercentage = $roiArr['roi_percentage'];
            $roiRemainingMonth = 0;
            if ($roiArr['idx'] <= 18) {
                $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
            } else {
                $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
            }
            $remarks = "";
            $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

            $this->mt4Balance = $mt4Balance;
            $this->remainingRoiAmount = $remainingRoiAmount;
            $this->roiRemainingMonth = $roiRemainingMonth;
            $this->roiPercentage = $roiPercentage;

            $totalAmountConverted = $mt4Balance + ($mt4Balance * $roiRemainingMonth * $roiPercentage / 100);
            $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted;
            $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

            $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
            if ($totalRshare < 0) {
                $totalRshare = 0;
            }
            $this->totalRshare = round($totalRshare);

            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();

                $roiStatus = "ASSS";
                $sss_application = new SssApplication();
                $sss_application->setDistId($distId);
                $sss_application->setDividendId($roiArr['devidend_id']);
                $sss_application->setMt4UserName($mt4UserName);
                $sss_application->setCp2Balance(0);
                $sss_application->setCp3Balance(0);
                $sss_application->setMt4Balance($this->mt4Balance);
                $sss_application->setRoiRemainingMonth($roiRemainingMonth);
                $sss_application->setRoiPercentage($roiPercentage);
                $sss_application->setShareValue(0.8);
                $sss_application->setTotalShareConverted($totalRshare);
                $sss_application->setRemarks($remarks);
                $sss_application->setSignature($distributorDB->getDistributorCode());
                $sss_application->setSwapType($roiStatus);
                $sss_application->setStatusCode(Globals::STATUS_SSS_PENDING);
                $sss_application->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sss_application->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sss_application->save();

                $query = "UPDATE mlm_roi_dividend SET status_code = '".$roiStatus."', updated_on = ?, updated_by = ?  WHERE status_code = 'PENDING' AND dist_id = " . $distId;
                $query = $query . " AND mt4_user_name = ?";
                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $statement->set(1, date('Y-m-d H:i:s'));
                $statement->set(2, $this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $statement->set(3, $mt4UserName);
                $statement->executeUpdate();

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }
        print_r("done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoCp2cp3Swap()
    {
        $distributorDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->mt4Id = $this->getRequestParameter('mt4Id');
        $this->ignoreMt4 = $this->getRequestParameter('ignoreMt4');

        if (!$this->mt4Id) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err801:Invalid Action."));
            return $this->redirect('/offerToSwapRshare/cp2cp3Swap');
        }

        $this->mt4Balance = 0;
        $this->remainingRoiAmount = 0;
        $mt4UserName = $this->getRequestParameter('mt4Id');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);

        if ($this->ignoreMt4 == "N") {
            $this->mt4Ids = $this->getSwapedMt4($this->getUser()->getAttribute(Globals::SESSION_DISTID), $this->getRequestParameter('mt4Id'));
            if (count($this->mt4Ids) <= 0) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err802:Invalid Action."));
                return $this->redirect('/offerToSwapRshare/cp2cp3Swap');
            }
        }

        //$mt4Balance = $this->getMt4Balance($distId, $mt4UserName);
        $mt4Balance = 0;
//        $mt4Balance = 5000;
        $roiArr = $this->getRoiInformation($distId, $mt4UserName);

        /*if ($mt4Balance == null) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err803:Invalid Action."));
            return $this->redirect('/offerToSwapRshare/cp2cp3Swap');
        }*/

        $roiPercentage = $roiArr['roi_percentage'];
        $roiRemainingMonth = 0;
        /*if ($roiArr['idx'] <= 18) {
            $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
        } else {
            $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
        }*/
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
        if ($this->convertedCp2 <= 0 && $this->convertedCp3 <= 0) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid CP2 / CP3 Balance."));
            return $this->redirect('/offerToSwapRshare/cp2cp3Swap');
        }
        if ($this->convertedCp2 > $this->cp2Balance) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Insufficient CP2 Balance."));
            return $this->redirect('/offerToSwapRshare/cp2cp3Swap');
        }
        if ($this->convertedCp3 > $this->cp3Balance) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Insufficient CP3 Balance."));
            return $this->redirect('/offerToSwapRshare/cp2cp3Swap');
        }
        $totalAmountConvertedWithCp2Cp3 = $this->convertedCp2 + $this->convertedCp3;
        $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);

        $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;

        $this->totalRshare = round($totalRshare);

        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            $sss_application = new SssApplication();
            $sss_application->setDistId($distId);
            $sss_application->setDividendId(0);
            $sss_application->setMt4UserName($mt4UserName);
            $sss_application->setCp2Balance($this->convertedCp2);
            $sss_application->setCp3Balance($this->convertedCp3);
            $sss_application->setMt4Balance(0);
            $sss_application->setRoiRemainingMonth(0);
            $sss_application->setRoiPercentage(0);
            $sss_application->setShareValue(0.8);
            $sss_application->setTotalShareConverted($totalRshare);
            $sss_application->setTotalAmountConvertedWithCp2cp3($totalAmountConvertedWithCp2Cp3);
            $sss_application->setRemarks($remarks);
            $sss_application->setSignature("");
            $sss_application->setStatusCode(Globals::STATUS_SSS_SUCCESS);
            $sss_application->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sss_application->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sss_application->save();

            $rwalletBalance = $distributorDB->getRwallet();
            $totalRshare = $sss_application->getTotalShareConverted();
            $rwalletBalance = $rwalletBalance + $totalRshare;
            // credited S4
            $ggMemberRwalletRecord = new GgMemberRwalletRecord();
            $ggMemberRwalletRecord->setUid($sss_application->getDistId());
            $ggMemberRwalletRecord->setAid(0);
            $ggMemberRwalletRecord->setActionType("SSS");
            $ggMemberRwalletRecord->setType("credit");
            $ggMemberRwalletRecord->setAmount($totalRshare);
            $ggMemberRwalletRecord->setBal($rwalletBalance);
            $ggMemberRwalletRecord->setDescr("Super Share Swap (CP2/CP3), REF:".$sss_application->getSssId());
            $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
            $ggMemberRwalletRecord->save();

            if ($distributorDB) {
                $distributorDB->setRwallet($rwalletBalance);
                $distributorDB->save();
            }

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
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your application has been submitted and pending for approval."));
        return $this->redirect('/offerToSwapRshare/cp2cp3Swap');
    }
    public function executeCp2cp3Swap()
    {
        $this->distributorDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->mt4Ids = $this->getSwapedMt4($this->getUser()->getAttribute(Globals::SESSION_DISTID), "");
        $this->mt4Balance = 0;
        $this->remainingRoiAmount = 0;
        $this->cp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->cp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->totalRshare = 0;
        $this->roiRemainingMonth = 0;
        $this->roiPercentage = 0;
        $this->ignoreMt4 = $this->getRequestParameter('ignoreMt4','N');
    }
    public function executeDoAutoConvertEShare()
    {
        // monkey 254781
        $query = "SELECT roi.devidend_id, roi.dist_id, roi.mt4_user_name, roi.idx, roi.account_ledger_id
                    , roi.dividend_date, roi.package_id, roi.package_price, roi.roi_percentage
                    , roi.mt4_balance, roi.dividend_amount, roi.remarks, roi.status_code
                    , roi.created_by, roi.created_on, roi.updated_by, roi.updated_on
                    , roi.first_dividend_date
                    , dist.leader_id
                FROM mlm_roi_dividend roi
                    LEFT JOIN mlm_distributor dist ON dist.distributor_id = roi.dist_id
                WHERE roi.idx = 18 and roi.status_code = 'PENDING'";

        $query2 = "and dist.leader_id = 254781 limit 50";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //exit();
        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $mt4UserName = $arr['mt4_user_name'];
            $distId = $arr['dist_id'];
            $package_price = $arr['package_price'];

            print_r("<br>mt4:".$mt4UserName);

            $this->remainingRoiAmount = 0;

            $mt4Balance = $package_price;
            $roiArr = $this->getRoiInformation($distId, $mt4UserName);

            $roiPercentage = $roiArr['roi_percentage'];
            $roiRemainingMonth = 0;
            $remarks = "AUTO SWAP R-SHARE";

            $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

            $this->swapToRt = $this->getRequestParameter('swapToRt', '');
            $this->mt4Balance = $mt4Balance;
            $this->remainingRoiAmount = $remainingRoiAmount;

            $this->convertedCp2 = $this->getRequestParameter('convertedCp2', 0);
            $this->convertedCp3 = $this->getRequestParameter('convertedCp3', 0);

            $this->convertedCp2 = str_replace(",", "", $this->convertedCp2);
            $this->convertedCp3 = str_replace(",", "", $this->convertedCp3);

            $this->roiRemainingMonth = $roiRemainingMonth;
            $this->roiPercentage = $roiPercentage;

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

                $mlm_distributor = MlmDistributorPeer::retrieveByPk($distId);
                if (!$mlm_distributor) {
                    continue;
                }
                $uplinePosition = $mlm_distributor->getPlacementPosition();
                $pairingPoint = $totalAmountConvertedWithCp2Cp3 * Globals::PAIRING_POINT_BV;
                $pairingPointActual = $totalAmountConvertedWithCp2Cp3;

                print_r("<br>".$mlm_distributor->getDistributorId());

                $pairingPointActual = $totalAmountConverted;
                $pairingPoint = $pairingPointActual * Globals::PAIRING_POINT_BV;
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

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoAutoConvertEShare_ori()
    {
        // monkey 254781
        $query = "SELECT roi.devidend_id, roi.dist_id, roi.mt4_user_name, roi.idx, roi.account_ledger_id
                    , roi.dividend_date, roi.package_id, roi.package_price, roi.roi_percentage
                    , roi.mt4_balance, roi.dividend_amount, roi.remarks, roi.status_code
                    , roi.created_by, roi.created_on, roi.updated_by, roi.updated_on
                    , roi.first_dividend_date
                    , dist.leader_id
                FROM mlm_roi_dividend roi
                    LEFT JOIN mlm_distributor dist ON dist.distributor_id = roi.dist_id
                WHERE roi.idx = 36 and roi.status_code = 'PENDING'";

        $query2 = "and dist.leader_id = 254781 limit 50";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //exit();
        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $mt4UserName = $arr['mt4_user_name'];
            $distId = $arr['dist_id'];

            print_r("<br>mt4:".$mt4UserName);

            $this->mt4Balance = 0;
            $this->remainingRoiAmount = 0;

            $mt4Balance = $this->getMt4Balance($distId, $mt4UserName);
            $roiArr = $this->getRoiInformation($distId, $mt4UserName);

            if ($mt4Balance == null) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("err803:Invalid Action.".$mt4UserName));
                return $this->redirect('/offerToSwapRshare/index');
            }

            $roiPercentage = $roiArr['roi_percentage'];
            $roiRemainingMonth = 0;
            $remarks = "AUTO SWAP R-SHARE";

            $remainingRoiAmount = $mt4Balance * $roiRemainingMonth * $roiPercentage / 100;

            $this->swapToRt = $this->getRequestParameter('swapToRt', '');
            $this->mt4Balance = $mt4Balance;
            $this->remainingRoiAmount = $remainingRoiAmount;

            $this->convertedCp2 = $this->getRequestParameter('convertedCp2', 0);
            $this->convertedCp3 = $this->getRequestParameter('convertedCp3', 0);

            $this->convertedCp2 = str_replace(",", "", $this->convertedCp2);
            $this->convertedCp3 = str_replace(",", "", $this->convertedCp3);

            $this->roiRemainingMonth = $roiRemainingMonth;
            $this->roiPercentage = $roiPercentage;

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
                $sss_application->setCp2Balance(0);
                $sss_application->setCp3Balance(0);
                $sss_application->setMt4Balance($this->mt4Balance);
                $sss_application->setRoiRemainingMonth($roiRemainingMonth);
                $sss_application->setRoiPercentage($roiPercentage);
                $sss_application->setShareValue(0.8);
                $sss_application->setTotalShareConverted($totalRshare);
                $sss_application->setRemarks($remarks);
                $sss_application->setSignature($this->signature);
                $sss_application->setStatusCode(Globals::STATUS_SSS_SUCCESS);
                $sss_application->setSwapType("ASS");
                $sss_application->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sss_application->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sss_application->save();

                $roiStatus = "ASS";
                $query = "UPDATE mlm_roi_dividend SET status_code = '" . $roiStatus . "', updated_on = ?, updated_by = ?  WHERE status_code = 'PENDING' AND dist_id = " . $distId;
                $query = $query . " AND mt4_user_name = ?";
                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $statement->set(1, date('Y-m-d H:i:s'));
                $statement->set(2, $this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $statement->set(3, $mt4UserName);
                $statement->executeUpdate();

                // disabled MT4
                $mt4request = new CMT4DataReciver;
                $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

                $params['array'] = array();
                $params['login'] = $mt4UserName;
                var_dump($params);
                $answer = $mt4request->MakeRequest("getaccountinfo", $params);
                var_dump($answer);
                print_r("<br><br>");
                if ($answer['result'] != 1) {
                    var_dump("<br>error:" . $answer["reason"]);
                    //return sfView::HEADER_ONLY;
                    $remark = $sss_application->getRemarks();
                    if ($remark != "") {
                        $remark .= "; ";
                    }
                    //$remark .= date('Y-m-d H:i:s') .": MT4 Account not exist.";
                    $sss_application->setRemarks($remark);
                    //$sssApplication->setStatusCode("ERROR");
                    $sss_application->save();
                } else {
                    $comment = $answer["comment"];
                    $mt4Enable = $answer["enable"];
                    $mt4Balance = $answer["balance"];
                    if ($comment != "") {
                        $comment .= ";";
                    }
                    if ($mt4Enable == "1") {
                        $comment = $comment . date('Y-m-d H:i:s') . ": Disabled (SSS)";
                        $params['comment'] = $comment;
                        $params['enable'] = "0"; // 1 = enabled, 0 = disabled
                        $answer = $mt4request->MakeRequest("modifyaccount", $params);
                        //print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$packagePrice.".</p>";
                        if ($answer['result'] != 1) {
                            var_dump("<br>error:" . $answer["reason"]);
                            $remark = $sss_application->getRemarks();
                            if ($remark != "") {
                                $remark .= "; ";
                            }
                            $remark .= date('Y-m-d H:i:s') . ": MT4 Account cannot be disabled.";
                            $sss_application->setRemarks($remark);
                            $sss_application->setStatusCode(Globals::STATUS_SSS_ERROR);
                            $sss_application->save();
                        } else {
                            $distDB = MlmDistributorPeer::retrieveByPK($distId);
                            $rwalletBalance = $distDB->getRwallet();
                            /*if ($ggMemberRwalletRecordDB) {
                                $rwalletBalance = $ggMemberRwalletRecordDB->getBal();
                            }*/
                            $rwalletBalance = $rwalletBalance + $totalRshare;
                            // credited S4
                            $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                            $ggMemberRwalletRecord->setUid($sss_application->getDistId());
                            $ggMemberRwalletRecord->setAid(0);
                            $ggMemberRwalletRecord->setActionType("ASSS");
                            $ggMemberRwalletRecord->setType("credit");
                            $ggMemberRwalletRecord->setAmount($totalRshare);
                            $ggMemberRwalletRecord->setBal($rwalletBalance);
                            $ggMemberRwalletRecord->setDescr("Super Auto Swap, REF:".$sss_application->getSssId());
                            $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                            $ggMemberRwalletRecord->save();

                            $distDB->setRwallet($rwalletBalance);
                            $distDB->save();
                        }
                    } else {
                        $remark = $sss_application->getRemarks();
                        if ($remark != "") {
                            $remark .= "; ";
                        }
                        $remark .= date('Y-m-d H:i:s') . ": MT4 Account disabled.";
                        $sss_application->setRemarks($remark);
                        $sss_application->setStatusCode(Globals::STATUS_SSS_ERROR);
                        $sss_application->save();
                    }
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }

        print_r("done");
        return sfView::HEADER_ONLY;
    }
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
        $swapType = "SSS";
        print_r("SSS");
        print_r("<br>Total: ".number_format($this->totalCountOfSss($this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType), 2));
        print_r("<br>Mt4 (< 12): ".number_format($this->totalSumOfSssByMonth("mt4_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType, "<"), 2));
        print_r("<br>Mt4 (>= 12): ".number_format($this->totalSumOfSssByMonth("mt4_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType, ">="), 2));
        print_r("<br>CP2: ".number_format($this->totalSumOfSss("cp2_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType), 2));
        print_r("<br>CP3: ".number_format($this->totalSumOfSss("cp3_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType), 2));

        return sfView::HEADER_ONLY;
    }
    public function executeReport2()
    {
        $swapType = "SES";
        print_r("<br><br>SES");
        print_r("<br>Total: ".number_format($this->totalCountOfSss($this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType), 2));
        print_r("<br>Mt4 (< 12): ".number_format($this->totalSumOfSssByMonth("mt4_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType, "<"), 2));
        print_r("<br>Mt4 (>= 12): ".number_format($this->totalSumOfSssByMonth("mt4_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType, ">="), 2));
        print_r("<br>CP2: ".number_format($this->totalSumOfSss("cp2_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType), 2));
        print_r("<br>CP3: ".number_format($this->totalSumOfSss("cp3_balance", $this->getRequestParameter('dateFrom',''), $this->getRequestParameter('dateTo',''), $swapType), 2));

        return sfView::HEADER_ONLY;
    }
    public function executeDailyBonus()
    {
        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        /*try {
            $con->begin();*/

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
                //$bonusDate = "2015-06-10";
                print_r("bonusDate=".$bonusDate."<br>");
                $level = 0;
                while ($level < 1) {
                    if ($bonusDate == $currentDate) {
                        print_r("break<br>");
                        break;
                    }
                    $limit = $this->getRequestParameter('q','');
                    $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($bonusDate)));
                    print_r("level start :".$level."<br><br>");
                    $query = "SELECT distinct dist_id FROM sss_dist_pairing_ledger WHERE created_on >= '".$yesterday." 00:00:00' AND created_on < '".$bonusDate." 00:00:00'";

                    if ($limit != "") {
                        $query .= " LIMIT ".$limit;
                    }

                    //$query = "SELECT distinct dist_id FROM sss_dist_pairing_ledger WHERE created_on >= '2015-06-09 00:00:00' AND created_on < '2015-06-10 00:00:00'";
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

                                //if ($dist && $dist->getCloseAccount() == "Y") {

                                //} else {
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
                                //}
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
            /*$con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }*/

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
    public function executeDoDisabledMt4AndCheckForMaturity_testing()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_PENDING);
        $c->add(SssApplicationPeer::DIST_ID, 275251);
        $c->setLimit(30);
        $sssApplication = SssApplicationPeer::doSelectOne($c);

        if ($sssApplication->getSwapType() == "SES") {
            $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);

            $pairingBonusAmount = $sssApplication->getTotalShareConverted();
            $ecashBalance = $this->getAccountBalance($sssApplication->getDistId(), Globals::ACCOUNT_TYPE_RT2);

            $tbl_account_ledger2 = new MlmAccountLedger();
            $tbl_account_ledger2->setAccountType(Globals::ACCOUNT_TYPE_RT2);
            $tbl_account_ledger2->setDistId($sssApplication->getDistId());
            $tbl_account_ledger2->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SWAP_SSS);
            $tbl_account_ledger2->setCredit($pairingBonusAmount);
            $tbl_account_ledger2->setDebit(0);
            $tbl_account_ledger2->setRemark("");
            $tbl_account_ledger2->setBalance($ecashBalance + $pairingBonusAmount);
            $tbl_account_ledger2->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger2->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account_ledger2->save();

            $c = new Criteria();
            $c->add(GgMemberWalletPeer::UID, $sssApplication->getDistId());
            $ggMemberWallet = GgMemberWalletPeer::doSelectOne($c);

            $balance = 0;
            if (!$ggMemberWallet) {
                $ggMemberWallet = new GgMemberWallet();
                $ggMemberWallet->setUid($sssApplication->getDistId());
                $ggMemberWallet->setRt2wallet(0);
                $ggMemberWallet->setDescr("");
                $ggMemberWallet->setCdate(date('Y-m-d H:i:s'));
                $ggMemberWallet->save();
            }
            $balance = $ggMemberWallet->getRt2wallet() + $pairingBonusAmount;

            $gg_member_rtwallet_record = new GgMemberRt2walletRecord();
            $gg_member_rtwallet_record->setUid($sssApplication->getDistId());
            $gg_member_rtwallet_record->setActionType('SWAP SES from Maxim');
            $gg_member_rtwallet_record->setCredit($pairingBonusAmount);
            $gg_member_rtwallet_record->setDebit(0);
            $gg_member_rtwallet_record->setBalance($balance);
            $gg_member_rtwallet_record->setDescr("");
            $gg_member_rtwallet_record->setCdate(date('Y-m-d H:i:s'));
            $gg_member_rtwallet_record->save();

            $ggMemberWallet->setRt2wallet($balance);
            $ggMemberWallet->save();
        } else {
            $sssApplication->setStatusCode(Globals::STATUS_SSS_PAIRING);
        }
        $sssApplication->save();

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoDisabledMt4AndCheckForMaturity()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_ERROR);
        //$c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_PENDING);
        //$c->add(SssApplicationPeer::SWAP_TYPE, "SES");
        if ($this->getRequestParameter('q') != "") {
            $c->add(SssApplicationPeer::DIST_ID, $this->getRequestParameter('q'));
        }
        $c->setLimit(100);
        $sssApplications = SssApplicationPeer::doSelect($c);

        print_r("<br>".count($sssApplications));
        foreach ($sssApplications as $sssApplication) {
            print_r("<br>SSS::: ".$sssApplication->getSssId().", Dist: ".$sssApplication->getDistId());
            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();
                $mt4Id = $sssApplication->getMt4UserName();

                $array = explode(',', Globals::STATUS_MATURITY_PENDING.",".Globals::STATUS_MATURITY_CLIENT_WITHDRAW.",".Globals::STATUS_MATURITY_WITHDRAW.",".Globals::STATUS_MATURITY_ON_HOLD);

                $c = new Criteria();
                $c->add(NotificationOfMaturityPeer::MT4_USER_NAME, $mt4Id);
                $c->add(NotificationOfMaturityPeer::STATUS_CODE, $array, Criteria::IN);
                $notificationOfMaturity = NotificationOfMaturityPeer::doSelectOne($c);

                $isValid = true;
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
                        $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sssApplication->save();
                        $isValid = false;
                    }
                }

                if ($isValid == true) {
                    // disabled MT4
                    $mt4request = new CMT4DataReciver;
                    $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

                    $params['array'] = array();
                    $params['login'] = $mt4Id;
                    //var_dump($params);
                    $answer = $mt4request->MakeRequest("getaccountinfo", $params);
                    //var_dump($answer);
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
                        $sssApplication->setStatusCode(Globals::STATUS_SSS_ERROR);
                        $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sssApplication->save();
                    } else {
                        $comment = $answer["comment"];
                        $mt4Enable = $answer["enable"];
                        $mt4Balance = $answer["balance"];
                        if ($comment != "") {
                            $comment .= ";";
                        }

                        if ($mt4Enable == "0") {
                            $pos = strrpos($comment, "Disabled (SSS)");
                            if ($pos === false) { // note: three equal signs

                            } else {
                                $array = explode(',', "PROCESS,SUCCESS");

                                $c = new Criteria();
                                $c->add(SssApplicationPeer::MT4_USER_NAME, $mt4Id);
                                $c->add(SssApplicationPeer::STATUS_CODE, $array, Criteria::IN);
                                $sssApplicationExist = SssApplicationPeer::doSelectOne($c);

                                if (!$sssApplicationExist) {
                                    $mt4Enable = "1";
                                }
                            }
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
                                $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sssApplication->save();
                            } else {
                                $sssApplication->setMt4Balance($mt4Balance);
                                if ($sssApplication->getSwapType() == "SES") {
                                    $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);

                                    $pairingBonusAmount = $sssApplication->getTotalShareConverted();
                                    $ecashBalance = $this->getAccountBalance($sssApplication->getDistId(), Globals::ACCOUNT_TYPE_RT2);

                                    $tbl_account_ledger2 = new MlmAccountLedger();
                                    $tbl_account_ledger2->setAccountType(Globals::ACCOUNT_TYPE_RT2);
                                    $tbl_account_ledger2->setDistId($sssApplication->getDistId());
                                    $tbl_account_ledger2->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SWAP_SSS);
                                    $tbl_account_ledger2->setCredit($pairingBonusAmount);
                                    $tbl_account_ledger2->setDebit(0);
                                    $tbl_account_ledger2->setRemark("");
                                    $tbl_account_ledger2->setBalance($ecashBalance + $pairingBonusAmount);
                                    $tbl_account_ledger2->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $tbl_account_ledger2->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $tbl_account_ledger2->save();

                                    $c = new Criteria();
                                    $c->add(GgMemberWalletPeer::UID, $sssApplication->getDistId());
                                    $ggMemberWallet = GgMemberWalletPeer::doSelectOne($c);

                                    $balance = 0;
                                    if (!$ggMemberWallet) {
                                        $ggMemberWallet = new GgMemberWallet();
                                        $ggMemberWallet->setUid($sssApplication->getDistId());
                                        $ggMemberWallet->setRt2wallet(0);
                                        $ggMemberWallet->setDescr("");
                                        $ggMemberWallet->setCdate(date('Y-m-d H:i:s'));
                                        $ggMemberWallet->save();
                                    }
                                    $balance = $ggMemberWallet->getRt2wallet() + $pairingBonusAmount;

                                    $gg_member_rtwallet_record = new GgMemberRt2walletRecord();
                                    $gg_member_rtwallet_record->setUid($sssApplication->getDistId());
                                    $gg_member_rtwallet_record->setActionType('SWAP SES from Maxim');
                                    $gg_member_rtwallet_record->setCredit($pairingBonusAmount);
                                    $gg_member_rtwallet_record->setDebit(0);
                                    $gg_member_rtwallet_record->setBalance($balance);
                                    $gg_member_rtwallet_record->setDescr("");
                                    $gg_member_rtwallet_record->setCdate(date('Y-m-d H:i:s'));
                                    $gg_member_rtwallet_record->save();

                                    $ggMemberWallet->setRt2wallet($balance);
                                    $ggMemberWallet->save();
                                } else {
                                    if ($sssApplication->getSwapType() == "ASS") {
                                        //$sssApplication->setStatusCode(Globals::STATUS_SSS_PENDING_ASSS);
                                        $distributorDB = MlmDistributorPeer::retrieveByPK($sssApplication->getDistId());
                                        if ($distributorDB) {
                                            $rwalletBalance = $distributorDB->getRwallet();

                                            $totalRshare = $sssApplication->getTotalShareConverted();
                                            $rwalletBalance = $rwalletBalance + $totalRshare;
                                            // credited S4
                                            $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                                            $ggMemberRwalletRecord->setUid($sssApplication->getDistId());
                                            $ggMemberRwalletRecord->setAid(0);
                                            $ggMemberRwalletRecord->setActionType("ASSS");
                                            $ggMemberRwalletRecord->setType("credit");
                                            $ggMemberRwalletRecord->setAmount($totalRshare);
                                            $ggMemberRwalletRecord->setBal($rwalletBalance);
                                            $ggMemberRwalletRecord->setDescr("Auto Super Share Swap, REF:".$sssApplication->getSssId());
                                            $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                                            $ggMemberRwalletRecord->save();

                                            if ($distributorDB) {
                                                $distributorDB->setRwallet($rwalletBalance);
                                                $distributorDB->save();
                                            }

                                            $sssApplication->setStatusCode(Globals::STATUS_SSS_PAIRING_ASSS);
                                            $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                            $sssApplication->save();
                                        } else {
                                            $remark = $sssApplication->getRemarks();
                                            if ($remark != ""){
                                                $remark .= "; ";
                                            }
                                            $remark .= date('Y-m-d H:i:s') .": Member ID Invalid.";
                                            $sssApplication->setRemarks($remark);
                                            $sssApplication->setStatusCode(Globals::STATUS_SSS_ERROR);
                                            $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                            $sssApplication->save();
                                        }
                                    } else {
                                        $sssApplication->setStatusCode(Globals::STATUS_SSS_PAIRING);
                                    }
                                }
                                $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
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
                            $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sssApplication->save();
                        }
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
    public function executeRunGeneratePairingPoint()
    {
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoGeneratePairingPoint()
    {
        $c = new Criteria();
        $c->add(SssApplicationPeer::STATUS_CODE, Globals::STATUS_SSS_PAIRING);
        if ($this->getRequestParameter('q') != "") {
            $c->add(SssApplicationPeer::DIST_ID, $this->getRequestParameter('q'));
        }
        $c->setLimit(50);
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
                    print_r("<br>skip::: ".$distributorDB->getDistributorId());
                    continue;
                }
                $entitledPairing = true;
                if ($roiArr['idx'] <= 18) {
                    $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
                } else {
                    $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
                }
                if ($roiArr['idx'] <= 0) {
                    $roiRemainingMonth = 0;
                }
                if ($roiArr['idx'] <= 12) {
                    $entitledPairing = false;
                }
                if ($roiArr['idx'] >= 19 && $roiArr['idx'] <= 36) {
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
                $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
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
                if ($sssApplication->getSwapType() == "RSHARE") {
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
                    $ggMemberRwalletRecord->setDescr("Super Share Swap, REF:".$sssApplication->getSssId());
                    $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                    $ggMemberRwalletRecord->save();

                    if ($distributorDB) {
                        $distributorDB->setRwallet($rwalletBalance);
                        $distributorDB->save();
                    }
                } else if ($sssApplication->getSwapType() == "ASSS") {
                    $rwalletBalance = $distributorDB->getRwallet();
                    /*if ($ggMemberRwalletRecordDB) {
                        $rwalletBalance = $ggMemberRwalletRecordDB->getBal();
                    }*/
                    $rwalletBalance = $rwalletBalance + $totalRshare;
                    // credited S4
                    $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                    $ggMemberRwalletRecord->setUid($sssApplication->getDistId());
                    $ggMemberRwalletRecord->setAid(0);
                    $ggMemberRwalletRecord->setActionType("ASSS");
                    $ggMemberRwalletRecord->setType("credit");
                    $ggMemberRwalletRecord->setAmount($totalRshare);
                    $ggMemberRwalletRecord->setBal($rwalletBalance);
                    $ggMemberRwalletRecord->setDescr("Auto Super Share Swap, REF:".$sssApplication->getSssId());
                    $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                    $ggMemberRwalletRecord->save();

                    if ($distributorDB) {
                        $distributorDB->setRwallet($rwalletBalance);
                        $distributorDB->save();
                    }
                }

                $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);
                $sssApplication->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sssApplication->save();

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                var_dump($e);
                //throw $e;
                break;
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoRerunRshare()
    {
        $c = new Criteria();
        //$c->add(SssApplicationPeer::DIST_ID, 262535);
        $c->add(SssApplicationPeer::STATUS_CODE, "RERUN");
        $c->add(SssApplicationPeer::SWAP_TYPE, "SES", Criteria::NOT_EQUAL);
        $c->setLimit(100);
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
                $dividendId = $sssApplication->getDividendId();

                print_r("<br><br>Dist:".$sssApplication->getDistId().",swap type:".$sssApplication->getSwapType());
                if ($sssApplication->getSwapType() == "ASS") {
                    print_r("<br>ASS");
                    if ($distributorDB) {
                        $rwalletBalance = $this->getTotalOfRShare($sssApplication->getDistId());

                        $totalRshare = $sssApplication->getTotalShareConverted();
                        $rwalletBalance = $rwalletBalance + $totalRshare;
                        // credited S4
                        $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                        $ggMemberRwalletRecord->setUid($sssApplication->getDistId());
                        $ggMemberRwalletRecord->setAid(0);
                        $ggMemberRwalletRecord->setActionType("ASSS");
                        $ggMemberRwalletRecord->setType("credit");
                        $ggMemberRwalletRecord->setAmount($totalRshare);
                        $ggMemberRwalletRecord->setBal($rwalletBalance);
                        $ggMemberRwalletRecord->setDescr("Auto Super Share Swap, REF:".$sssApplication->getSssId());
                        $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                        $ggMemberRwalletRecord->save();

                        if ($distributorDB) {
                            $distributorDB->setRwallet($rwalletBalance);
                            $distributorDB->save();
                        }

                        $sssApplication->setStatusCode(Globals::STATUS_SSS_PAIRING_ASSS);
                        $sssApplication->save();
                    }
                } else if ($sssApplication->getSwapType() == "CP4") {
                    print_r("<br>CP4");
                    $totalRshare = $sssApplication->getTotalShareConverted();
                    $rwalletBalance = $this->getTotalOfRShare($sssApplication->getDistId()) + $totalRshare;
                    // credited S4
                    $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                    $ggMemberRwalletRecord->setUid($sssApplication->getDistId());
                    $ggMemberRwalletRecord->setAid(0);
                    $ggMemberRwalletRecord->setActionType("CP4");
                    $ggMemberRwalletRecord->setType("credit");
                    $ggMemberRwalletRecord->setAmount($totalRshare);
                    $ggMemberRwalletRecord->setBal($rwalletBalance);
                    $ggMemberRwalletRecord->setDescr("Super Share Swap (CP4), REF: ". $sssApplication->getSssId());
                    $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                    $ggMemberRwalletRecord->save();

                    if ($distributorDB) {
                        $distributorDB->setRwallet($rwalletBalance);
                        $distributorDB->save();
                    }

                    $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);
                    $sssApplication->save();
                } else {
                    print_r("<br>Else");
                    if ($mt4Balance == 0 && $dividendId == 0) {
                        // convert cp2/cp3 to rshare
                        $rwalletBalance = $this->getTotalOfRShare($sssApplication->getDistId());
                        $totalRshare = $sssApplication->getTotalShareConverted();
                        $rwalletBalance = $rwalletBalance + $totalRshare;
                        // credited S4
                        $ggMemberRwalletRecord = new GgMemberRwalletRecord();
                        $ggMemberRwalletRecord->setUid($sssApplication->getDistId());
                        $ggMemberRwalletRecord->setAid(0);
                        $ggMemberRwalletRecord->setActionType("SSS");
                        $ggMemberRwalletRecord->setType("credit");
                        $ggMemberRwalletRecord->setAmount($totalRshare);
                        $ggMemberRwalletRecord->setBal($rwalletBalance);
                        $ggMemberRwalletRecord->setDescr("Super Share Swap (CP2/CP3), REF:".$sssApplication->getSssId());
                        $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                        $ggMemberRwalletRecord->save();

                        if ($distributorDB) {
                            $distributorDB->setRwallet($rwalletBalance);
                            $distributorDB->save();
                        }

                        $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);
                        $sssApplication->save();
                    } else {
                        // $roiRemainingMonth = $sssApplication->getRoiRemainingMonth();
                        $roiArr = $this->getRoiInformation($sssApplication->getDistId(), $sssApplication->getMt4UserName());
                        $roiRemainingMonth = 0;
                        if ($roiArr == null) {
                            print_r("<br>skip::: ".$distributorDB->getDistributorId());
                            continue;
                        }
                        $entitledPairing = true;
                        if ($roiArr['idx'] <= 0) {
                            $roiRemainingMonth = 0;
                        } else {
                            if ($roiArr['idx'] <= 18) {
                                $roiRemainingMonth = 18 - $roiArr['idx'] + 1;
                            } else {
                                $roiRemainingMonth = 36 - $roiArr['idx'] + 1;
                            }
                        }
                        if ($roiArr['idx'] <= 12) {
                            $entitledPairing = false;
                        }
                        if ($roiArr['idx'] >= 19 && $roiArr['idx'] <= 36) {
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

                        $sssApplication->setRoiRemainingMonth($roiRemainingMonth);
                        $sssApplication->setTotalShareConverted($totalRshare);
                        $sssApplication->setTotalAmountConvertedWithCp2cp3($totalAmountConvertedWithCp2Cp3);
                        $sssApplication->save();

                        $mlm_distributor = $distributorDB;
                        $uplinePosition = $mlm_distributor->getPlacementPosition();
                        $pairingPoint = $totalAmountConvertedWithCp2Cp3 * Globals::PAIRING_POINT_BV;
                        $pairingPointActual = $totalAmountConvertedWithCp2Cp3;

                        print_r("<br>".$distributorDB->getDistributorId());

                        /*$c = new Criteria();
                      $c->addDescendingOrderByColumn(GgMemberRwalletRecordPeer::CDATE);
                      $ggMemberRwalletRecordDB = GgMemberRwalletRecordPeer::doSelectOne($c);*/
                        if ($sssApplication->getSwapType() == "RSHARE") {
                            $rwalletBalance = $this->getTotalOfRShare($sssApplication->getDistId());
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
                            $ggMemberRwalletRecord->setDescr("Super Share Swap, REF:".$sssApplication->getSssId());
                            $ggMemberRwalletRecord->setCdate(date('Y-m-d H:i:s'));
                            $ggMemberRwalletRecord->save();

                            if ($distributorDB) {
                                $distributorDB->setRwallet($rwalletBalance);
                                $distributorDB->save();
                            }
                        }

                        $sssApplication->setStatusCode(Globals::STATUS_SSS_SUCCESS);
                        $sssApplication->save();
                    }
                }

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                var_dump($e);
                //throw $e;
                break;
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

        if (count($arr) == 0) {
            $query = "SELECT notice_id, dist_id, mt4_user_name, dividend_date, maturity_type, email, retry, remark, internal_remark, email_status, status_code, approve_reject_datetime, client_response_datatime, mt4_balance, package_price, leader_dist_id, client_action, maturity_withdrawal_status, created_by, created_on, updated_by, updated_on
	            FROM notification_of_maturity
	        WHERE status_code IN ('".Globals::STATUS_MATURITY_PENDING."','".Globals::STATUS_MATURITY_CLIENT_RENEW."','".Globals::STATUS_MATURITY_CLIENT_WITHDRAW."','".Globals::STATUS_MATURITY_ON_HOLD."') AND dist_id = " . $distId ;


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
                $c = new Criteria();
                $c->add(SssApplicationPeer::DIST_ID, $arrResult['dist_id']);
                $c->add(SssApplicationPeer::MT4_USER_NAME, $arrResult['mt4_user_name']);
                $sssApplication = SssApplicationPeer::doSelectOne($c);
                if (!$sssApplication) {
                    $arr[] = $arrResult['mt4_user_name'];
                }
            }
        }
        return $arr;
    }

    function getSwapedMt4($distId, $mt4UserName)
    {
        $query = "SELECT sss_id, dist_id, dividend_id, mt4_user_name, cp2_balance, cp3_balance, rt_balance, mt4_balance, roi_remaining_month, roi_percentage, total_amount_converted_with_cp2cp3, share_value, total_share_converted, signature, remarks, status_code, swap_type, created_by, created_on, updated_by, updated_on
            FROM sss_application where dist_id = ".$distId." AND status_code IN ('SUCCESS','ASSS PAIRING','PROCESS','PENDING','PAIRING','ERROR')";

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
            $arr[] = $arrResult['mt4_user_name'];
        }
        return $arr;
    }

    function getRoiInformation($distId, $mt4UserName)
    {
        $query = "SELECT devidend_id, dist_id, mt4_user_name, idx, account_ledger_id, dividend_date, package_id, package_price, roi_percentage, mt4_balance, dividend_amount, remarks, exceed_dist_id, exceed_roi_percentage, exceed_dividend_amount, status_code, created_by, created_on, updated_by, updated_on, first_dividend_date
	                FROM mlm_roi_dividend WHERE mt4_user_name = ? AND status_code IN ('PENDING','SSS','ASSS') AND dist_id = ? ORDER BY idx limit 1 ";
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
        if ($arr == null) {
            $query = "SELECT count(*) AS _count
	                FROM mlm_roi_dividend WHERE mt4_user_name = ? AND status_code IN ('SUCCESS') AND dist_id = ? ";
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

                if ($arr['_count'] == 18) {
                    $query = "SELECT devidend_id, dist_id, mt4_user_name, idx, account_ledger_id, dividend_date, package_id, package_price, roi_percentage, mt4_balance, dividend_amount, remarks, exceed_dist_id, exceed_roi_percentage, exceed_dividend_amount, status_code, created_by, created_on, updated_by, updated_on, first_dividend_date
                                FROM mlm_roi_dividend WHERE mt4_user_name = ? AND status_code IN ('SUCCESS') AND dist_id = ? AND idx = 18 ";
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
                }
            }
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
    function totalCountOfSss($dateFrom, $dateTo, $swapType)
    {
        $query = "SELECT count(*) as _TOTAL FROM sss_application WHERE status_code not IN ('REJECTED','ERROR')";

        if ($dateFrom != null) {
            $query .= " AND created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != null) {
            $query .= " AND created_on <= '".$dateTo." 23:59:59'";
        }

        if ($swapType == "SSS" || $swapType == "ASSS") {
            $query .= " AND swap_type IN ('RSHARE','ASS','ASSS')";
        } else if ($swapType == "SES") {
            $query .= " AND swap_type IN ('SES')";
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
    function totalSumOfSss($fieldName, $dateFrom, $dateTo, $swapType)
    {
        $query = "SELECT SUM(".$fieldName.") as _TOTAL FROM sss_application WHERE status_code not IN ('REJECTED','ERROR')";

        if ($dateFrom != null) {
            $query .= " AND created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != null) {
            $query .= " AND created_on <= '".$dateTo." 23:59:59'";
        }

        if ($swapType == "SSS" || $swapType == "ASSS") {
            $query .= " AND swap_type IN ('RSHARE','ASS','ASSS')";
        } else if ($swapType == "SES") {
            $query .= " AND swap_type IN ('SES')";
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

    function totalSumOfSssByMonth($fieldName, $dateFrom, $dateTo, $swapType, $criteriaGL)
    {
        $query = "SELECT SUM(sss.".$fieldName.") as _TOTAL FROM sss_application sss
            INNER JOIN mlm_roi_dividend roi ON roi.devidend_id = sss.dividend_id
        WHERE sss.status_code not IN ('REJECTED','ERROR') ";

        if ($dateFrom != null) {
            $query .= " AND sss.created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != null) {
            $query .= " AND sss.created_on <= '".$dateTo." 23:59:59'";
        }

        if ($swapType == "SSS" || $swapType == "ASSS") {
            $query .= " AND sss.swap_type IN ('RSHARE','ASS','ASSS')";
        } else if ($swapType == "SES") {
            $query .= " AND sss.swap_type IN ('SES')";
        }
        if ($criteriaGL == "<") {
            $query .= " AND roi.idx < 12";
        } else if ($criteriaGL == ">=") {
            $query .= " AND roi.idx >= 12";
        }
        //var_dump($query);
        //exit();
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

    function getTotalOfRShare($distributorId)
    {
        $query = "SELECT SUM(amount) AS SUB_TOTAL FROM gg_member_rwallet_record WHERE uid = " . $distributorId
                 . " AND type IN ('credit','c')";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $totalCredit = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                $totalCredit = $arr["SUB_TOTAL"];
            } else {
                $totalCredit = 0;
            }
        }
        $query = "SELECT SUM(amount) AS SUB_TOTAL FROM gg_member_rwallet_record WHERE uid = " . $distributorId
                 . " AND type IN ('debit','d')";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $totalDebit = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                $totalDebit = $arr["SUB_TOTAL"];
            } else {
                $totalDebit = 0;
            }
        }
        return $totalCredit - $totalDebit;
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