<?php


abstract class BaseNotificationOfMaturity extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $notice_id;


	
	protected $dist_id;


	
	protected $mt4_user_name;


	
	protected $dividend_date;


	
	protected $maturity_type;


	
	protected $email;


	
	protected $retry;


	
	protected $remark;


	
	protected $status_code;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getNoticeId()
	{

		return $this->notice_id;
	}

	
	public function getDistId()
	{

		return $this->dist_id;
	}

	
	public function getMt4UserName()
	{

		return $this->mt4_user_name;
	}

	
	public function getDividendDate($format = 'Y-m-d H:i:s')
	{

		if ($this->dividend_date === null || $this->dividend_date === '') {
			return null;
		} elseif (!is_int($this->dividend_date)) {
						$ts = strtotime($this->dividend_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [dividend_date] as date/time value: " . var_export($this->dividend_date, true));
			}
		} else {
			$ts = $this->dividend_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getMaturityType()
	{

		return $this->maturity_type;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getRetry()
	{

		return $this->retry;
	}

	
	public function getRemark()
	{

		return $this->remark;
	}

	
	public function getStatusCode()
	{

		return $this->status_code;
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

	
	public function setNoticeId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->notice_id !== $v) {
			$this->notice_id = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::NOTICE_ID;
		}

	} 
	
	public function setDistId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->dist_id !== $v) {
			$this->dist_id = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::DIST_ID;
		}

	} 
	
	public function setMt4UserName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mt4_user_name !== $v) {
			$this->mt4_user_name = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::MT4_USER_NAME;
		}

	} 
	
	public function setDividendDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [dividend_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->dividend_date !== $ts) {
			$this->dividend_date = $ts;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::DIVIDEND_DATE;
		}

	} 
	
	public function setMaturityType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->maturity_type !== $v) {
			$this->maturity_type = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::MATURITY_TYPE;
		}

	} 
	
	public function setEmail($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::EMAIL;
		}

	} 
	
	public function setRetry($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->retry !== $v) {
			$this->retry = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::RETRY;
		}

	} 
	
	public function setRemark($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark !== $v) {
			$this->remark = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::REMARK;
		}

	} 
	
	public function setStatusCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::STATUS_CODE;
		}

	} 
	
	public function setCreatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::CREATED_BY;
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
			$this->modifiedColumns[] = NotificationOfMaturityPeer::CREATED_ON;
		}

	} 
	
	public function setUpdatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = NotificationOfMaturityPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = NotificationOfMaturityPeer::UPDATED_ON;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->notice_id = $rs->getInt($startcol + 0);

			$this->dist_id = $rs->getInt($startcol + 1);

			$this->mt4_user_name = $rs->getString($startcol + 2);

			$this->dividend_date = $rs->getTimestamp($startcol + 3, null);

			$this->maturity_type = $rs->getString($startcol + 4);

			$this->email = $rs->getString($startcol + 5);

			$this->retry = $rs->getInt($startcol + 6);

			$this->remark = $rs->getString($startcol + 7);

			$this->status_code = $rs->getString($startcol + 8);

			$this->created_by = $rs->getInt($startcol + 9);

			$this->created_on = $rs->getTimestamp($startcol + 10, null);

			$this->updated_by = $rs->getInt($startcol + 11);

			$this->updated_on = $rs->getTimestamp($startcol + 12, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 13; 
		} catch (Exception $e) {
			throw new PropelException("Error populating NotificationOfMaturity object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(NotificationOfMaturityPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			NotificationOfMaturityPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(NotificationOfMaturityPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(NotificationOfMaturityPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(NotificationOfMaturityPeer::DATABASE_NAME);
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
					$pk = NotificationOfMaturityPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNoticeId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += NotificationOfMaturityPeer::doUpdate($this, $con);
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


			if (($retval = NotificationOfMaturityPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NotificationOfMaturityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getNoticeId();
				break;
			case 1:
				return $this->getDistId();
				break;
			case 2:
				return $this->getMt4UserName();
				break;
			case 3:
				return $this->getDividendDate();
				break;
			case 4:
				return $this->getMaturityType();
				break;
			case 5:
				return $this->getEmail();
				break;
			case 6:
				return $this->getRetry();
				break;
			case 7:
				return $this->getRemark();
				break;
			case 8:
				return $this->getStatusCode();
				break;
			case 9:
				return $this->getCreatedBy();
				break;
			case 10:
				return $this->getCreatedOn();
				break;
			case 11:
				return $this->getUpdatedBy();
				break;
			case 12:
				return $this->getUpdatedOn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NotificationOfMaturityPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getNoticeId(),
			$keys[1] => $this->getDistId(),
			$keys[2] => $this->getMt4UserName(),
			$keys[3] => $this->getDividendDate(),
			$keys[4] => $this->getMaturityType(),
			$keys[5] => $this->getEmail(),
			$keys[6] => $this->getRetry(),
			$keys[7] => $this->getRemark(),
			$keys[8] => $this->getStatusCode(),
			$keys[9] => $this->getCreatedBy(),
			$keys[10] => $this->getCreatedOn(),
			$keys[11] => $this->getUpdatedBy(),
			$keys[12] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NotificationOfMaturityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setNoticeId($value);
				break;
			case 1:
				$this->setDistId($value);
				break;
			case 2:
				$this->setMt4UserName($value);
				break;
			case 3:
				$this->setDividendDate($value);
				break;
			case 4:
				$this->setMaturityType($value);
				break;
			case 5:
				$this->setEmail($value);
				break;
			case 6:
				$this->setRetry($value);
				break;
			case 7:
				$this->setRemark($value);
				break;
			case 8:
				$this->setStatusCode($value);
				break;
			case 9:
				$this->setCreatedBy($value);
				break;
			case 10:
				$this->setCreatedOn($value);
				break;
			case 11:
				$this->setUpdatedBy($value);
				break;
			case 12:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NotificationOfMaturityPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setNoticeId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDistId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMt4UserName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDividendDate($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMaturityType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setRetry($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setRemark($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setStatusCode($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedBy($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedOn($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setUpdatedBy($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedOn($arr[$keys[12]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(NotificationOfMaturityPeer::DATABASE_NAME);

		if ($this->isColumnModified(NotificationOfMaturityPeer::NOTICE_ID)) $criteria->add(NotificationOfMaturityPeer::NOTICE_ID, $this->notice_id);
		if ($this->isColumnModified(NotificationOfMaturityPeer::DIST_ID)) $criteria->add(NotificationOfMaturityPeer::DIST_ID, $this->dist_id);
		if ($this->isColumnModified(NotificationOfMaturityPeer::MT4_USER_NAME)) $criteria->add(NotificationOfMaturityPeer::MT4_USER_NAME, $this->mt4_user_name);
		if ($this->isColumnModified(NotificationOfMaturityPeer::DIVIDEND_DATE)) $criteria->add(NotificationOfMaturityPeer::DIVIDEND_DATE, $this->dividend_date);
		if ($this->isColumnModified(NotificationOfMaturityPeer::MATURITY_TYPE)) $criteria->add(NotificationOfMaturityPeer::MATURITY_TYPE, $this->maturity_type);
		if ($this->isColumnModified(NotificationOfMaturityPeer::EMAIL)) $criteria->add(NotificationOfMaturityPeer::EMAIL, $this->email);
		if ($this->isColumnModified(NotificationOfMaturityPeer::RETRY)) $criteria->add(NotificationOfMaturityPeer::RETRY, $this->retry);
		if ($this->isColumnModified(NotificationOfMaturityPeer::REMARK)) $criteria->add(NotificationOfMaturityPeer::REMARK, $this->remark);
		if ($this->isColumnModified(NotificationOfMaturityPeer::STATUS_CODE)) $criteria->add(NotificationOfMaturityPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(NotificationOfMaturityPeer::CREATED_BY)) $criteria->add(NotificationOfMaturityPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(NotificationOfMaturityPeer::CREATED_ON)) $criteria->add(NotificationOfMaturityPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(NotificationOfMaturityPeer::UPDATED_BY)) $criteria->add(NotificationOfMaturityPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(NotificationOfMaturityPeer::UPDATED_ON)) $criteria->add(NotificationOfMaturityPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(NotificationOfMaturityPeer::DATABASE_NAME);

		$criteria->add(NotificationOfMaturityPeer::NOTICE_ID, $this->notice_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getNoticeId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setNoticeId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDistId($this->dist_id);

		$copyObj->setMt4UserName($this->mt4_user_name);

		$copyObj->setDividendDate($this->dividend_date);

		$copyObj->setMaturityType($this->maturity_type);

		$copyObj->setEmail($this->email);

		$copyObj->setRetry($this->retry);

		$copyObj->setRemark($this->remark);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setNoticeId(NULL); 
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
			self::$peer = new NotificationOfMaturityPeer();
		}
		return self::$peer;
	}

} 