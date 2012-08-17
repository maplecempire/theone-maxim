<?php

/**
 * eshare actions.
 *
 * @package    sf_sandbox
 * @subpackage eshare
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class eshareActions extends sfActions
{
    public function executeIndex() {
        return $this->redirect('/eshare/tradingCenter');
    }
    public function executeReinvestEshare() {
        /* *****************************************
         * Setting
         * ******************************************/
        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SHARE_MARKET);
        $settingDB = AppSettingPeer::doSelectOne($c);

        $validToSellShare = false;
        $validToBuyShare = false;
        if ($settingDB->getSettingValue()=='0') {
            $todayDateDay = date('d');

            if ($todayDateDay == "15" || $todayDateDay == "30") {
                $validToSellShare = true;
            }
            $validToBuyShare = true;
        }
        $this->validToSellShare = $validToSellShare;
        $this->validToBuyShare = $validToBuyShare;
        $this->maintenance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_LEDGER_ACTION_MAINTENANCE);

        $eshareTradingService = new EShareTradingService();
        $this->eshareTradingDto = $eshareTradingService->fetchAllShareTradingData($this->getUser()->getAttribute(Globals::SESSION_DISTID));
    }
    public function executeTradingCenter()
    {
        /* *****************************************
         * Setting
         * ******************************************/
        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SHARE_MARKET);
        $settingDB = AppSettingPeer::doSelectOne($c);

        $validToSellShare = false;
        //$validToSellShare = true;
        $validToBuyShare = false;
        if ($settingDB->getSettingValue()=='0') {
            $todayDateDay = date('d');

            if ($todayDateDay == "15" || $todayDateDay == "30") {
                $validToSellShare = true;
            }
            $validToBuyShare = true;
        }
        $this->validToSellShare = $validToSellShare;
        $this->validToBuyShare = $validToBuyShare;

        $eshareTradingService = new EShareTradingService();
        $this->eshareTradingDto = $eshareTradingService->fetchAllShareTradingData($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        /* *****************************************
         * fetch last 14 days share price log
         * ******************************************/
        $dateUtil = new DateUtil();
        $date = $dateUtil->formatDate("Y-m-d", date("Y-m-d"));
        $query = "SELECT log_id, share_value, created_by, created_on, updated_by, updated_on
	                    FROM mlm_eshare_log WHERE created_on <= '" . $date . " 23:59:59' order by created_on desc limit 14";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $arr = array();
        $i = 0;
        while ($resultset->next()) {
            $arr[$i++] = $resultset->getRow();
        }
        $this->eshareLogs = $arr;
    }

    public function executeSellShare()
    {
        $shareId = $this->getRequestParameter('shareId');
        $currentDate = date("Y-m-d");

        $mlm_dist_eshare_account = MlmDistEshareAccountPeer::retrieveByPK($shareId);
        $this->forward404Unless($mlm_dist_eshare_account);

        Globals::SESSION_DISTID; // this is neccessary to initialial Globals class
        $eshareTradingService = new EShareTradingService();
        $eshareValue = $eshareTradingService->fetchEsharePrice();

        $buyPrice = $mlm_dist_eshare_account->getBuyPrice();
        $credit = $mlm_dist_eshare_account->getCredit();
        $sellPrice = $eshareValue;
        $debit = $credit;
        $profit = $credit * ($sellPrice - $buyPrice);

        $mlm_dist_eshare_account->setSellPrice($sellPrice);
        $mlm_dist_eshare_account->setDebit($debit);
        $mlm_dist_eshare_account->setProfit($profit);
        $mlm_dist_eshare_account->setShareBalance(0);
        $mlm_dist_eshare_account->setRemark("");
        $mlm_dist_eshare_account->setSellDate($currentDate);
        $mlm_dist_eshare_account->setStatusCode(Globals::ESHARE_ACCOUNT_STATUS_COMPLETE);
        $mlm_dist_eshare_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_dist_eshare_account->save();

        $distId = $mlm_dist_eshare_account->getDistId();

        /* ******************************
         *  Update Account EShare
         ******************************* */
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ESHARE);
        $c->addAnd(MlmAccountPeer::DIST_ID, $distId);
        $mlmAccount = MlmAccountPeer::doSelectOne($c);
        $accountEshareBalance = $mlmAccount->getBalance();

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($distId);
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ESHARE);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SELL);
        $mlm_account_ledger->setRemark("");
        $mlm_account_ledger->setCredit(0);
        $mlm_account_ledger->setDebit($debit);
        $mlm_account_ledger->setBalance($accountEshareBalance - $debit);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ESHARE);

        /* **********************************
         *  E-cash
         ************************************/
        $maintenanceBalance = $profit * Globals::BONUS_MAINTENANCE_PERCENTAGE;

        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $distId);
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
        $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
        $this->forward404Unless($accountLedgerDB);

        $distAccountECashBalance = $accountLedgerDB->getBalance();

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($distId);
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SELL_ESHARE);
        $mlm_account_ledger->setRemark("SELL GOLD AMOUNT " . number_format($profit, 2) . " (" . $currentDate . ")");
        $mlm_account_ledger->setCredit($profit);
        $mlm_account_ledger->setDebit(0);
        $mlm_account_ledger->setBalance($distAccountECashBalance + $profit);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        $maintenanceEcashAccountLedger = new MlmAccountLedger();
        $maintenanceEcashAccountLedger->setDistId($distId);
        $maintenanceEcashAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
        $maintenanceEcashAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MAINTENANCE);
        $maintenanceEcashAccountLedger->setRemark("MAINTENANCE BALANCE (" . number_format($profit, 2) . ")");
        $maintenanceEcashAccountLedger->setCredit(0);
        $maintenanceEcashAccountLedger->setDebit($maintenanceBalance);
        $maintenanceEcashAccountLedger->setBalance($distAccountECashBalance + $profit - $maintenanceBalance);
        $maintenanceEcashAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $maintenanceEcashAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $maintenanceEcashAccountLedger->save();

        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);

        /******************************/
        /*  Maintenance
        /******************************/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $distId);
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
        $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
        $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
        $this->forward404Unless($accountLedgerDB);
        $distAccountMaintenanceBalance = $accountLedgerDB->getBalance();

        $maintenanceAccountLedger = new MlmAccountLedger();
        $maintenanceAccountLedger->setDistId($distId);
        $maintenanceAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
        $maintenanceAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_SELL_ESHARE);
        $maintenanceAccountLedger->setRemark("SELL GOLD AMOUNT " . number_format($profit, 2) . " (" . $currentDate . ")");
        $maintenanceAccountLedger->setCredit($maintenanceBalance);
        $maintenanceAccountLedger->setDebit(0);
        $maintenanceAccountLedger->setBalance($distAccountMaintenanceBalance + $maintenanceBalance);
        $maintenanceAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $maintenanceAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $maintenanceAccountLedger->save();

        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

        $this->setFlash('successMsg', "Sell share successfully.");
        return $this->redirect('/eshare/tradingCenter');
    }

    public function executeBuyShare()
    {
        $buyAmount = $this->getRequestParameter('txtBuyAmount');
        $maintenanceTransaction = false;

        if ($this->getRequestParameter('buyType') && $this->getRequestParameter('buyType') == "maintenance") {
            $maintenanceTransaction = true;
        }

        $eshareTradingService = new EShareTradingService();
        $eshareTradingDto = $eshareTradingService->fetchAllShareTradingData($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $ecash = $eshareTradingDto->getEcash();

        if ($maintenanceTransaction == true) {
            $ecash = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_LEDGER_ACTION_MAINTENANCE);
        }

        if ($ecash == 0) {
            $this->setFlash('successMsg', "Buy amount must be greater than 0.");

            if ($maintenanceTransaction == true) {
                return $this->redirect('/eshare/reinvestEshare');
            } else {
                return $this->redirect('/eshare/tradingCenter');
            }
        }
        if ($ecash < $buyAmount) {
            $this->setFlash('successMsg', "In-sufficient E-Cash.");

            if ($maintenanceTransaction == true) {
                return $this->redirect('/eshare/reinvestEshare');
            } else {
                return $this->redirect('/eshare/tradingCenter');
            }
        }

        $dateUtil = new DateUtil();
        $eshareValue = $eshareTradingDto->getEsharePrice();
        $totalEshare = $buyAmount / $eshareValue;

        $unitArrs = explode(",", GLOBALS::ESHARE_SPLIT_SELL_UNIT);
        $dayArrs = explode(",", GLOBALS::ESHARE_SPLIT_SELL_DAY);

        $totalEshareConclude = 0;
        for ($i = 0; $i < count($unitArrs); $i++) {
            $totalEsharePartition = ceil($unitArrs[$i] / 100 * $totalEshare);
            $totalEshareConclude += $totalEsharePartition;

            $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"))." 00:00:00";
            $validSellDate = $dateUtil->addDate($currentDate, $dayArrs[$i], 0, 0);

            $mlm_dist_eshare_account = new MlmDistEshareAccount();
            $mlm_dist_eshare_account->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlm_dist_eshare_account->setBuyPrice($eshareValue);
            $mlm_dist_eshare_account->setCredit($totalEsharePartition);
            $mlm_dist_eshare_account->setSellPrice(0);
            $mlm_dist_eshare_account->setDebit(0);
            $mlm_dist_eshare_account->setProfit(0);
            $mlm_dist_eshare_account->setShareBalance($totalEsharePartition);
            $mlm_dist_eshare_account->setRemark("");
            $mlm_dist_eshare_account->setValidSellDate($validSellDate);
            //$mlm_dist_eshare_account->setSellDate("$y-$m-$d");
            $mlm_dist_eshare_account->setStatusCode(Globals::ESHARE_ACCOUNT_STATUS_ACTIVE);
            $mlm_dist_eshare_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_dist_eshare_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_dist_eshare_account->save();
        }

        /* ******************************
         *  Update Account Ecash
         ******************************* */
        $c = new Criteria();
        if ($maintenanceTransaction == true) {
            $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
        } else {
            $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        }
        $c->addAnd(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $mlmAccount = MlmAccountPeer::doSelectOne($c);
        $accountEcashBalance = $mlmAccount->getBalance();

        $mlm_account_ledger = new MlmAccountLedger();
        if ($maintenanceTransaction == true) {
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
        } else {
            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
        }
        $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_BUY_ESHARE);
        $mlm_account_ledger->setRemark("");
        $mlm_account_ledger->setCredit(0);
        $mlm_account_ledger->setDebit($buyAmount);
        $mlm_account_ledger->setBalance($accountEcashBalance - $buyAmount);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        if ($maintenanceTransaction == true) {
            $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        } else {
            $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        }

        /* ******************************
         *  Update Account EShare
         ******************************* */
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ESHARE);
        $c->addAnd(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $mlmAccount = MlmAccountPeer::doSelectOne($c);
        $accountEshareBalance = $mlmAccount->getBalance();

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ESHARE);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_BUY);
        $mlm_account_ledger->setRemark("");
        $mlm_account_ledger->setCredit($totalEshareConclude);
        $mlm_account_ledger->setDebit(0);
        $mlm_account_ledger->setBalance($accountEshareBalance + $totalEshareConclude);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ESHARE);

        $this->setFlash('successMsg', "Buy share successfully.");

        if ($maintenanceTransaction == true) {
            return $this->redirect('/eshare/reinvestEshare');
        } else {
            return $this->redirect('/eshare/tradingCenter');
        }
    }

    public function executeOpenTransactionListing()
    {
        Globals::SESSION_DISTID; // this is neccessary to initialial Globals class

        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM mlm_dist_eshare_account";

        /******   total records  *******/
        $sWhere = " WHERE dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND status_code ='".Globals::ESHARE_ACCOUNT_STATUS_ACTIVE."'";
        $sWhere .= " AND debit = 0";
        $totalRecords = $this->getTotalRecords($sql.$sWhere);

        /******   total filtered records  *******/
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

        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
		$resultset = $statement->executeQuery();

        $eshareTradingService = new EShareTradingService();
        $currentEsharePrice = $eshareTradingService->fetchEsharePrice();
	    while ($resultset->next())
	    {
            $resultArr = $resultset->getRow();
            $buyPrice = $resultArr['buy_price'] == null ? "0.00" : $resultArr['buy_price'];
            $totalShare = $resultArr['credit'] == null ? "0" : $resultArr['credit'];
            $validSellDate = $resultArr['valid_sell_date'] == null ? "" : $resultArr['valid_sell_date'];
            $unrealizedProfitLoss = ($currentEsharePrice - $buyPrice) * $totalShare;
            $validSell = false;

            $currentTime = strtotime(date("Y-m-d"));
            $validSellDateTime = strtotime($validSellDate);

            if ($validSellDateTime < $currentTime) {
                $validSell = true;
            }
            $arr[] = array(
                $resultArr['eshare_id'] == null ? "" : $resultArr['eshare_id'],
                $resultArr['eshare_id'] == null ? "" : $resultArr['eshare_id'],
                $buyPrice,
                $totalShare,
                $unrealizedProfitLoss,
                $validSellDate,
                $validSell
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

    public function executeBuyingHistoryListing()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("marginUsed", "(ledger.f_gram * ledger.f_original_price) AS marginUsed", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM mlm_dist_eshare_account";

        /******   total records  *******/
        $sWhere = " WHERE dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $totalRecords = $this->getTotalRecords($sql.$sWhere);

        /******   total filtered records  *******/
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
                $resultArr['eshare_id'] == null ? "" : $resultArr['eshare_id'],
                $resultArr['eshare_id'] == null ? "" : $resultArr['eshare_id'],
                $resultArr['credit'] == null ? "0" : $resultArr['credit'],
                $resultArr['buy_price'] == null ? "0.00" : $resultArr['buy_price'],
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

    public function executeSellingHistoryListing()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM mlm_dist_eshare_account";

        /******   total records  *******/
        $sWhere = " WHERE dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND debit <> 0 AND status_code = '" . Globals::ESHARE_ACCOUNT_STATUS_COMPLETE . "'";
        $totalRecords = $this->getTotalRecords($sql.$sWhere);

        /******   total filtered records  *******/
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
            //var_dump(round(resultArr['marginUsed']));
            //var_dump("==>".round($resultArr['marginUsed'], 2, PHP_ROUND_HALF_UP));
            $arr[] = array(
                $resultArr['eshare_id'] == null ? "" : $resultArr['eshare_id'],
                $resultArr['eshare_id'] == null ? "" : $resultArr['eshare_id'],
                $resultArr['debit'] == null ? "0" : $resultArr['debit'],
                $resultArr['sell_price'] == null ? "0.00" : $resultArr['sell_price'],
                $resultArr['profit'] == null ? "0.00" : $resultArr['profit'],
                $resultArr['sell_date'] == null ? "" : $resultArr['sell_date']
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

    /* *************************************************************************
     *      FUNCTION
     ************************************************************************** */

    function revalidateAccount($distributorId, $accountType)
    {
        $balance = $this->getAccountBalance($distributorId, $accountType);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, $accountType);
        $c->add(MlmAccountPeer::DIST_ID, $distributorId);
        $tbl_account = MlmAccountPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmAccount();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setAccountType($accountType);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
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
    function getTotalRecords($sql)
	{
		$query = "SELECT COUNT(*) AS _TOTAL ".$sql;
        //var_dump($query);
		$connection = Propel::getConnection();
	  	$statement = $connection->prepareStatement($query);
		$resultset = $statement->executeQuery();

		$count = 0;
	    if ($resultset->next())
	    {
	    	$arr = $resultset->getRow();
	    	if ($arr["_TOTAL"] != null) {
	    		$count = $arr["_TOTAL"];
	    	} else {
	    		$count = 0;
	    	}
	    }
        return $count;
	}
}
