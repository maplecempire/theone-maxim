<?php


abstract class BaseMlmAccountPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_account';

	
	const CLASS_DEFAULT = 'lib.model.MlmAccount';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ACCOUNT_ID = 'mlm_account.ACCOUNT_ID';

	
	const DIST_ID = 'mlm_account.DIST_ID';

	
	const ACCOUNT_TYPE = 'mlm_account.ACCOUNT_TYPE';

	
	const BALANCE = 'mlm_account.BALANCE';

	
	const CREATED_BY = 'mlm_account.CREATED_BY';

	
	const CREATED_ON = 'mlm_account.CREATED_ON';

	
	const UPDATED_BY = 'mlm_account.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_account.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('AccountId', 'DistId', 'AccountType', 'Balance', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MlmAccountPeer::ACCOUNT_ID, MlmAccountPeer::DIST_ID, MlmAccountPeer::ACCOUNT_TYPE, MlmAccountPeer::BALANCE, MlmAccountPeer::CREATED_BY, MlmAccountPeer::CREATED_ON, MlmAccountPeer::UPDATED_BY, MlmAccountPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('account_id', 'dist_id', 'account_type', 'balance', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('AccountId' => 0, 'DistId' => 1, 'AccountType' => 2, 'Balance' => 3, 'CreatedBy' => 4, 'CreatedOn' => 5, 'UpdatedBy' => 6, 'UpdatedOn' => 7, ),
		BasePeer::TYPE_COLNAME => array (MlmAccountPeer::ACCOUNT_ID => 0, MlmAccountPeer::DIST_ID => 1, MlmAccountPeer::ACCOUNT_TYPE => 2, MlmAccountPeer::BALANCE => 3, MlmAccountPeer::CREATED_BY => 4, MlmAccountPeer::CREATED_ON => 5, MlmAccountPeer::UPDATED_BY => 6, MlmAccountPeer::UPDATED_ON => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('account_id' => 0, 'dist_id' => 1, 'account_type' => 2, 'balance' => 3, 'created_by' => 4, 'created_on' => 5, 'updated_by' => 6, 'updated_on' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmAccountMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmAccountMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmAccountPeer::getTableMap();
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
		return str_replace(MlmAccountPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmAccountPeer::ACCOUNT_ID);

		$criteria->addSelectColumn(MlmAccountPeer::DIST_ID);

		$criteria->addSelectColumn(MlmAccountPeer::ACCOUNT_TYPE);

		$criteria->addSelectColumn(MlmAccountPeer::BALANCE);

		$criteria->addSelectColumn(MlmAccountPeer::CREATED_BY);

		$criteria->addSelectColumn(MlmAccountPeer::CREATED_ON);

		$criteria->addSelectColumn(MlmAccountPeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmAccountPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(mlm_account.ACCOUNT_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_account.ACCOUNT_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		
		$criteria = clone $criteria;

		
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmAccountPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmAccountPeer::COUNT);
		}

		
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmAccountPeer::doSelectRS($criteria, $con);
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
		$objects = MlmAccountPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmAccountPeer::populateObjects(MlmAccountPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmAccountPeer::addSelectColumns($criteria);
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		
		
		return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
		
		$cls = MlmAccountPeer::getOMClass();
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
		return MlmAccountPeer::CLASS_DEFAULT;
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

		$criteria->remove(MlmAccountPeer::ACCOUNT_ID); 


		
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

			$comparison = $criteria->getComparison(MlmAccountPeer::ACCOUNT_ID);
			$selectCriteria->add(MlmAccountPeer::ACCOUNT_ID, $criteria->remove(MlmAccountPeer::ACCOUNT_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MlmAccountPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MlmAccountPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
		} elseif ($values instanceof MlmAccount) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmAccountPeer::ACCOUNT_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MlmAccount $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmAccountPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmAccountPeer::TABLE_NAME);

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

		return BasePeer::doValidate(MlmAccountPeer::DATABASE_NAME, MlmAccountPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmAccountPeer::DATABASE_NAME);

		$criteria->add(MlmAccountPeer::ACCOUNT_ID, $pk);


		$v = MlmAccountPeer::doSelect($criteria, $con);

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
			$criteria->add(MlmAccountPeer::ACCOUNT_ID, $pks, Criteria::IN);
			$objs = MlmAccountPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 


if (Propel::isInit()) {
	
	
	try {
		BaseMlmAccountPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	
	
	require_once 'lib/model/map/MlmAccountMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmAccountMapBuilder');
}
