<?php


abstract class BaseMlmEsharePriceSettingPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_eshare_price_setting';

	
	const CLASS_DEFAULT = 'lib.model.MlmEsharePriceSetting';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const SETTING_ID = 'mlm_eshare_price_setting.SETTING_ID';

	
	const SHARE_VALUE = 'mlm_eshare_price_setting.SHARE_VALUE';

	
	const VOLUME = 'mlm_eshare_price_setting.VOLUME';

	
	const STATUS_CODE = 'mlm_eshare_price_setting.STATUS_CODE';

	
	const CREATED_BY = 'mlm_eshare_price_setting.CREATED_BY';

	
	const CREATED_ON = 'mlm_eshare_price_setting.CREATED_ON';

	
	const UPDATED_BY = 'mlm_eshare_price_setting.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_eshare_price_setting.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('SettingId', 'ShareValue', 'Volume', 'StatusCode', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MlmEsharePriceSettingPeer::SETTING_ID, MlmEsharePriceSettingPeer::SHARE_VALUE, MlmEsharePriceSettingPeer::VOLUME, MlmEsharePriceSettingPeer::STATUS_CODE, MlmEsharePriceSettingPeer::CREATED_BY, MlmEsharePriceSettingPeer::CREATED_ON, MlmEsharePriceSettingPeer::UPDATED_BY, MlmEsharePriceSettingPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('setting_id', 'share_value', 'volume', 'status_code', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('SettingId' => 0, 'ShareValue' => 1, 'Volume' => 2, 'StatusCode' => 3, 'CreatedBy' => 4, 'CreatedOn' => 5, 'UpdatedBy' => 6, 'UpdatedOn' => 7, ),
		BasePeer::TYPE_COLNAME => array (MlmEsharePriceSettingPeer::SETTING_ID => 0, MlmEsharePriceSettingPeer::SHARE_VALUE => 1, MlmEsharePriceSettingPeer::VOLUME => 2, MlmEsharePriceSettingPeer::STATUS_CODE => 3, MlmEsharePriceSettingPeer::CREATED_BY => 4, MlmEsharePriceSettingPeer::CREATED_ON => 5, MlmEsharePriceSettingPeer::UPDATED_BY => 6, MlmEsharePriceSettingPeer::UPDATED_ON => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('setting_id' => 0, 'share_value' => 1, 'volume' => 2, 'status_code' => 3, 'created_by' => 4, 'created_on' => 5, 'updated_by' => 6, 'updated_on' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmEsharePriceSettingMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmEsharePriceSettingMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmEsharePriceSettingPeer::getTableMap();
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
		return str_replace(MlmEsharePriceSettingPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::SETTING_ID);

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::SHARE_VALUE);

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::VOLUME);

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::STATUS_CODE);

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::CREATED_BY);

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::CREATED_ON);

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmEsharePriceSettingPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(mlm_eshare_price_setting.SETTING_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_eshare_price_setting.SETTING_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		
		$criteria = clone $criteria;

		
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmEsharePriceSettingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmEsharePriceSettingPeer::COUNT);
		}

		
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmEsharePriceSettingPeer::doSelectRS($criteria, $con);
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
		$objects = MlmEsharePriceSettingPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmEsharePriceSettingPeer::populateObjects(MlmEsharePriceSettingPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmEsharePriceSettingPeer::addSelectColumns($criteria);
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		
		
		return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
		
		$cls = MlmEsharePriceSettingPeer::getOMClass();
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
		return MlmEsharePriceSettingPeer::CLASS_DEFAULT;
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

		$criteria->remove(MlmEsharePriceSettingPeer::SETTING_ID); 


		
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

			$comparison = $criteria->getComparison(MlmEsharePriceSettingPeer::SETTING_ID);
			$selectCriteria->add(MlmEsharePriceSettingPeer::SETTING_ID, $criteria->remove(MlmEsharePriceSettingPeer::SETTING_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MlmEsharePriceSettingPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MlmEsharePriceSettingPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
		} elseif ($values instanceof MlmEsharePriceSetting) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmEsharePriceSettingPeer::SETTING_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MlmEsharePriceSetting $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmEsharePriceSettingPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmEsharePriceSettingPeer::TABLE_NAME);

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

		return BasePeer::doValidate(MlmEsharePriceSettingPeer::DATABASE_NAME, MlmEsharePriceSettingPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmEsharePriceSettingPeer::DATABASE_NAME);

		$criteria->add(MlmEsharePriceSettingPeer::SETTING_ID, $pk);


		$v = MlmEsharePriceSettingPeer::doSelect($criteria, $con);

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
			$criteria->add(MlmEsharePriceSettingPeer::SETTING_ID, $pks, Criteria::IN);
			$objs = MlmEsharePriceSettingPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 


if (Propel::isInit()) {
	
	
	try {
		BaseMlmEsharePriceSettingPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	
	
	require_once 'lib/model/map/MlmEsharePriceSettingMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmEsharePriceSettingMapBuilder');
}
