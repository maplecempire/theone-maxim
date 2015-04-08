<?php


abstract class BaseGgMemberRpfwalletRecordPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'gg_member_rpfwallet_record';

	
	const CLASS_DEFAULT = 'lib.model.GgMemberRpfwalletRecord';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'gg_member_rpfwallet_record.ID';

	
	const UID = 'gg_member_rpfwallet_record.UID';

	
	const AID = 'gg_member_rpfwallet_record.AID';

	
	const ACTION_TYPE = 'gg_member_rpfwallet_record.ACTION_TYPE';

	
	const TYPE = 'gg_member_rpfwallet_record.TYPE';

	
	const AMOUNT = 'gg_member_rpfwallet_record.AMOUNT';

	
	const BAL = 'gg_member_rpfwallet_record.BAL';

	
	const DESCR = 'gg_member_rpfwallet_record.DESCR';

	
	const CDATE = 'gg_member_rpfwallet_record.CDATE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Uid', 'Aid', 'ActionType', 'Type', 'Amount', 'Bal', 'Descr', 'Cdate', ),
		BasePeer::TYPE_COLNAME => array (GgMemberRpfwalletRecordPeer::ID, GgMemberRpfwalletRecordPeer::UID, GgMemberRpfwalletRecordPeer::AID, GgMemberRpfwalletRecordPeer::ACTION_TYPE, GgMemberRpfwalletRecordPeer::TYPE, GgMemberRpfwalletRecordPeer::AMOUNT, GgMemberRpfwalletRecordPeer::BAL, GgMemberRpfwalletRecordPeer::DESCR, GgMemberRpfwalletRecordPeer::CDATE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'uid', 'aid', 'action_type', 'type', 'amount', 'bal', 'descr', 'cdate', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Uid' => 1, 'Aid' => 2, 'ActionType' => 3, 'Type' => 4, 'Amount' => 5, 'Bal' => 6, 'Descr' => 7, 'Cdate' => 8, ),
		BasePeer::TYPE_COLNAME => array (GgMemberRpfwalletRecordPeer::ID => 0, GgMemberRpfwalletRecordPeer::UID => 1, GgMemberRpfwalletRecordPeer::AID => 2, GgMemberRpfwalletRecordPeer::ACTION_TYPE => 3, GgMemberRpfwalletRecordPeer::TYPE => 4, GgMemberRpfwalletRecordPeer::AMOUNT => 5, GgMemberRpfwalletRecordPeer::BAL => 6, GgMemberRpfwalletRecordPeer::DESCR => 7, GgMemberRpfwalletRecordPeer::CDATE => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'uid' => 1, 'aid' => 2, 'action_type' => 3, 'type' => 4, 'amount' => 5, 'bal' => 6, 'descr' => 7, 'cdate' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/GgMemberRpfwalletRecordMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.GgMemberRpfwalletRecordMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = GgMemberRpfwalletRecordPeer::getTableMap();
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
		return str_replace(GgMemberRpfwalletRecordPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::ID);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::UID);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::AID);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::ACTION_TYPE);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::TYPE);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::AMOUNT);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::BAL);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::DESCR);

		$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::CDATE);

	}

	const COUNT = 'COUNT(gg_member_rpfwallet_record.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT gg_member_rpfwallet_record.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GgMemberRpfwalletRecordPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = GgMemberRpfwalletRecordPeer::doSelectRS($criteria, $con);
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
		$objects = GgMemberRpfwalletRecordPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return GgMemberRpfwalletRecordPeer::populateObjects(GgMemberRpfwalletRecordPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			GgMemberRpfwalletRecordPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = GgMemberRpfwalletRecordPeer::getOMClass();
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
		return GgMemberRpfwalletRecordPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(GgMemberRpfwalletRecordPeer::ID); 

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
			$comparison = $criteria->getComparison(GgMemberRpfwalletRecordPeer::ID);
			$selectCriteria->add(GgMemberRpfwalletRecordPeer::ID, $criteria->remove(GgMemberRpfwalletRecordPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(GgMemberRpfwalletRecordPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(GgMemberRpfwalletRecordPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof GgMemberRpfwalletRecord) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(GgMemberRpfwalletRecordPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(GgMemberRpfwalletRecord $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(GgMemberRpfwalletRecordPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(GgMemberRpfwalletRecordPeer::TABLE_NAME);

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

		return BasePeer::doValidate(GgMemberRpfwalletRecordPeer::DATABASE_NAME, GgMemberRpfwalletRecordPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(GgMemberRpfwalletRecordPeer::DATABASE_NAME);

		$criteria->add(GgMemberRpfwalletRecordPeer::ID, $pk);


		$v = GgMemberRpfwalletRecordPeer::doSelect($criteria, $con);

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
			$criteria->add(GgMemberRpfwalletRecordPeer::ID, $pks, Criteria::IN);
			$objs = GgMemberRpfwalletRecordPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseGgMemberRpfwalletRecordPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/GgMemberRpfwalletRecordMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.GgMemberRpfwalletRecordMapBuilder');
}
