<?php


abstract class BaseApiTransactionPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'api_transaction';

	
	const CLASS_DEFAULT = 'lib.model.ApiTransaction';

	
	const NUM_COLUMNS = 12;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const TRANSACTION_ID = 'api_transaction.TRANSACTION_ID';

	
	const ACCESS_IP = 'api_transaction.ACCESS_IP';

	
	const USER_ID = 'api_transaction.USER_ID';

	
	const TRANSACTION_ACTION = 'api_transaction.TRANSACTION_ACTION';

	
	const TRANSACTION_DATA = 'api_transaction.TRANSACTION_DATA';

	
	const REMARK = 'api_transaction.REMARK';

	
	const STATUS_CODE = 'api_transaction.STATUS_CODE';

	
	const TOKEN = 'api_transaction.TOKEN';

	
	const CREATED_BY = 'api_transaction.CREATED_BY';

	
	const CREATED_ON = 'api_transaction.CREATED_ON';

	
	const UPDATED_BY = 'api_transaction.UPDATED_BY';

	
	const UPDATED_ON = 'api_transaction.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('TransactionId', 'AccessIp', 'UserId', 'TransactionAction', 'TransactionData', 'Remark', 'StatusCode', 'Token', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (ApiTransactionPeer::TRANSACTION_ID, ApiTransactionPeer::ACCESS_IP, ApiTransactionPeer::USER_ID, ApiTransactionPeer::TRANSACTION_ACTION, ApiTransactionPeer::TRANSACTION_DATA, ApiTransactionPeer::REMARK, ApiTransactionPeer::STATUS_CODE, ApiTransactionPeer::TOKEN, ApiTransactionPeer::CREATED_BY, ApiTransactionPeer::CREATED_ON, ApiTransactionPeer::UPDATED_BY, ApiTransactionPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('transaction_id', 'access_ip', 'user_id', 'transaction_action', 'transaction_data', 'remark', 'status_code', 'token', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('TransactionId' => 0, 'AccessIp' => 1, 'UserId' => 2, 'TransactionAction' => 3, 'TransactionData' => 4, 'Remark' => 5, 'StatusCode' => 6, 'Token' => 7, 'CreatedBy' => 8, 'CreatedOn' => 9, 'UpdatedBy' => 10, 'UpdatedOn' => 11, ),
		BasePeer::TYPE_COLNAME => array (ApiTransactionPeer::TRANSACTION_ID => 0, ApiTransactionPeer::ACCESS_IP => 1, ApiTransactionPeer::USER_ID => 2, ApiTransactionPeer::TRANSACTION_ACTION => 3, ApiTransactionPeer::TRANSACTION_DATA => 4, ApiTransactionPeer::REMARK => 5, ApiTransactionPeer::STATUS_CODE => 6, ApiTransactionPeer::TOKEN => 7, ApiTransactionPeer::CREATED_BY => 8, ApiTransactionPeer::CREATED_ON => 9, ApiTransactionPeer::UPDATED_BY => 10, ApiTransactionPeer::UPDATED_ON => 11, ),
		BasePeer::TYPE_FIELDNAME => array ('transaction_id' => 0, 'access_ip' => 1, 'user_id' => 2, 'transaction_action' => 3, 'transaction_data' => 4, 'remark' => 5, 'status_code' => 6, 'token' => 7, 'created_by' => 8, 'created_on' => 9, 'updated_by' => 10, 'updated_on' => 11, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ApiTransactionMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ApiTransactionMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ApiTransactionPeer::getTableMap();
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
		return str_replace(ApiTransactionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ApiTransactionPeer::TRANSACTION_ID);

		$criteria->addSelectColumn(ApiTransactionPeer::ACCESS_IP);

		$criteria->addSelectColumn(ApiTransactionPeer::USER_ID);

		$criteria->addSelectColumn(ApiTransactionPeer::TRANSACTION_ACTION);

		$criteria->addSelectColumn(ApiTransactionPeer::TRANSACTION_DATA);

		$criteria->addSelectColumn(ApiTransactionPeer::REMARK);

		$criteria->addSelectColumn(ApiTransactionPeer::STATUS_CODE);

		$criteria->addSelectColumn(ApiTransactionPeer::TOKEN);

		$criteria->addSelectColumn(ApiTransactionPeer::CREATED_BY);

		$criteria->addSelectColumn(ApiTransactionPeer::CREATED_ON);

		$criteria->addSelectColumn(ApiTransactionPeer::UPDATED_BY);

		$criteria->addSelectColumn(ApiTransactionPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(api_transaction.TRANSACTION_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT api_transaction.TRANSACTION_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ApiTransactionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ApiTransactionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ApiTransactionPeer::doSelectRS($criteria, $con);
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
		$objects = ApiTransactionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ApiTransactionPeer::populateObjects(ApiTransactionPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ApiTransactionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ApiTransactionPeer::getOMClass();
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
		return ApiTransactionPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ApiTransactionPeer::TRANSACTION_ID); 

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
			$comparison = $criteria->getComparison(ApiTransactionPeer::TRANSACTION_ID);
			$selectCriteria->add(ApiTransactionPeer::TRANSACTION_ID, $criteria->remove(ApiTransactionPeer::TRANSACTION_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ApiTransactionPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ApiTransactionPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ApiTransaction) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ApiTransactionPeer::TRANSACTION_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ApiTransaction $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ApiTransactionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ApiTransactionPeer::TABLE_NAME);

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

		return BasePeer::doValidate(ApiTransactionPeer::DATABASE_NAME, ApiTransactionPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ApiTransactionPeer::DATABASE_NAME);

		$criteria->add(ApiTransactionPeer::TRANSACTION_ID, $pk);


		$v = ApiTransactionPeer::doSelect($criteria, $con);

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
			$criteria->add(ApiTransactionPeer::TRANSACTION_ID, $pks, Criteria::IN);
			$objs = ApiTransactionPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseApiTransactionPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ApiTransactionMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ApiTransactionMapBuilder');
}
