<?php


abstract class BaseMlmPackage extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $package_id;


	
	protected $package_name;


	
	protected $color;


	
	protected $price;


	
	protected $direct_generation;


	
	protected $direct_pips;


	
	protected $commission;


	
	protected $credit_refund;


	
	protected $pairing_bonus = 0;


	
	protected $monthly_performance;


	
	protected $special_bonus;


	
	protected $special_bonus_min_lot_traded;


	
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

	
	public function getColor()
	{

		return $this->color;
	}

	
	public function getPrice()
	{

		return $this->price;
	}

	
	public function getDirectGeneration()
	{

		return $this->direct_generation;
	}

	
	public function getDirectPips()
	{

		return $this->direct_pips;
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

	
	public function getMonthlyPerformance()
	{

		return $this->monthly_performance;
	}

	
	public function getSpecialBonus()
	{

		return $this->special_bonus;
	}

	
	public function getSpecialBonusMinLotTraded()
	{

		return $this->special_bonus_min_lot_traded;
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
	
	public function setColor($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->color !== $v) {
			$this->color = $v;
			$this->modifiedColumns[] = MlmPackagePeer::COLOR;
		}

	} 
	
	public function setPrice($v)
	{

		if ($this->price !== $v) {
			$this->price = $v;
			$this->modifiedColumns[] = MlmPackagePeer::PRICE;
		}

	} 
	
	public function setDirectGeneration($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->direct_generation !== $v) {
			$this->direct_generation = $v;
			$this->modifiedColumns[] = MlmPackagePeer::DIRECT_GENERATION;
		}

	} 
	
	public function setDirectPips($v)
	{

		if ($this->direct_pips !== $v) {
			$this->direct_pips = $v;
			$this->modifiedColumns[] = MlmPackagePeer::DIRECT_PIPS;
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
	
	public function setMonthlyPerformance($v)
	{

		if ($this->monthly_performance !== $v) {
			$this->monthly_performance = $v;
			$this->modifiedColumns[] = MlmPackagePeer::MONTHLY_PERFORMANCE;
		}

	} 
	
	public function setSpecialBonus($v)
	{

		if ($this->special_bonus !== $v) {
			$this->special_bonus = $v;
			$this->modifiedColumns[] = MlmPackagePeer::SPECIAL_BONUS;
		}

	} 
	
	public function setSpecialBonusMinLotTraded($v)
	{

		if ($this->special_bonus_min_lot_traded !== $v) {
			$this->special_bonus_min_lot_traded = $v;
			$this->modifiedColumns[] = MlmPackagePeer::SPECIAL_BONUS_MIN_LOT_TRADED;
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

			$this->color = $rs->getString($startcol + 2);

			$this->price = $rs->getFloat($startcol + 3);

			$this->direct_generation = $rs->getInt($startcol + 4);

			$this->direct_pips = $rs->getFloat($startcol + 5);

			$this->commission = $rs->getFloat($startcol + 6);

			$this->credit_refund = $rs->getFloat($startcol + 7);

			$this->pairing_bonus = $rs->getFloat($startcol + 8);

			$this->monthly_performance = $rs->getFloat($startcol + 9);

			$this->special_bonus = $rs->getFloat($startcol + 10);

			$this->special_bonus_min_lot_traded = $rs->getFloat($startcol + 11);

			$this->daily_max_pairing = $rs->getFloat($startcol + 12);

			$this->public_purchase = $rs->getString($startcol + 13);

			$this->created_by = $rs->getInt($startcol + 14);

			$this->created_on = $rs->getTimestamp($startcol + 15, null);

			$this->updated_by = $rs->getInt($startcol + 16);

			$this->updated_on = $rs->getTimestamp($startcol + 17, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 18; 
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
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
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
				return $this->getColor();
				break;
			case 3:
				return $this->getPrice();
				break;
			case 4:
				return $this->getDirectGeneration();
				break;
			case 5:
				return $this->getDirectPips();
				break;
			case 6:
				return $this->getCommission();
				break;
			case 7:
				return $this->getCreditRefund();
				break;
			case 8:
				return $this->getPairingBonus();
				break;
			case 9:
				return $this->getMonthlyPerformance();
				break;
			case 10:
				return $this->getSpecialBonus();
				break;
			case 11:
				return $this->getSpecialBonusMinLotTraded();
				break;
			case 12:
				return $this->getDailyMaxPairing();
				break;
			case 13:
				return $this->getPublicPurchase();
				break;
			case 14:
				return $this->getCreatedBy();
				break;
			case 15:
				return $this->getCreatedOn();
				break;
			case 16:
				return $this->getUpdatedBy();
				break;
			case 17:
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
			$keys[2] => $this->getColor(),
			$keys[3] => $this->getPrice(),
			$keys[4] => $this->getDirectGeneration(),
			$keys[5] => $this->getDirectPips(),
			$keys[6] => $this->getCommission(),
			$keys[7] => $this->getCreditRefund(),
			$keys[8] => $this->getPairingBonus(),
			$keys[9] => $this->getMonthlyPerformance(),
			$keys[10] => $this->getSpecialBonus(),
			$keys[11] => $this->getSpecialBonusMinLotTraded(),
			$keys[12] => $this->getDailyMaxPairing(),
			$keys[13] => $this->getPublicPurchase(),
			$keys[14] => $this->getCreatedBy(),
			$keys[15] => $this->getCreatedOn(),
			$keys[16] => $this->getUpdatedBy(),
			$keys[17] => $this->getUpdatedOn(),
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
				$this->setColor($value);
				break;
			case 3:
				$this->setPrice($value);
				break;
			case 4:
				$this->setDirectGeneration($value);
				break;
			case 5:
				$this->setDirectPips($value);
				break;
			case 6:
				$this->setCommission($value);
				break;
			case 7:
				$this->setCreditRefund($value);
				break;
			case 8:
				$this->setPairingBonus($value);
				break;
			case 9:
				$this->setMonthlyPerformance($value);
				break;
			case 10:
				$this->setSpecialBonus($value);
				break;
			case 11:
				$this->setSpecialBonusMinLotTraded($value);
				break;
			case 12:
				$this->setDailyMaxPairing($value);
				break;
			case 13:
				$this->setPublicPurchase($value);
				break;
			case 14:
				$this->setCreatedBy($value);
				break;
			case 15:
				$this->setCreatedOn($value);
				break;
			case 16:
				$this->setUpdatedBy($value);
				break;
			case 17:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmPackagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setPackageId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPackageName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setColor($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPrice($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDirectGeneration($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDirectPips($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCommission($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreditRefund($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPairingBonus($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setMonthlyPerformance($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setSpecialBonus($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setSpecialBonusMinLotTraded($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setDailyMaxPairing($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setPublicPurchase($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setCreatedBy($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setCreatedOn($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setUpdatedBy($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setUpdatedOn($arr[$keys[17]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MlmPackagePeer::DATABASE_NAME);

		if ($this->isColumnModified(MlmPackagePeer::PACKAGE_ID)) $criteria->add(MlmPackagePeer::PACKAGE_ID, $this->package_id);
		if ($this->isColumnModified(MlmPackagePeer::PACKAGE_NAME)) $criteria->add(MlmPackagePeer::PACKAGE_NAME, $this->package_name);
		if ($this->isColumnModified(MlmPackagePeer::COLOR)) $criteria->add(MlmPackagePeer::COLOR, $this->color);
		if ($this->isColumnModified(MlmPackagePeer::PRICE)) $criteria->add(MlmPackagePeer::PRICE, $this->price);
		if ($this->isColumnModified(MlmPackagePeer::DIRECT_GENERATION)) $criteria->add(MlmPackagePeer::DIRECT_GENERATION, $this->direct_generation);
		if ($this->isColumnModified(MlmPackagePeer::DIRECT_PIPS)) $criteria->add(MlmPackagePeer::DIRECT_PIPS, $this->direct_pips);
		if ($this->isColumnModified(MlmPackagePeer::COMMISSION)) $criteria->add(MlmPackagePeer::COMMISSION, $this->commission);
		if ($this->isColumnModified(MlmPackagePeer::CREDIT_REFUND)) $criteria->add(MlmPackagePeer::CREDIT_REFUND, $this->credit_refund);
		if ($this->isColumnModified(MlmPackagePeer::PAIRING_BONUS)) $criteria->add(MlmPackagePeer::PAIRING_BONUS, $this->pairing_bonus);
		if ($this->isColumnModified(MlmPackagePeer::MONTHLY_PERFORMANCE)) $criteria->add(MlmPackagePeer::MONTHLY_PERFORMANCE, $this->monthly_performance);
		if ($this->isColumnModified(MlmPackagePeer::SPECIAL_BONUS)) $criteria->add(MlmPackagePeer::SPECIAL_BONUS, $this->special_bonus);
		if ($this->isColumnModified(MlmPackagePeer::SPECIAL_BONUS_MIN_LOT_TRADED)) $criteria->add(MlmPackagePeer::SPECIAL_BONUS_MIN_LOT_TRADED, $this->special_bonus_min_lot_traded);
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

		$copyObj->setColor($this->color);

		$copyObj->setPrice($this->price);

		$copyObj->setDirectGeneration($this->direct_generation);

		$copyObj->setDirectPips($this->direct_pips);

		$copyObj->setCommission($this->commission);

		$copyObj->setCreditRefund($this->credit_refund);

		$copyObj->setPairingBonus($this->pairing_bonus);

		$copyObj->setMonthlyPerformance($this->monthly_performance);

		$copyObj->setSpecialBonus($this->special_bonus);

		$copyObj->setSpecialBonusMinLotTraded($this->special_bonus_min_lot_traded);

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