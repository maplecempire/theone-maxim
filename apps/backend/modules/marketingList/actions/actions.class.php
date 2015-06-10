<?php

/**
 * marketingList actions.
 *
 * @package    sf_sandbox
 * @subpackage marketingList
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class marketingListActions extends sfActions
{
    public function executeUploadMaterialList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM mlm_upload_material a ";

        /******   total records  *******/
        $sWhere = " WHERE 1=1 ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/

        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['id'] == null ? "" : $resultArr['id'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['file_name'] == null ? "" : $resultArr['file_name'],
                $resultArr['file_thumbnail'] == null ? "" : $resultArr['file_thumbnail'],
                $resultArr['description'] == null ? "" : $resultArr['description'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['id'] == null ? "" : $resultArr['id']
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
    public function executeAnnouncementList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM app_news announcement ";

        /******   total records  *******/
        $sWhere = " WHERE 1=1 ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterTitle') != "") {
            $sWhere .= " AND announcement.ns_title like '%" . $this->getRequestParameter('filterTitle') ."%'";
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sStatus = "";

            if ($this->getRequestParameter('filterStatusCode') == Globals::STATUS_ACTIVE) {
                $sStatus = " AND announcement.ns_end_date > NOW()";
            }

            $sWhere .= " AND announcement.ns_status like '%" . $this->getRequestParameter('filterStatusCode') ."%'" . $sStatus;
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . ", IF(announcement.ns_end_date > NOW(), announcement.ns_status, 'CLOSED') ns_status2 " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['id'] == null ? "" : $resultArr['id'],
                $resultArr['id'] == null ? "" : $resultArr['id'],
                $resultArr['ns_title'] == null ? "" : $resultArr['ns_title'],
                $resultArr['ns_status'] == null ? "" : $resultArr['ns_status2'],
                $resultArr['ns_start_date'] == null ? "" : $resultArr['ns_start_date'],
                $resultArr['ns_end_date'] == null ? "" : $resultArr['ns_end_date'],
                $resultArr['updated_on'] == null ? "" : $resultArr['updated_on']
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

    public function executeCommissionList()
    {
        if ($this->getRequestParameter('filterRemark') == "") {
            $output = array(
                "sEcho" => intval($this->getRequestParameter('sEcho')),
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array()
            );
            echo json_encode($output);
            return sfView::HEADER_ONLY;
        }

        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        $sColumns = str_replace("leader.distributor_code", "leader.distributor_code as leader_dist_code", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM mlm_dist_commission_ledger";

        /******   total records  *******/
        $sWhere = " WHERE commission_type = 'DRB' AND dist_id > 0";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/

        if ($this->getRequestParameter('filterRemark') != "") {
            $sWhere .= " AND remark like '%" . $this->getRequestParameter('filterRemark') ."%'";
        }

        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['created_on'] == null ? "" : $resultArr['created_on']
                , $resultArr['credit'] == null ? "" : $resultArr['credit']
                , $resultArr['remark'] == null ? "" : $resultArr['remark']
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
    public function executeMaturityAccountList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        $sColumns = str_replace("leader.distributor_code", "leader.distributor_code as leader_dist_code", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM notification_of_maturity maturity
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = maturity.dist_id
        LEFT JOIN mlm_distributor leader ON leader.distributor_id = maturity.leader_dist_id";

        /******   total records  *******/
        $sWhere = " WHERE 1=1";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/

        if ($this->getRequestParameter('filterDistcode') != "") {
            $sWhere .= " AND dist.distributor_code like '%" . $this->getRequestParameter('filterDistcode') ."%'";
        }
        if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sWhere .= " AND maturity.mt4_user_name like '%" . $this->getRequestParameter('filterMt4Userame') ."%'";
        }
        if ($this->getRequestParameter('filterEmail') != "") {
            $sWhere .= " AND maturity.email like '%" . $this->getRequestParameter('filterEmail') ."%'";
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND maturity.status_code = '" . $this->getRequestParameter('filterStatusCode') ."'";
        }

        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $packagePrice = $resultArr['package_price'];
            $mt4Username = $resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name'];
            if ($packagePrice == null) {
                $c = new Criteria();
                $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
                $c->add(MlmRoiDividendPeer::IDX, 18);
                $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);
                $packagePrice = $mlmRoiDividendDB->getPackagePrice();

                $existNotificationOfMaturity = NotificationOfMaturityPeer::retrieveByPK($resultArr['notice_id']);
                $existNotificationOfMaturity->setPackagePrice($packagePrice);
                $existNotificationOfMaturity->save();
            }
            $arr[] = array(
                $resultArr['notice_id'] == null ? "" : $resultArr['notice_id']
                , $resultArr['notice_id'] == null ? "" : $resultArr['notice_id']
                , $resultArr['dividend_date'] == null ? "" : $resultArr['dividend_date']
                , $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code']
                , $resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name']
                , $resultArr['mt4_balance'] == null ? "" : $resultArr['mt4_balance']
                , $resultArr['status_code'] == null ? "" : $resultArr['status_code']
                , $resultArr['approve_reject_datetime'] == null ? "" : $resultArr['approve_reject_datetime']
                , $resultArr['remark'] == null ? "" : $resultArr['remark']
                , $resultArr['internal_remark'] == null ? "" : $resultArr['internal_remark']
                , $resultArr['email'] == null ? "" : $resultArr['email']
                , $resultArr['maturity_type'] == null ? "" : $resultArr['maturity_type']
                , $resultArr['leader_dist_code'] == null ? "" : $resultArr['leader_dist_code']
                , $resultArr['dividend_date'] == null ? "" : $resultArr['dividend_date']
                , $resultArr['email_status'] == null ? "" : $resultArr['email_status']
                , $packagePrice
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
    public function executeLuckydrawList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("parent_nickname", "parentUser.distributor_code as parent_nickname", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM lucky_draw";

        /******   total records  *******/
        $sWhere = " WHERE draw_type = '".$this->getRequestParameter('filterSearch_drawType')."'";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/

        if ($this->getRequestParameter('filterSearch_email') != "") {
            $sWhere .= " AND email like '%" . $this->getRequestParameter('filterSearch_email') ."%'";
        }
        if ($this->getRequestParameter('filterSearch_mt4Username') != "") {
            $sWhere .= " AND mt4_username like '%" . $this->getRequestParameter('filterSearch_mt4Username') ."%'";
        }
        if ($this->getRequestParameter('filterSearch_fullname') != "") {
            $sWhere .= " AND full_name like '%" . $this->getRequestParameter('filterSearch_fullname') ."%'";
        }

        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['account_id'] == null ? "" : $resultArr['account_id'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['email'] == null ? "" : $resultArr['email'],
                $resultArr['mt4_username'] == null ? "" : $resultArr['mt4_username'],
                $resultArr['mt4_password'] == null ? "" : $resultArr['mt4_password'],
                $resultArr['amount'] == null ? "" : $resultArr['amount']
                , $resultArr['status_code'] == null ? "" : $resultArr['status_code']
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
    public function executeRpLogList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("parent_nickname", "parentUser.distributor_code as parent_nickname", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM mlm_account_ledger account
                    LEFT JOIN app_user appUser ON appUser.user_id = account.created_by";

        /******   total records  *******/
        $sWhere = " WHERE account.account_type IN ('".Globals::ACCOUNT_TYPE_RP."','".Globals::ACCOUNT_TYPE_DEBIT."') ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/
        $toQuery = false;
        if ($this->getRequestParameter('filterDistId') != "") {
            $sWhere .= " AND account.dist_id = " . $this->getRequestParameter('filterDistId');
            $toQuery = true;
        }
        if ($this->getRequestParameter('filterAccountType') != "") {
            $sWhere .= " AND account.account_type like '%" . mysql_real_escape_string($this->getRequestParameter('filterAccountType')). "%'";
        }
        if ($this->getRequestParameter('filterTransactionType') != "") {
            $sWhere .= " AND account.transaction_type like '%" . mysql_real_escape_string($this->getRequestParameter('filterTransactionType')). "%'";
        }

        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;

        if ($toQuery) {
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $resultset = $statement->executeQuery();
            //var_dump($query);
            while ($resultset->next())
            {
                $resultArr = $resultset->getRow();

                $arr[] = array(
                    $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                    $resultArr['account_type'] == null ? "" : $resultArr['account_type'],
                    $resultArr['transaction_type'] == null ? "" : $resultArr['transaction_type'],
                    $resultArr['credit'] == null ? "" : $resultArr['credit'],
                    $resultArr['debit'] == null ? "" : $resultArr['debit'],
                    $resultArr['balance'] == null ? "" : $resultArr['balance'],
                    $resultArr['username'] == null ? "" : $resultArr['username']
                , $resultArr['remark'] == null ? "" : $resultArr['remark']
                , $resultArr['internal_remark'] == null ? "" : $resultArr['internal_remark']
                );
            }
            $output = array(
                "sEcho" => intval($sEcho),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalFilteredRecords,
                "aaData" => $arr
            );
        } else {
            $output = array(
                "sEcho" => intval($sEcho),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalFilteredRecords,
                "aaData" => array()
            );
        }
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }
    public function executeRpLogList_bak()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $accountTypeArr = array(Globals::ACCOUNT_TYPE_RP, Globals::ACCOUNT_TYPE_DEBIT);

        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, $accountTypeArr , Criteria::IN);
        $totalRecords = MlmAccountLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistId') != "") {
            $c->addAnd(MlmAccountLedgerPeer::DIST_ID, $this->getRequestParameter('filterDistId'));
        }
        if ($this->getRequestParameter('filterAccountType') != "") {
            $c->addAnd(MlmAccountLedgerPeer::ACCOUNT_TYPE, "%" . $this->getRequestParameter('filterAccountType') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterTransactionType') != "") {
            $c->addAnd(MlmAccountLedgerPeer::TRANSACTION_TYPE, "%" . $this->getRequestParameter('filterTransactionType') . "%", Criteria::LIKE);
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
                $result->getAccountType() == null ? "" : $this->getContext()->getI18N()->__($result->getAccountType()),
                $result->getTransactionType() == null ? "" : $this->getContext()->getI18N()->__($result->getTransactionType()),
                $result->getCredit() == null ? "0" : $result->getCredit(),
                $result->getDebit() == null ? "0" : $result->getDebit(),
                $result->getBalance() == null ? "0" : $result->getBalance(),
                $result->getRemark()  == null ? "" : $result->getRemark(),
                $result->getInternalRemark()  == null ? "" : $result->getInternalRemark()
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
    public function executeRpList()
    {
        //$sColumns = $this->getRequestParameter('sColumns'). ", rp.TOTAL_DEBIT ";
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("parent_nickname", "parentUser.distributor_code as parent_nickname", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM mlm_distributor dist
            LEFT JOIN app_user tblUser ON dist.user_id = tblUser.user_id
            LEFT JOIN mlm_distributor parentUser ON dist.upline_dist_id = parentUser.distributor_id
            INNER JOIN
            (
                SELECT transferLedger.dist_id
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
                    where transferLedger.account_type = '".Globals::ACCOUNT_TYPE_RP."' group by transferLedger.dist_id
            ) rp ON rp.dist_id = dist.distributor_id
        ";

        $sql = " FROM mlm_distributor dist
            LEFT JOIN app_user tblUser ON dist.user_id = tblUser.user_id
            LEFT JOIN mlm_distributor parentUser ON dist.upline_dist_id = parentUser.distributor_id
        ";

        if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sql .= " INNER JOIN ";
        } else {
            $sql .= " LEFT JOIN ";
        }

        $sql .= " (
                    select dist_id, mt4_user_name, mt4_password from mlm_dist_mt4";

        if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sql .= " where mt4_user_name LIKE '%" . $this->getRequestParameter('filterMt4Userame') . "%'";
        }

        $sql .= " group by dist_id
        ) mt4 ON mt4.dist_id = dist.distributor_id ";

        /******   total records  *******/
        $sWhere = " WHERE 1=1 ";

        //var_dump($this->getUser()->getAttribute(Globals::SESSION_USERID));
        if ($this->getUser()->getAttribute(Globals::SESSION_USERID) == 1015 || $this->getUser()->getAttribute(Globals::SESSION_USERID) == 1016 || $this->getUser()->getAttribute(Globals::SESSION_USERID) == 1017) {
            $sWhere .= " AND dist.distributor_code NOT IN ('bra129', 'bre129', 'dca1491', 'chris5', 'datoheng', 'boing1491a', 'boing1491b', 'amz001', 'klm76', 'kl6', 'vision1', 'fyl188')";
        }

        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistcode') != "") {
            $sWhere .= " AND dist.distributor_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterDistcode')) . "%'";
        }

        if ($this->getRequestParameter('filterFullName') != "") {
            $sWhere .= " AND dist.full_name LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterFullName')) . "%'";
        }
        if ($this->getRequestParameter('filterEmail') != "") {
            $sWhere .= " AND dist.email LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterEmail')) . "%'";
        }
        if ($this->getRequestParameter('filterParentCode') != "") {
            $sWhere .= " AND dist.upline_dist_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterParentCode')) . "%'";
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND dist.status_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterStatusCode')) . "%'";
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);
        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $resultArr['distributor_id']);
            $distMt4s = MlmDistMt4Peer::doSelect($c);

            $mt4Id = "";
            $mt4Password = "";
            if (count($distMt4s)) {
                foreach ($distMt4s as $distMt4) {
                    if ($mt4Id != "")
                        $mt4Id .= ",";
                    if ($mt4Password != "")
                        $mt4Password .= ",";
                    $mt4Id .= $distMt4->getMt4UserName();
                    $mt4Password .= $distMt4->getMt4Password();
                }
            }

//            $debitAccount = $resultArr['TOTAL_DEBIT'] == null ? 0 : $resultArr['TOTAL_DEBIT'];
//            $rollingPoint = $resultArr['TOTAL_ROLLING_POINT'] - $debitAccount;

            $arr[] = array(
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
//                number_format($rollingPoint, 2),
                $resultArr['rank_code'] == null ? "" : $resultArr['rank_code'],
                $resultArr['rank_code'] == null ? "" : $resultArr['rank_code'],
                $resultArr['userpassword'] == null ? "" : $resultArr['userpassword'],
                $resultArr['userpassword2'] == null ? "" : $resultArr['userpassword2'],
                $mt4Id,
                $mt4Password,
                /*$resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name'],
                $resultArr['mt4_password'] == null ? "" : $resultArr['mt4_password'],*/
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['nickname'] == null ? "" : $resultArr['nickname'],
                $resultArr['ic'] == null ? "" : $resultArr['ic'],
                $resultArr['country'] == null ? "" : $resultArr['country'],
                $resultArr['address'] == null ? "" : $resultArr['address'],
                $resultArr['postcode'] == null ? "" : $resultArr['postcode'],
                $resultArr['email'] == null ? "" : $resultArr['email'],
                $resultArr['contact'] == null ? "" : $resultArr['contact'],
                $resultArr['gender'] == null ? "" : $resultArr['gender'],
                $resultArr['dob'] == null ? "" : $resultArr['dob'],
                $resultArr['bank_name'] == null ? "" : $resultArr['bank_name'],
                $resultArr['bank_acc_no'] == null ? "" : $resultArr['bank_acc_no'],
                $resultArr['bank_holder_name'] == null ? "" : $resultArr['bank_holder_name'],
                $resultArr['bank_swift_code'] == null ? "" : $resultArr['bank_swift_code'],
                $resultArr['visa_debit_card'] == null ? "" : $resultArr['visa_debit_card'],
                $resultArr['upline_dist_code'] == null ? "" : $resultArr['upline_dist_code'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on']
                , $resultArr['file_bank_pass_book'] == null ? "" : $resultArr['file_bank_pass_book']
                , $resultArr['file_proof_of_residence'] == null ? "" : $resultArr['file_proof_of_residence']
                , $resultArr['file_nric'] == null ? "" : $resultArr['file_nric']
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

    public function executeEzyCashCardApplicationList()
    {
        $page = intval($this->getRequestParameter('page'));
	    $limit = intval($this->getRequestParameter('displayLength'));

        $offset = ($page-1) * $limit;
        $result = array();

        $sWhere = " WHERE 1=1";
        $sql = " FROM mlm_ezy_cash_card debit
                    LEFT JOIN mlm_distributor dist ON debit.dist_id = dist.distributor_id";

        $result["total"] = $this->getTotalRecords($sql.$sWhere);

        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);
        $sColumns = "debit.card_id, debit.dist_id, debit.qty, debit.sub_total, debit.status_code, debit.remark, debit.created_on
            , debit.remark, dist.distributor_code, dist.full_name, dist.email, dist.contact";
        /******   sorting  *******/
        $sOrder = " ";
        $order = $this->getRequestParameter('order');
        $sortField = $this->getRequestParameter('sort');
        if ($this->getRequestParameter('sort')) {
            $sOrder = " ORDER BY ".$sortField." ".$order;
        }

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $items = array();
        while ($resultset->next())
        {
            $row = $resultset->getRow();
            array_push($items, $row);
        }
        $result["rows"] = $items;

        echo json_encode($result);

        return sfView::HEADER_ONLY;
    }
    public function executeDebitCardApplicationList()
    {
        $page = intval($this->getRequestParameter('page'));
	    $limit = intval($this->getRequestParameter('displayLength'));

        $offset = ($page-1) * $limit;
        $result = array();

        $sWhere = " WHERE 1=1";
        $sql = " FROM mlm_debit_card_registration debit
                    LEFT JOIN mlm_distributor dist ON debit.dist_id = dist.distributor_id";

        $result["total"] = $this->getTotalRecords($sql.$sWhere);

        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);
        $sColumns = "debit.card_id, debit.dist_id, debit.account_id, debit.status_code, debit.full_name, debit.dob, debit.ic, debit.mother_maiden_name
        , debit.name_on_card, debit.address, debit.address2, debit.city, debit.state, debit.postcode, debit.country, debit.email, debit.contact
        , debit.created_by, debit.created_on, debit.updated_by, debit.updated_on, debit.remark, dist.distributor_code";
        /******   sorting  *******/
        $sOrder = " ";
        $order = $this->getRequestParameter('order');
        $sortField = $this->getRequestParameter('sort');
        if ($this->getRequestParameter('sort')) {
            $sOrder = " ORDER BY ".$sortField." ".$order;
        }

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $items = array();
        while ($resultset->next())
        {
            $row = $resultset->getRow();
            array_push($items, $row);
        }
        $result["rows"] = $items;

        echo json_encode($result);

        return sfView::HEADER_ONLY;
    }
    public function executeLiveAccountRequestList()
    {
        $page = intval($this->getRequestParameter('page'));
	    $limit = intval($this->getRequestParameter('displayLength'));

        $offset = ($page-1) * $limit;
        $result = array();

        $sWhere = " WHERE live_demo = 'LIVE'";
        $sql = " FROM mlm_mt4_demo_request ";

        $result["total"] = $this->getTotalRecords($sql.$sWhere);

        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);
        $sColumns = "request_id, first_name, email, status_code, created_by, created_on, updated_by, updated_on, country, phone_number, last_name, title, live_demo, address1, address2, agree_of_business, risk_disclosure, country_of_citizen, dob_day, dob_month, dob_year, ref_id, passport, subject, city, address_state";
        /******   sorting  *******/
        $sOrder = " ";
        $order = $this->getRequestParameter('order');
        $sortField = $this->getRequestParameter('sort');
        if ($this->getRequestParameter('sort')) {
            $sOrder = " ORDER BY ".$sortField." ".$order;
        }

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $items = array();
        while ($resultset->next())
        {
            $row = $resultset->getRow();
            array_push($items, $row);
        }
        $result["rows"] = $items;

        echo json_encode($result);

        return sfView::HEADER_ONLY;
    }
    public function executeDemoAccountRequestList()
    {
        $page = intval($this->getRequestParameter('page'));
	    $limit = intval($this->getRequestParameter('displayLength'));

        $offset = ($page-1) * $limit;
        $result = array();

        $sWhere = " WHERE live_demo = 'DEMO'";
        $sql = " FROM mlm_mt4_demo_request ";

        $result["total"] = $this->getTotalRecords($sql.$sWhere);

        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);
        $sColumns = "request_id, first_name, email, status_code, created_by, created_on, updated_by, updated_on, country, phone_number, last_name, title, live_demo, address1, address2, agree_of_business, risk_disclosure, country_of_citizen, dob_day, dob_month, dob_year, ref_id, passport, subject, city, address_state";
        /******   sorting  *******/
        $sOrder = " ";
        $order = $this->getRequestParameter('order');
        $sortField = $this->getRequestParameter('sort');
        if ($this->getRequestParameter('sort')) {
            $sOrder = " ORDER BY ".$sortField." ".$order;
        }

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $items = array();
        while ($resultset->next())
        {
            $row = $resultset->getRow();
            array_push($items, $row);
        }
        $result["rows"] = $items;

        echo json_encode($result);

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

        $sql = " FROM mlm_customer_enquiry customer
                    LEFT JOIN mlm_distributor dist ON customer.distributor_id = dist.distributor_id";

        /******   total records  *******/
        $sWhere = " WHERE 1=1";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterCategory') != "") {
            $sWhere .= " AND customer.category like '%" . $this->getRequestParameter('filterCategory') ."%'";
        }
        if ($this->getRequestParameter('filterSubject') != "") {
            $sWhere .= " AND customer.title like '%" . $this->getRequestParameter('filterSubject') ."%'";
        }
        if ($this->getRequestParameter('filterDistCode') != "") {
            $sWhere .= " AND dist.distributor_code like '%" . $this->getRequestParameter('filterDistCode') ."%'";
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND customer.status_code like '%" . $this->getRequestParameter('filterStatusCode') ."%'";
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();
            $lastReply = "";
            $read = "";

            if ($resultArr['distributor_updated'] == "T") {
                $lastReply = "<font style='color:red'>Yes</font>";
            }
            if ($resultArr['admin_read'] == "T") {
                $read = "Read";
            } else {
                $read = "Unread";
            }
            $arr[] = array(
                $resultArr['enquiry_id'] == null ? "" : $resultArr['enquiry_id'],
                $resultArr['enquiry_id'] == null ? "" : $resultArr['enquiry_id'],
                $resultArr['category'] == null ? "" : $resultArr['category'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['title'] == null ? "" : $resultArr['title'],
                $lastReply,
                $read,
                $resultArr['status_code'] == null ? "" : $resultArr['status_code']
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
    public function executeAdminUserList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        $sColumns = str_replace("createdBy", "createdBy.username as createdBy", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM mlm_admin a
            LEFT JOIN app_user u ON a.user_id = u.user_id
            LEFT JOIN app_user createdBy ON createdBy.user_id = a.created_by";

        /******   total records  *******/
        $sWhere = " WHERE a.admin_role <> 'SUPERADMIN' ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterUsername') != "") {
            $sWhere .= " AND u.username LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterUsername')) . "%'";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['user_id'] == null ? "" : $resultArr['user_id'],
                $resultArr['user_id'] == null ? "" : $resultArr['user_id'],
                $resultArr['username'] == null ? "" : $resultArr['username'],
                $resultArr['userpassword'] == null ? "" : $resultArr['userpassword'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['admin_role'] == null ? "" : $resultArr['admin_role'],
                $resultArr['createdBy'] == null ? "" : $resultArr['createdBy'],
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

    public function executeRoleList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("createdBy", "createdBy.username as createdBy", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " FROM app_user_role ";

        /******   total records  *******/
        $sWhere = " WHERE 1=1 ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterRoleCode') != "") {
            $sWhere .= " AND role_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterRoleCode')) . "%'";
            //$c->addAnd(sfPropelPager::F_DIST_CODE2, "%" . $this->getRequestParameter('filterDistcode') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['role_id'] == null ? "" : $resultArr['role_id'],
                $resultArr['role_id'] == null ? "" : $resultArr['role_id'],
                $resultArr['role_code'] == null ? "" : $resultArr['role_code'],
                $resultArr['role_desc'] == null ? "" : $resultArr['role_desc'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code']
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

    public function executeDistList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("parent_nickname", "parentUser.distributor_code as parent_nickname", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');
        $doSearch = false;
        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        if ($this->getRequestParameter('filterDistcode') == "" || strlen($this->getRequestParameter('filterDistcode')) < 3) {
            $output = array(
                "sEcho" => intval($sEcho),
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => $arr
            );
            echo json_encode($output);

            return sfView::HEADER_ONLY;
        }

        $sql = " ,dist.tree_structure,dist.leader_dist_id FROM mlm_distributor dist
            LEFT JOIN app_user tblUser ON dist.user_id = tblUser.user_id
         ";
        $sql = " ,dist.tree_structure FROM mlm_distributor dist ";

        // LEFT JOIN mlm_distributor parentUser ON dist.upline_dist_id = parentUser.distributor_id

        /*if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sql .= " INNER JOIN ";
        } else {
            $sql .= " LEFT JOIN ";
        }

        $sql .= " (
                    select dist_id, mt4_user_name, mt4_password from mlm_dist_mt4";

        if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sql .= " where mt4_user_name LIKE '%" . $this->getRequestParameter('filterMt4Userame') . "%'";
        }

        $sql .= " group by dist_id
        ) mt4 ON mt4.dist_id = dist.distributor_id ";*/

        /******   total records  *******/
        $sWhere = " WHERE 1=1 ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistcode') != "") {
            //$sWhere .= " AND dist.distributor_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterDistcode')) . "%'";
            $sWhere .= " AND dist.distributor_code LIKE '" . mysql_real_escape_string($this->getRequestParameter('filterDistcode')) . "'";
        }

        if ($this->getRequestParameter('filterFullName') != "") {
            $sWhere .= " AND dist.full_name LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterFullName')) . "%'";
        }
        if ($this->getRequestParameter('filterEmail') != "") {
            $sWhere .= " AND dist.email LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterEmail')) . "%'";
        }
        if ($this->getRequestParameter('filterContact') != "") {
            $sWhere .= " AND dist.contact LIKE '%" . $this->getRequestParameter('filterContact') . "%'";
        }
        if ($this->getRequestParameter('filterParentCode') != "") {
            $sWhere .= " AND dist.upline_dist_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterParentCode')) . "%'";
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND dist.status_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterStatusCode')) . "%'";
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);

        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            /*$c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $resultArr['distributor_id']);
            $distMt4s = MlmDistMt4Peer::doSelect($c);*/

            $mt4Id = "***";
            $mt4Password = "***";
            /*if (count($distMt4s)) {
                foreach ($distMt4s as $distMt4) {
                    if ($mt4Id != "")
                        $mt4Id .= ",";
                    if ($mt4Password != "")
                        $mt4Password .= ",";
                    $mt4Id .= $distMt4->getMt4UserName();
                    $mt4Password .= $distMt4->getMt4Password();
                }
            }*/

            $leader = "***";
            $dist = MlmDistributorPeer::retrieveByPK($resultArr['leader_dist_id']);
            if ($dist) {
                $leader = $dist->getDistributorCode();
            }

            $arr[] = array(
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['rank_code'] == null ? "" : $resultArr['rank_code'],
                //$resultArr['userpassword'] == null ? "" : $resultArr['userpassword'],
                //$resultArr['userpassword2'] == null ? "" : $resultArr['userpassword2'],
                "******",
                "******",
                $mt4Id,
                $mt4Password,
                /*$resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name'],
                $resultArr['mt4_password'] == null ? "" : $resultArr['mt4_password'],*/
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['nickname'] == null ? "" : $resultArr['nickname'],
                $resultArr['ic'] == null ? "" : $resultArr['ic'],
                $resultArr['country'] == null ? "" : $resultArr['country'],
                $resultArr['address'] == null ? "" : $resultArr['address'],
                $resultArr['postcode'] == null ? "" : $resultArr['postcode'],
                $resultArr['email'] == null ? "" : $resultArr['email'],
                $resultArr['contact'] == null ? "" : $resultArr['contact'],
                $resultArr['gender'] == null ? "" : $resultArr['gender'],
                $resultArr['dob'] == null ? "" : $resultArr['dob'],
                $resultArr['bank_name'] == null ? "" : $resultArr['bank_name'],
                $resultArr['bank_acc_no'] == null ? "" : $resultArr['bank_acc_no'],
                $resultArr['bank_holder_name'] == null ? "" : $resultArr['bank_holder_name'],
                $resultArr['bank_swift_code'] == null ? "" : $resultArr['bank_swift_code'],
                $resultArr['visa_debit_card'] == null ? "" : $resultArr['visa_debit_card'],
                $resultArr['upline_dist_code'] == null ? "" : $resultArr['upline_dist_code'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on']
                , $resultArr['file_bank_pass_book'] == null ? "" : $resultArr['file_bank_pass_book']
                , $resultArr['file_proof_of_residence'] == null ? "" : $resultArr['file_proof_of_residence']
                , $resultArr['file_nric'] == null ? "" : $resultArr['file_nric']
                , $leader
                , $resultArr['remark'] == null ? "" : $resultArr['remark']
                , $resultArr['hide_genealogy'] == null ? "" : $resultArr['hide_genealogy']
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

    public function executeKycList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("parent_nickname", "parentUser.distributor_code as parent_nickname", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = " ,dist.tree_structure FROM mlm_distributor dist
            LEFT JOIN app_user tblUser ON dist.user_id = tblUser.user_id
         ";

        /******   total records  *******/
        $sWhere = " WHERE 1=1 ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);
        //var_dump($sql);
        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistcode') != "") {
            $sWhere .= " AND dist.distributor_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterDistcode')) . "%'";
        }
        if ($this->getRequestParameter('filterKycStatus') != "") {
            $sWhere .= " AND dist.kyc_status = '" . mysql_real_escape_string($this->getRequestParameter('filterKycStatus')) . "'";
        }

        if ($this->getRequestParameter('filterFullName') != "") {
            $sWhere .= " AND dist.full_name LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterFullName')) . "%'";
        }
        if ($this->getRequestParameter('filterEmail') != "") {
            $sWhere .= " AND dist.email LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterEmail')) . "%'";
        }
        if ($this->getRequestParameter('filterContact') != "") {
            $sWhere .= " AND dist.contact LIKE '%" . $this->getRequestParameter('filterContact') . "%'";
        }
        /*if ($this->getRequestParameter('filterParentCode') != "") {
            $sWhere .= " AND dist.upline_dist_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterParentCode')) . "%'";
        }*/
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND dist.status_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterStatusCode')) . "%'";
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        //var_dump($query);

        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $leader = "";
            $arr[] = array(
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['kyc_status'] == null ? "" : $resultArr['kyc_status'],
                //$resultArr['userpassword'] == null ? "" : $resultArr['userpassword'],
                //$resultArr['userpassword2'] == null ? "" : $resultArr['userpassword2'],
                "******",
                "******",
                "",
                "",
                /*$resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name'],
                $resultArr['mt4_password'] == null ? "" : $resultArr['mt4_password'],*/
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['nickname'] == null ? "" : $resultArr['nickname'],
                $resultArr['ic'] == null ? "" : $resultArr['ic'],
                $resultArr['country'] == null ? "" : $resultArr['country'],
                $resultArr['address'] == null ? "" : $resultArr['address'],
                $resultArr['postcode'] == null ? "" : $resultArr['postcode'],
                $resultArr['email'] == null ? "" : $resultArr['email'],
                $resultArr['contact'] == null ? "" : $resultArr['contact'],
                $resultArr['gender'] == null ? "" : $resultArr['gender'],
                $resultArr['dob'] == null ? "" : $resultArr['dob'],
                $resultArr['bank_name'] == null ? "" : $resultArr['bank_name'],
                $resultArr['bank_acc_no'] == null ? "" : $resultArr['bank_acc_no'],
                $resultArr['bank_holder_name'] == null ? "" : $resultArr['bank_holder_name'],
                $resultArr['bank_swift_code'] == null ? "" : $resultArr['bank_swift_code'],
                $resultArr['visa_debit_card'] == null ? "" : $resultArr['visa_debit_card'],
                $resultArr['upline_dist_code'] == null ? "" : $resultArr['upline_dist_code'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on']
                , $resultArr['file_bank_pass_book'] == null ? "" : $resultArr['file_bank_pass_book']
                , $resultArr['file_proof_of_residence'] == null ? "" : $resultArr['file_proof_of_residence']
                , $resultArr['file_nric'] == null ? "" : $resultArr['file_nric']
                , $leader
                , $resultArr['remark'] == null ? "" : $resultArr['remark']
                , $resultArr['hide_genealogy'] == null ? "" : $resultArr['hide_genealogy']
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

    public function executeIbList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("parent_nickname", "parentUser.distributor_code as parent_nickname", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM mlm_distributor dist
            LEFT JOIN app_user tblUser ON dist.user_id = tblUser.user_id
            LEFT JOIN mlm_distributor parentUser ON dist.upline_dist_id = parentUser.distributor_id ";

        if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sql .= " INNER JOIN ";
        } else {
            $sql .= " LEFT JOIN ";
        }

        $sql .= " (
                    select dist_id, mt4_user_name, mt4_password from mlm_dist_mt4";

        if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sql .= " where mt4_user_name LIKE '%" . $this->getRequestParameter('filterMt4Userame') . "%'";
        }

        $sql .= " group by dist_id
        ) mt4 ON mt4.dist_id = dist.distributor_id ";

        /******   total records  *******/
        $sWhere = " WHERE dist.IS_IB =".Globals::YES;
        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistcode') != "") {
            $sWhere .= " AND dist.distributor_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterDistcode')) . "%'";
        }
        /*if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sWhere .= " AND dist.mt4_user_name LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterMt4Userame')) . "%'";
        }*/
        if ($this->getRequestParameter('filterFullName') != "") {
            $sWhere .= " AND dist.full_name LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterFullName')) . "%'";
        }
        if ($this->getRequestParameter('filterEmail') != "") {
            $sWhere .= " AND dist.email LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterEmail')) . "%'";
        }
        if ($this->getRequestParameter('filterParentCode') != "") {
            $sWhere .= " AND dist.upline_dist_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterParentCode')) . "%'";
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND dist.status_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterStatusCode')) . "%'";
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $resultArr['distributor_id']);
            $distMt4s = MlmDistMt4Peer::doSelect($c);

            $mt4Id = "";
            $mt4Password = "";
            if (count($distMt4s)) {
                foreach ($distMt4s as $distMt4) {
                    if ($mt4Id != "")
                        $mt4Id .= ",";
                    if ($mt4Password != "")
                        $mt4Password .= ",";
                    $mt4Id .= $distMt4->getMt4UserName();
                    $mt4Password .= $distMt4->getMt4Password();
                }
            }

            $arr[] = array(
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['rank_code'] == null ? "" : $resultArr['rank_code'],
                $resultArr['userpassword'] == null ? "" : $resultArr['userpassword'],
                $resultArr['userpassword2'] == null ? "" : $resultArr['userpassword2'],
                $mt4Id,
                $mt4Password,
                //$resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name'],
                //$resultArr['mt4_password'] == null ? "" : $resultArr['mt4_password'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['nickname'] == null ? "" : $resultArr['nickname'],
                $resultArr['ic'] == null ? "" : $resultArr['ic'],
                $resultArr['country'] == null ? "" : $resultArr['country'],
                $resultArr['address'] == null ? "" : $resultArr['address'],
                $resultArr['postcode'] == null ? "" : $resultArr['postcode'],
                $resultArr['email'] == null ? "" : $resultArr['email'],
                $resultArr['contact'] == null ? "" : $resultArr['contact'],
                $resultArr['gender'] == null ? "" : $resultArr['gender'],
                $resultArr['dob'] == null ? "" : $resultArr['dob'],
                $resultArr['bank_name'] == null ? "" : $resultArr['bank_name'],
                $resultArr['bank_acc_no'] == null ? "" : $resultArr['bank_acc_no'],
                $resultArr['bank_holder_name'] == null ? "" : $resultArr['bank_holder_name'],
                $resultArr['bank_swift_code'] == null ? "" : $resultArr['bank_swift_code'],
                $resultArr['visa_debit_card'] == null ? "" : $resultArr['visa_debit_card'],
                $resultArr['upline_dist_code'] == null ? "" : $resultArr['upline_dist_code'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['ib_commission'] == null ? "" : $resultArr['ib_commission']
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

    public function executeDistPipsList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);
        //$sColumns = str_replace("parent_nickname", "parentUser.distributor_code as parent_nickname", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        $sql = "FROM mlm_distributor dist
            LEFT JOIN app_user tblUser ON dist.user_id = tblUser.user_id
            LEFT JOIN mlm_distributor parentUser ON dist.upline_dist_id = parentUser.distributor_id
            LEFT JOIN (
                SELECT SUM(credit-debit) AS SUB_TOTAL, dist_id FROM mlm_dist_commission_ledger WHERE commission_type = '" . Globals::COMMISSION_TYPE_PIPS_BONUS . "' GROUP BY dist_id
            ) comm ON dist.distributor_id = comm.dist_id";

        /******   total records  *******/
        $sWhere = " WHERE 1=1 ";
        $totalRecords = $this->getTotalRecords($sql . $sWhere);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterDistcode') != "") {
            $sWhere .= " AND dist.distributor_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterDistcode')) . "%'";
        }
        if ($this->getRequestParameter('filterMt4Userame') != "") {
            $sWhere .= " AND dist.mt4_user_name LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterMt4Userame')) . "%'";
        }
        if ($this->getRequestParameter('filterFullName') != "") {
            $sWhere .= " AND dist.full_name LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterFullName')) . "%'";
        }
        if ($this->getRequestParameter('filterEmail') != "") {
            $sWhere .= " AND dist.email LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterEmail')) . "%'";
        }
        if ($this->getRequestParameter('filterParentCode') != "") {
            $sWhere .= " AND dist.upline_dist_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterParentCode')) . "%'";
        }
        if ($this->getRequestParameter('filterStatusCode') != "") {
            $sWhere .= " AND dist.status_code LIKE '%" . mysql_real_escape_string($this->getRequestParameter('filterStatusCode')) . "%'";
        }
        $totalFilteredRecords = $this->getTotalRecords($sql . $sWhere);

        /******   sorting  *******/
        $sOrder = "ORDER BY  ";
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
        //var_dump($sOrder);
        /******   pagination  *******/
        $sLimit = " LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($limit);

        $query = "SELECT " . $sColumns . " " . $sql . " " . $sWhere . " " . $sOrder . " " . $sLimit;
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next())
        {
            $resultArr = $resultset->getRow();

            $arr[] = array(
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_id'] == null ? "" : $resultArr['distributor_id'],
                $resultArr['distributor_code'] == null ? "" : $resultArr['distributor_code'],
                $resultArr['rank_code'] == null ? "" : $resultArr['rank_code'],
                $resultArr['userpassword'] == null ? "" : $resultArr['userpassword'],
                $resultArr['userpassword2'] == null ? "" : $resultArr['userpassword2'],
                $resultArr['mt4_user_name'] == null ? "" : $resultArr['mt4_user_name'],
                $resultArr['mt4_password'] == null ? "" : $resultArr['mt4_password'],
                $resultArr['full_name'] == null ? "" : $resultArr['full_name'],
                $resultArr['nickname'] == null ? "" : $resultArr['nickname'],
                $resultArr['ic'] == null ? "" : $resultArr['ic'],
                $resultArr['country'] == null ? "" : $resultArr['country'],
                $resultArr['address'] == null ? "" : $resultArr['address'],
                $resultArr['postcode'] == null ? "" : $resultArr['postcode'],
                $resultArr['email'] == null ? "" : $resultArr['email'],
                $resultArr['contact'] == null ? "" : $resultArr['contact'],
                $resultArr['gender'] == null ? "" : $resultArr['gender'],
                $resultArr['dob'] == null ? "" : $resultArr['dob'],
                $resultArr['bank_name'] == null ? "" : $resultArr['bank_name'],
                $resultArr['bank_acc_no'] == null ? "" : $resultArr['bank_acc_no'],
                $resultArr['bank_holder_name'] == null ? "" : $resultArr['bank_holder_name'],
                $resultArr['bank_swift_code'] == null ? "" : $resultArr['bank_swift_code'],
                $resultArr['visa_debit_card'] == null ? "" : $resultArr['visa_debit_card'],
                $resultArr['upline_dist_code'] == null ? "" : $resultArr['upline_dist_code'],
                $resultArr['status_code'] == null ? "" : $resultArr['status_code'],
                $resultArr['created_on'] == null ? "" : $resultArr['created_on'],
                $resultArr['SUB_TOTAL'] == null ? "" : $resultArr['SUB_TOTAL']
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
}
