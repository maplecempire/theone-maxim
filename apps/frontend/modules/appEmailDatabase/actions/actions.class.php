<?php
// auto-generated by sfPropelCrud
// date: 2013/12/31 10:47:22
?>
<?php

/**
 * appEmailDatabase actions.
 *
 * @package    sf_sandbox
 * @subpackage appEmailDatabase
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class appEmailDatabaseActions extends sfActions
{
    public function executeSaveEmailDatabase()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::EMAIL_STATUS, 'SENT');
        $distributorDBs = MlmDistributorPeer::doSelect($c);

        $totalRecord = count($distributorDBs);
        foreach ($distributorDBs as $distributorDB) {
            print_r($totalRecord--."<br>");
            $app_email_database = new AppEmailDatabase();
            $app_email_database->setEmail($distributorDB->getEmail());
            $app_email_database->setStatusCode("ACTIVE");
            $app_email_database->setRemark($this->getRequestParameter('remark',''));
            $app_email_database->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $app_email_database->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $app_email_database->save();
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeIndex()
    {
        return $this->forward('appEmailDatabase', 'list');
    }

    public function executeList()
    {
        $this->app_email_databases = AppEmailDatabasePeer::doSelect(new Criteria());
    }

    public function executeShow()
    {
        $this->app_email_database = AppEmailDatabasePeer::retrieveByPk($this->getRequestParameter('email_id'));
        $this->forward404Unless($this->app_email_database);
    }

    public function executeCreate()
    {
        $this->app_email_database = new AppEmailDatabase();

        $this->setTemplate('edit');
    }

    public function executeEdit()
    {
        $this->app_email_database = AppEmailDatabasePeer::retrieveByPk($this->getRequestParameter('email_id'));
        $this->forward404Unless($this->app_email_database);
    }

    public function executeUpdate()
    {
        if (!$this->getRequestParameter('email_id')) {
            $app_email_database = new AppEmailDatabase();
        }
        else
        {
            $app_email_database = AppEmailDatabasePeer::retrieveByPk($this->getRequestParameter('email_id'));
            $this->forward404Unless($app_email_database);
        }

        $app_email_database->setEmailId($this->getRequestParameter('email_id'));
        $app_email_database->setEmail($this->getRequestParameter('email'));
        $app_email_database->setStatusCode($this->getRequestParameter('status_code'));
        $app_email_database->setCreatedBy($this->getRequestParameter('created_by'));
        if ($this->getRequestParameter('created_on')) {
            list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('created_on'), $this->getUser()->getCulture());
            $app_email_database->setCreatedOn("$y-$m-$d");
        }
        $app_email_database->setUpdatedBy($this->getRequestParameter('updated_by'));
        if ($this->getRequestParameter('updated_on')) {
            list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('updated_on'), $this->getUser()->getCulture());
            $app_email_database->setUpdatedOn("$y-$m-$d");
        }
        $app_email_database->setRemark($this->getRequestParameter('remark'));

        $app_email_database->save();

        return $this->redirect('appEmailDatabase/show?email_id=' . $app_email_database->getEmailId());
    }

    public function executeDelete()
    {
        $app_email_database = AppEmailDatabasePeer::retrieveByPk($this->getRequestParameter('email_id'));

        $this->forward404Unless($app_email_database);

        $app_email_database->delete();

        return $this->redirect('appEmailDatabase/list');
    }
}