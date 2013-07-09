<?php


abstract class Globals {
    const PROJECT_NAME = "MAXIM_";
    const COMPANY_NAME = "Maxim Trader";
    const TOTAL_BONUS_PAYOUT = 10;

    const SF_ENVIRONMENT_PROD = 'prod';
    const SF_ENVIRONMENT_DEV = 'dev';
    const SF_ENVIRONMENT_TEST = 'test';

    const WITHDRAWAL_LOCAL_BANK = 'LOCAL BANK';
    const WITHDRAWAL_EZY_CASH_CARD = 'EZY CASH CARD';
    const WITHDRAWAL_VISA_DEBIT_CARD = 'VISA DEBIT CARD';

    const COUNTRY_OTHER = "Others";
    const YES = 1;
    const NO = 0;
    const YES_Y = 'Y';
    const TRUE = 'T';
    const FALSE = 'F';
    const SYSTEM_USER_ID = '0';
    const SYSTEM_BROKER_ID = '-1';
    const SYSTEM_COMPANY_DIST_ID = '0';
    const SYSTEM_CAPTCHA_ID = 'captcha_id';
    const LOAN_ACCOUNT_CREATOR_DIST_ID = 1;
    const LOGIN_RETRY = 0;
    const FIRST_LOGIN = 0;
    const DEBIT_CARD_CHARGES = 35;
    const DEBIT_CARD_ACTIVATION_CHARGES = 50;
    const EZY_CASH_CARD_CHARGES = 35;
    const IME_CHARGES = 800;

    const FULL_DATETIME_FORMAT = 'l j F, Y g:i a';
    const BONUS_MAINTENANCE_PERCENTAGE = 0;
    //const BONUS_MAINTENANCE_PERCENTAGE = 0.1;

    /************************************/
    /*****          STATUS         ******/
    /************************************/
	const STATUS_ACTIVE = 'ACTIVE';
	const STATUS_ERROR = 'ERROR';
	const STATUS_INACTIVE = 'INACTIVE';
	const STATUS_PENDING = 'PENDING';
	const STATUS_PROCESSING = 'PROCESSING';
	const STATUS_PAYMENT_PENDING = 'PAYMENT PENDING';
	const STATUS_CANCEL = 'CANCEL';
	const STATUS_REJECT = 'REJECT';
	const STATUS_APPROVE = 'APPROVE';
	const STATUS_COMPLETE = 'COMPLETE';
    const STATUS_SUCCESS = 'SUCCESS';

    /*************************/
    /*****    ROLE      ******/
    /*************************/
	const ROLE_DISTRIBUTOR = 'DISTRIBUTOR';
	const ROLE_ADMIN = 'ADMIN';
	const ROLE_SUPERADMIN = 'SUPERADMIN';

    /*************************/
    /*****    SESSION   ******/
    /*************************/
	const SESSION_DISTID = "MAXIM_DISTID";
	const SESSION_ADMINID = 'MAXIM_ADMINID';
	const SESSION_USERNAME = 'MAXIM_USERNAME';
	const SESSION_DISTCODE = 'MAXIM_DISTCODE';
	const SESSION_USERID = 'MAXIM_USERID';
	const SESSION_USERTYPE = 'MAXIM_USERTYPE';
	const SESSION_USERSTATUS = 'MAXIM_USERSTATUS';
    const SESSION_CPS_PRICE = 'MAXIM_CPS_PRICE';
    const SESSION_GOLD_PRICE = 'MAXIM_GOLD_PRICE';
    const SESSION_MENU_IDX = 'MAXIM__MENU_IDX';
    const SESSION_ADMIN_MENU_IDX = 'MAXIM_ADMIN_MENU_IDX';
    const SESSION_NICKNAME = 'MAXIM_NICKNAME';
    const SESSION_MASTER_LOGIN_ID = 'MAXIM_MASTER_LOGIN_ID';
    const SESSION_MASTER_LOGIN = 'MAXIM_MASTER_LOGIN';

