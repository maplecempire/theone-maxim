<?php


abstract class BaseMlmDistEpointPurchasePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_dist_epoint_purchase';

	
	const CLASS_DEFAULT = 'lib.model.MlmDistEpointPurchase';

	
	const NUM_COLUMNS = 15;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const PURCHASE_ID = 'mlm_dist_epoint_purchase.PURCHASE_ID';

	
	const DIST_ID = 'mlm_dist_epoint_purchase.DIST_ID';

	
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

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('PurchaseId', 'DistId', 'Amount', 'TransactionType', 'ImageSrc', 'StatusCode', 'Remarks', 'PaymentReference', 'BankId', 'ApproveRejectDatetime', 'ApprovedByUserid', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MlmDistEpointPurchasePeer::PURCHASE_ID, MlmDistEpointPurchasePeer::DIST_ID, MlmDistEpointPurchasePeer::AMOUNT, MlmDistEpointPurchasePeer::TRANSACTION_TYPE, MlmDistEpointPurchasePeer::IMAGE_SRC, MlmDistEpointPurchasePeer::STATUS_CODE, MlmDistEpointPurchasePeer::REMARKS, MlmDistEpointPurchasePeer::PAYMENT_REFERENCE, MlmDistEpointPurchasePeer::BANK_ID, MlmDistEpointPurchasePeer::APPROVE_REJECT_DATETIME, MlmDistEpointPurchasePeer::APPROVED_BY_USERID, MlmDistEpointPurchasePeer::CREATED_BY, MlmDistEpointPurchasePeer::CREATED_ON, MlmDistEpointPurchasePeer::UPDATED_BY, MlmDistEpointPurchasePeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('purchase_id', 'dist_id', 'amount', 'transaction_type', 'image_src', 'status_code', 'remarks', 'payment_reference', 'bank_id', 'approve_reject_datetime', 'approved_by_userid', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('PurchaseId' => 0, 'DistId' => 1, 'Amount' => 2, 'TransactionType' => 3, 'ImageSrc' => 4, 'StatusCode' => 5, 'Remarks' => 6, 'PaymentReference' => 7, 'BankId' => 8, 'ApproveRejectDatetime' => 9, 'ApprovedByUserid' => 10, 'CreatedBy' => 11, 'CreatedOn' => 12, 'UpdatedBy' => 13, 'UpdatedOn' => 14, ),
		BasePeer::TYPE_COLNAME => array (MlmDistEpointPurchasePeer::PURCHASE_ID => 0, MlmDistEpointPurchasePeer::DIST_ID => 1, MlmDistEpointPurchasePeer::AMOUNT => 2, MlmDistEpointPurchasePeer::TRANSACTION_TYPE => 3, MlmDistEpointPurchasePeer::IMAGE_SRC => 4, MlmDistEpointPurchasePeer::STATUS_CODE => 5, MlmDistEpointPurchasePeer::REMARKS => 6, MlmDistEpointPurchasePeer::PAYMENT_REFERENCE => 7, MlmDistEpointPurchasePeer::BANK_ID => 8, MlmDistEpointPurchasePeer::APPROVE_REJECT_DATETIME => 9, MlmDistEpointPurchasePeer::APPROVED_BY_USERID => 10, MlmDistEpointPurchasePeer::CREATED_BY => 11, MlmDistEpointPurchasePeer::CREATED_ON => 12, MlmDistEpointPurchasePeer::UPDATED_BY => 13, MlmDistEpointPurchasePeer::UPDATED_ON => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('purchase_id' => 0, 'dist_id' => 1, 'amount' => 2, 'transaction_type' => 3, 'image_src' => 4, 'status_code' => 5, 'remarks' => 6, 'payment_reference' => 7, 'bank_id' => 8, 'approve_reject_datetime' => 9, 'approved_by_userid' => 10, 'created_by' => 11, 'created_on' => 12, 'updated_by' => 13, 'updated_on' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
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
			$criteria = clone $values; 
		} else {
			$criteria = $values->buildCriteria(); 
		}

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

		} else { 
			$criteria = $values->buildCriteria(); 
			$selectCriteria = $values->buildPkeyCriteria(); 
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 
		try {
			
			
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
			$criteria = clone $values; 
		} elseif ($values instanceof MlmDistEpointPurchase) {

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
