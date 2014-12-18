<?php

/**
 * porcherChallenge actions.
 *
 * @package    sf_sandbox
 * @subpackage porcherChallenge
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class porscheChallengeActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB != 1) {
          return $this->redirect('/member/summary');
        }
        $dateFrom = '2014-09-01 00:00:00';
        $dateTo = '2014-12-31 23:59:59';
        $this->totalPersonalSales = $this->getTotalPersonalSales($dateFrom, $dateTo);

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
                    AND history.created_on >= '" . $dateFrom . "' AND history.created_on <= '" . $dateTo . "' group by upline_dist_id
        ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id
            HAVING SUB_TOTAL >= 100000
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
                            AND newDist.upline_dist_id = " . $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0) . "
                            AND history.created_on >= '" . $dateFrom . "' AND history.created_on <= '" . $dateTo . "' group by upline_dist_id
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
