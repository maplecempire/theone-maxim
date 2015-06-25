<?php

/**
 * finance actions.
 *
 * @package    sf_sandbox
 * @subpackage finance
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class financeActions extends sfActions
{
    public function executeTest() {

        $bonusService = new BonusService();
        //$bonusService->contraDebitAccountByEpoint(263918, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(264193, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(264788, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(264787, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(261974, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(259509, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(266499, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(266510, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(266510, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(266497, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(266508, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(266498, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(271934, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(82, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(267688, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(278433, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(256630, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(281454, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283154, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283156, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283155, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283517, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(281449, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(264009, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283503, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(260251, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283510, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(280618, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283154, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283156, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283155, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(283157, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccount(274445, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(255792, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(260581, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(262252, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(339633, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(339630, "CONTRA BY CP2", 0);
        $bonusService->contraDebitAccount(261554, "CONTRA BY CP2", 0);

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeBonusDetailLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = "SELECT commission.created_on
, Coalesce(ob._GDB, 0) AS _GDB
, Coalesce(sss._GDB_SSS, 0) AS _GDB_SSS
, Coalesce(drb._DRB, 0) AS _DRB
, Coalesce(sales._PIPS_BONUS, 0) AS _PIPS_BONUS
, Coalesce(leader._SPECIAL_BONUS, 0) AS _SPECIAL_BONUS
, (Coalesce(ob._GDB, 0) + Coalesce(sss._GDB_SSS, 0) + Coalesce(drb._DRB,0) + Coalesce(sales._PIPS_BONUS, 0) + Coalesce(leader._SPECIAL_BONUS, 0)) AS SUB_TOTAL
    FROM (
        SELECT DATE(created_on) AS created_on FROM mlm_dist_commission_ledger WHERE dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) commission
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _GDB, DATE(created_on) as ob_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_GDB."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) ob ON commission.created_on = ob.ob_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _GDB_SSS, DATE(created_on) as sss_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_GDB_SSS."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) sss ON commission.created_on = sss.sss_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _DRB, DATE(created_on) as drb_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_DRB."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) drb ON commission.created_on = drb.drb_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _SPECIAL_BONUS, DATE(created_on) as leader_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_SPECIAL_BONUS."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) leader ON commission.created_on = leader.leader_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _PIPS_BONUS, DATE(created_on) as sales_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_PIPS_BONUS."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) sales ON commission.created_on = sales.sales_created_on";

        /******   total records  *******/
        $sWhere = "";
        /******   total filtered records  *******/

        $countSql = " FROM (
        SELECT DATE(created_on) AS created_on FROM mlm_dist_commission_ledger WHERE dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) commission
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _GDB, DATE(created_on) as ob_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_GDB."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) ob ON commission.created_on = ob.ob_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _GDB_SSS, DATE(created_on) as sss_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_GDB_SSS."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) sss ON commission.created_on = sss.sss_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _DRB, DATE(created_on) as drb_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_DRB."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) drb ON commission.created_on = drb.drb_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _SPECIAL_BONUS, DATE(created_on) as leader_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_SPECIAL_BONUS."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) leader ON commission.created_on = leader.leader_created_on
    LEFT JOIN (
        SELECT SUM(credit-debit) AS _PIPS_BONUS, DATE(created_on) as sales_created_on
            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_PIPS_BONUS."' AND dist_id = ".$this->getUser()->getAttribute(Globals::SESSION_DISTID)." GROUP BY DATE(created_on)
    ) sales ON commission.created_on = sales.sales_created_on";
        $totalRecords = $this->getTotalRecords($countSql . $sWhere);
        $totalFilteredRecords = $totalRecords;

        /******   sorting  *******/
        $sOrder = "ORDER BY ";
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] . "
                    " . mysql_real_escape_string($this->getRequestParameter('sSortDir_' . $i)) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") {
            $sOrder = "";
        }

        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();
            $arr[] = array(
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['_DRB'] == null ? "" : $resultArr['_DRB'],
                $resultArr['_GDB'] == null ? "" : $resultArr['_GDB'],
                $resultArr['_GDB_SSS'] == null ? "" : $resultArr['_GDB_SSS'],
                $resultArr['_PIPS_BONUS'] == null ? "" : $resultArr['_PIPS_BONUS'],
                $resultArr['_SPECIAL_BONUS'] == null ? "" : $resultArr['_SPECIAL_BONUS'],
                $resultArr['SUB_TOTAL'] == null ? "" : $resultArr['SUB_TOTAL'],
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        if ($this->getRequestParameter("t_columns")) {
            $output["t_columns"] = json_decode($this->getRequestParameter("t_columns"));
        }
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeBonusDetailList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = " credit, debit, balance, remark, created_on
	        FROM mlm_dist_commission_ledger ";

        /******   total records  *******/
        $sWhere = " WHERE dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND commission_type = '".$this->getRequestParameter('filterAction')."'";
        $sWhere .= " AND created_on >= '".$this->getRequestParameter('filterDate')." 00:00:00' AND created_on <= '".$this->getRequestParameter('filterDate')." 23:59:59'";
        /******   total filtered records  *******/

        $ssql = " FROM mlm_dist_commission_ledger";

        if ("MAINTENANCE" == $this->getRequestParameter('filterAction')) {
            $sql = " credit, debit, balance, remark, created_on
	                FROM mlm_account_ledger ";

            /******   total records  *******/
            $sWhere = " WHERE dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
            $sWhere .= " AND account_type = 'ECASH'";
            $sWhere .= " AND transaction_type = 'SYSTEM MAINTENANCE'";
            $sWhere .= " AND created_on >= '".$this->getRequestParameter('filterDate')." 00:00:00' AND created_on <= '".$this->getRequestParameter('filterDate')." 23:59:59'";
            /******   total filtered records  *******/

            $ssql = " FROM mlm_account_ledger";
        }

        $totalRecords = $this->getTotalRecords($ssql . $sWhere);
        $totalFilteredRecords = $totalRecords;

        /******   sorting  *******/
        $sOrder = "ORDER BY ";
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] . "
                    " . mysql_real_escape_string($this->getRequestParameter('sSortDir_' . $i)) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") {
            $sOrder = "";
        }

        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

