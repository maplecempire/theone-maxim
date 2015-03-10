-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2015 at 02:17 PM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `maxim`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_news`
--

CREATE TABLE IF NOT EXISTS `app_news` (
`id` bigint(20) NOT NULL,
  `ns_title` varchar(500) NOT NULL,
  `ns_content` longtext NOT NULL,
  `ns_status` varchar(50) NOT NULL,
  `ns_start_date` datetime NOT NULL,
  `ns_end_date` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `app_news`
--

INSERT INTO `app_news` (`id`, `ns_title`, `ns_content`, `ns_status`, `ns_start_date`, `ns_end_date`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'iAccount Notice<br>iAccount通告<br>iAccount 고지', '<br>Dear Members, <br>亲爱的会员: <br> <br>Further to our announcement on monthly withdrawals via iAccount to be made compulsory, please note with effect from January 2015, every member is required to open an iAccount and update it in their user profile, otherwise your January withdrawal will be rejected until you have opened your iAccount. In order to enable you to open the iAccount, January 2015 withdrawal period will be extended till 20 January 2015. Those of you who haven''t opened your iAccount yet, please do so immediately. <br>鉴于此前发布的会员通过iAccount取现的政策, 请注意从2015年1月份开始, 所有会员需开通iAccount账户,并于会员区个人资料处更新：若然,本月的取现请求将会被系统拒绝. 为了给大家更多时间开通iAccount, 本月(2015.1月)的取现申请接收时间将会延迟至2015.1.20日.请所有会员尽快开通iAccount账户. <br> <br>Please note members in China, Thailand and Indonesia may do withdrawal request via local bank account or iAccount. <br>另外, 中国大陆, 泰国以及印度尼西亚的会员可以自由选择通过iAccount或者本地银行取现. <br> <br>Your prompt action and kind understanding of the matter is highly appreciated in order to enable us to serve you better. <br>敬请留意,谢谢大家的配合!我们一直努力,更好地服务所有会员! <br> <br>Thank you. 谢谢! <br>CEO 首席执行官 <br> <br>친애하는 회원 여러분, <br> <br>매월 인출시 i어카운트로 인출하는 것이 의무사항이 됨에 따라, 2015년 1월부로 모든 회원들은   i어카운트 계좌를 개설하고 유저 프로필을 업데이트 하여야만 합니다. 만약 이를 실시하지 않을 경우, 귀하의 1월 인출은  i어카운트 계좌 개설시 까지 불가능합니다.  i어카운트 계좌를 개설 하실 수 있도록 2015 1월 인출 기간을 2015년 1월 20일까지 연장할 것입니다.   아직 i어카운트 계좌를 개설하지 않으신 회원분들은 즉시 개설하시기 바랍니다. <br> <br>중국, 태국, 인도네시아 회원분들은 현지 은행 계좌 또는 i어카운트 계좌에서 인출하실 수 있습니다. <br> <br>귀하의 빠른 계좌 개설과 본 사항에 대한 이해에 감사드리며 더 나은 서비스를 드릴 수 있도록 최선을 다하겠습니다. <br> <br>감사합니다. <br>CEO', 'ACTIVE', '2015-01-05 00:00:00', '2016-01-01 00:00:00', 0, '2015-01-05 00:00:00', 1, '2015-03-07 20:28:27'),
(2, 'e-wallet Notice\r\n<br>e-wallet 通告\r\n<br>e-wallet 고지\r\n<br>e-wallet のお知らせ', '<br>Dear IMs &amp; Partners,\r\n<br>亲爱的代理及伙伴们:\r\n<br>\r\n<br>Effective 1st Jan 2015, all transactions in your e-wallet which are more than 3 months old will be archived. You will be able to view current and immediate past 3 months transactions.\r\n<br>从2015.1.1日生效-会员专区内超过3个月之久的金融钱包声明将会被存档. 会员只能看见最近3个月之内的交易明细.\r\n<br>\r\n<br>Anyone requiring archived statements, please write to <a href="mailto:support@maximtrader.com">support@maximtrader.com</a>.\r\n<br>如果需要查看3个月之前的明细, 请邮件至 <a href="mailto:support@maximtrader.com">support@maximtrader.com</a> 申请.\r\n<br>\r\n<br>There will be a nominal charge of 10 CPs per month, for requests processed. Please give 3 working days for processing.\r\n<br>针对此类申请,系统将收取10CP点数/每月(明细). 处理时间为三个工作日.\r\n<br>\r\n<br>Thank you.\r\n<br>谢谢配合!\r\n<br>\r\n<br>CEO 首席执行官\r\n<br>\r\n<br>친애하는 맥심 회원 및 파트너 여러분,\r\n<br>\r\n<br>2015년 1월 1일부로, 3개월 이상된  e-월렛에서 이루어지는 모든 거래는 기록으로 남겨질 것입니다. 현재 상태를 보실 수 있으면 지난 3개월 동안의 거래 내역도 확인하실 수 있습니다.\r\n<br>\r\n<br>거래 내역서를 원하신다면, <a href="mailto:support@maximtrader.com">support@maximtrader.com</a> 으로 메일 보내주시기 바랍니다.\r\n<br>\r\n<br>신청을 진행함에 있어서 매달 10 CPs의 수수료가 발생하며 근무일 3일의 시간이 소요됩니다.\r\n<br>\r\n<br>감사합니다.\r\n<br>CEO\r\n<br>\r\n<br>親愛なるIMおよびパートナーの皆様\r\n<br>\r\n<br>2015年1月1日より、お客様のe-walletにおける三ヶ月以上前のすべての取引はアーカイブされます。ご覧いただけるのは、現在および三ヶ月以内のお取引となります。\r\n<br>\r\n<br>\r\n<br>アーカイブをご覧になりたい方は、どうぞCSセンターまでご連絡ください。一度リクエストが処理されますと10CPのわずかな手数料が毎月発生します。処理には3営業日いただきます。\r\n<br>\r\n<br>ありがとうございます。\r\n<br>CEO', 'ACTIVE', '2015-01-06 00:00:00', '2016-01-01 00:00:00', 0, '2015-01-06 00:00:00', 1, '2015-03-07 20:28:27'),
(3, 'Market Holidays Notice\r\n<br>市场假期通告', '<br>Please take note of the upcoming market holiday(s) below.\r\n<br>\r\n<br>19 Jan 2015 - US, Dr. Martin Luther King, Jr. Day\r\n<br>\r\n<br>While FX and Precious Metals trading hours remain the same, a lack of liquidity may lead to wider spreads; please plan your trades accordingly.\r\n<br>\r\n<br>For Precious Metals, due to the closure of futures markets during the period as stated below, liquidity may be especially thin and there may be no bid/offers at times:\r\n<br>20 Jan 2015 0200hrs (SGT/HKT) - 20 Jan 2015 0700hrs (SGT/HKT).\r\n<br>\r\n<br>*******************************************************************************\r\n<br>\r\n<br>尊敬的客户，\r\n<br>\r\n<br>以下是即将来临的市场假期 。\r\n<br>\r\n<br>19 Jan 2015 - US Dr. Martin Luther King, Jr. Day\r\n<br>\r\n<br>当日外汇与贵金属照常交易，但潜在市场流通性不足的情况，有可能导致点差扩大，请相应地计划您的交易。\r\n<br>\r\n<br>至于贵金属，尤其是在以下时段，ＣＭＥ黄金与白银期货交易停止，比较少银行会报价：\r\n<br>20 Jan 2015 0200hrs (SGT/HKT) - 20 Jan 2015 0700hrs (SGT/HKT).', 'ACTIVE', '2015-01-13 00:00:00', '2016-01-01 00:00:00', 0, '2015-01-13 00:00:00', 1, '2015-03-07 20:28:27'),
(4, 'iAccount Notice\r\n<br>iAccount 通告\r\n<br>iAccount 고지\r\n<br>iAccount お知らせ', '<br>Dear Members,\r\n<br>亲爱的会员,\r\n<br>\r\n<br>Please take note that iAccount website is under maintenance, as such online iAccount new applications cannot be processed now. The website is expected to be back to normal by tomorrow morning. Very sorry for the inconvenience caused.\r\n<br>请注意, 目前iAccount网站正在维护当中, 因此新iAccount申请将暂停处理;预计iAccount网站明天早晨会恢复正常. 为此造成的不便,我们表示非常抱歉.\r\n<br>\r\n<br>Thank you. 谢谢!\r\n<br>\r\n<br>Revi Pillai CFO 首席财务官\r\n<br>\r\n<br>친애하는 회원 여러분,\r\n<br>\r\n<br>i어카운트 웹사이트가 유지보수 중이므로 현재 새로운 신청이 진행되지 않고 있습니다. 내일 아침에 정상진행이 될 예정입니다. 불편을 끼쳐  대단히 죄송합니다.\r\n<br>\r\n<br>감사합니다.\r\n<br>\r\n<br>레비 필라이 CFO\r\n<br>\r\n<br>メンバーのみなさま\r\n<br>\r\n<br>どうぞiAccountのウエブサイトが現在メンテナンス中であることにご注意ください。そのためiAccountの新しいアプリケーションは現在お使いいただけません。ウエブサイトは明日の朝には通常通りお使いいただける見込みです。ご不便をおかけして大変申し訳ございません。\r\n<br>\r\n<br>ありがとうございます。\r\n<br>\r\n<br>Revi Pillai CFO', 'ACTIVE', '2015-01-13 00:00:00', '2016-01-01 00:00:00', 0, '2015-01-13 00:00:00', 1, '2015-03-07 20:28:27'),
(5, 'Maxim Annual Convention Notice', '<br>Dear IMs and Partners\r\n<br>亲爱的代理及伙伴们:\r\n<br>\r\n<br>CONGRATULATIONS .... We have COMPLETELY SOLD OUT our Maxim Annual Convention to be held in Marina Bay Sands on March 22nd 2015.\r\n<br>热烈恭喜!我们将于2015.3.22日在新加坡金沙湾酒店盛大开幕的年会门票正式售罄!!\r\n<br>\r\n<br>ALL PROMOs FOR THIS EVENT WILL EFFECTIVELY END AS OF 2359 Hours (GMT+8) December 31st, 2014.\r\n<br>所有有关此次年会的优惠促销活动于2014.12.31日23:59分(GMT+8)正式结束!\r\n<br>\r\n<br>See you in Singapore !!!!!\r\n<br>与您相约在新加坡!!!!!\r\n<br>\r\n<br>친애하는 국제회원 및 파트너 여러분,\r\n<br>\r\n<br>축하합니다 .... 2015년 3월 22일 마리나 베이 샌드에서 열릴 맥심 애뉴얼 컨벤션 티켓이 완판되었습니다.\r\n<br>\r\n<br>이 행사 관련 모든 프로모션은 2014년 12월 31일 오전 9시 (GMT+8)에 마감됩니다.\r\n<br>\r\n<br>싱가폴에서 뵙기를 기원합니다!!!!!', 'ACTIVE', '2015-01-23 00:00:00', '2016-01-01 00:00:00', 0, '2015-01-23 00:00:00', 1, '2015-03-07 20:28:27'),
(6, 'iAccount Notice\r\n<br>iAccount 通告\r\n<br>iAccount 고지\r\n<br>iAccount お知らせ', '<br>Dear Members,\r\n<br>亲爱的会员,\r\n<br>\r\n<br>Pls note withdrawal process for February 2015 will be as follows:\r\n<br>请注意2015年2月份取现安排将会如下:\r\n<br>\r\n<br>1. Withdrawal period: 1 to 7 February only.\r\n<br>取现申请时间: 2月1号-7号\r\n<br>\r\n<br>2. Members who have iAccount will be able to select iAccount option only.\r\n<br>拥有iAccount账户的会员,将只能通过iAccount进行取现.\r\n<br>\r\n<br>3. For members without iAccount, the system will automatically allow them only to select local bank transfer.\r\n<br>尚未开通iAccount账户的会员, 系统将自动只允许其通过本地银行进行转账.\r\n<br>\r\n<br>4. Pls note after February, withdrawal option will be available only via iAccount, as such please apply for your iAccount immediately.\r\n<br>请注意, 从2月份开始以后的月份, 取现只可以通过iAccount进行. 所以请尽快申请iAccount账户.\r\n<br>\r\n<br>5. The above does not apply to members in China, Indonesia and Thailand whose present withdrawal system will remain unchanged.\r\n<br>以上变更不适用于来自中国、泰国以及印度尼西亚的会员; 以上三个国家的本地银行取现政策保持不变.\r\n<br>\r\n<br>Thank you, 谢谢\r\n<br>\r\n<br>CFO 首席财务官\r\n<br>Maxim Trader 马胜金融\r\n<br>\r\n<br>친애하는 회원여러분\r\n<br>\r\n<br>2015년 2월 인출이 아래와 같이 진행될 것입니다.\r\n<br>\r\n<br>1. 인출기간 : 2월 1일에서 7일 까지 한정\r\n<br>2. I-어카트를 가진 회원은 I어카운트 옵션만 선택할 수 있습니다.\r\n<br>3. I어카운트를 가지고 있지 않은 회원은 시스템이 자동적으로 현지 은행만 선택할 수 있도록 합니다.\r\n<br>4. 2월 이후부터 인출 옵션은 i어카운트만 가능할 것이므로 i어카운트를 즉시 신청하시기 바랍니다.\r\n<br>5. The above does not apply to members in China, Indonesia and Thailand whose present withdrawal system will remain unchanged.\r\n<br>\r\n<br>감사합니다.\r\n<br>CFO\r\n<br>\r\n<br>メンバーの皆さま\r\n<br>\r\n<br>2015年2月の引き出し手順は以下の通りになりますのでお知らせします。\r\n<br>\r\n<br>1..引き出し期間:2月1日から7日のみとなります。\r\n<br>2. iAccountをお持ちのお客様はiAccountオプションのみを選択いただけます。\r\n<br>3.iAccountをお持ちでないお客様はシステムにより自動的に地域の銀行送金を選択することになります。\r\n<br>4. どうぞ2月以降、引き出しオプションはiAccountを通してのみ可能になりますことをご注意ください。そのため、どうぞiAccountに至急お申し込みください。\r\n<br>5. The above does not apply to members in China, Indonesia and Thailand whose present withdrawal system will remain unchanged.\r\n<br>\r\n<br>ありがとうございます。\r\n<br>CFO\r\n<br>マキシムトレーダー', 'ACTIVE', '2015-02-01 00:00:00', '2016-01-01 00:00:00', 0, '2015-02-01 00:00:00', 1, '2015-03-07 20:28:27'),
(7, 'Forex Markets Notice', '<br>Dear Members,\r\n<br>\r\n<br>Please take note of the upcoming market holiday(s) below.\r\n<br>\r\n<br>17 Feb 2015 - US, Presidents'' Day\r\n<br>\r\n<br>The Forex markets will be open throughout this period but liquidity is expected to be lower than normal. The Gold and Silver Markets will be closed at 2.00am - 7.00am SGT/HKT\r\n<br>\r\n<br>Kindly plan your trades accordingly.', 'ACTIVE', '2015-02-11 00:00:00', '2016-01-01 00:00:00', 0, '2015-02-11 00:00:00', 1, '2015-03-07 20:28:27'),
(8, 'Chinese New Year Notice', '<br>Dear Members,\r\n<br>亲爱的会员,\r\n<br>\r\n<br>Please note our Customer Service Division will be closed from 18 to 24 February in conjunction with Chinese New Year celebrations. If you need any urgent assistance during this period, please contact your Leaders or alternatively you may continue to email support@maximtrader.com and we will reply you soonest possible. Thank you for your understanding and co-operation.\r\n<br>请注意: 因为中国春节即将到来,公司的客户服务中心将从2.18日-2.24日暂停服务. 如果在此期间您有紧急事情需要公司的处理, 请发送邮件至support@maximtrader.com, 我们会尽快回复您.谢谢您的谅解与合作!\r\n<br>\r\n<br>We wish All Members and their Families, A Very Happy and Prosperous New Year !\r\n<br>祝愿您及您的家人新春快乐、笑口常开、万事如意!\r\n<br>\r\n<br>CEO\r\n<br>Maxim Trader\r\n<br>马胜金融集团首席执行官\r\n<br>\r\n<br>친애하는 회원 여러분,\r\n<br>\r\n<br>설날을 기하여 2월 18일부터 24일까지 당사 고객서비스부서가 근무를 하지 않습니다. 만약 이 기간동안 급한 도움이 필요하시면, 귀하의 리더에게 연락하시거나 support@maximtrader.com으로 메일을 보내주시기 바랍니다.  가능한 한 빠른 시일내에 답변을 드리도록 하겠습니다.  이해와 협조에 감사드립니다.\r\n<br>\r\n<br>모든 회원분들과 그 가족 분들 모두 새해 복 많이 받으시기 바랍니다.\r\n<br>\r\n<br>CEO\r\n<br>맥심 트레이더\r\n<br>\r\n<br>メンバーの皆様\r\n<br>\r\n<br>弊社カスタマーサービス部は、２月18日〜24日の間中国の旧正月のお祝いのため閉鎖となりますのでご注意ください。もし何かしらの緊急のご用事がこの期間にある場合、あなたのリーダー、または別の方法として\r\n<br>support@maximtrader.com にメールしてくだされば、できるだけ早めにお返事いたします。ご理解とご協力に感謝します。\r\n<br>\r\n<br>すべてのメンバーおよびご家族の皆様に、新年のご挨拶を申し上げるとともに、繁栄した１年になるよう、お祈りいたします。\r\n<br>\r\n<br>CEO\r\n<br>マキシムトレーダー', 'ACTIVE', '2015-02-12 00:00:00', '2016-01-01 00:00:00', 0, '2015-02-12 00:00:00', 1, '2015-03-07 20:28:27'),
(9, 'iAccount Notice\r\n<br>iAccount 通告\r\n<br>iAccount 고지\r\n<br>iAccount お知らせ', '<br>Dear Members,\r\n<br>亲爱的会员,\r\n<br>\r\n<br>Your February 2015 withdrawals have been processed by Maxim. We have been informed by iAccount that the crediting into individual iAccounts are going on progressively but some delays are expected due to the festive season which is hindered by manpower shortages as result of Chinese New Year celebrations.\r\n<br>针对本月(2015.2月)的取现, 都已经在处理当中. 有关iAccount的取现, 公司得到通知已经在稳序进行当中; 因为中国假期的到来, 部分iAccount员工已经休假, 因此可能会因人手问题而出现稍许延误.\r\n<br>\r\n<br>iAccount has assured us that they will complete the crediting soonest possible.\r\n<br>请放心, iAccount已经在快马加鞭, 承诺会以最快的速度处理所有客户的转款.\r\n<br>\r\n<br>Your kind understanding and patience is much appreciated over this isolated delay.\r\n<br>为此造成的延误,我们表示十分的抱歉; 也万分感谢您的谅解与理解!\r\n<br>\r\n<br>Thank you 非常感谢!\r\n<br>CFO\r\n<br>Maxim Trader\r\n<br>马胜金融首席财务官\r\n<br>\r\n<br>친애하는 회원  여러분\r\n<br>\r\n<br>맥심 2015년 2월 인출이 진행되었습니다.  i어카운트에서 설날을 기하여 많은 직원들의 휴가로 인한 인력 부족으로 개인의 계좌로의 진행이 조금 늦어질 수 있다는 연락을 받았습니다.\r\n<br>\r\n<br>i어카운트는 가능한한 가장 빠른 시간에 작업을 완수할 것을 약속했습니다.\r\n<br>\r\n<br>여러분의 이해와 인내에 깊은 감사드립니다.\r\n<br>\r\n<br>감사합니다.\r\n<br>CFO\r\n<br>맥심 트레이더\r\n<br>\r\n<br>メンバーの皆様\r\n<br>\r\n<br>皆様の2015年２月の引き出しは現在マキシムによって処理中です。弊社はiAccountより、個人のお客様へのへのiAccountsへの入金作業は現在進行中ながら、中国正月による人出不足が見込まれるため、若干の遅れが予測されるとの知らせを受けています。\r\n<br>iAccountは可能な限り早急に入金を完了させると私たちに確約しています。\r\n<br>この遅れに対して、皆様のご理解およびご協力をいただければ幸いです。\r\n<br>\r\n<br>ありがとうございます。\r\n<br>CFO', 'ACTIVE', '2015-02-14 00:00:00', '2016-01-01 00:00:00', 0, '2015-02-14 00:00:00', 1, '2015-03-07 20:28:27'),
(10, 'US Daylight Changing Notice', '<br>Dear Members,\r\n<br>\r\n<br>Please note the US daylight changing will starts on Sunday 8/3/2015, 2am. The MT4 day end time will be adjusted to 5am. Metal trading session starts on 6am on Monday.', 'ACTIVE', '2015-03-05 00:00:00', '2016-01-01 00:00:00', 0, '2015-03-05 00:00:00', 1, '2015-03-07 20:28:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_news`
--
ALTER TABLE `app_news`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_news`
--
ALTER TABLE `app_news`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
