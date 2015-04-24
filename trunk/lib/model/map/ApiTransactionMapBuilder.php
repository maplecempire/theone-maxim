<?php



class ApiTransactionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ApiTransactionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('api_transaction');
		$tMap->setPhpName('ApiTransaction');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('TRANSACTION_ID', 'TransactionId', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('ACCESS_IP', 'AccessIp', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('USER_ID', 'UserId', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('TRANSACTION_ACTION', 'TransactionAction', 'string', CreoleTypes::VARCHAR, true, 150);

		$tMap->addColumn('TRANSACTION_DATA', 'TransactionData', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('REMARK', 'Remark', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('STATUS_CODE', 'StatusCode', 'string', CreoleTypes::VARCHAR, true, 150);

		$tMap->addColumn('TOKEN', 'Token', 'string', CreoleTypes::VARCHAR, true, 150);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 