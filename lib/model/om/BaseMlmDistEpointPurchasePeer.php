<?php


abstract class BaseMlmDistEpointPurchasePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_dist_epoint_purchase';

	
	const CLASS_DEFAULT = 'lib.model.MlmDistEpointPurchase';

	
	const NUM_COLUMNS = 23;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const PURCHASE_ID = 'mlm_dist_epoint_purchase.PURCHASE_ID';

	
	const DIST_ID = 'mlm_dist_epoint_purchase.DIST_ID';

	
	const CURRENCY_TYPE = 'mlm_dist_epoint_purchase.CURRENCY_TYPE';

	
	const AMOUNT = 'mlm_dist_epoint_purchase.AMOUNT';

	
	const TRANSACTION_TYPE = 'mlm_dist_epoint_purchase.TRANSACTION_TYPE';

	
	const IMAGE_SRC = 'mlm_dist_epoint_purchase.IMAGE_SRC';

	
	const STATUS_CODE = 'mlm_dist_epoint_purchase.STATUS_CODE';

	
	const REMARKS = 'mlm_dist_epoint_purchase.REMARKS';

	
	const PAYMENT_REFERENCE = 'mlm_dist_epoint_purchase.PAYMENT_REFERENCE';

	
	const BANK_ID = 'mlm_dist_epoint_purchase.BANK_ID';

	
	const APPROVE_REJECT_DATETIME = 'mlm_dist_epoint_purchase.APPROVE_REJECT_DATETIME';

	
	const APPROVED_BY_USERID = 'mlm_dist_epoint_purchase.APPROVED_BY_USERID';

	
	const CREATED_BY = 'mlm_dist_epoint_purchase.CREATED_BY';

	
	const CREATED_ON = 'mlm_dist_epoint_purchase.CREATED_ON';

	
	const UPDATED_BY = 'mlm_dist_epoint_purchase.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_dist_epoint_purchase.UPDATED_ON';

	
	const PAYMENT_METHOD = 'mlm_dist_epoint_purchase.PAYMENT_METHOD';

	
	const PG_SUCCESS = 'mlm_dist_epoint_purchase.PG_SUCCESS';

	
	const PG_MSG = 'mlm_dist_epoint_purchase.PG_MSG';

	
	const PG_BILL_NO = 'mlm_dist_epoint_purchase.PG_BILL_NO';

	
	const PG_RET_ENCODE_TYPE = 'mlm_dist_epoint_purchase.PG_RET_ENCODE_TYPE';

	
	const PG_CURRENCY_TYPE = 'mlm_dist_epoint_purchase.PG_CURRENCY_TYPE';

	
	const PG_SIGNATURE = 'mlm_dist_epoint_purchase.PG_SIGNATURE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('PurchaseId', 'DistId', 'CurrencyType', 'Amount', 'TransactionType', 'ImageSrc', 'StatusCode', 'Remarks', 'PaymentReference', 'BankId', 'ApproveRejectDatetime', 'ApprovedByUserid', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', 'PaymentMethod', 'PgSuccess', 'PgMsg', 'PgBillNo', 'PgRetEncodeType', 'PgCurrencyType', 'PgSignature', ),
		BasePeer::TYPE_COLNAME => array (MlmDistEpointPurchasePeer::PURCHASE_ID, MlmDistEpointPurchasePeer::DIST_ID, MlmDistEpointPurchasePeer::CURRENCY_TYPE, MlmDistEpointPurchasePeer::AMOUNT, MlmDistEpointPurchasePeer::TRANSACTION_TYPE, MlmDistEpointPurchasePeer::IMAGE_SRC, MlmDistEpointPurchasePeer::STATUS_CODE, MlmDistEpointPurchasePeer::REMARKS, MlmDistEpointPurchasePeer::PAYMENT_REFERENCE, MlmDistEpointPurchasePeer::BANK_ID, MlmDistEpointPurchasePeer::APPROVE_REJECT_DATETIME, MlmDistEpointPurchasePeer::APPROVED_BY_USERID, MlmDistEpointPurchasePeer::CREATED_BY, MlmDistEpointPurchasePeer::CREATED_ON, MlmDistEpointPurchasePeer::UPDATED_BY, MlmDistEpointPurchasePeer::UPDATED_ON, MlmDistEpointPurchasePeer::PAYMENT_METHOD, MlmDistEpointPurchasePeer::PG_SUCCESS, MlmDistEpointPurchasePeer::PG_MSG, MlmDistEpointPurchasePeer::PG_BILL_NO, MlmDistEpointPurchasePeer::PG_RET_ENCODE_TYPE, MlmDistEpointPurchasePeer::PG_CURRENCY_TYPE, MlmDistEpointPurchasePeer::PG_SIGNATURE, ),
		BasePeer::TYPE_FIELDNAME => array ('purchase_id', 'dist_id', 'currency_type', 'amount', 'transaction_type', 'image_src', 'status_code', 'remarks', 'payment_reference', 'bank_id', 'approve_reject_datetime', 'approved_by_userid', 'created_by', 'created_on', 'updated_by', 'updated_on', 'payment_method', 'pg_success', 'pg_msg', 'pg_bill_no', 'pg_ret_encode_type', 'pg_currency_type', 'pg_signature', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('PurchaseId' => 0, 'DistId' => 1, 'CurrencyType' => 2, 'Amount' => 3, 'TransactionType' => 4, 'ImageSrc' => 5, 'StatusCode' => 6, 'Remarks' => 7, 'PaymentReference' => 8, 'BankId' => 9, 'ApproveRejectDatetime' => 10, 'ApprovedByUserid' => 11, 'CreatedBy' => 12, 'CreatedOn' => 13, 'UpdatedBy' => 14, 'UpdatedOn' => 15, 'PaymentMethod' => 16, 'PgSuccess' => 17, 'PgMsg' => 18, 'PgBillNo' => 19, 'PgRetEncodeType' => 20, 'PgCurrencyType' => 21, 'PgSignature' => 22, ),
		BasePeer::TYPE_COLNAME => array (MlmDistEpointPurchasePeer::PURCHASE_ID => 0, MlmDistEpointPurchasePeer::DIST_ID => 1, MlmDistEpointPurchasePeer::CURRENCY_TYPE => 2, MlmDistEpointPurchasePeer::AMOUNT => 3, MlmDistEpointPurchasePeer::TRANSACTION_TYPE => 4, MlmDistEpointPurchasePeer::IMAGE_SRC => 5, MlmDistEpointPurchasePeer::STATUS_CODE => 6, MlmDistEpointPurchasePeer::REMARKS => 7, MlmDistEpointPurchasePeer::PAYMENT_REFERENCE => 8, MlmDistEpointPurchasePeer::BANK_ID => 9, MlmDistEpointPurchasePeer::APPROVE_REJECT_DATETIME => 10, MlmDistEpointPurchasePeer::APPROVED_BY_USERID => 11, MlmDistEpointPurchasePeer::CREATED_BY => 12, MlmDistEpointPurchasePeer::CREATED_ON => 13, MlmDistEpointPurchasePeer::UPDATED_BY => 14, MlmDistEpointPurchasePeer::UPDATED_ON => 15, MlmDistEpointPurchasePeer::PAYMENT_METHOD => 16, MlmDistEpointPurchasePeer::PG_SUCCESS => 17, MlmDistEpointPurchasePeer::PG_MSG => 18, MlmDistEpointPurchasePeer::PG_BILL_NO => 19, MlmDistEpointPurchasePeer::PG_RET_ENCODE_TYPE => 20, MlmDistEpointPurchasePeer::PG_CURRENCY_TYPE => 21, MlmDistEpointPurchasePeer::PG_SIGNATURE => 22, ),
		BasePeer::TYPE_FIELDNAME => array ('purchase_id' => 0, 'dist_id' => 1, 'currency_type' => 2, 'amount' => 3, 'transaction_type' => 4, 'image_src' => 5, 'status_code' => 6, 'remarks' => 7, 'payment_reference' => 8, 'bank_id' => 9, 'approve_reject_datetime' => 10, 'approved_by_userid' => 11, 'created_by' => 12, 'created_on' => 13, 'updated_by' => 14, 'updated_on' => 15, 'payment_method' => 16, 'pg_success' => 17, 'pg_msg' => 18, 'pg_bill_no' => 19, 'pg_ret_encode_type' => 20, 'pg_currency_type' => 21, 'pg_signature' => 22, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmDistEpointPurchaseMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmDistEpointPurchaseMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmDistEpointPurchasePeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(MlmDistEpointPurchasePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PURCHASE_ID);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::DIST_ID);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::CURRENCY_TYPE);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::AMOUNT);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::TRANSACTION_TYPE);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::IMAGE_SRC);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::STATUS_CODE);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::REMARKS);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PAYMENT_REFERENCE);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::BANK_ID);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::APPROVE_REJECT_DATETIME);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::APPROVED_BY_USERID);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::CREATED_BY);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::CREATED_ON);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::UPDATED_ON);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PAYMENT_METHOD);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PG_SUCCESS);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PG_MSG);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PG_BILL_NO);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PG_RET_ENCODE_TYPE);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PG_CURRENCY_TYPE);

		$criteria->addSelectColumn(MlmDistEpointPurchasePeer::PG_SIGNATURE);

	}

	const COUNT = 'COUNT(mlm_dist_epoint_purchase.PURCHASE_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_dist_epoint_purchase.PURCHASE_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmDistEpointPurchasePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmDistEpointPurchasePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmDistEpointPurchasePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = MlmDistEpointPurchasePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmDistEpointPurchasePeer::populateObjects(MlmDistEpointPurchasePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmDistEpointPurchasePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MlmDistEpointPurchasePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return MlmDistEpointPurchasePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(MlmDistEpointPurchasePeer::PURCHASE_ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(MlmDistEpointPurchasePeer::PURCHASE_ID);
			$selectCriteria->add(MlmDistEpointPurchasePeer::PURCHASE_ID, $criteria->remove(MlmDistEpointPurchasePeer::PURCHASE_ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(MlmDistEpointPurchasePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(MlmDistEpointPurchasePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MlmDistEpointPurchase) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmDistEpointPurchasePeer::PURCHASE_ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(MlmDistEpointPurchase $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmDistEpointPurchasePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmDistEpointPurchasePeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(MlmDistEpointPurchasePeer::DATABASE_NAME, MlmDistEpointPurchasePeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmDistEpointPurchasePeer::DATABASE_NAME);

		$criteria->add(MlmDistEpointPurchasePeer::PURCHASE_ID, $pk);


		$v = MlmDistEpointPurchasePeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(MlmDistEpointPurchasePeer::PURCHASE_ID, $pks, Criteria::IN);
			$objs = MlmDistEpointPurchasePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMlmDistEpointPurchasePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MlmDistEpointPurchaseMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmDistEpointPurchaseMapBuilder');
}
