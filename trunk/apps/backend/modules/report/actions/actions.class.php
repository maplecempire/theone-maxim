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
    public function executeRollingPointList()
    {
        $this->rollingPointTable = $this->getRollingPointData();
    }
    public function executeConvertEcashToEpoint()
    {
    }
    public function executeEpointTransfer()
    {
    }
    public function executeGroupSales()
    {
    }
    public function executeIndividualTraderSales()
    {
    }
    public function executeMt4Withdrawal()
    {
    }
    public function executeReferralBonus()
    {
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

    function getRollingPointData() {
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
            $rollingPointAvailable = $rollingPoint - $arr['TOTAL_RP_USED'];

            $body .= "<tr class='sf_admin_row_1'>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$idx++."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['distributor_code']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['full_name']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['email']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['contact']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPoint,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPointAvailable,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPointUsed,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($debitAccount,2)."</td>
                    </tr>";
        }

        $body .= "</tbody>
                </table>";

        return $body;
    }
    function fetchRollingPoint() {
        $query = "SELECT transferLedger.dist_id, dist.distributor_code, dist.full_name, dist.email, dist.contact
        , totalRollingPoint.TOTAL_ROLLING_POINT
        , debitPoint.TOTAL_DEBIT
        , rpUsed.TOTAL_RP_USED
    FROM mlm_account_ledger transferLedger
        LEFT JOIN
            (
                SELECT sum(credit) AS TOTAL_ROLLING_POINT, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '".Globals::ACCOUNT_TYPE_RP."' group by dist_id
            ) totalRollingPoint ON totalRollingPoint.dist_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(credit) AS TOTAL_DEBIT, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '".Globals::ACCOUNT_TYPE_DEBIT."' group by dist_id
            ) debitPoint ON debitPoint.dist_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(debit) AS TOTAL_RP_USED, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '".Globals::ACCOUNT_TYPE_RP."' group by dist_id
            ) rpUsed ON rpUsed.dist_id = transferLedger.dist_id
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = transferLedger.dist_id
    where transferLedger.account_type = '".Globals::ACCOUNT_TYPE_RP."' group by transferLedger.dist_id";
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
            $count++;
        }
        return $resultArray;
    }
}
