<?php

/**
 * rookieChallenge actions.
 *
 * @package    sf_sandbox
 * @subpackage rookieChallenge
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class rookieChallengeActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
        $rookieChallenge = false;
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB->getActiveDatetime() != null) {
            $exp_date = "2014-03-01";
            $todays_date = $distDB->getActiveDatetime();
            $today = strtotime($todays_date);
            $expiration_date = strtotime($exp_date);
            if ($expiration_date > $today) {

            } else {
                $rookieChallenge = true;
            }
        }

        if ($rookieChallenge == true) {
            $dateFrom = '2014-08-08 00:00:00';
            $dateTo = '2014-09-19 23:59:59';
            $this->totalPersonalSales = $this->getTotalPersonalSales($this->getUser()->getAttribute(Globals::SESSION_DISTID, 0), $dateFrom, $dateTo);
        } else {
            return $this->redirect('/member/summary');
        }
    }

    public function executeDoReleaseCommission()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(3000);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);

        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            foreach ($distDBs as $affectedDistributor) {
                print_r($idx-- . ":" . $affectedDistributor->getDistributorCode()."<br>");


                $dateFrom = '2014-08-08 00:00:00';
                $dateTo = '2014-09-19 23:59:59';
                $totalPersonalSales = $this->getTotalPersonalSales($affectedDistributor->getDistributorId(), $dateFrom, $dateTo);

                $commission = 0;
                $percentage = 0;
                $exceedPersonalSales = $totalPersonalSales;
                if ($totalPersonalSales >= 50000 && $totalPersonalSales < 100000) {
                    $percentage = 5;
                    $commission = $totalPersonalSales * $percentage / 100;
                } else if ($totalPersonalSales >= 100000 && $totalPersonalSales < 200000) {
                    $percentage = 6;
                    $commission = $totalPersonalSales * $percentage / 100;
                } else if ($totalPersonalSales >= 200000) {
                    if ($totalPersonalSales > 300000) {
                        $exceedPersonalSales = $totalPersonalSales;
                        $totalPersonalSales = 300000;
                    }
                    $percentage = 7;
                    $commission = $totalPersonalSales * $percentage / 100;
                }

                if ($commission > 0) {
                    $distAccountEcashBalance = $this->getAccountBalance($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
                    $distAccountEcashBalance = $distAccountEcashBalance + $commission;

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($affectedDistributor->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ROOKIE_CHALLENGE);
                    $mlm_account_ledger->setRemark("Total Sales: ". number_format($exceedPersonalSales, 0). " (".$percentage."%)");
                    //$mlm_account_ledger->setInternalRemark("Total Sales: ". number_format($exceedPersonalSales, 0). " (".$percentage.")");
                    $mlm_account_ledger->setCredit($commission);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distAccountEcashBalance);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->mirroringAccountLedger($mlm_account_ledger, "92");
                }

                $affectedDistributor->setBkkStatus("COMPLETE");
                $affectedDistributor->save();
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            //throw $e;
        }

        print_r("<br><br><br>Done");
        return sfView::HEADER_ONLY;
    }
    function getTotalPersonalSales($distId, $dateFrom, $dateTo)
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
                            AND newDist.upline_dist_id = " . $distId . "
                            AND newDist.active_datetime >= '".$dateFrom."' AND newDist.active_datetime <= '".$dateTo."' group by upline_dist_id
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
                            AND newDist.upline_dist_id = " . $distId . "
                            AND history.created_on >= '".$dateFrom."' AND history.created_on <= '".$dateTo."' group by upline_dist_id
                ) upgrade ON reg.upline_dist_id = upgrade.upline_dist_id
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = reg.upline_dist_id
            WHERE dist.distributor_id = " . $distId;

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
        $log_account_ledger->setCreatedBy($mlmAccountLedger->getCreatedBy());
        $log_account_ledger->setUpdatedBy($mlmAccountLedger->getUpdatedBy());
        $log_account_ledger->save();
    }
}
