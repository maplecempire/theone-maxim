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
    public function executeIncentive()
    {
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "prize.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $counter = 1;
        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = $totalRow; $x > 0; $x--) {
            $memberId = $data->val($x, "A");
            $prize = $data->val($x, "E");
            $deduct = $data->val($x, "F");

            $prize = str_replace(",", "", $prize);
            $prize = str_replace("*", "", $prize);
            $deduct = str_replace("(", "", $deduct);
            $deduct = str_replace(")", "", $deduct);
            $deduct = str_replace("*", "", $deduct);

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $memberId);
            $distributorDB = MlmDistributorPeer::doSelectOne($c);

            if ($distributorDB) {
                print_r($memberId.":".$prize.":".$deduct."<br>");

                $cp2 = $this->getAccountBalance($distributorDB->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);

                if ($prize > 0) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distributorDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType("WOF");
                    $mlm_account_ledger->setRemark("WOF PRIZE");
                    $mlm_account_ledger->setCredit($prize);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($cp1 + $prize);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                } else {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distributorDB->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType("WOF");
                    $mlm_account_ledger->setRemark("WOF");
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($deduct);
                    $mlm_account_ledger->setBalance($cp1 - $deduct);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                }
            } else {
                print_r($memberId."not found========================================<br>");
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDisqualifiedMember()
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
                            AND dist.q3_champions = 'Y'
                            AND newDist.created_on >= '2013-08-05 00:00:00' AND newDist.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
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
                            AND dist.q3_champions = 'Y'
                            AND history.created_on >= '2013-08-05 00:00:00' AND history.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id
                    HAVING SUB_TOTAL < 100000
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
        $idx = 1;
        foreach ($resultArray as $member) {
            $totalSales = $member['SUB_TOTAL'];
            echo "<br>" . $idx++ . "-" . $totalSales . "-" . $member['distributor_code'] . "-" . $member['country'];
        }
        /*foreach ($resultArray as $member) {
            $totalSales = $member['SUB_TOTAL'];

            $cp1 = $this->getAccountBalance($member['upline_dist_id'], Globals::ACCOUNT_TYPE_EPOINT);
            $cp2 = $this->getAccountBalance($member['upline_dist_id'], Globals::ACCOUNT_TYPE_ECASH);
            $cp3 = $this->getAccountBalance($member['upline_dist_id'], Globals::ACCOUNT_TYPE_MAINTENANCE);
            $fine = 1000;
            $enough = "*****";
            if ($cp1 >= $fine) {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($member['upline_dist_id']);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType("Q3");
                $mlm_account_ledger->setRemark("Commitment Fee of 1,000CP (deducted from CP1/CP2/CP3) in the event that the Registrant fails to achieve at least USD100,000 of Personal Sales during Challenge Period.");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($fine);
                $mlm_account_ledger->setBalance($cp1 - $fine);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $enough = "";
            } else if ($cp2 >= $fine) {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($member['upline_dist_id']);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setTransactionType("Q3");
                $mlm_account_ledger->setRemark("Commitment Fee of 1,000CP (deducted from CP1/CP2/CP3) in the event that the Registrant fails to achieve at least USD100,000 of Personal Sales during Challenge Period.");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($fine);
                $mlm_account_ledger->setBalance($cp2 - $fine);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $enough = "";
            } else if ($cp3 >= $fine) {
                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($member['upline_dist_id']);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $mlm_account_ledger->setTransactionType("Q3");
                $mlm_account_ledger->setRemark("Commitment Fee of 1,000CP (deducted from CP1/CP2/CP3) in the event that the Registrant fails to achieve at least USD100,000 of Personal Sales during Challenge Period.");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($fine);
                $mlm_account_ledger->setBalance($cp3 - $fine);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $enough = "";
            }

            echo $enough.$member['upline_dist_id']."-".$idx++ . "-" . $totalSales . "-" . $member['distributor_code'] . "-" . $member['country'] . "-CP1:" . $cp1. "-CP2:" . $cp2. "-CP3:" . $cp3 . "<br>";
        }*/

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeIndex()
    {
        //return $this->redirect('member/summary');

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->isChallenge = "N";
        $this->totalPersonalSales = 0;
        $this->entitleRolex = "N";
        if ($distDB->getQ3Champions() == "Y") {
            $this->isChallenge = "Y";
            $this->totalPersonalSales = $this->getTotalPersonalSales();

            if ($this->totalPersonalSales > 200000) {
                $this->entitleRolex = "Y";
            }
        }

        $query = "SELECT newDist.upline_dist_id, dist.distributor_code, SUM(package.price) AS _SUM
                            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM mlm_distributor newDist
                        LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                where newDist.loan_account = 'N'
                    AND newDist.from_abfx = 'N'
                    AND dist.q3_champions = 'Y'
                    AND newDist.created_on >= '2013-08-05 00:00:00' AND newDist.created_on <= '2013-09-30 23:59:59' group by upline_dist_id order by 3 desc limit 10";

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
                            AND dist.q3_champions = 'Y'
                            AND newDist.created_on >= '2013-08-05 00:00:00' AND newDist.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
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
                            AND dist.q3_champions = 'Y'
                            AND history.created_on >= '2013-08-05 00:00:00' AND history.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
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

    public function executeIndex2()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->isChallenge = "N";
        $this->totalPersonalSales = 0;
        $this->entitleRolex = "N";
        if ($distDB->getQ3Champions() == "Y") {
            $this->isChallenge = "Y";
            $this->totalPersonalSales = $this->getTotalPersonalSales();

            if ($this->totalPersonalSales > 200000) {
                $this->entitleRolex = "Y";
            }
        }

        $query = "SELECT newDist.upline_dist_id, dist.distributor_code, SUM(package.price) AS _SUM
                            , dist.tree_structure, dist.full_name, dist.email, dist.contact, dist.country, dist.created_on
                    FROM mlm_distributor newDist
                        LEFT JOIN mlm_package package ON package.package_id = newDist.init_rank_id
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = newDist.upline_dist_id
                where newDist.loan_account = 'N'
                    AND newDist.from_abfx = 'N'
                    AND dist.q3_champions = 'Y'
                    AND newDist.created_on >= '2013-08-05 00:00:00' AND newDist.created_on <= '2013-09-30 23:59:59' group by upline_dist_id order by 3 desc limit 10";

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
                            AND dist.q3_champions = 'Y'
                            AND newDist.created_on >= '2013-08-05 00:00:00' AND newDist.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
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
                            AND dist.q3_champions = 'Y'
                            AND history.created_on >= '2013-08-05 00:00:00' AND history.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
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

    public function executeSubmit()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB->getQ3Champions() != "Y") {
            $distDB->setQ3Champions("Y");
            $distDB->setQ3Datetime(date("Y/m/d h:i:s A"));
            $distDB->save();
        }
        $this->setFlash('successMsg', "Submit successfully");
        return $this->redirect('q3ChampionsChallenge/index');
    }

    function getTotalPersonalSales()
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
                            AND dist.q3_champions = 'Y'
                            AND newDist.upline_dist_id = " . $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0) . "
                            AND newDist.created_on >= '2013-08-05 00:00:00' AND newDist.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
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
                            AND dist.q3_champions = 'Y'
                            AND newDist.upline_dist_id = " . $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0) . "
                            AND history.created_on >= '2013-08-05 00:00:00' AND history.created_on <= '2013-09-30 23:59:59' group by upline_dist_id
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

