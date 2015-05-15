<?php


abstract class BaseMlmUploadMaterial extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $file_name;


	
	protected $file_name_server;


	
	protected $file_ext;


	
	protected $file_thumbnail;


	
	protected $file_size;


	
	protected $status_code;


	
	protected $description;


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFileName()
	{

		return $this->file_name;
	}

	
	public function getFileNameServer()
	{

		return $this->file_name_server;
	}

	
	public function getFileExt()
	{

		return $this->file_ext;
	}

	
	public function getFileThumbnail()
	{

		return $this->file_thumbnail;
	}

	
	public function getFileSize()
	{

		return $this->file_size;
	}

	
	public function getStatusCode()
	{

		return $this->status_code;
	}

	
	public function getDescription()
	{

		return $this->description;
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

	
	public function setId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::ID;
		}

	} 
	
	public function setFileName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_name !== $v) {
			$this->file_name = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::FILE_NAME;
		}

	} 
	
	public function setFileNameServer($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_name_server !== $v) {
			$this->file_name_server = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::FILE_NAME_SERVER;
		}

	} 
	
	public function setFileExt($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_ext !== $v) {
			$this->file_ext = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::FILE_EXT;
		}

	} 
	
	public function setFileThumbnail($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_thumbnail !== $v) {
			$this->file_thumbnail = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::FILE_THUMBNAIL;
		}

	} 
	
	public function setFileSize($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_size !== $v) {
			$this->file_size = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::FILE_SIZE;
		}

	} 
	
	public function setStatusCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::STATUS_CODE;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::DESCRIPTION;
		}

	} 
	
	public function setCreatedBy($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::CREATED_BY;
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
			$this->modifiedColumns[] = MlmUploadMaterialPeer::CREATED_ON;
		}

	} 
	
	public function setUpdatedBy($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = MlmUploadMaterialPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = MlmUploadMaterialPeer::UPDATED_ON;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getString($startcol + 0);

			$this->file_name = $rs->getString($startcol + 1);

			$this->file_name_server = $rs->getString($startcol + 2);

			$this->file_ext = $rs->getString($startcol + 3);

			$this->file_thumbnail = $rs->getString($startcol + 4);

			$this->file_size = $rs->getString($startcol + 5);

			$this->status_code = $rs->getString($startcol + 6);

			$this->description = $rs->getString($startcol + 7);

			$this->created_by = $rs->getString($startcol + 8);

			$this->created_on = $rs->getTimestamp($startcol + 9, null);

			$this->updated_by = $rs->getString($startcol + 10);

			$this->updated_on = $rs->getTimestamp($startcol + 11, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MlmUploadMaterial object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmUploadMaterialPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MlmUploadMaterialPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MlmUploadMaterialPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MlmUploadMaterialPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmUploadMaterialPeer::DATABASE_NAME);
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
					$pk = MlmUploadMaterialPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MlmUploadMaterialPeer::doUpdate($this, $con);
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


			if (($retval = MlmUploadMaterialPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmUploadMaterialPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFileName();
				break;
			case 2:
				return $this->getFileNameServer();
				break;
			case 3:
				return $this->getFileExt();
				break;
			case 4:
				return $this->getFileThumbnail();
				break;
			case 5:
				return $this->getFileSize();
				break;
			case 6:
				return $this->getStatusCode();
				break;
			case 7:
				return $this->getDescription();
				break;
			case 8:
				return $this->getCreatedBy();
				break;
			case 9:
				return $this->getCreatedOn();
				break;
			case 10:
				return $this->getUpdatedBy();
				break;
			case 11:
				return $this->getUpdatedOn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmUploadMaterialPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFileName(),
			$keys[2] => $this->getFileNameServer(),
			$keys[3] => $this->getFileExt(),
			$keys[4] => $this->getFileThumbnail(),
			$keys[5] => $this->getFileSize(),
			$keys[6] => $this->getStatusCode(),
			$keys[7] => $this->getDescription(),
			$keys[8] => $this->getCreatedBy(),
			$keys[9] => $this->getCreatedOn(),
			$keys[10] => $this->getUpdatedBy(),
			$keys[11] => $this->getUpdatedOn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmUploadMaterialPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFileName($value);
				break;
			case 2:
				$this->setFileNameServer($value);
				break;
			case 3:
				$this->setFileExt($value);
				break;
			case 4:
				$this->setFileThumbnail($value);
				break;
			case 5:
				$this->setFileSize($value);
				break;
			case 6:
				$this->setStatusCode($value);
				break;
			case 7:
				$this->setDescription($value);
				break;
			case 8:
				$this->setCreatedBy($value);
				break;
			case 9:
				$this->setCreatedOn($value);
				break;
			case 10:
				$this->setUpdatedBy($value);
				break;
			case 11:
				$this->setUpdatedOn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmUploadMaterialPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFileName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFileNameServer($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setFileExt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFileThumbnail($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFileSize($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setStatusCode($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDescription($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedOn($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setUpdatedBy($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setUpdatedOn($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MlmUploadMaterialPeer::DATABASE_NAME);

		if ($this->isColumnModified(MlmUploadMaterialPeer::ID)) $criteria->add(MlmUploadMaterialPeer::ID, $this->id);
		if ($this->isColumnModified(MlmUploadMaterialPeer::FILE_NAME)) $criteria->add(MlmUploadMaterialPeer::FILE_NAME, $this->file_name);
		if ($this->isColumnModified(MlmUploadMaterialPeer::FILE_NAME_SERVER)) $criteria->add(MlmUploadMaterialPeer::FILE_NAME_SERVER, $this->file_name_server);
		if ($this->isColumnModified(MlmUploadMaterialPeer::FILE_EXT)) $criteria->add(MlmUploadMaterialPeer::FILE_EXT, $this->file_ext);
		if ($this->isColumnModified(MlmUploadMaterialPeer::FILE_THUMBNAIL)) $criteria->add(MlmUploadMaterialPeer::FILE_THUMBNAIL, $this->file_thumbnail);
		if ($this->isColumnModified(MlmUploadMaterialPeer::FILE_SIZE)) $criteria->add(MlmUploadMaterialPeer::FILE_SIZE, $this->file_size);
		if ($this->isColumnModified(MlmUploadMaterialPeer::STATUS_CODE)) $criteria->add(MlmUploadMaterialPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(MlmUploadMaterialPeer::DESCRIPTION)) $criteria->add(MlmUploadMaterialPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(MlmUploadMaterialPeer::CREATED_BY)) $criteria->add(MlmUploadMaterialPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(MlmUploadMaterialPeer::CREATED_ON)) $criteria->add(MlmUploadMaterialPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(MlmUploadMaterialPeer::UPDATED_BY)) $criteria->add(MlmUploadMaterialPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(MlmUploadMaterialPeer::UPDATED_ON)) $criteria->add(MlmUploadMaterialPeer::UPDATED_ON, $this->updated_on);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MlmUploadMaterialPeer::DATABASE_NAME);

		$criteria->add(MlmUploadMaterialPeer::ID, $this->id);

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

		$copyObj->setFileName($this->file_name);

		$copyObj->setFileNameServer($this->file_name_server);

		$copyObj->setFileExt($this->file_ext);

		$copyObj->setFileThumbnail($this->file_thumbnail);

		$copyObj->setFileSize($this->file_size);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setDescription($this->description);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);


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
			self::$peer = new MlmUploadMaterialPeer();
		}
		return self::$peer;
	}

} 