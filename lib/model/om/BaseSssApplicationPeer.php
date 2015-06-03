<?php


abstract class BaseSssApplicationPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sss_application';

	
	const CLASS_DEFAULT = 'lib.model.SssApplication';

	
	const NUM_COLUMNS = 20;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const SSS_ID = 'sss_application.SSS_ID';

	
	const DIST_ID = 'sss_application.DIST_ID';

	
	const DIVIDEND_ID = 'sss_application.DIVIDEND_ID';

	
	const MT4_USER_NAME = 'sss_application.MT4_USER_NAME';

	
	const CP2_BALANCE = 'sss_application.CP2_BALANCE';

	
	const CP3_BALANCE = 'sss_application.CP3_BALANCE';

	
	const MT4_BALANCE = 'sss_application.MT4_BALANCE';

	
	const ROI_REMAINING_MONTH = 'sss_application.ROI_REMAINING_MONTH';

	
	const ROI_PERCENTAGE = 'sss_application.ROI_PERCENTAGE';

	
	const TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3 = 'sss_application.TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3';

	
	const SHARE_VALUE = 'sss_application.SHARE_VALUE';

	
	const TOTAL_SHARE_CONVERTED = 'sss_application.TOTAL_SHARE_CONVERTED';

	
	const SIGNATURE = 'sss_application.SIGNATURE';

	
	const REMARKS = 'sss_application.REMARKS';

	
	const STATUS_CODE = 'sss_application.STATUS_CODE';

	
	const SWAP_TYPE = 'sss_application.SWAP_TYPE';

	
	const CREATED_BY = 'sss_application.CREATED_BY';

	
	const CREATED_ON = 'sss_application.CREATED_ON';

	
	const UPDATED_BY = 'sss_application.UPDATED_BY';

	
	const UPDATED_ON = 'sss_application.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('SssId', 'DistId', 'DividendId', 'Mt4UserName', 'Cp2Balance', 'Cp3Balance', 'Mt4Balance', 'RoiRemainingMonth', 'RoiPercentage', 'TotalAmountConvertedWithCp2cp3', 'ShareValue', 'TotalShareConverted', 'Signature', 'Remarks', 'StatusCode', 'SwapType', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (SssApplicationPeer::SSS_ID, SssApplicationPeer::DIST_ID, SssApplicationPeer::DIVIDEND_ID, SssApplicationPeer::MT4_USER_NAME, SssApplicationPeer::CP2_BALANCE, SssApplicationPeer::CP3_BALANCE, SssApplicationPeer::MT4_BALANCE, SssApplicationPeer::ROI_REMAINING_MONTH, SssApplicationPeer::ROI_PERCENTAGE, SssApplicationPeer::TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3, SssApplicationPeer::SHARE_VALUE, SssApplicationPeer::TOTAL_SHARE_CONVERTED, SssApplicationPeer::SIGNATURE, SssApplicationPeer::REMARKS, SssApplicationPeer::STATUS_CODE, SssApplicationPeer::SWAP_TYPE, SssApplicationPeer::CREATED_BY, SssApplicationPeer::CREATED_ON, SssApplicationPeer::UPDATED_BY, SssApplicationPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('sss_id', 'dist_id', 'dividend_id', 'mt4_user_name', 'cp2_balance', 'cp3_balance', 'mt4_balance', 'roi_remaining_month', 'roi_percentage', 'total_amount_converted_with_cp2cp3', 'share_value', 'total_share_converted', 'signature', 'remarks', 'status_code', 'swap_type', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('SssId' => 0, 'DistId' => 1, 'DividendId' => 2, 'Mt4UserName' => 3, 'Cp2Balance' => 4, 'Cp3Balance' => 5, 'Mt4Balance' => 6, 'RoiRemainingMonth' => 7, 'RoiPercentage' => 8, 'TotalAmountConvertedWithCp2cp3' => 9, 'ShareValue' => 10, 'TotalShareConverted' => 11, 'Signature' => 12, 'Remarks' => 13, 'StatusCode' => 14, 'SwapType' => 15, 'CreatedBy' => 16, 'CreatedOn' => 17, 'UpdatedBy' => 18, 'UpdatedOn' => 19, ),
		BasePeer::TYPE_COLNAME => array (SssApplicationPeer::SSS_ID => 0, SssApplicationPeer::DIST_ID => 1, SssApplicationPeer::DIVIDEND_ID => 2, SssApplicationPeer::MT4_USER_NAME => 3, SssApplicationPeer::CP2_BALANCE => 4, SssApplicationPeer::CP3_BALANCE => 5, SssApplicationPeer::MT4_BALANCE => 6, SssApplicationPeer::ROI_REMAINING_MONTH => 7, SssApplicationPeer::ROI_PERCENTAGE => 8, SssApplicationPeer::TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3 => 9, SssApplicationPeer::SHARE_VALUE => 10, SssApplicationPeer::TOTAL_SHARE_CONVERTED => 11, SssApplicationPeer::SIGNATURE => 12, SssApplicationPeer::REMARKS => 13, SssApplicationPeer::STATUS_CODE => 14, SssApplicationPeer::SWAP_TYPE => 15, SssApplicationPeer::CREATED_BY => 16, SssApplicationPeer::CREATED_ON => 17, SssApplicationPeer::UPDATED_BY => 18, SssApplicationPeer::UPDATED_ON => 19, ),
		BasePeer::TYPE_FIELDNAME => array ('sss_id' => 0, 'dist_id' => 1, 'dividend_id' => 2, 'mt4_user_name' => 3, 'cp2_balance' => 4, 'cp3_balance' => 5, 'mt4_balance' => 6, 'roi_remaining_month' => 7, 'roi_percentage' => 8, 'total_amount_converted_with_cp2cp3' => 9, 'share_value' => 10, 'total_share_converted' => 11, 'signature' => 12, 'remarks' => 13, 'status_code' => 14, 'swap_type' => 15, 'created_by' => 16, 'created_on' => 17, 'updated_by' => 18, 'updated_on' => 19, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SssApplicationMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SssApplicationMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SssApplicationPeer::getTableMap();
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
		return str_replace(SssApplicationPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SssApplicationPeer::SSS_ID);

		$criteria->addSelectColumn(SssApplicationPeer::DIST_ID);

		$criteria->addSelectColumn(SssApplicationPeer::DIVIDEND_ID);

		$criteria->addSelectColumn(SssApplicationPeer::MT4_USER_NAME);

		$criteria->addSelectColumn(SssApplicationPeer::CP2_BALANCE);

		$criteria->addSelectColumn(SssApplicationPeer::CP3_BALANCE);

		$criteria->addSelectColumn(SssApplicationPeer::MT4_BALANCE);

		$criteria->addSelectColumn(SssApplicationPeer::ROI_REMAINING_MONTH);

		$criteria->addSelectColumn(SssApplicationPeer::ROI_PERCENTAGE);

		$criteria->addSelectColumn(SssApplicationPeer::TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3);

		$criteria->addSelectColumn(SssApplicationPeer::SHARE_VALUE);

		$criteria->addSelectColumn(SssApplicationPeer::TOTAL_SHARE_CONVERTED);

		$criteria->addSelectColumn(SssApplicationPeer::SIGNATURE);

		$criteria->addSelectColumn(SssApplicationPeer::REMARKS);

		$criteria->addSelectColumn(SssApplicationPeer::STATUS_CODE);

		$criteria->addSelectColumn(SssApplicationPeer::SWAP_TYPE);

		$criteria->addSelectColumn(SssApplicationPeer::CREATED_BY);

		$criteria->addSelectColumn(SssApplicationPeer::CREATED_ON);

		$criteria->addSelectColumn(SssApplicationPeer::UPDATED_BY);

		$criteria->addSelectColumn(SssApplicationPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(sss_application.SSS_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sss_application.SSS_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SssApplicationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SssApplicationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SssApplicationPeer::doSelectRS($criteria, $con);
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
		$objects = SssApplicationPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SssApplicationPeer::populateObjects(SssApplicationPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SssApplicationPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SssApplicationPeer::getOMClass();
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
		return SssApplicationPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(SssApplicationPeer::SSS_ID); 

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
			$comparison = $criteria->getComparison(SssApplicationPeer::SSS_ID);
			$selectCriteria->add(SssApplicationPeer::SSS_ID, $criteria->remove(SssApplicationPeer::SSS_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(SssApplicationPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(SssApplicationPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof SssApplication) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SssApplicationPeer::SSS_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(SssApplication $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SssApplicationPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SssApplicationPeer::TABLE_NAME);

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

		return BasePeer::doValidate(SssApplicationPeer::DATABASE_NAME, SssApplicationPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(SssApplicationPeer::DATABASE_NAME);

		$criteria->add(SssApplicationPeer::SSS_ID, $pk);


		$v = SssApplicationPeer::doSelect($criteria, $con);

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
			$criteria->add(SssApplicationPeer::SSS_ID, $pks, Criteria::IN);
			$objs = SssApplicationPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSssApplicationPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SssApplicationMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SssApplicationMapBuilder');
}