//        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $query = "SELECT " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $remark = $resultArr['remark'];

            $arr[] = array(
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['credit'] == null ? "0" : $resultArr['credit'],
                $resultArr['debit'] == null ? "0" : $resultArr['debit'],
                $resultArr['balance'] == null ? "0" : $resultArr['balance'],
                $remark
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        if ($this->getRequestParameter("t_columns")) {
            $output["t_columns"] = json_decode($this->getRequestParameter("t_columns"));
        }
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeFetchRoiList()
    {
        $mt4Username = $this->getRequestParameter('mt4UserId');
        $c = new Criteria();

        $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
        $totalRecords = MlmRoiDividendPeer::doCount($c);

        if ($totalRecords < Globals::DIVIDEND_TIMES_ENTITLEMENT) {
            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
            $c->addDescendingOrderByColumn(MlmRoiDividendPeer::IDX);
            $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

            if ($mlmRoiDividendDB) {
                $idx = $mlmRoiDividendDB->getIdx() + 1;
                for ($i = $idx; $i <= Globals::DIVIDEND_TIMES_ENTITLEMENT; $i++) {
                    $firstDividendTime = strtotime($mlmRoiDividendDB->getFirstDividendDate());

                    $monthAdded = $idx - 1;
                    $dividendDate = strtotime("+".$monthAdded." months", $firstDividendTime);

                    $mlm_roi_dividend = new MlmRoiDividend();
                    $mlm_roi_dividend->setDistId($mlmRoiDividendDB->getDistId());
                    $mlm_roi_dividend->setMt4UserName($mlmRoiDividendDB->getMt4UserName());
                    $mlm_roi_dividend->setIdx($idx);
                    //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                    $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                    $mlm_roi_dividend->setFirstDividendDate($mlmRoiDividendDB->getFirstDividendDate());
                    $mlm_roi_dividend->setPackageId($mlmRoiDividendDB->getPackageId());
                    $mlm_roi_dividend->setPackagePrice($mlmRoiDividendDB->getPackagePrice());
                    $mlm_roi_dividend->setRoiPercentage($mlmRoiDividendDB->getRoiPercentage());
                    $mlm_roi_dividend->setExceedDistId($mlmRoiDividendDB->getExceedDistId());
                    $mlm_roi_dividend->setExceedRoiPercentage($mlmRoiDividendDB->getExceedRoiPercentage());
                    //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                    //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                    $mlm_roi_dividend->setStatusCode($mlmRoiDividendDB->getStatusCode());
                    $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->save();

                    $idx = $idx + 1;
                }
            }
        }
        $c = new Criteria();
        $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
        $c->addAscendingOrderByColumn(MlmRoiDividendPeer::IDX);
        $mlmRoiDividends = MlmRoiDividendPeer::doSelect($c);

        $arr = array();
        foreach ($mlmRoiDividends as $result) {
            $percentage = $result->getRoiPercentage() == null ? "0" : $result->getRoiPercentage();
            if ($result->getStatusCode() == "PENDING") {
                $percentage = 0;
            }
            $statusCode = $result->getStatusCode()  == null ? "" : $result->getStatusCode();

            if ($statusCode == "ASSS") {
                $statusCode = "Auto - SSS";
            }
            $arr[] = array(
                $result->getIdx() == null ? "0" : $result->getIdx(),
                $result->getDividendDate() == null ? "" : $result->getDividendDate(),
                $result->getPackagePrice() == null ? "0" : number_format($result->getPackagePrice(),2),
                $result->getMt4Balance() == null ? "0" : number_format($result->getMt4Balance(),2),
                $percentage,
                $result->getDividendAmount() == null ? "0" : number_format($result->getDividendAmount(),2),
                $statusCode
            );
        }
        $output = array(
            "mlmRoiDividends" => $arr
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateDistPairing()
    {
        $distId = $this->getRequestParameter('distId');
        $distDB = MlmDistributorPeer::retrieveByPK($distId);

        print_r("======================================================");
        print_r("dist code=".$distDB->getDistributorId());
        print_r("<br>");

        $c = new Criteria();
        $c->add(MlmDistPairingLedgerPeer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, Globals::PLACEMENT_LEFT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedgerPeer::doSelect($c);

        $balance = 0;
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        $c = new Criteria();
        $c->add(MlmDistPairingLedgerPeer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, Globals::PLACEMENT_RIGHT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedgerPeer::doSelect($c);

        $balance = 0;
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateDistPairing2()
    {
        $distId = $this->getRequestParameter('distId');
        $distDB = MlmDistributorPeer::retrieveByPK($distId);

        print_r("======================================================");
        print_r("dist code=".$distDB->getDistributorId());
        print_r("<br>");

        $c = new Criteria();
        $c->add(MlmDistPairingLedger2Peer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedger2Peer::LEFT_RIGHT, Globals::PLACEMENT_LEFT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedger2Peer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedger2Peer::doSelect($c);

        $balance = 0;
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        $c = new Criteria();
        $c->add(MlmDistPairingLedger2Peer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedger2Peer::LEFT_RIGHT, Globals::PLACEMENT_RIGHT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedger2Peer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedger2Peer::doSelect($c);

        $balance = 0;
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateDistPairing20141231()
    {
        $distId = $this->getRequestParameter('distId');
        $distDB = MlmDistributorPeer::retrieveByPK($distId);

        print_r("======================================================");
        print_r("20141231 dist code=".$distDB->getDistributorId());
        print_r("<br>");

        $c = new Criteria();
        $c->add(MlmDistPairingLedger20150131Peer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedger20150131Peer::LEFT_RIGHT, Globals::PLACEMENT_LEFT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedger20150131Peer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedger20150131Peer::doSelect($c);

        print_r("<br><br>LEFT======================================================");
        $balance = 0;
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            print_r("<br>".$balance);
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        $c = new Criteria();
        $c->add(MlmDistPairingLedger20150131Peer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedger20150131Peer::LEFT_RIGHT, Globals::PLACEMENT_RIGHT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedger20150131Peer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedger20150131Peer::doSelect($c);

        print_r("<br><br>RIGHT======================================================");
        $balance = 0;
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            print_r("<br>".$balance);
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateDistPairing20150331()
    {
        $distId = $this->getRequestParameter('distId');
        $distDB = MlmDistributorPeer::retrieveByPK($distId);

        print_r("======================================================");
        print_r("dist code=".$distDB->getDistributorId());
        print_r("<br>");

        $c = new Criteria();
        $c->add(MlmDistPairingLedger20150331Peer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedger20150331Peer::LEFT_RIGHT, Globals::PLACEMENT_LEFT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedger20150331Peer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedger20150331Peer::doSelect($c);

        $balance = 0;
        print_r("LEFT<br>");
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            print_r($balance."<br>");
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        $c = new Criteria();
        $c->add(MlmDistPairingLedger20150331Peer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedger20150331Peer::LEFT_RIGHT, Globals::PLACEMENT_RIGHT);
        $c->addAscendingOrderByColumn(MlmDistPairingLedger20150331Peer::CREATED_ON);
        $sponsorDistPairingLedgerDBs = MlmDistPairingLedger20150331Peer::doSelect($c);

        $balance = 0;
        print_r("RIGHT<br>");
        foreach ($sponsorDistPairingLedgerDBs as $sponsorDistPairingLedgerDB) {
            $balance = $balance + $sponsorDistPairingLedgerDB->getCredit() - $sponsorDistPairingLedgerDB->getDebit();
            print_r($balance."<br>");
            $sponsorDistPairingLedgerDB->setBalance($balance);
            $sponsorDistPairingLedgerDB->save();
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateDistCommission()
    {
        $distId = $this->getRequestParameter('distId');
        $c = new Criteria();
        if ($distId != null) {
            $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distId);
        }
        $distDBs = MlmDistributorPeer::doSelect($c);

        foreach ($distDBs as $distDB) {
            print_r("======================================================");
            print_r("dist code=".$distDB->getDistributorId());
            print_r("<br>");

            $c = new Criteria();
            $c->add(MlmAccountLedgerPeer::DIST_ID, $distDB->getDistributorId());
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
            $c->addAscendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
            $accountLedgers = MlmAccountLedgerPeer::doSelect($c);

            $balance = 0;
            foreach ($accountLedgers as $accountLedger) {
                $balance = $balance + $accountLedger->getCredit() - $accountLedger->getDebit();
                $accountLedger->setBalance($balance);
                $accountLedger->save();
                print_r("ecash balance=".$balance);
                print_r("<br>");
            }

            $c = new Criteria();
            $c->add(MlmAccountLedgerPeer::DIST_ID, $distDB->getDistributorId());
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
            $c->addAscendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
            $accountLedgers = MlmAccountLedgerPeer::doSelect($c);

            $balance = 0;
            print_r("<br>");
            foreach ($accountLedgers as $accountLedger) {

                $balance = $balance + $accountLedger->getCredit() - $accountLedger->getDebit();
                $accountLedger->setBalance($balance);
                $accountLedger->save();
                print_r("epoint balance=".$balance);
                print_r("<br>");
            }

            $c = new Criteria();
            $c->add(MlmAccountLedgerPeer::DIST_ID, $distDB->getDistributorId());
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
            $c->addAscendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
            $accountLedgers = MlmAccountLedgerPeer::doSelect($c);

            $balance = 0;
            print_r("<br>");
            foreach ($accountLedgers as $accountLedger) {

                $balance = $balance + $accountLedger->getCredit() - $accountLedger->getDebit();
                $accountLedger->setBalance($balance);
                $accountLedger->save();
                print_r("cp3 balance=".$balance);
                print_r("<br>");
            }

            $c = new Criteria();
            $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $distDB->getDistributorId());
            $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, "DRB");
            $c->addAscendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
            $commissionLedgers = MlmDistCommissionLedgerPeer::doSelect($c);

            $balance = 0;
            print_r("<br>");
            foreach ($commissionLedgers as $commissionLedger) {

                $balance = $balance + $commissionLedger->getCredit() - $commissionLedger->getDebit();
                $commissionLedger->setBalance($balance);
                $commissionLedger->save();
                print_r("commission balance=".$balance);
                print_r("<br>");
            }
        }

        return sfView::HEADER_ONLY;
    }
    public function executeIndex()
    {
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $leaderArrs = explode(",", Globals::HIDE_DIST_GROUP);
        $leaderArrs = explode(",", Globals::TO_HIDE_DIST_GROUP);
        $groupLeaderId = "";

        for  ($i = 0; $i < count($leaderArrs); $i++) {
            $c = new Criteria();
            var_dump($leaderArrs[$i]);
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $leaderArrs[$i]);
            $existDist = MlmDistributorPeer::doSelectOne($c);

            if ($existDist)
                $groupLeaderId .= $existDist->getDistributorId(). ",";
        }
        print_r($groupLeaderId);
        return sfView::HEADER_ONLY;
        /*$mlm_account = MlmAccountPeer::retrieveByPK(2);
        $mlm_account->setBalance(9900000);
        $mlm_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account->save();

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId(1);
        $mlm_account_ledger->setAccountType("EPOINT");
        $mlm_account_ledger->setTransactionType("COMPANY");
        $mlm_account_ledger->setRemark("Advance");
        $mlm_account_ledger->setCredit(9900000);
        $mlm_account_ledger->setDebit(0);
        $mlm_account_ledger->setBalance(9900000);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();*/
    }

    public function executePipsBonusList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = ", commission_type, bonus.pips_downline_username, bonus.remark, bonus.pips_mt4_id, bonus.pips_rebate, bonus.pips_level, bonus.pips_lots_traded FROM mlm_dist_commission_ledger bonus
        LEFT JOIN mlm_distributor dist ON bonus.dist_id = dist.distributor_id
        LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id ";

        /******   total records  *******/
        $sWhere = " WHERE bonus.dist_id=".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        /******   total filtered records  *******/

        if ($this->getRequestParameter('filterBonusType') != "") {
            $sWhere .= " AND commission_type = '".$this->getRequestParameter('filterBonusType')."'";
        }
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        if ($this->getRequestParameter('filterMonth') != "") {
            $sWhere .= " AND csv.month_traded = " . mysql_real_escape_string($this->getRequestParameter('filterMonth'));
        }
        if ($this->getRequestParameter('filterYear') != "") {
            $sWhere .= " AND csv.year_traded = " . mysql_real_escape_string($this->getRequestParameter('filterYear'));
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY dist.distributor_id, bonus.pips_level, ";
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] . "
                    " . mysql_real_escape_string($this->getRequestParameter('sSortDir_' . $i)) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") {
            $sOrder = "";
        }

        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $month = array();
        $month["1"] = "January";
        $month["2"] = "February";
        $month["3"] = "March";
        $month["4"] = "April";
        $month["5"] = "May";
        $month["6"] = "June";
        $month["7"] = "July";
        $month["8"] = "August";
        $month["9"] = "September";
        $month["10"] = "October";
        $month["11"] = "November";
        $month["12"] = "December";
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();
            $commissionType = $resultArr['commission_type'] == null ? "" : $resultArr['commission_type'];

            $desc = "";
            if ($commissionType == Globals::COMMISSION_TYPE_PIPS_BONUS) {
                $desc = "Rebate received<br><br>Downline Username :".$resultArr['pips_downline_username']
                        ."<br>MT4 ID :".$resultArr['pips_mt4_id']
                        ."<br>Rebate :".$resultArr['pips_rebate']
                        ."<br>Level :".$resultArr['pips_level']
                        ."<br>"
                        ."<br>Lots Traded :".$resultArr['pips_lots_traded'];
            } elseif ($commissionType == Globals::COMMISSION_TYPE_CREDIT_REFUND) {

                $desc = $resultArr['remark'];
            } elseif ($commissionType == Globals::COMMISSION_TYPE_FUND_MANAGEMENT) {

                $desc = $resultArr['remark'];
            }


            $arr[] = array(
                $resultArr['commission_id'] == null ? "" : $resultArr['commission_id'],
                $resultArr['month_traded'] == null ? "" : $month[$resultArr['month_traded']],
                $desc,
                $resultArr['credit'] == null ? "" : $resultArr['credit'],
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeFundManagementReturnList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = "
            FROM mlm_roi_dividend bonus
        LEFT JOIN mlm_distributor dist ON bonus.dist_id = dist.distributor_id";

        /******   total records  *******/
        $sWhere = " WHERE bonus.dist_id=".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        /******   total filtered records  *******/

        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        if ($this->getRequestParameter('filterMonth') != "" && $this->getRequestParameter('filterYear') != "") {
            $filterMonth = $this->getRequestParameter('filterMonth');
            $filterYear = $this->getRequestParameter('filterYear');

            $dateUtil = new DateUtil();
            $d = $dateUtil->getMonth($filterMonth, $filterYear);
            $firstOfMonth = date('Y-m-j', $d["first_of_month"])." 00:00:00";
            $lastOfMonth = date('Y-m-j', $d["last_of_month"])." 23:59:59";

            $sWhere .= " AND (bonus.dividend_date >= '". $firstOfMonth . "' AND bonus.dividend_date <= '". $lastOfMonth ."'";
            $sWhere .= " OR (bonus.status_code = '".Globals::DIVIDEND_STATUS_PENDING."' AND bonus.created_on >= '". $firstOfMonth . "' AND bonus.created_on <= '". $lastOfMonth ."'))";
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY ";
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] . "
                    " . mysql_real_escape_string($this->getRequestParameter('sSortDir_' . $i)) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") {
            $sOrder = "";
        }

        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $dateUtil = new DateUtil();
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();
            $arr[] = array(
                $resultArr['devidend_id'] == null ? "" : $resultArr['devidend_id'],
                $resultArr['dividend_date'] == null ? "" : $dateUtil->formatDate("Y-M-d", $resultArr['dividend_date']),
                $resultArr['package_price'] == null ? "" : $resultArr['package_price'],
                $resultArr['roi_percentage'] == null ? "" : $resultArr['roi_percentage'],
                $resultArr['dividend_amount'] == null ? "" : $resultArr['dividend_amount'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeDebitCardHistoryList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = "
            FROM mlm_debit_card_registration";

        /******   total records  *******/
        $sWhere = " WHERE dist_id=".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        /******   total filtered records  *******/

        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        $totalFilteredRecords = $totalRecords;

        /******   sorting  *******/
        $sOrder = "ORDER BY ";
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] . "
                    " . mysql_real_escape_string($this->getRequestParameter('sSortDir_' . $i)) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") {
            $sOrder = "";
        }

        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $dateUtil = new DateUtil();
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();
            $arr[] = array(
                $resultArr['card_id'] == null ? "" : $resultArr['card_id'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['remark'] == null ? "" : $resultArr['remark'],
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeEzyCashCardHistoryList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = "
            FROM mlm_ezy_cash_card";

        /******   total records  *******/
        $sWhere = " WHERE dist_id=".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        /******   total filtered records  *******/

        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        $totalFilteredRecords = $totalRecords;

        /******   sorting  *******/
        $sOrder = "ORDER BY ";
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] . "
                    " . mysql_real_escape_string($this->getRequestParameter('sSortDir_' . $i)) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") {
            $sOrder = "";
        }

        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $dateUtil = new DateUtil();
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();
            $arr[] = array(
                $resultArr['card_id'] == null ? "" : $resultArr['card_id'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['qty'] == null ? "" : $resultArr['qty'],
                $resultArr['sub_total'] == null ? "" : $resultArr['sub_total'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['remark'] == null ? "" : $resultArr['remark'],
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeEcashLogList()
    {
        // request parameter *****************************
        /*            $bSortable_0	false
          bSortable_1	false
          bSortable_2	true
          bSortable_3	false
          iColumns	4
          iDisplayLength	10
          iDisplayStart	0
          iSortCol_0	2
          iSortDir_0	asc
          iSortingCols	1
          sColumns	userId,userName,email1,lastName
          sEcho	2*/
        // end request parameter *****************************
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $totalRecords = MlmAccountLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmAccountLedgerPeer::TRANSACTION_TYPE, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = MlmAccountLedgerPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    if ($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] == "created_on") {
                        $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                        $c->addAscendingOrderByColumn("account_id");
                    } else {
                        $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                    }
                } else {
                    if ($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))] == "created_on") {
                        $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                        $c->addDescendingOrderByColumn("account_id");
                    } else {
                        $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                    }
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmAccountLedger', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getAccountId == null ? "0" : $result->getAccountId(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getCredit() == null ? "0" : $result->getCredit(),
                $result->getDebit() == null ? "0" : $result->getDebit(),
                $result->getBalance() == null ? "0" : $result->getBalance(),
                $result->getTransactionType() == null ? "" : $this->getContext()->getI18N()->__($result->getTransactionType()),
                $result->getRemark()  == null ? "" : $result->getRemark()
            );
        }

        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 256135) {
            $arr[] = array();
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeMaintenanceLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
        $totalRecords = MlmAccountLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmAccountLedgerPeer::TRANSACTION_TYPE, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = MlmAccountLedgerPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmAccountLedger', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getAccountId == null ? "0" : $result->getAccountId(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getCredit() == null ? "0" : $result->getCredit(),
                $result->getDebit() == null ? "0" : $result->getDebit(),
                $result->getBalance() == null ? "0" : $result->getBalance(),
                $result->getTransactionType() == null ? "" : $this->getContext()->getI18N()->__($result->getTransactionType()),
                $result->getRemark()  == null ? "" : $result->getRemark()
            );
        }

        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 256135) {
            $arr[] = array();
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeEpointLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
        $totalRecords = MlmAccountLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmAccountLedgerPeer::TRANSACTION_TYPE, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = MlmAccountLedgerPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmAccountLedger', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getCredit() == null ? "0" : $result->getCredit(),
                $result->getDebit() == null ? "0" : $result->getDebit(),
                $result->getBalance() == null ? "0" : $result->getBalance(),
                $result->getTransactionType() == null ? "" : $this->getContext()->getI18N()->__($result->getTransactionType()),
                $result->getRemark()  == null ? "" : $result->getRemark()
            );
        }

        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 256135) {
            $arr[] = array();
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeRpLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_RP);
        $totalRecords = MlmAccountLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmAccountLedgerPeer::TRANSACTION_TYPE, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = MlmAccountLedgerPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmAccountLedger', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getCredit() == null ? "0" : $result->getCredit(),
                $result->getDebit() == null ? "0" : $result->getDebit(),
                $result->getBalance() == null ? "0" : $result->getBalance(),
                $result->getTransactionType() == null ? "" : $this->getContext()->getI18N()->__($result->getTransactionType()),
                $result->getRemark()  == null ? "" : $result->getRemark()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeRtLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_RT);
        $totalRecords = MlmAccountLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmAccountLedgerPeer::TRANSACTION_TYPE, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = MlmAccountLedgerPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmAccountLedger', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getCredit() == null ? "0" : $result->getCredit(),
                $result->getDebit() == null ? "0" : $result->getDebit(),
                $result->getBalance() == null ? "0" : $result->getBalance(),
                $result->getTransactionType() == null ? "" : $this->getContext()->getI18N()->__($result->getTransactionType()),
                $result->getRemark()  == null ? "" : $result->getRemark()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeCp3WithdrawalList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmCp3WithdrawPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = MlmCp3WithdrawPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmEcashWithdrawPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmCp3WithdrawPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmCp3Withdraw', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $statusCode = $result->getStatusCode() == null ? "" : $this->getContext()->getI18N()->__($result->getStatusCode());

            if ($statusCode == "PAID") {
                $statusCode = "REMITTED";
            }
            $arr[] = array(
                $result->getDistId() == null ? "" : $result->getDistId(),
                $result->getDeduct() == null ? "" : $result->getDeduct(),
                $result->getAmount() == null ? "" : $result->getAmount(),
                $result->getBankInTo() == null ? "" : $result->getBankInTo(),
                $statusCode,
                $result->getRemarks() == null ? "" : $result->getRemarks(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        if ($this->getRequestParameter("t_columns")) {
            $output["t_columns"] = json_decode($this->getRequestParameter("t_columns"));
        }
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeDownlineCp3WithdrawalList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = " FROM mlm_cp3_withdraw withdrawal
                    LEFT JOIN mlm_distributor dist ON dist.distributor_id = withdrawal.dist_id ";

        /******   total records  *******/
        $sWhere = " WHERE withdrawal.dist_id <> ".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND dist.placement_tree_structure like '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1458) {
            // hide datoheng group
            $sWhere .= " AND dist.placement_tree_structure not like '%|203|%'";
        }
        /******   total filtered records  *******/

        $totalRecords = $this->getTotalRecords($sql.$sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterMemberId') != "") {
            $sWhere .= " AND dist.distributor_code LIKE '%".mysql_real_escape_string($this->getRequestParameter('filterMemberId'))."%'";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND withdrawal.status_code LIKE '%".mysql_real_escape_string($this->getRequestParameter('filterStatusCode'))."%'";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }

        $totalFilteredRecords = $this->getTotalRecords($sql.$sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
        for ($i=0 ; $i<intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_'.intval($this->getRequestParameter('iSortCol_'.$i))) == "true")
            {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_'.$i))]."
                    ".mysql_real_escape_string($this->getRequestParameter('sSortDir_'.$i)).", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY")
        {
            $sOrder = "";
        }
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT ".mysql_real_escape_string($offset).", ".mysql_real_escape_string($limit);

        $query  = "SELECT ".$sColumns." ".$sql." ".$sWhere." ".$sOrder." ".$sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
		$resultset = $statement->executeQuery();

	    while ($resultset->next())
	    {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['dist_id'] == null ? "" : $resultArr['dist_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['deduct'] == null ? "" : $resultArr['deduct'],
                $resultArr['amount'] == null ? "" : $resultArr['amount'],
                $resultArr['bank_in_to'] == null ? "" : $resultArr['bank_in_to'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['remarks'] == null ? "" : $resultArr['remarks'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on']
            );
	    }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeDownlineCp2WithdrawalList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = " FROM mlm_ecash_withdraw withdrawal
                    LEFT JOIN mlm_distributor dist ON dist.distributor_id = withdrawal.dist_id ";

        /******   total records  *******/
        $sWhere = " WHERE withdrawal.dist_id <> ".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND dist.placement_tree_structure like '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1458) {
            // hide datoheng group
            $sWhere .= " AND dist.placement_tree_structure not like '%|203|%'";
        }
        /******   total filtered records  *******/

        $totalRecords = $this->getTotalRecords($sql.$sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterMemberId') != "") {
            $sWhere .= " AND dist.distributor_code LIKE '%".mysql_real_escape_string($this->getRequestParameter('filterMemberId'))."%'";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND withdrawal.status_code LIKE '%".mysql_real_escape_string($this->getRequestParameter('filterStatusCode'))."%'";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }

        $totalFilteredRecords = $this->getTotalRecords($sql.$sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
        for ($i=0 ; $i<intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_'.intval($this->getRequestParameter('iSortCol_'.$i))) == "true")
            {
                $sOrder .= $aColumns[intval($this->getRequestParameter('iSortCol_'.$i))]."
                    ".mysql_real_escape_string($this->getRequestParameter('sSortDir_'.$i)).", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY")
        {
            $sOrder = "";
        }
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT ".mysql_real_escape_string($offset).", ".mysql_real_escape_string($limit);

        $query  = "SELECT ".$sColumns." ".$sql." ".$sWhere." ".$sOrder." ".$sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
		$resultset = $statement->executeQuery();

	    while ($resultset->next())
	    {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['dist_id'] == null ? "" : $resultArr['dist_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['deduct'] == null ? "" : $resultArr['deduct'],
                $resultArr['amount'] == null ? "" : $resultArr['amount'],
                $resultArr['bank_in_to'] == null ? "" : $resultArr['bank_in_to'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['remarks'] == null ? "" : $resultArr['remarks'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on']
            );
	    }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeEcashWithdrawalList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmEcashWithdrawPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        //$c->addAnd(MlmEcashWithdrawPeer::F_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $totalRecords = MlmEcashWithdrawPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmEcashWithdrawPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmEcashWithdrawPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmEcashWithdraw', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $statusCode = $result->getStatusCode() == null ? "" : $this->getContext()->getI18N()->__($result->getStatusCode());

            if ($statusCode == "PAID") {
                $statusCode = "REMITTED";
            }
            $arr[] = array(
                $result->getDistId() == null ? "" : $result->getDistId(),
                $result->getDeduct() == null ? "" : $result->getDeduct(),
                $result->getAmount() == null ? "" : $result->getAmount(),
                $result->getBankInTo() == null ? "" : $result->getBankInTo(),
                $statusCode,
                $result->getRemarks() == null ? "" : $result->getRemarks(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        if ($this->getRequestParameter("t_columns")) {
            $output["t_columns"] = json_decode($this->getRequestParameter("t_columns"));
        }
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeMt4WithdrawalList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmMt4WithdrawPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = MlmMt4WithdrawPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmMt4WithdrawPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmMt4WithdrawPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmMt4Withdraw', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $paymentType = $result->getPaymentType() == null ? "" : $result->getPaymentType();
            if ($paymentType == "VISA") {
                $paymentType = "VISA Cash Card";
            } elseif ($paymentType == "BANK") {
                $paymentType = "Local Bank Transfer";
            }
            $statusCode = $result->getStatusCode() == null ? "" : $this->getContext()->getI18N()->__($result->getStatusCode());
            $dateString = $result->getUpdatedOn();
            $dateArr = explode(" ", $dateString);
            if (Globals::STATUS_COMPLETE == $statusCode) {
                $statusCode = "SUCCESSFUL (".$dateArr[0].")";
            } else if (Globals::STATUS_REJECT == $statusCode) {
                $statusCode = "REJECTED (".$dateArr[0].")";
            }
            $arr[] = array(
                $result->getDistId() == null ? "" : $result->getDistId(),
                $result->getCurrencyCode() == null ? "" : $result->getCurrencyCode(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getAmountRequested() == null ? "" : $result->getAmountRequested(),
                $result->getHandlingFee() == null ? "" : $result->getHandlingFee(),
                $result->getGrandAmount() == null ? "" : $result->getGrandAmount(),
                $paymentType,
                $statusCode,
                $result->getRemarks() == null ? "" : $result->getRemarks()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        if ($this->getRequestParameter("t_columns")) {
            $output["t_columns"] = json_decode($this->getRequestParameter("t_columns"));
        }
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeEpointPurchaseHistoryList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmDistEpointPurchasePeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = MlmDistEpointPurchasePeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmDistEpointPurchasePeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmDistEpointPurchasePeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmDistEpointPurchase', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $dateString = $result->getUpdatedOn();
            $dateArr = explode(" ", $dateString);
            $statusCode = $result->getStatusCode() == null ? "" : $this->getContext()->getI18N()->__($result->getStatusCode());
            if ($result->getStatusCode() == Globals::STATUS_COMPLETE) {
                $statusCode = "SUCCESSFUL (".$dateArr[0].")";
            } else if (Globals::STATUS_REJECT == $result->getStatusCode()) {
                $statusCode = "REJECTED (".$dateArr[0].")";
            }
            $arr[] = array(
                $result->getPurchaseId() == null ? "" : $result->getPurchaseId(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getAmount() == null ? "" : $result->getCurrencyType()." ".number_format($result->getAmount(),2),
                $result->getPaymentReference() == null ? "" : $result->getPaymentReference(),
                $statusCode,
                $result->getRemarks() == null ? "" : $result->getRemarks(),
                $result->getImageSrc()  == null ? "" : $result->getImageSrc(),
                $result->getBankId()  == null ? "" : $result->getBankId()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeReloadMT4FundList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmMt4ReloadFundPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = MlmMt4ReloadFundPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmEcashWithdrawPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmMt4ReloadFundPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmMt4ReloadFund', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $statusCode = $result->getStatusCode() == null ? "" : $this->getContext()->getI18N()->__($result->getStatusCode());
            $dateString = $result->getUpdatedOn();
            $dateArr = explode(" ", $dateString);
            if (Globals::STATUS_COMPLETE == $statusCode) {
                $statusCode = "SUCCESSFUL (".$dateArr[0].")";
            } else if (Globals::STATUS_REJECT == $statusCode) {
                $statusCode = "REJECTED (".$dateArr[0].")";
            }
            $arr[] = array(
                $result->getDistId() == null ? "" : $result->getDistId(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getMt4UserName() == null ? "" : $result->getMt4UserName(),
                $result->getAmount() == null ? "" : $result->getAmount(),
                $statusCode,
                $result->getRemarks() == null ? "" : $result->getRemarks()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executePackageUpgradeList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmPackageUpgradeHistoryPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = MlmPackageUpgradeHistoryPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmEcashWithdrawPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmPackageUpgradeHistoryPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmPackageUpgradeHistory', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $statusCode = $result->getStatusCode() == null ? "" : $this->getContext()->getI18N()->__($result->getStatusCode());
            $dateString = $result->getUpdatedOn();
            $dateArr = explode(" ", $dateString);
            if (Globals::STATUS_COMPLETE == $statusCode) {
                $statusCode = "SUCCESSFUL (".$dateArr[0].")";
            } else if (Globals::STATUS_REJECT == $statusCode) {
                $statusCode = "REJECTED (".$dateArr[0].")";
            }
            $arr[] = array(
                $result->getDistId() == null ? "" : $result->getDistId(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getTransactionCode() == null ? "" : $result->getTransactionCode(),
                $result->getAmount() == null ? "" : $result->getAmount(),
                $statusCode,
                $result->getRemarks() == null ? "" : $result->getRemarks()
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    /**********************************************************************************************************/
    /********                                        FUNCTION                                         *********/
    /**********************************************************************************************************/
    function getTotalRecords($sql)
    {
        $query = "SELECT COUNT(*) AS _TOTAL " . $sql;
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $count = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["_TOTAL"] != null) {
                $count = $arr["_TOTAL"];
            } else {
                $count = 0;
            }
        }
        return $count;
    }

    function findPairingLedgers($distributorId, $position, $date)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'";

        if ($date != null) {
            $query .= " AND created_on <= '" . $date . " 23:59:59'";
        }
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

    function revalidatePairing($distributorId, $leftRight)
    {
        $balance = $this->getPairingBalance($distributorId, $leftRight);

        $c = new Criteria();
        $c->add(MlmDistPairingPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistPairingPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistPairing();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setLeftBalance(0);
            $tbl_account->setRightBalance(0);
        }
        if (Globals::PLACEMENT_LEFT == $leftRight) {
            $tbl_account->setLeftBalance($balance);
        } else if (Globals::PLACEMENT_RIGHT == $leftRight) {
            $tbl_account->setRightBalance($balance);
        }

        $tbl_account->save();
    }

    function getPairingBalance($distributorId, $leftRight)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId . " AND left_right = '" . $leftRight . "'";

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
    
    public function executeUpdatePairingRecord()
    {
        $arr = array();
		
		$dist_id = "29,30,31,32,33,34,35,558,561,562,1555,2062,2141,2142,2143,2209,2210,2211,2212,2213,2214,2215,2217,2248,2271,2323,2324,2332,126284,126285,126286,130875,130878,254447,254668,254676,254677,254680,254774,254787,255143,255144,255145,255147,255148,255149,255152,255153,255154,255155,255156,255157,255162,255235,255236,255287,255329,255330,255344,255345,255346,255347,255430,255477,255526,255527,255528,255655,255707,255770,255771,255841,255842,255858,255976,255977,255989,256014,256022,256025,256056,256065,256070,256125,256128,256129,256130,256131,256149,256221,256371,256870,256924,256926,256928,257188,257192,257274,257289,257591,257592,257593,257596,257750,257751,257752,259743,259794,259906,259907,260132,260421,261240,261241,261242,261529,261530,261531,261532,261995,262895,262898,262899,262905,262906,262907,262916,262917,262918,262919,262920,262921,262936,262945,262949,263330,263332,265267,265268,265391,268207,269767,269861,270574,270575,270576,270577,270578,270579,270580,270581,270582,270583,270585,270586,270587,270588,270589,270591,270592,270593,270594,270595,270662,270663,270665,270666,270667,270668,270669,270670,270671,270672,270673,270674,270675,270677,270678,270679,270680,270696,270778,270779,270889,270891,270894,270897,270899,270900,270901,270902,270903,258115,263571,263570,260951,255009,264687,257554,262039,262563,257548,261200,263569,262591,2267,255894,256992,1378,1945,263047,262696,255638,254837,255683,257879,257093,938,259945,1712,259977,259659,263288,262314,2117,254848,263369,255827,255499,255190,262530,661,262009,255787,262405,261117,261111,260926,1332,683,261517,262012,255337,255605,973,256712,259284,259729,126202,262012,2134,254903,261370,1649,258354,254861,254858,2360,257463,261516,258899,260182,260130,254911,260330,261628,260293,257704,260784,261323,261198,259948,256733,257908,255341,126179,256774,259088,261448,261997,261866,260741,257479,258031,258549,1594,257121,261814,1104,261816,256392,255180,255048,1426,260215,1822,258334,260199,260025,1971,255272,260753,2125,259608,256616,2231,255208,258741,210444,258106,256629,257157,258577,256197,260303,258597,690,259943,258720,255211,2097,259275,256123,257307,258810,259772,259497,254862,258742,254855,254850,257796,256506,258116,255179,259607,259918,259283,259460,258997,259176,260023,259401,255889,258690,258781,258954,258292,256652,1216,256916,255696,259080,256991,569,257462,256739,258195,258531,253015,255217,256437,257025,257500,257499,531,210444,255660,255126,255470,255650,256475,254832,258595,255443,257667,254844,257066,258345,2229,2104,255218,254910,254836,254827,254868,257600,257363,257152,255762,1152,256204,1438,257972,256713,256132,255188,255166,255049,257070,254975,257938,255805,257603,256939,256837,256684,256233,256917,254684,257021,2261,2096,1826,256690,255210,256262,255358,254683,256068,218,255536,256662,255820,254953,255534,256049,255967,255786,-256440,255863,-256140,255609,255776,255779,256290,1609,254820,255854,254830,1136,255430,255336,1114,254842,255624,255178,727,1516,255537,344,255625,254837,254843,255193,2054,1837,1610,252412,255335,255551,1378,277,255349,254859,254832,1167,254863,2078,1296,254719,254829,751,750,1844,2344,2098,1655,735,1169,1515,2195,1518,586,1532,1498,1250,88,618,1249,591,973,1668,617,101,570,1201,1167,298,274,257,258,390,365,342,90,121,120,98,3";
		$arr = explode(",",$dist_id);
		
		for($i=0; $i<count($arr); $i++){
			$sql = "SELECT c.debit, a.dist_id, a.left_right, a.debit as left_debit, b.left_right, b.debit as right_debit, date_format(a.created_on, '%Y-%m-%d') as create_on 
					FROM maxim.mlm_dist_pairing_ledger a 
					inner join maxim.mlm_dist_pairing_ledger b on a.dist_id=b.dist_id 
					and date_format(a.created_on, '%Y-%m-%d')=date_format(b.created_on, '%Y-%m-%d')
					and a.debit<>b.debit and a.transaction_type=b.transaction_type 
					left join mlm_account_ledger c on c.dist_id=a.dist_id and c.remark like 'FLUSH%' 
					and date_format(a.created_on, '%Y-%m-%d')=date_format(c.created_on, '%Y-%m-%d')
					where a.dist_id = ".$arr[$i]." and a.transaction_type = 'PAIRED' and a.left_right='LEFT' and date_format(a.created_on, '%Y-%m-%d')>='2013-10-01' order by a.created_on
					";
			
			$connection = Propel::getConnection();
			$statement = $connection->prepareStatement($sql);
			$resultset = $statement->executeQuery();

			while ($resultset->next())
			{
				$resultArr = $resultset->getRow();
				
				if($resultArr['debit']<=0){
					if($resultArr['left_debit']>$resultArr['right_debit']){
						$query = "UPDATE maxim.mlm_dist_pairing_ledger SET debit=".$resultArr['left_debit']." WHERE dist_id=".$resultArr['dist_id']." and date_format(created_on, '%Y-%m-%d')='".$resultArr['create_on']."' and transaction_type = 'PAIRED'";
					}else{
						$query = "UPDATE maxim.mlm_dist_pairing_ledger SET debit=".$resultArr['right_debit']." WHERE dist_id=".$resultArr['dist_id']." and date_format(created_on, '%Y-%m-%d')='".$resultArr['create_on']."' and transaction_type = 'PAIRED'";
					}
					
					//echo $query."<br>";
					$statement = $connection->prepareStatement($query);
					$statement->executeQuery();
				}
			}
		}
		return sfView::NONE;
    }
}