<?php



class GgMemberWithdrawMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.GgMemberWithdrawMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('gg_member_withdraw');
		$tMap->setPhpName('GgMemberWithdraw');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('UID', 'Uid', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('AMOUNT', 'Amount', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('WITHDRAW_AMOUNT', 'WithdrawAmount', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('CHARGES', 'Charges', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('RATE', 'Rate', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('CONVERT_AMOUNT', 'ConvertAmount', 'double', CreoleTypes::DECIMAL, true, 15);

		$tMap->addColumn('PAYMENT_TYPE', 'PaymentType', 'string', CreoleTypes::VARCHAR, false, 1);

		$tMap->addColumn('BANK_NAME', 'BankName', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('BANK_BRANCH_NAME', 'BankBranchName', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('BANK_ADDRESS', 'BankAddress', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BANK_ACC_NO', 'BankAccNo', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('BANK_HOLDER_NAME', 'BankHolderName', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('BANK_SWIFT_CODE', 'BankSwiftCode', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('IACCOUNT', 'Iaccount', 'string', CreoleTypes::VARCHAR, false, 45);

		$tMap->addColumn('IACCOUNT_USERNAME', 'IaccountUsername', 'string', CreoleTypes::VARCHAR, false, 200);

		$tMap->addColumn('PAYMENT_DATE', 'PaymentDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PAYMENT_REMARK', 'PaymentRemark', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('REMARK', 'Remark', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('AUTOWIT', 'Autowit', 'string', CreoleTypes::VARCHAR, false, 1);

		$tMap->addColumn('STATUS', 'Status', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('CDATE', 'Cdate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LEADER_DIST_ID', 'LeaderDistId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('BRANCH_CODE', 'BranchCode', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('ABA_ROUTING', 'AbaRouting', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('BSB_CODE', 'BsbCode', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('TRANSIT_NUMBER', 'TransitNumber', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('IBAN', 'Iban', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('ACCOUNT_TYPE', 'AccountType', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('BANK_ACCOUNT_CURRENCY', 'BankAccountCurrency', 'string', CreoleTypes::VARCHAR, false, 100);

	} 
} 