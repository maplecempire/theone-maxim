<?php


abstract class BaseApiTransaction extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $transaction_id;


	
	protected $access_ip;


	
	protected $user_id;


	
	protected $transaction_action;


	
	protected $transaction_data;


	
	protected $request_data;


	
	protected $response_data;


	
	protected $ref_id;


	
	protected $ref_type;


	
	protected $remark;


	
	protected $status_code;


	
	protected $token;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getTransactionId()
	{

		return $this->transaction_id;
	}

	
	public function getAccessIp()
	{

		return $this->access_ip;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getTransactionAction()
	{

		return $this->transaction_action;
	}

	
	public function getTransactionData()
	{

		return $this->transaction_data;
	}

	
	public function getRequestData()
	{

		return $this->request_data;
	}

	
	public function getResponseData()
	{

		return $this->response_data;
	}

	
	public function getRefId()
	{

		return $this->ref_id;
	}

	
	public function getRefType()
	{

		return $this->ref_type;
	}

	
	public function getRemark()
	{

		return $this->remark;
	}

	
	public function getStatusCode()
	{

		return $this->status_code;
	}

	
	public function getToken()
	{

		return $this->token;
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

	
	public function setTransactionId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->transaction_id !== $v) {
			$this->transaction_id = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::TRANSACTION_ID;
		}

	} 
	
	public function setAccessIp($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->access_ip !== $v) {
			$this->access_ip = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::ACCESS_IP;
		}

	} 
	
	public function setUserId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::USER_ID;
		}

	} 
	
	public function setTransactionAction($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->transaction_action !== $v) {
			$this->transaction_action = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::TRANSACTION_ACTION;
		}

	} 
	
	public function setTransactionData($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->transaction_data !== $v) {
			$this->transaction_data = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::TRANSACTION_DATA;
		}

	} 
	
	public function setRequestData($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->request_data !== $v) {
			$this->request_data = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::REQUEST_DATA;
		}

	} 
	
	public function setResponseData($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->response_data !== $v) {
			$this->response_data = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::RESPONSE_DATA;
		}

	} 
	
	public function setRefId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ref_id !== $v) {
			$this->ref_id = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::REF_ID;
		}

	} 
	
	public function setRefType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ref_type !== $v) {
			$this->ref_type = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::REF_TYPE;
		}

	} 
	
	public function setRemark($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark !== $v) {
			$this->remark = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::REMARK;
		}

	} 
	
	public function setStatusCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::STATUS_CODE;
		}

	} 
	
	public function setToken($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->token !== $v) {
			$this->token = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::TOKEN;
		}

	} 
	
	public function setCreatedBy($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::CREATED_BY;
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
			$this->modifiedColumns[] = ApiTransactionPeer::CREATED_ON;
		}

	} 
	
	public function setUpdatedBy($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = ApiTransactionPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = ApiTransactionPeer::UPDATED_ON;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->transaction_id = $rs->getString($startcol + 0);

			$this->access_ip = $rs->getString($startcol + 1);

			$this->user_id = $rs->getString($startcol + 2);

			$this->transaction_action = $rs->getString($startcol + 3);

			$this->transaction_data = $rs->getString($startcol + 4);

			$this->request_data = $rs->getString($startcol + 5);

			$this->response_data = $rs->getString($startcol + 6);

			$this->ref_id = $rs->getInt($startcol + 7);

			$this->ref_type = $rs->getString($startcol + 8);

			$this->remark = $rs->getString($startcol + 9);

			$this->status_code = $rs->getString($startcol + 10);

			$this->token = $rs->getString($startcol + 11);

			$this->created_by = $rs->getString($startcol + 12);

			$this->created_on = $rs->getTimestamp($startcol + 13, null);

			$this->updated_by = $rs->getString($startcol + 14);

			$this->updated_on = $rs->getTimestamp($startcol + 15, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ApiTransaction object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ApiTransactionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ApiTransactionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(ApiTransactionPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ApiTransactionPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ApiTransactionPeer::DATABASE_NAME);
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
					$pk = ApiTransactionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setTransactionId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ApiTransactionPeer::doUpdate($this, $con);
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


			if (($retval = ApiTransactionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ApiTransactionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getTransactionId();
				break;
			case 1:
				return $this->getAccessIp();
				break;
			case 2:
				return $this->getUserId();
				break;
			case 3:
				return $this->getTransactionAction();
				break;
			case 4:
				return $this->getTransactionData();
				break;
			case 5:
				return $this->getRequestData();
				break;
			case 6:
				return $this->getResponseData();
				break;
			case 7:
				return $this->getRefId();
				break;
			case 8:
				return $this->getRefType();
				break;
			case 9:
				return $this->getRemark();
				break;
			case 10:
				return $this->getStatusCode();
				break;
			case 11:
				return $this->getToken();
				break;
			case 12:
				return $this->getCreatedBy();
				break;
			case 13:
				return $this->getCreatedOn();
				break;
			case 14:
				return $this->getUpdatedBy();
				break;
			case 15:
				return $this->getUpdatedOn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ApiTransactionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getTransactionId(),
			$keys[1] => $this->getAccessIp(),
			$keys[2] => $this->getUserId(),
			$keys[3] => $this->getTransactionAction(),
			$keys[4] => $this->getTransactionData(),
			$keys[5] => $this->getRequestData(),
			$keys[6] => $this->getResponseData(),
			$keys[7] => $this->getRefId(),
			$keys[8] => $this->getRefType(),
			$keys[9] => $this->getRemark(),
			$keys[10] => $this->getStatusCode(),
			$keys[11] => $this->getToken(),
			$keys[12] => $this->getCreatedBy(),
			$keys[13] => $this->getCreatedOn(),
			$keys[14] => $this->getUpdatedBy(),
			$keys[15] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ApiTransactionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setTransactionId($value);
				break;
			case 1:
				$this->setAccessIp($value);
				break;
			case 2:
				$this->setUserId($value);
				break;
			case 3:
				$this->setTransactionAction($value);
				break;
			case 4:
				$this->setTransactionData($value);
				break;
			case 5:
				$this->setRequestData($value);
				break;
			case 6:
				$this->setResponseData($value);
				break;
			case 7:
				$this->setRefId($value);
				break;
			case 8:
				$this->setRefType($value);
				break;
			case 9:
				$this->setRemark($value);
				break;
			case 10:
				$this->setStatusCode($value);
				break;
			case 11:
				$this->setToken($value);
				break;
			case 12:
				$this->setCreatedBy($value);
				break;
			case 13:
				$this->setCreatedOn($value);
				break;
			case 14:
				$this->setUpdatedBy($value);
				break;
			case 15:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ApiTransactionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setTransactionId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAccessIp($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTransactionAction($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTransactionData($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRequestData($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setResponseData($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setRefId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setRefType($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRemark($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setStatusCode($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setToken($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setCreatedBy($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCreatedOn($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUpdatedBy($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUpdatedOn($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ApiTransactionPeer::DATABASE_NAME);

		if ($this->isColumnModified(ApiTransactionPeer::TRANSACTION_ID)) $criteria->add(ApiTransactionPeer::TRANSACTION_ID, $this->transaction_id);
		if ($this->isColumnModified(ApiTransactionPeer::ACCESS_IP)) $criteria->add(ApiTransactionPeer::ACCESS_IP, $this->access_ip);
		if ($this->isColumnModified(ApiTransactionPeer::USER_ID)) $criteria->add(ApiTransactionPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(ApiTransactionPeer::TRANSACTION_ACTION)) $criteria->add(ApiTransactionPeer::TRANSACTION_ACTION, $this->transaction_action);
		if ($this->isColumnModified(ApiTransactionPeer::TRANSACTION_DATA)) $criteria->add(ApiTransactionPeer::TRANSACTION_DATA, $this->transaction_data);
		if ($this->isColumnModified(ApiTransactionPeer::REQUEST_DATA)) $criteria->add(ApiTransactionPeer::REQUEST_DATA, $this->request_data);
		if ($this->isColumnModified(ApiTransactionPeer::RESPONSE_DATA)) $criteria->add(ApiTransactionPeer::RESPONSE_DATA, $this->response_data);
		if ($this->isColumnModified(ApiTransactionPeer::REF_ID)) $criteria->add(ApiTransactionPeer::REF_ID, $this->ref_id);
		if ($this->isColumnModified(ApiTransactionPeer::REF_TYPE)) $criteria->add(ApiTransactionPeer::REF_TYPE, $this->ref_type);
		if ($this->isColumnModified(ApiTransactionPeer::REMARK)) $criteria->add(ApiTransactionPeer::REMARK, $this->remark);
		if ($this->isColumnModified(ApiTransactionPeer::STATUS_CODE)) $criteria->add(ApiTransactionPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(ApiTransactionPeer::TOKEN)) $criteria->add(ApiTransactionPeer::TOKEN, $this->token);
		if ($this->isColumnModified(ApiTransactionPeer::CREATED_BY)) $criteria->add(ApiTransactionPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(ApiTransactionPeer::CREATED_ON)) $criteria->add(ApiTransactionPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(ApiTransactionPeer::UPDATED_BY)) $criteria->add(ApiTransactionPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(ApiTransactionPeer::UPDATED_ON)) $criteria->add(ApiTransactionPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ApiTransactionPeer::DATABASE_NAME);

		$criteria->add(ApiTransactionPeer::TRANSACTION_ID, $this->transaction_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getTransactionId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setTransactionId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAccessIp($this->access_ip);

		$copyObj->setUserId($this->user_id);

		$copyObj->setTransactionAction($this->transaction_action);

		$copyObj->setTransactionData($this->transaction_data);

		$copyObj->setRequestData($this->request_data);

		$copyObj->setResponseData($this->response_data);

		$copyObj->setRefId($this->ref_id);

		$copyObj->setRefType($this->ref_type);

		$copyObj->setRemark($this->remark);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setToken($this->token);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setTransactionId(NULL); 
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
			self::$peer = new ApiTransactionPeer();
		}
		return self::$peer;
	}

} 