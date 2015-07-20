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
    public function executeCorrectDoublePairing()
    {
        $query = "SELECT * FROM maxim.mlm_dist_pairing_ledger
            WHERE
        remark LIKE '%(".$this->getRequestParameter('q').")%'
            AND created_on >= '2015-06-29 00:00:00'
        ORDER BY dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $distIdStr = "";
        while ($resultset->next()) {
            $arr = $resultset->getRow();
            var_dump("<br>".$arr['dist_id']);
            $pos = strrpos($distIdStr, "|".$arr['dist_id']."|");
            if ($pos === false) { // note: three equal signs

            } else {
                $mlmDistPairinLedgerDB = MlmDistPairingLedgerPeer::retrieveByPK($arr['pairing_id']);
                $mlmDistPairinLedgerDB->delete();
                var_dump("<br>remove".$arr['dist_id']);
            }

            $distIdStr = $distIdStr."|".$arr['dist_id']."|";
        }

        echo "ok";
        return sfView::HEADER_ONLY;
    }
    public function executeCorrectDoubleGdbSss()
    {
        $query = "SELECT count(*) as _total, descr, uid FROM maxim.gg_member_rtwallet_record
                where action_type = 'GDB SSS FROM MAXIM'
                group by descr, uid
                having _total > 1";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        while ($resultset->next()) {
            $arr = $resultset->getRow();
            var_dump("<br><br>".$arr['uid']);
            $remark = "";
            $amount = 0;

            $query2 = "select * from maxim.gg_member_rtwallet_record where uid= ".$arr["uid"]."
                        and action_type = 'GDB SSS FROM MAXIM'
                        order by descr";

            $statement2 = $connection->prepareStatement($query2);
            $resultset2 = $statement2->executeQuery();

            while ($resultset2->next()) {
                $arr2 = $resultset2->getRow();

                if ($remark == $arr2["descr"] && $amount == $arr2["amount"]) {
                    print_r("<br>DELETE == >".$arr2["id"]);
                    $ggMemberRtwalletRecordDB = GgMemberRtwalletRecordPeer::retrieveByPK($arr2["id"]);
                    $ggMemberRtwalletRecordDB->setDistId($ggMemberRtwalletRecordDB->getDistId() * -1);
                    $ggMemberRtwalletRecordDB->setDescr($remark."; Duplicated");
                    $ggMemberRtwalletRecordDB->save();
                } else {
                    $remark = $arr2["descr"];
                    $amount = $arr2["amount"];
                }
            }

            //break;
        }

        echo "ok";
        return sfView::HEADER_ONLY;
    }
    public function executeTestSssApplication()
    {
        $sssApplicationDB = SssApplicationPeer::retrieveByPK(3);
        $mlmDistributerDB = MlmDistributorPeer::retrieveByPK($sssApplicationDB->getDistId());

        if ($sssApplicationDB && $mlmDistributerDB) {
            $user_id = $mlmDistributerDB->getDistributorCode();
            $member_name = $mlmDistributerDB->getFullName();
            $member_home_address = $mlmDistributerDB->getAddress();
            $member_home_address2 = $mlmDistributerDB->getAddress2();
            $country = $mlmDistributerDB->getCountry();
            $member_current_email = $mlmDistributerDB->getEmail();
            $mobile = $mlmDistributerDB->getContact();
            $contract_date = date("Y-m-d", strtotime($sssApplicationDB->getCreatedOn()));
            $mt4_balance = number_format($sssApplicationDB->getMt4Balance(), 2);
            $cp23_balance = number_format($sssApplicationDB->getCp2Balance(), 2) . " & " . number_format($sssApplicationDB->getCp3Balance(), 2);
            $roi_remaining_month = $sssApplicationDB->getRoiRemainingMonth();
            $total_converted = number_format($sssApplicationDB->getTotalShareConverted(), 2);
            $dated_day = date("d", strtotime($sssApplicationDB->getCreatedOn()));
            $sign = $sssApplicationDB->getSignature();

            require_once("dompdf/dompdf_config.inc.php");

            $html = file_get_contents('assets/html_template/sss-application/template.html');

            // Apply parameters into html.
            $html = str_replace("%user_id%", $user_id, $html);
            $html = str_replace("%member_name%", $member_name, $html);
            $html = str_replace("%member_home_address%", $member_home_address, $html);
            $html = str_replace("%member_home_address2%", $member_home_address2, $html);
            $html = str_replace("%country%", $country, $html);
            $html = str_replace("%member_current_email%", $member_current_email, $html);
            $html = str_replace("%mobile%", $mobile, $html);
            $html = str_replace("%contract_date%", $contract_date, $html);
            $html = str_replace("%mt4_balance%", $mt4_balance, $html);
            $html = str_replace("%cp23_balance%", $cp23_balance, $html);
            $html = str_replace("%roi_remaining_month%", $roi_remaining_month, $html);
            $html = str_replace("%total_converted%", $total_converted, $html);
            $html = str_replace("%dated_day%", $dated_day, $html);
            $html = str_replace("%sign%", $sign, $html);

            $dompdf = new DOMPDF();
            $dompdf->set_paper('A4');
            $dompdf->load_html($html);
            $dompdf->render();
            $dompdf->stream("dispensation_application.pdf");
        }

        echo "ok";
        return sfView::HEADER_ONLY;
    }

    public function executeEventCalendar()
    {
        $act = $this->getRequestParameter("act");

        if ($act == "load") {
            // Ajax load data for calendar.
            $dateFrom = $this->getRequestParameter("start") . " 00:00:00";
            $dateTo = $this->getRequestParameter("end") . " 00:00:00";
            $data = array();

            $c = new Criteria();
            $c->add(MlmEventCalendarPeer::DATE_START, $dateFrom, Criteria::GREATER_EQUAL);
            $c->add(MlmEventCalendarPeer::DATE_END, $dateTo, Criteria::LESS_EQUAL);
            $mlmEventCalendarDB = MlmEventCalendarPeer::doSelect($c);

            foreach ($mlmEventCalendarDB as $event) {
                $arr = array(
                    "id" => $event->getId(),
                    "title" => $event->getEventTitle(),
                    "detail" => $event->getEventDetail(),
                    "all_day" => $event->getAllDay(),
                    "status_code" => $event->getStatusCode()
                );

                if ($event->getAllDay() == "Y") {
                    $arr["start"] = date("Y-m-d", strtotime($event->getDateStart()));
                } else {
                    $arr["start"] = $event->getDateStart();
                }

                if ($event->getDateEnd()) {
                    if ($event->getAllDay() == "Y") {
                        $arr["end"] = date("Y-m-d", strtotime($event->getDateEnd()));
                    } else {
                        $arr["end"] = $event->getDateEnd();
                    }
                }

                $data[] = $arr;
            }

            echo json_encode($data);
            return sfView::HEADER_ONLY;
        } elseif ($act == "new") {
            if ($this->getRequestParameter("event_id")) {
                // Update event.
                $mlmEventCalendarDB = MlmEventCalendarPeer::retrieveByPK($this->getRequestParameter("event_id"));
                $hasError = true;

                if ($mlmEventCalendarDB) {
                    $mlmEventCalendarDB->setEventTitle($this->getRequestParameter("event_title"));
                    $mlmEventCalendarDB->setEventDetail($this->getRequestParameter("event_detail"));
                    $mlmEventCalendarDB->setDateStart($this->getRequestParameter("date_start"));
                    $mlmEventCalendarDB->setDateEnd($this->getRequestParameter("date_end"));
                    $mlmEventCalendarDB->setAllDay(($this->getRequestParameter("all_day") == "Y" ? "Y" : "N"));
                    $mlmEventCalendarDB->setStatusCode($this->getRequestParameter("status_code"));
                    $mlmEventCalendarDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

                    $mlmEventCalendarDB->save();
                    $hasError = false;
                }

                if ($hasError) {
                    $this->setFlash("errorMsg", "Unable to save event. Please try again later.");
                } else {
                    $this->setFlash("successMsg", "Event saved successfully.");
                }
            } else {
                // Create new event.
                $mlmEventCalendarDB = new MlmEventCalendar();
                $mlmEventCalendarDB->setEventTitle($this->getRequestParameter("event_title"));
                $mlmEventCalendarDB->setEventDetail($this->getRequestParameter("event_detail"));
                $mlmEventCalendarDB->setDateStart($this->getRequestParameter("date_start"));
                $mlmEventCalendarDB->setDateEnd($this->getRequestParameter("date_end"));
                $mlmEventCalendarDB->setAllDay(($this->getRequestParameter("all_day") == "Y" ? "Y" : "N"));
                $mlmEventCalendarDB->setStatusCode($this->getRequestParameter("status_code"));
                $mlmEventCalendarDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmEventCalendarDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

                if ($mlmEventCalendarDB->save()) {
                    $this->setFlash("successMsg", "Event saved successfully.");
                } else {
                    $this->setFlash("errorMsg", "Unable to save event. Please try again later.");
                }
            }

            return $this->redirect("marketing/eventCalendar");
        } elseif ($act == "calendar") {
            // Save calendar grad & drop changes.
            $con = Propel::getConnection();
            $con->begin();

            try {
                $events = json_decode($this->getRequestParameter("events"));

                foreach ($events as $event) {
                    $mlmEventCalendarDB = MlmEventCalendarPeer::retrieveByPK($event->id);

                    if ($mlmEventCalendarDB) {
                        $mlmEventCalendarDB->setDateStart($event->date_start);
                        $mlmEventCalendarDB->setDateEnd($event->date_end);
                        $mlmEventCalendarDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

                        $mlmEventCalendarDB->save();
                    }
                }

                $con->commit();
                $this->setFlash("successMsg", "Event saved successfully.");
            } catch (Exception $e) {
                $con->rollback();
                $this->setFlash("errorMsg", "Unable to save event. Please try again later.");
            }

            return $this->redirect("marketing/eventCalendar");
        } elseif ($act == "delete") {
            $hasError = true;

            if ($this->getRequestParameter("event_id")) {
                // Delete event.
                $mlmEventCalendarDB = MlmEventCalendarPeer::retrieveByPK($this->getRequestParameter("event_id"));

                if ($mlmEventCalendarDB) {
                    $mlmEventCalendarDB->delete();
                    $hasError = false;
                }
            }

            if ($hasError) {
                $this->setFlash("errorMsg", "Unable to delete event. Please try again later.");
            } else {
                $this->setFlash("successMsg", "Event deleted successfully.");
            }

            return $this->redirect("marketing/eventCalendar");
        }
    }
    public function executeUploadMaterial()
    {
        if ($this->getRequestParameter("act")) {
            // Ajax call.
            if ($this->getRequestParameter("act") == "delete") {
                // Delete file.
                $mlmUploadMaterialDB = MlmUploadMaterialPeer::retrieveByPK($this->getRequestParameter("ref"));

                if ($mlmUploadMaterialDB) {
                    unlink(sfConfig::get('sf_upload_dir') . "/upload_material/" . $mlmUploadMaterialDB->getFileNameServer());
                }

                if ($mlmUploadMaterialDB->delete()) {
                    echo json_encode(["File deleted successfully."]);
                }
            }

            return sfView::HEADER_ONLY;
        }

        if ($this->getRequest()->getFileName('file_upload') != "") {
            $uploadFolder = sfConfig::get('sf_upload_dir') . "/upload_material/";

            $uploadedFilename = $this->getRequest()->getFileName('file_upload');
            $ext = explode(".", $uploadedFilename);
            $extensionName = $ext[count($ext) - 1];
            $newFilename = date("YmdHis") . "_" . rand(1000, 9999) . "." . $extensionName;
            $this->getRequest()->moveFile('file_upload', $uploadFolder . $newFilename);

            $fileSize = filesize($uploadFolder . $newFilename);

            if ($fileSize > 1024 * 1024 * 1024) {
                $fileSize = number_format(($fileSize / 1024 / 1024 / 1024), 2) . " GB";
            } elseif ($fileSize > 1024 * 1024) {
                $fileSize = number_format(($fileSize / 1024 / 1024), 2) . " MB";
            } elseif ($fileSize > 1024) {
                $fileSize = number_format(($fileSize / 1024), 2) . " KB";
            } else {
                $fileSize .= " Bytes";
            }

            $mlmUploadMaterialDB = new MlmUploadMaterial();
            $mlmUploadMaterialDB->setFileName($this->getRequestParameter("file_name"));
            $mlmUploadMaterialDB->setFileNameServer($newFilename);
            $mlmUploadMaterialDB->setFileExt($extensionName);
            $mlmUploadMaterialDB->setFileThumbnail($this->getRequestParameter("file_thumbnail"));
            $mlmUploadMaterialDB->setFileSize($fileSize);
            $mlmUploadMaterialDB->setStatusCode($this->getRequestParameter("status_code"));
            $mlmUploadMaterialDB->setDescription($this->getRequestParameter("description"));
            $mlmUploadMaterialDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmUploadMaterialDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmUploadMaterialDB->save();

            $this->setFlash('successMsg', "Files was successfully uploaded.");
            return $this->redirect('/marketing/uploadMaterial');
        }
    }
    public function executeDoRunPairingForMaturity()
    {
        $c = new Criteria();
        $c->add(NotificationOfMaturityPeer::EMAIL_STATUS, "PAIRING");
        //$c->setLimit(1);
        $notificationOfMaturitys = NotificationOfMaturityPeer::doSelect($c);

        foreach ($notificationOfMaturitys as $existNotificationOfMaturity) {
            $existDist = MlmDistributorPeer::retrieveByPK($existNotificationOfMaturity->getDistId());

            if (!$existDist) {
                continue;
            }

            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $existNotificationOfMaturity->getMt4UserName());
            $c->addDescendingOrderByColumn(MlmRoiDividendPeer::IDX);
            $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

            // store pairing point ++++++++++++++++++++++++++++++
            $uplinePosition = $existDist->getPlacementPosition();
            $uplineDistDB = MlmDistributorPeer::retrieveByPk($existDist->getTreeUplineDistId());

            $dateUtil = new DateUtil();

            $sponsoredDistributorCode = $existDist->getDistributorCode();
            $pairingPoint = $mlmRoiDividendDB->getPackagePrice();
            $pairingPointActual = $mlmRoiDividendDB->getPackagePrice();
            $exp_date = "2014-08-01 ";
            $todays_date = $dateUtil->formatDate("Y-m-d", $mlmRoiDividendDB->getDividendDate());
            $today = strtotime($todays_date);
            $expiration_date = strtotime($exp_date);
            print_r("<br>".$sponsoredDistributorCode);
            //if ()
            if ($expiration_date > $today) {

            } else {
                $pairingPoint = $mlmRoiDividendDB->getPackagePrice() * Globals::PAIRING_POINT_BV;
            }
            $level = 0;
            while ($level < 200) {
                //var_dump($uplineDistDB->getUplineDistId());
                //var_dump($uplineDistDB->getUplineDistCode());
                //print_r("<br>");
                $c = new Criteria();
                $c->add(MlmDistPairingPeer::DIST_ID, $uplineDistDB->getDistributorId());
                $sponsorDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                $addToLeft = 0;
                $addToRight = 0;
                $leftBalance = 0;
                $rightBalance = 0;
                if (!$sponsorDistPairingDB) {
                    $sponsorDistPairingDB = new MlmDistPairing();
                    $sponsorDistPairingDB->setDistId($uplineDistDB->getDistributorId());

                    $packageDB = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                    if (!$packageDB) {
                        $output = array(
                            "error" => true,
                            "errorMsg" => "Invalid Rank Id."
                        );
                        echo json_encode($output);
                        return sfView::HEADER_ONLY;
                    }

                    $sponsorDistPairingDB->setLeftBalance($leftBalance);
                    $sponsorDistPairingDB->setRightBalance($rightBalance);
                    $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                    $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                } else {
                    $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                    $rightBalance = $sponsorDistPairingDB->getRightBalance();
                }
                $sponsorDistPairingDB->setLeftBalance($leftBalance + $addToLeft);
                $sponsorDistPairingDB->setRightBalance($rightBalance + $addToRight);
                $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingDB->save();

                $c = new Criteria();
                $c->add(MlmDistPairingLedgerPeer::DIST_ID, $uplineDistDB->getDistributorId());
                $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $uplinePosition);
                $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
                $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

                $legBalance = 0;
                if ($sponsorDistPairingLedgerDB) {
                    $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                }

                $sponsorDistPairingledger = new MlmDistPairingLedger();
                $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                $sponsorDistPairingledger->setLeftRight($uplinePosition);
                $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                $sponsorDistPairingledger->setCredit($pairingPoint);
                $sponsorDistPairingledger->setCreditActual($pairingPointActual);
                $sponsorDistPairingledger->setDebit(0);
                $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") [MATURITY]");
                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistPairingledger->save();

                $this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                    break;
                }

                $uplinePosition = $uplineDistDB->getPlacementPosition();
                $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                $level++;
            }
            $existNotificationOfMaturity->setEmailStatus("COMPLETE");
            $existNotificationOfMaturity->save();
        }

        print_r("<br>Done");
        return sfView::NONE;
    }
    public function executeFindLeader()
    {
        $c = new Criteria();
        $c->addAnd(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('q'));
        $mlmDistributor = MlmDistributorPeer::doSelectOne($c);

        $leader = "";
        $leader2 = "";
        $leaderArrs = explode(",", Globals::GROUP_LEADER);

        if ($mlmDistributor) {
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($mlmDistributor->getTreeStructure(), "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }

            $dist = MlmDistributorPeer::retrieveByPK($mlmDistributor->getLeaderId());
            if ($dist) {
                $leader2 = $dist->getDistributorCode();
            }
        }
        print_r($this->getRequestParameter('q'). ": " .$leader. ": " .$leader2);
        return sfView::NONE;
    }
    public function executeUpdateKIV()
    {
        $mlmDistributor = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('distId'));

        if ($mlmDistributor) {
            $mlmDistributor->setKycRemark($this->getRequestParameter('kycRemark'));
            $mlmDistributor->setKycStatus($this->getRequestParameter('kycStatus'));

            if ($this->getRequestParameter('kycStatus') == "APPROVE") {
                $mlmDistributor->setkycUserId($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmDistributor->setkycDatetime(date("Y-m-d h:i:s"));
            }
            $mlmDistributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistributor->save();
        }

        return sfView::NONE;
    }
    public function executePersonalProfile()
    {
    }
    public function executeProofOfResidence()
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

            readfile(sfConfig::get('sf_upload_dir')."/proof_of_residence/".$fileName);
        }

        return sfView::NONE;
    }
    public function executeBankPassBook()
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
    public function executeNric()
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
    public function executeRetrievePersonalProfile()
    {
        $distributorDB = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('distId'));

        $arr = array(
            'fullName' => $distributorDB->getFullName()
            ,'country' => $distributorDB->getCountry()
            ,'dob' => $distributorDB->getDob()
            ,'address' => $distributorDB->getAddress()
            ,'address2' => $distributorDB->getAddress2()
            ,'city' => $distributorDB->getCity()
            ,'state' => $distributorDB->getState()
            ,'email' => $distributorDB->getEmail()
            ,'alternateEmail' => $distributorDB->getAlternateEmail()
            ,'contact' => $distributorDB->getContact()
            ,'gender' => $distributorDB->getGender()
            ,'nomineeName' => $distributorDB->getNomineeName()
            ,'nomineeRelationship' => $distributorDB->getNomineeRelationship()
            ,'nomineeIc' => $distributorDB->getNomineeIc()
            ,'nomineeContactNo' => $distributorDB->getNomineeContactNo()
            ,'bankName' => $distributorDB->getBankName()
            ,'bankBranchName' => $distributorDB->getBankBranchName()
            ,'bankAddress' => $distributorDB->getBankAddress()
            ,'bankCountry' => $distributorDB->getBankCountry()
            ,'bankAccountCurrency' => $distributorDB->getBankAccountCurrency()
            ,'bankAccNo' => $distributorDB->getBankAccNo()
            ,'bankHolderName' => $distributorDB->getBankHolderName()
            ,'bankSwiftCode' => $distributorDB->getBankSwiftCode()
            ,'bankCode' => $distributorDB->getBankCode()
            ,'visaDebitCard' => $distributorDB->getVisaDebitCard()
            ,'iaccountUsername' => $distributorDB->getIaccountUsername()
            ,'iaccount' => $distributorDB->getIaccount()
            ,'fileBankPassBook' => $distributorDB->getFileBankPassBook()
            ,'fileProofOfResidence' => $distributorDB->getFileProofOfResidence()
            ,'fileNric' => $distributorDB->getFileNric()
            ,'remark' => $distributorDB->getRemark()
            ,'kycRemark' => $distributorDB->getKycRemark()
            ,'kycStatus' => $distributorDB->getKycStatus()
        );

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executePackageUpgradeContract()
    {

    }
    public function executeEmailPIA()
    {
        $c = new Criteria();
        //$c->add(MlmPackageContractPeer::DIST_ID, 1);
        $c->add(MlmPackageContractPeer::EMAIL_STATUS, Globals::STATUS_PENDING);
        $c->setLimit(100);
        $mlmPackageContracts = MlmPackageContractPeer::doSelect($c);

        foreach ($mlmPackageContracts as $mlmPackageContract) {
            $mlmDistributor = MlmDistributorPeer::retrieveByPK($mlmPackageContract->getDistId());

            $successfulSent = $this->sendEmailForPIA($mlmPackageContract, $mlmDistributor);
            var_dump($successfulSent);
            if ($successfulSent == true) {
                $mlmPackageContract->setEmailStatus("SENT");
                $mlmPackageContract->save();
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeAnnouncementList()
    {
        if ($this->getRequestParameter('announcementStatus') && $this->getRequestParameter('announcementId')) {
            $error = false;
            $arr = $this->getRequestParameter('announcementId');
            $statusCode = $this->getRequestParameter('announcementStatus');

            $con = Propel::getConnection(AppNewsPeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $announcementDB = AppNewsPeer::retrieveByPk($arr[$i]);

                    if ($announcementDB) {
                        $announcementDB->setNsStatus($statusCode);
                        $announcementDB->setUpdatedby($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $announcementDB->save();
                    } else {
                        $error = true;
                    }
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                $error = true;
                throw $e;
            }

            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
            else
                $this->setFlash('errorMsg', "Warning: some records are not able to be saved.");

            return $this->redirect('marketing/announcementList');
        }
    }

    public function executeAnnouncementDetail()
    {
        $announcementId = $this->getRequestParameter("announcementId", 0);

        if ($announcementId > 0) {
            $announcementDB = AppNewsPeer::retrieveByPK($announcementId);
        } else {
            $announcementDB = null;
        }

        if ($this->getRequestParameter("act") == "doSave") {
            // Add or edit record.
            if ($announcementDB == null) {
                $announcementDB = new AppNews();
                $announcementDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            }

            $announcementDB->setNsTitle(trim($this->getRequestParameter("title")));
            $announcementDB->setNsContent(trim($this->getRequestParameter("content")));
            $announcementDB->setNsStatus($this->getRequestParameter("status"));
            $announcementDB->setNsStartDate($this->getRequestParameter("startDate") . " 00:00:00");
            $announcementDB->setNsEndDate($this->getRequestParameter("endDate") . " 00:00:00");
            $announcementDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $announcementDB->save();

            $this->setFlash("successMsg", "Record saved successfully.");
        } elseif ($announcementDB && $this->getRequestParameter("act") == "doDelete") {
            // Delete record.
            $announcementDB->delete();

            $this->setFlash("successMsg", "Record deleted successfully.");
            return $this->redirect("marketing/announcementList");
        }

        if ($announcementDB) {
            $this->title = $announcementDB->getNsTitle();
            $this->content = $announcementDB->getNsContent();
            $this->status = $announcementDB->getNsStatus();
            $this->startDate = date("Y-m-d", strtotime($announcementDB->getNsStartDate()));
            $this->endDate = date("Y-m-d", strtotime($announcementDB->getNsEndDate()));
            $this->announcementId = $announcementDB->getId();
        } else {
            // Record not found, reset id to 0.
            $this->announcementId = 0;
        }
    }

    public function executeCreateMt4Account()
    {
        $c = new Criteria();
        $c->add(MlmDistMt4Peer::MT4_ID, 63019, Criteria::GREATER_EQUAL);
        $c->addAnd(MlmDistMt4Peer::MT4_ID, 63111, Criteria::LESS_EQUAL);
        //$c->add(MlmDistMt4Peer::MT4_USER_NAME, 8070899, Criteria::LESS_EQUAL);
        $mlmDistMt4DBs = MlmDistMt4Peer::doSelect($c);

        foreach ($mlmDistMt4DBs as $mlmDistMt4DB) {
            print_r($mlmDistMt4DB->getDistId());
            print_r("<br>");
            print_r($mlmDistMt4DB->getMt4UserName());
            print_r("<br>");
            $tbl_distributor = MlmDistributorPeer::retrieveByPK($mlmDistMt4DB->getDistId());
            $packageDB = MlmPackagePeer::retrieveByPK($mlmDistMt4DB->getRankId());

            $leader = "";
            $leaderArrs = explode(",", Globals::GROUP_LEADER);
            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($tbl_distributor->getTreeStructure(), "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }
            $mt4Id = $mlmDistMt4DB->getMt4UserName();
            $mt4Password = $mlmDistMt4DB->getMt4Password();
            $groupName = $packageDB->getMt4GroupName();
            $packagePrice = $packageDB->getPrice();

            $mt4request = new CMT4DataReciver;
            $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

            $params['array'] = array();
            $params['group'] = $groupName;
            //                    $params['group'] = "MX10000";
            //        $params['group'] = "KLTEST";
            $params['agent'] = null;
            $params['login'] = $mt4Id;
            //        $params['country'] = $mlm_distributor->getCountry();
            $params['country'] = "";
            $params['state'] = "";
            $params['city'] = $leader;
            //        $params['city'] = "";
            $params['address'] = $tbl_distributor->getDistributorCode();
            $params['name'] = $tbl_distributor->getFullName();
            $params['email'] = $tbl_distributor->getEmail();
            $params['password'] = $mt4Password;
            //        $params['password'] = "qwer1234";
            $params['password_investor'] = "123abc";
            $params['password_phone'] = null;
            $params['leverage'] = "100";
            //$params['leverage'] = $this->getRequestParameter('leverage');      2
            $params['zipcode'] = "";
            $params['phone'] = $packagePrice; // package price
            $params['id'] = '';
            $params['comment'] = "";
            var_dump($params);
            $answer = $mt4request->MakeRequest("createaccount", $params);

            if ($answer['result'] != 1) {
                var_dump($answer["reason"]);
                return sfView::HEADER_ONLY;
            }
            else
            {
                $params = array();
                $params['login'] 	= $answer['login'];
                $params['value'] 	= $packagePrice; // above zero for deposits, below zero for withdraws
                $params['comment'] 	= "Deposit Funds";
                $answer = $mt4request->MakeRequest("changebalance", $params);
                print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$packagePrice.".</p>";
            }
            $mt4request->CloseConnection();
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoGetAccount()
    {

    }
    public function executeDoUpdateContract()
    {
        $str = "2570,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2584,2585,2586,2587,2588,2589,2590,2591,2592,2593,2594,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2606,2607,2608,2609,2610,2611,2612,2613,2614,2615,2616,2617,2618,2619,2620,2621,2622,2623,2624,2625,2626,2627,2628,2629,2630,2631,2632,2633,2634,2635,2636,2637,2638,2639,2640,2641,2642,2643,2644,2645,2646,2647,2648,2649,2650,2651,2652,2653,2654,2655,2656,2657,2658,2659,2660,2661,2662,2663,2664,2665,2666,2667,2668,2669,2670,2671,2672,2673,2674,2675,2676,2677,2678,2679,2680,2681,2682,2683,2684,2685,2686,2687,2688,2689,2690,2691,2692,2693,2694,2695,2696,2697,2698,2699,2700,2701,2702,2703,2704,2705,2706,2707,2708,2709,2710,2711,2712,2713,2714,2715,2716,2717,2718,2719,2720,2721,2722,2723,2724,2725,2726,2727,2728,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2740,2741,2742,2743,2744,2745,2746,2747,2748,2749,2750,2751,2752,2753,2754,2755,2756,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2774,2775,2776,2777,2778,2779,2780,2781,2782,2783,2784,2785,2786,2787,2788,2789,2790,2791,2792,2793,2794,2795,2796,2797,2798,2799,2800,2801";

        $memberIdArrs = explode(",", $str);

        for ($i = 0; $i < count($memberIdArrs); $i++) {
            $packageUpgradeHistoryDB = MlmPackageUpgradeHistoryPeer::retrieveByPK($memberIdArrs[$i]);
            $tbl_distributor = MlmDistributorPeer::retrieveByPK($packageUpgradeHistoryDB->getDistId());
            $userDB = AppUserPeer::retrieveByPK($tbl_distributor->getUserId());

            $currentDate_timestamp = strtotime($packageUpgradeHistoryDB->getCreatedOn());

            $c = new Criteria();
            $c->add(MlmDistMt4Peer::MT4_USER_NAME, $packageUpgradeHistoryDB->getMt4UserName());
            $mlmDistMt4DB = MlmDistMt4Peer::doSelectOne($c);

            $mlmPackageContract = new MlmPackageContract();
            $mlmPackageContract->setDistId($tbl_distributor->getDistributorId());
            $mlmPackageContract->setFullName($tbl_distributor->getFullName());
            $mlmPackageContract->setUsername($userDB->getUsername());
            $mlmPackageContract->setMt4Id($packageUpgradeHistoryDB->getMt4UserName());
            $mlmPackageContract->setPackagePrice($packageUpgradeHistoryDB->getAmount());
            $mlmPackageContract->setEmailStatus(Globals::STATUS_PENDING);
            $mlmPackageContract->setSignDateDay(date("d", $currentDate_timestamp));
            $mlmPackageContract->setSignDateMonth(date("F", $currentDate_timestamp));
            $mlmPackageContract->setSignDateYear(date("Y", $currentDate_timestamp));
            $mlmPackageContract->setInitialSignature($tbl_distributor->getSignName());
            $mlmPackageContract->setDistMt4Id($mlmDistMt4DB->getMt4Id());
            $mlmPackageContract->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmPackageContract->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmPackageContract->save();
        }
    }
    public function executeDoUpdatePackagePurchaseViaAuto()
    {
        $c = new Criteria();
//        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->add(MlmDistributorPeer::PACKAGE_PURCHASE_FLAG, "Y");
//        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, 1);
        $c->setLimit(15);
        $distributorDBs = MlmDistributorPeer::doSelect($c);

        if (count($distributorDBs) > 0) {
            foreach ($distributorDBs as $tbl_distributor) {
                $con = Propel::getConnection(MlmPipCsvPeer::DATABASE_NAME);
                $error = false;
                $errorMessage = "";

                try {
                    $con->begin();

                    $encryptionKey = Globals::MT4_ENCRYPTIONKEY;
                    $secretHash = Globals::MT4_SECRETHASH;

                    $c = new Criteria();
                    $c->add(AppSettingPeer::SETTING_PARAMETER, "MT4_ID");
                    $appSettingDB = AppSettingPeer::doSelectOne($c);

                    if (!$appSettingDB) {
                        print_r("Error, MT4 ID not exits");
                        return sfView::HEADER_ONLY;
                    }

                    $mt4Id = $appSettingDB->getSettingValue();
                    $mt4Password = $this->generateMt4Password();

                    $c = new Criteria();
                    $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Id);
                    $mlmDistMt4DB = MlmDistMt4Peer::doSelectOne($c);

                    if (!$mlmDistMt4DB) {
                        print_r("<br>Distributor ID:".$tbl_distributor->getDistributorId().", Distributor Code:".$tbl_distributor->getDistributorCode().", MT4:".$mt4Id);
                        $packageDB = MlmPackagePeer::retrieveByPK($tbl_distributor->getInitRankId());
                        if ($tbl_distributor->getDebitAccount() == "Y") {
                            $packageDB = MlmPackagePeer::retrieveByPK($tbl_distributor->getDebitRankId());
                        }

                        $leader = "";
                        $leaderArrs = explode(",", Globals::GROUP_LEADER);
                        for ($i = 0; $i < count($leaderArrs); $i++) {
                            $pos = strrpos($tbl_distributor->getTreeStructure(), "|".$leaderArrs[$i]."|");
                            if ($pos === false) { // note: three equal signs

                            } else {
                                $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                                if ($dist) {
                                    $leader = $dist->getDistributorCode();
                                }
                                break;
                            }
                        }
                        $groupName = $packageDB->getMt4GroupName();
                        $packagePrice = $packageDB->getPrice();

                        $mt4request = new CMT4DataReciver;
                        $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

                        $params['array'] = array();
                        $params['group'] = $groupName;
                        //                    $params['group'] = "MX10000";
                        //        $params['group'] = "KLTEST";
                        $params['agent'] = null;
                        $params['login'] = $mt4Id;
                        //        $params['country'] = $mlm_distributor->getCountry();
                        $params['country'] = "";
                        $params['state'] = "";
                        $params['city'] = $leader;
                        //        $params['city'] = "";
                        $params['address'] = $tbl_distributor->getDistributorCode();
                        $params['name'] = $tbl_distributor->getFullName();
                        $params['email'] = $tbl_distributor->getEmail();
                        $params['password'] = $mt4Password;
                        //        $params['password'] = "qwer1234";
                        $params['password_investor'] = "123abc";
                        $params['password_phone'] = null;
                        $params['leverage'] = "100";
                        //$params['leverage'] = $this->getRequestParameter('leverage');      2
                        $params['zipcode'] = "";
                        $params['phone'] = $packagePrice; // package price
                        $params['id'] = '';
                        $params['comment'] = "";
                        var_dump($params);
                        $answer = $mt4request->MakeRequest("createaccount", $params);

                        if ($answer['result'] != 1) {
                            var_dump($answer["reason"]);

                            $params = array();
                            $params['login'] = $mt4Id;

                            $answer = $mt4request->MakeRequest("getaccountbalance", $params);
                            var_dump("<br>getaccountbalance<br>");
                            var_dump($answer);
                            if ($answer == null || is_numeric($answer['balance']) == false) {

                            } else {
                                $appSettingDB->setSettingValue($mt4Id + 1);
                                $appSettingDB->save();
                            }

                            $mt4request->CloseConnection();
                            //return sfView::HEADER_ONLY;
                        } else {
                            $params = array();
                            $params['login'] 	= $answer['login'];
                            $params['value'] 	= $packagePrice; // above zero for deposits, below zero for withdraws
                            $params['comment'] 	= "Deposit Funds";
                            $answer = $mt4request->MakeRequest("changebalance", $params);

                            var_dump("<br>changebalance<br>");
                            var_dump($answer);

                            if ($answer['result'] != 1) {
                                print "<p style='background-color:red'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$packagePrice.".</p>";
                            }
                            print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$packagePrice.".</p>";

                            $mt4request->CloseConnection();

                            $tbl_distributor->setPackagePurchaseFlag("N");
                            $tbl_distributor->save();

                            $mlm_dist_mt4 = new MlmDistMt4();
                            $mlm_dist_mt4->setDistId($tbl_distributor->getDistributorId());
                            $mlm_dist_mt4->setRankId($tbl_distributor->getInitRankId());
                            $mlm_dist_mt4->setMt4UserName($mt4Id);
                            $mlm_dist_mt4->setMt4Password($mt4Password);
                            $mlm_dist_mt4->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_dist_mt4->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_dist_mt4->save();

                            /* ****************************************************
                           * ROI Divident
                           * ***************************************************/
                            $dateUtil = new DateUtil();
                            $currentDate = $dateUtil->formatDate("Y-m-d", $tbl_distributor->getActiveDatetime()) . " 00:00:00";
                            $currentDate_timestamp = strtotime($currentDate);
                            //$dividendDate = $dateUtil->addDate($currentDate, 30, 0, 0);


                            // MV168 all referrer exceeded 3% will transfer to his account
                            $exceedRoiSpecialCase = false;
                            $pos = strrpos($tbl_distributor->getTreeStructure(), "|295032|");
                            if ($pos === false) { // note: three equal signs

                            } else {
                                $exceedRoiSpecialCase = true;
                            }

                            for ($idx = 1; $idx <= 18; $idx++) {
                                $dividendDate = strtotime("+".$idx." months", $currentDate_timestamp);

                                $mlm_roi_dividend = new MlmRoiDividend();
                                $mlm_roi_dividend->setDistId($tbl_distributor->getDistributorId());
                                $mlm_roi_dividend->setIdx($idx);
                                $mlm_roi_dividend->setMt4UserName($mt4Id);
                                //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                                $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                                $mlm_roi_dividend->setFirstDividendDate(date("Y-m-d h:i:s", $currentDate_timestamp));
                                $mlm_roi_dividend->setPackageId($packageDB->getPackageId());
                                $mlm_roi_dividend->setPackagePrice($packageDB->getPrice());

                                if ($exceedRoiSpecialCase == false) {
                                    $mlm_roi_dividend->setRoiPercentage($packageDB->getMonthlyPerformance());
                                    $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                                } else {
                                    $roi = $packageDB->getMonthlyPerformance();
                                    $exceedRoi = 0;
                                    if ($roi > 3) {
                                        $exceedRoi = $roi - 3;
                                        $roi = $roi - 3;
                                    }
                                    $mlm_roi_dividend->setRoiPercentage($roi);
                                    $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                                    $mlm_roi_dividend->setExceedDistId(295032);
                                    $mlm_roi_dividend->setExceedRoiPercentage($exceedRoi);
                                }

                                //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                                //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                                $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_roi_dividend->save();
                            }

                            $userDB = AppUserPeer::retrieveByPK($tbl_distributor->getUserId());

                            $mlmPackageContract = new MlmPackageContract();
                            $mlmPackageContract->setDistId($tbl_distributor->getDistributorId());
                            $mlmPackageContract->setFullName($tbl_distributor->getFullName());
                            $mlmPackageContract->setUsername($userDB->getUsername());
                            $mlmPackageContract->setMt4Id($mlm_roi_dividend->getMt4UserName());
                            $mlmPackageContract->setPackagePrice($packageDB->getPrice());
                            $mlmPackageContract->setEmailStatus(Globals::STATUS_PENDING);
                            $mlmPackageContract->setSignDateDay(date("d", $currentDate_timestamp));
                            $mlmPackageContract->setSignDateMonth(date("F", $currentDate_timestamp));
                            $mlmPackageContract->setSignDateYear(date("Y", $currentDate_timestamp));
                            $mlmPackageContract->setInitialSignature($tbl_distributor->getSignName());
                            $mlmPackageContract->setDistMt4Id($mlm_dist_mt4->getMt4Id());
                            if ($exceedRoiSpecialCase == false) {
                                $mlmPackageContract->setStatusCode(Globals::STATUS_ACTIVE);
                            } else {
                                $mlmPackageContract->setStatusCode(Globals::STATUS_COMPLETE);
                            }
                            $mlmPackageContract->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlmPackageContract->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlmPackageContract->save();

                            $appSettingDB->setSettingValue($mt4Id + 1);
                            $appSettingDB->save();

                            //$tbl_distributor->setPackagePurchaseFlag("N");
                            //$tbl_distributor->save();

                            $this->sendEmailForMt4($mt4Id, $mt4Password, $tbl_distributor->getFullName(), $tbl_distributor->getEmail(), $tbl_distributor);
                        }
                    } else {
                        print_r($errorMessage);
                        return sfView::HEADER_ONLY;

                        break;
                    }
                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
            }
        } else {
            $c = new Criteria();
            $c->add(MlmPackageUpgradeHistoryPeer::STATUS_CODE, "ACTIVE");
            $c->add(MlmPackageUpgradeHistoryPeer::TRANSACTION_CODE, "PACKAGE UPGRADE");
            //$c->add(MlmDistributorPeer::DISTRIBUTOR_ID, 1);
            $c->setLimit(30);
            $packageUpgradeHistoryDBs = MlmPackageUpgradeHistoryPeer::doSelect($c);

            foreach ($packageUpgradeHistoryDBs as $packageUpgradeHistoryDB) {
                $con = Propel::getConnection(MlmPipCsvPeer::DATABASE_NAME);
                $error = false;
                $errorMessage = "";

                try {
                    $con->begin();

                    $c = new Criteria();
                    $c->add(AppSettingPeer::SETTING_PARAMETER, "MT4_ID");
                    $appSettingDB = AppSettingPeer::doSelectOne($c);

                    if (!$appSettingDB) {
                        print_r("Error, MT4 ID not exits");
                        return sfView::HEADER_ONLY;
                    }
                    $tbl_distributor = MlmDistributorPeer::retrieveByPK($packageUpgradeHistoryDB->getDistId());
                    $mt4Id = $appSettingDB->getSettingValue();
                    $mt4Password = $this->generateMt4Password();
                    $password = $mt4Password;
                    print_r("<br>Distributor ID:".$tbl_distributor->getDistributorId().", Distributor Code:".$tbl_distributor->getDistributorCode().", MT4:".$mt4Id);

                    $packageDB = MlmPackagePeer::retrieveByPK($packageUpgradeHistoryDB->getPackageId());
                    $leader = "";
                    $leaderArrs = explode(",", Globals::GROUP_LEADER);
                    for ($i = 0; $i < count($leaderArrs); $i++) {
                        $pos = strrpos($tbl_distributor->getTreeStructure(), "|".$leaderArrs[$i]."|");
                        if ($pos === false) { // note: three equal signs

                        } else {
                            $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                            if ($dist) {
                                $leader = $dist->getDistributorCode();
                            }
                            break;
                        }
                    }
                    $groupName = $packageDB->getMt4GroupName();
                    $packagePrice = $packageDB->getPrice();

                    $mt4request = new CMT4DataReciver;
                    $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

                    $params['array'] = array();
                    $params['group'] = $groupName;
                    //                    $params['group'] = "MX10000";
                    //        $params['group'] = "KLTEST";
                    $params['agent'] = null;
                    $params['login'] = $mt4Id;
                    //        $params['country'] = $mlm_distributor->getCountry();
                    $params['country'] = "";
                    $params['state'] = "";
                    $params['city'] = $leader;
                    //        $params['city'] = "";
                    $params['address'] = $tbl_distributor->getDistributorCode();
                    $params['name'] = $tbl_distributor->getFullName();
                    $params['email'] = $tbl_distributor->getEmail();
                    $params['password'] = $mt4Password;
                    //        $params['password'] = "qwer1234";
                    $params['password_investor'] = "123abc";
                    $params['password_phone'] = null;
                    $params['leverage'] = "100";
                    //$params['leverage'] = $this->getRequestParameter('leverage');      2
                    $params['zipcode'] = "";
                    $params['phone'] = $packagePrice; // package price
                    $params['id'] = '';
                    $params['comment'] = "";
                    var_dump($params);
                    $answer = $mt4request->MakeRequest("createaccount", $params);

                    if ($answer['result'] != 1) {
                        var_dump($answer["reason"]);
                        return sfView::HEADER_ONLY;
                    }
                    else
                    {
                        $params = array();
                        $params['login'] 	= $answer['login'];
                        $params['value'] 	= $packagePrice; // above zero for deposits, below zero for withdraws
                        $params['comment'] 	= "Deposit Funds";
                        $answer = $mt4request->MakeRequest("changebalance", $params);
                        print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$packagePrice.".</p>";
                    }
                    $mt4request->CloseConnection();

                    $mlm_dist_mt4 = new MlmDistMt4();
                    $mlm_dist_mt4->setDistId($packageUpgradeHistoryDB->getDistId());
                    $mlm_dist_mt4->setMt4UserName($mt4Id);
                    $mlm_dist_mt4->setMt4Password($password);
                    $mlm_dist_mt4->setRankId($packageUpgradeHistoryDB->getPackageId());
                    $mlm_dist_mt4->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_dist_mt4->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_dist_mt4->save();

                    /* ****************************************************
                   * ROI Divident
                   * ***************************************************/
                    $dateUtil = new DateUtil();
                    $currentDate = $dateUtil->formatDate("Y-m-d", $packageUpgradeHistoryDB->getCreatedOn()) . " 00:00:00";
                    $currentDate_timestamp = strtotime($currentDate);
                    $firstDividendDate = strtotime("+1 months", $currentDate_timestamp);

                    // MV168 all referrer exceeded 3% will transfer to his account
                    $exceedRoiSpecialCase = false;
                    $pos = strrpos($tbl_distributor->getTreeStructure(), "|295032|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $exceedRoiSpecialCase = true;
                    }

                    for ($x=1; $x <= 18; $x++) {
                        $dividendDate = strtotime("+" . $x . " months", $currentDate_timestamp);

                        $mlm_roi_dividend = new MlmRoiDividend();
                        $mlm_roi_dividend->setDistId($tbl_distributor->getDistributorId());
                        $mlm_roi_dividend->setIdx($x);
                        $mlm_roi_dividend->setMt4UserName($mt4Id);
                        //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                        $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                        $mlm_roi_dividend->setFirstDividendDate(date("Y-m-d h:i:s", $currentDate_timestamp));
                        $mlm_roi_dividend->setPackageId($packageDB->getPackageId());
                        $mlm_roi_dividend->setPackagePrice($packageDB->getPrice());
                        if ($exceedRoiSpecialCase == false) {
                            $mlm_roi_dividend->setRoiPercentage($packageDB->getMonthlyPerformance());
                            $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                        } else {
                            $roi = $packageDB->getMonthlyPerformance();
                            $exceedRoi = 0;
                            if ($roi > 3) {
                                $exceedRoi = $roi - 3;
                                $roi = $roi - 3;
                            }
                            $mlm_roi_dividend->setRoiPercentage($roi);
                            $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                            $mlm_roi_dividend->setExceedDistId(295032);
                            $mlm_roi_dividend->setExceedRoiPercentage($exceedRoi);
                        }
                        //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                        //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                        $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->save();
                    }

                    $userDB = AppUserPeer::retrieveByPK($tbl_distributor->getUserId());

                    $mlmPackageContract = new MlmPackageContract();
                    $mlmPackageContract->setDistId($tbl_distributor->getDistributorId());
                    $mlmPackageContract->setFullName($tbl_distributor->getFullName());
                    $mlmPackageContract->setUsername($userDB->getUsername());
                    $mlmPackageContract->setMt4Id($mt4Id);
                    $mlmPackageContract->setPackagePrice($packageDB->getPrice());
                    $mlmPackageContract->setEmailStatus(Globals::STATUS_PENDING);
                    $mlmPackageContract->setSignDateDay(date("d", $currentDate_timestamp));
                    $mlmPackageContract->setSignDateMonth(date("F", $currentDate_timestamp));
                    $mlmPackageContract->setSignDateYear(date("Y", $currentDate_timestamp));
                    $mlmPackageContract->setInitialSignature($tbl_distributor->getSignName());
                    $mlmPackageContract->setDistMt4Id($mlm_dist_mt4->getMt4Id());
                    if ($exceedRoiSpecialCase == false) {
                        $mlmPackageContract->setStatusCode(Globals::STATUS_ACTIVE);
                    } else {
                        $mlmPackageContract->setStatusCode(Globals::STATUS_COMPLETE);
                    }
                    $mlmPackageContract->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageContract->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageContract->save();

                    $appSettingDB->setSettingValue($mt4Id + 1);
                    $appSettingDB->save();

                    $packageUpgradeHistoryDB->setMt4UserName($mt4Id);
                    $packageUpgradeHistoryDB->setMt4Password($mt4Password);
                    $packageUpgradeHistoryDB->setRemarks("");
                    $packageUpgradeHistoryDB->setStatusCode(Globals::STATUS_COMPLETE);
                    $packageUpgradeHistoryDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

                    $packageUpgradeHistoryDB->save();

                    $this->sendEmailForMt4($mt4Id, $mt4Password, $tbl_distributor->getFullName(), $tbl_distributor->getEmail());

                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeUnlockBulkGenealogy()
    {
        $bulkContent = $this->getRequestParameter('bulkContent');

        $lineArr = explode("\n", $bulkContent); // break line
//        $arr = explode("Username:", $bulkContent);

        $idx = 1;
        foreach ($lineArr as $line) {
            $strArr = explode("Username:", $line);

            if (count($strArr) < 2) {
                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, trim($strArr[0]));
                $distDB = MlmDistributorPeer::doSelectOne($c);

                if ($distDB) {
                    print_r($strArr[0]."Open Successfully<br><br>");
                    $distDB->setHideGenealogy("N");
                    $distDB->save();
                } else {
                    var_dump("=================>");
                    var_dump($strArr);
                    print_r("<br>");
                }
            } else {
                print_r($idx."<br><br>");
                $memberId = trim($strArr[1]);

                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $memberId);
                $distDB = MlmDistributorPeer::doSelectOne($c);

                if ($distDB) {
                    print_r($memberId."Open Successfully<br><br>");
                    $distDB->setHideGenealogy("N");
                    $distDB->save();
                } else {
                    print_r("<br><br>++++++++++++++++++++ No exist ++++++++++".$memberId);
                }
                $idx++;
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeFindPassword()
    {
        $bulkContent = $this->getRequestParameter('bulkContentHiddenPassword');

        $lineArr = explode("\n", $bulkContent); // break line
//        $arr = explode("Username:", $bulkContent);

        $idx = 1;
        foreach ($lineArr as $line) {
            $strArr = explode("Username:", $line);

            if ($idx == 1) {
                if (trim($line) != date("Ymd")) {
                    break;
                }

                $idx++;
                continue;
            }

            $c = new Criteria();
            $c->add(AppUserPeer::USERNAME, trim($line));
            $appUserDB = AppUserPeer::doSelectOne($c);

            if ($appUserDB) {
                print_r("<br><br>");
                print_r($line."<br>P1: ".$appUserDB->getUserpassword()."<br>P2: ".$appUserDB->getUserpassword2()."<br><br>");
            } else {
                var_dump("=================>");
                var_dump($strArr);
                print_r("<br>");
            }
            $idx++;
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoRoiNoReturn()
    {
        $accountTypeArr = array(265754,265733,265734,265750,265738,265755,265756,265714,265751,265752,265753,265737,265736,265735,265726,265727,265749,265741,265740,265739);

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $accountTypeArr, Criteria::IN);
        $distDBs = MlmDistributorPeer::doSelect($c);
        $idx = 1;
        foreach ($distDBs as $distDB) {
            print_r($idx++ . ":" . $distDB->getDistributorId() . "<br>");

            $distDB->setPrincipleReturn("N");
            $distDB->save();

            /*$mlm_roi_dividend = new MlmRoiDividend();
            $mlm_roi_dividend->setDistId($tbl_distributor->getDistributorId());
            $mlm_roi_dividend->setIdx(1);
            $mlm_roi_dividend->setMt4UserName($this->getRequestParameter('mt4_user_name'));
            //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
            $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
            $mlm_roi_dividend->setFirstDividendDate(date("Y-m-d h:i:s", $dividendDate));
            $mlm_roi_dividend->setPackageId($packageDB->getPackageId());
            $mlm_roi_dividend->setPackagePrice($packageDB->getPrice());
            $mlm_roi_dividend->setRoiPercentage($packageDB->getMonthlyPerformance());
            //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
            //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
            $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
            $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_roi_dividend->save();*/
        }
        return sfView::HEADER_ONLY;
    }
    public function executeDoSendEmail()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::EMAIL, "hong_gsn2u@yahoo.com");
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);
        foreach ($distDBs as $distDB) {
            print_r($idx-- . "<br>");
            $tbl_user = AppUserPeer::retrieveByPk($distDB->getUserId());
            $this->sendEmailForLoginPassword($distDB, $tbl_user->getUsername(), $tbl_user->getUserpassword(), $tbl_user->getUserpassword2());
        }
        return sfView::HEADER_ONLY;
    }
    public function executeDoSendAbfxMT4()
    {
        $c = new Criteria();
        $c->add(AbfxDistMt4Peer::STATUS_CODE, "COMPLETE");
        $abfxDistMt4s = AbfxDistMt4Peer::doSelect($c);

        foreach ($abfxDistMt4s as $abfxDistMt4) {
            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $abfxDistMt4->getDistId());
            $distMt4s = MlmDistMt4Peer::doSelect($c);

            if (count($distMt4s) >= 1) {
                foreach ($distMt4s as $distMt4) {
                    $result = $this->sendEmailForMt4($distMt4->getMt4UserName(), $distMt4->getMt4Password(), $abfxDistMt4->getFullName(), $abfxDistMt4->getEmail());
                    if ($result != "") {
                        $abfxDistMt4->setStatusCode("ERROR");
                        $abfxDistMt4->save();
                    } else {
                        $abfxDistMt4->setStatusCode("SENT");
                        $abfxDistMt4->save();
                    }
                }
            }

        }

        echo "Done.";
        return sfView::HEADER_ONLY;
    }

    public function executeMaturityManagement()
    {
        $this->updateLeaderForNotificationOfMaturity();
    }

    public function executeLuckyDraw()
    {
        $doAction = "EVENT";
        $screenLebel = "Send Lucky Draw - Event";

        $this->doAction = $doAction;
        $this->screenLebel = $screenLebel;
    }

    public function executeDeductIaccountCharges() {
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "I-account_visa_debit_card.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = 2; $x <= $totalRow; $x++) {
            $distCode = $data->val($x, "C");

            //print_r($distCode."<br>");

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode);
            $mlmDistributor = MlmDistributorPeer::doSelectOne($c);

            if ($mlmDistributor) {
                $distAccountCp3Balance = $this->getAccountBalance($mlmDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_MAINTENANCE);

                if ($distAccountCp3Balance >= 30) {
                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($mlmDistributor->getDistributorId());
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $mlm_account_ledger->setTransactionType("APPLY DEBIT CARD");
                    $mlm_account_ledger->setRemark("APPLY I-ACCOUNT VISA DEBIT CARD");
                    $mlm_account_ledger->setInternalRemark("APPLY BASE CARD");
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit(30);
                    $mlm_account_ledger->setBalance($distAccountCp3Balance - 30);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();
                } else {
                    $distAccountCp2Balance = $this->getAccountBalance($mlmDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);

                    if ($distAccountCp2Balance >= 30) {
                        print_r($distCode." PAID BY CP2 <br>");

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($mlmDistributor->getDistributorId());
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $mlm_account_ledger->setTransactionType("APPLY DEBIT CARD");
                        $mlm_account_ledger->setRemark("APPLY I-ACCOUNT VISA DEBIT CARD");
                        $mlm_account_ledger->setInternalRemark("APPLY BASE CARD");
                        $mlm_account_ledger->setCredit(0);
                        $mlm_account_ledger->setDebit(30);
                        $mlm_account_ledger->setBalance($distAccountCp2Balance - 30);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();
                    } else {
                        $distAccountCp1Balance = $this->getAccountBalance($mlmDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);

                        if ($distAccountCp1Balance >= 30) {
                            print_r($distCode." PAID BY CP3 <br>");

                            $mlm_account_ledger = new MlmAccountLedger();
                            $mlm_account_ledger->setDistId($mlmDistributor->getDistributorId());
                            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                            $mlm_account_ledger->setTransactionType("APPLY DEBIT CARD");
                            $mlm_account_ledger->setRemark("APPLY I-ACCOUNT VISA DEBIT CARD");
                            $mlm_account_ledger->setInternalRemark("APPLY BASE CARD");
                            $mlm_account_ledger->setCredit(0);
                            $mlm_account_ledger->setDebit(30);
                            $mlm_account_ledger->setBalance($distAccountCp1Balance - 30);
                            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->save();
                        } else {
                            print_r("<br><br>".$distCode." ++++++++ Totally Empty, CP3 negative 30 <br><br>");

                            $mlm_account_ledger = new MlmAccountLedger();
                            $mlm_account_ledger->setDistId($mlmDistributor->getDistributorId());
                            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                            $mlm_account_ledger->setTransactionType("APPLY DEBIT CARD");
                            $mlm_account_ledger->setRemark("APPLY I-ACCOUNT VISA DEBIT CARD");
                            $mlm_account_ledger->setInternalRemark("APPLY BASE CARD");
                            $mlm_account_ledger->setCredit(0);
                            $mlm_account_ledger->setDebit(30);
                            $mlm_account_ledger->setBalance($distAccountCp3Balance - 30);
                            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->save();
                        }
                    }
                }
            } else {
                print_r("Not found ".$distCode."<br>");
            }
        }

        return sfView::NONE;
    }

    public function executeInsertMbs() {
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "mbs.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $totalRow = $data->rowcount($sheet_index = 0);
        $id = "";
        for ($x = 2; $x <= $totalRow; $x++) {
            $distCode = $data->val($x, "A");
            $leader = $data->val($x, "F");

            if ($leader == "TWOSASA") {
                continue;
            }
            //print_r($distCode."<br>");

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode);
            $mlmDistributor = MlmDistributorPeer::doSelectOne($c);

            if ($mlmDistributor) {
                $pos = strrpos($mlmDistributor->getTreeStructure(), "|682|");
                if ($pos === false) { // note: three equal signs

                } else {
                    //print_r("<br>ID:".$mlmDistributor->getDistributorId().", Code:".$mlmDistributor->getDistributorCode());
                    //print_r("<br>ID:".$mlmDistributor->getDistributorId().", Code:".$mlmDistributor->getDistributorCode());
                    $id .= $mlmDistributor->getDistributorId().",";
                }
                /*$distAccountCp3Balance = $this->getAccountBalance($mlmDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($mlmDistributor->getDistributorId());
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType("MBS");
                $mlm_account_ledger->setRemark("MBS");
                $mlm_account_ledger->setInternalRemark("");
                $mlm_account_ledger->setCredit(25);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distAccountCp3Balance + 25);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();*/

            } else {
                //print_r("Not found ".$distCode."<br>");
            }
        }
        print_r($id);
        return sfView::NONE;
    }
    public function executeUpdateMemberData() {
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "distList.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = $totalRow; $x > 0; $x--) {
            $distId = $data->val($x, "A");
            $fullName = $data->val($x, "B");
            $nickName = $data->val($x, "C");
            $bankName = $data->val($x, "D");
            $bankHolderName = $data->val($x, "E");
            $address = $data->val($x, "F");
            $address2 = $data->val($x, "G");
            $city = $data->val($x, "H");
            $state = $data->val($x, "I");
            $signName = $data->val($x, "J");

            $mlmDistributor = MlmDistributorPeer::retrieveByPK($distId);

            if ($mlmDistributor) {
                print_r($x . ":" . $fullName);
                print_r("<br>");

                $mlmDistributor->setFullName($fullName);
                $mlmDistributor->setNickname($nickName);
                $mlmDistributor->setBankName($bankName);
                $mlmDistributor->setBankHolderName($bankHolderName);
                $mlmDistributor->setAddress($address);
                $mlmDistributor->setAddress2($address2);
                $mlmDistributor->setCity($city);
                $mlmDistributor->setState($state);
                $mlmDistributor->setSignName($signName);
                $mlmDistributor->save();
            }
        }
    }
    public function executeDoSendLuckyDraw()
    {

        $email = $this->getRequestParameter('email');
        $fullName = $this->getRequestParameter('fullname');
        $mt4UserName = $this->getRequestParameter('mt4Username');
        $mt4Password = $this->getRequestParameter('mt4Password');
        $amount = $this->getRequestParameter('optPackage');
        $drawType = $this->getRequestParameter('drawType');

        $subject = "Maxim Trader Wheel of Fortune Million Dollar$ Lucky Draw Winnings 百万美金幸运财富大抽奖";
        if ($drawType == "EVENT") {
            $subject = "Terms for Commit Sales Get Extra MT4 Credit Account 会议现场报单承诺奖励";
        }

        $body = "<table width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#939393' align='center'>
	<tbody>
		<tr>
			<td style='padding:20px 0px'>
				<table width='606' cellspacing='0' cellpadding='0' border='0' align='center' style='background:white;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
							<td colspan='2'>
								<a target='_blank' href='http://www.maximtrader.com'><img width='606' height='115' border='0' src='http://partner.maximtrader.com/images/email/banner.png' alt='Maxim Trader'></a></td>
						</tr>

						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
																Dear <strong>" . $fullName . "</strong>,<br><br>
																Congratulations on your recent Wheel of Fortune Million Dollar$ Lucky Draw Winnings.<br><br>
																It gives us great pleasure to activate your MT4 account with: <br><br>
																Live MT4 Trading Account ID : <strong>" . $mt4UserName . "</strong><br><br>
																Live MT4 Trading Account password : <strong>" . $mt4Password . "</strong><br><br>

                                                                <strong>WoF Lucky Draw Winnings: USD " . $amount . "</strong><br><br>

																Terms & Conditions:<br>
a)	In order to withdraw your trading profits, you are required to achieve a minimum volume of trading within certain period of time:<br><br>
<table border='1' cellpadding='3' cellspacing='0' style='font-size:12px;' align='center'>
<tr>
    <td><strong>USD</strong></td><td><strong>Minimum volume Required</strong></td><td><strong>Expired On</strong></td>
</tr>
<tr>
    <td>100</td><td>10 lots</td><td>10th July 2013</td>
</tr>
<tr>
    <td>300</td><td>30 lots</td><td>10th July 2013</td>
</tr>
<tr>
    <td>500</td><td>50 lots</td><td>10th July 2013</td>
</tr>
<tr>
    <td>1000</td><td>100 lots</td><td>10th Aug 2013</td>
</tr>
<tr>
    <td>3000</td><td>300 lots</td><td>10th Sept 2013</td>
</tr>
<tr>
    <td>5000</td><td>500 lots</td><td>10th Oct 2013</td>
</tr>
<tr>
    <td>10000</td><td>1000 lots</td><td>10th Nov 2013</td>
</tr>
<tr>
    <td>30000</td><td>3000 lots</td><td>10th Dec 2013</td>
</tr>
</table>
<br><br>
We look forward to your custom in the near future. Should you have any queries, please do not hesitate to contact support@maximtrader.com

                                                                </font>
																<br>
																<br>
																<br>
																<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:17px'>
																Forex, spread bets and CFDs are leveraged products. They may not be suitable for you as they carry a high degree of risk to your capital and you can lose more than your initial investment. You should ensure you understand all of the risks.
																</font>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody><tr>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85' align='center'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85' align='center'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91' align='center'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
												</tr>
											</tbody></table>
										</td>
									</tr>
						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
												您好! <strong>" . $fullName . "</strong>,<br><br>
																恭喜您在刚刚进行的马胜金融集团百万美金幸运轮盘大抽奖中赢得奖金!<br><br>
																我们非常荣幸能够帮助激活您在马胜外汇交易平台MT4的帐号: <br><br>
																MT4交易户口登录ID  : <strong>" . $mt4UserName . "</strong><br><br>
																MT4交易户口密码 : <strong>" . $mt4Password . "</strong><br><br>

                                                                <strong>幸运轮盘大抽奖:美金" . $amount . "</strong><br><br>

																条款与条件:<br>
a)	为了能够兑现您的交易利润，请您务必在一定的时间期限内完成一定数量的交易次数。具体如下表：<br><br>
<table border='1' cellpadding='3' cellspacing='0' style='font-size:12px;' align='center'>
<tr>
<td><strong>美金（USD）</strong></td><td><strong>最少交易次数(手)</strong></td><td><strong>最晚时间</strong></td>
</tr>
<tr>
<td>100</td><td>10 手</td><td>2013.7.10</td>
</tr>
<tr>
<td>300</td><td>30 手</td><td>2013.7.10</td>
</tr>
<tr>
<td>500</td><td>50 手</td><td>2013.7.10</td>
</tr>
<tr>
<td>1000</td><td>100 手</td><td>2013.8.10</td>
</tr>
<tr>
<td>3000</td><td>300 手</td><td>2013.9.10</td>
</tr>
<tr>
<td>5000</td><td>500 手</td><td>2013.10.10</td>
</tr>
<tr>
<td>10000</td><td>1000 手</td><td>2013.11.10</td>
</tr>
<tr>
<td>30000</td><td>3000 手</td><td>2013.12.10</td>
</tr>
</table>
<br><br>
我们期待在不久的将来，您可以自由交易。 如果您有任何问题或者疑虑，请随时通过邮箱联系我们。  邮箱地址为 support@maximtrader.com 。
																</font>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody><tr>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0;' align='center'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

												<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
												</tr>
											</tbody></table>
										</td>
									</tr>

						<tr>
							<td width='606' style='font-size:0;line-height:0' bgcolor='#0080C8'>
							<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'>
							</td>
						</tr>
						<tr>
							<td width='606' style='font-size:0;line-height:0' colspan='2'>
								<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'>
							</td>
						</tr>

						<tr>
							<td width='606' style='padding:15px 15px 0px;color:rgb(153,153,153);font-size:11px' colspan='2' align='right'>
							<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
								<em>
									Best Regards,<br>
									<strong>Maxim Trader Account Opening Team</strong><br>
								</em>
							</font>
							<br>
							<a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>
							<br>
						</tr>

						<tr>
							<td width='606' style='padding:5px 15px 20px;color:rgb(153,153,153);font-size:11px' colspan='2'>
							<p align='justify'>
								<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
									Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议。
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入。 请根据您可以承受的损失程度理性参与投资。 在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见。
								</font>
							</p>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>";


        if ($drawType == "EVENT") {
            $body = "<table width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#939393' align='center'>
	<tbody>
		<tr>
			<td style='padding:20px 0px'>
				<table width='606' cellspacing='0' cellpadding='0' border='0' align='center' style='background:white;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
							<td colspan='2'>
								<a target='_blank' href='http://www.maximtrader.com'><img width='606' height='115' border='0' src='http://partner.maximtrader.com/images/email/banner.png' alt='Maxim Trader'></a></td>
						</tr>

						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
																Dear <strong>" . $fullName . "</strong>,<br><br>
																Congratulations on your Extra MT4 Credit Account.<br><br>
																It gives us great pleasure to activate your MT4 account with: <br><br>
																Live MT4 Trading Account ID : <strong>" . $mt4UserName . "</strong><br><br>
																Live MT4 Trading Account password : <strong>" . $mt4Password . "</strong><br><br>

                                                                <strong>USD " . $amount . "</strong><br><br>

																<strong>Extra MT4 Credit Account Term and Condition</strong><br><br>
																1) Commit USD 1000 get USD 100 credit MT4 account Term and Condition apply
<br>
<br>2) Commit USD 5000 get USD 500 credit  MT4 account Term and Condition apply
<br>
<br>3)  Commit USD 10000 get USD 1000 credit  MT4 account Term and Condition apply
<br>
<br>4) Commit USD 20000 get USD 3000 credit  MT4 account Term and Condition apply
<br>
<br>5) Commit USD 30000 get USD 5000 credit  MT4 account Term and Condition apply
<br>
<br><strong>Terms & Conditions :</strong>
<br>
<br>In order to withdraw your trading profits, you are required to achieve a minimum volume of trading within certain period of time :
<br>
<br>Prize : USD 100
<br>Minimum Volume Required : 5 lots
<br>EXPIRED FROM THE STARTED  : 90 days
<br>
<br>Prize : USD 300
<br>Minimum Volume Required : 15 lots
<br>EXPIRED FROM THE STARTED  : 90 days
<br>
<br>Prize : USD 500
<br>Minimum Volume Required : 25 lots
<br>EXPIRED FROM THE STARTED  : 90 days
<br>
<br>Prize : USD 1000
<br>Minimum Volume Required : 50 lots
<br>EXPIRED FROM THE STARTED  : 180 days
<br>
<br>Prize : USD 3000
<br>Minimum Volume Required : 150 lots
<br>EXPIRED FROM THE STARTED  : 180 days
<br>
<br>Prize : USD 5000
<br>Minimum Volume Required : 250 lots
<br>EXPIRED FROM THE STARTED  : 180 days
<br>
<br>
<br><strong>*** Terms of trading applies ***</strong>
<br>
<br>1) This Extra Credit is used for MT4 trading account.
<br>
<br>2) This Extra Credit is NOT TRANSFERABLE.
<br>
<br>3) This Extra Credit is valid for below USD 999.00 is 90days  and USD 1000.00 and above is 180 days from the account effective date started.
<br>
<br>4) Every ( 1.0 ) standard lot trading will have USD 30 commission charge.
<br>
<br>5) No hedging trade allowed in this platform.
<br>
																Terms & Conditions:<br>