    /*************************/
    /*****    ACCOUNT   ******/
    /*************************/
    const ACCOUNT_TYPE_RANK = 'RANK';
    const ACCOUNT_TYPE_ECASH = 'ECASH';
    const ACCOUNT_TYPE_EPOINT = 'EPOINT';
    const ACCOUNT_TYPE_RP = 'RP';
    const ACCOUNT_TYPE_DEBIT = 'DEBIT';
    const ACCOUNT_TYPE_MAINTENANCE = 'MAINTENANCE';
    const ACCOUNT_TYPE_DEBIT_ACCOUNT = 'DEBIT ACCOUNT';

    /*******************************/
    /*****    ACCOUNT LEDGER  ******/
    /*******************************/
    const ACCOUNT_LEDGER_ACTION_DEBIT = 'DEBIT';
    const ACCOUNT_LEDGER_ACTION_ECASH_DEBIT = 'ECASH DEBIT';
    const ACCOUNT_LEDGER_ACTION_DEBIT_ACCOUNT = 'DEBIT ACCOUNT';
    const ACCOUNT_LEDGER_ACTION_REGISTER = 'REGISTER';
    const ACCOUNT_LEDGER_ACTION_PURCHASE = 'PURCHASE';
    const ACCOUNT_LEDGER_ACTION_SELL = 'SELL';
    const ACCOUNT_LEDGER_ACTION_BUY = 'BUY';
    const ACCOUNT_LEDGER_ACTION_TRANSFER = 'TRANSFER';
    const ACCOUNT_LEDGER_ACTION_TRANSFER_TO = 'TRANSFER TO';
    const ACCOUNT_LEDGER_ACTION_RP_TRANSFER_TO = 'RP TRANSFER TO';
    const ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE = 'PROCESS CHARGES';
    const ACCOUNT_LEDGER_ACTION_TRANSFER_FROM = 'TRANSFER FROM';
    const ACCOUNT_LEDGER_ACTION_RP_RECALL = 'RP RECALL';
    const ACCOUNT_LEDGER_ACTION_RP_TRANSFER_FROM = 'RP TRANSFER FROM';
    const ACCOUNT_LEDGER_ACTION_MT4_WITHDRAWAL = 'MT4 WITHDRAWAL';
    const ACCOUNT_LEDGER_ACTION_REDEEM = 'REDEEM';
    const ACCOUNT_LEDGER_ACTION_WITHDRAWAL = 'WITHDRAWAL';
    const ACCOUNT_LEDGER_ACTION_DAILY_BONUS = 'DAILY BONUS';
    const ACCOUNT_LEDGER_ACTION_MONTHLY_BONUS = 'MONTHLY BONUS';
    const ACCOUNT_LEDGER_ACTION_ADJUSTMENT = 'ADJUSTMENT';
    const ACCOUNT_LEDGER_ACTION_DEPOSIT = 'DEPOSIT';
    const ACCOUNT_LEDGER_ACTION_DRB = 'DRB';
    const ACCOUNT_LEDGER_ACTION_GDB = 'GDB';
    const ACCOUNT_LEDGER_ACTION_ADVANCE = 'ADVANCE';
    const ACCOUNT_LEDGER_ACTION_POINT_PURCHASE = 'POINT PURCHASE';
    const ACCOUNT_LEDGER_ACTION_CONVERT_EPOINT = 'CONVERT EPOINT';
    const ACCOUNT_LEDGER_ACTION_CONVERT = 'CONVERT';
    const ACCOUNT_LEDGER_ACTION_TOPUP = 'RELOAD';
    const ACCOUNT_LEDGER_ACTION_TOPUP_MT4 = 'RELOAD MT4';
    const ACCOUNT_LEDGER_ACTION_PACKAGE_UPGRADE = 'PACKAGE UPGRADE';
    const ACCOUNT_LEDGER_ACTION_REFUND = 'REFUND';
    const ACCOUNT_LEDGER_ACTION_MAINTENANCE = 'MAINTENANCE';
    const ACCOUNT_LEDGER_ACTION_PIPS_BONUS = 'PIPS BONUS';
    const ACCOUNT_LEDGER_ACTION_CREDIT_REFUND = 'PIPS REBATE';
    const ACCOUNT_LEDGER_ACTION_FUND_MANAGEMENT = 'FUND MANAGEMENT';
    const ACCOUNT_LEDGER_ACTION_SPECIAL_BONUS = 'SPECIAL BONUS';
    const ACCOUNT_LEDGER_ACTION_APPLY_DEBIT_CARD = 'APPLY DEBIT CARD';
    const ACCOUNT_LEDGER_ACTION_APPLY_EZY_CASH_CARD = 'APPLY EZY CASH CARD';
    const ACCOUNT_LEDGER_ACTION_IME_REGISTRATION = 'IME REGISTRATION';

