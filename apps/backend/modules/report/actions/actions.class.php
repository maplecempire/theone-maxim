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
        $this->rollingPointTable = $this->getRollingPointData();
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

            $totalSales = $bonusService->doCalculateTotalSales($bonusDate);
            $totalDrb = $bonusService->doCalculateDrb($bonusDate);
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

    public function executeIndividualTraderSales()
    {
        $query = "SELECT dist.distributor_code, package.price
            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
	FROM mlm_distributor dist
        LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
where dist.loan_account = 'N'
AND dist.from_abfx = 'N'
AND dist.created_on >= '2013-03-17 00:00:00'
and dist.created_on <= '2013-07-10 23:59:59' AND package.price >= 10000 order by 2";

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

    function getRollingPointData()
    {
        $arrs = $this->fetchRollingPoint();

        $body = "<h3>Rolling Point Table</h3><table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
                    <thead>
                    <tr>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'></th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Distributor Code</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Full Name</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Email</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Contact</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Rolling Point</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Rolling Point Available</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Rolling Point Used</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Debit</th>
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
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $arr['distributor_code'] . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $arr['full_name'] . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $arr['email'] . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . $arr['contact'] . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($rollingPoint, 2) . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($rollingPointAvailable, 2) . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($rollingPointUsed, 2) . "</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>" . number_format($debitAccount, 2) . "</td>
                    </tr>";
        }

        $body .= "</tbody>
                </table>";

        return $body;
    }

    function fetchRollingPoint()
    {
        $query = "SELECT transferLedger.dist_id, dist.distributor_code, dist.full_name, dist.email, dist.contact
        , totalRollingPoint.TOTAL_ROLLING_POINT
        , rpUsed.TOTAL_RP_USED
    FROM mlm_account_ledger transferLedger
        LEFT JOIN
            (
                SELECT sum(credit) AS TOTAL_ROLLING_POINT, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '" . Globals::ACCOUNT_TYPE_RP . "' group by dist_id
            ) totalRollingPoint ON totalRollingPoint.dist_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(debit) AS TOTAL_RP_USED, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '" . Globals::ACCOUNT_TYPE_RP . "' group by dist_id
            ) rpUsed ON rpUsed.dist_id = transferLedger.dist_id
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = transferLedger.dist_id
    where transferLedger.account_type = '" . Globals::ACCOUNT_TYPE_RP . "' group by transferLedger.dist_id";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        //var_dump($query);
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $resultArray[$count] = $arr;
            $resultArray[$count]['TOTAL_DEBIT'] = $this->fetchTotalDebit($arr['dist_id']);
            $count++;
        }
        return $resultArray;
    }

    function fetchTotalDebit($distId)
    {
        $query = "SELECT sum(credit) AS TOTAL_DEBIT, dist_id
                    FROM mlm_account_ledger
                where account_type = '" . Globals::ACCOUNT_TYPE_DEBIT . "' AND dist_id = " . $distId . " group by dist_id";

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
}
