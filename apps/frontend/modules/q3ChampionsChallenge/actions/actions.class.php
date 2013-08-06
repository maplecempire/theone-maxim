<?php

/**
 * q3ChampionsChallenge actions.
 *
 * @package    sf_sandbox
 * @subpackage q3ChampionsChallenge
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class q3ChampionsChallengeActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->isChallenge = "N";
        if ($distDB->getQ3Champions() == "Y") {
            $this->isChallenge = "Y";
        }
    }

    public function executeSubmit() {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB->getQ3Champions() != "Y") {
            $distDB->setQ3Champions("Y");
            $distDB->setQ3Datetime(date("Y/m/d h:i:s A"));
            $distDB->save();
        }
        $this->setFlash('successMsg', "Submit successfully");
        return $this->redirect('q3ChampionsChallenge/index');
    }
}
