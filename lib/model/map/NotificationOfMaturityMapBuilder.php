<?php



class NotificationOfMaturityMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.NotificationOfMaturityMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('notification_of_maturity');
		$tMap->setPhpName('NotificationOfMaturity');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('NOTICE_ID', 'NoticeId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DIST_ID', 'DistId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MT4_USER_NAME', 'Mt4UserName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DIVIDEND_DATE', 'DividendDate', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('MATURITY_TYPE', 'MaturityType', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('RETRY', 'Retry', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('REMARK', 'Remark', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('STATUS_CODE', 'StatusCode', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 