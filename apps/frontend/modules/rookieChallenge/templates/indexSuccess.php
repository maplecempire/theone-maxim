<?php include('scripts.php'); ?>
<?php
$culture = $sf_user->getCulture();
?>
<script type='text/javascript' src='/js/jquery/cmxforms.js'></script>

<script src="/js/jquery-countdown/js/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>

<?php

$time1 = strtotime(date("Y-m-d H:i:s"));
$time2 = strtotime("2014-09-20 00:00:00");
//$time2 = strtotime("2014-05-30 01:34:00");

$diff = $time2-$time1;

$days    = floor($diff / 86400);
$hours   = floor(($diff - ($days * 86400)) / 3600);
$minutes = floor(($diff - ($days * 86400) - ($hours * 3600)) / 60);
$seconds = floor(($diff - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
$stop = false;

if ($days < 0) {
    $stop = true;
} else {
    if ($days < 10) {
        $days = "0".$days;
    }
}
if ($hours < 10) {
    $hours = "0".$hours;
}
if ($minutes < 10) {
    $minutes = "0".$minutes;
}
if ($seconds < 10) {
    $seconds = "0".$seconds;
}
?>

<script type="text/javascript">
$(function() {
    <?php if ($stop == false) { ?>
    $('#counter').countdown({
        image: '/js/jquery-countdown/img/digits.png',
        startTime: '<?php echo $days.":".$hours.":".$minutes.":".$seconds?>'
    });
    <?php } ?>
});
</script>
<style type="text/css">
    br {
        clear: both;
    }

    .cntSeparator {
        font-size: 54px;
        margin: 10px 7px;
        color: #000;
    }

    .desc {
        margin: 7px 3px;
    }

    .desc div {
        float: left;
        font-family: Arial;
        width: 70px;
        margin-right: 65px;
        font-size: 13px;
        font-weight: bold;
        color: #000;
    }
</style>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <?php if ($culture == "cn") { ?>
        <td class="tbl_sprt_bottom"><span class="txt_title">最新针对新伙伴挑战计划!!!</span></td>
        <?php } else if ($culture == "jp") { ?>
        <td class="tbl_sprt_bottom"><span class="txt_title">ルーキー・チャレンジ!!!!</span></td>
        <?php } else if ($culture == "kr") { ?>
        <td class="tbl_sprt_bottom"><span class="txt_title">새회원 챌린지!!!!</span></td>
        <?php } else { ?>
        <td class="tbl_sprt_bottom"><span class="txt_title">Rookie Challenge!!!!</span></td>
        <?php } ?>
    </tr>
    <tr>
        <td><br>
            <?php if ($sf_flash->has('successMsg')): ?>
                <!--<div class="ui-widget">
                    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                         class="ui-state-highlight ui-corner-all">
                        <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                      class="ui-icon ui-icon-info"></span>
                            <strong><?php /*echo $sf_flash->get('successMsg') */?></strong></p>
                    </div>
                </div>-->
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
            <input type="hidden" id="pid" name="pid" value=""/>

            <table cellspacing="0" cellpadding="0" class="tbl_form">
                <colgroup>
                    <col width="1%">
                    <col width="30%">
                    <col width="69%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <tr>
                    <td colspan="4">
                        <?php if ($stop == true) { ?>
                        <div id="counter" style="height: 77px; overflow: hidden;">
                            <div class="cntDigit" id="cnt_0"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                            <div class="cntDigit" id="cnt_2"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                            <div class="cntSeparator" style="float: left;">:</div>
                            <div class="cntDigit" id="cnt_4"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                            <div class="cntDigit" id="cnt_5"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                            <div class="cntSeparator" style="float: left;">:</div>
                            <div class="cntDigit" id="cnt_7"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                            <div class="cntDigit" id="cnt_8"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                            <div class="cntSeparator" style="float: left;">:</div>
                            <div class="cntDigit" id="cnt_10"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                            <div class="cntDigit" id="cnt_11"
                                 style="height: 4620px; float: left; background: url(&quot;/js/jquery-countdown/img/digits.png&quot;) repeat scroll 0% 0% transparent; width: 53px; margin-top: 0px;"></div>
                        </div>
                        <?php } else { ?>
                            <div id="counter"></div>
                        <?php }  ?>
                        <div class="desc">
                            <div>Days</div>
                            <div>Hours</div>
                            <div>Minutes</div>
                            <div>Seconds</div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<style type="text/css">
.blue_text {
    color: #0080C8;
    font-weight: bold;
}
</style>

<form action="" id="q3Form" name="q3Form" method="post">
<table cellpadding="3" cellspacing="5">
    <tbody>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td class="tbl_sprt_bottom"><span class="txt_title"></span></td>
        </tr>
        <tr>
            <?php if ($culture == "cn") { ?>
            <td class=""><span style="font-weight: bold;">有史以来第一次公司针对新会员及伙伴们开放此政策，只要您加入马胜不超过6个(自然)月，您就可以享受该优惠！</span></td>
            <?php } else if ($culture == "jp") { ?>
            <td class=""><span style="font-weight: bold;">今回初めて、そして大変誇らしいことに、私たちは6ヵ月以内に参加してくれた新人のIMとパートナーの皆様に向けてプロモーションを開始しました。</span></td>
            <?php } else if ($culture == "kr") { ?>
            <td class=""><span style="font-weight: bold;">처음으로 자랑스럽게 새로운 국제 회원 여러분과 파트너들을 위한 프로모션을 발표합니다. 새 회워 자격은 최초로 회사에 합류한 일자가 지금부터 6개월 이내의 회원을 의미합니다.</span></td>
            <?php } else { ?>
            <td class=""><span style="font-weight: bold;"><?php echo __('Proudly and for the first-time ever, we are having a promo for Rookie IMs and Partners who as long as from date joined till now, are not over 6 calendar months') ?></span></td>
            <?php } ?>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text" style="font-weight: bold;">
                <?php if ($culture == "cn") { ?>
                    优惠时间: 1014.8.8 - 9.8日
                    <br><br>直接推荐:
                    <br>5万-9.9万美金可额外享受5%奖金
                    <br>10万-19.9万美金可额外享受6%奖金
                    <br>20万-30万美金可额外享受7%奖金
                <?php } else if ($culture == "jp") { ?>
                    チャレンジ期間　2014年8月8日〜9月8日
                    <br><br>ダイレクトスポンサー／パーソナルセールス:
                    <br>USD50k〜99k　の方はさらに5％
                    <br>USD100k〜199kの方はさらに6％
                    <br>USD300k〜300kの方はさらに7％
                <?php } else if ($culture == "kr") { ?>
                    도전 기간 : 2014년 8월 8일에서 9월 8일까지
                    <br><br>직 스폰서/개인 매출 :
                    <br>USD50,000부터 USD99,000 은 추가 5%를 받습니다
                    <br>USD100,000부터 USD199,000은 추가 6%를
                    <br>USD200,000부터 USD300,000은 추가 7%를 받게 됩니다.
                <?php } else { ?>
                    Challenge Period: August 8th to September 8th, 2014
                    <br><br>Direct Sponsor/Personal Sales:
                    <br>USD50k to USD99k will receive an Extra 5%
                    <br>USD100k to USD199k will receive an Extra 6%
                    <br>USD200k to USD300k will receive an Extra 7%
                <?php } ?>
                </span>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text">
                <?php if ($culture == "cn") { ?>
                    <?php echo __('注1')?> :
                    <?php echo __('该项奖金将会进入CP1账户')?><br><br>
                <?php } else if ($culture == "jp") { ?>
                    <?php echo __('Nb1')?> :
                    <?php echo __('ルーキーチャレンジボーナスはCP1にクレジットされます')?><br><br>
                <?php } else if ($culture == "kr") { ?>
                    <?php echo __('참고 1')?> :
                    <?php echo __('새 회원 도전 보너스는 CP1 계좌로 들어갑니다')?><br><br>
                <?php } else { ?>
                    <?php echo __('Nb1')?> :
                    <?php echo __('Rookie Challenge Bonus will be credited into CP1')?><br><br>
                <?php } ?>
                </span>
            </td>
        </tr>
        <tr>
            <td><span class="blue_text">
                <?php if ($culture == "cn") { ?>
                    <?php echo __('注2')?> :
                    <?php echo __('该项奖金只对于2014年3月、4月、5月、6月、7月、8月、9月加入马胜的会员')?><br><br>
                <?php } else if ($culture == "jp") { ?>
                    <?php echo __('Nb2')?> :
                    <?php echo __('2014年3月、4月、5月、6月、7月、8月、9月に参加したメンバーのみがルーキーとなります')?><br><br>
                <?php } else if ($culture == "kr") { ?>
                    <?php echo __('참고 2')?> :
                    <?php echo __('2014 3월, 5월, 6월, 7월, 8월, 9월에 등록한 새 회원들만 도전이 가능합니다')?><br><br>
                <?php } else { ?>
                    <?php echo __('Nb2')?> :
                    <?php echo __('Rookie member who joined on 2014 March, April, May, June, July, August & September entitled only')?><br><br>
                <?php } ?>
                </span>
            </td>
        </tr>
        <tr>
            <td><span class="blue_text">
                <?php if ($culture == "cn") { ?>
                    <?php echo __('加油吧，所有新伙伴们！这是专属您闪亮炫耀的机会！')?><br><br>
                <?php } else if ($culture == "jp") { ?>
                    <?php echo __('来れルーキーたちよ ...... あなたの報酬を輝かせて刈り取るチャンスです！')?><br><br>
                <?php } else if ($culture == "kr") { ?>
                    <?php echo __('도전하세요, 새 회원 여러분... 여러분의 보상을 거둬들이고 밝혀줄 기회입니다')?><br><br>
                <?php } else { ?>
                    <?php echo __('Come On Rookies...... This is your chance to shine and reap your reward $$$')?><br><br>
                <?php } ?>
                </span>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>

        <tr>
            <td>
            <div class="ui-widget">
                <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                     class="ui-state-highlight ui-corner-all">
                    <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                  class="ui-icon ui-icon-info"></span>
                        <strong><?php echo __("Your current personal sales : ".number_format($totalPersonalSales,2)) ?></strong></p>
                </div>
            </div>
            </td>
        </tr>

        <tr>
            <td><br></td>
        </tr>
    </tbody>
</table>

</form>