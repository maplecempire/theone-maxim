<?php


abstract class BaseMbsCostcontrolPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mbs_costcontrol';

	
	const CLASS_DEFAULT = 'lib.model.MbsCostcontrol';

	
	const NUM_COLUMNS = 14;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const MBS_ID = 'mbs_costcontrol.MBS_ID';

	
	const IDX = 'mbs_costcontrol.IDX';

	
	const DESCRIPTION_OF_EXPENDITURE = 'mbs_costcontrol.DESCRIPTION_OF_EXPENDITURE';

	
	const BUDGET = 'mbs_costcontrol.BUDGET';

	
	const SERVICE_CHARGE = 'mbs_costcontrol.SERVICE_CHARGE';

	
	const GST = 'mbs_costcontrol.GST';

	
	const TOTAL_NETT_AMOUNT = 'mbs_costcontrol.TOTAL_NETT_AMOUNT';

	
	const PAYMENTS_MADE = 'mbs_costcontrol.PAYMENTS_MADE';

	
	const BALANCE_PAYABLE = 'mbs_costcontrol.BALANCE_PAYABLE';

	
	const REMARKS = 'mbs_costcontrol.REMARKS';

	
	const CREATED_BY = 'mbs_costcontrol.CREATED_BY';

	
	const CREATED_ON = 'mbs_costcontrol.CREATED_ON';

	
	const UPDATED_BY = 'mbs_costcontrol.UPDATED_BY';

	
	const UPDATED_ON = 'mbs_costcontrol.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('MbsId', 'Idx', 'DescriptionOfExpenditure', 'Budget', 'ServiceCharge', 'Gst', 'TotalNettAmount', 'PaymentsMade', 'BalancePayable', 'Remarks', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MbsCostcontrolPeer::MBS_ID, MbsCostcontrolPeer::IDX, MbsCostcontrolPeer::DESCRIPTION_OF_EXPENDITURE, MbsCostcontrolPeer::BUDGET, MbsCostcontrolPeer::SERVICE_CHARGE, MbsCostcontrolPeer::GST, MbsCostcontrolPeer::TOTAL_NETT_AMOUNT, MbsCostcontrolPeer::PAYMENTS_MADE, MbsCostcontrolPeer::BALANCE_PAYABLE, MbsCostcontrolPeer::REMARKS, MbsCostcontrolPeer::CREATED_BY, MbsCostcontrolPeer::CREATED_ON, MbsCostcontrolPeer::UPDATED_BY, MbsCostcontrolPeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('mbs_id', 'idx', 'description_of_expenditure', 'budget', 'service_charge', 'gst', 'total_nett_amount', 'payments_made', 'balance_payable', 'remarks', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('MbsId' => 0, 'Idx' => 1, 'DescriptionOfExpenditure' => 2, 'Budget' => 3, 'ServiceCharge' => 4, 'Gst' => 5, 'TotalNettAmount' => 6, 'PaymentsMade' => 7, 'BalancePayable' => 8, 'Remarks' => 9, 'CreatedBy' => 10, 'CreatedOn' => 11, 'UpdatedBy' => 12, 'UpdatedOn' => 13, ),
		BasePeer::TYPE_COLNAME => array (MbsCostcontrolPeer::MBS_ID => 0, MbsCostcontrolPeer::IDX => 1, MbsCostcontrolPeer::DESCRIPTION_OF_EXPENDITURE => 2, MbsCostcontrolPeer::BUDGET => 3, MbsCostcontrolPeer::SERVICE_CHARGE => 4, MbsCostcontrolPeer::GST => 5, MbsCostcontrolPeer::TOTAL_NETT_AMOUNT => 6, MbsCostcontrolPeer::PAYMENTS_MADE => 7, MbsCostcontrolPeer::BALANCE_PAYABLE => 8, MbsCostcontrolPeer::REMARKS => 9, MbsCostcontrolPeer::CREATED_BY => 10, MbsCostcontrolPeer::CREATED_ON => 11, MbsCostcontrolPeer::UPDATED_BY => 12, MbsCostcontrolPeer::UPDATED_ON => 13, ),
		BasePeer::TYPE_FIELDNAME => array ('mbs_id' => 0, 'idx' => 1, 'description_of_expenditure' => 2, 'budget' => 3, 'service_charge' => 4, 'gst' => 5, 'total_nett_amount' => 6, 'payments_made' => 7, 'balance_payable' => 8, 'remarks' => 9, 'created_by' => 10, 'created_on' => 11, 'updated_by' => 12, 'updated_on' => 13, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MbsCostcontrolMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MbsCostcontrolMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MbsCostcontrolPeer::getTableMap();
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
		return str_replace(MbsCostcontrolPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MbsCostcontrolPeer::MBS_ID);

		$criteria->addSelectColumn(MbsCostcontrolPeer::IDX);

		$criteria->addSelectColumn(MbsCostcontrolPeer::DESCRIPTION_OF_EXPENDITURE);

		$criteria->addSelectColumn(MbsCostcontrolPeer::BUDGET);

		$criteria->addSelectColumn(MbsCostcontrolPeer::SERVICE_CHARGE);

		$criteria->addSelectColumn(MbsCostcontrolPeer::GST);

		$criteria->addSelectColumn(MbsCostcontrolPeer::TOTAL_NETT_AMOUNT);

		$criteria->addSelectColumn(MbsCostcontrolPeer::PAYMENTS_MADE);

		$criteria->addSelectColumn(MbsCostcontrolPeer::BALANCE_PAYABLE);

		$criteria->addSelectColumn(MbsCostcontrolPeer::REMARKS);

		$criteria->addSelectColumn(MbsCostcontrolPeer::CREATED_BY);

		$criteria->addSelectColumn(MbsCostcontrolPeer::CREATED_ON);

		$criteria->addSelectColumn(MbsCostcontrolPeer::UPDATED_BY);

		$criteria->addSelectColumn(MbsCostcontrolPeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(mbs_costcontrol.MBS_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mbs_costcontrol.MBS_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MbsCostcontrolPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MbsCostcontrolPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MbsCostcontrolPeer::doSelectRS($criteria, $con);
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
		$objects = MbsCostcontrolPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MbsCostcontrolPeer::populateObjects(MbsCostcontrolPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MbsCostcontrolPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MbsCostcontrolPeer::getOMClass();
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
		return MbsCostcontrolPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(MbsCostcontrolPeer::MBS_ID); 

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
			$comparison = $criteria->getComparison(MbsCostcontrolPeer::MBS_ID);
			$selectCriteria->add(MbsCostcontrolPeer::MBS_ID, $criteria->remove(MbsCostcontrolPeer::MBS_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MbsCostcontrolPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MbsCostcontrolPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MbsCostcontrol) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MbsCostcontrolPeer::MBS_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MbsCostcontrol $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MbsCostcontrolPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MbsCostcontrolPeer::TABLE_NAME);

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

		return BasePeer::doValidate(MbsCostcontrolPeer::DATABASE_NAME, MbsCostcontrolPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MbsCostcontrolPeer::DATABASE_NAME);

		$criteria->add(MbsCostcontrolPeer::MBS_ID, $pk);


		$v = MbsCostcontrolPeer::doSelect($criteria, $con);

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
			$criteria->add(MbsCostcontrolPeer::MBS_ID, $pks, Criteria::IN);
			$objs = MbsCostcontrolPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMbsCostcontrolPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MbsCostcontrolMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MbsCostcontrolMapBuilder');
}
