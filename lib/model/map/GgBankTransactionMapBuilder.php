<?php



class GgBankTransactionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.GgBankTransactionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('gg_bank_transaction');
		$tMap->setPhpName('GgBankTransaction');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('FILENAME', 'Filename', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BANK_IN_TO', 'BankInTo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CURRENCY', 'Currency', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('AMOUNT', 'Amount', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('ESWALLET', 'Eswallet', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('BANKIN_STATUS', 'BankinStatus', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('BDATE', 'Bdate', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('ADATE', 'Adate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('CDATE', 'Cdate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('CREATE_BY', 'CreateBy', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('APPROVE_BY', 'ApproveBy', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('REMARK1', 'Remark1', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('REMARK2', 'Remark2', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('STATUS', 'Status', 'string', CreoleTypes::VARCHAR, false, 10);

	} 
} 