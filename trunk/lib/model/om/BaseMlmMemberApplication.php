<?php


abstract class BaseMlmMemberApplication extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $member_id;


	
	protected $full_name;


	
	protected $email;


	
	protected $contact;


	
	protected $qq;


	
	protected $status_code;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getMemberId()
	{

		return $this->member_id;
	}

	
	public function getFullName()
	{

		return $this->full_name;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getContact()
	{

		return $this->contact;
	}

	
	public function getQq()
	{

		return $this->qq;
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

	
	public function setMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_id !== $v) {
			$this->member_id = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::MEMBER_ID;
		}

	} 

	
	public function setFullName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->full_name !== $v) {
			$this->full_name = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::FULL_NAME;
		}

	} 

	
	public function setEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::EMAIL;
		}

	} 

	
	public function setContact($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->contact !== $v) {
			$this->contact = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::CONTACT;
		}

	} 

	
	public function setQq($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->qq !== $v) {
			$this->qq = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::QQ;
		}

	} 

	
	public function setStatusCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::STATUS_CODE;
		}

	} 

	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::CREATED_BY;
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
			$this->modifiedColumns[] = MlmMemberApplicationPeer::CREATED_ON;
		}

	} 

	
	public function setUpdatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = MlmMemberApplicationPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = MlmMemberApplicationPeer::UPDATED_ON;
		}

	} 

	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->member_id = $rs->getInt($startcol + 0);

			$this->full_name = $rs->getString($startcol + 1);

			$this->email = $rs->getString($startcol + 2);

			$this->contact = $rs->getString($startcol + 3);

			$this->qq = $rs->getString($startcol + 4);

			$this->status_code = $rs->getString($startcol + 5);

			$this->created_by = $rs->getInt($startcol + 6);

			$this->created_on = $rs->getTimestamp($startcol + 7, null);

			$this->updated_by = $rs->getInt($startcol + 8);

			$this->updated_on = $rs->getTimestamp($startcol + 9, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MlmMemberApplication object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmMemberApplicationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MlmMemberApplicationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MlmMemberApplicationPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MlmMemberApplicationPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmMemberApplicationPeer::DATABASE_NAME);
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
					$pk = MlmMemberApplicationPeer::doInsert($this, $con);
					$affectedRows += 1; 
										 
										 

					$this->setMemberId($pk);  

					$this->setNew(false);
				} else {
					$affectedRows += MlmMemberApplicationPeer::doUpdate($this, $con);
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


			if (($retval = MlmMemberApplicationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmMemberApplicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getMemberId();
				break;
			case 1:
				return $this->getFullName();
				break;
			case 2:
				return $this->getEmail();
				break;
			case 3:
				return $this->getContact();
				break;
			case 4:
				return $this->getQq();
				break;
			case 5:
				return $this->getStatusCode();
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
		$keys = MlmMemberApplicationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getMemberId(),
			$keys[1] => $this->getFullName(),
			$keys[2] => $this->getEmail(),
			$keys[3] => $this->getContact(),
			$keys[4] => $this->getQq(),
			$keys[5] => $this->getStatusCode(),
			$keys[6] => $this->getCreatedBy(),
			$keys[7] => $this->getCreatedOn(),
			$keys[8] => $this->getUpdatedBy(),
			$keys[9] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmMemberApplicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setMemberId($value);
				break;
			case 1:
				$this->setFullName($value);
				break;
			case 2:
				$this->setEmail($value);
				break;
			case 3:
				$this->setContact($value);
				break;
			case 4:
				$this->setQq($value);
				break;
			case 5:
				$this->setStatusCode($value);
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
		$keys = MlmMemberApplicationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setMemberId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFullName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setEmail($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setContact($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setQq($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setStatusCode($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedBy($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedOn($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpdatedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedOn($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MlmMemberApplicationPeer::DATABASE_NAME);

		if ($this->isColumnModified(MlmMemberApplicationPeer::MEMBER_ID)) $criteria->add(MlmMemberApplicationPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(MlmMemberApplicationPeer::FULL_NAME)) $criteria->add(MlmMemberApplicationPeer::FULL_NAME, $this->full_name);
		if ($this->isColumnModified(MlmMemberApplicationPeer::EMAIL)) $criteria->add(MlmMemberApplicationPeer::EMAIL, $this->email);
		if ($this->isColumnModified(MlmMemberApplicationPeer::CONTACT)) $criteria->add(MlmMemberApplicationPeer::CONTACT, $this->contact);
		if ($this->isColumnModified(MlmMemberApplicationPeer::QQ)) $criteria->add(MlmMemberApplicationPeer::QQ, $this->qq);
		if ($this->isColumnModified(MlmMemberApplicationPeer::STATUS_CODE)) $criteria->add(MlmMemberApplicationPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(MlmMemberApplicationPeer::CREATED_BY)) $criteria->add(MlmMemberApplicationPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(MlmMemberApplicationPeer::CREATED_ON)) $criteria->add(MlmMemberApplicationPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(MlmMemberApplicationPeer::UPDATED_BY)) $criteria->add(MlmMemberApplicationPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(MlmMemberApplicationPeer::UPDATED_ON)) $criteria->add(MlmMemberApplicationPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MlmMemberApplicationPeer::DATABASE_NAME);

		$criteria->add(MlmMemberApplicationPeer::MEMBER_ID, $this->member_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getMemberId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setMemberId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setFullName($this->full_name);

		$copyObj->setEmail($this->email);

		$copyObj->setContact($this->contact);

		$copyObj->setQq($this->qq);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setMemberId(NULL); 

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
			self::$peer = new MlmMemberApplicationPeer();
		}
		return self::$peer;
	}

} 