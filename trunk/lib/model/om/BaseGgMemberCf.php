<?php


abstract class BaseGgMemberCf extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $tree_upline_dist_id = 0;


	
	protected $uid = '0';


	
	protected $leg = 0;


	
	protected $volume_type = 0;


	
	protected $bv = 0;


	
	protected $amount = 0;


	
	protected $pair_amount = 0;


	
	protected $flash_amount = 0;


	
	protected $cdate;


	
	protected $descr;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTreeUplineDistId()
	{

		return $this->tree_upline_dist_id;
	}

	
	public function getUid()
	{

		return $this->uid;
	}

	
	public function getLeg()
	{

		return $this->leg;
	}

	
	public function getVolumeType()
	{

		return $this->volume_type;
	}

	
	public function getBv()
	{

		return $this->bv;
	}

	
	public function getAmount()
	{

		return $this->amount;
	}

	
	public function getPairAmount()
	{

		return $this->pair_amount;
	}

	
	public function getFlashAmount()
	{

		return $this->flash_amount;
	}

	
	public function getCdate($format = 'Y-m-d')
	{

		if ($this->cdate === null || $this->cdate === '') {
			return null;
		} elseif (!is_int($this->cdate)) {
						$ts = strtotime($this->cdate);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [cdate] as date/time value: " . var_export($this->cdate, true));
			}
		} else {
			$ts = $this->cdate;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDescr()
	{

		return $this->descr;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::ID;
		}

	} 
	
	public function setTreeUplineDistId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tree_upline_dist_id !== $v || $v === 0) {
			$this->tree_upline_dist_id = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::TREE_UPLINE_DIST_ID;
		}

	} 
	
	public function setUid($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->uid !== $v || $v === '0') {
			$this->uid = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::UID;
		}

	} 
	
	public function setLeg($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->leg !== $v || $v === 0) {
			$this->leg = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::LEG;
		}

	} 
	
	public function setVolumeType($v)
	{

		if ($this->volume_type !== $v || $v === 0) {
			$this->volume_type = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::VOLUME_TYPE;
		}

	} 
	
	public function setBv($v)
	{

		if ($this->bv !== $v || $v === 0) {
			$this->bv = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::BV;
		}

	} 
	
	public function setAmount($v)
	{

		if ($this->amount !== $v || $v === 0) {
			$this->amount = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::AMOUNT;
		}

	} 
	
	public function setPairAmount($v)
	{

		if ($this->pair_amount !== $v || $v === 0) {
			$this->pair_amount = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::PAIR_AMOUNT;
		}

	} 
	
	public function setFlashAmount($v)
	{

		if ($this->flash_amount !== $v || $v === 0) {
			$this->flash_amount = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::FLASH_AMOUNT;
		}

	} 
	
	public function setCdate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [cdate] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->cdate !== $ts) {
			$this->cdate = $ts;
			$this->modifiedColumns[] = GgMemberCfPeer::CDATE;
		}

	} 
	
	public function setDescr($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->descr !== $v) {
			$this->descr = $v;
			$this->modifiedColumns[] = GgMemberCfPeer::DESCR;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getString($startcol + 0);

			$this->tree_upline_dist_id = $rs->getInt($startcol + 1);

			$this->uid = $rs->getString($startcol + 2);

			$this->leg = $rs->getInt($startcol + 3);

			$this->volume_type = $rs->getFloat($startcol + 4);

			$this->bv = $rs->getFloat($startcol + 5);

			$this->amount = $rs->getFloat($startcol + 6);

			$this->pair_amount = $rs->getFloat($startcol + 7);

			$this->flash_amount = $rs->getFloat($startcol + 8);

			$this->cdate = $rs->getDate($startcol + 9, null);

			$this->descr = $rs->getString($startcol + 10);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 11; 
		} catch (Exception $e) {
			throw new PropelException("Error populating GgMemberCf object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GgMemberCfPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			GgMemberCfPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(GgMemberCfPeer::DATABASE_NAME);
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
					$pk = GgMemberCfPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += GgMemberCfPeer::doUpdate($this, $con);
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


			if (($retval = GgMemberCfPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgMemberCfPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTreeUplineDistId();
				break;
			case 2:
				return $this->getUid();
				break;
			case 3:
				return $this->getLeg();
				break;
			case 4:
				return $this->getVolumeType();
				break;
			case 5:
				return $this->getBv();
				break;
			case 6:
				return $this->getAmount();
				break;
			case 7:
				return $this->getPairAmount();
				break;
			case 8:
				return $this->getFlashAmount();
				break;
			case 9:
				return $this->getCdate();
				break;
			case 10:
				return $this->getDescr();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgMemberCfPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTreeUplineDistId(),
			$keys[2] => $this->getUid(),
			$keys[3] => $this->getLeg(),
			$keys[4] => $this->getVolumeType(),
			$keys[5] => $this->getBv(),
			$keys[6] => $this->getAmount(),
			$keys[7] => $this->getPairAmount(),
			$keys[8] => $this->getFlashAmount(),
			$keys[9] => $this->getCdate(),
			$keys[10] => $this->getDescr(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgMemberCfPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTreeUplineDistId($value);
				break;
			case 2:
				$this->setUid($value);
				break;
			case 3:
				$this->setLeg($value);
				break;
			case 4:
				$this->setVolumeType($value);
				break;
			case 5:
				$this->setBv($value);
				break;
			case 6:
				$this->setAmount($value);
				break;
			case 7:
				$this->setPairAmount($value);
				break;
			case 8:
				$this->setFlashAmount($value);
				break;
			case 9:
				$this->setCdate($value);
				break;
			case 10:
				$this->setDescr($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgMemberCfPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTreeUplineDistId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUid($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLeg($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setVolumeType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setBv($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAmount($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPairAmount($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setFlashAmount($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCdate($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setDescr($arr[$keys[10]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(GgMemberCfPeer::DATABASE_NAME);

		if ($this->isColumnModified(GgMemberCfPeer::ID)) $criteria->add(GgMemberCfPeer::ID, $this->id);
		if ($this->isColumnModified(GgMemberCfPeer::TREE_UPLINE_DIST_ID)) $criteria->add(GgMemberCfPeer::TREE_UPLINE_DIST_ID, $this->tree_upline_dist_id);
		if ($this->isColumnModified(GgMemberCfPeer::UID)) $criteria->add(GgMemberCfPeer::UID, $this->uid);
		if ($this->isColumnModified(GgMemberCfPeer::LEG)) $criteria->add(GgMemberCfPeer::LEG, $this->leg);
		if ($this->isColumnModified(GgMemberCfPeer::VOLUME_TYPE)) $criteria->add(GgMemberCfPeer::VOLUME_TYPE, $this->volume_type);
		if ($this->isColumnModified(GgMemberCfPeer::BV)) $criteria->add(GgMemberCfPeer::BV, $this->bv);
		if ($this->isColumnModified(GgMemberCfPeer::AMOUNT)) $criteria->add(GgMemberCfPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(GgMemberCfPeer::PAIR_AMOUNT)) $criteria->add(GgMemberCfPeer::PAIR_AMOUNT, $this->pair_amount);
		if ($this->isColumnModified(GgMemberCfPeer::FLASH_AMOUNT)) $criteria->add(GgMemberCfPeer::FLASH_AMOUNT, $this->flash_amount);
		if ($this->isColumnModified(GgMemberCfPeer::CDATE)) $criteria->add(GgMemberCfPeer::CDATE, $this->cdate);
		if ($this->isColumnModified(GgMemberCfPeer::DESCR)) $criteria->add(GgMemberCfPeer::DESCR, $this->descr);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GgMemberCfPeer::DATABASE_NAME);

		$criteria->add(GgMemberCfPeer::ID, $this->id);

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

		$copyObj->setTreeUplineDistId($this->tree_upline_dist_id);

		$copyObj->setUid($this->uid);

		$copyObj->setLeg($this->leg);

		$copyObj->setVolumeType($this->volume_type);

		$copyObj->setBv($this->bv);

		$copyObj->setAmount($this->amount);

		$copyObj->setPairAmount($this->pair_amount);

		$copyObj->setFlashAmount($this->flash_amount);

		$copyObj->setCdate($this->cdate);

		$copyObj->setDescr($this->descr);


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
			self::$peer = new GgMemberCfPeer();
		}
		return self::$peer;
	}

} 