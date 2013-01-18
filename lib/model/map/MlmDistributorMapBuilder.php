<?php



class MlmDistributorMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MlmDistributorMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('mlm_distributor');
		$tMap->setPhpName('MlmDistributor');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('DISTRIBUTOR_ID', 'DistributorId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DISTRIBUTOR_CODE', 'DistributorCode', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('STATUS_CODE', 'StatusCode', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('FULL_NAME', 'FullName', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('NICKNAME', 'Nickname', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('IC', 'Ic', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('COUNTRY', 'Country', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('ADDRESS', 'Address', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('ADDRESS2', 'Address2', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('CITY', 'City', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('STATE', 'State', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('POSTCODE', 'Postcode', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('ALTERNATE_EMAIL', 'AlternateEmail', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('CONTACT', 'Contact', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('GENDER', 'Gender', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('DOB', 'Dob', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('BANK_NAME', 'BankName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('BANK_ACC_NO', 'BankAccNo', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('BANK_HOLDER_NAME', 'BankHolderName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('BANK_SWIFT_CODE', 'BankSwiftCode', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('VISA_DEBIT_CARD', 'VisaDebitCard', 'string', CreoleTypes::VARCHAR, false, 18);

		$tMap->addColumn('TREE_LEVEL', 'TreeLevel', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TREE_STRUCTURE', 'TreeStructure', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('PLACEMENT_TREE_LEVEL', 'PlacementTreeLevel', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PLACEMENT_TREE_STRUCTURE', 'PlacementTreeStructure', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('INIT_RANK_ID', 'InitRankId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INIT_RANK_CODE', 'InitRankCode', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('UPLINE_DIST_ID', 'UplineDistId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('UPLINE_DIST_CODE', 'UplineDistCode', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('TREE_UPLINE_DIST_ID', 'TreeUplineDistId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TREE_UPLINE_DIST_CODE', 'TreeUplineDistCode', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('TOTAL_LEFT', 'TotalLeft', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TOTAL_RIGHT', 'TotalRight', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PLACEMENT_POSITION', 'PlacementPosition', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('PLACEMENT_DATETIME', 'PlacementDatetime', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('RANK_ID', 'RankId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('RANK_CODE', 'RankCode', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('ACTIVE_DATETIME', 'ActiveDatetime', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('ACTIVATED_BY', 'ActivatedBy', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('LEVERAGE', 'Leverage', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('SPREAD', 'Spread', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('DEPOSIT_CURRENCY', 'DepositCurrency', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('DEPOSIT_AMOUNT', 'DepositAmount', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('SIGN_NAME', 'SignName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('SIGN_DATE', 'SignDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('TERM_CONDITION', 'TermCondition', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('IB_COMMISSION', 'IbCommission', 'double', CreoleTypes::DECIMAL, true, 12);

		$tMap->addColumn('IS_IB', 'IsIb', 'string', CreoleTypes::VARCHAR, true, 1);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('PACKAGE_PURCHASE_FLAG', 'PackagePurchaseFlag', 'string', CreoleTypes::VARCHAR, true, 1);

		$tMap->addColumn('FILE_BANK_PASS_BOOK', 'FileBankPassBook', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('FILE_PROOF_OF_RESIDENCE', 'FileProofOfResidence', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('FILE_NRIC', 'FileNric', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('EXCLUDED_STRUCTURE', 'ExcludedStructure', 'string', CreoleTypes::VARCHAR, false, 1);

		$tMap->addColumn('PRODUCT_MTE', 'ProductMte', 'string', CreoleTypes::VARCHAR, false, 1);

		$tMap->addColumn('PRODUCT_FXGOLD', 'ProductFxgold', 'string', CreoleTypes::VARCHAR, false, 1);

		$tMap->addColumn('REMARK', 'Remark', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('LOAN_ACCOUNT', 'LoanAccount', 'string', CreoleTypes::VARCHAR, false, 1);

	} 
} 