<?php


abstract class BaseMlmPackage extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $package_id;


	
	protected $package_name;


	
	protected $price;


	
	protected $commission;


	
	protected $credit_refund;


	
	protected $pairing_bonus = 0;


	
	protected $daily_max_pairing = 0;


	
	protected $public_purchase = '1';


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getPackageId()
	{

		return $this->package_id;
	}

	
	public function getPackageName()
	{

		return $this->package_name;
	}

	
	public function getPrice()
	{

		return $this->price;
	}

	
	public function getCommission()
	{

		return $this->commission;
	}

	
	public function getCreditRefund()
	{

		return $this->credit_refund;
	}

	
	public function getPairingBonus()
	{

		return $this->pairing_bonus;
	}

	
	public function getDailyMaxPairing()
	{

		return $this->daily_max_pairing;
	}

	
	public function getPublicPurchase()
	{

		return $this->public_purchase;
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

	
	public function setPackageId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->package_id !== $v) {
			$this->package_id = $v;
			$this->modifiedColumns[] = MlmPackagePeer::PACKAGE_ID;
		}

	} 

	
	public function setPackageName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->package_name !== $v) {
			$this->package_name = $v;
			$this->modifiedColumns[] = MlmPackagePeer::PACKAGE_NAME;
		}

	} 

	
	public function setPrice($v)
	{

		if ($this->price !== $v) {
			$this->price = $v;
			$this->modifiedColumns[] = MlmPackagePeer::PRICE;
		}

	} 

	
	public function setCommission($v)
	{

		if ($this->commission !== $v) {
			$this->commission = $v;
			$this->modifiedColumns[] = MlmPackagePeer::COMMISSION;
		}

	} 

	
	public function setCreditRefund($v)
	{

		if ($this->credit_refund !== $v) {
			$this->credit_refund = $v;
			$this->modifiedColumns[] = MlmPackagePeer::CREDIT_REFUND;
		}

	} 

	
	public function setPairingBonus($v)
	{

		if ($this->pairing_bonus !== $v || $v === 0) {
			$this->pairing_bonus = $v;
			$this->modifiedColumns[] = MlmPackagePeer::PAIRING_BONUS;
		}

	} 

	
	public function setDailyMaxPairing($v)
	{

		if ($this->daily_max_pairing !== $v || $v === 0) {
			$this->daily_max_pairing = $v;
			$this->modifiedColumns[] = MlmPackagePeer::DAILY_MAX_PAIRING;
		}

	} 

	
	public function setPublicPurchase($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->public_purchase !== $v || $v === '1') {
			$this->public_purchase = $v;
			$this->modifiedColumns[] = MlmPackagePeer::PUBLIC_PURCHASE;
		}

	} 

	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = MlmPackagePeer::CREATED_BY;
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
			$this->modifiedColumns[] = MlmPackagePeer::CREATED_ON;
		}

	} 

	
	public function setUpdatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = MlmPackagePeer::UPDATED_BY;
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
			$this->modifiedColumns[] = MlmPackagePeer::UPDATED_ON;
		}

	} 

	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->package_id = $rs->getInt($startcol + 0);

			$this->package_name = $rs->getString($startcol + 1);

			$this->price = $rs->getFloat($startcol + 2);

			$this->commission = $rs->getFloat($startcol + 3);

			$this->credit_refund = $rs->getFloat($startcol + 4);

			$this->pairing_bonus = $rs->getFloat($startcol + 5);

			$this->daily_max_pairing = $rs->getFloat($startcol + 6);

			$this->public_purchase = $rs->getString($startcol + 7);

			$this->created_by = $rs->getInt($startcol + 8);

			$this->created_on = $rs->getTimestamp($startcol + 9, null);

			$this->updated_by = $rs->getInt($startcol + 10);

			$this->updated_on = $rs->getTimestamp($startcol + 11, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MlmPackage object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmPackagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MlmPackagePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MlmPackagePeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MlmPackagePeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmPackagePeer::DATABASE_NAME);
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
		$affectedRows = 0; 
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MlmPackagePeer::doInsert($this, $con);
					$affectedRows += 1; 
										 
										 

					$this->setPackageId($pk);  

					$this->setNew(false);
				} else {
					$affectedRows += MlmPackagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 
			}

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


			if (($retval = MlmPackagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmPackagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getPackageId();
				break;
			case 1:
				return $this->getPackageName();
				break;
			case 2:
				return $this->getPrice();
				break;
			case 3:
				return $this->getCommission();
				break;
			case 4:
				return $this->getCreditRefund();
				break;
			case 5:
				return $this->getPairingBonus();
				break;
			case 6:
				return $this->getDailyMaxPairing();
				break;
			case 7:
				return $this->getPublicPurchase();
				break;
			case 8:
				return $this->getCreatedBy();
				break;
			case 9:
				return $this->getCreatedOn();
				break;
			case 10:
				return $this->getUpdatedBy();
				break;
			case 11:
				return $this->getUpdatedOn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmPackagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getPackageId(),
			$keys[1] => $this->getPackageName(),
			$keys[2] => $this->getPrice(),
			$keys[3] => $this->getCommission(),
			$keys[4] => $this->getCreditRefund(),
			$keys[5] => $this->getPairingBonus(),
			$keys[6] => $this->getDailyMaxPairing(),
			$keys[7] => $this->getPublicPurchase(),
			$keys[8] => $this->getCreatedBy(),
			$keys[9] => $this->getCreatedOn(),
			$keys[10] => $this->getUpdatedBy(),
			$keys[11] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmPackagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setPackageId($value);
				break;
			case 1:
				$this->setPackageName($value);
				break;
			case 2:
				$this->setPrice($value);
				break;
			case 3:
				$this->setCommission($value);
				break;
			case 4:
				$this->setCreditRefund($value);
				break;
			case 5:
				$this->setPairingBonus($value);
				break;
			case 6:
				$this->setDailyMaxPairing($value);
				break;
			case 7:
				$this->setPublicPurchase($value);
				break;
			case 8:
				$this->setCreatedBy($value);
				break;
			case 9:
				$this->setCreatedOn($value);
				break;
			case 10:
				$this->setUpdatedBy($value);
				break;
			case 11:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmPackagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setPackageId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPackageName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPrice($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCommission($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreditRefund($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPairingBonus($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDailyMaxPairing($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPublicPurchase($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedOn($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setUpdatedBy($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setUpdatedOn($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MlmPackagePeer::DATABASE_NAME);

		if ($this->isColumnModified(MlmPackagePeer::PACKAGE_ID)) $criteria->add(MlmPackagePeer::PACKAGE_ID, $this->package_id);
		if ($this->isColumnModified(MlmPackagePeer::PACKAGE_NAME)) $criteria->add(MlmPackagePeer::PACKAGE_NAME, $this->package_name);
		if ($this->isColumnModified(MlmPackagePeer::PRICE)) $criteria->add(MlmPackagePeer::PRICE, $this->price);
		if ($this->isColumnModified(MlmPackagePeer::COMMISSION)) $criteria->add(MlmPackagePeer::COMMISSION, $this->commission);
		if ($this->isColumnModified(MlmPackagePeer::CREDIT_REFUND)) $criteria->add(MlmPackagePeer::CREDIT_REFUND, $this->credit_refund);
		if ($this->isColumnModified(MlmPackagePeer::PAIRING_BONUS)) $criteria->add(MlmPackagePeer::PAIRING_BONUS, $this->pairing_bonus);
		if ($this->isColumnModified(MlmPackagePeer::DAILY_MAX_PAIRING)) $criteria->add(MlmPackagePeer::DAILY_MAX_PAIRING, $this->daily_max_pairing);
		if ($this->isColumnModified(MlmPackagePeer::PUBLIC_PURCHASE)) $criteria->add(MlmPackagePeer::PUBLIC_PURCHASE, $this->public_purchase);
		if ($this->isColumnModified(MlmPackagePeer::CREATED_BY)) $criteria->add(MlmPackagePeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(MlmPackagePeer::CREATED_ON)) $criteria->add(MlmPackagePeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(MlmPackagePeer::UPDATED_BY)) $criteria->add(MlmPackagePeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(MlmPackagePeer::UPDATED_ON)) $criteria->add(MlmPackagePeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MlmPackagePeer::DATABASE_NAME);

		$criteria->add(MlmPackagePeer::PACKAGE_ID, $this->package_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getPackageId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setPackageId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setPackageName($this->package_name);

		$copyObj->setPrice($this->price);

		$copyObj->setCommission($this->commission);

		$copyObj->setCreditRefund($this->credit_refund);

		$copyObj->setPairingBonus($this->pairing_bonus);

		$copyObj->setDailyMaxPairing($this->daily_max_pairing);

		$copyObj->setPublicPurchase($this->public_purchase);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setPackageId(NULL); 

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
			self::$peer = new MlmPackagePeer();
		}
		return self::$peer;
	}

} 