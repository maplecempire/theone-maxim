<?php

/**
 * datoheng actions.
 *
 * @package    sf_sandbox
 * @subpackage datoheng
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class datohengActions extends sfActions
{
    public function executeCp2Withdrawal()
    {
        $query = "SELECT dist.distributor_code, dist.full_name, withdrawal.deduct, withdrawal.bank_in_to
        , withdrawal.status_code, withdrawal.remarks, withdrawal.created_on, leader.distributor_code as leader_code
	FROM mlm_ecash_withdraw withdrawal
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = withdrawal.dist_id
        LEFT JOIN mlm_distributor leader ON leader.distributor_id = withdrawal.leader_dist_id
    WHERE leader_dist_id IN (203,1797) AND withdrawal.status_code = 'PAID'";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();

        print_r("<table><tr><td>Member ID </td><td>Full Name</td><td>Withdrawal Amount</td><td>Type</td><td>Status</td><td>Remark</td><td>Date</td><td>Leader</td></tr>");
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            print_r("<tr><td>".$arr['distributor_code']."</td><td>".$arr['full_name']."</td><td>".$arr['deduct']."</td><td>".$arr['bank_in_to']
                    ."</td><td>".$arr['status_code']."</td><td>".$arr['remarks']."</td><td>".$arr['created_on']."</td><td>".$arr['leader_code']."</td></tr>");
        }
        print_r("</table>");
        print_r("<br><br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeCp3Withdrawal()
    {
        $query = "SELECT dist.distributor_code, dist.full_name, withdrawal.deduct, withdrawal.bank_in_to
        , withdrawal.status_code, withdrawal.remarks, withdrawal.created_on, leader.distributor_code as leader_code
	FROM mlm_cp3_withdraw withdrawal
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = withdrawal.dist_id
        LEFT JOIN mlm_distributor leader ON leader.distributor_id = withdrawal.leader_dist_id
    WHERE leader_dist_id IN (203,1797) AND withdrawal.status_code = 'PAID'";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();

        print_r("<table><tr><td>Member ID </td><td>Full Name</td><td>Withdrawal Amount</td><td>Type</td><td>Status</td><td>Remark</td><td>Date</td><td>Leader</td></tr>");
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            print_r("<tr><td>".$arr['distributor_code']."</td><td>".$arr['full_name']."</td><td>".$arr['deduct']."</td><td>".$arr['bank_in_to']
                    ."</td><td>".$arr['status_code']."</td><td>".$arr['remarks']."</td><td>".$arr['created_on']."</td><td>".$arr['leader_code']."</td></tr>");
        }
        print_r("</table>");
        print_r("<br><br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeSalesReport()
    {
        $leaderStr = "282,257273,255677,1615,1797,263134,333,255322";
        $leaderArrs = explode(",", $leaderStr);

        print_r("<table><tr><td>Member ID </td><td>01 2014</td><td>02 2014</td><td>03 2014</td><td>04 2014</td><td>05 2014</td><td>06 2014</td><td>07 2014</td><td>08 2014</td><td>09 2014</td><td>10 2014</td><td>11 2014</td><td>12 2014</td><td>01 2015</td><td>02 2015</td><td>03 2015</td><td>04 2015</td></tr>");
        foreach ($leaderArrs as $leaderId) {
            $mlmDistributor = MlmDistributorPeer::retrieveByPK($leaderId);
            print_r("<tr>");
            print_r("<td>".$mlmDistributor->getDistributorCode()."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-01-01 00:00:00", "2014-02-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-02-01 00:00:00", "2014-03-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-03-01 00:00:00", "2014-04-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-04-01 00:00:00", "2014-05-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-05-01 00:00:00", "2014-06-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-06-01 00:00:00", "2014-07-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-07-01 00:00:00", "2014-08-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-08-01 00:00:00", "2014-09-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-09-01 00:00:00", "2014-10-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-10-01 00:00:00", "2014-11-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-11-01 00:00:00", "2014-12-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2014-12-01 00:00:00", "2015-01-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2015-01-01 00:00:00", "2015-02-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2015-02-01 00:00:00", "2015-03-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2015-03-01 00:00:00", "2015-04-01 00:00:00")."</td>");
            print_r("<td>".$this->getMonthlySales($leaderId, "2015-04-01 00:00:00", "2015-05-01 00:00:00")."</td>");
            print_r("</tr>");
        }
        print_r("</table>");
        print_r("<br><br>Done");
        return sfView::HEADER_ONLY;
    }
    public function executeTotalCommissionReport()
    {
        $query = "SELECT dist.distributor_code, YEAR(commission.created_on) AS year, MONTH(commission.created_on) as month
, SUM(commission.credit - commission.debit) AS total_commission, commission.created_on
	FROM mlm_dist_commission_ledger commission
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = commission.dist_id
WHERE commission.dist_id IN (203,1797,1615,263134,282,255677,257273,333,255322) AND commission_type IN ('DRB','GDB','PIPS_BONUS','CREDIT_REFUND')
    GROUP BY commission.dist_id, YEAR(commission.created_on), MONTH(commission.created_on)
ORDER BY commission.dist_id, YEAR(commission.created_on), MONTH(commission.created_on)";
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        $arr = array();

        print_r("<table><tr><td>Member ID </td><td>Year</td><td>Month</td><td>Total Commission</td><td>Date</td></tr>");
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            print_r("<tr><td>".$arr['distributor_code']."</td><td>".$arr['year']."</td><td>".$arr['month']."</td><td>".$arr['total_commission']
                    ."</td><td>".$arr['created_on']."</td></tr>");
        }
        print_r("</table>");
        print_r("<br><br>Done");
        return sfView::HEADER_ONLY;
    }

    function getMonthlySales($distributorId, $dateFrom, $dateTo)
    {
        $query = "SELECT dist.distributor_code
        , (Coalesce(reg._SUM, 0) + Coalesce(upgrade._SUM,0)) AS SUB_TOTAL
        , Coalesce(reg._SUM, 0) AS register_sum
        , Coalesce(upgrade._SUM, 0) AS upgrade_sum
, dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
    FROM
    mlm_distributor dist
LEFT JOIN
(
    SELECT SUM(package.price) AS _SUM, ".$distributorId." AS upline_dist_id
        FROM mlm_distributor newDist
            LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
        WHERE newDist.loan_account = 'N'
            AND newDist.from_abfx = 'N'
            AND newDist.tree_structure LIKE '%|".$distributorId."|%'
            AND newDist.active_datetime >= '".$dateFrom."'
            AND newDist.active_datetime < '".$dateTo."'
) reg ON dist.distributor_id = reg.upline_dist_id
LEFT JOIN
(
    SELECT SUM(package.price) AS _sum
            , ".$distributorId." AS upline_dist_id
        FROM mlm_package_upgrade_history history
            LEFT JOIN mlm_distributor newDist ON history.dist_id = newDist.distributor_id
            LEFT JOIN mlm_package package ON package.package_id = history.package_id
        WHERE newDist.loan_account = 'N'
            AND newDist.from_abfx = 'N'
            AND newDist.tree_structure LIKE '%|".$distributorId."|%'
            AND history.created_on >= '".$dateFrom."'
            AND history.created_on < '".$dateTo."'
) upgrade ON dist.distributor_id = upgrade.upline_dist_id WHERE dist.distributor_id = ".$distributorId;

        //var_dump($query);
        //exit();
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
}
