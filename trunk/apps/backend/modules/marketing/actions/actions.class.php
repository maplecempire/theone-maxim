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

    public function executeLuckyDraw()
    {
        $doAction = "EVENT";
        $screenLebel = "Send Lucky Draw - Event";
        if ($this->getRequestParameter('doAction','EVENT') != "EVENT") {
            $doAction = "WOF";
            $screenLebel = "Send Lucky Draw - Wheel of Fortune Million Dollar";
        }

        $this->doAction = $doAction;
        $this->screenLebel = $screenLebel;
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜资本有限公司是皇家控股集团Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子企业。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜资本有限公司是皇家控股集团Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子企业。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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

            $mlmCustomerEnquiry->save();

            $enquiryId = $mlmCustomerEnquiry->getEnquiryId();
        } else {
            $mlmCustomerEnquiry = MlmCustomerEnquiryPeer::retrieveByPK($enquiryId);
            $mlmCustomerEnquiry->setAdminUpdated(Globals::TRUE);
            $mlmCustomerEnquiry->setDistributorUpdated(Globals::FALSE);
            $mlmCustomerEnquiry->setDistributorRead(Globals::FALSE);
            $mlmCustomerEnquiry->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));

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
                        $mlm_pip_csv->setYearTraded($tradingYear);
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
                    $c->setLimit(5000);
                    $mlmPipsCsvDBs = MlmPipCsvPeer::doSelect($c);
                    $totalCount = count($mlmPipsCsvDBs);
                    //$c = new Criteria();
                    //$c->addDescendingOrderByColumn(MlmFundManagementRecordPeer::CREATED_ON);
                    //$mlmFundManagementRecord = MlmFundManagementRecordPeer::doSelectOne($c);

                    $fundManagementPercentage = 0;
                    //if ($mlmFundManagementRecord) {
                    //    $fundManagementPercentage = $mlmFundManagementRecord->getPercentage();
                    //}

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
                        if ($mlm_dist_mt4) {
                            $index = 0;
                            if ($mlm_dist_mt4->getDistId() < 0)
                                continue;
                            //var_dump($mlm_dist_mt4->getDistId());
                            //var_dump("<br>");
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

                                                        $distAccountEcashBalance = $this->getAccountBalance($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);

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
                                                        $this->revalidateAccount($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);
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

                                                        $distAccountEcashBalance = $this->getAccountBalance($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);

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
                                                        $this->revalidateAccount($affectedDistributor->getDistributorId(), Globals::ACCOUNT_TYPE_ECASH);
                                                    }
                                                }
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
                    if ($totalCount <= 0) {
                        $mlmFileDownloadDB->setStatusCode(Globals::STATUS_COMPLETE);
                        $mlmFileDownloadDB->save();
                    }

                    $con->commit();
                } catch (PropelException $e) {
                    $con->rollback();
                    throw $e;
                }
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

        $editFullname = $this->getRequestParameter('editFullName');

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

        $tbl_user->setUserpassword($this->getRequestParameter('password'));
        $tbl_user->setUserpassword2($this->getRequestParameter('password2'));
        $tbl_user->setStatusCode($this->getRequestParameter('status'));

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

                    $mlm_roi_dividend = new MlmRoiDividend();
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
                    $mlmPackageContract->setStatusCode(Globals::STATUS_ACTIVE);
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
            $uplineDistCommissionDB->setUpdatedBy($this->getUser()->getAttribute(Globals::SESSION_USERID, Globals::SYSTEM_USER_ID));
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
									<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜资本有限公司是皇家控股集团Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子企业。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
									<br><br>Maxim Capital Limited is a subsidiary of Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.) a public listed company in USA.
									<br><br>CONFIDENTIALITY: This e-mail and any files transmitted with it are confidential and intended solely for the use of the recipient(s) only. Any review, retransmission, dissemination or other use of, or taking any action in reliance upon this information by persons or entities other than the intended recipient(s) is prohibited. If you have received this e-mail in error please notify the sender immediately and destroy the material whether stored on a computer or otherwise.
									<br><br>DISCLAIMER: Any views or opinions presented within this e-mail are solely those of the author and do not necessarily represent those of Maxim capital Limited, unless otherwise specifically stated. The content of this message does not constitute Investment Advice.
									<br><br>RISK WARNING: Forex, spread bets, and CFDs carry a high degree of risk to your capital and it is possible to lose more than your initial investment. Only speculate with money you can afford to lose. As with any trading, you should not engage in it unless you understand the nature of the transaction you are entering into and, the true extent of your exposure to the risk of loss. These products may not be suitable for all investors, therefore if you do not fully understand the risks involved, please seek independent advice.
																		<br><br>
马胜金融集团公司于新西兰总部地址为:新西兰奥克兰奥克兰市中心1010号思科迪亚广场10/12号8楼11套房
<br>电话(国际): (+64) 9925 0379 电话(新西兰): 09 925 0379
<br>邮箱： support@maximtrader.com
<br><br>马胜资本有限公司是皇家控股集团Royale Globe Holding Inc. (Formerly known as Royale Group Holding Inc.)旗下的子企业。 该母公司是一家已在美国公开上市，拥有卓越信誉的金融和投资机构。
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
}