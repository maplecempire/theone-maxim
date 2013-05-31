<?php

/**
 * may2013_shanghai_fair_wheel_of_fortune actions.
 *
 * @package    sf_sandbox
 * @subpackage may2013_shanghai_fair_wheel_of_fortune
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class may2013_shanghai_fair_wheel_of_fortuneActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {

    }
    public function executeDoSubmit()
    {
        $wheel_of_fortune_registration = new WheelOfFortuneRegistration();
        $wheel_of_fortune_registration->setFullName($this->getRequestParameter('fullname'));
        $wheel_of_fortune_registration->setCountry($this->getRequestParameter('country'));
        $wheel_of_fortune_registration->setMobileNo($this->getRequestParameter('contactNumber'));
        $wheel_of_fortune_registration->setEmail($this->getRequestParameter('email'));
        $wheel_of_fortune_registration->setQq($this->getRequestParameter('qq'));
        $wheel_of_fortune_registration->setReferrer($this->getRequestParameter('referrer'));
        $wheel_of_fortune_registration->setLuckyDraw($this->getRequestParameter('luckyDraw'));
        $wheel_of_fortune_registration->setSerialNo($this->getRequestParameter('serialNo'));
        $wheel_of_fortune_registration->setStatusCode(Globals::STATUS_ACTIVE);
        $wheel_of_fortune_registration->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $wheel_of_fortune_registration->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $wheel_of_fortune_registration->save();
        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Submit successfully. Thank you."));

        return $this->redirect('/may2013_shanghai_fair_wheel_of_fortune/index');
    }
}