    /*******************************/
    /*****    RELOAD TOPUP  ******/
    /*******************************/
    const RELOAD_TOPUP_TOPUP = 'RELOAD';

    /*******************************/
    /*****    ACCOUNT LEDGER  ******/
    /*******************************/
    const SETTING_MT4_HANDLING_FEE = 'MT4_HANDLING_FEE';
    const SETTING_MT4_HANDLING_FEE_USD = 'MT4_HANDLING_FEE_USD';
    const SETTING_CPS = 'CPS';
    const SETTING_SERVER_MAINTAIN = 'SERVER_MAINTAIN';
    const SETTING_SYSTEM_CURRENCY = 'SYSTEM_CURRENCY';
    const SETTING_USD_TO_MYR = 'USD_TO_MYR';

    const SETTING_BANK_NAME = 'BANK_NAME';
    const SETTING_BANK_SWIFT_CODE = 'BANK_SWIFT_CODE';
    const SETTING_IBAN = 'IBAN';
    const SETTING_BANK_ACCOUNT_HOLDER = 'BANK_ACCOUNT_HOLDER';
    const SETTING_BANK_ACCOUNT_NUMBER = 'BANK_ACCOUNT_NUMBER';
    const SETTING_CITY_OF_BANK = 'CITY_OF_BANK';
    const SETTING_COUNTRY_OF_BANK = 'COUNTRY_OF_BANK';

    const SETTING_BANK_NAME_2 = 'BANK_NAME_2';
    const SETTING_BANK_SWIFT_CODE_2 = 'BANK_SWIFT_CODE_2';
    const SETTING_IBAN_2 = 'IBAN_2';
    const SETTING_BANK_ACCOUNT_HOLDER_2 = 'BANK_ACCOUNT_HOLDER_2';
    const SETTING_BANK_ACCOUNT_NUMBER_2 = 'BANK_ACCOUNT_NUMBER_2';
    const SETTING_CITY_OF_BANK_2 = 'CITY_OF_BANK_2';
    const SETTING_COUNTRY_OF_BANK_2 = 'COUNTRY_OF_BANK_2';

    const SETTING_SHARE_MARKET = 'SHARE_MARKET';
    const SETTING_TRANSFER_PROCESS_FEE = 'TRANSFER_PROCESS_FEE';

    /*************************************/
    /*****      COMMISSION          ******/
    /*************************************/
    const COMMISSION_TYPE_DRB = 'DRB';
    const COMMISSION_TYPE_PIPS_BONUS = 'PIPS_BONUS';
    const COMMISSION_TYPE_CREDIT_REFUND = 'CREDIT_REFUND';
    const COMMISSION_TYPE_FUND_MANAGEMENT = 'FUND_MANAGEMENT';
    const COMMISSION_TYPE_SPECIAL_BONUS = 'SPECIAL_BONUS';
    const COMMISSION_TYPE_GDB = 'GDB';

