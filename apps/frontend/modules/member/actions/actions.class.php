<?php
/**
 * member actions.
 *
 * @package    sf_sandbox
 * @subpackage member
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class memberActions extends sfActions
{
    public function executeTest() {
        //echo $this->getRollingPointData();

        $query = "SELECT mt4_user_name, dist_id FROM mlm_roi_dividend group by mt4_user_name";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        while ($resultset->next()) {
            $arr = $resultset->getRow();
            $mt4UserName = $arr["mt4_user_name"];
            print_r("mt4UserName " . $mt4UserName . "<br>");

            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4UserName);
            $totalRecords = MlmRoiDividendPeer::doCount($c);

            if ($totalRecords < Globals::DIVIDEND_TIMES_ENTITLEMENT) {
                $c = new Criteria();
                $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4UserName);
                $c->addDescendingOrderByColumn(MlmRoiDividendPeer::IDX);
                $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

                if ($mlmRoiDividendDB) {
                    $idx = $mlmRoiDividendDB->getIdx() + 1;
                    for ($i = $idx; $i <= Globals::DIVIDEND_TIMES_ENTITLEMENT; $i++) {
                        $firstDividendTime = strtotime($mlmRoiDividendDB->getFirstDividendDate());

                        $monthAdded = $idx - 1;
                        $dividendDate = strtotime("+".$monthAdded." months", $firstDividendTime);

                        $mlm_roi_dividend = new MlmRoiDividend();
                        $mlm_roi_dividend->setDistId($mlmRoiDividendDB->getDistId());
                        $mlm_roi_dividend->setMt4UserName($mlmRoiDividendDB->getMt4UserName());
                        $mlm_roi_dividend->setIdx($idx);
                        //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                        $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                        $mlm_roi_dividend->setFirstDividendDate($mlmRoiDividendDB->getFirstDividendDate());
                        $mlm_roi_dividend->setPackageId($mlmRoiDividendDB->getPackageId());
                        $mlm_roi_dividend->setPackagePrice($mlmRoiDividendDB->getPackagePrice());
                        $mlm_roi_dividend->setRoiPercentage($mlmRoiDividendDB->getRoiPercentage());
                        //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                        //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                        $mlm_roi_dividend->setStatusCode($mlmRoiDividendDB->getStatusCode());
                        $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->save();

                        $idx = $idx + 1;
                    }
                }
            }
        }


        /*$q = 2;
        $queryRecord = 10;
        $c = new Criteria();
        $c->setOffset($q * $queryRecord);
        $c->setLimit($queryRecord);
        $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_ID);
        $dists = MlmDistributorPeer::doSelect($c);
        print_r("total Dist:".count($dists)."<br><br>");
        foreach ($dists as $dist) {
            print_r("Dist:".$dist->getDistributorId()."<br><br>");
        }
        $bonusService = new BonusService();*/
//        $bonusService->contraDebitAccountByEpoint(262636, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(263918, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(295, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(263051, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(262855, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(262108, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(262223, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(262182, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(262047, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(262046, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(261626, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(261627, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(261357, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(267514, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccountByEpoint(259508, "CONTRA BY CP1", 0);
//        $bonusService->contraDebitAccount(256463, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(1995, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256462, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256461, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256460, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256459, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256458, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256457, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256456, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256455, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256454, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256453, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256452, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256451, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256450, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256449, "CONTRA BY CP2", 0);
//        $bonusService->contraDebitAccount(256448, "CONTRA BY CP2", 0);
        /*$dateUtil = new DateUtil();

        $c = new Criteria();
        $c->add(MlmRoiDividendPeer::STATUS_CODE, Globals::STATUS_SUCCESS);
        $mlmRoiDividends = MlmRoiDividendPeer::doSelect($c);

        foreach ($mlmRoiDividends as $mlmRoiDividend) {
            $distId = $mlmRoiDividend->getDistId();
            $mt4UserName = $mlmRoiDividend->getMt4UserName();
            $packagePrice = $mlmRoiDividend->getPackagePrice();
            $dividendDate = $mlmRoiDividend->getDividendDate();
            //print_r("DistId " . $distId . "<br>");

            $dividendDateStr = $dateUtil->formatDate("Y-m-j", $dividendDate);
            $dividendDateFrom = $dividendDateStr . " 00:00:00";
            $dividendDateTo = $dividendDateStr . " 23:59:59";

            $dividendDateFromTS = strtotime($dividendDateFrom);
            $dividendDateToTS = strtotime($dividendDateTo);

            $query = "SELECT mt4_credit, credit_id FROM mlm_daily_dist_mt4_credit WHERE 1=1 "
                 . " AND dist_id = '" . $distId . "' AND mt4_user_name = '" . $mt4UserName . "'"
                 . " AND traded_datetime >= '" . date("Y-m-d H:i:s", $dividendDateFromTS) . "' AND traded_datetime <= '" . date("Y-m-d H:i:s", $dividendDateToTS) . "'";

            //var_dump($query);
            //exit();
            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $resultset = $statement->executeQuery();

            if ($resultset->next()) {
                $arr = $resultset->getRow();
                if ($packagePrice > $arr["mt4_credit"]) {
                    $packagePrice = $arr["mt4_credit"];
                }

                $mlmRoiDividend->setMt4Balance($packagePrice);
                $mlmRoiDividend->save();
            } else {
                print_r($mlmRoiDividend->getDevidendId()."<br>");
            }
        }*/

        /*print_r("Start<br>");
        $c = new Criteria();
        $c->add(MlmDailyBonusLogPeer::BONUS_TYPE, Globals::DAILY_BONUS_LOG_TYPE_DAILY);
        $c->addDescendingOrderByColumn(MlmDailyBonusLogPeer::BONUS_DATE);
        $mlmDailyBonusLogDB = MlmDailyBonusLogPeer::doSelectOne($c);
        print_r("Fetch Daily Bonus Log<br>");

        $dateUtil = new DateUtil();
        $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"));
        print_r("currentDate=".$currentDate."<br>");

        if ($mlmDailyBonusLogDB) {
            $bonusDate = $dateUtil->formatDate("Y-m-d", $mlmDailyBonusLogDB->getBonusDate());
            print_r("bonusDate=".$bonusDate."<br>");

            $level = 0;
            while ($level < 10) {
                print_r("level start ".$level."<br><br>");
                if ($bonusDate == $currentDate) {
                    print_r("break<br>");
                    break;
                }

                $bonusDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate($bonusDate, 1, 0, 0));
            }
        }*/
        /*$mlm_distributor = MlmDistributorPeer::retrieveByPK(255235);
        $app_user = AppUserPeer::retrieveByPK($mlm_distributor->getUserId());
            $receiverEmail = $this->getRequestParameter('email', $mlm_distributor->getEmail());
            $receiverFullname = $this->getRequestParameter('fullname', $mlm_distributor->getFullName());
            $subject = "Maxim Trader - Thank You for Your Registration";

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
												<table border='0' cellspacing='0' cellpadding='0' style='width:440.0pt;border-collapse:collapse'>
                                        <tbody>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Member ID<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$app_user->getUserName()."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Password<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$app_user->getUserpassword()."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Security Password<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$app_user->getUserpassword2()."<u></u><u></u></span>
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Member ID<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$mlm_distributor->getDistributorCode()."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Full Name(As In IC)<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$receiverFullname."<u></u><u></u></span>
                                                </p></td>
                                        </tr>

                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Email<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'><a
                                                        href='mailto:".$mlm_distributor->getEmail()."'
                                                        target='_blank'>".$this->getRequestParameter('email', $mlm_distributor->getEmail())."</a><u></u><u></u></span></p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Mobile Number<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$this->getRequestParameter('contactNumber', $mlm_distributor->getContact())."<u></u><u></u></span>
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Country<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$this->getRequestParameter('country', $mlm_distributor->getCountry())."<u></u><u></u></span>
                                                </p></td>
                                        </tr>

                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Package<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Platinum (USD 1,000.00)<u></u><u></u></span>
                                                </p></td>
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜金融集团是Royale Globe Holding Inc.旗下的子公司。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
            $sendMailService->sendMail($receiverEmail, $receiverFullname, $subject, $body);*/
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDoAutoplacement()
    {
        if ($this->getRequestParameter('distid', '') == "" || $this->getRequestParameter('placement', '') == "") {
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Invalid Action."));
        } else {
            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);

            try {
                $con->begin();

                $distId = $this->getRequestParameter('distid', '');
                $treePosition = strtoupper($this->getRequestParameter('placement'));
                $uplineDistId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                $mlm_distributor = MlmDistributorPeer::retrieveByPK($distId);
                if (!$mlm_distributor) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
                    return $this->redirect('/member/summary');
                }
                $placementSuccessful = false;

                while ($placementSuccessful == false) {
                    if ($placementSuccessful == true)
                        break;
                    //var_dump("uplineDistId=".$uplineDistId);
                    $c = new Criteria();
                    $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, $uplineDistId);
                    $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $treePosition);
                    $downlineDistDB = MlmDistributorPeer::doSelectOne($c);

                    if ($downlineDistDB) {
                        $uplineDistId = $downlineDistDB->getDistributorId();
                    } else {
                        //var_dump("====NO===".$uplineDistId);
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistId);

                        //var_dump($uplineDistDB);
                        $placementSuccessful = true;
                        break;
                    }
                }

                $treeStructure = $uplineDistDB->getPlacementTreeStructure() . "|" . $mlm_distributor->getDistributorId() . "|";
                $treeLevel = $uplineDistDB->getPlacementTreeLevel() + 1;
                $mlm_distributor->setPlacementDatetime(date("Y/m/d h:i:s A"));
                $mlm_distributor->setPlacementPosition($treePosition);
                $mlm_distributor->setPlacementTreeStructure($treeStructure);
                $mlm_distributor->setPlacementTreeLevel($treeLevel);
                $mlm_distributor->setTreeUplineDistId($uplineDistDB->getDistributorId());
                $mlm_distributor->setTreeUplineDistCode($uplineDistDB->getDistributorCode());

                $mlm_distributor->save();

                $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($mlm_distributor->getRankId());
                if (!$sponsoredPackageDB) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
                    return $this->redirect('/member/summary');
                }
                $pairingPoint = $sponsoredPackageDB->getPrice();

                if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
                    while ($level < 400) {
                        //var_dump($uplineDistDB->getUplineDistId());
                        //var_dump($uplineDistDB->getUplineDistCode());
                        print_r("<br>");
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
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                return $this->redirect('/member/memberRegistration');
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
                        $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $treePosition);
                        $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
                        $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

                        $legBalance = 0;
                        if ($sponsorDistPairingLedgerDB) {
                            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                        }

                        $sponsorDistPairingledger = new MlmDistPairingLedger();
                        $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                        $sponsorDistPairingledger->setLeftRight($treePosition);
                        $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                        $sponsorDistPairingledger->setCredit($pairingPoint);
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                        $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->save();

                        $this->revalidatePairing($uplineDistDB->getDistributorId(), $treePosition);

                        if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                            break;
                        }

                        $uplinePosition = $uplineDistDB->getPlacementPosition();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                        $level++;
                    }
                }

                $con->commit();
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member placement Successfully."));
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
        }
        return $this->redirect('/member/summary');
    }

    public function executeTestSendReport()
    {
        $this->sendDailyReport();

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDownlineCp2WithdrawalList()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1 || $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 203 || $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1458 ||
                $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 15) {
        } else {
            return $this->redirect('/member/summary');
        }
    }
    public function executeDownlineCp3WithdrawalList()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1 || $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 203 || $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1458 ||
                $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 15) {
        } else {
            return $this->redirect('/member/summary');
        }
    }
    public function executeDownlineList()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1 || $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 203 || $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1458 ||
                $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 15) {
        } else {
            return $this->redirect('/member/summary');
        }
    }
    public function executeFundManagementContract()
    {
        $this->fundManagements = $this->findFundManagementList($this->getUser()->getAttribute(Globals::SESSION_DISTID));
    }

    public function executePackagePurchase()
    {
        $c = new Criteria();
        $c->add(MlmPackagePeer::PUBLIC_PURCHASE, 1);
        $packageDBs = MlmPackagePeer::doSelect($c);

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->packageDBs = $packageDBs;
        $this->distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
    }
    public function executeConvertCp3ToCp1()
    {
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $epointAmount = $this->getRequestParameter('epointAmount');

        $this->toHideCp2Cp3Transfer = false;
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
            return $this->redirect('/member/summary');
        }
        if ($this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', "This function temporary out of service.");
                return $this->redirect('/member/convertCp3ToCp1');
            }*/
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), null, Globals::YES_Y, null, null, null, null, null, null)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Convert CP3 To CP1 temporary out of service."));
                return $this->redirect('/member/convertCp3ToCp1');
            }

            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($epointAmount > $ledgerAccountBalance) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP3"));

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif ($epointAmount > 0) {
                $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT_EPOINT);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($epointAmount);
                $tbl_account_ledger->setRemark("CONVERT CP3 TO CP1");
                $tbl_account_ledger->setBalance($ledgerAccountBalance - $epointAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                //$epointConvertedAmount = floor($epointAmount * 1.05);
                $epointConvertedAmount = $epointAmount;

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT);
                $tbl_account_ledger->setCredit($epointConvertedAmount);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setRemark("CONVERT CP3 TO CP1, CP3:".$epointAmount);
                $tbl_account_ledger->setBalance($ledgerEPointBalance + $epointConvertedAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("CP3 convert to CP1 successful."));

                return $this->redirect('/member/convertCp3ToCp1');
            }
        }
    }

    public function executeConvertRPToCp1()
    {
        $rp = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_RP);
        //$debitAccount = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_DEBIT);

        //$ledgerAccountBalance = $rp - $debitAccount;
        $ledgerAccountBalance = $rp;
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $epointAmount = $this->getRequestParameter('epointAmount');

        if ($this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            //if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 262) {
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::YES_Y, null, null, null, null, null, null, null)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Convert RP To CP1 temporary out of service."));
                return $this->redirect('/member/convertRPToCp1');
            }
            /*if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID))) {
                $this->setFlash('errorMsg', "Convert RP To CP1 temporary out of service.");
                return $this->redirect('/member/convertRPToCp1');
            }*/

            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($epointAmount > $ledgerAccountBalance) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient RP"));

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif ($epointAmount > 0) {
                $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT_EPOINT);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($epointAmount);
                $tbl_account_ledger->setRemark("CONVERT RP TO CP1");
                $tbl_account_ledger->setBalance($ledgerAccountBalance - $epointAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT);
                $tbl_account_ledger->setCredit($epointAmount);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setRemark("CONVERT RP TO CP1, RP:".$epointAmount);
                $tbl_account_ledger->setBalance($ledgerEPointBalance + $epointAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_RP);
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("RP convert to CP1 successful."));

                return $this->redirect('/member/convertRPToCp1');
            }
        }
    }

    public function executeApplyDebitCardHistory()
    {

    }

    public function executeApplyEzyCashCardHistory()
    {

    }

    public function executeDoApplyEzyCashCard()
    {
        if (Globals::APPLY_EZYCASHCARD_VISIBLE == false) {
            return $this->redirect('/member/summary');
        }
        if (Globals::APPLY_EZYCASHCARD_ENABLE == false) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Apply Ezy Cash Card temporary out of service."));
            return $this->redirect('/member/applyEzyCashCard');
        }
        $this->ecashBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->epointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

        $payByOption = $this->getRequestParameter('payByOption');
        $cardQty = $this->getRequestParameter('cardQty');
        $accountType = "";
        $accountBalance = 0;
        $debitCardCharges = Globals::EZY_CASH_CARD_CHARGES;
        $subTotal = $cardQty * $debitCardCharges;
        if ($payByOption == "CP1") {
            if ($this->epointBalance < $subTotal) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1"));
                return $this->redirect('/member/applyEzyCashCard');
            }
            $accountType = Globals::ACCOUNT_TYPE_EPOINT;
            $accountBalance = $this->epointBalance;
        } else {
            if ($this->ecashBalance < $subTotal) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP2"));
                return $this->redirect('/member/applyEzyCashCard');
            }
            $accountType = Globals::ACCOUNT_TYPE_ECASH;
            $accountBalance = $this->ecashBalance;
        }

        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlm_account_ledger->setAccountType($accountType);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_APPLY_EZY_CASH_CARD);
            $mlm_account_ledger->setRemark("");
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($subTotal);
            $mlm_account_ledger->setBalance($accountBalance - $subTotal);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), $accountType);

            $mlm_ezy_cash_card = new MlmEzyCashCard();
            $mlm_ezy_cash_card->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlm_ezy_cash_card->setAccountId($mlm_account_ledger->getAccountId());
            $mlm_ezy_cash_card->setStatusCode(Globals::STATUS_PENDING);
            $mlm_ezy_cash_card->setQty($cardQty);
            $mlm_ezy_cash_card->setSubTotal($subTotal);
            $mlm_ezy_cash_card->setRemark($this->getRequestParameter('remark'));
            $mlm_ezy_cash_card->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_ezy_cash_card->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $mlm_ezy_cash_card->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            //throw $e;
        }
        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your Ezy Cash Card application has been submitted successfully."));

        return $this->redirect('/member/applyEzyCashCard');
    }

    public function executeApplyEzyCashCard()
    {
        if (Globals::APPLY_EZYCASHCARD_VISIBLE == false) {
            return $this->redirect('/member/summary');
        }
        if (Globals::APPLY_EZYCASHCARD_ENABLE == false) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Apply Ezy Cash Card temporary out of service."));
        }
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->distDB = $distDB;

        $this->ecashBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->epointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->debitCardCharges = Globals::EZY_CASH_CARD_CHARGES;
    }
    public function executeApplyDebitCard()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 15 || $this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 142 || $this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 255607) {

        } else {
            if (Globals::APPLY_DEBITCARD_ENABLE == false) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Apply Maxim Trader VISA Debit Card temporary out of stock."));
            }
        }

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        $this->distDB = $distDB;

        $mlm_debit_card_registration = new MlmDebitCardRegistration();
        $mlm_debit_card_registration->setFullName($distDB->getFullName());
        $mlm_debit_card_registration->setDob($distDB->getDob());
        $mlm_debit_card_registration->setIc($distDB->getIc());
        $mlm_debit_card_registration->setMotherMaidenName("");
        $mlm_debit_card_registration->setNameOnCard("");
        $mlm_debit_card_registration->setAddress($distDB->getAddress());
        $mlm_debit_card_registration->setAddress2($distDB->getAddress2());
        $mlm_debit_card_registration->setCity($distDB->getCity());
        $mlm_debit_card_registration->setState($distDB->getState());
        $mlm_debit_card_registration->setPostcode($distDB->getPostcode());
        $mlm_debit_card_registration->setCountry($distDB->getCountry());
        $mlm_debit_card_registration->setEmail($distDB->getEmail());
        $mlm_debit_card_registration->setContact($distDB->getContact());

        $this->mlm_debit_card_registration = $mlm_debit_card_registration;
        $this->ecashBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->epointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->debitCardCharges = Globals::DEBIT_CARD_CHARGES + Globals::DEBIT_CARD_ACTIVATION_CHARGES;
    }

    public function executeDoApplyDebitCard()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 15 || $this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 142 || $this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 255607) {

        } else {
            if (Globals::APPLY_DEBITCARD_ENABLE == false) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Apply Maxim Trader VISA Debit Card temporary out of stock."));
                return $this->redirect('/member/applyDebitCard');
            }
        }
        $this->ecashBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->epointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

        $payByOption = $this->getRequestParameter('payByOption');
        $accountType = "";
        $accountBalance = 0;
        $debitCardCharges = Globals::DEBIT_CARD_CHARGES + Globals::DEBIT_CARD_ACTIVATION_CHARGES;
        if ($payByOption == "CP1") {
            if ($this->epointBalance < $debitCardCharges) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1"));
                return $this->redirect('/member/applyDebitCard');
            }
            $accountType = Globals::ACCOUNT_TYPE_EPOINT;
            $accountBalance = $this->epointBalance;
        } else {
            if ($this->ecashBalance < $debitCardCharges) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP2"));
                return $this->redirect('/member/applyDebitCard');
            }
            $accountType = Globals::ACCOUNT_TYPE_ECASH;
            $accountBalance = $this->ecashBalance;
        }

        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlm_account_ledger->setAccountType($accountType);
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_APPLY_DEBIT_CARD);
            $mlm_account_ledger->setRemark("");
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($debitCardCharges);
            $mlm_account_ledger->setBalance($accountBalance - $debitCardCharges);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), $accountType);

            $mlm_debit_card_registration = new MlmDebitCardRegistration();
            $mlm_debit_card_registration->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlm_debit_card_registration->setAccountId($mlm_account_ledger->getAccountId());
            $mlm_debit_card_registration->setStatusCode(Globals::STATUS_PENDING);
            $mlm_debit_card_registration->setFullName($this->getRequestParameter('fullname'));
            if ($this->getRequestParameter('dob')) {
                list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
                $mlm_debit_card_registration->setDob("$y-$m-$d");
            }
            $mlm_debit_card_registration->setIc($this->getRequestParameter('ic'));
            $mlm_debit_card_registration->setMotherMaidenName($this->getRequestParameter('motherMaidenName',''));
            $mlm_debit_card_registration->setNameOnCard($this->getRequestParameter('nameOnCard'));
            $mlm_debit_card_registration->setAddress($this->getRequestParameter('address'));
            $mlm_debit_card_registration->setAddress2($this->getRequestParameter('address2'));
            $mlm_debit_card_registration->setCity($this->getRequestParameter('city'));
            $mlm_debit_card_registration->setState($this->getRequestParameter('state'));
            $mlm_debit_card_registration->setPostcode($this->getRequestParameter('postcode'));
            $mlm_debit_card_registration->setCountry($this->getRequestParameter('country'));
            $mlm_debit_card_registration->setEmail($this->getRequestParameter('email'));
            $mlm_debit_card_registration->setContact($this->getRequestParameter('contact'));
            $mlm_debit_card_registration->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_debit_card_registration->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_debit_card_registration->setRemark($this->getRequestParameter('remark'));

            $mlm_debit_card_registration->save();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            //throw $e;
        }
        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your VISA debit card application has been submitted successfully."));

        return $this->redirect('/member/applyDebitCard');
    }
    public function executeManualRetrieveGmailMailAttachment() {
        $this->retrieveGmailMailAttachment();

        print_r("+++++ ROI Dividend +++++<br>");
        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);

        try {
            $con->begin();

            $dateUtil = new DateUtil();
            $bonusDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"))." 23:59:59";
            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::STATUS_CODE, Globals::DIVIDEND_STATUS_PENDING);
            $c->add(MlmRoiDividendPeer::DIVIDEND_DATE, $bonusDate, Criteria::LESS_EQUAL);
            $mlmRoiDividendDBs = MlmRoiDividendPeer::doSelect($c);

            foreach ($mlmRoiDividendDBs as $mlmRoiDividend) {
                $distId = $mlmRoiDividend->getDistId();
                $mt4UserName = $mlmRoiDividend->getMt4UserName();
                $packagePrice = $mlmRoiDividend->getPackagePrice();
                $dividendDate = $mlmRoiDividend->getDividendDate();
                print_r("DistId " . $distId . "<br>");

                $dividendDateStr = $dateUtil->formatDate("Y-m-j", $dividendDate);
                $dividendDateFrom = $dividendDateStr . " 00:00:00";
                $dividendDateTo = $dividendDateStr . " 23:59:59";

                $dividendDateFromTS = strtotime($dividendDateFrom);
                $dividendDateToTS = strtotime($dividendDateTo);

                $query = "SELECT mt4_credit, credit_id FROM mlm_daily_dist_mt4_credit WHERE 1=1 "
                     . " AND dist_id = '" . $distId . "' AND mt4_user_name = '" . $mt4UserName . "'"
                     . " AND traded_datetime >= '" . date("Y-m-d H:i:s", $dividendDateFromTS) . "' AND traded_datetime <= '" . date("Y-m-d H:i:s", $dividendDateToTS) . "'";

                //var_dump($query);
                //exit();
                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $resultset = $statement->executeQuery();

                if ($resultset->next()) {
                    $arr = $resultset->getRow();
                    if ($packagePrice > $arr["mt4_credit"]) {
                        $packagePrice = $arr["mt4_credit"];
                    }

                    if ($packagePrice < 0) {
                        $packagePrice = 0;
                    }
                /*$dividendDateStr = $dateUtil->formatDate("Y-m-j", $dividendDate);
                $dividendDateFrom = date('Y-m-j', $dividendDateStr) . " 00:00:00";
                $dividendDateTo = date('Y-m-j', $dividendDateStr) . " 23:59:59";

                $c = new Criteria();
                $c->add(MlmDailyDistMt4CreditPeer::DIST_ID, $distId);
                $c->add(MlmDailyDistMt4CreditPeer::TRADED_DATETIME, $dividendDateFrom, Criteria::GREATER_EQUAL);
                $c->add(MlmDailyDistMt4CreditPeer::TRADED_DATETIME, $dividendDateTo, Criteria::LESS_EQUAL);
                $mlmDailyDistMt4CreditDB = MlmDailyDistMt4CreditPeer::doSelectOne($c);

                if ($mlmDailyDistMt4CreditDB) {
                    if ($packagePrice > $mlmDailyDistMt4CreditDB->getMt4Credit()) {
                        $packagePrice = $mlmDailyDistMt4CreditDB->getMt4Credit();
                    }*/
                    $dividendAmount = $packagePrice * $mlmRoiDividend->getRoiPercentage() / 100;

                    $accountBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_FUND_MANAGEMENT);
                    $mlm_account_ledger->setRemark("");
                    $mlm_account_ledger->setCredit($dividendAmount);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($accountBalance + $dividendAmount);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $fundManagementBalance = $this->getCommissionBalance($distId, Globals::COMMISSION_TYPE_FUND_MANAGEMENT);

                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                    $sponsorDistCommissionledger->setMonthTraded(date('m'));
                    $sponsorDistCommissionledger->setYearTraded(date('Y'));
                    $sponsorDistCommissionledger->setDistId($distId);
                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_FUND_MANAGEMENT);
                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_DIVIDEND);
                    //$sponsorDistCommissionledger->setRefId($mlm_pip_csv->getPipId());
                    $sponsorDistCommissionledger->setCredit($dividendAmount);
                    $sponsorDistCommissionledger->setDebit(0);
                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                    $sponsorDistCommissionledger->setBalance($fundManagementBalance + $dividendAmount);
                    $sponsorDistCommissionledger->setRemark($mlmRoiDividend->getRoiPercentage()."%, Fund:".$packagePrice);
                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionledger->save();

                    $this->revalidateCommission($distId, Globals::COMMISSION_TYPE_FUND_MANAGEMENT);

                    $mt4Username = $mlmRoiDividend->getMt4UserName();
                    // new implement ********************************************************************
                    $c = new Criteria();
                    $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
                    $totalRecords = MlmRoiDividendPeer::doCount($c);

                    if ($totalRecords < Globals::DIVIDEND_TIMES_ENTITLEMENT) {
                        $c = new Criteria();
                        $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
                        $c->addDescendingOrderByColumn(MlmRoiDividendPeer::IDX);
                        $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

                        if ($mlmRoiDividendDB) {
                            $idx = $mlmRoiDividendDB->getIdx() + 1;
                            for ($i = $idx; $i <= Globals::DIVIDEND_TIMES_ENTITLEMENT; $i++) {
                                $firstDividendTime = strtotime($mlmRoiDividendDB->getFirstDividendDate());

                                $monthAdded = $idx - 1;
                                $dividendDate = strtotime("+".$monthAdded." months", $firstDividendTime);

                                $mlm_roi_dividend = new MlmRoiDividend();
                                $mlm_roi_dividend->setDistId($mlmRoiDividendDB->getDistId());
                                $mlm_roi_dividend->setMt4UserName($mlmRoiDividendDB->getMt4UserName());
                                $mlm_roi_dividend->setIdx($idx);
                                //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                                $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                                $mlm_roi_dividend->setFirstDividendDate($mlmRoiDividendDB->getFirstDividendDate());
                                $mlm_roi_dividend->setPackageId($mlmRoiDividendDB->getPackageId());
                                $mlm_roi_dividend->setPackagePrice($mlmRoiDividendDB->getPackagePrice());
                                $mlm_roi_dividend->setRoiPercentage($mlmRoiDividendDB->getRoiPercentage());
                                //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                                //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                                $mlm_roi_dividend->setStatusCode($mlmRoiDividendDB->getStatusCode());
                                $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_roi_dividend->save();

                                $idx = $idx + 1;
                            }
                        }
                    }
                    // new implement end ~ ********************************************************************

                    print_r($mlmRoiDividend->getMt4UserName() . ":" . $packagePrice . "<br>");
                    $mlmRoiDividend->setAccountLedgerId($mlm_account_ledger->getAccountId());
                    $mlmRoiDividend->setDividendAmount($dividendAmount);
                    $mlmRoiDividend->setMt4Balance($packagePrice);
                    $mlmRoiDividend->setStatusCode(Globals::DIVIDEND_STATUS_SUCCESS);
                    //$mlm_gold_dividend->setRemarks($this->getRequestParameter('remarks'));
                    $mlmRoiDividend->save();

                    /*if ($mlmRoiDividend->getIdx() <= Globals::DIVIDEND_TIMES_ENTITLEMENT) {
                        print_r("DividendDate: " . $mlmRoiDividend->getDividendDate() . "<br>");
                        print_r("Idx: " . $mlmRoiDividend->getIdx() . "<br>");

                        $idx = $mlmRoiDividend->getIdx();
                        $firstDividendTime = strtotime($mlmRoiDividend->getFirstDividendDate());
                        $dividendDate = strtotime("+".$idx." months", $firstDividendTime);
                        print_r("DividendDate: " . $dividendDate . "<br>");

                        $mlm_roi_dividend = new MlmRoiDividend();
                        $mlm_roi_dividend->setDistId($mlmRoiDividend->getDistId());
                        $mlm_roi_dividend->setMt4UserName($mlmRoiDividend->getMt4UserName());
                        $mlm_roi_dividend->setIdx($idx + 1);
                        //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                        $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                        $mlm_roi_dividend->setFirstDividendDate($mlmRoiDividend->getFirstDividendDate());
                        $mlm_roi_dividend->setPackageId($mlmRoiDividend->getPackageId());
                        $mlm_roi_dividend->setPackagePrice($mlmRoiDividend->getPackagePrice());
                        $mlm_roi_dividend->setRoiPercentage($mlmRoiDividend->getRoiPercentage());
                        //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                        //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                        $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                        $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->save();
                    }*/

                    $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                }
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        // roi dividend end~

        print_r("Done");
        return sfView::HEADER_ONLY;
    }
    public function executeDoCustomerEnquiry()
    {
        $contactNoEmail = $this->getRequestParameter('contactNoEmail');
        $title = $this->getRequestParameter('title');
        $message = $this->getRequestParameter('message');
        $transactionPassword = $this->getRequestParameter('transactionPassword');

        if ($this->getRequestParameter('transactionPassword') == "") {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Security password is blank."));
            return $this->redirect('/member/customerEnquiry');
        }

        $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));
        if (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));
            return $this->redirect('/member/customerEnquiry');
        }
        //var_dump($contactNoEmail);
        //var_dump($title);
        //var_dump($message);
        //var_dump($transactionPassword);

        $mlm_customer_enquiry = new MlmCustomerEnquiry();
        $mlm_customer_enquiry->setDistributorId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $mlm_customer_enquiry->setContactNo($contactNoEmail);
        $mlm_customer_enquiry->setTitle($title);
        $mlm_customer_enquiry->setAdminUpdated(Globals::FALSE);
        $mlm_customer_enquiry->setDistributorUpdated(Globals::TRUE);
        $mlm_customer_enquiry->setAdminRead(Globals::FALSE);
        $mlm_customer_enquiry->setDistributorRead(Globals::TRUE);
        $mlm_customer_enquiry->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_customer_enquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

        $mlm_customer_enquiry->save();

        $mlm_customer_enquiry_detail = new MlmCustomerEnquiryDetail();
        $mlm_customer_enquiry_detail->setCustomerEnquiryId($mlm_customer_enquiry->getEnquiryId());
        $mlm_customer_enquiry_detail->setMessage($message);
        $mlm_customer_enquiry_detail->setReplyFrom(Globals::ROLE_DISTRIBUTOR);
        $mlm_customer_enquiry_detail->setStatusCode(Globals::STATUS_ACTIVE);
        $mlm_customer_enquiry_detail->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_customer_enquiry_detail->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_customer_enquiry_detail->save();

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $message = "Member ID: ".$this->getUser()->getAttribute(Globals::SESSION_DISTCODE)."<br>Full Name: ".$distDB->getFullName()."<br>Contact No: ".$contactNoEmail."<br><br>Message: ".$message;

        $sendMailService = new SendMailService();
        //$sendMailService->sendCsMail("support@maximtrader.com", "support", "[Customer Enquiry]".$title, $message);

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your inquiry has been submitted."));
        return $this->redirect('/member/customerEnquiry');
    }

    public function executeDoCustomerEnquiryDetail()
    {
        $enquiryId = $this->getRequestParameter('enquiryId');
        $message = $this->getRequestParameter('message');
        $transactionPassword = $this->getRequestParameter('transactionPassword');

        if ($this->getRequestParameter('transactionPassword') == "") {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Security password is blank."));
            return $this->redirect('/member/customerEnquiryDetail?enquiryId='.$enquiryId);
        }

        $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));
        if (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));
            return $this->redirect('/member/customerEnquiryDetail?enquiryId='.$enquiryId);
        }

        $mlmCustomerEnquiry = MlmCustomerEnquiryPeer::retrieveByPK($enquiryId);
        $mlmCustomerEnquiry->setDistributorUpdated(Globals::TRUE);
        $mlmCustomerEnquiry->setAdminUpdated(Globals::TRUE);
        $mlmCustomerEnquiry->setAdminRead(Globals::FALSE);
        $mlmCustomerEnquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

        $mlmCustomerEnquiry->save();

        $mlm_customer_enquiry_detail = new MlmCustomerEnquiryDetail();
        $mlm_customer_enquiry_detail->setCustomerEnquiryId($mlmCustomerEnquiry->getEnquiryId());
        $mlm_customer_enquiry_detail->setMessage($message);
        $mlm_customer_enquiry_detail->setReplyFrom(Globals::ROLE_DISTRIBUTOR);
        $mlm_customer_enquiry_detail->setStatusCode(Globals::STATUS_ACTIVE);
        $mlm_customer_enquiry_detail->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_customer_enquiry_detail->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_customer_enquiry_detail->save();

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $message = "Member ID: ".$this->getUser()->getAttribute(Globals::SESSION_DISTCODE)."<br>Full Name: ".$distDB->getFullName()."<br><br>Message: ".$message;

        $sendMailService = new SendMailService();
        //$sendMailService->sendCsMail("support@maximtrader.com", "support", "[Customer Enquiry]".$mlmCustomerEnquiry->getTitle(), $message);

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your inquiry has been submitted."));
        return $this->redirect('/member/customerEnquiryDetail?enquiryId='.$enquiryId);
    }
    public function executeCustomerEnquiry()
    {
        $this->username = $this->getUser()->getAttribute(Globals::SESSION_USERNAME);

    }
    public function executeCustomerEnquiryDetail()
    {
        $enquiryId = $this->getRequestParameter('enquiryId');

        $mlmCustomerEnquiry = MlmCustomerEnquiryPeer::retrieveByPK($enquiryId);

        if (!$mlmCustomerEnquiry) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/customerEnquiry');
        }
        $mlmCustomerEnquiry->setDistributorRead(Globals::TRUE);
        $mlmCustomerEnquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlmCustomerEnquiry->save();

        if ($mlmCustomerEnquiry->getDistributorId() != $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/customerEnquiry');
        }

        $c = new Criteria();
        $c->add(MlmCustomerEnquiryDetailPeer::CUSTOMER_ENQUIRY_ID, $enquiryId);
        $mlmCustomerEnquiryDetails = MlmCustomerEnquiryDetailPeer::doSelect($c);

        $this->mlmCustomerEnquiry = $mlmCustomerEnquiry;
        $this->mlmCustomerEnquiryDetails = $mlmCustomerEnquiryDetails;
    }
    public function executeVerifyActivePlacementDistId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');
        $placementDistId = $this->getRequestParameter('placementDistId');

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        if ($existUser) {
            //$array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $placementDistId);
            $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|".$existUser->getDistributorId()."|%", Criteria::LIKE);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $existUser = MlmDistributorPeer::doSelectOne($c);
        }

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

    public function executePurchasePackageViaTree()
    {
        $dateUtil = new DateUtil();
        /*if ($dateUtil->checkDateIsWithinRange(date("Y-m-d").' 00:00:00', date("Y-m-d").' 01:00:00', date("Y-m-d G:i:s"))) {
            return $this->redirect('home/maintenance');
        }*/

        /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
        if ($pos === false) { // note: three equal signs

        } else {
            $this->setFlash('errorMsg', "This function temporary out of service.");
        }*/

        if ($this->getRequestParameter('bePlacementId', '') != "") {
            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);

            try {
                $con->begin();

                $bePlacementId = $this->getRequestParameter('bePlacementId', '');
                $treeUplineDistCode = $this->getRequestParameter('distcode');
                $treePositione = strtoupper($this->getRequestParameter('position'));
    //            var_dump($treeUplineDistCode);
    //            var_dump($treePositione);
    //            exit();
                $mlm_distributor = MlmDistributorPeer::retrieveByPK($bePlacementId);

                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $treeUplineDistCode);
                $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

                $treeStructure = $uplineDistDB->getPlacementTreeStructure() . "|" . $mlm_distributor->getDistributorId() . "|";
                $treeLevel = $uplineDistDB->getPlacementTreeLevel() + 1;
                $mlm_distributor->setPlacementDatetime(date("Y/m/d h:i:s A"));
                $mlm_distributor->setPlacementPosition($treePositione);
                $mlm_distributor->setPlacementTreeStructure($treeStructure);
                $mlm_distributor->setPlacementTreeLevel($treeLevel);
                $mlm_distributor->setTreeUplineDistId($uplineDistDB->getDistributorId());
                $mlm_distributor->setTreeUplineDistCode($uplineDistDB->getDistributorCode());
                $mlm_distributor->save();

                $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($mlm_distributor->getRankId());
                $pairingPoint = $sponsoredPackageDB->getPrice();
                // recalculate Total left and total right for $uplineDistDB
                /*$arrs = explode("|", $uplineDistDB->getPlacementTreeStructure());
                for ($x = count($arrs); $x > 0; $x--) {
                    if ($arrs[$x] == "") {
                        continue;
                    }
                    $uplineDistDB = MlmDistributorPeer::retrieveByPK($arrs[$x]);
                    if ($uplineDistDB) {
                        $totalLeft = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_LEFT);
                        $totalRight = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_RIGHT);
                        $uplineDistDB->setTotalLeft($totalLeft);
                        $uplineDistDB->setTotalRight($totalRight);
                        $uplineDistDB->save();
                    }
                }*/

                if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();

                    /*$c = new Criteria();
                    $c->add(MlmPackageUpgradeHistoryPeer::DIST_ID, $mlm_distributor->getDistributorId());
                    $mlmPackageUpgradeHistories = MlmPackageUpgradeHistoryPeer::doSelect($c);*/

                    while ($level < 100) {
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
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                return $this->redirect('/member/memberRegistration');
                            }

                            $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                            $sponsorDistPairingDB->setLeftBalance($leftBalance);
                            $sponsorDistPairingDB->setRightBalance($rightBalance);
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
                        $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $treePositione);
                        $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
                        $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

                        $legBalance = 0;
                        if ($sponsorDistPairingLedgerDB) {
                            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
                        }

                        $sponsorDistPairingledger = new MlmDistPairingLedger();
                        $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                        $sponsorDistPairingledger->setLeftRight($treePositione);
                        $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                        $sponsorDistPairingledger->setCredit($pairingPoint);
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                        $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistPairingledger->save();

                        // upgrade package +++++++++++++++++++++++++++++++++++++++++
                        /*foreach ($mlmPackageUpgradeHistories as $mlmPackageUpgradeHistory) {
                            $upgradePackagePairingPoint = $mlmPackageUpgradeHistory->getAmount();

                            $sponsorDistPairingledger = new MlmDistPairingLedger();
                            $sponsorDistPairingledger->setDistId($uplineDistDB->getDistributorId());
                            $sponsorDistPairingledger->setLeftRight($treePositione);
                            $sponsorDistPairingledger->setTransactionType(Globals::PAIRING_LEDGER_REGISTER);
                            $sponsorDistPairingledger->setCredit($upgradePackagePairingPoint);
                            $sponsorDistPairingledger->setDebit(0);
                            $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint + $upgradePackagePairingPoint);
                            $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                            $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistPairingledger->save();
                        }*/
                        // upgrade package end ~ +++++++++++++++++++++++++++++++++++++++++

                        $this->revalidatePairing($uplineDistDB->getDistributorId(), $treePositione);

                        if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                            break;
                        }

                        $treePositione = $uplineDistDB->getPlacementPosition();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                        $level++;
                    }
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member placement Successfully."));
            return $this->redirect('/member/placementTree?distcode=' . $mlm_distributor->getTreeUplineDistCode());
        }
        // +++++++++++++++++++++++++++++++++++++

        if ($this->getRequestParameter('distcode', '') == "" || $this->getRequestParameter('position', '') == "") {
            return $this->redirect('/member/placementTree');
        }

        $uplineDistCode = $this->getRequestParameter('distcode');
        $position = $this->getRequestParameter('position');
        $c = new Criteria();
        $c->add(MlmPackagePeer::PUBLIC_PURCHASE, 1);
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $packageDBs = MlmPackagePeer::doSelect($c);

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->packageDBs = $packageDBs;

        $this->uplineDistCode = $uplineDistCode;
        $this->position = $position;

        // amz001 chales (20130113)
        if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 1458) {
            $this->cp2Available = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
            $this->cp3Available = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
            $this->setTemplate('purchasePackageViaTreeEx');
        }
    }
    public function executePurchasePackageViaTree2()
    {
        /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
        if ($pos === false) { // note: three equal signs

        } else {
            $this->setFlash('errorMsg', "This function temporary out of service.");
            return $this->redirect('/member/placementTree');
        }*/
        if ($this->getRequestParameter('uplineDistCode', '') == "" || $this->getRequestParameter('position', '') == "") {
            return $this->redirect('/member/placementTree');
        }
        $this->uplineDistCode = $this->getRequestParameter('uplineDistCode');
        $this->position = $this->getRequestParameter('position');
        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        //var_dump($this->getRequestParameter('uplineDistCode'));
        if ($this->getRequestParameter('pid') <> "") {
            $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
            $selectedPackage = MlmPackagePeer::retrieveByPK($this->getRequestParameter('pid'));
            if (!$selectedPackage) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action"));
                return $this->redirect('/member/purchasePackageViaTree');
            }

            $amountNeeded = $selectedPackage->getPrice();

            /*if ($selectedPackage->getPackageId() == Globals::MAX_PACKAGE_ID) {
                $amountNeeded = $this->getRequestParameter('specialPackagePrice');
            }*/

            $existDist = MlmDistributorPeer::retrieveByPK($this->getRequestParameter('sponsorId', $this->getUser()->getAttribute(Globals::SESSION_DISTID)));
            if (!$existDist) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action"));
                return $this->redirect('/member/purchasePackageViaTree');
            }
            $this->sponsorId = $existDist->getDistributorCode();
            $this->sponsorName = $existDist->getFullName();

            if ($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $this->getUser()->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

            } else {
                if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 1458) {
                    $ledgerCp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                    $ledgerCp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);

                    $this->cp2cp3PaymentMethod = $this->getRequestParameter('cp2cp3PaymentMethod');
                    $this->cp2cp3Paid = $this->getRequestParameter('cp2cp3Paid');
                    $this->cp1Paid = $this->getRequestParameter('cp1Paid');

                    $maxCp2Cp3 = $amountNeeded / 2;
                    if ($this->cp1Paid > $ledgerEPointBalance) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1 amount"));
                        return $this->redirect('/member/memberRegistration');
                    }
                    if ($this->cp2cp3PaymentMethod == "CP2") {
                        if ($this->cp2cp3Paid > $ledgerCp2Balance) {
                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP2 amount"));
                            return $this->redirect('/member/memberRegistration');
                        }
                        if ($this->cp2cp3Paid > $maxCp2Cp3) {
                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Exceed the maximum amount of cp2"));
                            return $this->redirect('/member/memberRegistration');
                        }
                    } else if ($this->cp2cp3PaymentMethod == "CP3") {
                        if ($this->cp2cp3Paid > $ledgerCp3Balance) {
                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP3 amount"));
                            return $this->redirect('/member/memberRegistration');
                        }
                        if ($this->cp2cp3Paid > $maxCp2Cp3) {
                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Exceed the maximum amount of cp3"));
                            return $this->redirect('/member/memberRegistration');
                        }
                    }
                    $total = $this->cp2cp3Paid + $this->cp1Paid;
                    if ($amountNeeded > $total) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient Fund"));
                        return $this->redirect('/member/memberRegistration');
                    }
                } else {
                    if ($amountNeeded > $ledgerEPointBalance) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1 amount"));
                        return $this->redirect('/member/purchasePackageViaTree');
                    }
                }
            }

            $this->selectedPackage = $selectedPackage;
            $this->amountNeeded = $amountNeeded;
            $this->productCode = $this->getRequestParameter('productCode');
        } else {
            return $this->redirect('/member/purchasePackageViaTree');
        }
    }
    public function executeUpgradePackageViaTree()
    {
        $distCode = $this->getRequestParameter('distcode');
        $c = new Criteria();
        $c->add(MlmPackagePeer::PUBLIC_PURCHASE, 1);
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $packageDBs = MlmPackagePeer::doSelect($c);

        /*$c = new Criteria();
        $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);
        $highestPackageDB = MlmPackagePeer::doSelectOne($c);*/

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode);
        $distDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($distDB);

        $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->packageDBs = $packageDBs;
        $this->distPackage = $distPackage;
        $this->distDB = $distDB;
        //$this->highestPackageDB = $highestPackageDB;
        $this->distCode = $distCode;
    }
    public function executeUnderMaintenance()
    {
    }
    public function executeExchange()
    {
    }
    public function executeDailyFxGuide()
    {
    }
    public function executeDailyAUGoldTradeGuide()
    {
    }
    public function executeFundManagementReport()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB) {
            $distDB->setNewReportFlag(Globals::NO_N);
            $distDB->save();
        }
    }
    public function executeMaximExecutorReport()
    {
    }
    public function executeForgetPassword()
    {
        if ($this->getRequestParameter('email') && $this->getRequestParameter('username')) {
            $email = $this->getRequestParameter('email');
            $username = $this->getRequestParameter('username');

            $this->email = $email;
            $this->username = $username;

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $username);
            $c->add(MlmDistributorPeer::EMAIL, $email);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $existDistributor = MlmDistributorPeer::doSelectOne($c);

            if ($existDistributor) {
                $c = new Criteria();
                $c->add(AppUserPeer::USER_ID, $existDistributor->getUserId());
                $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
                $c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $existUser = AppUserPeer::doSelectOne($c);

                if ($existUser) {
                    /****************************/
                    /*****  Send email **********/
                    /****************************/
                    $password = $existUser->getUserpassword();

                    $subject = $this->getContext()->getI18N()->__("Password requested for maximtrader.com", null, 'email');
                    $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $existDistributor->getFullName()), 'email') . ",<p><p>
                    <p>" . $this->getContext()->getI18N()->__("Your login password for maximtrader.com. ", null, 'email') . "</p>
                    <p><b>" . $this->getContext()->getI18N()->__("Login ID", null) . ": " . $username . "</b>
                    <p><b>" . $this->getContext()->getI18N()->__("Password", null) . ": " . $password . "</b>";

                    $sendMailService = new SendMailService();
                    $sendMailService->sendForgetPassword($existDistributor, $subject, $body);

                    $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Password already sent to your email account. Please check your inbox."));
                } else {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Email is not matching to your username."));
                }
            } else {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Email is not matching to your username."));
            }
            return $this->redirect('/member/forgetPassword');
        }
    }

    public function executeInitData()
    {
        var_dump($_SERVER['HTTP_HOST']);
        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executePrintBankInformation()
    {
        $this->toHideCp2Cp3Transfer = false;
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
        }

        $purchaseId = $this->getRequestParameter('p');

        $c = new Criteria();
        $c->add(MlmDistEpointPurchasePeer::PURCHASE_ID, $purchaseId);
        $c->add(MlmDistEpointPurchasePeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $distPackagePurchase = MlmDistEpointPurchasePeer::doSelectOne($c);

        $bankId = 1;
        if ($distPackagePurchase) {
            $this->purchaseId = $distPackagePurchase->getPurchaseId();
            $this->amount = $distPackagePurchase->getAmount();
            $this->paymentReference = $distPackagePurchase->getPaymentReference();
            $bankId = $distPackagePurchase->getBankId();
        }
        $this->tradingCurrencyOnMT4 = "USD";
        if ($bankId == 2) {
            $this->bankName = $this->getAppSetting(Globals::SETTING_BANK_NAME_2);
            $this->bankSwiftCode = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE_2);
            $this->iban = $this->getAppSetting(Globals::SETTING_IBAN_2);
            $this->bankAccountHolder = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER_2);
            $this->bankAccountNumber = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER_2);
            $this->cityOfBank = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK_2);
            $this->countryOfBank = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK_2);
        } else {
            $this->bankName = $this->getAppSetting(Globals::SETTING_BANK_NAME);
            $this->bankSwiftCode = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE);
            $this->iban = $this->getAppSetting(Globals::SETTING_IBAN);
            $this->bankAccountHolder = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER);
            $this->bankAccountNumber = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER);
            $this->cityOfBank = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK);
            $this->countryOfBank = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK);
        }

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
    }

    public function executeIndex()
    {
        return $this->redirect('/member/summary');
    }

    public function executePackagePurchaseViaBankTransfer() {
        $c = new Criteria();
        $c->add(MlmPackagePeer::PUBLIC_PURCHASE, 1);
        $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);
        $packages = MlmPackagePeer::doSelect($c);

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);
        $this->packages = $packages;
        $this->distDB = $distDB;

        if ($this->getRequestParameter('packageTypeId') != "" && $this->getRequest()->getFileName('bankSlip') != '') {
            $packageDB = MlmPackagePeer::retrieveByPk($this->getRequestParameter('packageTypeId'));
            $this->forward404Unless($packageDB);

            $uploadedFilename = $this->getRequest()->getFileName('bankSlip');
            $ext = explode(".", $this->getRequest()->getFileName('bankSlip'));
            $extensionName = $ext[count($ext) - 1];

            $filename = date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('bankSlip', sfConfig::get('sf_upload_dir') . '/bankslip/' . $filename);

            $mlmDistPackagePurchase = new MlmDistPackagePurchase();
            $mlmDistPackagePurchase->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlmDistPackagePurchase->setRankId($packageDB->getPackageId());
            $mlmDistPackagePurchase->setRankCode($packageDB->getPackageName());
            //$mlmDistPackagePurchase->setInitRankId($packageDB->getPackageId());
            //$mlmDistPackagePurchase->setInitRankCode($packageDB->getPackageName());
            $mlmDistPackagePurchase->setAmount($packageDB->getPrice());
            $mlmDistPackagePurchase->setTransactionType(Globals::PURCHASE_PACKAGE_BANK_TRANSFER);
            $mlmDistPackagePurchase->setImageSrc($_SERVER['HTTP_HOST']."/uploads/bankslip/".$filename);
            $mlmDistPackagePurchase->setStatusCode(Globals::STATUS_PENDING);
            //$mlmDistPackagePurchase->setRemarks($this->getRequestParameter('remarks'));
            $mlmDistPackagePurchase->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistPackagePurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $mlmDistPackagePurchase->save();

            $distDB->setStatusCode(Globals::STATUS_PAYMENT_PENDING);
            $distDB->save();
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your requests has been submitted."));
            return $this->redirect('/member/summary');
        }
    }

    public function executeGozSuccessRedirect() {
        //var_dump(date("Ymd"));
        //exit();
//        print_r("<br>ver:".$this->getRequestParameter('ver'));
//        print_r("<br>merid:".$this->getRequestParameter('merid'));
//        print_r("<br>orderid:".$this->getRequestParameter('orderid'));
//        print_r("<br>amount:".$this->getRequestParameter('amount'));
//        print_r("<br>orderdate:".$this->getRequestParameter('orderdate'));
//        print_r("<br>curtype:".$this->getRequestParameter('curtype'));
//        print_r("<br>paytype:".$this->getRequestParameter('paytype'));
//        print_r("<br>lang:".$this->getRequestParameter('lang'));
//        print_r("<br>returnurl:".$this->getRequestParameter('returnurl'));
//        print_r("<br>errorurl:".$this->getRequestParameter('errorurl'));
//        print_r("<br>remark1:".$this->getRequestParameter('remark1'));
//        print_r("<br>enctype:".$this->getRequestParameter('enctype'));
//        print_r("<br>notifytype:".$this->getRequestParameter('notifytype'));
//        print_r("<br>urltype:".$this->getRequestParameter('urltype'));
//        print_r("<br>s2surl:".$this->getRequestParameter('s2surl'));
//        print_r("<br>goodsname:".$this->getRequestParameter('goodsname'));
//        print_r("<br>channelid:".$this->getRequestParameter('channelid'));
//        print_r("<br>sign:".$this->getRequestParameter('sign'));

        $sign = $this->getRequestParameter("sign");
        $transtat = $this->getRequestParameter("transtat");
        $amount = $this->getRequestParameter("amount");

        $c = new Criteria();
        $c->add(MlmDistEpointPurchasePeer::PG_SIGNATURE, $sign);
        $mlmDistEpointPurchase = MlmDistEpointPurchasePeer::doSelectOne($c);

        /*mysql_select_db('dfff_a', $con);
        mysql_query("SET CHARACTER SET UTF8");
        $sql = "SELECT *  FROM `cn` WHERE `amount` = '" . $amount . "' AND `sign` = '" . $sign . "' LIMIT 1";
        $rs = mysql_query($sql);
        $count = count($rs);
        if ($coun != 1) {
            die("Valid result!");
        } else {
            if ($transtat == '000') {
                die("OK");
            } else {
                die("Valid result!");
            }
        }*/
        if ($mlmDistEpointPurchase) {
            if ($transtat == '000') {
                $dist = MlmDistributorPeer::retrieveByPK($mlmDistEpointPurchase->getDistId());
                $companyEpoint = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
                $distEpoint = $this->getAccountBalance($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);

                $totalEpoint = $mlmDistEpointPurchase->getAmount();

                $mlmDistEpointPurchase->setPgSuccess("Y");
                $mlmDistEpointPurchase->setPgMsg("SUCCESS");
                $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_COMPLETE);
                $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mlmDistEpointPurchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                $mlmDistEpointPurchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));

                $mlmDistEpointPurchase->save();

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                $mlm_account_ledger->setRemark("EPOINT PURCHASE (" . $dist->getDistributorCode() . ")");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($totalEpoint);
                $mlm_account_ledger->setBalance($companyEpoint - $totalEpoint);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($dist->getDistributorId());
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                $mlm_account_ledger->setRemark("");
                $mlm_account_ledger->setCredit($totalEpoint);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distEpoint + $totalEpoint);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transaction Successful."));
                return $this->redirect('/member/epointPurchase?pg=Y');
            } else {
                $mlmDistEpointPurchase->setPgSuccess("N");
                $mlmDistEpointPurchase->setPgMsg("transtat not 000");
                $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_REJECT);
                $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mlmDistEpointPurchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                $mlmDistEpointPurchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mlmDistEpointPurchase->save();

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
                return $this->redirect('/member/epointPurchase');
            }
        } else {
            $mlmDistEpointPurchase->setPgSuccess("N");
            $mlmDistEpointPurchase->setPgMsg("Invalid Signature");
            $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_REJECT);
            $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
            $mlmDistEpointPurchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            $mlmDistEpointPurchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
            $mlmDistEpointPurchase->save();

            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/epointPurchase');
        }
        return sfView::HEADER_ONLY;
    }
    public function executeGozErrorRedirect() {
        return sfView::HEADER_ONLY;
    }

    public function executeEpointPurchaseGoz() {
        //var_dump(date("Ymd"));
        //exit();
        $this->setTemplate('epointPurchaseGoz');
    }
    public function executeEpointPurchase() {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        $this->toHideCp2Cp3Transfer = false;
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
        }
        $this->distDB = $distDB;

        $this->tradingCurrencyOnMT4 = "USD";
        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);

        $this->bankName = $this->getAppSetting(Globals::SETTING_BANK_NAME);
        $this->bankSwiftCode = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE);
        $this->iban = $this->getAppSetting(Globals::SETTING_IBAN);
        $this->bankAccountHolder = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER);
        $this->bankAccountNumber = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER);
        $this->cityOfBank = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK);
        $this->countryOfBank = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK);

        $this->bankName2 = $this->getAppSetting(Globals::SETTING_BANK_NAME_2);
        $this->bankSwiftCode2 = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE_2);
        $this->iban2 = $this->getAppSetting(Globals::SETTING_IBAN_2);
        $this->bankAccountHolder2 = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER_2);
        $this->bankAccountNumber2 = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER_2);
        $this->cityOfBank2 = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK_2);
        $this->countryOfBank2 = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK_2);
        $this->pg = $this->getRequestParameter('pg','N');

        if ($this->getRequestParameter('epointAmount') != "") {
            $amount = $this->getRequestParameter('epointAmount');
            //$currencyType = $this->getRequestParameter('currency_type');
            //$paymentReference = $this->generatePaymentReference();
            //$dispAmount = $amount * 7;
            $dispAmount = $amount;
            $paymentMethod = $this->getRequestParameter('paymentMethod', 'LB');

            if ($paymentMethod == "PG" && $amount > 50000) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Maximum Payment RMB 50,000 per transaction"));
                return $this->redirect('/member/epointPurchase');
            } else if ($paymentMethod == "GOZ" && $amount > 200000) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Maximum Payment RMB 200,000 per transaction"));
                return $this->redirect('/member/epointPurchase');
            }

            $mlmDistEpointPurchase = new MlmDistEpointPurchase();
            $mlmDistEpointPurchase->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $mlmDistEpointPurchase->setPaymentMethod($paymentMethod);
            $mlmDistEpointPurchase->setAmount($amount);
            $mlmDistEpointPurchase->setPaymentReference("");
            $mlmDistEpointPurchase->setTransactionType(Globals::PURCHASE_EPOINT_BANK_TRANSFER);
            $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_PENDING);
            $mlmDistEpointPurchase->setCurrencyType("USD");
            $mlmDistEpointPurchase->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlmDistEpointPurchase->save();

            $mlmDistEpointPurchase->setPaymentReference($mlmDistEpointPurchase->getPurchaseId());
            $mlmDistEpointPurchase->save();

            $paymentReference = $mlmDistEpointPurchase->getPaymentReference();

            if ($paymentMethod == "PG") {
                $this->billNo = $paymentReference;
                $this->amount = $dispAmount;
                $this->paymentDate = date('Ymd');
                $this->currencyType = "RMB";
                $this->gatewayType = "01";
                $this->lang = "GB";
                $this->attach = "";
                $this->dispAmount = $dispAmount;
                $this->orderEncodeType = "5";  // md5摘要
                $this->retEncodeType = "17"; // md5摘要
                $this->rettype = "1";  // 有Server to Server
                $this->merCode = Globals::PAYMENT_GATEWAY_MER_CODE;
                $this->merKey = Globals::PAYMENT_GATEWAY_MER_KEY;
                $this->test = "0";

                if (Globals::PAYMENT_GATEWAY_ENVIRONMENT == "DEV") {
                    $this->test = "1";
                    $this->merCode = "000015";
                    $this->merKey = "GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ";
                }

                $mlmDistEpointPurchase->setCurrencyType($this->currencyType);
                $mlmDistEpointPurchase->save();

                $this->setTemplate('epointPurchasePG');
            } else if ($paymentMethod == "GOZ") {
                $ver = "1.0";
                $merid = "100009";
                $orderid = $paymentReference;
                $amount = number_format($dispAmount,2);
                $orderdate = date("Ymd");
                $curtype = "RMB";
                $paytype = "01";
                $lang = "GB";
                $returnurl = "http://partner.maximtrader.com/member/gozSuccessRedirect";
                $errorurl = "http://partner.maximtrader.com/member/gozErrorRedirect";
                $remark = $distDB->getDistributorCode();
                $enctype = "1";
                $channelid = $this->getRequestParameter('channelid', "CMB");

                $this->ver = $ver;
                $this->merid = $merid;
                $this->orderid = $orderid;
                $this->amount = $amount;
                $this->orderdate = $orderdate;
                $this->curtype = $curtype;
                $this->paytype = $paytype;
                $this->lang = $lang;
                $this->returnurl = $returnurl;
                $this->errorurl = $errorurl;
                $this->remark = $remark;
                $this->enctype = $enctype;
                $this->channelid = $channelid;

                $md5Key = "88496625849445331821427993934397583101845496550535688096140279054296113998693043340961948795056633136331268949200793818235742794";
                $orge = 'ver='.$ver.'&merid='.$merid.'&orderid='.$orderid.'&amount='.$amount.'&orderdate='.$orderdate.'&curtype='.$curtype.'&paytype='.$paytype.'&lang='.$lang.'&returnurl='.$returnurl.'&errorurl='.$errorurl.'&remark1='.$remark.'&enctype='.$enctype.'&notifytype=2&urltype=1&s2surl='.$errorurl.'&goodsname=goods&channelid='.$channelid;
                  //echo  $orge;
                $this->SignMD5 = md5($orge.$md5Key) ;

                $mlmDistEpointPurchase->setCurrencyType($curtype);
                $mlmDistEpointPurchase->setPgMsg($orge);
                $mlmDistEpointPurchase->setPgBillNo($orderid);
                $mlmDistEpointPurchase->setPgRetEncodeType($channelid);
                $mlmDistEpointPurchase->setPgCurrencyType($curtype);
                $mlmDistEpointPurchase->setPgSignature($this->SignMD5);
                $mlmDistEpointPurchase->save();

                $this->setTemplate('epointPurchaseGoz');
            } else {
                $this->setFlash('purchaseId', $mlmDistEpointPurchase->getPurchaseId());
                $this->setFlash('amount', $mlmDistEpointPurchase->getCurrencyType() . " ". $amount);
                $this->setFlash('paymentReference', $paymentReference);
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your requests has been submitted, to complete the funding, please proceed to remit the payment to the account, with details as indicated below:"));
                return $this->redirect('/member/epointPurchase');
            }
        }
    }

    public function executePgRedirect() {
        $billno = $this->getRequestParameter('billno');
        $amount = $this->getRequestParameter('amount');
        $mydate = $this->getRequestParameter('date');
        $succ = $this->getRequestParameter('succ');
        $msg = $this->getRequestParameter('msg');
        $attach = $this->getRequestParameter('attach');
        $ipsbillno = $this->getRequestParameter('ipsbillno');
        $retEncodeType = $this->getRequestParameter('retencodetype');
        $currency_type = $this->getRequestParameter('Currency_type');
        $signature = $this->getRequestParameter('signature');

        $content = 'billno'.$billno.'currencytype'.$currency_type.'amount'.$amount.'date'.$mydate.'succ'.$succ.'ipsbillno'.$ipsbillno.'retencodetype'.$retEncodeType;
        //请在该字段中放置商户登陆merchant.ips.com.cn下载的证书
        $cert = Globals::PAYMENT_GATEWAY_MER_KEY;
        if (Globals::PAYMENT_GATEWAY_ENVIRONMENT == "DEV") {
            $cert = "GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ";
        }
        $signature_1ocal = md5($content . $cert);

        $c = new Criteria();
        $c->add(MlmDistEpointPurchasePeer::PAYMENT_REFERENCE, $billno);
        $mlmDistEpointPurchase = MlmDistEpointPurchasePeer::doSelectOne($c);
        //var_dump($ipsbillno);
        //var_dump($billno);
        //exit();
        if (!$mlmDistEpointPurchase) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/epointPurchase');
        }
        $mlmDistEpointPurchase->setPgBillNo($ipsbillno);
        $mlmDistEpointPurchase->setPgRetEncodeType($retEncodeType);
        $mlmDistEpointPurchase->setPgCurrencyType($currency_type);
        $mlmDistEpointPurchase->setPgSignature($signature);

        if ($signature_1ocal == $signature)
        {
            //----------------------------------------------------
            //  判断交易是否成功
            //  See the successful flag of this transaction
            //----------------------------------------------------
            if ($succ == 'Y')
            {
                $dist = MlmDistributorPeer::retrieveByPK($mlmDistEpointPurchase->getDistId());
                $companyEpoint = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);
                $distEpoint = $this->getAccountBalance($dist->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);

                $totalEpoint = $mlmDistEpointPurchase->getAmount() / 7;

                $mlmDistEpointPurchase->setPgSuccess("Y");
                $mlmDistEpointPurchase->setPgMsg($msg);
                $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_COMPLETE);
                $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mlmDistEpointPurchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                $mlmDistEpointPurchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));

                $mlmDistEpointPurchase->save();

                /*$mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                $mlm_account_ledger->setRemark("EPOINT PURCHASE (" . $dist->getDistributorCode() . ")");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($totalEpoint);
                $mlm_account_ledger->setBalance($companyEpoint - $totalEpoint);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();*/

                //$this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);

                /*$mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($dist->getDistributorId());
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_POINT_PURCHASE);
                $mlm_account_ledger->setRemark("FUND:".$mlmDistEpointPurchase->getAmount());
                $mlm_account_ledger->setCredit($totalEpoint);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distEpoint + $totalEpoint);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();*/

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transaction Successful."));
                return $this->redirect('/member/epointPurchase?pg=Y');
            } else {
                $mlmDistEpointPurchase->setPgSuccess("N");
                $mlmDistEpointPurchase->setPgMsg($msg);
                $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_REJECT);
                $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mlmDistEpointPurchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
                $mlmDistEpointPurchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $mlmDistEpointPurchase->save();

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
                return $this->redirect('/member/epointPurchase');
            }
        } else {
            $mlmDistEpointPurchase->setPgSuccess("N");
            $mlmDistEpointPurchase->setPgMsg("Invalid Signature");
            $mlmDistEpointPurchase->setStatusCode(Globals::STATUS_REJECT);
            $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID));
            $mlmDistEpointPurchase->setApproveRejectDatetime(date("Y/m/d h:i:s A"));
            $mlmDistEpointPurchase->setApprovedByUserid($this->getUser()->getAttribute(Globals::SESSION_USERID));
            $mlmDistEpointPurchase->save();

            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/epointPurchase');
        }
    }

    public function executeDoUploadFile() {
        if ($this->getRequest()->getFileName('bankPassBook') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $uploadedFilename = $this->getRequest()->getFileName('bankPassBook');
            $ext = explode(".", $this->getRequest()->getFileName('bankPassBook'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "bankPassBook_".date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('bankPassBook', sfConfig::get('sf_upload_dir') . '/bank_pass_book/' . $filename);

            $distDB->setFileBankPassBook($filename);
            $distDB->save();

            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Upload successful."));
        }
        if ($this->getRequest()->getFileName('proofOfResidence') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $uploadedFilename = $this->getRequest()->getFileName('proofOfResidence');
            $ext = explode(".", $this->getRequest()->getFileName('proofOfResidence'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "proofOfResidence_".date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('proofOfResidence', sfConfig::get('sf_upload_dir') . '/proof_of_residence/' . $filename);

            $distDB->setFileProofOfResidence($filename);
            $distDB->save();

            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Upload successful."));
        }
        if ($this->getRequest()->getFileName('nric') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $uploadedFilename = $this->getRequest()->getFileName('nric');
            $ext = explode(".", $this->getRequest()->getFileName('nric'));
            $extensionName = $ext[count($ext) - 1];

            $filename = "nric_".date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('nric', sfConfig::get('sf_upload_dir') . '/nric/' . $filename);

            $distDB->setFileNric($filename);
            $distDB->save();

            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Upload successful."));
        }
        if ($this->getRequestParameter('doAction', '') == "DEBIT_CARD") {
            return $this->redirect('/member/applyDebitCard');
        }
        if ($this->getRequestParameter('doAction', '') == "EZY_CASH_CARD") {
            return $this->redirect('/member/applyEzyCashCard');
        }
        return $this->redirect('/member/viewProfile');
    }

    public function executeUploadBankReceipt() {
        if ($this->getRequestParameter('purchaseId') != "" && $this->getRequest()->getFileName('bankSlip') != '') {
            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);
            $this->distDB = $distDB;

            $uploadedFilename = $this->getRequest()->getFileName('bankSlip');
            $ext = explode(".", $this->getRequest()->getFileName('bankSlip'));
            $extensionName = $ext[count($ext) - 1];

            $filename = date("Ymd")."_".$distDB->getDistributorCode()."_".rand(1000,9999).".".$extensionName;
            $this->getRequest()->moveFile('bankSlip', sfConfig::get('sf_upload_dir') . '/bankslip/' . $filename);

            $mlmDistEpointPurchase = MlmDistEpointPurchasePeer::retrieveByPK($this->getRequestParameter('purchaseId'));
            $mlmDistEpointPurchase->setImageSrc("http://".$_SERVER['HTTP_HOST']."/uploads/bankslip/".$filename);
            $mlmDistEpointPurchase->setBankId($this->getRequestParameter('bankId'));
            $mlmDistEpointPurchase->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

            $mlmDistEpointPurchase->save();

            $this->setFlash('banksuccessMsg', $this->getContext()->getI18N()->__("Bank receipt upload successful."));
            return $this->redirect('/member/epointPurchase');
        }
    }

    public function executeUpdateTermCondition() {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        $mlm_distributor->setTermCondition(Globals::YES);
        $mlm_distributor->save();
        return $this->redirect('/member/summary');
    }

    public function executeRegister()
    {
        $this->sponsorId = $this->getRequestParameter('id');

        $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 2));

        // Concatenate the random string onto the random numbers
        // The font 'Anorexia' doesn't have a character for '8', so the numbers will only go up to 7
        // '0' is left out to avoid confusion with 'O'
        $str = rand(1, 7) . rand(1, 7) . $char;
        $this->getUser()->setAttribute(Globals::SYSTEM_CAPTCHA_ID, $str);
    }

    public function executeMemberRegistration()
    {
        $c = new Criteria();
        $c->add(MlmPackagePeer::PUBLIC_PURCHASE, 1);
        $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
        $packageDBs = MlmPackagePeer::doSelect($c);

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->packageDBs = $packageDBs;

        // amz001 chales (20130113)
        if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 1458) {
            $this->cp2Available = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
            $this->cp3Available = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
            $this->setTemplate('memberRegistrationEx');
        }
    }
    public function executeMemberRegistration2()
    {
        //if ($this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('pid') <> "") {
        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        if ($this->getRequestParameter('pid') <> "") {
            /*$tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));
            if ($tbl_user->getUserpassword2() <> $this->getRequestParameter('transactionPassword')) {
                $this->setFlash('errorMsg', "Invalid Security password");
                return $this->redirect('/member/memberRegistration');
            }*/
            /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', "This function temporary out of service.");
                return $this->redirect('/member/memberRegistration');
            }*/

            $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

            $selectedPackage = MlmPackagePeer::retrieveByPK($this->getRequestParameter('pid'));
            if (!$selectedPackage) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action"));
                return $this->redirect('/member/summary');
            }

            $amountNeeded = $selectedPackage->getPrice();

            /*if ($selectedPackage->getPackageId() == Globals::MAX_PACKAGE_ID) {
                $amountNeeded = $this->getRequestParameter('specialPackagePrice');
            }*/
            if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 1458) {
                $ledgerCp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                $ledgerCp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);

                $this->cp2cp3PaymentMethod = $this->getRequestParameter('cp2cp3PaymentMethod');
                $this->cp2cp3Paid = $this->getRequestParameter('cp2cp3Paid');
                $this->cp1Paid = $this->getRequestParameter('cp1Paid');

                $maxCp2Cp3 = $amountNeeded / 2;
                if ($this->cp1Paid > $ledgerEPointBalance) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1 amount"));
                    return $this->redirect('/member/memberRegistration');
                }
                if ($this->cp2cp3PaymentMethod == "CP2") {
                    if ($this->cp2cp3Paid > $ledgerCp2Balance) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP2 amount"));
                        return $this->redirect('/member/memberRegistration');
                    }
                    if ($this->cp2cp3Paid > $maxCp2Cp3) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Exceed the maximum amount of cp2"));
                        return $this->redirect('/member/memberRegistration');
                    }
                } else if ($this->cp2cp3PaymentMethod == "CP3") {
                    if ($this->cp2cp3Paid > $ledgerCp3Balance) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP3 amount"));
                        return $this->redirect('/member/memberRegistration');
                    }
                    if ($this->cp2cp3Paid > $maxCp2Cp3) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Exceed the maximum amount of cp3"));
                        return $this->redirect('/member/memberRegistration');
                    }
                }
                $total = $this->cp2cp3Paid + $this->cp1Paid;
                if ($amountNeeded > $total) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient Fund"));
                    return $this->redirect('/member/memberRegistration');
                }
            } else {
                if ($amountNeeded > $ledgerEPointBalance) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1 amount"));
                    return $this->redirect('/member/memberRegistration');
                }
            }

            $this->selectedPackage = $selectedPackage;
            $this->amountNeeded = $amountNeeded;
            $this->productCode = $this->getRequestParameter('productCode');

            $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->distributor = $mlm_distributor;
            $this->sponsorId = $mlm_distributor->getDistributorCode();
            $this->sponsorName = $mlm_distributor->getFullName();
        } else {
            return $this->redirect('/member/memberRegistration');
        }
    }

    public function executeRegisterInfo()
    {
    }

    public function executeUpdateProfile()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        //$mlm_distributor->setNickname($this->getRequestParameter('nickName'));
        //$mlm_distributor->setFullName($this->getRequestParameter('fullname'));
        $mlm_distributor->setIc($this->getRequestParameter('ic'));
        if ($this->getRequestParameter('country') == 'China') {
            $mlm_distributor->setCountry('China (PRC)');
        } else {
            $mlm_distributor->setCountry($this->getRequestParameter('country'));
        }
        $mlm_distributor->setAddress($this->getRequestParameter('address'));
        $mlm_distributor->setAddress2($this->getRequestParameter('address2'));
        $mlm_distributor->setCity($this->getRequestParameter('city'));
        $mlm_distributor->setState($this->getRequestParameter('state'));
        $mlm_distributor->setPostcode($this->getRequestParameter('zip'));
        $mlm_distributor->setEmail($this->getRequestParameter('email'));
        $mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
        $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
        $mlm_distributor->setGender($this->getRequestParameter('gender'));
        if ($this->getRequestParameter('dob')) {
            list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
            $mlm_distributor->setDob("$y-$m-$d");
        }
        //$mlm_distributor->setBankName($this->getRequestParameter('bankName'));
        //$mlm_distributor->setBankAccNo($this->getRequestParameter('bankNo'));
        //$mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolder'));
        $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Profile update successfully"));

        return $this->redirect('/member/viewProfile');
    }

    public function executeUpdateBankInformation()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
        $mlm_distributor->setBankBranchName($this->getRequestParameter('bankBranchName'));
        $mlm_distributor->setBankAddress($this->getRequestParameter('bankAddress'));
        $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccNo'));
        $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));
        $mlm_distributor->setBankSwiftCode($this->getRequestParameter('bankSwiftCode'));
        $mlm_distributor->setVisaDebitCard($this->getRequestParameter('visaDebitCard'));
        $mlm_distributor->setEzyCashCard($this->getRequestParameter('ezyCashCard'));
        $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Bank Account Information update successfully"));

        //return $this->redirect('/member/viewBankInformation');
        return $this->redirect('/member/viewProfile');
    }
    public function executeUpdateMoneyTrac()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        $mlm_distributor->setMoneytracUsername($this->getRequestParameter('moneyTracUsername'));
        $mlm_distributor->setMoneytracCustomerId($this->getRequestParameter('moneyTracCustomerId'));
        $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $mlm_distributor->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Money Trac Information update successfully"));

        //return $this->redirect('/member/viewBankInformation');
        return $this->redirect('/member/viewProfile');
    }

    public function executeUpdateBeneficiary()
    {
        $mlm_distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($mlm_distributor);

        $mlm_distributor->setNomineeName($this->getRequestParameter('nomineeName'));
        $mlm_distributor->setNomineeIc($this->getRequestParameter('nomineeIc'));
        $mlm_distributor->setNomineeRelationship($this->getRequestParameter('nomineeRelationship'));
        $mlm_distributor->setNomineeContactno($this->getRequestParameter('nomineeContactNo'));
        $mlm_distributor->save();

        $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Beneficiary update successfully"));

        //return $this->redirect('/member/viewBankInformation');
        return $this->redirect('/member/viewProfile');
    }

    public function executeDoRegister()
    {
        /*require_once('recaptchalib.php');
        $privatekey = "6LfhJtYSAAAAALocUxn6PpgfoWCFjRquNFOSRFdb";
        $resp = recaptcha_check_answer ($privatekey,
                                    $_SERVER["REMOTE_ADDR"],
                                    $_POST["recaptcha_challenge_field"],
                                    $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {
            $this->setFlash('errorMsg', "The CAPTCHA wasn't entered correctly. Go back and try it again.");
            return $this->redirect('/home/login');
        }*/

        if (strtoupper($this->getRequestParameter('captcha')) == $this->getUser()->getAttribute(Globals::SYSTEM_CAPTCHA_ID)){
    	} else{
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("The CAPTCHA wasn't entered correctly. Go back and try it again."));
            return $this->redirect('/member/register');
    	}
        $userName = $this->getRequestParameter('userName');
        $fcode = $userName;
        //$fcode = $this->generateFcode($this->getRequestParameter('country'));
        $password = $this->getRequestParameter('userpassword');
        $password2 = $this->getRequestParameter('securityPassword');

        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $userName);
        $exist = AppUserPeer::doSelectOne($c);

        if ($exist) {
            $this->setFlash('errorMsg', "User Name already exist.");
            return $this->redirect('/member/register');
        }
        //******************* upline distributor ID
        $con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
        try {
            $con->begin();
            //******************* upline distributor ID
            $uplineDistCode = $this->getRequestParameter('sponsorId');

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
            //$c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%", Criteria::LIKE);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

            if (!$uplineDistDB) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Referrer ID."));
                return $this->redirect('/member/register');
            }

            $uplineDistId = $uplineDistDB->getDistributorId();

            $treeLevel = $uplineDistDB->getTreeLevel() + 1;

            $app_user = new AppUser();
            $app_user->setUsername($userName);
            $app_user->setKeepPassword($password);
            $app_user->setUserpassword($password);
            $app_user->setKeepPassword2($password2);
            $app_user->setUserpassword2($password2);
            $app_user->setUserRole(Globals::ROLE_DISTRIBUTOR);
            $app_user->setStatusCode(Globals::STATUS_PENDING);
            $app_user->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $app_user->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $app_user->save();

            // ****************************
            $mlm_distributor = new MlmDistributor();
            $mlm_distributor->setDistributorCode($fcode);
            $mlm_distributor->setUserId($app_user->getUserId());
            $mlm_distributor->setStatusCode(Globals::STATUS_PENDING);
            $mlm_distributor->setFullName($this->getRequestParameter('fullname'));
            $mlm_distributor->setNickname($fcode);
            $mlm_distributor->setIc($this->getRequestParameter('ic'));
            if ($this->getRequestParameter('country') == 'China') {
                $mlm_distributor->setCountry('China (PRC)');
            } else {
                $mlm_distributor->setCountry($this->getRequestParameter('country'));
            }
            $mlm_distributor->setAddress($this->getRequestParameter('address'));
            $mlm_distributor->setAddress2($this->getRequestParameter('address2'));
            $mlm_distributor->setCity($this->getRequestParameter('city'));
            $mlm_distributor->setState($this->getRequestParameter('state'));
            $mlm_distributor->setPostcode($this->getRequestParameter('zip'));
            $mlm_distributor->setEmail($this->getRequestParameter('email'));
            $mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
            $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
            $mlm_distributor->setGender($this->getRequestParameter('gender'));
            if ($this->getRequestParameter('dob')) {
                list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
                $mlm_distributor->setDob("$y-$m-$d");
            }
            $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
            $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccountNo'));
            $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));

            $mlm_distributor->setTreeLevel($treeLevel);
            $mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
            $mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());

            $mlm_distributor->setLeverage($this->getRequestParameter('leverage'));
            $mlm_distributor->setSpread($this->getRequestParameter('spread'));
            $mlm_distributor->setDepositCurrency($this->getRequestParameter('deposit_currency'));
            $mlm_distributor->setDepositAmount($this->getRequestParameter('deposit_amount'));
            $mlm_distributor->setSignName($this->getRequestParameter('sign_name'));
            $mlm_distributor->setSignDate(date("Y/m/d h:i:s A"));
            $mlm_distributor->setTermCondition($this->getRequestParameter('term_condition'));
            $mlm_distributor->setSelfRegister("Y");

            $mlm_distributor->setNomineeName($this->getRequestParameter('nomineeName'));
            $mlm_distributor->setNomineeIc($this->getRequestParameter('nomineeIc'));
            $mlm_distributor->setNomineeRelationship($this->getRequestParameter('nomineeRelationship'));
            $mlm_distributor->setNomineeContactno($this->getRequestParameter('nomineeContactNo'));

            if ($this->getRequestParameter('productCode') == "fxgold") {
                $mlm_distributor->setProductMte("Y");
            }
            if ($this->getRequestParameter('productCode') == "mte") {
                $mlm_distributor->setProductFxgold("Y");
            }

            $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_distributor->save();

            $treeStructure = $uplineDistDB->getTreeStructure() . "|" . $mlm_distributor->getDistributorId() . "|";
            $mlm_distributor->setTreeStructure($treeStructure);
            $mlm_distributor->save();
            /****************************/
            /*****  Send email **********/
            /****************************/
            $receiverEmail = $this->getRequestParameter('email', $mlm_distributor->getEmail());
            $receiverFullname = $this->getRequestParameter('fullname', $mlm_distributor->getFullName());
            $subject = "Maxim Trader - Thank You for Your Registration";

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
												<table border='0' cellspacing='0' cellpadding='0' style='width:440.0pt;border-collapse:collapse'>
                                        <tbody>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Member ID<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$userName."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Password<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$password."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Security Password<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$password2."<u></u><u></u></span>
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Member ID<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$fcode."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Full Name(As In IC)<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$receiverFullname."<u></u><u></u></span>
                                                </p></td>
                                        </tr>

                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Email<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'><a
                                                        href='mailto:".$mlm_distributor->getEmail()."'
                                                        target='_blank'>".$this->getRequestParameter('email', $mlm_distributor->getEmail())."</a><u></u><u></u></span></p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Mobile Number<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$this->getRequestParameter('contactNumber', $mlm_distributor->getContact())."<u></u><u></u></span>
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Country<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$this->getRequestParameter('country', $mlm_distributor->getCountry())."<u></u><u></u></span>
                                                </p></td>
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜金融集团是Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子公司。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
            $sendMailService->sendMail($receiverEmail, $receiverFullname, $subject, $body);

            $con->commit();
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your Username is")." ".$userName);
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        //$this->getUser()->setAttribute(Globals::SESSION_USERNAME, $fcode);

        /****************************/
        /*****  Send email **********/
        /****************************/
        /*error_reporting(E_STRICT);

        date_default_timezone_set(date_default_timezone_get());

        include_once('class.phpmailer.php');

        $subject = $this->getContext()->getI18N()->__("Vital Universe Group Registration email notification", null, 'email');
        $body = $this->getContext()->getI18N()->__("Dear %1%", array('%1%' => $mlm_distributor->getNickname()), 'email') . ",<p><p>

        <p>" . $this->getContext()->getI18N()->__("Your registration request has been successfully sent to Vital Universe Group", null, 'email') . "</p>
        <p><b>" . $this->getContext()->getI18N()->__("Member ID", null) . ": " . $fcode . "</b>
        <p><b>" . $this->getContext()->getI18N()->__("Password", null) . ": " . $password . "</b>";

        $mail = new PHPMailer();
        $mail->IsMail(); // telling the class to use SMTP
        $mail->Host = Mails::EMAIL_HOST; // SMTP server
        $mail->Sender = Mails::EMAIL_FROM_NOREPLY;
        $mail->From = Mails::EMAIL_FROM_NOREPLY;
        $mail->FromName = Mails::EMAIL_FROM_NOREPLY_NAME;
        $mail->Subject = $subject;
        $mail->CharSet="utf-8";

        $text_body = $body;

        $mail->Body = $body;
        $mail->AltBody = $text_body;
        $mail->AddAddress($mlm_distributor->getEmail(), $mlm_distributor->getNickname());
        $mail->AddBCC("r9projecthost@gmail.com", "jason");

        if (!$mail->Send()) {                                                                                                               r
            echo $mail->ErrorInfo;
        }*/
        return $this->redirect('/member/registerInfo');
    }

    public function executeDoMemberRegistration()
    {
        $dateUtil = new DateUtil();
        /*if ($dateUtil->checkDateIsWithinRange(date("Y-m-d").' 00:00:00', date("Y-m-d").' 01:00:00', date("Y-m-d G:i:s"))) {
            return $this->redirect('home/maintenance');
        }*/

        /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
        if ($pos === false) { // note: three equal signs

        } else {
            $this->setFlash('errorMsg', "This function temporary out of service.");
            return $this->redirect('/member/memberRegistration');
        }*/

        $userName = $this->getRequestParameter('userName','');
        //$fcode = $this->generateFcode($this->getRequestParameter('country'));
        if ($userName == '') {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/memberRegistration');
        }

        $fcode = $userName;
        $password = $this->getRequestParameter('userpassword');
        $password2 = $this->getRequestParameter('securityPassword');
        $packageId = $this->getRequestParameter('packageId');
        $position = $this->getRequestParameter('position1');
        $amountNeeded = $this->getRequestParameter('amountNeeded');
        $doAction = $this->getRequestParameter('doAction', '');
        /* ****************************************************
         * get distributor last account ledger epoint balance
         * ***************************************************/
        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $userName);
        $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID), Criteria::NOT_EQUAL);
        $exist = AppUserPeer::doSelectOne($c);

        //var_dump($userName);
        //var_dump($this->getUser()->getAttribute(Globals::SESSION_USERID));
        //exit();
        if ($exist) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("User Name already exist."));
            return $this->redirect('/member/memberRegistration');
        }

        $packageDB = MlmPackagePeer::retrieveByPK($packageId);

        if (!$packageDB) {
            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Action."));
            return $this->redirect('/member/memberRegistration');
        }

        $applicationPackageName = $packageDB->getPackageName();
        $packagePrice = $packageDB->getPrice();

        $sponsorAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

        if ($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $this->getUser()->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

        } else {
            if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 1458) {
                $ledgerCp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                $ledgerCp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);

                $this->cp2cp3PaymentMethod = $this->getRequestParameter('cp2cp3PaymentMethod');
                $this->cp2cp3Paid = $this->getRequestParameter('cp2cp3Paid');
                $this->cp1Paid = $this->getRequestParameter('cp1Paid');

                $maxCp2Cp3 = $amountNeeded / 2;
                if ($this->cp1Paid > $sponsorAccountBalance) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1 amount"));
                    return $this->redirect('/member/memberRegistration');
                }
                if ($this->cp2cp3PaymentMethod == "CP2") {
                    if ($this->cp2cp3Paid > $ledgerCp2Balance) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP2 amount"));
                        return $this->redirect('/member/memberRegistration');
                    }
                    if ($this->cp2cp3Paid > $maxCp2Cp3) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Exceed the maximum amount of cp2"));
                        return $this->redirect('/member/memberRegistration');
                    }
                } else if ($this->cp2cp3PaymentMethod == "CP3") {
                    if ($this->cp2cp3Paid > $ledgerCp3Balance) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP3 amount"));
                        return $this->redirect('/member/memberRegistration');
                    }
                    if ($this->cp2cp3Paid > $maxCp2Cp3) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Exceed the maximum amount of cp3"));
                        return $this->redirect('/member/memberRegistration');
                    }
                }
                $total = $this->cp2cp3Paid + $this->cp1Paid;
                if ($amountNeeded > $total) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient Fund"));
                    return $this->redirect('/member/memberRegistration');
                }
            } else {
                if ($packagePrice > $sponsorAccountBalance) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient fund to purchase package."));
                    return $this->redirect('/member/memberRegistration');
                }
            }
        }

        $con = Propel::getConnection(MlmDistributorPeer::DATABASE_NAME);
        try {
            $con->begin();
            //******************* upline distributor ID

            $app_user = new AppUser();
            $mlm_distributor = new MlmDistributor();
            $uplineDistDB = new MlmDistributor();
            $uplineDistId = 0;
            if ($doAction == "PENDING_MEMBER") {
                $app_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));
                $app_user->setStatusCode(Globals::STATUS_ACTIVE);
                $app_user->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $app_user->save();

                $userName = $app_user->getUsername();
                $password = $app_user->getUserpassword();
                $password2 = $app_user->getUserpassword2();
                $mlm_distributor = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

                $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getUplineDistId());
                $uplineDistId = $uplineDistDB->getDistributorId();

                $mlm_distributor->setRankId($packageDB->getPackageId());
                $mlm_distributor->setRankCode($packageDB->getPackageName());
                $mlm_distributor->setInitRankId($packageDB->getPackageId());
                $mlm_distributor->setInitRankCode($packageDB->getPackageName());
                $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_distributor->setPackagePurchaseFlag("Y");
                $mlm_distributor->setActiveDatetime(date("Y/m/d h:i:s A"));
                $mlm_distributor->setActivatedBy($this->getUser()->getAttribute(Globals::SESSION_DISTID));

                if ($this->getRequestParameter('productCode') == "fxgold") {
                    $mlm_distributor->setProductMte("Y");
                }
                if ($this->getRequestParameter('productCode') == "mte") {
                    $mlm_distributor->setProductFxgold("Y");
                }
                $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_distributor->save();
            } else {
                $uplineDistCode = $this->getRequestParameter('sponsorId');

                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
                $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%", Criteria::LIKE);
                $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

                if (!$uplineDistDB) {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Referrer ID."));
                    return $this->redirect('/member/memberRegistration');
                }

                $uplineDistId = $uplineDistDB->getDistributorId();
                $treeLevel = $uplineDistDB->getTreeLevel() + 1;

                $app_user->setUsername($userName);
                $app_user->setKeepPassword($password);
                $app_user->setUserpassword($password);
                $app_user->setKeepPassword2($password2);
                $app_user->setUserpassword2($password2);
                $app_user->setUserRole(Globals::ROLE_DISTRIBUTOR);
                $app_user->setStatusCode(Globals::STATUS_ACTIVE);
                $app_user->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $app_user->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $app_user->save();


                $mlm_distributor->setDistributorCode($fcode);
                $mlm_distributor->setUserId($app_user->getUserId());
                $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
                $mlm_distributor->setFullName($this->getRequestParameter('fullname'));
                $mlm_distributor->setNickname($userName);
                $mlm_distributor->setIc($this->getRequestParameter('ic'));
                if ($this->getRequestParameter('country') == 'China') {
                    $mlm_distributor->setCountry('China (PRC)');
                } else {
                    $mlm_distributor->setCountry($this->getRequestParameter('country'));
                }
                $mlm_distributor->setAddress($this->getRequestParameter('address'));
                $mlm_distributor->setAddress2($this->getRequestParameter('address2'));
                $mlm_distributor->setCity($this->getRequestParameter('city'));
                $mlm_distributor->setState($this->getRequestParameter('state'));
                $mlm_distributor->setPostcode($this->getRequestParameter('zip'));
                $mlm_distributor->setEmail($this->getRequestParameter('email'));
                $mlm_distributor->setAlternateEmail($this->getRequestParameter('alt_email'));
                $mlm_distributor->setContact($this->getRequestParameter('contactNumber'));
                $mlm_distributor->setGender($this->getRequestParameter('gender'));
                if ($this->getRequestParameter('dob')) {
                    list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('dob'), $this->getUser()->getCulture());
                    $mlm_distributor->setDob("$y-$m-$d");
                }
                $mlm_distributor->setBankName($this->getRequestParameter('bankName'));
                $mlm_distributor->setBankAccNo($this->getRequestParameter('bankAccountNo'));
                $mlm_distributor->setBankHolderName($this->getRequestParameter('bankHolderName'));

                $mlm_distributor->setTreeLevel($treeLevel);
                $mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
                $mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());

                $mlm_distributor->setLeverage($this->getRequestParameter('leverage'));
                $mlm_distributor->setSpread($this->getRequestParameter('spread'));
                $mlm_distributor->setDepositCurrency($this->getRequestParameter('deposit_currency'));
                $mlm_distributor->setDepositAmount($this->getRequestParameter('deposit_amount'));
                $mlm_distributor->setSignName($this->getRequestParameter('sign_name'));
                $mlm_distributor->setSignDate(date("Y/m/d h:i:s A"));
                $mlm_distributor->setTermCondition($this->getRequestParameter('term_condition'));

                $mlm_distributor->setRankId($packageDB->getPackageId());
                $mlm_distributor->setRankCode($packageDB->getPackageName());
                $mlm_distributor->setInitRankId($packageDB->getPackageId());
                $mlm_distributor->setInitRankCode($packageDB->getPackageName());
                $mlm_distributor->setStatusCode(Globals::STATUS_ACTIVE);
                if ($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $this->getUser()->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {
                    $mlm_distributor->setPackagePurchaseFlag("N");
                    $mlm_distributor->setRemark("loan account");
                    //$mlm_distributor->setRemark("loan account, Bandung Case (Steven)");
                    $mlm_distributor->setLoanAccount("Y");
                    $mlm_distributor->setHideGenealogy("N");

                    //$mlm_distributor->setDebitRankId(1);
                    //$mlm_distributor->setPackagePurchaseFlag("Y");
                    //$mlm_distributor->setDebitStatusCode(Globals::STATUS_COMPLETE);
                } else {
                    $mlm_distributor->setPackagePurchaseFlag("Y");
                }
                $mlm_distributor->setActiveDatetime(date("Y/m/d h:i:s A"));
                $mlm_distributor->setActivatedBy($this->getUser()->getAttribute(Globals::SESSION_DISTID));

                if ($this->getRequestParameter('productCode') == "fxgold") {
                    $mlm_distributor->setProductMte("Y");
                }
                if ($this->getRequestParameter('productCode') == "mte") {
                    $mlm_distributor->setProductFxgold("Y");
                }

                $mlm_distributor->setNomineeName($this->getRequestParameter('nomineeName'));
                $mlm_distributor->setNomineeIc($this->getRequestParameter('nomineeIc'));
                $mlm_distributor->setNomineeRelationship($this->getRequestParameter('nomineeRelationship'));
                $mlm_distributor->setNomineeContactno($this->getRequestParameter('nomineeContactNo'));

                $mlm_distributor->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_distributor->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_distributor->save();

                $treeStructure = $uplineDistDB->getTreeStructure() . "|" . $mlm_distributor->getDistributorId() . "|";
                $mlm_distributor->setTreeStructure($treeStructure);
                $mlm_distributor->save();

            }

            // create mlm_dist_pairing
            $sponsorDistPairingDB = MlmDistPairingPeer::retrieveByPK($mlm_distributor->getDistributorId());
            if (!$sponsorDistPairingDB) {
                $sponsorDistPairingDB = new MlmDistPairing();
                $sponsorDistPairingDB->setDistId($mlm_distributor->getDistributorId());
                $sponsorDistPairingDB->setLeftBalance(0);
                $sponsorDistPairingDB->setRightBalance(0);
                $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            }
            //var_dump($packagePrice);
            //exit();
            $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
            $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $sponsorDistPairingDB->save();
            /* ****************************************************
             * ROI Divident
             * ***************************************************/
            /*$dateUtil = new DateUtil();
            $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d")) . " 00:00:00";
            $currentDate_timestamp = strtotime($currentDate);
            //$dividendDate = $dateUtil->addDate($currentDate, 30, 0, 0);
            $dividendDate = strtotime("+1 months", $currentDate_timestamp);

            $mlm_roi_dividend = new MlmRoiDividend();
            $mlm_roi_dividend->setDistId($mlm_distributor->getDistributorId());
            $mlm_roi_dividend->setIdx(1);
            //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
            $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
            $mlm_roi_dividend->setFirstDividendDate(date("Y-m-d h:i:s", $dividendDate));
            $mlm_roi_dividend->setPackageId($packageDB->getPackageId());
            $mlm_roi_dividend->setPackagePrice($packagePrice);
            $mlm_roi_dividend->setRoiPercentage($packageDB->getMonthlyPerformance());
            //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
            //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
            $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
            $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_roi_dividend->save();*/

            $sponsorId = $mlm_distributor->getDistributorId();
            /**************************************/
            /*  Direct REFERRER Bonus For Upline
            /**************************************/
            if ($uplineDistDB->getIsIb() == Globals::YES) {
                $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                $directSponsorBonusAmount = $directSponsorPercentage * $packagePrice / 100;
            } else {
                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                $directSponsorPercentage = $uplineDistPackage->getCommission();
                $directSponsorBonusAmount = $directSponsorPercentage * $packagePrice / 100;
            }
            $totalBonusPayOut = $directSponsorPercentage;

            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_ECASH, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");
            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_EPOINT, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");
            /* ****************************************************
             * Update upline distributor account
             * ***************************************************/
            $bonusService = new BonusService();

            if ($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $this->getUser()->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

            } else {
                if ($this->getUser()->getAttribute(Globals::SESSION_LEADER_ID) == 1458) {
                    $ledgerCp2Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                    $ledgerCp3Balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);

                    $this->cp2cp3PaymentMethod = $this->getRequestParameter('cp2cp3PaymentMethod');
                    $this->cp2cp3Paid = $this->getRequestParameter('cp2cp3Paid');
                    $this->cp1Paid = $this->getRequestParameter('cp1Paid');

                    if ($this->cp2cp3Paid > 0) {
                        $accountType = "";
                        $accountTypeDesc = "";
                        $accountTypeBalance = 0;
                        if ($this->cp2cp3PaymentMethod == "CP2") {
                            $accountType = Globals::ACCOUNT_TYPE_ECASH;
                            $accountTypeBalance = $ledgerCp2Balance;
                            $accountTypeDesc = "CP2";
                        } else if ($this->cp2cp3PaymentMethod == "CP3") {
                            $accountType = Globals::ACCOUNT_TYPE_MAINTENANCE;
                            $accountTypeBalance = $ledgerCp3Balance;
                            $accountTypeDesc = "CP3";
                        }

                        if ($accountType != "") {
                            $mlm_account_ledger = new MlmAccountLedger();
                            $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                            $mlm_account_ledger->setAccountType($accountType);
                            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
                            $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") - ".$mlm_distributor->getDistributorCode().", ".$accountTypeDesc.":".$this->cp2cp3Paid.", CP1:".$this->cp1Paid);
                            $mlm_account_ledger->setCredit(0);
                            $mlm_account_ledger->setDebit($this->cp2cp3Paid);
                            $mlm_account_ledger->setBalance($accountTypeBalance - $this->cp2cp3Paid);
                            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->save();
                        }
                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
                        $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") - ".$mlm_distributor->getDistributorCode().", ".$accountType.":".$this->cp2cp3Paid.", CP1:".$this->cp1Paid);
                        $mlm_account_ledger->setCredit(0);
                        $mlm_account_ledger->setDebit($this->cp1Paid);
                        $mlm_account_ledger->setBalance($sponsorAccountBalance - $this->cp1Paid);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();
                    }

                } else {
                    $sponsorAccountBalance = $sponsorAccountBalance - $packagePrice;

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
                    $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") - ".$mlm_distributor->getDistributorCode());
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($packagePrice);
                    $mlm_account_ledger->setBalance($sponsorAccountBalance);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
                }

                /******************************/
                /*  Direct Sponsor Bonus
                /******************************/
                $firstForDRB = true;
                while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                    $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($uplineDistId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                    $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $mlm_distributor->getDistributorCode() . ")");
                    $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    if ($bonusService->checkDebitAccount($uplineDistId) == true) {
                        $debitAccountRemark = "PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $mlm_distributor->getDistributorCode() . ")";
                        $bonusService->contraDebitAccount($uplineDistId, $debitAccountRemark, $directSponsorBonusAmount);
                    }
                    //var_dump($bonusService->checkDebitAccount($uplineDistId));
                    //exit();
                    $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                    /******************************/
                    /*  Commission
                    /******************************/
                    $c = new Criteria();
                    $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                    $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                    $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                    $commissionBalance = 0;
                    if (!$sponsorDistCommissionDB) {
                        $sponsorDistCommissionDB = new MlmDistCommission();
                        $sponsorDistCommissionDB->setDistId($uplineDistId);
                        $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                        $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    } else {
                        $commissionBalance = $sponsorDistCommissionDB->getBalance();
                    }
                    $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                    $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionDB->save();

                    $c = new Criteria();
                    $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                    $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                    $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                    $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                    $dsbBalance = 0;
                    if ($sponsorDistCommissionLedgerDB)
                        $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                    $sponsorDistCommissionledger->setDistId($uplineDistId);
                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_REGISTER);
                    $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                    $sponsorDistCommissionledger->setDebit(0);
                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                    $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                    if ($firstForDRB == true) {
                        $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                        $firstForDRB = false;
                    } else {
                        $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$mlm_distributor->getDistributorCode());
                    }
                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionledger->save();

                    $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                    //var_dump("==>1");
                    //var_dump("totalBonusPayOut=".$totalBonusPayOut);
                    if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT && $uplineDistDB) {
                        //var_dump("==>2");
                        $checkCommission = true;
                        $uplineDistId = $uplineDistDB->getUplineDistId();
                        while ($checkCommission == true) {
                            //var_dump("==>3**".$uplineDistId);
                            $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                            //var_dump("==>3$$".$uplineDistId);
                            if (!$uplineDistDB) {
                                break;
                            }

                            if ($uplineDistDB->getIsIb() == Globals::YES) {
                                /*if ($uplineDistDB->getIbRankId() != null) {
                                    $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                                } else {
                                    $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                }*/
                                $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                            } else {
                                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                $directSponsorPercentage = $uplineDistPackage->getCommission();
                            }
                            if ($directSponsorPercentage > $totalBonusPayOut) {
                                //var_dump("==>6");
                                $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                                $totalBonusPayOut += $directSponsorPercentage;
                                if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                    //var_dump("==>7");
                                    $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                                }
                            } else {
                                //var_dump("==>8");
                                $uplineDistId = $uplineDistDB->getUplineDistId();
                                continue;
                            }

                            $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
                            $checkCommission == false;
                            break;
                            //var_dump("==>9");
                        }
                    } else {
                        break;
                        //var_dump("==>^^");
                    }
                }
            }
            $distributor = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

            /*if ($doAction == "PENDING_MEMBER" && $distributor->getPlacementTreeStructure() != null) {
                if ($distributor->getTreeUplineDistId() != 0 && $distributor->getTreeUplineDistCode() != null) {
                    $fcode = $distributor->getDistributorCode();
                    $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($distributor->getRankId());
                    $pairingPoint = $sponsoredPackageDB->getPrice();
                    $uplinePosition = $distributor->getPlacementPosition();
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($distributor->getTreeUplineDistId());
                    $sponsoredDistributorCode = $distributor->getDistributorCode();
                    while ($level < 200) {
                        //var_dump($uplineDistDB->getUplineDistId());
                        //var_dump($uplineDistDB->getUplineDistCode());
                        print_r("<br>");
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
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                return $this->redirect('/member/memberRegistration');
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
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
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
                }
            } else*/
            if ($doAction == "PENDING_MEMBER" || $distributor->getPlacementTreeStructure() == null) {

            } else {
                // **********************************************************************************************
                // *****************************         tree placement          **********************
                // **********************************************************************************************
                $uplineDistCode = $this->getRequestParameter('uplineDistCode');
                $treePosition = $this->getRequestParameter('treePosition');
                $placementType = $this->getRequestParameter('placementType'); // 1 = auto, 0 = manual
                $placementDistCode = $this->getRequestParameter('placementDistId'); // 1 = auto, 0 = manual

                if ($position == 1 || $position == 2 || $treePosition != "") {
                    $uplinePosition = "";

                    if ($treePosition != "") {
                        if ($treePosition == "left") {
                            $uplinePosition = Globals::PLACEMENT_LEFT;
                        } else if ($treePosition == "right") {
                            $uplinePosition = Globals::PLACEMENT_RIGHT;
                        }
                    } else {
                        if ($position == 1) {
                            $uplinePosition = Globals::PLACEMENT_LEFT;
                        } else if ($position == 2) {
                            $uplinePosition = Globals::PLACEMENT_RIGHT;
                        }
                    }

                    $placementSuccessful = false;

                    if ($uplineDistCode != "") {
                        $c = new Criteria();
                        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
                        $uplineDistDB = MlmDistributorPeer::doSelectOne($c);
                    } else {
                        if ($placementType == 0) {
                            $c = new Criteria();
                            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $placementDistCode);
                            $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

                            $uplineDistId = $uplineDistDB->getDistributorId();
                        } else {
                            if ($doAction == "PENDING_MEMBER") {
                                $c = new Criteria();
                                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('placementDistId'));
                                $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

                                $uplineDistId = $uplineDistDB->getDistributorId();
                            } else {
                                $uplineDistCode = $this->getRequestParameter('sponsorId', $this->getUser()->getAttribute(Globals::SESSION_DISTCODE));
                                $c = new Criteria();
                                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $uplineDistCode);
                                $uplineDistDB = MlmDistributorPeer::doSelectOne($c);

                                $uplineDistId = $uplineDistDB->getDistributorId();
                            }
                        }

                        while ($placementSuccessful == false) {
                            if ($placementSuccessful == true)
                                break;
                            //var_dump("uplineDistId=".$uplineDistId);
                            $c = new Criteria();
                            $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, $uplineDistId);
                            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
                            $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $uplinePosition);
                            $downlineDistDB = MlmDistributorPeer::doSelectOne($c);

                            if ($downlineDistDB) {
                                $uplineDistId = $downlineDistDB->getDistributorId();
                            } else {
                                //var_dump("====NO===".$uplineDistId);
                                $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistId);

                                //var_dump($uplineDistDB);
                                $placementSuccessful = true;
                                break;
                            }
                        }
                    }
                    //var_dump("result:::".$uplineDistId);
                    //var_dump($uplineDistDB);
                    //exit();
                    $treeStructure = $uplineDistDB->getPlacementTreeStructure() . "|" . $mlm_distributor->getDistributorId() . "|";
                    $treeLevel = $uplineDistDB->getPlacementTreeLevel() + 1;
                    $mlm_distributor->setPlacementDatetime(date("Y/m/d h:i:s A"));
                    $mlm_distributor->setPlacementPosition($uplinePosition);
                    //$mlm_distributor->setUplineDistId($uplineDistDB->getDistributorId());
                    //$mlm_distributor->setUplineDistCode($uplineDistDB->getDistributorCode());
                    $mlm_distributor->setPlacementTreeStructure($treeStructure);
                    $mlm_distributor->setPlacementTreeLevel($treeLevel);
                    $mlm_distributor->setTreeUplineDistId($uplineDistDB->getDistributorId());
                    $mlm_distributor->setTreeUplineDistCode($uplineDistDB->getDistributorCode());

                    // requested by andrew lim
                    $pos = strrpos($mlm_distributor->getPlacementTreeStructure(), "|256175|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $mlm_distributor->setHideGenealogy("N");
                    }
                    $pos = strrpos($mlm_distributor->getPlacementTreeStructure(), "|256258|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $mlm_distributor->setHideGenealogy("N");
                    }
                    $pos = strrpos($mlm_distributor->getPlacementTreeStructure(), "|256170|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $mlm_distributor->setHideGenealogy("N");
                    }

                    $mlm_distributor->save();

                    $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($mlm_distributor->getRankId());
                    if (!$sponsoredPackageDB) {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Package selected."));
                        return $this->redirect('/member/memberRegistration');
                    }

                    $pairingPoint = $sponsoredPackageDB->getPrice();
                    //$sponsoredPackageDB = MlmPackagePeer::retrieveByPK($mlm_distributor->getRankId());
                    /*if ($sponsoredPackageDB->getPackageId() == Globals::MAX_PACKAGE_ID) {
                        $pairingPoint = $amountNeeded;
                    }*/

                    // recalculate Total left and total right for $uplineDistDB
                    //var_dump("===========");
                    /*$arrs = explode("|", $uplineDistDB->getPlacementTreeStructure());
                    for ($x = count($arrs); $x > 0; $x--) {
                        if ($arrs[$x] == "") {
                            continue;
                        }
                        //var_dump("+++".$arrs[$x]);
                        $uplineDistDB = MlmDistributorPeer::retrieveByPK($arrs[$x]);
                        if ($uplineDistDB) {
                            $totalLeft = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_LEFT);
                            $totalRight = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_RIGHT);
                            $uplineDistDB->setTotalLeft($totalLeft);
                            $uplineDistDB->setTotalRight($totalRight);
                            $uplineDistDB->save();
                        }
                    }*/

                    /******************************/
                    /*  store Pairing points
                    /******************************/
                    //var_dump("===========");
                    if ($this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $this->getUser()->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

                    } else {
                        if ($mlm_distributor->getTreeUplineDistId() != 0 && $mlm_distributor->getTreeUplineDistCode() != null) {
                            $level = 0;
                            $uplineDistDB = MlmDistributorPeer::retrieveByPk($mlm_distributor->getTreeUplineDistId());
                            $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();
                            while ($level < 400) {
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
                                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                        return $this->redirect('/member/memberRegistration');
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
                                $sponsorDistPairingledger->setDebit(0);
                                $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                                $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
                                $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistPairingledger->save();

                                //$this->revalidatePairing($uplineDistDB->getDistributorId(), $uplinePosition);

                                if ($uplineDistDB->getTreeUplineDistId() == 0 || $uplineDistDB->getTreeUplineDistCode() == null) {
                                    break;
                                }

                                $uplinePosition = $uplineDistDB->getPlacementPosition();
                                $uplineDistDB = MlmDistributorPeer::retrieveByPk($uplineDistDB->getTreeUplineDistId());
                                $level++;
                            }
                            // **tips worlspeace sales link kashventure and eesiang01
                            // **tips 558 kashventure
                            // **tips kashventure sales entitled for  after 124	MaxProLtd1 to 132	MaxProLtd6   & worldpeace
                            $pos = strrpos($mlm_distributor->getPlacementTreeStructure(), "|558|");
                            if ($pos === false) { // note: three equal signs

                            } else {
                                // **tips 879 eesiang01 :: worldpeace downline eesiang01 not maxproltd6 but for chris5 (globalchina)
                                /*$pos2 = strrpos($mlm_distributor->getPlacementTreeStructure(), "|879|");
                                if ($pos2 === false) { // note: three equal signs

                                } else {*/
                                    $level = 0;
                                    $uplineDistDB = MlmDistributorPeer::retrieveByPk(557);
                                    $uplinePosition = Globals::PLACEMENT_LEFT;
                                    $sponsoredDistributorCode = $mlm_distributor->getDistributorCode();

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
                                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid action."));
                                            return $this->redirect('/member/memberRegistration');
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
                                    $sponsorDistPairingledger->setDebit(0);
                                    $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                                    $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ") [kashventure]");
                                    $sponsorDistPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistPairingledger->save();
                                //}
                            }
                        }
                    }
                }
            }
            $con->commit();

            /****************************/
            /*****  Send email **********/
            /****************************/
            $receiverEmail = $this->getRequestParameter('email', $mlm_distributor->getEmail());
            $receiverFullname = $this->getRequestParameter('fullname', $mlm_distributor->getFullName());
            $subject = "Maxim Trader - Thank You for Your Registration";

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
												<table border='0' cellspacing='0' cellpadding='0' style='width:440.0pt;border-collapse:collapse'>
                                        <tbody>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Member ID<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$userName."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Password<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$password."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Security Password<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$password2."<u></u><u></u></span>
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180' style='width:135.0pt;border:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Member ID<u></u><u></u></span>
                                                </p></td>
                                            <td style='border:solid black 1.0pt;border-left:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'><p
                                                    class='MsoNormal'><span
                                                    style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$fcode."<u></u><u></u></span>
                                            </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Full Name(As In IC)<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$receiverFullname."<u></u><u></u></span>
                                                </p></td>
                                        </tr>

                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Email<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'><a
                                                        href='mailto:".$mlm_distributor->getEmail()."'
                                                        target='_blank'>".$this->getRequestParameter('email', $mlm_distributor->getEmail())."</a><u></u><u></u></span></p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Mobile Number<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$this->getRequestParameter('contactNumber', $mlm_distributor->getContact())."<u></u><u></u></span>
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Country<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$this->getRequestParameter('country', $mlm_distributor->getCountry())."<u></u><u></u></span>
                                                </p></td>
                                        </tr>

                                        <tr>
                                            <td width='180'
                                                style='width:135.0pt;border:solid black 1.0pt;border-top:none;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>Package<u></u><u></u></span>
                                                </p></td>
                                            <td style='border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:2.25pt 2.25pt 2.25pt 2.25pt'>
                                                <p class='MsoNormal'><span
                                                        style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;'>".$applicationPackageName." (USD ".number_format($packagePrice,2).")<u></u><u></u></span>
                                                </p></td>
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜金融集团是Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子公司。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
            $sendMailService->sendMail($receiverEmail, $receiverFullname, $subject, $body);
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        if ($doAction == "PENDING_MEMBER") {
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("(%1%) Package Purchase Successfully.", array('%1%' => $fcode)));
            return $this->redirect('/member/summary');
        } else if ($distributor->getPlacementTreeStructure() == null) {
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member (%1%) Registered Successfully.", array('%1%' => $fcode)));
            return $this->redirect('/member/summary');
        } else {
            if ($position == 1 || $position == 2 || $treePosition != ""){
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member (%1%) Registered Successfully.", array('%1%' => $fcode)));
                return $this->redirect('/member/placementTree?distcode=' . $mlm_distributor->getTreeUplineDistCode());
            } else if ($position == 0){
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member (%1%) Registered Successfully. Please manual do placement now.", array('%1%' => $fcode)));
                return $this->redirect('/member/placementTree');
                //return $this->redirect('/member/placementTree?distcode=' . $mlm_distributor->getUplineDistCode());
            }
        }
        return $this->redirect('/member/summary');
    }

    // **********************************************************************************************
    // *****************************         For broker registeration          **********************
    // **********************************************************************************************
    function generateFcode($countryName)
    {
        $max_digit = 99999999;
        $digit = 8;

        while (true) {
            $fcode = rand(0, $max_digit) . "";
            $fcode = str_pad($fcode, $digit, "0", STR_PAD_LEFT);

            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, "%".$fcode, Criteria::LIKE);
            $existDist = MlmDistributorPeer::doSelectOne($c);

            if (!$existDist) {
                $c = new Criteria();
                $c->add(MlmRegistrationCountryCodePeer::COUNTRY_NAME, $countryName);
                $mlmRegistrationCountryCode = MlmRegistrationCountryCodePeer::doSelectOne($c);

                if (!$mlmRegistrationCountryCode) {
                    $c = new Criteria();
                    $c->add(MlmRegistrationCountryCodePeer::COUNTRY_NAME, Globals::COUNTRY_OTHER);
                    $mlmRegistrationCountryCode = MlmRegistrationCountryCodePeer::doSelectOne($c);
                }

                $fcode = $mlmRegistrationCountryCode->getPrefix().$fcode;
                break;
            }
        }
        return $fcode;
    }
    public function executeDemoAccount()
    {
    }
    public function executeOpenDemoAccount()
    {
        $error = false;
        $errorMsg = "";

        //_wpcf7	1264
        //_wpcf7_is_ajax_call	1
        //_wpcf7_unit_tag	wpcf7-f1264-p587-o1
        //_wpcf7_version	3.3.1
        //_wpnonce	f24ca11af2
        //countrylist	Angola
        //f-name	firstname
        //l-name	last name
        //phone-number	phonr
        //title	Mrs
        //your-email	test@asdff
        if (!$this->getRequestParameter('your-email')) {
            $error = true;
            $errorMsg = "Email is required.";
        } else if (!$this->getRequestParameter('f-name')) {
            $error = true;
            $errorMsg = "First Name is required.";
        } else {
            $mlm_mt4_demo_request = new MlmMt4DemoRequest();
            $mlm_mt4_demo_request->setFirstName($this->getRequestParameter('f-name'));
            $mlm_mt4_demo_request->setEmail($this->getRequestParameter('your-email'));
            $mlm_mt4_demo_request->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_mt4_demo_request->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_mt4_demo_request->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_mt4_demo_request->setCountry($this->getRequestParameter('countrylist'));
            $mlm_mt4_demo_request->setPhoneNumber($this->getRequestParameter('phone-number'));
            $mlm_mt4_demo_request->setLastName($this->getRequestParameter('l-name'));
            $mlm_mt4_demo_request->setTitle($this->getRequestParameter('title'));
            $mlm_mt4_demo_request->setLiveDemo("DEMO");
            $mlm_mt4_demo_request->setAddress1($this->getRequestParameter('address-1'));
            $mlm_mt4_demo_request->setAddress2($this->getRequestParameter('address-2'));
            $mlm_mt4_demo_request->setAddressState($this->getRequestParameter('state'));
            $mlm_mt4_demo_request->setAgreeOfBusiness($this->getRequestParameter('agreeofBusiness'));
            $mlm_mt4_demo_request->setRiskDisclosure($this->getRequestParameter('agreeofRiskDisclosure'));
            $mlm_mt4_demo_request->setCountryOfCitizen($this->getRequestParameter('coutrylist'));
            $mlm_mt4_demo_request->setCity($this->getRequestParameter('city'));
            $mlm_mt4_demo_request->setDobDay($this->getRequestParameter('dob_day'));
            $mlm_mt4_demo_request->setDobMonth($this->getRequestParameter('dob_month'));
            $mlm_mt4_demo_request->setDobYear($this->getRequestParameter('dob_year'));
            $mlm_mt4_demo_request->setRefId($this->getRequestParameter('referid'));
            $mlm_mt4_demo_request->setPassport($this->getRequestParameter('ssnumber'));
            $mlm_mt4_demo_request->setSubject($this->getRequestParameter('your-subject'));

            $mlm_mt4_demo_request->save();

            $subject = "Thank you for register Maxim Trader Demo Account 感谢您申请马胜金融交易模拟帐户";
            //$subject = "Thank you for register Maxim Trader Demo Account";

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
																	Dear <strong>".$this->getRequestParameter("l-name")." ".$this->getRequestParameter("f-name")."</strong>,<br><br>
																	Thank you for your interest in opening a Free Demo Account with Maxim Trader. We are proud to offer our cutting-edge trading platform with industry leading performance and stability. Test your market strategies and get used to our platform before starting for real.
                                                                    <br><br>
                                                                    Kindly download the MT4 in order to start your trading activities.
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
							<td style='padding:5px 15px 15px;font-weight:bold' colspan='2'>
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
																	亲爱的 <STRONG>".$this->getRequestParameter('l-name')." ".$this->getRequestParameter('f-name')."</strong>，<br><br>
																	你的免费模拟帐户将使你可以进行“纸上贸易”，我们很自豪能够提供最先进的交易平台，提供业界领先的性能和稳定性，使用MetaTrader 4可以允许你开发和测试您的交易策略。

																	<br><br>如想立刻体验交易，请下载并安装MT4。
																	<br>
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
							<td style='padding:5px 15px 15px;font-weight:bold' colspan='2'>
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜金融集团是Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子公司。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
            $sendMailService->sendMail($this->getRequestParameter('your-email'), $this->getRequestParameter('l-name')." ".$this->getRequestParameter('f-name'), $subject, $body);
        }

        $arr = array(
            'error' => $error,
            'errorMsg' => $errorMsg
        );

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }
    public function executeLiveAccount()
    {
    }
    public function executeOpenLiveAccount()
    {
        $error = false;
        $errorMsg = "";

        //_wpcf7	1266
        //_wpcf7_is_ajax_call	1
        //_wpcf7_unit_tag	wpcf7-f1266-p667-o1
        //_wpcf7_version	3.3.1
        //_wpnonce	5283ef444c
        //address-1	address
        //address-2	address 2
        //agreeofBusiness	1
        //agreeofRiskDisclosure	1
        //city	city
        //countrylist	Albania
        //coutrylist	Armenia
        //f-name	first name
        //l-name	last name
        //menu-dob-day	23
        //menu-dob-month	12
        //menu-dob-year	2000
        //phone-number	phone
        //referid	referrer
        //ssnumber	password
        //state	state
        //title	Mr.
        //your-email	email
        //your-subject	subject

        if (!$this->getRequestParameter('your-email')) {
            $error = true;
            $errorMsg = "Email is required.";
        } else if (!$this->getRequestParameter('f-name')) {
            $error = true;
            $errorMsg = "First Name is required.";
        } else {
            $mlm_mt4_demo_request = new MlmMt4DemoRequest();
            $mlm_mt4_demo_request->setFirstName($this->getRequestParameter('f-name'));
            $mlm_mt4_demo_request->setEmail($this->getRequestParameter('your-email'));
            $mlm_mt4_demo_request->setStatusCode(Globals::STATUS_ACTIVE);
            $mlm_mt4_demo_request->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_mt4_demo_request->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_mt4_demo_request->setCountry($this->getRequestParameter('countrylist'));
            $mlm_mt4_demo_request->setPhoneNumber($this->getRequestParameter('phone-number'));
            $mlm_mt4_demo_request->setLastName($this->getRequestParameter('l-name'));
            $mlm_mt4_demo_request->setTitle($this->getRequestParameter('title'));
            $mlm_mt4_demo_request->setLiveDemo("LIVE");
            $mlm_mt4_demo_request->setAddress1($this->getRequestParameter('address-1'));
            $mlm_mt4_demo_request->setAddress2($this->getRequestParameter('address-2'));
            $mlm_mt4_demo_request->setAddressState($this->getRequestParameter('state'));
            $mlm_mt4_demo_request->setAgreeOfBusiness($this->getRequestParameter('agreeofBusiness'));
            $mlm_mt4_demo_request->setRiskDisclosure($this->getRequestParameter('agreeofRiskDisclosure'));
            $mlm_mt4_demo_request->setCountryOfCitizen($this->getRequestParameter('coutrylist'));
            $mlm_mt4_demo_request->setCity($this->getRequestParameter('city'));
            $mlm_mt4_demo_request->setDobDay($this->getRequestParameter('dob_day'));
            $mlm_mt4_demo_request->setDobMonth($this->getRequestParameter('dob_month'));
            $mlm_mt4_demo_request->setDobYear($this->getRequestParameter('dob_year'));
            $mlm_mt4_demo_request->setRefId($this->getRequestParameter('referid'));
            $mlm_mt4_demo_request->setPassport($this->getRequestParameter('ssnumber'));
            $mlm_mt4_demo_request->setSubject($this->getRequestParameter('your-subject'));

            $mlm_mt4_demo_request->save();

            $subject = "感谢您申请马胜金融交易MT4帐户 Thank you for register Maxim Trader MT4 Account";
            //$subject = "Thank you for register Maxim Trader Demo Account";

            $body = "<table width='800' align='center' cellpadding='0' cellspacing='0' border='0'>
                    <tbody><tr>
                        <td valign='top' colspan='3'>
                            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                                <tbody>
                                <tr><td colspan='3' style='font-size:0;line-height:0' bgcolor='#0080C8'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='34'></td></tr>
                                <tr>
                                    <td style='font-size:0;line-height:0' width='201' valign='top'><img src='http://partner.maximtrader.com/images/email/bg-top.png' width='160'></td>
                                    <td valign='top' width='551'>
                                        <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                                            <tbody><tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='71'></td></tr>
                                            <tr>
                                                <td valign='top' style='font-size:0;line-height:0' width='86'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='86' height='1'></td>
                                                <td valign='top' style='line-height:17px'>
                                                    <font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
												Dear <strong>".$this->getRequestParameter('l-name')." ".$this->getRequestParameter('f-name')."</strong>,<br><br>

                                                Thank you for your recent application for a trading account with Maxim Trader.
                                                <br><br>
We are pleased to advise you that your account application has been accepted.
<br><br>
In order for us to open your account, there are a few pieces of information we need from you as soon as possible, so you can start to enjoy trading with Maxim Trader.
<br><br>
Please send us <strong>one</strong> certified** document from list (i) and <strong>two</strong> certified** documents from list (ii) below:
<br><br>

(i) ID Verification (non-expired)
<br>&nbsp;&nbsp;1. Passport; or
<br>&nbsp;&nbsp;2. Photocard driving licence; or
<br>&nbsp;&nbsp;3. National ID card
<br><br>
(ii) Address Verification*
<br>&nbsp;&nbsp;1. Bank statement; or
<br>&nbsp;&nbsp;2. Utility bill (gas, water, electric or land line telephone); or
<br>&nbsp;&nbsp;3. Credit card Statement.
<br><br>
<br><br>
Please scan the required documents and send them to us by email at <strong>account@maximtrader.com</strong>
<br><br>
Once your documents have been successfully verified, we will advise you of your account number/login and password.
<br><br>
We look forward to your custom in the near future. Should you have any queries, please do not hesitate to contact us.
											</font>

											<br>
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
												</tr>
											</tbody></table>
										</td>
									</tr>
									<tr>
										<td valign='top' style='font-size:0;line-height:0' width='86'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='86' height='1'></td>
										<td valign='top' style='line-height:17px'>
										<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:14px;line-height:17px'>
                                                        亲爱的 <STRONG>".$this->getRequestParameter('l-name')." ".$this->getRequestParameter('f-name')."</strong>，<br><br>
                                                        你的MT4帐户将使你可以进行贸易，使用MetaTrader 4可以允许你开发和测试您的交易策略。


                                                        感谢您申请Maxim Trader的交易账户。
                                                <br><br>
我们很高兴地告诉你，你的开户申请已经被接受。
<br><br>
您已选择（个人）以美元交易的账户。
<br><br>
为了让我们激活您的帐户，我们需要您尽快尽快提交以下的文件与资料:
<br><br>
请发送给我们<STRONG>一份</strong>（必须认证）**文件列表（i）及<STRONG>两份</strong>（必须认证）**文件列表（ii）段：
<br><br>

（ii）身份验证（未过期）
<BR>1. 护照;
<BR>2. 驾驶执照;
<BR>3. 国民身分证
<br><br>
（ii）地址验证码*
<BR>1. 银行对账单;
<BR>2. 水电费帐单（煤气，水，电或陆地线路电话）;
<BR>3. 信用卡对帐单。
<br><br>
*本文件必须是最近3个月内，文件里包括您的姓名和现住址，发行人及日期必须是清楚可见的。
<br><br>
<br><br>
请扫描所需的文件和电子邮件发送给我们在<strong> account@maximtrader.com </strong>
<br><br>
您的文件得到了成功验证后，我们会通知您，您的帐户号码/用户名和密码。
<br><br>
我们期待着在不久的将来，您的自定义。如果您有任何疑问，请不要犹豫与我们联系。
                                                        <br>
                                                    </font>
                                                    <br>

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
												</tr>
											</tbody></table>
										</td>
									</tr>
									<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='32'></td></tr>
									<tr>
										<td valign='top' style='font-size:0;line-height:0' width='86'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='86' height='1'></td>
										<td style='font-size:0;line-height:0' bgcolor='#0080C8'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='1'></td>
									</tr>
									<tr><td style='font-size:0;line-height:0' colspan='2'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='10'></td></tr>
									<tr>
										<td valign='top' style='line-height:15px;text-align:right' colspan='2' align='right'>
											<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:15px'>
												<em>
													Best Regards,<br>
													<strong>Maxim Trader Account Opening Team</strong><br>
												</em>
											</font>
										</td>
									</tr>
								</tbody></table>
							</td>
							<td style='font-size:0;line-height:0' width='48'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='48' height='1'></td>
						</tr>
					</tbody></table>
				</td>
			</tr>
			<tr>
				<td style='font-size:0;line-height:0' width='63'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='63' height='1'></td>
				<td valign='top' width='689'>
					<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tbody><tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='28'></td></tr>
						<tr>
							<td align='right' style='text-align:right;font-size:0;line-height:0'>
								<a href='http://maximtrader.com/' target='_blank'><img src='http://partner.maximtrader.com/images/email/logo.png' width='254' height='87' border='0'></a>

								<br>
								<p align='justify'>
									<font face='Arial, Verdana, sans-serif' size='3' color='#666666' style='font-size:10px;line-height:15px'>
											Maxim Trader is managed by Maxim Capital Limited. Registered Office: Level 8, 10/12 Scotia Place, Suite 11, Auckland City Centre, Auckland, 1010, New Zealand. Tel (International): (+64) 9925 0379 Tel (Dial within NZ): 09 925 0379, Email support@maximtrader.com
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜金融集团是Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子公司。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
<br><br>保密条款: 本邮件及其附件仅限于发送给上面地址中列出的个人、群组。禁止任何其他人以任何形式使用（包括但不限于全部或部分的泄露、复制、或散发）本邮件中的信息。如果您错收了本邮件，请您立即电话或邮件通知发件人，并删除任何您存于电脑或者其他终端的本邮件！
<br><br>免责声明: 本邮件中任何观点和意见仅代表邮件发件人个人观点； 且除非特别声明，本邮件中的任何观点或意见并不代表马胜金融集团的立场。另本邮件中所含信息并不构成投资建议。
<br><br>风险警示:外汇、差价赌注、差价合同交易均为高风险操作，您的损失可能会超出您的初始投入。 请根据您可以承受的损失程度理性参与投资。 在您决定参与任何交易前，请一定了解您正在接触的交易其本质，并全面理解您个人的风险暴露程度。这些产品可能不适用于所有的投资者，所以若您未能充分了解所涉及的风险，请您寻求独立意见。
									</font>
								</p>
							</td>
						</tr>
						<tr><td style='font-size:0;line-height:0'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='16'></td></tr>
					</tbody></table>
				</td>
				<td style='font-size:0;line-height:0' width='48'><img src='http://partner.maximtrader.com/images/email/transparent.gif' width='48' height='1'></td>
			</tr>
			<tr><td colspan='3' style='font-size:0;line-height:0' bgcolor='#0080C8'><img src='http://partner.maximtrader.com/images/email/transparent.gif' height='34'></td></tr>
		</tbody></table>";

            $sendMailService = new SendMailService();
            $sendMailService->sendMail($this->getRequestParameter('your-email'), $this->getRequestParameter('l-name')." ".$this->getRequestParameter('f-name'), $subject, $body);
        }

        $arr = array(
            'error' => $error,
            'errorMsg' => $errorMsg
        );

        echo json_encode($arr);

        return sfView::HEADER_ONLY;
    }

    // **********************************************************************************************
    // *******************   ~ end      For broker registeration       end ~   **********************
    // **********************************************************************************************

    public function executeVerifySameGroupSponsorId()
    {
        //var_dump($this->getUser()->getAttribute(Globals::SESSION_USERNAME));
        $sponsorId = $this->getRequestParameter('sponsorId');

        $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname, dist.PLACEMENT_TREE_STRUCTURE, dist.TREE_STRUCTURE
            FROM mlm_distributor dist
                LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                    WHERE appUser.username = '".$sponsorId."'";
//                    WHERE appUser.username = '".$sponsorId."' AND dist.TREE_STRUCTURE LIKE '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

        $arr = "";


        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $isFound = false;

        if ($resultset->next()) {
            $resultArr = $resultset->getRow();

            $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
            if ($pos === false) { // note: three equal signs
                $pos = strrpos($resultArr["TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                if ($pos === false) { // note: three equal signs

                } else {
                    $isFound = true;
                }
            } else {
                $isFound = true;
            }

            if ($isFound == false) {
                $existDist = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                if ($existDist) {
                    $pos = strrpos($existDist->getPlacementTreeStructure(), "|".$resultArr["distributor_id"]."|");
                    if ($pos === false) { // note: three equal signs
                        $pos = strrpos($existDist->getTreeStructure(), "|".$resultArr["distributor_id"]."|");
                        if ($pos === false) { // note: three equal signs

                        } else {
                            $isFound = true;
                        }
                    } else {
                        $isFound = true;
                    }
                }
            }
            if ($isFound) {
                $arr = array(
                    'userId' => $resultArr["distributor_id"],
                    'userName' => $resultArr["distributor_code"],
                    'fullname' => $resultArr["full_name"],
                    'nickname' => $resultArr["full_name"]
                );
            }
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeVerifySponsorUserName()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');

        $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname
            FROM mlm_distributor dist
                LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                    WHERE appUser.username = '".$sponsorId."'";

        $arr = "";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        if ($resultset->next()) {
            $resultArr = $resultset->getRow();

            $arr = array(
                'userId' => $resultArr["distributor_id"],
                'userName' => $resultArr["distributor_code"],
                'fullname' => $resultArr["full_name"],
                'nickname' => $resultArr["full_name"]
            );
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeVerifySponsorId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');

        $array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, $array, Criteria::IN);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            //if ($existUser->getDistributorId() <> $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
            $arr = array(
                'userId' => $existUser->getDistributorId(),
                'userName' => $existUser->getDistributorCode(),
                'fullname' => $existUser->getFullName(),
                'nickname' => $existUser->getFullName()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    function generatePaymentReference()
    {
        $max_digit = 9999999999;
        $digit = 12;

        while (true) {
            $fcode = rand(1000000000, $max_digit) . "";
            //$fcode = str_pad($fcode, $digit, "0", STR_PAD_LEFT);
            /*
            for ($x=0; $x < ($digit - strlen($fcode)); $x++) {
                $fcode = "0".$fcode;
            }
			*/
            $c = new Criteria();
            $c->add(MlmDistEpointPurchasePeer::PAYMENT_REFERENCE, $fcode);
            $existCode = MlmDistEpointPurchasePeer::doSelectOne($c);

            if (!$existCode) {
                break;
            }
        }
        return $fcode;
    }

    public function executeVerifyActiveSponsorId()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');
        $verifySameGroup = $this->getRequestParameter('verifySameGroup', "N");

        //$array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
        if ($verifySameGroup == "Y") {
            $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%", Criteria::LIKE);
        }
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        $arr = "";
        if ($existUser) {
            //if ($existUser->getDistributorId() <> $this->getUser()->getAttribute(Globals::SESSION_DISTID)) {
            $arr = array(
                'userId' => $existUser->getDistributorId(),
                'userName' => $existUser->getDistributorCode(),
                'fullname' => $existUser->getFullName(),
                'nickname' => $existUser->getFullName()
            );
            //}
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeFetchPackage()
    {
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $account = MlmAccountPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $ecashAccount = MlmAccountPeer::doSelectOne($c);

        $arr = array(
            'packageId' => 0,
            'point' => 0,
            'ecash' => 0,
            'package' => ""
        );
        if (($account) && ($ecashAccount)) {
            $max = $ecashAccount->getBalance();

            if ($account->getBalance() > $ecashAccount->getBalance())
                $max = $account->getBalance();

            $c = new Criteria();
            //$c->add(MlmPackagePeer::PRICE, $max, Criteria::LESS_EQUAL);
            if ($this->getRequestParameter('publicPurchase') == "") {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, Globals::YES);
            } else {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, $this->getRequestParameter('publicPurchase'));
            }

            $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);
            $packages = MlmPackagePeer::doSelect($c);

            $packageArray = array();
            $count = 0;
            foreach ($packages as $package) {
                $packageArray[$count]["packageId"] = $package->getPackageId();
                $packageArray[$count]["name"] = $this->getContext()->getI18N()->__($package->getPackageName());
                $packageArray[$count]["price"] = $package->getPrice();
                $count++;
            }

            $arr = array(
                'point' => $account->getBalance(),
                'ecash' => $ecashAccount->getBalance(),
                'package' => $packageArray
            );
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeFetchTopupPackage()
    {
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $account = MlmAccountPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        $c->add(MlmAccountPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $ecashAccount = MlmAccountPeer::doSelectOne($c);

        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());
        $currentPackageAmount = $distPackage->getPrice();

        if ($currentPackageAmount == null)
            $currentPackageAmount = 99999999;

        $arr = array(
            'packageId' => 0,
            'point' => 0,
            'ecash' => 0,
            'package' => ""
        );
        if (($account) && ($ecashAccount)) {
            $totalEcash = $ecashAccount->getBalance() + $currentPackageAmount;
            $totalEpoint = $account->getBalance() + $currentPackageAmount;

            $max = $totalEcash;

            if ($totalEpoint > $totalEcash)
                $max = $totalEpoint;

            $c = new Criteria();
            $c->add(MlmPackagePeer::PRICE, $max, Criteria::LESS_EQUAL);
            $c->addAnd(MlmPackagePeer::PRICE, $currentPackageAmount, Criteria::GREATER_THAN);
            $c->addAnd(MlmPackagePeer::PRICE, null, Criteria::ISNOTNULL);

            if ($this->getRequestParameter('publicPurchase') == "") {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, Globals::YES);
            } else {
                $c->add(MlmPackagePeer::PUBLIC_PURCHASE, $this->getRequestParameter('publicPurchase'));
            }

            $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);

            $packages = MlmPackagePeer::doSelect($c);

            $packageArray = array();
            $count = 0;
            foreach ($packages as $package) {
                $packageArray[$count]["packageId"] = $package->getPackageId();
                $packageArray[$count]["name"] = $this->getContext()->getI18N()->__($package->getPackageName());
                $packageArray[$count]["price"] = $package->getPrice() - $currentPackageAmount;
                $count++;
            }

            $arr = array(
                'point' => $totalEpoint,
                'ecash' => $totalEcash,
                'package' => $packageArray
            );
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeSummary()
    {
        $c = new Criteria();
        if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 1) {

        } else {
            $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        }
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, null, Criteria::ISNULL);
        $this->pendingDistributors = MlmDistributorPeer::doSelect($c);

        $c = new Criteria();
        $c->add(MlmAnnouncementPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->addDescendingOrderByColumn(MlmAnnouncementPeer::CREATED_ON);
        $c->setLimit(5);
        $this->announcements = MlmAnnouncementPeer::doSelect($c);

        $distributor = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distributor);

        $rp = 0;
        $debitAccount = 0;
        $ecash = 0;
        $epoint = 0;
        $maintenancePoint = 0;
        $totalNetworks = 0;
        $ranking = "";
        $mt4Id = "";
        $currencyCode = "";

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_SYSTEM_CURRENCY);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $currencyCode = $settingDB->getSettingValue();
        }
        if ($distributor) {
            $existUser = AppUserPeer::retrieveByPK($distributor->getUserId());

            if ($existUser) {
                $lastLogin = $existUser->getLastLoginDatetime();
            }

            $ranking = $distributor->getRankCode();

            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $distMt4s = MlmDistMt4Peer::doSelect($c);

            foreach ($distMt4s as $distMt4) {
                if ($mt4Id != "")
                    $mt4Id .= ",";
                $mt4Id .= $distMt4->getMt4UserName();
            }

            $ecash = $this->getAccountBalance($distributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);
            $epoint = $this->getAccountBalance($distributor->getDistributorId(), Globals::ACCOUNT_TYPE_EPOINT);
            $maintenancePoint = $this->getAccountBalance($distributor->getDistributorId(), Globals::ACCOUNT_TYPE_MAINTENANCE);

            $rp = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_RP);
            $debitAccount = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_DEBIT_ACCOUNT);
            //$debitAccount = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_DEBIT);

            //$rp = $rp - $debitAccount;

            $c = new Criteria();
            $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%|".$distributor->getDistributorId()."|%", Criteria::LIKE);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $totalNetworks = MlmDistributorPeer::doCount($c);
        }

        $this->ecash = $ecash;
        $this->epoint = $epoint;
        $this->totalNetworks = $totalNetworks;
        $this->ranking = $ranking;
        $this->mt4Id = $mt4Id;
        $this->distMt4s = $distMt4s;
        $this->colorArr = $this->getRankColorArr();
        $this->currencyCode = $currencyCode;
        $this->distributor = $distributor;
        $this->lastLogin = $lastLogin;
        $this->maintenancePoint = $maintenancePoint;
        $this->rp = $rp;
        $this->debitAccount = $debitAccount;
    }

    public function executeAnnouncementList()
    {
        $c = new Criteria();
        $c->add(MlmAnnouncementPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->addDescendingOrderByColumn(MlmAnnouncementPeer::CREATED_ON);
        $c->setLimit(10);
        $this->announcements = MlmAnnouncementPeer::doSelect($c);
    }

    public function executeBonusDetailList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        //$c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::ACCOUNT_LEDGER_ACTION_DRB);
        $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, $this->getRequestParameter('filterBonusType'));
        $totalRecords = MlmDistCommissionLedgerPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterMonth') != "" && $this->getRequestParameter('filterYear') != "") {
            $dateUtil = new DateUtil();
            $month = $this->getRequestParameter('filterMonth');
            $year = $this->getRequestParameter('filterYear');
            $d = $dateUtil->getMonth($month, $year);

            $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
            $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

            $c->add(MlmDistCommissionLedgerPeer::CREATED_ON, $firstOfMonth, Criteria::GREATER_EQUAL);
            $c->addAnd(MlmDistCommissionLedgerPeer::CREATED_ON, $lastOfMonth, Criteria::LESS_EQUAL);
        }

        $totalFilteredRecords = MlmDistCommissionLedgerPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmDistCommissionLedger', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $extraRemark = "";
            if (Globals::STATUS_COMPLETE == $result->getStatusCode()) {
                $dateString = $result->getUpdatedOn();
                $dateArr = explode(" ", $dateString);
                $extraRemark = "Successful credited into MT4 Fund (".$dateArr[0].")";
            }
            $arr[] = array(
                $result->getCommissionId() == null ? "0" : $result->getCommissionId(),
                $result->getCreatedOn() == null ? "" : $result->getCreatedOn(),
                $result->getCommissionType() == null ? ""
                        : $this->getContext()->getI18N()->__($result->getCommissionType()),
                $result->getCredit() == null ? "0" : number_format($result->getCredit(), 2),
                $result->getDebit() == null ? "0" : number_format($result->getDebit(), 2),
                $result->getRemark() == null ? "" : $result->getRemark(),
                $extraRemark
            );
        }

        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeDelete()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, null, Criteria::ISNULL);
        $c->addAnd(MlmDistributorPeer::DISTRIBUTOR_ID, $this->getRequestParameter('distid'));
        $mlmDistributor = MlmDistributorPeer::doSelectOne($c);

        if ($mlmDistributor) {
            $appUser = AppUserPeer::retrieveByPk($mlmDistributor->getUserId());
            $appUser->delete();

            $mlmDistributor->delete();
            $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Member deleted successfully."));
        }

        return $this->redirect('/member/summary');
    }

    public function executeVerifyTransactionPassword()
    {
        $array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
        $c->add(AppUserPeer::USERPASSWORD2, $this->getRequestParameter('transactionPassword'));
        $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
        //$c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(AppUserPeer::STATUS_CODE, $array, Criteria::IN);

        $existUser = AppUserPeer::doSelectOne($c);

        if ($existUser) {
            echo 'true';
        } else {
            echo 'false';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeActivateMember()
    {
        $sponsorId = $this->getRequestParameter('sponsorId');
        //$sponsorId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $transactionPassword = $this->getRequestParameter('transactionPassword');
        $packageId = $this->getRequestParameter('packageId');
        $paymentType = "epoint";
        //$paymentType = $this->getRequestParameter('paymentType');
        $error = false;
        $errorMsg = "";

        //$array = explode(',', Globals::STATUS_ACTIVE.",".Globals::STATUS_PENDING);
        $c = new Criteria();
        $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
        $c->add(AppUserPeer::USERPASSWORD2, $transactionPassword);
        $c->add(AppUserPeer::USER_ROLE, Globals::ROLE_DISTRIBUTOR);
        $c->add(AppUserPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        //$c->add(MlmDistributorPeer::STATUS_CODE, $array, Criteria::IN);

        $existUser = AppUserPeer::doSelectOne($c);
        if (!$existUser) {
            $error = true;
            $errorMsg = "Invalid Security Password.";
        }

        $packageDB = null;
        if (!$error) {
            $packageDB = MlmPackagePeer::retrieveByPK($packageId);
            $this->forward404Unless($packageDB);
            if (!$packageDB) {
                $error = true;
                $errorMsg = "Invalid Package.";
            }
        }

        if (!$error) {
            if ("epoint" == $paymentType) {
                $balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
                if ($balance < $packageDB->getPrice()) {
                    $error = true;
                    $errorMsg = "Insufficient CP1.";
                }
            } else if ("ecash" == $paymentType) {
                $balance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                if ($balance < $packageDB->getPrice()) {
                    $error = true;
                    $errorMsg = "Insufficient CP2.";
                }
            } else {
                $error = true;
                $errorMsg = "Invalid Action.";
            }
        }

        if (!$error) {
            $distDB = MlmDistributorPeer::retrieveByPK($sponsorId);
            $this->doActivateAccount($distDB->getUplineDistId(), $sponsorId, $packageId, $paymentType);
        }
        $arr = array(
            'error' => $error
        , 'errorMsg' => $errorMsg
        );
        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executePlacementTree()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_GENEALOGY, false) == false && $this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN, Globals::FALSE) == Globals::FALSE) {
            return $this->redirect('/member/securityPasswordRequired?doAction=G');
        }

        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB->getHideGenealogy() == "Y") {
            return $this->redirect('/member/summary');
        }
        $dateUtil = new DateUtil();
        /*if ($dateUtil->checkDateIsWithinRange(date("Y-m-d").' 00:00:00', date("Y-m-d").' 01:00:00', date("Y-m-d G:i:s"))) {
            return $this->redirect('home/maintenance');
        }*/
        if ($this->getRequestParameter('doAction') == "save") {
            /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', "This function temporary out of service.");
                return $this->redirect('/member/summary');
            }*/
            $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
            try {
                $con->begin();

                $uplineDistCode = $this->getRequestParameter('uplineDistCode');
                $uplinePosition = $this->getRequestParameter('uplinePosition');
                $sponsorDistId = $this->getRequestParameter('sponsorDistId');

                $uplineDistDB = $this->getDistributorInformation($uplineDistCode);
                $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $sponsorDB = MlmDistributorPeer::retrieveByPk($sponsorDistId);
                $this->forward404Unless($distDB);
                $this->forward404Unless($sponsorDB);

                $treeStructure = $uplineDistDB->getPlacementTreeStructure() . "|" . $sponsorDB->getDistributorCode() . "|";
                $treeLevel = $uplineDistDB->getPlacementTreeLevel() + 1;

                $sponsorDB->setPlacementDatetime(date("Y/m/d h:i:s A"));
                $sponsorDB->setPlacementPosition($uplinePosition);
                //$sponsorDB->setUplineDistId($uplineDistDB->getDistributorId());
                //$sponsorDB->setUplineDistCode($uplineDistDB->getDistributorCode());
                $sponsorDB->setPlacementTreeStructure($treeStructure);
                $sponsorDB->setPlacementTreeLevel($treeLevel);
                $sponsorDB->setTreeUplineDistId($uplineDistDB->getDistributorId());
                $sponsorDB->setTreeUplineDistCode($uplineDistDB->getDistributorCode());
                $sponsorDB->save();

                $sponsoredPackageDB = MlmPackagePeer::retrieveByPK($sponsorDB->getRankId());
                $this->forward404Unless($sponsoredPackageDB);
                $pairingPoint = $sponsoredPackageDB->getPrice();
                /*if ($sponsoredPackageDB->getPackageId() == Globals::MAX_PACKAGE_ID) {
                    $pairingPoint = $amountNeeded;
                }*/
                // recalculate Total left and total right for $uplineDistDB
                /*$arrs = explode("|", $uplineDistDB->getPlacementTreeStructure());
                for ($x = count($arrs); $x > 0; $x--) {
                    if ($arrs[$x] == "") {
                        continue;
                    }
                    $uplineDistDB = MlmDistributorPeer::retrieveByPK($arrs[$x]);
                    $this->forward404Unless($uplineDistDB);
                    $totalLeft = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_LEFT);
                    $totalRight = $this->getTotalPosition($arrs[$x], Globals::PLACEMENT_RIGHT);
                    $uplineDistDB->setTotalLeft($totalLeft);
                    $uplineDistDB->setTotalRight($totalRight);
                    $uplineDistDB->save();
                }*/

                /******************************/
                /*  store Pairing points
                /******************************/
                if ($sponsorDB->getTreeUplineDistId() != 0 && $sponsorDB->getTreeUplineDistCode() != null) {
                    $level = 0;
                    $uplineDistDB = MlmDistributorPeer::retrieveByPk($sponsorDB->getTreeUplineDistId());
                    $sponsoredDistributorCode = $sponsorDB->getDistributorCode();
                    while ($level < 400) {
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
                            $this->forward404Unless($packageDB);

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
                        $sponsorDistPairingledger->setDebit(0);
                        $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                        $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
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
                }
                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                throw $e;
            }

            /******************************/
            /*  Pairing             ~ END ~
            /******************************/
            return $this->redirect('/member/placementTree?distcode=' . $this->getRequestParameter('distcode', $this->getUser()->getAttribute(Globals::SESSION_DISTCODE)));
        }
        $distcode = $this->getRequestParameter('distcode', $this->getUser()->getAttribute(Globals::SESSION_DISTCODE));
        $pageDirection = $this->getRequestParameter('p', "");
        $bePlacementId = $this->getRequestParameter('bePlacementId', "");

        $bePlacementDistCode = "";
        if ($bePlacementId != "") {
            $distPendingToPlacement = MlmDistributorPeer::retrieveByPK($bePlacementId);
            if ($distPendingToPlacement) {
                $bePlacementDistCode = $distPendingToPlacement->getDistributorCode();
            }
        }
        $this->bePlacementId = $bePlacementId;
        $this->bePlacementDistCode = $bePlacementDistCode;

        $this->pageDirection = $pageDirection;
        $anode = array();
        //      0
        //  1       2
        //3   4   5   6

        // TO_HIDE_DIST_GROUP
        $hideDistGroup = false;
        $pos = strrpos(Globals::TO_HIDE_DIST_GROUP, "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
        //var_dump($pos."<br>");
        if ($pos === false) { // note: oee equal signs

        } else {
            $hideDistGroup = true;
        }
        $this->hideDistGroup = $hideDistGroup;
        //var_dump(Globals::HIDE_DIST_GROUP."<br>");
        //var_dump($this->getUser()->getAttribute(Globals::SESSION_DISTID)."<br>");
        //var_dump($hideDistGroup);
        // TO_HIDE_DIST_GROUP end ~

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distcode);
        //$c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|" . $this->getUser()->getAttribute(Globals::SESSION_DISTID) . "|%", Criteria::LIKE);
        $distDB = MlmDistributorPeer::doSelectOne($c);

        // maxworld = 175
        if (!$distDB && $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 175) {
        //if (!$distDB && ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 175 || $this->getUser()->getAttribute(Globals::SESSION_DISTID) == 175)) {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distcode."_");
            //$c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|" . $this->getUser()->getAttribute(Globals::SESSION_DISTID) . "|%", Criteria::LIKE);
            $distDB = MlmDistributorPeer::doSelectOne($c);
        }

        if (!$distDB) {
            $this->errorSearch = true;
            $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        }

        // TO_HIDE_DIST_GROUP
        $apService = new ApService();
        if ($hideDistGroup) {
            if ($apService->blockGenealogy($this->getUser()->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $this->errorSearch = true;
                //$c = new Criteria();
                //$c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getUser()->getAttribute(Globals::SESSION_DISTCODE));
                //$distDB = MlmDistributorPeer::doSelectOne($c);
                $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            }
        }
        // TO_HIDE_DIST_GROUP end ~

        $leftOnePlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $rightTwoPlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
        $anode[0]["distCode"] = $distDB->getDistributorCode();
        $anode[0]["_self"] = $distDB;
        $anode[0]["_left"] = $leftOnePlacement;
        $anode[0]["_right"] = $rightTwoPlacement;
        $anode[0]["_available"] = false;
        $anode[0]["_left_this_month_sales"] = $this->getThisMonthSales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $anode[0]["_right_this_month_sales"] = $this->getThisMonthSales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
        $anode[0]["_dist_pairing_ledger"] = $this->queryDistPairing($distDB->getDistributorId());
        $anode[0]["_accumulate_left"] = $this->getAccumulateGroupBvs($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $anode[0]["_accumulate_right"] = $this->getAccumulateGroupBvs($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
        $anode[0]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
        $anode[0]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

        $_carry_left = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[0]["_today_left"];
        if ($_carry_left < 0)
            $_carry_left = 0;
        $_carry_right = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[0]["_today_right"];
        if ($_carry_right < 0)
            $_carry_right = 0;

        $anode[0]["_carry_left"] = $_carry_left;
        $anode[0]["_carry_right"] = $_carry_right;
        $anode[0]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
        $anode[0]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

        // openman
        if ($distDB->getDistributorId() == 273056 && $this->getUser()->getAttribute(Globals::SESSION_DISTID) != 273056) {
            $anode[0]["_right_this_month_sales"] = 0;
            $anode[0]["_accumulate_right"] = 0;
            $anode[0]["_today_right"] = 0;
            $anode[0]["_carry_right"] = 0;
            $anode[0]["_sales_right"] = 0;
        }

        if ($leftOnePlacement == null) {
            $anode[1]["distCode"] = "";
            $anode[1]["_self"] = new MlmDistributor();
            $anode[1]["_left"] = null;
            $anode[1]["_right"] = null;
            $anode[1]["_available"] = true;
            $anode[1]["_left_this_month_sales"] = null;
            $anode[1]["_right_this_month_sales"] = null;
            $anode[1]["_dist_pairing_ledger"] = null;
            $anode[1]["_accumulate_left"] = null;
            $anode[1]["_accumulate_right"] = null;
            $anode[1]["_today_left"] = null;
            $anode[1]["_today_right"] = null;
            $anode[1]["_carry_left"] = null;
            $anode[1]["_carry_right"] = null;
            $anode[1]["_sales_left"] = null;
            $anode[1]["_sales_right"] = null;

            $anode[3]["distCode"] = "";
            $anode[3]["_self"] = new MlmDistributor();
            $anode[3]["_left"] = null;
            $anode[3]["_right"] = null;
            $anode[3]["_available"] = false;
            $anode[3]["_left_this_month_sales"] = null;
            $anode[3]["_right_this_month_sales"] = null;
            $anode[3]["_dist_pairing_ledger"] = null;
            $anode[3]["_accumulate_left"] = null;
            $anode[3]["_accumulate_right"] = null;
            $anode[3]["_today_left"] = null;
            $anode[3]["_today_right"] = null;
            $anode[3]["_carry_left"] = null;
            $anode[3]["_carry_right"] = null;
            $anode[3]["_sales_left"] = null;
            $anode[3]["_sales_right"] = null;

            $anode[4]["distCode"] = "";
            $anode[4]["_self"] = new MlmDistributor();
            $anode[4]["_left"] = null;
            $anode[4]["_right"] = null;
            $anode[4]["_available"] = false;
            $anode[4]["_left_this_month_sales"] = null;
            $anode[4]["_right_this_month_sales"] = null;
            $anode[4]["_dist_pairing_ledger"] = null;
            $anode[4]["_accumulate_left"] = null;
            $anode[4]["_accumulate_right"] = null;
            $anode[4]["_today_left"] = null;
            $anode[4]["_today_right"] = null;
            $anode[4]["_carry_left"] = null;
            $anode[4]["_carry_right"] = null;
            $anode[4]["_sales_left"] = null;
            $anode[4]["_sales_right"] = null;

        } else {
            $distDB = $this->getDistributorInformation($leftOnePlacement->getDistributorCode());
            $leftThreePlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $rightFourPlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $anode[1]["distCode"] = $leftOnePlacement->getDistributorCode();
            $anode[1]["_self"] = $distDB;
            $anode[1]["_left"] = $leftThreePlacement;
            $anode[1]["_right"] = $rightFourPlacement;
            $anode[1]["_available"] = false;
            $anode[1]["_left_this_month_sales"] = $this->getThisMonthSales($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[1]["_right_this_month_sales"] = $this->getThisMonthSales($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[1]["_dist_pairing_ledger"] = $this->queryDistPairing($leftOnePlacement->getDistributorId());
            $anode[1]["_accumulate_left"] = $this->getAccumulateGroupBvs($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[1]["_accumulate_right"] = $this->getAccumulateGroupBvs($leftOnePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[1]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[1]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $_carry_left = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[1]["_today_left"];
            if ($_carry_left < 0)
                $_carry_left = 0;
            $_carry_right = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[1]["_today_right"];
            if ($_carry_right < 0)
                $_carry_right = 0;

            $anode[1]["_carry_left"] = $_carry_left;
            $anode[1]["_carry_right"] = $_carry_right;

            $anode[1]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
            $anode[1]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

            // openman
            if ($distDB->getDistributorId() == 273056 && $this->getUser()->getAttribute(Globals::SESSION_DISTID) != 273056) {
                $anode[1]["_right_this_month_sales"] = 0;
                $anode[1]["_accumulate_right"] = 0;
                $anode[1]["_today_right"] = 0;
                $anode[1]["_carry_right"] = 0;
                $anode[1]["_sales_right"] = 0;
            }

            if ($leftThreePlacement == null) {
                $anode[3]["distCode"] = "";
                $anode[3]["_self"] = new MlmDistributor();
                $anode[3]["_left"] = null;
                $anode[3]["_right"] = null;
                $anode[3]["_available"] = true;
                $anode[3]["_left_this_month_sales"] = null;
                $anode[3]["_right_this_month_sales"] = null;
                $anode[3]["_dist_pairing_ledger"] = null;
                $anode[3]["_accumulate_left"] = null;
                $anode[3]["_accumulate_right"] = null;
                $anode[3]["_today_left"] = null;
                $anode[3]["_today_right"] = null;
                $anode[3]["_carry_left"] = null;
                $anode[3]["_carry_right"] = null;
                $anode[3]["_sales_left"] = null;
                $anode[3]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($leftThreePlacement->getDistributorCode());
                $anode[3]["distCode"] = $leftThreePlacement->getDistributorCode();
                $anode[3]["_self"] = $distDB;
                $anode[3]["_left"] = null;
                $anode[3]["_right"] = null;
                $anode[3]["_available"] = false;
                $anode[3]["_left_this_month_sales"] = $this->getThisMonthSales($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[3]["_right_this_month_sales"] = $this->getThisMonthSales($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[3]["_dist_pairing_ledger"] = $this->queryDistPairing($leftThreePlacement->getDistributorId());
                $anode[3]["_accumulate_left"] = $this->getAccumulateGroupBvs($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[3]["_accumulate_right"] = $this->getAccumulateGroupBvs($leftThreePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[3]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[3]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $_carry_left = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[3]["_today_left"];
                if ($_carry_left < 0)
                    $_carry_left = 0;
                $_carry_right = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[3]["_today_right"];
                if ($_carry_right < 0)
                    $_carry_right = 0;

                $anode[3]["_carry_left"] = $_carry_left;
                $anode[3]["_carry_right"] = $_carry_right;

                $anode[3]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[3]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

                // openman
                if ($distDB->getDistributorId() == 273056 && $this->getUser()->getAttribute(Globals::SESSION_DISTID) != 273056) {
                    $anode[3]["_right_this_month_sales"] = 0;
                    $anode[3]["_accumulate_right"] = 0;
                    $anode[3]["_today_right"] = 0;
                    $anode[3]["_carry_right"] = 0;
                    $anode[3]["_sales_right"] = 0;
                }
            }
            if ($rightFourPlacement == null) {
                $anode[4]["distCode"] = "";
                $anode[4]["_self"] = new MlmDistributor();
                $anode[4]["_left"] = null;
                $anode[4]["_right"] = null;
                $anode[4]["_available"] = true;
                $anode[4]["_left_this_month_sales"] = null;
                $anode[4]["_right_this_month_sales"] = null;
                $anode[4]["_dist_pairing_ledger"] = null;
                $anode[4]["_accumulate_left"] = null;
                $anode[4]["_accumulate_right"] = null;
                $anode[4]["_today_left"] = null;
                $anode[4]["_today_right"] = null;
                $anode[4]["_carry_left"] = null;
                $anode[4]["_carry_right"] = null;
                $anode[4]["_sales_left"] = null;
                $anode[4]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($rightFourPlacement->getDistributorCode());
                $anode[4]["distCode"] = $rightFourPlacement->getDistributorCode();
                $anode[4]["_self"] = $distDB;
                $anode[4]["_left"] = null;
                $anode[4]["_right"] = null;
                $anode[4]["_available"] = false;
                $anode[4]["_left_this_month_sales"] = $this->getThisMonthSales($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[4]["_right_this_month_sales"] = $this->getThisMonthSales($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[4]["_dist_pairing_ledger"] = $this->queryDistPairing($rightFourPlacement->getDistributorId());
                $anode[4]["_accumulate_left"] = $this->getAccumulateGroupBvs($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[4]["_accumulate_right"] = $this->getAccumulateGroupBvs($rightFourPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[4]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[4]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

                $_carry_left = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[4]["_today_left"];
                if ($_carry_left < 0)
                    $_carry_left = 0;
                $_carry_right = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[4]["_today_right"];
                if ($_carry_right < 0)
                    $_carry_right = 0;

                $anode[4]["_carry_left"] = $_carry_left;
                $anode[4]["_carry_right"] = $_carry_right;

                $anode[4]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[4]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

                // openman
                if ($distDB->getDistributorId() == 273056 && $this->getUser()->getAttribute(Globals::SESSION_DISTID) != 273056) {
                    $anode[4]["_right_this_month_sales"] = 0;
                    $anode[4]["_accumulate_right"] = 0;
                    $anode[4]["_today_right"] = 0;
                    $anode[4]["_carry_right"] = 0;
                    $anode[4]["_sales_right"] = 0;
                }
            }
        }

        if ($rightTwoPlacement == null) {
            $anode[2]["distCode"] = "";
            $anode[2]["_self"] = new MlmDistributor();
            $anode[2]["_left"] = null;
            $anode[2]["_right"] = null;
            $anode[2]["_available"] = true;
            $anode[2]["_left_this_month_sales"] = null;
            $anode[2]["_right_this_month_sales"] = null;
            $anode[2]["_dist_pairing_ledger"] = null;
            $anode[2]["_accumulate_left"] = null;
            $anode[2]["_accumulate_right"] = null;
            $anode[2]["_today_left"] = null;
            $anode[2]["_today_right"] = null;
            $anode[2]["_carry_left"] = null;
            $anode[2]["_carry_right"] = null;
            $anode[2]["_sales_left"] = null;
            $anode[2]["_sales_right"] = null;

            $anode[5]["distCode"] = "";
            $anode[5]["_self"] = new MlmDistributor();
            $anode[5]["_left"] = null;
            $anode[5]["_right"] = null;
            $anode[5]["_available"] = false;
            $anode[5]["_left_this_month_sales"] = null;
            $anode[5]["_right_this_month_sales"] = null;
            $anode[5]["_dist_pairing_ledger"] = null;
            $anode[5]["_accumulate_left"] = null;
            $anode[5]["_accumulate_right"] = null;
            $anode[5]["_today_left"] = null;
            $anode[5]["_today_right"] = null;
            $anode[5]["_carry_left"] = null;
            $anode[5]["_carry_right"] = null;
            $anode[5]["_sales_left"] = null;
            $anode[5]["_sales_right"] = null;

            $anode[6]["distCode"] = "";
            $anode[6]["_self"] = new MlmDistributor();
            $anode[6]["_left"] = null;
            $anode[6]["_right"] = null;
            $anode[6]["_available"] = false;
            $anode[6]["_left_this_month_sales"] = null;
            $anode[6]["_right_this_month_sales"] = null;
            $anode[6]["_dist_pairing_ledger"] = null;
            $anode[6]["_accumulate_left"] = null;
            $anode[6]["_accumulate_right"] = null;
            $anode[6]["_today_left"] = null;
            $anode[6]["_today_right"] = null;
            $anode[6]["_carry_left"] = null;
            $anode[6]["_carry_right"] = null;
            $anode[6]["_sales_left"] = null;
            $anode[6]["_sales_right"] = null;
        } else {
            $distDB = $this->getDistributorInformation($rightTwoPlacement->getDistributorCode());
            $leftFivePlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $rightSixPlacement = $this->getPlacementDistributorInformation($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $anode[2]["distCode"] = $rightTwoPlacement->getDistributorCode();
            $anode[2]["_self"] = $distDB;
            $anode[2]["_left"] = $leftFivePlacement;
            $anode[2]["_right"] = $rightSixPlacement;
            $anode[2]["_available"] = false;
            $anode[2]["_left_this_month_sales"] = $this->getThisMonthSales($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[2]["_right_this_month_sales"] = $this->getThisMonthSales($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[2]["_dist_pairing_ledger"] = $this->queryDistPairing($rightTwoPlacement->getDistributorId());
            $anode[2]["_accumulate_left"] = $this->getAccumulateGroupBvs($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[2]["_accumulate_right"] = $this->getAccumulateGroupBvs($rightTwoPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
            $anode[2]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
            $anode[2]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

            $_carry_left = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[2]["_today_left"];
            if ($_carry_left < 0)
                $_carry_left = 0;
            $_carry_right = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[2]["_today_right"];
            if ($_carry_right < 0)
                $_carry_right = 0;

            $anode[2]["_carry_left"] = $_carry_left;
            $anode[2]["_carry_right"] = $_carry_right;

            $anode[2]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
            $anode[2]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

            // openman
            if ($distDB->getDistributorId() == 273056 && $this->getUser()->getAttribute(Globals::SESSION_DISTID) != 273056) {
                $anode[2]["_right_this_month_sales"] = 0;
                $anode[2]["_accumulate_right"] = 0;
                $anode[2]["_today_right"] = 0;
                $anode[2]["_carry_right"] = 0;
                $anode[2]["_sales_right"] = 0;
            }
            if ($leftFivePlacement == null) {
                $anode[5]["distCode"] = "";
                $anode[5]["_self"] = new MlmDistributor();
                $anode[5]["_left"] = null;
                $anode[5]["_right"] = null;
                $anode[5]["_available"] = true;
                $anode[5]["_left_this_month_sales"] = null;
                $anode[5]["_right_this_month_sales"] = null;
                $anode[5]["_dist_pairing_ledger"] = null;
                $anode[5]["_accumulate_left"] = null;
                $anode[5]["_accumulate_right"] = null;
                $anode[5]["_today_left"] = null;
                $anode[5]["_today_right"] = null;
                $anode[5]["_carry_left"] = null;
                $anode[5]["_carry_right"] = null;
                $anode[5]["_sales_left"] = null;
                $anode[5]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($leftFivePlacement->getDistributorCode());
                $anode[5]["distCode"] = $leftFivePlacement->getDistributorCode();
                $anode[5]["_self"] = $distDB;
                $anode[5]["_left"] = null;
                $anode[5]["_right"] = null;
                $anode[5]["_available"] = false;
                $anode[5]["_left_this_month_sales"] = $this->getThisMonthSales($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[5]["_right_this_month_sales"] = $this->getThisMonthSales($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[5]["_dist_pairing_ledger"] = $this->queryDistPairing($leftFivePlacement->getDistributorId());
                $anode[5]["_accumulate_left"] = $this->getAccumulateGroupBvs($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[5]["_accumulate_right"] = $this->getAccumulateGroupBvs($leftFivePlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[5]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[5]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

                $_carry_left = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[5]["_today_left"];
                if ($_carry_left < 0)
                    $_carry_left = 0;
                $_carry_right = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[5]["_today_right"];
                if ($_carry_right < 0)
                    $_carry_right = 0;

                $anode[5]["_carry_left"] = $_carry_left;
                $anode[5]["_carry_right"] = $_carry_right;

                $anode[5]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[5]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

                // openman
                if ($distDB->getDistributorId() == 273056 && $this->getUser()->getAttribute(Globals::SESSION_DISTID) != 273056) {
                    $anode[5]["_right_this_month_sales"] = 0;
                    $anode[5]["_accumulate_right"] = 0;
                    $anode[5]["_today_right"] = 0;
                    $anode[5]["_carry_right"] = 0;
                    $anode[5]["_sales_right"] = 0;
                }
            }
            if ($rightSixPlacement == null) {
                $anode[6]["distCode"] = "";
                $anode[6]["_self"] = new MlmDistributor();
                $anode[6]["_left"] = null;
                $anode[6]["_right"] = null;
                $anode[6]["_available"] = true;
                $anode[6]["_left_this_month_sales"] = null;
                $anode[6]["_right_this_month_sales"] = null;
                $anode[6]["_dist_pairing_ledger"] = null;
                $anode[6]["_accumulate_left"] = null;
                $anode[6]["_accumulate_right"] = null;
                $anode[6]["_today_left"] = null;
                $anode[6]["_today_right"] = null;
                $anode[6]["_carry_left"] = null;
                $anode[6]["_carry_right"] = null;
                $anode[6]["_sales_left"] = null;
                $anode[6]["_sales_right"] = null;
            } else {
                $distDB = $this->getDistributorInformation($rightSixPlacement->getDistributorCode());
                $anode[6]["distCode"] = $rightSixPlacement->getDistributorCode();
                $anode[6]["_self"] = $distDB;
                $anode[6]["_left"] = null;
                $anode[6]["_right"] = null;
                $anode[6]["_available"] = false;
                $anode[6]["_left_this_month_sales"] = $this->getThisMonthSales($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[6]["_right_this_month_sales"] = $this->getThisMonthSales($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[6]["_dist_pairing_ledger"] = $this->queryDistPairing($rightSixPlacement->getDistributorId());
                $anode[6]["_accumulate_left"] = $this->getAccumulateGroupBvs($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[6]["_accumulate_right"] = $this->getAccumulateGroupBvs($rightSixPlacement->getDistributorId(), Globals::PLACEMENT_RIGHT);
                $anode[6]["_today_left"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_LEFT);
                $anode[6]["_today_right"] = $this->getTodaySales($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT);

                $_carry_left = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null) - $anode[6]["_today_left"];
                if ($_carry_left < 0)
                    $_carry_left = 0;
                $_carry_right = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null) - $anode[6]["_today_right"];
                if ($_carry_right < 0)
                    $_carry_right = 0;

                $anode[6]["_carry_left"] = $_carry_left;
                $anode[6]["_carry_right"] = $_carry_right;
                $anode[6]["_sales_left"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_LEFT, null);
                $anode[6]["_sales_right"] = $this->findPairingLedgers($distDB->getDistributorId(), Globals::PLACEMENT_RIGHT, null);

                // openman
                if ($distDB->getDistributorId() == 273056 && $this->getUser()->getAttribute(Globals::SESSION_DISTID) != 273056) {
                    $anode[6]["_right_this_month_sales"] = 0;
                    $anode[6]["_accumulate_right"] = 0;
                    $anode[6]["_today_right"] = 0;
                    $anode[6]["_carry_right"] = 0;
                    $anode[6]["_sales_right"] = 0;
                }
            }
        }

        $this->distcode = $distcode;
        $this->anode = $anode;
        $this->colorArr = $this->getRankColorArr();

        $isTop = false;
        if (strtoupper($distcode) == strtoupper($this->getUser()->getAttribute(Globals::SESSION_DISTCODE))) {
            $isTop = true;
        }
        $this->isTop = $isTop;

        if ($pageDirection == "stat") {
            $this->setTemplate('placementTreeStat');
        }
    }

    public function executePendingMemberList()
    {
        $sColumns = $this->getRequestParameter('sColumns');
        $aColumns = explode(",", $sColumns);

        $iColumns = $this->getRequestParameter('iColumns');

        $offset = $this->getRequestParameter('iDisplayStart');
        $sEcho = $this->getRequestParameter('sEcho');
        $limit = $this->getRequestParameter('iDisplayLength');
        $arr = array();

        /******   total records  *******/
        $c = new Criteria();
        $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_LEVEL, null, Criteria::ISNULL);
        $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, null, Criteria::ISNULL);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, null, Criteria::ISNULL);
        $totalRecords = MlmDistributorPeer::doCount($c);

        /******   total filtered records  *******/
        if ($this->getRequestParameter('filterFullname') != "") {
            $c->addAnd(MlmDistributorPeer::FULL_NAME, "%" . $this->getRequestParameter('filterFullname') . "%", Criteria::LIKE);
        }
        if ($this->getRequestParameter('filterNickname') != "") {
            $c->addAnd(MlmDistributorPeer::NICKNAME, "%" . $this->getRequestParameter('filterNickname') . "%", Criteria::LIKE);
        }
        $totalFilteredRecords = MlmDistributorPeer::doCount($c);

        /******   sorting  *******/
        for ($i = 0; $i < intval($this->getRequestParameter('iSortingCols')); $i++)
        {
            if ($this->getRequestParameter('bSortable_' . intval($this->getRequestParameter('iSortCol_' . $i))) == "true") {
                if ("asc" == $this->getRequestParameter('sSortDir_' . $i)) {
                    $c->addAscendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                } else {
                    $c->addDescendingOrderByColumn($aColumns[intval($this->getRequestParameter('iSortCol_' . $i))]);
                }
            }
        }

        /******   pagination  *******/
        $pager = new sfPropelPager('MlmDistributor', $limit);
        $pager->setCriteria($c);
        $pager->setPage(($offset / $limit) + 1);
        $pager->init();

        foreach ($pager->getResults() as $result) {
            $arr[] = array(
                $result->getDistributorId() == null ? "" : $result->getDistributorId(),
                $result->getDistributorId() == null ? "" : $result->getDistributorId(),
                $result->getCreatedOn() == null ? "" : $result->getActiveDatetime(),
                $result->getDistributorCode() == null ? "" : $result->getDistributorCode(),
                $result->getFullName() == null ? "" : $result->getFullName(),
                $result->getFullName() == null ? "" : $result->getFullName(),
                $result->getIc() == null ? "" : $result->getIc(),
                $result->getRankCode() == null ? "" : $result->getRankCode(),
            );
        }
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalFilteredRecords,
            "aaData" => $arr
        );
        echo json_encode($output);

        return sfView::HEADER_ONLY;
    }

    public function executeTransferEcash()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            return $this->redirect('/member/summary');
        }
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $processFee = 0;
        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_TRANSFER_PROCESS_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $processFee = $settingDB->getSettingValue();
        }*/
        $this->processFee = $processFee;

        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('ecashAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("This function temporary out of service."));
                return $this->redirect('/member/transferEcash');
            }

            $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (($this->getRequestParameter('ecashAmount') + $processFee) > $ledgerAccountBalance) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient MT4 Credit Amount"));

            } elseif (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif (strtoupper($this->getRequestParameter('sponsorId')) == $this->getUser()->getAttribute(Globals::SESSION_DISTCODE)) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You are not allow to transfer to own account."));

            } elseif ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('ecashAmount') > 0) {

                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('sponsorId'));
                $existDist = MlmDistributorPeer::doSelectOne($c);

                $c = new Criteria();
                $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
                $c->addAnd(MlmAccountPeer::DIST_ID, $existDist->getDistributorId());
                $toAccount = MlmAccountPeer::doSelectOne($c);

                $toId = $existDist->getDistributorId();
                $toCode = $existDist->getDistributorCode();
                $toName = $existDist->getFullName();
                $toBalance = $toAccount->getBalance();
                $fromId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                $fromCode = $this->getUser()->getAttribute(Globals::SESSION_DISTCODE);
                $fromName = $this->getUser()->getAttribute(Globals::SESSION_NICKNAME);
                $fromBalance = $ledgerAccountBalance;

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setDistId($fromId);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
                $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")");
                $mlm_account_ledger->setCredit(0);
                $mlm_account_ledger->setDebit($this->getRequestParameter('ecashAmount'));
                $mlm_account_ledger->setBalance($fromBalance - $this->getRequestParameter('ecashAmount'));
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($toId);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " " . $fromCode . " (" . $fromName . ")");
                $tbl_account_ledger->setCredit($this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($toBalance + $this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_ECASH);

                // ******       processing fees      ****************
                /*$tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($fromId);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ") PROCESS CHARGES");
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($processFee);
                $tbl_account_ledger->setBalance($fromBalance - ($this->getRequestParameter('ecashAmount') + $processFee));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);*/

                // ******       company account      ****************
                /*$c = new Criteria();
                $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
                $c->addAnd(MlmAccountPeer::DIST_ID, Globals::SYSTEM_COMPANY_DIST_ID);
                $companyAccount = MlmAccountPeer::doSelectOne($c);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE . " " . $fromCode . " -> " . $toCode);
                $tbl_account_ledger->setCredit($processFee);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($companyAccount->getBalance() + $processFee);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);*/

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transfer success"));

                return $this->redirect('/member/transferEcash');
            }
        }
    }

    public function executeTransferEpoint()
    {
        $this->toHideCp2Cp3Transfer = false;
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
        }
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $processFee = 0;
        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_TRANSFER_PROCESS_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $processFee = $settingDB->getSettingValue();
        }*/
        $this->processFee = $processFee;

        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), null, null, null, null, null, Globals::YES_Y, null, null)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("CP1 Transfer temporary out of service."));
                return $this->redirect('/member/transferEpoint');
            }

            /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', "This function temporary out of service.");
                return $this->redirect('/member/transferEpoint');
            }*/
            $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            $sponsorId = $this->getRequestParameter('sponsorId');

            //if ($this->getUser()->getAttribute(Globals::SESSION_USERNAME) == "thorsengwah") {
                $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname, dist.PLACEMENT_TREE_STRUCTURE, dist.TREE_STRUCTURE
            FROM mlm_distributor dist
                LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                    WHERE appUser.username = '".$sponsorId."'";
//                        WHERE appUser.username = '".$sponsorId."' AND dist.TREE_STRUCTURE LIKE '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

                $arr = "";

                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $resultset = $statement->executeQuery();
                $isFound = false;

                if ($resultset->next()) {
                    $resultArr = $resultset->getRow();

                    $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                    if ($pos === false) { // note: three equal signs
                        $pos = strrpos($resultArr["TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                        if ($pos === false) { // note: three equal signs

                        } else {
                            $isFound = true;
                        }
                    } else {
                        $isFound = true;
                    }

                    if ($isFound == false) {
                        $existDist = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                        if ($existDist) {
                            $pos = strrpos($existDist->getPlacementTreeStructure(), "|".$resultArr["distributor_id"]."|");
                            if ($pos === false) { // note: three equal signs
                                $pos = strrpos($existDist->getTreeStructure(), "|".$resultArr["distributor_id"]."|");
                                if ($pos === false) { // note: three equal signs
                                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                                    return $this->redirect('/member/transferEpoint');
                                }
                            }
                        }
                    }

                    // block worldpeace upline transfer worldpeace downline
                    $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|557|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $worldPeaceDist = MlmDistributorPeer::retrieveByPK(557);

                        $worldPeacePlacementTreeLevel = $worldPeaceDist->getPlacementTreeLevel();

                        if ($distDB->getPlacementTreeLevel() < $worldPeacePlacementTreeLevel) {
                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You do not have the right to proceed this action."));
                            return $this->redirect('/member/transferEpoint');
                        }
                    }
                } else {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                    return $this->redirect('/member/transferEpoint');
                }
            //}

            if (($this->getRequestParameter('epointAmount') + $processFee) > $ledgerAccountBalance) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1"));
                return $this->redirect('/member/transferEpoint');

            } elseif (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));
                return $this->redirect('/member/transferEpoint');

            } elseif (strtoupper($sponsorId) == strtoupper($this->getUser()->getAttribute(Globals::SESSION_DISTCODE))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You are not allow to transfer to own account."));
                return $this->redirect('/member/transferEpoint');

            } elseif ($sponsorId <> "" && $this->getRequestParameter('epointAmount') > 0) {

                /*$c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
                $existDist = MlmDistributorPeer::doSelectOne($c);*/

                $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
                try {
                    $con->begin();

                    $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname
                    FROM mlm_distributor dist
                        LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                            WHERE appUser.username = '" . $sponsorId . "'";


                    $connection = Propel::getConnection();
                    $statement = $connection->prepareStatement($query);
                    $resultset = $statement->executeQuery();

                    $toId = "";
                    $toCode = "";
                    $toName = "";

                    if ($resultset->next()) {
                        $resultArr = $resultset->getRow();

                        $toId = $resultArr["distributor_id"];
                        $toCode = $resultArr["distributor_code"];
                        $toName = $resultArr["full_name"];
                    } else {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid User Name."));
                        return $this->redirect('/member/transferEpoint');
                    }

                    $c = new Criteria();
                    $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
                    $c->addAnd(MlmAccountPeer::DIST_ID, $toId);
                    $toAccount = MlmAccountPeer::doSelectOne($c);

                    if (!$toAccount) {
                        $toAccount = new MlmAccount();

                        $toAccount->setDistId($toId);
                        $toAccount->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $toAccount->setBalance(0);
                        $toAccount->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->save();
                    }


                    $toBalance = $toAccount->getBalance();
                    $fromId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                    $fromCode = $this->getUser()->getAttribute(Globals::SESSION_DISTCODE);
                    $fromName = $this->getUser()->getAttribute(Globals::SESSION_NICKNAME);
                    $fromBalance = $ledgerAccountBalance;

                    $remark = "";
                    if ($this->getRequestParameter('remark')) {
                        $remark = ", ".$this->getRequestParameter('remark');
                    }

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $mlm_account_ledger->setDistId($fromId);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
                    $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")".$remark);
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setBalance($fromBalance - $this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_EPOINT);

                    $tbl_account_ledger = new MlmAccountLedger();
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $tbl_account_ledger->setDistId($toId);
                    $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
                    $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " " . $fromCode . " (" . $fromName . ")".$remark);
                    $tbl_account_ledger->setCredit($this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setDebit(0);
                    $tbl_account_ledger->setBalance($toBalance + $this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->save();

                    $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_EPOINT);

                    // ******       processing fees      ****************
                    /*$tbl_account_ledger = new MlmAccountLedger();
                   $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                   $tbl_account_ledger->setDistId($fromId);
                   $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE);
                   $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ") PROCESS CHARGES");
                   $tbl_account_ledger->setCredit(0);
                   $tbl_account_ledger->setDebit($processFee);
                   $tbl_account_ledger->setBalance($fromBalance - ($this->getRequestParameter('ecashAmount') + $processFee));
                   $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->save();

                   $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);*/

                    // ******       company account      ****************
                    /*$c = new Criteria();
                   $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
                   $c->addAnd(MlmAccountPeer::DIST_ID, Globals::SYSTEM_COMPANY_DIST_ID);
                   $companyAccount = MlmAccountPeer::doSelectOne($c);

                   $tbl_account_ledger = new MlmAccountLedger();
                   $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                   $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                   $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER);
                   $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE . " " . $fromCode . " -> " . $toCode);
                   $tbl_account_ledger->setCredit($processFee);
                   $tbl_account_ledger->setDebit(0);
                   $tbl_account_ledger->setBalance($companyAccount->getBalance() + $processFee);
                   $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->save();

                   $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);*/
                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transfer success"));

                return $this->redirect('/member/transferEpoint');
            }
        }
    }

    public function executeTransferCp2()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
        }

        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $processFee = 0;
        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_TRANSFER_PROCESS_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $processFee = $settingDB->getSettingValue();
        }*/
        $this->processFee = $processFee;

        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), null, null, null, null, null, null, Globals::YES_Y, null)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("CP2 Transfer temporary out of service."));
                return $this->redirect('/member/transferCp2');
            }
            /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("This function temporary out of service."));
                return $this->redirect('/member/transferCp2');
            }*/

            $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            $sponsorId = $this->getRequestParameter('sponsorId');

            //if ($this->getUser()->getAttribute(Globals::SESSION_USERNAME) == "thorsengwah") {
                $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname, dist.PLACEMENT_TREE_STRUCTURE, dist.TREE_STRUCTURE
            FROM mlm_distributor dist
                LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                    WHERE appUser.username = '".$sponsorId."'";
//                        WHERE appUser.username = '".$sponsorId."' AND dist.TREE_STRUCTURE LIKE '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

                $arr = "";

                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $resultset = $statement->executeQuery();
                $isFound = false;

                if ($resultset->next()) {
                    $resultArr = $resultset->getRow();

                    $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                    if ($pos === false) { // note: three equal signs
                        $pos = strrpos($resultArr["TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                        if ($pos === false) { // note: three equal signs

                        } else {
                            $isFound = true;
                        }
                    } else {
                        $isFound = true;
                    }

                    if ($isFound == false) {
                        $existDist = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                        if ($existDist) {
                            $pos = strrpos($existDist->getPlacementTreeStructure(), "|".$resultArr["distributor_id"]."|");
                            if ($pos === false) { // note: three equal signs
                                $pos = strrpos($existDist->getTreeStructure(), "|".$resultArr["distributor_id"]."|");
                                if ($pos === false) { // note: three equal signs
                                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                                    return $this->redirect('/member/transferCp2');
                                }
                            }
                        }
                    }

                    // block worldpeace upline transfer worldpeace downline
                    $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|557|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $worldPeaceDist = MlmDistributorPeer::retrieveByPK(557);

                        $worldPeacePlacementTreeLevel = $worldPeaceDist->getPlacementTreeLevel();

                        if ($distDB->getPlacementTreeLevel() < $worldPeacePlacementTreeLevel) {
                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You do not have the right to proceed this action."));
                            return $this->redirect('/member/transferCp2');
                        }
                    }
                } else {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                    return $this->redirect('/member/transferCp2');
                }
            //}

            if (($this->getRequestParameter('epointAmount') + $processFee) > $ledgerAccountBalance) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1"));
                return $this->redirect('/member/transferCp2');

            } elseif (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));
                return $this->redirect('/member/transferCp2');

            } elseif (strtoupper($sponsorId) == strtoupper($this->getUser()->getAttribute(Globals::SESSION_DISTCODE))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You are not allow to transfer to own account."));
                return $this->redirect('/member/transferCp2');

            } elseif ($sponsorId <> "" && $this->getRequestParameter('epointAmount') > 0) {

                /*$c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
                $existDist = MlmDistributorPeer::doSelectOne($c);*/
                $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
                try {
                    $con->begin();

                    $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname
                    FROM mlm_distributor dist
                        LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                            WHERE appUser.username = '" . $sponsorId . "'";


                    $connection = Propel::getConnection();
                    $statement = $connection->prepareStatement($query);
                    $resultset = $statement->executeQuery();

                    $toId = "";
                    $toCode = "";
                    $toName = "";

                    if ($resultset->next()) {
                        $resultArr = $resultset->getRow();

                        $toId = $resultArr["distributor_id"];
                        $toCode = $resultArr["distributor_code"];
                        $toName = $resultArr["full_name"];
                    } else {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid User Name."));
                        return $this->redirect('/member/transferCp2');
                    }

                    $c = new Criteria();
                    $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
                    $c->addAnd(MlmAccountPeer::DIST_ID, $toId);
                    $toAccount = MlmAccountPeer::doSelectOne($c);

                    if (!$toAccount) {
                        $toAccount = new MlmAccount();

                        $toAccount->setDistId($toId);
                        $toAccount->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $toAccount->setBalance(0);
                        $toAccount->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->save();
                    }


                    $toBalance = $this->getAccountBalance($toId, Globals::ACCOUNT_TYPE_ECASH);
                    $fromId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                    $fromCode = $this->getUser()->getAttribute(Globals::SESSION_DISTCODE);
                    $fromName = $this->getUser()->getAttribute(Globals::SESSION_NICKNAME);
                    $fromBalance = $ledgerAccountBalance;

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $mlm_account_ledger->setDistId($fromId);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
                    $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")");
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setBalance($fromBalance - $this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);

                    $tbl_account_ledger = new MlmAccountLedger();
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                    $tbl_account_ledger->setDistId($toId);
                    $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
                    $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " " . $fromCode . " (" . $fromName . ")");
                    $tbl_account_ledger->setCredit($this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setDebit(0);
                    $tbl_account_ledger->setBalance($toBalance + $this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->save();

                    $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_ECASH);

                    // ******       processing fees      ****************
                    /*$tbl_account_ledger = new MlmAccountLedger();
                   $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                   $tbl_account_ledger->setDistId($fromId);
                   $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE);
                   $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ") PROCESS CHARGES");
                   $tbl_account_ledger->setCredit(0);
                   $tbl_account_ledger->setDebit($processFee);
                   $tbl_account_ledger->setBalance($fromBalance - ($this->getRequestParameter('ecashAmount') + $processFee));
                   $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->save();

                   $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);*/

                    // ******       company account      ****************
                    /*$c = new Criteria();
                   $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
                   $c->addAnd(MlmAccountPeer::DIST_ID, Globals::SYSTEM_COMPANY_DIST_ID);
                   $companyAccount = MlmAccountPeer::doSelectOne($c);

                   $tbl_account_ledger = new MlmAccountLedger();
                   $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                   $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                   $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER);
                   $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE . " " . $fromCode . " -> " . $toCode);
                   $tbl_account_ledger->setCredit($processFee);
                   $tbl_account_ledger->setDebit(0);
                   $tbl_account_ledger->setBalance($companyAccount->getBalance() + $processFee);
                   $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->save();

                   $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);*/
                    $con->commit();
                    $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transfer success"));

                    return $this->redirect('/member/transferCp2');

                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
            }
        }
    }

    public function executeTransferCp3()
    {
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
        }
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $processFee = 0;
        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_TRANSFER_PROCESS_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $processFee = $settingDB->getSettingValue();
        }*/
        $this->processFee = $processFee;

        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), null, null, null, null, null, null, null, Globals::YES_Y)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("CP3 Transfer temporary out of service."));
                return $this->redirect('/member/transferCp3');
            }
            $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            /*$pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("This function temporary out of service."));
                return $this->redirect('/member/transferCp3');
            }*/

            $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            $sponsorId = $this->getRequestParameter('sponsorId');

            //if ($this->getUser()->getAttribute(Globals::SESSION_USERNAME) == "thorsengwah") {
                $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname, dist.PLACEMENT_TREE_STRUCTURE, dist.TREE_STRUCTURE
            FROM mlm_distributor dist
                LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                    WHERE appUser.username = '".$sponsorId."'";
//                        WHERE appUser.username = '".$sponsorId."' AND dist.TREE_STRUCTURE LIKE '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

                $arr = "";

                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $resultset = $statement->executeQuery();
                $isFound = false;

                if ($resultset->next()) {
                    $resultArr = $resultset->getRow();

                    $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                    if ($pos === false) { // note: three equal signs
                        $pos = strrpos($resultArr["TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                        if ($pos === false) { // note: three equal signs

                        } else {
                            $isFound = true;
                        }
                    } else {
                        $isFound = true;
                    }

                    if ($isFound == false) {
                        $existDist = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                        if ($existDist) {
                            $pos = strrpos($existDist->getPlacementTreeStructure(), "|".$resultArr["distributor_id"]."|");
                            if ($pos === false) { // note: three equal signs
                                $pos = strrpos($existDist->getTreeStructure(), "|".$resultArr["distributor_id"]."|");
                                if ($pos === false) { // note: three equal signs
                                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                                    return $this->redirect('/member/transferCp3');
                                }
                                //$this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                                //return $this->redirect('/member/transferCp3');
                            }
                        }
                    }

                    // block worldpeace upline transfer worldpeace downline
                    $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|557|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $worldPeaceDist = MlmDistributorPeer::retrieveByPK(557);

                        $worldPeacePlacementTreeLevel = $worldPeaceDist->getPlacementTreeLevel();

                        if ($distDB->getPlacementTreeLevel() < $worldPeacePlacementTreeLevel) {
                            $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You do not have the right to proceed this action."));
                            return $this->redirect('/member/transferCp3');
                        }
                    }
                } else {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                    return $this->redirect('/member/transferCp3');
                }
            //}

            if (($this->getRequestParameter('epointAmount') + $processFee) > $ledgerAccountBalance) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1"));
                return $this->redirect('/member/transferCp3');

            } elseif (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));
                return $this->redirect('/member/transferCp3');

            } elseif (strtoupper($sponsorId) == strtoupper($this->getUser()->getAttribute(Globals::SESSION_DISTCODE))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You are not allow to transfer to own account."));
                return $this->redirect('/member/transferCp3');

            } elseif ($sponsorId <> "" && $this->getRequestParameter('epointAmount') > 0) {

                /*$c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorId);
                $existDist = MlmDistributorPeer::doSelectOne($c);*/
                $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
                try {
                    $con->begin();
                    $query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname
                    FROM mlm_distributor dist
                        LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                            WHERE appUser.username = '" . $sponsorId . "'";


                    $connection = Propel::getConnection();
                    $statement = $connection->prepareStatement($query);
                    $resultset = $statement->executeQuery();

                    $toId = "";
                    $toCode = "";
                    $toName = "";

                    if ($resultset->next()) {
                        $resultArr = $resultset->getRow();

                        $toId = $resultArr["distributor_id"];
                        $toCode = $resultArr["distributor_code"];
                        $toName = $resultArr["full_name"];
                    } else {
                        $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid User Name."));
                        return $this->redirect('/member/transferCp3');
                    }

                    $c = new Criteria();
                    $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $c->addAnd(MlmAccountPeer::DIST_ID, $toId);
                    $toAccount = MlmAccountPeer::doSelectOne($c);

                    if (!$toAccount) {
                        $toAccount = new MlmAccount();

                        $toAccount->setDistId($toId);
                        $toAccount->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                        $toAccount->setBalance(0);
                        $toAccount->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->save();
                    }


                    $toBalance = $this->getAccountBalance($toId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $fromId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                    $fromCode = $this->getUser()->getAttribute(Globals::SESSION_DISTCODE);
                    $fromName = $this->getUser()->getAttribute(Globals::SESSION_NICKNAME);
                    $fromBalance = $ledgerAccountBalance;

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $mlm_account_ledger->setDistId($fromId);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
                    $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")");
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setBalance($fromBalance - $this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                    $tbl_account_ledger = new MlmAccountLedger();
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $tbl_account_ledger->setDistId($toId);
                    $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
                    $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " " . $fromCode . " (" . $fromName . ")");
                    $tbl_account_ledger->setCredit($this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setDebit(0);
                    $tbl_account_ledger->setBalance($toBalance + $this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->save();

                    $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                    // ******       processing fees      ****************
                    /*$tbl_account_ledger = new MlmAccountLedger();
                   $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                   $tbl_account_ledger->setDistId($fromId);
                   $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE);
                   $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ") PROCESS CHARGES");
                   $tbl_account_ledger->setCredit(0);
                   $tbl_account_ledger->setDebit($processFee);
                   $tbl_account_ledger->setBalance($fromBalance - ($this->getRequestParameter('ecashAmount') + $processFee));
                   $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->save();

                   $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_ECASH);*/

                    // ******       company account      ****************
                    /*$c = new Criteria();
                   $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
                   $c->addAnd(MlmAccountPeer::DIST_ID, Globals::SYSTEM_COMPANY_DIST_ID);
                   $companyAccount = MlmAccountPeer::doSelectOne($c);

                   $tbl_account_ledger = new MlmAccountLedger();
                   $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                   $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                   $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER);
                   $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_PROCESS_CHARGE . " " . $fromCode . " -> " . $toCode);
                   $tbl_account_ledger->setCredit($processFee);
                   $tbl_account_ledger->setDebit(0);
                   $tbl_account_ledger->setBalance($companyAccount->getBalance() + $processFee);
                   $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                   $tbl_account_ledger->save();

                   $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_EPOINT);*/
                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transfer success"));

                return $this->redirect('/member/transferCp3');
            }
        }
    }

    public function executeTransferRP()
    {
        $rp = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_RP);
        //$debitAccount = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_DEBIT);

        $ledgerAccountBalance = $rp;
        //$ledgerAccountBalance = $rp - $debitAccount;
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        if ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::YES_Y, null, null, null, null, null, null, null)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("RP Transfer temporary out of service."));
                return $this->redirect('/member/convertRPToCp1');
            }
            if ($this->getUser()->getAttribute(Globals::SESSION_DISTID) == 262) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Convert RP To CP1 temporary out of service."));
                return $this->redirect('/member/convertRPToCp1');
            }
            /*if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID))) {
                $this->setFlash('errorMsg', "RP Transfer temporary out of service.");
                return $this->redirect('/member/transferRP');
            }*/

            $appUser = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            $sponsorId = $this->getRequestParameter('sponsorId');
            //if ($this->getUser()->getAttribute(Globals::SESSION_USERNAME) == "thorsengwah") {
                /*$query = "SELECT dist.distributor_id, dist.distributor_code, dist.full_name, dist.nickname, dist.PLACEMENT_TREE_STRUCTURE, dist.TREE_STRUCTURE
            FROM mlm_distributor dist
                LEFT JOIN app_user appUser ON appUser.user_id = dist.user_id
                    WHERE appUser.username = '".$sponsorId."'";
//                        WHERE appUser.username = '".$sponsorId."' AND dist.TREE_STRUCTURE LIKE '%|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|%'";

                $arr = "";

                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $resultset = $statement->executeQuery();
                $isFound = false;

                if ($resultset->next()) {
                    $resultArr = $resultset->getRow();

                    $pos = strrpos($resultArr["PLACEMENT_TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                    if ($pos === false) { // note: three equal signs
                        $pos = strrpos($resultArr["TREE_STRUCTURE"], "|".$this->getUser()->getAttribute(Globals::SESSION_DISTID)."|");
                        if ($pos === false) { // note: three equal signs

                        } else {
                            $isFound = true;
                        }
                    } else {
                        $isFound = true;
                    }

                    if ($isFound == false) {
                        $existDist = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                        if ($existDist) {
                            $pos = strrpos($existDist->getPlacementTreeStructure(), "|".$resultArr["distributor_id"]."|");
                            if ($pos === false) { // note: three equal signs
                                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                                return $this->redirect('/member/transferRP');
                            }
                        }
                    }
                } else {
                    $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Member ID."));
                    return $this->redirect('/member/transferRP');
                }*/
            //}
            if (($this->getRequestParameter('epointAmount')) > $ledgerAccountBalance) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient RP"));
                return $this->redirect('/member/transferRP');

            } elseif (strtoupper($appUser->getUserPassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));
                return $this->redirect('/member/transferRP');

            } elseif (strtoupper($this->getRequestParameter('sponsorId')) == strtoupper($this->getUser()->getAttribute(Globals::SESSION_DISTCODE))) {

                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("You are not allow to transfer to own account."));
                return $this->redirect('/member/transferRP');

            } elseif ($this->getRequestParameter('sponsorId') <> "" && $this->getRequestParameter('epointAmount') > 0) {
                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('sponsorId'));
                $existDist = MlmDistributorPeer::doSelectOne($c);

                $c = new Criteria();
                $c->add(MlmAccountPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
                $c->addAnd(MlmAccountPeer::DIST_ID, $existDist->getDistributorId());
                $toAccount = MlmAccountPeer::doSelectOne($c);

                $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
                try {
                    $con->begin();

                    if (!$toAccount) {
                        $toAccount = new MlmAccount();

                        $toAccount->setDistId($existDist->getDistributorId());
                        $toAccount->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $toAccount->setBalance(0);
                        $toAccount->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $toAccount->save();
                    }

                    $toId = $existDist->getDistributorId();
                    $toCode = $existDist->getDistributorCode();
                    $toName = $existDist->getFullName();
                    $toBalance = $toAccount->getBalance();
                    $fromId = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
                    $fromCode = $this->getUser()->getAttribute(Globals::SESSION_DISTCODE);
                    $fromName = $this->getUser()->getAttribute(Globals::SESSION_NICKNAME);
                    $fromBalance = $ledgerAccountBalance;

                    $remark = "";
                    if ($this->getRequestParameter('remark')) {
                        $remark = ", ".$this->getRequestParameter('remark');
                    }

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_RP);
                    $mlm_account_ledger->setDistId($fromId);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO);
                    $mlm_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_TO . " " . $toCode . " (" . $toName . ")".$remark);
                    $mlm_account_ledger->setCredit(0);
                    $mlm_account_ledger->setDebit($this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setBalance($fromBalance - $this->getRequestParameter('epointAmount'));
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $this->revalidateAccount($fromId, Globals::ACCOUNT_TYPE_RP);

                    $tbl_account_ledger = new MlmAccountLedger();
                    $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                    $tbl_account_ledger->setDistId($toId);
                    $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM);
                    $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_TRANSFER_FROM . " " . $fromCode . " (" . $fromName . ")".$remark);
                    $tbl_account_ledger->setCredit($this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setDebit(0);
                    $tbl_account_ledger->setBalance($toBalance + $this->getRequestParameter('epointAmount'));
                    $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->save();

                    $this->revalidateAccount($toId, Globals::ACCOUNT_TYPE_EPOINT);
                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Transfer success"));

                return $this->redirect('/member/transferRP');
            }
        }
    }

    public function executeEcashLog()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_WALLET, false) == false && $this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN, Globals::FALSE) == Globals::FALSE) {
            return $this->redirect('/member/securityPasswordRequired?doAction=W');
        }

        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_RP);

        $totalRp = MlmAccountLedgerPeer::doCount($c);
        $this->totalRp = $totalRp;
    }
    public function executeEpointLog()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_WALLET, false) == false && $this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN, Globals::FALSE) == Globals::FALSE) {
            return $this->redirect('/member/securityPasswordRequired?doAction=W');
        }

        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_RP);

        $totalRp = MlmAccountLedgerPeer::doCount($c);
        $this->totalRp = $totalRp;
    }
    public function executeRpLog()
    {
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_RP);

        $totalRp = MlmAccountLedgerPeer::doCount($c);

        if ($totalRp <= 0) {
            return $this->redirect('/member/summary');
        }
    }
    public function executeMaintenanceLog()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_WALLET, false) == false && $this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN, Globals::FALSE) == Globals::FALSE) {
            return $this->redirect('/member/securityPasswordRequired?doAction=W');
        }
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_RP);

        $totalRp = MlmAccountLedgerPeer::doCount($c);
        $this->totalRp = $totalRp;
    }

    public function executeFetchAnnouncementById()
    {
        $arr = "";
        if ($this->getRequestParameter('announcementId') <> "") {
            $announcement = MlmAnnouncementPeer::retrieveByPk($this->getRequestParameter('announcementId'));

            if ($announcement) {
                $title = $announcement->getTitle();
                $content = $announcement->getContent();
                if ($this->getUser()->getCulture() == 'cn') {
                    $title = $announcement->getTitleCn();
                    $content = $announcement->getContentCn();
                }
                $arr = array(
                    'title' => $title,
                    'content' => $content
                );
            }
        }

        echo json_encode($arr);
        return sfView::HEADER_ONLY;
    }

    public function executeLoginPassword()
    {
        if ($this->getRequestParameter('oldPassword')) {
            $c = new Criteria();
            $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
            $c->add(AppUserPeer::USERPASSWORD, $this->getRequestParameter('oldPassword'));
            $exist = AppUserPeer::doSelectOne($c);

            if (!$exist) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Old password is not valid."));
            } else {
                $exist->setUserpassword($this->getRequestParameter('newPassword'));
                $exist->setKeepPassword($this->getRequestParameter('newPassword'));
                $exist->save();
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Password updated"));
            }
            //return $this->redirect('/member/loginPassword');
        }
        return $this->redirect('/member/viewProfile');
    }

    public function executeSecurityPasswordRequired()
    {
        $doAction = $this->getRequestParameter('doAction', "VP");
        $this->doAction = $doAction;

        if ($this->getRequestParameter('transactionPassword')) {
            $c = new Criteria();
            $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
            if ($doAction == "VP") {
                $c->add(AppUserPeer::USERPASSWORD, $this->getRequestParameter('transactionPassword'));
            } else if ($doAction == "G") {
                $c->add(AppUserPeer::USERPASSWORD, $this->getRequestParameter('transactionPassword'));
            } else if ($doAction == "C") {
                $c->add(AppUserPeer::USERPASSWORD, $this->getRequestParameter('transactionPassword'));
            } else if ($doAction == "W") {
                $c->add(AppUserPeer::USERPASSWORD, $this->getRequestParameter('transactionPassword'));
            }
            $exist = AppUserPeer::doSelectOne($c);

            if (!$exist) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Login password is not valid."));
                return $this->redirect('/member/securityPasswordRequired?doAction='.$doAction);
            }

            if ($doAction == "VP") {
                $this->getUser()->setAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_VIEW_PROFILE, true);
                return $this->redirect('/member/viewProfile');
            } else if ($doAction == "G") {
                $this->getUser()->setAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_GENEALOGY, true);
                return $this->redirect('/member/sponsorTree');
            } else if ($doAction == "C") {
                $this->getUser()->setAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_COMMISSION, true);
                return $this->redirect('/member/bonusDetails');
            } else if ($doAction == "W") {
                $this->getUser()->setAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_WALLET, true);
                return $this->redirect('/member/epointLog');
            }
        }
    }
    public function executeTransactionPassword()
    {
        if ($this->getRequestParameter('oldSecurityPassword')) {
            $c = new Criteria();
            $c->add(AppUserPeer::USER_ID, $this->getUser()->getAttribute(Globals::SESSION_USERID));
            $c->add(AppUserPeer::USERPASSWORD2, $this->getRequestParameter('oldSecurityPassword'));
            $exist = AppUserPeer::doSelectOne($c);

            if (!$exist) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Old Security password is not valid."));
            } else {
                $exist->setUserpassword2($this->getRequestParameter('newSecurityPassword'));
                $exist->setKeepPassword2($this->getRequestParameter('newSecurityPassword'));
                $exist->save();
                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Security Password updated"));
            }
            //return $this->redirect('/member/transactionPassword');
        }
        return $this->redirect('/member/viewProfile');
    }

    public function executeAnnouncement()
    {
        $announcement = MlmAnnouncementPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($announcement);

        $this->announcement = $announcement;
    }

    public function executeSponsorTree()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_GENEALOGY, false) == false && $this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN, Globals::FALSE) == Globals::FALSE) {
            return $this->redirect('/member/securityPasswordRequired?doAction=G');
        }

        $id = $this->getUser()->getAttribute(Globals::SESSION_DISTID);
        $distinfo = MlmDistributorPeer::retrieveByPk($id);

        if ($distinfo->getHideGenealogy() == "Y") {
            return $this->redirect('/member/summary');
        }

        $this->distinfo = $distinfo;
        $this->hasChild = $this->checkHasChild($distinfo->getDistributorId());

        /*********************/
        /* Search Function
         * ********************/
        $fullName = $this->getRequestParameter('fullName');
        $arrTree = array();

        if ($fullName != "") {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $fullName);
            $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $c->add(MlmDistributorPeer::TREE_STRUCTURE, "%|" . $this->getUser()->getAttribute(Globals::SESSION_DISTID) . "|%", Criteria::LIKE);
            $distinfo = MlmDistributorPeer::doSelectOne($c);

            if (!$distinfo) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Username is not exist."));
                return $this->redirect('/member/sponsorTree');
            }

            $this->distinfo = $distinfo;
            $this->hasChild = $this->checkHasChild($distinfo->getDistributorId());
        }
        $this->userDB = AppUserPeer::retrieveByPK($distinfo->getUserId());
        $this->headColor = $this->getRankColor($distinfo->getRankId());
        $this->arrTree = $arrTree;
        $this->fullName = $fullName;
    }

    public function executeManipulateSponsorTree()
    {
        $parentId = $this->getRequestParameter('root');
        $arrTree = array();
        $html = "";
        if ($parentId != "") {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $parentId);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $dists = MlmDistributorPeer::doSelect($c);

            $idx = 0;
            $count = count($dists);
            foreach ($dists as $dist)
            {
                $idx++;
                $hasChild = $this->checkHasChild($dist->getDistributorId());

                $treeLine = "tree-controller-lplus-line";
                $treeLine2 = "tree-controller-lplus-right";
                $treeLineNoChild = "tree-controller-t-line";
                $treeLineNoChild2 = "tree-controller-t-right";
                $treeControllerWrap = "tree-controller-wrap";
                $img = "<img class='tree-plus-button' src='/css/network/plus.png'>";
                if ($idx == $count) {
                    $treeLineNoChild = "tree-controller-l-line";
                    $treeLineNoChild2 = "tree-controller-l-right";
                    $treeControllerWrap = "tree-controller-l-wrap";
                }

                if ($hasChild) {
                } else {
                    $img = "";
                    $treeLine = $treeLineNoChild;
                    $treeLine2 = $treeLineNoChild2;
                }

                $headColor = $this->getRankColor($dist->getRankId());

                $userDB = AppUserPeer::retrieveByPK($dist->getUserId());

                $html .= "<div class='".$treeControllerWrap."'>
                        <div class='controller-node-con'>
                            <div class='tree-controller ".$treeLine."'>
                                <div class='tree-controller-in ".$treeLine2."'>
                                    ".$img."
                                </div>
                            </div>
                            <div class='node-info-raw' id='node-id-".$dist->getDistributorId()."'>
                                <div class='node-info'>
                                    <span class='user-rank'><img
                                            src='/css/network/".$headColor."_head.png'></span>
                                    <span class='user-id'>".$dist->getDistributorCode()."</span>
                                    <span class='user-joined'>".$this->getContext()->getI18N()->__("Joined")." ".date('Y-m-d', strtotime($dist->getActiveDatetime()))."</span>
                                    <span class='user-joined'>".$userDB->getUsername()." (".$this->getContext()->getI18N()->__($dist->getRankCode()).")</span>
                                </div>
                            </div>
                        </div>";
                if ($hasChild) {
                    $html .= "<div id='node-wrapper-".$dist->getDistributorId()."' class='ajax-more'></div>";
                }
                $html .= "</div>";
            }
        }


        //echo json_encode($arrTree);
        echo $html;
        return sfView::HEADER_ONLY;
    }

    public function executeManipulateSponsorTree_old()
    {
        $parentId = $this->getRequestParameter('root');
        $arrTree = array();
        if ($parentId != "") {
            $c = new Criteria();
            $c->add(MlmDistributorPeer::UPLINE_DIST_ID, $parentId);
            $c->addAnd(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
            $dists = MlmDistributorPeer::doSelect($c);

            $idx = 0;
            $colorArr = $this->getRankColorArr();

            foreach ($dists as $dist)
            {
                $arrTree[$idx]["text"] = "<span class='user-rank'><img src='/css/maxim/tree/".$colorArr[$dist->getRankId()]."_head.png'></span><span class='user-id'>".$dist->getDistributorCode() . "</span><span class='user-joined'>" . $dist->getFullName() . "</span><span class='user-joined'> Joined " . date('Y-m-d', strtotime($dist->getActiveDatetime())). "</span><span class='user-joined'>" . $dist->getRankCode()."</span>";
                $arrTree[$idx]["id"] = $dist->getDistributorId();
                $arrTree[$idx]["hasChildren"] = $this->checkHasChild($dist->getDistributorId());
                $idx++;
            }
        }


        echo json_encode($arrTree);
        return sfView::HEADER_ONLY;
    }

    public function executeCp3Withdrawal()
    {
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);
        $this->ledgerAccountBalance = $ledgerAccountBalance;
        $this->distributorDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        $pos = strrpos($this->distributorDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
            return $this->redirect('/member/summary');
        }

        $withdrawAmount = $this->getRequestParameter('cp3Amount');
        $processFee = 30;

        if ($withdrawAmount > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            if (date("d") > 8) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Withdrawal request must be done during the first 7 days of each month"));
                return $this->redirect('/member/cp3Withdrawal');
            }
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), null, null, Globals::YES_Y, null, null, null, null, null)) {
            //if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("CP3 Withdrawal temporary out of service."));
                return $this->redirect('/member/cp3Withdrawal');
            }

            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($withdrawAmount > $ledgerAccountBalance) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP3"));

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif ($withdrawAmount > 0) {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($withdrawAmount);
                $tbl_account_ledger->setBalance($ledgerAccountBalance - $withdrawAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_MAINTENANCE);

                // ******       company account      ****************
                $companyEcashBalance = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_MAINTENANCE);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL . " " . $this->getUser()->getAttribute(Globals::SESSION_DISTCODE));
                $tbl_account_ledger->setCredit($processFee);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($companyEcashBalance + $processFee);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_MAINTENANCE);

                $tbl_cp3_withdraw = new MlmCp3Withdraw();
                $tbl_cp3_withdraw->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_cp3_withdraw->setDeduct($withdrawAmount);
                $tbl_cp3_withdraw->setBankInTo($this->getRequestParameter('bankInTo'));
                $tbl_cp3_withdraw->setAmount($withdrawAmount - $processFee);
                $tbl_cp3_withdraw->setStatusCode(Globals::WITHDRAWAL_PENDING);
                $tbl_cp3_withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_cp3_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_cp3_withdraw->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your CP3 withdrawal has been submitted."));

                return $this->redirect('/member/cp3Withdrawal');
            }
        }
    }

    public function executeEcashWithdrawal()
    {
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->ledgerAccountBalance = $ledgerAccountBalance;
        $this->distributorDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $pos = strrpos($this->distributorDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
            return $this->redirect('/member/summary');
        }

        $withdrawAmount = $this->getRequestParameter('ecashAmount');
        //$processFee = 0;
        $processFee = 60;
        $percentageProcessFee = $this->getRequestParameter('ecashAmount') * 5 / 100;

        if ($percentageProcessFee > $processFee)
            $processFee = $percentageProcessFee;

        if ($this->getRequestParameter('ecashAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            if (date("d") > 8) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Withdrawal request must be done during the first 7 days of each month"));
                return $this->redirect('/member/ecashWithdrawal');
            }

            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), null, null, null, null, Globals::YES_Y, null, null, null)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("CP2 Withdrawal temporary out of service."));
                return $this->redirect('/member/ecashWithdrawal');
            }

            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($withdrawAmount > $ledgerAccountBalance) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP2"));

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif ($withdrawAmount > 0) {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setBalance($ledgerAccountBalance - $this->getRequestParameter('ecashAmount'));
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);

                // ******       company account      ****************
                $companyEcashBalance = $this->getAccountBalance(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId(Globals::SYSTEM_COMPANY_DIST_ID);
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL);
                $tbl_account_ledger->setRemark(Globals::ACCOUNT_LEDGER_ACTION_WITHDRAWAL . " " . $this->getUser()->getAttribute(Globals::SESSION_DISTCODE));
                $tbl_account_ledger->setCredit($processFee);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setBalance($companyEcashBalance + $processFee);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount(Globals::SYSTEM_COMPANY_DIST_ID, Globals::ACCOUNT_TYPE_ECASH);


                $tbl_ecash_withdraw = new MlmEcashWithdraw();
                $tbl_ecash_withdraw->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_ecash_withdraw->setDeduct($withdrawAmount);
                $tbl_ecash_withdraw->setBankInTo($this->getRequestParameter('bankInTo'));
                $tbl_ecash_withdraw->setAmount($withdrawAmount - $processFee);
                $tbl_ecash_withdraw->setStatusCode(Globals::WITHDRAWAL_PENDING);
                $tbl_ecash_withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_ecash_withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_ecash_withdraw->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your CP2 withdrawal has been submitted."));

                return $this->redirect('/member/ecashWithdrawal');
            }
        }
    }

    public function executeMt4Withdrawal()
    {
        //$usdToMyr = 3.4;
        $usdToMyr = 1;
        $handlingCharge = 4;
        $handlingChargeInUsd = 40;

        $distributorDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->distributorDB = $distributorDB;

        // amz001 chales (20131223)
        $pos = strrpos($distributorDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
        }
        /*$c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_USD_TO_MYR);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $usdToMyr = $settingDB->getSettingValue();
        }*/
        $this->usdToMyr = $usdToMyr;

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_MT4_HANDLING_FEE);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $handlingCharge = $settingDB->getSettingValue();
        }
        $this->handlingCharge = $handlingCharge;

        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_MT4_HANDLING_FEE_USD);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $handlingChargeInUsd = $settingDB->getSettingValue();
        }
        $this->handlingChargeInUsd = $handlingChargeInUsd;

        $c = new Criteria();
        $c->add(MlmDistMt4Peer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $distMt4DBs = MlmDistMt4Peer::doSelect($c);
        $this->distMt4DBs = $distMt4DBs;

        if ($this->getRequestParameter('mt4Amount') > 0 && $this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('paymentType') <> "") {
            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } else if (!$this->getRequestParameter('mt4Id')) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid MT4 ID."));

            } else {
                $paymentType = $this->getRequestParameter('paymentType');
                $usdAmount = $this->getRequestParameter('mt4Amount');
                $mt4Id = $this->getRequestParameter('mt4Id');

                $mt4Withdraw = new MlmMt4Withdraw();
                $mt4Withdraw->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $mt4Withdraw->setMt4UserName($mt4Id);
                $mt4Withdraw->setStatusCode(Globals::WITHDRAWAL_PENDING);

                $minHandlingFee = 0;
                $myrAmount = 0;
                $handlingFee = 0;
                $currencyCode = "USD";
                $grandAmount = 0;

                /*if ($paymentType == "BANK") {
                    $currencyCode = "MYR";

                    $usdCurrency = $usdToMyr;
                    $minHandlingFee = $handlingChargeInUsd * $usdCurrency;
                    $myrAmount = $usdAmount * $usdCurrency;
                    $handlingFee = floor($myrAmount * $usdCurrency / 100);
                    if ($handlingFee < $minHandlingFee)
                        $handlingFee = $minHandlingFee;

                    $grandAmount = $myrAmount - $handlingFee;

                    $mt4Withdraw->setAmountRequested($myrAmount);
                    $mt4Withdraw->setRemarks("MT4 Fund :".$usdAmount);
                } elseif ($paymentType == "VISA") {*/
                    $currencyCode = "USD";

                    $minHandlingFee = floor($usdAmount * $handlingCharge / 100);
                    if ($minHandlingFee < $handlingChargeInUsd)
                        $handlingFee = $handlingChargeInUsd;
                    else
                        $handlingFee = $minHandlingFee;

                    $grandAmount = $usdAmount - $handlingFee;

                    $mt4Withdraw->setAmountRequested($usdAmount);
                //}

                $mt4Withdraw->setHandlingFee($handlingFee);
                $mt4Withdraw->setGrandAmount($grandAmount);
                $mt4Withdraw->setPaymentType($paymentType);
                $mt4Withdraw->setCurrencyCode($currencyCode);

                $mt4Withdraw->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mt4Withdraw->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mt4Withdraw->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your MT4 withdrawal has been submitted."));

                return $this->redirect('/member/mt4Withdrawal');
            }
        }
    }

    public function executeReloadTopup()
    {
        $usdToMyr = 3.4;
        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, Globals::SETTING_USD_TO_MYR);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $usdToMyr = $settingDB->getSettingValue();
        }
        $this->usdToMyr = $usdToMyr;

        $ledgerEpointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->ledgerEpointBalance = $ledgerEpointBalance;

        $distributorDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->distributorDB = $distributorDB;

        $c = new Criteria();
        $c->add(MlmDistMt4Peer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $distMt4DBs = MlmDistMt4Peer::doSelect($c);
        $this->distMt4DBs = $distMt4DBs;

        $mt4Amount = $this->getRequestParameter('mt4Amount');
        //$pointNeeded = $this->getRequestParameter('mt4Amount') * $usdToMyr;
        $pointNeeded = $this->getRequestParameter('mt4Amount');
        $mt4UserName = $this->getRequestParameter('mt4UserName', "");

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);

        if ($mt4Amount > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($pointNeeded > $ledgerEpointBalance) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1"));

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif ($mt4UserName == "") {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid MT4 ID."));

            } else {
                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_TOPUP_MT4);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($pointNeeded);
                $tbl_account_ledger->setBalance($ledgerEpointBalance - $pointNeeded);
                $tbl_account_ledger->setRemark("MT4 Fund :".$mt4Amount);
                //$tbl_account_ledger->setRemark("MT4 Fund :".$mt4Amount.", CONVERSION RATE :".$usdToMyr);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $mlmMt4ReloadFund = new MlmMt4ReloadFund();
                $mlmMt4ReloadFund->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $mlmMt4ReloadFund->setMt4UserName($mt4UserName);
                $mlmMt4ReloadFund->setAmount($this->getRequestParameter('mt4Amount'));
                $mlmMt4ReloadFund->setStatusCode(Globals::STATUS_PENDING);
                $mlmMt4ReloadFund->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmMt4ReloadFund->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlmMt4ReloadFund->save();

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Your MT4 Fund Reload has been submitted."));

                return $this->redirect('/member/reloadTopup');
            }
        }
    }

    public function executeBdetails()
    {
        $this->bonus = $this->getRequestParameter('bonus');

        $c = new Criteria();
        $c->add(TblMemberCommPeer::F_DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $c->addAnd(TblMemberCommPeer::F_TYPE, $this->getRequestParameter('bonus'));

        $this->TblBonus = TblMemberCommPeer::doSelect($c);
    }

    public function executeBonusDetails() {
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ($distDB->getHideGenealogy() == "Y") {
            return $this->redirect('/member/summary');
        }
        if ($this->getUser()->getAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_COMMISSION, false) == false && $this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN, Globals::FALSE) == Globals::FALSE) {
            return $this->redirect('/member/securityPasswordRequired?doAction=C');
        }
    }
    public function executePipsRebate()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $joinDate = $distDB->getActiveDatetime();

        $creditRefunds = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_CREDIT_REFUND);

        $this->creditRefund = number_format($creditRefunds, 2);

        /* *************************
         *  PIPS DETAIL
         * **************************/
        $currentMonth = date('m');
        $currentYear = date('Y');

        $anode = array();

        $idx = 0;
        if ($joinDate != null) {
            $joinMonth = date('m', strtotime($joinDate));
            $joinYear = date('Y', strtotime($joinDate));
            for ($x = intval($joinYear); $x <= intval($currentYear); $x++) {
                if ($x != $currentYear) {
                    for ($i = intval($joinMonth); $i <= 12; $i++) {
                        $anode[$idx]["year"] = $x;
                        $anode[$idx]["month"] = $i;
                        $anode[$idx]["credit_refund"] = $this->getCreditRefundDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                        $idx++;
                    }
                } else {
                    if ($joinYear != $currentYear) {
                        $joinMonth = 1;
                    }
                    for ($i = intval($joinMonth); $i <= intval($currentMonth); $i++) {
                        $anode[$idx]["year"] = $x;
                        $anode[$idx]["month"] = $i;
                        $anode[$idx]["credit_refund"] = $this->getCreditRefundDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                        $idx++;
                    }
                }
            }
        }
        $this->anode = $anode;
    }

    public function executeBonusDetails2()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $joinDate = $distDB->getActiveDatetime();

        $dsb = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_DRB);
        $pipsBonus = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_PIPS_BONUS);
        $creditRefunds = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_CREDIT_REFUND);
        $fundManagements = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_FUND_MANAGEMENT);
        $pairingBonus = $this->getCommissionBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::COMMISSION_TYPE_GDB);
        $specialBonus = 0;
        $totalLotTraded = 0;

        $this->dsb = number_format($dsb, 2);
        $this->pipsBonus = number_format($pipsBonus, 2);
        $this->creditRefund = number_format($creditRefunds, 2);
        $this->fundManagement = number_format($fundManagements, 2);
        $this->pairingBonus = number_format($pairingBonus, 2);
        $this->specialBonus = number_format($specialBonus, 2);
        $this->totalLotTraded = number_format($totalLotTraded, 2);
        $this->nextPerformanceDate = $this->getNextPerformanceDate($this->getUser()->getAttribute(Globals::SESSION_DISTID));

        $this->total = number_format($dsb + $pipsBonus + $creditRefunds + $fundManagements + $pairingBonus + $specialBonus, 2);

        /* *************************
         *  PIPS DETAIL
         * **************************/
        $currentMonth = date('m');
        $currentYear = date('Y');

        $anode = array();

        $idx = 0;
        if ($joinDate != null) {
            $joinMonth = date('m', strtotime($joinDate));
            $joinYear = date('Y', strtotime($joinDate));
            for ($x = intval($joinYear); $x <= intval($currentYear); $x++) {
                if ($x != $currentYear) {
                    for ($i = intval($joinMonth); $i <= 12; $i++) {
                        $anode[$idx]["year"] = $x;
                        $anode[$idx]["month"] = $i;
                        $anode[$idx]["pips_bonus"] = $this->getPipsBonusDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                        $anode[$idx]["credit_refund"] = $this->getCreditRefundDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                        $anode[$idx]["fund_dividend"] = $this->getFundDividendDetailByMonth($distDB->getDistributorId(), $i, $x);
                        $anode[$idx]["rb_bonus"] = $this->getRbDetailByMonth($distDB->getDistributorId(), $i, $x);
                        $anode[$idx]["paring_bonus"] = $this->getPairingDetailByMonth($distDB->getDistributorId(), $i, $x);
                        $idx++;
                    }
                } else {
                    if ($joinYear != $currentYear) {
                        $joinMonth = 1;
                    }
                    for ($i = intval($joinMonth); $i <= intval($currentMonth); $i++) {
                        $anode[$idx]["year"] = $x;
                        $anode[$idx]["month"] = $i;
                        $anode[$idx]["pips_bonus"] = $this->getPipsBonusDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                        $anode[$idx]["credit_refund"] = $this->getCreditRefundDetailByMonth($distDB->getDistributorId(), $i, $x, null);
                        $anode[$idx]["fund_dividend"] = $this->getFundDividendDetailByMonth($distDB->getDistributorId(), $i, $x);
                        $anode[$idx]["rb_bonus"] = $this->getRbDetailByMonth($distDB->getDistributorId(), $i, $x);
                        $anode[$idx]["paring_bonus"] = $this->getPairingDetailByMonth($distDB->getDistributorId(), $i, $x);
                        $idx++;
                    }
                }
            }
        }
        $this->anode = $anode;
    }

    public function executeProfile()
    {
    }

    public function executeRegistration()
    {
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

    public function executeVerifyUserName()
    {
        $c = new Criteria();
        $c->add(AppUserPeer::USERNAME, $this->getRequestParameter('userName'));
        $exist = AppUserPeer::doSelectOne($c);

        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeVerifyFullName()
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::FULL_NAME, $this->getRequestParameter('fullname'));
        $exist = MlmDistributorPeer::doSelectOne($c);

        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }

        return sfView::HEADER_ONLY;
    }

    public function executeViewProfile()
    {
        if ($this->getUser()->getAttribute(Globals::SESSION_SECURITY_PASSWORD_REQUIRED_VIEW_PROFILE, false) == false && $this->getUser()->getAttribute(Globals::SESSION_MASTER_LOGIN, Globals::FALSE) == Globals::FALSE) {
            return $this->redirect('/member/securityPasswordRequired?doAction=VP');
        }
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distDB->getUplineDistId());
        $sponsor = MlmDistributorPeer::doSelectOne($c);
        if (!$sponsor) {
            $sponsor = new MlmDistributor();
        }

        $this->sponsor = $sponsor;
        $this->distDB = $distDB;
    }
    public function executeBankInformation()
    {
        $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $this->forward404Unless($distDB);

        $this->distDB = $distDB;

        $this->bankName2 = $this->getAppSetting(Globals::SETTING_BANK_NAME_2);
        $this->bankSwiftCode2 = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE_2);
        $this->iban2 = $this->getAppSetting(Globals::SETTING_IBAN_2);
        $this->bankAccountHolder2 = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER_2);
        $this->bankAccountNumber2 = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER_2);
        $this->cityOfBank2 = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK_2);
        $this->countryOfBank2 = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK_2);

        /*$this->bankName3 = $this->getAppSetting(Globals::SETTING_BANK_NAME_3);
        $this->bankSwiftCode3 = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE_3);
        $this->iban3 = $this->getAppSetting(Globals::SETTING_IBAN_3);
        $this->bankAccountHolder3 = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER_3);
        $this->bankAccountNumber3 = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER_3);
        $this->cityOfBank3 = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK_3);
        $this->countryOfBank3 = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK_3);*/

        $this->bankName = $this->getAppSetting(Globals::SETTING_BANK_NAME);
        $this->bankSwiftCode = $this->getAppSetting(Globals::SETTING_BANK_SWIFT_CODE);
        $this->iban = $this->getAppSetting(Globals::SETTING_IBAN);
        $this->bankAccountHolder = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_HOLDER);
        $this->bankAccountNumber = $this->getAppSetting(Globals::SETTING_BANK_ACCOUNT_NUMBER);
        $this->cityOfBank = $this->getAppSetting(Globals::SETTING_CITY_OF_BANK);
        $this->countryOfBank = $this->getAppSetting(Globals::SETTING_COUNTRY_OF_BANK);
    }

    public function executeDailyBonusFlushBothLeg()
    {
        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        $fromAbfx = "N";
        try {
            $con->begin();

            print_r("Start<br>");
            $c = new Criteria();
            $c->add(MlmDailyBonusLogPeer::BONUS_TYPE, Globals::DAILY_BONUS_LOG_TYPE_DAILY);
            $c->addDescendingOrderByColumn(MlmDailyBonusLogPeer::BONUS_DATE);
            $mlmDailyBonusLogDB = MlmDailyBonusLogPeer::doSelectOne($c);
            print_r("Fetch Daily Bonus Log<br>");

            $dateUtil = new DateUtil();
            $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"));
            print_r("currentDate=".$currentDate."<br>");

            $queryRecord = 20000;
            if ($mlmDailyBonusLogDB) {
                $bonusDate = $dateUtil->formatDate("Y-m-d", $mlmDailyBonusLogDB->getBonusDate());
                print_r("bonusDate=".$bonusDate."<br>");

                $level = 0;
                while ($level < 10) {
                    if ($bonusDate == $currentDate) {
                        print_r("break<br>");
                        break;
                    }
                    print_r("level start :".$level."<br><br>");
//                    $c = new Criteria();
//                    $mlmDistPairingDBs = MlmDistPairingPeer::doSelect($c);
                    $c = new Criteria();
                    //$c->add(MlmDistributorPeer::DISTRIBUTOR_ID, 1824);
                    $c->add(MlmDistributorPeer::FROM_ABFX, $fromAbfx);
                    //$c->setOffset($this->getRequestParameter('q') * $queryRecord);
                    //$c->setLimit($queryRecord);
                    $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_ID);
                    $dists = MlmDistributorPeer::doSelect($c);
                    print_r("total Dist:".count($dists)."<br><br>");
                    foreach ($dists as $dist) {
//                    foreach ($mlmDistPairingDBs as $mlmDistPairingDB) {
                        $c = new Criteria();
                        $c->add(MlmDistPairingPeer::DIST_ID, $dist->getDistributorId());
                        $mlmDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                        if (!$mlmDistPairingDB)
                            continue;

                        $distId = $mlmDistPairingDB->getDistId();
                        $packageDB = MlmPackagePeer::retrieveByPK($dist->getRankId());

                        $flushLimit = $packageDB->getDailyMaxPairing();
                        $legFlushLimit = $packageDB->getDailyMaxPairing() * 10;
                        print_r("DistId ".$distId."<br>");
                        $leftBalance = $this->findPairingLedgersBonus($distId, Globals::PLACEMENT_LEFT, $currentDate);
                        $rightBalance = $this->findPairingLedgersBonus($distId, Globals::PLACEMENT_RIGHT, $currentDate);

                        if ($leftBalance > 0 && $rightBalance > 0) {
                            print_r("Start Calculate bonus:".$bonusDate."<br>");
                            // requery for paring ledger

                            // start paring bonus
                            //$distributorDB = MlmDistributorPeer::retrieveByPK($distId);
                            $pairingPercentage = $packageDB->getPairingBonus();
                            $dailyMaxPairing = $packageDB->getDailyMaxPairing();
                            if ($flushLimit != $dailyMaxPairing) {
                                $mlmDistPairingDB->setFlushLimit($dailyMaxPairing);
                                $mlmDistPairingDB->save();

                                $flushLimit = $dailyMaxPairing;
                                $legFlushLimit = $flushLimit * 10;
                            }

                            $minBalance = $leftBalance;
                            $leftPairedPoint = $leftBalance;
                            $rightPairedPoint = $rightBalance;
                            if ($rightBalance < $leftBalance) {
                                $minBalance = $rightBalance;
                            }
                            if ($legFlushLimit < $minBalance) {
                                if ($leftPairedPoint > $rightPairedPoint) {
                                    $leftPairedPoint = $legFlushLimit;
                                } else {
                                    $rightPairedPoint = $legFlushLimit;
                                }
                            } else {
                                $leftPairedPoint = $minBalance;
                                $rightPairedPoint = $minBalance;
                            }
                            print_r("leftBalance ".$leftBalance."<br>");
                            print_r("rightBalance ".$rightBalance."<br>");
                            print_r("minBalance ".$minBalance."<br>");
                            if ($leftBalance > 0 && $rightBalance > 0) {
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_LEFT, $leftPairedPoint);
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_RIGHT, $rightPairedPoint);

                                $pairingBonusAmount = $minBalance * $pairingPercentage / 100;
                                print_r("pairingBonusAmount =".$pairingBonusAmount."<br>");
                                $flushAmount = 0;
                                if ($pairingBonusAmount > $flushLimit) {
                                    $flushAmount = $pairingBonusAmount - $flushLimit;
                                }

                                /******************************/
                                /*  Commission
                                /******************************/
                                $c = new Criteria();
                                $c->add(MlmDistCommissionPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                                $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                                $commissionBalance = 0;
                                if (!$sponsorDistCommissionDB) {
                                    $sponsorDistCommissionDB = new MlmDistCommission();
                                    $sponsorDistCommissionDB->setDistId($distId);
                                    $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                } else {
                                    $commissionBalance = $sponsorDistCommissionDB->getBalance();
                                }
                                $sponsorDistCommissionDB->setBalance($commissionBalance + $pairingBonusAmount);
                                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionDB->save();

                                $c = new Criteria();
                                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                                $gdbBalance = 0;
                                if ($sponsorDistCommissionLedgerDB)
                                    $gdbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                                /******************************/
                                /*  Account
                                /******************************/
                                $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

                                // pairing amount
                                $ecashBalance = $distAccountEcashBalance + $pairingBonusAmount;
                                $mlm_account_ledger = new MlmAccountLedger();
                                $mlm_account_ledger->setDistId($distId);
                                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                $mlm_account_ledger->setRemark("GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")");
                                $mlm_account_ledger->setCredit($pairingBonusAmount);
                                $mlm_account_ledger->setDebit(0);
                                $mlm_account_ledger->setBalance($ecashBalance);
                                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->save();

                                //commission
                                $commissionBalance = $gdbBalance + $pairingBonusAmount;
                                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                $sponsorDistCommissionledger->setDistId($distId);
                                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                $sponsorDistCommissionledger->setCredit($pairingBonusAmount);
                                $sponsorDistCommissionledger->setDebit(0);
                                $sponsorDistCommissionledger->setBalance($commissionBalance);
                                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                $sponsorDistCommissionledger->setRemark("GROUP PAIRING AMOUNT (" . $bonusDate . ")");
                                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->save();

                                // flush amount
                                if ($flushAmount != 0) {
                                    $ecashBalance = $ecashBalance - $flushAmount;
                                    $mlm_account_ledger = new MlmAccountLedger();
                                    $mlm_account_ledger->setDistId($distId);
                                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                    $mlm_account_ledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                    $mlm_account_ledger->setCredit(0);
                                    $mlm_account_ledger->setDebit($flushAmount);
                                    $mlm_account_ledger->setBalance($ecashBalance);
                                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->save();

                                    $commissionBalance = $commissionBalance - $flushAmount;
                                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                    $sponsorDistCommissionledger->setDistId($distId);
                                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                    $sponsorDistCommissionledger->setCredit(0);
                                    $sponsorDistCommissionledger->setDebit($flushAmount);
                                    $sponsorDistCommissionledger->setBalance($commissionBalance);
                                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                    $sponsorDistCommissionledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->save();

                                    $pairingBonusAmount = $pairingBonusAmount - $flushAmount;
                                }

                                $maintenanceBalance = $pairingBonusAmount * Globals::BONUS_MAINTENANCE_PERCENTAGE;
                                if ($maintenanceBalance != 0) {
                                    $ecashBalance = $ecashBalance - $maintenanceBalance;
                                    $maintenanceEcashAccountLedger = new MlmAccountLedger();
                                    $maintenanceEcashAccountLedger->setDistId($distId);
                                    $maintenanceEcashAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                    $maintenanceEcashAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MAINTENANCE);
                                    $maintenanceEcashAccountLedger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                                    $maintenanceEcashAccountLedger->setCredit(0);
                                    $maintenanceEcashAccountLedger->setDebit($maintenanceBalance);
                                    $maintenanceEcashAccountLedger->setBalance($ecashBalance);
                                    $maintenanceEcashAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceEcashAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceEcashAccountLedger->save();
                                }

                                $bonusService = new BonusService();
                                //print_r($bonusService->checkDebitAccount($distId)."<br>");
                                //print_r($pairingBonusAmount."<br>");
                                //print_r($flushAmount."<br>");
                                //exit();
                                if ($bonusService->checkDebitAccount($distId) == true) {
                                    $debitAccountRemark = "GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")";
                                    $bonusService->contraDebitAccount($distId, $debitAccountRemark, $pairingBonusAmount);
                                }
                                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);

                                if ($maintenanceBalance != 0) {
                                    $commissionBalance = $commissionBalance - $maintenanceBalance;
                                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                    $sponsorDistCommissionledger->setDistId($distId);
                                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                    $sponsorDistCommissionledger->setCredit(0);
                                    $sponsorDistCommissionledger->setDebit($maintenanceBalance);
                                    $sponsorDistCommissionledger->setBalance($commissionBalance);
                                    $sponsorDistCommissionledger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->save();

                                    $this->revalidateCommission($distId, Globals::COMMISSION_TYPE_GDB);
                                }
                                /******************************/
                                /*  Maintenance
                                /******************************/
                                /*$c = new Criteria();
                                $c->add(MlmAccountLedgerPeer::DIST_ID, $distId);
                                $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
                                $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
                                $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
                                $this->forward404Unless($accountLedgerDB);
                                $distAccountMaintenanceBalance = $accountLedgerDB->getBalance();*/

                                if ($maintenanceBalance != 0) {
                                    $distAccountMaintenanceBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                                    $maintenanceAccountLedger = new MlmAccountLedger();
                                    $maintenanceAccountLedger->setDistId($distId);
                                    $maintenanceAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                                    $maintenanceAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                    $maintenanceAccountLedger->setRemark("PAIRING BALANCE " . number_format($pairingBonusAmount, 2) . " (" . $bonusDate . ")");
                                    $maintenanceAccountLedger->setCredit($maintenanceBalance);
                                    $maintenanceAccountLedger->setDebit(0);
                                    $maintenanceAccountLedger->setBalance($distAccountMaintenanceBalance + $maintenanceBalance);
                                    $maintenanceAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceAccountLedger->save();

                                    $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                                }
                            }
                        }
                    }

                    $bonusDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate($bonusDate, 1, 0, 0));
                    if (count($dists) != $queryRecord) {
                        $mlm_daily_bonus_log = new MlmDailyBonusLog();
                        $mlm_daily_bonus_log->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                        $mlm_daily_bonus_log->setBonusType(Globals::DAILY_BONUS_LOG_TYPE_DAILY);
                        $mlm_daily_bonus_log->setBonusDate($bonusDate);
                        $mlm_daily_bonus_log->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_daily_bonus_log->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_daily_bonus_log->save();
                    }
                    $level++;
                }
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDailyBonus()
    {
        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        $fromAbfx = "N";
        try {
            $con->begin();

            print_r("Start<br>");
            $c = new Criteria();
            $c->add(MlmDailyBonusLogPeer::BONUS_TYPE, Globals::DAILY_BONUS_LOG_TYPE_DAILY);
            $c->addDescendingOrderByColumn(MlmDailyBonusLogPeer::BONUS_DATE);
            $mlmDailyBonusLogDB = MlmDailyBonusLogPeer::doSelectOne($c);
            print_r("Fetch Daily Bonus Log<br>");

            $dateUtil = new DateUtil();
            $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"));
            print_r("currentDate=".$currentDate."<br>");

            $queryRecord = 5000;
            if ($mlmDailyBonusLogDB) {
                $bonusDate = $dateUtil->formatDate("Y-m-d", $mlmDailyBonusLogDB->getBonusDate());
                print_r("bonusDate=".$bonusDate."<br>");

                $level = 0;
                while ($level < 10) {
                    if ($bonusDate == $currentDate) {
                        print_r("break<br>");
                        break;
                    }
                    print_r("level start :".$level."<br><br>");
//                    $c = new Criteria();
//                    $mlmDistPairingDBs = MlmDistPairingPeer::doSelect($c);
                    $c = new Criteria();
                    //$c->add(MlmDistributorPeer::DISTRIBUTOR_ID, 1824);
                    $c->add(MlmDistributorPeer::FROM_ABFX, $fromAbfx);
                    $c->setOffset($this->getRequestParameter('q') * $queryRecord);
                    $c->setLimit($queryRecord);
                    $c->addAscendingOrderByColumn(MlmDistributorPeer::DISTRIBUTOR_ID);
                    $dists = MlmDistributorPeer::doSelect($c);
                    print_r("total Dist:".count($dists)."<br><br>");
                    foreach ($dists as $dist) {
//                    foreach ($mlmDistPairingDBs as $mlmDistPairingDB) {
                        $c = new Criteria();
                        $c->add(MlmDistPairingPeer::DIST_ID, $dist->getDistributorId());
                        $mlmDistPairingDB = MlmDistPairingPeer::doSelectOne($c);

                        if (!$mlmDistPairingDB)
                            continue;

                        $distId = $mlmDistPairingDB->getDistId();
                        $packageDB = MlmPackagePeer::retrieveByPK($dist->getRankId());

                        $flushLimit = $packageDB->getDailyMaxPairing();
                        $legFlushLimit = $packageDB->getDailyMaxPairing() * 10;
                        print_r("DistId ".$distId."<br>");
                        $leftBalance = $this->findPairingLedgersBonus($distId, Globals::PLACEMENT_LEFT, $currentDate);
                        $rightBalance = $this->findPairingLedgersBonus($distId, Globals::PLACEMENT_RIGHT, $currentDate);

                        if ($leftBalance > 0 && $rightBalance > 0) {
                            print_r("Start Calculate bonus:".$bonusDate."<br>");
                            // requery for paring ledger

                            // start paring bonus
                            //$distributorDB = MlmDistributorPeer::retrieveByPK($distId);
                            $pairingPercentage = $packageDB->getPairingBonus();
                            $dailyMaxPairing = $packageDB->getDailyMaxPairing();
                            if ($flushLimit != $dailyMaxPairing) {
                                $mlmDistPairingDB->setFlushLimit($dailyMaxPairing);
                                $mlmDistPairingDB->save();

                                $flushLimit = $dailyMaxPairing;
                                $legFlushLimit = $flushLimit * 10;
                            }

                            $minBalance = $leftBalance;
                            $leftPairedPoint = $leftBalance;
                            $rightPairedPoint = $rightBalance;
                            if ($rightBalance < $leftBalance) {
                                $minBalance = $rightBalance;
                            }
                            if ($legFlushLimit < $minBalance) {
                                if ($leftPairedPoint > $rightPairedPoint) {
                                    $leftPairedPoint = $legFlushLimit;
                                } else {
                                    $rightPairedPoint = $legFlushLimit;
                                }
                            } else {
                                $leftPairedPoint = $minBalance;
                                $rightPairedPoint = $minBalance;
                            }
                            print_r("leftBalance ".$leftBalance."<br>");
                            print_r("rightBalance ".$rightBalance."<br>");
                            print_r("minBalance ".$minBalance."<br>");
                            if ($leftBalance > 0 && $rightBalance > 0) {
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_LEFT, $leftPairedPoint);
                                $this->updateDistPairingLeader($distId, Globals::PLACEMENT_RIGHT, $rightPairedPoint);

                                $pairingBonusAmount = $minBalance * $pairingPercentage / 100;
                                print_r("pairingBonusAmount =".$pairingBonusAmount."<br>");
                                $flushAmount = 0;
                                if ($pairingBonusAmount > $flushLimit) {
                                    $flushAmount = $pairingBonusAmount - $flushLimit;
                                }

                                /******************************/
                                /*  Commission
                                /******************************/
                                $c = new Criteria();
                                $c->add(MlmDistCommissionPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                                $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                                $commissionBalance = 0;
                                if (!$sponsorDistCommissionDB) {
                                    $sponsorDistCommissionDB = new MlmDistCommission();
                                    $sponsorDistCommissionDB->setDistId($distId);
                                    $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                } else {
                                    $commissionBalance = $sponsorDistCommissionDB->getBalance();
                                }
                                $sponsorDistCommissionDB->setBalance($commissionBalance + $pairingBonusAmount);
                                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionDB->save();

                                $c = new Criteria();
                                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $distId);
                                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                                $gdbBalance = 0;
                                if ($sponsorDistCommissionLedgerDB)
                                    $gdbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                                /******************************/
                                /*  Account
                                /******************************/
                                $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

                                // pairing amount
                                $ecashBalance = $distAccountEcashBalance + $pairingBonusAmount;
                                $mlm_account_ledger = new MlmAccountLedger();
                                $mlm_account_ledger->setDistId($distId);
                                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                $mlm_account_ledger->setRemark("GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")");
                                $mlm_account_ledger->setCredit($pairingBonusAmount);
                                $mlm_account_ledger->setDebit(0);
                                $mlm_account_ledger->setBalance($ecashBalance);
                                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_account_ledger->save();

                                //commission
                                $commissionBalance = $gdbBalance + $pairingBonusAmount;
                                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                $sponsorDistCommissionledger->setDistId($distId);
                                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                $sponsorDistCommissionledger->setCredit($pairingBonusAmount);
                                $sponsorDistCommissionledger->setDebit(0);
                                $sponsorDistCommissionledger->setBalance($commissionBalance);
                                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                $sponsorDistCommissionledger->setRemark("GROUP PAIRING AMOUNT (" . $bonusDate . ")");
                                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionledger->save();

                                // flush amount
                                if ($flushAmount != 0) {
                                    $ecashBalance = $ecashBalance - $flushAmount;
                                    $mlm_account_ledger = new MlmAccountLedger();
                                    $mlm_account_ledger->setDistId($distId);
                                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                    $mlm_account_ledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                    $mlm_account_ledger->setCredit(0);
                                    $mlm_account_ledger->setDebit($flushAmount);
                                    $mlm_account_ledger->setBalance($ecashBalance);
                                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlm_account_ledger->save();

                                    $commissionBalance = $commissionBalance - $flushAmount;
                                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                    $sponsorDistCommissionledger->setDistId($distId);
                                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                    $sponsorDistCommissionledger->setCredit(0);
                                    $sponsorDistCommissionledger->setDebit($flushAmount);
                                    $sponsorDistCommissionledger->setBalance($commissionBalance);
                                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                                    $sponsorDistCommissionledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->save();

                                    $pairingBonusAmount = $pairingBonusAmount - $flushAmount;
                                }

                                $maintenanceBalance = $pairingBonusAmount * Globals::BONUS_MAINTENANCE_PERCENTAGE;
                                if ($maintenanceBalance != 0) {
                                    $ecashBalance = $ecashBalance - $maintenanceBalance;
                                    $maintenanceEcashAccountLedger = new MlmAccountLedger();
                                    $maintenanceEcashAccountLedger->setDistId($distId);
                                    $maintenanceEcashAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                                    $maintenanceEcashAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MAINTENANCE);
                                    $maintenanceEcashAccountLedger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                                    $maintenanceEcashAccountLedger->setCredit(0);
                                    $maintenanceEcashAccountLedger->setDebit($maintenanceBalance);
                                    $maintenanceEcashAccountLedger->setBalance($ecashBalance);
                                    $maintenanceEcashAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceEcashAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceEcashAccountLedger->save();
                                }

                                $bonusService = new BonusService();
                                //print_r($bonusService->checkDebitAccount($distId)."<br>");
                                //print_r($pairingBonusAmount."<br>");
                                //print_r($flushAmount."<br>");
                                //exit();
                                if ($bonusService->checkDebitAccount($distId) == true) {
                                    $debitAccountRemark = "GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")";
                                    $bonusService->contraDebitAccount($distId, $debitAccountRemark, $pairingBonusAmount);
                                }
                                $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);

                                if ($maintenanceBalance != 0) {
                                    $commissionBalance = $commissionBalance - $maintenanceBalance;
                                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                                    $sponsorDistCommissionledger->setDistId($distId);
                                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                                    $sponsorDistCommissionledger->setCredit(0);
                                    $sponsorDistCommissionledger->setDebit($maintenanceBalance);
                                    $sponsorDistCommissionledger->setBalance($commissionBalance);
                                    $sponsorDistCommissionledger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $sponsorDistCommissionledger->save();

                                    $this->revalidateCommission($distId, Globals::COMMISSION_TYPE_GDB);
                                }
                                /******************************/
                                /*  Maintenance
                                /******************************/
                                /*$c = new Criteria();
                                $c->add(MlmAccountLedgerPeer::DIST_ID, $distId);
                                $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_MAINTENANCE);
                                $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
                                $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
                                $this->forward404Unless($accountLedgerDB);
                                $distAccountMaintenanceBalance = $accountLedgerDB->getBalance();*/

                                if ($maintenanceBalance != 0) {
                                    $distAccountMaintenanceBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                                    $maintenanceAccountLedger = new MlmAccountLedger();
                                    $maintenanceAccountLedger->setDistId($distId);
                                    $maintenanceAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                                    $maintenanceAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                                    $maintenanceAccountLedger->setRemark("PAIRING BALANCE " . number_format($pairingBonusAmount, 2) . " (" . $bonusDate . ")");
                                    $maintenanceAccountLedger->setCredit($maintenanceBalance);
                                    $maintenanceAccountLedger->setDebit(0);
                                    $maintenanceAccountLedger->setBalance($distAccountMaintenanceBalance + $maintenanceBalance);
                                    $maintenanceAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $maintenanceAccountLedger->save();

                                    $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                                }
                            }
                        }
                    }

                    $bonusDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate($bonusDate, 1, 0, 0));
                    if (count($dists) != $queryRecord) {
                        $mlm_daily_bonus_log = new MlmDailyBonusLog();
                        $mlm_daily_bonus_log->setAccessIp($this->getRequest()->getHttpHeader('addr','remote'));
                        $mlm_daily_bonus_log->setBonusType(Globals::DAILY_BONUS_LOG_TYPE_DAILY);
                        $mlm_daily_bonus_log->setBonusDate($bonusDate);
                        $mlm_daily_bonus_log->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_daily_bonus_log->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_daily_bonus_log->save();
                    }
                    $level++;
                }
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
        //exit();
        if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_PROD && $fromAbfx == "N") {
            print_r("+++++ Retrieve Gmail Mail Attachment +++++<br>");
            $this->retrieveGmailMailAttachment();

            print_r("+++++ ROI Dividend +++++<br>");
            $bonusDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"))." 23:59:59";
            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::STATUS_CODE, Globals::DIVIDEND_STATUS_PENDING);
            $c->add(MlmRoiDividendPeer::DIVIDEND_DATE, $bonusDate, Criteria::LESS_EQUAL);
            $mlmRoiDividendDBs = MlmRoiDividendPeer::doSelect($c);

            foreach ($mlmRoiDividendDBs as $mlmRoiDividend) {
                $distId = $mlmRoiDividend->getDistId();
                $mt4UserName = $mlmRoiDividend->getMt4UserName();
                $packagePrice = $mlmRoiDividend->getPackagePrice();
                $dividendDate = $mlmRoiDividend->getDividendDate();
                print_r("DistId " . $distId . "<br>");

                $dividendDateStr = $dateUtil->formatDate("Y-m-j", $dividendDate);
                $dividendDateFrom = $dividendDateStr . " 00:00:00";
                $dividendDateTo = $dividendDateStr . " 23:59:59";

                $dividendDateFromTS = strtotime($dividendDateFrom);
                $dividendDateToTS = strtotime($dividendDateTo);

                $query = "SELECT mt4_credit, credit_id FROM mlm_daily_dist_mt4_credit WHERE 1=1 "
                         . " AND dist_id = '" . $distId . "' AND mt4_user_name = '" . $mt4UserName . "'"
                         . " AND traded_datetime >= '" . date("Y-m-d H:i:s", $dividendDateFromTS) . "' AND traded_datetime <= '" . date("Y-m-d H:i:s", $dividendDateToTS) . "'";

                //var_dump($query);
                //exit();
                $connection = Propel::getConnection();
                $statement = $connection->prepareStatement($query);
                $resultset = $statement->executeQuery();

                if ($resultset->next()) {
                    $arr = $resultset->getRow();
                    if ($packagePrice > $arr["mt4_credit"]) {
                        $packagePrice = $arr["mt4_credit"];
                    }

                    if ($packagePrice < 0)
                        $packagePrice = 0;
                    /*$dividendDateStr = $dateUtil->formatDate("Y-m-j", $dividendDate);
                $dividendDateFrom = date('Y-m-j', $dividendDateStr) . " 00:00:00";
                $dividendDateTo = date('Y-m-j', $dividendDateStr) . " 23:59:59";

                $c = new Criteria();
                $c->add(MlmDailyDistMt4CreditPeer::DIST_ID, $distId);
                $c->add(MlmDailyDistMt4CreditPeer::TRADED_DATETIME, $dividendDateFrom, Criteria::GREATER_EQUAL);
                $c->add(MlmDailyDistMt4CreditPeer::TRADED_DATETIME, $dividendDateTo, Criteria::LESS_EQUAL);
                $mlmDailyDistMt4CreditDB = MlmDailyDistMt4CreditPeer::doSelectOne($c);

                if ($mlmDailyDistMt4CreditDB) {
                    if ($packagePrice > $mlmDailyDistMt4CreditDB->getMt4Credit()) {
                        $packagePrice = $mlmDailyDistMt4CreditDB->getMt4Credit();
                    }*/
                    $dividendAmount = $packagePrice * $mlmRoiDividend->getRoiPercentage() / 100;

                    $accountBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);

                    $mlm_account_ledger = new MlmAccountLedger();
                    $mlm_account_ledger->setDistId($distId);
                    $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_MAINTENANCE);
                    $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_FUND_MANAGEMENT);
                    $mlm_account_ledger->setRemark("");
                    $mlm_account_ledger->setCredit($dividendAmount);
                    $mlm_account_ledger->setDebit(0);
                    $mlm_account_ledger->setBalance($accountBalance + $dividendAmount);
                    $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_account_ledger->save();

                    $fundManagementBalance = $this->getCommissionBalance($distId, Globals::COMMISSION_TYPE_FUND_MANAGEMENT);

                    $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                    $sponsorDistCommissionledger->setMonthTraded(date('m'));
                    $sponsorDistCommissionledger->setYearTraded(date('Y'));
                    $sponsorDistCommissionledger->setDistId($distId);
                    $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_FUND_MANAGEMENT);
                    $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_DIVIDEND);
                    //$sponsorDistCommissionledger->setRefId($mlm_pip_csv->getPipId());
                    $sponsorDistCommissionledger->setCredit($dividendAmount);
                    $sponsorDistCommissionledger->setDebit(0);
                    $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                    $sponsorDistCommissionledger->setBalance($fundManagementBalance + $dividendAmount);
                    $sponsorDistCommissionledger->setRemark($mlmRoiDividend->getRoiPercentage()."%, Fund:".$packagePrice);
                    $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionledger->save();

                    $this->revalidateCommission($distId, Globals::COMMISSION_TYPE_FUND_MANAGEMENT);

                    $mt4Username = $mlmRoiDividend->getMt4UserName();
                    // new implement ********************************************************************
                    $c = new Criteria();
                    $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
                    $totalRecords = MlmRoiDividendPeer::doCount($c);

                    if ($totalRecords < Globals::DIVIDEND_TIMES_ENTITLEMENT) {
                        $c = new Criteria();
                        $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
                        $c->addDescendingOrderByColumn(MlmRoiDividendPeer::IDX);
                        $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

                        if ($mlmRoiDividendDB) {
                            $idx = $mlmRoiDividendDB->getIdx() + 1;
                            for ($i = $idx; $i <= Globals::DIVIDEND_TIMES_ENTITLEMENT; $i++) {
                                $firstDividendTime = strtotime($mlmRoiDividendDB->getFirstDividendDate());

                                $monthAdded = $idx - 1;
                                $dividendDate = strtotime("+".$monthAdded." months", $firstDividendTime);

                                $mlm_roi_dividend = new MlmRoiDividend();
                                $mlm_roi_dividend->setDistId($mlmRoiDividendDB->getDistId());
                                $mlm_roi_dividend->setMt4UserName($mlmRoiDividendDB->getMt4UserName());
                                $mlm_roi_dividend->setIdx($idx);
                                //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                                $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                                $mlm_roi_dividend->setFirstDividendDate($mlmRoiDividendDB->getFirstDividendDate());
                                $mlm_roi_dividend->setPackageId($mlmRoiDividendDB->getPackageId());
                                $mlm_roi_dividend->setPackagePrice($mlmRoiDividendDB->getPackagePrice());
                                $mlm_roi_dividend->setRoiPercentage($mlmRoiDividendDB->getRoiPercentage());
                                //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                                //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                                $mlm_roi_dividend->setStatusCode($mlmRoiDividendDB->getStatusCode());
                                $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $mlm_roi_dividend->save();

                                $idx = $idx + 1;
                            }
                        }
                    }
                    // new implement end ~ ********************************************************************
                    $mlmRoiDividend->setAccountLedgerId($mlm_account_ledger->getAccountId());
                    $mlmRoiDividend->setDividendAmount($dividendAmount);
                    $mlmRoiDividend->setMt4Balance($packagePrice);
                    $mlmRoiDividend->setStatusCode(Globals::DIVIDEND_STATUS_SUCCESS);
                    //$mlm_gold_dividend->setRemarks($this->getRequestParameter('remarks'));
                    $mlmRoiDividend->save();

                    /*if ($mlmRoiDividend->getIdx() <= Globals::DIVIDEND_TIMES_ENTITLEMENT) {
                        print_r("DividendDate: " . $mlmRoiDividend->getDividendDate() . "<br>");
                        print_r("Idx: " . $mlmRoiDividend->getIdx() . "<br>");

                        $idx = $mlmRoiDividend->getIdx();
                        $firstDividendTime = strtotime($mlmRoiDividend->getFirstDividendDate());
                        $dividendDate = strtotime("+".$idx." months", $firstDividendTime);
                        print_r("DividendDate: " . $dividendDate . "<br>");

                        $mlm_roi_dividend = new MlmRoiDividend();
                        $mlm_roi_dividend->setDistId($mlmRoiDividend->getDistId());
                        $mlm_roi_dividend->setMt4UserName($mlmRoiDividend->getMt4UserName());
                        $mlm_roi_dividend->setIdx($idx + 1);
                        //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                        $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                        $mlm_roi_dividend->setFirstDividendDate($mlmRoiDividend->getFirstDividendDate());
                        $mlm_roi_dividend->setPackageId($mlmRoiDividend->getPackageId());
                        $mlm_roi_dividend->setPackagePrice($mlmRoiDividend->getPackagePrice());
                        $mlm_roi_dividend->setRoiPercentage($mlmRoiDividend->getRoiPercentage());
                        //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                        //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                        $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                        $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_roi_dividend->save();
                    }*/

                    $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_MAINTENANCE);
                }
            }
            // roi dividend end~

            print_r("<br>executeSendRemindationEmailForUploadAgreement<br>");
            //$this->executeSendRemindationEmailForUploadAgreement();
            print_r("<br>sendDailyReport<br>");
            if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_PROD) {
                //$this->sendDailyReport();
            }
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    public function executeDailyBonusAbfx()
    {
        $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
        try {
            $con->begin();

            print_r("Start<br>");

//            $c = new Criteria();
//            $mlmDistPairingDBs = MlmDistPairingPeer::doSelect($c);
            $bonusDate = date("Y-m-d");
            $query = "SELECT pairing.pairing_id, pairing.dist_id, pairing.left_balance, pairing.right_balance
                , pairing.flush_limit, pairing.created_by, pairing.created_on, pairing.updated_by, pairing.updated_on
            FROM mlm_dist_pairing pairing
                LEFT JOIN mlm_distributor dist ON dist.distributor_id = pairing.dist_id
                    WHERE dist.from_abfx = 'Y'";

            $connection = Propel::getConnection();
            $statement = $connection->prepareStatement($query);
            $resultset = $statement->executeQuery();
            $resultArray = array();
            $result = 0;
            while ($resultset->next()) {
                $resultArr = $resultset->getRow();
//            foreach ($mlmDistPairingDBs as $mlmDistPairingDB) {
//                $distId = $mlmDistPairingDB->getDistId();
                $distId = $resultArr['dist_id'];
//                $flushLimit = $mlmDistPairingDB->getFlushLimit();
                $flushLimit = $resultArr['flush_limit'];
                print_r("DistId " . $distId . "<br>");
                $leftBalance = $this->findPairingLedgers($distId, Globals::PLACEMENT_LEFT, null);
                $rightBalance = $this->findPairingLedgers($distId, Globals::PLACEMENT_RIGHT, null);

                if ($leftBalance > 0 && $rightBalance > 0) {
                    $minBalance = $leftBalance;
                    if ($rightBalance < $leftBalance) {
                        $minBalance = $rightBalance;
                    }
                    print_r("leftBalance " . $leftBalance . "<br>");
                    print_r("rightBalance " . $rightBalance . "<br>");
                    print_r("minBalance " . $minBalance . "<br>");
                    if ($leftBalance > 0 && $rightBalance > 0) {
                        $this->updateDistPairingLeader($distId, Globals::PLACEMENT_LEFT, $minBalance);
                        $this->updateDistPairingLeader($distId, Globals::PLACEMENT_RIGHT, $minBalance);

                        // start paring bonus
                        $distributorDB = MlmDistributorPeer::retrieveByPK($distId);
                        $packageDB = MlmPackagePeer::retrieveByPK($distributorDB->getRankId());

                        $pairingPercentage = $packageDB->getPairingBonus();
                        $dailyMaxPairing = $packageDB->getDailyMaxPairing();
                        if ($flushLimit != $dailyMaxPairing) {
                            //$mlmDistPairingDB->setFlushLimit($dailyMaxPairing);
                            //$mlmDistPairingDB->save();

                            $flushLimit = $dailyMaxPairing;
                        }

                        $pairingBonusAmount = $minBalance * $pairingPercentage / 100;
                        print_r("pairingBonusAmount =" . $pairingBonusAmount . "<br>");
                        $flushAmount = 0;
                        if ($pairingBonusAmount > $flushLimit) {
                            $flushAmount = $pairingBonusAmount - $flushLimit;
                        }

                        /******************************/
                        /*  Commission
                        /******************************/
                        $c = new Criteria();
                        $c->add(MlmDistCommissionPeer::DIST_ID, $distId);
                        $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                        $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                        $commissionBalance = 0;
                        if (!$sponsorDistCommissionDB) {
                            $sponsorDistCommissionDB = new MlmDistCommission();
                            $sponsorDistCommissionDB->setDistId($distId);
                            $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                            $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        } else {
                            $commissionBalance = $sponsorDistCommissionDB->getBalance();
                        }
                        $sponsorDistCommissionDB->setBalance($commissionBalance + $pairingBonusAmount);
                        $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistCommissionDB->save();

                        $c = new Criteria();
                        $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $distId);
                        $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_GDB);
                        $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                        $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                        $gdbBalance = 0;
                        if ($sponsorDistCommissionLedgerDB)
                            $gdbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                        /******************************/
                        /*  Account
                        /******************************/
                        $distAccountEcashBalance = $this->getAccountBalance($distId, Globals::ACCOUNT_TYPE_ECASH);

                        // pairing amount
                        $ecashBalance = $distAccountEcashBalance + $pairingBonusAmount;
                        $mlm_account_ledger = new MlmAccountLedger();
                        $mlm_account_ledger->setDistId($distId);
                        $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                        $mlm_account_ledger->setRemark("GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")");
                        $mlm_account_ledger->setCredit($pairingBonusAmount);
                        $mlm_account_ledger->setDebit(0);
                        $mlm_account_ledger->setBalance($ecashBalance);
                        $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $mlm_account_ledger->save();

                        //commission
                        $commissionBalance = $gdbBalance + $pairingBonusAmount;
                        $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                        $sponsorDistCommissionledger->setDistId($distId);
                        $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                        $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                        $sponsorDistCommissionledger->setCredit($pairingBonusAmount);
                        $sponsorDistCommissionledger->setDebit(0);
                        $sponsorDistCommissionledger->setBalance($commissionBalance);
                        $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                        $sponsorDistCommissionledger->setRemark("GROUP PAIRING AMOUNT (" . $bonusDate . ")");
                        $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                        $sponsorDistCommissionledger->save();

                        // flush amount
                        if ($flushAmount != 0) {
                            $ecashBalance = $ecashBalance - $flushAmount;
                            $mlm_account_ledger = new MlmAccountLedger();
                            $mlm_account_ledger->setDistId($distId);
                            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_GDB);
                            $mlm_account_ledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                            $mlm_account_ledger->setCredit(0);
                            $mlm_account_ledger->setDebit($flushAmount);
                            $mlm_account_ledger->setBalance($ecashBalance);
                            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->save();

                            $commissionBalance = $commissionBalance - $flushAmount;
                            $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                            $sponsorDistCommissionledger->setDistId($distId);
                            $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                            $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                            $sponsorDistCommissionledger->setCredit(0);
                            $sponsorDistCommissionledger->setDebit($flushAmount);
                            $sponsorDistCommissionledger->setBalance($commissionBalance);
                            $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                            $sponsorDistCommissionledger->setRemark("FLUSH " . $pairingBonusAmount . " (" . $bonusDate . ")");
                            $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionledger->save();

                            $pairingBonusAmount = $pairingBonusAmount - $flushAmount;
                        }

                        $maintenanceBalance = $pairingBonusAmount * Globals::BONUS_MAINTENANCE_PERCENTAGE;
                        if ($maintenanceBalance != 0) {
                            $ecashBalance = $ecashBalance - $maintenanceBalance;
                            $maintenanceEcashAccountLedger = new MlmAccountLedger();
                            $maintenanceEcashAccountLedger->setDistId($distId);
                            $maintenanceEcashAccountLedger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                            $maintenanceEcashAccountLedger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_MAINTENANCE);
                            $maintenanceEcashAccountLedger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                            $maintenanceEcashAccountLedger->setCredit(0);
                            $maintenanceEcashAccountLedger->setDebit($maintenanceBalance);
                            $maintenanceEcashAccountLedger->setBalance($ecashBalance);
                            $maintenanceEcashAccountLedger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $maintenanceEcashAccountLedger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $maintenanceEcashAccountLedger->save();
                        }

                        $bonusService = new BonusService();
                        //print_r($bonusService->checkDebitAccount($distId)."<br>");
                        //print_r($pairingBonusAmount."<br>");
                        //print_r($flushAmount."<br>");
                        //exit();
                        if ($bonusService->checkDebitAccount($distId) == true) {
                            $debitAccountRemark = "GROUP PAIRING BONUS AMOUNT (" . $bonusDate . ")";
                            $bonusService->contraDebitAccount($distId, $debitAccountRemark, $pairingBonusAmount);
                        }
                        $this->revalidateAccount($distId, Globals::ACCOUNT_TYPE_ECASH);

                        if ($maintenanceBalance != 0) {
                            $commissionBalance = $commissionBalance - $maintenanceBalance;
                            $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                            $sponsorDistCommissionledger->setDistId($distId);
                            $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_GDB);
                            $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_PAIRED);
                            $sponsorDistCommissionledger->setCredit(0);
                            $sponsorDistCommissionledger->setDebit($maintenanceBalance);
                            $sponsorDistCommissionledger->setBalance($commissionBalance);
                            $sponsorDistCommissionledger->setRemark("MAINTENANCE BALANCE (" . $bonusDate . ")");
                            $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionledger->save();

                            $this->revalidateCommission($distId, Globals::COMMISSION_TYPE_GDB);
                        }
                    }
                }
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }

        print_r("Done");
        return sfView::HEADER_ONLY;
    }

    function retrieveGmailMailAttachment()
    {
        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'maximdailyreport@gmail.com';
        $password = 'maximdailyreport868';

        var_dump("start reading email");
        /* try to connect */
        $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        /* grab emails */
        $emails = imap_search($inbox, 'UNSEEN');
        /* if emails are returned, cycle through each... */
        if ($emails) {

            /* begin output var */
            $remarks = '';

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach ($emails as $email_number) {
                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox, $email_number, 0);
                $message = imap_fetchbody($inbox, $email_number, 2);
                $structure = imap_fetchstructure($inbox, $email_number);

                //pre($overview);
                $remarks = "";
                $remarks .= 'subject:' . $overview[0]->subject;
                $remarks .= ', from:' . $overview[0]->from;
                $remarks .= ', date:' . $overview[0]->date;

                $emailSubject = $overview[0]->subject;

                $timeStamp = strtotime($emailSubject); //"06-10-2011 14:28" or "06/10/2011 14:28"

                $tradedDate = date("d-m-Y", $timeStamp); // outputs 06-10

                $attachments = array();
                if (isset($structure->parts) && count($structure->parts)) {
                    for ($i = 0; $i < count($structure->parts); $i++) {
                        $attachments[$i] = array(
                            'is_attachment' => false,
                            'filename' => '',
                            'name' => '',
                            'attachment' => '');


                        if ($structure->parts[$i]->ifdparameters) {
                            foreach ($structure->parts[$i]->dparameters as $object) {
                                if (strtolower($object->attribute) == 'filename') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
                                }
                            }
                        }

                        if ($structure->parts[$i]->ifparameters) {
                            foreach ($structure->parts[$i]->parameters as $object) {
                                if (strtolower($object->attribute) == 'name') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = $object->value;
                                }
                            }
                        }


                        if ($attachments[$i]['is_attachment']) {
                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i + 1);
                            if ($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            }
                            elseif ($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }
                        }
                    } // for($i = 0; $i < count($structure->parts); $i++)
                } // if(isset($structure->parts) && count($structure->parts))

                if (count($attachments) != 0) {
                    foreach ($attachments as $at) {
                        if ($at['is_attachment'] == 1) {
                            $pos = strrpos($at['filename'], "csv");
                            if ($pos === false) { // note: three equal signs
                                // not found...
                            } else {

                                $con = Propel::getConnection(MlmDailyPipsFilePeer::DATABASE_NAME);
                                try {
                                    $con->begin();

                                    $fileName = date("YmdGis") . "_" . $at['filename'];
                                    file_put_contents(sfConfig::get('sf_upload_dir') . '/daily_pips/' . $fileName, $at['attachment']);

                                    $physicalDirectory = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . 'daily_pips' . DIRECTORY_SEPARATOR . $fileName;
                                    $file_handle = fopen($physicalDirectory, "rb");

                                    $mlmDailyPipsFile = new MlmDailyPipsFile();
                                    $mlmDailyPipsFile->setFileType("PIPS");
                                    $mlmDailyPipsFile->setFileSrc($physicalDirectory);
                                    $mlmDailyPipsFile->setFileName($fileName);
                                    $mlmDailyPipsFile->setContentType("application/csv");
                                    $mlmDailyPipsFile->setStatusCode(Globals::STATUS_ACTIVE);
                                    $mlmDailyPipsFile->setRemarks($remarks);
                                    $mlmDailyPipsFile->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlmDailyPipsFile->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                    $mlmDailyPipsFile->save();

                                    while (!feof($file_handle)) {
                                        $line_of_text = fgets($file_handle);
                                        $parts = explode('=', $line_of_text);
                                        //print_r($line_of_text);
                                        $string = $parts[0] . $parts[1];
                                        $arr = explode(';', $string);

                                        $status = Globals::STATUS_PIPS_CSV_ACTIVE;
                                        $remarks = "";

//                                        $mlm_pip_csv = new MlmDailyPipsCsv();
//                                        $mlm_pip_csv->setFileId($mlmDailyPipsFile->getFileId());
//                                        $mlm_pip_csv->setPipsString($string);

                                        if (count($arr) == 12) {
                                            if (is_numeric($arr[0])) {
                                                $idx = 0;
//                                                $mlm_pip_csv->setTradedDatetime($tradedDate);
//                                                $mlm_pip_csv->setLoginId($arr[0]);
//                                                $mlm_pip_csv->setLoginName($arr[1]);
//                                                $mlm_pip_csv->setBalance($arr[12]);
//                                                $mlm_pip_csv->setCredit($arr[5]);
//                                                $mlm_pip_csv->setCommissions($arr[7]);
//                                                $mlm_pip_csv->setTaxes($arr[8]);
//                                                $mlm_pip_csv->setStorage($arr[10]);
//                                                $mlm_pip_csv->setProfit($arr[11]);
                                                //$mlm_pip_csv->setInterest($arr[$idx++]);
                                                //$mlm_pip_csv->setTax($arr[8]);
                                                //$mlm_pip_csv->setUnrealizedpl($arr[$idx++]);
                                                //$mlm_pip_csv->setEquity($arr[$idx++]);
//                                                $mlm_pip_csv->setLoginId($arr[$idx++]);
//                                                $mlm_pip_csv->setLoginName($arr[$idx++]);
//                                                $mlm_pip_csv->setBalance($arr[$idx++]);
//                                                $mlm_pip_csv->setCredit($arr[$idx++]);
//                                                $mlm_pip_csv->setCommissions($arr[$idx++]);
//                                                $mlm_pip_csv->setTaxes($arr[$idx++]);
//                                                $mlm_pip_csv->setStorage($arr[$idx++]);
//                                                $mlm_pip_csv->setProfit($arr[$idx++]);
//                                                $mlm_pip_csv->setInterest($arr[$idx++]);
//                                                $mlm_pip_csv->setTax($arr[$idx++]);
//                                                $mlm_pip_csv->setUnrealizedpl($arr[$idx++]);
//                                                $mlm_pip_csv->setEquity($arr[$idx++]);
//                                                $mlm_pip_csv->setStatusCode($status);
//                                                $mlm_pip_csv->setRemarks($remarks);
//                                                $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                                                $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                                                $mlm_pip_csv->save();
                                                /* ++++++++++++++++++++++++++++++++++++++++++++++
                                               *      Calculate Pips
                                               * +++++++++++++++++++++++++++++++++++++++++++++++*/
                                                //$totalVolume = $mlm_pip_csv->getVolume();
                                                $mt4Id = $arr[0];

                                                $c = new Criteria();
                                                $c->add(MlmDistMt4Peer::MT4_USER_NAME, $mt4Id);
                                                $mlm_dist_mt4 = MlmDistMt4Peer::doSelectOne($c);

                                                if ($mlm_dist_mt4) {
                                                    $mlmDailyDistMt4Credit = new MlmDailyDistMt4Credit();
                                                    $mlmDailyDistMt4Credit->setDistId($mlm_dist_mt4->getDistId());
                                                    $mlmDailyDistMt4Credit->setMt4UserName($mlm_dist_mt4->getMt4UserName());
                                                    $mlmDailyDistMt4Credit->setMt4Credit($arr[2]);
                                                    $mlmDailyDistMt4Credit->setTradedDatetime($tradedDate);
                                                    $mlmDailyDistMt4Credit->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                    $mlmDailyDistMt4Credit->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                                    $mlmDailyDistMt4Credit->save();
                                                } else {
//                                                    $mlm_pip_csv->setStatusCode(Globals::STATUS_PIPS_CSV_ERROR);
//                                                    $mlm_pip_csv->setRemarks("Invalid MT4 ID");
//                                                    $mlm_pip_csv->save();
                                                }
                                                /* ++++++++++++++++++++++++++++++++++++++++++++++
                                               *      ~ END Calculate Pips ~
                                               * +++++++++++++++++++++++++++++++++++++++++++++++*/
                                            } else {
                                                $status = Globals::STATUS_PIPS_CSV_ERROR;
                                                $remarks = "FIRST ELEMENT NOT NUMERIC";

//                                                $mlm_pip_csv->setStatusCode($status);
//                                                $mlm_pip_csv->setRemarks($remarks);
//                                                $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                                                $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                                                $mlm_pip_csv->save();
                                            }
                                        } else {
                                            $status = Globals::STATUS_PIPS_CSV_ERROR;
                                            $remarks = "ARRAY NOT EQUAL TO 12";

//                                            $mlm_pip_csv->setStatusCode($status);
//                                            $mlm_pip_csv->setRemarks($remarks);
//                                            $mlm_pip_csv->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                                            $mlm_pip_csv->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
//                                            $mlm_pip_csv->save();
                                        }
                                    }
                                    $con->commit();
                                } catch (PropelException $e) {
                                    $con->rollback();
                                    throw $e;
                                }
                            }
                        }
                    }
                }
            }
            //echo $output;
        }

        /* close the connection */
        imap_close($inbox);
    }

    public function executeDownloadMt4()
    {
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
        $response->setContentType('application/exe');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', TRUE);
        $response->setHttpHeader('Content-Disposition','attachment; filename=Maxim4Setup.exe', TRUE);
        $response->sendHttpHeaders();
        readfile(sfConfig::get('sf_upload_dir')."/Maxim4Setup.exe");
        return sfView::NONE;
    }

    public function executeConvertEcashToEpoint()
    {
        $this->toHideCp2Cp3Transfer = false;
        $distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        // amz001 chales (20131223)
        $pos = strrpos($distDB->getTreeStructure(), "|1458|");
        if ($pos === false) { // note: three equal signs

        } else {
            $this->toHideCp2Cp3Transfer = true;
            return $this->redirect('/member/summary');
        }
        $ledgerAccountBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
        $this->ledgerAccountBalance = $ledgerAccountBalance;

        $epointAmount = $this->getRequestParameter('epointAmount');

        if ($this->getRequestParameter('epointAmount') > 0 && $this->getRequestParameter('transactionPassword') <> "") {
            /*$distDB = MlmDistributorPeer::retrieveByPK($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $pos = strrpos($distDB->getPlacementTreeStructure(), Globals::ABFX_GROUP);
            if ($pos === false) { // note: three equal signs

            } else {
                $this->setFlash('errorMsg', "This function temporary out of service.");
                return $this->redirect('/member/convertEcashToEpoint');
            }*/
            if ($this->checkIsDebitedAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), null, null, null, Globals::YES_Y, null, null, null, null)) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Convert CP2 To CP1 temporary out of service."));
                return $this->redirect('/member/convertEcashToEpoint');
            }

            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));

            if ($epointAmount > $ledgerAccountBalance) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP2"));

            } elseif (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));

            } elseif ($epointAmount > 0) {
                $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT_EPOINT);
                $tbl_account_ledger->setCredit(0);
                $tbl_account_ledger->setDebit($epointAmount);
                $tbl_account_ledger->setBalance($ledgerAccountBalance - $epointAmount);
                $tbl_account_ledger->setRemark("CONVERT CP2 TO CP1");
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                //$epointConvertedAmount = floor($epointAmount * 1.05);
                //if ($this->toHideCp2Cp3Transfer == true) {
                    $epointConvertedAmount = floor($epointAmount);
                //}

                $tbl_account_ledger = new MlmAccountLedger();
                $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_CONVERT);
                $tbl_account_ledger->setCredit($epointConvertedAmount);
                $tbl_account_ledger->setDebit(0);
                $tbl_account_ledger->setRemark("CONVERT CP2 TO CP1, CP2:".$epointAmount);
                $tbl_account_ledger->setBalance($ledgerEPointBalance + $epointConvertedAmount);
                $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $tbl_account_ledger->save();

                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

                $this->setFlash('successMsg', $this->getContext()->getI18N()->__("CP2 convert to CP1 successful."));

                return $this->redirect('/member/convertEcashToEpoint');
            }
        }
    }

    public function executePurchasePackage()
    {
        $pendingDistId = $this->getRequestParameter('p');

        $c = new Criteria();

        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $pendingDistId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_PENDING);
        $pendingDistDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($pendingDistDB);

        $c = new Criteria();
        $c->add(MlmPackagePeer::PUBLIC_PURCHASE, 1);
        $packageDBs = MlmPackagePeer::doSelect($c);

        $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
        $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
        $this->pendingDistDB = $pendingDistDB;
        $this->packageDBs = $packageDBs;
    }

    public function executePackageUpgrade()
    {
        $dateUtil = new DateUtil();
        /*if ($dateUtil->checkDateIsWithinRange(date("Y-m-d").' 00:00:00', date("Y-m-d").' 01:00:00', date("Y-m-d G:i:s"))) {
            return $this->redirect('home/maintenance');
        }*/
        //if ($this->getRequestParameter('packageTypeSelected') <> "" && $this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('topupPackageTypePaymentType') <> "") {
        if ($this->getRequestParameter('transactionPassword') <> "" && $this->getRequestParameter('pid') <> "") {
            $ledgerECashBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
            $ledgerEPointBalance = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);

            $distDB = null;
            $distId = null;
            if ($this->getRequestParameter('distCode') != "") {
                $c = new Criteria();
                $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $this->getRequestParameter('distCode'));
                $distDB = MlmDistributorPeer::doSelectOne($c);
            } else {
                $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            }
            $this->forward404Unless($distDB);
            $distId = $distDB->getDistributorId();

            $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());
            $currentPackageAmount = $distPackage->getPrice();

            $selectedPackage = MlmPackagePeer::retrieveByPK($this->getRequestParameter('pid'));

            $amountNeeded = 9999999;
            //$paymentType = $this->getRequestParameter('topupPackageTypePaymentType');
            $paymentType = "epoint";

            $tbl_user = AppUserPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_USERID));
            if ($paymentType == 'ecash') {
//                $amountNeeded = $selectedPackage->getPrice() - $currentPackageAmount;
                $amountNeeded = $selectedPackage->getPrice();
            } else if ($paymentType == "epoint") {
//                $amountNeeded = $selectedPackage->getPrice() -  $currentPackageAmount;
                $amountNeeded = $selectedPackage->getPrice();
            }
            /*if ($selectedPackage->getPackageId() == Globals::MAX_PACKAGE_ID) {
                $amountNeeded = $this->getRequestParameter('specialPackagePrice');
            }*/

            if ($amountNeeded > $ledgerECashBalance && $paymentType == "ecash") {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient MT4 Credit amount"));
                return $this->redirect('/member/packageUpgrade');
            } else if ($amountNeeded > $ledgerEPointBalance && $paymentType == "epoint") {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("In-sufficient CP1 amount"));
                return $this->redirect('/member/packageUpgrade');
            } else if (strtoupper($tbl_user->getUserpassword2()) <> strtoupper($this->getRequestParameter('transactionPassword'))) {
                $this->setFlash('errorMsg', $this->getContext()->getI18N()->__("Invalid Security password"));
                return $this->redirect('/member/packageUpgrade');
            } else {
                $con = Propel::getConnection(MlmDailyBonusLogPeer::DATABASE_NAME);
                try {
                    $con->begin();

                    $tbl_account_ledger = new MlmAccountLedger();
                    $tbl_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
                    $tbl_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_PACKAGE_UPGRADE);
                    $tbl_account_ledger->setCredit(0);

                    if ($paymentType == "ecash") {
                        $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                        $tbl_account_ledger->setBalance($ledgerECashBalance - $amountNeeded);
                    } elseif ($paymentType == "epoint") {
                        $tbl_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
                        $tbl_account_ledger->setBalance($ledgerEPointBalance - $amountNeeded);
                    }
                    $tbl_account_ledger->setDebit($amountNeeded);
                    $tbl_account_ledger->setRemark("PACKAGE UPGRADED FROM ".$distPackage->getPackageName()." => ".$selectedPackage->getPackageName());
                    $tbl_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $tbl_account_ledger->save();

                    if ($paymentType == "ecash") {
                        $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
                    } elseif ($paymentType == "epoint") {
                        $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
                    }

                    // ******       company account      ****************
                    $mlmPackageUpgradeHistory = new MlmPackageUpgradeHistory();
                    $mlmPackageUpgradeHistory->setDistId($distId);
                    $mlmPackageUpgradeHistory->setTransactionCode(Globals::ACCOUNT_LEDGER_ACTION_PACKAGE_UPGRADE);
                    $mlmPackageUpgradeHistory->setAmount($amountNeeded);
                    $mlmPackageUpgradeHistory->setPackageId($selectedPackage->getPackageId());
                    $mlmPackageUpgradeHistory->setStatusCode(Globals::STATUS_ACTIVE);
                    $mlmPackageUpgradeHistory->setRemarks("PACKAGE UPGRADED FROM ".$distPackage->getPackageName()." => ".$selectedPackage->getPackageName());
                    $mlmPackageUpgradeHistory->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageUpgradeHistory->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlmPackageUpgradeHistory->save();

                    $distPackageDB = MlmPackagePeer::retrieveByPK($distDB->getRankId());
                    if ($distPackageDB && $selectedPackage->getPrice() > $distPackageDB->getPrice()) {
                        $distDB->setRankId($selectedPackage->getPackageId());
                        $distDB->setRankCode($selectedPackage->getPackageName());
                        $distDB->save();
                    }

                    // create mlm_dist_pairing
                    $sponsorDistPairingDB = MlmDistPairingPeer::retrieveByPK($distId);
                    if (!$sponsorDistPairingDB) {
                        $sponsorDistPairingDB = new MlmDistPairing();
                        $sponsorDistPairingDB->setDistId($distId);
                        $sponsorDistPairingDB->setLeftBalance(0);
                        $sponsorDistPairingDB->setRightBalance(0);
                        $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    }
                    $sponsorDistPairingDB->setFlushLimit($selectedPackage->getDailyMaxPairing());
                    $sponsorDistPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistPairingDB->save();
                    /* ****************************************************
                     * ROI Divident
                     * ***************************************************/
                    $dateUtil = new DateUtil();
                    $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d")) . " 00:00:00";
                    $currentDate_timestamp = strtotime($currentDate);
                    //$dividendDate = $dateUtil->addDate($currentDate, 30, 0, 0);
                    $dividendDate = strtotime("+1 months", $currentDate_timestamp);

                    /*$mlm_roi_dividend = new MlmRoiDividend();
                    $mlm_roi_dividend->setDistId($distId);
                    $mlm_roi_dividend->setIdx(1);
                    //$mlm_roi_dividend->setAccountLedgerId($this->getRequestParameter('account_ledger_id'));
                    $mlm_roi_dividend->setDividendDate(date("Y-m-d h:i:s", $dividendDate));
                    $mlm_roi_dividend->setFirstDividendDate(date("Y-m-d h:i:s", $dividendDate));
                    $mlm_roi_dividend->setPackageId($selectedPackage->getPackageId());
                    $mlm_roi_dividend->setPackagePrice($amountNeeded);
                    $mlm_roi_dividend->setRoiPercentage($selectedPackage->getMonthlyPerformance());
                    //$mlm_roi_dividend->setDevidendAmount($this->getRequestParameter('devidend_amount'));
                    //$mlm_roi_dividend->setRemarks($this->getRequestParameter('remarks'));
                    $mlm_roi_dividend->setStatusCode(Globals::DIVIDEND_STATUS_PENDING);
                    $mlm_roi_dividend->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $mlm_roi_dividend->save();*/


                    /**************************************/
                    /*  Direct REFERRER Bonus For Upline
                    /**************************************/
                    $uplineDistId = $distDB->getUplineDistId();
                    $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);
                    if ($uplineDistDB) {
                        //if ($uplineDistDB->getIbRankId() != null) {
                        if ($uplineDistDB->getIsIb() == Globals::YES) {
                            $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                            $directSponsorBonusAmount = $directSponsorPercentage * $amountNeeded / 100;
                        } else {
                            $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                            $directSponsorPercentage = $uplineDistPackage->getCommission();
                            $directSponsorBonusAmount = $directSponsorPercentage * $amountNeeded / 100;
                        }
                        $totalBonusPayOut = $directSponsorPercentage;

                        /******************************/
                        /*  store Pairing points
                        /******************************/
                        $pairingPoint = $amountNeeded;
                        $uplinePosition = $distDB->getPlacementPosition();
                        if ($distDB->getTreeUplineDistId() != 0 && $distDB->getTreeUplineDistCode() != null) {
                            $level = 0;
                            $uplineDistDB = MlmDistributorPeer::retrieveByPk($distDB->getTreeUplineDistId());
                            $sponsoredDistributorCode = $distDB->getDistributorCode();
                            while ($level < 400) {
                                //var_dump($uplineDistDB->getUplineDistId());
                                //var_dump($uplineDistDB->getUplineDistCode());
                                //print_r($uplineDistDB->getDistributorId()."<br>");
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
                                    $this->forward404Unless($packageDB);

                                    $sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
                                    $sponsorDistPairingDB->setLeftBalance($leftBalance);
                                    $sponsorDistPairingDB->setRightBalance($rightBalance);
                                    $sponsorDistPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                } else {
                                    $leftBalance = $sponsorDistPairingDB->getLeftBalance();
                                    $rightBalance = $sponsorDistPairingDB->getRightBalance();
                                }
                                //$sponsorDistPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
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
                                $sponsorDistPairingledger->setDebit(0);
                                $sponsorDistPairingledger->setBalance($legBalance + $pairingPoint);
                                $sponsorDistPairingledger->setRemark("PAIRING POINT AMOUNT (" . $sponsoredDistributorCode . ")");
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
                        }
                        /******************************/
                        /*  Direct Sponsor Bonus
                        /******************************/
                        $uplineDistId = $distDB->getUplineDistId();
                        $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                        $firstForDRB = true;
                        while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                            $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                            $mlm_account_ledger = new MlmAccountLedger();
                            $mlm_account_ledger->setDistId($uplineDistId);
                            $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                            $mlm_account_ledger->setRemark("PACKAGE UPGRADE ".$directSponsorPercentage."% for " . $distDB->getDistributorCode() . " (" .$distPackage->getPackageName()." => ".$selectedPackage->getPackageName().")");
                            $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                            $mlm_account_ledger->setDebit(0);
                            $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $mlm_account_ledger->save();

                            $bonusService = new BonusService();
                            if ($bonusService->checkDebitAccount($uplineDistId) == true) {
                                $debitAccountRemark = "PACKAGE UPGRADE ".$directSponsorPercentage."% for " . $distDB->getDistributorCode() . " (" .$distPackage->getPackageName()." => ".$selectedPackage->getPackageName().")";
                                $bonusService->contraDebitAccount($uplineDistId, $debitAccountRemark, $directSponsorBonusAmount);
                            }
                            $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                            /******************************/
                            /*  Commission
                            /******************************/
                            $c = new Criteria();
                            $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                            $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                            $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                            $commissionBalance = 0;
                            if (!$sponsorDistCommissionDB) {
                                $sponsorDistCommissionDB = new MlmDistCommission();
                                $sponsorDistCommissionDB->setDistId($uplineDistId);
                                $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                                $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            } else {
                                $commissionBalance = $sponsorDistCommissionDB->getBalance();
                            }
                            $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                            $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionDB->save();

                            $c = new Criteria();
                            $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                            $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                            $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                            $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                            $dsbBalance = 0;
                            if ($sponsorDistCommissionLedgerDB)
                                $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                            $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                            $sponsorDistCommissionledger->setDistId($uplineDistId);
                            $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                            $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_UPGRADE);
                            $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                            $sponsorDistCommissionledger->setDebit(0);
                            $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                            $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                            //$sponsorDistCommissionledger->setRemark("PACKAGE UPGRADE BONUS AMOUNT ".$directSponsorPercentage."% (" . $distDB->getDistributorCode() . "-" . $distDB->getMt4UserName() . ")");
                            if ($firstForDRB == true) {
                                $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE UPGRADE ".$directSponsorPercentage."% (" .$distPackage->getPackageName()."=>".$selectedPackage->getPackageName().") for " . $distDB->getDistributorCode());
                                $firstForDRB = false;
                            } else {
                                $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE UPGRADE ".$directSponsorPercentage."% (" .$distPackage->getPackageName()."=>".$selectedPackage->getPackageName().") for " . $distDB->getDistributorCode());
                            }
                            $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                            $sponsorDistCommissionledger->save();

                            $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                            //var_dump("==>1");
                            if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT) {
                                //var_dump("==>2");
                                $checkCommission = true;
                                $uplineDistId = $uplineDistDB->getUplineDistId();

                                while ($checkCommission == true) {
                                    //var_dump("==>3**".$uplineDistId);
                                    if ($uplineDistId == null || $uplineDistId == 0) {
                                        $totalBonusPayOut = Globals::TOTAL_BONUS_PAYOUT;
                                        break;
                                    }
                                    $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                                    if (!$uplineDistDB) {
                                        break;
                                    }

                                    if ($uplineDistDB->getIsIb() == Globals::YES) {
                                        /*if ($uplineDistDB->getIbRankId() != null) {
                                            $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                                        } else {
                                            $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                        }*/
                                        //$directSponsorPercentage = $uplineDistPackage->getCommission();
                                        $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                                    } else {
                                        $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                                        $directSponsorPercentage = $uplineDistPackage->getCommission();
                                    }
                                    if ($directSponsorPercentage > $totalBonusPayOut) {
                                        //var_dump("==>6");
                                        $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                                        $totalBonusPayOut += $directSponsorPercentage;
                                        if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                            //var_dump("==>7");
                                            $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                                        }
                                    } else {
                                        //var_dump("==>8");
                                        $uplineDistId = $uplineDistDB->getUplineDistId();
                                        continue;
                                    }

                                    $directSponsorBonusAmount = $directSponsorPercentage * $amountNeeded / 100;
                                    $checkCommission == false;
                                    break;
                                    //var_dump("==>9");
                                }
                            } else {
                                break;
                                //var_dump("==>^^");
                            }
                        }
                    }

                    $this->setFlash('successMsg', $this->getContext()->getI18N()->__("Package upgraded successful."));
                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
                return $this->redirect('/member/packageUpgrade');
            }
        } else {
            $c = new Criteria();
            $c->add(MlmPackagePeer::PUBLIC_PURCHASE, 1);
            $c->addAscendingOrderByColumn(MlmPackagePeer::PRICE);
            $packageDBs = MlmPackagePeer::doSelect($c);

            /*$c = new Criteria();
            $c->addDescendingOrderByColumn(MlmPackagePeer::PRICE);
            $highestPackageDB = MlmPackagePeer::doSelectOne($c);*/

            $distDB = MlmDistributorPeer::retrieveByPk($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $this->forward404Unless($distDB);

            $distPackage = MlmPackagePeer::retrieveByPK($distDB->getRankId());

            $this->systemCurrency = $this->getAppSetting(Globals::SETTING_SYSTEM_CURRENCY);
            $this->pointAvailable = $this->getAccountBalance($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
            $this->packageDBs = $packageDBs;
            $this->distPackage = $distPackage;
            $this->distDB = $distDB;
            //$this->highestPackageDB = $highestPackageDB;
        }
    }

    /************************************************************************************************************************
     * function
     ************************************************************************************************************************/
    function getDistributorIdByCode($sponsorCode)
    {
        $userId = 0;

        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $sponsorCode);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $existUser = MlmDistributorPeer::doSelectOne($c);

        if ($existUser) {
            $userId = $existUser->getDistributorId();
        }

        return $userId;
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

    function revalidatePairing($distributorId, $leftRight)
    {
        //$balance = $this->getPairingBalance($distributorId, $leftRight);

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
        /*if (Globals::PLACEMENT_LEFT == $leftRight) {
            $tbl_account->setLeftBalance($balance);
        } else if (Globals::PLACEMENT_RIGHT == $leftRight) {
            $tbl_account->setRightBalance($balance);
        }*/

        //$tbl_account->save();
    }

    function getPairingBalance($distributorId, $leftRight)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId . " AND left_right = '" . $leftRight . "'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();

        $count = 0;
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

    function doActivateAccount($uplineDistId, $sponsorId, $packageId, $paymentType)
    {
        $packageDB = MlmPackagePeer::retrieveByPK($packageId);
        $this->forward404Unless($packageDB);
        $packageAmount = $packageDB->getPrice();

        /* ****************************************************
         * get distributor last account ledger epoint balance
         * ***************************************************/
        $c = new Criteria();
        $c->add(MlmAccountLedgerPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID));
        if ("epoint" == $paymentType) {
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_EPOINT);
        } else if ("ecash" == $paymentType) {
            $c->add(MlmAccountLedgerPeer::ACCOUNT_TYPE, Globals::ACCOUNT_TYPE_ECASH);
        }
        $c->addDescendingOrderByColumn(MlmAccountLedgerPeer::CREATED_ON);
        $accountLedgerDB = MlmAccountLedgerPeer::doSelectOne($c);
        if (!$accountLedgerDB) {
            $accountLedgerDB = new MlmAccountLedger();
            $accountLedgerDB->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            $accountLedgerDB->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            $accountLedgerDB->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
            $accountLedgerDB->setRemark("");
            $accountLedgerDB->setCredit(0);
            $accountLedgerDB->setDebit(0);
            $accountLedgerDB->setBalance(0);
            $accountLedgerDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $accountLedgerDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $accountLedgerDB->save();
        }

        $sponsorAccountBalance = $accountLedgerDB->getBalance();

        /* ****************************************************
         * get sponsored distributor and user
         * ***************************************************/
        $c = new Criteria();
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $sponsorId);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_PENDING);
        $sponsoredDistDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($sponsoredDistDB);

        $userDB = AppUserPeer::retrieveByPK($sponsoredDistDB->getUserId());
        $this->forward404Unless($userDB);

        /* ****************************************************
         * update sponsored distributor and user
         * ***************************************************/
        $sponsoredDistDB->setRankId($packageDB->getPackageId());
        $sponsoredDistDB->setRankCode($packageDB->getPackageName());
        $sponsoredDistDB->setInitRankId($packageDB->getPackageId());
        $sponsoredDistDB->setInitRankCode($packageDB->getPackageName());
        $sponsoredDistDB->setStatusCode(Globals::STATUS_ACTIVE);
        $sponsoredDistDB->setPackagePurchaseFlag("Y");
        $sponsoredDistDB->setActiveDatetime(date("Y/m/d h:i:s A"));
        $sponsoredDistDB->setActivatedBy($this->getUser()->getAttribute(Globals::SESSION_DISTID));
        $sponsoredDistDB->save();

        $userDB->setStatusCode(Globals::STATUS_ACTIVE);
        $userDB->save();

        /**************************************/
        /*  Direct REFERRER Bonus For Upline
        /**************************************/
        $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);
        if ($uplineDistDB) {
            //if ($uplineDistDB->getIbRankId() != null) {
            if ($uplineDistDB->getIsIb() == Globals::YES) {
                $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
            } else {
                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                $directSponsorPercentage = $uplineDistPackage->getCommission();
                $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
            }
            $totalBonusPayOut = $directSponsorPercentage;

            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_ECASH, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");
            $this->doSaveAccount($sponsorId, Globals::ACCOUNT_TYPE_EPOINT, 0, 0, Globals::ACCOUNT_LEDGER_ACTION_REGISTER, "");
            /* ****************************************************
           * Update upline distributor account
           * ***************************************************/
            $sponsorAccountBalance = $sponsorAccountBalance - $packageDB->getPrice();

            $mlm_account_ledger = new MlmAccountLedger();
            $mlm_account_ledger->setDistId($this->getUser()->getAttribute(Globals::SESSION_DISTID));
            if ("epoint" == $paymentType) {
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_EPOINT);
            } else if ("ecash" == $paymentType) {
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
            }
            $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_REGISTER);
            $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") - ".$sponsoredDistDB->getDistributorCode());
            $mlm_account_ledger->setCredit(0);
            $mlm_account_ledger->setDebit($packageDB->getPrice());
            $mlm_account_ledger->setBalance($sponsorAccountBalance);
            $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $mlm_account_ledger->save();

            if ("epoint" == $paymentType) {
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_EPOINT);
            } else if ("ecash" == $paymentType) {
                $this->revalidateAccount($this->getUser()->getAttribute(Globals::SESSION_DISTID), Globals::ACCOUNT_TYPE_ECASH);
            }

            /******************************/
            /*  Direct Sponsor Bonus
            /******************************/
            $firstForDRB = true;
            while ($totalBonusPayOut <= Globals::TOTAL_BONUS_PAYOUT) {
                $distAccountEcashBalance = $this->getAccountBalance($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                $mlm_account_ledger = new MlmAccountLedger();
                $mlm_account_ledger->setDistId($uplineDistId);
                $mlm_account_ledger->setAccountType(Globals::ACCOUNT_TYPE_ECASH);
                $mlm_account_ledger->setTransactionType(Globals::ACCOUNT_LEDGER_ACTION_DRB);
                $mlm_account_ledger->setRemark("PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $sponsoredDistDB->getDistributorCode() . ")");
                $mlm_account_ledger->setCredit($directSponsorBonusAmount);
                $mlm_account_ledger->setDebit(0);
                $mlm_account_ledger->setBalance($distAccountEcashBalance + $directSponsorBonusAmount);
                $mlm_account_ledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $mlm_account_ledger->save();

                $bonusService = new BonusService();
                if ($bonusService->checkDebitAccount($uplineDistId) == true) {
                    $debitAccountRemark = "PACKAGE PURCHASE (".$packageDB->getPackageName().") ".$directSponsorPercentage."% (" . $sponsoredDistDB->getDistributorCode() . ")";
                    $bonusService->contraDebitAccount($uplineDistId, $debitAccountRemark, $directSponsorBonusAmount);
                }
                $this->revalidateAccount($uplineDistId, Globals::ACCOUNT_TYPE_ECASH);

                /******************************/
                /*  Commission
                /******************************/
                $c = new Criteria();
                $c->add(MlmDistCommissionPeer::DIST_ID, $uplineDistId);
                $c->add(MlmDistCommissionPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                $sponsorDistCommissionDB = MlmDistCommissionPeer::doSelectOne($c);

                $commissionBalance = 0;
                if (!$sponsorDistCommissionDB) {
                    $sponsorDistCommissionDB = new MlmDistCommission();
                    $sponsorDistCommissionDB->setDistId($uplineDistId);
                    $sponsorDistCommissionDB->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                    $sponsorDistCommissionDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                    $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                } else {
                    $commissionBalance = $sponsorDistCommissionDB->getBalance();
                }
                $sponsorDistCommissionDB->setBalance($commissionBalance + $directSponsorBonusAmount);
                $sponsorDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionDB->save();

                $c = new Criteria();
                $c->add(MlmDistCommissionLedgerPeer::DIST_ID, $uplineDistId);
                $c->add(MlmDistCommissionLedgerPeer::COMMISSION_TYPE, Globals::COMMISSION_TYPE_DRB);
                $c->addDescendingOrderByColumn(MlmDistCommissionLedgerPeer::CREATED_ON);
                $sponsorDistCommissionLedgerDB = MlmDistCommissionLedgerPeer::doSelectOne($c);

                $dsbBalance = 0;
                if ($sponsorDistCommissionLedgerDB)
                    $dsbBalance = $sponsorDistCommissionLedgerDB->getBalance();

                $sponsorDistCommissionledger = new MlmDistCommissionLedger();
                $sponsorDistCommissionledger->setDistId($uplineDistId);
                $sponsorDistCommissionledger->setCommissionType(Globals::COMMISSION_TYPE_DRB);
                $sponsorDistCommissionledger->setTransactionType(Globals::COMMISSION_LEDGER_REGISTER);
                $sponsorDistCommissionledger->setCredit($directSponsorBonusAmount);
                $sponsorDistCommissionledger->setDebit(0);
                $sponsorDistCommissionledger->setStatusCode(Globals::STATUS_ACTIVE);
                $sponsorDistCommissionledger->setBalance($dsbBalance + $directSponsorBonusAmount);
                if ($firstForDRB == true) {
                    $sponsorDistCommissionledger->setRemark("DRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$sponsoredDistDB->getDistributorCode());
                    $firstForDRB = false;
                } else {
                    $sponsorDistCommissionledger->setRemark("GRB FOR PACKAGE PURCHASE ".$directSponsorPercentage."% (".$packageDB->getPackageName().") for ".$sponsoredDistDB->getDistributorCode());
                }
                $sponsorDistCommissionledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
                $sponsorDistCommissionledger->save();

                $this->revalidateCommission($uplineDistId, Globals::COMMISSION_TYPE_DRB);
                //var_dump("==>1");
                if ($totalBonusPayOut < Globals::TOTAL_BONUS_PAYOUT) {
                    //var_dump("==>2");
                    $checkCommission = true;
                    $uplineDistId = $uplineDistDB->getUplineDistId();
                    while ($checkCommission == true) {
                        //var_dump("==>3**".$uplineDistId);
                        $uplineDistDB = MlmDistributorPeer::retrieveByPK($uplineDistId);

                        //var_dump("==>3$$".$uplineDistId);
                        $this->forward404Unless($uplineDistDB);

                        if ($uplineDistDB->getIsIb() == Globals::YES) {
                            /*if ($uplineDistDB->getIbRankId() != null) {
                                $uplineDistPackage = MlmIbPackagePeer::retrieveByPK($uplineDistDB->getIbRankId());
                            } else {
                                $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                            }*/
                            $directSponsorPercentage = $uplineDistDB->getIbCommission() * 100;
                        } else {
                            $uplineDistPackage = MlmPackagePeer::retrieveByPK($uplineDistDB->getRankId());
                            $directSponsorPercentage = $uplineDistPackage->getCommission();
                        }
                        if ($directSponsorPercentage > $totalBonusPayOut) {
                            //var_dump("==>6");
                            $directSponsorPercentage = $directSponsorPercentage - $totalBonusPayOut;
                            $totalBonusPayOut += $directSponsorPercentage;
                            if ($totalBonusPayOut > Globals::TOTAL_BONUS_PAYOUT) {
                                //var_dump("==>7");
                                $directSponsorPercentage = $directSponsorPercentage - ($totalBonusPayOut - Globals::TOTAL_BONUS_PAYOUT);
                            }
                        } else {
                            //var_dump("==>8");
                            $uplineDistId = $uplineDistDB->getUplineDistId();
                            continue;
                        }

                        $directSponsorBonusAmount = $directSponsorPercentage * $packageDB->getPrice() / 100;
                        $checkCommission == false;
                        break;
                        //var_dump("==>9");
                    }
                } else {
                    break;
                    //var_dump("==>^^");
                }
            }
        }

    }

    function getAppSetting($parameter)
    {
        $result = "";
        $c = new Criteria();
        $c->add(AppSettingPeer::SETTING_PARAMETER, $parameter);
        $settingDB = AppSettingPeer::doSelectOne($c);
        if ($settingDB) {
            $result = $settingDB->getSettingValue();
        }
        return $result;
    }

    function doSaveAccount($distId, $accountType, $credit, $debit, $transactionType, $remarks)
    {
        $c = new Criteria();
        $c->add(MlmAccountPeer::ACCOUNT_TYPE, $accountType);
        $c->add(MlmAccountPeer::DIST_ID, $distId);
        $mlm_account = MlmAccountPeer::doSelectOne($c);

        if (!$mlm_account) {
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
    }

    function getDistributorInformation($distCode)
    {
        $c = new Criteria();

        $c->add(MlmDistributorPeer::DISTRIBUTOR_CODE, $distCode);
        //$c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);
        $distDB = MlmDistributorPeer::doSelectOne($c);
        $this->forward404Unless($distDB);

        return $distDB;
    }

    function getPlacementDistributorInformation($uplineDistId, $placeLocation)
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::TREE_UPLINE_DIST_ID, $uplineDistId);
        $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $placeLocation);
        //$c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);

        $placeDB = MlmDistributorPeer::doSelectOne($c);
        return $placeDB;
    }

    function getTotalPosition($distId, $position)
    {
        $c = new Criteria();
        $c->add(MlmDistributorPeer::PLACEMENT_POSITION, $position);
        $c->add(MlmDistributorPeer::DISTRIBUTOR_ID, $distId, Criteria::NOT_EQUAL);
        $c->add(MlmDistributorPeer::PLACEMENT_TREE_STRUCTURE, "%|" . $distId . "|%", Criteria::LIKE);
        $c->add(MlmDistributorPeer::STATUS_CODE, Globals::STATUS_ACTIVE);

        $totalDis = MlmDistributorPeer::doCount($c);
        return $totalDis;
    }

    function queryDistPairing($distributorId)
    {
        $c = new Criteria();
        $c->add(MlmDistPairingPeer::DIST_ID, $distributorId);
        $mlmDist = MlmDistPairingPeer::doSelectOne($c);
        if (!$mlmDist) {
            $distDB = MlmDistributorPeer::retrieveByPK($distributorId);
            $distPairingDB = new MlmDistPairing();
            $distPairingDB->setDistId($distributorId);

            $packageDB = MlmPackagePeer::retrieveByPK($distDB->getRankId());
            $this->forward404Unless($packageDB);

            $distPairingDB->setLeftBalance(0);
            $distPairingDB->setRightBalance(0);
            $distPairingDB->setFlushLimit($packageDB->getDailyMaxPairing());
            $distPairingDB->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $distPairingDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
            $distPairingDB->save();
            return $distPairingDB;
        }
        return $mlmDist;
    }

    function getThisMonthSales($distributorId, $position)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth();
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'"
                 . " AND transaction_type = '" . Globals::PAIRING_LEDGER_REGISTER . "'"
                 . " AND created_on >= '" . $firstOfMonth . "' AND created_on <= '" . $lastOfMonth . "'";

        //var_dump($query);
        //exit();
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

    function findPairingLedgers($distributorId, $position, $date)
    {
        $query = "SELECT SUM(credit-debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'";

        if ($date != null) {
            $query .= " AND created_on <= '" . $date . " 23:59:59'";
        }
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

    function findPairingLedgersBonus($distributorId, $position, $date)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        //var_dump($yesterday);
        //exit();
        $totalCredit = $this->getPairingSumCredit($distributorId, $position, $yesterday);
        $totalDebit = $this->getPairingSumDebit($distributorId, $position, null);

        if ($totalCredit > $totalDebit) {
            return $totalCredit - $totalDebit;
        } else {
            return 0;
        }
    }

    function getPairingSumCredit($distributorId, $position, $date)
    {
        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'";

        if ($date != null) {
            $query .= " AND created_on <= '" . $date . " 23:59:59'";
        }
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

    function getPairingSumDebit($distributorId, $position, $date)
    {
        $query = "SELECT SUM(debit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'";

        if ($date != null) {
            $query .= " AND created_on <= '" . $date . " 23:59:59'";
        }
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

    function getDsbAmount($distributorId, $date)
    {
        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_commission_ledger WHERE dist_id = " . $distributorId
                 . " AND commission_type = '" . Globals::ACCOUNT_LEDGER_ACTION_DRB . "'";

        $query .= " AND created_on >= '" . $date . " 00:00:00'";
        $query .= " AND created_on <= '" . $date . " 23:59:59'";

        //var_dump($query);
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

    function updateDistPairingLeader($distId, $position, $debit, $remark="PAIRED", $transactionType=Globals::PAIRING_LEDGER_PAIRED)
    {
        /*$c = new Criteria();
        $c->add(MlmDistPairingLedgerPeer::DIST_ID, $distId);
        $c->add(MlmDistPairingLedgerPeer::LEFT_RIGHT, $position);
        $c->addDescendingOrderByColumn(MlmDistPairingLedgerPeer::CREATED_ON);
        $sponsorDistPairingLedgerDB = MlmDistPairingLedgerPeer::doSelectOne($c);

        $legBalance = 0;
        if ($sponsorDistPairingLedgerDB) {
            $legBalance = $sponsorDistPairingLedgerDB->getBalance();
        }*/
        $legBalance = $this->findPairingLedgers($distId, $position, null);
        // update pairing balance
        $distPairingledger = new MlmDistPairingLedger();
        $distPairingledger->setDistId($distId);
        $distPairingledger->setLeftRight($position);
        $distPairingledger->setTransactionType($transactionType);
        $distPairingledger->setCredit(0);
        $distPairingledger->setDebit($debit);
        $distPairingledger->setBalance($legBalance - $debit);
        $distPairingledger->setRemark($remark);
        $distPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->save();

        $this->revalidatePairing($distId, $position);
    }

    function flushDistPairingLeader($distId, $position, $minBalance, $remark)
    {
        $distPairingledger = new MlmDistPairingLedger();
        $distPairingledger->setDistId($distId);
        $distPairingledger->setLeftRight($position);
        $distPairingledger->setTransactionType(Globals::PAIRING_LEDGER_FLUSH);
        $distPairingledger->setCredit(0);
        $distPairingledger->setDebit($minBalance);
        $distPairingledger->setBalance(0);
        $distPairingledger->setRemark($remark);
        $distPairingledger->setCreatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
        $distPairingledger->save();

        $this->revalidatePairing($distId, $position);
    }

    function getPipsBonusDetailByMonth($distributorId, $month, $year, $fileId)
    {
        //$dateUtil = new DateUtil();

        //$d = $dateUtil->getMonth($month, $year);
        //$firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        //$lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_PIPS_BONUS . "'"
                 . " AND bonus.transaction_type = '" . Globals::COMMISSION_LEDGER_PIPS_GAIN . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($fileId != null) {
            $query = $query." csv.file_id = ".$fileId;
        }
        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

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

    function getRbDetailByMonth($distributorId, $month, $year)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth($month, $year);
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_DRB . "'"
                 . " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

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

    function getPairingDetailByMonth($distributorId, $month, $year)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth($month, $year);
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_GDB . "'"
                 . " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

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

    function getCreditRefundDetailByMonth($distributorId, $month, $year, $fileId)
    {
        //$dateUtil = new DateUtil();

        //$d = $dateUtil->getMonth($month, $year);
        //$firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        //$lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                LEFT JOIN mlm_pip_csv csv ON csv.pip_id = bonus.ref_id
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_CREDIT_REFUND . "'"
                 . " AND csv.month_traded = '" . $month . "' AND csv.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        if ($fileId != null) {
            $query = $query." csv.file_id = ".$fileId;
        }
        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }
        //var_dump($query);

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

    function getFundDividendDetailByMonth($distributorId, $month, $year)
    {
        $query = "SELECT SUM(bonus.credit-bonus.debit) AS SUB_TOTAL FROM mlm_dist_commission_ledger bonus
                        WHERE 1=1 "
                 . " AND bonus.commission_type = '" . Globals::COMMISSION_TYPE_FUND_MANAGEMENT . "'"
                 . " AND bonus.month_traded = '" . $month . "' AND bonus.year_traded = '" . $year . "'";
                 //. " AND bonus.created_on >= '" . $firstOfMonth . "' AND bonus.created_on <= '" . $lastOfMonth . "'";

        /*if ($fileId != null) {
            $query = $query." csv.file_id = ".$fileId;
        }*/
        if ($distributorId != null) {
            $query = $query." AND bonus.dist_id = ".$distributorId;
        }

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

    function getRankColor($packageId)
    {
        $color = "blue";

        $package = MlmPackagePeer::retrieveByPK($packageId);
        if ($package) {
            $color = $package->getColor();
        }

        return $color;
    }
    function getRankColorArr()
    {
        $packageArray = array();
        $c = new Criteria();
        $packages = MlmPackagePeer::doSelect($c);
        foreach ($packages as $package) {
            $packageArray[$package->getPackageId()] = $package->getColor();
        }

        return $packageArray;
    }

    function getAccumulateGroupBvs($distributorId, $position)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth();
        $firstOfMonth = date('Y-m-j', $d["first_of_month"]) . " 00:00:00";
        $lastOfMonth = date('Y-m-j', $d["last_of_month"]) . " 23:59:59";

        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'"
                 . " AND transaction_type = '" . Globals::PAIRING_LEDGER_REGISTER . "'";

        //var_dump($query);
        //exit();
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

    function getTodaySales($distributorId, $position)
    {
        $dateUtil = new DateUtil();

        $d = $dateUtil->getMonth();
        $firstOfMonth = date('Y-m-j') . " 00:00:00";
        $lastOfMonth = date('Y-m-j') . " 23:59:59";

        $query = "SELECT SUM(credit) AS SUB_TOTAL FROM mlm_dist_pairing_ledger WHERE dist_id = " . $distributorId
                 . " AND left_right = '" . $position . "'"
                 . " AND transaction_type = '" . Globals::PAIRING_LEDGER_REGISTER . "'"
                 . " AND created_on >= '" . $firstOfMonth . "' AND created_on <= '" . $lastOfMonth . "'";

        //var_dump($query);
        //exit();
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

    function executeSendRemindationEmailForUploadAgreement()
    {
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
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:17px'>
												Dear our distinguished member,
<br><br>
Thank you for your support and faith in us!
<br><br>
Owning to the terms as stipulated by Forex world, please provide us your documents:
<br><br>
1)      Identification (IC / Passport, front and back at same page)
<br><br>
2)      Proof of Address (Bank / Credit Card statement, OR Water / Electric statement, OR Phone / Internet statement)
<br><br>
-          Your name, current address and the date of the latest 3 months must be shown at the statement.
<br><br>
3)      Download and sign the Forex Agreements.
<br><br>
And upload all the documents at website.
<br><br>
Note:
<br><br>
Please logon to http://partner.maximtrader.com. Click “User Profile” to upload all the documents at “Upload Document”.
<br><br>
Thank you for your highly cooperation.
<br><br>
Wish you all the best.
<br><br>
<br><br>


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
																<font face='Arial, Verdana, sans-serif' size='3' color='#000000' style='font-size:12px;line-height:17px'>
												亲爱的会员，
<br><br>
您好。
<br><br>
由于外汇的要求严谨，请您将您的文件包括：
<br><br>
1） 身份证（正反面在同一页）
<br><br>
2） 地址证明（银行/信用卡明细单，或水/电明细单，或电话/网络明细单）
<br><br>
-          明细单必须清楚列明您的姓名，目前住址及最近3个月日期。
<br><br>
3） 下载并签署外汇合约。
<br><br>
上传给公司，否则这会影响您日后的提现。
<br><br>
注：请登入http://partner.maximtrader.com，点击“用户个人资料”将所有文件上传给公司（点击“上传文件”）。
<br><br>
谢谢您的鼎力合作。
<br><br>
祝：一切顺利

												<br>
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜金融集团是Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子公司。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
        $subject = "Maxim Trader Forex Agreement 外汇合约";

        $dateUtil = new DateUtil();
        $date = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate(date("Y-m-d"), -7, 0, 0));
        $arrs = $this->fetchMemberWithoutUploadDocument($date);
        foreach ($arrs as $arr) {
            $receiverEmail = $arr['email'];
            $receiverFullName = $arr['full_name'];

            //print_r($receiverFullName."<br>");
            $sendMailService->sendMail($receiverEmail, $receiverFullName, $subject, $body);
        }
    }

    function sendDailyReport()
    {
        $body = "";
        $body .= $this->getAllBonusData();
        $body .= $this->getRollingPointData();
        $body .= $this->getPackageSaleData();
        //$body .= $this->getUpcomingPerformanceReturn();

        $sendMailService = new SendMailService();
        $dateUtil = new DateUtil();
        $subject = "Maxim Trader Daily Report ".$dateUtil->formatDate("Y-m-d", $dateUtil->addDate(date("Y-m-d"), -1, 0, 0));

//        $sendMailService->sendMail("r9jason@gmail.com", "Boss", $subject, $body, Mails::EMAIL_SENDER, "r9jason@gmail.com");
        $sendMailService->sendMail("kclim23@yahoo.com", "Boss", $subject, $body, Mails::EMAIL_SENDER, "dcc@maximtrader.com,r9jason@gmail.com,lawrenceng1010@hotmail.com");
    }

    function getAllBonusData() {

        $bonusService = new BonusService();

        $body = "<h3>All Bonus Data</h3><table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
                    <thead>
                    <tr>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Date</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Country Sales</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>DRB</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>GRB</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Generation Bonus</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Pips Rebate</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Fund Management Bonus</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Special Bonus</th>
                    </tr>
                    </thead>
                    <tbody>";

        $dateUtil = new DateUtil();

        for ($i = 0; $i < 3; $i++) {
            $queryDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate(date("Y-m-d"), ($i + 1) * -1, 0, 0));
            $queryDateForGrb = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate(date("Y-m-d"), $i * -1, 0, 0));

            $totalDrb = $bonusService->doCalculateDrb($queryDate);
            $countrySales = $bonusService->doCountrySales($queryDate);
            $totalGrb = $bonusService->doCalculateGrb($queryDateForGrb);
            $totalGenerationBonus = $bonusService->doCalculateGenerationBonus($queryDate);
            $pipsRebate = $bonusService->doCalculatePipsRebateBonus($queryDate);
            $fundManagementBonus = $bonusService->doCalculateFundManagementBonus($queryDate);
            $specialBonus = $bonusService->doCalculateSpecialBonus($queryDate);

            $body .= "<tr class='sf_admin_row_1'>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$queryDate."</td>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$countrySales."</td>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($totalDrb,0)."</td>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($totalGrb,0)."</td>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($totalGenerationBonus,2)."</td>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($pipsRebate,2)."</td>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($fundManagementBonus,2)."</td>
                    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($specialBonus,2)."</td>
                </tr>";
        }

        $body .= "</tbody>
                </table>";

        return $body;
    }

    function getUpcomingPerformanceReturn() {
        $query = "SELECT devidend_id, dist_id, mt4_user_name, idx, account_ledger_id, dividend_date, package_id, package_price, roi_percentage, dividend_amount, remarks, status_code, created_by, created_on, updated_by, updated_on, first_dividend_date
	                FROM mlm_roi_dividend where status_code = '".Globals::DIVIDEND_STATUS_PENDING."'
	                order by dividend_date limit 10";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();

        $body = "<h3>Upcoming 10 Fund Management pending to pay</h3><table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
                    <thead>
                    <tr>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>MT4 ID</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Idx</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Dividend Date</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Package Price</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>ROI Percentage</th>
                    </tr>
                    </thead>
                    <tbody>";
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $body .= "<tr class='sf_admin_row_1'>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['mt4_user_name']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['idx']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['dividend_date']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($arr['package_price'],2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['roi_percentage']."</td>
                    </tr>";
        }

        $body .= "</tbody>
                </table>";

        return $body;
    }

    function getPackageSaleData() {
        $bonusService = new BonusService();
        $dateUtil = new DateUtil();
        $queryDate = $dateUtil->formatDate("Y-m-d", $dateUtil->addDate(date("Y-m-d"), -1, 0, 0));
        $packageArrs = $bonusService->doCalculatePackage($queryDate);

        $body = "<h3>Sales for today</h3><table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
                    <thead>
                    <tr>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Package Name</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Qty</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Price</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>";

        $totalAmount = 0;
        foreach ($packageArrs as $packageArr) {
            if ($packageArr['qty'] > 0) {
                $totalAmount = $totalAmount + ($packageArr["qty"] * $packageArr["price"]);
                $body .= "<tr class='sf_admin_row_1'>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$packageArr['name']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$packageArr['qty']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($packageArr['price'],2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($packageArr["qty"] * $packageArr["price"],2)."</td>
                    </tr>";
            }
        }
        $body .= "<tr class='sf_admin_row_1'>
            <td colspan='3' align='right' style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>Total Amount</td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$totalAmount."</td>
        </tr>";
        $body .= "</tbody>
                </table>";

        return $body;
    }

    function getRollingPointData() {
        $dateUtil = new DateUtil();
        $currentDate = $dateUtil->formatDate("Y-m-d", date("Y-m-d"));

        $lastWeekSun = null;
        for ($i = 0; $i < 7; $i++) {
            $dividendDate = strtotime("-".$i." day", strtotime($currentDate));

            if (date('D', $dividendDate) == "Sun") {
                $lastWeekSun = date("Y-m-d", $dividendDate);
                break;
            }
        }

        //var_dump($lastWeekSun);
        //exit();
        $arrs = $this->fetchRollingPoint($lastWeekSun);

        $body = "<h3>Rolling Point Table</h3><table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
                    <thead>
                    <tr>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'></th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Distributor Code</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Full Name</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Rolling Point</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Rolling Point Available</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Rolling Point Used</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Debit</th>
                        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>".$lastWeekSun." RP Bill</th>
                    </tr>
                    </thead>
                    <tbody>";

        $idx = 1;
        foreach ($arrs as $arr) {
            $debitAccount = $arr['TOTAL_DEBIT'];
            if ($debitAccount == null)
                $debitAccount = 0;
            $rollingPoint = $arr['TOTAL_ROLLING_POINT'] - $debitAccount;
            $rollingPointUsed = $arr['TOTAL_RP_USED'] - $debitAccount;
            $rollingPointAvailable = $arr['TOTAL_ROLLING_POINT'] - $arr['TOTAL_RP_USED'];
            $lastWeekRP = $arr['TOTAL_LAST_WEEK_RP_USED'] - $debitAccount;
            if ($lastWeekRP < 0) {
                $lastWeekRP = 0;
            }

            $body .= "<tr class='sf_admin_row_1'>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$idx++."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['distributor_code']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".$arr['full_name']."<br>".$arr['email']."<br>".$arr['contact']."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPoint,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($rollingPointAvailable,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;font-weight:bold; font-size:15px;'>".number_format($rollingPointUsed,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($debitAccount,2)."</td>
                        <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'>".number_format($lastWeekRP,2)."</td>
                    </tr>";
        }

        $body .= "</tbody>
                </table>";

        return $body;
    }
    function fetchRollingPoint($lastWeekSun) {
        $query = "SELECT transferLedger.dist_id, dist.distributor_code, dist.full_name, dist.email, dist.contact
        , totalRollingPoint.TOTAL_ROLLING_POINT, rpUsed.TOTAL_RP_USED, lastWeekRpUsed.TOTAL_LAST_WEEK_RP_USED
            FROM mlm_distributor dist
        INNER JOIN
        (
            SELECT dist_id FROM mlm_account_ledger where account_type = '" . Globals::ACCOUNT_TYPE_RP . "'
                group by dist_id
        ) transferLedger ON dist.distributor_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(credit) AS TOTAL_ROLLING_POINT, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '".Globals::ACCOUNT_TYPE_RP."' group by dist_id
            ) totalRollingPoint ON totalRollingPoint.dist_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(debit) AS TOTAL_RP_USED, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '".Globals::ACCOUNT_TYPE_RP."' group by dist_id
            ) rpUsed ON rpUsed.dist_id = transferLedger.dist_id
        LEFT JOIN
            (
                SELECT sum(debit) AS TOTAL_LAST_WEEK_RP_USED, dist_id
                    FROM mlm_account_ledger account
                        where account_type = '".Globals::ACCOUNT_TYPE_RP."'";

        if ($lastWeekSun != null) {
            $query .= " AND account.created_on <= '".$lastWeekSun." 23:59:59'";
        }

        $query .= " group by dist_id
            ) lastWeekRpUsed ON lastWeekRpUsed.dist_id = transferLedger.dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;

        //var_dump($query);
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $resultArray[$count] = $arr;
            $resultArray[$count]['TOTAL_DEBIT'] = $this->fetchTotalDebit($arr['dist_id']);

            $count++;
        }
        return $resultArray;
    }

    function fetchMemberWithoutUploadDocument($date) {
        $dateFrom = $date . " 00:00:00";
        $dateTo = $date . " 23:59:59";

        $query = "SELECT distributor_id, distributor_code, full_name, email
	                    FROM mlm_distributor where (file_bank_pass_book is null or file_proof_of_residence is null or file_nric is null)
	                    and email is not null
	                    and active_datetime >= '" . $dateFrom . "' AND created_on <= '" . $dateTo . "'
	                    and status_code = '".Globals::STATUS_ACTIVE."'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $resultArray[$count]["distributor_id"] = $arr["distributor_id"];
            $resultArray[$count]["distributor_code"] = $arr["distributor_code"];
            $resultArray[$count]["full_name"] = $arr["full_name"];
            $resultArray[$count]["email"] = $arr["email"];
            $count++;
        }
        return $resultArray;
    }
    function fetchTotalDebit($distId) {
        $query = "SELECT sum(credit) AS TOTAL_DEBIT, dist_id
                    FROM mlm_account_ledger
                where account_type = '".Globals::ACCOUNT_TYPE_DEBIT."' AND dist_id = '".$distId."' group by dist_id";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();
            $result = $arr["TOTAL_DEBIT"];
        }
        return $result;
    }

    function findFundManagementList($distId) {

        $query = "SELECT DISTINCT dist_id, mt4_user_name
	                FROM mlm_roi_dividend WHERE dist_id = ".$distId;

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $count = 0;
        while ($resultset->next()) {
            $arr = $resultset->getRow();

            $resultArray[$count]["dist_id"] = $arr["dist_id"];
            $resultArray[$count]["mt4_user_name"] = $arr["mt4_user_name"];
            $resultArray[$count]["unrealized_profit"] = $this->getUnrealizedProfit($arr["mt4_user_name"]);
            $resultArray[$count]["realized_rofit"] = $this->getRealizedProfit($arr["mt4_user_name"]);

            $c = new Criteria();
            $c->add(MlmPackageContractPeer::MT4_ID, $arr["mt4_user_name"]);
            $c->add(MlmPackageContractPeer::DIST_ID, $this->getUser()->getAttribute(Globals::SESSION_DISTID, 0));
            $c->add(MlmPackageContractPeer::STATUS_CODE, Globals::STATUS_COMPLETE);
            $mlmPackageContract = MlmPackageContractPeer::doSelectOne($c);

            //var_dump($mlmPackageContract);
            if ($mlmPackageContract) {
                $resultArray[$count]["contract"] = $arr["mt4_user_name"];
            } else {
                $resultArray[$count]["contract"] = "";
            }

            $count++;
        }
        return $resultArray;
    }

    function getRealizedProfit($mt4Username) {

        $query = "SELECT SUM(dividend_amount) AS _SUM FROM mlm_roi_dividend
                WHERE mt4_user_name = '".$mt4Username."' AND status_code = '".Globals::DIVIDEND_STATUS_SUCCESS."'";

        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        $resultset = $statement->executeQuery();
        $resultArray = array();
        $result = 0;
        if ($resultset->next()) {
            $arr = $resultset->getRow();

            $result = $arr["_SUM"];
        }
        return $result;
    }

    function getUnrealizedProfit($mt4Username) {
        $result = 0;

        $c = new Criteria();

        $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $mt4Username);
        $c->add(MlmRoiDividendPeer::IDX, 1);
        $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

        if ($mlmRoiDividendDB) {
            $result = $mlmRoiDividendDB->getPackagePrice() * $mlmRoiDividendDB->getRoiPercentage() / 100 * Globals::DIVIDEND_TIMES_ENTITLEMENT;
        }

        return $result;
    }

    function checkIsDebitedAccount($distId, $convertRpToCp1, $convertCp3ToCp1, $cp3Withdrawal, $convertCp2ToCp1, $ecashWithdrawal, $transferCp1, $transferCp2, $transferCp3) {
        $c = new Criteria();

        $c->add(MlmDebitAccountPeer::DIST_ID, $distId);
        if ($convertRpToCp1 != null) {
            $c->add(MlmDebitAccountPeer::CONVERT_RP_TO_CP1, $convertRpToCp1);
        }
        if ($convertCp3ToCp1 != null) {
            $c->add(MlmDebitAccountPeer::CONVERT_CP3_TO_CP1, $convertCp3ToCp1);
        }
        if ($convertCp2ToCp1 != null) {
            $c->add(MlmDebitAccountPeer::CONVERT_CP2_TO_CP1, $convertCp2ToCp1);
        }
        if ($ecashWithdrawal != null) {
            $c->add(MlmDebitAccountPeer::ECASH_WITHDRAWAL, $ecashWithdrawal);
        }
        if ($cp3Withdrawal != null) {
            $c->add(MlmDebitAccountPeer::CP3_WITHDRAWAL, $cp3Withdrawal);
        }
        if ($transferCp1 != null) {
            $c->add(MlmDebitAccountPeer::TRANSFER_CP1, $transferCp1);
        }
        if ($transferCp2 != null) {
            $c->add(MlmDebitAccountPeer::TRANSFER_CP2, $transferCp2);
        }
        if ($transferCp3 != null) {
            $c->add(MlmDebitAccountPeer::TRANSFER_CP3, $transferCp3);
        }
        $debitAccountDB = MlmDebitAccountPeer::doSelectOne($c);

        if ($debitAccountDB) {
            return true;
        }
        return false;
    }

    function getNextPerformanceDate($distId) {
        $c = new Criteria();

        $c->add(MlmRoiDividendPeer::DIST_ID, $distId);
        $c->add(MlmRoiDividendPeer::STATUS_CODE, Globals::DIVIDEND_STATUS_PENDING);
        $c->addAscendingOrderByColumn(MlmRoiDividendPeer::DIVIDEND_DATE);
        $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

        if ($mlmRoiDividendDB) {
            $dateUtil = new DateUtil();
            return $dateUtil->formatDate("Y-M-d", $mlmRoiDividendDB->getDividendDate());
        }
        return "";
    }
}