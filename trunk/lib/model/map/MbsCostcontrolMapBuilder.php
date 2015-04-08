<?php



class MbsCostcontrolMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MbsCostcontrolMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('mbs_costcontrol');
		$tMap->setPhpName('MbsCostcontrol');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('MBS_ID', 'MbsId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('IDX', 'Idx', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DESCRIPTION_OF_EXPENDITURE', 'DescriptionOfExpenditure', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('BUDGET', 'Budget', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('SERVICE_CHARGE', 'ServiceCharge', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('GST', 'Gst', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('TOTAL_NETT_AMOUNT', 'TotalNettAmount', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('PAYMENTS_MADE', 'PaymentsMade', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('BALANCE_PAYABLE', 'BalancePayable', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('REMARKS', 'Remarks', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 