In order to withdraw your trading profits, you are required to achieve a minimum volume of trading within certain period of time:
<br>
1.) For Member only
<br><br>
a.) Validity : 180 days from the date of signing.<br>
b.) Withdrawal requirement : within 180 days from date of signing,
    after 180 days, members cannot cash out even if required volume is achieved.
<br><br>
2.) For Non Member only
<br><br>
a.) Validity :30days from the date of signing<br>
b.) Withdrawal requirement : within 30 days from date of signing,
    after 180days, members cannot cash out even if required volume is achieved.

<br><br>
<table border='1' cellpadding='3' cellspacing='0' style='font-size:12px;' align='center'>
<tr>
    <td><strong>USD</strong></td><td><strong>Minimum volume Required</strong></td>
</tr>
<tr>
    <td>100</td><td>5 lots</td>
</tr>
<tr>
    <td>300</td><td>15 lots</td>
</tr>
<tr>
    <td>500</td><td>25 lots</td>
</tr>
<tr>
    <td>1,000</td><td>50 lots</td>
</tr>
<tr>
    <td>3,000</td><td>150 lots</td>
</tr>
<tr>
    <td>5,000</td><td>300 lots</td>
</tr>
</table>
<br><br>
We look forward to your custom in the near future. Should you have any queries, please do not hesitate to contact support@maximtrader.com

                                                                </font>
																<br>
																<br>
																<br>
																<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:17px'>
																Forex, spread bets and CFDs are leveraged products. They may not be suitable for you as they carry a high degree of risk to your capital and you can lose more than your initial investment. You should ensure you understand all of the risks.
																</font>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody><tr>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85' align='center'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85' align='center'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91' align='center'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
												</tr>
											</tbody></table>
										</td>
									</tr>
						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
												您好! <strong>" . $fullName . "</strong>,<br><br>
																恭喜您在马胜金融集团开户后得到额外MT4信用额帐户<br><br>
																MT4交易户口登录ID  : <strong>" . $mt4UserName . "</strong><br><br>
																MT4交易户口密码 : <strong>" . $mt4Password . "</strong><br><br>

                                                                <strong>美金" . $amount . "</strong><br><br>

																<strong>如何可以获得额外MT4信用额帐号：</strong><br>