//    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//    ^^^^^^^^^^^^^^^^^^^^      Bangkok      ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    public function executeBkk2()
    {
//        $this->executeTop2013();
//        $this->executeTop2013();
//        $this->executeTop2013();
//        $this->executeTop2013();
//        $this->executeTop2013();
//        $this->executeTop2013();
//        $this->executeBkk();
        $this->executeCheckSales();
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeTop2013()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(10000);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        foreach ($distDBs as $distDB) {
            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");

            $left = $this->getTotalGroupSales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $right = $this->getTotalGroupSales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $lowest = $left;
            if ($right < $left) {
                $lowest = $right;
            }

            //$distDB->setBkkQualify1(number_format($left,0));
            //$distDB->setBkkQualify2($right);
            $distDB->setBkkPersonalSales($lowest);
            $distDB->setBkkStatus("COMPLETE");
            $distDB->save();
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeBkk()
    {
//        258906	aplim-01
//        261490	LimLayHong
//        262217	LimSiangLong
//        260314	TanEngeHooi
//        $accountTypeArr = array(258906,261490,262217,260314);
        $accountTypeArr = array(260743);

        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(10000);
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr , Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        foreach ($distDBs as $distDB) {
            $distDB->setBkkQualify1("N");
            $distDB->setBkkQualify2("N");
            $distDB->setBkkQualify3("N");
            $distDB->setBkkPersonalSales(0);

            print_r($idx-- . ":" . $distDB->getDistributorCode()."<br>");

            if ($distDB->getLoanAccount() != "Y") {
                if ($distDB->getInitRankId() == 3 && $this->validateActivateDate($distDB->getDistributorId())) {
                    $distDB->setBkkQualify1("Y");
                }
                if ($distDB->getInitRankId() >= 4 && $this->validateActivateDate($distDB->getDistributorId())) {
                    $distDB->setBkkQualify2("Y");
                }
            }

            $amount = $this->getUpgradedPackage($distDB->getDistributorId());
            if ($amount == 10000) {
                $distDB->setBkkQualify1("Y");
            }
            if ($amount >= 20000) {
                $distDB->setBkkQualify2("Y");
            }
            $distDB->setRemark($amount);
            $personalSales = $this->getBkkTotalPersonalSales($distDB->getDistributorId());
            $distDB->setBkkPersonalSales($personalSales);

            if ($personalSales >= 40000) {
                $distDB->setBkkQualify3("Y");
            }

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

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeCheckSales()
    {
//        258906	aplim-01
//        261490	LimLayHong
//        262217	LimSiangLong
//        260314	TanEngeHooi
//        $accountTypeArr = array(258906,261490,262217,260314);
        $distStr = "datoheng,success69,CHONGLONGHONG,helenpoh,FX5796,lee_chew_chun,chuashyangjwu,GDGRACE,yeesowsen,LKAng481,CHEAHSOKPING,chongszechung,lewtenshong,lor_Vincent,CKLeeJB2,ngiamhaiyi,chiayuhtzer,taysiaoleng,tansenghao,soosenjon,jeremyleechenhung,chuazongpu,phangkangsheng,davidtoo129,Yauchinjun,shenping,chuayeesoung,wongqianwei,Romzi_anwar,Angchunyee,chewhooicheng";
        $distStr .= ",pingguatkhim,ngteckzhong,ongeuzan,cyliew,jawskit,mrleejb,TGKhoo,TLOng1,ShLim489,KEAVEN129,Eleenwong2,BRE129,david1470,joeey33,MINGDAWN,vision1,LAWCHUHOON,JULIEHA,AIFAA_ROSLAN,Rohasniza_mohamad_rosli,CHAI_YOKE_KHAM,KIMPLANETSA,wilson2,chinseng,gtkhoo62,wongyeowwah,ngyehming4,jackwongsk,William178,kenthugo";

        $arrs = explode(',', $distStr);
        for ($x = 0; $x <= count($arrs); $x++) {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $arrs[$x]);
            $distDB = MlmDistributorPeer::doSelectOne($c);

            if ($distDB) {
                $personalSales = $this->getCommitmentTotalPersonalSales($distDB->getDistributorId());

                print_r("<br>".$arrs[$x].":".$personalSales);
            } else {
                print_r("<br>".$arrs[$x].":not found");
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    function validateActivateDate($distributorId)
    {
        $query = "SELECT distributor_id, active_datetime
                    FROM mlm_distributor dist
                WHERE dist.active_datetime >= '2013-10-22 00:00:00' AND dist.active_datetime <= '2013-12-31 23:59:59'
                    AND distributor_id = '" . $distributorId . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            return true;
        }
        return false;
    }

    function getUpgradedPackage($distributorId)
    {
        $query = "SELECT upgrade_id, dist_id, package_id, mt4_user_name, mt4_password, transaction_code, amount
                    FROM mlm_package_upgrade_history history
                        LEFT JOIN mlm_distributor dist ON dist.distributor_id = history.dist_id
                    WHERE history.created_on >= '2013-10-22 00:00:00' AND history.created_on <= '2013-12-31 23:59:59'
                            AND amount >= 10000
                            AND dist_id = '" . $distributorId . "'
                        ORDER BY amount DESC";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["amount"] != null) {
                return $arr["amount"];
            } else {
                return 0;
            }
        }
        return 0;
    }

    function getBkkTotalPersonalSales($distributorId)
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
                            AND newDist.from_abfx = 'N'
                            AND newDist.upline_dist_id = " . $distributorId . "
                            AND newDist.active_datetime >= '2013-10-22 00:00:00' AND newDist.active_datetime <= '2013-12-31 23:59:59' group by upline_dist_id
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
                            AND newDist.upline_dist_id = " . $distributorId . "
                            AND history.created_on >= '2013-10-22 00:00:00' AND history.created_on <= '2013-12-31 23:59:59' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id";

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
    function getCommitmentTotalPersonalSales($distributorId)
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
                            AND newDist.from_abfx = 'N'
                            AND newDist.upline_dist_id = " . $distributorId . "
                            AND newDist.active_datetime >= '2014-01-27 00:00:00' AND newDist.active_datetime <= '2014-02-15 23:59:59' group by upline_dist_id
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
                            AND newDist.upline_dist_id = " . $distributorId . "
                            AND history.created_on >= '2014-01-27 00:00:00' AND history.created_on <= '2014-02-15 23:59:59' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id";

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

    function getTotalGroupSales($distributorId, $leftRight)
    {
        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE
            dist_id = " . $distributorId . " AND left_right = '" . $leftRight . "' AND created_on >= '2013-01-01 00:00:00' AND created_on <= '2013-12-31 23:59:59'";

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
}