    const TOTAL_LOT_TRADED = 'TOTAL_LOT_TRADED';
    /*************************************/
    /*****   COMMISSION LEDGER      ******/
    /*************************************/
    const COMMISSION_LEDGER_REGISTER = 'REGISTER';
    const COMMISSION_LEDGER_UPGRADE = 'UPGRADE';
    const COMMISSION_LEDGER_PAIRED = 'PAIRED';
    const COMMISSION_LEDGER_WITHDRAW = 'WITHDRAW';
    const COMMISSION_LEDGER_PIPS_GAIN = 'PIPS_GAIN';
    const COMMISSION_LEDGER_PIPS_TRADED = 'TRADED';
    const COMMISSION_LEDGER_DIVIDEND = 'DIVIDEND';

    /*************************************/
    /*****   WITHDRAWAL      ******/
    /*************************************/
    const WITHDRAWAL_PENDING = 'PENDING';
    const WITHDRAWAL_PROCESSING = 'PROCESSING';
    const WITHDRAWAL_REJECTED = 'REJECTED';
    const WITHDRAWAL_PAID = 'PAID';

    /*************************************/
    /*****   ECREDIT PURCHASE      ******/
    /*************************************/
    const ECREDIT_PURCHASE_PENDING = 'PENDING';
    const ECREDIT_PURCHASE_PROCESSING = 'PROCESSING';
    const ECREDIT_PURCHASE_REJECTED = 'REJECTED';
    const ECREDIT_PURCHASE_COMPLETED = 'COMPLETED';

    /*************************************/
    /*****   ECREDIT PURCHASE      ******/
    /*************************************/
    const STATUS_PIPS_CSV_ACTIVE = 'ACTIVE';
    const STATUS_PIPS_CSV_SUCCESS = 'SUCCESS';
    const STATUS_PIPS_CSV_ERROR = 'ERROR';

    /*************************************/
    /*****   PAIRING LEDGER      ******/
    /*************************************/
    const PAIRING_LEDGER_REGISTER = 'REGISTER';
    const PAIRING_LEDGER_FLUSH = 'FLUSH';
    const PAIRING_LEDGER_PAIRED = 'PAIRED';

    /*******************************/
    /*****    Placement  ******/
    /*******************************/
    const PLACEMENT_LEFT = 'LEFT';
    const PLACEMENT_RIGHT = 'RIGHT';

    /*******************************/
    /*****   Daily Bonus Log  ******/
    /*******************************/
    const DAILY_BONUS_LOG_TYPE_DAILY = 'DAILY';

    /*******************************/
    /*****   Purchase Package  *****/
    /*******************************/
    const PURCHASE_PACKAGE_BANK_TRANSFER = 'BANK TRANSFER';

    /*******************************/
    /*****   e-Point Package  ******/
    /*******************************/
    const PURCHASE_EPOINT_BANK_TRANSFER = 'BANK TRANSFER';

    /*******************************/
    /*****   EShare  ******/
    /*******************************/
    const ESHARE_SPLIT_SELL_UNIT = '30,20,20,20,10';
    const ESHARE_SPLIT_SELL_DAY = '15,30,45,60,75';
    const ESHARE_ACCOUNT_STATUS_ACTIVE = 'ACTIVE';
    const ESHARE_ACCOUNT_STATUS_COMPLETE = 'COMPLETE';
    const ESHARE_REINVEST_AMOUNT = 500;

    const PATH_VERIFICATION = 'verification';

    const PIN_ACTION_REGISTER = 'register';
    const PIN_ACTION_TRANSFER = 'transfer';
    const PIN_ACTION_REINVEST = 'reinvest';

    const REINVEST_CPS_DAYS = 21;
    const REINVEST_GAP_MULTIPLY = 3;
    const REFRESH_GOLD_INTEVAL = 20000;  // 10 sec
    const GRAM_TO_TROY_OUNCES = 0.0321507466; //1 gram = 0.0321507466 troy ounces
    const PACKAGE_PINS = "5,10,20,30,50,100";
    const FIRST_REGISTERED_DISTRIBUTOR_CODE = "TV1";
    const FIRST_REGISTERED_DISTRIBUTOR_ID = 1;

    const MAX_PACKAGE_PRICE = 30000;
    const MAX_PACKAGE_ID = 5;

