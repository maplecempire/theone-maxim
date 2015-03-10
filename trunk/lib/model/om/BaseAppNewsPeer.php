<?php


abstract class BaseAppNewsPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'app_news';

	
	const CLASS_DEFAULT = 'lib.model.AppNews';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'app_news.ID';

	
	const NS_TITLE = 'app_news.NS_TITLE';

	
	const NS_CONTENT = 'app_news.NS_CONTENT';

	
	const NS_STATUS = 'app_news.NS_STATUS';

	
	const NS_START_DATE = 'app_news.NS_START_DATE';

	
	const NS_END_DATE = 'app_news.NS_END_DATE';

	
	const CREATED_ON = 'app_news.CREATED_ON';

	
	const CREATED_BY = 'app_news.CREATED_BY';

	
	const UPDATED_ON = 'app_news.UPDATED_ON';

	
	const UPDATED_BY = 'app_news.UPDATED_BY';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'NsTitle', 'NsContent', 'NsStatus', 'NsStartDate', 'NsEndDate', 'CreatedOn', 'CreatedBy', 'UpdatedOn', 'UpdatedBy', ),
		BasePeer::TYPE_COLNAME => array (AppNewsPeer::ID, AppNewsPeer::NS_TITLE, AppNewsPeer::NS_CONTENT, AppNewsPeer::NS_STATUS, AppNewsPeer::NS_START_DATE, AppNewsPeer::NS_END_DATE, AppNewsPeer::CREATED_ON, AppNewsPeer::CREATED_BY, AppNewsPeer::UPDATED_ON, AppNewsPeer::UPDATED_BY, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'ns_title', 'ns_content', 'ns_status', 'ns_start_date', 'ns_end_date', 'created_on', 'created_by', 'updated_on', 'updated_by', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'NsTitle' => 1, 'NsContent' => 2, 'NsStatus' => 3, 'NsStartDate' => 4, 'NsEndDate' => 5, 'CreatedOn' => 6, 'CreatedBy' => 7, 'UpdatedOn' => 8, 'UpdatedBy' => 9, ),
		BasePeer::TYPE_COLNAME => array (AppNewsPeer::ID => 0, AppNewsPeer::NS_TITLE => 1, AppNewsPeer::NS_CONTENT => 2, AppNewsPeer::NS_STATUS => 3, AppNewsPeer::NS_START_DATE => 4, AppNewsPeer::NS_END_DATE => 5, AppNewsPeer::CREATED_ON => 6, AppNewsPeer::CREATED_BY => 7, AppNewsPeer::UPDATED_ON => 8, AppNewsPeer::UPDATED_BY => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ns_title' => 1, 'ns_content' => 2, 'ns_status' => 3, 'ns_start_date' => 4, 'ns_end_date' => 5, 'created_on' => 6, 'created_by' => 7, 'updated_on' => 8, 'updated_by' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AppNewsMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AppNewsMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AppNewsPeer::getTableMap();
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
		return str_replace(AppNewsPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AppNewsPeer::ID);

		$criteria->addSelectColumn(AppNewsPeer::NS_TITLE);

		$criteria->addSelectColumn(AppNewsPeer::NS_CONTENT);

		$criteria->addSelectColumn(AppNewsPeer::NS_STATUS);

		$criteria->addSelectColumn(AppNewsPeer::NS_START_DATE);

		$criteria->addSelectColumn(AppNewsPeer::NS_END_DATE);

		$criteria->addSelectColumn(AppNewsPeer::CREATED_ON);

		$criteria->addSelectColumn(AppNewsPeer::CREATED_BY);

		$criteria->addSelectColumn(AppNewsPeer::UPDATED_ON);

		$criteria->addSelectColumn(AppNewsPeer::UPDATED_BY);

	}

	const COUNT = 'COUNT(app_news.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT app_news.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AppNewsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AppNewsPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AppNewsPeer::doSelectRS($criteria, $con);
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
		$objects = AppNewsPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AppNewsPeer::populateObjects(AppNewsPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AppNewsPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = AppNewsPeer::getOMClass();
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
		return AppNewsPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(AppNewsPeer::ID); 

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
			$comparison = $criteria->getComparison(AppNewsPeer::ID);
			$selectCriteria->add(AppNewsPeer::ID, $criteria->remove(AppNewsPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(AppNewsPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AppNewsPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof AppNews) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AppNewsPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(AppNews $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AppNewsPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AppNewsPeer::TABLE_NAME);

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

		return BasePeer::doValidate(AppNewsPeer::DATABASE_NAME, AppNewsPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(AppNewsPeer::DATABASE_NAME);

		$criteria->add(AppNewsPeer::ID, $pk);


		$v = AppNewsPeer::doSelect($criteria, $con);

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
			$criteria->add(AppNewsPeer::ID, $pks, Criteria::IN);
			$objs = AppNewsPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseAppNewsPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/AppNewsMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AppNewsMapBuilder');
}
