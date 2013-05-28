<?php

/**
 *
 *
 *
 * @package lib.model
 * @author r9jason
 */
class BonusService
{
    function checkDebitAccount($distId)
    {
        $isDebit = false;

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distId);
        $c->add(MlmDistributorPeer::DEBIT_ACCOUNT, "Y");
        $c->add(MlmDistributorPeer::DEBIT_STATUS_CODE, Globals::STATUS_ACTIVE);
        $distDB = MlmDistributorPeer::doSelectOne($c);

        if ($distDB) {
            $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);

            if ($distAccountEcashBalance <= 0) {
                $distDB->setPackagePurchaseFlag(Globals::YES);
                $distDB->setDebitStatusCode(Globals::STATUS_COMPLETE);
                $distDB->save();
            } else {
                $isDebit = true;
            }
        }

        return $isDebit;
    }
    function contraDebitAccount($distId, $debitAccountRemark)
    {
        $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);
        $distAccountDebitBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);

        $totalDebit = 0;
        if ($distAccountDebitBalance > $distAccountEcashBalance) {
            $totalDebit = $distAccountEcashBalance;
        } else {
            $totalDebit = $distAccountDebitBalance;

            $distDB = MlmDistributorPeer::retrieveByPK($distId);
            $distDB->setPackagePurchaseFlag("Y");
            $distDB->setDebitStatusCode(Globals::STATUS_COMPLETE);
            $distDB->save();
        }

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($distId);
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DEBIT_ACCOUNT);
        $mlm_account_ledger->setRemark("DEBITED TO DEBIT ACCOUNT");
        $mlm_account_ledger->setCredit(0);
        $mlm_account_ledger->setDebit($totalDebit);
        $mlm_account_ledger->setBalance($distAccountEcashBalance - $totalDebit);
        $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
        $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
        $mlm_account_ledger->save();

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($distId);
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_ECASH_DEBIT);
        $mlm_account_ledger->setRemark($debitAccountRemark);
        $mlm_account_ledger->setCredit(0);
        $mlm_account_ledger->setDebit($totalDebit);
        $mlm_account_ledger->setBalance($distAccountDebitBalance - $totalDebit);
        $mlm_account_ledger->setCreatedBy(Globals::SYSTEM_USER_ID);
        $mlm_account_ledger->setUpdatedBy(Globals::SYSTEM_USER_ID);
        $mlm_account_ledger->save();

        return true;
    }

    function doCalculateSpecialBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_SPECIAL_BONUS . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        //var_dump($query);

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
    function doCalculateFundManagementBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_FUND_MANAGEMENT . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        //var_dump($query);

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
    function doCalculatePipsRebateBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_CREDIT_REFUND . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        //var_dump($query);

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
    function doCalculateGenerationBonus($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_PIPS_BONUS . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        //var_dump($query);

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
    function doCalculateGrb($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_GDB . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        //var_dump($query);

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
    function doCalculateDrb($queryDate)
    {
        $query = "SELECT sum(credit - debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger";

        $query .= " WHERE commission_type = '" . Globals::COMMISSION_TYPE_DRB . "'";
        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        //var_dump($query);

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
    function doCalculatePackage($queryDate)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $mlm_packages = MlmPackagePeer::doSelect($c);

        $resultArr = array();
        $count = 0;
        foreach ($mlm_packages as $package) {
            $resultArr[$count]["packageId"] = $package->getPackageId();
            $resultArr[$count]["name"] = $package->getPackageName();
            $resultArr[$count]["price"] = $package->getPrice();

            $totalPurchasePackage = $this->doTotalPurchasePackage($queryDate, $package->getPackageId());
            $totalUpgradePackage = $this->doTotalUpgradePackage($queryDate, $package->getPackageId());
            $resultArr[$count]["qty"] = $totalPurchasePackage + $totalUpgradePackage;
            $count++;
        }

        return $resultArr;
    }
    function doTotalPurchasePackage($queryDate, $packageId)
    {
        $query = "select count(rank_id) as SUB_TOTAL from mlm_distributor
                    where rank_id = ".$packageId;

        $query .= " AND loan_account = 'N'";
        $query .= " AND active_datetime >= '" . $queryDate . " 00:00:00'";
        $query .= " AND active_datetime <= '" . $queryDate . " 23:59:59'";
        $query .= " group by rank_id";
        //var_dump($query);

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
    function doTotalUpgradePackage($queryDate, $packageId)
    {
        $query = "select count(package_id) as SUB_TOTAL from mlm_package_upgrade_history
                    where package_id = ".$packageId;

        $query .= " AND created_on >= '" . $queryDate . " 00:00:00'";
        $query .= " AND created_on <= '" . $queryDate . " 23:59:59'";
        $query .= " group by package_id";
        //var_dump($query);

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
}
