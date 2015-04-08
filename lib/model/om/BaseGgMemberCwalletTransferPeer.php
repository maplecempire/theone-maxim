<?php


abstract class BaseGgMemberCwalletTransferPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'gg_member_cwallet_transfer';

	
	const CLASS_DEFAULT = 'lib.model.GgMemberCwalletTransfer';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'gg_member_cwallet_transfer.ID';

	
	const FROM_UID = 'gg_member_cwallet_transfer.FROM_UID';

	
	const TO_UID = 'gg_member_cwallet_transfer.TO_UID';

	
	const AMOUNT = 'gg_member_cwallet_transfer.AMOUNT';

	
	const REMARK = 'gg_member_cwallet_transfer.REMARK';

	
	const CDATE = 'gg_member_cwallet_transfer.CDATE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'FromUid', 'ToUid', 'Amount', 'Remark', 'Cdate', ),
		BasePeer::TYPE_COLNAME => array (GgMemberCwalletTransferPeer::ID, GgMemberCwalletTransferPeer::FROM_UID, GgMemberCwalletTransferPeer::TO_UID, GgMemberCwalletTransferPeer::AMOUNT, GgMemberCwalletTransferPeer::REMARK, GgMemberCwalletTransferPeer::CDATE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'from_uid', 'to_uid', 'amount', 'remark', 'cdate', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'FromUid' => 1, 'ToUid' => 2, 'Amount' => 3, 'Remark' => 4, 'Cdate' => 5, ),
		BasePeer::TYPE_COLNAME => array (GgMemberCwalletTransferPeer::ID => 0, GgMemberCwalletTransferPeer::FROM_UID => 1, GgMemberCwalletTransferPeer::TO_UID => 2, GgMemberCwalletTransferPeer::AMOUNT => 3, GgMemberCwalletTransferPeer::REMARK => 4, GgMemberCwalletTransferPeer::CDATE => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'from_uid' => 1, 'to_uid' => 2, 'amount' => 3, 'remark' => 4, 'cdate' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/GgMemberCwalletTransferMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.GgMemberCwalletTransferMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = GgMemberCwalletTransferPeer::getTableMap();
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
		return str_replace(GgMemberCwalletTransferPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(GgMemberCwalletTransferPeer::ID);

		$criteria->addSelectColumn(GgMemberCwalletTransferPeer::FROM_UID);

		$criteria->addSelectColumn(GgMemberCwalletTransferPeer::TO_UID);

		$criteria->addSelectColumn(GgMemberCwalletTransferPeer::AMOUNT);

		$criteria->addSelectColumn(GgMemberCwalletTransferPeer::REMARK);

		$criteria->addSelectColumn(GgMemberCwalletTransferPeer::CDATE);

	}

	const COUNT = 'COUNT(gg_member_cwallet_transfer.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT gg_member_cwallet_transfer.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(GgMemberCwalletTransferPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GgMemberCwalletTransferPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = GgMemberCwalletTransferPeer::doSelectRS($criteria, $con);
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
		$objects = GgMemberCwalletTransferPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return GgMemberCwalletTransferPeer::populateObjects(GgMemberCwalletTransferPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			GgMemberCwalletTransferPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = GgMemberCwalletTransferPeer::getOMClass();
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
		return GgMemberCwalletTransferPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(GgMemberCwalletTransferPeer::ID); 

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
			$comparison = $criteria->getComparison(GgMemberCwalletTransferPeer::ID);
			$selectCriteria->add(GgMemberCwalletTransferPeer::ID, $criteria->remove(GgMemberCwalletTransferPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(GgMemberCwalletTransferPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(GgMemberCwalletTransferPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof GgMemberCwalletTransfer) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(GgMemberCwalletTransferPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(GgMemberCwalletTransfer $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(GgMemberCwalletTransferPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(GgMemberCwalletTransferPeer::TABLE_NAME);

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

		return BasePeer::doValidate(GgMemberCwalletTransferPeer::DATABASE_NAME, GgMemberCwalletTransferPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(GgMemberCwalletTransferPeer::DATABASE_NAME);

		$criteria->add(GgMemberCwalletTransferPeer::ID, $pk);


		$v = GgMemberCwalletTransferPeer::doSelect($criteria, $con);

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
			$criteria->add(GgMemberCwalletTransferPeer::ID, $pks, Criteria::IN);
			$objs = GgMemberCwalletTransferPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseGgMemberCwalletTransferPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/GgMemberCwalletTransferMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.GgMemberCwalletTransferMapBuilder');
}
