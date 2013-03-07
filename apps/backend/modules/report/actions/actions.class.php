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
                    </tr>
                    </thead>
                    <tbody>";

        $idx = 1;
        foreach ($arrs as $arr) {
            $rollingPoint = $arr['ROLLING_POINT'];
            $rollingPointAvailable = $rollingPoint;
            $rollingPointUsed = 0;
            if ($arr['EPOINT'] < 0) {
                $rollingPointAvailable = $rollingPointAvailable + $arr['EPOINT'];
                $rollingPointUsed = $arr['EPOINT'] * -1;
            }

            $body .= "<tr class='sf_admin_row_1'>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$idx++."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['distributor_code']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['full_name']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['email']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['contact']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPoint,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPointAvailable,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPointUsed,2)."</td>
                    </tr>";
        }

        $body .= "</tbody>
                </table>";

        return $body;
    }
    function fetchRollingPoint() {
        $query = "SELECT
            transferLedger.dist_id, dist.distributor_code, dist.full_name, dist.email, dist.contact
            , SUM(transferLedger.credit - transferLedger.debit) AS ROLLING_POINT
                    , account.EPOINT
                FROM mlm_account_ledger transferLedger
                    LEFT JOIN
                        (
                            SELECT sum(credit - debit) AS EPOINT, account.dist_id
                                FROM mlm_account_ledger account
                                    where account.account_type = 'EPOINT' AND rolling_point = 'N' group by account.dist_id
                        ) account ON account.dist_id = transferLedger.dist_id
                    LEFT JOIN mlm_distributor dist ON dist.distributor_id = transferLedger.dist_id
                where transferLedger.rolling_point = 'Y' group by transferLedger.dist_id";

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
        return $resultArray;
    }
}
