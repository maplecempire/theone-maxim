<?php include('scripts.php'); ?>
<style type="text/css">
.blue_text {
    color: #0080C8;
    font-weight: bold;
}
</style>
<?php if ($sf_flash->has('successMsg')) { ?>
<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __("Your important message has been sent to LEGAL WATCH (LW).") ?></span></td>
</tr>
<tr>
    <td>
        <table cellpadding="3" cellspacing="5">
            <tbody>
                <tr>
                    <td>
                        <br>
                        <span class="">
                            <?php echo __('We thank you for having the wisdom to participate on LW like hundreds of others are doing.  The fact that you are asking, means you care enough to want things to be proper and legitimate, and we congratulate you for that. Do remember, that no matter who tells you what, the truth comes from us at Legal Watch.')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <span class="">
                            <?php echo __('Please now expect a response from LACD  as soon as possible.. If nothing at all comes to your given email within  10 days, this means, LACD did not receive your message. Otherwise, everyone are getting responses in proper order.')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <span class="blue_text">
                            <?php // echo __('Congratulations ! on your wisdom, to Ask and be Answered.')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <span class="">
                            <?php echo __('With warm regards,')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="">
                            <?php echo __('LACD Officer.')?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>
<?php } ?>