<br>1)开户1000美元获得100美元的mt4信用额帐户需符合条款和条件
<br>2)开户5000美元获得500美元的mt4信用额帐户需符合条款和条件
<br>3)开户10000美元获得1000美元的mt4信用额帐户必须符合条款和条件
<br>4)开户20000美元获得3000美元的mt4信用额帐户必须符合条款和条件
<br>5)开户30000美元获得5000美元的mt4信用额帐户必须符合户条款和条件
<br>

<strong>条款与条件:</strong><br>
<br>为了能够兑现您的交易利润，请您务必在一定的时间期限内完成一定数量的交易次数。具体如下表：
<br>
<br>交易条款适用于
<br>1)这额外MT4信用额奖励只用于在mt4交易帐户。
<br>2）这额外信用额帐户是不得转让。
<br>3）这个额外信用额奖励有效期为999.00美元以下是90天,usd 1000.00及以上是180天从账户生效日期开始。
<br>4)每手(1.0)标准手数将有30美元手续费。
<br>5)不允许在这个平台做任何对冲交易。
<br>
		条款与条件:<br>
为了能够兑现您的交易利润，请您务必在一定的时间期限内完成一定数量的交易次数。具体如下表：<br><br>
<br>
1.) 只限会员
<br><br>
a.) 有效期 : 从签字日起180天.<br>
b.) 提款要求 : 提款只能从签订日起180天以内,180天后将不能兑现，即使达到所需的交易次数。
<br><br>
2.) 对于非会员
<br><br>
a.) 有效期 : 从签字日起30天.<br>
b.) 提款要求 : 提款只能从签订日起180天以内,180天后将不能兑现，即使达到所需的交易次数。

