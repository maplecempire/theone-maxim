<?php


abstract class BaseMlmEventCalendarPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_event_calendar';

	
	const CLASS_DEFAULT = 'lib.model.MlmEventCalendar';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'mlm_event_calendar.ID';

	
	const EVENT_TITLE = 'mlm_event_calendar.EVENT_TITLE';

	
	const EVENT_DETAIL = 'mlm_event_calendar.EVENT_DETAIL';

	
	const DATE_START = 'mlm_event_calendar.DATE_START';

	
	const DATE_END = 'mlm_event_calendar.DATE_END';

	
	const ALL_DAY = 'mlm_event_calendar.ALL_DAY';

	
	const CREATED_BY = 'mlm_event_calendar.CREATED_BY';

	
	const CREATED_ON = 'mlm_event_calendar.CREATED_ON';

	
	const UPDATED_BY = 'mlm_event_calendar.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_event_calendar.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'EventTitle', 'EventDetail', 'DateStart', 'DateEnd', 'AllDay', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MlmEventCalendarPeer::ID, MlmEventCalendarPeer::EVENT_TITLE, MlmEventCalendarPeer::EVENT_DETAIL, MlmEventCalendarPeer::DATE_START, MlmEventCalendarPeer::DATE_END, MlmEventCalendarPeer::ALL_DAY, MlmEventCalendarPeer::CREATED_BY, MlmEventCalendarPeer::CREATED_ON, MlmEventCalendarPeer::UPDATED_BY, MlmEventCalendarPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'event_title', 'event_detail', 'date_start', 'date_end', 'all_day', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'EventTitle' => 1, 'EventDetail' => 2, 'DateStart' => 3, 'DateEnd' => 4, 'AllDay' => 5, 'CreatedBy' => 6, 'CreatedOn' => 7, 'UpdatedBy' => 8, 'UpdatedOn' => 9, ),
		BasePeer::TYPE_COLNAME => array (MlmEventCalendarPeer::ID => 0, MlmEventCalendarPeer::EVENT_TITLE => 1, MlmEventCalendarPeer::EVENT_DETAIL => 2, MlmEventCalendarPeer::DATE_START => 3, MlmEventCalendarPeer::DATE_END => 4, MlmEventCalendarPeer::ALL_DAY => 5, MlmEventCalendarPeer::CREATED_BY => 6, MlmEventCalendarPeer::CREATED_ON => 7, MlmEventCalendarPeer::UPDATED_BY => 8, MlmEventCalendarPeer::UPDATED_ON => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'event_title' => 1, 'event_detail' => 2, 'date_start' => 3, 'date_end' => 4, 'all_day' => 5, 'created_by' => 6, 'created_on' => 7, 'updated_by' => 8, 'updated_on' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmEventCalendarMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmEventCalendarMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmEventCalendarPeer::getTableMap();
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
		return str_replace(MlmEventCalendarPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmEventCalendarPeer::ID);

		$criteria->addSelectColumn(MlmEventCalendarPeer::EVENT_TITLE);

		$criteria->addSelectColumn(MlmEventCalendarPeer::EVENT_DETAIL);

		$criteria->addSelectColumn(MlmEventCalendarPeer::DATE_START);

		$criteria->addSelectColumn(MlmEventCalendarPeer::DATE_END);

		$criteria->addSelectColumn(MlmEventCalendarPeer::ALL_DAY);

		$criteria->addSelectColumn(MlmEventCalendarPeer::CREATED_BY);

		$criteria->addSelectColumn(MlmEventCalendarPeer::CREATED_ON);

		$criteria->addSelectColumn(MlmEventCalendarPeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmEventCalendarPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(mlm_event_calendar.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_event_calendar.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmEventCalendarPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmEventCalendarPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmEventCalendarPeer::doSelectRS($criteria, $con);
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
		$objects = MlmEventCalendarPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmEventCalendarPeer::populateObjects(MlmEventCalendarPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmEventCalendarPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MlmEventCalendarPeer::getOMClass();
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
		return MlmEventCalendarPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(MlmEventCalendarPeer::ID); 

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
			$comparison = $criteria->getComparison(MlmEventCalendarPeer::ID);
			$selectCriteria->add(MlmEventCalendarPeer::ID, $criteria->remove(MlmEventCalendarPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MlmEventCalendarPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MlmEventCalendarPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MlmEventCalendar) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmEventCalendarPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MlmEventCalendar $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmEventCalendarPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmEventCalendarPeer::TABLE_NAME);

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

		return BasePeer::doValidate(MlmEventCalendarPeer::DATABASE_NAME, MlmEventCalendarPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmEventCalendarPeer::DATABASE_NAME);

		$criteria->add(MlmEventCalendarPeer::ID, $pk);


		$v = MlmEventCalendarPeer::doSelect($criteria, $con);

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
			$criteria->add(MlmEventCalendarPeer::ID, $pks, Criteria::IN);
			$objs = MlmEventCalendarPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMlmEventCalendarPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MlmEventCalendarMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmEventCalendarMapBuilder');
}
