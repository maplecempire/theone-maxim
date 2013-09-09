<?php include('scripts.php'); ?>

<script type='text/javascript' src='/js/jquery/cmxforms.js'></script>

<script src="/js/jquery-countdown/js/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>

<?php

$time1 = strtotime(date("Y-m-d H:i:s"));
$time2 = strtotime("2013-10-01 00:00:00");

$diff = $time2-$time1;

$days    = floor($diff / 86400);
$hours   = floor(($diff - ($days * 86400)) / 3600);
$minutes = floor(($diff - ($days * 86400) - ($hours * 3600)) / 60);
$seconds = floor(($diff - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

if ($days < 10) {
    $days = "0".$days;
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
    $('#counter').countdown({
        image: '/js/jquery-countdown/img/digits.png',
        startTime: '<?php echo $days.":".$hours.":".$minutes.":".$seconds?>'
    });
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
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Q3 Champions Challenge Ranking') ?></span></td>
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
                        <div id="counter"></div>
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

                                        echo "<tr class='row" . $trStyle . "'>
                                                <td align='left'>" . $idx++ . ".</td>
                                                <td align='middle'>" . $member['distributor_code'] . "</td>
                                                <td align='middle'>" . $member['country'] . "</td>
                                                </tr>";
                                    }
                                } else {
                                    echo "<tr class='odd' align='center'><td colspan='2'>" . __('No data available in table') . "</td></tr>";
                                }
                            ?>
                            </tbody>
                            <!--<input type='text' class='text qty' name='qty[]' value='0' size='5' ref='".$productDB->getPrice()."'>-->
                        </table>
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

<form action="/q3ChampionsChallenge/submit" id="q3Form" name="q3Form" method="post">
<table cellpadding="3" cellspacing="5">
    <tbody>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Q3 Champions Challenge – BMW 5 Series') ?></span></td>
        </tr>
        <tr>
            <td class=""><span style="font-weight: bold;"><?php echo __('Qualifying period August 5th to September 30th 2013 (GMT+8)') ?></span></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td align="center">
                <?php echo __('Here is a challenge worthy of champions to be…')?> <strong><?php echo __('Register', null, 'email')?></strong> <?php echo __('your Challenge which kicks off on August 5th 2013 and ends on September 30th 2013(GMT+8)') ?>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text">
                    <?php echo __('Stage 1 : Qualify with Personal Sales of USD200,000')?>
                </span>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span class="blue_text">
                    <?php echo __('Stage 2')?> :
                    <font color="#ff4500"><?php echo __('Top Performer')?></font> <?php echo __('during the Champions Challenge will win a Brand New BMW 5 Series 2013 model (regardless of country the winner is from)')?><br><br>
                    <font color="#ff4500"><?php echo __('1st Runner Up')?></font> : <?php echo __('Fully Furnished Resort Apartment by Royale Harmony (Southern Thailand) worth USD100,000.')?><br><br>
                    <font color="#ff4500"><?php echo __('2nd Runner Up')?></font> : <?php echo __('Resort Apartment by Royale Harmony (Southern Thailand) worth USD100,000')?><br><br>
                    <?php echo __('For those who achieve')?> <font color="#ff4500"><?php echo __('USD100K')?></font> – <?php echo __('2 tickets to “Annual Gala Dinner & Dance” to be held in Bangkok Thailand on January 2014 with 5-Star Hotel accommodation for 3 nights and air ticket reimbursement of 1,000 CP.')?><br>
                </span>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><span style="font-style: italic;"><?php echo __('NB. There will be a Commitment Fee of 1,000 CP (deducted from CP1/CP2/CP3) in the event that the Registrant fails to achieve at least USD100,000 of Personal Sales during Challenge Period.')?></span></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <?php
        if ($isChallenge == "N") {
        ?>
        <tr>
            <td><input type="checkbox" class="checkbox" id="terms_risk" name="terms_risk">&nbsp;<span style="font-weight: bold;"><label for="terms_risk"><?php echo __('I have read, have accepted and would like to Register my name to PARTICIPATE in the Q3 Champions Challenge.')?></label></span></td>
        </tr>
        <tr>
            <td align="right"><button id="btnSubmit"><?php echo __('Submit') ?></button></td>
        </tr>
        <?php } else { ?>
        <tr>
            <td>
            <div class="ui-widget">
                <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                     class="ui-state-highlight ui-corner-all">
                    <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                  class="ui-icon ui-icon-info"></span>
                        <strong><?php echo __("I'm Joined!!!") ?></strong></p>
                </div>
            </div>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td>
                <span style="font-style: italic;"><?php echo __('Terms & Conditions')?></span><br><br>
                <span style="font-style: italic;">
                    <table>
                        <tr><td>1.</td><td><?php echo __('This Challenge is for Maxim Trader member who register this challenge on 5th & 6th August 2013 only.')?></td></tr>
                        <tr><td>2.</td><td><?php echo __('Challenge period start from 5th August 2013 till 30th September 2013 (GMT+8).')?></td></tr>
                        <tr><td>3.</td><td><?php echo __('There will be a Commitment Fee of 1,000CP (deducted from CP1/CP2/CP3) in the event that the Registrant fails to achieve at least USD100,000 of Personal Sales during Challenge Period.')?></td></tr>
                        <tr><td>4.</td><td><?php echo __('The prize will not be transferable to another person.')?></td></tr>
                        <tr><td>5.</td><td><?php echo __('No part of a prize is exchangeable for cash or any other prize.')?></td></tr>
                        <tr><td>6.</td><td><?php echo __('If an advertised prize is not available, we reserve the right to offer an alternative prize of equal or greater value.')?></td></tr>
                        <tr><td>7.</td><td><?php echo __('This challenge is to be run with the spirit of Trust & Integrity which is the culture by which MAXIMers’ have embraced and forms the foundation of our corporate Credo. We will not hesitate to disqualify any Registrant found manipulating fair-play and damaging company’s image and integrity during the challenge period.')?></td></tr>
                        <tr><td>8.</td><td><?php echo __('Organizer will endeavor to send prizes within 6 month of the competition end date but cannot guarantee this delivery time.')?></td></tr>
                        <tr><td>9.</td><td><?php echo __('If you win a competition, we will notify you by e-mail. The judges’ decision will be final, and no correspondence will be entered into.')?></td></tr>
                        <tr><td>10.</td><td><?php echo __('This competition is being run by Maxim Capital Limited.')?></td></tr>
                    </table>
                </span>

            </td>
        </tr>
    </tbody>
</table>

</form>