    /************************************/
    /****    DIVIDEND STATUS       ******/
    /************************************/
	const DIVIDEND_STATUS_PENDING = 'PENDING';
	const DIVIDEND_STATUS_SUCCESS = 'SUCCESS';
	const DIVIDEND_TIMES_ENTITLEMENT = 18;

    /***********************************************/
    /****    DEBIT CARD & EZY CASH CARD       ******/
    /***********************************************/
    const APPLY_DEBITCARD_ENABLE = true;
    const APPLY_EZYCASHCARD_ENABLE = false;
    const APPLY_DEBITCARD_VISIBLE = true;
    const APPLY_EZYCASHCARD_VISIBLE = false;

    const APPLY_IME_VISIBLE = false;
    const APPLY_IME_ENABLE = false;

    /*******************************/
    /*****   GROUP LEADER   ******/
    /*******************************/
    /*const GROUP_LEADER = "thorsengwah,kaseong,maximthai1,MAXCAP,maxworld,MaximIndon,Dynasty,MaximChina,datoheng";*/
    //const GROUP_LEADER = "SUPERA,TWOSASA,Diana,Jchooi,CN777,Rudy001,AlexSim,kaseong,Dynasty,MaximTaiwan,thorsengwah,MaximIndon,maximthai1,ongeuzan,MaximChina,uncletong,MAXCAP,maxworld,BRA129,kinowaiming,alvinang1,datoheng,amz001,klm76,vision1,chris5,KL6,FYL188";
    const GROUP_LEADER = "595,763,665,715,554,142,61,143,283,60,240,71,57,161,262,43,175,104,557,124,203,1458,1561,1984,135,1763,1770,129";

//    const HIDE_DIST_GROUP = "MAXCAP";
//    const TO_HIDE_DIST_GROUP = "alvinang1,alvinang2,alvinang3,alvinang4,alvinang5,alvinang6,alvinang7,law1,law01,chris3,Law001,chris5,chris6,chris7,roy1,roy2,roy3,roy4,roy5,roy6,roy7,ALVINANG1,ALVINANG2,ALVINANG3,ALVINANG4,ALVINANG5,ALVINANG6,ALVINANG7,LAW1,LAW01,CHRIS3,LAW001,CHRIS5,CHRIS6,CHRIS7,ROY1,ROY2,ROY3,ROY4,ROY5,ROY6,ROY7";
//    const HIDE_DIST_GROUP = "MAXCAP,law01,Law001,BRF129,maxworld";
    const HIDE_DIST_GROUP = "43,128,129,402,175";
//    const TO_HIDE_DIST_GROUP = "alvinang1,alvinang2,alvinang3,alvinang4,alvinang5,alvinang6,alvinang7,BRA129,BRB129,BRF129,law1,law01,chris3,Law001,chris5,chris6,chris7,roy1,roy2,roy3,roy4,roy5,roy6,roy7,ALVINANG1,ALVINANG2,ALVINANG3,ALVINANG4,ALVINANG5,ALVINANG6,ALVINANG7,LAW1,LAW01,CHRIS3,LAW001,CHRIS5,CHRIS6,CHRIS7,ROY1,ROY2,ROY3,ROY4,ROY5,ROY6,ROY7";
    const TO_HIDE_DIST_GROUP = "124,125,130,126,131,132,133,104,105,402,127,128,134,129,135,136,137,124,125,130,126,131,132,133";

    const HIDE_DIST_GROUP_2 = "law01";
    const TO_HIDE_DIST_GROUP_2 = "alvinang1,alvinang2,alvinang4";
    const HIDE_DIST_GROUP_3 = "Law001";
    const TO_HIDE_DIST_GROUP_3 = "law01,law1";
    const HIDE_DIST_GROUP_4 = "BRF129";
    const TO_HIDE_DIST_GROUP_4 = "Law001";
    const HIDE_DIST_GROUP_5 = "maxworld";
    const TO_HIDE_DIST_GROUP_5 = "alvinang1,alvinang2,alvinang4,BRA129,BRB129,BRF129,Law001,law01,law1";

    const ABFX_GROUP = "|1763|"; // Law001
}