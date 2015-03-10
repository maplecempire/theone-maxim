<?php


abstract class BaseAppMobileLog extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $log_id;


	
	protected $access_ip;


	
	protected $user_id;


	
	protected $trans_action;


	
	protected $trans_data;


	
	protected $remark;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getLogId()
	{

		return $this->log_id;
	}

	
	public function getAccessIp()
	{

		return $this->access_ip;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getTransAction()
	{

		return $this->trans_action;
	}

	
	public function getTransData()
	{

		return $this->trans_data;
	}

	
	public function getRemark()
	{

		return $this->remark;
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

	
	public function setLogId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->log_id !== $v) {
			$this->log_id = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::LOG_ID;
		}

	} 
	
	public function setAccessIp($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->access_ip !== $v) {
			$this->access_ip = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::ACCESS_IP;
		}

	} 
	
	public function setUserId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::USER_ID;
		}

	} 
	
	public function setTransAction($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->trans_action !== $v) {
			$this->trans_action = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::TRANS_ACTION;
		}

	} 
	
	public function setTransData($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->trans_data !== $v) {
			$this->trans_data = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::TRANS_DATA;
		}

	} 
	
	public function setRemark($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark !== $v) {
			$this->remark = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::REMARK;
		}

	} 
	
	public function setCreatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::CREATED_BY;
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
			$this->modifiedColumns[] = AppMobileLogPeer::CREATED_ON;
		}

	} 
	
	public function setUpdatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = AppMobileLogPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = AppMobileLogPeer::UPDATED_ON;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->log_id = $rs->getInt($startcol + 0);

			$this->access_ip = $rs->getString($startcol + 1);

			$this->user_id = $rs->getInt($startcol + 2);

			$this->trans_action = $rs->getString($startcol + 3);

			$this->trans_data = $rs->getString($startcol + 4);

			$this->remark = $rs->getString($startcol + 5);

			$this->created_by = $rs->getInt($startcol + 6);

			$this->created_on = $rs->getTimestamp($startcol + 7, null);

			$this->updated_by = $rs->getInt($startcol + 8);

			$this->updated_on = $rs->getTimestamp($startcol + 9, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating AppMobileLog object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AppMobileLogPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			AppMobileLogPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(AppMobileLogPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(AppMobileLogPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AppMobileLogPeer::DATABASE_NAME);
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
					$pk = AppMobileLogPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setLogId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += AppMobileLogPeer::doUpdate($this, $con);
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


			if (($retval = AppMobileLogPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AppMobileLogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getLogId();
				break;
			case 1:
				return $this->getAccessIp();
				break;
			case 2:
				return $this->getUserId();
				break;
			case 3:
				return $this->getTransAction();
				break;
			case 4:
				return $this->getTransData();
				break;
			case 5:
				return $this->getRemark();
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
		$keys = AppMobileLogPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getLogId(),
			$keys[1] => $this->getAccessIp(),
			$keys[2] => $this->getUserId(),
			$keys[3] => $this->getTransAction(),
			$keys[4] => $this->getTransData(),
			$keys[5] => $this->getRemark(),
			$keys[6] => $this->getCreatedBy(),
			$keys[7] => $this->getCreatedOn(),
			$keys[8] => $this->getUpdatedBy(),
			$keys[9] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AppMobileLogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setLogId($value);
				break;
			case 1:
				$this->setAccessIp($value);
				break;
			case 2:
				$this->setUserId($value);
				break;
			case 3:
				$this->setTransAction($value);
				break;
			case 4:
				$this->setTransData($value);
				break;
			case 5:
				$this->setRemark($value);
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
		$keys = AppMobileLogPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setLogId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAccessIp($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTransAction($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTransData($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRemark($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedBy($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedOn($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpdatedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedOn($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(AppMobileLogPeer::DATABASE_NAME);

		if ($this->isColumnModified(AppMobileLogPeer::LOG_ID)) $criteria->add(AppMobileLogPeer::LOG_ID, $this->log_id);
		if ($this->isColumnModified(AppMobileLogPeer::ACCESS_IP)) $criteria->add(AppMobileLogPeer::ACCESS_IP, $this->access_ip);
		if ($this->isColumnModified(AppMobileLogPeer::USER_ID)) $criteria->add(AppMobileLogPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(AppMobileLogPeer::TRANS_ACTION)) $criteria->add(AppMobileLogPeer::TRANS_ACTION, $this->trans_action);
		if ($this->isColumnModified(AppMobileLogPeer::TRANS_DATA)) $criteria->add(AppMobileLogPeer::TRANS_DATA, $this->trans_data);
		if ($this->isColumnModified(AppMobileLogPeer::REMARK)) $criteria->add(AppMobileLogPeer::REMARK, $this->remark);
		if ($this->isColumnModified(AppMobileLogPeer::CREATED_BY)) $criteria->add(AppMobileLogPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(AppMobileLogPeer::CREATED_ON)) $criteria->add(AppMobileLogPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(AppMobileLogPeer::UPDATED_BY)) $criteria->add(AppMobileLogPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(AppMobileLogPeer::UPDATED_ON)) $criteria->add(AppMobileLogPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(AppMobileLogPeer::DATABASE_NAME);

		$criteria->add(AppMobileLogPeer::LOG_ID, $this->log_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getLogId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setLogId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAccessIp($this->access_ip);

		$copyObj->setUserId($this->user_id);

		$copyObj->setTransAction($this->trans_action);

		$copyObj->setTransData($this->trans_data);

		$copyObj->setRemark($this->remark);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setLogId(NULL); 
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
			self::$peer = new AppMobileLogPeer();
		}
		return self::$peer;
	}

} 