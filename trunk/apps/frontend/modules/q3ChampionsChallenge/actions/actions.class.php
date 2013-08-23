<?php

/**
 * q3ChampionsChallenge actions.
 *
 * @package    sf_sandbox
 * @subpackage q3ChampionsChallenge
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class q3ChampionsChallengeActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->isChallenge = "N";
        if ($distDB->getQ3Champions() == "Y") {
            $this->isChallenge = "Y";
        }

        $query = "SELECT newDist.upline_dist_id, dist.distributor_code, dist.country, SUM(package.price) AS _SUM
                            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM mlm_distributor newDist
                        LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                where newDist.loan_account = 'N'
                    AND newDist.from_abfx = 'N'
                    AND dist.q3_champions = 'Y'
                    AND newDist.created_on >= '2013-07-06 00:00:00' group by upline_dist_id order by 3 desc limit 10";

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

    public function executeSubmit() {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB->getQ3Champions() != "Y") {
            $distDB->setQ3Champions("Y");
            $distDB->setQ3Datetime(date("Y/m/d h:i:s A"));
            $distDB->save();
        }
        $this->setFlash('successMsg', "Submit successfully");
        return $this->redirect('q3ChampionsChallenge/index');
    }
}
