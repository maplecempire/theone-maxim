<?php


abstract class BaseAppUserPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'app_user';

	
	const CLASS_DEFAULT = 'lib.model.AppUser';

	
	const NUM_COLUMNS = 15;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const USER_ID = 'app_user.USER_ID';

	
	const USERNAME = 'app_user.USERNAME';

	
	const KEEP_PASSWORD = 'app_user.KEEP_PASSWORD';

	
	const USERPASSWORD = 'app_user.USERPASSWORD';

	
	const KEEP_PASSWORD2 = 'app_user.KEEP_PASSWORD2';

	
	const USERPASSWORD2 = 'app_user.USERPASSWORD2';

	
	const USER_ROLE = 'app_user.USER_ROLE';

	
	const STATUS_CODE = 'app_user.STATUS_CODE';

	
	const LAST_LOGIN_DATETIME = 'app_user.LAST_LOGIN_DATETIME';

	
	const CREATED_BY = 'app_user.CREATED_BY';

	
	const CREATED_ON = 'app_user.CREATED_ON';

	
	const UPDATED_BY = 'app_user.UPDATED_BY';

	
	const UPDATED_ON = 'app_user.UPDATED_ON';

	
	const FROM_ABFX = 'app_user.FROM_ABFX';

	
	const REMARK = 'app_user.REMARK';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('UserId', 'Username', 'KeepPassword', 'Userpassword', 'KeepPassword2', 'Userpassword2', 'UserRole', 'StatusCode', 'LastLoginDatetime', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', 'FromAbfx', 'Remark', ),
		BasePeer::TYPE_COLNAME => array (AppUserPeer::USER_ID, AppUserPeer::USERNAME, AppUserPeer::KEEP_PASSWORD, AppUserPeer::USERPASSWORD, AppUserPeer::KEEP_PASSWORD2, AppUserPeer::USERPASSWORD2, AppUserPeer::USER_ROLE, AppUserPeer::STATUS_CODE, AppUserPeer::LAST_LOGIN_DATETIME, AppUserPeer::CREATED_BY, AppUserPeer::CREATED_ON, AppUserPeer::UPDATED_BY, AppUserPeer::UPDATED_ON, AppUserPeer::FROM_ABFX, AppUserPeer::REMARK, ),
		BasePeer::TYPE_FIELDNAME => array ('user_id', 'username', 'keep_password', 'userpassword', 'keep_password2', 'userpassword2', 'user_role', 'status_code', 'last_login_datetime', 'created_by', 'created_on', 'updated_by', 'updated_on', 'from_abfx', 'remark', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('UserId' => 0, 'Username' => 1, 'KeepPassword' => 2, 'Userpassword' => 3, 'KeepPassword2' => 4, 'Userpassword2' => 5, 'UserRole' => 6, 'StatusCode' => 7, 'LastLoginDatetime' => 8, 'CreatedBy' => 9, 'CreatedOn' => 10, 'UpdatedBy' => 11, 'UpdatedOn' => 12, 'FromAbfx' => 13, 'Remark' => 14, ),
		BasePeer::TYPE_COLNAME => array (AppUserPeer::USER_ID => 0, AppUserPeer::USERNAME => 1, AppUserPeer::KEEP_PASSWORD => 2, AppUserPeer::USERPASSWORD => 3, AppUserPeer::KEEP_PASSWORD2 => 4, AppUserPeer::USERPASSWORD2 => 5, AppUserPeer::USER_ROLE => 6, AppUserPeer::STATUS_CODE => 7, AppUserPeer::LAST_LOGIN_DATETIME => 8, AppUserPeer::CREATED_BY => 9, AppUserPeer::CREATED_ON => 10, AppUserPeer::UPDATED_BY => 11, AppUserPeer::UPDATED_ON => 12, AppUserPeer::FROM_ABFX => 13, AppUserPeer::REMARK => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('user_id' => 0, 'username' => 1, 'keep_password' => 2, 'userpassword' => 3, 'keep_password2' => 4, 'userpassword2' => 5, 'user_role' => 6, 'status_code' => 7, 'last_login_datetime' => 8, 'created_by' => 9, 'created_on' => 10, 'updated_by' => 11, 'updated_on' => 12, 'from_abfx' => 13, 'remark' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/AppUserMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.AppUserMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = AppUserPeer::getTableMap();
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
		return str_replace(AppUserPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AppUserPeer::USER_ID);

		$criteria->addSelectColumn(AppUserPeer::USERNAME);

		$criteria->addSelectColumn(AppUserPeer::KEEP_PASSWORD);

		$criteria->addSelectColumn(AppUserPeer::USERPASSWORD);

		$criteria->addSelectColumn(AppUserPeer::KEEP_PASSWORD2);

		$criteria->addSelectColumn(AppUserPeer::USERPASSWORD2);

		$criteria->addSelectColumn(AppUserPeer::USER_ROLE);

		$criteria->addSelectColumn(AppUserPeer::STATUS_CODE);

		$criteria->addSelectColumn(AppUserPeer::LAST_LOGIN_DATETIME);

		$criteria->addSelectColumn(AppUserPeer::CREATED_BY);

		$criteria->addSelectColumn(AppUserPeer::CREATED_ON);

		$criteria->addSelectColumn(AppUserPeer::UPDATED_BY);

		$criteria->addSelectColumn(AppUserPeer::UPDATED_ON);

		$criteria->addSelectColumn(AppUserPeer::FROM_ABFX);

		$criteria->addSelectColumn(AppUserPeer::REMARK);

	}

	const COUNT = 'COUNT(app_user.USER_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT app_user.USER_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		
		$criteria = clone $criteria;

		
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(AppUserPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AppUserPeer::COUNT);
		}

		
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AppUserPeer::doSelectRS($criteria, $con);
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
		$objects = AppUserPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return AppUserPeer::populateObjects(AppUserPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			AppUserPeer::addSelectColumns($criteria);
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		
		
		return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
		
		$cls = AppUserPeer::getOMClass();
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
		return AppUserPeer::CLASS_DEFAULT;
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

		$criteria->remove(AppUserPeer::USER_ID); 


		
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

			$comparison = $criteria->getComparison(AppUserPeer::USER_ID);
			$selectCriteria->add(AppUserPeer::USER_ID, $criteria->remove(AppUserPeer::USER_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(AppUserPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AppUserPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
		} elseif ($values instanceof AppUser) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AppUserPeer::USER_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(AppUser $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AppUserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AppUserPeer::TABLE_NAME);

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

		return BasePeer::doValidate(AppUserPeer::DATABASE_NAME, AppUserPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(AppUserPeer::DATABASE_NAME);

		$criteria->add(AppUserPeer::USER_ID, $pk);


		$v = AppUserPeer::doSelect($criteria, $con);

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
			$criteria->add(AppUserPeer::USER_ID, $pks, Criteria::IN);
			$objs = AppUserPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 


if (Propel::isInit()) {
	
	
	try {
		BaseAppUserPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	
	
	require_once 'lib/model/map/AppUserMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.AppUserMapBuilder');
}
