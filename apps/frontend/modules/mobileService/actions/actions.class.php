<?php

class mobileServiceActions extends sfActions
{
    /*****
     * Basic function reference format (with custom logic).
     * Instead of adding more line of code at other actions.class.php files,
     * try move results from other actions using MUserObj to here.
     *****
     *
     * public function executeMyUrl()
     * {
     * if ($this->isResponded()) {
     * $muObj = new MUserObj();
     * $muObj->loadFromSession($this);
     *
     * if ($muObj->isEmpty()) {
     * return $this->emptyDataException();
     * }
     *
     * // TODO Your code/logic here.
     * } else {
     * if (!$this->isValidAccess()) {
     * return sfView::HEADER_ONLY;
     * }
     *
     * return $this->forward("myModule", "myAction"); // TODO Change this.
     * }
     * }
     *****
     * Basic function reference format (redirect only).
     *****
     *
     * public function executeMyUrl()
     * {
     * if (!$this->isValidAccess()) {
     * return sfView::HEADER_ONLY;
     * }
     *
     * return $this->forward("myModule", "myAction"); // TODO Change this.
     * }
     *****/

    public function executeIndex()
    {
        // TODO Test generate msc
//        echo md5("user" . "pass" . MUserUtil::SECRET_CODE);
//        return sfView::HEADER_ONLY;
        return $this->forward404();
    }

    public function executeAnnouncement()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        $start = intval($this->getRequestParameter("start", 0));
        $length = $this->getRequestParameter("length", 3);

        if (intval($length) < 1) {
            $length = 1;
        }

        $sql = "SELECT ns_title, ns_content, ns_start_date " .
            "FROM app_news " .
            "WHERE ns_status = '" . Globals::STATUS_ACTIVE . "' " .
            "AND ns_start_date <= NOW() " .
            "AND ns_end_date > NOW() " .
            "ORDER BY ns_start_date DESC, id DESC " .
            "LIMIT " . $length . " OFFSET " . $start . " ";
        $rs = Propel::getConnection(AppNewsPeer::DATABASE_NAME)->executeQuery($sql);

        $data = array();

        while ($rs->next()) {
            $r = $rs->getRow();

            array_push($data, array(
                "title" => $r["ns_title"],
                "date" => date_format(DateTime::createFromFormat("Y-m-d H:i:s", $r["ns_start_date"]), "Y-m-d"),
                "content" => $r["ns_content"]
            ));
        }

