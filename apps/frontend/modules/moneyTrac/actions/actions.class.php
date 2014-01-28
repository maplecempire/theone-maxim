<?php

/**
 * moneyTrac actions.
 *
 * @package    sf_sandbox
 * @subpackage moneyTrac
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class moneyTracActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
        return $this->redirect('member/createAccount');
    }

    public function executeCreateAccount()
    {

    }
}
