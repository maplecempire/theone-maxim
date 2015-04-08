<?php


abstract class BaseGgSharePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'gg_share';

	
	const CLASS_DEFAULT = 'lib.model.GgShare';

	
	const NUM_COLUMNS = 13;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'gg_share.ID';

	
	const UID = 'gg_share.UID';

	
	const ACCOUNT_TYPE = 'gg_share.ACCOUNT_TYPE';

	
	const TOTAL_UNIT = 'gg_share.TOTAL_UNIT';

	
	const ORIGINAL_TOTAL_UNIT = 'gg_share.ORIGINAL_TOTAL_UNIT';

	
	const BUY_PRICE = 'gg_share.BUY_PRICE';

	
	const SELL_PRICE = 'gg_share.SELL_PRICE';

	
	const BUY_DATE = 'gg_share.BUY_DATE';

	
	const SELL_DATE = 'gg_share.SELL_DATE';

	
	const TRADE_DATE = 'gg_share.TRADE_DATE';

	
	const REPLICA = 'gg_share.REPLICA';

	
	const STATUS = 'gg_share.STATUS';

	
	const SELLING_DATETIME = 'gg_share.SELLING_DATETIME';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Uid', 'AccountType', 'TotalUnit', 'OriginalTotalUnit', 'BuyPrice', 'SellPrice', 'BuyDate', 'SellDate', 'TradeDate', 'Replica', 'Status', 'SellingDatetime', ),
		BasePeer::TYPE_COLNAME => array (GgSharePeer::ID, GgSharePeer::UID, GgSharePeer::ACCOUNT_TYPE, GgSharePeer::TOTAL_UNIT, GgSharePeer::ORIGINAL_TOTAL_UNIT, GgSharePeer::BUY_PRICE, GgSharePeer::SELL_PRICE, GgSharePeer::BUY_DATE, GgSharePeer::SELL_DATE, GgSharePeer::TRADE_DATE, GgSharePeer::REPLICA, GgSharePeer::STATUS, GgSharePeer::SELLING_DATETIME, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'uid', 'account_type', 'total_unit', 'original_total_unit', 'buy_price', 'sell_price', 'buy_date', 'sell_date', 'trade_date', 'replica', 'status', 'selling_datetime', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Uid' => 1, 'AccountType' => 2, 'TotalUnit' => 3, 'OriginalTotalUnit' => 4, 'BuyPrice' => 5, 'SellPrice' => 6, 'BuyDate' => 7, 'SellDate' => 8, 'TradeDate' => 9, 'Replica' => 10, 'Status' => 11, 'SellingDatetime' => 12, ),
		BasePeer::TYPE_COLNAME => array (GgSharePeer::ID => 0, GgSharePeer::UID => 1, GgSharePeer::ACCOUNT_TYPE => 2, GgSharePeer::TOTAL_UNIT => 3, GgSharePeer::ORIGINAL_TOTAL_UNIT => 4, GgSharePeer::BUY_PRICE => 5, GgSharePeer::SELL_PRICE => 6, GgSharePeer::BUY_DATE => 7, GgSharePeer::SELL_DATE => 8, GgSharePeer::TRADE_DATE => 9, GgSharePeer::REPLICA => 10, GgSharePeer::STATUS => 11, GgSharePeer::SELLING_DATETIME => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'uid' => 1, 'account_type' => 2, 'total_unit' => 3, 'original_total_unit' => 4, 'buy_price' => 5, 'sell_price' => 6, 'buy_date' => 7, 'sell_date' => 8, 'trade_date' => 9, 'replica' => 10, 'status' => 11, 'selling_datetime' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/GgShareMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.GgShareMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = GgSharePeer::getTableMap();
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
		return str_replace(GgSharePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(GgSharePeer::ID);

		$criteria->addSelectColumn(GgSharePeer::UID);

		$criteria->addSelectColumn(GgSharePeer::ACCOUNT_TYPE);

		$criteria->addSelectColumn(GgSharePeer::TOTAL_UNIT);

		$criteria->addSelectColumn(GgSharePeer::ORIGINAL_TOTAL_UNIT);

		$criteria->addSelectColumn(GgSharePeer::BUY_PRICE);

		$criteria->addSelectColumn(GgSharePeer::SELL_PRICE);

		$criteria->addSelectColumn(GgSharePeer::BUY_DATE);

		$criteria->addSelectColumn(GgSharePeer::SELL_DATE);

		$criteria->addSelectColumn(GgSharePeer::TRADE_DATE);

		$criteria->addSelectColumn(GgSharePeer::REPLICA);

		$criteria->addSelectColumn(GgSharePeer::STATUS);

		$criteria->addSelectColumn(GgSharePeer::SELLING_DATETIME);

	}

	const COUNT = 'COUNT(gg_share.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT gg_share.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(GgSharePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GgSharePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = GgSharePeer::doSelectRS($criteria, $con);
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
		$objects = GgSharePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return GgSharePeer::populateObjects(GgSharePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			GgSharePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = GgSharePeer::getOMClass();
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
		return GgSharePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(GgSharePeer::ID); 

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
			$comparison = $criteria->getComparison(GgSharePeer::ID);
			$selectCriteria->add(GgSharePeer::ID, $criteria->remove(GgSharePeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(GgSharePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(GgSharePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof GgShare) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(GgSharePeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(GgShare $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(GgSharePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(GgSharePeer::TABLE_NAME);

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

		return BasePeer::doValidate(GgSharePeer::DATABASE_NAME, GgSharePeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(GgSharePeer::DATABASE_NAME);

		$criteria->add(GgSharePeer::ID, $pk);


		$v = GgSharePeer::doSelect($criteria, $con);

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
			$criteria->add(GgSharePeer::ID, $pks, Criteria::IN);
			$objs = GgSharePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseGgSharePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/GgShareMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.GgShareMapBuilder');
}
