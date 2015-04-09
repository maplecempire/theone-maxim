<?php


abstract class BaseMlmDistributorPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'mlm_distributor';

	
	const CLASS_DEFAULT = 'lib.model.MlmDistributor';

	
	const NUM_COLUMNS = 141;

	
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

	
	const BANK_BRANCH_NAME = 'mlm_distributor.BANK_BRANCH_NAME';

	
	const BANK_ADDRESS = 'mlm_distributor.BANK_ADDRESS';

	
	const BANK_ACC_NO = 'mlm_distributor.BANK_ACC_NO';

	
	const BANK_HOLDER_NAME = 'mlm_distributor.BANK_HOLDER_NAME';

	
	const BANK_SWIFT_CODE = 'mlm_distributor.BANK_SWIFT_CODE';

	
	const BRANCH_CODE = 'mlm_distributor.BRANCH_CODE';

	
	const ABA_ROUTING = 'mlm_distributor.ABA_ROUTING';

	
	const BSB_CODE = 'mlm_distributor.BSB_CODE';

	
	const TRANSIT_NUMBER = 'mlm_distributor.TRANSIT_NUMBER';

	
	const IBAN = 'mlm_distributor.IBAN';

	
	const ACCOUNT_TYPE = 'mlm_distributor.ACCOUNT_TYPE';

	
	const BANK_CODE = 'mlm_distributor.BANK_CODE';

	
	const BANK_COUNTRY = 'mlm_distributor.BANK_COUNTRY';

	
	const BANK_ACCOUNT_CURRENCY = 'mlm_distributor.BANK_ACCOUNT_CURRENCY';

	
	const VISA_DEBIT_CARD = 'mlm_distributor.VISA_DEBIT_CARD';

	
	const EZY_CASH_CARD = 'mlm_distributor.EZY_CASH_CARD';

	
	const IACCOUNT = 'mlm_distributor.IACCOUNT';

	
	const IACCOUNT_USERNAME = 'mlm_distributor.IACCOUNT_USERNAME';

	
	const TREE_LEVEL = 'mlm_distributor.TREE_LEVEL';

	
	const TREE_STRUCTURE = 'mlm_distributor.TREE_STRUCTURE';

	
	const PLACEMENT_TREE_LEVEL = 'mlm_distributor.PLACEMENT_TREE_LEVEL';

	
	const PLACEMENT_TREE_STRUCTURE = 'mlm_distributor.PLACEMENT_TREE_STRUCTURE';

	
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

	
	const EXCLUDED_STRUCTURE = 'mlm_distributor.EXCLUDED_STRUCTURE';

	
	const PRODUCT_MTE = 'mlm_distributor.PRODUCT_MTE';

	
	const PRODUCT_FXGOLD = 'mlm_distributor.PRODUCT_FXGOLD';

	
	const REMARK = 'mlm_distributor.REMARK';

	
	const LOAN_ACCOUNT = 'mlm_distributor.LOAN_ACCOUNT';

	
	const SELF_REGISTER = 'mlm_distributor.SELF_REGISTER';

	
	const DEBIT_ACCOUNT = 'mlm_distributor.DEBIT_ACCOUNT';

	
	const DEBIT_RANK_ID = 'mlm_distributor.DEBIT_RANK_ID';

	
	const DEBIT_STATUS_CODE = 'mlm_distributor.DEBIT_STATUS_CODE';

	
	const HIDE_GENEALOGY = 'mlm_distributor.HIDE_GENEALOGY';

	
	const FROM_ABFX = 'mlm_distributor.FROM_ABFX';

	
	const ABFX_USER_ID = 'mlm_distributor.ABFX_USER_ID';

	
	const ABFX_REF = 'mlm_distributor.ABFX_REF';

	
	const ABFX_UPLINE1 = 'mlm_distributor.ABFX_UPLINE1';

	
	const ABFX_POSITION = 'mlm_distributor.ABFX_POSITION';

	
	const ABFX_REMARK = 'mlm_distributor.ABFX_REMARK';

	
	const ABFX_EWALLET = 'mlm_distributor.ABFX_EWALLET';

	
	const ABFX_EPOINT = 'mlm_distributor.ABFX_EPOINT';

	
	const ABFX_PAIRING_LEFT = 'mlm_distributor.ABFX_PAIRING_LEFT';

	
	const ABFX_PAIRING_RIGHT = 'mlm_distributor.ABFX_PAIRING_RIGHT';

	
	const MIGRATED_STATUS = 'mlm_distributor.MIGRATED_STATUS';

	
	const MIGRATED_PLACEMENT_STATUS = 'mlm_distributor.MIGRATED_PLACEMENT_STATUS';

	
	const MIGRATE_RETRY = 'mlm_distributor.MIGRATE_RETRY';

	
	const NOMINEE_NAME = 'mlm_distributor.NOMINEE_NAME';

	
	const NOMINEE_IC = 'mlm_distributor.NOMINEE_IC';

	
	const NOMINEE_RELATIONSHIP = 'mlm_distributor.NOMINEE_RELATIONSHIP';

	
	const NOMINEE_CONTACTNO = 'mlm_distributor.NOMINEE_CONTACTNO';

	
	const NEW_ACTIVITY_FLAG = 'mlm_distributor.NEW_ACTIVITY_FLAG';

	
	const NEW_REPORT_FLAG = 'mlm_distributor.NEW_REPORT_FLAG';

	
	const Q3_CHAMPIONS = 'mlm_distributor.Q3_CHAMPIONS';

	
	const Q3_DATETIME = 'mlm_distributor.Q3_DATETIME';

	
	const EMAIL_STATUS = 'mlm_distributor.EMAIL_STATUS';

	
	const BKK_PACKAGE_PURCHASE = 'mlm_distributor.BKK_PACKAGE_PURCHASE';

	
	const BKK_QUALIFY_1 = 'mlm_distributor.BKK_QUALIFY_1';

	
	const BKK_QUALIFY_2 = 'mlm_distributor.BKK_QUALIFY_2';

	
	const BKK_PERSONAL_SALES = 'mlm_distributor.BKK_PERSONAL_SALES';

	
	const BKK_QUALIFY_3 = 'mlm_distributor.BKK_QUALIFY_3';

	
	const BKK_STATUS = 'mlm_distributor.BKK_STATUS';

	
	const MONEYTRAC_CUSTOMER_ID = 'mlm_distributor.MONEYTRAC_CUSTOMER_ID';

	
	const MONEYTRAC_USERNAME = 'mlm_distributor.MONEYTRAC_USERNAME';

	
	const PREFER_LANGUAGE = 'mlm_distributor.PREFER_LANGUAGE';

	
	const NORMAL_INVESTOR = 'mlm_distributor.NORMAL_INVESTOR';

	
	const PRINCIPLE_RETURN = 'mlm_distributor.PRINCIPLE_RETURN';

	
	const LEADER_ID = 'mlm_distributor.LEADER_ID';

	
	const CLOSE_ACCOUNT = 'mlm_distributor.CLOSE_ACCOUNT';

	
	const SECONDTIME_RENEWAL = 'mlm_distributor.SECONDTIME_RENEWAL';

	
	const ESWALLET = 'mlm_distributor.ESWALLET';

	
	const EWALLET = 'mlm_distributor.EWALLET';

	
	const CWALLET = 'mlm_distributor.CWALLET';

	
	const MWALLET = 'mlm_distributor.MWALLET';

	
	const OWALLET = 'mlm_distributor.OWALLET';

	
	const SWALLET = 'mlm_distributor.SWALLET';

	
	const PWALLET = 'mlm_distributor.PWALLET';

	
	const RWALLET = 'mlm_distributor.RWALLET';

	
	const TWALLET = 'mlm_distributor.TWALLET';

	
	const RTWALLET = 'mlm_distributor.RTWALLET';

	
	const RPFWALLET = 'mlm_distributor.RPFWALLET';

	
	const RANK_A = 'mlm_distributor.RANK_A';

	
	const IS_AGL = 'mlm_distributor.IS_AGL';

	
	const IOUWALLET = 'mlm_distributor.IOUWALLET';

	
	const OWALLET_20141214 = 'mlm_distributor.OWALLET_20141214';

	
	const RWALLET_20141214 = 'mlm_distributor.RWALLET_20141214';

	
	const SHORTNAME = 'mlm_distributor.SHORTNAME';

	
	const IS_BLOCK = 'mlm_distributor.IS_BLOCK';

	
	const FULL_RT = 'mlm_distributor.FULL_RT';

	
	const KYC_STATUS = 'mlm_distributor.KYC_STATUS';

	
	const KYC_REMARK = 'mlm_distributor.KYC_REMARK';

	
	const KYC_USER_ID = 'mlm_distributor.KYC_USER_ID';

	
	const KYC_DATETIME = 'mlm_distributor.KYC_DATETIME';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('DistributorId', 'DistributorCode', 'UserId', 'StatusCode', 'FullName', 'Nickname', 'Ic', 'Country', 'Address', 'Address2', 'City', 'State', 'Postcode', 'Email', 'AlternateEmail', 'Contact', 'Gender', 'Dob', 'BankName', 'BankBranchName', 'BankAddress', 'BankAccNo', 'BankHolderName', 'BankSwiftCode', 'BranchCode', 'AbaRouting', 'BsbCode', 'TransitNumber', 'Iban', 'AccountType', 'BankCode', 'BankCountry', 'BankAccountCurrency', 'VisaDebitCard', 'EzyCashCard', 'Iaccount', 'IaccountUsername', 'TreeLevel', 'TreeStructure', 'PlacementTreeLevel', 'PlacementTreeStructure', 'InitRankId', 'InitRankCode', 'UplineDistId', 'UplineDistCode', 'TreeUplineDistId', 'TreeUplineDistCode', 'TotalLeft', 'TotalRight', 'PlacementPosition', 'PlacementDatetime', 'RankId', 'RankCode', 'ActiveDatetime', 'ActivatedBy', 'Leverage', 'Spread', 'DepositCurrency', 'DepositAmount', 'SignName', 'SignDate', 'TermCondition', 'IbCommission', 'IsIb', 'CreatedBy', 'CreatedOn', 'UpdatedBy', 'UpdatedOn', 'PackagePurchaseFlag', 'FileBankPassBook', 'FileProofOfResidence', 'FileNric', 'ExcludedStructure', 'ProductMte', 'ProductFxgold', 'Remark', 'LoanAccount', 'SelfRegister', 'DebitAccount', 'DebitRankId', 'DebitStatusCode', 'HideGenealogy', 'FromAbfx', 'AbfxUserId', 'AbfxRef', 'AbfxUpline1', 'AbfxPosition', 'AbfxRemark', 'AbfxEwallet', 'AbfxEpoint', 'AbfxPairingLeft', 'AbfxPairingRight', 'MigratedStatus', 'MigratedPlacementStatus', 'MigrateRetry', 'NomineeName', 'NomineeIc', 'NomineeRelationship', 'NomineeContactno', 'NewActivityFlag', 'NewReportFlag', 'Q3Champions', 'Q3Datetime', 'EmailStatus', 'BkkPackagePurchase', 'BkkQualify1', 'BkkQualify2', 'BkkPersonalSales', 'BkkQualify3', 'BkkStatus', 'MoneytracCustomerId', 'MoneytracUsername', 'PreferLanguage', 'NormalInvestor', 'PrincipleReturn', 'LeaderId', 'CloseAccount', 'SecondtimeRenewal', 'Eswallet', 'Ewallet', 'Cwallet', 'Mwallet', 'Owallet', 'Swallet', 'Pwallet', 'Rwallet', 'Twallet', 'Rtwallet', 'Rpfwallet', 'RankA', 'IsAgl', 'Iouwallet', 'Owallet20141214', 'Rwallet20141214', 'Shortname', 'IsBlock', 'FullRt', 'KycStatus', 'KycRemark', 'KycUserId', 'KycDatetime', ),
		BasePeer::TYPE_COLNAME => array (MlmDistributorPeer::DISTRIBUTOR_ID, MlmDistributorPeer::DISTRIBUTOR_CODE, MlmDistributorPeer::USER_ID, MlmDistributorPeer::STATUS_CODE, MlmDistributorPeer::FULL_NAME, MlmDistributorPeer::NICKNAME, MlmDistributorPeer::IC, MlmDistributorPeer::COUNTRY, MlmDistributorPeer::ADDRESS, MlmDistributorPeer::ADDRESS2, MlmDistributorPeer::CITY, MlmDistributorPeer::STATE, MlmDistributorPeer::POSTCODE, MlmDistributorPeer::EMAIL, MlmDistributorPeer::ALTERNATE_EMAIL, MlmDistributorPeer::CONTACT, MlmDistributorPeer::GENDER, MlmDistributorPeer::DOB, MlmDistributorPeer::BANK_NAME, MlmDistributorPeer::BANK_BRANCH_NAME, MlmDistributorPeer::BANK_ADDRESS, MlmDistributorPeer::BANK_ACC_NO, MlmDistributorPeer::BANK_HOLDER_NAME, MlmDistributorPeer::BANK_SWIFT_CODE, MlmDistributorPeer::BRANCH_CODE, MlmDistributorPeer::ABA_ROUTING, MlmDistributorPeer::BSB_CODE, MlmDistributorPeer::TRANSIT_NUMBER, MlmDistributorPeer::IBAN, MlmDistributorPeer::ACCOUNT_TYPE, MlmDistributorPeer::BANK_CODE, MlmDistributorPeer::BANK_COUNTRY, MlmDistributorPeer::BANK_ACCOUNT_CURRENCY, MlmDistributorPeer::VISA_DEBIT_CARD, MlmDistributorPeer::EZY_CASH_CARD, MlmDistributorPeer::IACCOUNT, MlmDistributorPeer::IACCOUNT_USERNAME, MlmDistributorPeer::TREE_LEVEL, MlmDistributorPeer::TREE_STRUCTURE, MlmDistributorPeer::PLACEMENT_TREE_LEVEL, MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, MlmDistributorPeer::INIT_RANK_ID, MlmDistributorPeer::INIT_RANK_CODE, MlmDistributorPeer::UPLINE_DIST_ID, MlmDistributorPeer::UPLINE_DIST_CODE, MlmDistributorPeer::TREE_UPLINE_DIST_ID, MlmDistributorPeer::TREE_UPLINE_DIST_CODE, MlmDistributorPeer::TOTAL_LEFT, MlmDistributorPeer::TOTAL_RIGHT, MlmDistributorPeer::PLACEMENT_POSITION, MlmDistributorPeer::PLACEMENT_DATETIME, MlmDistributorPeer::RANK_ID, MlmDistributorPeer::RANK_CODE, MlmDistributorPeer::ACTIVE_DATETIME, MlmDistributorPeer::ACTIVATED_BY, MlmDistributorPeer::LEVERAGE, MlmDistributorPeer::SPREAD, MlmDistributorPeer::DEPOSIT_CURRENCY, MlmDistributorPeer::DEPOSIT_AMOUNT, MlmDistributorPeer::SIGN_NAME, MlmDistributorPeer::SIGN_DATE, MlmDistributorPeer::TERM_CONDITION, MlmDistributorPeer::IB_COMMISSION, MlmDistributorPeer::IS_IB, MlmDistributorPeer::CREATED_BY, MlmDistributorPeer::CREATED_ON, MlmDistributorPeer::UPDATED_BY, MlmDistributorPeer::UPDATED_ON, MlmDistributorPeer::PACKAGE_PURCHASE_FLAG, MlmDistributorPeer::FILE_BANK_PASS_BOOK, MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE, MlmDistributorPeer::FILE_NRIC, MlmDistributorPeer::EXCLUDED_STRUCTURE, MlmDistributorPeer::PRODUCT_MTE, MlmDistributorPeer::PRODUCT_FXGOLD, MlmDistributorPeer::REMARK, MlmDistributorPeer::LOAN_ACCOUNT, MlmDistributorPeer::SELF_REGISTER, MlmDistributorPeer::DEBIT_ACCOUNT, MlmDistributorPeer::DEBIT_RANK_ID, MlmDistributorPeer::DEBIT_STATUS_CODE, MlmDistributorPeer::HIDE_GENEALOGY, MlmDistributorPeer::FROM_ABFX, MlmDistributorPeer::ABFX_USER_ID, MlmDistributorPeer::ABFX_REF, MlmDistributorPeer::ABFX_UPLINE1, MlmDistributorPeer::ABFX_POSITION, MlmDistributorPeer::ABFX_REMARK, MlmDistributorPeer::ABFX_EWALLET, MlmDistributorPeer::ABFX_EPOINT, MlmDistributorPeer::ABFX_PAIRING_LEFT, MlmDistributorPeer::ABFX_PAIRING_RIGHT, MlmDistributorPeer::MIGRATED_STATUS, MlmDistributorPeer::MIGRATED_PLACEMENT_STATUS, MlmDistributorPeer::MIGRATE_RETRY, MlmDistributorPeer::NOMINEE_NAME, MlmDistributorPeer::NOMINEE_IC, MlmDistributorPeer::NOMINEE_RELATIONSHIP, MlmDistributorPeer::NOMINEE_CONTACTNO, MlmDistributorPeer::NEW_ACTIVITY_FLAG, MlmDistributorPeer::NEW_REPORT_FLAG, MlmDistributorPeer::Q3_CHAMPIONS, MlmDistributorPeer::Q3_DATETIME, MlmDistributorPeer::EMAIL_STATUS, MlmDistributorPeer::BKK_PACKAGE_PURCHASE, MlmDistributorPeer::BKK_QUALIFY_1, MlmDistributorPeer::BKK_QUALIFY_2, MlmDistributorPeer::BKK_PERSONAL_SALES, MlmDistributorPeer::BKK_QUALIFY_3, MlmDistributorPeer::BKK_STATUS, MlmDistributorPeer::MONEYTRAC_CUSTOMER_ID, MlmDistributorPeer::MONEYTRAC_USERNAME, MlmDistributorPeer::PREFER_LANGUAGE, MlmDistributorPeer::NORMAL_INVESTOR, MlmDistributorPeer::PRINCIPLE_RETURN, MlmDistributorPeer::LEADER_ID, MlmDistributorPeer::CLOSE_ACCOUNT, MlmDistributorPeer::SECONDTIME_RENEWAL, MlmDistributorPeer::ESWALLET, MlmDistributorPeer::EWALLET, MlmDistributorPeer::CWALLET, MlmDistributorPeer::MWALLET, MlmDistributorPeer::OWALLET, MlmDistributorPeer::SWALLET, MlmDistributorPeer::PWALLET, MlmDistributorPeer::RWALLET, MlmDistributorPeer::TWALLET, MlmDistributorPeer::RTWALLET, MlmDistributorPeer::RPFWALLET, MlmDistributorPeer::RANK_A, MlmDistributorPeer::IS_AGL, MlmDistributorPeer::IOUWALLET, MlmDistributorPeer::OWALLET_20141214, MlmDistributorPeer::RWALLET_20141214, MlmDistributorPeer::SHORTNAME, MlmDistributorPeer::IS_BLOCK, MlmDistributorPeer::FULL_RT, MlmDistributorPeer::KYC_STATUS, MlmDistributorPeer::KYC_REMARK, MlmDistributorPeer::KYC_USER_ID, MlmDistributorPeer::KYC_DATETIME, ),
		BasePeer::TYPE_FIELDNAME => array ('distributor_id', 'distributor_code', 'user_id', 'status_code', 'full_name', 'nickname', 'ic', 'country', 'address', 'address2', 'city', 'state', 'postcode', 'email', 'alternate_email', 'contact', 'gender', 'dob', 'bank_name', 'bank_branch_name', 'bank_address', 'bank_acc_no', 'bank_holder_name', 'bank_swift_code', 'branch_code', 'aba_routing', 'bsb_code', 'transit_number', 'iban', 'account_type', 'bank_code', 'bank_country', 'bank_account_currency', 'visa_debit_card', 'ezy_cash_card', 'iaccount', 'iaccount_username', 'tree_level', 'tree_structure', 'placement_tree_level', 'placement_tree_structure', 'init_rank_id', 'init_rank_code', 'upline_dist_id', 'upline_dist_code', 'tree_upline_dist_id', 'tree_upline_dist_code', 'total_left', 'total_right', 'placement_position', 'placement_datetime', 'rank_id', 'rank_code', 'active_datetime', 'activated_by', 'leverage', 'spread', 'deposit_currency', 'deposit_amount', 'sign_name', 'sign_date', 'term_condition', 'ib_commission', 'is_ib', 'created_by', 'created_on', 'updated_by', 'updated_on', 'package_purchase_flag', 'file_bank_pass_book', 'file_proof_of_residence', 'file_nric', 'excluded_structure', 'product_mte', 'product_fxgold', 'remark', 'loan_account', 'self_register', 'debit_account', 'debit_rank_id', 'debit_status_code', 'hide_genealogy', 'from_abfx', 'abfx_user_id', 'abfx_ref', 'abfx_upline1', 'abfx_position', 'abfx_remark', 'abfx_ewallet', 'abfx_epoint', 'abfx_pairing_left', 'abfx_pairing_right', 'migrated_status', 'migrated_placement_status', 'migrate_retry', 'nominee_name', 'nominee_ic', 'nominee_relationship', 'nominee_contactno', 'new_activity_flag', 'new_report_flag', 'q3_champions', 'q3_datetime', 'email_status', 'bkk_package_purchase', 'bkk_qualify_1', 'bkk_qualify_2', 'bkk_personal_sales', 'bkk_qualify_3', 'bkk_status', 'moneytrac_customer_id', 'moneytrac_username', 'prefer_language', 'normal_investor', 'principle_return', 'leader_id', 'close_account', 'secondtime_renewal', 'eswallet', 'ewallet', 'cwallet', 'mwallet', 'owallet', 'swallet', 'pwallet', 'rwallet', 'twallet', 'rtwallet', 'rpfwallet', 'rank_a', 'is_agl', 'iouwallet', 'owallet_20141214', 'rwallet_20141214', 'shortname', 'is_block', 'full_rt', 'kyc_status', 'kyc_remark', 'kyc_user_id', 'kyc_datetime', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DistributorId' => 0, 'DistributorCode' => 1, 'UserId' => 2, 'StatusCode' => 3, 'FullName' => 4, 'Nickname' => 5, 'Ic' => 6, 'Country' => 7, 'Address' => 8, 'Address2' => 9, 'City' => 10, 'State' => 11, 'Postcode' => 12, 'Email' => 13, 'AlternateEmail' => 14, 'Contact' => 15, 'Gender' => 16, 'Dob' => 17, 'BankName' => 18, 'BankBranchName' => 19, 'BankAddress' => 20, 'BankAccNo' => 21, 'BankHolderName' => 22, 'BankSwiftCode' => 23, 'BranchCode' => 24, 'AbaRouting' => 25, 'BsbCode' => 26, 'TransitNumber' => 27, 'Iban' => 28, 'AccountType' => 29, 'BankCode' => 30, 'BankCountry' => 31, 'BankAccountCurrency' => 32, 'VisaDebitCard' => 33, 'EzyCashCard' => 34, 'Iaccount' => 35, 'IaccountUsername' => 36, 'TreeLevel' => 37, 'TreeStructure' => 38, 'PlacementTreeLevel' => 39, 'PlacementTreeStructure' => 40, 'InitRankId' => 41, 'InitRankCode' => 42, 'UplineDistId' => 43, 'UplineDistCode' => 44, 'TreeUplineDistId' => 45, 'TreeUplineDistCode' => 46, 'TotalLeft' => 47, 'TotalRight' => 48, 'PlacementPosition' => 49, 'PlacementDatetime' => 50, 'RankId' => 51, 'RankCode' => 52, 'ActiveDatetime' => 53, 'ActivatedBy' => 54, 'Leverage' => 55, 'Spread' => 56, 'DepositCurrency' => 57, 'DepositAmount' => 58, 'SignName' => 59, 'SignDate' => 60, 'TermCondition' => 61, 'IbCommission' => 62, 'IsIb' => 63, 'CreatedBy' => 64, 'CreatedOn' => 65, 'UpdatedBy' => 66, 'UpdatedOn' => 67, 'PackagePurchaseFlag' => 68, 'FileBankPassBook' => 69, 'FileProofOfResidence' => 70, 'FileNric' => 71, 'ExcludedStructure' => 72, 'ProductMte' => 73, 'ProductFxgold' => 74, 'Remark' => 75, 'LoanAccount' => 76, 'SelfRegister' => 77, 'DebitAccount' => 78, 'DebitRankId' => 79, 'DebitStatusCode' => 80, 'HideGenealogy' => 81, 'FromAbfx' => 82, 'AbfxUserId' => 83, 'AbfxRef' => 84, 'AbfxUpline1' => 85, 'AbfxPosition' => 86, 'AbfxRemark' => 87, 'AbfxEwallet' => 88, 'AbfxEpoint' => 89, 'AbfxPairingLeft' => 90, 'AbfxPairingRight' => 91, 'MigratedStatus' => 92, 'MigratedPlacementStatus' => 93, 'MigrateRetry' => 94, 'NomineeName' => 95, 'NomineeIc' => 96, 'NomineeRelationship' => 97, 'NomineeContactno' => 98, 'NewActivityFlag' => 99, 'NewReportFlag' => 100, 'Q3Champions' => 101, 'Q3Datetime' => 102, 'EmailStatus' => 103, 'BkkPackagePurchase' => 104, 'BkkQualify1' => 105, 'BkkQualify2' => 106, 'BkkPersonalSales' => 107, 'BkkQualify3' => 108, 'BkkStatus' => 109, 'MoneytracCustomerId' => 110, 'MoneytracUsername' => 111, 'PreferLanguage' => 112, 'NormalInvestor' => 113, 'PrincipleReturn' => 114, 'LeaderId' => 115, 'CloseAccount' => 116, 'SecondtimeRenewal' => 117, 'Eswallet' => 118, 'Ewallet' => 119, 'Cwallet' => 120, 'Mwallet' => 121, 'Owallet' => 122, 'Swallet' => 123, 'Pwallet' => 124, 'Rwallet' => 125, 'Twallet' => 126, 'Rtwallet' => 127, 'Rpfwallet' => 128, 'RankA' => 129, 'IsAgl' => 130, 'Iouwallet' => 131, 'Owallet20141214' => 132, 'Rwallet20141214' => 133, 'Shortname' => 134, 'IsBlock' => 135, 'FullRt' => 136, 'KycStatus' => 137, 'KycRemark' => 138, 'KycUserId' => 139, 'KycDatetime' => 140, ),
		BasePeer::TYPE_COLNAME => array (MlmDistributorPeer::DISTRIBUTOR_ID => 0, MlmDistributorPeer::DISTRIBUTOR_CODE => 1, MlmDistributorPeer::USER_ID => 2, MlmDistributorPeer::STATUS_CODE => 3, MlmDistributorPeer::FULL_NAME => 4, MlmDistributorPeer::NICKNAME => 5, MlmDistributorPeer::IC => 6, MlmDistributorPeer::COUNTRY => 7, MlmDistributorPeer::ADDRESS => 8, MlmDistributorPeer::ADDRESS2 => 9, MlmDistributorPeer::CITY => 10, MlmDistributorPeer::STATE => 11, MlmDistributorPeer::POSTCODE => 12, MlmDistributorPeer::EMAIL => 13, MlmDistributorPeer::ALTERNATE_EMAIL => 14, MlmDistributorPeer::CONTACT => 15, MlmDistributorPeer::GENDER => 16, MlmDistributorPeer::DOB => 17, MlmDistributorPeer::BANK_NAME => 18, MlmDistributorPeer::BANK_BRANCH_NAME => 19, MlmDistributorPeer::BANK_ADDRESS => 20, MlmDistributorPeer::BANK_ACC_NO => 21, MlmDistributorPeer::BANK_HOLDER_NAME => 22, MlmDistributorPeer::BANK_SWIFT_CODE => 23, MlmDistributorPeer::BRANCH_CODE => 24, MlmDistributorPeer::ABA_ROUTING => 25, MlmDistributorPeer::BSB_CODE => 26, MlmDistributorPeer::TRANSIT_NUMBER => 27, MlmDistributorPeer::IBAN => 28, MlmDistributorPeer::ACCOUNT_TYPE => 29, MlmDistributorPeer::BANK_CODE => 30, MlmDistributorPeer::BANK_COUNTRY => 31, MlmDistributorPeer::BANK_ACCOUNT_CURRENCY => 32, MlmDistributorPeer::VISA_DEBIT_CARD => 33, MlmDistributorPeer::EZY_CASH_CARD => 34, MlmDistributorPeer::IACCOUNT => 35, MlmDistributorPeer::IACCOUNT_USERNAME => 36, MlmDistributorPeer::TREE_LEVEL => 37, MlmDistributorPeer::TREE_STRUCTURE => 38, MlmDistributorPeer::PLACEMENT_TREE_LEVEL => 39, MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE => 40, MlmDistributorPeer::INIT_RANK_ID => 41, MlmDistributorPeer::INIT_RANK_CODE => 42, MlmDistributorPeer::UPLINE_DIST_ID => 43, MlmDistributorPeer::UPLINE_DIST_CODE => 44, MlmDistributorPeer::TREE_UPLINE_DIST_ID => 45, MlmDistributorPeer::TREE_UPLINE_DIST_CODE => 46, MlmDistributorPeer::TOTAL_LEFT => 47, MlmDistributorPeer::TOTAL_RIGHT => 48, MlmDistributorPeer::PLACEMENT_POSITION => 49, MlmDistributorPeer::PLACEMENT_DATETIME => 50, MlmDistributorPeer::RANK_ID => 51, MlmDistributorPeer::RANK_CODE => 52, MlmDistributorPeer::ACTIVE_DATETIME => 53, MlmDistributorPeer::ACTIVATED_BY => 54, MlmDistributorPeer::LEVERAGE => 55, MlmDistributorPeer::SPREAD => 56, MlmDistributorPeer::DEPOSIT_CURRENCY => 57, MlmDistributorPeer::DEPOSIT_AMOUNT => 58, MlmDistributorPeer::SIGN_NAME => 59, MlmDistributorPeer::SIGN_DATE => 60, MlmDistributorPeer::TERM_CONDITION => 61, MlmDistributorPeer::IB_COMMISSION => 62, MlmDistributorPeer::IS_IB => 63, MlmDistributorPeer::CREATED_BY => 64, MlmDistributorPeer::CREATED_ON => 65, MlmDistributorPeer::UPDATED_BY => 66, MlmDistributorPeer::UPDATED_ON => 67, MlmDistributorPeer::PACKAGE_PURCHASE_FLAG => 68, MlmDistributorPeer::FILE_BANK_PASS_BOOK => 69, MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE => 70, MlmDistributorPeer::FILE_NRIC => 71, MlmDistributorPeer::EXCLUDED_STRUCTURE => 72, MlmDistributorPeer::PRODUCT_MTE => 73, MlmDistributorPeer::PRODUCT_FXGOLD => 74, MlmDistributorPeer::REMARK => 75, MlmDistributorPeer::LOAN_ACCOUNT => 76, MlmDistributorPeer::SELF_REGISTER => 77, MlmDistributorPeer::DEBIT_ACCOUNT => 78, MlmDistributorPeer::DEBIT_RANK_ID => 79, MlmDistributorPeer::DEBIT_STATUS_CODE => 80, MlmDistributorPeer::HIDE_GENEALOGY => 81, MlmDistributorPeer::FROM_ABFX => 82, MlmDistributorPeer::ABFX_USER_ID => 83, MlmDistributorPeer::ABFX_REF => 84, MlmDistributorPeer::ABFX_UPLINE1 => 85, MlmDistributorPeer::ABFX_POSITION => 86, MlmDistributorPeer::ABFX_REMARK => 87, MlmDistributorPeer::ABFX_EWALLET => 88, MlmDistributorPeer::ABFX_EPOINT => 89, MlmDistributorPeer::ABFX_PAIRING_LEFT => 90, MlmDistributorPeer::ABFX_PAIRING_RIGHT => 91, MlmDistributorPeer::MIGRATED_STATUS => 92, MlmDistributorPeer::MIGRATED_PLACEMENT_STATUS => 93, MlmDistributorPeer::MIGRATE_RETRY => 94, MlmDistributorPeer::NOMINEE_NAME => 95, MlmDistributorPeer::NOMINEE_IC => 96, MlmDistributorPeer::NOMINEE_RELATIONSHIP => 97, MlmDistributorPeer::NOMINEE_CONTACTNO => 98, MlmDistributorPeer::NEW_ACTIVITY_FLAG => 99, MlmDistributorPeer::NEW_REPORT_FLAG => 100, MlmDistributorPeer::Q3_CHAMPIONS => 101, MlmDistributorPeer::Q3_DATETIME => 102, MlmDistributorPeer::EMAIL_STATUS => 103, MlmDistributorPeer::BKK_PACKAGE_PURCHASE => 104, MlmDistributorPeer::BKK_QUALIFY_1 => 105, MlmDistributorPeer::BKK_QUALIFY_2 => 106, MlmDistributorPeer::BKK_PERSONAL_SALES => 107, MlmDistributorPeer::BKK_QUALIFY_3 => 108, MlmDistributorPeer::BKK_STATUS => 109, MlmDistributorPeer::MONEYTRAC_CUSTOMER_ID => 110, MlmDistributorPeer::MONEYTRAC_USERNAME => 111, MlmDistributorPeer::PREFER_LANGUAGE => 112, MlmDistributorPeer::NORMAL_INVESTOR => 113, MlmDistributorPeer::PRINCIPLE_RETURN => 114, MlmDistributorPeer::LEADER_ID => 115, MlmDistributorPeer::CLOSE_ACCOUNT => 116, MlmDistributorPeer::SECONDTIME_RENEWAL => 117, MlmDistributorPeer::ESWALLET => 118, MlmDistributorPeer::EWALLET => 119, MlmDistributorPeer::CWALLET => 120, MlmDistributorPeer::MWALLET => 121, MlmDistributorPeer::OWALLET => 122, MlmDistributorPeer::SWALLET => 123, MlmDistributorPeer::PWALLET => 124, MlmDistributorPeer::RWALLET => 125, MlmDistributorPeer::TWALLET => 126, MlmDistributorPeer::RTWALLET => 127, MlmDistributorPeer::RPFWALLET => 128, MlmDistributorPeer::RANK_A => 129, MlmDistributorPeer::IS_AGL => 130, MlmDistributorPeer::IOUWALLET => 131, MlmDistributorPeer::OWALLET_20141214 => 132, MlmDistributorPeer::RWALLET_20141214 => 133, MlmDistributorPeer::SHORTNAME => 134, MlmDistributorPeer::IS_BLOCK => 135, MlmDistributorPeer::FULL_RT => 136, MlmDistributorPeer::KYC_STATUS => 137, MlmDistributorPeer::KYC_REMARK => 138, MlmDistributorPeer::KYC_USER_ID => 139, MlmDistributorPeer::KYC_DATETIME => 140, ),
		BasePeer::TYPE_FIELDNAME => array ('distributor_id' => 0, 'distributor_code' => 1, 'user_id' => 2, 'status_code' => 3, 'full_name' => 4, 'nickname' => 5, 'ic' => 6, 'country' => 7, 'address' => 8, 'address2' => 9, 'city' => 10, 'state' => 11, 'postcode' => 12, 'email' => 13, 'alternate_email' => 14, 'contact' => 15, 'gender' => 16, 'dob' => 17, 'bank_name' => 18, 'bank_branch_name' => 19, 'bank_address' => 20, 'bank_acc_no' => 21, 'bank_holder_name' => 22, 'bank_swift_code' => 23, 'branch_code' => 24, 'aba_routing' => 25, 'bsb_code' => 26, 'transit_number' => 27, 'iban' => 28, 'account_type' => 29, 'bank_code' => 30, 'bank_country' => 31, 'bank_account_currency' => 32, 'visa_debit_card' => 33, 'ezy_cash_card' => 34, 'iaccount' => 35, 'iaccount_username' => 36, 'tree_level' => 37, 'tree_structure' => 38, 'placement_tree_level' => 39, 'placement_tree_structure' => 40, 'init_rank_id' => 41, 'init_rank_code' => 42, 'upline_dist_id' => 43, 'upline_dist_code' => 44, 'tree_upline_dist_id' => 45, 'tree_upline_dist_code' => 46, 'total_left' => 47, 'total_right' => 48, 'placement_position' => 49, 'placement_datetime' => 50, 'rank_id' => 51, 'rank_code' => 52, 'active_datetime' => 53, 'activated_by' => 54, 'leverage' => 55, 'spread' => 56, 'deposit_currency' => 57, 'deposit_amount' => 58, 'sign_name' => 59, 'sign_date' => 60, 'term_condition' => 61, 'ib_commission' => 62, 'is_ib' => 63, 'created_by' => 64, 'created_on' => 65, 'updated_by' => 66, 'updated_on' => 67, 'package_purchase_flag' => 68, 'file_bank_pass_book' => 69, 'file_proof_of_residence' => 70, 'file_nric' => 71, 'excluded_structure' => 72, 'product_mte' => 73, 'product_fxgold' => 74, 'remark' => 75, 'loan_account' => 76, 'self_register' => 77, 'debit_account' => 78, 'debit_rank_id' => 79, 'debit_status_code' => 80, 'hide_genealogy' => 81, 'from_abfx' => 82, 'abfx_user_id' => 83, 'abfx_ref' => 84, 'abfx_upline1' => 85, 'abfx_position' => 86, 'abfx_remark' => 87, 'abfx_ewallet' => 88, 'abfx_epoint' => 89, 'abfx_pairing_left' => 90, 'abfx_pairing_right' => 91, 'migrated_status' => 92, 'migrated_placement_status' => 93, 'migrate_retry' => 94, 'nominee_name' => 95, 'nominee_ic' => 96, 'nominee_relationship' => 97, 'nominee_contactno' => 98, 'new_activity_flag' => 99, 'new_report_flag' => 100, 'q3_champions' => 101, 'q3_datetime' => 102, 'email_status' => 103, 'bkk_package_purchase' => 104, 'bkk_qualify_1' => 105, 'bkk_qualify_2' => 106, 'bkk_personal_sales' => 107, 'bkk_qualify_3' => 108, 'bkk_status' => 109, 'moneytrac_customer_id' => 110, 'moneytrac_username' => 111, 'prefer_language' => 112, 'normal_investor' => 113, 'principle_return' => 114, 'leader_id' => 115, 'close_account' => 116, 'secondtime_renewal' => 117, 'eswallet' => 118, 'ewallet' => 119, 'cwallet' => 120, 'mwallet' => 121, 'owallet' => 122, 'swallet' => 123, 'pwallet' => 124, 'rwallet' => 125, 'twallet' => 126, 'rtwallet' => 127, 'rpfwallet' => 128, 'rank_a' => 129, 'is_agl' => 130, 'iouwallet' => 131, 'owallet_20141214' => 132, 'rwallet_20141214' => 133, 'shortname' => 134, 'is_block' => 135, 'full_rt' => 136, 'kyc_status' => 137, 'kyc_remark' => 138, 'kyc_user_id' => 139, 'kyc_datetime' => 140, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, )
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

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_BRANCH_NAME);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_ADDRESS);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_ACC_NO);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_HOLDER_NAME);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_SWIFT_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::BRANCH_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::ABA_ROUTING);

		$criteria->addSelectColumn(MlmDistributorPeer::BSB_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::TRANSIT_NUMBER);

		$criteria->addSelectColumn(MlmDistributorPeer::IBAN);

		$criteria->addSelectColumn(MlmDistributorPeer::ACCOUNT_TYPE);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_COUNTRY);

		$criteria->addSelectColumn(MlmDistributorPeer::BANK_ACCOUNT_CURRENCY);

		$criteria->addSelectColumn(MlmDistributorPeer::VISA_DEBIT_CARD);

		$criteria->addSelectColumn(MlmDistributorPeer::EZY_CASH_CARD);

		$criteria->addSelectColumn(MlmDistributorPeer::IACCOUNT);

		$criteria->addSelectColumn(MlmDistributorPeer::IACCOUNT_USERNAME);

		$criteria->addSelectColumn(MlmDistributorPeer::TREE_LEVEL);

		$criteria->addSelectColumn(MlmDistributorPeer::TREE_STRUCTURE);

		$criteria->addSelectColumn(MlmDistributorPeer::PLACEMENT_TREE_LEVEL);

		$criteria->addSelectColumn(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE);

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

		$criteria->addSelectColumn(MlmDistributorPeer::EXCLUDED_STRUCTURE);

		$criteria->addSelectColumn(MlmDistributorPeer::PRODUCT_MTE);

		$criteria->addSelectColumn(MlmDistributorPeer::PRODUCT_FXGOLD);

		$criteria->addSelectColumn(MlmDistributorPeer::REMARK);

		$criteria->addSelectColumn(MlmDistributorPeer::LOAN_ACCOUNT);

		$criteria->addSelectColumn(MlmDistributorPeer::SELF_REGISTER);

		$criteria->addSelectColumn(MlmDistributorPeer::DEBIT_ACCOUNT);

		$criteria->addSelectColumn(MlmDistributorPeer::DEBIT_RANK_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::DEBIT_STATUS_CODE);

		$criteria->addSelectColumn(MlmDistributorPeer::HIDE_GENEALOGY);

		$criteria->addSelectColumn(MlmDistributorPeer::FROM_ABFX);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_USER_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_REF);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_UPLINE1);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_POSITION);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_REMARK);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_EWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_EPOINT);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_PAIRING_LEFT);

		$criteria->addSelectColumn(MlmDistributorPeer::ABFX_PAIRING_RIGHT);

		$criteria->addSelectColumn(MlmDistributorPeer::MIGRATED_STATUS);

		$criteria->addSelectColumn(MlmDistributorPeer::MIGRATED_PLACEMENT_STATUS);

		$criteria->addSelectColumn(MlmDistributorPeer::MIGRATE_RETRY);

		$criteria->addSelectColumn(MlmDistributorPeer::NOMINEE_NAME);

		$criteria->addSelectColumn(MlmDistributorPeer::NOMINEE_IC);

		$criteria->addSelectColumn(MlmDistributorPeer::NOMINEE_RELATIONSHIP);

		$criteria->addSelectColumn(MlmDistributorPeer::NOMINEE_CONTACTNO);

		$criteria->addSelectColumn(MlmDistributorPeer::NEW_ACTIVITY_FLAG);

		$criteria->addSelectColumn(MlmDistributorPeer::NEW_REPORT_FLAG);

		$criteria->addSelectColumn(MlmDistributorPeer::Q3_CHAMPIONS);

		$criteria->addSelectColumn(MlmDistributorPeer::Q3_DATETIME);

		$criteria->addSelectColumn(MlmDistributorPeer::EMAIL_STATUS);

		$criteria->addSelectColumn(MlmDistributorPeer::BKK_PACKAGE_PURCHASE);

		$criteria->addSelectColumn(MlmDistributorPeer::BKK_QUALIFY_1);

		$criteria->addSelectColumn(MlmDistributorPeer::BKK_QUALIFY_2);

		$criteria->addSelectColumn(MlmDistributorPeer::BKK_PERSONAL_SALES);

		$criteria->addSelectColumn(MlmDistributorPeer::BKK_QUALIFY_3);

		$criteria->addSelectColumn(MlmDistributorPeer::BKK_STATUS);

		$criteria->addSelectColumn(MlmDistributorPeer::MONEYTRAC_CUSTOMER_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::MONEYTRAC_USERNAME);

		$criteria->addSelectColumn(MlmDistributorPeer::PREFER_LANGUAGE);

		$criteria->addSelectColumn(MlmDistributorPeer::NORMAL_INVESTOR);

		$criteria->addSelectColumn(MlmDistributorPeer::PRINCIPLE_RETURN);

		$criteria->addSelectColumn(MlmDistributorPeer::LEADER_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::CLOSE_ACCOUNT);

		$criteria->addSelectColumn(MlmDistributorPeer::SECONDTIME_RENEWAL);

		$criteria->addSelectColumn(MlmDistributorPeer::ESWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::EWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::CWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::MWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::OWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::SWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::PWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::RWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::TWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::RTWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::RPFWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::RANK_A);

		$criteria->addSelectColumn(MlmDistributorPeer::IS_AGL);

		$criteria->addSelectColumn(MlmDistributorPeer::IOUWALLET);

		$criteria->addSelectColumn(MlmDistributorPeer::OWALLET_20141214);

		$criteria->addSelectColumn(MlmDistributorPeer::RWALLET_20141214);

		$criteria->addSelectColumn(MlmDistributorPeer::SHORTNAME);

		$criteria->addSelectColumn(MlmDistributorPeer::IS_BLOCK);

		$criteria->addSelectColumn(MlmDistributorPeer::FULL_RT);

		$criteria->addSelectColumn(MlmDistributorPeer::KYC_STATUS);

		$criteria->addSelectColumn(MlmDistributorPeer::KYC_REMARK);

		$criteria->addSelectColumn(MlmDistributorPeer::KYC_USER_ID);

		$criteria->addSelectColumn(MlmDistributorPeer::KYC_DATETIME);

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
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

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

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
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
			$criteria = clone $values; 		} elseif ($values instanceof MlmDistributor) {

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
