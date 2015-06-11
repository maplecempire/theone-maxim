<?php



class GgMemberRt2walletRecordMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.GgMemberRt2walletRecordMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('gg_member_rt2wallet_record');
		$tMap->setPhpName('GgMemberRt2walletRecord');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('UID', 'Uid', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('AID', 'Aid', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('ACTION_TYPE', 'ActionType', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('CREDIT', 'Credit', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('DEBIT', 'Debit', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('BALANCE', 'Balance', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('DESCR', 'Descr', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('CDATE', 'Cdate', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 