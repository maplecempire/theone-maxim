<?php include('scripts.php'); ?>

<script type='text/javascript' src='/js/jquery/cmxforms.js'></script>

<script src="/js/jquery-countdown/js/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>

<?php

$time1 = strtotime(date("Y-m-d H:i:s"));
$time2 = strtotime("2014-09-11 00:00:00");
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
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Rookie Challenge') ?></span></td>
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
            <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Rookie Challenge') ?></span></td>
        </tr>
        <tr>
            <td class=""><span style="font-weight: bold;"><?php echo __('Proudly and for the first-time ever, we are having a promo for Rookie IMs and Partners who as long as from date joined till now, are not over 6 calendar months') ?></span></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text" style="font-weight: bold;">
                    <?php echo __('Challenge Period: August 8th to September 8th, 2014
                    <br><br>Direct Sponsor/Personal Sales:
                    <br>USD50 to USD99k will receive an Extra 5%
                    <br>USD100k to USD199k will receive an Extra 6%
                    <br>USD200k to USD300k will receive an Extra 7%')?>
                </span>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text">
                    <?php echo __('Nb1')?> :
                    <?php echo __('Rookie Challenge Bonus will be credited into CP1')?><br><br>
                </span>
            </td>
        </tr>
        <tr>
            <td><span class="blue_text">
                    <?php echo __('Nb2')?> :
                    <?php echo __('Rookie member who joined on 2014 March, April, May, June, July, August & September entitled only')?><br><br>
                </span>
            </td>
        </tr>
        <tr>
            <td><span class="blue_text">
                    <?php echo __('Come On Rookies...... This is your chance to shine and reap your reward $$$')?><br><br>
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