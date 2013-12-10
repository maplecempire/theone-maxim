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
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __("Your important message has been sent to LACD.") ?></span></td>
</tr>
<tr>
    <td>
        <table cellpadding="3" cellspacing="5">
            <tbody>
                <tr>
                    <td>
                        <br>
                        <span class="blue_text">
                            <?php echo __('We thank you for taking the time to “ASK and be ANSWERED”. No matter what, we are there for you, and YES WE CAN!')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <span class="blue_text">
                            <?php echo __('Please now expect a response from LACD within 48 hours. Even if LACD cannot give a conclusive response, you SHALL receive an interim response within the 48 hours and be informed when the conclusive response is to come to you. If nothing at all comes to your given email within 48 hours, this means, LACD did not receive your message, and to please resend your message, which is why we have your message is automatically copied to your email. Please check your email to make sure you have a copy of your message sent to LACD. DO NOT resend your message to LACD within 48 hours.')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <span class="blue_text">
                            <?php echo __('Congratulations ! on your wisdom, to Ask and be Answered.')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <span class="blue_text">
                            <?php echo __('With warm regards,')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="blue_text">
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