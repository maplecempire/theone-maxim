<?php


abstract class BaseMlmDistributor extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $distributor_id;


	
	protected $distributor_code;


	
	protected $user_id;


	
	protected $status_code;


	
	protected $full_name;


	
	protected $nickname;


	
	protected $ic;


	
	protected $country;


	
	protected $address;


	
	protected $address2;


	
	protected $city;


	
	protected $state;


	
	protected $postcode;


	
	protected $email;


	
	protected $alternate_email;


	
	protected $contact;


	
	protected $gender;


	
	protected $dob;


	
	protected $bank_name;


	
	protected $bank_acc_no;


	
	protected $bank_holder_name;


	
	protected $bank_swift_code;


	
	protected $visa_debit_card;


	
	protected $tree_level;


	
	protected $tree_structure;


	
	protected $placement_tree_level;


	
	protected $placement_tree_structure;


	
	protected $init_rank_id;


	
	protected $init_rank_code;


	
	protected $upline_dist_id;


	
	protected $upline_dist_code;


	
	protected $tree_upline_dist_id;


	
	protected $tree_upline_dist_code;


	
	protected $total_left = 0;


	
	protected $total_right = 0;


	
	protected $placement_position;


	
	protected $placement_datetime;


	
	protected $rank_id;


	
	protected $rank_code;


	
	protected $active_datetime;


	
	protected $activated_by;


	
	protected $leverage;


	
	protected $spread;


	
	protected $deposit_currency;


	
	protected $deposit_amount;


	
	protected $sign_name;


	
	protected $sign_date;


	
	protected $term_condition = 0;


	
	protected $ib_commission = 0;


	
	protected $is_ib = '0';


	
	protected $created_by;


	
	protected $created_on;


	
	protected $updated_by;


	
	protected $updated_on;


	
	protected $package_purchase_flag = '';


	
	protected $file_bank_pass_book;


	
	protected $file_proof_of_residence;


	
	protected $file_nric;


	
	protected $excluded_structure = '';


	
	protected $product_mte = '';


	
	protected $product_fxgold = '';


	
	protected $remark;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getDistributorId()
	{

		return $this->distributor_id;
	}

	
	public function getDistributorCode()
	{

		return $this->distributor_code;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getStatusCode()
	{

		return $this->status_code;
	}

	
	public function getFullName()
	{

		return $this->full_name;
	}

	
	public function getNickname()
	{

		return $this->nickname;
	}

	
	public function getIc()
	{

		return $this->ic;
	}

	
	public function getCountry()
	{

		return $this->country;
	}

	
	public function getAddress()
	{

		return $this->address;
	}

	
	public function getAddress2()
	{

		return $this->address2;
	}

	
	public function getCity()
	{

		return $this->city;
	}

	
	public function getState()
	{

		return $this->state;
	}

	
	public function getPostcode()
	{

		return $this->postcode;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getAlternateEmail()
	{

		return $this->alternate_email;
	}

	
	public function getContact()
	{

		return $this->contact;
	}

	
	public function getGender()
	{

		return $this->gender;
	}

	
	public function getDob($format = 'Y-m-d')
	{

		if ($this->dob === null || $this->dob === '') {
			return null;
		} elseif (!is_int($this->dob)) {
						$ts = strtotime($this->dob);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [dob] as date/time value: " . var_export($this->dob, true));
			}
		} else {
			$ts = $this->dob;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getBankName()
	{

		return $this->bank_name;
	}

	
	public function getBankAccNo()
	{

		return $this->bank_acc_no;
	}

	
	public function getBankHolderName()
	{

		return $this->bank_holder_name;
	}

	
	public function getBankSwiftCode()
	{

		return $this->bank_swift_code;
	}

	
	public function getVisaDebitCard()
	{

		return $this->visa_debit_card;
	}

	
	public function getTreeLevel()
	{

		return $this->tree_level;
	}

	
	public function getTreeStructure()
	{

		return $this->tree_structure;
	}

	
	public function getPlacementTreeLevel()
	{

		return $this->placement_tree_level;
	}

	
	public function getPlacementTreeStructure()
	{

		return $this->placement_tree_structure;
	}

	
	public function getInitRankId()
	{

		return $this->init_rank_id;
	}

	
	public function getInitRankCode()
	{

		return $this->init_rank_code;
	}

	
	public function getUplineDistId()
	{

		return $this->upline_dist_id;
	}

	
	public function getUplineDistCode()
	{

		return $this->upline_dist_code;
	}

	
	public function getTreeUplineDistId()
	{

		return $this->tree_upline_dist_id;
	}

	
	public function getTreeUplineDistCode()
	{

		return $this->tree_upline_dist_code;
	}

	
	public function getTotalLeft()
	{

		return $this->total_left;
	}

	
	public function getTotalRight()
	{

		return $this->total_right;
	}

	
	public function getPlacementPosition()
	{

		return $this->placement_position;
	}

	
	public function getPlacementDatetime($format = 'Y-m-d H:i:s')
	{

		if ($this->placement_datetime === null || $this->placement_datetime === '') {
			return null;
		} elseif (!is_int($this->placement_datetime)) {
						$ts = strtotime($this->placement_datetime);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [placement_datetime] as date/time value: " . var_export($this->placement_datetime, true));
			}
		} else {
			$ts = $this->placement_datetime;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getRankId()
	{

		return $this->rank_id;
	}

	
	public function getRankCode()
	{

		return $this->rank_code;
	}

	
	public function getActiveDatetime($format = 'Y-m-d H:i:s')
	{

		if ($this->active_datetime === null || $this->active_datetime === '') {
			return null;
		} elseif (!is_int($this->active_datetime)) {
						$ts = strtotime($this->active_datetime);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [active_datetime] as date/time value: " . var_export($this->active_datetime, true));
			}
		} else {
			$ts = $this->active_datetime;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getActivatedBy()
	{

		return $this->activated_by;
	}

	
	public function getLeverage()
	{

		return $this->leverage;
	}

	
	public function getSpread()
	{

		return $this->spread;
	}

	
	public function getDepositCurrency()
	{

		return $this->deposit_currency;
	}

	
	public function getDepositAmount()
	{

		return $this->deposit_amount;
	}

	
	public function getSignName()
	{

		return $this->sign_name;
	}

	
	public function getSignDate($format = 'Y-m-d H:i:s')
	{

		if ($this->sign_date === null || $this->sign_date === '') {
			return null;
		} elseif (!is_int($this->sign_date)) {
						$ts = strtotime($this->sign_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [sign_date] as date/time value: " . var_export($this->sign_date, true));
			}
		} else {
			$ts = $this->sign_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getTermCondition()
	{

		return $this->term_condition;
	}

	
	public function getIbCommission()
	{

		return $this->ib_commission;
	}

	
	public function getIsIb()
	{

		return $this->is_ib;
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

	
	public function getPackagePurchaseFlag()
	{

		return $this->package_purchase_flag;
	}

	
	public function getFileBankPassBook()
	{

		return $this->file_bank_pass_book;
	}

	
	public function getFileProofOfResidence()
	{

		return $this->file_proof_of_residence;
	}

	
	public function getFileNric()
	{

		return $this->file_nric;
	}

	
	public function getExcludedStructure()
	{

		return $this->excluded_structure;
	}

	
	public function getProductMte()
	{

		return $this->product_mte;
	}

	
	public function getProductFxgold()
	{

		return $this->product_fxgold;
	}

	
	public function getRemark()
	{

		return $this->remark;
	}

	
	public function setDistributorId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->distributor_id !== $v) {
			$this->distributor_id = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::DISTRIBUTOR_ID;
		}

	} 

	
	public function setDistributorCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->distributor_code !== $v) {
			$this->distributor_code = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::DISTRIBUTOR_CODE;
		}

	} 

	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::USER_ID;
		}

	} 

	
	public function setStatusCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status_code !== $v) {
			$this->status_code = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::STATUS_CODE;
		}

	} 

	
	public function setFullName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->full_name !== $v) {
			$this->full_name = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::FULL_NAME;
		}

	} 

	
	public function setNickname($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nickname !== $v) {
			$this->nickname = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::NICKNAME;
		}

	} 

	
	public function setIc($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ic !== $v) {
			$this->ic = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::IC;
		}

	} 

	
	public function setCountry($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->country !== $v) {
			$this->country = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::COUNTRY;
		}

	} 

	
	public function setAddress($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->address !== $v) {
			$this->address = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::ADDRESS;
		}

	} 

	
	public function setAddress2($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->address2 !== $v) {
			$this->address2 = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::ADDRESS2;
		}

	} 

	
	public function setCity($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->city !== $v) {
			$this->city = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::CITY;
		}

	} 

	
	public function setState($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->state !== $v) {
			$this->state = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::STATE;
		}

	} 

	
	public function setPostcode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->postcode !== $v) {
			$this->postcode = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::POSTCODE;
		}

	} 

	
	public function setEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::EMAIL;
		}

	} 

	
	public function setAlternateEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->alternate_email !== $v) {
			$this->alternate_email = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::ALTERNATE_EMAIL;
		}

	} 

	
	public function setContact($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->contact !== $v) {
			$this->contact = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::CONTACT;
		}

	} 

	
	public function setGender($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->gender !== $v) {
			$this->gender = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::GENDER;
		}

	} 

	
	public function setDob($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [dob] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->dob !== $ts) {
			$this->dob = $ts;
			$this->modifiedColumns[] = MlmDistributorPeer::DOB;
		}

	} 

	
	public function setBankName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_name !== $v) {
			$this->bank_name = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::BANK_NAME;
		}

	} 

	
	public function setBankAccNo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_acc_no !== $v) {
			$this->bank_acc_no = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::BANK_ACC_NO;
		}

	} 

	
	public function setBankHolderName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_holder_name !== $v) {
			$this->bank_holder_name = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::BANK_HOLDER_NAME;
		}

	} 

	
	public function setBankSwiftCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bank_swift_code !== $v) {
			$this->bank_swift_code = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::BANK_SWIFT_CODE;
		}

	} 

	
	public function setVisaDebitCard($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->visa_debit_card !== $v) {
			$this->visa_debit_card = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::VISA_DEBIT_CARD;
		}

	} 

	
	public function setTreeLevel($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tree_level !== $v) {
			$this->tree_level = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::TREE_LEVEL;
		}

	} 

	
	public function setTreeStructure($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tree_structure !== $v) {
			$this->tree_structure = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::TREE_STRUCTURE;
		}

	} 

	
	public function setPlacementTreeLevel($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->placement_tree_level !== $v) {
			$this->placement_tree_level = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::PLACEMENT_TREE_LEVEL;
		}

	} 

	
	public function setPlacementTreeStructure($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->placement_tree_structure !== $v) {
			$this->placement_tree_structure = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE;
		}

	} 

	
	public function setInitRankId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->init_rank_id !== $v) {
			$this->init_rank_id = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::INIT_RANK_ID;
		}

	} 

	
	public function setInitRankCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->init_rank_code !== $v) {
			$this->init_rank_code = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::INIT_RANK_CODE;
		}

	} 

	
	public function setUplineDistId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->upline_dist_id !== $v) {
			$this->upline_dist_id = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::UPLINE_DIST_ID;
		}

	} 

	
	public function setUplineDistCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->upline_dist_code !== $v) {
			$this->upline_dist_code = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::UPLINE_DIST_CODE;
		}

	} 

	
	public function setTreeUplineDistId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tree_upline_dist_id !== $v) {
			$this->tree_upline_dist_id = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::TREE_UPLINE_DIST_ID;
		}

	} 

	
	public function setTreeUplineDistCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tree_upline_dist_code !== $v) {
			$this->tree_upline_dist_code = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::TREE_UPLINE_DIST_CODE;
		}

	} 

	
	public function setTotalLeft($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_left !== $v || $v === 0) {
			$this->total_left = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::TOTAL_LEFT;
		}

	} 

	
	public function setTotalRight($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_right !== $v || $v === 0) {
			$this->total_right = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::TOTAL_RIGHT;
		}

	} 

	
	public function setPlacementPosition($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->placement_position !== $v) {
			$this->placement_position = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::PLACEMENT_POSITION;
		}

	} 

	
	public function setPlacementDatetime($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [placement_datetime] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->placement_datetime !== $ts) {
			$this->placement_datetime = $ts;
			$this->modifiedColumns[] = MlmDistributorPeer::PLACEMENT_DATETIME;
		}

	} 

	
	public function setRankId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->rank_id !== $v) {
			$this->rank_id = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::RANK_ID;
		}

	} 

	
	public function setRankCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rank_code !== $v) {
			$this->rank_code = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::RANK_CODE;
		}

	} 

	
	public function setActiveDatetime($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [active_datetime] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->active_datetime !== $ts) {
			$this->active_datetime = $ts;
			$this->modifiedColumns[] = MlmDistributorPeer::ACTIVE_DATETIME;
		}

	} 

	
	public function setActivatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->activated_by !== $v) {
			$this->activated_by = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::ACTIVATED_BY;
		}

	} 

	
	public function setLeverage($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->leverage !== $v) {
			$this->leverage = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::LEVERAGE;
		}

	} 

	
	public function setSpread($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->spread !== $v) {
			$this->spread = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::SPREAD;
		}

	} 

	
	public function setDepositCurrency($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->deposit_currency !== $v) {
			$this->deposit_currency = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::DEPOSIT_CURRENCY;
		}

	} 

	
	public function setDepositAmount($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->deposit_amount !== $v) {
			$this->deposit_amount = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::DEPOSIT_AMOUNT;
		}

	} 

	
	public function setSignName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->sign_name !== $v) {
			$this->sign_name = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::SIGN_NAME;
		}

	} 

	
	public function setSignDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [sign_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->sign_date !== $ts) {
			$this->sign_date = $ts;
			$this->modifiedColumns[] = MlmDistributorPeer::SIGN_DATE;
		}

	} 

	
	public function setTermCondition($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->term_condition !== $v || $v === 0) {
			$this->term_condition = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::TERM_CONDITION;
		}

	} 

	
	public function setIbCommission($v)
	{

		if ($this->ib_commission !== $v || $v === 0) {
			$this->ib_commission = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::IB_COMMISSION;
		}

	} 

	
	public function setIsIb($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->is_ib !== $v || $v === '0') {
			$this->is_ib = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::IS_IB;
		}

	} 

	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::CREATED_BY;
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
			$this->modifiedColumns[] = MlmDistributorPeer::CREATED_ON;
		}

	} 

	
	public function setUpdatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::UPDATED_BY;
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
			$this->modifiedColumns[] = MlmDistributorPeer::UPDATED_ON;
		}

	} 

	
	public function setPackagePurchaseFlag($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->package_purchase_flag !== $v || $v === '') {
			$this->package_purchase_flag = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::PACKAGE_PURCHASE_FLAG;
		}

	} 

	
	public function setFileBankPassBook($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_bank_pass_book !== $v) {
			$this->file_bank_pass_book = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::FILE_BANK_PASS_BOOK;
		}

	} 

	
	public function setFileProofOfResidence($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_proof_of_residence !== $v) {
			$this->file_proof_of_residence = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE;
		}

	} 

	
	public function setFileNric($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file_nric !== $v) {
			$this->file_nric = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::FILE_NRIC;
		}

	} 

	
	public function setExcludedStructure($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->excluded_structure !== $v || $v === '') {
			$this->excluded_structure = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::EXCLUDED_STRUCTURE;
		}

	} 

	
	public function setProductMte($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->product_mte !== $v || $v === '') {
			$this->product_mte = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::PRODUCT_MTE;
		}

	} 

	
	public function setProductFxgold($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->product_fxgold !== $v || $v === '') {
			$this->product_fxgold = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::PRODUCT_FXGOLD;
		}

	} 

	
	public function setRemark($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark !== $v) {
			$this->remark = $v;
			$this->modifiedColumns[] = MlmDistributorPeer::REMARK;
		}

	} 

	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->distributor_id = $rs->getInt($startcol + 0);

			$this->distributor_code = $rs->getString($startcol + 1);

			$this->user_id = $rs->getInt($startcol + 2);

			$this->status_code = $rs->getString($startcol + 3);

			$this->full_name = $rs->getString($startcol + 4);

			$this->nickname = $rs->getString($startcol + 5);

			$this->ic = $rs->getString($startcol + 6);

			$this->country = $rs->getString($startcol + 7);

			$this->address = $rs->getString($startcol + 8);

			$this->address2 = $rs->getString($startcol + 9);

			$this->city = $rs->getString($startcol + 10);

			$this->state = $rs->getString($startcol + 11);

			$this->postcode = $rs->getString($startcol + 12);

			$this->email = $rs->getString($startcol + 13);

			$this->alternate_email = $rs->getString($startcol + 14);

			$this->contact = $rs->getString($startcol + 15);

			$this->gender = $rs->getString($startcol + 16);

			$this->dob = $rs->getDate($startcol + 17, null);

			$this->bank_name = $rs->getString($startcol + 18);

			$this->bank_acc_no = $rs->getString($startcol + 19);

			$this->bank_holder_name = $rs->getString($startcol + 20);

			$this->bank_swift_code = $rs->getString($startcol + 21);

			$this->visa_debit_card = $rs->getString($startcol + 22);

			$this->tree_level = $rs->getInt($startcol + 23);

			$this->tree_structure = $rs->getString($startcol + 24);

			$this->placement_tree_level = $rs->getInt($startcol + 25);

			$this->placement_tree_structure = $rs->getString($startcol + 26);

			$this->init_rank_id = $rs->getInt($startcol + 27);

			$this->init_rank_code = $rs->getString($startcol + 28);

			$this->upline_dist_id = $rs->getInt($startcol + 29);

			$this->upline_dist_code = $rs->getString($startcol + 30);

			$this->tree_upline_dist_id = $rs->getInt($startcol + 31);

			$this->tree_upline_dist_code = $rs->getString($startcol + 32);

			$this->total_left = $rs->getInt($startcol + 33);

			$this->total_right = $rs->getInt($startcol + 34);

			$this->placement_position = $rs->getString($startcol + 35);

			$this->placement_datetime = $rs->getTimestamp($startcol + 36, null);

			$this->rank_id = $rs->getInt($startcol + 37);

			$this->rank_code = $rs->getString($startcol + 38);

			$this->active_datetime = $rs->getTimestamp($startcol + 39, null);

			$this->activated_by = $rs->getInt($startcol + 40);

			$this->leverage = $rs->getString($startcol + 41);

			$this->spread = $rs->getString($startcol + 42);

			$this->deposit_currency = $rs->getString($startcol + 43);

			$this->deposit_amount = $rs->getString($startcol + 44);

			$this->sign_name = $rs->getString($startcol + 45);

			$this->sign_date = $rs->getTimestamp($startcol + 46, null);

			$this->term_condition = $rs->getInt($startcol + 47);

			$this->ib_commission = $rs->getFloat($startcol + 48);

			$this->is_ib = $rs->getString($startcol + 49);

			$this->created_by = $rs->getInt($startcol + 50);

			$this->created_on = $rs->getTimestamp($startcol + 51, null);

			$this->updated_by = $rs->getInt($startcol + 52);

			$this->updated_on = $rs->getTimestamp($startcol + 53, null);

			$this->package_purchase_flag = $rs->getString($startcol + 54);

			$this->file_bank_pass_book = $rs->getString($startcol + 55);

			$this->file_proof_of_residence = $rs->getString($startcol + 56);

			$this->file_nric = $rs->getString($startcol + 57);

			$this->excluded_structure = $rs->getString($startcol + 58);

			$this->product_mte = $rs->getString($startcol + 59);

			$this->product_fxgold = $rs->getString($startcol + 60);

			$this->remark = $rs->getString($startcol + 61);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 62; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MlmDistributor object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MlmDistributorPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MlmDistributorPeer::CREATED_ON))
    {
      $this->setCreatedOn(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MlmDistributorPeer::UPDATED_ON))
    {
      $this->setUpdatedOn(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
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
					$pk = MlmDistributorPeer::doInsert($this, $con);
					$affectedRows += 1; 
										 
										 

					$this->setDistributorId($pk);  

					$this->setNew(false);
				} else {
					$affectedRows += MlmDistributorPeer::doUpdate($this, $con);
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


			if (($retval = MlmDistributorPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmDistributorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getDistributorId();
				break;
			case 1:
				return $this->getDistributorCode();
				break;
			case 2:
				return $this->getUserId();
				break;
			case 3:
				return $this->getStatusCode();
				break;
			case 4:
				return $this->getFullName();
				break;
			case 5:
				return $this->getNickname();
				break;
			case 6:
				return $this->getIc();
				break;
			case 7:
				return $this->getCountry();
				break;
			case 8:
				return $this->getAddress();
				break;
			case 9:
				return $this->getAddress2();
				break;
			case 10:
				return $this->getCity();
				break;
			case 11:
				return $this->getState();
				break;
			case 12:
				return $this->getPostcode();
				break;
			case 13:
				return $this->getEmail();
				break;
			case 14:
				return $this->getAlternateEmail();
				break;
			case 15:
				return $this->getContact();
				break;
			case 16:
				return $this->getGender();
				break;
			case 17:
				return $this->getDob();
				break;
			case 18:
				return $this->getBankName();
				break;
			case 19:
				return $this->getBankAccNo();
				break;
			case 20:
				return $this->getBankHolderName();
				break;
			case 21:
				return $this->getBankSwiftCode();
				break;
			case 22:
				return $this->getVisaDebitCard();
				break;
			case 23:
				return $this->getTreeLevel();
				break;
			case 24:
				return $this->getTreeStructure();
				break;
			case 25:
				return $this->getPlacementTreeLevel();
				break;
			case 26:
				return $this->getPlacementTreeStructure();
				break;
			case 27:
				return $this->getInitRankId();
				break;
			case 28:
				return $this->getInitRankCode();
				break;
			case 29:
				return $this->getUplineDistId();
				break;
			case 30:
				return $this->getUplineDistCode();
				break;
			case 31:
				return $this->getTreeUplineDistId();
				break;
			case 32:
				return $this->getTreeUplineDistCode();
				break;
			case 33:
				return $this->getTotalLeft();
				break;
			case 34:
				return $this->getTotalRight();
				break;
			case 35:
				return $this->getPlacementPosition();
				break;
			case 36:
				return $this->getPlacementDatetime();
				break;
			case 37:
				return $this->getRankId();
				break;
			case 38:
				return $this->getRankCode();
				break;
			case 39:
				return $this->getActiveDatetime();
				break;
			case 40:
				return $this->getActivatedBy();
				break;
			case 41:
				return $this->getLeverage();
				break;
			case 42:
				return $this->getSpread();
				break;
			case 43:
				return $this->getDepositCurrency();
				break;
			case 44:
				return $this->getDepositAmount();
				break;
			case 45:
				return $this->getSignName();
				break;
			case 46:
				return $this->getSignDate();
				break;
			case 47:
				return $this->getTermCondition();
				break;
			case 48:
				return $this->getIbCommission();
				break;
			case 49:
				return $this->getIsIb();
				break;
			case 50:
				return $this->getCreatedBy();
				break;
			case 51:
				return $this->getCreatedOn();
				break;
			case 52:
				return $this->getUpdatedBy();
				break;
			case 53:
				return $this->getUpdatedOn();
				break;
			case 54:
				return $this->getPackagePurchaseFlag();
				break;
			case 55:
				return $this->getFileBankPassBook();
				break;
			case 56:
				return $this->getFileProofOfResidence();
				break;
			case 57:
				return $this->getFileNric();
				break;
			case 58:
				return $this->getExcludedStructure();
				break;
			case 59:
				return $this->getProductMte();
				break;
			case 60:
				return $this->getProductFxgold();
				break;
			case 61:
				return $this->getRemark();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmDistributorPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getDistributorId(),
			$keys[1] => $this->getDistributorCode(),
			$keys[2] => $this->getUserId(),
			$keys[3] => $this->getStatusCode(),
			$keys[4] => $this->getFullName(),
			$keys[5] => $this->getNickname(),
			$keys[6] => $this->getIc(),
			$keys[7] => $this->getCountry(),
			$keys[8] => $this->getAddress(),
			$keys[9] => $this->getAddress2(),
			$keys[10] => $this->getCity(),
			$keys[11] => $this->getState(),
			$keys[12] => $this->getPostcode(),
			$keys[13] => $this->getEmail(),
			$keys[14] => $this->getAlternateEmail(),
			$keys[15] => $this->getContact(),
			$keys[16] => $this->getGender(),
			$keys[17] => $this->getDob(),
			$keys[18] => $this->getBankName(),
			$keys[19] => $this->getBankAccNo(),
			$keys[20] => $this->getBankHolderName(),
			$keys[21] => $this->getBankSwiftCode(),
			$keys[22] => $this->getVisaDebitCard(),
			$keys[23] => $this->getTreeLevel(),
			$keys[24] => $this->getTreeStructure(),
			$keys[25] => $this->getPlacementTreeLevel(),
			$keys[26] => $this->getPlacementTreeStructure(),
			$keys[27] => $this->getInitRankId(),
			$keys[28] => $this->getInitRankCode(),
			$keys[29] => $this->getUplineDistId(),
			$keys[30] => $this->getUplineDistCode(),
			$keys[31] => $this->getTreeUplineDistId(),
			$keys[32] => $this->getTreeUplineDistCode(),
			$keys[33] => $this->getTotalLeft(),
			$keys[34] => $this->getTotalRight(),
			$keys[35] => $this->getPlacementPosition(),
			$keys[36] => $this->getPlacementDatetime(),
			$keys[37] => $this->getRankId(),
			$keys[38] => $this->getRankCode(),
			$keys[39] => $this->getActiveDatetime(),
			$keys[40] => $this->getActivatedBy(),
			$keys[41] => $this->getLeverage(),
			$keys[42] => $this->getSpread(),
			$keys[43] => $this->getDepositCurrency(),
			$keys[44] => $this->getDepositAmount(),
			$keys[45] => $this->getSignName(),
			$keys[46] => $this->getSignDate(),
			$keys[47] => $this->getTermCondition(),
			$keys[48] => $this->getIbCommission(),
			$keys[49] => $this->getIsIb(),
			$keys[50] => $this->getCreatedBy(),
			$keys[51] => $this->getCreatedOn(),
			$keys[52] => $this->getUpdatedBy(),
			$keys[53] => $this->getUpdatedOn(),
			$keys[54] => $this->getPackagePurchaseFlag(),
			$keys[55] => $this->getFileBankPassBook(),
			$keys[56] => $this->getFileProofOfResidence(),
			$keys[57] => $this->getFileNric(),
			$keys[58] => $this->getExcludedStructure(),
			$keys[59] => $this->getProductMte(),
			$keys[60] => $this->getProductFxgold(),
			$keys[61] => $this->getRemark(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MlmDistributorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setDistributorId($value);
				break;
			case 1:
				$this->setDistributorCode($value);
				break;
			case 2:
				$this->setUserId($value);
				break;
			case 3:
				$this->setStatusCode($value);
				break;
			case 4:
				$this->setFullName($value);
				break;
			case 5:
				$this->setNickname($value);
				break;
			case 6:
				$this->setIc($value);
				break;
			case 7:
				$this->setCountry($value);
				break;
			case 8:
				$this->setAddress($value);
				break;
			case 9:
				$this->setAddress2($value);
				break;
			case 10:
				$this->setCity($value);
				break;
			case 11:
				$this->setState($value);
				break;
			case 12:
				$this->setPostcode($value);
				break;
			case 13:
				$this->setEmail($value);
				break;
			case 14:
				$this->setAlternateEmail($value);
				break;
			case 15:
				$this->setContact($value);
				break;
			case 16:
				$this->setGender($value);
				break;
			case 17:
				$this->setDob($value);
				break;
			case 18:
				$this->setBankName($value);
				break;
			case 19:
				$this->setBankAccNo($value);
				break;
			case 20:
				$this->setBankHolderName($value);
				break;
			case 21:
				$this->setBankSwiftCode($value);
				break;
			case 22:
				$this->setVisaDebitCard($value);
				break;
			case 23:
				$this->setTreeLevel($value);
				break;
			case 24:
				$this->setTreeStructure($value);
				break;
			case 25:
				$this->setPlacementTreeLevel($value);
				break;
			case 26:
				$this->setPlacementTreeStructure($value);
				break;
			case 27:
				$this->setInitRankId($value);
				break;
			case 28:
				$this->setInitRankCode($value);
				break;
			case 29:
				$this->setUplineDistId($value);
				break;
			case 30:
				$this->setUplineDistCode($value);
				break;
			case 31:
				$this->setTreeUplineDistId($value);
				break;
			case 32:
				$this->setTreeUplineDistCode($value);
				break;
			case 33:
				$this->setTotalLeft($value);
				break;
			case 34:
				$this->setTotalRight($value);
				break;
			case 35:
				$this->setPlacementPosition($value);
				break;
			case 36:
				$this->setPlacementDatetime($value);
				break;
			case 37:
				$this->setRankId($value);
				break;
			case 38:
				$this->setRankCode($value);
				break;
			case 39:
				$this->setActiveDatetime($value);
				break;
			case 40:
				$this->setActivatedBy($value);
				break;
			case 41:
				$this->setLeverage($value);
				break;
			case 42:
				$this->setSpread($value);
				break;
			case 43:
				$this->setDepositCurrency($value);
				break;
			case 44:
				$this->setDepositAmount($value);
				break;
			case 45:
				$this->setSignName($value);
				break;
			case 46:
				$this->setSignDate($value);
				break;
			case 47:
				$this->setTermCondition($value);
				break;
			case 48:
				$this->setIbCommission($value);
				break;
			case 49:
				$this->setIsIb($value);
				break;
			case 50:
				$this->setCreatedBy($value);
				break;
			case 51:
				$this->setCreatedOn($value);
				break;
			case 52:
				$this->setUpdatedBy($value);
				break;
			case 53:
				$this->setUpdatedOn($value);
				break;
			case 54:
				$this->setPackagePurchaseFlag($value);
				break;
			case 55:
				$this->setFileBankPassBook($value);
				break;
			case 56:
				$this->setFileProofOfResidence($value);
				break;
			case 57:
				$this->setFileNric($value);
				break;
			case 58:
				$this->setExcludedStructure($value);
				break;
			case 59:
				$this->setProductMte($value);
				break;
			case 60:
				$this->setProductFxgold($value);
				break;
			case 61:
				$this->setRemark($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MlmDistributorPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setDistributorId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDistributorCode($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setStatusCode($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFullName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setNickname($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIc($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCountry($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAddress($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setAddress2($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCity($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setState($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPostcode($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setEmail($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setAlternateEmail($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setContact($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setGender($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setDob($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setBankName($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setBankAccNo($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setBankHolderName($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setBankSwiftCode($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setVisaDebitCard($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setTreeLevel($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setTreeStructure($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setPlacementTreeLevel($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setPlacementTreeStructure($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setInitRankId($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setInitRankCode($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setUplineDistId($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setUplineDistCode($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setTreeUplineDistId($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setTreeUplineDistCode($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setTotalLeft($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setTotalRight($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setPlacementPosition($arr[$keys[35]]);
		if (array_key_exists($keys[36], $arr)) $this->setPlacementDatetime($arr[$keys[36]]);
		if (array_key_exists($keys[37], $arr)) $this->setRankId($arr[$keys[37]]);
		if (array_key_exists($keys[38], $arr)) $this->setRankCode($arr[$keys[38]]);
		if (array_key_exists($keys[39], $arr)) $this->setActiveDatetime($arr[$keys[39]]);
		if (array_key_exists($keys[40], $arr)) $this->setActivatedBy($arr[$keys[40]]);
		if (array_key_exists($keys[41], $arr)) $this->setLeverage($arr[$keys[41]]);
		if (array_key_exists($keys[42], $arr)) $this->setSpread($arr[$keys[42]]);
		if (array_key_exists($keys[43], $arr)) $this->setDepositCurrency($arr[$keys[43]]);
		if (array_key_exists($keys[44], $arr)) $this->setDepositAmount($arr[$keys[44]]);
		if (array_key_exists($keys[45], $arr)) $this->setSignName($arr[$keys[45]]);
		if (array_key_exists($keys[46], $arr)) $this->setSignDate($arr[$keys[46]]);
		if (array_key_exists($keys[47], $arr)) $this->setTermCondition($arr[$keys[47]]);
		if (array_key_exists($keys[48], $arr)) $this->setIbCommission($arr[$keys[48]]);
		if (array_key_exists($keys[49], $arr)) $this->setIsIb($arr[$keys[49]]);
		if (array_key_exists($keys[50], $arr)) $this->setCreatedBy($arr[$keys[50]]);
		if (array_key_exists($keys[51], $arr)) $this->setCreatedOn($arr[$keys[51]]);
		if (array_key_exists($keys[52], $arr)) $this->setUpdatedBy($arr[$keys[52]]);
		if (array_key_exists($keys[53], $arr)) $this->setUpdatedOn($arr[$keys[53]]);
		if (array_key_exists($keys[54], $arr)) $this->setPackagePurchaseFlag($arr[$keys[54]]);
		if (array_key_exists($keys[55], $arr)) $this->setFileBankPassBook($arr[$keys[55]]);
		if (array_key_exists($keys[56], $arr)) $this->setFileProofOfResidence($arr[$keys[56]]);
		if (array_key_exists($keys[57], $arr)) $this->setFileNric($arr[$keys[57]]);
		if (array_key_exists($keys[58], $arr)) $this->setExcludedStructure($arr[$keys[58]]);
		if (array_key_exists($keys[59], $arr)) $this->setProductMte($arr[$keys[59]]);
		if (array_key_exists($keys[60], $arr)) $this->setProductFxgold($arr[$keys[60]]);
		if (array_key_exists($keys[61], $arr)) $this->setRemark($arr[$keys[61]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MlmDistributorPeer::DATABASE_NAME);

		if ($this->isColumnModified(MlmDistributorPeer::DISTRIBUTOR_ID)) $criteria->add(MlmDistributorPeer::DISTRIBUTOR_ID, $this->distributor_id);
		if ($this->isColumnModified(MlmDistributorPeer::DISTRIBUTOR_CODE)) $criteria->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->distributor_code);
		if ($this->isColumnModified(MlmDistributorPeer::USER_ID)) $criteria->add(MlmDistributorPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(MlmDistributorPeer::STATUS_CODE)) $criteria->add(MlmDistributorPeer::STATUS_CODE, $this->status_code);
		if ($this->isColumnModified(MlmDistributorPeer::FULL_NAME)) $criteria->add(MlmDistributorPeer::FULL_NAME, $this->full_name);
		if ($this->isColumnModified(MlmDistributorPeer::NICKNAME)) $criteria->add(MlmDistributorPeer::NICKNAME, $this->nickname);
		if ($this->isColumnModified(MlmDistributorPeer::IC)) $criteria->add(MlmDistributorPeer::IC, $this->ic);
		if ($this->isColumnModified(MlmDistributorPeer::COUNTRY)) $criteria->add(MlmDistributorPeer::COUNTRY, $this->country);
		if ($this->isColumnModified(MlmDistributorPeer::ADDRESS)) $criteria->add(MlmDistributorPeer::ADDRESS, $this->address);
		if ($this->isColumnModified(MlmDistributorPeer::ADDRESS2)) $criteria->add(MlmDistributorPeer::ADDRESS2, $this->address2);
		if ($this->isColumnModified(MlmDistributorPeer::CITY)) $criteria->add(MlmDistributorPeer::CITY, $this->city);
		if ($this->isColumnModified(MlmDistributorPeer::STATE)) $criteria->add(MlmDistributorPeer::STATE, $this->state);
		if ($this->isColumnModified(MlmDistributorPeer::POSTCODE)) $criteria->add(MlmDistributorPeer::POSTCODE, $this->postcode);
		if ($this->isColumnModified(MlmDistributorPeer::EMAIL)) $criteria->add(MlmDistributorPeer::EMAIL, $this->email);
		if ($this->isColumnModified(MlmDistributorPeer::ALTERNATE_EMAIL)) $criteria->add(MlmDistributorPeer::ALTERNATE_EMAIL, $this->alternate_email);
		if ($this->isColumnModified(MlmDistributorPeer::CONTACT)) $criteria->add(MlmDistributorPeer::CONTACT, $this->contact);
		if ($this->isColumnModified(MlmDistributorPeer::GENDER)) $criteria->add(MlmDistributorPeer::GENDER, $this->gender);
		if ($this->isColumnModified(MlmDistributorPeer::DOB)) $criteria->add(MlmDistributorPeer::DOB, $this->dob);
		if ($this->isColumnModified(MlmDistributorPeer::BANK_NAME)) $criteria->add(MlmDistributorPeer::BANK_NAME, $this->bank_name);
		if ($this->isColumnModified(MlmDistributorPeer::BANK_ACC_NO)) $criteria->add(MlmDistributorPeer::BANK_ACC_NO, $this->bank_acc_no);
		if ($this->isColumnModified(MlmDistributorPeer::BANK_HOLDER_NAME)) $criteria->add(MlmDistributorPeer::BANK_HOLDER_NAME, $this->bank_holder_name);
		if ($this->isColumnModified(MlmDistributorPeer::BANK_SWIFT_CODE)) $criteria->add(MlmDistributorPeer::BANK_SWIFT_CODE, $this->bank_swift_code);
		if ($this->isColumnModified(MlmDistributorPeer::VISA_DEBIT_CARD)) $criteria->add(MlmDistributorPeer::VISA_DEBIT_CARD, $this->visa_debit_card);
		if ($this->isColumnModified(MlmDistributorPeer::TREE_LEVEL)) $criteria->add(MlmDistributorPeer::TREE_LEVEL, $this->tree_level);
		if ($this->isColumnModified(MlmDistributorPeer::TREE_STRUCTURE)) $criteria->add(MlmDistributorPeer::TREE_STRUCTURE, $this->tree_structure);
		if ($this->isColumnModified(MlmDistributorPeer::PLACEMENT_TREE_LEVEL)) $criteria->add(MlmDistributorPeer::PLACEMENT_TREE_LEVEL, $this->placement_tree_level);
		if ($this->isColumnModified(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE)) $criteria->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, $this->placement_tree_structure);
		if ($this->isColumnModified(MlmDistributorPeer::INIT_RANK_ID)) $criteria->add(MlmDistributorPeer::INIT_RANK_ID, $this->init_rank_id);
		if ($this->isColumnModified(MlmDistributorPeer::INIT_RANK_CODE)) $criteria->add(MlmDistributorPeer::INIT_RANK_CODE, $this->init_rank_code);
		if ($this->isColumnModified(MlmDistributorPeer::UPLINE_DIST_ID)) $criteria->add(MlmDistributorPeer::UPLINE_DIST_ID, $this->upline_dist_id);
		if ($this->isColumnModified(MlmDistributorPeer::UPLINE_DIST_CODE)) $criteria->add(MlmDistributorPeer::UPLINE_DIST_CODE, $this->upline_dist_code);
		if ($this->isColumnModified(MlmDistributorPeer::TREE_UPLINE_DIST_ID)) $criteria->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, $this->tree_upline_dist_id);
		if ($this->isColumnModified(MlmDistributorPeer::TREE_UPLINE_DIST_CODE)) $criteria->add(MlmDistributorPeer::TREE_UPLINE_DIST_CODE, $this->tree_upline_dist_code);
		if ($this->isColumnModified(MlmDistributorPeer::TOTAL_LEFT)) $criteria->add(MlmDistributorPeer::TOTAL_LEFT, $this->total_left);
		if ($this->isColumnModified(MlmDistributorPeer::TOTAL_RIGHT)) $criteria->add(MlmDistributorPeer::TOTAL_RIGHT, $this->total_right);
		if ($this->isColumnModified(MlmDistributorPeer::PLACEMENT_POSITION)) $criteria->add(MlmDistributorPeer::PLACEMENT_POSITION, $this->placement_position);
		if ($this->isColumnModified(MlmDistributorPeer::PLACEMENT_DATETIME)) $criteria->add(MlmDistributorPeer::PLACEMENT_DATETIME, $this->placement_datetime);
		if ($this->isColumnModified(MlmDistributorPeer::RANK_ID)) $criteria->add(MlmDistributorPeer::RANK_ID, $this->rank_id);
		if ($this->isColumnModified(MlmDistributorPeer::RANK_CODE)) $criteria->add(MlmDistributorPeer::RANK_CODE, $this->rank_code);
		if ($this->isColumnModified(MlmDistributorPeer::ACTIVE_DATETIME)) $criteria->add(MlmDistributorPeer::ACTIVE_DATETIME, $this->active_datetime);
		if ($this->isColumnModified(MlmDistributorPeer::ACTIVATED_BY)) $criteria->add(MlmDistributorPeer::ACTIVATED_BY, $this->activated_by);
		if ($this->isColumnModified(MlmDistributorPeer::LEVERAGE)) $criteria->add(MlmDistributorPeer::LEVERAGE, $this->leverage);
		if ($this->isColumnModified(MlmDistributorPeer::SPREAD)) $criteria->add(MlmDistributorPeer::SPREAD, $this->spread);
		if ($this->isColumnModified(MlmDistributorPeer::DEPOSIT_CURRENCY)) $criteria->add(MlmDistributorPeer::DEPOSIT_CURRENCY, $this->deposit_currency);
		if ($this->isColumnModified(MlmDistributorPeer::DEPOSIT_AMOUNT)) $criteria->add(MlmDistributorPeer::DEPOSIT_AMOUNT, $this->deposit_amount);
		if ($this->isColumnModified(MlmDistributorPeer::SIGN_NAME)) $criteria->add(MlmDistributorPeer::SIGN_NAME, $this->sign_name);
		if ($this->isColumnModified(MlmDistributorPeer::SIGN_DATE)) $criteria->add(MlmDistributorPeer::SIGN_DATE, $this->sign_date);
		if ($this->isColumnModified(MlmDistributorPeer::TERM_CONDITION)) $criteria->add(MlmDistributorPeer::TERM_CONDITION, $this->term_condition);
		if ($this->isColumnModified(MlmDistributorPeer::IB_COMMISSION)) $criteria->add(MlmDistributorPeer::IB_COMMISSION, $this->ib_commission);
		if ($this->isColumnModified(MlmDistributorPeer::IS_IB)) $criteria->add(MlmDistributorPeer::IS_IB, $this->is_ib);
		if ($this->isColumnModified(MlmDistributorPeer::CREATED_BY)) $criteria->add(MlmDistributorPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(MlmDistributorPeer::CREATED_ON)) $criteria->add(MlmDistributorPeer::CREATED_ON, $this->created_on);
		if ($this->isColumnModified(MlmDistributorPeer::UPDATED_BY)) $criteria->add(MlmDistributorPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(MlmDistributorPeer::UPDATED_ON)) $criteria->add(MlmDistributorPeer::UPDATED_ON, $this->updated_on);
		if ($this->isColumnModified(MlmDistributorPeer::PACKAGE_PURCHASE_FLAG)) $criteria->add(MlmDistributorPeer::PACKAGE_PURCHASE_FLAG, $this->package_purchase_flag);
		if ($this->isColumnModified(MlmDistributorPeer::FILE_BANK_PASS_BOOK)) $criteria->add(MlmDistributorPeer::FILE_BANK_PASS_BOOK, $this->file_bank_pass_book);
		if ($this->isColumnModified(MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE)) $criteria->add(MlmDistributorPeer::FILE_PROOF_OF_RESIDENCE, $this->file_proof_of_residence);
		if ($this->isColumnModified(MlmDistributorPeer::FILE_NRIC)) $criteria->add(MlmDistributorPeer::FILE_NRIC, $this->file_nric);
		if ($this->isColumnModified(MlmDistributorPeer::EXCLUDED_STRUCTURE)) $criteria->add(MlmDistributorPeer::EXCLUDED_STRUCTURE, $this->excluded_structure);
		if ($this->isColumnModified(MlmDistributorPeer::PRODUCT_MTE)) $criteria->add(MlmDistributorPeer::PRODUCT_MTE, $this->product_mte);
		if ($this->isColumnModified(MlmDistributorPeer::PRODUCT_FXGOLD)) $criteria->add(MlmDistributorPeer::PRODUCT_FXGOLD, $this->product_fxgold);
		if ($this->isColumnModified(MlmDistributorPeer::REMARK)) $criteria->add(MlmDistributorPeer::REMARK, $this->remark);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MlmDistributorPeer::DATABASE_NAME);

		$criteria->add(MlmDistributorPeer::DISTRIBUTOR_ID, $this->distributor_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getDistributorId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setDistributorId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDistributorCode($this->distributor_code);

		$copyObj->setUserId($this->user_id);

		$copyObj->setStatusCode($this->status_code);

		$copyObj->setFullName($this->full_name);

		$copyObj->setNickname($this->nickname);

		$copyObj->setIc($this->ic);

		$copyObj->setCountry($this->country);

		$copyObj->setAddress($this->address);

		$copyObj->setAddress2($this->address2);

		$copyObj->setCity($this->city);

		$copyObj->setState($this->state);

		$copyObj->setPostcode($this->postcode);

		$copyObj->setEmail($this->email);

		$copyObj->setAlternateEmail($this->alternate_email);

		$copyObj->setContact($this->contact);

		$copyObj->setGender($this->gender);

		$copyObj->setDob($this->dob);

		$copyObj->setBankName($this->bank_name);

		$copyObj->setBankAccNo($this->bank_acc_no);

		$copyObj->setBankHolderName($this->bank_holder_name);

		$copyObj->setBankSwiftCode($this->bank_swift_code);

		$copyObj->setVisaDebitCard($this->visa_debit_card);

		$copyObj->setTreeLevel($this->tree_level);

		$copyObj->setTreeStructure($this->tree_structure);

		$copyObj->setPlacementTreeLevel($this->placement_tree_level);

		$copyObj->setPlacementTreeStructure($this->placement_tree_structure);

		$copyObj->setInitRankId($this->init_rank_id);

		$copyObj->setInitRankCode($this->init_rank_code);

		$copyObj->setUplineDistId($this->upline_dist_id);

		$copyObj->setUplineDistCode($this->upline_dist_code);

		$copyObj->setTreeUplineDistId($this->tree_upline_dist_id);

		$copyObj->setTreeUplineDistCode($this->tree_upline_dist_code);

		$copyObj->setTotalLeft($this->total_left);

		$copyObj->setTotalRight($this->total_right);

		$copyObj->setPlacementPosition($this->placement_position);

		$copyObj->setPlacementDatetime($this->placement_datetime);

		$copyObj->setRankId($this->rank_id);

		$copyObj->setRankCode($this->rank_code);

		$copyObj->setActiveDatetime($this->active_datetime);

		$copyObj->setActivatedBy($this->activated_by);

		$copyObj->setLeverage($this->leverage);

		$copyObj->setSpread($this->spread);

		$copyObj->setDepositCurrency($this->deposit_currency);

		$copyObj->setDepositAmount($this->deposit_amount);

		$copyObj->setSignName($this->sign_name);

		$copyObj->setSignDate($this->sign_date);

		$copyObj->setTermCondition($this->term_condition);

		$copyObj->setIbCommission($this->ib_commission);

		$copyObj->setIsIb($this->is_ib);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedOn($this->created_on);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedOn($this->updated_on);

		$copyObj->setPackagePurchaseFlag($this->package_purchase_flag);

		$copyObj->setFileBankPassBook($this->file_bank_pass_book);

		$copyObj->setFileProofOfResidence($this->file_proof_of_residence);

		$copyObj->setFileNric($this->file_nric);

		$copyObj->setExcludedStructure($this->excluded_structure);

		$copyObj->setProductMte($this->product_mte);

		$copyObj->setProductFxgold($this->product_fxgold);

		$copyObj->setRemark($this->remark);


		$copyObj->setNew(true);

		$copyObj->setDistributorId(NULL); 

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
			self::$peer = new MlmDistributorPeer();
		}
		return self::$peer;
	}

} 