<?php include('scripts.php'); ?>
<style type="text/css">
.blue_text {
    color: #0080C8;
    font-weight: bold;
}
</style>

<script type="text/javascript">
$(function() {
    $("#legalForm").validate({
        rules : {
            "fullName" : {
                required : true
            },
            "email" : {
                required : true
                , email: true
            },
            "terms_risk" : {
                required : true
            },
            "contact" : {
                required : true
            },
            "title" : {
                required : true
            },
            "legalWatchDicta" : {
                required: "#legalWatchDicta.length > 0",
                minlength : 3,
                accept:'docx?|pdf|bmp|jpg|jpeg|gif|png|tif|tiff|xls|xlsx'
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        },
        success: function(label) {
            //label.addClass("valid").text("Valid captcha!")
        }
    });
});
</script>
<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __("Legal Watch - Ask and be answered") ?></span></td>
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
                    <td>
                        <span class="blue_text" style="font-style: italic;">
                            <?php echo __('This is a free service to maxim members only. For  Non English communicators, please have someone read the two paragraphs below to you, in your language, and  type questions in English, as answers will be given in English.')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <strong>READ THIS CAREFULLY PLEASE:</strong>
                        <br>
                        <br>
                        <span style="color:#ff4500; font-size: 14px;line-height: 20px">
                        This is a FREE service designed for YOU ONLY, as an existing MAXIM member. If you have prospects who want to make the wise decision to come into MAXIM but are not in yet, they must ask their legal questions through YOU, as we can only advise YOU as a MAXIM member. Furthermore, we are not Formal Legal Advisers and therefore are NOT qualified to opine what the law may happen to be in your particular jurisdiction or Country. Therefore, we disclaim any responsibility as to the accuracy of our responses, despite our careful diligence  applied. Please consult your own local practicing Solicitor, Attorney or Advocate for any formal legal advice, at your expense, if you so wish. Lastly, if you are a minor (person below 18), you must have a parent type in the question and give their email for the answer. Our system is designed to automatically check the MAXIM number you give, against the information held against that number, ie; Name, age etc.
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><br>Having said that, now let us say this. <strong>YES WE CAN !</strong> Your question will go direct to our Legal Affairs and Compliance Department (LACD) and a response shall be given to you within NO LONGER than 48 hours, whether it is an interim or conclusive response. If interim, you will there be informed on when you will have a conclusive answer. Our program will also, devise a FAQ system as time goes on. This way, any regular question will first be assessed by our system and if the answer is already in our system, an immediate answer will be given to YOU. Please now accurately complete the following information, so we can help you;
                        <br><br>
                        <form action="/legalWatch/doSubmit" id="legalForm" name="legalForm" method="post" enctype="multipart/form-data">
                        <table cellspacing="0" cellpadding="0" class="tbl_form">
                            <colgroup>
                                <col width="1%">
                                <col width="30%">
                                <col width="69%">
                                <col width="1%">
                            </colgroup>
                            <tbody>
                            <tr>
                                <th class="tbl_header_left">
                                    <div class="border_left_grey">&nbsp;</div>
                                </th>
                                <th colspan="2"><?php echo __('Please fill in all the fields') ?></th>
                                <th class="tbl_header_right">
                                    <div class="border_right_grey">&nbsp;</div>
                                </th>
                            </tr>

                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('I have carefully read the above'); ?>:</td>
                                <td>
                                    <input type="checkbox" class="checkbox" id="terms_risk" name="terms_risk">&nbsp;
                                    <label for="terms_risk"><?php echo __('YES') ?> </label>
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td><?php echo __('My Passport/ID card full name (In English please)'); ?>:</td>
                                <td>
                                    <input name="fullName" id="fullName"
                                                       value="<?php echo $distDB->getFullName(); ?>"/>
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('Member ID'); ?>:</td>
                                <td>
                                    <input name="memberId" id="memberId"  disabled="disabled"
                                                       value="<?php echo $distDB->getDistributorCode(); ?>"/>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td><?php echo __('My age'); ?>:</td>
                                <td>
                                    <select id="age" name="age">
                                        <?php
                                        for ($x = 21; $x <= 100; $x++) {
                                        ?>
                                        <option value="<?php echo $x;?>"><?php echo $x;?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('My Education level'); ?>:</td>
                                <td>
                                    <select id="educationLevel" name="educationLevel">
                                        <option value="Primary School">Primary School</option>
                                        <option value="Secondary School">Secondary School</option>
                                        <option value="University">University</option>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td><?php echo __('My Email Address'); ?>:</td>
                                <td>
                                    <input name="email" id="email" 
                                                       value="<?php echo $distDB->getEmail(); ?>"/>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('My Contact Number'); ?>:</td>
                                <td>
                                    <input name="contact" id="contact" 
                                                       value="<?php echo $distDB->getContact(); ?>"/>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td><?php echo __('My title or job is'); ?>:</td>
                                <td>
                                    <input name="title" id="title"  maxlength="200"
                                                       value=""/>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('The Legal Issue I want to ask about is …(keep it very concise and brief)'); ?></td>
                                <td>
                                    <textarea rows="3" cols="30" id="message" name="message"></textarea>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td><?php echo __('Attach any related picture, Legal dicta or article in support of your above question'); ?></td>
                                <td>
                                    <?php echo input_file_tag('legalWatchDicta', array("id" => "legalWatchDicta", "name" => "legalWatchDicta")); ?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td></td>
                                <td align="right">
                                    <button id="btnTransfer"><?php echo __('Submit') ?></button>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="pbt_table">
            <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url_for("/download/downloadDicta?a=cn&q=" . rand()) ?>"><span><?php echo __("Click to DOWNLOAD LEGAL WATCH DICTA (Chinese)") ?></span></a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url_for("/download/downloadDicta?a=en&q=" . rand()) ?>"><span><?php echo __("Click to DOWNLOAD LEGAL WATCH DICTA (English)") ?></span></a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url_for("/download/downloadDicta?a=kr&q=" . rand()) ?>"><span><?php echo __("Click to DOWNLOAD LEGAL WATCH DICTA (Korea)") ?></span></a>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>