<?php



class MlmPackageMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MlmPackageMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('mlm_package');
		$tMap->setPhpName('MlmPackage');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('PACKAGE_ID', 'PackageId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PACKAGE_NAME', 'PackageName', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('PRICE', 'Price', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('COMMISSION', 'Commission', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('PIPS', 'Pips', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('GENERATION', 'Generation', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('PIPS2', 'Pips2', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('GENERATION2', 'Generation2', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('CREDIT_REFUND', 'CreditRefund', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('PUBLIC_PURCHASE', 'PublicPurchase', 'string', CreoleTypes::VARCHAR, true, 1);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 