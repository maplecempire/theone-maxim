<?php

/**
 * business actions.
 *
 * @package    sf_sandbox
 * @subpackage business
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class businessActions extends sfActions
{
    public function executeManualInsertPips()
    {
//        $mlm_distributor = MlmDistributorPeer::retrieveByPk(257750);
//        $mlm_distributor = MlmDistributorPeer::retrieveByPk(257751);
        $mlm_distributor = MlmDistributorPeer::retrieveByPk(258461);
        $uplinePosition = $mlm_distributor->getPlacementPosition();
        $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());

        $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
        $pairingPoint = 30000;
        $level =0;
        while ($level < 200) {
            //var_dump($uplineDistDB->getUplineDistId());
            //var_dump($uplineDistDB->getUplineDistCode());
            //print_r("<br>");
            $c = new Criteria();
            $c->add(MlmDistPairingPeer::DIST_ID, $uplineDistDB->getDistributorId());
            $sponsorDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

            $addToLeft = 0;
            $addToRight = 0;
            $leftBalance = 0;
            $rightBalance = 0;
            if (!$sponsorDistPairingDB) {
                $sponsorDistPairingDB = new MlmDistPairing();
                $sponsorDistPairingDB->setDistId($uplineDistDB->getDistributorId());

                $packageDB = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                if (!$packageDB) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                    return $this->redirect('/member/memberRegistration');
                }

                $sponsorDistPairingDB->setLeftBalance($leftBalance);
                $sponsorDistPairingDB->setRightBalance($rightBalance);
                $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            } else {
                $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                $rightBalance = $sponsorDistPairingDB->getRightBalance();
            }
            $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
            $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
            $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sponsorDistPairingDB->save();

            $c = new Criteria();
            $c->add(MlmDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
            $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
            $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
            $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

            $legBalance = 0;
            if ($sponsorDistPairingLedgerDB) {
                $legBalance = $sponsorDistPairingLedgerDB->getBalance();
            }

            $sponsorDistPairingledger = new MlmDistPairingLedger();
            $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
            $sponsorDistPairingledger->setLeftRight($uplinePosition);
            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
            $sponsorDistPairingledger->setCredit($pairingPoint);
            $sponsorDistPairingledger->setDebit(0);
            $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sponsorDistPairingledger->save();

            $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

            if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                break;
            }

            $uplinePosition = $uplineDistDB->getPlacementPosition();
            $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
            $level++;
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeAdjustmentAugustPipsBonus()
    {
        $con = Propel::getConnection(MlmEcashWithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();

            $query = "SELECT SUM(credit-debit) as _TOTAL, dist_id
                    FROM mlm_account_ledger
                where transaction_type IN ('PIPS BONUS','PIPS REBATE')
                    and account_type = 'ECASH'
                    and created_on >= '2013-09-07 00:00:00'
                group by dist_id having _TOTAL > 0";

            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $resultset = $statement->executeQuery();

            $totalBonus = 0;
            while ($resultset->next())
            {
                $arr = $resultset->getRow();
                if ($arr["_TOTAL"] != null) {
                    $totalBonus = $arr["_TOTAL"];
                    $dist_id = $arr["dist_id"];
                    print_r($dist_id.":".$totalBonus."<br>");
                    $ledgerAccountBalance = $this->getAccountBalance($dist_id, Globals::ACCOUNT_TYPE_ECASH);

                    $tbl_account_ledger = new MlmAccountLedger();
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $tbl_account_ledger->setDistId($dist_id);
                    $tbl_account_ledger->setTransactionType("ADJUSTMENT");
                    $tbl_account_ledger->setCredit(0);
                    $tbl_account_ledger->setDebit($totalBonus);
                    $tbl_account_ledger->setRemark("ADJUSTMENT");
                    $tbl_account_ledger->setBalance($ledgerAccountBalance - $totalBonus);
                    $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->save();
                } else {
                    $totalBonus = 0;
                }
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeIndex()
    {
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "gao_group_90.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $counter = 1;
        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = $totalRow; $x > 0; $x--) {
            $mt4Username = $data->val($x, "A");
            $mt4Password = $data->val($x, "E");
            $email = $data->val($x, "C");
            $fullname = $data->val($x, "B");

            if ($mt4Password == "" || $email == "")
                continue;

//            $c = new Criteria();
//            $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Username);
//            $mlmDistMt4 = MlmDistMt4Peer::doSelectOne($c);

//            if ($mlmDistMt4) {
                $tmpMt4Account = new TmpMt4Account();
                $tmpMt4Account->setMt4Username($mt4Username);
                $tmpMt4Account->setMt4Password($mt4Password);
                $tmpMt4Account->setFullname($fullname);
                $tmpMt4Account->setEmail($email);
                $tmpMt4Account->setStatusCode(Globals::STATUS_ACTIVE);
                $tmpMt4Account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tmpMt4Account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tmpMt4Account->save();

                $counter++;
//            } else {
//                $tmpMt4Account = new TmpMt4Account();
//                $tmpMt4Account->setMt4Username($mt4Username);
//                $tmpMt4Account->setMt4Password($mt4Password);
//                $tmpMt4Account->setFullname($fullname);
//                $tmpMt4Account->setEmail($email);
//                $tmpMt4Account->setStatusCode(Globals::STATUS_CANCEL);
//                $tmpMt4Account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                $tmpMt4Account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                $tmpMt4Account->save();
//
//                print_r($mt4Username);
//                print_r("<br>");
//            }
        }
        print_r($totalRow);

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeCustomerEnquiryList()
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
        $c->add(MlmCustomerEnquiryPeer::DISTRIBUTOR_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        //$c->addAnd(MlmEcashWithdrawPeer::F_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $totalRecords = MlmCustomerEnquiryPeer::doCount($c);

        /******   total filtered records  *******/
        /*if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(MlmEcashWithdrawPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }*/
        $totalFilteredRecords = MlmCustomerEnquiryPeer::doCount($c);

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
        $pager = new sfPropelPager('MlmCustomerEnquiry', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $lastReply = "";
            $read = "";

            if ($result->getAdminUpdated() == "T") {
                $lastReply = "<font style='color:red'>Yes</font>";
            }
            if ($result->getDistributorRead() == "T") {
                $read = "Read";
            } else {
                $read = "Unread";
            }
            $arr[] = array(
                $result->getEnquiryId() == null ? "" : $result->getEnquiryId(),
                $result->getUpdatedOn()  == null ? "" : $result->getUpdatedOn(),
                $result->getTitle() == null ? "" : $result->getTitle(),
                $lastReply,
                $read
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

    public function executeIndex_bak()
    {
        $con = Propel::getConnection(MlmEcashWithdrawPeer::DATABASE_NAME);
        try {
            $con->begin();
            $tbl_ecash_withdraw = new MlmEcashWithdraw();
            $tbl_ecash_withdraw->setDistId(0);
            $tbl_ecash_withdraw->setDeduct(0);
            $tbl_ecash_withdraw->setAmount(0);
            $tbl_ecash_withdraw->setStatusCode("12312312312313123123123123123131313213212312312313123");
            $tbl_ecash_withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->save();

            $tbl_ecash_withdraw = new MlmEcashWithdraw();
            $tbl_ecash_withdraw->setDistId(1);
            $tbl_ecash_withdraw->setDeduct(1);
            $tbl_ecash_withdraw->setAmount(1);
            $tbl_ecash_withdraw->setStatusCode(Globals::WITHDRAWAL_PENDING);
            $tbl_ecash_withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_ecash_withdraw->save();

            $distributorDB = MlmDistributorPeer::retrieveByPk(1000);
            $distributorDB->getDistributorCode();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executePinTransactionLogList()
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
        $c->add(TblPinPeer::F_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = TblPinPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterPinCode') != "") {
            $c->addAnd(TblPinPeer::F_PIN, "%" . $this->getRequestParameter('filterPinCode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterType') != "") {
            $c->addAnd(TblPinPeer::F_TYPE, "%" . $this->getRequestParameter('filterType') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterAction') != "") {
            $c->addAnd(TblPinPeer::F_ACTION, "%" . $this->getRequestParameter('filterAction') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = TblPinPeer::doCount($c);

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
        $pager = new sfPropelPager('TblPin', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getFPin() == null ? "" : $result->getFPin(),
                $result->getFCps() == null ? "" : $result->getFCps(),
                $result->getFType() == null ? "" : $result->getFType(),
                $result->getFAction() == null ? "" : $result->getFAction(),
                $result->getFActionDatetime() == null ? "" : $result->getFActionDatetime(),
                $result->getFCreatedDatetime() == null ? "" : $result->getFCreatedDatetime()
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

    public function executePlacementLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM tbl_placement placement
            LEFT JOIN tbl_distributor distributor ON placement.f_dist_id2 = distributor.f_id ";

        /******   total records  *******/
        $sWhere = " WHERE placement.f_dist_id =".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $totalRecords = $this->getTotalRecords($sql.$sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistcode') != "") {
            $sWhere .= " AND placement.f_dist_code2 LIKE %".mysql_real_escape_string($this->getRequestParameter('filterDistcode'))."%";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterPlacementcode') != "") {
            $sWhere .= " AND placement.f_parentid_code2 LIKE %".mysql_real_escape_string($this->getRequestParameter('filterPlacementcode'))."%";
            //$c->addAnd(sfPropelPager::F_PARENTID_CODE2, "%" . $this->getRequestParameter('filterPlacementcode') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterPosition') != "") {
            $sWhere .= " AND placement.f_position LIKE %".mysql_real_escape_string($this->getRequestParameter('filterPosition'))."%";
            //$c->addAnd(TblPlacementPeer::F_POSITION, "%" . $this->getRequestParameter('filterPosition') . "%", Criteria::LIKE);
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

            $position = "";
            if ($resultArr['f_position'] <> null && $this->getUser()->getCulture() == "cn") {
                if ("left" == $resultArr['f_position']){
                    $position = $this->getContext()->getI18N()->__("left");
                }else{
                    $position = $this->getContext()->getI18N()->__("right");
                }
            }
            $arr[] = array(
                $resultArr['f_dist_code2'] == null ? "" : $resultArr['f_dist_code2'],
                $resultArr['f_name'] == null ? "" : $resultArr['f_name'],
                $resultArr['f_parentid_code2'] == null ? "" : $resultArr['f_parentid_code2'],
                $position,
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

    public function executeDownlineMemberList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM mlm_distributor ";

        /******   total records  *******/
        $sWhere = " WHERE distributor_id <> ".$this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $sWhere .= " AND placement_tree_structure like '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1458) {
            // hide datoheng group
            $sWhere .= " AND placement_tree_structure not like '%|203|%'";
        }

        $totalRecords = $this->getTotalRecords($sql.$sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('search_memberId') != "") {
            $sWhere .= " AND distributor_code LIKE '%".mysql_real_escape_string($this->getRequestParameter('search_memberId'))."%'";
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
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name']
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
}
