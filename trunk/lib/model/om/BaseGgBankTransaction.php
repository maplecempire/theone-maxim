<?php


abstract class BaseGgBankTransaction extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $filename;


	
	protected $bank_in_to;


	
	protected $currency;


	
	protected $amount = 0;


	
	protected $code;


	
	protected $eswallet = 0;


	
	protected $bankin_status;


	
	protected $bdate;


	
	protected $adate;


	
	protected $cdate;


	
	protected $create_by;


	
	protected $approve_by;


	
	protected $remark1;


	
	protected $remark2;


	
	protected $status;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFilename()
	{

		return $this->filename;
	}

	
	public function getBankInTo()
	{

		return $this->bank_in_to;
	}

	
	public function getCurrency()
	{

		return $this->currency;
	}

	
	public function getAmount()
	{

		return $this->amount;
	}

	
	public function getCode()
	{

		return $this->code;
	}

	
	public function getEswallet()
	{

		return $this->eswallet;
	}

	
	public function getBankinStatus()
	{

		return $this->bankin_status;
	}

	
	public function getBdate($format = 'Y-m-d')
	{

		if ($this->bdate === null || $this->bdate === '') {
			return null;
		} elseif (!is_int($this->bdate)) {
						$ts = strtotime($this->bdate);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [bdate] as date/time value: " . var_export($this->bdate, true));
			}
		} else {
			$ts = $this->bdate;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getAdate($format = 'Y-m-d H:i:s')
	{

		if ($this->adate === null || $this->adate === '') {
			return null;
		} elseif (!is_int($this->adate)) {
						$ts = strtotime($this->adate);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [adate] as date/time value: " . var_export($this->adate, true));
			}
		} else {
			$ts = $this->adate;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
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

	
	public function getCreateBy()
	{

		return $this->create_by;
	}

	
	public function getApproveBy()
	{

		return $this->approve_by;
	}

	
	public function getRemark1()
	{

		return $this->remark1;
	}

	
	public function getRemark2()
	{

		return $this->remark2;
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::ID;
		}

	} 
	
	public function setFilename($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filename !== $v) {
			$this->filename = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::FILENAME;
		}

	} 
	
	public function setBankInTo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_in_to !== $v) {
			$this->bank_in_to = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::BANK_IN_TO;
		}

	} 
	
	public function setCurrency($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->currency !== $v) {
			$this->currency = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::CURRENCY;
		}

	} 
	
	public function setAmount($v)
	{

		if ($this->amount !== $v || $v === 0) {
			$this->amount = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::AMOUNT;
		}

	} 
	
	public function setCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->code !== $v) {
			$this->code = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::CODE;
		}

	} 
	
	public function setEswallet($v)
	{

		if ($this->eswallet !== $v || $v === 0) {
			$this->eswallet = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::ESWALLET;
		}

	} 
	
	public function setBankinStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bankin_status !== $v) {
			$this->bankin_status = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::BANKIN_STATUS;
		}

	} 
	
	public function setBdate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [bdate] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->bdate !== $ts) {
			$this->bdate = $ts;
			$this->modifiedColumns[] = GgBankTransactionPeer::BDATE;
		}

	} 
	
	public function setAdate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [adate] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->adate !== $ts) {
			$this->adate = $ts;
			$this->modifiedColumns[] = GgBankTransactionPeer::ADATE;
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
			$this->modifiedColumns[] = GgBankTransactionPeer::CDATE;
		}

	} 
	
	public function setCreateBy($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->create_by !== $v) {
			$this->create_by = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::CREATE_BY;
		}

	} 
	
	public function setApproveBy($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->approve_by !== $v) {
			$this->approve_by = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::APPROVE_BY;
		}

	} 
	
	public function setRemark1($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark1 !== $v) {
			$this->remark1 = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::REMARK1;
		}

	} 
	
	public function setRemark2($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark2 !== $v) {
			$this->remark2 = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::REMARK2;
		}

	} 
	
	public function setStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = GgBankTransactionPeer::STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->filename = $rs->getString($startcol + 1);

			$this->bank_in_to = $rs->getString($startcol + 2);

			$this->currency = $rs->getString($startcol + 3);

			$this->amount = $rs->getFloat($startcol + 4);

			$this->code = $rs->getString($startcol + 5);

			$this->eswallet = $rs->getFloat($startcol + 6);

			$this->bankin_status = $rs->getString($startcol + 7);

			$this->bdate = $rs->getDate($startcol + 8, null);

			$this->adate = $rs->getTimestamp($startcol + 9, null);

			$this->cdate = $rs->getTimestamp($startcol + 10, null);

			$this->create_by = $rs->getString($startcol + 11);

			$this->approve_by = $rs->getString($startcol + 12);

			$this->remark1 = $rs->getString($startcol + 13);

			$this->remark2 = $rs->getString($startcol + 14);

			$this->status = $rs->getString($startcol + 15);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
		} catch (Exception $e) {
			throw new PropelException("Error populating GgBankTransaction object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GgBankTransactionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			GgBankTransactionPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(GgBankTransactionPeer::DATABASE_NAME);
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
					$pk = GgBankTransactionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += GgBankTransactionPeer::doUpdate($this, $con);
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


			if (($retval = GgBankTransactionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgBankTransactionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFilename();
				break;
			case 2:
				return $this->getBankInTo();
				break;
			case 3:
				return $this->getCurrency();
				break;
			case 4:
				return $this->getAmount();
				break;
			case 5:
				return $this->getCode();
				break;
			case 6:
				return $this->getEswallet();
				break;
			case 7:
				return $this->getBankinStatus();
				break;
			case 8:
				return $this->getBdate();
				break;
			case 9:
				return $this->getAdate();
				break;
			case 10:
				return $this->getCdate();
				break;
			case 11:
				return $this->getCreateBy();
				break;
			case 12:
				return $this->getApproveBy();
				break;
			case 13:
				return $this->getRemark1();
				break;
			case 14:
				return $this->getRemark2();
				break;
			case 15:
				return $this->getStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgBankTransactionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFilename(),
			$keys[2] => $this->getBankInTo(),
			$keys[3] => $this->getCurrency(),
			$keys[4] => $this->getAmount(),
			$keys[5] => $this->getCode(),
			$keys[6] => $this->getEswallet(),
			$keys[7] => $this->getBankinStatus(),
			$keys[8] => $this->getBdate(),
			$keys[9] => $this->getAdate(),
			$keys[10] => $this->getCdate(),
			$keys[11] => $this->getCreateBy(),
			$keys[12] => $this->getApproveBy(),
			$keys[13] => $this->getRemark1(),
			$keys[14] => $this->getRemark2(),
			$keys[15] => $this->getStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgBankTransactionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFilename($value);
				break;
			case 2:
				$this->setBankInTo($value);
				break;
			case 3:
				$this->setCurrency($value);
				break;
			case 4:
				$this->setAmount($value);
				break;
			case 5:
				$this->setCode($value);
				break;
			case 6:
				$this->setEswallet($value);
				break;
			case 7:
				$this->setBankinStatus($value);
				break;
			case 8:
				$this->setBdate($value);
				break;
			case 9:
				$this->setAdate($value);
				break;
			case 10:
				$this->setCdate($value);
				break;
			case 11:
				$this->setCreateBy($value);
				break;
			case 12:
				$this->setApproveBy($value);
				break;
			case 13:
				$this->setRemark1($value);
				break;
			case 14:
				$this->setRemark2($value);
				break;
			case 15:
				$this->setStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgBankTransactionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFilename($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setBankInTo($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCurrency($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setAmount($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCode($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setEswallet($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setBankinStatus($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setBdate($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setAdate($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCdate($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreateBy($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setApproveBy($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setRemark1($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setRemark2($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setStatus($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(GgBankTransactionPeer::DATABASE_NAME);

		if ($this->isColumnModified(GgBankTransactionPeer::ID)) $criteria->add(GgBankTransactionPeer::ID, $this->id);
		if ($this->isColumnModified(GgBankTransactionPeer::FILENAME)) $criteria->add(GgBankTransactionPeer::FILENAME, $this->filename);
		if ($this->isColumnModified(GgBankTransactionPeer::BANK_IN_TO)) $criteria->add(GgBankTransactionPeer::BANK_IN_TO, $this->bank_in_to);
		if ($this->isColumnModified(GgBankTransactionPeer::CURRENCY)) $criteria->add(GgBankTransactionPeer::CURRENCY, $this->currency);
		if ($this->isColumnModified(GgBankTransactionPeer::AMOUNT)) $criteria->add(GgBankTransactionPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(GgBankTransactionPeer::CODE)) $criteria->add(GgBankTransactionPeer::CODE, $this->code);
		if ($this->isColumnModified(GgBankTransactionPeer::ESWALLET)) $criteria->add(GgBankTransactionPeer::ESWALLET, $this->eswallet);
		if ($this->isColumnModified(GgBankTransactionPeer::BANKIN_STATUS)) $criteria->add(GgBankTransactionPeer::BANKIN_STATUS, $this->bankin_status);
		if ($this->isColumnModified(GgBankTransactionPeer::BDATE)) $criteria->add(GgBankTransactionPeer::BDATE, $this->bdate);
		if ($this->isColumnModified(GgBankTransactionPeer::ADATE)) $criteria->add(GgBankTransactionPeer::ADATE, $this->adate);
		if ($this->isColumnModified(GgBankTransactionPeer::CDATE)) $criteria->add(GgBankTransactionPeer::CDATE, $this->cdate);
		if ($this->isColumnModified(GgBankTransactionPeer::CREATE_BY)) $criteria->add(GgBankTransactionPeer::CREATE_BY, $this->create_by);
		if ($this->isColumnModified(GgBankTransactionPeer::APPROVE_BY)) $criteria->add(GgBankTransactionPeer::APPROVE_BY, $this->approve_by);
		if ($this->isColumnModified(GgBankTransactionPeer::REMARK1)) $criteria->add(GgBankTransactionPeer::REMARK1, $this->remark1);
		if ($this->isColumnModified(GgBankTransactionPeer::REMARK2)) $criteria->add(GgBankTransactionPeer::REMARK2, $this->remark2);
		if ($this->isColumnModified(GgBankTransactionPeer::STATUS)) $criteria->add(GgBankTransactionPeer::STATUS, $this->status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GgBankTransactionPeer::DATABASE_NAME);

		$criteria->add(GgBankTransactionPeer::ID, $this->id);

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

		$copyObj->setFilename($this->filename);

		$copyObj->setBankInTo($this->bank_in_to);

		$copyObj->setCurrency($this->currency);

		$copyObj->setAmount($this->amount);

		$copyObj->setCode($this->code);

		$copyObj->setEswallet($this->eswallet);

		$copyObj->setBankinStatus($this->bankin_status);

		$copyObj->setBdate($this->bdate);

		$copyObj->setAdate($this->adate);

		$copyObj->setCdate($this->cdate);

		$copyObj->setCreateBy($this->create_by);

		$copyObj->setApproveBy($this->approve_by);

		$copyObj->setRemark1($this->remark1);

		$copyObj->setRemark2($this->remark2);

		$copyObj->setStatus($this->status);


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
			self::$peer = new GgBankTransactionPeer();
		}
		return self::$peer;
	}

} 