<?php



class MlmEventCalendarMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MlmEventCalendarMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('mlm_event_calendar');
		$tMap->setPhpName('MlmEventCalendar');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('EVENT_TITLE', 'EventTitle', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('EVENT_DETAIL', 'EventDetail', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('DATE_START', 'DateStart', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('DATE_END', 'DateEnd', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('ALL_DAY', 'AllDay', 'string', CreoleTypes::VARCHAR, false, 1);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 