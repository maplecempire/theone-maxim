<?php

class componentComponents extends sfComponents
{
    public function executeMultiLanguage()
    {

    }
    public function executeFooterInformation()
    {

    }
    public function executeHomeLeftMenu()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->param);

        $this->distDB = $distDB;
        $this->showLink = $this->showLink;
    }
    public function executeCountrySelectOption()
    {
        $this->countrySelected = $this->countrySelected;
        $this->countryName = $this->countryName;
        $this->countryId = $this->countryId;
    }
    public function executeSubmenu()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->param);

        if ($distDB) {
            $openTermCondition = true;
            if ($distDB->getTermCondition() != null && $distDB->getTermCondition() == Globals::YES)
                $openTermCondition = false;

            $c = new Criteria();
            $c->add(MlmCustomerEnquiryPeer::DISTRIBUTOR_ID, $this->param);
            $c->add(MlmCustomerEnquiryPeer::DISTRIBUTOR_READ, Globals::FALSE);
            $totalUnreadCsMessage = MlmCustomerEnquiryPeer::doCount($c);

            $rp = $this->getAccountBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_RP);
            //$debitAccount = $this->getAccountBalance($distDB->getDistributorId(), Globals::ACCOUNT_TYPE_DEBIT);
            //$this->rp = $rp - $debitAccount;
            $this->rp = $rp;

            $this->distDB = $distDB;
            $this->openTermCondition = $openTermCondition;
            $this->totalUnreadCsMessage = $totalUnreadCsMessage;
        }
    }
    public function executeHeaderInformation()
    {
        $array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(MlmDistributorPeer::STATUS_CODE, $array, Criteria::IN);
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $this->param);
        $componentDistributor = MlmDistributorPeer::doSelectOne($c);

        $ecash = 0;
        $epoint = 0;
        $totalNetworks = 0;
        $ranking = "";
        $mt4Id = "";
        $currencyCode = "";

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SYSTEM_CURRENCY);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $currencyCode = $settingDB->getSettingValue();
        }
        if ($componentDistributor) {
            $existUser = AppUserPeer::retrieveByPK($componentDistributor->getUserId());

            if ($existUser) {
                $lastLogin = $existUser->getLastLoginDatetime();
            }

            $this->componentDistributor = $componentDistributor;
            $ranking = $componentDistributor->getRankCode();

            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $this->param);
            $distMt4s = MlmDistMt4Peer::doSelect($c);

            foreach ($distMt4s as $distMt4) {
                if ($mt4Id != "")
                    $mt4Id .= ",";
                $mt4Id .= $distMt4->getMt4UserName();
            }

            $c = new Criteria();
            $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
            $c->add(MlmAccountPeer::DIST_ID, $componentDistributor->getDistributorId());
            $account = MlmAccountPeer::doSelectOne($c);

            if ($account) {
                $ecash = $account->getBalance();
            } else {
                $account = new MlmAccount();
                $account->setDistId($componentDistributor->getDistributorId());
                $account->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $account->setBalance(0);
                $account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $account->save();
            }

            $c = new Criteria();
            $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
            $c->add(MlmAccountPeer::DIST_ID, $componentDistributor->getDistributorId());
            $account = MlmAccountPeer::doSelectOne($c);

            if ($account) {
                $epoint = $account->getBalance();
            } else {
                $account = new MlmAccount();
                $account->setDistId($componentDistributor->getDistributorId());
                $account->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $account->setBalance(0);
                $account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $account->save();
            }

            $c = new Criteria();
            $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%|".$componentDistributor->getDistributorId()."|%", Criteria::LIKE);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $totalNetworks = MlmDistributorPeer::doCount($c);
        } else {
            $componentDistributor = new MlmDistributor();
        }
        $this->ecash = $ecash;
        $this->epoint = $epoint;
        $this->totalNetworks = $totalNetworks;
        $this->componentDistributor = $componentDistributor;
        $this->ranking = $ranking;
        $this->mt4Id = $mt4Id;
        $this->currencyCode = $currencyCode;
    }

    function getAccountBalance($distributorId, $accountType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_account_ledger WHERE dist_id = " . $distributorId . " AND account_type = '" . $accountType . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            if ($arr["SUB_TOTAL"] != null) {
                return $arr["SUB_TOTAL"];
            } else {
                return 0;
            }
        }
        return 0;
    }
}