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
    public function executeDistributorDetail()
    {
        $distributorCodes = $this->getRequestParameter('id');
        $aColumns = explode(",", $distributorCodes);
        foreach ($aColumns as $distributorCode) {
            print_r("<br><br><br><br>Dist Code=".$distributorCode);
            print_r("<br>");

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distributorCode);
            $mlmDistributor = MlmDistributorPeer::doSelectOne($c);

            if ($mlmDistributor) {
                print_r("<br>Member ID:".$mlmDistributor->getDistributorCode());
                print_r("<br>Full Name:".$mlmDistributor->getFullName());
                print_r("<br>Rank ID:".$mlmDistributor->getRankId());
                print_r("<br>Remark:".$mlmDistributor->getRemark());
                print_r("<br>Active Datetime:".$mlmDistributor->getActiveDatetime());

                $totalCommission = $this->getCommissionBalance($mlmDistributor->getDistributorId());
                $totalCommission2 = $this->getCommissionBalance20150529($mlmDistributor->getDistributorId());
                $totalRoi = $this->getRoi($mlmDistributor->getDistributorId());

                print_r("<br>Total Commission 1: ".$totalCommission);
                print_r("<br>Total Commission 2: ".$totalCommission2);
                print_r("<br>Total Commission: ".($totalCommission + $totalCommission2));
                print_r("<br>Total Roi: ".$totalRoi);

                $c = new Criteria();
                $c->add(MlmRoiDividendPeer::DIST_ID, $mlmDistributor->getDistributorId());
                $c->add(MlmRoiDividendPeer::IDX, 1);
                $roiDividends = MlmRoiDividendPeer::doSelect($c);

                foreach ($roiDividends as $roiDividend) {
                    print_r("<br>Total Investment: ".$roiDividend->getPackagePricer());
                }
            }
        }

        print_r("<br><br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDistributorReport()
    {
        $query = "SELECT distributor_code, full_name, email, country, active_datetime
                FROM mlm_distributor WHERE from_abfx = 'N'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();

        /*$str = $this->getRequestParameter('id')."<table><tr>
        <td>#</td>
        <td>Member ID</td>
        <td>Full Name</td>
        <td>Email</td>
        <td>Country</td>
        <td>Active Datetime</td>
        </tr>";*/
        $idx = 1;
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();

            /*$str.= "<tr><td>" . $idx++."</td><td>" . $arr['distributor_code']."</td>
            <td>" . $arr['full_name']."</td>
            <td>" . $arr['email']."</td>
            <td>" . $arr['country']."</td>
            <td>" . $arr['active_datetime']."</td></tr>";*/
        }
        $this->arr = $arr;
        /*$str .= "<table>";
        print_r($str);
        print_r("<br><br>Done");
        return sfView::HEADER_ONLY;*/
    }
    public function executeCompanyCapitalReport()
    {
        $dateFrom = "2015-01-01 00:00:00";
        $dateTo = "2015-12-31 23:59:59";

        $totalMaturityArrs = $this->getTotalAmountOfInvestmentByMonth($dateFrom, $dateTo);
        print_r("<br>");
        print_r("<br>");
        print_r("<br>");
        print_r("Total Amount of Investment:-<br>");
        foreach ($totalMaturityArrs as $totalMaturityArr) {
            print_r("<br>");
            print_r($totalMaturityArr['year']."-".$totalMaturityArr['month']." : ". number_format($totalMaturityArr['_total'], 0));
        }

        $dateFrom = "2015-01-01 00:00:00";
        $dateTo = "2016-06-31 23:59:59";

        $totalMaturityArrs = $this->getTotalMaturityByMonth($dateFrom, $dateTo);
        print_r("<br>");
        print_r("<br>");
        print_r("<br>");
        print_r("Total Maturing Amount:-<br>");
        foreach ($totalMaturityArrs as $totalMaturityArr) {
            print_r("<br>");
            print_r($totalMaturityArr['year']."-".$totalMaturityArr['month']." : ". number_format($totalMaturityArr['_total'], 0));
        }

        print_r("<br>");
        print_r("<br>");
        print_r("<br>");
        $totalMaturityArrs = $this->getTotalAmountOfReturnByMonth($dateFrom, $dateTo);
        print_r("Total Amount of Return:-<br>");
        foreach ($totalMaturityArrs as $totalMaturityArr) {
            print_r("<br>");
            print_r($totalMaturityArr['year']."-".$totalMaturityArr['month']." : ". number_format($totalMaturityArr['_total'], 0));
        }

        print_r("<br><br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeWithdrawalReport()
    {
    }
    public function executeMobileActivityLog()
    {
    }

    public function executeMatchMbsFromExcel()
    {
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "maxim-trader-2nd-annual-convention-2015-02-11.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $counter = 0;
        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = 1; $x <= $totalRow; $x++) {
            $counter++;
            print_r("===>user name:".$data->val($x, "A").",Full Name:".$data->val($x, "B")."<br>");
            $userName = trim($data->val($x, "A"));
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeCheckPersonalSales()
    {
        $memberId = $this->getRequestParameter('id');
        $dateFrom = $this->getRequestParameter('dateFrom');
        $dateTo = $this->getRequestParameter('dateTo');

        $query = "SELECT reg.upline_dist_id, dist.distributor_code
                        , (Coalesce(reg._SUM, 0) + Coalesce(upgrade._SUM,0)) AS SUB_TOTAL
                        , Coalesce(reg._SUM, 0) AS register_sum
                        , Coalesce(upgrade._SUM, 0) AS upgrade_sum
                , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM
                (
                    SELECT SUM(package.price) AS _SUM, newDist.upline_dist_id
                        FROM mlm_distributor newDist
                            LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                        WHERE newDist.loan_account = 'N'
                            AND newDist.from_abfx = 'N'
                            AND newDist.upline_dist_id = " . $memberId . "
                            AND newDist.created_on >= '" . $dateFrom . "' AND newDist.created_on <= '" . $dateTo . "' group by upline_dist_id
                ) reg
                LEFT JOIN
                (
                    SELECT SUM(package.price) AS _sum, newDist.upline_dist_id
                        FROM mlm_distributor newDist
                            LEFT JOIN mlm_package_upgrade_history history ON history.dist_id = newDist.distributor_id
                            LEFT JOIN mlm_package package ON package.package_id = history.package_id
                            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                        WHERE newDist.loan_account = 'N'
                            AND newDist.from_abfx = 'N'
                            AND newDist.upline_dist_id = " . $memberId . "
                            AND history.created_on >= '" . $dateFrom . "' AND history.created_on <= '" . $dateTo . "' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id
            WHERE dist.distributor_id = " . $memberId;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        var_dump($query);
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            $result = $arr["SUB_TOTAL"];
        }
        print_r("<br><br>".$result);
        return sfView::HEADER_ONLY;
    }
    public function executeTestFmcReport()
    {
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $leaderId = 0;
            $leader = "";
            $treeStr = "|308347||308348||308349||1||9||274020||314539||314540||314542||175||43||49||57||58||60||140||142||298||1201||260946||273267||311511|";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                print_r($leaderArrs[$i]."<br>");
                $pos = strrpos($treeStr, "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
        print_r($leader."::".$leaderId);
        return sfView::HEADER_ONLY;

    }
    public function executeFmcReport20141201()
    {
        $dateFrom = "2014-12-01 00:00:00";
        $dateTo = "2015-01-26 23:59:59";
        $distDBs = $this->getFmcList20141201($dateFrom, null);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $str = "<table><tr><td>Member ID </td><td>Full Name</td><td>FMC</td><td>Date</td><td>Leader</td></tr>";
        $idx = 1;
        foreach ($distDBs as $distDB) {
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            $str.= "<tr><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['debit']."</td><td>" . $distDB['created_on']."</td><td>" . $leader."</td></tr>";
//            $str.= "<tr><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['debit']."</td><td>" . $distDB['created_on']."</td><td>" . $leader."</td><td>" . $distDB['tree_structure']."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeFmcReport Done");
        return sfView::HEADER_ONLY;
    }
    public function executeFmcReport()
    {
        $dateFrom = "2015-06-01 00:00:00";
        $dateTo = "2015-01-26 23:59:59";
        $distDBs = $this->getFmcList($dateFrom, null);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $str = "<table><tr><td>Member ID </td><td>Full Name</td><td>FMC</td><td>Date</td><td>Leader</td></tr>";
        $idx = 1;
        foreach ($distDBs as $distDB) {
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            $str.= "<tr><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['debit']."</td><td>" . $distDB['created_on']."</td><td>" . $leader."</td></tr>";
//            $str.= "<tr><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['debit']."</td><td>" . $distDB['created_on']."</td><td>" . $leader."</td><td>" . $distDB['tree_structure']."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeFmcReport Done");
        return sfView::HEADER_ONLY;
    }
    public function executeFmcReportGideon()
    {
        $dateFrom = "2015-03-01 00:00:00";
        $dateTo = "2015-01-26 23:59:59";
        $distDBs = $this->getFmcList($dateFrom, null);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER_GIDEON);

        $str = "<table><tr><td>Member ID </td><td>Full Name</td><td>FMC</td><td>Date</td><td>Leader</td></tr>";
        $idx = 1;
        foreach ($distDBs as $distDB) {
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            $str.= "<tr><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['debit']."</td><td>" . $distDB['created_on']."</td><td>" . $leader."</td></tr>";
//            $str.= "<tr><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['debit']."</td><td>" . $distDB['created_on']."</td><td>" . $leader."</td><td>" . $distDB['tree_structure']."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeFmcReport Done");
        return sfView::HEADER_ONLY;
    }
    public function executeNextBill120150114()
    {
        $dateFrom = "2014-11-21 00:00:00";
        $dateTo = "2014-12-31 23:59:59";
        $distDBs = $this->getTotalSponsor(264845, $dateFrom, $dateTo, 5, null);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $str = "<table>";
        $idx = 0;
        foreach ($distDBs as $distDB) {
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['price']."</td><td>" . $distDB['active_datetime']."</td><td>" . $distDB['total_count']."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeMaxcapGalaDinner2015 Done");
        return sfView::HEADER_ONLY;
    }
    public function executeGoldCoinPangkorSelfPurchase()
    {
        $dateFrom = "2015-02-01 00:00:00";
        $dateTo = "2015-03-19 23:59:59";

        $query = "SELECT dist.distributor_id, dist.distributor_code, package.price, uplineDist.distributor_code as upline_member_code
                        , uplineDist.full_name as upline_full_name
                , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on, dist.user_id
                    FROM mlm_distributor dist
                        LEFT JOIN mlm_distributor uplineDist ON uplineDist.distributor_id = dist.upline_dist_id
                        LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
                    WHERE dist.active_datetime >= '" . $dateFrom . "' AND dist.active_datetime <= '" . $dateTo . "'
                        AND dist.loan_account = 'N'
                        AND dist.tree_structure like '%|43|%'  and dist.tree_structure not like '%|595|%'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        var_dump($query);

        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $idx = 1;
        $arr = array();
        $str = "<table><tr><td>#</td><td>Member ID</td><td>Full Name</td><td>Package</td><td>Upline ID</td><td>Upline Full Name</td><td>Contact</td><td>Email</td><td>Total</td><td>leader</td></a></tr>";
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $totalPurchaseAmount = $arr['price'];
            $totalUpgradedPackageAmount = $this->getTotalUpgradedPackageAmount($arr['distributor_id'], $dateFrom, $dateTo);
            $totalPrice = $totalPurchaseAmount + $totalUpgradedPackageAmount;
            //var_dump($totalPrice);
            if ($totalPrice >= 20000) {
                for ($i = 0; $i < count($leaderArrs); $i++) {
                    $pos = strrpos($arr['tree_structure'], "|".$leaderArrs[$i]."|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                        if ($dist) {
                            $leader = $dist->getDistributorCode();
                            $leaderId = $dist->getDistributorId();
                        }
                        break;
                    }
                }

                $str.= "<tr><td>" . $idx++."</td><td>" . $arr['distributor_code']."</td><td>" . $arr['full_name']."</td><td>" . $arr['price']."</td><td>" . $arr['upline_member_code']."</td><td>" . $arr['upline_full_name']."</td><td>" . $arr['contact']."</td><td>" . $arr['email']."</td><td>" . $totalPrice."</td><td>" . $leader."</td></tr>";
            }
        }
        print_r($str);
        print_r("</table>");
        print_r("executeGoldCoinPangkor Done");
        return sfView::HEADER_ONLY;
    }
    public function executeGoldCoinPangkorPersonalSales()
    {
        $dateFrom = "2015-02-01 00:00:00";
        $dateTo = "2015-03-19 23:59:59";

        $query = "SELECT dist.distributor_id, dist.distributor_code
        , personalSales.total_personal_sales
        , upgradeHistory.total_upgrade_sales
        , (Coalesce(personalSales.total_personal_sales, 0) + Coalesce(upgradeHistory.total_upgrade_sales, 0)) AS _total
        , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country
    FROM mlm_distributor dist
        LEFT JOIN
        (
            SELECT SUM(package.price) AS total_personal_sales, upline_dist_id FROM mlm_distributor downline
                LEFT JOIN mlm_package package ON package.package_id = downline.init_rank_id
            WHERE downline.loan_account = 'N'
                AND downline.active_datetime >= '" . $dateFrom . "'
                AND downline.active_datetime <= '" . $dateTo . "' GROUP BY upline_dist_id
        ) personalSales ON personalSales.upline_dist_id = dist.distributor_id
        LEFT JOIN
        (
            SELECT SUM(history.amount) AS total_upgrade_sales, upgrade_dist.upline_dist_id, dist_id FROM mlm_package_upgrade_history history
                LEFT JOIN mlm_distributor upgrade_dist ON history.dist_id = upgrade_dist.distributor_id
            WHERE history.created_on >= '" . $dateFrom . "'
                AND history.created_on <= '" . $dateTo . "' GROUP BY upline_dist_id
        ) upgradeHistory ON upgradeHistory.upline_dist_id = dist.distributor_id
WHERE dist.tree_structure like '%|43|%'  and dist.tree_structure not like '%|595|%'
HAVING _total >= 50000";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        var_dump($query);

        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $idx = 1;
        $arr = array();
        $str = "<table><tr><td>#</td><td>Member ID</td><td>Full Name</td><td>Contact</td><td>Email</td><td>Total</td><td>leader</td></a></tr>";
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $totalPrice = $arr['_total'];
            //var_dump($totalPrice);
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($arr['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }

            $str.= "<tr><td>" . $idx++."</td><td>" . $arr['distributor_code']."</td><td>" . $arr['full_name']."</td><td>" . $arr['contact']."</td><td>" . $arr['email']."</td><td>" . $totalPrice."</td><td>" . $leader."</td></tr>";
        }
        print_r($str);
        print_r("</table>");
        print_r("executeGoldCoinPangkorPersonalSales Done");
        return sfView::HEADER_ONLY;
    }
    public function executeGoldCoin()
    {
        $dateFrom = "2014-10-01 00:00:00";
        $dateTo = "2014-10-31 23:59:59";
        $distDBs = $this->getTotalSponsor(null, $dateFrom, $dateTo, null, 100000);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $str = "<table><tr><td>#</td><td>Member ID</td><td>Full Name</td><td>Contact</td><td>Email</td><td>Total</td><td>leader</td></a></tr>";
        $idx = 1;
        foreach ($distDBs as $distDB) {
            if ($distDB['total_count'] < 2) {
                continue;
            }
            $appUser = AppUserPeer::retrieveByPK($distDB['user_id']);
            if ($appUser->getStatusCode() != "ACTIVE") {
                print_r("=============".$distDB->getDistributorCode());
                continue;
            }
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['contact']."</td><td>" . $distDB['email']."</td><td>" . $distDB['total_count']."</td><td>" . $leader."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeGoldCoin Done");
        return sfView::HEADER_ONLY;
    }
    public function executeGoldCoin2()
    {
        $dateFrom = "2014-09-21 00:00:00";
        $dateTo = "2014-09-28 23:59:59";
        $distDBs = $this->getEntitledMemberList($dateFrom, $dateTo, 100000);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $leaderSummaryArr = array();
        for ($i = 0; $i < count($leaderArrs); $i++) {
            $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
            if ($dist) {
                $leaderSummaryArr[$dist->getDistributorCode()] = 0;
            }
        }
        //var_dump($leaderArr);
        //exit();
        $str = "<table><tr><td>#</td><td>Member ID</td><td>Full Name</td><td>Contact</td><td>Email</td><td>Total</td><td>leader</td></a></tr>";
        $idx = 1;
        foreach ($distDBs as $distDB) {
            $appUser = AppUserPeer::retrieveByPK($distDB['user_id']);
            if ($appUser->getStatusCode() != "ACTIVE") {
                print_r("=============".$distDB->getDistributorCode());
                continue;
            }
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                        $leaderSummaryArr[$leader] = $leaderSummaryArr[$leader] + 1;
                    }
                    break;
                }
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['contact']."</td><td>" . $distDB['email']."</td><td>" . $distDB['price']."</td><td>" . $leader."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("<br><br><br>");
        print_r("<table>");
        for ($i = 0; $i < count($leaderArrs); $i++) {
            $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
            if ($leaderSummaryArr[$dist->getDistributorCode()] == 0) {
                continue;
            }
            print_r("<tr><td>".$dist->getDistributorCode()."</td><td>".$leaderSummaryArr[$dist->getDistributorCode()]."</td></tr>");
        }
        print_r("</table>");
        print_r("executeGoldCoin2 Done");
        return sfView::HEADER_ONLY;
    }
    public function executeMbs()
    {
        $dateFrom = "2014-11-20 00:00:00";
        $dateTo = "2015-01-28 23:59:59";
        $distDBs = $this->getMbsList($dateFrom, $dateTo);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $str = "<table><tr><td>#</td><td>Member ID</td><td>Full Name</td><td>Contact</td><td>Email</td><td>Date</td><td>leader</td></a></tr>";
        $idx = 1;
        foreach ($distDBs as $distDB) {
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            if ($leader == "") {
                continue;
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['contact']."</td><td>" . $distDB['email']."</td><td>" . $distDB['active_datetime']."</td><td>" . $leader."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeMbs Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAustraliaGalaDinner()
    {
        $dateFrom = "2014-03-01 00:00:00";
        $dateTo = "2015-04-31 23:59:59";
        $distDBs = $this->getMbsList($dateFrom, $dateTo);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $str = "<table><tr><td>#</td><td>Member ID</td><td>Full Name</td><td>Contact</td><td>Email</td><td>Date</td><td>leader</td></a></tr>";
        $idx = 1;
        foreach ($distDBs as $distDB) {
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            if ($leader == "") {
                continue;
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['contact']."</td><td>" . $distDB['email']."</td><td>" . $distDB['active_datetime']."</td><td>" . $leader."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeMbs Done");
        return sfView::HEADER_ONLY;
    }
    public function executeQueryAccountLedger20141231()
    {
        $c = new Criteria();
        $c->add(MlmAccountLedger20141231Peer::DIST_ID, $this->getRequestParameter('id'));
        $c->addAscendingOrderByColumn(MlmAccountLedger20141231Peer::CREATED_ON);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $accountLedgerDBs = MlmAccountLedger20141231Peer::doSelect($c);

        $str = $this->getRequestParameter('id')."<table><tr>
        <td>#</td>
        <td>Account Type</td>
        <td>Transaction Type</td>
        <td>Credit</td>
        <td>Debit</td>
        <td>Balance</td>
        <td>Remark</td>
        <td>Internal Remark</td>
        <td>Credited By</td>
        <td>Credited On</td>
        </tr>";
        $idx = 1;
        foreach ($accountLedgerDBs as $accountLedgerDB) {
            $accountType = $accountLedgerDB->getAccountType();

            if ($accountLedgerDB->getAccountType() == "EPOINT") {
                $accountType = "CP1";
            } else if ($accountLedgerDB->getAccountType() == "ECASH") {
                $accountType = "CP2";
            } else if ($accountLedgerDB->getAccountType() == "MAINTENANCE") {
                $accountType = "CP3";
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $accountType."</td>
            <td>" . $accountLedgerDB->getTransactionType()."</td>
            <td>" . $accountLedgerDB->getCredit()."</td>
            <td>" . $accountLedgerDB->getDebit()."</td>
            <td>" . $accountLedgerDB->getBalance()."</td>
            <td>" . $accountLedgerDB->getRemark()."</td>
            <td>" . $accountLedgerDB->getInternalRemark()."</td>
            <td>" . $accountLedgerDB->getCreatedBy()."</td>
            <td>" . $accountLedgerDB->getCreatedOn()."</td></tr>";
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeQueryAccountLedger20141231 Done");
        return sfView::HEADER_ONLY;
    }
    public function executeQueryAccountLedger()
    {
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getRequestParameter('id'));
        $c->addAscendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $accountLedgerDBs = MlmAccountLedgerPeer::doSelect($c);

        $str = $this->getRequestParameter('id')."<table><tr>
        <td>#</td>
        <td>Account Type</td>
        <td>Transaction Type</td>
        <td>Credit</td>
        <td>Debit</td>
        <td>Balance</td>
        <td>Remark</td>
        <td>Internal Remark</td>
        <td>Credited By</td>
        <td>Credited On</td>
        </tr>";
        $idx = 1;
        foreach ($accountLedgerDBs as $accountLedgerDB) {
            $accountType = $accountLedgerDB->getAccountType();

            if ($accountLedgerDB->getAccountType() == "EPOINT") {
                $accountType = "CP1";
            } else if ($accountLedgerDB->getAccountType() == "ECASH") {
                $accountType = "CP2";
            } else if ($accountLedgerDB->getAccountType() == "MAINTENANCE") {
                $accountType = "CP3";
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $accountType."</td>
            <td>" . $accountLedgerDB->getTransactionType()."</td>
            <td>" . $accountLedgerDB->getCredit()."</td>
            <td>" . $accountLedgerDB->getDebit()."</td>
            <td>" . $accountLedgerDB->getBalance()."</td>
            <td>" . $accountLedgerDB->getRemark()."</td>
            <td>" . $accountLedgerDB->getInternalRemark()."</td>
            <td>" . $accountLedgerDB->getCreatedBy()."</td>
            <td>" . $accountLedgerDB->getCreatedOn()."</td></tr>";
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeQueryAccountLedger20141231 Done");
        return sfView::HEADER_ONLY;
    }
    public function executeQueryAccount()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('id'));
        $mlmDistributor = MlmDistributorPeer::doSelectOne($c);

        if ($mlmDistributor) {
            print_r("<br>Member ID:".$mlmDistributor->getDistributorCode());
            print_r("<br>Full Name:".$mlmDistributor->getFullName());
            print_r("<br>Rank ID:".$mlmDistributor->getRankId());
            print_r("<br>Remark:".$mlmDistributor->getRemark());

            $cp1 = $this->getAccountBalance($mlmDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
            $cp2 = $this->getAccountBalance($mlmDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);
            $cp3 = $this->getAccountBalance($mlmDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_MAINTENANCE);

            print_r("<br>CP1:".$cp1);
            print_r("<br>CP2:".$cp2);
            print_r("<br>CP3:".$cp3);
        }

        print_r("executeQueryAccount Done");
        return sfView::HEADER_ONLY;
    }
    public function executeBmwX6Challenge()
    {
        $this->resultList = $this->findPersonalSalesList(null, "2014-03-10 00:00:00", "2014-05-31 00:00:00", null);
    }
    public function executeUpdateLeaderId()
    {
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        for ($i = 0; $i < count($leaderArrs); $i++) {
            $query = "update mlm_distributor set leader_id = ".$leaderArrs[$i]." where
                tree_structure like '%|".$leaderArrs[$i]."|%' and
            leader_id is null";

            var_dump("<br>".$query);
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $resultset = $statement->executeQuery();
        }

        print_r("<br>UpdateLeaderId");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateLeaderId__BAK()
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
//        $this->executeJapanIncentive();
//        $this->executeJapanIncentive();
//        $this->executeJapanIncentive();
//        $this->executeJapanIncentive();
//        $this->executeJapanIncentive();
//        $this->executeJapanIncentive();
//
//        $this->executeSingaporeYachtShowLifestyleIncentive();
//        $this->executeSingaporeYachtShowLifestyleIncentive();
//        $this->executeSingaporeYachtShowLifestyleIncentive();
//        $this->executeSingaporeYachtShowLifestyleIncentive();
//        $this->executeSingaporeYachtShowLifestyleIncentive();
//        $this->executeSingaporeYachtShowLifestyleIncentive();

//        $this->executeLangkawiIncentive();
//        $this->executeLangkawiIncentive();
//        $this->executeLangkawiIncentive();
//        $this->executeLangkawiIncentive();
//        $this->executeLangkawiIncentive();

//        $this->executeShanghaiConventionTrip();
        $this->executeBaliJapanKoreaPersonalSignup();
        $this->executeBaliJapanKoreaPersonalSignup();
        $this->executeBaliJapanKoreaPersonalSignup();
        $this->executeBaliJapanKoreaPersonalSignup();
        $this->executeBaliJapanKoreaPersonalSignup();
//        $this->executeShanghaiConventionTrip();
//        $this->executeShanghaiConventionTrip();
//        $this->executeShanghaiConventionTrip();
//        $this->executeShanghaiConventionTrip();

//        $this->executeUpdateLeader();
//        $this->executeUpdateLeader();
//        $this->executeUpdateLeader();
//        $this->executeUpdateLeader();
//        $this->executeUpdateLeader();
//        $this->executeUpdateLeader();

//        $q3 = 11 / 3;
//        var_dump($q3);
//        $q3 = floor(11 / 3);
//        var_dump($q3);
        print_r("<br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeTest2()
    {
//        $this->executeJapanChallenge();
//        $this->executeJapanChallenge();
//        $this->executeJapanChallenge();
//        $this->executeJapanChallenge();
//        $this->executeJapanChallenge();

//        $this->executeSingaporeYachtShowLifestyleChallenge();
//        $this->executeSingaporeYachtShowLifestyleChallenge();
//        $this->executeSingaporeYachtShowLifestyleChallenge();
//        $this->executeSingaporeYachtShowLifestyleChallenge();
//        $this->executeSingaporeYachtShowLifestyleChallenge();
//        $this->executeSingaporeYachtShowLifestyleChallenge();

//        $this->executeCaratDiamondChallenge();
//        $this->executeCaratDiamondChallenge();
//        $this->executeCaratDiamondChallenge();
//        $this->executeCaratDiamondChallenge();
//        $this->executeCaratDiamondChallenge();
//        $this->executeCaratDiamondChallenge();

//        $this->executeLangkawiChallenge();
//        $this->executeLangkawiChallenge();
//        $this->executeLangkawiChallenge();
//        $this->executeLangkawiChallenge();
//        $this->executeLangkawiChallenge();

//        $this->executeShanghaiChallenge();
//        $this->executeShanghaiChallenge();
//        $this->executeShanghaiChallenge();
//        $this->executeShanghaiChallenge();
//        $this->executeShanghaiChallenge();

        $this->executeBaliJapanKoreaChallenge();
        $this->executeBaliJapanKoreaChallenge();
        $this->executeBaliJapanKoreaChallenge();

        print_r("<br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateLeader()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::LEADER_ID, null, Criteria::ISNULL);
        $c->add(MlmDistributorPeer::BKK_QUALIFY_1, "Y");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(5000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        print_r($idx);
        foreach ($distDBs as $distDB) {
            //$distDB->setBkkStatus("COMPLETE");

            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
//                        $leader = $dist->getDistributorCode();
                        $leader = $dist->getDistributorId();
                    }
                    break;
                }
            }
            $distDB->setLeaderId($leader);
            $distDB->save();
        }

        print_r("executeUpdateLeader Done");
        return sfView::HEADER_ONLY;
    }
    public function executeCaratDiamondChallenge()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(10000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-06-14 00:00:00";
        $dateTo = "2014-06-30 23:59:59";
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

        print_r("executeCaratDiamondChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeLangkawiChallenge()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(10000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-02-20 00:00:00";
        $dateTo = "2014-05-09 23:59:59";
        foreach ($distDBs as $distDB) {
            $distDB->setBkkQualify1("");
            $distDB->setBkkQualify2("");
            $distDB->setBkkQualify3("");
            $distDB->setAbfxRemark("");

            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $totalSponsorAmount = $this->getSponsorAmount($distDB->getDistributorId());

            $x30to99 = 0;
            $x100to499 = 0;
            $x500 = 0;
            if ($totalSponsorAmount >= 5000) {
                $q3 = floor($totalSponsorAmount / 30000);
                $distDB->setBkkQualify1($q3);
                $distDB->setAbfxRemark("Total Sales=".$totalSponsorAmount);
            }
            $distDB->setBkkStatus("COMPLETE");
            $distDB->save();
        }

        print_r("executeLangkawiChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeShanghaiChallenge()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(10000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-03-12 00:00:00";
        $dateTo = "2014-06-15 23:59:59";
        foreach ($distDBs as $distDB) {
            $distDB->setBkkQualify1("");
            $distDB->setBkkQualify2("");
            $distDB->setBkkQualify3("");
            $distDB->setAbfxRemark("");

            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $totalSponsorAmount = $this->getSponsorAmount($distDB->getDistributorId());

            $x30to99 = 0;
            $x100to499 = 0;
            $x500 = 0;
            if ($totalSponsorAmount >= 50000) {
                $q3 = floor($totalSponsorAmount / 50000);
                $distDB->setBkkQualify1($q3);
                $distDB->setAbfxRemark("Total Sales=".$totalSponsorAmount);
            }
            $distDB->setBkkStatus("COMPLETE");
            $distDB->save();
        }

        print_r("executeShanghaiChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeBaliJapanKoreaChallenge()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->setLimit(10000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        foreach ($distDBs as $distDB) {
            $distDB->setAbfxRemark("");

            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $totalSponsorAmount = $this->getSponsorAmount($distDB->getDistributorId());

            if ($totalSponsorAmount >= 100000 && ($distDB->getLeaderId() == 255607
                    || $distDB->getLeaderId() == 264838
                    || $distDB->getLeaderId() == 264839
                    || $distDB->getLeaderId() == 257700
                    || $distDB->getLeaderId() == 255709
                    || $distDB->getLeaderId() == 264845
                    || $distDB->getLeaderId() == 273056)) {
                $distDB->setBkkQualify1("Y");
                $distDB->setAbfxRemark("Total Sales=".$totalSponsorAmount);
            } else if ($totalSponsorAmount >= 150000 && ($distDB->getLeaderId() == 142
                    || $distDB->getLeaderId() == 15)) {
                $distDB->setBkkQualify1("Y");
                $distDB->setAbfxRemark("Total Sales=".$totalSponsorAmount);
            }
            $distDB->setBkkStatus("COMPLETE");
            $distDB->save();
        }

        print_r("executeShanghaiChallenge Done");
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
        $dateFrom = "2014-03-26 00:00:00";
        $dateTo = "2014-04-30 23:59:59";
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
    public function executeJapanChallenge()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(10000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-03-01 00:00:00";
        $dateTo = "2014-04-30 23:59:59";
        foreach ($distDBs as $distDB) {
            $distDB->setBkkQualify1("");
            $distDB->setBkkQualify2("");
            $distDB->setBkkQualify3("");
            $distDB->setAbfxRemark("");

            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $totalSponsorAmount = $this->getSponsorAmount($distDB->getDistributorId());

            $x30to99 = 0;
            $x100to499 = 0;
            $x500 = 0;
            if ($totalSponsorAmount >= 50000) {
                $q3 = floor($totalSponsorAmount / 50000);
                $distDB->setBkkQualify1($q3);
                $distDB->setAbfxRemark("Total Sales=".$totalSponsorAmount);
            }
            $distDB->setBkkStatus("COMPLETE");
            $distDB->save();
        }

        print_r("executeJapanChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeLangkawiIncentive()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(5000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-02-20 00:00:00";
        $dateTo = "2014-05-09 23:59:59";
        foreach ($distDBs as $distDB) {
            $distDB->setBkkQualify1("N");
            $distDB->setBkkQualify2("N");
            $distDB->setBkkQualify3("N");
            $distDB->setBkkPersonalSalessetBkkPersonalSales(0);

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
            //$distDB->setNomineeName($leader);
            $distDB->save();
        }

        print_r("executeSingaporeYachtShowLifestyleChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeMaxcapGalaDinner2015()
    {
        $dateFrom = "2014-08-29 00:00:00";
        $dateTo = "2014-10-07 23:59:59";
        $distDBs = $this->getDistributorList(43, $dateFrom, $dateTo);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $str = "<table>";
        $idx = 0;
        foreach ($distDBs as $distDB) {
            //print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");
            $leaderId = 0;
            $leader = "";
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB['tree_structure'], "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                        $leaderId = $dist->getDistributorId();
                    }
                    break;
                }
            }
            $str.= "<tr><td>" . $idx++."</td><td>" . $distDB['distributor_code']."</td><td>" . $distDB['full_name']."</td><td>" . $distDB['price']."</td><td>" . $distDB['active_datetime']."</td><td>" . $leader."</td></tr>";

            /*$distDB->setLeaderId($leaderId);
            $distDB->setNomineeName($leader);
            $distDB->save();*/
        }
        $str .= "<table>";
        print_r($str);
        print_r("executeMaxcapGalaDinner2015 Done");
        return sfView::HEADER_ONLY;
    }

    public function executeShanghaiConventionTrip()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(5000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-03-12 00:00:00";
        $dateTo = "2014-06-15 23:59:59";
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
            //$distDB->setNomineeName($leader);
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
        $dateFrom = "2014-03-26 00:00:00";
        $dateTo = "2014-04-30 23:59:59";
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
            //$distDB->setNomineeName($leader);
            $distDB->save();
        }

        print_r("executeSingaporeYachtShowLifestyleChallenge Done");
        return sfView::HEADER_ONLY;
    }
    public function executeJapanIncentive()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(5000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-06-01 00:00:00";
        $dateTo = "2014-06-30 23:59:59";
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
            //$distDB->setNomineeName($leader);
            $distDB->save();
        }

        print_r("executeJapanIncentive Done");
        return sfView::HEADER_ONLY;
    }
    public function executeBaliJapanKoreaPersonalSignup()
    {
        $leaderArr = explode(',', "255607,264838,264839,142,257700,255709,264845,273056,15");
//        $leaderArr = explode(',', "273056");
        $accountTypeArr = explode(',', "276932,290399,281128,273135,278236,276016");
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::LEADER_ID, $leaderArr , Criteria::IN);
        $c->setLimit(5000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $dateFrom = "2014-06-15 00:00:00";
        $dateTo = "2014-08-15 23:59:59";
        foreach ($distDBs as $distDB) {
            $distDB->setBkkPersonalSales(0);

            $signPackageAmount = $this->getSignPackageAmount($distDB->getDistributorId(), $dateFrom, $dateTo);
            $upgradedAmount = $this->getTotalUpgradedPackageAmount($distDB->getDistributorId(), $dateFrom, $dateTo);
            $distDB->setBkkPersonalSales($signPackageAmount + $upgradedAmount);
            $distDB->setRemark("Package Amount:".$signPackageAmount.", Upgrade Amount:".$upgradedAmount);
            print_r($idx-- . ":" . $distDB->getDistributorCode().":Package Amount:".$signPackageAmount.", Upgrade Amount:".$upgradedAmount."<br>");
            //$personalSales = $this->findPersonalSalesList($distDB->getDistributorId(), $dateFrom, $dateTo, null);

            /*if ($personalSales >= 40000) {
                $distDB->setBkkQualify3("Y");
            }*/

            $distDB->setBkkStatus("COMPLETE");
            $distDB->save();
        }

        print_r("executeJapanIncentive Done");
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

    function getSponsorAmount($distId)
    {
        $query = "SELECT SUM(bkk_personal_sales) AS _SUM
                    FROM mlm_distributor WHERE 1=1 ";

        if ($distId != null) {
            $query .= " AND upline_dist_id = " . $distId;
        }
        $query .= " GROUP BY upline_dist_id ";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        //var_dump($query);
        //exit();
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            $count = $arr['_SUM'];
        }
        return $count;
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
    function getDistributorList($distributorId, $dateFrom, $dateTo)
    {
        $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, leader.distributor_code as leader_id
                        , package.price, dist.active_datetime, dist.tree_structure
                    FROM mlm_distributor dist
                        LEFT JOIN mlm_distributor leader ON leader.distributor_id = dist.leader_id
                        LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
                    WHERE dist.loan_account = 'N' AND dist.active_datetime >= '".$dateFrom."' AND dist.active_datetime <= '".$dateTo."'
                            AND dist.tree_structure like '%|" . $distributorId . "|%' AND dist.init_rank_id >= 3";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }
        return $arr;
    }
    function getTotalSponsor($distributorId, $dateFrom, $dateTo, $packageId, $packageAmount)
    {
        $query = "SELECT COUNT(dist.upline_dist_id) as total_count, uplinedist.distributor_id, uplinedist.distributor_code, uplinedist.full_name
                        , package.price, dist.active_datetime, dist.email, dist.contact, dist.tree_structure, dist.user_id
                    FROM mlm_distributor dist
                        LEFT JOIN mlm_distributor uplinedist ON uplinedist.distributor_id = dist.upline_dist_id
                        LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
                    WHERE dist.loan_account = 'N' AND dist.active_datetime >= '".$dateFrom."'
                        AND dist.active_datetime <= '".$dateTo."'";

        if ($distributorId != null) {
            $query .= " AND dist.tree_structure like '%|" . $distributorId . "|%'";
        }
        if ($packageId != null) {
            $query .= " AND dist.init_rank_id >= ".$packageId;
        }
        if ($packageAmount != null) {
            $query .= " AND package.price >= ".$packageAmount;
        }
        $query .= " group by dist.upline_dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }
        return $arr;
    }
    function getFmcList($dateFrom, $dateTo)
    {
        $query = "SELECT acc.account_id, acc.dist_id, acc.account_type, acc.transaction_type
                        , acc.rolling_point, acc.credit, acc.debit, acc.balance, acc.remark
                        , acc.internal_remark, acc.referer_id, acc.referer_type, acc.created_by
                        , acc.created_on, acc.updated_by, acc.updated_on
                        , dist.tree_structure, dist.distributor_code, dist.full_name
                    FROM mlm_account_ledger acc
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = acc.dist_id
                        where acc.dist_id > 0 and
                acc.transaction_type = '".Globals::ACCOUNT_LEDGER_ACTION_FMC."' AND acc.created_on >= '".$dateFrom."'";

        //                AND acc.created_on <= '".$dateTo."' and ";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }
        return $arr;
    }
    function getFmcList20141201($dateFrom, $dateTo)
    {
        $query = "SELECT acc.account_id, acc.dist_id, acc.account_type, acc.transaction_type
                        , acc.rolling_point, acc.credit, acc.debit, acc.balance, acc.remark
                        , acc.internal_remark, acc.referer_id, acc.referer_type, acc.created_by
                        , acc.created_on, acc.updated_by, acc.updated_on
                        , dist.tree_structure, dist.distributor_code, dist.full_name
                    FROM mlm_account_ledger_20141231 acc
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = acc.dist_id
                        where acc.dist_id > 0 and
                acc.transaction_type = '".Globals::ACCOUNT_LEDGER_ACTION_FMC."' AND acc.created_on >= '".$dateFrom."'";

        //                AND acc.created_on <= '".$dateTo."' and ";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }
        return $arr;
    }
    function getMbsList($dateFrom, $dateTo)
    {
        $query = "SELECT dist.distributor_code, dist.full_name
                    , package.price, dist.active_datetime, dist.email, dist.contact, dist.tree_structure, dist.active_datetime
            FROM mlm_distributor dist
                LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
            WHERE
                dist.loan_account = 'N' AND dist.init_rank_id >= 5 AND dist.active_datetime >= '".$dateFrom."'
                and dist.active_datetime <= '".$dateTo."'
            UNION
            SELECT ggdist.distributor_code, ggdist.full_name
                    , gg.amount, ggdist.active_datetime, ggdist.email, ggdist.contact, ggdist.tree_structure, gg.cdate
            FROM gg_purchase gg
                LEFT JOIN mlm_distributor ggdist ON gg.uid = ggdist.distributor_id
            WHERE gg.amount >= 30000 AND gg.cdate >= '".$dateFrom."'
                and gg.cdate <= '".$dateTo."'";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }
        return $arr;
    }

    function getAustralia($dateFrom, $dateTo)
    {
        $query = "SELECT dist.distributor_code, dist.full_name
                    , package.price, dist.active_datetime, dist.email, dist.contact, dist.tree_structure, dist.active_datetime
            FROM mlm_distributor dist
                LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
            WHERE
                dist.loan_account = 'N' AND dist.init_rank_id >= 5 AND dist.active_datetime >= '".$dateFrom."'
                and dist.active_datetime <= '".$dateTo."'
            UNION
            SELECT ggdist.distributor_code, ggdist.full_name
                    , gg.amount, ggdist.active_datetime, ggdist.email, ggdist.contact, ggdist.tree_structure, gg.cdate
            FROM gg_purchase gg
                LEFT JOIN mlm_distributor ggdist ON gg.uid = ggdist.distributor_id
            WHERE gg.amount >= 30000 AND gg.cdate >= '".$dateFrom."'
                and gg.cdate <= '".$dateTo."'";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }
        return $arr;
    }
    function getEntitledMemberList($dateFrom, $dateTo, $amountMore)
    {
        $query = "SELECT dist.distributor_code, package.price
                        , dist.email, dist.full_name, dist.contact, dist.country
                , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on, dist.user_id
                    FROM mlm_distributor dist
                        LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
                    WHERE package.price >= ".$amountMore." AND dist.active_datetime >= '" . $dateFrom . "' AND dist.active_datetime <= '" . $dateTo . "'";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }
        return $arr;
    }
    function getTotalAmountOfInvestmentByMonth($dateFrom, $dateTo)
    {
        $query = "SELECT SUM(package_price) AS _total, YEAR(dividend_date) AS year, MONTH(dividend_date) as month
                        FROM mlm_roi_dividend WHERE dividend_date >= '".$dateFrom."'
                    AND dividend_date <= '".$dateTo."' and idx = 1 AND status_code IN ('SUCCESS', 'PENDING')
                  GROUP BY YEAR(dividend_date), MONTH(dividend_date)";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }

        return $arr;
    }
    function getTotalMaturityByMonth($dateFrom, $dateTo)
    {
        $query = "SELECT SUM(package_price) AS _total, YEAR(dividend_date) AS year, MONTH(dividend_date) as month
                        FROM mlm_roi_dividend WHERE dividend_date >= '".$dateFrom."'
                    AND dividend_date <= '".$dateTo."' and idx = 18 AND status_code IN ('SUCCESS', 'PENDING')
                  GROUP BY YEAR(dividend_date), MONTH(dividend_date)";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }

        return $arr;
    }
    function getTotalAmountOfReturnByMonth($dateFrom, $dateTo)
    {
        $query = "SELECT SUM(package_price * roi_percentage / 100) AS _total, YEAR(dividend_date) AS year, MONTH(dividend_date) as month
                FROM mlm_roi_dividend WHERE dividend_date >= '".$dateFrom."'
            AND dividend_date <= '".$dateTo."' AND status_code IN ('PENDING')
                GROUP BY YEAR(dividend_date), MONTH(dividend_date)";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();
        while ($resultset->next()) {
            $arr[] = $resultset->getRow();
        }

        return $arr;
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
    function getCommissionBalance($distributorId)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger
            WHERE dist_id = ? AND commission_type IN (?,?)";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $distributorId);
        $statement->set(2, "DRB");
        $statement->set(3, "GDB");
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
    function getCommissionBalance20150529($distributorId)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger_20150529
            WHERE dist_id = ? AND commission_type IN (?,?)";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $distributorId);
        $statement->set(2, "DRB");
        $statement->set(3, "GDB");
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
    function getRoi($distributorId)
    {
        $query = "SELECT SUM(dividend_amount) AS SUB_TOTAL FROM mlm_roi_dividend
            WHERE dist_id = ? AND status_code IN (?)";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $statement->set(1, $distributorId);
        $statement->set(2, "SUCCESS");
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
