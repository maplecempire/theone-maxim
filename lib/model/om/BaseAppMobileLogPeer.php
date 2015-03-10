<?php


abstract class BaseAppMobileLogPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'app_mobile_log';

	
	const CLASS_DEFAULT = 'lib.model.AppMobileLog';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const LOG_ID = 'app_mobile_log.LOG_ID';

	
	const ACCESS_IP = 'app_mobile_log.ACCESS_IP';

	
	const USER_ID = 'app_mobile_log.USER_ID';

	
	const TRANS_ACTION = 'app_mobile_log.TRANS_ACTION';

	
	const TRANS_DATA = 'app_mobile_log.TRANS_DATA';

	
	const REMARK = 'app_mobile_log.REMARK';

	
	const CREATED_BY = 'app_mobile_log.CREATED_BY';

	
	const CREATED_ON = 'app_mobile_log.CREATED_ON';

	
	const UPDATED_BY = 'app_mobile_log.UPDATED_BY';

	
	const UPDATED_ON = 'app_mobile_log.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('LogId', 'AccessIp', 'UserId', 'TransAction', 'TransData', 'Remark', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (AppMobileLogPeer::LOG_ID, AppMobileLogPeer::ACCESS_IP, AppMobileLogPeer::USER_ID, AppMobileLogPeer::TRANS_ACTION, AppMobileLogPeer::TRANS_DATA, AppMobileLogPeer::REMARK, AppMobileLogPeer::CREATED_BY, AppMobileLogPeer::CREATED_ON, AppMobileLogPeer::UPDATED_BY, AppMobileLogPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('log_id', 'access_ip', 'user_id', 'trans_action', 'trans_data', 'remark', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('LogId' => 0, 'AccessIp' => 1, 'UserId' => 2, 'TransAction' => 3, 'TransData' => 4, 'Remark' => 5, 'CreatedBy' => 6, 'CreatedOn' => 7, 'UpdatedBy' => 8, 'UpdatedOn' => 9, ),
		BasePeer::TYPE_COLNAME => array (AppMobileLogPeer::LOG_ID => 0, AppMobileLogPeer::ACCESS_IP => 1, AppMobileLogPeer::USER_ID => 2, AppMobileLogPeer::TRANS_ACTION => 3, AppMobileLogPeer::TRANS_DATA => 4, AppMobileLogPeer::REMARK => 5, AppMobileLogPeer::CREATED_BY => 6, AppMobileLogPeer::CREATED_ON => 7, AppMobileLogPeer::UPDATED_BY => 8, AppMobileLogPeer::UPDATED_ON => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('log_id' => 0, 'access_ip' => 1, 'user_id' => 2, 'trans_action' => 3, 'trans_data' => 4, 'remark' => 5, 'created_by' => 6, 'created_on' => 7, 'updated_by' => 8, 'updated_on' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AppMobileLogMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AppMobileLogMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AppMobileLogPeer::getTableMap();
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
		return str_replace(AppMobileLogPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AppMobileLogPeer::LOG_ID);

		$criteria->addSelectColumn(AppMobileLogPeer::ACCESS_IP);

		$criteria->addSelectColumn(AppMobileLogPeer::USER_ID);

		$criteria->addSelectColumn(AppMobileLogPeer::TRANS_ACTION);

		$criteria->addSelectColumn(AppMobileLogPeer::TRANS_DATA);

		$criteria->addSelectColumn(AppMobileLogPeer::REMARK);

		$criteria->addSelectColumn(AppMobileLogPeer::CREATED_BY);

		$criteria->addSelectColumn(AppMobileLogPeer::CREATED_ON);

		$criteria->addSelectColumn(AppMobileLogPeer::UPDATED_BY);

		$criteria->addSelectColumn(AppMobileLogPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(app_mobile_log.LOG_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT app_mobile_log.LOG_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AppMobileLogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AppMobileLogPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AppMobileLogPeer::doSelectRS($criteria, $con);
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
		$objects = AppMobileLogPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AppMobileLogPeer::populateObjects(AppMobileLogPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AppMobileLogPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = AppMobileLogPeer::getOMClass();
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
		return AppMobileLogPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(AppMobileLogPeer::LOG_ID); 

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
			$comparison = $criteria->getComparison(AppMobileLogPeer::LOG_ID);
			$selectCriteria->add(AppMobileLogPeer::LOG_ID, $criteria->remove(AppMobileLogPeer::LOG_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(AppMobileLogPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AppMobileLogPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof AppMobileLog) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AppMobileLogPeer::LOG_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(AppMobileLog $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AppMobileLogPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AppMobileLogPeer::TABLE_NAME);

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

		return BasePeer::doValidate(AppMobileLogPeer::DATABASE_NAME, AppMobileLogPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(AppMobileLogPeer::DATABASE_NAME);

		$criteria->add(AppMobileLogPeer::LOG_ID, $pk);


		$v = AppMobileLogPeer::doSelect($criteria, $con);

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
			$criteria->add(AppMobileLogPeer::LOG_ID, $pks, Criteria::IN);
			$objs = AppMobileLogPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseAppMobileLogPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/AppMobileLogMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AppMobileLogMapBuilder');
}
