<?php


abstract class BaseMlmDistPairingLedger20150131Peer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_dist_pairing_ledger_20150131';

	
	const CLASS_DEFAULT = 'lib.model.MlmDistPairingLedger20150131';

	
	const NUM_COLUMNS = 13;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const PAIRING_ID = 'mlm_dist_pairing_ledger_20150131.PAIRING_ID';

	
	const DIST_ID = 'mlm_dist_pairing_ledger_20150131.DIST_ID';

	
	const LEFT_RIGHT = 'mlm_dist_pairing_ledger_20150131.LEFT_RIGHT';

	
	const TRANSACTION_TYPE = 'mlm_dist_pairing_ledger_20150131.TRANSACTION_TYPE';

	
	const CREDIT = 'mlm_dist_pairing_ledger_20150131.CREDIT';

	
	const CREDIT_ACTUAL = 'mlm_dist_pairing_ledger_20150131.CREDIT_ACTUAL';

	
	const DEBIT = 'mlm_dist_pairing_ledger_20150131.DEBIT';

	
	const BALANCE = 'mlm_dist_pairing_ledger_20150131.BALANCE';

	
	const REMARK = 'mlm_dist_pairing_ledger_20150131.REMARK';

	
	const CREATED_BY = 'mlm_dist_pairing_ledger_20150131.CREATED_BY';

	
	const CREATED_ON = 'mlm_dist_pairing_ledger_20150131.CREATED_ON';

	
	const UPDATED_BY = 'mlm_dist_pairing_ledger_20150131.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_dist_pairing_ledger_20150131.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('PairingId', 'DistId', 'LeftRight', 'TransactionType', 'Credit', 'CreditActual', 'Debit', 'Balance', 'Remark', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MlmDistPairingLedger20150131Peer::PAIRING_ID, MlmDistPairingLedger20150131Peer::DIST_ID, MlmDistPairingLedger20150131Peer::LEFT_RIGHT, MlmDistPairingLedger20150131Peer::TRANSACTION_TYPE, MlmDistPairingLedger20150131Peer::CREDIT, MlmDistPairingLedger20150131Peer::CREDIT_ACTUAL, MlmDistPairingLedger20150131Peer::DEBIT, MlmDistPairingLedger20150131Peer::BALANCE, MlmDistPairingLedger20150131Peer::REMARK, MlmDistPairingLedger20150131Peer::CREATED_BY, MlmDistPairingLedger20150131Peer::CREATED_ON, MlmDistPairingLedger20150131Peer::UPDATED_BY, MlmDistPairingLedger20150131Peer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('pairing_id', 'dist_id', 'left_right', 'transaction_type', 'credit', 'credit_actual', 'debit', 'balance', 'remark', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('PairingId' => 0, 'DistId' => 1, 'LeftRight' => 2, 'TransactionType' => 3, 'Credit' => 4, 'CreditActual' => 5, 'Debit' => 6, 'Balance' => 7, 'Remark' => 8, 'CreatedBy' => 9, 'CreatedOn' => 10, 'UpdatedBy' => 11, 'UpdatedOn' => 12, ),
		BasePeer::TYPE_COLNAME => array (MlmDistPairingLedger20150131Peer::PAIRING_ID => 0, MlmDistPairingLedger20150131Peer::DIST_ID => 1, MlmDistPairingLedger20150131Peer::LEFT_RIGHT => 2, MlmDistPairingLedger20150131Peer::TRANSACTION_TYPE => 3, MlmDistPairingLedger20150131Peer::CREDIT => 4, MlmDistPairingLedger20150131Peer::CREDIT_ACTUAL => 5, MlmDistPairingLedger20150131Peer::DEBIT => 6, MlmDistPairingLedger20150131Peer::BALANCE => 7, MlmDistPairingLedger20150131Peer::REMARK => 8, MlmDistPairingLedger20150131Peer::CREATED_BY => 9, MlmDistPairingLedger20150131Peer::CREATED_ON => 10, MlmDistPairingLedger20150131Peer::UPDATED_BY => 11, MlmDistPairingLedger20150131Peer::UPDATED_ON => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('pairing_id' => 0, 'dist_id' => 1, 'left_right' => 2, 'transaction_type' => 3, 'credit' => 4, 'credit_actual' => 5, 'debit' => 6, 'balance' => 7, 'remark' => 8, 'created_by' => 9, 'created_on' => 10, 'updated_by' => 11, 'updated_on' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmDistPairingLedger20150131MapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmDistPairingLedger20150131MapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmDistPairingLedger20150131Peer::getTableMap();
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
		return str_replace(MlmDistPairingLedger20150131Peer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::PAIRING_ID);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::DIST_ID);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::LEFT_RIGHT);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::TRANSACTION_TYPE);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::CREDIT);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::CREDIT_ACTUAL);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::DEBIT);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::BALANCE);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::REMARK);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::CREATED_BY);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::CREATED_ON);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::UPDATED_BY);

		$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::UPDATED_ON);

	}

	const COUNT = 'COUNT(mlm_dist_pairing_ledger_20150131.PAIRING_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_dist_pairing_ledger_20150131.PAIRING_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmDistPairingLedger20150131Peer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmDistPairingLedger20150131Peer::doSelectRS($criteria, $con);
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
		$objects = MlmDistPairingLedger20150131Peer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmDistPairingLedger20150131Peer::populateObjects(MlmDistPairingLedger20150131Peer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmDistPairingLedger20150131Peer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MlmDistPairingLedger20150131Peer::getOMClass();
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
		return MlmDistPairingLedger20150131Peer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(MlmDistPairingLedger20150131Peer::PAIRING_ID); 

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
			$comparison = $criteria->getComparison(MlmDistPairingLedger20150131Peer::PAIRING_ID);
			$selectCriteria->add(MlmDistPairingLedger20150131Peer::PAIRING_ID, $criteria->remove(MlmDistPairingLedger20150131Peer::PAIRING_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MlmDistPairingLedger20150131Peer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MlmDistPairingLedger20150131Peer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MlmDistPairingLedger20150131) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmDistPairingLedger20150131Peer::PAIRING_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MlmDistPairingLedger20150131 $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmDistPairingLedger20150131Peer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmDistPairingLedger20150131Peer::TABLE_NAME);

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

		return BasePeer::doValidate(MlmDistPairingLedger20150131Peer::DATABASE_NAME, MlmDistPairingLedger20150131Peer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmDistPairingLedger20150131Peer::DATABASE_NAME);

		$criteria->add(MlmDistPairingLedger20150131Peer::PAIRING_ID, $pk);


		$v = MlmDistPairingLedger20150131Peer::doSelect($criteria, $con);

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
			$criteria->add(MlmDistPairingLedger20150131Peer::PAIRING_ID, $pks, Criteria::IN);
			$objs = MlmDistPairingLedger20150131Peer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMlmDistPairingLedger20150131Peer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MlmDistPairingLedger20150131MapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmDistPairingLedger20150131MapBuilder');
}
