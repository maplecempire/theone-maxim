<?php

/**
 * marketing actions.
 *
 * @package    sf_sandbox
 * @subpackage marketing
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class marketingActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeIndex()
    {
        return $this->redirect('/marketing/distList');
    }

    public function executeFxGuideUpload()
    {
    }

    public function executeDoUploadPips()
    {
        if ($this->getRequest()->getFileName('file_upload') != "") {
            $uploadedFilename = $this->getRequest()->getFileName('file_upload');
            $tradingMonth = $this->getRequestParameter('tradingMonth');
            $ext = explode(".", $this->getRequest()->getFileName('file_upload'));
            $extensionName = $ext[count($ext) - 1];

            $this->getRequest()->moveFile('file_upload', sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . 'pips' . DIRECTORY_SEPARATOR . $uploadedFilename);

            $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . 'pips' . DIRECTORY_SEPARATOR . $uploadedFilename;

            $mlm_file_download = new MlmFileDownload();
            $mlm_file_download->setFileType("PIPS");
            $mlm_file_download->setFileSrc($physicalDirectory);
            $mlm_file_download->setFileName($uploadedFilename);
            $mlm_file_download->setContentType("application/csv");
            $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_file_download->setRemarks("");
            $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_file_download->save();
            /* **********************************************
             *      Manipulate PIPS
             * ***********************************************/
            $file_handle = fopen($physicalDirectory, "rb");

            /*$con = Propel::getConnection(MlmFileDownloadPeer::DATABASE_NAME);
            try {
                $con->begin();*/

            while (!feof($file_handle)) {
                $line_of_text = fgets($file_handle);
                $parts = explode('=', $line_of_text);

                $string = $parts[0] . $parts[1];
                $arr = explode(';', $string);

                $status = Globals::STATUS_PIPS_CSV_ACTIVE;
                $remarks = "";
                $mlm_pip_csv = new MlmPipCsv();
                $mlm_pip_csv->setFileId($mlm_file_download->getFileId());
                $mlm_pip_csv->setPipsString($string);

                if (count($arr) == 13) {
                    if (is_numeric($arr[0])) {
                        $idx = 0;
                        $mlm_pip_csv->setMonthTraded($tradingMonth);
                        $mlm_pip_csv->setYearTraded(date('Y'));
                        $mlm_pip_csv->setLoginId($arr[$idx++]);
                        $mlm_pip_csv->setLoginName($arr[$idx++]);
                        $mlm_pip_csv->setDeposit($arr[$idx++]);
                        $mlm_pip_csv->setWithdraw($arr[$idx++]);
                        $mlm_pip_csv->setInOut($arr[$idx++]);
                        $mlm_pip_csv->setCredit($arr[$idx++]);
                        $mlm_pip_csv->setVolume($arr[$idx++]);
                        $mlm_pip_csv->setCommission($arr[$idx++]);
                        $mlm_pip_csv->setTaxes($arr[$idx++]);
                        $mlm_pip_csv->setAgent($arr[$idx++]);
                        $mlm_pip_csv->setStorage($arr[$idx++]);
                        $mlm_pip_csv->setProfit($arr[$idx++]);
                        $mlm_pip_csv->setLastBalance($arr[$idx++]);
                        $mlm_pip_csv->setStatusCode($status);
                        $mlm_pip_csv->setRemarks($remarks);
                        $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_pip_csv->save();
                        /* ++++++++++++++++++++++++++++++++++++++++++++++
                       *      Calculate Pips
                       * +++++++++++++++++++++++++++++++++++++++++++++++*/
                        $totalVolume = $mlm_pip_csv->getVolume();
                        $mt4Id = $mlm_pip_csv->getLoginId();

                        $c = new Criteria();
                        $c->add(MlmDistributorPeer::MT4_USER_NAME, $mt4Id);
                        $existDistributor = MlmDistributorPeer::doSelectOne($c);

                        if ($existDistributor) {
                            /*$index = 0;
                            $treeLevel = $existDistributor->getTreeLevel();
                            $treeStructure = $existDistributor->getTreeStructure();
                            $affectedDistributorArrs = explode("|", $treeStructure);

                            for ($y = count($affectedDistributorArrs); $y > 0; $y--) {
                                if ($affectedDistributorArrs[$y] == "") {
                                    continue;
                                }
                                $affectedDistributorId = $affectedDistributorArrs[$y];
                                $c = new Criteria();
                                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $affectedDistributorId, Criteria::EQUAL);
                                $affectedDistributor = MlmDistributorPeer::doSelectOne($c);

                                $affectedDistributorTreeLevel = $affectedDistributor->getTreeLevel();
                                $affectedDistributorPackageDB = MlmPackagePeer::retrieveByPK($affectedDistributor->getRankId());
                                if ($affectedDistributorPackageDB) {
                                    $generation = $affectedDistributorPackageDB->getGeneration();
                                    $pips = $affectedDistributorPackageDB->getPips();
                                    $generation2 = $affectedDistributorPackageDB->getGeneration2();
                                    $pips2 = $affectedDistributorPackageDB->getPips2();

                                    $totalGeneration = $generation + $generation2;

                                    $gap = $treeLevel - $affectedDistributorTreeLevel;
                                    $isEntitled = false;
                                    $pipsAmountEntitied = 0;
                                    $pipsEntitied = 0;
                                    if ($generation == null) {
                                        $isEntitled = true;
                                    } else {
                                        if ($gap <= $totalGeneration) {
                                            $isEntitled = true;

                                            if ($gap > $generation) {
                                                $pipsAmountEntitied = $pips2 * $totalVolume;
                                                $pipsEntitied = $pips2;
                                            } else {
                                                $pipsAmountEntitied = $pips * $totalVolume;
                                                $pipsEntitied = $pips;
                                            }
                                        }
                                    }

                                    if ($isEntitled) {
                                        if ($pipsAmountEntitied > 0) {

                                            if ($gap == 0) {
                                                $c = new Criteria();
                                                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $affectedDistributor->getDistributorId());
                                                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_PIPS_VOLUME);
                                                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                                                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                                                $pipsBalance = 0;
                                                if ($sponsorDistCommissionLedgerDB)
                                                    $pipsBalance = $sponsorDistCommissionLedgerDB->getBalance();

                                                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                                $sponsorDistCommissionledger->setMonthTraded($tradingMonth);
                                                $sponsorDistCommissionledger->setDistId($affectedDistributor->getDistributorId());
                                                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_PIPS_VOLUME);
                                                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PIPS_TRADED);
                                                $sponsorDistCommissionledger->setRefId($mlm_pip_csv->getPipId());
                                                $sponsorDistCommissionledger->setCredit($totalVolume);
                                                $sponsorDistCommissionledger->setDebit(0);
                                                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                                $sponsorDistCommissionledger->setBalance($pipsBalance + $totalVolume);
                                                $sponsorDistCommissionledger->setRemark("");
                                                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                $sponsorDistCommissionledger->save();

                                                $this->revalidateCommission($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_PIPS_BONUS);
                                            } else {
                                                $c = new Criteria();
                                                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $affectedDistributor->getDistributorId());
                                                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_PIPS_BONUS);
                                                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                                                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                                                $pipsBalance = 0;
                                                if ($sponsorDistCommissionLedgerDB)
                                                    $pipsBalance = $sponsorDistCommissionLedgerDB->getBalance();

                                                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                                $sponsorDistCommissionledger->setMonthTraded($tradingMonth);
                                                $sponsorDistCommissionledger->setDistId($affectedDistributor->getDistributorId());
                                                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_PIPS_BONUS);
                                                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PIPS_GAIN);
                                                $sponsorDistCommissionledger->setRefId($mlm_pip_csv->getPipId());
                                                $sponsorDistCommissionledger->setCredit($pipsAmountEntitied);
                                                $sponsorDistCommissionledger->setDebit(0);
                                                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_PENDING);
                                                $sponsorDistCommissionledger->setBalance($pipsBalance + $pipsAmountEntitied);
                                                $sponsorDistCommissionledger->setRemark("e-Trader:".$existDistributor->getDistributorCode().", Gap:".$gap.", volume:".$totalVolume.", pips:".$pipsEntitied);
                                                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                $sponsorDistCommissionledger->save();

                                                $this->revalidateCommission($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_PIPS_BONUS);
                                            }
                                        }
                                    }
                                }
                            }

                            $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_SUCCESS);
                            $mlm_pip_csv->save();*/
                        } else {
                            $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_ERROR);
                            $mlm_pip_csv->setRemarks("Invalid MT4 ID");
                            $mlm_pip_csv->save();
                        }
                        /* ++++++++++++++++++++++++++++++++++++++++++++++
                       *      ~ END Calculate Pips ~
                       * +++++++++++++++++++++++++++++++++++++++++++++++*/
                    } else {
                        $status = Globals::STATUS_PIPS_CSV_ERROR;
                        $remarks = "FIRST ELEMENT NOT NUMERIC";

                        $mlm_pip_csv->setStatusCode($status);
                        $mlm_pip_csv->setRemarks($remarks);
                        $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_pip_csv->save();
                    }
                } else {
                    $status = Globals::STATUS_PIPS_CSV_ERROR;
                    $remarks = "ARRAY NOT EQUAL TO 13";

                    $mlm_pip_csv->setStatusCode($status);
                    $mlm_pip_csv->setRemarks($remarks);
                    $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_pip_csv->save();
                }
            }
            /*$con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }*/
            $this->setFlash('successMsg', "Files was successfully uploaded.");
            return $this->redirect('/marketing/pipsUpload?doAction=show_pips');
        }
    }

    public function executePipsUpload()
    {
        /*$file_handle = fopen("E://xampplite/htdocs/defxm2u/web/uploads/pips/GVFpipsApril.csv", "rb");

        while (!feof($file_handle)) {
            $line_of_text = fgets($file_handle);
            $parts = explode('=', $line_of_text);

            print $parts[0] . $parts[1] . "<BR>";
        }

        fclose($file_handle);*/

        $array = explode(',', Globals::STATUS_ACTIVE . "," . Globals::STATUS_COMPLETE);
        $c = new Criteria();
        $c->add(MlmFileDownloadPeer::FILE_TYPE, "PIPS");
        $c->add(MlmFileDownloadPeer::STATUS_CODE, $array, Criteria::IN);
        $c->addDescendingOrderByColumn(MlmFileDownloadPeer::CREATED_ON);
        $mlmFileDownloadDB = MlmFileDownloadPeer::doSelectOne($c);

        $fileName = "";
        $uploadDate = "";
        $approvedStatus = "";

        if ($mlmFileDownloadDB) {
            $fileName = $mlmFileDownloadDB->getFileName();
            $uploadDate = $mlmFileDownloadDB->getCreatedOn();
            $approvedStatus = $mlmFileDownloadDB->getStatusCode();
        }

        $this->fileName = $fileName;
        $this->approvedStatus = $approvedStatus;
        $this->uploadDate = $uploadDate;

        /* *************************************
         *   LIST
         * ************************************* */
        $doAction = $this->getRequestParameter('doAction');

        if ($doAction != "") {
            if ($doAction == "show_pips" && $mlmFileDownloadDB) {
                $c = new Criteria();
                $c->add(MlmPipCsvPeer::FILE_ID, $mlmFileDownloadDB->getFileId());
                $c->addAscendingOrderByColumn(MlmPipCsvPeer::PIP_ID);
                $this->pipDBs = MlmPipCsvPeer::doSelect($c);
            } else if ($doAction == "calc_pips" && $mlmFileDownloadDB) {
                $this->refId = $mlmFileDownloadDB->getFileId();
            } else if ($doAction == "approve_pips" && $mlmFileDownloadDB) {
                $this->refId = $mlmFileDownloadDB->getFileId();

                $c = new Criteria();
                $c->add(MlmPipCsvPeer::STATUS_CODE, Globals::STATUS_PIPS_CSV_ACTIVE);
                $c->add(MlmPipCsvPeer::FILE_ID, $mlmFileDownloadDB->getFileId());
                $mlmPipsCsvDBs = MlmPipCsvPeer::doSelect($c);

                foreach ($mlmPipsCsvDBs as $mlm_pip_csv) {
                    $totalVolume = $mlm_pip_csv->getVolume();
                    $mt4Id = $mlm_pip_csv->getLoginId();
                    $tradingMonth =  $mlm_pip_csv->getMonthTraded();

                    $c = new Criteria();
                    $c->add(MlmDistributorPeer::MT4_USER_NAME, $mt4Id);
                    $existDistributor = MlmDistributorPeer::doSelectOne($c);

                    if ($existDistributor) {
                        $index = 0;
                        $treeLevel = $existDistributor->getTreeLevel();
                        $treeStructure = $existDistributor->getTreeStructure();
                        $affectedDistributorArrs = explode("|", $treeStructure);

                        for ($y = count($affectedDistributorArrs); $y > 0; $y--) {
                            if ($affectedDistributorArrs[$y] == "") {
                                continue;
                            }
                            $affectedDistributorId = $affectedDistributorArrs[$y];
                            $c = new Criteria();
                            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $affectedDistributorId, Criteria::EQUAL);
                            $affectedDistributor = MlmDistributorPeer::doSelectOne($c);

                            $affectedDistributorTreeLevel = $affectedDistributor->getTreeLevel();
                            $affectedDistributorPackageDB = MlmPackagePeer::retrieveByPK($affectedDistributor->getRankId());
                            if ($affectedDistributorPackageDB) {
                                $generation = $affectedDistributorPackageDB->getGeneration();
                                $pips = $affectedDistributorPackageDB->getPips();
                                $generation2 = $affectedDistributorPackageDB->getGeneration2();
                                $pips2 = $affectedDistributorPackageDB->getPips2();
                                $creditRefundByPackage = $affectedDistributorPackageDB->getCreditRefund();

                                $totalGeneration = $generation + $generation2;

                                $gap = $treeLevel - $affectedDistributorTreeLevel;
                                $isEntitled = false;
                                $pipsAmountEntitied = 0;
                                $pipsEntitied = 0;
                                if ($generation == null) {
                                    $isEntitled = true;
                                } else {
                                    if ($gap <= $totalGeneration) {
                                        $isEntitled = true;

                                        if ($gap > $generation) {
                                            $pipsAmountEntitied = $pips2 * $totalVolume;
                                            $pipsEntitied = $pips2;
                                        } else {
                                            $pipsAmountEntitied = $pips * $totalVolume;
                                            $pipsEntitied = $pips;
                                        }
                                    }
                                }

                                if ($isEntitled) {
                                    if ($pipsAmountEntitied > 0) {

                                        if ($gap == 0) {
                                            $pipsBalance = $this->getCommissionBalance($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_CREDIT_REFUND);

                                            $creditRefund = $totalVolume * $creditRefundByPackage;

                                            $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                            $sponsorDistCommissionledger->setMonthTraded($tradingMonth);
                                            $sponsorDistCommissionledger->setDistId($affectedDistributor->getDistributorId());
                                            $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_CREDIT_REFUND);
                                            $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PIPS_TRADED);
                                            $sponsorDistCommissionledger->setRefId($mlm_pip_csv->getPipId());
                                            $sponsorDistCommissionledger->setCredit($creditRefund);
                                            $sponsorDistCommissionledger->setDebit(0);
                                            $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                            $sponsorDistCommissionledger->setBalance($pipsBalance + $creditRefund);
                                            $sponsorDistCommissionledger->setRemark("USD ".$creditRefundByPackage.", Volume:".$totalVolume);
                                            $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                            $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                            $sponsorDistCommissionledger->save();

                                            $this->revalidateCommission($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_PIPS_BONUS);
                                        } else {
                                            $pipsBalance = $this->getCommissionBalance($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_PIPS_BONUS);

                                            $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                            $sponsorDistCommissionledger->setMonthTraded($tradingMonth);
                                            $sponsorDistCommissionledger->setDistId($affectedDistributor->getDistributorId());
                                            $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_PIPS_BONUS);
                                            $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PIPS_GAIN);
                                            $sponsorDistCommissionledger->setRefId($mlm_pip_csv->getPipId());
                                            $sponsorDistCommissionledger->setCredit($pipsAmountEntitied);
                                            $sponsorDistCommissionledger->setDebit(0);
                                            $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                            $sponsorDistCommissionledger->setBalance($pipsBalance + $pipsAmountEntitied);
                                            $sponsorDistCommissionledger->setRemark("e-Trader:".$existDistributor->getDistributorCode().", tier:".$gap.", volume:".$totalVolume.", pips:".$pipsEntitied);
                                            $sponsorDistCommissionledger->setPipsDownlineUsername($existDistributor->getDistributorCode());
                                            $sponsorDistCommissionledger->setPipsMt4Id($existDistributor->getMt4UserName());
                                            $sponsorDistCommissionledger->setPipsRebate($pipsEntitied);
                                            $sponsorDistCommissionledger->setPipsLevel($gap);
                                            $sponsorDistCommissionledger->setPipsLotsTraded($totalVolume);
                                            $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                            $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                            $sponsorDistCommissionledger->save();

                                            $this->revalidateCommission($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_PIPS_BONUS);
                                        }
                                    }
                                }
                            }
                        }

                        $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_SUCCESS);
                        $mlm_pip_csv->save();
                    } else {
                        $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_ERROR);
                        $mlm_pip_csv->setRemarks("Invalid MT4 ID");
                        $mlm_pip_csv->save();
                    }
                }
                $mlmFileDownloadDB->setStatusCode(Globals::STATUS_COMPLETE);
                $mlmFileDownloadDB->save();
                return $this->redirect('/marketing/pipsUpload?doAction=calc_pips');
            }
        }
    }

    public function executeManipulatePips()
    {
        $targetFolder = '/uploads/pips'; // Relative to the root

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];

            // Validate the file type
            //$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $fileTypes = array('csv'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);

                $mlm_file_download = new MlmFileDownload();
                $mlm_file_download->setFileType("PIPS");
                $mlm_file_download->setFileSrc($targetFile);
                $mlm_file_download->setFileName($_FILES['Filedata']['name']);
                $mlm_file_download->setContentType("application/csv");
                $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_file_download->setRemarks("");
                $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_file_download->save();

                /*$mlm_pip_csv = new MlmPipCsv();
                $mlm_pip_csv->setFileId($mlm_file_download->getFileId());
                $mlm_pip_csv->setPipsString("test");
                $mlm_pip_csv->setStatusCode("active");
                $mlm_pip_csv->setRemarks("test");
                $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_pip_csv->save();*/

                /* **********************************************
                 *      Manipulate PIPS
                 * ***********************************************/
                $file_handle = fopen($targetFile, "rb");

                while (!feof($file_handle)) {
                    $line_of_text = fgets($file_handle);
                    $parts = explode('=', $line_of_text);

                    $string = $parts[0] . $parts[1];
                    $arr = explode(';', $string);

                    $status = "ACTIVE";
                    $remarks = "";
                    $mlm_pip_csv = new MlmPipCsv();
                    $mlm_pip_csv->setFileId($mlm_file_download->getFileId());
                    $mlm_pip_csv->setPipsString($string);

                    if (count($arr) == 13) {
                        if (is_numeric($arr[0])) {
                            $idx = 0;
                            $mlm_pip_csv->setLoginId($arr[$idx++]);
                            $mlm_pip_csv->setLoginName($arr[$idx++]);
                            $mlm_pip_csv->setDeposit($arr[$idx++]);
                            $mlm_pip_csv->setWithdraw($arr[$idx++]);
                            $mlm_pip_csv->setInOut($arr[$idx++]);
                            $mlm_pip_csv->setCredit($arr[$idx++]);
                            $mlm_pip_csv->setVolume($arr[$idx++]);
                            $mlm_pip_csv->setCommission($arr[$idx++]);
                            $mlm_pip_csv->setTaxes($arr[$idx++]);
                            $mlm_pip_csv->setAgent($arr[$idx++]);
                            $mlm_pip_csv->setStorage($arr[$idx++]);
                            $mlm_pip_csv->setProfit($arr[$idx++]);
                            $mlm_pip_csv->setLastBalance($arr[$idx++]);
                        } else {
                            $status = "ERROR";
                            $remarks = "FIRST ELEMENT NOT NUMERIC";
                        }
                    } else {
                        $status = "ERROR";
                        $remarks = "ARRAY NOT EQUAL TO 13";
                    }
                    $mlm_pip_csv->setStatusCode($status);
                    $mlm_pip_csv->setRemarks($remarks);
                    $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_pip_csv->save();
                    //print $parts[0] . $parts[1] . "<BR>";
                }

                fclose($file_handle);
                echo 'Files was successfully uploaded.';
            } else {
                echo 'Invalid file type.';
            }
        }
        return sfView::HEADER_ONLY;
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

    public function executeDistAdd()
    {
        $this->showSuccessfulMsg = $this->getRequestParameter('showSuccessfulMsg');
    }

    public function executeDistList()
    {
    }

    public function executeSuperIbList()
    {
    }

    public function executeDoSaveDist()
    {
        $tbl_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));

        //todo update mt4
        //$tbl_distributor->setMt4UserName($this->getRequestParameter('mt4_user_name'));
        //$tbl_distributor->setMt4Password($this->getRequestParameter('mt4_password'));
        $tbl_distributor->setFullName($this->getRequestParameter('fullname'));
        $tbl_distributor->setNickname($this->getRequestParameter('nickname'));
        $tbl_distributor->setIc($this->getRequestParameter('ic'));
        $tbl_distributor->setCountry($this->getRequestParameter('country'));
        $tbl_distributor->setAddress($this->getRequestParameter('address'));
        $tbl_distributor->setPostcode($this->getRequestParameter('postcode'));
        $tbl_distributor->setEmail($this->getRequestParameter('email'));
        $tbl_distributor->setContact($this->getRequestParameter('contact'));
        $tbl_distributor->setGender($this->getRequestParameter('gender'));
        if ($this->getRequestParameter('dob')) {
            list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
            $tbl_distributor->setDob("$y-$m-$d");
        }
        $tbl_distributor->setBankName($this->getRequestParameter('bankName'));
        $tbl_distributor->setBankAccNo($this->getRequestParameter('bankAccNo'));
        $tbl_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));
        $tbl_distributor->setBankSwiftCode($this->getRequestParameter('bank_swift_code'));
        $tbl_distributor->setVisaDebitCard($this->getRequestParameter('visa_debit_card'));
        $tbl_distributor->setStatusCode($this->getRequestParameter('status'));
        $tbl_distributor->save();

        $tbl_user = AppUserPeer::retrieveByPk($tbl_distributor->getUserId());

        $tbl_user->setUserpassword($this->getRequestParameter('password'));
        $tbl_user->setUserpassword2($this->getRequestParameter('password2'));

        $tbl_user->save();

        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeDoUpdatePackagePurchase()
    {
        $tbl_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));
        //$tbl_distributor->setMt4UserName($this->getRequestParameter('mt4_user_name'));
        //$tbl_distributor->setMt4Password($this->getRequestParameter('mt4_password'));
        $tbl_distributor->setPackagePurchaseFlag("N");

        $tbl_distributor->save();

        $mlm_dist_mt4 = new MlmDistMt4();
        $mlm_dist_mt4->setDistId($tbl_distributor->getDistributorId());
        $mlm_dist_mt4->setMt4UserName($this->getRequestParameter('mt4_user_name'));
        $mlm_dist_mt4->setMt4Password($this->getRequestParameter('mt4_password'));
        $mlm_dist_mt4->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_dist_mt4->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_dist_mt4->save();

        $output = array(
            "error" => false
        );
        echo json_encode($output);

        if ($this->getRequestParameter('mt4_user_name') != "" && $this->getRequestParameter('mt4_password') != "") {
            $subject = $this->getContext()->getI18N()->__("Maxim Trader Accounts Team", null, 'email');
            $body = "Dear " . $tbl_distributor->getFullName() . ",
                <p>
                <p>
                Congratulations! Your live trading account with Maxim Trader
                has been activated! Please find the details of your trading account as
                per below :
                <p>
                <p>
                Live MT4 Trading Account ID : " . $this->getRequestParameter('mt4_user_name') . "<p>
                Live MT4 Trading Account password : " . $this->getRequestParameter('mt4_password') . "<p>
                <p>
                <p>
                The Login ID and Password is strictly confidential and should not be
                disclosed to anyone. Should someone with access to your password wish,
                all of your account information can be changed. You will be held
                liable for any activity that may occur as a result of you losing your
                password. Therefore, if you feel that your password has been
                compromised, you should immediately contact us by email to
                cs@maxim.com to rectify the situation.<p>
                We look forward to your custom in the near future. Should you have any
                queries, please do not hesitate to get back to us.
                <p>
                --
                <p>
                Best Regards,
                <p>
                Maxim Trader
                <p>
                E mail : admin@maxim.com";

            $sendMailService = new SendMailService();
            $sendMailService->sendMt4UsernameAndPassword($tbl_distributor, $subject, $body);
        }

        return sfView::HEADER_ONLY;
    }

    public function executeSponsorTree()
    {
        $id = Globals::FIRST_REGISTERED_DISTRIBUTOR_ID;
        $distinfo = MlmDistributorPeer::retrieveByPk($id);
        $this->doSearch = false;
        $this->distinfo = $distinfo;
        $this->hasChild = $this->checkHasChild($distinfo->getDistributorId());

        /*********************/
        /* Search Function
         * ********************/
        $fullName = $this->getRequestParameter('fullName');
        $arrTree = array();

        if ($fullName != "") {
            $this->doSearch = true;

            $c = new Criteria();
            $c->add(MlmDistributorPeer::FULL_NAME, $fullName);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $searchDist = MlmDistributorPeer::doSelectOne($c);

            if ($searchDist) {
                $parentId = $id;

                $searchDistArr = array();
                $arrs = explode("|", $searchDist->getTreeStructure());
                $idx = 0;
                for ($x = 0; $x < count($arrs); $x++) {
                    if ($arrs[$x] == "") {
                        continue;
                    }
                    $dist = $this->getDistributorInformation($arrs[$x]);
                    $searchDistArr[$idx]["code"] = $arrs[$x];
                    $searchDistArr[$idx]["hasChildren"] = $this->checkHasChild($dist->getDistributorId());
                    $searchDistArr[$idx]["text"] = "<span class='gen_id'>" . $dist->getDistributorCode() . "</span> <span class='gen_active'>" . $dist->getFullname() . "</span> Joined " . date('Y-m-d', strtotime($dist->getCreatedOn())) . " " . $dist->getRankCode();
                    $searchDistArr[$idx]["id"] = $dist->getDistributorId();

                    /************ sibling ************/
                    $c = new Criteria();
                    $c->add(MlmDistributorPeer::UPLINE_DIST_CODE, $dist->getUplineDistCode());
                    $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $arrs[$x], Criteria::NOT_EQUAL);
                    $siblingDists = MlmDistributorPeer::doSelect($c);
                    //var_dump(count($siblingDists));
                    $siblingDistArr = array();
                    $siblingIdx = 0;
                    foreach ($siblingDists as $siblingDist)
                    {
                        /*var_dump($siblingDist->getDistributorCode());
                        var_dump($arrs[$x]);
                        var_dump("<br>");*/
                        if ($arrs[$x] == $siblingDist->getDistributorCode())
                            continue;
                        $siblingDistArr[$siblingIdx]["code"] = $siblingDist->getDistributorCode();
                        $siblingDistArr[$siblingIdx]["hasChildren"] = $this->checkHasChild($siblingDist->getDistributorId());
                        $siblingDistArr[$siblingIdx]["text"] = "<span class='gen_id'>" . $siblingDist->getDistributorCode() . "</span> <span class='gen_active'>" . $siblingDist->getFullname() . "</span> Joined " . date('Y-m-d', strtotime($siblingDist->getCreatedOn())) . " " . $siblingDist->getRankCode();
                        $siblingDistArr[$siblingIdx]["id"] = $siblingDist->getDistributorId();

                        $siblingIdx++;
                    }
                    $searchDistArr[$idx]["sibling"] = $siblingDistArr;
                    $idx++;
                }

                $c = new Criteria();
                $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $parentId);
                $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $dists = MlmDistributorPeer::doSelect($c);

                $idx = 0;
                foreach ($dists as $dist)
                {
                    $arrTree[$idx]["text"] = "<span class='gen_id'>" . $dist->getDistributorCode() . "</span> <span class='gen_active'>" . $dist->getFullname() . "</span> Joined " . date('Y-m-d', strtotime($dist->getCreatedOn())) . " " . $dist->getRankCode();
                    // $arrTree[$idx]["text"] = "<span class='gen_img'><img src='http://www.eslfreedom.com/js/jqtree/images/node70.gif'></span><span class='gen_id'>Olga</span><span class='gen_active'>1300805</span>  <span class='gen_name'>Diamond - A</span><span class='gen_active'>Activated 01/01/1970</span> <span class='gen_jdate'>Joined 31/08/2011</span>";
                    $arrTree[$idx]["id"] = $dist->getDistributorId();
                    $arrTree[$idx]["code"] = $dist->getDistributorCode();
                    $arrTree[$idx]["hasChildren"] = $this->checkHasChild($dist->getDistributorId());
                    $idx++;
                }

                $this->searchDist = $searchDist;
                $this->searchDistArr = $searchDistArr;
            }
        }
        $this->arrTree = $arrTree;
        $this->fullName = $fullName;
    }

    public function executeVerifySponsorId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            //if ($existUser->getDistributorId() <> $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
            $arr = array(
                'userId' => $existUser->getDistributorId(),
                'userName' => $existUser->getDistributorCode(),
                'fullname' => $existUser->getFullName(),
                'nickname' => $existUser->getNickname()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeVerifyMasterIBId()
    {
        $masterIbCode = $this->getRequestParameter('masterIbCode');

        $c = new Criteria();
        $c->add(MlmMasterIbPeer::MASTER_IB_CODE, $masterIbCode);
        $c->add(MlmMasterIbPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmMasterIbPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            $arr = array(
                'masterIbId' => $existUser->getMasterIbId(),
                'masterIbCode' => $existUser->getMasterIbCode(),
                'masterIbName' => $existUser->getMasterIbName()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeVerifyNickName()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::NICKNAME, $this->getRequestParameter('nickName'));
        $exist = MlmDistributorPeer::doSelectOne($c);

        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeFetchPackage()
    {
        $c = new Criteria();
        $packages = MlmPackagePeer::doSelect($c);

        $packageArray = array();
        $count = 0;
        foreach ($packages as $package) {
            $packageArray[$count]["packageId"] = $package->getPackageId();
            $packageArray[$count]["name"] = $this->getContext()->getI18N()->__($package->getPackageName());
            $packageArray[$count]["price"] = $package->getPrice() == null ? "" : $package->getPrice();
            $count++;
        }

        $arr = array(
            'package' => $packageArray
        );

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeDoRegister()
    {
        $sponsorDistId = Globals::SYSTEM_COMPANY_DIST_ID;

        $fcode = $this->generateFcode($this->getRequestParameter('country'));
        $password = $this->getRequestParameter('userpassword');
        $parentId = $this->getRequestParameter('sponsorId');
        $masterIbCode = $this->getRequestParameter('masterIbCode');
        //******************* upline distributor ID
        $uplineDistDB = $this->getDistributorInformation($parentId);
        $this->forward404Unless($uplineDistDB);

        $treeStructure = $uplineDistDB->getTreeStructure() . "|" . $fcode . "|";
        $treeLevel = $uplineDistDB->getTreeLevel() + 1;

        //******************** master IB
        $c = new Criteria();
        $c->add(MlmMasterIbPeer::MASTER_IB_CODE, $masterIbCode);
        $c->add(MlmMasterIbPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $masterIB = MlmMasterIbPeer::doSelectOne($c);
        $this->forward404Unless($masterIB);
        //******************** package
        $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($this->getRequestParameter('rankId'));
        $this->forward404Unless($sponsoredPackageDB);

        //******************** company account
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->add(MlmAccountPeer::DIST_ID, $sponsorDistId);
        $CompanyAccount = MlmAccountPeer::doSelectOne($c);
        $this->forward404Unless($CompanyAccount);

        $app_user = new AppUser();
        $app_user->setUsername($fcode);
        $app_user->setKeepPassword($password);
        $app_user->setUserpassword($password);
        $app_user->setKeepPassword2($password);
        $app_user->setUserpassword2($password);
        $app_user->setUserRole(Globals::ROLE_DISTRIBUTOR);
        $app_user->setStatusCode(Globals::STATUS_ACTIVE);
        $app_user->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $app_user->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $app_user->save();

        // ****************************
        $mlm_distributor = new MlmDistributor();
        $mlm_distributor->setDistributorCode($fcode);
        $mlm_distributor->setUserId($app_user->getUserId());
        $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
        $mlm_distributor->setFullName($this->getRequestParameter('fullname'));
        $mlm_distributor->setNickname($this->getRequestParameter('nickName'));
        $mlm_distributor->setIc($this->getRequestParameter('ic'));
        if ($this->getRequestParameter('country') == 'China') {
            $mlm_distributor->setCountry('China (PRC)');
        } else {
            $mlm_distributor->setCountry($this->getRequestParameter('country'));
        }
        $mlm_distributor->setAddress($this->getRequestParameter('address'));
        $mlm_distributor->setPostcode($this->getRequestParameter('postcode'));
        $mlm_distributor->setEmail($this->getRequestParameter('email'));
        $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
        $mlm_distributor->setGender($this->getRequestParameter('gender'));
        if ($this->getRequestParameter('dob')) {
            list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
            $mlm_distributor->setDob("$y-$m-$d");
        }
        $mlm_distributor->setTreeLevel($treeLevel);
        $mlm_distributor->setTreeStructure($treeStructure);
        $mlm_distributor->setMasterIbId($masterIB->getMasterIbId());
        $mlm_distributor->setMasterIbCode($masterIB->getMasterIbCode());
        $mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
        $mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());
        $mlm_distributor->setRankId($sponsoredPackageDB->getPackageId());
        $mlm_distributor->setRankCode($sponsoredPackageDB->getPackageName());

        $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
        $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccountNo'));
        $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));
        $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->save();

        $this->doSaveAccount($mlm_distributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");

        /* ****************************************************
         * get company last account ledger epoint balance
         * ***************************************************/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $sponsorDistId);
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
        $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
        $this->forward404Unless($accountLedgerDB);

        $sponsorAccountBalance = $accountLedgerDB->getBalance();

        /* ****************************************************
         * Update distributor account
         * ***************************************************/
        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($sponsorDistId);
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
        $mlm_account_ledger->setRemark("DIRECT SPONSOR TO " . $mlm_distributor->getDistributorCode());
        $mlm_account_ledger->setCredit(0);
        $mlm_account_ledger->setDebit($sponsoredPackageDB->getPrice());
        $mlm_account_ledger->setBalance($sponsorAccountBalance - $sponsoredPackageDB->getPrice());
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();

        $this->revalidateAccount($sponsorDistId, Globals::ACCOUNT_TYPE_ECASH);

        /**************************************/
        /*  Direct Sponsor Bonus For Upline
        /**************************************/
        $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());

        $directSponsorPercentage = $uplineDistPackage->getCommission();
        $directSponsorBonusAmount = $directSponsorPercentage * $sponsoredPackageDB->getPrice() / 100;

        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
        $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
        $this->forward404Unless($accountLedgerDB);
        $distAccountEcashBalance = $accountLedgerDB->getBalance();
        var_dump("here3");
        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($uplineDistDB->getDistributorId());
        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
        $mlm_account_ledger->setRemark("DIRECT SPONSOR BONUS AMOUNT (" . $mlm_distributor->getDistributorCode() . ")");
        $mlm_account_ledger->setCredit($directSponsorBonusAmount);
        $mlm_account_ledger->setDebit(0);
        $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();
        var_dump("here4");
        $this->revalidateAccount($uplineDistDB->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);
        var_dump("here5");
        /******************************/
        /*  Commission
        /******************************/
        $c = new Criteria();
        $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistDB->getDistributorId());
        $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
        $uplineDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);
        var_dump("here6");
        $commissionBalance = 0;
        if (!$uplineDistCommissionDB) {
            $uplineDistCommissionDB = new MlmDistCommission();
            $uplineDistCommissionDB->setDistId($uplineDistDB->getDistributorId());
            $uplineDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
            $uplineDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        } else {
            $commissionBalance = $uplineDistCommissionDB->getBalance();
        }
        $uplineDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
        $uplineDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $uplineDistCommissionDB->save();

        $c = new Criteria();
        $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
        $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
        $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
        $uplineDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

        $dsbBalance = 0;
        if ($uplineDistCommissionLedgerDB)
            $dsbBalance = $uplineDistCommissionLedgerDB->getBalance();

        $uplineDistCommissionledger = new MlmDistCommissionLedger();
        $uplineDistCommissionledger->setDistId($uplineDistDB->getDistributorId());
        $uplineDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
        $uplineDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_REGISTER);
        $uplineDistCommissionledger->setCredit($directSponsorBonusAmount);
        $uplineDistCommissionledger->setDebit(0);
        $uplineDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
        $uplineDistCommissionledger->setRemark("DIRECT SPONSOR BONUS AMOUNT (" . $mlm_distributor->getDistributorCode() . ")");
        $uplineDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $uplineDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $uplineDistCommissionledger->save();

        $this->revalidateCommission($uplineDistDB->getDistributorId(), Globals::COMMISSION_TYPE_DRB);
        /****************************/
        /*****  Send email **********/
        /****************************/
        error_reporting(E_STRICT);

        date_default_timezone_set(date_default_timezone_get());

        include_once('class.phpmailer.php');

        $subject = $this->getContext()->getI18N()->__("Forex International Group Registration email notification", null, 'email');
        $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $mlm_distributor->getNickname()), 'email') . ",<p><p>

        <p>" . $this->getContext()->getI18N()->__("Your registration request has been successfully sent to Forex International Group", null, 'email') . "</p>
        <p><b>" . $this->getContext()->getI18N()->__("Trader ID", null) . ": " . $fcode . "</b>
        <p><b>" . $this->getContext()->getI18N()->__("Password", null) . ": " . $password . "</b>";

        $mail = new PHPMailer();
        $mail->IsMail(); // telling the class to use SMTP
        $mail->Host = Mails::EMAIL_HOST; // SMTP server
        $mail->Sender = Mails::EMAIL_FROM_NOREPLY;
        $mail->From = Mails::EMAIL_FROM_NOREPLY;
        $mail->FromName = Mails::EMAIL_FROM_NOREPLY_NAME;
        $mail->Subject = $subject;
        $mail->CharSet = "utf-8";

        $text_body = $body;

        $mail->Body = $body;
        $mail->AltBody = $text_body;
        $mail->AddAddress($mlm_distributor->getEmail(), $mlm_distributor->getNickname());
        $mail->AddBCC("r9projecthost@gmail.com", "jason");

        if (!$mail->Send()) {
            echo $mail->ErrorInfo;
        }
        $this->setFlash("successMsg", "Trader has been registered successfully.<br><br>Your Trader ID : <span id='LabelMemberName'>" . $fcode . "</span>");
        return $this->redirect('/marketing/distAdd');
    }

    public function executeManipulateSponsorTree()
    {
        $parentId = $this->getRequestParameter('root');
        $arrTree = array();
        if ($parentId != "") {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $parentId);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $dists = MlmDistributorPeer::doSelect($c);

            $idx = 0;
            foreach ($dists as $dist)
            {
                $arrTree[$idx]["text"] = "<span class='gen_id'>" . $dist->getDistributorCode() . "</span> <span class='gen_active'>" . $dist->getFullname() . "</span> Joined " . date('Y-m-d', strtotime($dist->getCreatedOn())) . " " . $dist->getRankCode();
                // $arrTree[$idx]["text"] = "<span class='gen_img'><img src='http://www.eslfreedom.com/js/jqtree/images/node70.gif'></span><span class='gen_id'>Olga</span><span class='gen_active'>1300805</span>  <span class='gen_name'>Diamond - A</span><span class='gen_active'>Activated 01/01/1970</span> <span class='gen_jdate'>Joined 31/08/2011</span>";
                $arrTree[$idx]["id"] = $dist->getDistributorId();
                $arrTree[$idx]["hasChildren"] = $this->checkHasChild($dist->getDistributorId());
                $idx++;
            }
        }


        echo json_encode($arrTree);
        return sfView::HEADER_ONLY;
    }

    /************************************************************************************************************************
     * function
     ************************************************************************************************************************/
    function getParentId($sponsorId)
    {
        $userId = 0;

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        if ($existUser) {
            $userId = $existUser->getDistributorId();
        }

        return $userId;
    }

    function generateFcode($country = 'China (PRC)')
    {
        if ($country == 'Malaysia') {
            $max_digit = 999999;
            $digit = 6;
        } elseif ($country == 'Indonesia') {
            $max_digit = 9999999;
            $digit = 7;
        } elseif ($country == 'China (PRC)' || $country == 'China') {
            $max_digit = 99999999;
            $digit = 8;
        } else {
            $max_digit = 999999999;
            $digit = 9;
        }

        while (true) {
            $fcode = rand(0, $max_digit) . "";
            $fcode = str_pad($fcode, $digit, "0", STR_PAD_LEFT);
            /*
            for ($x=0; $x < ($digit - strlen($fcode)); $x++) {
                $fcode = "0".$fcode;
            }
			*/
            $c = new Criteria();
            $c->add(AppUserPeer::USERNAME, $fcode);
            $existUser = AppUserPeer::doSelectOne($c);

            if (!$existUser) {
                break;
            }
        }
        return $fcode;
    }

    function format2decimal($d)
    {
        return ceil($d * 100) / 100;
    }

    function checkHasChild($distId)
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $distId);
        $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $list = MlmDistributorPeer::doSelect($c);
        if ($list) {
            return true;
        }
        return false;
    }

    function getDistributorInformation($distCode)
    {
        $c = new Criteria();

        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $distDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($distDB);

        return $distDB;
    }

    function doSaveAccount($distId, $accountType, $credit, $debit, $transactionType, $remarks)
    {
        $mlm_account = new MlmAccount();
        $mlm_account->setDistId($distId);
        $mlm_account->setAccountType($accountType);
        $mlm_account->setBalance($credit - $debit);
        $mlm_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account->save();

        $mlm_account_ledger = new MlmAccountLedger();
        $mlm_account_ledger->setDistId($distId);
        $mlm_account_ledger->setAccountType($accountType);
        $mlm_account_ledger->setTransactionType($transactionType);
        $mlm_account_ledger->setRemark($remarks);
        $mlm_account_ledger->setCredit($credit);
        $mlm_account_ledger->setDebit($debit);
        $mlm_account_ledger->setBalance($credit - $debit);
        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_account_ledger->save();
    }

    function revalidateAccount($distributorId, $accountType)
    {
        $balance = $this->getAccountBalance($distributorId, $accountType);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, $accountType);
        $c->add(MlmAccountPeer::DIST_ID, $distributorId);
        $tbl_account = MlmAccountPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmAccount();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setAccountType($accountType);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
    }

    function revalidateCommission($distributorId, $commissionType)
    {
        $balance = $this->getCommissionBalance($distributorId, $commissionType);

        $c = new Criteria();
        $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, $commissionType);
        $c->add(MlmDistCommissionPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistCommissionPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistCommission();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setCommissionType($commissionType);
        }

        $tbl_account->setBalance($balance);
        $tbl_account->save();
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

    function getCommissionBalance($distributorId, $commissionType)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger WHERE dist_id = " . $distributorId . " AND commission_type = '" . $commissionType . "'";

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

    public function executeDownloadNric()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('q'));

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

    public function executeDownloadProofOfResidence()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('q'));

        if ($distDB) {
            $fileName = $distDB->getFileProofOfResidence();

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
            $response->setContentType('application/pdf');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/proofOfResidence/".$fileName);
        }

        return sfView::NONE;
    }

    public function executeDownloadBankPassBook()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('q'));

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