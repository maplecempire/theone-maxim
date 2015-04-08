<?php


abstract class BaseGgCron extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $type;


	
	protected $started;


	
	protected $ended;


	
	protected $year;


	
	protected $month;


	
	protected $day;


	
	protected $message;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getStarted($format = 'Y-m-d H:i:s')
	{

		if ($this->started === null || $this->started === '') {
			return null;
		} elseif (!is_int($this->started)) {
						$ts = strtotime($this->started);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [started] as date/time value: " . var_export($this->started, true));
			}
		} else {
			$ts = $this->started;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getEnded($format = 'Y-m-d H:i:s')
	{

		if ($this->ended === null || $this->ended === '') {
			return null;
		} elseif (!is_int($this->ended)) {
						$ts = strtotime($this->ended);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [ended] as date/time value: " . var_export($this->ended, true));
			}
		} else {
			$ts = $this->ended;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getYear()
	{

		return $this->year;
	}

	
	public function getMonth()
	{

		return $this->month;
	}

	
	public function getDay()
	{

		return $this->day;
	}

	
	public function getMessage()
	{

		return $this->message;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = GgCronPeer::ID;
		}

	} 
	
	public function setType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = GgCronPeer::TYPE;
		}

	} 
	
	public function setStarted($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [started] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->started !== $ts) {
			$this->started = $ts;
			$this->modifiedColumns[] = GgCronPeer::STARTED;
		}

	} 
	
	public function setEnded($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [ended] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->ended !== $ts) {
			$this->ended = $ts;
			$this->modifiedColumns[] = GgCronPeer::ENDED;
		}

	} 
	
	public function setYear($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->year !== $v) {
			$this->year = $v;
			$this->modifiedColumns[] = GgCronPeer::YEAR;
		}

	} 
	
	public function setMonth($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->month !== $v) {
			$this->month = $v;
			$this->modifiedColumns[] = GgCronPeer::MONTH;
		}

	} 
	
	public function setDay($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->day !== $v) {
			$this->day = $v;
			$this->modifiedColumns[] = GgCronPeer::DAY;
		}

	} 
	
	public function setMessage($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->message !== $v) {
			$this->message = $v;
			$this->modifiedColumns[] = GgCronPeer::MESSAGE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getString($startcol + 0);

			$this->type = $rs->getString($startcol + 1);

			$this->started = $rs->getTimestamp($startcol + 2, null);

			$this->ended = $rs->getTimestamp($startcol + 3, null);

			$this->year = $rs->getInt($startcol + 4);

			$this->month = $rs->getInt($startcol + 5);

			$this->day = $rs->getInt($startcol + 6);

			$this->message = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating GgCron object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GgCronPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			GgCronPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(GgCronPeer::DATABASE_NAME);
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
					$pk = GgCronPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += GgCronPeer::doUpdate($this, $con);
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


			if (($retval = GgCronPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgCronPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getType();
				break;
			case 2:
				return $this->getStarted();
				break;
			case 3:
				return $this->getEnded();
				break;
			case 4:
				return $this->getYear();
				break;
			case 5:
				return $this->getMonth();
				break;
			case 6:
				return $this->getDay();
				break;
			case 7:
				return $this->getMessage();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgCronPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getType(),
			$keys[2] => $this->getStarted(),
			$keys[3] => $this->getEnded(),
			$keys[4] => $this->getYear(),
			$keys[5] => $this->getMonth(),
			$keys[6] => $this->getDay(),
			$keys[7] => $this->getMessage(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgCronPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setType($value);
				break;
			case 2:
				$this->setStarted($value);
				break;
			case 3:
				$this->setEnded($value);
				break;
			case 4:
				$this->setYear($value);
				break;
			case 5:
				$this->setMonth($value);
				break;
			case 6:
				$this->setDay($value);
				break;
			case 7:
				$this->setMessage($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgCronPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setType($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setStarted($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEnded($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setYear($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMonth($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDay($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMessage($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(GgCronPeer::DATABASE_NAME);

		if ($this->isColumnModified(GgCronPeer::ID)) $criteria->add(GgCronPeer::ID, $this->id);
		if ($this->isColumnModified(GgCronPeer::TYPE)) $criteria->add(GgCronPeer::TYPE, $this->type);
		if ($this->isColumnModified(GgCronPeer::STARTED)) $criteria->add(GgCronPeer::STARTED, $this->started);
		if ($this->isColumnModified(GgCronPeer::ENDED)) $criteria->add(GgCronPeer::ENDED, $this->ended);
		if ($this->isColumnModified(GgCronPeer::YEAR)) $criteria->add(GgCronPeer::YEAR, $this->year);
		if ($this->isColumnModified(GgCronPeer::MONTH)) $criteria->add(GgCronPeer::MONTH, $this->month);
		if ($this->isColumnModified(GgCronPeer::DAY)) $criteria->add(GgCronPeer::DAY, $this->day);
		if ($this->isColumnModified(GgCronPeer::MESSAGE)) $criteria->add(GgCronPeer::MESSAGE, $this->message);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GgCronPeer::DATABASE_NAME);

		$criteria->add(GgCronPeer::ID, $this->id);

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

		$copyObj->setType($this->type);

		$copyObj->setStarted($this->started);

		$copyObj->setEnded($this->ended);

		$copyObj->setYear($this->year);

		$copyObj->setMonth($this->month);

		$copyObj->setDay($this->day);

		$copyObj->setMessage($this->message);


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
			self::$peer = new GgCronPeer();
		}
		return self::$peer;
	}

} 