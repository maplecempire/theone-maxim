<?php


abstract class BaseMlmMt4DemoRequestPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_mt4_demo_request';

	
	const CLASS_DEFAULT = 'lib.model.MlmMt4DemoRequest';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const REQUEST_ID = 'mlm_mt4_demo_request.REQUEST_ID';

	
	const FULL_NAME = 'mlm_mt4_demo_request.FULL_NAME';

	
	const EMAIL = 'mlm_mt4_demo_request.EMAIL';

	
	const STATUS_CODE = 'mlm_mt4_demo_request.STATUS_CODE';

	
	const CREATED_BY = 'mlm_mt4_demo_request.CREATED_BY';

	
	const CREATED_ON = 'mlm_mt4_demo_request.CREATED_ON';

	
	const UPDATED_BY = 'mlm_mt4_demo_request.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_mt4_demo_request.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('RequestId', 'FullName', 'Email', 'StatusCode', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MlmMt4DemoRequestPeer::REQUEST_ID, MlmMt4DemoRequestPeer::FULL_NAME, MlmMt4DemoRequestPeer::EMAIL, MlmMt4DemoRequestPeer::STATUS_CODE, MlmMt4DemoRequestPeer::CREATED_BY, MlmMt4DemoRequestPeer::CREATED_ON, MlmMt4DemoRequestPeer::UPDATED_BY, MlmMt4DemoRequestPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('request_id', 'full_name', 'email', 'status_code', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('RequestId' => 0, 'FullName' => 1, 'Email' => 2, 'StatusCode' => 3, 'CreatedBy' => 4, 'CreatedOn' => 5, 'UpdatedBy' => 6, 'UpdatedOn' => 7, ),
		BasePeer::TYPE_COLNAME => array (MlmMt4DemoRequestPeer::REQUEST_ID => 0, MlmMt4DemoRequestPeer::FULL_NAME => 1, MlmMt4DemoRequestPeer::EMAIL => 2, MlmMt4DemoRequestPeer::STATUS_CODE => 3, MlmMt4DemoRequestPeer::CREATED_BY => 4, MlmMt4DemoRequestPeer::CREATED_ON => 5, MlmMt4DemoRequestPeer::UPDATED_BY => 6, MlmMt4DemoRequestPeer::UPDATED_ON => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('request_id' => 0, 'full_name' => 1, 'email' => 2, 'status_code' => 3, 'created_by' => 4, 'created_on' => 5, 'updated_by' => 6, 'updated_on' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmMt4DemoRequestMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmMt4DemoRequestMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmMt4DemoRequestPeer::getTableMap();
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
		return str_replace(MlmMt4DemoRequestPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::REQUEST_ID);

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::FULL_NAME);

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::EMAIL);

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::STATUS_CODE);

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::CREATED_BY);

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::CREATED_ON);

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmMt4DemoRequestPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(mlm_mt4_demo_request.REQUEST_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_mt4_demo_request.REQUEST_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		
		$criteria = clone $criteria;

		
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmMt4DemoRequestPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmMt4DemoRequestPeer::COUNT);
		}

		
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmMt4DemoRequestPeer::doSelectRS($criteria, $con);
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
		$objects = MlmMt4DemoRequestPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmMt4DemoRequestPeer::populateObjects(MlmMt4DemoRequestPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmMt4DemoRequestPeer::addSelectColumns($criteria);
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		
		
		return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
		
		$cls = MlmMt4DemoRequestPeer::getOMClass();
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
		return MlmMt4DemoRequestPeer::CLASS_DEFAULT;
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

		$criteria->remove(MlmMt4DemoRequestPeer::REQUEST_ID); 


		
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

			$comparison = $criteria->getComparison(MlmMt4DemoRequestPeer::REQUEST_ID);
			$selectCriteria->add(MlmMt4DemoRequestPeer::REQUEST_ID, $criteria->remove(MlmMt4DemoRequestPeer::REQUEST_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MlmMt4DemoRequestPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MlmMt4DemoRequestPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
		} elseif ($values instanceof MlmMt4DemoRequest) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmMt4DemoRequestPeer::REQUEST_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MlmMt4DemoRequest $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmMt4DemoRequestPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmMt4DemoRequestPeer::TABLE_NAME);

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

		return BasePeer::doValidate(MlmMt4DemoRequestPeer::DATABASE_NAME, MlmMt4DemoRequestPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmMt4DemoRequestPeer::DATABASE_NAME);

		$criteria->add(MlmMt4DemoRequestPeer::REQUEST_ID, $pk);


		$v = MlmMt4DemoRequestPeer::doSelect($criteria, $con);

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
			$criteria->add(MlmMt4DemoRequestPeer::REQUEST_ID, $pks, Criteria::IN);
			$objs = MlmMt4DemoRequestPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 


if (Propel::isInit()) {
	
	
	try {
		BaseMlmMt4DemoRequestPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	
	
	require_once 'lib/model/map/MlmMt4DemoRequestMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmMt4DemoRequestMapBuilder');
}
