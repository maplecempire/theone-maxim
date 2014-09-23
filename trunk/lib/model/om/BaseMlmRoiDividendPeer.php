<?php


abstract class BaseMlmRoiDividendPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_roi_dividend';

	
	const CLASS_DEFAULT = 'lib.model.MlmRoiDividend';

	
	const NUM_COLUMNS = 21;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const DEVIDEND_ID = 'mlm_roi_dividend.DEVIDEND_ID';

	
	const DIST_ID = 'mlm_roi_dividend.DIST_ID';

	
	const MT4_USER_NAME = 'mlm_roi_dividend.MT4_USER_NAME';

	
	const IDX = 'mlm_roi_dividend.IDX';

	
	const ACCOUNT_LEDGER_ID = 'mlm_roi_dividend.ACCOUNT_LEDGER_ID';

	
	const DIVIDEND_DATE = 'mlm_roi_dividend.DIVIDEND_DATE';

	
	const PACKAGE_ID = 'mlm_roi_dividend.PACKAGE_ID';

	
	const PACKAGE_PRICE = 'mlm_roi_dividend.PACKAGE_PRICE';

	
	const ROI_PERCENTAGE = 'mlm_roi_dividend.ROI_PERCENTAGE';

	
	const MT4_BALANCE = 'mlm_roi_dividend.MT4_BALANCE';

	
	const DIVIDEND_AMOUNT = 'mlm_roi_dividend.DIVIDEND_AMOUNT';

	
	const REMARKS = 'mlm_roi_dividend.REMARKS';

	
	const EXCEED_DIST_ID = 'mlm_roi_dividend.EXCEED_DIST_ID';

	
	const EXCEED_ROI_PERCENTAGE = 'mlm_roi_dividend.EXCEED_ROI_PERCENTAGE';

	
	const EXCEED_DIVIDEND_AMOUNT = 'mlm_roi_dividend.EXCEED_DIVIDEND_AMOUNT';

	
	const STATUS_CODE = 'mlm_roi_dividend.STATUS_CODE';

	
	const CREATED_BY = 'mlm_roi_dividend.CREATED_BY';

	
	const CREATED_ON = 'mlm_roi_dividend.CREATED_ON';

	
	const UPDATED_BY = 'mlm_roi_dividend.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_roi_dividend.UPDATED_ON';

	
	const FIRST_DIVIDEND_DATE = 'mlm_roi_dividend.FIRST_DIVIDEND_DATE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('DevidendId', 'DistId', 'Mt4UserName', 'Idx', 'AccountLedgerId', 'DividendDate', 'PackageId', 'PackagePrice', 'RoiPercentage', 'Mt4Balance', 'DividendAmount', 'Remarks', 'ExceedDistId', 'ExceedRoiPercentage', 'ExceedDividendAmount', 'StatusCode', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', 'FirstDividendDate', ),
		BasePeer::TYPE_COLNAME => array (MlmRoiDividendPeer::DEVIDEND_ID, MlmRoiDividendPeer::DIST_ID, MlmRoiDividendPeer::MT4_USER_NAME, MlmRoiDividendPeer::IDX, MlmRoiDividendPeer::ACCOUNT_LEDGER_ID, MlmRoiDividendPeer::DIVIDEND_DATE, MlmRoiDividendPeer::PACKAGE_ID, MlmRoiDividendPeer::PACKAGE_PRICE, MlmRoiDividendPeer::ROI_PERCENTAGE, MlmRoiDividendPeer::MT4_BALANCE, MlmRoiDividendPeer::DIVIDEND_AMOUNT, MlmRoiDividendPeer::REMARKS, MlmRoiDividendPeer::EXCEED_DIST_ID, MlmRoiDividendPeer::EXCEED_ROI_PERCENTAGE, MlmRoiDividendPeer::EXCEED_DIVIDEND_AMOUNT, MlmRoiDividendPeer::STATUS_CODE, MlmRoiDividendPeer::CREATED_BY, MlmRoiDividendPeer::CREATED_ON, MlmRoiDividendPeer::UPDATED_BY, MlmRoiDividendPeer::UPDATED_ON, MlmRoiDividendPeer::FIRST_DIVIDEND_DATE, ),
		BasePeer::TYPE_FIELDNAME => array ('devidend_id', 'dist_id', 'mt4_user_name', 'idx', 'account_ledger_id', 'dividend_date', 'package_id', 'package_price', 'roi_percentage', 'mt4_balance', 'dividend_amount', 'remarks', 'exceed_dist_id', 'exceed_roi_percentage', 'exceed_dividend_amount', 'status_code', 'created_by', 'created_on', 'updated_by', 'updated_on', 'first_dividend_date', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DevidendId' => 0, 'DistId' => 1, 'Mt4UserName' => 2, 'Idx' => 3, 'AccountLedgerId' => 4, 'DividendDate' => 5, 'PackageId' => 6, 'PackagePrice' => 7, 'RoiPercentage' => 8, 'Mt4Balance' => 9, 'DividendAmount' => 10, 'Remarks' => 11, 'ExceedDistId' => 12, 'ExceedRoiPercentage' => 13, 'ExceedDividendAmount' => 14, 'StatusCode' => 15, 'CreatedBy' => 16, 'CreatedOn' => 17, 'UpdatedBy' => 18, 'UpdatedOn' => 19, 'FirstDividendDate' => 20, ),
		BasePeer::TYPE_COLNAME => array (MlmRoiDividendPeer::DEVIDEND_ID => 0, MlmRoiDividendPeer::DIST_ID => 1, MlmRoiDividendPeer::MT4_USER_NAME => 2, MlmRoiDividendPeer::IDX => 3, MlmRoiDividendPeer::ACCOUNT_LEDGER_ID => 4, MlmRoiDividendPeer::DIVIDEND_DATE => 5, MlmRoiDividendPeer::PACKAGE_ID => 6, MlmRoiDividendPeer::PACKAGE_PRICE => 7, MlmRoiDividendPeer::ROI_PERCENTAGE => 8, MlmRoiDividendPeer::MT4_BALANCE => 9, MlmRoiDividendPeer::DIVIDEND_AMOUNT => 10, MlmRoiDividendPeer::REMARKS => 11, MlmRoiDividendPeer::EXCEED_DIST_ID => 12, MlmRoiDividendPeer::EXCEED_ROI_PERCENTAGE => 13, MlmRoiDividendPeer::EXCEED_DIVIDEND_AMOUNT => 14, MlmRoiDividendPeer::STATUS_CODE => 15, MlmRoiDividendPeer::CREATED_BY => 16, MlmRoiDividendPeer::CREATED_ON => 17, MlmRoiDividendPeer::UPDATED_BY => 18, MlmRoiDividendPeer::UPDATED_ON => 19, MlmRoiDividendPeer::FIRST_DIVIDEND_DATE => 20, ),
		BasePeer::TYPE_FIELDNAME => array ('devidend_id' => 0, 'dist_id' => 1, 'mt4_user_name' => 2, 'idx' => 3, 'account_ledger_id' => 4, 'dividend_date' => 5, 'package_id' => 6, 'package_price' => 7, 'roi_percentage' => 8, 'mt4_balance' => 9, 'dividend_amount' => 10, 'remarks' => 11, 'exceed_dist_id' => 12, 'exceed_roi_percentage' => 13, 'exceed_dividend_amount' => 14, 'status_code' => 15, 'created_by' => 16, 'created_on' => 17, 'updated_by' => 18, 'updated_on' => 19, 'first_dividend_date' => 20, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmRoiDividendMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmRoiDividendMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmRoiDividendPeer::getTableMap();
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
		return str_replace(MlmRoiDividendPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmRoiDividendPeer::DEVIDEND_ID);

		$criteria->addSelectColumn(MlmRoiDividendPeer::DIST_ID);

		$criteria->addSelectColumn(MlmRoiDividendPeer::MT4_USER_NAME);

		$criteria->addSelectColumn(MlmRoiDividendPeer::IDX);

		$criteria->addSelectColumn(MlmRoiDividendPeer::ACCOUNT_LEDGER_ID);

		$criteria->addSelectColumn(MlmRoiDividendPeer::DIVIDEND_DATE);

		$criteria->addSelectColumn(MlmRoiDividendPeer::PACKAGE_ID);

		$criteria->addSelectColumn(MlmRoiDividendPeer::PACKAGE_PRICE);

		$criteria->addSelectColumn(MlmRoiDividendPeer::ROI_PERCENTAGE);

		$criteria->addSelectColumn(MlmRoiDividendPeer::MT4_BALANCE);

		$criteria->addSelectColumn(MlmRoiDividendPeer::DIVIDEND_AMOUNT);

		$criteria->addSelectColumn(MlmRoiDividendPeer::REMARKS);

		$criteria->addSelectColumn(MlmRoiDividendPeer::EXCEED_DIST_ID);

		$criteria->addSelectColumn(MlmRoiDividendPeer::EXCEED_ROI_PERCENTAGE);

		$criteria->addSelectColumn(MlmRoiDividendPeer::EXCEED_DIVIDEND_AMOUNT);

		$criteria->addSelectColumn(MlmRoiDividendPeer::STATUS_CODE);

		$criteria->addSelectColumn(MlmRoiDividendPeer::CREATED_BY);

		$criteria->addSelectColumn(MlmRoiDividendPeer::CREATED_ON);

		$criteria->addSelectColumn(MlmRoiDividendPeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmRoiDividendPeer::UPDATED_ON);

		$criteria->addSelectColumn(MlmRoiDividendPeer::FIRST_DIVIDEND_DATE);

	}

	const COUNT = 'COUNT(mlm_roi_dividend.DEVIDEND_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_roi_dividend.DEVIDEND_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmRoiDividendPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmRoiDividendPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmRoiDividendPeer::doSelectRS($criteria, $con);
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
		$objects = MlmRoiDividendPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmRoiDividendPeer::populateObjects(MlmRoiDividendPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmRoiDividendPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MlmRoiDividendPeer::getOMClass();
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
		return MlmRoiDividendPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(MlmRoiDividendPeer::DEVIDEND_ID); 

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
			$comparison = $criteria->getComparison(MlmRoiDividendPeer::DEVIDEND_ID);
			$selectCriteria->add(MlmRoiDividendPeer::DEVIDEND_ID, $criteria->remove(MlmRoiDividendPeer::DEVIDEND_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MlmRoiDividendPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MlmRoiDividendPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MlmRoiDividend) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmRoiDividendPeer::DEVIDEND_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MlmRoiDividend $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmRoiDividendPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmRoiDividendPeer::TABLE_NAME);

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

		return BasePeer::doValidate(MlmRoiDividendPeer::DATABASE_NAME, MlmRoiDividendPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmRoiDividendPeer::DATABASE_NAME);

		$criteria->add(MlmRoiDividendPeer::DEVIDEND_ID, $pk);


		$v = MlmRoiDividendPeer::doSelect($criteria, $con);

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
			$criteria->add(MlmRoiDividendPeer::DEVIDEND_ID, $pks, Criteria::IN);
			$objs = MlmRoiDividendPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMlmRoiDividendPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MlmRoiDividendMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmRoiDividendMapBuilder');
}
