<?php
include('scripts.php');
$culture = $sf_user->getCulture();
?>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td><br></td>
</tr>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Super Share Swap - SSS Note') ?> - 11 May 2015</span></td>
</tr>
<tr>
    <td><br>
        <?php if ($sf_flash->has('successMsg')): ?>
            <div class="ui-widget">
                <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                     class="ui-state-highlight ui-corner-all">
                    <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                  class="ui-icon ui-icon-info"></span>
                        <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                </div>
            </div>
            <?php endif; ?>
        <?php if ($sf_flash->has('errorMsg')): ?>
            <div class="ui-widget">
                <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                     class="ui-state-error ui-corner-all">
                    <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                  class="ui-icon ui-icon-alert"></span>
                        <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                </div>
            </div>
            <?php endif; ?>

    </td>
</tr>
<tr>
    <td>
        <table cellpadding="3" cellspacing="5">
            <tbody>

            <tr>
                <td><br></td>
            </tr>

            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td align="center">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title"><?php echo __('股票转换规则公告') ?></span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title"><?php echo __('전환 공지') ?></span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">スーパー株式スワップに関するルール</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title"><?php echo __('THE RULES ON SUPER SHARE SWAP') ?></span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title"><?php echo __('1. 马胜会员股票转换选择') ?></span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title"><?php echo __('1. 맥심 트레이더  회원에게 제안하는 주식전환 기회') ?></span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title"><?php echo __('1. マキシムトレーダー会員へ提供可能なスワップ') ?></span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title"><?php echo __('1. Share swap available to Maxim members') ?></span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        基于市场的强烈要求, 已于马胜金融集团投资长达12个月或以上的投资会可以拥有以下转换选择; 该转换选择也向1个月投资周期即将结束的会员开放:
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        회원들의 요청에 의해, 맥심 투자 패키지에 최소 12개월 예치 완료한 맥심 트레이더 회원을 대상으로 다음과 같은 옵션을 제안할 것입니다. 이번 제안은 또한 곧 1개월 만료가 되는 회원에게도 열려 있습니다.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        市場の強い願望より、以下が最低12ヶ月以上投資したマキシムのメンバーにオープンになる。マキシムトレーダー（以下会社と略す）は12ヶ月あるいはそれ以上、マキシム投資パッケージに投資した会員へ以下のオプションを提供する。これはまた1ヶ月投資の満期に達する会員にも提供する。
                    <?php
                    } else {
                    ?>
                        As a result of popular requests from members, the following is open to Maxim members who have completed a <u>minimum of 1 months</u> under the Maxim Investment Package which is also open to members who are going to reach 18 months maturity soon:
                    <?php
                    }
                    ?>
                    <ol style="padding-left: 20px;">
                        <?php if ($culture == "cn") { ?>
                        <li>您可以选择将投资本金以及尚未实现的投资分红利润(CP3)以<?php echo Globals::SHARE_VALUE ?>美金一股的价格转换成ROGP股票。该转换期限仅限于2015.5.12日至6.30日</li>
                        <li>一旦您决定将您的马胜投资转换成R股, 您仍然可以继续发展您的马胜事业, 享受系统的奖金制度，即直接推荐奖和组织奖。在您合同原到期日之外, 公司特额外再赠送18个月的账户有效时间</li>
                        <li>如果您选择了将投资转换成R股, 您的直接推荐人将会于马胜系统内再获得一次组织奖金
                            <ol>
                                <li>如果您的投资合同已达12个月或以上，那么您的推荐人将会以您的投资本金加剩余月投资分红总额为销售业绩，再享受一次组织奖金。</li>
                                <li>如果您的投资合同尚未达12个月，那么您的推荐人将会（只）以您的投资本金为销售业绩，再享受一次组织奖金。</li>
                            </ol>
                        </li>
                        <li>如果您尚未激活AGL账户，当您选择转换时，系统会自动将等额的S4股票数额放置于您的S4账户; 您可以使用同一账户ID及密码登陆AGL系统。如果您希望开展AGL事业，您也是需要有自己的账户的</li>
                        <?php } else if ($culture == "kr") { ?>
                        <li>귀하는 현재 만료일까지의 수당지급 (CP3)을 더한 투자금을 ROGP (R-Share)로 전환할 수 있으며, 가격은 USD80센트입니다. 본 제안은 2015년 5월 12일부터 6월 30일까지만 가능합니다</li>
                        <li>귀하의 맥심 투자금을 R-주식으로 전환을 결정하시면, 맥심 비즈니스를  계속하게 되어, 직접 소개 수당 및 개발 수당과 같은 맥심의 소개 보너스를 예전과 같이 받을 수 있는 자격은 유지됩니다. 귀하는 다가오는 계약 만료일부터 18개월 동안 더 이러한 혜택을 받을 수 있습니다</li>
                        <li>R-주식으로 전환하면, 귀하의 업라인은 한차례 맥심 개발 수당 혜택을 받을 수 있습니다
                            <ol>
                                <li>만약 귀하의 계약이 12개월 또는 그 이상을 완료한 상태라면, 귀하의 어퍼 멤버는 귀하의 원금과 받지 못한 투자 이윤에 대한 개발 보너스를 받으실 수 있습니다.</li>
                                <li>만약 귀하의 계약이 12개월 미만을 완료한 상태라면, 귀하의 어퍼 멤버는 귀하의 원금에 대한 개발 보너스를 받으실 수 있습니다.</li>
                            </ol>
                        </li>
                        <li>AGL 계좌를 가지고 있지 않으면, 주식 스왑시, 귀하의 R-주식은 자동으로 AGL S4 지갑으로 이전되고, 귀하는 현재의 ID와 패스워드로 여기에 접근할 수 있습니다. 그럼에도 불구하고 AGL 사업진행을 원하시면 , AGL 계좌를 오픈해야 합니다</li>
                        <?php } else if ($culture == "jp") { ?>
                        <li>会員様は投資元本および投資周期残りの月間配当（CP3）を<?php echo Globals::SHARE_VALUE ?>ドル/株の株価でROGP株に転換することが可能である。申請期間は2015年5月12日から2015年6月30日まで</li>
                        <li>マキシムトレーダーへの投資をROGP株へ転換することを決めたあとで、マキシムトレーダーへの投資をビジネスとして継続することが可能で、今までの直接紹介ボーナスや組織発展ボーナスが発生します。18ヶ月の投資契約満了した後、会社はさらに18ヶ月間の口座有効期間を提供します</li>
                        <li>ROGP株への転換を選択した場合、あなたの上位のメンバーベースはマキシムトレーダーのシステム内で、もう一度組織発展ボーナスが発生します
                            <ol>
                                <li>会員様の投資は12ヶ月以上となった場合、その元本および残りの月間配当の合計がアップラインの業績として蓄積される</li>
                                <li>会員様の投資は12ヶ月未満の場合、その元本のみがアップラインの業績として蓄積される。</li>
                            </ol>
                        </li>
                        <li>あなたはAGL口座をアクティブしてない場合、システムが自動的に同額の株をAGL口座のS4に移管する。それによって、マキシムトレーダーと同じIDとパスワードでAGLに登録できます。AGLをビジネスとして展開したい場合、有効な口座が必要である</li>
                        <?php } else { ?>
                        <li>You may convert your investment, capital plus the remaining unearned Performance Returns (CP3) till the maturity date, into ROGP shares (R-Shares) at promotional price of USD80 cents. Please note this is open only during the period from 12 May to 30 June 2015.</li>
                        <li>Once you decide to swap your Maxim investment to R-Shares, you may continue to promote Maxim business and you will still be entitled to earn the bonuses in the usual manner as offered by our referral programs in Maxim ie. Direct Referral Bonus and Development Bonus. You will enjoy this benefit for a further 18 months from your upcoming date of 18 months maturity. </li>
                        <li>Upon conversion to R-Share, your higher member base will be able to enjoy a one time development bonus in Maxim.
                            <ol>
                                <li>If your contract has completed 12 months or more, your upper member will be able to earn development bonus on your principal sum plus the remaining unearned return on investment.</li>
                                <li>If your contract has completed less than 12 months your upper member will be able to earn development bonus on your principal sum only.</li>
                            </ol>
                        </li>
                        <li>If you do not already have your AGL account, when you elect to share swap, your R-shares will be automatically credited into an AGL S4 wallet and you may access them with your existing Maxim user ID and password. However if you wish to do AGL business, you will have to open your own AGL account.</li>
                        <?php } ?>

                    </ol>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">2. 针对已经续约投资合同的会员</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">2. 계약을 최근 갱신한 회원</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">2. マキシムトレーダーで再投資した場合</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">2. Members who have just renewed their contract</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        已经续约第二个18各月投资合同的客户必须在第二个合同也已达到12个月的情况下才符合转换条件
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        최근18개월 연장을 갱신한 회원은 주식전환 자격 취득을 위해 최소 12개월을 기다려야 합니다
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        一回目の投資契約が満了し、再投資した会員様は同様に第二回目の投資契約が12ヶ月に達することが、株転換の条件とする
                    <?php
                    } else {
                    ?>
                        Members who have just renewed their contract for another 18 months will have to wait for a minimum of 12 months before they can qualify for the share swap plan.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">3. 投资合同到期时的其他选择</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">3. 만료일에 대한 다른 옵션</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">3. 投資契約期間満了時の選択肢</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">3. Other options upon reaching maturity</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        如果您不愿意选择R股转换计划，那么当您合同投资到期不续约时，您不能继续享受推荐奖金以及组织奖金。因此，我们建议您合同到期时，在网站提示处选择“续约”选项，以便您在再次享受每月投资分红的同时，可以继续享受系统的奖金制度。
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        만약 만기일 도래시 위의 R-주식 전환을 원치 않으면,  맥심 소개 및 투자 수당 프로그램이 상실됩니다.  이에 따라 당사는 웹사이트로 가서 ‘갱신’ 옵션을 선택하시기를 권장합니다.  갱신하면 당사의 소개 수당 및 월간 실적 수당을 받을 수 있는 자격을 가지게 됩니다
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        ROGP株への転換を申請せず、投資契約期間が満了時に再投資しない場合、引き続き直接紹介ボーナスおよび組織発展ボーナスを受けることできない。によって、会社のアドバイスとして、投資契約期間満了時に「継続」を選択することがお勧めします。それによって、毎月の配当およびシステムのボーナス制度を受けることができる。
                    <?php
                    } else {
                    ?>
                        If you do not want to select the R-Share swap plan, once your account reaches maturity, you will not be entitled to earn from our referral and investment programs. We therefore recommend that you go into the website and select the ‘renew’ option. Once you renew, you will be entitled to earn the bonuses offered by our referral programs and earn monthly performance returns.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">4. MT4余额低于初始本金</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">4. MT4 계좌 잔액 부족</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">4. MT4 Balanceは投資元本より減少した場合</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">4. Shortfall in the MT4 account</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        如果您的MT4余额低于您的初始入金，我们建议您充值至初始本金额度  以继续享受由公司市场推荐制度产生的推荐奖金及投资分红。如果您未在合同到期日之前充值，您的账户将在合同到期日之后被暂时搁置，直到您充值至初始本金额度。一旦账户额度达到初始本金额度，您将重新开始享受推荐奖金及每月投资分红
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        만약 현재 맥심 패키지를 갱신하기로 결정했는데, MT4 잔액이 초기 투자 금액이하로 떨어졌다면,  초기 투자 금액으로 탑업하여 소개 수당과 매월 실적 수당을 받을 수 있는 자격을 얻으시기 바랍니다.  만약 만기일 까지 탑업하지 않으면, 탑업시 까지 계좌는 정지됩니다.  탑업하면 자격을 얻게 됩니다
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        MT4 Balanceは投資元本より少ない場合、投資元本まで補填することがお勧めする。それによって会社の組織発展ボーナスおよび直接紹介ボーナスを受けることができる。投資契約期間が満了時に元本まで補填してない場合、口座は補填するまで有効な口座として見なさない。一旦元本まで補填すると、各種のボーナスおよび月間配当が再開される
                    <?php
                    } else {
                    ?>
                        If you decide to renew your existing Maxim package and if your balance in the MT4 has fallen below your initial capital investment amount, we invite you to top-up to its original sum so that you can continue to be entitled to bonuses offered by our referral programs and enjoy monthly performance returns. If you do not top-up by the maturity date, your account will be put on hold until you fully top-up to its original sum. Once topped up, you will be entitled to our referral program and earn monthly performance returns from the date of top up.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">5. 不继续合同</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">5. 갱신하지 않을 경우</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">5. 投資契約を継続しない場合</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">5. Non-renewal of contract</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        如果您个人决定不再继续合同，请于公司网站会员专区选择“不再续期”选项。请按照要求填写“合同不再续期”表格并邮件至<a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a>. 您MT4账号中最后的余额（合同到期届时，投资本金等同于MT4交易账户中的最后余额），将会在合同到期日后14天之内转入您的CP3账户。公司会将您CP2与CP3款项全部支付给您，之后您的个人账户将会从系统中注销，因此您将不再享受马胜市场推荐制度所带来的任何获利。
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        어떠한 이유로든지, 만약 갱신하지 않기를 원하시면, 웹사이트로 가서 “Non-renewal (갱신안함) “을 선택하십시오. 또한 ‘Non-renewal(갱신안함) 계약서”를 작성해서 <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> 로 메일을 보내주시기 바랍니다.  귀하의 마지막 MT4 잔액( 만기일 MT4 계좌 잔액에 표시된 초기 자본 투자)는 만기일 후 14일 이내 귀하의 CP3 계좌로 이체될 것입니다.  이후 다음 인출 사이클시 평소처럼 인출 할 것입니다.  지급되면 귀하의 계좌는 폐쇄됩니다.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        あなたは投資契約を継続しない場合、会社ホームページのメンバーエリアにで、「継続しない」と選択してください。そして、該当する申請書を記入し、maturity@maximtrader.comまで送信してください。あなたの口座内のMT4 Balanceと同額な金額は14日以内にCP3に振り込まれる。CP2およびCP3の全額は支給する。その後、あなたの口座はシステムから取り消され、マキシムトレーダーをビジネスとして展開する一切のボーナスを受けることできなくなる。
                    <?php
                    } else {
                    ?>
                        For any reason, if you wish not to renew your contract AND do not wish participate in the share swap plan, please go to the website and select the ‘non-renewal’ option. You are also required to complete the ‘non-renewal of contract’ form and email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a>. Your FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date) will then be credited into your CP3 account within 14 days after maturity date. You may then withdraw your CP2 and CP3 balances in the usual manner at the next withdrawal cycle. Once the payment is made, your account will be closed.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">6. 6个月不得重新加入</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">6. 6개월 금지</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">6. 6ヶ月内で再投資できない</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">6. Six months exclusion</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        如果您选择终止合同，公司严格规定6个月之内您将不得再次投资马胜，敬请遵守。
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        갱신하지 않는다면, 만기일 이후 6개월 동안 맥심트레이더에 재가입이 안됩니다.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        あなたは投資契約を継続しないと選択した場合、6ヶ月以内にマキシムトレーダーへの投資は禁止される。
                    <?php
                    } else {
                    ?>
                        Please note if you decide not to renew your contract, you are not allowed to re-join Maxim Trader for a period of 6 months after the maturity date.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">7. 一个账户ID内拥有多个配套的会员</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">7. 동일 유저 ID회원</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">7. 同一口座内複数のパッケージを持つ会員様</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">7. Members with the same user ID</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        请留意: 如果会员在一个账户ID内拥有多个投资配套，若会员需要继续享受推荐奖金或组织奖金，会员需要续约所有的配套; 如果有任一配套没有续约而被终止，那么该账户将不再继续享受任何推荐奖或组织奖。
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        동일 아이디로 한 개 이상의 패키지를 가입한 회원은 모든 패키지를 갱신해야 소개 수당 및 실적 수당을 받을 수 있는 자격을 얻을 수 있습니다. 만약 하나라도 갱신하지 않으면, 동일 ID의 모든 패키지로는 추천수당과 디벨롭먼트 수당을 받을 수 없습니다.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        注意：同一口座内に複数のパッケージを持つ会員様は、直接紹介ボーナスおよび組織発展ボーナスを受けるには、すべてのパッケージを投資継続することが必要である。そのうちの一つのパッケージを投資継続しないでも、各種の紹介とデヴェロッップメント・ボーナßスを受けることができない。
                    <?php
                    } else {
                    ?>
                        Please note that Maxim members who have more than one package under the same user ID will need to renew all the packages as and when they fall due, in order to be entitled to bonuses offered by Maxim’s referral programs and enjoy monthly performance returns. If anyone one of the packages are not renewed, all the remaining packages under the same user ID will cease to earn any referral and development bonus.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="">欲知更多详情，欢迎邮件至<a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a>.</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="">8.	추가 문의가 있으시면 <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> 로 연라바랍니다.</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="">8.	より詳細な情報は<a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a>まで請求してください。</span>
                    <?php
                    } else {
                    ?>
                        <span class="">Please email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> if you need further clarifications.</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>


            <tr>
                <td>
                    <span style="font-weight: bold;">
                    <?php
                    if ($culture == "cn") {
                    ?>
谢谢!
<br>
<br>Dr. Andrew Lim
<br>马胜资本有限公司首席执行官
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        감사합니다,
<br>
<br>앤드류 림 박사
<br>CEO
<br>맥심 캐피탈

                    <?php
                    } else if ($culture == "jp") {
                    ?>
                                            Thank you,
<br>
<br>Dr. Andrew Lim
<br>マキシムトレーダー CEO
                    <?php
                    } else {
                    ?>
                                            Thank you,
<br>
<br>Dr. Andrew Lim
<br>Chief Executive Officer
<br>Maxim Capital Limited
                    <?php
                    }
                     ?>
                        </span>
</td>
            </tr>

            </tbody>
        </table>
    </td>
</tr>
<tr>
<td>
</td>
</tr>
</tbody>
</table>