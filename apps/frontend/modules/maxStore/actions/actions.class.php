<?php

/**
 * maxStore actions.
 *
 * @package    sf_sandbox
 * @subpackage maxStore
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class maxStoreActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
        return $this->redirect('member/summary');

        $c = new Criteria();
        $c->add(MlmMaxStorePeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $productDBs = MlmMaxStorePeer::doSelect($c);

        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->ecashAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->cp3Available = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->productDBs = $productDBs;
    }

    public function executeDoPurchaseProduct()
    {
        $productIdArr = $this->getRequestParameter('productId');
        $qtyArr = $this->getRequestParameter('qty');

        $con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
        try {
            $con->begin();
            $success = true;

            $totalPurchaseAmount = 0;
            for ($i = 0; $i < count($productIdArr); $i++) {
                $productId = $productIdArr[$i];
                $qty = $qtyArr[$i];

                if ($qty != 0) {
                    $productDB = MlmMaxStorePeer::retrieveByPK($productId);
                    $totalAmount = $qty * $productDB->getPrice();

                    $totalPurchaseAmount += $totalAmount;
                }
            }

            $mlmProductPurchaseHistory = new MlmProductPurchaseHistory();
            $mlmProductPurchaseHistory->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlmProductPurchaseHistory->setTotalAmount($totalPurchaseAmount);
            $mlmProductPurchaseHistory->setStatusCode(Globals::STATUS_PENDING);
            $mlmProductPurchaseHistory->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmProductPurchaseHistory->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmProductPurchaseHistory->save();

            for ($i = 0; $i < count($productIdArr); $i++) {
                $productId = $productIdArr[$i];
                $qty = $qtyArr[$i];

                if ($qty != 0) {
                    $productDB = MlmMaxStorePeer::retrieveByPK($productId);
                    $totalAmount = $qty * $productDB->getPrice();
                    $distAccountEpointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                    if ($distAccountEpointBalance < $totalAmount) {
                        $success = false;
                        break;
                    }

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_TYPE_MAXSTORE);
                    $mlm_account_ledger->setRemark("PRODUCT PURCHASE (" . $productDB->getProductName() . "), PRICE:" . $productDB->getPrice() . ", QTY:" . $qty . ", TOTAL AMOUNT:" . $totalAmount);
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($totalAmount);
                    $mlm_account_ledger->setBalance($distAccountEpointBalance - $totalAmount);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->mirroringAccountLedger($mlm_account_ledger);

                    $mlmProductPurchaseHistoryDetail = new MlmProductPurchaseHistoryDetail();
                    $mlmProductPurchaseHistoryDetail->setHistoryId($mlmProductPurchaseHistory->getHistoryId());
                    $mlmProductPurchaseHistoryDetail->setProductId($productId);
                    $mlmProductPurchaseHistoryDetail->setAccountId($mlm_account_ledger->getAccountId());
                    $mlmProductPurchaseHistoryDetail->setPrice($productDB->getPrice());
                    $mlmProductPurchaseHistoryDetail->setQty($qty);
                    $mlmProductPurchaseHistoryDetail->setTotalAmount($totalAmount);
                    $mlmProductPurchaseHistoryDetail->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmProductPurchaseHistoryDetail->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmProductPurchaseHistoryDetail->save();
                }
            }
            if ($success) {
                $con->commit();
            } else {
                $con->rollback();
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient fund to purchase product."));

                return $this->redirect('/maxStore/index');
            }
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Product purchase successfully"));

        return $this->redirect('/maxStore/index');
    }

    public function executeHistory()
    {

    }

    public function executeHistoryDetailList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();
        $sql = "
            FROM mlm_product_purchase_history_detail detail
        LEFT JOIN mlm_max_store product ON product.store_id = detail.product_id";

        /******   total records  *******/
        $sWhere = " WHERE detail.history_id=".$this->getRequestParameter('filterHistoryId');
        /******   total filtered records  *******/

        $totalRecords = $this->getTotalRecords($sql . $sWhere);
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
                $resultArr['history_detail_id'] == null ? "" : $resultArr['history_detail_id'],
                $resultArr['product_name'] == null ? "" : $resultArr['product_name'],
                $resultArr['price'] == null ? "" : $resultArr['price'],
                $resultArr['qty'] == null ? "" : $resultArr['qty'],
                $resultArr['total_amount'] == null ? "" : $resultArr['total_amount'],
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

    public function executeHistoryList()
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
        $c->add(MlmProductPurchaseHistoryPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $totalRecords = MlmProductPurchaseHistoryPeer::doCount($c);

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
        $pager = new sfPropelPager('MlmProductPurchaseHistory', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getHistoryId()  == null ? "" : $result->getHistoryId(),
                $result->getCreatedOn()  == null ? "" : $result->getCreatedOn(),
                $result->getTotalAmount() == null ? "0" : $result->getTotalAmount(),
                $result->getStatusCode() == null ? "0" : $result->getStatusCode()
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

    function mirroringAccountLedger($mlmAccountLedger)
    {
        $log_account_ledger = new LogAccountLedger();
        $log_account_ledger->setAccountId($mlmAccountLedger->getAccountId());
        $log_account_ledger->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
        $log_account_ledger->setDistId($mlmAccountLedger->getDistId());
        $log_account_ledger->setAccountType($mlmAccountLedger->getAccountType());
        $log_account_ledger->setTransactionType($mlmAccountLedger->getTransactionType());
        $log_account_ledger->setRemark($mlmAccountLedger->getRemark());
        $log_account_ledger->setInternalRemark($mlmAccountLedger->getInternalRemark());
        $log_account_ledger->setCredit($mlmAccountLedger->getCredit());
        $log_account_ledger->setDebit($mlmAccountLedger->getDebit());
        $log_account_ledger->setBalance($mlmAccountLedger->getBalance());
        $log_account_ledger->setCreatedBy($mlmAccountLedger->getCreatedBy());
        $log_account_ledger->setUpdatedBy($mlmAccountLedger->getUpdatedBy());
        $log_account_ledger->save();
    }
}
