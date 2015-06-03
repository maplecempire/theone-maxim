<?php



class SssApplicationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SssApplicationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sss_application');
		$tMap->setPhpName('SssApplication');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('SSS_ID', 'SssId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DIST_ID', 'DistId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DIVIDEND_ID', 'DividendId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MT4_USER_NAME', 'Mt4UserName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('CP2_BALANCE', 'Cp2Balance', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('CP3_BALANCE', 'Cp3Balance', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('MT4_BALANCE', 'Mt4Balance', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('ROI_REMAINING_MONTH', 'RoiRemainingMonth', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ROI_PERCENTAGE', 'RoiPercentage', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3', 'TotalAmountConvertedWithCp2cp3', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('SHARE_VALUE', 'ShareValue', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('TOTAL_SHARE_CONVERTED', 'TotalShareConverted', 'double', CreoleTypes::DECIMAL, false, 12);

		$tMap->addColumn('SIGNATURE', 'Signature', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('REMARKS', 'Remarks', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('STATUS_CODE', 'StatusCode', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('SWAP_TYPE', 'SwapType', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 