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

    public function executeNewsletter2013()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/exe');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=maximtrader_news_letter_nov_dec_2013.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/news_letter/maximtrader_news_letter_nov_dec_2013.pdf");

        return sfView::NONE;
    }
    public function executeDownloadMaximTrader4SetupV3()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/exe');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=maxim4setup.v3.exe', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/maxim4setup.v3.exe");

        return sfView::NONE;
    }
    public function executeInvitation()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/jpg');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=invitation.jpg', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/activities/INVITATION.jpg");

        return sfView::NONE;
    }
    public function executePrivateInvestmentAgreementContract()
    {
        $mt4Id = $this->getRequestParameter('q');
        $distId = $this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID);

        $c = new Criteria();
        $c->add(MlmPackageContractPeer::MT4_ID, $mt4Id);
        $c->add(MlmPackageContractPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0));
        $c->add(MlmPackageContractPeer::STATUS_CODE, Globals::STATUS_COMPLETE);
        $mlmPackageContract = MlmPackageContractPeer::doSelectOne($c);

        if ($mlmPackageContract) {
            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType('application/pdf');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename=Private_Investment_Agreement.pdf', TRUE);
            $response->sendHttpHeaders();
            readfile(sfConfig::get('sf_upload_dir')."/private_investment_agreement/".$mt4Id."_Private_Investment_Agreement.pdf");
        }

        return sfView::NONE;
    }
    public function executeDownloadMaximTrader4Setup()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/exe');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=Maxim4Setup2.exe', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/Maxim4Setup2.exe");

        return sfView::NONE;
    }
    public function executeDemoMt4()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/exe');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=maximtrader4setup.exe', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/maximtrader4setup.exe");
        return sfView::NONE;
    }
    public function executeDownloadFxGuide()
    {
    }
    public function executeDownloadVideo()
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
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=Maxim_Trade_Executors.exe', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/MaximTradeExecutors.exe");
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
    public function executeUploadFxGuideCN()
    {
    }
    public function executeUploadFxGuideEN()
    {
    }
    public function executeUploadFxGuideJP()
    {
    }
    public function executeUploadFxGuideKR()
    {
    }

    public function executeDoUploadChineseGuide()
    {
        if ($this->getRequest()->getFileName('fxguide') != '') {
            $uploadedFilename = $this->getRequest()->getFileName('fxguide');

            $filename = "chinese_".$uploadedFilename;
            $this->getRequest()->moveFile('fxguide', sfConfig::get('sf_upload_dir') . '/guide/' . $filename);

            $mlm_file_download = new MlmFileDownload();
            $mlm_file_download->setFileType("GUIDE_CN");
            $mlm_file_download->setFileSrc(sfConfig::get('sf_upload_dir') . '/guide/' . $filename);
            $mlm_file_download->setFileName($filename);
            $mlm_file_download->setContentType("application/pdf");
            $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_file_download->setRemarks("");
            $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->save();

            /*$ch = curl_init();

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('fxguide' => '@'.sfConfig::get('sf_upload_dir') . '/guide/' . $filename));
            curl_setopt($ch, CURLOPT_URL, 'http://cn.maplefx.com/download/doUploadChineseGuide');
            curl_exec($ch);

            curl_close($ch);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('fxguide' => '@'.sfConfig::get('sf_upload_dir') . '/guide/' . $filename));
            curl_setopt($ch, CURLOPT_URL, 'http://my.maplefx.com/download/doUploadChineseGuide');
            curl_exec($ch);

            curl_close($ch);*/

            $this->setFlash('successMsg', "Upload successful.");
            return $this->redirect('/download/uploadFxGuideCN');
        }
        $this->setFlash('successMsg', "Upload failure.");
        return $this->redirect('/download/uploadFxGuideCN');
    }

    public function executeDoUploadEnglishGuide()
    {
        if ($this->getRequest()->getFileName('fxguide') != '') {
            $uploadedFilename = $this->getRequest()->getFileName('fxguide');

            $filename = "english_".$uploadedFilename;
            $this->getRequest()->moveFile('fxguide', sfConfig::get('sf_upload_dir') . '/guide/' . $filename);

            $mlm_file_download = new MlmFileDownload();
            $mlm_file_download->setFileType("GUIDE_EN");
            $mlm_file_download->setFileSrc(sfConfig::get('sf_upload_dir') . '/guide/' . $filename);
            $mlm_file_download->setFileName($filename);
            $mlm_file_download->setContentType("application/pdf");
            $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_file_download->setRemarks("");
            $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->save();

            /*$ch = curl_init();

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('fxguide' => '@'.sfConfig::get('sf_upload_dir') . '/guide/' . $filename));
            curl_setopt($ch, CURLOPT_URL, 'http://cn.maplefx.com/download/doUploadEnglishGuide');
            curl_exec($ch);

            curl_close($ch);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('fxguide' => '@'.sfConfig::get('sf_upload_dir') . '/guide/' . $filename));
            curl_setopt($ch, CURLOPT_URL, 'http://my.maplefx.com/download/doUploadEnglishGuide');
            curl_exec($ch);

            curl_close($ch);*/

            $this->setFlash('successMsg', "Upload successful.");
            return $this->redirect('/download/uploadFxGuideEN');
        }
        $this->setFlash('successMsg', "Upload failure.");
        return $this->redirect('/download/uploadFxGuideEN');
    }

    public function executeDoUploadJapaneseGuide()
    {
        if ($this->getRequest()->getFileName('fxguide') != '') {
            $uploadedFilename = $this->getRequest()->getFileName('fxguide');

            $filename = "japanese_".$uploadedFilename;
            $this->getRequest()->moveFile('fxguide', sfConfig::get('sf_upload_dir') . '/guide/' . $filename);

            $mlm_file_download = new MlmFileDownload();
            $mlm_file_download->setFileType("GUIDE_JP");
            $mlm_file_download->setFileSrc(sfConfig::get('sf_upload_dir') . '/guide/' . $filename);
            $mlm_file_download->setFileName($filename);
            $mlm_file_download->setContentType("application/pdf");
            $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_file_download->setRemarks("");
            $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->save();

            /*$ch = curl_init();

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('fxguide' => '@'.sfConfig::get('sf_upload_dir') . '/guide/' . $filename));
            curl_setopt($ch, CURLOPT_URL, 'http://cn.maplefx.com/download/doUploadJapaneseGuide');
            curl_exec($ch);

            curl_close($ch);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('fxguide' => '@'.sfConfig::get('sf_upload_dir') . '/guide/' . $filename));
            curl_setopt($ch, CURLOPT_URL, 'http://my.maplefx.com/download/doUploadJapaneseGuide');
            curl_exec($ch);

            curl_close($ch);*/

            $this->setFlash('successMsg', "Upload successful.");
            return $this->redirect('/download/uploadFxGuideJP');
        }
        $this->setFlash('successMsg', "Upload failure.");
        return $this->redirect('/download/uploadFxGuideJP');
    }

    public function executeDoUploadKoreanGuide()
    {
        if ($this->getRequest()->getFileName('fxguide') != '') {
            $uploadedFilename = $this->getRequest()->getFileName('fxguide');

            $filename = "korean_".$uploadedFilename;
            $this->getRequest()->moveFile('fxguide', sfConfig::get('sf_upload_dir') . '/guide/' . $filename);

            $mlm_file_download = new MlmFileDownload();
            $mlm_file_download->setFileType("GUIDE_KR");
            $mlm_file_download->setFileSrc(sfConfig::get('sf_upload_dir') . '/guide/' . $filename);
            $mlm_file_download->setFileName($filename);
            $mlm_file_download->setContentType("application/pdf");
            $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_file_download->setRemarks("");
            $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->save();

            $this->setFlash('successMsg', "Upload successful.");
            return $this->redirect('/download/uploadFxGuideKR');
        }
        $this->setFlash('successMsg', "Upload failure.");
        return $this->redirect('/download/uploadFxGuideKR');
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
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=Private_Investment_Agreement.pdf', TRUE);
        $response->sendHttpHeaders();
        if ($this->getUser()->getCulture() == 'cn') {
            readfile(sfConfig::get('sf_upload_dir')."/agreements/Private_Investment_Agreement_Cn.pdf");
        } else {
            readfile(sfConfig::get('sf_upload_dir')."/agreements/Private_Investment_Agreement.pdf");
        }
        return sfView::NONE;
    }
    public function executeMteAgreement()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/pdf');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=MTE_Agreement.pdf', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/agreements/MTE_Agreement.pdf");
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
            $response->setHttpHeader('Content-Disposition','attachment; filename=maximtrader4setup.exe', TRUE);
            $response->sendHttpHeaders();
            readfile(sfConfig::get('sf_upload_dir')."/maximtrader4setup.exe");
        }

        return sfView::NONE;
    }

    public function executeDownloadGuide()
    {
        $c = new Criteria();
        $c->add(MlmFileDownloadPeer::FILE_TYPE, "GUIDE_".$this->getRequestParameter('a'));
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

    public function executeDownloadDicta()
    {
        $fileName = "Maxim-LEGAL_WATCH_dicta_".$this->getRequestParameter('a').".pdf";

        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/octet-stream');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
        $response->sendHttpHeaders();

        readfile(sfConfig::get('sf_upload_dir')."/agreements/".$fileName);

        return sfView::NONE;
    }

    public function executeDownloadClientDicta()
    {
        $fileName = $this->getRequestParameter('p');

        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/octet-stream');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
        $response->sendHttpHeaders();

        readfile(sfConfig::get('sf_upload_dir')."/legal_watch_dicta/".$fileName);

        return sfView::NONE;
    }

    public function executeDownloadFundManagementReport()
    {
        $fileName = $this->getRequestParameter('p');

        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType("application/pdf");
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary');
        $response->setHttpHeader('Content-Disposition','inline; filename=Maxim_Fund_Manager_Report_'.$fileName.".pdf");
        $response->sendHttpHeaders();

        readfile(sfConfig::get('sf_upload_dir')."/fundManagement/Maxim_Fund_Manager_Report_".$fileName.".pdf");
        return sfView::NONE;
    }

    public function executeDownloadEzybondsRegisterProcedure()
    {
        $fileName = $this->getRequestParameter('p');

        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType("application/pdf");
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary');
        $response->setHttpHeader('Content-Disposition','inline; filename=Ezybonds_Register_Procedure_'.$fileName.".pdf");
        $response->sendHttpHeaders();

        readfile(sfConfig::get('sf_upload_dir')."/Ezybonds_Register_Procedure/Ezybonds_Register_Procedure_".$fileName.".pdf");
        return sfView::NONE;
    }

    public function executeDownloadEzyFile()
    {
        $fileName = $this->getRequestParameter('p');
        $fileEx = $this->getRequestParameter('e');

        $contentDisposition = "inline";
        if ($fileEx != "pdf") {
            $contentDisposition = "attachment";
        }
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType("application/pdf");
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary');
        $response->setHttpHeader('Content-Disposition',$contentDisposition.'; filename='.$fileName.".".$fileEx);
        $response->sendHttpHeaders();

        readfile(sfConfig::get('sf_upload_dir')."/Ezybonds_Register_Procedure/".$fileName.".".$fileEx);
        return sfView::NONE;
    }

    public function executeDownloadFundManagementReport2()
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
    public function executeBankslip()
    {
        $distEpointPurchaseDB = MlmDistEpointPurchasePeer::retrieveByPk($this->getRequestParameter('p'));

        if ($distEpointPurchaseDB) {
            $fileName = $distEpointPurchaseDB->getImageSource();

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
