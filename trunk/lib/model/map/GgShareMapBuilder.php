<?php



class GgShareMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.GgShareMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('gg_share');
		$tMap->setPhpName('GgShare');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UID', 'Uid', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('ACCOUNT_TYPE', 'AccountType', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('TOTAL_UNIT', 'TotalUnit', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('ORIGINAL_TOTAL_UNIT', 'OriginalTotalUnit', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('BUY_PRICE', 'BuyPrice', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('SELL_PRICE', 'SellPrice', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('BUY_DATE', 'BuyDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('SELL_DATE', 'SellDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('TRADE_DATE', 'TradeDate', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('REPLICA', 'Replica', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addColumn('STATUS', 'Status', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addColumn('SELLING_DATETIME', 'SellingDatetime', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 