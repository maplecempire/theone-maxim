<?php

/**
 * maturityAccount actions.
 *
 * @package    sf_sandbox
 * @subpackage maturityAccount
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class maturityAccountActions extends sfActions
{
    /**
     * Executes index action
     *
     */
    public function executeSendEmail()
    {
        $c = new Criteria();
        $c->add(NotificationOfMaturityPeer::EMAIL_STATUS, "ACTIVE");
//        $c->add(NotificationOfMaturityPeer::EMAIL_STATUS, "COMPLETE");
//        $c->add(NotificationOfMaturityPeer::MATURITY_TYPE, "JULY");
        $notificationOfMaturityDBs = NotificationOfMaturityPeer::doSelect($c);
        $totalCount = count($notificationOfMaturityDBs);
        foreach ($notificationOfMaturityDBs as $notificationOfMaturityDB) {
            print_r("<br>".$totalCount--."::".$notificationOfMaturityDB->getEmail());
            $month = $notificationOfMaturityDB->getMaturityType();
            $attachment = sfConfig::get('sf_upload_dir')."/Maturity-".$month.".pdf";
            $attachment_name = "Maxim-18 month Option Notice - ".$month." '14 MATURITY.pdf";
            $subject = "NOTIFICATION OF MATURITY – 18th MONTH OPTION NOTICE";

            $dateUtil = new DateUtil();
            $maturityDate = $dateUtil->formatDate("d M Y", $notificationOfMaturityDB->getDividendDate());
            $todayDate = date("d M Y");
            $body = $todayDate;
            $body = "
            <br>Dear International Member,
            <br>
            <br><strong>NOTIFICATION OF MATURITY – 18th MONTH OPTION NOTICE</strong>
            <br>
            <br>Firstly, we congratulate and thank you for walking the success trail with us in this past 18 months.
            <br>
            <br>Secondly, this is your reminder, that your Contract with Maxim Trader will achieve its full maturity status of 18 months on ".$maturityDate.".
            <br>
            <br><strong>In the event that you elect only to renew the contract, you need not take any action. We will automatically renew the contract for another 18 months.</strong>
            <br>
            <br>However, if you wish to end your contract, please note that you will then end your contract and thereafter withdraw your <strong>FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date)</strong>. You will also receive all your CP2 and CP3 balances paid to you and thereafter NOT be entitled to any further monies from the our Referral program as your UserID will be deleted from our system. Within 14 days after maturity date, we will credit your final balance into your CP3.
            <br>
            <br>
            <br><strong>PLEASE NOTE:</strong>
            <br>
            <br>If you wish to end your contract, please complete the information below, sign, scan-in and email to revi@maximtrader.com BEFORE the maturity of your contract.
            <br>
            <br>
            <br><br><a href='http://partner.maximtrader.com/uploads/Maturity-".$month.".pdf' target='_blank'>Download Notification of Maturity</a>
            <br>
            <br>
            <br>================================================================================================
            <br>
            <br>
            <br>亲爱的马胜会员，
            <br>
            <br><strong>投资合同18个月到期-后续选择通知</strong>
            <br>
            <br>首先，我们恭喜并谢谢您成功与我们携手走过这过去的18个月。
            <br>
            <br>其次，这是系统发布的通知邮件-您与马胜金融集团签订的18个月投资合同即将于".$maturityDate."到期。
            <br>
            <br><strong>如果您选择继续更新您的投资合同，您无需采取任何操作。</strong>
            <br>我们会自动为您续期18个月。
            <br>
            <br>但是，如果您选择终止您的投资合同并取现；- 您选择终止投资合同，并会取出您MT4账号中最后的余额（合同到期届时，投资本金等同于MT4交易账户中的最后余额）。您也会收到所有的CP2与CP3款项，且之后个人账户会从系统中注销，因此您将不再享受马胜市场推荐制度所带来的任何获利。合同到期日14日之内，我们会将您的余额转入您的CP3账户。
            <br>
            <br><strong>请注意：</strong>
            <br>
            <br>完整填写以上表格、签名并扫描文件，于您本人合同到期日之前邮件至revi@maximtrader.com。
            <br><br><a href='http://partner.maximtrader.com/uploads/Maturity-".$month.".pdf' target='_blank'>下载投资合同</a>";

            $sendMailService = new SendMailService();
            $att = $attachment;
            $attName = $attachment_name;

            $email = $notificationOfMaturityDB->getEmail();
//            $email = "r9jason@gmail.com";
            $fullName = $notificationOfMaturityDB->getMt4UserName();
//            $msg = $sendMailService->sendMaturityAccount($email, $fullName, $subject, $body, $att, $attName);
            $msg = $sendMailService->sendMaturityAccount($email, $fullName, $subject, $body, "", "");

//            break;
            $notificationOfMaturityDB->setEmailStatus("SENT");
            $notificationOfMaturityDB->setInternalRemark($msg);
            if ($msg != "") {
                $notificationOfMaturityDB->setEmailStatus("ERROR");
            }
            $notificationOfMaturityDB->save();
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeSendEmail_May()
    {
        $attachment_MAY_IA = "";
        $attachment_name_MAY_IA = "";
        $subject_MAY_IA = "NOTIFICATION OF MATURITY – 18th MONTH OPTION NOTICE";
        $body_MAY_IA = "16 May 2014
        <br>
        <br>Dear International Member,
        <br>
        <br><strong>NOTIFICATION OF MATURITY – 18th MONTH OPTION NOTICE</strong>
        <br>
        <br>Firstly, we congratulate and thank you for walking the success trail with us in this past 18 months.
        <br>
        <br>Secondly, we wish to notify you, that your Contract with Maxim Trader will achieve its full maturity status of 18 months in May 2014.
        <br>
        <br>Since your MT4 account is that of an “incentive account”, you will not be entitled to earn any Performance Returns subsequent to the maturity date. However you will still be entitled to earn bonuses in your CP2.
        <br>
        <br>For any questions on this, please email to revi@maximtrader.com
        <br>
        <br>Thank you,
        <br>CEO
        <br>
        <br>
        <br>2014.5.16日
        <br>
        <br>亲爱的马胜会员，
        <br>
        <br><strong>投资合同18个月到期-后续选择通知</strong>
        <br>
        <br>首先，我们恭喜并谢谢您成功与我们携手走过这过去的18个月。
        <br>
        <br>其次，这是系统发布的通知邮件-您与马胜金融集团签订的18个月投资合同即将于2014.5月到期。
        <br>
        <br>鉴于您的MT4账户为“优惠账户”，因此在合同到期之后，您将不再享受任何每月固定分红  ，但是您仍然可以享受CP2账户中的利润。
        <br>
        <br>如果您有任何问题，欢迎邮件至revi@maximtrader.com  谢谢！
        <br>
        <br>首席执行官CEO";

        $attachment_MAY = sfConfig::get('sf_upload_dir')."/Maturity-May.pdf";
        $attachment_name_MAY = "Maxim-18 month Option Notice - MAY '14 MATURITY.pdf";
        $subject_MAY = "NOTIFICATION OF MATURITY – 18th MONTH OPTION NOTICE";
        $body_MAY = "16 May 2014
        <br>
        <br>Dear International Member,
        <br>
        <br><strong>NOTIFICATION OF MATURITY – 18th MONTH OPTION NOTICE</strong>
        <br>
        <br>Firstly, we congratulate and thank you for walking the success trail with us in this past 18 months.
        <br>
        <br>Secondly, this is your reminder, that your Contract with Maxim Trader will achieve its full maturity status of 18 months in May 2014.
        <br>
        <br><strong>In the event that you elect only to renew the contract, you need not take any action. We will automatically renew the contract for another 18 months.</strong>
        <br>
        <br>However, if you wish to end your contract, please note that you will then end your contract and thereafter withdraw your <strong>FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date)</strong>. You will also receive all your CP2 and CP3 balances paid to you and thereafter NOT be entitled to any further monies from the our Referral program as your UserID will be deleted from our system. Within 14 days after maturity date, we will credit your final balance into your CP3.
        <br>
        <br>
        <br><strong>PLEASE NOTE:</strong>
        <br>
        <br>If you wish to end your contract, please complete the information below, sign, scan-in and email to revi@maximtrader.com BEFORE the maturity of your contract.
        <br>
        <br>
        <br>2014.5.16日
        <br>
        <br>亲爱的马胜会员，
        <br>
        <br><strong>投资合同18个月到期-后续选择通知</strong>
        <br>
        <br>首先，我们恭喜并谢谢您成功与我们携手走过这过去的18个月。
        <br>
        <br>其次，这是系统发布的通知邮件-您与马胜金融集团签订的18个月投资合同即将于2014.5月到期。
        <br>
        <br><strong>如果您选择继续更新您的投资合同，您无需采取任何操作。</strong>
        <br>我们会自动为您续期18个月。
        <br>
        <br>但是，如果您选择终止您的投资合同并取现；- 您选择终止投资合同，并会取出您MT4账号中最后的余额（合同到期届时，投资本金等同于MT4交易账户中的最后余额）。您也会收到所有的CP2与CP3款项，且之后个人账户会从系统中注销，因此您将不再享受马胜市场推荐制度所带来的任何获利。合同到期日14日之内，我们会将您的余额转入您的CP3账户。
        <br>
        <br><strong>请注意：</strong>
        <br>
        <br>完整填写以上表格、签名并扫描文件，于您本人合同到期日之前邮件至revi@maximtrader.com 。";

        $c = new Criteria();
        $c->add(NotificationOfMaturityPeer::EMAIL_STATUS, "ACTIVE");
        //$c->add(NotificationOfMaturityPeer::MATURITY_TYPE, "MAY-IA");
        $notificationOfMaturityDBs = NotificationOfMaturityPeer::doSelect($c);

        foreach ($notificationOfMaturityDBs as $notificationOfMaturityDB) {
            $sendMailService = new SendMailService();
            $subject = "";
            $body = "";
            $att = "";
            $attName = "";

            if ($notificationOfMaturityDB->getMaturityType() == "MAY") {
                $subject = $subject_MAY;
                $body = $body_MAY;
                $att = $attachment_MAY;
                $attName = $attachment_name_MAY;
            } else if ($notificationOfMaturityDB->getMaturityType() == "MAY-IA") {
                $subject = $subject_MAY_IA;
                $body = $body_MAY_IA;
                $att = $attachment_MAY_IA;
                $attName = $attachment_name_MAY_IA;
            }

            $email = $notificationOfMaturityDB->getEmail();
            //$email = "r9jason@gmail.com";
            $fullName = $notificationOfMaturityDB->getMt4UserName();
            $msg = $sendMailService->sendMaturityAccount($email, $fullName, $subject, $body, $att, $attName);

            $notificationOfMaturityDB->setEmailStatus("SENT");
            $notificationOfMaturityDB->setInternalRemark($msg);
            if ($msg != "") {
                $notificationOfMaturityDB->setEmailStatus("ERROR");
            }
            $notificationOfMaturityDB->save();

            //break;
        }
        return sfView::HEADER_ONLY;
    }

    public function executeSave()
    {
//      $longString = "1514,2651,2146";
//      $maturityType = "MAY-IA";
        $longString = $this->getRequestParameter('longString');
        $maturityType = $this->getRequestParameter('maturityType');
        $arr = explode(",", $longString);

        if ($longString == "") {
            print_r("Invalid Long String");
            return sfView::HEADER_ONLY;
        }
        if ($maturityType == "") {
            print_r("Invalid Maturity Type");
            return sfView::HEADER_ONLY;
        }

        $leaderArrs = explode(",", Globals::GROUP_LEADER);
        var_dump($arr);
        foreach ($arr as $dividendId) {
            $mlmRoiDividendDB = MlmRoiDividendPeer::retrieveByPK($dividendId);

            if ($mlmRoiDividendDB && $mlmRoiDividendDB->getIdx() == 18) {
                $mlmDistributorDB = MlmDistributorPeer::retrieveByPK($mlmRoiDividendDB->getDistId());

                if (!$mlmDistributorDB) {
                    print_r("+++ continue " . $mlmRoiDividendDB->getDistId());
                    continue;
                }

                $leader = "";
                $distDB = MlmDistributorPeer::retrieveByPK($mlmRoiDividendDB->getDistId());
                for ($i = 0; $i < count($leaderArrs); $i++) {
                    $pos = strrpos($distDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $dist = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                        if ($dist) {
                            $leader = $dist->getDistributorId();
                        }
                        break;
                    }
                }
                $notificationOfMaturity = new NotificationOfMaturity();
                $notificationOfMaturity->setDistId($mlmRoiDividendDB->getDistId());
                $notificationOfMaturity->setMt4UserName($mlmRoiDividendDB->getMt4UserName());
                $notificationOfMaturity->setDividendDate($mlmRoiDividendDB->getDividendDate());
                $notificationOfMaturity->setMaturityType($maturityType);
                $notificationOfMaturity->setEmail($mlmDistributorDB->getEmail());
                $notificationOfMaturity->setRetry(0);
                $notificationOfMaturity->setRemark("");
                $notificationOfMaturity->setInternalRemark("");
                $notificationOfMaturity->setPackagePrice($mlmRoiDividendDB->getPackagePrice());
                $notificationOfMaturity->setLeaderDistId($leader);
                $notificationOfMaturity->setEmailStatus(Globals::STATUS_ACTIVE);
                $notificationOfMaturity->setStatusCode(Globals::STATUS_PENDING);
                $notificationOfMaturity->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $notificationOfMaturity->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $notificationOfMaturity->save();
            } else {
                var_dump($mlmRoiDividendDB);
            }
        }
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDoMaturityAction()
    {
        $noticeId= $this->getRequestParameter('maturityNotificationId');
        $maturityAction = $this->getRequestParameter('maturityAction');

        if ($noticeId == "") {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action.") + " [error:901]");
            return $this->redirect('member/summary');
        }
        if ($maturityAction == "") {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action.") + " [error:902]");
            return $this->redirect('member/summary');
        }
        $array = explode(',', Globals::STATUS_MATURITY_ON_HOLD.",".Globals::STATUS_MATURITY_PENDING);

        $c = new Criteria();
        $c->add(NotificationOfMaturityPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->add(NotificationOfMaturityPeer::STATUS_CODE, $array, Criteria::IN);
        $existNotificationOfMaturity = NotificationOfMaturityPeer::doSelectOne($c);
        if (!$existNotificationOfMaturity) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action.") + " [error:903]");
            return $this->redirect('member/summary');
        }
        if ($existNotificationOfMaturity) {

            if ($maturityAction == "RENEW") {
                $maturityArr = $this->getMt4Balance($this->getUser()->getAttribute(Globals::SESSION_DISTID), $existNotificationOfMaturity->getMt4UserName());

                if ($maturityArr != null) {
                    $mt4Balance = $maturityArr['mt4_credit'];
                    $mt4BalanceDate = $maturityArr['traded_datetime'];

                    $c = new Criteria();
                    $c->add(MlmRoiDividendPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
                    $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $existNotificationOfMaturity->getMt4UserName());
                    $c->add(MlmRoiDividendPeer::IDX, 18);
                    $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

                    if ($mt4Balance < $mlmRoiDividendDB->getPackagePrice()) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Your balance in the MT4 has fallen below your initial capital investment amount, Please top-up if you want to continue to renew your contract."));
                        return $this->redirect('member/summary');
                    }
                }

                $existNotificationOfMaturity->setStatusCode(Globals::STATUS_MATURITY_CLIENT_RENEW);
                $existNotificationOfMaturity->setClientAction(Globals::STATUS_MATURITY_CLIENT_RENEW);
            } else if ($maturityAction == "WITHDRAW") {
                $existNotificationOfMaturity->setStatusCode(Globals::STATUS_MATURITY_CLIENT_WITHDRAW);
                $existNotificationOfMaturity->setClientAction(Globals::STATUS_MATURITY_CLIENT_WITHDRAW);
            } else {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action.") + " [error:904]");
                return $this->redirect('member/summary');
            }
        } else {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action.") + " [error:905]");
            return $this->redirect('member/summary');
        }

        $existNotificationOfMaturity->setClientResponseDatatime(date("Y/m/d h:i:s A"));
        $existNotificationOfMaturity->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $existNotificationOfMaturity->save();
        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your request has been submitted for review by our admin. Thank you."));
        return $this->redirect('member/summary');
    }

    function getMt4Balance($distributorId, $mt4Username)
    {
        $arr = array();

        $mt4request = new CMT4DataReciver;
        $mt4request->OpenConnection(Globals::MT4_SERVER, Globals::MT4_SERVER_PORT);

        $params = array();
        $params['login'] = $mt4Username;

        $answer = $mt4request->MakeRequest("getaccountbalance", $params);

        $packagePrice = $answer['balance'];
        if ($packagePrice == null && is_numeric($packagePrice) == false) {
            //var_dump($answer);
            //var_dump($mt4UserName);
            //var_dump($packagePrice);
            //var_dump("<br>");
            //var_dump(is_numeric($packagePrice));
        } else {
            $arr = array();
            $arr['mt4_credit'] = $answer['balance'];
            $arr['traded_datetime'] = date("Y-m-d h:i:s");
            return $arr;
        }

        $mt4request->CloseConnection();
        /*$query = "SELECT credit_id, dist_id, mt4_user_name, mt4_credit, traded_datetime, created_by, created_on, updated_by, updated_on
          	FROM mlm_daily_dist_mt4_credit WHERE dist_id = ".$distributorId. " AND mt4_user_name = '".$mt4Username ."' ORDER BY traded_datetime DESC LIMIT 1";
        //var_dump($query);
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $arr = $resultset->getRow();
            return $arr;
        }
        */
        return null;
    }
}