        echo MUserUtil::init($this)->getJson(1, "", array("data" => $data));
        return sfView::HEADER_ONLY;
    }

    public function executeMemberSummary()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $mt4JsonData = array();

            foreach ($muObj->distMt4s as $distMt4) {
                $joinDate = $distMt4->getCreatedOn();
                $arr = explode(" ", $joinDate);

                switch ($muObj->colorArr[$distMt4->getRankId()]) {
                    case "blue":
                        $rankColor = "0099cc";
                        break;
                    case "green":
                        $rankColor = "33ff33";
                        break;
                    case "red":
                        $rankColor = "ff6666";
                        break;
                    case "gold":
                        $rankColor = "ffff33";
                        break;
                    case "pink":
                        $rankColor = "ff99ff";
                        break;
                    case "white":
                        $rankColor = "ffffff";
                        break;
                    default:
                        $rankColor = "000000";
                        break;
                }

                array_push($mt4JsonData, array(
                    "value" => $distMt4->getMt4UserName() . " [" . $arr[0] . "]",
                    "color" => $rankColor
                ));
            }

            $jsonData = array(
                "data" => array(
                    "account_info" => array(
                        "label" => $this->getContext()->getI18N()->__("Account Information"),
                        "value" => array(
                            "member_id" => array(
                                "label" => $this->getContext()->getI18N()->__("Member ID"),
                                "value" => $muObj->distributorCode
                            ),
                            "mt4_id" => array(
                                "label" => $this->getContext()->getI18N()->__("MT4 ID"),
                                "value" => $mt4JsonData
                            ),
                            "ranking" => array(
                                "label" => $this->getContext()->getI18N()->__("Ranking"),
                                "value" => $muObj->ranking
                            ),
                            "status" => array(
                                "label" => $this->getContext()->getI18N()->__("Status"),
                                "value" => $muObj->statusCode
                            ),
                            "last_login" => array(
                                "label" => $this->getContext()->getI18N()->__("Last Login"),
                                "value" => $muObj->lastLogin
                            )
                        )
                    ),
                    "account_point" => array(
                        "label" => $this->getContext()->getI18N()->__("Your Account Point"),
                        "value" => array(
                            "currency" => array(
                                "label" => $this->getContext()->getI18N()->__("Currency"),
                                "value" => $muObj->currencyCode
                            ),
                            "cp1_account" => array(
                                "label" => $this->getContext()->getI18N()->__("CP1 Account"),
                                "value" => $muObj->cp1Account
                            ),
                            "cp2_account" => array(
                                "label" => $this->getContext()->getI18N()->__("CP2 Account"),
                                "value" => $muObj->cp2Account
                            ),
                            "cp3_account" => array(
                                "label" => $this->getContext()->getI18N()->__("CP3 Account"),
                                "value" => $muObj->cp3Account
                            ),
                            "rp_account" => array(
                                "label" => $this->getContext()->getI18N()->__("RP Account"),
                                "visible" => $muObj->rpAccountVisible,
                                "value" => $muObj->rpAccount
                            ),
                            "rt_account" => array(
                                "label" => $this->getContext()->getI18N()->__("RT Account"),
                                "visible" => $muObj->rtAccountVisible,
                                "value" => $muObj->rtAccount
                            )
                        )
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "summary");
        }
    }

    public function executeVerifySameGroupSponsorId()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        return $this->forward("member", "verifySameGroupSponsorId");
    }

    public function executeVerifyTransactionPassword()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        return $this->forward("member", "verifyTransactionPassword");
    }

    public function executeTransferCp1()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $jsonData = array(
                "data" => array(
                    "sponsor_id" => array(
                        "label" => $this->getContext()->getI18N()->__("Transfer To User Name"),
                    ),
                    "member_name" => array(
                        "label" => $this->getContext()->getI18N()->__("Member Name"),
                    ),
                    "transfer_amount" => array(
                        "label" => $this->getContext()->getI18N()->__("Transfer CP1 Amount"),
                    ),
                    "reference_remark" => array(
                        "label" => $this->getContext()->getI18N()->__("Reference Remark"),
                    ),
                    "transaction_password" => array(
                        "label" => $this->getContext()->getI18N()->__("Security Password"),
                    ),
                    "cp1_balance" => array(
                        "label" => $this->getContext()->getI18N()->__("CP1 Balance"),
                        "value" => $muObj->cp1Balance
                    ),
                    "process_fee" => array(
                        "label" => $this->getContext()->getI18N()->__('every transfer action need to pay USD%1%.00 processing fees', array('%1%' => $muObj->processFee)),
                        "value" => $muObj->processFee
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "transferEpoint");
        }
    }

    public function executeTransferCp2()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $jsonData = array(
                "data" => array(
                    "sponsor_id" => array(
                        "label" => $this->getContext()->getI18N()->__("Transfer To User Name"),
                    ),
                    "member_name" => array(
                        "label" => $this->getContext()->getI18N()->__("Member Name"),
                    ),
                    "transfer_amount" => array(
                        "label" => $this->getContext()->getI18N()->__("Transfer CP2 Amount"),
                    ),
                    "reference_remark" => array(
                        "label" => $this->getContext()->getI18N()->__("Reference Remark"),
                    ),
                    "transaction_password" => array(
                        "label" => $this->getContext()->getI18N()->__("Security Password"),
                    ),
                    "cp2_balance" => array(
                        "label" => $this->getContext()->getI18N()->__("CP2 Balance"),
                        "value" => $muObj->cp2Balance
                    ),
                    "process_fee" => array(
                        "label" => $this->getContext()->getI18N()->__('every transfer action need to pay USD%1%.00 processing fees', array('%1%' => $muObj->processFee)),
                        "value" => $muObj->processFee
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "transferCp2");
        }
    }

    public function executeTransferCp3()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $jsonData = array(
                "data" => array(
                    "sponsor_id" => array(
                        "label" => $this->getContext()->getI18N()->__("Transfer To User Name"),
                    ),
                    "member_name" => array(
                        "label" => $this->getContext()->getI18N()->__("Member Name"),
                    ),
                    "transfer_amount" => array(
                        "label" => $this->getContext()->getI18N()->__("Transfer CP3 Amount"),
                    ),
                    "reference_remark" => array(
                        "label" => $this->getContext()->getI18N()->__("Reference Remark"),
                    ),
                    "transaction_password" => array(
                        "label" => $this->getContext()->getI18N()->__("Security Password"),
                    ),
                    "cp3_balance" => array(
                        "label" => $this->getContext()->getI18N()->__("CP3 Balance"),
                        "value" => $muObj->cp3Balance
                    ),
                    "process_fee" => array(
                        "label" => $this->getContext()->getI18N()->__('every transfer action need to pay USD%1%.00 processing fees', array('%1%' => $muObj->processFee)),
                        "value" => $muObj->processFee
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "transferCp3");
        }
    }

    public function executeConvertCp2ToCp1()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $jsonData = array(
                "data" => array(
                    "cp2_balance" => array(
                        "label" => $this->getContext()->getI18N()->__("CP2 Balance"),
                        "value" => $muObj->cp2Balance
                    ),
                    "convert_rate" => array(
                        "label" => $this->getContext()->getI18N()->__("Convert Rate"),
                        "value" => $muObj->convertRate
                    ),
                    "note" => array(
                        "label" => $this->getContext()->getI18N()->__("Note"),
                        "value" => $this->getContext()->getI18N()->__("CP1 is ONLY for package purchase, package upgrade, MT4 account reload and is NON-WITHDRAWABLE.")
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "convertEcashToEpoint");
        }
    }

    public function executeConvertCp3ToCp1()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $jsonData = array(
                "data" => array(
                    "cp3_balance" => array(
                        "label" => $this->getContext()->getI18N()->__("CP3 Balance"),
                        "value" => $muObj->cp3Balance
                    ),
                    "convert_rate" => array(
                        "label" => $this->getContext()->getI18N()->__("Convert Rate"),
                        "value" => $muObj->convertRate
                    ),
                    "note" => array(
                        "label" => $this->getContext()->getI18N()->__("Note"),
                        "value" => $this->getContext()->getI18N()->__("CP1 is ONLY for package purchase, package upgrade, MT4 account reload and is NON-WITHDRAWABLE.")
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "convertCp3ToCp1");
        }
    }

    public function executeCommissionList()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        $dStart = $this->getRequestParameter("start", 0);
        $dLength = $this->getRequestParameter("length", 10);

        $this->getRequest()->setParameter("iDisplayStart", $dStart);
        $this->getRequest()->setParameter("iDisplayLength", $dLength);
        $this->getRequest()->setParameter("sColumns", "commission.created_on,_DRB,_GDB,_PIPS_BONUS,_SPECIAL_BONUS,SUB_TOTAL");
        $this->getRequest()->setParameter("sEcho", 1);
        $this->getRequest()->setParameter("iColumns", 6);
        $this->getRequest()->setParameter("iSortingCols", 1);
        $this->getRequest()->setParameter("iSortCol_0", 0);
        $this->getRequest()->setParameter("sSortDir_0", "desc");
        $this->getRequest()->setParameter("bSortable_0", "true");
        $this->getRequest()->setParameter("bSortable_1", "true");
        $this->getRequest()->setParameter("bSortable_2", "true");
        $this->getRequest()->setParameter("bSortable_3", "true");
        $this->getRequest()->setParameter("bSortable_4", "true");
        $this->getRequest()->setParameter("bSortable_5", "true");

        return $this->forward("finance", "bonusDetailLogList");
    }

    public function executeCommissionListDetail()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        $dStart = $this->getRequestParameter("start", 0);
        $dLength = $this->getRequestParameter("length", 10);
        $dAction = $this->getRequestParameter("faction", false);
        $dDate = $this->getRequestParameter("fdate", false);

        if (!$dAction || !$dDate) {
            $msg = $this->action->getContext()->getI18N()->__("Invalid action: missing required parameters.");
            echo MUserUtil::init($this)->updateLog($msg)->getJson(0, $msg);
            return sfView::HEADER_ONLY;
        }

        $this->getRequest()->setParameter("iDisplayStart", $dStart);
        $this->getRequest()->setParameter("iDisplayLength", $dLength);
        $this->getRequest()->setParameter("filterAction", $dAction);
        $this->getRequest()->setParameter("filterDate", $dDate);
        $this->getRequest()->setParameter("sColumns", "created_on,credit,debit,balance,remark");
        $this->getRequest()->setParameter("sEcho", 1);
        $this->getRequest()->setParameter("iColumns", 5);
        $this->getRequest()->setParameter("iSortingCols", 1);
        $this->getRequest()->setParameter("iSortCol_0", 0);
        $this->getRequest()->setParameter("sSortDir_0", "desc");
        $this->getRequest()->setParameter("bSortable_0", "true");
        $this->getRequest()->setParameter("bSortable_1", "true");
        $this->getRequest()->setParameter("bSortable_2", "true");
        $this->getRequest()->setParameter("bSortable_3", "true");
        $this->getRequest()->setParameter("bSortable_4", "true");
        $this->getRequest()->setParameter("bSortable_5", "true");

        return $this->forward("finance", "bonusDetailList");
    }

    public function executeMt4Withdrawal()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $mt4JsonData = array();

            foreach ($muObj->distMt4DBs as $distMt4) {
                array_push($mt4JsonData, $distMt4->getMt4UserName());
            }

            $mt4FundJsonData = array();

            for ($i = 100; $i <= 10000; $i = $i + 100) {
                array_push($mt4FundJsonData, $i);
//                $mt4FundJsonData[$i] = $i;
            }
            for ($i = 10500; $i <= 100000; $i = $i + 500) {
                array_push($mt4FundJsonData, $i);
//                $mt4FundJsonData[$i] = $i;
            }

            $jsonData = array(
                "data" => array(
                    "usd_to_myr" => array(
                        "value" => $muObj->usdToMyr
                    ),
                    "handling_charge" => array(
                        "value" => $muObj->handlingCharge
                    ),
                    "handling_charge_in_usd" => array(
                        "value" => $muObj->handlingChargeInUsd
                    ),
                    "mt4_fund_withdrawal" => array(
                        "label" => $this->getContext()->getI18N()->__("MT4 Fund Withdrawal Amount In USD"),
                        "value" => $mt4FundJsonData
                    ),
                    "mt4_id" => array(
                        "label" => $this->getContext()->getI18N()->__("MT4 ID"),
                        "value" => $mt4JsonData
                    ),
                    "note" => array(
                        "label" => $this->getContext()->getI18N()->__("Note"),
                        "value" => "1. " . $this->getContext()->getI18N()->__("Minimum withdrawal amount : USD 100") . "<br />" .
                            "2. " . $this->getContext()->getI18N()->__("Processing time : 3 working days") . "<br />" .
                            "3. " . $this->getContext()->getI18N()->__("Please close your floating trading before you submit withdrawal") . "<br />" .
                            "4. " . $this->getContext()->getI18N()->__("MT4 Withdrawal will be credited into CP3 account")
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "mt4Withdrawal");
        }
    }

    public function executeMt4WithdrawalList()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        $dStart = $this->getRequestParameter("start", 0);
        $dLength = $this->getRequestParameter("length", 10);

        $this->getRequest()->setParameter("iDisplayStart", $dStart);
        $this->getRequest()->setParameter("iDisplayLength", $dLength);
        $this->getRequest()->setParameter("sColumns", "dist_id,currency_code,created_on,amount_requested,handling_fee,grand_amount,payment_type,status_code,remarks");
        $this->getRequest()->setParameter("sEcho", 1);
        $this->getRequest()->setParameter("iColumns", 9);
        $this->getRequest()->setParameter("iSortingCols", 1);
        $this->getRequest()->setParameter("iSortCol_0", 2);
        $this->getRequest()->setParameter("sSortDir_0", "desc");
        $this->getRequest()->setParameter("bSortable_0", "true");
        $this->getRequest()->setParameter("bSortable_1", "true");
        $this->getRequest()->setParameter("bSortable_2", "true");
        $this->getRequest()->setParameter("bSortable_3", "true");
        $this->getRequest()->setParameter("bSortable_4", "true");
        $this->getRequest()->setParameter("bSortable_5", "true");
        $this->getRequest()->setParameter("bSortable_6", "true");
        $this->getRequest()->setParameter("bSortable_7", "true");
        $this->getRequest()->setParameter("bSortable_8", "true");

        return $this->forward("finance", "mt4WithdrawalList");
    }

    public function executeCp2Withdrawal()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $creditToJsonData = array(
                Globals::WITHDRAWAL_IACCOUNT => $this->getContext()->getI18N()->__("i-Account"),
                Globals::WITHDRAWAL_LOCAL_BANK => $this->getContext()->getI18N()->__("Local Bank Transfer")
            );

            $cp2AmountJsonData = array();

            for ($i = 100; $i <= 10000; $i = $i + 100) {
                array_push($cp2AmountJsonData, $i);
            }
            for ($i = 10500; $i <= 100000; $i = $i + 500) {
                array_push($cp2AmountJsonData, $i);
            }

            $jsonData = array(
                "data" => array(
                    "cp2_balance" => array(
                        "label" => $this->getContext()->getI18N()->__("CP2 Balance"),
                        "value" => $muObj->cp2Balance
                    ),
                    "cp2_withdrawal_amount" => array(
                        "label" => $this->getContext()->getI18N()->__("CP2 Withdrawal Amount"),
                        "value" => $cp2AmountJsonData
                    ),
                    "credit_to" => array(
                        "label" => $this->getContext()->getI18N()->__("Credit To"),
                        "value" => $creditToJsonData
                    ),
                    "note" => array(
                        "label" => $this->getContext()->getI18N()->__("Note"),
                        "value" => "1. " . $this->getContext()->getI18N()->__("Minimum withdrawal amount is USD100") . "<br/>" .
                            "2. " . $this->getContext()->getI18N()->__("Withdrawal request must be done during the first 7 days of each month") . "<br/>" .
                            "3. " . $this->getContext()->getI18N()->__("Processing time will be at least 3 days") . "<br/>" .
                            "4. " . $this->getContext()->getI18N()->__("Payout will be by the 15th of each month") . "<br/>" .
                            "5. " . $this->getContext()->getI18N()->__("Handling Fee USD60 or 5% whichever is higher") . "<br/>" .
                            "6. " . $this->getContext()->getI18N()->__("All withdrawals shall be paid out based on current days\' prevailing exchange rate and subject to local bank charges") . "<br/>" .
                            "7. " . $this->getContext()->getI18N()->__("Payout time for monthly CP2 withdrawals to be credited to your account:") . "<br/>" .
                            "&nbsp;&nbsp;a. " . $this->getContext()->getI18N()->__("Local bank accounts - by 25th") . " " . $this->getContext()->getI18N()->__("(Excluding non-working days)") . "<br/>" .
                            "&nbsp;&nbsp;b. " . $this->getContext()->getI18N()->__("i-Account - by 11th") . " " . $this->getContext()->getI18N()->__("(Excluding non-working days)")
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "ecashWithdrawal");
        }
    }

    public function executeCp2WithdrawalList()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        $dStart = $this->getRequestParameter("start", 0);
        $dLength = $this->getRequestParameter("length", 10);

        $this->getRequest()->setParameter("iDisplayStart", $dStart);
        $this->getRequest()->setParameter("iDisplayLength", $dLength);
        $this->getRequest()->setParameter("sColumns", "dist_id,deduct,amount,bank_in_to,status_code,remarks,created_on");
        $this->getRequest()->setParameter("sEcho", 1);
        $this->getRequest()->setParameter("iColumns", 7);
        $this->getRequest()->setParameter("iSortingCols", 1);
        $this->getRequest()->setParameter("iSortCol_0", 6);
        $this->getRequest()->setParameter("sSortDir_0", "desc");
        $this->getRequest()->setParameter("bSortable_0", "true");
        $this->getRequest()->setParameter("bSortable_1", "true");
        $this->getRequest()->setParameter("bSortable_2", "true");
        $this->getRequest()->setParameter("bSortable_3", "true");
        $this->getRequest()->setParameter("bSortable_4", "true");
        $this->getRequest()->setParameter("bSortable_5", "true");
        $this->getRequest()->setParameter("bSortable_6", "true");

        return $this->forward("finance", "ecashWithdrawalList");
    }

    public function executeCp3Withdrawal()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $creditToJsonData = array(
                Globals::WITHDRAWAL_IACCOUNT => $this->getContext()->getI18N()->__("i-Account"),
                Globals::WITHDRAWAL_LOCAL_BANK => $this->getContext()->getI18N()->__("Local Bank Transfer")
            );

            $cp3AmountJsonData = array();

            for ($i = 100; $i <= 10000; $i = $i + 100) {
                array_push($cp3AmountJsonData, $i);
            }
            for ($i = 10500; $i <= 100000; $i = $i + 500) {
                array_push($cp3AmountJsonData, $i);
            }

            $jsonData = array(
                "data" => array(
                    "cp3_balance" => array(
                        "label" => $this->getContext()->getI18N()->__("CP3 Balance"),
                        "value" => $muObj->cp2Balance
                    ),
                    "cp3_withdrawal_amount" => array(
                        "label" => $this->getContext()->getI18N()->__("CP3 Withdrawal Amount"),
                        "value" => $cp3AmountJsonData
                    ),
                    "credit_to" => array(
                        "label" => $this->getContext()->getI18N()->__("Credit To"),
                        "value" => $creditToJsonData
                    ),
                    "note" => array(
                        "label" => $this->getContext()->getI18N()->__("Note"),
                        "value" => "1. " . $this->getContext()->getI18N()->__("Minimum withdrawal amount is USD100") . "<br/>" .
                            "2. " . $this->getContext()->getI18N()->__("Withdrawal request must be done during the first 7 days of each month") . "<br/>" .
                            "3. " . $this->getContext()->getI18N()->__("Processing time will be at least 3 days") . "<br/>" .
                            "4. " . $this->getContext()->getI18N()->__("Payout will be by the 15th of each month") . "<br/>" .
                            "5. " . $this->getContext()->getI18N()->__("Handling Fee is USD30") . "<br/>" .
                            "6. " . $this->getContext()->getI18N()->__("All withdrawals shall be paid out based on current days\' prevailing exchange rate and subject to local bank charges") . "<br/>" .
                            "7. " . $this->getContext()->getI18N()->__("Payout time for monthly CP3 withdrawals to be credited to your account:") . "<br/>" .
                            "&nbsp;&nbsp;a. " . $this->getContext()->getI18N()->__("Local bank accounts - by 25th") . " " . $this->getContext()->getI18N()->__("(Excluding non-working days)") . "<br/>" .
                            "&nbsp;&nbsp;b. " . $this->getContext()->getI18N()->__("i-Account - by 11th") . " " . $this->getContext()->getI18N()->__("(Excluding non-working days)")
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            return $this->forward("member", "cp3Withdrawal");
        }
    }

    public function executeCp3WithdrawalList()
    {
        if (!$this->isValidAccess()) {
            return sfView::HEADER_ONLY;
        }

        $dStart = $this->getRequestParameter("start", 0);
        $dLength = $this->getRequestParameter("length", 10);

        $this->getRequest()->setParameter("iDisplayStart", $dStart);
        $this->getRequest()->setParameter("iDisplayLength", $dLength);
        $this->getRequest()->setParameter("sColumns", "dist_id,deduct,amount,bank_in_to,status_code,remarks,created_on");
        $this->getRequest()->setParameter("sEcho", 1);
        $this->getRequest()->setParameter("iColumns", 7);
        $this->getRequest()->setParameter("iSortingCols", 1);
        $this->getRequest()->setParameter("iSortCol_0", 6);
        $this->getRequest()->setParameter("sSortDir_0", "desc");
        $this->getRequest()->setParameter("bSortable_0", "true");
        $this->getRequest()->setParameter("bSortable_1", "true");
        $this->getRequest()->setParameter("bSortable_2", "true");
        $this->getRequest()->setParameter("bSortable_3", "true");
        $this->getRequest()->setParameter("bSortable_4", "true");
        $this->getRequest()->setParameter("bSortable_5", "true");
        $this->getRequest()->setParameter("bSortable_6", "true");

        return $this->forward("finance", "cp3WithdrawalList");
    }

    public function executeMemberProfile()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $jsonData = array(
                "data" => array(
                    "fullname" => array(
                        "label" => $this->getContext()->getI18N()->__("Full Name"),
                        "value" => $muObj->distDB->getFullName()
                    ),
                    "country" => array(
                        "label" => $this->getContext()->getI18N()->__("Country"),
                        "value" => $muObj->distDB->getCountry()
                    ),
                    "dob" => array(
                        "label" => $this->getContext()->getI18N()->__("Date of Birth"),
                        "value" => array(
                            "year" => date("Y", strtotime($muObj->distDB->getDob())),
                            "month" => date("m", strtotime($muObj->distDB->getDob())),
                            "day" => date("d", strtotime($muObj->distDB->getDob()))
                        )
                    ),
                    "address" => array(
                        "label" => $this->getContext()->getI18N()->__("Address"),
                        "value" => $muObj->distDB->getAddress()
                    ),
                    "address2" => array(
                        "label" => "",
                        "value" => $muObj->distDB->getAddress2()
                    ),
                    "city" => array(
                        "label" => $this->getContext()->getI18N()->__("City / Town"),
                        "value" => $muObj->distDB->getCity()
                    ),
                    "state" => array(
                        "label" => $this->getContext()->getI18N()->__("State / Province"),
                        "value" => $muObj->distDB->getState()
                    ),
                    "zip" => array(
                        "label" => $this->getContext()->getI18N()->__("Zip / Postal Code"),
                        "value" => $muObj->distDB->getPostcode()
                    ),
                    "email" => array(
                        "label" => $this->getContext()->getI18N()->__("Email"),
                        "value" => $muObj->distDB->getEmail()
                    ),
                    "alt_email" => array(
                        "label" => $this->getContext()->getI18N()->__("Alternate Email"),
                        "value" => $muObj->distDB->getAlternateEmail()
                    ),
                    "contactNumber" => array(
                        "label" => $this->getContext()->getI18N()->__("Contact Number"),
                        "value" => $muObj->distDB->getContact()
                    ),
                    "gender" => array(
                        "label" => $this->getContext()->getI18N()->__("Gender"),
                        "value" => $muObj->distDB->getGender()
                    ),
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            if ($this->getRequestParameter("doSave") == "y") {
                return $this->forward("member", "updateProfile");
            } else {
                $this->getRequest()->setParameter(MUserUtil::REQ_MACT, "memberProfile");
                return $this->forward("member", "viewProfile");
            }
        }
    }

    public function executeBeneficiary()
    {
        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            $jsonData = array(
                "data" => array(
                    "nomineeName" => array(
                        "label" => $this->getContext()->getI18N()->__("Name"),
                        "value" => strval($muObj->distDB->getNomineeName())
                    ),
                    "nomineeRelationship" => array(
                        "label" => $this->getContext()->getI18N()->__("Relationship"),
                        "value" => strval($muObj->distDB->getNomineeRelationship())
                    ),
                    "nomineeIc" => array(
                        "label" => $this->getContext()->getI18N()->__("IC./Passport No."),
                        "value" => strlen($muObj->distDB->getNomineeIc())
                    ),
                    "nomineeContactNo" => array(
                        "label" => $this->getContext()->getI18N()->__("Contact No."),
                        "value" => strval($muObj->distDB->getNomineeContactNo())
                    )
                )
            );

            echo MUserUtil::init($this)->getJson(1, null, $jsonData);
            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            if ($this->getRequestParameter("doSave") == "y") {
                return $this->forward("member", "updateBeneficiary");
            } else {
                $this->getRequest()->setParameter(MUserUtil::REQ_MACT, "beneficiary");
                return $this->forward("member", "viewProfile");
            }
        }
    }

    public function executeUpdateLoginPassword()
    {
        $jsonData = array(
            "data" => array(
                "change_login_password" => array(
                    "label" => $this->getContext()->getI18N()->__("Change Account login Password"),
                    "value" => array(
                        "oldPassword" => array(
                            "label" => $this->getContext()->getI18N()->__("Old Login Password")
                        ),
                        "newPassword" => array(
                            "label" => $this->getContext()->getI18N()->__("New Login Password")
                        ),
                        "newPassword2" => array(
                            "label" => $this->getContext()->getI18N()->__("Re-enter Login Password")
                        )
                    )
                )
            )
        );

        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            if ($muObj->result) {
                echo MUserUtil::init($this)->getJson(1, $this->getFlash("successMsg"), $jsonData);
            } else {
                $msg = $this->getFlash("errorMsg");
                echo MUserUtil::init($this)->updateLog($msg)->getJson(0, $msg, $jsonData);
            }

            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            if ($this->getRequestParameter("doSave") == "y") {
                $this->getRequest()->setParameter(MUserUtil::REQ_MACT, "updateLoginPassword");
                return $this->forward("member", "loginPassword");
            } else {
                echo MUserUtil::init($this)->getJson(0, null, $jsonData);
                return sfView::HEADER_ONLY;
            }
        }
    }

    public function executeUpdateTransactionPassword()
    {
        $jsonData = array(
            "data" => array(
                "change_transaction_password" => array(
                    "label" => $this->getContext()->getI18N()->__("Change Security Password"),
                    "value" => array(
                        "oldSecurityPassword" => array(
                            "label" => $this->getContext()->getI18N()->__("Old Security Password")
                        ),
                        "newSecurityPassword" => array(
                            "label" => $this->getContext()->getI18N()->__("New Security Password")
                        ),
                        "newSecurityPassword2" => array(
                            "label" => $this->getContext()->getI18N()->__("Re-enter Security Password")
                        )
                    )
                )
            )
        );

        if ($this->isResponded()) {
            $muObj = new MUserObj();
            $muObj->loadFromSession($this);

            if ($muObj->isEmpty()) {
                return $this->emptyDataException();
            }

            if ($muObj->result) {
                echo MUserUtil::init($this)->getJson(1, $this->getFlash("successMsg"), $jsonData);
            } else {
                $msg = $this->getFlash("errorMsg");
                echo MUserUtil::init($this)->updateLog($msg)->getJson(0, $msg, $jsonData);
            }

            return sfView::HEADER_ONLY;
        } else {
            if (!$this->isValidAccess()) {
                return sfView::HEADER_ONLY;
            }

            if ($this->getRequestParameter("doSave") == "y") {
                $this->getRequest()->setParameter(MUserUtil::REQ_MACT, "updateTransactionPassword");
                return $this->forward("member", "transactionPassword");
            } else {
                echo MUserUtil::init($this)->getJson(0, null, $jsonData);
                return sfView::HEADER_ONLY;
            }
        }
    }

    public function executeCheckPasswordExpiry()
    {
        $username = $this->action->getRequestParameter(MUserUtil::REQ_MUSER);
        $secret = $this->action->getRequestParameter(MUserUtil::REQ_MSECR);
        $muUtil = MUserUtil::init($this);
        $result = 0;

        if ($username && $secret) {
            // Has all required param.
            $c = new Criteria();
            $c->add(AppUserPeer::USERNAME, $username);
            $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
            $existUser = AppUserPeer::doSelectOne($c);

            if ($existUser) {
                // AppUser exists.
                if ($existUser->getPasswordExpireDate() != "") {
                    $passwordExpire = DateTime::createFromFormat("Y-m-d H:i:s", $existUser->getPasswordExpireDate());
                    $now = new DateTime();

                    if ($now >= $passwordExpire) {
                        // Password is expired.
                        $result = 1;
                    } else {
                        // Password is valid.
                        $result = 0;
                    }
                } else {
                    // Password expire date not set yet, force user to update password page.
                    $result = 1;
                }
            }
        }

        echo $muUtil->getJson($result, "");
        return sfView::HEADER_ONLY;
    }

    public function executeGetGenderList()
    {
        $lang = $this->getRequestParameter("mlang", "en");
        $this->getUser()->setCulture($lang);

        $genders = array(
            array(
                "label" => $this->getContext()->getI18N()->__("Male"),
                "value" => "M"
            ),
            array(
                "label" => $this->getContext()->getI18N()->__("Female"),
                "value" => "F"
            )
        );

        echo MUserUtil::init($this)->getJson(1, "", array("data" => $genders));
        return sfView::HEADER_ONLY;
    }

    public function executeGetCountryList()
    {
        $lang = $this->getRequestParameter("mlang", "en");
        $this->getUser()->setCulture($lang);

        // Copy from component/_countrySelectOption
        $countrycodes = array();
        array_push($countrycodes, 'Afghanistan@93@' . 'Afghanistan');
        array_push($countrycodes, 'Albania@355@' . 'Albania');
        array_push($countrycodes, 'Algeria@213@' . 'Algeria');
        array_push($countrycodes, 'American Samoa@684@' . 'American Samoa');
        array_push($countrycodes, 'Andorra@376@' . 'Andorra');
        array_push($countrycodes, 'Argentina@54@' . 'Argentina');
        array_push($countrycodes, 'Armenia@374@' . 'Armenia');
        array_push($countrycodes, 'Aruba@297@' . 'Aruba');
        array_push($countrycodes, 'Ascension Land@247@' . 'Ascension Land');
        array_push($countrycodes, 'Australia@61@' . 'Australia');
        array_push($countrycodes, 'Austria@43@' . 'Austria');
        array_push($countrycodes, 'Azerbaijan@994@' . 'Azerbaijan');
        array_push($countrycodes, 'Bahrain@973@' . 'Bahrain');
        array_push($countrycodes, 'Belgium@32@' . 'Belgium');
        array_push($countrycodes, 'Belize@501@' . 'Belize');
        array_push($countrycodes, 'Benin@229@' . 'Benin');
        array_push($countrycodes, 'Bhutan@975@' . 'Bhutan');
        array_push($countrycodes, 'Bolivia@591@' . 'Bolivia');
        array_push($countrycodes, 'Bosnia@387@' . 'Bosnia');
        array_push($countrycodes, 'Botswana@267@' . 'Botswana');
        array_push($countrycodes, 'Brazil@55@' . 'Brazil');
        array_push($countrycodes, 'Brunei@673@' . 'Brunei');
        array_push($countrycodes, 'Bulgaria@359@' . 'Bulgaria');
        array_push($countrycodes, 'Burkina Faso@226@' . 'Burkina Faso');
        array_push($countrycodes, 'Burundi@257@' . 'Burundi');
        array_push($countrycodes, 'Cambodia@855@' . 'Cambodia');
        array_push($countrycodes, 'Cameron@237@' . 'Cameron');
        array_push($countrycodes, 'Canada@1@' . 'Canada');
        array_push($countrycodes, 'Chad@235@' . 'Chad');
        array_push($countrycodes, 'Chile@56@' . 'Chile');
        array_push($countrycodes, 'China (PRC)@86@' . 'China (PRC)');
        array_push($countrycodes, 'Colombia@57@' . 'Colombia');
        array_push($countrycodes, 'Costa Rica@506@' . 'Costa Rica');
        array_push($countrycodes, 'Croatia@385@' . 'Croatia');
        array_push($countrycodes, 'Cuba@53@' . 'Cuba');
        array_push($countrycodes, 'Cyprus@357@' . 'Cyprus');
        array_push($countrycodes, 'Czech Republic@420@' . 'Czech Republic');
        array_push($countrycodes, 'Denmark@45@' . 'Denmark');
        array_push($countrycodes, 'Deigo Garicia@246@' . 'Deigo Garicia');
        array_push($countrycodes, 'Djibouti@253@' . 'Djibouti');
        array_push($countrycodes, 'Ecuador@593@' . 'Ecuador');
        array_push($countrycodes, 'Egypt@20@' . 'Egypt');
        array_push($countrycodes, 'El Salvador@503@' . 'El Salvador');
        array_push($countrycodes, 'Equatorial Guinea@24@' . 'Equatorial Guinea');
        array_push($countrycodes, 'Eritrea@291@' . 'Eritrea');
        array_push($countrycodes, 'Estonia@372@' . 'Estonia');
        array_push($countrycodes, 'Ethiopia@251@' . 'Ethiopia');
        array_push($countrycodes, 'Faeroe Islands@298@' . 'Faeroe Islands');
        array_push($countrycodes, 'Falkland Islands@500@' . 'Falkland Islands');
        array_push($countrycodes, 'Fiji Islands@679@' . 'Fiji Islands');
        array_push($countrycodes, 'Finland@358@' . 'Finland');
        array_push($countrycodes, 'France@33@' . 'France');
        array_push($countrycodes, 'French Antilles@596@' . 'French Antilles');
        array_push($countrycodes, 'French Guiana@594@' . 'French Guiana');
        array_push($countrycodes, 'French Polynesia@689@' . 'French Polynesia');
        array_push($countrycodes, 'Gabon@241@' . 'Gabon');
        array_push($countrycodes, 'Gambia@220@' . 'Gambia');
        array_push($countrycodes, 'Georgia@995@' . 'Georgia');
        array_push($countrycodes, 'Germany@49@' . 'Germany');
        array_push($countrycodes, 'Ghana@233@' . 'Ghana');
        array_push($countrycodes, 'Gibraltar@350@' . 'Gibraltar');
        array_push($countrycodes, 'Greece@30@' . 'Greece');
        array_push($countrycodes, 'Greenland@299@' . 'Greenland');
        array_push($countrycodes, 'Guinea-Bissau@245@' . 'Guinea-Bissau');
        array_push($countrycodes, 'Guinea (PRP)@224@' . 'Guinea (PRP)');
        array_push($countrycodes, 'Hong Kong@852@' . 'Hong Kong');
        array_push($countrycodes, 'Hungary@36@' . 'Hungary');
        array_push($countrycodes, 'Iceland@353@' . 'Iceland');
        array_push($countrycodes, 'India@611@' . 'India');
        array_push($countrycodes, 'Indonesia@62@' . 'Indonesia');
        array_push($countrycodes, 'Islands@682@' . 'Islands');
        array_push($countrycodes, 'Israel@972@' . 'Israel');
        array_push($countrycodes, 'Italy@39@' . 'Italy');
        array_push($countrycodes, 'Jamaica@1876@' . 'Jamaica');
        array_push($countrycodes, 'Japan@81@' . 'Japan');
        array_push($countrycodes, 'Jordan@962@' . 'Jordan');
        array_push($countrycodes, 'Kazakhsthan@7@' . 'Kazakhsthan');
        array_push($countrycodes, 'Kenya@254@' . 'Kenya');
        array_push($countrycodes, 'Kiribati@686@' . 'Kiribati');
        array_push($countrycodes, 'Korea North@850@' . 'Korea North');
        array_push($countrycodes, 'Korea South@82@' . 'Korea South');
        array_push($countrycodes, 'Kuwait@965@' . 'Kuwait');
        array_push($countrycodes, 'Laos@856@' . 'Laos');
        array_push($countrycodes, 'Latvia@371@' . 'Latvia');
        array_push($countrycodes, 'Lebanon@961@' . 'Lebanon');
        array_push($countrycodes, 'Lesotho@266@' . 'Lesotho');
        array_push($countrycodes, 'Liberia@231@' . 'Liberia');
        array_push($countrycodes, 'Libya@218@' . 'Libya');
        array_push($countrycodes, 'Liechtenstein@423@' . 'Liechtenstein');
        array_push($countrycodes, 'Lithuania@370@' . 'Lithuania');
        array_push($countrycodes, 'Luxembourg@352@' . 'Luxembourg');
        array_push($countrycodes, 'Macau@853@' . 'Macau');
        array_push($countrycodes, 'Macedonia@389@' . 'Macedonia');
        array_push($countrycodes, 'Madagascar@261@' . 'Madagascar');
        array_push($countrycodes, 'Malawi@265@' . 'Malawi');
        array_push($countrycodes, 'Malaysia@60@' . 'Malaysia');
        array_push($countrycodes, 'Maldives@960@' . 'Maldives');
        array_push($countrycodes, 'Mali Republic@223@' . 'Mali Republic');
        array_push($countrycodes, 'Malta@356@' . 'Malta');
        array_push($countrycodes, 'Martinique@596@' . 'Martinique');
        array_push($countrycodes, 'Maurutania@222@' . 'Maurutania');
        array_push($countrycodes, 'Mauritius@230@' . 'Mauritius');
        array_push($countrycodes, 'Mexico@52@' . 'Mexico');
        array_push($countrycodes, 'Mongolia@976@' . 'Mongolia');
        array_push($countrycodes, 'Morocco@212@' . 'Morocco');
        array_push($countrycodes, 'Mozambique@258@' . 'Mozambique');
        array_push($countrycodes, 'Myanmar@95@' . 'Myanmar');
        array_push($countrycodes, 'Namibia@264@' . 'Namibia');
        array_push($countrycodes, 'Nauru@674@' . 'Nauru');
        array_push($countrycodes, 'Nepal@977@' . 'Nepal');
        array_push($countrycodes, 'Netherlands@31@' . 'Netherlands');
        array_push($countrycodes, 'New Zealand@64@' . 'New Zealand');
        array_push($countrycodes, 'Nicaragua@505@' . 'Nicaragua');
        array_push($countrycodes, 'Niger@227@' . 'Niger');
        array_push($countrycodes, 'Nigeria@234@' . 'Nigeria');
        array_push($countrycodes, 'Niue@683@' . 'Niue');
        array_push($countrycodes, 'Norfolk Island@672@' . 'Norfolk Island');
        array_push($countrycodes, 'Norway@47@' . 'Norway');
        array_push($countrycodes, 'Oman@968@' . 'Oman');
        array_push($countrycodes, 'Pakistan@92@' . 'Pakistan');
        array_push($countrycodes, 'Palau@680@' . 'Palau');
        array_push($countrycodes, 'Palestine@970@' . 'Palestine');
        array_push($countrycodes, 'Panama@507@' . 'Panama');
        array_push($countrycodes, 'Paraguay@595@' . 'Paraguay');
        array_push($countrycodes, 'Peru@51@' . 'Peru');
        array_push($countrycodes, 'Philippines@63@' . 'Philippines');
        array_push($countrycodes, 'Poland@48@' . 'Poland');
        array_push($countrycodes, 'Portugal@351@' . 'Portugal');
        array_push($countrycodes, 'Qatar@974@' . 'Qatar');
        array_push($countrycodes, 'Reunion Island@262@' . 'Reunion Island');
        array_push($countrycodes, 'Romania@40@' . 'Romania');
        array_push($countrycodes, 'Russia@7@' . 'Russia');
        array_push($countrycodes, 'Rwanda@250@' . 'Rwanda');
        array_push($countrycodes, 'San Marino@378@' . 'San Marino');
        array_push($countrycodes, 'Saudi Arabia@9666@' . 'Saudi Arabia');
        array_push($countrycodes, 'Senegal@221@' . 'Senegal');
        array_push($countrycodes, 'Serbia@381@' . 'Serbia');
        array_push($countrycodes, 'Seychelles Islands@248@' . 'Seychelles Islands');
        array_push($countrycodes, 'Sierra Leone@232@' . 'Sierra Leone');
        array_push($countrycodes, 'Singapore@65@' . 'Singapore');
        array_push($countrycodes, 'Slovak Republic@421@' . 'Slovak Republic');
        array_push($countrycodes, 'Slovenia@386@' . 'Slovenia');
        array_push($countrycodes, 'Solomon Islands@677@' . 'Solomon Islands');
        array_push($countrycodes, 'South Africa@27@' . 'South Africa');
        array_push($countrycodes, 'Spain@34@' . 'Spain');
        array_push($countrycodes, 'Sri Lanka@94@' . 'Sri Lanka');
        array_push($countrycodes, 'Sudan@249@' . 'Sudan');
        array_push($countrycodes, 'Suriname@597@' . 'Suriname');
        array_push($countrycodes, 'Swaziland@268@' . 'Swaziland');
        array_push($countrycodes, 'Sweden@46@' . 'Sweden');
        array_push($countrycodes, 'Switzerland@41@' . 'Switzerland');
        array_push($countrycodes, 'Syria@963@' . 'Syria');
        array_push($countrycodes, 'Taiwan@886@' . 'Taiwan');
        array_push($countrycodes, 'Tajikistan@992@' . 'Tajikistan');
        array_push($countrycodes, 'Tanzania@255@' . 'Tanzania');
        array_push($countrycodes, 'Thailand@66@' . 'Thailand');
        array_push($countrycodes, 'Toto@228@' . 'Toto');
        array_push($countrycodes, 'Tonga Islands@676@' . 'Tonga Islands');
        array_push($countrycodes, 'Tunisia@216@' . 'Tunisia');
        array_push($countrycodes, 'Turkey@90@' . 'Turkey');
        array_push($countrycodes, 'Turkmenistan@993@' . 'Turkmenistan');
        array_push($countrycodes, 'Tuvalu@688@' . 'Tuvalu');
        array_push($countrycodes, 'Uganda@256@' . 'Uganda');
        array_push($countrycodes, 'Ukraine@380@' . 'Ukraine');
        array_push($countrycodes, 'UAE@971@' . 'UAE');
        array_push($countrycodes, 'United Kingdom@44@' . 'United Kingdom');
        array_push($countrycodes, 'USA@1@' . 'USA');
        array_push($countrycodes, 'Uruguay@598@' . 'Uruguay');
        array_push($countrycodes, 'Uzbekistan@998@' . 'Uzbekistan');
        array_push($countrycodes, 'Vanuatu@678@' . 'Vanuatu');
        array_push($countrycodes, 'Vatican City@39@' . 'Vatican City');
        array_push($countrycodes, 'Venezuela@58@' . 'Venezuela');
        array_push($countrycodes, 'Vietnam@84@' . 'Vietnam');
        array_push($countrycodes, 'Western Samoa@685@' . 'Western Samoa');
        array_push($countrycodes, 'Yemen@967@' . 'Yemen');
        array_push($countrycodes, 'Yugoslavia@381@' . 'Yugoslavia');
        array_push($countrycodes, 'Zambia@260@' . 'Zambia');
        array_push($countrycodes, 'Zanzibar@255@' . 'Zanzibar');
        array_push($countrycodes, 'Zimbabwe@263@' . 'Zimbabwe');

        // Convert to JSON format array.
        $countries = array();

        foreach ($countrycodes as $countrycode) {
            $position = explode('@', $countrycode);

            array_push($countries, array(
                "label" => $this->getContext()->getI18N()->__($position[2], null, "country"),
                "value" => $position[0]
            ));
        }

        echo MUserUtil::init($this)->getJson(1, "", array("data" => $countries));
        return sfView::HEADER_ONLY;
    }

    public function executeGetDobDateList()
    {
        $lang = $this->getRequestParameter("mlang", "en");
        $this->getUser()->setCulture($lang);

        $dob = array(
            "year" => array(),
            "month" => array(),
            "day" => array()
        );

        $startYear = date("Y") - 5;

        // Year.
        for ($i = $startYear; $i >= ($startYear - 110); $i--) {
            array_push($dob["year"], $i);
        }

        // Month and day.
        for ($i = 1; $i <= 31; $i++) {
            if ($i <= 12) {
                array_push($dob["month"], $i);
            }

            array_push($dob["day"], $i);
        }

        echo MUserUtil::init($this)->getJson(1, "", array("data" => $dob));
        return sfView::HEADER_ONLY;
    }

    private function isSignatureValid()
    {
        // TODO
        return false;
    }

    private function isValidAccess($logAccess = true)
    {
        if ($this->getRequest()->getMethod() !== sfRequest::POST) {
//            return false; TODO
        }

        $muUtil = MUserUtil::init($this);
        $result = $muUtil->verifyMobileUser($errMsg);

        if ($logAccess) {
            // Log mobile access to database.
            $log = new AppMobileLog();
            $log->setAccessIp($this->getRequest()->getHttpHeader("addr", "remote"));
            $log->setUserId($this->getUser()->getAttribute(Globals::SESSION_USERID));
            $log->setTransAction($this->getActionName());
            $log->setTransData(var_export($this->getRequest()->getParameterHolder(), true));
            $log->setRemark(strlen($errMsg) ? $errMsg : null);
            $log->setCreatedBy(Globals::SYSTEM_USER_ID);
            $log->setUpdatedBy(Globals::SYSTEM_USER_ID);
            $log->save();

            $this->getUser()->setAttribute(MUserUtil::REQ_MLOG_ID, $log->getLogId());
        }

        if (strlen($errMsg)) {
            // Error occur while validating mobile user.
            echo $muUtil->getJson(0, $errMsg);
        }

        return $result;
    }

    private function emptyDataException()
    {
        echo MUserUtil::init($this)->getJson(0, $this->getContext()->getI18N()->__("Invalid action: no data received from server."));
        return sfView::HEADER_ONLY;
    }

    private function isResponded()
    {
        return ($this->getUser()->getAttribute(MUserObj::SESSION_MUSEROBJ) !== null);
    }
}
