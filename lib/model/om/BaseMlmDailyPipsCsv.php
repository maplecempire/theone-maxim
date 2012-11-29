<?php


abstract class BaseMlmDailyPipsCsv extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $pips_id;


	
	protected $traded_datetime;


	
	protected $file_id;


	
	protected $pips_string;


	
	protected $login_id;


	
	protected $login_name;


	
	protected $deposit;


	
	protected $withdraw;


	
	protected $in_out;


	
	protected $credit;


	
	protected $volume;


	
	protected $commission;


	
	protected $taxes;


	
	protected $agent;


	
	protected $storage;


	
	protected $profit;


	
	protected $last_balance;


	
	protected $status_code;


	
	protected $remarks;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getPipsId()
	{

		return $this->pips_id;
	}

	
	public function getTradedDatetime($format = 'Y-m-d H:i:s')
	{

		if ($this->traded_datetime === null || $this->traded_datetime === '') {
			return null;
		} elseif (!is_int($this->traded_datetime)) {
						$ts = strtotime($this->traded_datetime);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [traded_datetime] as date/time value: " . var_export($this->traded_datetime, true));
			}
		} else {
			$ts = $this->traded_datetime;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getFileId()
	{

		return $this->file_id;
	}

	
	public function getPipsString()
	{

		return $this->pips_string;
	}

	
	public function getLoginId()
	{

		return $this->login_id;
	}

	
	public function getLoginName()
	{

		return $this->login_name;
	}

	
	public function getDeposit()
	{

		return $this->deposit;
	}

	
	public function getWithdraw()
	{

		return $this->withdraw;
	}

	
	public function getInOut()
	{

		return $this->in_out;
	}

	
	public function getCredit()
	{

		return $this->credit;
	}

	
	public function getVolume()
	{

		return $this->volume;
	}

	
	public function getCommission()
	{

		return $this->commission;
	}

	
	public function getTaxes()
	{

		return $this->taxes;
	}

	
	public function getAgent()
	{

		return $this->agent;
	}

	
	public function getStorage()
	{

		return $this->storage;
	}

	
	public function getProfit()
	{

		return $this->profit;
	}

	
	public function getLastBalance()
	{

		return $this->last_balance;
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

	
	public function setPipsId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->pips_id !== $v) {
			$this->pips_id = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::PIPS_ID;
		}

	} 

	
	public function setTradedDatetime($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [traded_datetime] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->traded_datetime !== $ts) {
			$this->traded_datetime = $ts;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::TRADED_DATETIME;
		}

	} 

	
	public function setFileId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->file_id !== $v) {
			$this->file_id = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::FILE_ID;
		}

	} 

	
	public function setPipsString($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->pips_string !== $v) {
			$this->pips_string = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::PIPS_STRING;
		}

	} 

	
	public function setLoginId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->login_id !== $v) {
			$this->login_id = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::LOGIN_ID;
		}

	} 

	
	public function setLoginName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->login_name !== $v) {
			$this->login_name = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::LOGIN_NAME;
		}

	} 

	
	public function setDeposit($v)
	{

		if ($this->deposit !== $v) {
			$this->deposit = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::DEPOSIT;
		}

	} 

	
	public function setWithdraw($v)
	{

		if ($this->withdraw !== $v) {
			$this->withdraw = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::WITHDRAW;
		}

	} 

	
	public function setInOut($v)
	{

		if ($this->in_out !== $v) {
			$this->in_out = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::IN_OUT;
		}

	} 

	
	public function setCredit($v)
	{

		if ($this->credit !== $v) {
			$this->credit = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::CREDIT;
		}

	} 

	
	public function setVolume($v)
	{

		if ($this->volume !== $v) {
			$this->volume = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::VOLUME;
		}

	} 

	
	public function setCommission($v)
	{

		if ($this->commission !== $v) {
			$this->commission = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::COMMISSION;
		}

	} 

	
	public function setTaxes($v)
	{

		if ($this->taxes !== $v) {
			$this->taxes = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::TAXES;
		}

	} 

	
	public function setAgent($v)
	{

		if ($this->agent !== $v) {
			$this->agent = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::AGENT;
		}

	} 

	
	public function setStorage($v)
	{

		if ($this->storage !== $v) {
			$this->storage = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::STORAGE;
		}

	} 

	
	public function setProfit($v)
	{

		if ($this->profit !== $v) {
			$this->profit = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::PROFIT;
		}

	} 

	
	public function setLastBalance($v)
	{

		if ($this->last_balance !== $v) {
			$this->last_balance = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::LAST_BALANCE;
		}

	} 

	
	public function setStatusCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::STATUS_CODE;
		}

	} 

	
	public function setRemarks($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remarks !== $v) {
			$this->remarks = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::REMARKS;
		}

	} 

	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::CREATED_BY;
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
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::CREATED_ON;
		}

	} 

	
	public function setUpdatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = MlmDailyPipsCsvPeer::UPDATED_ON;
		}

	} 

	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->pips_id = $rs->getInt($startcol + 0);

			$this->traded_datetime = $rs->getTimestamp($startcol + 1, null);

			$this->file_id = $rs->getInt($startcol + 2);

			$this->pips_string = $rs->getString($startcol + 3);

			$this->login_id = $rs->getInt($startcol + 4);

			$this->login_name = $rs->getString($startcol + 5);

			$this->deposit = $rs->getFloat($startcol + 6);

			$this->withdraw = $rs->getFloat($startcol + 7);

			$this->in_out = $rs->getFloat($startcol + 8);

			$this->credit = $rs->getFloat($startcol + 9);

			$this->volume = $rs->getFloat($startcol + 10);

			$this->commission = $rs->getFloat($startcol + 11);

			$this->taxes = $rs->getFloat($startcol + 12);

			$this->agent = $rs->getFloat($startcol + 13);

			$this->storage = $rs->getFloat($startcol + 14);

			$this->profit = $rs->getFloat($startcol + 15);

			$this->last_balance = $rs->getFloat($startcol + 16);

			$this->status_code = $rs->getString($startcol + 17);

			$this->remarks = $rs->getString($startcol + 18);

			$this->created_by = $rs->getInt($startcol + 19);

			$this->created_on = $rs->getTimestamp($startcol + 20, null);

			$this->updated_by = $rs->getInt($startcol + 21);

			$this->updated_on = $rs->getTimestamp($startcol + 22, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 23; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MlmDailyPipsCsv object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmDailyPipsCsvPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MlmDailyPipsCsvPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MlmDailyPipsCsvPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MlmDailyPipsCsvPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmDailyPipsCsvPeer::DATABASE_NAME);
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
					$pk = MlmDailyPipsCsvPeer::doInsert($this, $con);
					$affectedRows += 1; 
										 
										 

					$this->setPipsId($pk);  

					$this->setNew(false);
				} else {
					$affectedRows += MlmDailyPipsCsvPeer::doUpdate($this, $con);
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


			if (($retval = MlmDailyPipsCsvPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmDailyPipsCsvPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getPipsId();
				break;
			case 1:
				return $this->getTradedDatetime();
				break;
			case 2:
				return $this->getFileId();
				break;
			case 3:
				return $this->getPipsString();
				break;
			case 4:
				return $this->getLoginId();
				break;
			case 5:
				return $this->getLoginName();
				break;
			case 6:
				return $this->getDeposit();
				break;
			case 7:
				return $this->getWithdraw();
				break;
			case 8:
				return $this->getInOut();
				break;
			case 9:
				return $this->getCredit();
				break;
			case 10:
				return $this->getVolume();
				break;
			case 11:
				return $this->getCommission();
				break;
			case 12:
				return $this->getTaxes();
				break;
			case 13:
				return $this->getAgent();
				break;
			case 14:
				return $this->getStorage();
				break;
			case 15:
				return $this->getProfit();
				break;
			case 16:
				return $this->getLastBalance();
				break;
			case 17:
				return $this->getStatusCode();
				break;
			case 18:
				return $this->getRemarks();
				break;
			case 19:
				return $this->getCreatedBy();
				break;
			case 20:
				return $this->getCreatedOn();
				break;
			case 21:
				return $this->getUpdatedBy();
				break;
			case 22:
				return $this->getUpdatedOn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmDailyPipsCsvPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getPipsId(),
			$keys[1] => $this->getTradedDatetime(),
			$keys[2] => $this->getFileId(),
			$keys[3] => $this->getPipsString(),
			$keys[4] => $this->getLoginId(),
			$keys[5] => $this->getLoginName(),
			$keys[6] => $this->getDeposit(),
			$keys[7] => $this->getWithdraw(),
			$keys[8] => $this->getInOut(),
			$keys[9] => $this->getCredit(),
			$keys[10] => $this->getVolume(),
			$keys[11] => $this->getCommission(),
			$keys[12] => $this->getTaxes(),
			$keys[13] => $this->getAgent(),
			$keys[14] => $this->getStorage(),
			$keys[15] => $this->getProfit(),
			$keys[16] => $this->getLastBalance(),
			$keys[17] => $this->getStatusCode(),
			$keys[18] => $this->getRemarks(),
			$keys[19] => $this->getCreatedBy(),
			$keys[20] => $this->getCreatedOn(),
			$keys[21] => $this->getUpdatedBy(),
			$keys[22] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmDailyPipsCsvPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setPipsId($value);
				break;
			case 1:
				$this->setTradedDatetime($value);
				break;
			case 2:
				$this->setFileId($value);
				break;
			case 3:
				$this->setPipsString($value);
				break;
			case 4:
				$this->setLoginId($value);
				break;
			case 5:
				$this->setLoginName($value);
				break;
			case 6:
				$this->setDeposit($value);
				break;
			case 7:
				$this->setWithdraw($value);
				break;
			case 8:
				$this->setInOut($value);
				break;
			case 9:
				$this->setCredit($value);
				break;
			case 10:
				$this->setVolume($value);
				break;
			case 11:
				$this->setCommission($value);
				break;
			case 12:
				$this->setTaxes($value);
				break;
			case 13:
				$this->setAgent($value);
				break;
			case 14:
				$this->setStorage($value);
				break;
			case 15:
				$this->setProfit($value);
				break;
			case 16:
				$this->setLastBalance($value);
				break;
			case 17:
				$this->setStatusCode($value);
				break;
			case 18:
				$this->setRemarks($value);
				break;
			case 19:
				$this->setCreatedBy($value);
				break;
			case 20:
				$this->setCreatedOn($value);
				break;
			case 21:
				$this->setUpdatedBy($value);
				break;
			case 22:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmDailyPipsCsvPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setPipsId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTradedDatetime($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFileId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPipsString($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLoginId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLoginName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDeposit($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setWithdraw($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setInOut($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCredit($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setVolume($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCommission($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setTaxes($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setAgent($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setStorage($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setProfit($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setLastBalance($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setStatusCode($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setRemarks($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setCreatedBy($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setCreatedOn($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setUpdatedBy($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setUpdatedOn($arr[$keys[22]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MlmDailyPipsCsvPeer::DATABASE_NAME);

		if ($this->isColumnModified(MlmDailyPipsCsvPeer::PIPS_ID)) $criteria->add(MlmDailyPipsCsvPeer::PIPS_ID, $this->pips_id);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::TRADED_DATETIME)) $criteria->add(MlmDailyPipsCsvPeer::TRADED_DATETIME, $this->traded_datetime);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::FILE_ID)) $criteria->add(MlmDailyPipsCsvPeer::FILE_ID, $this->file_id);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::PIPS_STRING)) $criteria->add(MlmDailyPipsCsvPeer::PIPS_STRING, $this->pips_string);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::LOGIN_ID)) $criteria->add(MlmDailyPipsCsvPeer::LOGIN_ID, $this->login_id);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::LOGIN_NAME)) $criteria->add(MlmDailyPipsCsvPeer::LOGIN_NAME, $this->login_name);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::DEPOSIT)) $criteria->add(MlmDailyPipsCsvPeer::DEPOSIT, $this->deposit);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::WITHDRAW)) $criteria->add(MlmDailyPipsCsvPeer::WITHDRAW, $this->withdraw);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::IN_OUT)) $criteria->add(MlmDailyPipsCsvPeer::IN_OUT, $this->in_out);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::CREDIT)) $criteria->add(MlmDailyPipsCsvPeer::CREDIT, $this->credit);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::VOLUME)) $criteria->add(MlmDailyPipsCsvPeer::VOLUME, $this->volume);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::COMMISSION)) $criteria->add(MlmDailyPipsCsvPeer::COMMISSION, $this->commission);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::TAXES)) $criteria->add(MlmDailyPipsCsvPeer::TAXES, $this->taxes);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::AGENT)) $criteria->add(MlmDailyPipsCsvPeer::AGENT, $this->agent);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::STORAGE)) $criteria->add(MlmDailyPipsCsvPeer::STORAGE, $this->storage);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::PROFIT)) $criteria->add(MlmDailyPipsCsvPeer::PROFIT, $this->profit);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::LAST_BALANCE)) $criteria->add(MlmDailyPipsCsvPeer::LAST_BALANCE, $this->last_balance);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::STATUS_CODE)) $criteria->add(MlmDailyPipsCsvPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::REMARKS)) $criteria->add(MlmDailyPipsCsvPeer::REMARKS, $this->remarks);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::CREATED_BY)) $criteria->add(MlmDailyPipsCsvPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::CREATED_ON)) $criteria->add(MlmDailyPipsCsvPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::UPDATED_BY)) $criteria->add(MlmDailyPipsCsvPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(MlmDailyPipsCsvPeer::UPDATED_ON)) $criteria->add(MlmDailyPipsCsvPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MlmDailyPipsCsvPeer::DATABASE_NAME);

		$criteria->add(MlmDailyPipsCsvPeer::PIPS_ID, $this->pips_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getPipsId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setPipsId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTradedDatetime($this->traded_datetime);

		$copyObj->setFileId($this->file_id);

		$copyObj->setPipsString($this->pips_string);

		$copyObj->setLoginId($this->login_id);

		$copyObj->setLoginName($this->login_name);

		$copyObj->setDeposit($this->deposit);

		$copyObj->setWithdraw($this->withdraw);

		$copyObj->setInOut($this->in_out);

		$copyObj->setCredit($this->credit);

		$copyObj->setVolume($this->volume);

		$copyObj->setCommission($this->commission);

		$copyObj->setTaxes($this->taxes);

		$copyObj->setAgent($this->agent);

		$copyObj->setStorage($this->storage);

		$copyObj->setProfit($this->profit);

		$copyObj->setLastBalance($this->last_balance);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setRemarks($this->remarks);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


		$copyObj->setNew(true);

		$copyObj->setPipsId(NULL); 

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
			self::$peer = new MlmDailyPipsCsvPeer();
		}
		return self::$peer;
	}

} 