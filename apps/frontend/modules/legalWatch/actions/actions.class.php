<?php

/**
 * legalWatch actions.
 *
 * @package    sf_sandbox
 * @subpackage legalWatch
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class legalWatchActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeSuccessful()
    {
    }
    public function executeIndex()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        if (!$distDB) {
            return $this->redirect('/home/index');
        }

        $this->distDB = $distDB;
    }

    public function executeDoSubmit()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if (!$distDB) {
            return $this->redirect('/home/index');
        }
        $legal_watch = new LegalWatch();
        $legal_watch->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $legal_watch->setFullName($this->getRequestParameter('fullName'));
        $legal_watch->setDistCode($this->getUser()->getAttribute(Globals::SESSION_DISTCODE));
        $legal_watch->setAge($this->getRequestParameter('age'));
        $legal_watch->setEducationlevel($this->getRequestParameter('educationLevel'));
        $legal_watch->setEmail($this->getRequestParameter('email'));
        $legal_watch->setCountry($this->getRequestParameter('country'));		
        $legal_watch->setContact($this->getRequestParameter('contact'));
        $legal_watch->setTitle($this->getRequestParameter('title'));
        $legal_watch->setMessage($this->getRequestParameter('message'));
        $legal_watch->setStatusCode(Globals::STATUS_ACTIVE);
        if ($this->getRequest()->getFileName('legalWatchDicta') != '') {
            $uploadedFilename = $this->getRequest()->getFileName('legalWatchDicta');
            $ext = explode(".", $this->getRequest()->getFileName('legalWatchDicta'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "legalWatchDicta_" . date("Ymd") . "_" . $distDB->getDistributorCode() . "_" . rand(1000, 9999) . "." . $extensionName;
            $this->getRequest()->moveFile('legalWatchDicta', sfConfig::get('sf_upload_dir') . '/legal_watch_dicta/' . $filename);

            $legal_watch->setFileName($filename);
        }

        $legal_watch->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $legal_watch->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $legal_watch->save();

        $this->sendLegalWatchEmailToClient($legal_watch);
        $this->sendLegalWatchEmail($legal_watch);

        $this->setFlash('successMsg', "Your submission has been successfully received by LACD.<br><br>We thank you for taking the time to “ASK and be ANSWERED”. No matter what, we are there for you, and YES WE CAN! Please now expect a response from LACD within 48 hours.");
        return $this->redirect('/legalWatch/successful');
    }

    function sendLegalWatchEmail($legal_watch)
    {
        $subject = $legal_watch->getTitle();

        $body = "Passport/ID card full name (In English please): " . $legal_watch->getFullName() . "
                 <br><br>MAXIM Member ID: " . $legal_watch->getDistCode() . "
                 <br><br>age: " . $legal_watch->getAge() . "
                 <br><br>Education level: " . $legal_watch->getEducationLevel() . "
                 <br><br>Email Address: " . $legal_watch->getEmail() . "
                 <br><br>Contact Number: " . $legal_watch->getContact() . "
                 <br><br>preferred language is (if not English I can get your response translated)
                 <br><br>LEGAL WATCH DICTA: " . $legal_watch->getMessage();
        if ($legal_watch->getFileName() != "") {
            $body .= "<br>Attached herewith: <a target='_blank' href='http://partner.maximtrader.com/download/downloadClientDicta?p=" . $legal_watch->getFileName() . "'>Download</a>";
        }

        $sendMailService = new SendMailService();
        $sendMailService->sendLegalWatch("lacd@maximtrader.com", "LACD", $subject, $body);
    }

    function sendLegalWatchEmailToClient($legal_watch)
    {
        $subject = "LEGAL WATCH - Ask and be answered";

        $body = "We thank you for having the wisdom to participate on LW like hundreds of others are doing.
                <br>
                <br>The fact that you are asking, means you care enough to want things to be proper and legitimate, and we congratulate you for that. Do remember, that no matter who tells you what, the truth comes from us at Legal Watch.
                <br>
                <br><b>Please now expect a response from LACD as soon as possible. 
                <br>
                <br>If nothing at all comes to your given email within 10 days, this means, LACD did not receive your message. Otherwise, everyone are getting responses in proper order.</b>
                <br>
                <br>Thank you
				<br>
				<br>
				<br>With warm regards, 
                <br>LACD Officer. 				
				<br>LACD - We who advise and serve.";
        $sendMailService = new SendMailService();
        $sendMailService->sendLegalWatch($legal_watch->getEmail(), $legal_watch->getFullName(), $subject, $body);
    }
}
