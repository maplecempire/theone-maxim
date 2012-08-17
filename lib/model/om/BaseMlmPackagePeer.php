<?php


abstract class BaseMlmPackagePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_package';

	
	const CLASS_DEFAULT = 'lib.model.MlmPackage';

	
	const NUM_COLUMNS = 14;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const PACKAGE_ID = 'mlm_package.PACKAGE_ID';

	
	const PACKAGE_NAME = 'mlm_package.PACKAGE_NAME';

	
	const PRICE = 'mlm_package.PRICE';

	
	const COMMISSION = 'mlm_package.COMMISSION';

	
	const PIPS = 'mlm_package.PIPS';

	
	const GENERATION = 'mlm_package.GENERATION';

	
	const PIPS2 = 'mlm_package.PIPS2';

	
	const GENERATION2 = 'mlm_package.GENERATION2';

	
	const CREDIT_REFUND = 'mlm_package.CREDIT_REFUND';

	
	const PUBLIC_PURCHASE = 'mlm_package.PUBLIC_PURCHASE';

	
	const CREATED_BY = 'mlm_package.CREATED_BY';

	
	const CREATED_ON = 'mlm_package.CREATED_ON';

	
	const UPDATED_BY = 'mlm_package.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_package.UPDATED_ON';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('PackageId', 'PackageName', 'Price', 'Commission', 'Pips', 'Generation', 'Pips2', 'Generation2', 'CreditRefund', 'PublicPurchase', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', ),
		BasePeer::TYPE_COLNAME => array (MlmPackagePeer::PACKAGE_ID, MlmPackagePeer::PACKAGE_NAME, MlmPackagePeer::PRICE, MlmPackagePeer::COMMISSION, MlmPackagePeer::PIPS, MlmPackagePeer::GENERATION, MlmPackagePeer::PIPS2, MlmPackagePeer::GENERATION2, MlmPackagePeer::CREDIT_REFUND, MlmPackagePeer::PUBLIC_PURCHASE, MlmPackagePeer::CREATED_BY, MlmPackagePeer::CREATED_ON, MlmPackagePeer::UPDATED_BY, MlmPackagePeer::UPDATED_ON, ),
		BasePeer::TYPE_FIELDNAME => array ('package_id', 'package_name', 'price', 'commission', 'pips', 'generation', 'pips2', 'generation2', 'credit_refund', 'public_purchase', 'created_by', 'created_on', 'updated_by', 'updated_on', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('PackageId' => 0, 'PackageName' => 1, 'Price' => 2, 'Commission' => 3, 'Pips' => 4, 'Generation' => 5, 'Pips2' => 6, 'Generation2' => 7, 'CreditRefund' => 8, 'PublicPurchase' => 9, 'CreatedBy' => 10, 'CreatedOn' => 11, 'UpdatedBy' => 12, 'UpdatedOn' => 13, ),
		BasePeer::TYPE_COLNAME => array (MlmPackagePeer::PACKAGE_ID => 0, MlmPackagePeer::PACKAGE_NAME => 1, MlmPackagePeer::PRICE => 2, MlmPackagePeer::COMMISSION => 3, MlmPackagePeer::PIPS => 4, MlmPackagePeer::GENERATION => 5, MlmPackagePeer::PIPS2 => 6, MlmPackagePeer::GENERATION2 => 7, MlmPackagePeer::CREDIT_REFUND => 8, MlmPackagePeer::PUBLIC_PURCHASE => 9, MlmPackagePeer::CREATED_BY => 10, MlmPackagePeer::CREATED_ON => 11, MlmPackagePeer::UPDATED_BY => 12, MlmPackagePeer::UPDATED_ON => 13, ),
		BasePeer::TYPE_FIELDNAME => array ('package_id' => 0, 'package_name' => 1, 'price' => 2, 'commission' => 3, 'pips' => 4, 'generation' => 5, 'pips2' => 6, 'generation2' => 7, 'credit_refund' => 8, 'public_purchase' => 9, 'created_by' => 10, 'created_on' => 11, 'updated_by' => 12, 'updated_on' => 13, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmPackageMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmPackageMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmPackagePeer::getTableMap();
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
		return str_replace(MlmPackagePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmPackagePeer::PACKAGE_ID);

		$criteria->addSelectColumn(MlmPackagePeer::PACKAGE_NAME);

		$criteria->addSelectColumn(MlmPackagePeer::PRICE);

		$criteria->addSelectColumn(MlmPackagePeer::COMMISSION);

		$criteria->addSelectColumn(MlmPackagePeer::PIPS);

		$criteria->addSelectColumn(MlmPackagePeer::GENERATION);

		$criteria->addSelectColumn(MlmPackagePeer::PIPS2);

		$criteria->addSelectColumn(MlmPackagePeer::GENERATION2);

		$criteria->addSelectColumn(MlmPackagePeer::CREDIT_REFUND);

		$criteria->addSelectColumn(MlmPackagePeer::PUBLIC_PURCHASE);

		$criteria->addSelectColumn(MlmPackagePeer::CREATED_BY);

		$criteria->addSelectColumn(MlmPackagePeer::CREATED_ON);

		$criteria->addSelectColumn(MlmPackagePeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmPackagePeer::UPDATED_ON);

	}

	const COUNT = 'COUNT(mlm_package.PACKAGE_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_package.PACKAGE_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		
		$criteria = clone $criteria;

		
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmPackagePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmPackagePeer::COUNT);
		}

		
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmPackagePeer::doSelectRS($criteria, $con);
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
		$objects = MlmPackagePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmPackagePeer::populateObjects(MlmPackagePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmPackagePeer::addSelectColumns($criteria);
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		
		
		return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
		
		$cls = MlmPackagePeer::getOMClass();
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
		return MlmPackagePeer::CLASS_DEFAULT;
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

		$criteria->remove(MlmPackagePeer::PACKAGE_ID); 


		
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

			$comparison = $criteria->getComparison(MlmPackagePeer::PACKAGE_ID);
			$selectCriteria->add(MlmPackagePeer::PACKAGE_ID, $criteria->remove(MlmPackagePeer::PACKAGE_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(MlmPackagePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MlmPackagePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
		} elseif ($values instanceof MlmPackage) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmPackagePeer::PACKAGE_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MlmPackage $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmPackagePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmPackagePeer::TABLE_NAME);

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

		return BasePeer::doValidate(MlmPackagePeer::DATABASE_NAME, MlmPackagePeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmPackagePeer::DATABASE_NAME);

		$criteria->add(MlmPackagePeer::PACKAGE_ID, $pk);


		$v = MlmPackagePeer::doSelect($criteria, $con);

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
			$criteria->add(MlmPackagePeer::PACKAGE_ID, $pks, Criteria::IN);
			$objs = MlmPackagePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 


if (Propel::isInit()) {
	
	
	try {
		BaseMlmPackagePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	
	
	require_once 'lib/model/map/MlmPackageMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmPackageMapBuilder');
}
