<?php

/**
 * old actions.
 *
 * @package    sf_sandbox
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class goldActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
    }

    public function executeDoBuygold()
    {
        $goldPrice = $this->getRequestParameter('gp');
        $qty = $this->getRequestParameter('q');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);

        $goldTradingService = new GoldTradingService();
        $goldSell = $goldTradingService->fetchGoldSell();
        $goldBuy = $goldTradingService->fetchGoldBuy($goldSell);

        $error = false;
        $errorType = "REFRESH";
        $errorMsg = "";
        $tradingPointDB = 0;
        $tradingPointSpend = $goldSell * $qty;

        //$this->logMessage("this is log testing", "err");
        /*****************************/
        /* check valid transaction
        /*****************************/
        $c = new Criteria();
		$c->add(TblAccountPeer::F_DIST_ID, $distId);
		$c->addAnd(TblAccountPeer::F_TYPE, Globals::ACCOUNT_TYPE_TRADING_POINT);
		$accountDB = TblAccountPeer::doSelectOne($c);
		if($accountDB) $tradingPointDB = $accountDB->getFBalance();
        $this->logMessage("=========>" + $tradingPointDB, "err");
        $this->logMessage("=========>" + $tradingPointSpend, "err");
        if ($goldSell != $goldPrice) {
            $error = true;
        } else if ($tradingPointDB < $tradingPointSpend) {
            $error = true;
            $errorType = "";
            $this->logMessage("******>" + $tradingPointSpend, "err");
            $errorMsg = $this->getContext()->getI18N()->__("In-sufficient trading point", null, 'goldTrading');
        } else {
            $tradingPointDB = $this->format2decimal($tradingPointDB - $tradingPointSpend);

            $accountDB->setFBalance($tradingPointDB);
            $accountDB->save();

            $tbl_account_ledger = new TblAccountLedger();
            $tbl_account_ledger->setFType(Globals::ACCOUNT_TYPE_TRADING_POINT);
            $tbl_account_ledger->setFDistId($distId);
            $tbl_account_ledger->setFAction(Globals::ACCOUNT_LEDGER_ACTION_PURCHASE);
            $tbl_account_ledger->setFCredit(0);
            $tbl_account_ledger->setFDebit($this->format2decimal($tradingPointSpend));
            $tbl_account_ledger->setFBalance($tradingPointDB);
            $tbl_account_ledger->setFCreatedDatetime(date("Y/m/d h:i:s A"));
            $tbl_account_ledger->save();

            /******* EGOLD ********/
            $tbl_egold_account = new TblEgoldAccount();
            $tbl_egold_account->setFDistId($distId);
            $tbl_egold_account->setFGram($qty);
            $tbl_egold_account->setFPrice($goldSell);
            $tbl_egold_account->setFTradingPoint($this->format2decimal($tradingPointSpend));
            $tbl_egold_account->setFCreatedDatetime(date("Y/m/d h:i:s A"));
            $tbl_egold_account->save();

            $tbl_egold_ledger = new TblEgoldLedger();
            $tbl_egold_ledger->setFEgoldAccountId($tbl_egold_account->getFId());
            $tbl_egold_ledger->setFGram($qty);
            $tbl_egold_ledger->setFOriginalPrice($goldSell);
            $tbl_egold_ledger->setFSellPrice(0);
            $tbl_egold_ledger->setFProfit(0);
            $tbl_egold_ledger->setFCreatedDatetime(date("Y/m/d h:i:s A"));
            $tbl_egold_ledger->save();
        }


        $output = array(
            "error" => $error,
            "errorType" => $errorType,
            "errorMsg" => $errorMsg,
            "goldBuy" => $goldBuy
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeDoSellgold()
    {
        $transactionId = $this->getRequestParameter('id');
        $goldPrice = $this->getRequestParameter('gp');
        $qty = $this->getRequestParameter('q');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);

        $goldTradingService = new GoldTradingService();
        $goldSell = $goldTradingService->fetchGoldSell();
        $goldBuy = $goldTradingService->fetchGoldBuy($goldSell);

        $error = false;
        $errorType = "REFRESH";
        $errorMsg = "";
        /*****************************/
        /* check valid transaction
        /*****************************/
        $c = new Criteria();
        $c->add(TblEgoldAccountPeer::F_ID, $transactionId);
        $c->add(TblEgoldAccountPeer::F_DIST_ID, $distId);
        $c->add(TblEgoldAccountPeer::F_GRAM, 0, Criteria::NOT_EQUAL);
        $egoldAccountDB = TblEgoldAccountPeer::doSelectOne($c);

        if(!$egoldAccountDB){
            $error = true;
            $errorType = "";
            $errorMsg = "Invalid Transaction.";
        } else {
            if (intval($qty) > $egoldAccountDB->getFGram()) {
                $error = true;
                $errorType = "";
                $errorMsg = $this->getContext()->getI18N()->__("In-sufficient gold remaining", null, 'goldTrading');
            } else if (bccomp($goldBuy, $goldPrice) !== 0) {
                $error = true;
            } else {
                $balance = $egoldAccountDB->getFGram() - $qty;
                $oriPrice = $egoldAccountDB->getFPrice();

                $egoldAccountDB->setFGram($balance);
                $egoldAccountDB->save();

                $tbl_egold_ledger = new TblEgoldLedger();
                $tbl_egold_ledger->setFEgoldAccountId($transactionId);
                $tbl_egold_ledger->setFGram($qty);
                $tbl_egold_ledger->setFOriginalPrice($oriPrice);
                $tbl_egold_ledger->setFSellPrice($goldBuy);

                $profit = $this->format2decimal(($goldBuy - $egoldAccountDB->getFPrice()) * $qty);

                $tbl_egold_ledger->setFProfit($profit);
                $tbl_egold_ledger->setFCreatedDatetime(date("Y/m/d h:i:s A"));

                $tbl_egold_ledger->save();

                /******* trading point ********/
                $c = new Criteria();
				$c->add(TblAccountPeer::F_TYPE, Globals::ACCOUNT_TYPE_TRADING_POINT);
				$c->addAnd(TblAccountPeer::F_DIST_ID, $distId);
				$accountDB = TblAccountPeer::doSelectOne($c);
                $accountTradingPointDB = $accountDB->getFBalance();

                //$tradingPointSpend = $oriPrice * $qty;
                $tradingPointSpend = $egoldAccountDB->getFTradingPoint();
                $accountTradingPointDB = $accountTradingPointDB + $tradingPointSpend;

                $tbl_account_ledger = new TblAccountLedger();
                $tbl_account_ledger->setFType(Globals::ACCOUNT_TYPE_TRADING_POINT);
                $tbl_account_ledger->setFDistId($distId);
                $tbl_account_ledger->setFAction(Globals::ACCOUNT_LEDGER_ACTION_SELL_ESHARE);
                $tbl_account_ledger->setFCredit($tradingPointSpend);
                $tbl_account_ledger->setFDebit(0);
                $tbl_account_ledger->setFBalance($accountTradingPointDB);
                $tbl_account_ledger->setFCreatedDatetime(date("Y/m/d h:i:s A"));
                $tbl_account_ledger->save();

                $accountDB->setFBalance($accountTradingPointDB);
                $accountDB->save();

                /******* ecash ********/
                //todo temporary comment for test, live one 1st of oct
                $c = new Criteria();
				$c->add(TblAccountPeer::F_TYPE, Globals::ACCOUNT_TYPE_ECASH);
				$c->addAnd(TblAccountPeer::F_DIST_ID, $distId);
				$accountDB = TblAccountPeer::doSelectOne($c);

                $accountEcashDB = $accountDB->getFBalance();
                $ecashCredit = 0;
                $ecashDebit = 0;
                if ($profit >= 0) {
                    $ecashCredit = $profit;
                } else {
                    $ecashDebit = $profit;
                }
                $accountEcashDB = $accountEcashDB + $profit;

                $tbl_account_ledger = new TblAccountLedger();
                $tbl_account_ledger->setFType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setFDistId($distId);
                $tbl_account_ledger->setFAction(Globals::ACCOUNT_LEDGER_ACTION_SELL_ESHARE);
                $tbl_account_ledger->setFCredit($ecashCredit);
                $tbl_account_ledger->setFDebit($ecashDebit);
                $tbl_account_ledger->setFBalance($accountEcashDB);
                $tbl_account_ledger->setFCreatedDatetime(date("Y/m/d h:i:s A"));
                $tbl_account_ledger->save();

                $accountDB->setFBalance($accountEcashDB);
                $accountDB->save();
            }
        }

        $output = array(
            "error" => $error,
            "errorType" => $errorType,
            "errorMsg" => $errorMsg,
            "goldBuy" => $goldBuy
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeFetchGoldPrice()
    {
        Globals::SESSION_DISTID; // this is neccessary to initialial Globals class
        $goldTradingService = new GoldTradingService();
        $goldSell = $goldTradingService->fetchGoldSell();
        $goldBuy = $goldTradingService->fetchGoldBuy($goldSell);

    	$output = array(
            "goldSell" => $goldSell,
            "goldBuy" => $goldBuy
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeTrading()
    {
        return $this->redirect('/home/index');
    	$this->title = "Gold Trading";
    	$this->title2 = "Gold Trading";

        $goldTradingService = new GoldTradingService();
        $this->goldDto = $goldTradingService->fetchAllGoldTradingData($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        $c = new Criteria();
        $c->add(TblSettingPeer::F_PARAMETER, Globals::SETTING_GOLD_MARKET);
        $this->tbl_setting = TblSettingPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(TblAccountPeer::F_TYPE, Globals::ACCOUNT_TYPE_GOLD_DIVIDEND);
        $c->addAnd(TblAccountPeer::F_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->account = TblAccountPeer::doSelectOne($c);
    }
    public function executeFetchTradingData()
    {
        $goldTradingService = new GoldTradingService();
        $goldDto = $goldTradingService->fetchAllGoldTradingData($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        $output = array(
            "averagePriceBuy" => $goldDto->getAveragePriceBuy(),
            "goldBuy" => $goldDto->getGoldBuy(),
            "goldSell" => $goldDto->getGoldSell(),
            "paperGoldQuantity" => $goldDto->getPaperGoldQuantity(),
            "tradingMarginAvailable" => $goldDto->getTradingMarginAvailable(),
            "tradingMarginBalance" => $goldDto->getTradingMarginBalance(),
            "unrealizedProfitLoss" => $goldDto->getUnrealizedProfitLoss(),
            "ecash" => $goldDto->getEcash()
        );

        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }
    public function executeOpenTransactionListing()
    {
        Globals::SESSION_DISTID; // this is neccessary to initialial Globals class
        $goldTradingService = new GoldTradingService();
        $goldSell = $goldTradingService->fetchGoldSell();
        $goldBuy = $goldTradingService->fetchGoldBuy($goldSell);

        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        $sColumns = str_replace("marginUsed", "(f_gram * f_price) AS marginUsed", $sColumns);
        $sColumns = str_replace("unrealizedProfitLoss", "f_gram * (".$goldBuy." - f_price) AS unrealizedProfitLoss", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM tbl_egold_account";

        /******   total records  *******/
        $sWhere = " WHERE f_dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND f_gram > 0";
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
	    while ($resultset->next())
	    {
            $resultArr = $resultset->getRow();
            //var_dump(round(resultArr['marginUsed']));
            //var_dump("==>".round($resultArr['marginUsed'], 2, PHP_ROUND_HALF_UP));
            $marginUsed = $resultArr['marginUsed'] == null ? 0 : $resultArr['marginUsed'];
            $marginUsed = $this->format2decimal($marginUsed);
            $unrealizedProfitLoss = $resultArr['unrealizedProfitLoss'] == null ? 0 : $resultArr['unrealizedProfitLoss'];
            //$unrealizedProfitLoss = $this->format2decimal($unrealizedProfitLoss);
            $arr[] = array(
                $resultArr['f_id'] == null ? "" : $resultArr['f_id'],
                $resultArr['f_id'] == null ? "" : $resultArr['f_id'],
                $resultArr['f_price'] == null ? "0.00" : $resultArr['f_price'],
                $resultArr['f_gram'] == null ? "0" : $resultArr['f_gram'],
                number_format($marginUsed,2),
                $resultArr['f_created_datetime'] == null ? "0.00" : $resultArr['f_created_datetime'],
                $unrealizedProfitLoss,
                $resultArr['f_id'] == null ? "" : $resultArr['f_id']
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
        $sColumns = str_replace("marginUsed", "(ledger.f_gram * ledger.f_original_price) AS marginUsed", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM tbl_egold_ledger ledger
                    LEFT JOIN tbl_egold_account account ON ledger.f_egold_account_id = account.f_id";

        /******   total records  *******/
        $sWhere = " WHERE account.f_dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND ledger.f_sell_price = 0";
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
            $marginUsed = $resultArr['marginUsed'] == null ? 0 : $resultArr['marginUsed'];
            $marginUsed = $this->format2decimal($marginUsed);
            $arr[] = array(
                $resultArr['f_id'] == null ? "" : $resultArr['f_id'],
                $resultArr['f_id'] == null ? "" : $resultArr['f_id'],
                $resultArr['f_gram'] == null ? "0" : $resultArr['f_gram'],
                $resultArr['f_original_price'] == null ? "0.00" : $resultArr['f_original_price'],
                number_format($marginUsed,2),
                $resultArr['f_created_datetime'] == null ? "" : $resultArr['f_created_datetime']
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
        $sColumns = str_replace("marginUsed", "(ledger.f_gram * ledger.f_original_price) AS marginUsed", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM tbl_egold_ledger ledger
                    LEFT JOIN tbl_egold_account account ON ledger.f_egold_account_id = account.f_id";

        /******   total records  *******/
        $sWhere = " WHERE account.f_dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND ledger.f_sell_price <> 0";
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
            $marginUsed = $resultArr['marginUsed'] == null ? 0 : $resultArr['marginUsed'];
            $marginUsed = $this->format2decimal($marginUsed);
            $arr[] = array(
                $resultArr['f_id'] == null ? "" : $resultArr['f_id'],
                $resultArr['f_id'] == null ? "" : $resultArr['f_id'],
                $resultArr['f_gram'] == null ? "0" : $resultArr['f_gram'],
                $resultArr['f_sell_price'] == null ? "0.00" : $resultArr['f_sell_price'],
                number_format($marginUsed,2),
                $resultArr['f_profit'] == null ? "0.00" : $resultArr['f_profit'],
                $resultArr['f_created_datetime'] == null ? "" : $resultArr['f_created_datetime']
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

    public function executeGoldChart(){

    }

    /************************************/
    /********   FUNCTION        *********/
    /************************************/
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

    function format2decimal($d){
        return ceil($d * 100) / 100;
    }
    
}