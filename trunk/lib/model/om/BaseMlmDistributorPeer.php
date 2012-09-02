<?php


abstract class BaseMlmDistributorPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_distributor';

	
	const CLASS_DEFAULT = 'lib.model.MlmDistributor';

	
	const NUM_COLUMNS = 56;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const DISTRIBUTOR_ID = 'mlm_distributor.DISTRIBUTOR_ID';

	
	const DISTRIBUTOR_CODE = 'mlm_distributor.DISTRIBUTOR_CODE';

	
	const USER_ID = 'mlm_distributor.USER_ID';

	
	const STATUS_CODE = 'mlm_distributor.STATUS_CODE';

	
	const FULL_NAME = 'mlm_distributor.FULL_NAME';

	
	const NICKNAME = 'mlm_distributor.NICKNAME';

	
	const IC = 'mlm_distributor.IC';

	
	const COUNTRY = 'mlm_distributor.COUNTRY';

	
	const ADDRESS = 'mlm_distributor.ADDRESS';

	
	const ADDRESS2 = 'mlm_distributor.ADDRESS2';

	
	const CITY = 'mlm_distributor.CITY';

	
	const STATE = 'mlm_distributor.STATE';

	
	const POSTCODE = 'mlm_distributor.POSTCODE';

	
	const EMAIL = 'mlm_distributor.EMAIL';

	
	const ALTERNATE_EMAIL = 'mlm_distributor.ALTERNATE_EMAIL';

	
	const CONTACT = 'mlm_distributor.CONTACT';

	
	const GENDER = 'mlm_distributor.GENDER';

	
	const DOB = 'mlm_distributor.DOB';

	
	const BANK_NAME = 'mlm_distributor.BANK_NAME';

	
	const BANK_ACC_NO = 'mlm_distributor.BANK_ACC_NO';

	
	const BANK_HOLDER_NAME = 'mlm_distributor.BANK_HOLDER_NAME';

	
	const BANK_SWIFT_CODE = 'mlm_distributor.BANK_SWIFT_CODE';

	
	const VISA_DEBIT_CARD = 'mlm_distributor.VISA_DEBIT_CARD';

	
	const TREE_LEVEL = 'mlm_distributor.TREE_LEVEL';

	
	const TREE_STRUCTURE = 'mlm_distributor.TREE_STRUCTURE';

	
	const INIT_RANK_ID = 'mlm_distributor.INIT_RANK_ID';

	
	const INIT_RANK_CODE = 'mlm_distributor.INIT_RANK_CODE';

	
	const UPLINE_DIST_ID = 'mlm_distributor.UPLINE_DIST_ID';

	
	const UPLINE_DIST_CODE = 'mlm_distributor.UPLINE_DIST_CODE';

	
	const TREE_UPLINE_DIST_ID = 'mlm_distributor.TREE_UPLINE_DIST_ID';

	
	const TREE_UPLINE_DIST_CODE = 'mlm_distributor.TREE_UPLINE_DIST_CODE';

	
	const TOTAL_LEFT = 'mlm_distributor.TOTAL_LEFT';

	
	const TOTAL_RIGHT = 'mlm_distributor.TOTAL_RIGHT';

	
	const PLACEMENT_POSITION = 'mlm_distributor.PLACEMENT_POSITION';

	
	const PLACEMENT_DATETIME = 'mlm_distributor.PLACEMENT_DATETIME';

	
	const RANK_ID = 'mlm_distributor.RANK_ID';

	
	const RANK_CODE = 'mlm_distributor.RANK_CODE';

	
	const ACTIVE_DATETIME = 'mlm_distributor.ACTIVE_DATETIME';

	
	const ACTIVATED_BY = 'mlm_distributor.ACTIVATED_BY';

	
	const LEVERAGE = 'mlm_distributor.LEVERAGE';

	
	const SPREAD = 'mlm_distributor.SPREAD';

	
	const DEPOSIT_CURRENCY = 'mlm_distributor.DEPOSIT_CURRENCY';

	
	const DEPOSIT_AMOUNT = 'mlm_distributor.DEPOSIT_AMOUNT';

	
	const SIGN_NAME = 'mlm_distributor.SIGN_NAME';

	
	const SIGN_DATE = 'mlm_distributor.SIGN_DATE';

	
	const TERM_CONDITION = 'mlm_distributor.TERM_CONDITION';

	
	const IB_COMMISSION = 'mlm_distributor.IB_COMMISSION';

	
	const IS_IB = 'mlm_distributor.IS_IB';

	
	const CREATED_BY = 'mlm_distributor.CREATED_BY';

	
	const CREATED_ON = 'mlm_distributor.CREATED_ON';

	
	const UPDATED_BY = 'mlm_distributor.UPDATED_BY';

	
	const UPDATED_ON = 'mlm_distributor.UPDATED_ON';

	
	const PACKAGE_PURCHASE_FLAG = 'mlm_distributor.PACKAGE_PURCHASE_FLAG';

	
	const FILE_BANK_PASS_BOOK = 'mlm_distributor.FILE_BANK_PASS_BOOK';

	
	const FILE_PROOF_OF_RESIDENCE = 'mlm_distributor.FILE_PROOF_OF_RESIDENCE';

	
	const FILE_NRIC = 'mlm_distributor.FILE_NRIC';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('DistributorId', 'DistributorCode', 'UserId', 'StatusCode', 'FullName', 'Nickname', 'Ic', 'Country', 'Address', 'Address2', 'City', 'State', 'Postcode', 'Email', 'AlternateEmail', 'Contact', 'Gender', 'Dob', 'BankName', 'BankAccNo', 'BankHolderName', 'BankSwiftCode', 'VisaDebitCard', 'TreeLevel', 'TreeStructure', 'InitRankId', 'InitRankCode', 'UplineDistId', 'UplineDistCode', 'TreeUplineDistId', 'TreeUplineDistCode', 'TotalLeft', 'TotalRight', 'PlacementPosition', 'PlacementDatetime', 'RankId', 'RankCode', 'ActiveDatetime', 'ActivatedBy', 'Leverage', 'Spread', 'DepositCurrency', 'DepositAmount', 'SignName', 'SignDate', 'TermCondition', 'IbCommission', 'IsIb', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', 'PackagePurchaseFlag', 'FileBankPassBook', 'FileProofOfResidence', 'FileNric', ),
		BasePeer::TYPE_COLNAME => array (MlmDistributorPeer::DISTRIBUTOR_ID, MlmDistributorPeer::DISTRIBUTOR_CODE, MlmDistributorPeer::USER_ID, MlmDistributorPeer::STATUS_CODE, MlmDistributorPeer::FULL_NAME, MlmDistributorPeer::NICKNAME, MlmDistributorPeer::IC, MlmDistributorPeer::COUNTRY, MlmDistributorPeer::ADDRESS, MlmDistributorPeer::ADDRESS2, MlmDistributorPeer::CITY, MlmDistributorPeer::STATE, MlmDistributorPeer::POSTCODE, MlmDistributorPeer::EMAIL, MlmDistributorPeer::ALTERNATE_EMAIL, MlmDistributorPeer::CONTACT, MlmDistributorPeer::GENDER, MlmDistributorPeer::DOB, MlmDistributorPeer::BANK_NAME, MlmDistributorPeer::BANK_ACC_NO, MlmDistributorPeer::BANK_HOLDER_NAME, MlmDistributorPeer::BANK_SWIFT_CODE, MlmDistributorPeer::VISA_DEBIT_CARD, MlmDistributorPeer::TREE_LEVEL, MlmDistributorPeer::TREE_STRUCTURE, MlmDistributorPeer::INIT_RANK_ID, MlmDistributorPeer::INIT_RANK_CODE, MlmDistributorPeer::UPLINE_DIST_ID, MlmDistributorPeer::UPLINE_DIST_CODE, MlmDistributorPeer::TREE_UPLINE_DIST_ID, MlmDistributorPeer::TREE_UPLINE_DIST_CODE, MlmDistributorPeer::TOTAL_LEFT, MlmDistributorPeer::TOTAL_RIGHT, MlmDistributorPeer::PLACEMENT_POSITION, MlmDistributorPeer::PLACEMENT_DATETIME, MlmDistributorPeer::RANK_ID, MlmDistributorPeer::RANK_CODE, MlmDistributorPeer::ACTIVE_DATETIME, MlmDistributorPeer::ACTIVATED_BY, MlmDistributorPeer::LEVERAGE, MlmDistributorPeer::SPREAD, MlmDistributorPeer::DEPOSIT_CURRENCY, MlmDistributorPeer::DEPOSIT_AMOUNT, MlmDistributorPeer::SIGN_NAME, MlmDistributorPeer::SIGN_DATE, MlmDistributorPeer::TERM_CONDITION, MlmDistributorPeer::IB_COMMISSION, MlmDistributorPeer::IS_IB, MlmDistributorPeer::CREATED_BY, MlmDistributorPeer::CREATED_ON, MlmDistributorPeer::UPDATED_BY, MlmDistributorPeer::UPDATED_ON, MlmDistributorPeer::PACKAGE_PURCHASE_FLAG, MlmDistributorPeer::FILE_BANK_PASS_BOOK, MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE, MlmDistributorPeer::FILE_NRIC, ),
		BasePeer::TYPE_FIELDNAME => array ('distributor_id', 'distributor_code', 'user_id', 'status_code', 'full_name', 'nickname', 'ic', 'country', 'address', 'address2', 'city', 'state', 'postcode', 'email', 'alternate_email', 'contact', 'gender', 'dob', 'bank_name', 'bank_acc_no', 'bank_holder_name', 'bank_swift_code', 'visa_debit_card', 'tree_level', 'tree_structure', 'init_rank_id', 'init_rank_code', 'upline_dist_id', 'upline_dist_code', 'tree_upline_dist_id', 'tree_upline_dist_code', 'total_left', 'total_right', 'placement_position', 'placement_datetime', 'rank_id', 'rank_code', 'active_datetime', 'activated_by', 'leverage', 'spread', 'deposit_currency', 'deposit_amount', 'sign_name', 'sign_date', 'term_condition', 'ib_commission', 'is_ib', 'created_by', 'created_on', 'updated_by', 'updated_on', 'package_purchase_flag', 'file_bank_pass_book', 'file_proof_of_residence', 'file_nric', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DistributorId' => 0, 'DistributorCode' => 1, 'UserId' => 2, 'StatusCode' => 3, 'FullName' => 4, 'Nickname' => 5, 'Ic' => 6, 'Country' => 7, 'Address' => 8, 'Address2' => 9, 'City' => 10, 'State' => 11, 'Postcode' => 12, 'Email' => 13, 'AlternateEmail' => 14, 'Contact' => 15, 'Gender' => 16, 'Dob' => 17, 'BankName' => 18, 'BankAccNo' => 19, 'BankHolderName' => 20, 'BankSwiftCode' => 21, 'VisaDebitCard' => 22, 'TreeLevel' => 23, 'TreeStructure' => 24, 'InitRankId' => 25, 'InitRankCode' => 26, 'UplineDistId' => 27, 'UplineDistCode' => 28, 'TreeUplineDistId' => 29, 'TreeUplineDistCode' => 30, 'TotalLeft' => 31, 'TotalRight' => 32, 'PlacementPosition' => 33, 'PlacementDatetime' => 34, 'RankId' => 35, 'RankCode' => 36, 'ActiveDatetime' => 37, 'ActivatedBy' => 38, 'Leverage' => 39, 'Spread' => 40, 'DepositCurrency' => 41, 'DepositAmount' => 42, 'SignName' => 43, 'SignDate' => 44, 'TermCondition' => 45, 'IbCommission' => 46, 'IsIb' => 47, 'CreatedBy' => 48, 'CreatedOn' => 49, 'UpdatedBy' => 50, 'UpdatedOn' => 51, 'PackagePurchaseFlag' => 52, 'FileBankPassBook' => 53, 'FileProofOfResidence' => 54, 'FileNric' => 55, ),
		BasePeer::TYPE_COLNAME => array (MlmDistributorPeer::DISTRIBUTOR_ID => 0, MlmDistributorPeer::DISTRIBUTOR_CODE => 1, MlmDistributorPeer::USER_ID => 2, MlmDistributorPeer::STATUS_CODE => 3, MlmDistributorPeer::FULL_NAME => 4, MlmDistributorPeer::NICKNAME => 5, MlmDistributorPeer::IC => 6, MlmDistributorPeer::COUNTRY => 7, MlmDistributorPeer::ADDRESS => 8, MlmDistributorPeer::ADDRESS2 => 9, MlmDistributorPeer::CITY => 10, MlmDistributorPeer::STATE => 11, MlmDistributorPeer::POSTCODE => 12, MlmDistributorPeer::EMAIL => 13, MlmDistributorPeer::ALTERNATE_EMAIL => 14, MlmDistributorPeer::CONTACT => 15, MlmDistributorPeer::GENDER => 16, MlmDistributorPeer::DOB => 17, MlmDistributorPeer::BANK_NAME => 18, MlmDistributorPeer::BANK_ACC_NO => 19, MlmDistributorPeer::BANK_HOLDER_NAME => 20, MlmDistributorPeer::BANK_SWIFT_CODE => 21, MlmDistributorPeer::VISA_DEBIT_CARD => 22, MlmDistributorPeer::TREE_LEVEL => 23, MlmDistributorPeer::TREE_STRUCTURE => 24, MlmDistributorPeer::INIT_RANK_ID => 25, MlmDistributorPeer::INIT_RANK_CODE => 26, MlmDistributorPeer::UPLINE_DIST_ID => 27, MlmDistributorPeer::UPLINE_DIST_CODE => 28, MlmDistributorPeer::TREE_UPLINE_DIST_ID => 29, MlmDistributorPeer::TREE_UPLINE_DIST_CODE => 30, MlmDistributorPeer::TOTAL_LEFT => 31, MlmDistributorPeer::TOTAL_RIGHT => 32, MlmDistributorPeer::PLACEMENT_POSITION => 33, MlmDistributorPeer::PLACEMENT_DATETIME => 34, MlmDistributorPeer::RANK_ID => 35, MlmDistributorPeer::RANK_CODE => 36, MlmDistributorPeer::ACTIVE_DATETIME => 37, MlmDistributorPeer::ACTIVATED_BY => 38, MlmDistributorPeer::LEVERAGE => 39, MlmDistributorPeer::SPREAD => 40, MlmDistributorPeer::DEPOSIT_CURRENCY => 41, MlmDistributorPeer::DEPOSIT_AMOUNT => 42, MlmDistributorPeer::SIGN_NAME => 43, MlmDistributorPeer::SIGN_DATE => 44, MlmDistributorPeer::TERM_CONDITION => 45, MlmDistributorPeer::IB_COMMISSION => 46, MlmDistributorPeer::IS_IB => 47, MlmDistributorPeer::CREATED_BY => 48, MlmDistributorPeer::CREATED_ON => 49, MlmDistributorPeer::UPDATED_BY => 50, MlmDistributorPeer::UPDATED_ON => 51, MlmDistributorPeer::PACKAGE_PURCHASE_FLAG => 52, MlmDistributorPeer::FILE_BANK_PASS_BOOK => 53, MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE => 54, MlmDistributorPeer::FILE_NRIC => 55, ),
		BasePeer::TYPE_FIELDNAME => array ('distributor_id' => 0, 'distributor_code' => 1, 'user_id' => 2, 'status_code' => 3, 'full_name' => 4, 'nickname' => 5, 'ic' => 6, 'country' => 7, 'address' => 8, 'address2' => 9, 'city' => 10, 'state' => 11, 'postcode' => 12, 'email' => 13, 'alternate_email' => 14, 'contact' => 15, 'gender' => 16, 'dob' => 17, 'bank_name' => 18, 'bank_acc_no' => 19, 'bank_holder_name' => 20, 'bank_swift_code' => 21, 'visa_debit_card' => 22, 'tree_level' => 23, 'tree_structure' => 24, 'init_rank_id' => 25, 'init_rank_code' => 26, 'upline_dist_id' => 27, 'upline_dist_code' => 28, 'tree_upline_dist_id' => 29, 'tree_upline_dist_code' => 30, 'total_left' => 31, 'total_right' => 32, 'placement_position' => 33, 'placement_datetime' => 34, 'rank_id' => 35, 'rank_code' => 36, 'active_datetime' => 37, 'activated_by' => 38, 'leverage' => 39, 'spread' => 40, 'deposit_currency' => 41, 'deposit_amount' => 42, 'sign_name' => 43, 'sign_date' => 44, 'term_condition' => 45, 'ib_commission' => 46, 'is_ib' => 47, 'created_by' => 48, 'created_on' => 49, 'updated_by' => 50, 'updated_on' => 51, 'package_purchase_flag' => 52, 'file_bank_pass_book' => 53, 'file_proof_of_residence' => 54, 'file_nric' => 55, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MlmDistributorMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MlmDistributorMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MlmDistributorPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(MlmDistributorPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MlmDistributorPeer::DISTRIBUTOR_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::USER_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::STATUS_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::FULL_NAME);

		$criteria->addSelectColumn(MlmDistributorPeer::NICKNAME);

		$criteria->addSelectColumn(MlmDistributorPeer::IC);

		$criteria->addSelectColumn(MlmDistributorPeer::COUNTRY);

		$criteria->addSelectColumn(MlmDistributorPeer::ADDRESS);

		$criteria->addSelectColumn(MlmDistributorPeer::ADDRESS2);

		$criteria->addSelectColumn(MlmDistributorPeer::CITY);

		$criteria->addSelectColumn(MlmDistributorPeer::STATE);

		$criteria->addSelectColumn(MlmDistributorPeer::POSTCODE);

		$criteria->addSelectColumn(MlmDistributorPeer::EMAIL);

		$criteria->addSelectColumn(MlmDistributorPeer::ALTERNATE_EMAIL);

		$criteria->addSelectColumn(MlmDistributorPeer::CONTACT);

		$criteria->addSelectColumn(MlmDistributorPeer::GENDER);

		$criteria->addSelectColumn(MlmDistributorPeer::DOB);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_NAME);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_ACC_NO);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_HOLDER_NAME);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_SWIFT_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::VISA_DEBIT_CARD);

		$criteria->addSelectColumn(MlmDistributorPeer::TREE_LEVEL);

		$criteria->addSelectColumn(MlmDistributorPeer::TREE_STRUCTURE);

		$criteria->addSelectColumn(MlmDistributorPeer::INIT_RANK_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::INIT_RANK_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::UPLINE_DIST_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::UPLINE_DIST_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::TREE_UPLINE_DIST_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::TREE_UPLINE_DIST_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::TOTAL_LEFT);

		$criteria->addSelectColumn(MlmDistributorPeer::TOTAL_RIGHT);

		$criteria->addSelectColumn(MlmDistributorPeer::PLACEMENT_POSITION);

		$criteria->addSelectColumn(MlmDistributorPeer::PLACEMENT_DATETIME);

		$criteria->addSelectColumn(MlmDistributorPeer::RANK_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::RANK_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::ACTIVE_DATETIME);

		$criteria->addSelectColumn(MlmDistributorPeer::ACTIVATED_BY);

		$criteria->addSelectColumn(MlmDistributorPeer::LEVERAGE);

		$criteria->addSelectColumn(MlmDistributorPeer::SPREAD);

		$criteria->addSelectColumn(MlmDistributorPeer::DEPOSIT_CURRENCY);

		$criteria->addSelectColumn(MlmDistributorPeer::DEPOSIT_AMOUNT);

		$criteria->addSelectColumn(MlmDistributorPeer::SIGN_NAME);

		$criteria->addSelectColumn(MlmDistributorPeer::SIGN_DATE);

		$criteria->addSelectColumn(MlmDistributorPeer::TERM_CONDITION);

		$criteria->addSelectColumn(MlmDistributorPeer::IB_COMMISSION);

		$criteria->addSelectColumn(MlmDistributorPeer::IS_IB);

		$criteria->addSelectColumn(MlmDistributorPeer::CREATED_BY);

		$criteria->addSelectColumn(MlmDistributorPeer::CREATED_ON);

		$criteria->addSelectColumn(MlmDistributorPeer::UPDATED_BY);

		$criteria->addSelectColumn(MlmDistributorPeer::UPDATED_ON);

		$criteria->addSelectColumn(MlmDistributorPeer::PACKAGE_PURCHASE_FLAG);

		$criteria->addSelectColumn(MlmDistributorPeer::FILE_BANK_PASS_BOOK);

		$criteria->addSelectColumn(MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE);

		$criteria->addSelectColumn(MlmDistributorPeer::FILE_NRIC);

	}

	const COUNT = 'COUNT(mlm_distributor.DISTRIBUTOR_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT mlm_distributor.DISTRIBUTOR_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		
		$criteria = clone $criteria;

		
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MlmDistributorPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MlmDistributorPeer::COUNT);
		}

		
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MlmDistributorPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			
			return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = MlmDistributorPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MlmDistributorPeer::populateObjects(MlmDistributorPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MlmDistributorPeer::addSelectColumns($criteria);
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		
		
		return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
		
		$cls = MlmDistributorPeer::getOMClass();
		$cls = Propel::import($cls);
		
		while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return MlmDistributorPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
		} else {
			$criteria = $values->buildCriteria(); 
		}

		$criteria->remove(MlmDistributorPeer::DISTRIBUTOR_ID); 


		
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			
			
			$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 

			$comparison = $criteria->getComparison(MlmDistributorPeer::DISTRIBUTOR_ID);
			$selectCriteria->add(MlmDistributorPeer::DISTRIBUTOR_ID, $criteria->remove(MlmDistributorPeer::DISTRIBUTOR_ID), $comparison);

		} else { 
			$criteria = $values->buildCriteria(); 
			$selectCriteria = $values->buildPkeyCriteria(); 
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 
		try {
			
			
			$con->begin();
			$affectedRows += BasePeer::doDeleteAll(MlmDistributorPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
		} elseif ($values instanceof MlmDistributor) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MlmDistributorPeer::DISTRIBUTOR_ID, (array) $values, Criteria::IN);
		}

		
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 

		try {
			
			
			$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(MlmDistributor $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MlmDistributorPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MlmDistributorPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(MlmDistributorPeer::DATABASE_NAME, MlmDistributorPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MlmDistributorPeer::DATABASE_NAME);

		$criteria->add(MlmDistributorPeer::DISTRIBUTOR_ID, $pk);


		$v = MlmDistributorPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(MlmDistributorPeer::DISTRIBUTOR_ID, $pks, Criteria::IN);
			$objs = MlmDistributorPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 


if (Propel::isInit()) {
	
	
	try {
		BaseMlmDistributorPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	
	
	require_once 'lib/model/map/MlmDistributorMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MlmDistributorMapBuilder');
}
