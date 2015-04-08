<?php



class AppNewsMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.AppNewsMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('app_news');
		$tMap->setPhpName('AppNews');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('NS_TITLE', 'NsTitle', 'string', CreoleTypes::VARCHAR, true, 500);

		$tMap->addColumn('NS_CONTENT', 'NsContent', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('NS_STATUS', 'NsStatus', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('NS_START_DATE', 'NsStartDate', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('NS_END_DATE', 'NsEndDate', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 