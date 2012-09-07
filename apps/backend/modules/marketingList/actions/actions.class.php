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
        $sWhere = " WHERE 1=1 ";
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

        /******   total records  *******/
        $sWhere = " WHERE dist.IS_IB =".Globals::YES;
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
