<?php


abstract class BaseMlmReloadTopupHistory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $reload_id;


	
	protected $dist_id;


	
	protected $transaction_code;


	
	protected $amount = 0;


	
	protected $status_code;


	
	protected $remarks;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getReloadId()
	{

		return $this->reload_id;
	}

	
	public function getDistId()
	{

		return $this->dist_id;
	}

	
	public function getTransactionCode()
	{

		return $this->transaction_code;
	}

	
	public function getAmount()
	{

		return $this->amount;
	}

	
	public function getStatusCode()
	{

		return $this->status_code;
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

	
	public function setReloadId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->reload_id !== $v) {
			$this->reload_id = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::RELOAD_ID;
		}

	} 

	
	public function setDistId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->dist_id !== $v) {
			$this->dist_id = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::DIST_ID;
		}

	} 

	
	public function setTransactionCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->transaction_code !== $v) {
			$this->transaction_code = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::TRANSACTION_CODE;
		}

	} 

	
	public function setAmount($v)
	{

		if ($this->amount !== $v || $v === 0) {
			$this->amount = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::AMOUNT;
		}

	} 

	
	public function setStatusCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::STATUS_CODE;
		}

	} 

	
	public function setRemarks($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remarks !== $v) {
			$this->remarks = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::REMARKS;
		}

	} 

	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::CREATED_BY;
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
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::CREATED_ON;
		}

	} 

	
	public function setUpdatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = MlmReloadTopupHistoryPeer::UPDATED_ON;
		}

	} 

	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->reload_id = $rs->getInt($startcol + 0);

			$this->dist_id = $rs->getInt($startcol + 1);

			$this->transaction_code = $rs->getString($startcol + 2);

			$this->amount = $rs->getFloat($startcol + 3);

			$this->status_code = $rs->getString($startcol + 4);

			$this->remarks = $rs->getString($startcol + 5);

			$this->created_by = $rs->getInt($startcol + 6);

			$this->created_on = $rs->getTimestamp($startcol + 7, null);

			$this->updated_by = $rs->getInt($startcol + 8);

			$this->updated_on = $rs->getTimestamp($startcol + 9, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MlmReloadTopupHistory object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmReloadTopupHistoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MlmReloadTopupHistoryPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MlmReloadTopupHistoryPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MlmReloadTopupHistoryPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmReloadTopupHistoryPeer::DATABASE_NAME);
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
					$pk = MlmReloadTopupHistoryPeer::doInsert($this, $con);
					$affectedRows += 1; 
										 
										 

					$this->setReloadId($pk);  

					$this->setNew(false);
				} else {
					$affectedRows += MlmReloadTopupHistoryPeer::doUpdate($this, $con);
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


			if (($retval = MlmReloadTopupHistoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmReloadTopupHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getReloadId();
				break;
			case 1:
				return $this->getDistId();
				break;
			case 2:
				return $this->getTransactionCode();
				break;
			case 3:
				return $this->getAmount();
				break;
			case 4:
				return $this->getStatusCode();
				break;
			case 5:
				return $this->getRemarks();
				break;
			case 6:
				return $this->getCreatedBy();
				break;
			case 7:
				return $this->getCreatedOn();
				break;
			case 8:
				return $this->getUpdatedBy();
				break;
			case 9:
				return $this->getUpdatedOn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmReloadTopupHistoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getReloadId(),
			$keys[1] => $this->getDistId(),
			$keys[2] => $this->getTransactionCode(),
			$keys[3] => $this->getAmount(),
			$keys[4] => $this->getStatusCode(),
			$keys[5] => $this->getRemarks(),
			$keys[6] => $this->getCreatedBy(),
			$keys[7] => $this->getCreatedOn(),
			$keys[8] => $this->getUpdatedBy(),
			$keys[9] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmReloadTopupHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setReloadId($value);
				break;
			case 1:
				$this->setDistId($value);
				break;
			case 2:
				$this->setTransactionCode($value);
				break;
			case 3:
				$this->setAmount($value);
				break;
			case 4:
				$this->setStatusCode($value);
				break;
			case 5:
				$this->setRemarks($value);
				break;
			case 6:
				$this->setCreatedBy($value);
				break;
			case 7:
				$this->setCreatedOn($value);
				break;
			case 8:
				$this->setUpdatedBy($value);
				break;
			case 9:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmReloadTopupHistoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setReloadId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDistId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTransactionCode($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAmount($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setStatusCode($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRemarks($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedBy($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedOn($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpdatedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedOn($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MlmReloadTopupHistoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::RELOAD_ID)) $criteria->add(MlmReloadTopupHistoryPeer::RELOAD_ID, $this->reload_id);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::DIST_ID)) $criteria->add(MlmReloadTopupHistoryPeer::DIST_ID, $this->dist_id);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::TRANSACTION_CODE)) $criteria->add(MlmReloadTopupHistoryPeer::TRANSACTION_CODE, $this->transaction_code);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::AMOUNT)) $criteria->add(MlmReloadTopupHistoryPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::STATUS_CODE)) $criteria->add(MlmReloadTopupHistoryPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::REMARKS)) $criteria->add(MlmReloadTopupHistoryPeer::REMARKS, $this->remarks);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::CREATED_BY)) $criteria->add(MlmReloadTopupHistoryPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::CREATED_ON)) $criteria->add(MlmReloadTopupHistoryPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::UPDATED_BY)) $criteria->add(MlmReloadTopupHistoryPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(MlmReloadTopupHistoryPeer::UPDATED_ON)) $criteria->add(MlmReloadTopupHistoryPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MlmReloadTopupHistoryPeer::DATABASE_NAME);

		$criteria->add(MlmReloadTopupHistoryPeer::RELOAD_ID, $this->reload_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getReloadId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setReloadId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDistId($this->dist_id);

		$copyObj->setTransactionCode($this->transaction_code);

		$copyObj->setAmount($this->amount);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setRemarks($this->remarks);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setReloadId(NULL); 

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
			self::$peer = new MlmReloadTopupHistoryPeer();
		}
		return self::$peer;
	}

} 