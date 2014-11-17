<?php include('scripts.php'); ?>

<script type='text/javascript' src='/js/jquery/cmxforms.js'></script>

<script src="/js/jquery-countdown/js/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>

<?php

$time1 = strtotime(date("Y-m-d H:i:s"));
$time2 = strtotime("2014-06-01 00:00:00");
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
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('BMW X6 Challenge Ranking') ?></span></td>
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

                        <!--<div id="counter" style="height: 77px; overflow: hidden;">
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
                        </div>-->



                        <div class="desc">
                            <div>Days</div>
                            <div>Hours</div>
                            <div>Minutes</div>
                            <div>Seconds</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table class="pbl_table" border="1" cellspacing="0">
                            <tbody>
                            <tr class="pbl_header">
                                <td valign="middle" width="10"></td>
                                <td valign="middle"><?php echo __('Member ID') ?></td>
                                <td valign="middle"><?php echo __('Country') ?></td>
                                <td valign="middle"><?php echo __('Total Personal Sales') ?></td>
                                <?php
                                if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {
                                    echo "<td align='middle'>Full Name</td>";
                                } else {

                                }
                                ?>
                            </tr>

                            <?php
                                if (count($resultArray) > 0) {
                                    $trStyle = "1";
                                    $idx = 1;
                                    foreach ($resultArray as $member) {
                                        if ($trStyle == "1") {
                                            $trStyle = "0";
                                        } else {
                                            $trStyle = "1";
                                        }

                                        $totalSales = number_format($member['SUB_TOTAL'],2);
                                        if ($idx > 10) {
                                            if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

                                            } else {
                                                $totalSales = "******";
                                            }
                                        }

                                        echo "<tr class='row" . $trStyle . "'>
                                                <td align='left'>" . $idx++ . ".</td>
                                                <td align='middle'>" . $member['distributor_code'] . "</td>
                                                <td align='middle'>" . $member['country'] . "</td>
                                                <td align='middle'>" . $totalSales . "</td>";

                                        if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {
                                            echo "<td align='middle'>" . $member['full_name'] . "</td>";
                                        } else {

                                        }
                                        echo "</tr>";

                                        if ($idx > 10)
                                            break;
                                    }
                                } else {
                                    echo "<tr class='odd' align='center'><td colspan='2'>" . __('No data available in table') . "</td></tr>";
                                }
                            ?>
                            </tbody>
                            <!--<input type='text' class='text qty' name='qty[]' value='0' size='5' ref='".$productDB->getPrice()."'>-->
                        </table>
                        <br>
                        <br>
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

<script type="text/javascript">
$(function() {
    $("#q3Form").validate({
        messages : {
            transactionPassword: {
                remote: "<?php echo __("Security Password is not valid.")?>"
            }
        },
        rules : {
            "terms_risk" : {
                required : true
            }
        },
        submitHandler: function(form) {
            form.submit();
        },
        success: function(label) {
        }
    });
});
</script>

<form action="/bmwX6Challenge/submit" id="q3Form" name="q3Form" method="post">
<table cellpadding="3" cellspacing="5">
    <tbody>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('BMW X6 Challenge') ?></span></td>
        </tr>
        <tr>
            <td class=""><span style="font-weight: bold;"><?php echo __('Qualifying period March 10th to May 31th 2014 (GMT+8)') ?></span></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text">
                    <?php echo __('Stage 1 : Qualify with Personal Sales of USD3,000,000')?>
                </span>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text">
                    <?php echo __('Stage 2')?> :
                    <font color="#ff4500"><?php echo __('Top Performer')?></font> <?php echo __('during the Champions Challenge will win a Brand New BMW X6 SERIES (regardless of country the winner is from)')?><br><br>
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
        <tr>
            <td>
                <span style="font-style: italic;"><?php echo __('Terms & Conditions')?></span><br><br>
                <span style="font-style: italic;">
                    <ol>
                        <li><?php echo __('Challenge period start from 10th March 2014 till 31th May 2014 (GMT+8).')?></li>
                        <li><?php echo __('The prize will not be transferable to another person.')?></li>
                        <li><?php echo __('No part of a prize is exchangeable for cash or any other prize.')?></li>
                        <li><?php echo __('If an advertised prize is not available, we reserve the right to offer an alternative prize of equal or greater value.')?></li>
                        <li><?php echo __('This challenge is to be run with the spirit of Trust & Integrity which is the culture by which MAXIMers’ have embraced and forms the foundation of our corporate Credo. We will not hesitate to disqualify any Registrant found manipulating fair-play and damaging company’s image and integrity during the challenge period.')?></li>
                        <li><?php echo __('Organizer will endeavor to send prizes within 6 month of the competition end date but cannot guarantee this delivery time.')?></li>
                        <li><?php echo __('If you win a competition, we will notify you by e-mail. The judges’ decision will be final, and no correspondence will be entered into.')?></li>
                        <li><?php echo __('This competition is being run by Maxim Capital Limited.')?></li>
                    </ol>
                </span>

            </td>
        </tr>
    </tbody>
</table>

</form>