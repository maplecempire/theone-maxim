<?php

class componentComponents extends sfComponents
{
    public function executeCountrySelectOption()
    {
        $this->countrySelected = $this->countrySelected;
        $this->countryName = $this->countryName;
        $this->countryId = $this->countryId;
    }
    public function executeSubmenu()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->param);

        $openTermCondition = true;
        if ($distDB->getTermCondition() != null && $distDB->getTermCondition() == Globals::YES)
            $openTermCondition = false;

        $this->distDB = $distDB;
        $this->openTermCondition = $openTermCondition;
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
            $mt4Id = $componentDistributor->getMt4UserName();

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
                $account->save();
            }

            $c = new Criteria();
            $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%".$componentDistributor->getDistributorCode()."%", Criteria::LIKE);
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
}