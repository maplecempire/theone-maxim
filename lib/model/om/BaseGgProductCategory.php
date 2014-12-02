<?php


abstract class BaseGgProductCategory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $parent_id;


	
	protected $title;


	
	protected $plan;


	
	protected $act;


	
	protected $cdate;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getParentId()
	{

		return $this->parent_id;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getPlan()
	{

		return $this->plan;
	}

	
	public function getAct()
	{

		return $this->act;
	}

	
	public function getCdate($format = 'Y-m-d H:i:s')
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

	
	public function setId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = GgProductCategoryPeer::ID;
		}

	} 
	
	public function setParentId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->parent_id !== $v) {
			$this->parent_id = $v;
			$this->modifiedColumns[] = GgProductCategoryPeer::PARENT_ID;
		}

	} 
	
	public function setTitle($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = GgProductCategoryPeer::TITLE;
		}

	} 
	
	public function setPlan($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->plan !== $v) {
			$this->plan = $v;
			$this->modifiedColumns[] = GgProductCategoryPeer::PLAN;
		}

	} 
	
	public function setAct($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->act !== $v) {
			$this->act = $v;
			$this->modifiedColumns[] = GgProductCategoryPeer::ACT;
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
			$this->modifiedColumns[] = GgProductCategoryPeer::CDATE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getString($startcol + 0);

			$this->parent_id = $rs->getString($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->plan = $rs->getString($startcol + 3);

			$this->act = $rs->getString($startcol + 4);

			$this->cdate = $rs->getTimestamp($startcol + 5, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating GgProductCategory object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(GgProductCategoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			GgProductCategoryPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(GgProductCategoryPeer::DATABASE_NAME);
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
					$pk = GgProductCategoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += GgProductCategoryPeer::doUpdate($this, $con);
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


			if (($retval = GgProductCategoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgProductCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getParentId();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getPlan();
				break;
			case 4:
				return $this->getAct();
				break;
			case 5:
				return $this->getCdate();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgProductCategoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getParentId(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getPlan(),
			$keys[4] => $this->getAct(),
			$keys[5] => $this->getCdate(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GgProductCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setParentId($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setPlan($value);
				break;
			case 4:
				$this->setAct($value);
				break;
			case 5:
				$this->setCdate($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GgProductCategoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setParentId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPlan($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setAct($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCdate($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(GgProductCategoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(GgProductCategoryPeer::ID)) $criteria->add(GgProductCategoryPeer::ID, $this->id);
		if ($this->isColumnModified(GgProductCategoryPeer::PARENT_ID)) $criteria->add(GgProductCategoryPeer::PARENT_ID, $this->parent_id);
		if ($this->isColumnModified(GgProductCategoryPeer::TITLE)) $criteria->add(GgProductCategoryPeer::TITLE, $this->title);
		if ($this->isColumnModified(GgProductCategoryPeer::PLAN)) $criteria->add(GgProductCategoryPeer::PLAN, $this->plan);
		if ($this->isColumnModified(GgProductCategoryPeer::ACT)) $criteria->add(GgProductCategoryPeer::ACT, $this->act);
		if ($this->isColumnModified(GgProductCategoryPeer::CDATE)) $criteria->add(GgProductCategoryPeer::CDATE, $this->cdate);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GgProductCategoryPeer::DATABASE_NAME);

		$criteria->add(GgProductCategoryPeer::ID, $this->id);

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

		$copyObj->setParentId($this->parent_id);

		$copyObj->setTitle($this->title);

		$copyObj->setPlan($this->plan);

		$copyObj->setAct($this->act);

		$copyObj->setCdate($this->cdate);


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
			self::$peer = new GgProductCategoryPeer();
		}
		return self::$peer;
	}

} 