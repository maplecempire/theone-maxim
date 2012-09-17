<?php

/**
 * download actions.
 *
 * @package    sf_sandbox
 * @subpackage download
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class downloadActions extends sfActions
{
    public function executeDownloadFxGuide()
    {
    }
    public function executeDownloadMt4Pro()
    {
        $this->distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
    }
    public function executeMt4Pro()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/exe');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=MAXIM_MT4_PRO.exe', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/MAXIM_MT4_PRO.exe");
        return sfView::NONE;
    }
    public function executeMt4ProUserGuide()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=Mt4_Pro_User_Guide.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/MAXIMPROUSERGUIDE.pdf");
        return sfView::NONE;
    }
    public function executeDemo()
    {

    }
    public function executeIndex()
    {

    }
    public function executeUploadify()
    {
        $targetFolder = '/uploads/guide'; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];

            // Validate the file type
            //$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $fileTypes = array('pdf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);

                $mlm_file_download = new MlmFileDownload();
                $mlm_file_download->setFileType("GUIDE");
                $mlm_file_download->setFileSrc($targetFile);
                $mlm_file_download->setFileName($_FILES['Filedata']['name']);
                $mlm_file_download->setContentType("application/pdf");
                $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_file_download->setRemarks("");
                $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_file_download->save();

                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }
    public function executeAmlPolicy()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=AML-Policy.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/agreements/AML-Policy.pdf");
        return sfView::NONE;
    }
    public function executeCustomerAgreement()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=Customer-Agreement.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/agreements/Customer-Agreement.pdf");
        return sfView::NONE;
    }
    public function executePrivateInvestmentAgreement()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=Private_Investment_Agreement.doc', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/agreements/Private_Investment_Agreement.doc");
        return sfView::NONE;
    }
    public function executeIBAgreement()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=IB_Agreement.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/agreements/MAXIM_GLOBAL_IB_Agreement.pdf");
        return sfView::NONE;
    }
    public function executeRiskDisclosureStatement()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=Risk-Disclosure-Statement.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/agreements/Risk-Disclosure-Statement.pdf");
        return sfView::NONE;
    }
    public function executeTermsOfBusiness()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=TERMS-OF-BUSINESS.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/agreements/TERMS-OF-BUSINESS.pdf");
        return sfView::NONE;
    }

    public function executeDownloadDemoMt4()
    {
        if ($this->getRequestParameter('email') <> "" && $this->getRequestParameter('requesterName') <> "") {
            $mlmMt4DemoRequest = new MlmMt4DemoRequest();
            $mlmMt4DemoRequest->setFullName( $this->getRequestParameter('requesterName'));
            $mlmMt4DemoRequest->setEmail($this->getRequestParameter('email'));
            $mlmMt4DemoRequest->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmMt4DemoRequest->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmMt4DemoRequest->save();

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType('application/exe');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename=MAXIM4Setup.exe', TRUE);
            $response->sendHttpHeaders();
            readfile(sfConfig::get('sf_upload_dir')."/MAXIM4Setup.exe");
        }

        return sfView::NONE;
    }

    public function executeDownloadGuide()
    {
        $c = new Criteria();
        $c->add(MlmFileDownloadPeer::FILE_TYPE, "GUIDE");
        $c->add(MlmFileDownloadPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->addDescendingOrderByColumn(MlmFileDownloadPeer::CREATED_ON);
        $mlmFileDownloadDB = MlmFileDownloadPeer::doSelectOne($c);

        if ($mlmFileDownloadDB) {
            $fileName = str_replace(' ', '_', $mlmFileDownloadDB->getFileName());

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType($mlmFileDownloadDB->getContentType());
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/guide/".$mlmFileDownloadDB->getFileName());
        }

        return sfView::NONE;
    }

    public function executeDownloadFundManagementReport()
    {
        $c = new Criteria();
        $c->add(MlmFileDownloadPeer::FILE_TYPE, "FUND_MANAGEMENT_REPORT");
        $c->add(MlmFileDownloadPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->addDescendingOrderByColumn(MlmFileDownloadPeer::CREATED_ON);
        $mlmFileDownloadDB = MlmFileDownloadPeer::doSelectOne($c);

        if ($mlmFileDownloadDB) {
            $fileName = str_replace(' ', '_', $mlmFileDownloadDB->getFileName());

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType($mlmFileDownloadDB->getContentType());
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/fundManagement/".$mlmFileDownloadDB->getFileName());
        }

        return sfView::NONE;
    }

    public function executeDownloadGuide_BAK()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Weekly_Report_030612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Daily_Report_050612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Daily_Report_060612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Daily_Report_070612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Daily_Report_080612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Weekly_Report_090612.pdf', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Weekly_Report_160612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Daily_Report_120612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Daily_Report_130612.pdf', TRUE);
//        $response->setHttpHeader('Content-Disposition','attachment; filename=TAI_Daily_Report_150612.pdf', TRUE);
        $response->sendHttpHeaders();
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Weekly_Report_030612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Daily_Report_050612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Daily_Report_060612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Daily_Report_070612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Daily_Report_080612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Weekly_Report_090612.pdf");
        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Weekly_Report_160612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Daily_Report_120612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Daily_Report_130612.pdf");
//        readfile(sfConfig::get('sf_upload_dir')."/guide/TAI_Daily_Report_150612.pdf");

        return sfView::NONE;
    }

    public function executeNric()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        if ($distDB) {
            $fileName = $distDB->getFileNric();

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType('application/pdf');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/nric/".$fileName);
        }

        return sfView::NONE;
    }
    public function executeProofOfResidence()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        if ($distDB) {
            $fileName = $distDB->getFileProofOfResidence();

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType('application/pdf');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/proof_of_residence/".$fileName);
        }

        return sfView::NONE;
    }
    public function executeBankPassBook()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        if ($distDB) {
            $fileName = $distDB->getFileBankPassBook();

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType('application/pdf');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/bank_pass_book/".$fileName);
        }

        return sfView::NONE;
    }
}
