<?php

/**
 * report actions.
 *
 * @package    sf_sandbox
 * @subpackage report
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class reportActions extends sfActions
{
    public function executeBmwX6Challenge()
    {
        $this->resultList = $this->findPersonalSalesList(null, "2014-03-10 00:00:00", "2014-05-31 00:00:00", null);
    }
    public function executeUpdateLeaderId()
    {
        $query = "SELECT SUM(CREDIT-DEBIT) AS SUM, commission.dist_id
                    , dist.distributor_code, dist.full_name, dist.tree_structure
                FROM mlm_dist_commission_ledger commission
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = commission.dist_id
                    where commission.commission_type IN ('CREDIT_REFUND','DRB','GDB','PIPS_BONUS')
            group by commission.dist_id order by 1 desc LIMIT 300";

        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr["tree_structure"], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorId();
                    }
                    break;
                }
            }

            $distDB = MlmDistributorPeer::retrieveByPK($arr["dist_id"]);
            $distDB->setLeaderId($leader);
            $distDB->save();
        }

        print_r("<br>UpdateLeaderId");
        return sfView::HEADER_ONLY;
    }
    public function executeResetReport()
    {
        $query = "update mlm_distributor set bkk_status = 'PENDING', bkk_package_purchase= null, bkk_qualify_1 = null,
                bkk_qualify_2 = null, bkk_qualify_3 = null, bkk_personal_sales = null";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();

        print_r("<br>Reset Report Done");
        return sfView::HEADER_ONLY;
    }
    public function executeResetReport2()
    {
        $query = "update mlm_distributor set bkk_status = 'PENDING', bkk_qualify_1 = null,
                bkk_qualify_2 = null, bkk_qualify_3 = null";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();

        print_r("<br>Reset Report Done");
        return sfView::HEADER_ONLY;
    }
    public function executeTest()
    {
        $this->executeSingaporeYachtShowLifestyleIncentive();
        $this->executeSingaporeYachtShowLifestyleIncentive();
        $this->executeSingaporeYachtShowLifestyleIncentive();
        $this->executeSingaporeYachtShowLifestyleIncentive();
        $this->executeSingaporeYachtShowLifestyleIncentive();
        $this->executeSingaporeYachtShowLifestyleIncentive();
        print_r("<br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeTest2()
    {
        $this->executeSingaporeYachtShowLifestyleChallenge();
        $this->executeSingaporeYachtShowLifestyleChallenge();
        $this->executeSingaporeYachtShowLifestyleChallenge();
        $this->executeSingaporeYachtShowLifestyleChallenge();
        $this->executeSingaporeYachtShowLifestyleChallenge();
        $this->executeSingaporeYachtShowLifestyleChallenge();
        print_r("<br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateLeader()
    {
        $query = "select  distributor_id, distributor_code, email, full_name, contact, country, active_datetime, tree_structure
                , init_rank_code, rank_code, remark, abfx_remark, bkk_qualify_1, bkk_qualify_2, bkk_qualify_3, bkk_personal_sales, nominee_name
                    from mlm_distributor
                where
                    bkk_qualify_1 != '' or
                    bkk_qualify_2 != '' or bkk_qualify_3 != ''";

        $query2 = "select distributor_id, distributor_code, email, full_name, contact, country, active_datetime, tree_structure, init_rank_code, rank_code, remark, bkk_qualify_1, bkk_qualify_2, bkk_qualify_3, bkk_personal_sales, nominee_name
                     from mlm_distributor where bkk_personal_sales >= 30000 order by bkk_personal_sales desc";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr["tree_structure"], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $distDB = MlmDistributorPeer::retrieveByPK($arr["distributor_id"]);
            $distDB->setNomineeName($leader);
            $distDB->save();
        }


        print_r("executeUpdateLeader Done");
        return sfView::HEADER_ONLY;
    }
    public function executeSingaporeYachtShowLifestyleChallenge()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(10000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-03-10 00:00:00";
        $dateTo = "2014-03-25 23:59:59";
        foreach ($distDBs as $distDB) {
            $distDB->setBkkQualify1("");
            $distDB->setBkkQualify2("");
            $distDB->setBkkQualify3("");
            $distDB->setAbfxRemark("");

            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $directInformationRS = $this->getDirectInformation($distDB->getDistributorId());

            $x30to99 = 0;
            $x100to499 = 0;
            $x500 = 0;
            foreach ($directInformationRS as $directInformation) {
                $totalSales = $directInformation['bkk_personal_sales'];
                if ($totalSales >= 500000) {
                    $x500 += 1;
                } else if ($totalSales >= 100000 && $totalSales < 500000) {
                    $x100to499 += 1;
                } else if ($totalSales >= 30000 && $totalSales < 100000) {
                    $x30to99 += 1;
                }
            }

            if ($x500 > 0 || $x100to499  > 0 || $x30to99  > 0) {
                //if ($x500 >= 2) {
                $q3 = round($x500 / 2, 0, PHP_ROUND_HALF_DOWN);
                $q2 = round($x100to499 / 2, 0, PHP_ROUND_HALF_DOWN);
                $q1 = round($x30to99 / 2, 0, PHP_ROUND_HALF_DOWN);

                if ($q3 > 0 || $q2  > 0 || $q1  > 0) {
                    $distDB->setBkkQualify3($q3);
                    //}
                    //if ($x100to499 >= 2) {
                    $distDB->setBkkQualify2($q2);
                    //}
                    //if ($x30to99 >= 2) {
                    $distDB->setBkkQualify1($q1);
                    //}
                    //$personalSales = $this->findPersonalSalesList($distDB->getDistributorId(), $dateFrom, $dateTo, null);

                    /*if ($personalSales >= 40000) {
                        $distDB->setBkkQualify3("Y");
                    }*/

                    $distDB->setAbfxRemark("x500=".$x500.",x100to499=".$x100to499.",x30to99=".$x30to99);
                }
            }
            $distDB->setBkkStatus("COMPLETE");
            $distDB->save();
        }

        print_r("executeSingaporeYachtShowLifestyleChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeSingaporeYachtShowLifestyleIncentive()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(5000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-03-10 00:00:00";
        $dateTo = "2014-03-25 23:59:59";
        foreach ($distDBs as $distDB) {
            $distDB->setBkkQualify1("N");
            $distDB->setBkkQualify2("N");
            $distDB->setBkkQualify3("N");
            $distDB->setBkkPersonalSales(0);

            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $signPackageAmount = $this->getSignPackageAmount($distDB->getDistributorId(), $dateFrom, $dateTo);
            $upgradedAmount = $this->getTotalUpgradedPackageAmount($distDB->getDistributorId(), $dateFrom, $dateTo);
            $distDB->setBkkPersonalSales($signPackageAmount + $upgradedAmount);
            $distDB->setRemark("Package Amount:".$signPackageAmount.", Upgrade Amount:".$upgradedAmount);

            //$personalSales = $this->findPersonalSalesList($distDB->getDistributorId(), $dateFrom, $dateTo, null);

            /*if ($personalSales >= 40000) {
                $distDB->setBkkQualify3("Y");
            }*/

            $distDB->setBkkStatus("COMPLETE");

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }
            $distDB->setNomineeName($leader);
            $distDB->save();
        }

        print_r("executeSingaporeYachtShowLifestyleChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeRunImeReport()
    {
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $mlmDistributors = MlmDistributorPeer::doSelect($c);

        foreach ($mlmDistributors as $mlmDistributor) {
            $smallLeg = $this->getGroupSales($mlmDistributor->getDistributorId());
            $personalSales = $this->getPersonalSales($mlmDistributor->getDistributorId());
            $ticketQty = 0;
            $bonusType = "";

            if ($smallLeg >= 60000 && $personalSales >= 40000) {
                $bonusType = "SL60 and PS40";
                $ticketQty = 1;
            } else if ($smallLeg >= 80000 && $personalSales >= 30000) {
                $bonusType = "SL80 and PS30";
                $ticketQty = 1;
            } else if ($smallLeg >= 80000 && $personalSales >= 40000) {
                $bonusType = "SL60 and PS40";
                $ticketQty = 1;
            } else if ($smallLeg >= 80000 || $personalSales >= 40000) {
                $bonusType = "SL80 or PS40";
                $ticketQty = 1;
            } else if ($smallLeg >= 60000 || $personalSales >= 30000) {
                $bonusType = "SL60 or PS30";
                $ticketQty = 0.5;
            }

            $ime_report = new ImeReport();
            $ime_report->setDistId($mlmDistributor->getDistributorId());
            $ime_report->setBonusType($bonusType);
            $ime_report->setSmallLeg($smallLeg);
            $ime_report->setPersonalSales($personalSales);
            $ime_report->setTicketQty($ticketQty);
            $ime_report->setDistributorCode($mlmDistributor->getDistributorCode());
            $ime_report->setFullName($mlmDistributor->getFullName());
            $ime_report->setEmail($mlmDistributor->getEmail());
            $ime_report->setContact($mlmDistributor->getContact());
            $ime_report->setCountry($mlmDistributor->getCountry());
            $ime_report->setRegisteredOn($mlmDistributor->getCreatedOn());

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($mlmDistributor->getTreeStructure(), "|" . $leaderArrs[$i] . "|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $ime_report->setLeader($leader);
            $ime_report->setRemark("");
            $ime_report->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $ime_report->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $ime_report->save();
        }
    }

    public function executeImeReport()
    {
        $c = new Criteria();
        $c->add(ImeReportPeer::BONUS_TYPE, "", Criteria::NOT_EQUAL);
        $this->imeReports = ImeReportPeer::doSelect($c);
    }

    public function executeRollingPointList()
    {
        $dateFrom = $this->getRequestParameter('dateFrom','');
        $dateTo = $this->getRequestParameter('dateTo','');

        $this->rollingPointTable = $this->getRollingPointData($dateFrom, $dateTo, false);

        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
    public function executeRollingPointList2()
    {
        $dateFrom = $this->getRequestParameter('dateFrom','');
        $dateTo = $this->getRequestParameter('dateTo','');

        $this->rollingPointTable = $this->getRollingPointData($dateFrom, $dateTo, true);

        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function executeConvertEcashToEpoint()
    {
    }

    public function executeReferrerList()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, 71);
        $mlmDistributors = MlmDistributorPeer::doSelect($c);
    }

    public function executeEpointTransfer()
    {
    }

    public function executeDoReportPayout()
    {
        $bonusDate = date("Y-m-d", strtotime("9 November 2012"));

        $dateUtil = new DateUtil();
        $bonusService = new BonusService();

        print_r($bonusDate . "<br>");
        while ($bonusDate < date("Y-m-d")) {
            $queryDateForGrb = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate($bonusDate, 1, 0, 0));
            print_r($bonusDate . "<br>");

            $totalDrb = $bonusService->doCalculateDrb($bonusDate);
            //$totalSales = $bonusService->doCalculateTotalSales($bonusDate);
            $totalSales = $totalDrb * 10;
            $totalGdb = $bonusService->doCalculateGrb($queryDateForGrb);

            $reportPayoutBonus = new ReportPayoutBonus();
            $reportPayoutBonus->setBonusDate($bonusDate);
            $reportPayoutBonus->setTotalSales($totalSales);
            $reportPayoutBonus->setTotalDrb($totalDrb);
            $reportPayoutBonus->setTotalGdb($totalGdb);
            $reportPayoutBonus->setGdbPercentage($totalGdb / $totalSales);
            $reportPayoutBonus->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $reportPayoutBonus->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $reportPayoutBonus->save();

            $bonusDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate($bonusDate, 1, 0, 0));
        }
        return sfView::HEADER_ONLY;
    }

    public function executeGroupSales_bak()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $mlmDistributors = MlmDistributorPeer::doSelect($c);

        $count = 0;
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $resultArray = array();
        foreach ($mlmDistributors as $mlmDistributor) {
            $personalSales = $this->getPersonalSales($mlmDistributor->getDistributorId());
            $groupSales = $this->getGroupSales($mlmDistributor->getDistributorId());

            if ($personalSales >= 30000 || $groupSales >= 60000) {
                $resultArray[$count]['personal_sales'] = $personalSales;
                $resultArray[$count]['group_sales'] = $groupSales;

                $resultArray[$count]['distributor_code'] = $mlmDistributor->getDistributorCode();
                $resultArray[$count]['full_name'] = $mlmDistributor->getFullName();
                $resultArray[$count]['email'] = $mlmDistributor->getEmail();
                $resultArray[$count]['contact'] = $mlmDistributor->getContact();
                $resultArray[$count]['country'] = $mlmDistributor->getCountry();

                $leader = "";
                for ($i = 0; $i < count($leaderArrs); $i++) {
                    $pos = strrpos($mlmDistributor->getTreeStructure(), "|" . $leaderArrs[$i] . "|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                        if ($dist) {
                            $leader = $dist->getDistributorCode();
                        }
                        break;
                    }
                }
                $resultArray[$count]['LEADER'] = $leader;
                $count++;
            }
        }

        $this->resultArray = $resultArray;
    }

    public function executeGroupSales()
    {
        $query = "SELECT dist.distributor_code, leftgroup._SUM as left_sum, rightgroup._SUM as right_sum
        , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
            FROM mlm_distributor dist
LEFT JOIN (
    SELECT sum(pairing.credit) AS _SUM, pairing.dist_id
        FROM mlm_dist_pairing_ledger pairing
            LEFT JOIN mlm_distributor dist ON dist.distributor_id = pairing.dist_id
    where dist.from_abfx = 'N'
        AND pairing.left_right = 'LEFT'
        AND pairing.created_on >= '2013-03-17 00:00:00'
        AND pairing.created_on <= '2013-07-10 23:59:59'
    group by pairing.dist_id
) leftgroup ON leftgroup.dist_id = dist.distributor_id
LEFT JOIN (
    SELECT sum(pairing.credit) AS _SUM, pairing.dist_id
        FROM mlm_dist_pairing_ledger pairing
            LEFT JOIN mlm_distributor dist ON dist.distributor_id = pairing.dist_id
    where dist.from_abfx = 'N'
        AND pairing.left_right = 'RIGHT'
        AND pairing.created_on >= '2013-03-17 00:00:00'
        AND pairing.created_on <= '2013-07-10 23:59:59'
    group by pairing.dist_id
) rightgroup ON rightgroup.dist_id = dist.distributor_id
    where dist.from_abfx = 'N'
    Having (left_sum >= 60000 AND right_sum >= 60000) order by 2,3";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        //var_dump($query);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr['tree_structure'], "|" . $leaderArrs[$i] . "|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $resultArray[$count] = $arr;
            $resultArray[$count]['LEADER'] = $leader;
            $count++;
        }
        $this->resultArray = $resultArray;
    }

    public function executePersonalSales()
    {
        $query = "SELECT newDist.upline_dist_id, dist.distributor_code, SUM(package.price) AS _SUM
                            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM mlm_distributor newDist
                        LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                where newDist.loan_account = 'N'
                    AND newDist.from_abfx = 'N'
                    AND newDist.created_on >= '2013-03-17 00:00:00'
                    and newDist.created_on <= '2013-07-10 23:59:59' group by upline_dist_id Having SUM(package.price) >= 30000  order by 3";

        $query = "SELECT newDist.upline_dist_id, dist.distributor_code, SUM(package.price) AS _SUM
                            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM mlm_distributor newDist
                        LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                where newDist.loan_account = 'N'
                    AND newDist.from_abfx = 'N'
                    AND dist.placement_tree_structure like '%|1464|%'
                    AND newDist.created_on >= '2013-08-05 00:00:00' group by upline_dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        //var_dump($query);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr['tree_structure'], "|" . $leaderArrs[$i] . "|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $resultArray[$count] = $arr;
            $resultArray[$count]['LEADER'] = $leader;
            $resultArray[$count]['UPGRADE_AMOUNT'] = $this->getUpgradePackageSales($arr['upline_dist_id']);
            $count++;
        }
        $this->resultArray = $resultArray;
    }

    public function executeIndividualTraderSales()
    {
        $this->dateFrom = $this->getRequestParameter('dateFrom','');
        $this->dateTo = $this->getRequestParameter('dateTo','');
        $this->memberId = $this->getRequestParameter('memberId','');
    }
    public function executeDoIndividualTraderSales()
    {
        $dateFrom = $this->getRequestParameter('dateFrom','');
        $dateTo = $this->getRequestParameter('dateTo','');
        $memberId = $this->getRequestParameter('memberId','');

        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->memberId = $memberId;

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $memberId);
        $distributorDB = MlmDistributorPeer::doSelectOne($c);

        if (!$distributorDB) {
            $this->setFlash('errorMsg', "Member ID ".$memberId." not found.");
            return $this->redirect('report/individualTraderSales?dateFrom='.$dateFrom.'&dateTo='.$dateTo.'&memberId='.$memberId);
        }
        /*$c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $memberId, Criteria::LIKE);
        $distributorDBs = MlmDistributorPeer::doSelect($c);

        $memberIdStr = "";
        foreach ($distributorDBs as $distributorDB) {
            $memberIdStr .= $distributorDB->getDistributorId().",";
        }*/

        $query = "SELECT reg.upline_dist_id, dist.distributor_code
                        , (Coalesce(reg._SUM, 0) + Coalesce(upgrade._SUM,0)) AS SUB_TOTAL
                        , Coalesce(reg._SUM, 0) AS register_sum
                        , Coalesce(upgrade._SUM, 0) AS upgrade_sum
                        , dist.email, dist.full_name, dist.contact, dist.country
                , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM
                (
                    SELECT SUM(package.price) AS _SUM, newDist.upline_dist_id
                        FROM mlm_distributor newDist
                            LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                        WHERE newDist.loan_account = 'N'
                            AND newDist.from_abfx = 'N'
                            AND newDist.upline_dist_id = " . $distributorDB->getDistributorId();

        if ($dateFrom != "") {
            $query .= " AND newDist.active_datetime >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != "") {
            $query .= " AND newDist.active_datetime <= '".$dateTo." 23:59:59'";
        }
        $query .= " group by upline_dist_id ";

        $query .= " ) reg
                LEFT JOIN
                (
                    SELECT SUM(package.price) AS _sum, newDist.upline_dist_id
                        FROM mlm_distributor newDist
                            LEFT JOIN mlm_package_upgrade_history history ON history.dist_id = newDist.distributor_id
                            LEFT JOIN mlm_package package ON package.package_id = history.package_id
                            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                        WHERE newDist.loan_account = 'N'
                            AND newDist.from_abfx = 'N'
                            AND newDist.upline_dist_id = " . $distributorDB->getDistributorId();
        if ($dateFrom != "") {
            $query .= " AND history.created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != "") {
            $query .= " AND history.created_on <= '".$dateTo." 23:59:59'";
        }
        $query .= "  group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                    LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id";

        //var_dump($query);
        //exit();
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        //var_dump($query);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        if ($resultset->next()) {
            $arr = $resultset->getRow();

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr['tree_structure'], "|" . $leaderArrs[$i] . "|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $resultArray[$count] = $arr;
            $resultArray[$count]['LEADER'] = $leader;
            $count++;



        }

        $this->resultArray = $resultArray;

        $this->setTemplate('individualTraderSales');
    }
    public function executePackageUpgradeSales()
    {
        $query = "SELECT dist.distributor_code, package.price, history.created_on
            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country
	FROM mlm_package_upgrade_history history
        left join mlm_distributor dist ON dist.distributor_id = history.dist_id
        left join mlm_package package ON package.package_id = history.package_id
            WHERE history.created_on >= '2013-03-17 00:00:00'
and history.created_on <= '2013-07-10 23:59:59' AND package.price >= 10000 order by 2";

        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        //var_dump($query);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr['tree_structure'], "|" . $leaderArrs[$i] . "|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $resultArray[$count] = $arr;
            $resultArray[$count]['LEADER'] = $leader;
            $count++;
        }
        $this->resultArray = $resultArray;
    }

    function getUpgradePackageSales($distId)
    {
        $query = "SELECT SUM(package.price) AS _SUM
	FROM mlm_package_upgrade_history history
        left join mlm_distributor dist ON dist.distributor_id = history.dist_id
        left join mlm_package package ON package.package_id = history.package_id
            WHERE history.created_on >= '2013-08-05 00:00:00'
                    AND dist.upline_dist_id = ".$distId;

        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        if ($resultset->next()) {
            $arr = $resultset->getRow();

            return $arr['_SUM'];
        }
        return 0;
    }

    public function executeCustomerService()
    {
        $c = new Criteria();
        $this->mlmCustomerEnquirys = MlmCustomerEnquiryPeer::doSelect($c);
    }

    public function executeCustomerServiceDetail()
    {
        $c = new Criteria();
        $this->mlmCustomerEnquiryDetails = MlmCustomerEnquiryDetailPeer::doSelect($c);
    }

    public function executeImeRegistration()
    {
        $c = new Criteria();
        $this->ime_registrations = ImeRegistrationPeer::doSelect($c);
    }

    public function executeMt4Withdrawal()
    {
    }

    public function executeReferralBonus()
    {
        $c = new Criteria();
        $this->reports = ReportPayoutBonusPeer::doSelect($c);
    }

    public function executeTotalMt4Reload()
    {
    }

    public function executeTotalPackagePurchase()
    {
    }

    public function executeTotalPackageUpgrade()
    {
    }

    public function executeTotalVolumeTraded()
    {

    }

    public function executeRollingPointDetail()
    {
        $id = $this->getRequestParameter('id');

        $this->dist = MlmDistributorPeer::retrieveByPK($id);

        $c = new Criteria();

        $c1 = $c->getNewCriterion(MlmAccountLedgerPeer::ACCOUNT_TYPE, "RP");
        $c2 = $c->getNewCriterion(MlmAccountLedgerPeer::ACCOUNT_TYPE, "DEBIT");
        $c1->addOr($c2);
        $c->add($c1);
        $c->add(MlmAccountLedgerPeer::DIST_ID, $id);
        $c->addAscendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
        $this->reportDetails = MlmAccountLedgerPeer::doSelect($c);
    }

    function getRollingPointData($dateFrom, $dateTo, $moreDetail)
    {
        $arrs = $this->fetchRollingPoint($dateFrom, $dateTo);

        $body = "<h3>Rolling Point Table</h3><table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
                    <thead>
                    <tr>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'></th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Distributor Code</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Full Name</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Email</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Contact</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>RP</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>RP Available</th>";

        if ($moreDetail == true) {
            $body .= "<th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Total RP Used - DEBIT = RP Used Balance</th>";
        } else if ($moreDetail == false) {
            $body .= "<th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>RP Used Balance</th>";
        }

        $body .= "<th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Debit</th>
                    </tr>
                    </thead>
                    <tbody>";

        $idx = 1;
        foreach ($arrs as $arr) {
            $debitAccount = $arr['TOTAL_DEBIT'];
            if ($debitAccount == null)
                $debitAccount = 0;
            $rollingPoint = $arr['TOTAL_ROLLING_POINT'] - $debitAccount;
            $rollingPointUsed = $arr['TOTAL_RP_USED'] - $debitAccount;
            $rollingPointAvailable = $arr['TOTAL_ROLLING_POINT'] - $arr['TOTAL_RP_USED'];

            $body .= "<tr class='sf_admin_row_1'>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $idx++ . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><a href='/backend.php/report/rollingPointDetail?id=".$arr['dist_id']."'>" . $arr['distributor_code'] . "</a></td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $arr['full_name'] . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $arr['email'] . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $arr['contact'] . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($rollingPoint, 2) . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($rollingPointAvailable, 2) . "</td>";

            if ($moreDetail == true) {
                $body .= "<td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($arr['TOTAL_RP_USED'], 2)."(".number_format($debitAccount, 2).")=".number_format($rollingPointUsed, 2) . "</td>";
            } else {
                $body .= "<td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($rollingPointUsed, 2) . "</td>";
            }

            $body .= "<td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($debitAccount, 2) . "</td>
                    </tr>";
        }

        $body .= "</tbody>
                </table>";

        return $body;
    }

    function fetchRollingPoint($dateFrom, $dateTo)
    {
        $query = "SELECT transferLedger.dist_id, dist.distributor_code, dist.full_name, dist.email, dist.contact
        , totalRollingPoint.TOTAL_ROLLING_POINT, rpUsed.TOTAL_RP_USED
            FROM mlm_distributor dist
        INNER JOIN
        (
            SELECT dist_id FROM mlm_account_ledger where account_type = '" . Globals::ACCOUNT_TYPE_RP . "'
                group by dist_id
        ) transferLedger ON dist.distributor_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(credit) AS TOTAL_ROLLING_POINT, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '" . Globals::ACCOUNT_TYPE_RP . "'";

        if ($dateFrom != "") {
            $query .= " AND created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != "") {
            $query .= " AND created_on <= '".$dateTo." 23:59:59'";
        }

                    $query .= "group by dist_id
            ) totalRollingPoint ON totalRollingPoint.dist_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(debit) AS TOTAL_RP_USED, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '" . Globals::ACCOUNT_TYPE_RP . "'";

        if ($dateFrom != "") {
            $query .= " AND created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != "") {
            $query .= " AND created_on <= '".$dateTo." 23:59:59'";
        }

            $query .= "group by dist_id
        ) rpUsed ON rpUsed.dist_id = transferLedger.dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        //var_dump($query);
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $resultArray[$count] = $arr;
            $resultArray[$count]['TOTAL_DEBIT'] = $this->fetchTotalDebit($arr['dist_id'], $dateFrom, $dateTo);
            $count++;
        }
        return $resultArray;
    }

    function fetchTotalDebit($distId, $dateFrom, $dateTo)
    {
        $query = "SELECT sum(credit) AS TOTAL_DEBIT, dist_id
                    FROM mlm_account_ledger
                where account_type = '" . Globals::ACCOUNT_TYPE_DEBIT . "' AND dist_id = " . $distId;

        if ($dateFrom != "") {
            $query .= " AND created_on >= '".$dateFrom." 00:00:00'";
        }
        if ($dateTo != "") {
            $query .= " AND created_on <= '".$dateTo." 23:59:59'";
        }
        $query .= " group by dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            $result = $arr["TOTAL_DEBIT"];
        }
        return $result;
    }

    function getPersonalSales($distId)
    {
        $query = "SELECT newDist.upline_dist_id, dist.distributor_code, SUM(package.price) AS _SUM
            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country
	FROM mlm_distributor newDist
        LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
where newDist.loan_account = 'N'
AND newDist.upline_dist_id = " . $distId . "
AND newDist.from_abfx = 'N'
AND newDist.created_on >= '2013-03-17 00:00:00'
and newDist.created_on <= '2013-07-10 23:59:59' group by upline_dist_id Having SUM(package.price) >= 30000  order by 3";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            $result = $arr["_SUM"];
        }
        return $result;
    }

    function getGroupSales($distId)
    {
        $query = "SELECT sum(pairing.credit) AS _SUM, pairing.dist_id, dist.distributor_code, pairing.left_right, dist.full_name, dist.email, dist.contact
                    FROM mlm_dist_pairing_ledger pairing
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = pairing.dist_id
                where pairing.dist_id = " . $distId . "
                    AND dist.from_abfx = 'N'
                    AND pairing.created_on >= '2013-03-17 00:00:00'
                    and pairing.created_on <= '2013-07-10 23:59:59'
                group by pairing.dist_id, pairing.left_right
                    Having SUM(pairing.credit) >= 60000 order by 1";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            $result = $arr["_SUM"];
        }
        return $result;
    }

    function findPersonalSalesList($distId, $dateFrom, $dateTo, $minimum)
    {
        $query = "SELECT reg.upline_dist_id, dist.distributor_code
                        , (Coalesce(reg._SUM, 0) + Coalesce(upgrade._SUM,0)) AS SUB_TOTAL
                        , Coalesce(reg._SUM, 0) AS register_sum
                        , Coalesce(upgrade._SUM, 0) AS upgrade_sum
                        , dist.email, dist.full_name, dist.contact, dist.country
                , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM
                (
                    SELECT SUM(package.price) AS _SUM, newDist.upline_dist_id
                        FROM mlm_distributor newDist
                            LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                        WHERE newDist.loan_account = 'N'
                            AND newDist.from_abfx = 'N'";

        if ($distId != null) {
            $query .= " AND newDist.upline_dist_id = " . $distId;
        }

        $query .= " AND newDist.created_on >= '".$dateFrom."' AND newDist.created_on <= '".$dateTo."' group by upline_dist_id
                ) reg
                LEFT JOIN
                (
                    SELECT SUM(package.price) AS _sum, newDist.upline_dist_id
                        FROM mlm_distributor newDist
                            LEFT JOIN mlm_package_upgrade_history history ON history.dist_id = newDist.distributor_id
                            LEFT JOIN mlm_package package ON package.package_id = history.package_id
                            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                        WHERE newDist.loan_account = 'N'
                            AND newDist.from_abfx = 'N'";

        if ($distId != null) {
            $query .= " AND newDist.upline_dist_id = " . $distId;
        }

        $query .= " AND history.created_on >= '".$dateFrom."' AND history.created_on <= '".$dateTo."' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id ";

        $query .= " WHERE 1=1 ";

        if ($distId != null) {
            $query .= " AND dist.distributor_id = " . $distId;
        }

        if ($minimum != null) {
            $query .= " HAVING SUB_TOTAL >= " . $minimum;
        }
        $query .= " ORDER BY 3 DESC ";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $resultArray[$count] = $arr;
            $count++;
        }
        return $resultArray;
    }

    function getDirectInformation($distId)
    {
        $query = "SELECT upline_dist_id, bkk_personal_sales, distributor_id
                    FROM mlm_distributor WHERE 1=1 ";

        if ($distId != null) {
            $query .= " AND upline_dist_id = " . $distId;
        }
        $query .= " ORDER BY bkk_personal_sales DESC ";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $resultArray[$count] = $arr;
            $count++;
        }
        return $resultArray;
    }

    function getTotalUpgradedPackageAmount($distributorId, $dateFrom, $dateTo)
    {
        $query = "SELECT SUM(amount) as _SUM
                    FROM mlm_package_upgrade_history
                    WHERE created_on >= '".$dateFrom."' AND created_on <= '".$dateTo."'
                            AND dist_id = '" . $distributorId . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["_SUM"] != null) {
                return $arr["_SUM"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getSignPackageAmount($distributorId, $dateFrom, $dateTo)
    {
        $query = "SELECT SUM(pack.price) as _SUM
                    FROM mlm_distributor dist
                        LEFT JOIN mlm_package pack ON pack.package_id = dist.init_rank_id
                    WHERE dist.loan_account = 'N' AND dist.active_datetime >= '".$dateFrom."' AND dist.active_datetime <= '".$dateTo."'
                            AND dist.distributor_id = '" . $distributorId . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["_SUM"] != null) {
                return $arr["_SUM"];
            } else {
                return 0;
            }
        }
        return 0;
    }
}