<?php


abstract class BaseMbsCostcontrol extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $mbs_id;


	
	protected $idx;


	
	protected $description_of_expenditure;


	
	protected $budget = 0;


	
	protected $service_charge = 0;


	
	protected $gst = 0;


	
	protected $total_nett_amount = 0;


	
	protected $payments_made = 0;


	
	protected $balance_payable = 0;


	
	protected $remarks;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getMbsId()
	{

		return $this->mbs_id;
	}

	
	public function getIdx()
	{

		return $this->idx;
	}

	
	public function getDescriptionOfExpenditure()
	{

		return $this->description_of_expenditure;
	}

	
	public function getBudget()
	{

		return $this->budget;
	}

	
	public function getServiceCharge()
	{

		return $this->service_charge;
	}

	
	public function getGst()
	{

		return $this->gst;
	}

	
	public function getTotalNettAmount()
	{

		return $this->total_nett_amount;
	}

	
	public function getPaymentsMade()
	{

		return $this->payments_made;
	}

	
	public function getBalancePayable()
	{

		return $this->balance_payable;
	}

	
	public function getRemarks()
	{

		return $this->remarks;
	}

	
	public function getCreatedBy()
	{

		return $this->created_by;
	}

	
	public function getCreatedOn($format = 'Y-m-d H:i:s')
	{

		if ($this->created_on === null || $this->created_on === '') {
			return null;
		} elseif (!is_int($this->created_on)) {
						$ts = strtotime($this->created_on);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_on] as date/time value: " . var_export($this->created_on, true));
			}
		} else {
			$ts = $this->created_on;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUpdatedBy()
	{

		return $this->updated_by;
	}

	
	public function getUpdatedOn($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_on === null || $this->updated_on === '') {
			return null;
		} elseif (!is_int($this->updated_on)) {
						$ts = strtotime($this->updated_on);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_on] as date/time value: " . var_export($this->updated_on, true));
			}
		} else {
			$ts = $this->updated_on;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setMbsId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->mbs_id !== $v) {
			$this->mbs_id = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::MBS_ID;
		}

	} 
	
	public function setIdx($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->idx !== $v) {
			$this->idx = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::IDX;
		}

	} 
	
	public function setDescriptionOfExpenditure($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description_of_expenditure !== $v) {
			$this->description_of_expenditure = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::DESCRIPTION_OF_EXPENDITURE;
		}

	} 
	
	public function setBudget($v)
	{

		if ($this->budget !== $v || $v === 0) {
			$this->budget = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::BUDGET;
		}

	} 
	
	public function setServiceCharge($v)
	{

		if ($this->service_charge !== $v || $v === 0) {
			$this->service_charge = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::SERVICE_CHARGE;
		}

	} 
	
	public function setGst($v)
	{

		if ($this->gst !== $v || $v === 0) {
			$this->gst = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::GST;
		}

	} 
	
	public function setTotalNettAmount($v)
	{

		if ($this->total_nett_amount !== $v || $v === 0) {
			$this->total_nett_amount = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::TOTAL_NETT_AMOUNT;
		}

	} 
	
	public function setPaymentsMade($v)
	{

		if ($this->payments_made !== $v || $v === 0) {
			$this->payments_made = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::PAYMENTS_MADE;
		}

	} 
	
	public function setBalancePayable($v)
	{

		if ($this->balance_payable !== $v || $v === 0) {
			$this->balance_payable = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::BALANCE_PAYABLE;
		}

	} 
	
	public function setRemarks($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remarks !== $v) {
			$this->remarks = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::REMARKS;
		}

	} 
	
	public function setCreatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::CREATED_BY;
		}

	} 
	
	public function setCreatedOn($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_on] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_on !== $ts) {
			$this->created_on = $ts;
			$this->modifiedColumns[] = MbsCostcontrolPeer::CREATED_ON;
		}

	} 
	
	public function setUpdatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = MbsCostcontrolPeer::UPDATED_BY;
		}

	} 
	
	public function setUpdatedOn($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_on] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_on !== $ts) {
			$this->updated_on = $ts;
			$this->modifiedColumns[] = MbsCostcontrolPeer::UPDATED_ON;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->mbs_id = $rs->getInt($startcol + 0);

			$this->idx = $rs->getInt($startcol + 1);

			$this->description_of_expenditure = $rs->getString($startcol + 2);

			$this->budget = $rs->getFloat($startcol + 3);

			$this->service_charge = $rs->getFloat($startcol + 4);

			$this->gst = $rs->getFloat($startcol + 5);

			$this->total_nett_amount = $rs->getFloat($startcol + 6);

			$this->payments_made = $rs->getFloat($startcol + 7);

			$this->balance_payable = $rs->getFloat($startcol + 8);

			$this->remarks = $rs->getString($startcol + 9);

			$this->created_by = $rs->getInt($startcol + 10);

			$this->created_on = $rs->getTimestamp($startcol + 11, null);

			$this->updated_by = $rs->getInt($startcol + 12);

			$this->updated_on = $rs->getTimestamp($startcol + 13, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 14; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MbsCostcontrol object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MbsCostcontrolPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MbsCostcontrolPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MbsCostcontrolPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MbsCostcontrolPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MbsCostcontrolPeer::DATABASE_NAME);
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
					$pk = MbsCostcontrolPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setMbsId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MbsCostcontrolPeer::doUpdate($this, $con);
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


			if (($retval = MbsCostcontrolPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MbsCostcontrolPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getMbsId();
				break;
			case 1:
				return $this->getIdx();
				break;
			case 2:
				return $this->getDescriptionOfExpenditure();
				break;
			case 3:
				return $this->getBudget();
				break;
			case 4:
				return $this->getServiceCharge();
				break;
			case 5:
				return $this->getGst();
				break;
			case 6:
				return $this->getTotalNettAmount();
				break;
			case 7:
				return $this->getPaymentsMade();
				break;
			case 8:
				return $this->getBalancePayable();
				break;
			case 9:
				return $this->getRemarks();
				break;
			case 10:
				return $this->getCreatedBy();
				break;
			case 11:
				return $this->getCreatedOn();
				break;
			case 12:
				return $this->getUpdatedBy();
				break;
			case 13:
				return $this->getUpdatedOn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MbsCostcontrolPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getMbsId(),
			$keys[1] => $this->getIdx(),
			$keys[2] => $this->getDescriptionOfExpenditure(),
			$keys[3] => $this->getBudget(),
			$keys[4] => $this->getServiceCharge(),
			$keys[5] => $this->getGst(),
			$keys[6] => $this->getTotalNettAmount(),
			$keys[7] => $this->getPaymentsMade(),
			$keys[8] => $this->getBalancePayable(),
			$keys[9] => $this->getRemarks(),
			$keys[10] => $this->getCreatedBy(),
			$keys[11] => $this->getCreatedOn(),
			$keys[12] => $this->getUpdatedBy(),
			$keys[13] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MbsCostcontrolPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setMbsId($value);
				break;
			case 1:
				$this->setIdx($value);
				break;
			case 2:
				$this->setDescriptionOfExpenditure($value);
				break;
			case 3:
				$this->setBudget($value);
				break;
			case 4:
				$this->setServiceCharge($value);
				break;
			case 5:
				$this->setGst($value);
				break;
			case 6:
				$this->setTotalNettAmount($value);
				break;
			case 7:
				$this->setPaymentsMade($value);
				break;
			case 8:
				$this->setBalancePayable($value);
				break;
			case 9:
				$this->setRemarks($value);
				break;
			case 10:
				$this->setCreatedBy($value);
				break;
			case 11:
				$this->setCreatedOn($value);
				break;
			case 12:
				$this->setUpdatedBy($value);
				break;
			case 13:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MbsCostcontrolPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setMbsId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIdx($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescriptionOfExpenditure($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setBudget($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setServiceCharge($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setGst($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setTotalNettAmount($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPaymentsMade($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setBalancePayable($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRemarks($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedBy($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedOn($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedBy($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setUpdatedOn($arr[$keys[13]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MbsCostcontrolPeer::DATABASE_NAME);

		if ($this->isColumnModified(MbsCostcontrolPeer::MBS_ID)) $criteria->add(MbsCostcontrolPeer::MBS_ID, $this->mbs_id);
		if ($this->isColumnModified(MbsCostcontrolPeer::IDX)) $criteria->add(MbsCostcontrolPeer::IDX, $this->idx);
		if ($this->isColumnModified(MbsCostcontrolPeer::DESCRIPTION_OF_EXPENDITURE)) $criteria->add(MbsCostcontrolPeer::DESCRIPTION_OF_EXPENDITURE, $this->description_of_expenditure);
		if ($this->isColumnModified(MbsCostcontrolPeer::BUDGET)) $criteria->add(MbsCostcontrolPeer::BUDGET, $this->budget);
		if ($this->isColumnModified(MbsCostcontrolPeer::SERVICE_CHARGE)) $criteria->add(MbsCostcontrolPeer::SERVICE_CHARGE, $this->service_charge);
		if ($this->isColumnModified(MbsCostcontrolPeer::GST)) $criteria->add(MbsCostcontrolPeer::GST, $this->gst);
		if ($this->isColumnModified(MbsCostcontrolPeer::TOTAL_NETT_AMOUNT)) $criteria->add(MbsCostcontrolPeer::TOTAL_NETT_AMOUNT, $this->total_nett_amount);
		if ($this->isColumnModified(MbsCostcontrolPeer::PAYMENTS_MADE)) $criteria->add(MbsCostcontrolPeer::PAYMENTS_MADE, $this->payments_made);
		if ($this->isColumnModified(MbsCostcontrolPeer::BALANCE_PAYABLE)) $criteria->add(MbsCostcontrolPeer::BALANCE_PAYABLE, $this->balance_payable);
		if ($this->isColumnModified(MbsCostcontrolPeer::REMARKS)) $criteria->add(MbsCostcontrolPeer::REMARKS, $this->remarks);
		if ($this->isColumnModified(MbsCostcontrolPeer::CREATED_BY)) $criteria->add(MbsCostcontrolPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(MbsCostcontrolPeer::CREATED_ON)) $criteria->add(MbsCostcontrolPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(MbsCostcontrolPeer::UPDATED_BY)) $criteria->add(MbsCostcontrolPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(MbsCostcontrolPeer::UPDATED_ON)) $criteria->add(MbsCostcontrolPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MbsCostcontrolPeer::DATABASE_NAME);

		$criteria->add(MbsCostcontrolPeer::MBS_ID, $this->mbs_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getMbsId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setMbsId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIdx($this->idx);

		$copyObj->setDescriptionOfExpenditure($this->description_of_expenditure);

		$copyObj->setBudget($this->budget);

		$copyObj->setServiceCharge($this->service_charge);

		$copyObj->setGst($this->gst);

		$copyObj->setTotalNettAmount($this->total_nett_amount);

		$copyObj->setPaymentsMade($this->payments_made);

		$copyObj->setBalancePayable($this->balance_payable);

		$copyObj->setRemarks($this->remarks);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setMbsId(NULL); 
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
			self::$peer = new MbsCostcontrolPeer();
		}
		return self::$peer;
	}

} 