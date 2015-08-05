<?php


abstract class BaseSssApplication extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $sss_id;


	
	protected $dist_id;


	
	protected $dividend_id;


	
	protected $mt4_user_name;


	
	protected $cp2_balance = 0;


	
	protected $cp3_balance = 0;


	
	protected $rt_balance = 0;


	
	protected $mt4_balance = 0;


	
	protected $roi_remaining_month;


	
	protected $roi_percentage = 0;


	
	protected $total_amount_converted_with_cp2cp3 = 0;


	
	protected $share_value = 0;


	
	protected $total_share_converted = 0;


	
	protected $signature;


	
	protected $remarks;


	
	protected $status_code;


	
	protected $swap_type = 'RSHARE';


	
	protected $client_action = 'PENDING';


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;


	
	protected $share_from_roi_remaining;


	
	protected $ses_idx;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getSssId()
	{

		return $this->sss_id;
	}

	
	public function getDistId()
	{

		return $this->dist_id;
	}

	
	public function getDividendId()
	{

		return $this->dividend_id;
	}

	
	public function getMt4UserName()
	{

		return $this->mt4_user_name;
	}

	
	public function getCp2Balance()
	{

		return $this->cp2_balance;
	}

	
	public function getCp3Balance()
	{

		return $this->cp3_balance;
	}

	
	public function getRtBalance()
	{

		return $this->rt_balance;
	}

	
	public function getMt4Balance()
	{

		return $this->mt4_balance;
	}

	
	public function getRoiRemainingMonth()
	{

		return $this->roi_remaining_month;
	}

	
	public function getRoiPercentage()
	{

		return $this->roi_percentage;
	}

	
	public function getTotalAmountConvertedWithCp2cp3()
	{

		return $this->total_amount_converted_with_cp2cp3;
	}

	
	public function getShareValue()
	{

		return $this->share_value;
	}

	
	public function getTotalShareConverted()
	{

		return $this->total_share_converted;
	}

	
	public function getSignature()
	{

		return $this->signature;
	}

	
	public function getRemarks()
	{

		return $this->remarks;
	}

	
	public function getStatusCode()
	{

		return $this->status_code;
	}

	
	public function getSwapType()
	{

		return $this->swap_type;
	}

	
	public function getClientAction()
	{

		return $this->client_action;
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

	
	public function getShareFromRoiRemaining()
	{

		return $this->share_from_roi_remaining;
	}

	
	public function getSesIdx()
	{

		return $this->ses_idx;
	}

	
	public function setSssId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sss_id !== $v) {
			$this->sss_id = $v;
			$this->modifiedColumns[] = SssApplicationPeer::SSS_ID;
		}

	} 
	
	public function setDistId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->dist_id !== $v) {
			$this->dist_id = $v;
			$this->modifiedColumns[] = SssApplicationPeer::DIST_ID;
		}

	} 
	
	public function setDividendId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->dividend_id !== $v) {
			$this->dividend_id = $v;
			$this->modifiedColumns[] = SssApplicationPeer::DIVIDEND_ID;
		}

	} 
	
	public function setMt4UserName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mt4_user_name !== $v) {
			$this->mt4_user_name = $v;
			$this->modifiedColumns[] = SssApplicationPeer::MT4_USER_NAME;
		}

	} 
	
	public function setCp2Balance($v)
	{

		if ($this->cp2_balance !== $v || $v === 0) {
			$this->cp2_balance = $v;
			$this->modifiedColumns[] = SssApplicationPeer::CP2_BALANCE;
		}

	} 
	
	public function setCp3Balance($v)
	{

		if ($this->cp3_balance !== $v || $v === 0) {
			$this->cp3_balance = $v;
			$this->modifiedColumns[] = SssApplicationPeer::CP3_BALANCE;
		}

	} 
	
	public function setRtBalance($v)
	{

		if ($this->rt_balance !== $v || $v === 0) {
			$this->rt_balance = $v;
			$this->modifiedColumns[] = SssApplicationPeer::RT_BALANCE;
		}

	} 
	
	public function setMt4Balance($v)
	{

		if ($this->mt4_balance !== $v || $v === 0) {
			$this->mt4_balance = $v;
			$this->modifiedColumns[] = SssApplicationPeer::MT4_BALANCE;
		}

	} 
	
	public function setRoiRemainingMonth($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->roi_remaining_month !== $v) {
			$this->roi_remaining_month = $v;
			$this->modifiedColumns[] = SssApplicationPeer::ROI_REMAINING_MONTH;
		}

	} 
	
	public function setRoiPercentage($v)
	{

		if ($this->roi_percentage !== $v || $v === 0) {
			$this->roi_percentage = $v;
			$this->modifiedColumns[] = SssApplicationPeer::ROI_PERCENTAGE;
		}

	} 
	
	public function setTotalAmountConvertedWithCp2cp3($v)
	{

		if ($this->total_amount_converted_with_cp2cp3 !== $v || $v === 0) {
			$this->total_amount_converted_with_cp2cp3 = $v;
			$this->modifiedColumns[] = SssApplicationPeer::TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3;
		}

	} 
	
	public function setShareValue($v)
	{

		if ($this->share_value !== $v || $v === 0) {
			$this->share_value = $v;
			$this->modifiedColumns[] = SssApplicationPeer::SHARE_VALUE;
		}

	} 
	
	public function setTotalShareConverted($v)
	{

		if ($this->total_share_converted !== $v || $v === 0) {
			$this->total_share_converted = $v;
			$this->modifiedColumns[] = SssApplicationPeer::TOTAL_SHARE_CONVERTED;
		}

	} 
	
	public function setSignature($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->signature !== $v) {
			$this->signature = $v;
			$this->modifiedColumns[] = SssApplicationPeer::SIGNATURE;
		}

	} 
	
	public function setRemarks($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remarks !== $v) {
			$this->remarks = $v;
			$this->modifiedColumns[] = SssApplicationPeer::REMARKS;
		}

	} 
	
	public function setStatusCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = SssApplicationPeer::STATUS_CODE;
		}

	} 
	
	public function setSwapType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->swap_type !== $v || $v === 'RSHARE') {
			$this->swap_type = $v;
			$this->modifiedColumns[] = SssApplicationPeer::SWAP_TYPE;
		}

	} 
	
	public function setClientAction($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->client_action !== $v || $v === 'PENDING') {
			$this->client_action = $v;
			$this->modifiedColumns[] = SssApplicationPeer::CLIENT_ACTION;
		}

	} 
	
	public function setCreatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = SssApplicationPeer::CREATED_BY;
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
			$this->modifiedColumns[] = SssApplicationPeer::CREATED_ON;
		}

	} 
	
	public function setUpdatedBy($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = SssApplicationPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = SssApplicationPeer::UPDATED_ON;
		}

	} 
	
	public function setShareFromRoiRemaining($v)
	{

		if ($this->share_from_roi_remaining !== $v) {
			$this->share_from_roi_remaining = $v;
			$this->modifiedColumns[] = SssApplicationPeer::SHARE_FROM_ROI_REMAINING;
		}

	} 
	
	public function setSesIdx($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ses_idx !== $v) {
			$this->ses_idx = $v;
			$this->modifiedColumns[] = SssApplicationPeer::SES_IDX;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->sss_id = $rs->getInt($startcol + 0);

			$this->dist_id = $rs->getInt($startcol + 1);

			$this->dividend_id = $rs->getInt($startcol + 2);

			$this->mt4_user_name = $rs->getString($startcol + 3);

			$this->cp2_balance = $rs->getFloat($startcol + 4);

			$this->cp3_balance = $rs->getFloat($startcol + 5);

			$this->rt_balance = $rs->getFloat($startcol + 6);

			$this->mt4_balance = $rs->getFloat($startcol + 7);

			$this->roi_remaining_month = $rs->getInt($startcol + 8);

			$this->roi_percentage = $rs->getFloat($startcol + 9);

			$this->total_amount_converted_with_cp2cp3 = $rs->getFloat($startcol + 10);

			$this->share_value = $rs->getFloat($startcol + 11);

			$this->total_share_converted = $rs->getFloat($startcol + 12);

			$this->signature = $rs->getString($startcol + 13);

			$this->remarks = $rs->getString($startcol + 14);

			$this->status_code = $rs->getString($startcol + 15);

			$this->swap_type = $rs->getString($startcol + 16);

			$this->client_action = $rs->getString($startcol + 17);

			$this->created_by = $rs->getInt($startcol + 18);

			$this->created_on = $rs->getTimestamp($startcol + 19, null);

			$this->updated_by = $rs->getInt($startcol + 20);

			$this->updated_on = $rs->getTimestamp($startcol + 21, null);

			$this->share_from_roi_remaining = $rs->getFloat($startcol + 22);

			$this->ses_idx = $rs->getInt($startcol + 23);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 24; 
		} catch (Exception $e) {
			throw new PropelException("Error populating SssApplication object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SssApplicationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SssApplicationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(SssApplicationPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(SssApplicationPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SssApplicationPeer::DATABASE_NAME);
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
					$pk = SssApplicationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setSssId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SssApplicationPeer::doUpdate($this, $con);
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


			if (($retval = SssApplicationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SssApplicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getSssId();
				break;
			case 1:
				return $this->getDistId();
				break;
			case 2:
				return $this->getDividendId();
				break;
			case 3:
				return $this->getMt4UserName();
				break;
			case 4:
				return $this->getCp2Balance();
				break;
			case 5:
				return $this->getCp3Balance();
				break;
			case 6:
				return $this->getRtBalance();
				break;
			case 7:
				return $this->getMt4Balance();
				break;
			case 8:
				return $this->getRoiRemainingMonth();
				break;
			case 9:
				return $this->getRoiPercentage();
				break;
			case 10:
				return $this->getTotalAmountConvertedWithCp2cp3();
				break;
			case 11:
				return $this->getShareValue();
				break;
			case 12:
				return $this->getTotalShareConverted();
				break;
			case 13:
				return $this->getSignature();
				break;
			case 14:
				return $this->getRemarks();
				break;
			case 15:
				return $this->getStatusCode();
				break;
			case 16:
				return $this->getSwapType();
				break;
			case 17:
				return $this->getClientAction();
				break;
			case 18:
				return $this->getCreatedBy();
				break;
			case 19:
				return $this->getCreatedOn();
				break;
			case 20:
				return $this->getUpdatedBy();
				break;
			case 21:
				return $this->getUpdatedOn();
				break;
			case 22:
				return $this->getShareFromRoiRemaining();
				break;
			case 23:
				return $this->getSesIdx();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SssApplicationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getSssId(),
			$keys[1] => $this->getDistId(),
			$keys[2] => $this->getDividendId(),
			$keys[3] => $this->getMt4UserName(),
			$keys[4] => $this->getCp2Balance(),
			$keys[5] => $this->getCp3Balance(),
			$keys[6] => $this->getRtBalance(),
			$keys[7] => $this->getMt4Balance(),
			$keys[8] => $this->getRoiRemainingMonth(),
			$keys[9] => $this->getRoiPercentage(),
			$keys[10] => $this->getTotalAmountConvertedWithCp2cp3(),
			$keys[11] => $this->getShareValue(),
			$keys[12] => $this->getTotalShareConverted(),
			$keys[13] => $this->getSignature(),
			$keys[14] => $this->getRemarks(),
			$keys[15] => $this->getStatusCode(),
			$keys[16] => $this->getSwapType(),
			$keys[17] => $this->getClientAction(),
			$keys[18] => $this->getCreatedBy(),
			$keys[19] => $this->getCreatedOn(),
			$keys[20] => $this->getUpdatedBy(),
			$keys[21] => $this->getUpdatedOn(),
			$keys[22] => $this->getShareFromRoiRemaining(),
			$keys[23] => $this->getSesIdx(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SssApplicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setSssId($value);
				break;
			case 1:
				$this->setDistId($value);
				break;
			case 2:
				$this->setDividendId($value);
				break;
			case 3:
				$this->setMt4UserName($value);
				break;
			case 4:
				$this->setCp2Balance($value);
				break;
			case 5:
				$this->setCp3Balance($value);
				break;
			case 6:
				$this->setRtBalance($value);
				break;
			case 7:
				$this->setMt4Balance($value);
				break;
			case 8:
				$this->setRoiRemainingMonth($value);
				break;
			case 9:
				$this->setRoiPercentage($value);
				break;
			case 10:
				$this->setTotalAmountConvertedWithCp2cp3($value);
				break;
			case 11:
				$this->setShareValue($value);
				break;
			case 12:
				$this->setTotalShareConverted($value);
				break;
			case 13:
				$this->setSignature($value);
				break;
			case 14:
				$this->setRemarks($value);
				break;
			case 15:
				$this->setStatusCode($value);
				break;
			case 16:
				$this->setSwapType($value);
				break;
			case 17:
				$this->setClientAction($value);
				break;
			case 18:
				$this->setCreatedBy($value);
				break;
			case 19:
				$this->setCreatedOn($value);
				break;
			case 20:
				$this->setUpdatedBy($value);
				break;
			case 21:
				$this->setUpdatedOn($value);
				break;
			case 22:
				$this->setShareFromRoiRemaining($value);
				break;
			case 23:
				$this->setSesIdx($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SssApplicationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setSssId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDistId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDividendId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMt4UserName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCp2Balance($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCp3Balance($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setRtBalance($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMt4Balance($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setRoiRemainingMonth($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRoiPercentage($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setTotalAmountConvertedWithCp2cp3($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setShareValue($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setTotalShareConverted($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setSignature($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setRemarks($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setStatusCode($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setSwapType($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setClientAction($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setCreatedBy($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setCreatedOn($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setUpdatedBy($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setUpdatedOn($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setShareFromRoiRemaining($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setSesIdx($arr[$keys[23]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SssApplicationPeer::DATABASE_NAME);

		if ($this->isColumnModified(SssApplicationPeer::SSS_ID)) $criteria->add(SssApplicationPeer::SSS_ID, $this->sss_id);
		if ($this->isColumnModified(SssApplicationPeer::DIST_ID)) $criteria->add(SssApplicationPeer::DIST_ID, $this->dist_id);
		if ($this->isColumnModified(SssApplicationPeer::DIVIDEND_ID)) $criteria->add(SssApplicationPeer::DIVIDEND_ID, $this->dividend_id);
		if ($this->isColumnModified(SssApplicationPeer::MT4_USER_NAME)) $criteria->add(SssApplicationPeer::MT4_USER_NAME, $this->mt4_user_name);
		if ($this->isColumnModified(SssApplicationPeer::CP2_BALANCE)) $criteria->add(SssApplicationPeer::CP2_BALANCE, $this->cp2_balance);
		if ($this->isColumnModified(SssApplicationPeer::CP3_BALANCE)) $criteria->add(SssApplicationPeer::CP3_BALANCE, $this->cp3_balance);
		if ($this->isColumnModified(SssApplicationPeer::RT_BALANCE)) $criteria->add(SssApplicationPeer::RT_BALANCE, $this->rt_balance);
		if ($this->isColumnModified(SssApplicationPeer::MT4_BALANCE)) $criteria->add(SssApplicationPeer::MT4_BALANCE, $this->mt4_balance);
		if ($this->isColumnModified(SssApplicationPeer::ROI_REMAINING_MONTH)) $criteria->add(SssApplicationPeer::ROI_REMAINING_MONTH, $this->roi_remaining_month);
		if ($this->isColumnModified(SssApplicationPeer::ROI_PERCENTAGE)) $criteria->add(SssApplicationPeer::ROI_PERCENTAGE, $this->roi_percentage);
		if ($this->isColumnModified(SssApplicationPeer::TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3)) $criteria->add(SssApplicationPeer::TOTAL_AMOUNT_CONVERTED_WITH_CP2CP3, $this->total_amount_converted_with_cp2cp3);
		if ($this->isColumnModified(SssApplicationPeer::SHARE_VALUE)) $criteria->add(SssApplicationPeer::SHARE_VALUE, $this->share_value);
		if ($this->isColumnModified(SssApplicationPeer::TOTAL_SHARE_CONVERTED)) $criteria->add(SssApplicationPeer::TOTAL_SHARE_CONVERTED, $this->total_share_converted);
		if ($this->isColumnModified(SssApplicationPeer::SIGNATURE)) $criteria->add(SssApplicationPeer::SIGNATURE, $this->signature);
		if ($this->isColumnModified(SssApplicationPeer::REMARKS)) $criteria->add(SssApplicationPeer::REMARKS, $this->remarks);
		if ($this->isColumnModified(SssApplicationPeer::STATUS_CODE)) $criteria->add(SssApplicationPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(SssApplicationPeer::SWAP_TYPE)) $criteria->add(SssApplicationPeer::SWAP_TYPE, $this->swap_type);
		if ($this->isColumnModified(SssApplicationPeer::CLIENT_ACTION)) $criteria->add(SssApplicationPeer::CLIENT_ACTION, $this->client_action);
		if ($this->isColumnModified(SssApplicationPeer::CREATED_BY)) $criteria->add(SssApplicationPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(SssApplicationPeer::CREATED_ON)) $criteria->add(SssApplicationPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(SssApplicationPeer::UPDATED_BY)) $criteria->add(SssApplicationPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(SssApplicationPeer::UPDATED_ON)) $criteria->add(SssApplicationPeer::UPDATED_ON, $this->updated_on);
		if ($this->isColumnModified(SssApplicationPeer::SHARE_FROM_ROI_REMAINING)) $criteria->add(SssApplicationPeer::SHARE_FROM_ROI_REMAINING, $this->share_from_roi_remaining);
		if ($this->isColumnModified(SssApplicationPeer::SES_IDX)) $criteria->add(SssApplicationPeer::SES_IDX, $this->ses_idx);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SssApplicationPeer::DATABASE_NAME);

		$criteria->add(SssApplicationPeer::SSS_ID, $this->sss_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getSssId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setSssId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDistId($this->dist_id);

		$copyObj->setDividendId($this->dividend_id);

		$copyObj->setMt4UserName($this->mt4_user_name);

		$copyObj->setCp2Balance($this->cp2_balance);

		$copyObj->setCp3Balance($this->cp3_balance);

		$copyObj->setRtBalance($this->rt_balance);

		$copyObj->setMt4Balance($this->mt4_balance);

		$copyObj->setRoiRemainingMonth($this->roi_remaining_month);

		$copyObj->setRoiPercentage($this->roi_percentage);

		$copyObj->setTotalAmountConvertedWithCp2cp3($this->total_amount_converted_with_cp2cp3);

		$copyObj->setShareValue($this->share_value);

		$copyObj->setTotalShareConverted($this->total_share_converted);

		$copyObj->setSignature($this->signature);

		$copyObj->setRemarks($this->remarks);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setSwapType($this->swap_type);

		$copyObj->setClientAction($this->client_action);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);

		$copyObj->setShareFromRoiRemaining($this->share_from_roi_remaining);

		$copyObj->setSesIdx($this->ses_idx);


		$copyObj->setNew(true);

		$copyObj->setSssId(NULL); 
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
			self::$peer = new SssApplicationPeer();
		}
		return self::$peer;
	}

} 