<?php

class ValidatorLib
{

    private $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public static function init($action)
    {
        return new ValidatorLib($action);
    }

    public function isBankAccountDetailsUpdated($distributorDB, &$errorMsg = null)
    {

        if ($distributorDB->getBankAccNo() == "" || $distributorDB->getBankAccNo() == null
            || $distributorDB->getBankName() == "" || $distributorDB->getBankName() == null
            || $distributorDB->getBankBranchName() == "" || $distributorDB->getBankBranchName() == null
            || $distributorDB->getBankAddress() == "" || $distributorDB->getBankAddress() == null
            || $distributorDB->getBankHolderName() == "" || $distributorDB->getBankHolderName() == null
            || $distributorDB->getFileBankPassBook() == "" || $distributorDB->getFileBankPassBook() == null
            || $distributorDB->getFileNric() == "" || $distributorDB->getFileNric() == null
        ) {

            $errorMsg = 'You need to update all your Bank Account Details and upload Bank Account Proof, Proof of Residence and Passport/Photo ID';
        } elseif ($distributorDB->getBankCountry() <> "China (PRC)"
            && $distributorDB->getBankCountry() <> "Australia"
            && (trim(strtoupper($distributorDB->getBankHolderName())) <> trim(strtoupper($distributorDB->getFullName())))
        ) {

            $errorMsg = 'Bank Holder Name is not same as your full name';
        } elseif ($distributorDB->getBankCountry() == "Singapore"
            && $distributorDB->getBankCode() == ""
        ) {

            $errorMsg = 'Bank Code is required';
        } elseif ($distributorDB->getBankCountry() == "Taiwan"
            && ($this->isLatinWord($distributorDB->getBankName())
                || $this->isLatinWord($distributorDB->getBankBranchName())
                || $this->isLatinWord($distributorDB->getBankAddress())
                || $this->isLatinWord($distributorDB->getBankHolderName()))
        ) {

            $errorMsg = 'You need to update all your Bank Account Details must be latin word';
        } elseif (($distributorDB->getBankCountry() == "Korea North" || $distributorDB->getBankCountry() == "Korea South")
            && ($this->isLatinWord($distributorDB->getBankName())
                || $this->isLatinWord($distributorDB->getBankBranchName())
                || $this->isLatinWord($distributorDB->getBankAddress())
                || $this->isLatinWord($distributorDB->getBankHolderName()))
        ) {

            $errorMsg = 'Please ensure all your Bank Account Details is latin word';
        } elseif ($distributorDB->getBankCountry() == "China (PRC)"
            && (!$this->isLatinWord($distributorDB->getBankName())
                || !$this->isLatinWord($distributorDB->getBankBranchName())
                || !$this->isLatinWord($distributorDB->getBankAddress())
                || !$this->isLatinWord($distributorDB->getBankHolderName()))
        ) {

            $errorMsg = 'Please ensure all your Bank Account Details is chinese word';
        } elseif ($distributorDB->getVisaDebitCard() != ""
            && strlen($distributorDB->getVisaDebitCard()) != 16
        ) {

            $errorMsg = 'Maxim Trader VISA Debit Card must be 16 characters';
        }

        if ($errorMsg != null && strlen($errorMsg) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Special for member/cp2Withdrawal and member/cp3Withdrawal.
     * @param $distributorDB
     * @param null $errorMsg
     * @return bool
     */
    public function isBankAccountDetailsUpdated2($distributorDB, &$errorMsg = null)
    {
        $response = $this->isBankAccountDetailsUpdated($distributorDB, $errorMsg);

        if ($response !== true
            && $errorMsg == "Please ensure all your Bank Account Details is chinese word"
            && $distributorDB->getDistributorId() == 255828
        ) {

            // Exclusive for this distributor.
            $errorMsg = null;
            return true;
        }

        return $response;
    }

    public function isLatinWord($str)
    {
        return preg_match('/[^\\p{Common}\\p{Latin}]/u', $str) == 1;
    }
}