<?php


abstract class BaseGgMemberWithdraw extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $uid = '0';


	
	protected $amount = 0;


	
	protected $withdraw_amount = 0;


	
	protected $charges = 0;


	
	protected $rate = 0;


	
	protected $convert_amount = 0;


	
	protected $payment_type;


	
	protected $bank_name;


	
	protected $bank_branch_name;


	
	protected $bank_address;


	
	protected $bank_acc_no;


	
	protected $bank_holder_name;


	
	protected $bank_swift_code;


	
	protected $iaccount;


	
	protected $iaccount_username;


	
	protected $payment_date;


	
	protected $payment_remark;


	
	protected $remark;


	
	protected $autowit;


	
	protected $status;


	
	protected $cdate;


	
	protected $leader_dist_id = 0;


	
	protected $branch_code;


	
	protected $aba_routing;


	
	protected $bsb_code;


	
	protected $transit_number;


	
	protected $iban;


	
	protected $account_type;


	
	protected $bank_account_currency;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUid()
	{

		return $this->uid;
	}

	
	public function getAmount()
	{

		return $this->amount;
	}

	
	public function getWithdrawAmount()
	{

		return $this->withdraw_amount;
	}

	
	public function getCharges()
	{

		return $this->charges;
	}

	
	public function getRate()
	{

		return $this->rate;
	}

	
	public function getConvertAmount()
	{

		return $this->convert_amount;
	}

	
	public function getPaymentType()
	{

		return $this->payment_type;
	}

	
	public function getBankName()
	{

		return $this->bank_name;
	}

	
	public function getBankBranchName()
	{

		return $this->bank_branch_name;
	}

	
	public function getBankAddress()
	{

		return $this->bank_address;
	}

	
	public function getBankAccNo()
	{

		return $this->bank_acc_no;
	}

	
	public function getBankHolderName()
	{

		return $this->bank_holder_name;
	}

	
	public function getBankSwiftCode()
	{

		return $this->bank_swift_code;
	}

	
	public function getIaccount()
	{

		return $this->iaccount;
	}

	
	public function getIaccountUsername()
	{

		return $this->iaccount_username;
	}

	
	public function getPaymentDate($format = 'Y-m-d H:i:s')
	{

		if ($this->payment_date === null || $this->payment_date === '') {
			return null;
		} elseif (!is_int($this->payment_date)) {
						$ts = strtotime($this->payment_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [payment_date] as date/time value: " . var_export($this->payment_date, true));
			}
		} else {
			$ts = $this->payment_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getPaymentRemark()
	{

		return $this->payment_remark;
	}

	
	public function getRemark()
	{

		return $this->remark;
	}

	
	public function getAutowit()
	{

		return $this->autowit;
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getCdate($format = 'Y-m-d H:i:s')
	{

		if ($this->cdate === null || $this->cdate === '') {
			return null;
		} elseif (!is_int($this->cdate)) {
						$ts = strtotime($this->cdate);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [cdate] as date/time value: " . var_export($this->cdate, true));
			}
		} else {
			$ts = $this->cdate;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLeaderDistId()
	{

		return $this->leader_dist_id;
	}

	
	public function getBranchCode()
	{

		return $this->branch_code;
	}

	
	public function getAbaRouting()
	{

		return $this->aba_routing;
	}

	
	public function getBsbCode()
	{

		return $this->bsb_code;
	}

	
	public function getTransitNumber()
	{

		return $this->transit_number;
	}

	
	public function getIban()
	{

		return $this->iban;
	}

	
	public function getAccountType()
	{

		return $this->account_type;
	}

	
	public function getBankAccountCurrency()
	{

		return $this->bank_account_currency;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::ID;
		}

	} 
	
	public function setUid($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->uid !== $v || $v === '0') {
			$this->uid = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::UID;
		}

	} 
	
	public function setAmount($v)
	{

		if ($this->amount !== $v || $v === 0) {
			$this->amount = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::AMOUNT;
		}

	} 
	
	public function setWithdrawAmount($v)
	{

		if ($this->withdraw_amount !== $v || $v === 0) {
			$this->withdraw_amount = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::WITHDRAW_AMOUNT;
		}

	} 
	
	public function setCharges($v)
	{

		if ($this->charges !== $v || $v === 0) {
			$this->charges = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::CHARGES;
		}

	} 
	
	public function setRate($v)
	{

		if ($this->rate !== $v || $v === 0) {
			$this->rate = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::RATE;
		}

	} 
	
	public function setConvertAmount($v)
	{

		if ($this->convert_amount !== $v || $v === 0) {
			$this->convert_amount = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::CONVERT_AMOUNT;
		}

	} 
	
	public function setPaymentType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->payment_type !== $v) {
			$this->payment_type = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::PAYMENT_TYPE;
		}

	} 
	
	public function setBankName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_name !== $v) {
			$this->bank_name = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BANK_NAME;
		}

	} 
	
	public function setBankBranchName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_branch_name !== $v) {
			$this->bank_branch_name = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BANK_BRANCH_NAME;
		}

	} 
	
	public function setBankAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_address !== $v) {
			$this->bank_address = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BANK_ADDRESS;
		}

	} 
	
	public function setBankAccNo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_acc_no !== $v) {
			$this->bank_acc_no = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BANK_ACC_NO;
		}

	} 
	
	public function setBankHolderName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_holder_name !== $v) {
			$this->bank_holder_name = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BANK_HOLDER_NAME;
		}

	} 
	
	public function setBankSwiftCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_swift_code !== $v) {
			$this->bank_swift_code = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BANK_SWIFT_CODE;
		}

	} 
	
	public function setIaccount($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->iaccount !== $v) {
			$this->iaccount = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::IACCOUNT;
		}

	} 
	
	public function setIaccountUsername($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->iaccount_username !== $v) {
			$this->iaccount_username = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::IACCOUNT_USERNAME;
		}

	} 
	
	public function setPaymentDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [payment_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->payment_date !== $ts) {
			$this->payment_date = $ts;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::PAYMENT_DATE;
		}

	} 
	
	public function setPaymentRemark($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->payment_remark !== $v) {
			$this->payment_remark = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::PAYMENT_REMARK;
		}

	} 
	
	public function setRemark($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark !== $v) {
			$this->remark = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::REMARK;
		}

	} 
	
	public function setAutowit($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->autowit !== $v) {
			$this->autowit = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::AUTOWIT;
		}

	} 
	
	public function setStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::STATUS;
		}

	} 
	
	public function setCdate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [cdate] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->cdate !== $ts) {
			$this->cdate = $ts;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::CDATE;
		}

	} 
	
	public function setLeaderDistId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->leader_dist_id !== $v || $v === 0) {
			$this->leader_dist_id = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::LEADER_DIST_ID;
		}

	} 
	
	public function setBranchCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->branch_code !== $v) {
			$this->branch_code = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BRANCH_CODE;
		}

	} 
	
	public function setAbaRouting($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->aba_routing !== $v) {
			$this->aba_routing = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::ABA_ROUTING;
		}

	} 
	
	public function setBsbCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bsb_code !== $v) {
			$this->bsb_code = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BSB_CODE;
		}

	} 
	
	public function setTransitNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->transit_number !== $v) {
			$this->transit_number = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::TRANSIT_NUMBER;
		}

	} 
	
	public function setIban($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->iban !== $v) {
			$this->iban = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::IBAN;
		}

	} 
	
	public function setAccountType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->account_type !== $v) {
			$this->account_type = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::ACCOUNT_TYPE;
		}

	} 
	
	public function setBankAccountCurrency($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_account_currency !== $v) {
			$this->bank_account_currency = $v;
			$this->modifiedColumns[] = GgMemberWithdrawPeer::BANK_ACCOUNT_CURRENCY;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getString($startcol + 0);

			$this->uid = $rs->getString($startcol + 1);

			$this->amount = $rs->getFloat($startcol + 2);

			$this->withdraw_amount = $rs->getFloat($startcol + 3);

			$this->charges = $rs->getFloat($startcol + 4);

			$this->rate = $rs->getFloat($startcol + 5);

			$this->convert_amount = $rs->getFloat($startcol + 6);

			$this->payment_type = $rs->getString($startcol + 7);

			$this->bank_name = $rs->getString($startcol + 8);

			$this->bank_branch_name = $rs->getString($startcol + 9);

			$this->bank_address = $rs->getString($startcol + 10);

			$this->bank_acc_no = $rs->getString($startcol + 11);

			$this->bank_holder_name = $rs->getString($startcol + 12);

			$this->bank_swift_code = $rs->getString($startcol + 13);

			$this->iaccount = $rs->getString($startcol + 14);

			$this->iaccount_username = $rs->getString($startcol + 15);

			$this->payment_date = $rs->getTimestamp($startcol + 16, null);

			$this->payment_remark = $rs->getString($startcol + 17);

			$this->remark = $rs->getString($startcol + 18);

			$this->autowit = $rs->getString($startcol + 19);

			$this->status = $rs->getString($startcol + 20);

			$this->cdate = $rs->getTimestamp($startcol + 21, null);

			$this->leader_dist_id = $rs->getInt($startcol + 22);

			$this->branch_code = $rs->getString($startcol + 23);

			$this->aba_routing = $rs->getString($startcol + 24);

			$this->bsb_code = $rs->getString($startcol + 25);

			$this->transit_number = $rs->getString($startcol + 26);

			$this->iban = $rs->getString($startcol + 27);

			$this->account_type = $rs->getString($startcol + 28);

			$this->bank_account_currency = $rs->getString($startcol + 29);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 30; 
		} catch (Exception $e) {
			throw new PropelException("Error populating GgMemberWithdraw object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GgMemberWithdrawPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			GgMemberWithdrawPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GgMemberWithdrawPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = GgMemberWithdrawPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += GgMemberWithdrawPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = GgMemberWithdrawPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgMemberWithdrawPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUid();
				break;
			case 2:
				return $this->getAmount();
				break;
			case 3:
				return $this->getWithdrawAmount();
				break;
			case 4:
				return $this->getCharges();
				break;
			case 5:
				return $this->getRate();
				break;
			case 6:
				return $this->getConvertAmount();
				break;
			case 7:
				return $this->getPaymentType();
				break;
			case 8:
				return $this->getBankName();
				break;
			case 9:
				return $this->getBankBranchName();
				break;
			case 10:
				return $this->getBankAddress();
				break;
			case 11:
				return $this->getBankAccNo();
				break;
			case 12:
				return $this->getBankHolderName();
				break;
			case 13:
				return $this->getBankSwiftCode();
				break;
			case 14:
				return $this->getIaccount();
				break;
			case 15:
				return $this->getIaccountUsername();
				break;
			case 16:
				return $this->getPaymentDate();
				break;
			case 17:
				return $this->getPaymentRemark();
				break;
			case 18:
				return $this->getRemark();
				break;
			case 19:
				return $this->getAutowit();
				break;
			case 20:
				return $this->getStatus();
				break;
			case 21:
				return $this->getCdate();
				break;
			case 22:
				return $this->getLeaderDistId();
				break;
			case 23:
				return $this->getBranchCode();
				break;
			case 24:
				return $this->getAbaRouting();
				break;
			case 25:
				return $this->getBsbCode();
				break;
			case 26:
				return $this->getTransitNumber();
				break;
			case 27:
				return $this->getIban();
				break;
			case 28:
				return $this->getAccountType();
				break;
			case 29:
				return $this->getBankAccountCurrency();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgMemberWithdrawPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUid(),
			$keys[2] => $this->getAmount(),
			$keys[3] => $this->getWithdrawAmount(),
			$keys[4] => $this->getCharges(),
			$keys[5] => $this->getRate(),
			$keys[6] => $this->getConvertAmount(),
			$keys[7] => $this->getPaymentType(),
			$keys[8] => $this->getBankName(),
			$keys[9] => $this->getBankBranchName(),
			$keys[10] => $this->getBankAddress(),
			$keys[11] => $this->getBankAccNo(),
			$keys[12] => $this->getBankHolderName(),
			$keys[13] => $this->getBankSwiftCode(),
			$keys[14] => $this->getIaccount(),
			$keys[15] => $this->getIaccountUsername(),
			$keys[16] => $this->getPaymentDate(),
			$keys[17] => $this->getPaymentRemark(),
			$keys[18] => $this->getRemark(),
			$keys[19] => $this->getAutowit(),
			$keys[20] => $this->getStatus(),
			$keys[21] => $this->getCdate(),
			$keys[22] => $this->getLeaderDistId(),
			$keys[23] => $this->getBranchCode(),
			$keys[24] => $this->getAbaRouting(),
			$keys[25] => $this->getBsbCode(),
			$keys[26] => $this->getTransitNumber(),
			$keys[27] => $this->getIban(),
			$keys[28] => $this->getAccountType(),
			$keys[29] => $this->getBankAccountCurrency(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgMemberWithdrawPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUid($value);
				break;
			case 2:
				$this->setAmount($value);
				break;
			case 3:
				$this->setWithdrawAmount($value);
				break;
			case 4:
				$this->setCharges($value);
				break;
			case 5:
				$this->setRate($value);
				break;
			case 6:
				$this->setConvertAmount($value);
				break;
			case 7:
				$this->setPaymentType($value);
				break;
			case 8:
				$this->setBankName($value);
				break;
			case 9:
				$this->setBankBranchName($value);
				break;
			case 10:
				$this->setBankAddress($value);
				break;
			case 11:
				$this->setBankAccNo($value);
				break;
			case 12:
				$this->setBankHolderName($value);
				break;
			case 13:
				$this->setBankSwiftCode($value);
				break;
			case 14:
				$this->setIaccount($value);
				break;
			case 15:
				$this->setIaccountUsername($value);
				break;
			case 16:
				$this->setPaymentDate($value);
				break;
			case 17:
				$this->setPaymentRemark($value);
				break;
			case 18:
				$this->setRemark($value);
				break;
			case 19:
				$this->setAutowit($value);
				break;
			case 20:
				$this->setStatus($value);
				break;
			case 21:
				$this->setCdate($value);
				break;
			case 22:
				$this->setLeaderDistId($value);
				break;
			case 23:
				$this->setBranchCode($value);
				break;
			case 24:
				$this->setAbaRouting($value);
				break;
			case 25:
				$this->setBsbCode($value);
				break;
			case 26:
				$this->setTransitNumber($value);
				break;
			case 27:
				$this->setIban($value);
				break;
			case 28:
				$this->setAccountType($value);
				break;
			case 29:
				$this->setBankAccountCurrency($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgMemberWithdrawPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUid($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAmount($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setWithdrawAmount($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCharges($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRate($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setConvertAmount($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPaymentType($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setBankName($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setBankBranchName($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setBankAddress($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setBankAccNo($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setBankHolderName($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setBankSwiftCode($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setIaccount($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setIaccountUsername($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setPaymentDate($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setPaymentRemark($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setRemark($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setAutowit($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setStatus($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setCdate($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setLeaderDistId($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setBranchCode($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setAbaRouting($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setBsbCode($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setTransitNumber($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setIban($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setAccountType($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setBankAccountCurrency($arr[$keys[29]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(GgMemberWithdrawPeer::DATABASE_NAME);

		if ($this->isColumnModified(GgMemberWithdrawPeer::ID)) $criteria->add(GgMemberWithdrawPeer::ID, $this->id);
		if ($this->isColumnModified(GgMemberWithdrawPeer::UID)) $criteria->add(GgMemberWithdrawPeer::UID, $this->uid);
		if ($this->isColumnModified(GgMemberWithdrawPeer::AMOUNT)) $criteria->add(GgMemberWithdrawPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(GgMemberWithdrawPeer::WITHDRAW_AMOUNT)) $criteria->add(GgMemberWithdrawPeer::WITHDRAW_AMOUNT, $this->withdraw_amount);
		if ($this->isColumnModified(GgMemberWithdrawPeer::CHARGES)) $criteria->add(GgMemberWithdrawPeer::CHARGES, $this->charges);
		if ($this->isColumnModified(GgMemberWithdrawPeer::RATE)) $criteria->add(GgMemberWithdrawPeer::RATE, $this->rate);
		if ($this->isColumnModified(GgMemberWithdrawPeer::CONVERT_AMOUNT)) $criteria->add(GgMemberWithdrawPeer::CONVERT_AMOUNT, $this->convert_amount);
		if ($this->isColumnModified(GgMemberWithdrawPeer::PAYMENT_TYPE)) $criteria->add(GgMemberWithdrawPeer::PAYMENT_TYPE, $this->payment_type);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BANK_NAME)) $criteria->add(GgMemberWithdrawPeer::BANK_NAME, $this->bank_name);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BANK_BRANCH_NAME)) $criteria->add(GgMemberWithdrawPeer::BANK_BRANCH_NAME, $this->bank_branch_name);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BANK_ADDRESS)) $criteria->add(GgMemberWithdrawPeer::BANK_ADDRESS, $this->bank_address);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BANK_ACC_NO)) $criteria->add(GgMemberWithdrawPeer::BANK_ACC_NO, $this->bank_acc_no);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BANK_HOLDER_NAME)) $criteria->add(GgMemberWithdrawPeer::BANK_HOLDER_NAME, $this->bank_holder_name);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BANK_SWIFT_CODE)) $criteria->add(GgMemberWithdrawPeer::BANK_SWIFT_CODE, $this->bank_swift_code);
		if ($this->isColumnModified(GgMemberWithdrawPeer::IACCOUNT)) $criteria->add(GgMemberWithdrawPeer::IACCOUNT, $this->iaccount);
		if ($this->isColumnModified(GgMemberWithdrawPeer::IACCOUNT_USERNAME)) $criteria->add(GgMemberWithdrawPeer::IACCOUNT_USERNAME, $this->iaccount_username);
		if ($this->isColumnModified(GgMemberWithdrawPeer::PAYMENT_DATE)) $criteria->add(GgMemberWithdrawPeer::PAYMENT_DATE, $this->payment_date);
		if ($this->isColumnModified(GgMemberWithdrawPeer::PAYMENT_REMARK)) $criteria->add(GgMemberWithdrawPeer::PAYMENT_REMARK, $this->payment_remark);
		if ($this->isColumnModified(GgMemberWithdrawPeer::REMARK)) $criteria->add(GgMemberWithdrawPeer::REMARK, $this->remark);
		if ($this->isColumnModified(GgMemberWithdrawPeer::AUTOWIT)) $criteria->add(GgMemberWithdrawPeer::AUTOWIT, $this->autowit);
		if ($this->isColumnModified(GgMemberWithdrawPeer::STATUS)) $criteria->add(GgMemberWithdrawPeer::STATUS, $this->status);
		if ($this->isColumnModified(GgMemberWithdrawPeer::CDATE)) $criteria->add(GgMemberWithdrawPeer::CDATE, $this->cdate);
		if ($this->isColumnModified(GgMemberWithdrawPeer::LEADER_DIST_ID)) $criteria->add(GgMemberWithdrawPeer::LEADER_DIST_ID, $this->leader_dist_id);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BRANCH_CODE)) $criteria->add(GgMemberWithdrawPeer::BRANCH_CODE, $this->branch_code);
		if ($this->isColumnModified(GgMemberWithdrawPeer::ABA_ROUTING)) $criteria->add(GgMemberWithdrawPeer::ABA_ROUTING, $this->aba_routing);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BSB_CODE)) $criteria->add(GgMemberWithdrawPeer::BSB_CODE, $this->bsb_code);
		if ($this->isColumnModified(GgMemberWithdrawPeer::TRANSIT_NUMBER)) $criteria->add(GgMemberWithdrawPeer::TRANSIT_NUMBER, $this->transit_number);
		if ($this->isColumnModified(GgMemberWithdrawPeer::IBAN)) $criteria->add(GgMemberWithdrawPeer::IBAN, $this->iban);
		if ($this->isColumnModified(GgMemberWithdrawPeer::ACCOUNT_TYPE)) $criteria->add(GgMemberWithdrawPeer::ACCOUNT_TYPE, $this->account_type);
		if ($this->isColumnModified(GgMemberWithdrawPeer::BANK_ACCOUNT_CURRENCY)) $criteria->add(GgMemberWithdrawPeer::BANK_ACCOUNT_CURRENCY, $this->bank_account_currency);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GgMemberWithdrawPeer::DATABASE_NAME);

		$criteria->add(GgMemberWithdrawPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUid($this->uid);

		$copyObj->setAmount($this->amount);

		$copyObj->setWithdrawAmount($this->withdraw_amount);

		$copyObj->setCharges($this->charges);

		$copyObj->setRate($this->rate);

		$copyObj->setConvertAmount($this->convert_amount);

		$copyObj->setPaymentType($this->payment_type);

		$copyObj->setBankName($this->bank_name);

		$copyObj->setBankBranchName($this->bank_branch_name);

		$copyObj->setBankAddress($this->bank_address);

		$copyObj->setBankAccNo($this->bank_acc_no);

		$copyObj->setBankHolderName($this->bank_holder_name);

		$copyObj->setBankSwiftCode($this->bank_swift_code);

		$copyObj->setIaccount($this->iaccount);

		$copyObj->setIaccountUsername($this->iaccount_username);

		$copyObj->setPaymentDate($this->payment_date);

		$copyObj->setPaymentRemark($this->payment_remark);

		$copyObj->setRemark($this->remark);

		$copyObj->setAutowit($this->autowit);

		$copyObj->setStatus($this->status);

		$copyObj->setCdate($this->cdate);

		$copyObj->setLeaderDistId($this->leader_dist_id);

		$copyObj->setBranchCode($this->branch_code);

		$copyObj->setAbaRouting($this->aba_routing);

		$copyObj->setBsbCode($this->bsb_code);

		$copyObj->setTransitNumber($this->transit_number);

		$copyObj->setIban($this->iban);

		$copyObj->setAccountType($this->account_type);

		$copyObj->setBankAccountCurrency($this->bank_account_currency);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new GgMemberWithdrawPeer();
		}
		return self::$peer;
	}

} 