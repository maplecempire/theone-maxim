<?php


abstract class BaseGgBankTransactionPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'gg_bank_transaction';

	
	const CLASS_DEFAULT = 'lib.model.GgBankTransaction';

	
	const NUM_COLUMNS = 16;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'gg_bank_transaction.ID';

	
	const FILENAME = 'gg_bank_transaction.FILENAME';

	
	const BANK_IN_TO = 'gg_bank_transaction.BANK_IN_TO';

	
	const CURRENCY = 'gg_bank_transaction.CURRENCY';

	
	const AMOUNT = 'gg_bank_transaction.AMOUNT';

	
	const CODE = 'gg_bank_transaction.CODE';

	
	const ESWALLET = 'gg_bank_transaction.ESWALLET';

	
	const BANKIN_STATUS = 'gg_bank_transaction.BANKIN_STATUS';

	
	const BDATE = 'gg_bank_transaction.BDATE';

	
	const ADATE = 'gg_bank_transaction.ADATE';

	
	const CDATE = 'gg_bank_transaction.CDATE';

	
	const CREATE_BY = 'gg_bank_transaction.CREATE_BY';

	
	const APPROVE_BY = 'gg_bank_transaction.APPROVE_BY';

	
	const REMARK1 = 'gg_bank_transaction.REMARK1';

	
	const REMARK2 = 'gg_bank_transaction.REMARK2';

	
	const STATUS = 'gg_bank_transaction.STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Filename', 'BankInTo', 'Currency', 'Amount', 'Code', 'Eswallet', 'BankinStatus', 'Bdate', 'Adate', 'Cdate', 'CreateBy', 'ApproveBy', 'Remark1', 'Remark2', 'Status', ),
		BasePeer::TYPE_COLNAME => array (GgBankTransactionPeer::ID, GgBankTransactionPeer::FILENAME, GgBankTransactionPeer::BANK_IN_TO, GgBankTransactionPeer::CURRENCY, GgBankTransactionPeer::AMOUNT, GgBankTransactionPeer::CODE, GgBankTransactionPeer::ESWALLET, GgBankTransactionPeer::BANKIN_STATUS, GgBankTransactionPeer::BDATE, GgBankTransactionPeer::ADATE, GgBankTransactionPeer::CDATE, GgBankTransactionPeer::CREATE_BY, GgBankTransactionPeer::APPROVE_BY, GgBankTransactionPeer::REMARK1, GgBankTransactionPeer::REMARK2, GgBankTransactionPeer::STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'filename', 'bank_in_to', 'currency', 'amount', 'code', 'eswallet', 'bankin_status', 'bdate', 'adate', 'cdate', 'create_by', 'approve_by', 'remark1', 'remark2', 'status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Filename' => 1, 'BankInTo' => 2, 'Currency' => 3, 'Amount' => 4, 'Code' => 5, 'Eswallet' => 6, 'BankinStatus' => 7, 'Bdate' => 8, 'Adate' => 9, 'Cdate' => 10, 'CreateBy' => 11, 'ApproveBy' => 12, 'Remark1' => 13, 'Remark2' => 14, 'Status' => 15, ),
		BasePeer::TYPE_COLNAME => array (GgBankTransactionPeer::ID => 0, GgBankTransactionPeer::FILENAME => 1, GgBankTransactionPeer::BANK_IN_TO => 2, GgBankTransactionPeer::CURRENCY => 3, GgBankTransactionPeer::AMOUNT => 4, GgBankTransactionPeer::CODE => 5, GgBankTransactionPeer::ESWALLET => 6, GgBankTransactionPeer::BANKIN_STATUS => 7, GgBankTransactionPeer::BDATE => 8, GgBankTransactionPeer::ADATE => 9, GgBankTransactionPeer::CDATE => 10, GgBankTransactionPeer::CREATE_BY => 11, GgBankTransactionPeer::APPROVE_BY => 12, GgBankTransactionPeer::REMARK1 => 13, GgBankTransactionPeer::REMARK2 => 14, GgBankTransactionPeer::STATUS => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'filename' => 1, 'bank_in_to' => 2, 'currency' => 3, 'amount' => 4, 'code' => 5, 'eswallet' => 6, 'bankin_status' => 7, 'bdate' => 8, 'adate' => 9, 'cdate' => 10, 'create_by' => 11, 'approve_by' => 12, 'remark1' => 13, 'remark2' => 14, 'status' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/GgBankTransactionMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.GgBankTransactionMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = GgBankTransactionPeer::getTableMap();
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
		return str_replace(GgBankTransactionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(GgBankTransactionPeer::ID);

		$criteria->addSelectColumn(GgBankTransactionPeer::FILENAME);

		$criteria->addSelectColumn(GgBankTransactionPeer::BANK_IN_TO);

		$criteria->addSelectColumn(GgBankTransactionPeer::CURRENCY);

		$criteria->addSelectColumn(GgBankTransactionPeer::AMOUNT);

		$criteria->addSelectColumn(GgBankTransactionPeer::CODE);

		$criteria->addSelectColumn(GgBankTransactionPeer::ESWALLET);

		$criteria->addSelectColumn(GgBankTransactionPeer::BANKIN_STATUS);

		$criteria->addSelectColumn(GgBankTransactionPeer::BDATE);

		$criteria->addSelectColumn(GgBankTransactionPeer::ADATE);

		$criteria->addSelectColumn(GgBankTransactionPeer::CDATE);

		$criteria->addSelectColumn(GgBankTransactionPeer::CREATE_BY);

		$criteria->addSelectColumn(GgBankTransactionPeer::APPROVE_BY);

		$criteria->addSelectColumn(GgBankTransactionPeer::REMARK1);

		$criteria->addSelectColumn(GgBankTransactionPeer::REMARK2);

		$criteria->addSelectColumn(GgBankTransactionPeer::STATUS);

	}

	const COUNT = 'COUNT(gg_bank_transaction.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT gg_bank_transaction.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(GgBankTransactionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GgBankTransactionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = GgBankTransactionPeer::doSelectRS($criteria, $con);
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
		$objects = GgBankTransactionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return GgBankTransactionPeer::populateObjects(GgBankTransactionPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			GgBankTransactionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = GgBankTransactionPeer::getOMClass();
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
		return GgBankTransactionPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(GgBankTransactionPeer::ID); 

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
			$comparison = $criteria->getComparison(GgBankTransactionPeer::ID);
			$selectCriteria->add(GgBankTransactionPeer::ID, $criteria->remove(GgBankTransactionPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(GgBankTransactionPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(GgBankTransactionPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof GgBankTransaction) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(GgBankTransactionPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(GgBankTransaction $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(GgBankTransactionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(GgBankTransactionPeer::TABLE_NAME);

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

		return BasePeer::doValidate(GgBankTransactionPeer::DATABASE_NAME, GgBankTransactionPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(GgBankTransactionPeer::DATABASE_NAME);

		$criteria->add(GgBankTransactionPeer::ID, $pk);


		$v = GgBankTransactionPeer::doSelect($criteria, $con);

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
			$criteria->add(GgBankTransactionPeer::ID, $pks, Criteria::IN);
			$objs = GgBankTransactionPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseGgBankTransactionPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/GgBankTransactionMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.GgBankTransactionMapBuilder');
}