<br><br>
<table border='1' cellpadding='3' cellspacing='0' style='font-size:12px;' align='center'>
<tr>
    <td><strong>美金（USD）</strong></td><td><strong>最少交易次数(手)</strong></td>
</tr>
<tr>
    <td>100</td><td>5 手</td>
</tr>
<tr>
    <td>300</td><td>15 手</td>
</tr>
<tr>
    <td>500</td><td>25 手</td>
</tr>
<tr>
    <td>1,000</td><td>50 手</td>
</tr>
<tr>
    <td>3,000</td><td>150 手</td>
</tr>
<tr>
    <td>5,000</td><td>300 手</td>
</tr>
</table>
<br><br>
我们期待在不久的将来，您可以自由交易。 如果您有任何问题或者疑虑，请随时通过邮箱联系我们。  邮箱地址为 support@maximtrader.com 。
																</font>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody><tr>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0;' align='center'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0' align='center'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0' align='center'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

												<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
												</tr>
											</tbody></table>
										</td>
									</tr>

						<tr>
							<td width='606' style='font-size:0;line-height:0' bgcolor='#0080C8'>
							<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'>
							</td>
						</tr>
						<tr>
							<td width='606' style='font-size:0;line-height:0' colspan='2'>
								<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'>
							</td>
						</tr>

						<tr>
							<td width='606' style='padding:15px 15px 0px;color:rgb(153,153,153);font-size:11px' colspan='2' align='right'>
							<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
								<em>
									Best Regards,<br>
									<strong>Maxim Trader Account Opening Team</strong><br>
								</em>
							</font>
							<br>
							<a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>
							<br>
						</tr>

						<tr>
							<td width='606' style='padding:5px 15px 20px;color:rgb(153,153,153);font-size:11px' colspan='2'>
							<p align='justify'>
								<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
									Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议。
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入。 请根据您可以承受的损失程度理性参与投资。 在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见。
								</font>
							</p>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>";
        }

        $sendMailService = new SendMailService();
        $sendMessage = $sendMailService->sendMail($email, $fullName, $subject, $body);

        $statusCode = Globals::STATUS_COMPLETE;
        if ($sendMessage != "") {
            $statusCode = Globals::STATUS_ERROR;
        }

        $luckyDraw = new LuckyDraw();
        $luckyDraw->setFullName($fullName);
        $luckyDraw->setEmail($email);
        $luckyDraw->setMt4Username($mt4UserName);
        $luckyDraw->setMt4Password($mt4Password);
        $luckyDraw->setAmount($amount);
        $luckyDraw->setDrawType($drawType);
        $luckyDraw->setStatusCode($statusCode);
        $luckyDraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $luckyDraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $luckyDraw->save();

        $message = "Send Successfully";
        $arr = array(
            'message' => $message
        );

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executeGenealogyManagement()
    {
//        $c = new Criteria();
//        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
//        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);
//        $this->dists = MlmDistributorPeer::doSelect($c);
    }
    public function executeGenealogyManagement2()
    {
//        $c = new Criteria();
//        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
//        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);
//        $this->dists = MlmDistributorPeer::doSelect($c);
    }
    public function executeDoUpdateHideGenealogy()
    {
        $dist = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('distId'));
        $dist->setHideGenealogy($this->getRequestParameter('toHideGenealogy'));
        $dist->save();
        return sfView::HEADER_ONLY;
    }
    public function executeDoResetPassword()
    {
        $dist = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('distId'));
        if ($dist) {
            $appUser = AppUserPeer::retrieveByPK($dist->getUserId());
            if ($appUser) {
                $appUser->setUserpassword($dist->getDistributorCode());
                $appUser->save();
            }
        }
        return sfView::HEADER_ONLY;
    }
    public function executeDoCheckGenealogy()
    {
        $dist = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('distId'));
        if ($dist) {
            $arr = array(
                'result' => $dist->getHideGenealogy()
                , 'placementTreeStructure' => $dist->getPlacementTreeStructure()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executeCustomerEnquiryAdd()
    {
        /*$c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);
        $this->dists = MlmDistributorPeer::doSelect($c);*/
    }
    public function executeSendLuckyDraw()
    {
        $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . "Maxim_Luck_Draw_Listing_2013.xls";

        error_reporting(E_ALL ^ E_NOTICE);
        require_once 'excel_reader2.php';
        $data = new Spreadsheet_Excel_Reader($physicalDirectory);

        $counter = 0;
        $totalRow = $data->rowcount($sheet_index = 0);
        for ($x = $totalRow; $x > 0; $x--) {
            $mt4Username = $data->val($x, "B");
            $mt4Password = $data->val($x, "A");
            $email = $data->val($x, "E");
            $status = $data->val($x, "D");
            $fullname = $data->val($x, "C");

            if ($mt4Password == "" || $email == "" || $status != "ACTIVE")
                continue;

            $result = $this->sendEmailForMt4($mt4Username, $mt4Password, $fullname, $email);

            $counter++;
        }
        print_r("totalRow:".$totalRow."<br>");
        print_r("counter:".$counter."<br>");

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoSendMt4()
    {

        $c = new Criteria();
        $c->add(TmpMt4AccountPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $tmpMt4s = TmpMt4AccountPeer::doSelect($c);

        foreach ($tmpMt4s as $tmpMt4) {

                $result = $this->sendEmailForMt4($tmpMt4->getMt4Username(), $tmpMt4->getMt4Password(), $tmpMt4->getFullname(), $tmpMt4->getEmail());

                if ($result == "") {
//                    print_r("updated successfully");
//                    print_r("<br>");
                    $tmpMt4->setStatusCode(Globals::STATUS_COMPLETE);
                    $tmpMt4->save();
                } else {
                    break;
                }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoSendMt42()
    {

        $c = new Criteria();
        $c->add(TmpMt4AccountPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $tmpMt4s = TmpMt4AccountPeer::doSelect($c);

        foreach ($tmpMt4s as $tmpMt4) {
            $c = new Criteria();
            $c->add(MlmDistMt4Peer::MT4_USER_NAME, $tmpMt4->getMt4Username());
            $existDistMt4 = MlmDistMt4Peer::doSelectOne($c);

//            print_r("<br>");
//            print_r("<br>");
//            print_r($tmpMt4->getMt4Username());
//            print_r("<br>");
            if (!$existDistMt4)
                continue;

            $existDistMt4->setMt4Password($tmpMt4->getMt4Password());
            $existDistMt4->save();
//             print_r("save successfully");
//            print_r("<br>");
            $existDistributor = MlmDistributorPeer::retrieveByPK($existDistMt4->getDistId());

            if ($existDistributor) {
//                print_r("email sent successfully");
//                print_r("<br>");
                $result = $this->sendEmailForMt4($tmpMt4->getMt4Username(), $tmpMt4->getMt4Password(), $existDistributor->getFullName(), $existDistributor->getEmail());

                if ($result) {
//                    print_r("updated successfully");
//                    print_r("<br>");
                    $tmpMt4->setStatusCode(Globals::STATUS_COMPLETE);
                    $tmpMt4->save();
                } else {
                    break;
                }
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeFindUnderLeader() {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_CODE);
        $this->dists = MlmDistributorPeer::doSelect($c);
    }
    public function executeDoFindUnderLeader() {
        $str = '1992,1994,1984,1993';

        $memberArrs = explode(",", $str);
        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $leader = "";
        //for ($y = 0; $y < count($memberArrs); $y++) {
            //$c = new Criteria();
            //$c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $memberArrs[$y]);
            //$distDB = MlmDistributorPeer::doSelectOne($c);
            //$distDB = MlmDistributorPeer::retrieveByPK($memberArrs[$y]);
            $distDB = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('distId'));

            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $leader = $dist->getDistributorCode();
                    }
                    break;
                }
            }
//            print_r($memberArrs[$y].":".$leader."<br>");
            //print_r($leader."<br>");
        $arr = array(
            'result' => $leader
        );
        //}
        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executeUpdateAccountStatus()
    {
        $count = $this->getRequestParameter('count');
        $doAction = $this->getRequestParameter('doAction', 'UPDATE');
        for ($i= 0; $i < $count; $i++) {
            $requestId = $this->getRequestParameter('request_id_'. $i);

            $mlmMt4DemoRequest = MlmMt4DemoRequestPeer::retrieveByPK($requestId);
            if ($mlmMt4DemoRequest) {
                if ($doAction == "DELETE") {
                    $mlmMt4DemoRequest->delete();
                } else {
                    $mlmMt4DemoRequest->setStatusCode("VIEWED");
                    $mlmMt4DemoRequest->save();
                }
            }
        }
        return sfView::HEADER_ONLY;
    }
     public function executeUpdateDebitCardApplicationStatus()
    {
        $count = $this->getRequestParameter('count');
        $status = $this->getRequestParameter('status');

        $con = Propel::getConnection(MlmPipCsvPeer::DATABASE_NAME);
        try {
            $con->begin();

            $debitCardCharges = Globals::DEBIT_CARD_CHARGES + Globals::DEBIT_CARD_ACTIVATION_CHARGES;

            for ($i= 0; $i < $count; $i++) {
                $requestId = $this->getRequestParameter('card_id'. $i);

                $mlmDebitCardRegistration = MlmDebitCardRegistrationPeer::retrieveByPK($requestId);
                if ($mlmDebitCardRegistration) {
                    $mlmDebitCardRegistration->setStatusCode($status);
                    $mlmDebitCardRegistration->save();

                    if ($status == "REJECT") {
                        $mlmAccountLedgerDB = MlmAccountLedgerPeer::retrieveByPK($mlmDebitCardRegistration->getAccountId());

                        if ($mlmAccountLedgerDB) {
                            $accountBalance = $this->getAccountBalance($mlmAccountLedgerDB->getDistId(), $mlmAccountLedgerDB->getAccountType());

                            $mlm_account_ledger = new MlmAccountLedger();
                            $mlm_account_ledger->setDistId($mlmAccountLedgerDB->getDistId());
                            $mlm_account_ledger->setAccountType($mlmAccountLedgerDB->getAccountType());
                            $mlm_account_ledger->setTransactionType("REFUND");
                            $mlm_account_ledger->setRemark("DEBIT CARD REFUNDS");
                            $mlm_account_ledger->setCredit($debitCardCharges);
                            $mlm_account_ledger->setDebit(0);
                            $mlm_account_ledger->setBalance($accountBalance + $debitCardCharges);
                            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->save();

                            $this->mirroringAccountLedger($mlm_account_ledger, "38");
                        }
                    }
                }
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        return sfView::HEADER_ONLY;
    }
     public function executeUpdateEzyCashCardApplicationStatus()
    {
        $count = $this->getRequestParameter('count');
        $status = $this->getRequestParameter('status');
        for ($i= 0; $i < $count; $i++) {
            $requestId = $this->getRequestParameter('card_id'. $i);

            $mlmEzyCashCard = MlmEzyCashCardPeer::retrieveByPK($requestId);
            if ($mlmEzyCashCard) {
                $mlmEzyCashCard->setStatusCode($status);
                $mlmEzyCashCard->save();
            }
        }
        return sfView::HEADER_ONLY;
    }
    public function executeDemoAccountRequest()
    {
    }
    public function executeLiveAccountRequest()
    {
    }
    public function executeDebitCardApplication()
    {
    }
    public function executeEzyCashCardApplication()
    {
    }
    public function executeCustomerEnquiryList()
    {
    	if ($this->getRequestParameter('enquiryStatus') && $this->getRequestParameter('enquiryId')) {
            $error = false;
            $arr = $this->getRequestParameter('enquiryId');
            $statusCode = $this->getRequestParameter('enquiryStatus');

            $con = Propel::getConnection(MlmCustomerEnquiryPeer::DATABASE_NAME);
            try {
                $con->begin();

                for ($i = 0; $i < count($arr); $i++) {
                    $mlm_customer_enquiry = MlmCustomerEnquiryPeer::retrieveByPk($arr[$i]);
                    $this->forward404Unless($mlm_customer_enquiry);
					
                    $mlm_customer_enquiry->setStatusCode($statusCode);
                    $mlm_customer_enquiry->save();
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            if ($error == false)
                $this->setFlash('successMsg', "Update successfully");
                
            return $this->redirect('marketing/customerEnquiryList');
        }
    }

    public function executeCustomerEnquiryDetail()
    {
        $enquiryId = $this->getRequestParameter('enquiryId');

        $mlmCustomerEnquiry = MlmCustomerEnquiryPeer::retrieveByPK($enquiryId);

        if (!$mlmCustomerEnquiry) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/customerEnquiry');
        }
        $mlmCustomerEnquiry->setAdminRead(Globals::TRUE);
        $mlmCustomerEnquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlmCustomerEnquiry->save();

        $c = new Criteria();
        $c->add(MlmCustomerEnquiryDetailPeer::CUSTOMER_ENQUIRY_ID, $enquiryId);
        $mlmCustomerEnquiryDetails = MlmCustomerEnquiryDetailPeer::doSelect($c);

        $this->mlmCustomerEnquiry = $mlmCustomerEnquiry;
        $this->mlmCustomerEnquiryDetails = $mlmCustomerEnquiryDetails;
    }

    public function executeDoCustomerEnquiryDetail()
    {
        $enquiryId = $this->getRequestParameter('enquiryId');
        $message = $this->getRequestParameter('message');
        $status_code = $this->getRequestParameter('status_code');
        $category = $this->getRequestParameter('category');

        $mlmCustomerEnquiry = new MlmCustomerEnquiry();
        if ($enquiryId == "") {
            $distId = $this->getRequestParameter('distId');
            $title = $this->getRequestParameter('title');

            $mlmCustomerEnquiry->setDistributorId($distId);
            $mlmCustomerEnquiry->setContactNo("");
            $mlmCustomerEnquiry->setTitle($title);
            $mlmCustomerEnquiry->setAdminUpdated(Globals::TRUE);
            $mlmCustomerEnquiry->setDistributorUpdated(Globals::FALSE);
            $mlmCustomerEnquiry->setAdminRead(Globals::TRUE);
            $mlmCustomerEnquiry->setDistributorRead(Globals::FALSE);
            $mlmCustomerEnquiry->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmCustomerEnquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
			$mlmCustomerEnquiry->setStatusCode($status_code);
			$mlmCustomerEnquiry->setCategory($category);

            $mlmCustomerEnquiry->save();

            $enquiryId = $mlmCustomerEnquiry->getEnquiryId();
        } else {
            $mlmCustomerEnquiry = MlmCustomerEnquiryPeer::retrieveByPK($enquiryId);
            $mlmCustomerEnquiry->setAdminUpdated(Globals::TRUE);
            $mlmCustomerEnquiry->setDistributorUpdated(Globals::FALSE);
            $mlmCustomerEnquiry->setDistributorRead(Globals::FALSE);
            $mlmCustomerEnquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
			$mlmCustomerEnquiry->setStatusCode($status_code);
			$mlmCustomerEnquiry->setCategory($category);
            
            $mlmCustomerEnquiry->save();
        }

        $mlm_customer_enquiry_detail = new MlmCustomerEnquiryDetail();
        $mlm_customer_enquiry_detail->setCustomerEnquiryId($mlmCustomerEnquiry->getEnquiryId());
        $mlm_customer_enquiry_detail->setMessage($message);
        $mlm_customer_enquiry_detail->setReplyFrom(Globals::ROLE_ADMIN);
        $mlm_customer_enquiry_detail->setStatusCode(Globals::STATUS_ACTIVE);
        $mlm_customer_enquiry_detail->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_customer_enquiry_detail->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_customer_enquiry_detail->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your inquiry has been submitted."));
        return $this->redirect('/marketing/customerEnquiryDetail?enquiryId='.$enquiryId);
    }
    public function executeIndex()
    {
        return $this->redirect('/marketing/distList');
    }

    public function executeFundManagementUpload()
    {
        if ($this->getRequest()->getFileName('fundManagement') != '') {
            $uploadedFilename = $this->getRequest()->getFileName('fundManagement');
            $ext = explode(".", $this->getRequest()->getFileName('fundManagement'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "fundManagement_".date("Ymd")."_".rand(1000,9999).".".$extensionName;

            // Validate the file type
            //$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $fileTypes = array('pdf'); // File extensions
            $fileParts = pathinfo($uploadedFilename);

            if (in_array($fileParts['extension'], $fileTypes)) {
                $this->getRequest()->moveFile('fundManagement', sfConfig::get('sf_upload_dir') . '/fundManagement/' . $filename);

                $mlm_file_download = new MlmFileDownload();
                $mlm_file_download->setFileType("FUND_MANAGEMENT_REPORT");
                $mlm_file_download->setFileSrc(sfConfig::get('sf_upload_dir') . '/fundManagement/' . $filename);
                $mlm_file_download->setFileName($filename);
                $mlm_file_download->setContentType("application/pdf");
                $mlm_file_download->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_file_download->setRemarks("");
                $mlm_file_download->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_file_download->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_file_download->save();

                $this->setFlash('successMsg', "Upload successful.");
            }
        }
        return $this->redirect('/marketing/uploadFundManagement');
    }

    public function executeFxGuideUpload()
    {
    }
    public function executeUploadFundManagement()
    {
    }

    public function executeDoUploadPips()
    {
        if ($this->getRequest()->getFileName('file_upload') != "") {
            $uploadedFilename = $this->getRequest()->getFileName('file_upload');
            $tradingMonth = $this->getRequestParameter('tradingMonth');
            $tradingYear = $this->getRequestParameter('tradingYear');
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

            $this->setFlash('successMsg', "Files was successfully uploaded.");
            return $this->redirect('/marketing/pipsUpload?doAction=show_pips');
        }
    }

    public function executeDoUploadPips_ori()
    {
        if ($this->getRequest()->getFileName('file_upload') != "") {
            $uploadedFilename = $this->getRequest()->getFileName('file_upload');
            $tradingMonth = $this->getRequestParameter('tradingMonth');
            $tradingYear = $this->getRequestParameter('tradingYear');
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
                //$mlm_pip_csv->setPipsString($string);

                if (count($arr) == 13) {
                    if (is_numeric($arr[0])) {
                        $idx = 0;
                        $mlm_pip_csv->setMonthTraded($tradingMonth);
                        $mlm_pip_csv->setYearTraded($tradingYear);
                        $mlm_pip_csv->setLoginId($arr[$idx++]);
                        $mlm_pip_csv->setLoginName($arr[$idx++]);
                        $mlm_pip_csv->setLoginName("");
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

                        //$c = new Criteria();
                        //$c->add(MlmDistributorPeer::MT4_USER_NAME, $mt4Id);
                        //$existDistributor = MlmDistributorPeer::doSelectOne($c);

                        $c = new Criteria();
                        $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Id);
                        $mlm_dist_mt4 = MlmDistMt4Peer::doSelectOne($c);

                        if ($mlm_dist_mt4) {
                        //if ($existDistributor) {
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

    public function executeDailyPipsUpload()
    {

    }
    public function executeDoDailyPipsUpload()
    {
        if ($this->getRequest()->getFileName('file_upload') != "") {
            $uploadedFilename = $this->getRequest()->getFileName('file_upload');
            $tradingMonth = $this->getRequestParameter('tradingMonth');
            $ext = explode(".", $this->getRequest()->getFileName('file_upload'));

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
            while (!feof($file_handle)) {
                $line_of_text = fgets($file_handle);
                $parts = explode('=', $line_of_text);

                $string = $parts[0] . $parts[1];
                $arr = explode(';', $string);

                $status = Globals::STATUS_PIPS_CSV_ACTIVE;
                $remarks = "";
                $mlm_pip_csv = new MlmPipCsv();
                $mlm_pip_csv->setFileId($mlm_file_download->getFileId());
                //$mlm_pip_csv->setPipsString($string);

                if (count($arr) == 13) {
                    if (is_numeric($arr[0])) {
                        $idx = 0;
                        $mlm_pip_csv->setMonthTraded($tradingMonth);
                        $mlm_pip_csv->setYearTraded(date('Y'));
                        $mlm_pip_csv->setLoginId($arr[$idx++]);
                        $mlm_pip_csv->setLoginName($arr[$idx++]);
                        $mlm_pip_csv->setLoginName("");
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
                        $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Id);
                        $mlm_dist_mt4 = MlmDistMt4Peer::doSelectOne($c);

                        if ($mlm_dist_mt4) {

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

            $this->setFlash('successMsg', "Files was successfully uploaded.");
            return $this->redirect('/marketing/pipsUpload?doAction=show_pips');
        }
    }

    public function executeInsertPipsToAccountLedger()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::BKK_STATUS, "PENDING");
        $c->add(MlmDistributorPeer::FROM_ABFX, "N");
        $c->setLimit(3000);
        $distDBs = MlmDistributorPeer::doSelect($c);

        $idx = count($distDBs);

        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            foreach ($distDBs as $affectedDistributor) {
                print_r($idx-- . ":" . $affectedDistributor->getDistributorCode()."<br>");

                $resultArr = $this->getPipsBonus($affectedDistributor->getDistributorId());

                if ($resultArr != null) {
                    $distAccountEcashBalance = $this->getAccountBalance($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);

                    $creditRefund = $resultArr['_CREDIT_REFUND'];
                    $pipsAmountEntitied = $resultArr['_PIPS_BONUS'];

                    if ($creditRefund <= 0 && $pipsAmountEntitied <= 0) {
                        $affectedDistributor->setBkkStatus("COMPLETE");
                        $affectedDistributor->save();

                        continue;
                    }

                    if ($creditRefund > 0) {
                        $distAccountEcashBalance = $distAccountEcashBalance + $creditRefund;

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($affectedDistributor->getDistributorId());
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CREDIT_REFUND);
                        $mlm_account_ledger->setRemark("");
                        $mlm_account_ledger->setCredit($creditRefund);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distAccountEcashBalance);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->mirroringAccountLedger($mlm_account_ledger, "39");
                    }

                    if ($pipsAmountEntitied > 0) {
                        $distAccountEcashBalance = $distAccountEcashBalance + $pipsAmountEntitied;

                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($affectedDistributor->getDistributorId());
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PIPS_BONUS);
                        $mlm_account_ledger->setRemark("");
                        $mlm_account_ledger->setCredit($pipsAmountEntitied);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($distAccountEcashBalance);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        $this->mirroringAccountLedger($mlm_account_ledger, "40");
                    }

                    $bonusService = new BonusService();
                    if ($bonusService->checkDebitAccount($affectedDistributor->getDistributorId()) == true) {
                        $debitAccountRemark = "PIPS BONUS AND CREDIT REFUND";
                        $bonusService->contraDebitAccount($affectedDistributor->getDistributorId(), $debitAccountRemark, $pipsAmountEntitied);
                    }
                    $this->revalidateAccount($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);
                }
                $affectedDistributor->setBkkStatus("COMPLETE");
                $affectedDistributor->save();
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            //throw $e;
        }

        print_r("<br><br><br>Done");
        return sfView::HEADER_ONLY;
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
                $con = Propel::getConnection(MlmPipCsvPeer::DATABASE_NAME);
                try {
                    $con->begin();

                    $this->refId = $mlmFileDownloadDB->getFileId();

                    $c = new Criteria();
                    $c->add(MlmPipCsvPeer::STATUS_CODE, Globals::STATUS_PIPS_CSV_ACTIVE);
                    $c->add(MlmPipCsvPeer::FILE_ID, $mlmFileDownloadDB->getFileId());
                    $c->setLimit(500);
                    $mlmPipsCsvDBs = MlmPipCsvPeer::doSelect($c);
                    $totalCount = count($mlmPipsCsvDBs);
                    //$c = new Criteria();
                    //$c->addDescendingOrderByColumn(MlmFundManagementRecordPeer::CREATED_ON);
                    //$mlmFundManagementRecord = MlmFundManagementRecordPeer::doSelectOne($c);
                    $fundManagementPercentage = 0;
                    //if ($mlmFundManagementRecord) {
                    //    $fundManagementPercentage = $mlmFundManagementRecord->getPercentage();
                    //}
                    //print_r($totalCount."success<br>");
                    foreach ($mlmPipsCsvDBs as $mlm_pip_csv) {

                        $totalVolume = $mlm_pip_csv->getVolume();
                        $mt4Id = $mlm_pip_csv->getLoginId();
                        $tradingMonth =  $mlm_pip_csv->getMonthTraded();
                        $tradingYear =  $mlm_pip_csv->getYearTraded();

                        /*$c = new Criteria();
                        $c->add(MlmDistributorPeer::MT4_USER_NAME, $mt4Id);
                        $existDistributor = MlmDistributorPeer::doSelectOne($c);*/

                        $c = new Criteria();
                        $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Id);
                        $mlm_dist_mt4 = MlmDistMt4Peer::doSelectOne($c);
                        //if ($existDistributor) {
                        //print_r($mt4Id."<==<br>");
                        //var_dump($mlm_dist_mt4);
                        if ($mlm_dist_mt4) {
                            $index = 0;
                            if ($mlm_dist_mt4->getDistId() < 0) {
                                $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_ERROR);
                                $mlm_pip_csv->setRemarks("Invalid MT4 ID");
                                $mlm_pip_csv->save();
                                continue;
                            }
                            $existDistributor = MlmDistributorPeer::retrieveByPK($mlm_dist_mt4->getDistId());
                            //$this->forward404Unless($existDistributor);
                            if ($existDistributor) {
                                $treeLevel = $existDistributor->getTreeLevel();
                                $treeStructure = $existDistributor->getTreeStructure();
                                $affectedDistributorArrs = explode("|", $treeStructure);

                                for ($y = count($affectedDistributorArrs); $y > 0; $y--) {
                                    if ($affectedDistributorArrs[$y] == "") {
                                        continue;
                                    }
                                    $affectedDistributorId = $affectedDistributorArrs[$y];
                                    //$c = new Criteria();
                                    //$c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $affectedDistributorId, Criteria::EQUAL);
                                    $affectedDistributor = MlmDistributorPeer::retrieveByPK($affectedDistributorId);

                                    if ($affectedDistributor) {
                                        $affectedDistributorTreeLevel = $affectedDistributor->getTreeLevel();
                                        $affectedDistributorPackageDB = MlmPackagePeer::retrieveByPK($affectedDistributor->getRankId());
                                        if ($affectedDistributorPackageDB) {
                                            //$generation = $affectedDistributorPackageDB->getGeneration();
                                            //$pips = $affectedDistributorPackageDB->getPips();
                                            //$generation2 = $affectedDistributorPackageDB->getGeneration2();
                                            //$pips2 = $affectedDistributorPackageDB->getPips2();
                                            $creditRefundByPackage = $affectedDistributorPackageDB->getCreditRefund();
                                            //$fundMgnProfitSharing = $affectedDistributorPackageDB->getFundMgnProfitSharing();

                                            $generation = 0;
                                            $pips = 0;

                                            if ($affectedDistributorPackageDB->getDirectGeneration() != 0) {
                                                $generation = $affectedDistributorPackageDB->getDirectGeneration();
                                                $pips = $affectedDistributorPackageDB->getDirectPips();
                                            } else {
                                                $totalSponsor = $this->getTotalSponsor($affectedDistributor->getDistributorId());
                                                if ($totalSponsor > 0) {
                                                    $c = new Criteria();
                                                    $c->add(MlmPackagePipsPeer::TOTOL_SPONSOR, $totalSponsor, Criteria::LESS_EQUAL);
                                                    $c->addDescendingOrderByColumn(MlmPackagePipsPeer::TOTOL_SPONSOR);
                                                    $packagePips = MlmPackagePipsPeer::doSelectOne($c);

                                                    if ($affectedDistributor) {
                                                        $generation = $packagePips->getGeneration();
                                                        $pips = $packagePips->getPips();
                                                    }
                                                }
                                            }

                                            //$totalGeneration = $generation + $generation2;
                                            $totalGeneration = $generation;

                                            $gap = $treeLevel - $affectedDistributorTreeLevel;
                                            $isEntitled = false;
                                            $pipsAmountEntitied = 0;
                                            $pipsEntitied = 0;
                                            if ($generation == null) {
                                                $isEntitled = true;
                                            } else {
                                                if ($gap <= $totalGeneration) {
                                                    $isEntitled = true;

                                                    /*if ($gap > $generation) {
                                                      $pipsAmountEntitied = $pips2 * $totalVolume;
                                                      $pipsEntitied = $pips2;
                                                  } else {*/
                                                    $pipsAmountEntitied = $pips * $totalVolume;
                                                    $pipsEntitied = $pips;
                                                    //}
                                                }
                                            }

                                            if ($isEntitled) {
                                                if ($pipsAmountEntitied > 0) {

                                                    if ($gap == 0) {
                                                        $pipsBalance = $this->getCommissionBalance($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_CREDIT_REFUND);

                                                        $creditRefund = $totalVolume * $creditRefundByPackage;
                                                        //$fundManagement = $totalVolume * $fundManagementPercentage * ((100 - $fundMgnProfitSharing) / 100);
                                                        //$fundMgnProfitSharingAmount = $fundManagement * $fundMgnProfitSharing / 100;

                                                        //$fundManagement = $fundManagement - $fundMgnProfitSharingAmount;

                                                        $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                                        $sponsorDistCommissionledger->setMonthTraded($tradingMonth);
                                                        $sponsorDistCommissionledger->setYearTraded($tradingYear);
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

                                                        $this->revalidateCommission($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_CREDIT_REFUND);

                                                        /*$distAccountEcashBalance = $this->getAccountBalance($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);

                                                        $mlm_account_ledger = new MlmAccountLedger();
                                                        $mlm_account_ledger->setDistId($affectedDistributor->getDistributorId());
                                                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CREDIT_REFUND);
                                                        $mlm_account_ledger->setRemark("USD ".$creditRefundByPackage.", Volume:".$totalVolume);
                                                        $mlm_account_ledger->setCredit($creditRefund);
                                                        $mlm_account_ledger->setDebit(0);
                                                        $mlm_account_ledger->setBalance($distAccountEcashBalance + $creditRefund);
                                                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                        $mlm_account_ledger->save();

                                                        $bonusService = new BonusService();
                                                        if ($bonusService->checkDebitAccount($affectedDistributor->getDistributorId()) == true) {
                                                            $debitAccountRemark = "USD ".$creditRefundByPackage.", Volume:".$totalVolume;
                                                            $bonusService->contraDebitAccount($affectedDistributor->getDistributorId(), $debitAccountRemark, $creditRefund);
                                                        }
                                                        $this->revalidateAccount($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);*/
                                                    } else if ($gap > 0) {
                                                        $pipsBalance = $this->getCommissionBalance($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_PIPS_BONUS);

                                                        $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                                        $sponsorDistCommissionledger->setMonthTraded($tradingMonth);
                                                        $sponsorDistCommissionledger->setYearTraded($tradingYear);
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
                                                        $sponsorDistCommissionledger->setPipsMt4Id($mt4Id);
                                                        $sponsorDistCommissionledger->setPipsRebate($pipsEntitied);
                                                        $sponsorDistCommissionledger->setPipsLevel($gap);
                                                        $sponsorDistCommissionledger->setPipsLotsTraded($totalVolume);
                                                        $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                        $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                        $sponsorDistCommissionledger->save();

                                                        $this->revalidateCommission($affectedDistributor->getDistributorId(), Globals::COMMISSION_TYPE_PIPS_BONUS);

                                                        /*$distAccountEcashBalance = $this->getAccountBalance($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);

                                                        $mlm_account_ledger = new MlmAccountLedger();
                                                        $mlm_account_ledger->setDistId($affectedDistributor->getDistributorId());
                                                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PIPS_BONUS);
                                                        $mlm_account_ledger->setRemark("e-Trader:".$existDistributor->getDistributorCode().", tier:".$gap.", volume:".$totalVolume.", pips:".$pipsEntitied);
                                                        $mlm_account_ledger->setCredit($pipsAmountEntitied);
                                                        $mlm_account_ledger->setDebit(0);
                                                        $mlm_account_ledger->setBalance($distAccountEcashBalance + $pipsAmountEntitied);
                                                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                        $mlm_account_ledger->save();

                                                        $bonusService = new BonusService();
                                                        if ($bonusService->checkDebitAccount($affectedDistributor->getDistributorId()) == true) {
                                                            $debitAccountRemark = "e-Trader:".$existDistributor->getDistributorCode().", tier:".$gap.", volume:".$totalVolume.", pips:".$pipsEntitied;
                                                            $bonusService->contraDebitAccount($affectedDistributor->getDistributorId(), $debitAccountRemark, $pipsAmountEntitied);
                                                        }
                                                        $this->revalidateAccount($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);*/
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_SUCCESS);
                            $mlm_pip_csv->save();
                            //print_r("success<br>");
                        } else {
                            $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_ERROR);
                            $mlm_pip_csv->setRemarks("Invalid MT4 ID");
                            $mlm_pip_csv->save();
                            //print_r("error<br>");
                        }
                        //print_r("success<br>");
                    }
                    //print_r("done<br>");
                    if ($totalCount <= 0) {
                        $mlmFileDownloadDB->setStatusCode(Globals::STATUS_COMPLETE);
                        $mlmFileDownloadDB->save();
                    }

                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
                //return sfView::HEADER_ONLY;
                return $this->redirect('/marketing/pipsUpload?doAction=calc_pips');
            }
        }
    }

    public function executeManipulatePips()
    {
        //if ($this->getRequestParameter('file_upload') != "") {
            $uploadedFilename = "maxim-pip-bonus-aug14.csv";
            $tradingMonth = "8";
            $tradingYear = "2014";
            //$ext = explode(".", $this->getRequest()->getFileName('file_upload'));
            //$extensionName = $ext[count($ext) - 1];

            //$this->getRequest()->moveFile('file_upload', sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . 'pips' . DIRECTORY_SEPARATOR . $uploadedFilename);

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

            while (!feof($file_handle)) {
                $line_of_text = fgets($file_handle);
                $parts = explode('=', $line_of_text);

                $string = $parts[0] . $parts[1];
                $arr = explode(';', $string);

                $status = Globals::STATUS_PIPS_CSV_ACTIVE;
                $remarks = "";
                $mlm_pip_csv = new MlmPipCsv();
                $mlm_pip_csv->setFileId($mlm_file_download->getFileId());
                try {
                    //$mlm_pip_csv->setPipsString($string);
                    $mlm_pip_csv->setPipsString("");
                } catch (PropelException $e) {
                    //throw $e;
                    $mlm_pip_csv->setPipsString("");
                }

                if (count($arr) == 13) {
                    if (is_numeric($arr[0])) {
                        $idx = 0;
                        $mlm_pip_csv->setMonthTraded($tradingMonth);
                        $mlm_pip_csv->setYearTraded($tradingYear);
                        $mlm_pip_csv->setLoginId($arr[$idx++]);
                        $mlm_pip_csv->setLoginName($arr[$idx++]);
                        $mlm_pip_csv->setLoginName("");
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
                        $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Id);
                        $mlm_dist_mt4 = MlmDistMt4Peer::doSelectOne($c);

                        if ($mlm_dist_mt4) {

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
            print_r("Files was successfully uploaded.");
        //}
        print_r("<br>Done");
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

    public function executeKycList()
    {
    }

    public function executeSuperIbList()
    {
    }

    public function executeDoSaveDist()
    {
        $tbl_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));

        $editFullname = $this->getRequestParameter('editFullName');
        $editMemberId = $this->getRequestParameter('editMemberId');

        if ($editMemberId == "Y") {
            $c = new Criteria();
            $c->add(AppUserPeer::USERNAME, $this->getRequestParameter('distributorCode'));
            $exist = AppUserPeer::doSelectOne($c);

            if ($exist) {
                $output = array(
                    "error" => true
                    , "errorMsg" => "Username ".$this->getRequestParameter('distributorCode')." already exist"
                );
                echo json_encode($output);
                return sfView::HEADER_ONLY;
            }

            $remark = $tbl_distributor->getRemark();
            if ($remark != "") {
                $remark .= ", ";
            }
            $remark .= "renamed member ID from ".$tbl_distributor->getDistributorCode();
            $tbl_distributor->setRemark($remark);
            $tbl_distributor->setDistributorCode($this->getRequestParameter('distributorCode'));

            $tbl_user = AppUserPeer::retrieveByPk($tbl_distributor->getUserId());
            $tbl_user->setUsername($this->getRequestParameter('distributorCode'));
            $tbl_user->save();

            $c = new Criteria();
            $c->add(MlmPackageContractPeer::DIST_ID, $tbl_distributor->getDistributorId());
            $mlmPackageContracts = MlmPackageContractPeer::doSelect($c);

            foreach ($mlmPackageContracts as $mlmPackageContract) {
                $mlmPackageContract->setUsername($this->getRequestParameter('distributorCode'));
                $mlmPackageContract->setStatusCode("ACTIVE");
                $mlmPackageContract->save();
            }
        }
        if ($editFullname == "Y") {
            $remark = $tbl_distributor->getRemark();
            if ($remark != "") {
                $remark .= ", ";
            }
            $remark .= "renamed from ".$tbl_distributor->getFullName();
            $tbl_distributor->setRemark($remark);
            $tbl_distributor->setFullName($this->getRequestParameter('fullname'));

            $c = new Criteria();
            $c->add(MlmPackageContractPeer::DIST_ID, $tbl_distributor->getDistributorId());
            $mlmPackageContracts = MlmPackageContractPeer::doSelect($c);

            foreach ($mlmPackageContracts as $mlmPackageContract) {
                $mlmPackageContract->setFullName($this->getRequestParameter('fullname'));
                $mlmPackageContract->setInitialSignature($this->getRequestParameter('fullname'));
                $mlmPackageContract->setStatusCode("ACTIVE");
                $mlmPackageContract->save();
            }
        }
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

        // todo temp
        //$tbl_user->setUserpassword($this->getRequestParameter('password'));
        //$tbl_user->setUserpassword2($this->getRequestParameter('password2'));
        //$tbl_user->setStatusCode($this->getRequestParameter('status'));

        $tbl_user->save();

        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }
    public function executeDoRetrieveMemberData()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, "%".$this->getRequestParameter('distCode')."%", Criteria::LIKE);
        $c->setLimit(100);
        $distributorDBs = MlmDistributorPeer::doSelect($c);

        $output = array();
        $arr = array();
        foreach ($distributorDBs as $distributorDB) {
            $arr[] = array(
                $distributorDB->getDistributorId() == null ? "" : $distributorDB->getDistributorId(),
                $distributorDB->getDistributorCode() == null ? "" : $distributorDB->getDistributorCode()
            );
        }

        $output = array(
            "aaData" => $arr
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeDoUpdatePackagePurchase()
    {
        $tbl_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));
        //$tbl_distributor->setMt4UserName($this->getRequestParameter('mt4_user_name'));
        //$tbl_distributor->setMt4Password($this->getRequestParameter('mt4_password'));
        if ($tbl_distributor && $tbl_distributor->getPackagePurchaseFlag() == "Y") {
            $con = Propel::getConnection(MlmPipCsvPeer::DATABASE_NAME);
            $error = false;
            $errorMessage = "";

            try {
                $con->begin();

                $c = new Criteria();
                $c->add(MlmDistMt4Peer::MT4_USER_NAME, $this->getRequestParameter('mt4_user_name'));
                $mlmDistMt4DB = MlmDistMt4Peer::doSelectOne($c);

                if (!$mlmDistMt4DB) {
                    $tbl_distributor->setPackagePurchaseFlag("N");
                    $tbl_distributor->save();

                    $mlm_dist_mt4 = new MlmDistMt4();
                    $mlm_dist_mt4->setDistId($tbl_distributor->getDistributorId());
                    $mlm_dist_mt4->setRankId($tbl_distributor->getInitRankId());
                    $mlm_dist_mt4->setMt4UserName($this->getRequestParameter('mt4_user_name'));
                    $mlm_dist_mt4->setMt4Password($this->getRequestParameter('mt4_password'));
                    $mlm_dist_mt4->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_dist_mt4->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_dist_mt4->save();

                    $packageDB = MlmPackagePeer::retrieveByPK($tbl_distributor->getInitRankId());
                    if ($tbl_distributor->getDebitAccount() == "Y") {
                        $packageDB = MlmPackagePeer::retrieveByPK($tbl_distributor->getDebitRankId());
                    }

                    /* ****************************************************
                   * ROI Divident
                   * ***************************************************/
                    $dateUtil = new DateUtil();
                    $currentDate = $dateUtil->formatDate("Y-m-d", $tbl_distributor->getActiveDatetime()) . " 00:00:00";
                    $currentDate_timestamp = strtotime($currentDate);
                    //$dividendDate = $dateUtil->addDate($currentDate, 30, 0, 0);
                    $dividendDate = strtotime("+1 months", $currentDate_timestamp);

                    // MV168 all referrer exceeded 3% will transfer to his account
                    $exceedRoiSpecialCase = false;
                    $pos = strrpos($tbl_distributor->getTreeStructure(), "|295032|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $exceedRoiSpecialCase = true;
                    }

                    $mlm_roi_dividend = new MlmRoiDividend();
                    $mlm_roi_dividend->setDistId($tbl_distributor->getDistributorId());
                    $mlm_roi_dividend->setIdx(1);
                    $mlm_roi_dividend->setMt4UserName($this->getRequestParameter('mt4_user_name'));
                    //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                    $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                    $mlm_roi_dividend->setFirstDividendDate(date("Y-m-d h:i:s", $dividendDate));
                    $mlm_roi_dividend->setPackageId($packageDB->getPackageId());
                    $mlm_roi_dividend->setPackagePrice($packageDB->getPrice());
                    //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                    //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));

                    if ($exceedRoiSpecialCase == false) {
                        $mlm_roi_dividend->setRoiPercentage($packageDB->getMonthlyPerformance());
                        $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                    } else {
                        $roi = $packageDB->getMonthlyPerformance();
                        $exceedRoi = 0;
                        if ($roi > 3) {
                            $exceedRoi = $roi - 3;
                            $roi = $roi - 3;
                        }
                        $mlm_roi_dividend->setRoiPercentage($roi);
                        $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                        $mlm_roi_dividend->setExceedDistId(295032);
                        $mlm_roi_dividend->setExceedRoiPercentage($exceedRoi);
                    }
                    $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->save();

                    $userDB = AppUserPeer::retrieveByPK($tbl_distributor->getUserId());

                    $mlmPackageContract = new MlmPackageContract();
                    $mlmPackageContract->setDistId($tbl_distributor->getDistributorId());
                    $mlmPackageContract->setFullName($tbl_distributor->getFullName());
                    $mlmPackageContract->setUsername($userDB->getUsername());
                    $mlmPackageContract->setMt4Id($mlm_roi_dividend->getMt4UserName());
                    $mlmPackageContract->setPackagePrice($packageDB->getPrice());
                    $mlmPackageContract->setSignDateDay(date("d"));
                    $mlmPackageContract->setSignDateMonth(date("F"));
                    $mlmPackageContract->setSignDateYear(date("Y"));
                    $mlmPackageContract->setInitialSignature($tbl_distributor->getSignName());
                    $mlmPackageContract->setDistMt4Id($mlm_dist_mt4->getMt4Id());

                    if ($exceedRoiSpecialCase == false) {
                        $mlmPackageContract->setStatusCode(Globals::STATUS_ACTIVE);
                    } else {
                        $mlmPackageContract->setStatusCode(Globals::STATUS_COMPLETE);
                    }

                    $mlmPackageContract->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageContract->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageContract->save();

                    $this->sendEmailForMt4($this->getRequestParameter('mt4_user_name'), $this->getRequestParameter('mt4_password'), $tbl_distributor->getFullName(), $tbl_distributor->getEmail(), $tbl_distributor);
                } else {
                    $error = true;
                    $errorMessage = "MT4 already exist in database";
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            $output = array(
                "error" => $error
                , "errorMsg" => $errorMessage
            );
            echo json_encode($output);
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
            $tbl_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
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
            $tbl_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
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
    function getTotalSponsor($distributorId)
    {
        $query = "SELECT count(1) AS SUB_TOTAL FROM mlm_distributor WHERE upline_dist_id = " . $distributorId . " AND status_code = '" . Globals::STATUS_ACTIVE . "'";

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
            $response->setContentType('application/octet-stream');
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
            $response->setContentType('application/octet-stream');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/proof_of_residence/".$fileName);
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
            $response->setContentType('application/octet-stream');
            $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
            $response->setHttpHeader('Content-Disposition','attachment; filename='.$fileName, TRUE);
            $response->sendHttpHeaders();

            readfile(sfConfig::get('sf_upload_dir')."/bank_pass_book/".$fileName);
        }

        return sfView::NONE;
    }

    public function executeDoSendMemberMT4()
    {
        $tbl_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));

        $c = new Criteria();
        $c->add(MlmDistMt4Peer::DIST_ID, $this->getRequestParameter('distId'));
        $distMt4s = MlmDistMt4Peer::doSelect($c);

        if (count($distMt4s) >= 1) {
            foreach ($distMt4s as $distMt4) {
                $this->sendEmailForMt4($distMt4->getMt4UserName(), $distMt4->getMt4Password(), $tbl_distributor->getFullName(), $tbl_distributor->getEmail(), $tbl_distributor);
            }
        }

        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    public function executeDoSendMemberPassword()
    {
        $tbl_distributor = MlmDistributorPeer::retrieveByPk($this->getRequestParameter('distId'));
        $tbl_user = AppUserPeer::retrieveByPk($tbl_distributor->getUserId());

        $this->sendEmailForLoginPassword($tbl_distributor, $tbl_user->getUsername(), $tbl_user->getUserpassword(), $tbl_user->getUserpassword2());

        $output = array(
            "error" => false
        );
        echo json_encode($output);
        return sfView::HEADER_ONLY;
    }

    function sendEmailForMt4($mt4UserName, $mt4Password, $fullName, $email, $tbl_distributor=null)
    {
        if ($mt4UserName != "" && $mt4Password != "") {
                    $subject = "Your live trading account with Maxim Trader has been activated 您的马胜交易户口已被激活";

                    $body = "<table width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#939393' align='center'>
	<tbody>
		<tr>
			<td style='padding:20px 0px'>
				<table width='606' cellspacing='0' cellpadding='0' border='0' align='center' style='background:white;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
							<td colspan='2'>
								<a target='_blank' href='http://www.maximtrader.com'><img width='606' height='115' border='0' src='http://partner.maximtrader.com/images/email/banner.png' alt='Maxim Trader'></a></td>
						</tr>

						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
                                                                    Dear <strong>" . $fullName . "</strong>,<br><br>
                                                                    Congratulations! Your live trading account with Maxim Trader
                                                                    has been activated! Please find the details of your trading account as
                                                                    per below :<br><br>
                                                                    Live MT4 Trading Account ID : <strong>" . $mt4UserName . "</strong><br><br>
                                                                    Live MT4 Trading Account password : <strong>" . $mt4Password . "</strong><br><br>
                                                                    The Login ID and Password is strictly confidential and should not be
                                                                    disclosed to anyone. Should someone with access to your password wish,
                                                                    all of your account information can be changed. You will be held
                                                                    liable for any activity that may occur as a result of you losing your
                                                                    password. Therefore, if you feel that your password has been
                                                                    compromised, you should immediately contact us by email to
                                                                    <strong>support@maximtrader.com</strong> to rectify the situation.<br><br>
                                                                    We look forward to your custom in the near future. Should you have any
                                                                    queries, please do not hesitate to get back to us.<br>
                                                                </font>
																<br>

												<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
                                                Note: Trading credit of 70% from initial deposit will only be utilized for self trading with a variable of approximately 5%. The remaining 30% cannot be used as trading margin and the amount is to strictly WITHHOLD for fund management program.
                                                </font>
                                                <br>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody><tr>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform3.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>My<br> Account</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='http://partner.maximtrader.com' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-access.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
									</tr>
						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
												亲爱的 <strong>" . $fullName . "</strong>,<br><br>
												恭喜您！您的马胜交易户口已被激活！以下是您的交易帐户的详细资料：
												<br><br>
												MT4交易户口登录ID : <strong>" . $mt4UserName . "</strong><br><br>
												MT4交易户口密码 : <strong>" . $mt4Password . "</strong><br><br>
												登录ID和密码必须是严格保密及不应该向任何人透露。如果有人盗用了您的密码，
                                                您的帐户资料是有机会被篡改。您将必须承担任何可能发生的结果如果您遗失了你的密码。
                                                因此，如果您觉得您的密码不安全，您应该立即电邮联系我们
												<strong>support@maximtrader.com</strong>以纠正这种情况.<br><br>
												如果您有任何疑问，请不要犹豫立即联络我们。
												<br>
											</font>
											<br>

												<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
                                                会员账户中只有70%的初始投资及与之等额的MT4交易点数（附+-5%变化），才能用于会员自主交易. 剩余的初始资金的30%必须严格用于公司常规基金管理计划. 该规定所有会员均需遵守.
                                                </font>
                                                <br>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody><tr>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>

													</td>
													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> MT4 Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td><td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform1.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> IOS Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://itunes.apple.com/en/app/metatrader-4/id496212596?mt=8' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='91'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform2.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>Maxim Trader<br> Android Terminal</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-download_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>

													<td style='font-size:0;line-height:0' width='10'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='10' height='1'></td>
													<td style='font-size:0;line-height:0' width='85'>
														<table width='100%' cellpadding='0' cellspacing='0' border='0'>
															<tbody><tr>
																<td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/img-platform3.gif' width='85' height='60'></td>
															</tr>
															<tr>
																<td style='text-align:center;line-height:15px' align='center'>
																	<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																		<strong>My<br> Account</strong>
																	</font>
																</td>
															</tr>
															<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
															<tr>
																<td style='font-size:0;line-height:0'><a href='http://partner.maximtrader.com' target='_blank'><img src='http://partner.maximtrader.com/images/email/btn-access_cn.png' height='26' width='85' border='0'></a></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
									</tr>

						<tr>
							<td width='606' style='font-size:0;line-height:0' bgcolor='#0080C8'>
							<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'>
							</td>
						</tr>
						<tr>
							<td width='606' style='font-size:0;line-height:0' colspan='2'>
								<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'>
							</td>
						</tr>

						<tr>
							<td width='606' style='padding:15px 15px 0px;color:rgb(153,153,153);font-size:11px' colspan='2' align='right'>
							<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
								<em>
									Best Regards,<br>
									<strong>Maxim Trader Account Opening Team</strong><br>
								</em>
							</font>
							<br>
							<a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>
							<br>
						</tr>

						<tr>
							<td width='606' style='padding:5px 15px 20px;color:rgb(153,153,153);font-size:11px' colspan='2'>
							<p align='justify'>
								<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
									Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议。
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入。 请根据您可以承受的损失程度理性参与投资。 在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见。
								</font>
							</p>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>";

            $sendMailService = new SendMailService();
            $leaderArrs = explode(",", Globals::GROUP_LEADER);
            $isAmz001 = false;

            if ($tbl_distributor != null) {
                for ($i = 0; $i < count($leaderArrs); $i++) {
                    $pos = strrpos($tbl_distributor->getTreeStructure(), "|".$leaderArrs[$i]."|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        if ($leaderArrs[$i] == 1458) {
                            $isAmz001 = true;
                        }
                    }
                }
            }

            if ($isAmz001) {
                $dist = MlmDistributorPeer::retrieveByPK(1458);
                return $sendMailService->sendMail($email, $fullName, $subject, $body, $sendFrom=Mails::EMAIL_SENDER, $dist->getEmail());
            } else {
                return $sendMailService->sendMail($email, $fullName, $subject, $body);
            }
            return "";
        }
    }

    function sendEmailForPIA($mlmPackageContract, $mlmDistributor)
    {
        $subject = "Maxim Trader Private Investment Agreement";

        if ($mlmPackageContract) {
            $serverKey = md5($mlmPackageContract->getMt4Id() . $mlmPackageContract->getCreatedOn() . Globals::SALT_SOURCE);

            $body = "<table width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#939393' align='center'>
	<tbody>
		<tr>
			<td style='padding:20px 0px'>
				<table width='606' cellspacing='0' cellpadding='0' border='0' align='center' style='background:white;font-family:Arial,Helvetica,sans-serif'>
					<tbody>
						<tr>
							<td colspan='2'>
								<a target='_blank' href='http://www.maximtrader.com'><img width='606' height='115' border='0' src='http://partner.maximtrader.com/images/email/banner.png' alt='Maxim Trader'></a></td>
						</tr>

						<tr>
							<td colspan='2'>
								<table cellspacing='0' cellpadding='10' border='0'>
									<tbody>
										<tr>
											<td colspan='2'>
												<table style='background-color:rgb(246,246,246)'>
													<tbody>
														<tr>
															<td valign='top' style='padding-top:15px;padding-left:10px'>
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
                                                                    Dear <strong>" . $mlmDistributor->getFullName() . "</strong>,<br><br>
                                                                    Below are the contractural terms and agreements that you are bound by as a client of MaximTrader. We recommend that you take the time to read each of them carefully.<br><br>
                                                                    We look forward to your custom in the near future. Should you have any
                                                                    queries, please do not hesitate to get back to us.<br>
                                                                </font>
                                                <br>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='42'></td></tr>
									<tr>
										<td valign='top' width='551' colspan='2'>
											<table width='100%' cellpadding='0' cellspacing='0' border='0'>
												<tbody>
													<tr>
														<td style='font-size:0;line-height:0' align='center'>
														<a href='http://partner.maximtrader.com/download/privateInvestmentAgreementContractEK?q=".$mlmPackageContract->getMt4Id()."&k=".$serverKey."' target='_blank'>
														<img src='http://partner.maximtrader.com/images/common/download_pdf.png' height='60'>
														</a>
														</td>
													</tr>
													<tr>
														<td style='text-align:center;line-height:15px' align='center'>
															<font face='Arial, Verdana, sans-serif' size='3' color='#58584b' style='font-size:11px;line-height:15px'>
																<strong>Download<br> PIA</strong>
															</font>
														</td>
													</tr>
													<tr>
													<td>&nbsp;</td>
													</tr>

											</tbody></table>
										</td>
									</tr>


						<tr>
							<td width='606' style='font-size:0;line-height:0' bgcolor='#0080C8'>
							<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'>
							</td>
						</tr>
						<tr>
							<td width='606' style='font-size:0;line-height:0' colspan='2'>
								<img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'>
							</td>
						</tr>

						<tr>
							<td width='606' style='padding:15px 15px 0px;color:rgb(153,153,153);font-size:11px' colspan='2' align='right'>
							<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
								<em>
									Best Regards,<br>
									<strong>Maxim Trader Account Opening Team</strong><br>
								</em>
							</font>
							<br>
							<a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>
							<br>
						</tr>

						<tr>
							<td width='606' style='padding:5px 15px 20px;color:rgb(153,153,153);font-size:11px' colspan='2'>
							<p align='justify'>
								<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
									Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议。
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入。 请根据您可以承受的损失程度理性参与投资。 在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见。
								</font>
							</p>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>";
            $sendMailService = new SendMailService();

            $return = $sendMailService->sendMailPia($mlmDistributor->getEmail(), $mlmDistributor->getFullName(), $subject, $body);

            if ($return == "") {
                return true;
            }
        }


        return false;
    }

    function sendEmailForLoginPassword($existDistributor, $username, $password, $password2)
    {
        if ($existDistributor && $username != "" && $password != "" && $password2 != "") {
            $subject = "Maxim Trader - Account Password Retrieval";
                                $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $existDistributor->getFullName()), 'email') . ",<p><p>
                                <p>" . $this->getContext()->getI18N()->__("On our record, you have requested to retrieve your forgotten password. Your account(s) detail together with the password is listed below.", null, 'email') . "</p>
                                <p><br><b>" . $this->getContext()->getI18N()->__("Username", null) . ": " . $username . "</b>
                                <br><b>" . $this->getContext()->getI18N()->__("Account Password", null) . ": " . $password . "</b>
                                <br><b>" . $this->getContext()->getI18N()->__("Security Password", null) . ": " . $password2 . "</b>
                                <p><br>" . $this->getContext()->getI18N()->__("If you do not requested for this password retrieval, you can simply ignore this email since only you will receive this email. For more information, please contact us.", null, 'email') . "</p>
                                <p><a href='http://partner.maximtrader.com' target='_blank'>http://partner.maximtrader.com</a>";

                                $body = "<table width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#939393' align='center'>
                <tbody>
                    <tr>
                        <td style='padding:20px 0px'>
                            <table width='606' cellspacing='0' cellpadding='0' border='0' align='center' style='background:white;font-family:Arial,Helvetica,sans-serif'>
                                <tbody>
                                    <tr>
                                        <td colspan='2'>
                                            <a target='_blank' href='http://www.maximtrader.com'><img width='606' height='115' border='0' src='http://partner.maximtrader.com/images/email/banner.png' alt='Maxim Trader'></a></td>
                                    </tr>

                                    <tr>
                                        <td colspan='2'>
                                            <table cellspacing='0' cellpadding='10' border='0'>
                                                <tbody>
                                                    <tr>
                                                        <td colspan='2'>
                                                            <table style='background-color:rgb(246,246,246)'>
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign='top' style='padding-top:15px;padding-left:10px'>
                                                                            <font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
                                                                                Dear <strong>" . $existDistributor->getFullName() . "</strong>,<br>
                                                                                <br>" . $this->getContext()->getI18N()->__("Username", null) . ": <b>" . $username . "</b>
                                                                                <br>" . $this->getContext()->getI18N()->__("Account Password", null) . ": <b>" . $password . "</b>
                                                                                <br>" . $this->getContext()->getI18N()->__("Security Password", null) . ": <b>" . $password2 . "</b>
                                                                                <br><br>" . $this->getContext()->getI18N()->__("If you do not requested for this password retrieval, you can simply ignore this email since only you will receive this email. For more information, please contact us.", null, 'email') . "
                                                                            </font>
                                                                            <br>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width='606' style='font-size:0;line-height:0' bgcolor='#0080C8'>
                                        <img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width='606' style='font-size:0;line-height:0' colspan='2'>
                                            <img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width='606' style='padding:15px 15px 0px;color:rgb(153,153,153);font-size:11px' colspan='2' align='right'>
                                        <font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
                                            <em>
                                                Best Regards,<br>
                                                <strong>Maxim Trader Account Opening Team</strong><br>
                                            </em>
                                        </font>
                                        <br>
                                        <a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>
                                        <br>
                                    </tr>

                                    <tr>
                                        <td width='606' style='padding:5px 15px 20px;color:rgb(153,153,153);font-size:11px' colspan='2'>
                                        <p align='justify'>
                                            <font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
                                                Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
																		<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议。
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入。 请根据您可以承受的损失程度理性参与投资。 在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见。
                                            </font>
                                        </p>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>";
                $sendMailService = new SendMailService();
                $sendMailService->sendForgetPassword($existDistributor, $subject, $body);
        }
    }

    function updateLeaderForNotificationOfMaturity()
    {
        $c = new Criteria();
        $c->add(NotificationOfMaturityPeer::LEADER_DIST_ID, null, Criteria::ISNULL);
        $notificationOfMaturitys = NotificationOfMaturityPeer::doSelect($c);

        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        $leader = "";
        //var_dump($notificationOfMaturitys);
        foreach ($notificationOfMaturitys as $notificationOfMaturity) {

            $distDB = MlmDistributorPeer::retrieveByPK($notificationOfMaturity->getDistId());

            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $notificationOfMaturity->setLeaderDistId($dist->getDistributorId());
                        $notificationOfMaturity->save();
                    }
                    break;
                }
            }
        }

        $c = new Criteria();
        $c->add(NotificationOfMaturityPeer::PACKAGE_PRICE, null, Criteria::ISNULL);
        $notificationOfMaturitys = NotificationOfMaturityPeer::doSelect($c);

        foreach ($notificationOfMaturitys as $notificationOfMaturity) {
            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $notificationOfMaturity->getMt4UserName());
            $roiDBs = MlmRoiDividendPeer::doSelectOne($c);

            $distDB = MlmDistributorPeer::retrieveByPK($notificationOfMaturity->getDistId());

            for ($i = 0; $i < count($leaderArrs); $i++) {
                $pos = strrpos($distDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                    if ($dist) {
                        $notificationOfMaturity->setLeaderDistId($dist->getDistributorId());
                        $notificationOfMaturity->save();
                    }
                    break;
                }
            }
        }
    }

    function getPipsBonus($distId)
    {
        $arr = array();
        $query = "
            SELECT dist.distributor_id
                    , Coalesce(sales._PIPS_BONUS, 0) AS _PIPS_BONUS
                    , Coalesce(cf._CREDIT_REFUND, 0) AS _CREDIT_REFUND
                    FROM mlm_distributor dist
                    LEFT JOIN (
                        SELECT SUM(credit-debit) AS _PIPS_BONUS, dist_id
                            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_PIPS_BONUS."' AND dist_id = ".$distId."
                                AND created_on >= '".date("Y-m")."-01 00:00:00' AND created_on <= '".date("Y-m")."-28 23:59:59'
                    ) sales ON dist.distributor_id = sales.dist_id
                    LEFT JOIN (
                        SELECT SUM(credit-debit) AS _CREDIT_REFUND, dist_id
                            FROM mlm_dist_commission_ledger WHERE commission_type = '".Globals::COMMISSION_TYPE_CREDIT_REFUND."' AND dist_id = ".$distId."
                                AND created_on >= '".date("Y-m")."-01 00:00:00' AND created_on <= '".date("Y-m")."-28 23:59:59'
                    ) cf ON dist.distributor_id = cf.dist_id
            WHERE dist.distributor_id = ".$distId;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            return $arr;
        }
        return null;
    }

    function generateMt4Password()
    {
        $max_digit = 999999;
        $digit = 6;

        $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));

        $fcode = rand(0, $max_digit) . "";
        $fcode = str_pad($fcode, $digit, "0", STR_PAD_LEFT);

        return $char.$fcode;
    }

    function mirroringAccountLedger($mlmAccountLedger, $internalRemark)
    {
        $log_account_ledger = new LogAccountLedger();
        $log_account_ledger->setAccountId($mlmAccountLedger->getAccountId());
        $log_account_ledger->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
        $log_account_ledger->setDistId($mlmAccountLedger->getDistId());
        $log_account_ledger->setAccountType($mlmAccountLedger->getAccountType());
        $log_account_ledger->setTransactionType($mlmAccountLedger->getTransactionType());
        $log_account_ledger->setRemark($mlmAccountLedger->getRemark());
        $log_account_ledger->setInternalRemark($internalRemark);
        $log_account_ledger->setCredit($mlmAccountLedger->getCredit());
        $log_account_ledger->setDebit($mlmAccountLedger->getDebit());
        $log_account_ledger->setBalance($mlmAccountLedger->getBalance());
        $log_account_ledger->setCreatedBy($mlmAccountLedger->getCreatedBy());
        $log_account_ledger->setUpdatedBy($mlmAccountLedger->getUpdatedBy());
        $log_account_ledger->save();
    }

    function revalidatePairing($distributorId, $leftRight)
    {
        $c = new Criteria();
        $c->add(MlmDistPairingPeer::DIST_ID, $distributorId);
        $tbl_account = MlmDistPairingPeer::doSelectOne($c);

        if (!$tbl_account) {
            $tbl_account = new MlmDistPairing();
            $tbl_account->setDistId($distributorId);
            $tbl_account->setLeftBalance(0);
            $tbl_account->setRightBalance(0);
            $tbl_account->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $tbl_account->save();
        }
    }
}