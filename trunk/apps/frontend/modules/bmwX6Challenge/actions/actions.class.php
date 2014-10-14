<?php

/**
 * bmwX6Challenge actions.
 *
 * @package    sf_sandbox
 * @subpackage bmwX6Challenge
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class bmwX6ChallengeActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeDiamondChallenge()
    {
        $dateFrom = '2014-06-14 00:00:00';
        $dateTo = '2014-06-30 23:59:59';
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        $query = "SELECT distributor_id, distributor_code, full_name, package.price, tree_structure, active_datetime
                FROM mlm_distributor dist
                    LEFT JOIN mlm_package package ON package.package_id = dist.init_rank_id
                        WHERE dist.loan_account = 'N'
                            AND dist.from_abfx = 'N'
                                        AND dist.active_datetime >= '".$dateFrom."' AND dist.active_datetime <= '".$dateTo."'
                            AND package.price >= 100000";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $resultArray[$count] = $arr;

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
            $resultArray[$count]['LEADER'] = $leader;
            $count++;
        }

        $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, package.price, history.created_on, dist.tree_structure
        FROM mlm_package_upgrade_history history
        LEFT JOIN mlm_distributor dist ON history.dist_id = dist.distributor_id
        LEFT JOIN mlm_package package ON package.package_id = history.package_id
            WHERE dist.loan_account = 'N'
                AND dist.from_abfx = 'N'
                            AND history.created_on >= '".$dateFrom."' AND history.created_on <= '".$dateTo."'
                AND package.price >= 100000";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $upgradeResultArray = array();
        $count = 0;

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $upgradeResultArray[$count] = $arr;

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
            $upgradeResultArray[$count]['LEADER'] = $leader;

            $count++;
        }
        $this->resultArray = $resultArray;
        $this->upgradeResultArray = $upgradeResultArray;
    }
    public function executeIndex()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $dateFrom = '2014-06-01 00:00:00';
        $dateTo = '2014-08-31 23:59:59';
        $this->totalPersonalSales = $this->getTotalPersonalSales($dateFrom, $dateTo);

        $query = "SELECT reg.upline_dist_id, dist.distributor_code
                        , (Coalesce(reg._SUM, 0) + Coalesce(upgrade._SUM,0)) AS SUB_TOTAL
                        , Coalesce(reg._SUM, 0) AS register_sum
                        , Coalesce(upgrade._SUM, 0) AS upgrade_sum
                        , dist.email, dist.full_name, dist.contact, dist.country, dist.tree_structure
                , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM
                (
                    SELECT SUM(package.price) AS _SUM, newDist.upline_dist_id
                        FROM mlm_distributor newDist
                            LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                            LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                        WHERE newDist.loan_account = 'N'
                            AND newDist.from_abfx = 'N'
                            AND newDist.created_on >= '".$dateFrom."' AND newDist.created_on <= '".$dateTo."' group by upline_dist_id
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
                            AND history.created_on >= '".$dateFrom."' AND history.created_on <= '".$dateTo."' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id
                    HAVING SUB_TOTAL >= 3000000
                        ORDER BY 3 DESC ";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $resultArray[$count] = $arr;
            $count++;
        }
        $this->resultArray = $resultArray;
    }

    function getTotalPersonalSales($dateFrom, $dateTo)
    {
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
                            AND newDist.upline_dist_id = " . $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0) . "
                            AND newDist.created_on >= '".$dateFrom."' AND newDist.created_on <= '".$dateTo."' group by upline_dist_id
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
                            AND newDist.upline_dist_id = " . $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0) . "
                            AND history.created_on >= '".$dateFrom."' AND history.created_on <= '".$dateTo."' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id
            WHERE dist.distributor_id = " . $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0);

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            $result = $arr["SUB_TOTAL"];
        }
        return $result;
    }
}