<?php include('scripts.php'); ?>
<script type="text/javascript">
$(function() {
    $.populateDOB({
        dobYear : $("#dob_year")
        ,dobMonth : $("#dob_month")
        ,dobDay : $("#dob_day")
        ,dobFull : $("#dob")
    });

    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "No space please and don't leave it empty");

    jQuery.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s\_]+$/i.test(value);
    }, "This field only accept latin word, numbers, or dashes.");

    jQuery.validator.addMethod("latinRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s\_\/\.]+$/i.test(value);
    }, "This field only accept latin word, numbers, or dashes.");

    $("#registerForm").validate({
        messages : {
            confirmPassword: {
                equalTo: "<?php echo __('Please enter the same password as above') ?>"
            },
            userName: {
                remote: "<?php echo __('User Name already in use') ?>."
            },
            fullname: {
                remote: "<?php echo __('Full Name already in use') ?>."
            }
        },
        rules : {
            "userName" : {
                required : true,
                noSpace: true,
                loginRegex: true,
                <?php if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

                } else {?>
                minlength : 5,
                <?php } ?>
                remote: "/member/verifyUserName"
            },
            "sponsorId" : {
                required : true
            },
            "userpassword" : {
                required : true,
                minlength : 6
            },
            "confirmPassword" : {
                required : true,
                minlength : 6,
                equalTo: "#userpassword"
            },
            "securityPassword" : {
                required : true,
                minlength : 6
            },
            "confirmSecurityPassword" : {
                required : true,
                minlength : 6,
                equalTo: "#securityPassword"
            },
            "fullname" : {
                required : true,
                latinRegex: true,
                minlength : 2
//                , remote: "/member/verifyFullName"
            },
            "dob" : {
                required : true
            },
            <?php if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

            } else {?>
            "address" : {
                required : true
            },
            "gender" : {
                required : true
            },
            "contactNumber" : {
                required : true
                , minlength : 10
            },
            <?php } ?>
            "email" : {
                required : true
                , email: true
            },
            "email2" : {
                required : true,
                equalTo: "#email"
            },
            /*"terms_bis" : {
                required : true
            },*/
            <?php if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

            } else {?>
            "terms_risk" : {
                required : true
            },
            "term_condition" : {
                required : true
            },
            <?php } ?>
            "sign_name" : {
                latinRegex: true,
                required : true
            }
            /*"privateInvestmentAgreement" : {
                required : true
            }*/
        },
        submitHandler: function(form) {
            if ($.trim($('#sponsorId').val()) == "") {
                alert("<?php echo __('Referrer ID cannot be blank') ?>.");
                $('#sponsorId').focus();
            } else {
                waiting();
                $.ajax({
                    type : 'POST',
                    url : "/member/verifyActiveSponsorId",
                    dataType : 'json',
                    cache: false,
                    data: {
                        sponsorId : $('#sponsorId').val()
                        , verifySameGroup : "Y"
                        , placementDistCode : $('#uplineDistCode').val()
                    },
                    success : function(data) {
                        waiting();
                        if (data == null || data == "") {
                            alert("<?php echo __('Invalid Referrer ID') ?>");
                            $('#sponsorId').focus();
                            $("#sponsorName").val("");
                        } else {
                            form.submit();
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Your login attempt was not successful. Please try again.");
                    }
                });
            }
            /*waiting();
            form.submit();*/
        },
        success: function(label) {
        }
    });

    $("#sponsorId").change(function() {
        if ($.trim($('#sponsorId').val()) != "") {
            verifySponsorId();
        }
    });
    <?php if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) { ?>
    $("#userpassword,#confirmPassword,#securityPassword,#confirmSecurityPassword").val("abc123");
    $("#userName").change(function(event){
        $("#fullname,#sign_name").val($(this).val());
    });
    $("#fullname").change(function(event){
        $("#sign_name").val($(this).val());
    });
    $("#email").val("123456789@gmail.com");
    $("#email2").val("123456789@gmail.com");
    <?php } ?>
});

function verifySponsorId() {
    waiting();
    $.ajax({
        type : 'POST',
        url : "/member/verifyActiveSponsorId",
        dataType : 'json',
        cache: false,
        data: {
            sponsorId : $('#sponsorId').val()
            , verifySameGroup : "Y"
            , placementDistCode : $('#uplineDistCode').val()
        },
        success : function(data) {
            if (data == null || data == "") {
                error("<?php echo __('Invalid Referrer ID') ?>");
                $('#sponsorId').focus();
                $("#sponsorName").val("");
            } else {
                $.unblockUI();
                $("#sponsorName").val(data.userName);
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
        }
    });
}

function verifySponsorId____BAK() {
    waiting();
    $.ajax({
        type : 'POST',
        url : "/member/verifyPlacementUnderSameSponsorGroupBySponsorId",
        dataType : 'json',
        cache: false,
        data: {
            sponsorId : $('#sponsorId').val()
            , placementDistCode : $('#uplineDistCode').val()
        },
        success : function(data) {
            if (data == null || data == "") {
                error("<?php echo __('Invalid Referrer ID') ?>");
                $('#sponsorId').focus();
                $("#sponsorName").val("");
            } else {
                $.unblockUI();
                $("#sponsorName").val(data.userName);
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
        }
    });
}
</script>

<form action="/member/doMemberRegistration" id="registerForm" method="post">
<input type="hidden" name="cp1Paid" value="<?php echo $cp1Paid;?>">
<input type="hidden" name="cp2cp3PaymentMethod" value="<?php echo $cp2cp3PaymentMethod;?>">
<input type="hidden" name="cp2cp3Paid" value="<?php echo $cp2cp3Paid;?>">
<input type="hidden" name="payBy" value="<?php echo $payBy;?>">

<input type="hidden" class="inputbox" id="packageId" name="packageId" value="<?php echo $selectedPackage->getPackageId();?>" readonly="readonly">
<input type="hidden" class="inputbox" id="productCode" name="productCode" value="<?php echo $productCode;?>" readonly="readonly">
<input type="hidden" name="uplineDistCode" id="uplineDistCode" value="<?php echo $uplineDistCode;?>"/>
<input type="hidden" name="treePosition" id="position" value="<?php echo $position;?>"/>

<table cellspacing="0" cellpadding="0">
<colgroup>
    <col width="1%">
    <col width="99%">
    <col width="1%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Member Registration') ?></span></td>
    <td rowspan="3">&nbsp;</td>
</tr>
<tr>
    <td><br>
    </td>
</tr>
<tr>
<td>

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

<table cellspacing="0" cellpadding="0" class="textarea1">
<tbody>
<tr>
<td>
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
        <th colspan="2"><?php echo __('Referrer and Placement Position') ?></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Referrer ID') ?></td>
        <td>
            <input type="text" class="inputbox" id="sponsorId" name="sponsorId" value="<?php //echo $sponsorId;?>">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Referrer Name') ?></td>
        <td>
            <input type="text" class="inputbox" id="sponsorName" name="sponsorName" value="<?php //echo $sponsorName;?>" readonly="readonly">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>
<br>
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
        <th><?php echo __('Account Login Details') ?></th>
        <th class="tbl_content_right"><!--Step 1 of 3--></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('User Name') ?></td>
        <td>
            <input type="text" class="inputbox" id="userName" name="userName">
            &nbsp;
            <br>
            <?php echo __('Please choose a unique username for your account. Username accepts 3-32 characters, a-z, 0-9 and underscore (_) only.') ?>
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Set Password') ?></td>
        <td>
            <input type="password" class="inputbox" id="userpassword" name="userpassword">
            <br>
            <?php echo __('enter your password. Password accepts 4-32 characters, A-Z, a-z, 0-9 and underscore (_) only and must include at least one letter and one number. Password is also case sensitive.') ?>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Confirm Password') ?></td>
        <td>
            <input type="password" class="inputbox" id="confirmPassword" name="confirmPassword">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Security Password') ?></td>
        <td>
            <input type="password" class="inputbox" id="securityPassword" name="securityPassword">
            <br>
            <?php echo __('Security Password is a separate password that is required when you withdraw money from your account. This is for security purposes to further protect your funds.') ?>
            <br>
            <?php echo __('Note: We strongly recommend that you choose a Security Password that is different from your login password.') ?>
            <br>
            <?php echo __('Security Password accepts 4-32 characters, A-Z, a-z, 0-9 and underscore (_) only and must include at least one letter and one number. Security Password is also case sensitive.') ?>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Confirm Security Password') ?></td>
        <td>
            <input type="password" class="inputbox" id="confirmSecurityPassword" name="confirmSecurityPassword">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>


<br>

<table cellspacing="0" cellpadding="0" class="tbl_form">
    <colgroup>
        <col width="1%">
        <col width="30%">
        <col width="69%">
        <col width="1%">
    </colgroup>

    <tbody>
    <tr class="row_header">
        <th class="tbl_header_left">
            <div class="border_left_grey">&nbsp;</div>
        </th>
        <th><?php echo __('Personal Information') ?></th>
        <th></th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Full Name') ?></td>
        <td>
            <input name="fullname" type="text" id="fullname" class="inputbox"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Date of Birth') ?></td>
        <td>
            <select id="dob_year"></select>
            <select id="dob_month"></select>
            <select id="dob_day"></select>
            <input name="dob" readonly="readonly" type="hidden" id="dob" class="bp_05"/>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Address') ?></td>
        <td>
            <input type="text" name="address" class='inputbox' value="" id="address"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td></td>
        <td>
            <input type="text" name="address2" class='inputbox' value=""/>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('City / Town') ?></td>
        <td>
            <input type="text" name="city" class='inputbox' value="" id="city"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Zip / Postal Code') ?></td>
        <td>
            <input type="text" name="zip" class='inputbox' value="" id="zip"/>
            <br><?php echo __('Please enter \'0\' if postal code is not applicable in your country.') ?>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('State / Province') ?></td>
        <td>
            <input type="text" name="state" class='inputbox' value="" id="state"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Country') ?></td>
        <td>
            <?php include_component('component', 'countrySelectOption', array('countrySelected' => "China (PRC)", 'countryName' => 'country', 'countryId' => 'country')) ?>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Gender') ?></td>
        <td>
            <select name="gender" class='inputbox'>
                <option value="" selected="selected"><?php echo __('Please Select') ?></option>
                <option value="M"><?php echo __('Male') ?></option>
                <option value="F"><?php echo __('Female') ?></option>
            </select>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    </tbody>
</table>

<br>
<table cellspacing="0" cellpadding="0" class="tbl_form">
    <colgroup>
        <col width="1%">
        <col width="30%">
        <col width="69%">
        <col width="1%">
    </colgroup>

    <tbody>
    <tr class="row_header">
        <th class="tbl_header_left">
            <div class="border_left_grey">&nbsp;</div>
        </th>
        <th><?php echo __('Contact Details') ?></th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Telephone Number') ?></td>
        <td>
            <input type="text" class="inputbox" id="contactNumber" name="contactNumber">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Primary Email') ?></td>
        <td>
            <div>
                <input type="text" class="inputbox" id="email" name="email">
            </div>
            <div class="td_desc" id="fielddesc__email">
                <?php echo __('Please enter a valid Email address. Note: If you use a Yahoo! email account, please also provide an Alternate Email below.') ?>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Retype your email') ?></td>
        <td>
            <input type="text" id="email2" value="" class="inputbox" name="email2">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Alternate Email') ?></td>
        <td>
            <div>
                <input type="text" id="alt_email" value="" class="inputbox" name="alt_email">
            </div>
            <div class="td_desc" id="fielddesc__alt_email">
                <?php echo __('Alternate Email is required ONLY IF you use a Yahoo! email account as your primary Email. Note: Your Alternate Email cannot be a Yahoo! account. We recommend') ?>
                <a target="_blank" href="http://mail.google.com">Gmail</a> or <a target="_blank" href="http://www.live.com">Hotmail</a>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Retype alternate email') ?></td>
        <td>
            <input type="text" id="alt_email2" value="" class="inputbox" name="alt_email2">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    </tr>
    </tbody>
</table>

<br>
<table cellspacing="0" cellpadding="0" class="tbl_form">
    <colgroup>
        <col width="1%">
        <col width="30%">
        <col width="69%">
            <col width="1%">
    </colgroup>

    <tbody>
    <tr class="row_header">
        <th class="tbl_header_left">
            <div class="border_left_grey">&nbsp;</div>
        </th>
        <th><?php echo __('Selected Package') ?></th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Package') ?></td>
        <td>
            <input type="text" class="inputbox" id="packageName" name="packageName" value="<?php echo $selectedPackage->getPackageName();?>" readonly="readonly">
            &nbsp;
            <input type="hidden" class="inputbox" id="amountNeeded" name="amountNeeded" value="<?php echo $amountNeeded;?>" readonly="readonly">
            &nbsp;<input type="text" class="inputbox" id="amountNeeded2" name="amountNeeded2" value="<?php echo $systemCurrency; ?>&nbsp;<?php echo number_format($amountNeeded,2);?>" readonly="readonly">
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even" style="display: none">
        <td>&nbsp;</td>
        <td><?php echo __('Placement Position') ?></td>
        <td>
            <div style="width:350px;">
                <input type="radio" id="radio_position1_0" checked="checked" value="0" name="position1"><label for="radio_position1_2" style="display: inline; font-size: 12px !important;"><?php echo __('Manual') ?></label>&nbsp;
                <input type="radio" id="radio_position1_1" value="1" name="position1"><label for="radio_position1_1" style="display: inline; font-size: 12px !important;"><?php echo __('Auto Left') ?></label>&nbsp;
                <input type="radio" id="radio_position1_2" value="2" name="position1"> <label for="radio_position1_2" style="display: inline; font-size: 12px !important;"><?php echo __('Auto Right') ?></label>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    </tbody>
</table>
<!--<br>
<table cellspacing="0" cellpadding="0" class="tbl_form">
    <colgroup>
        <col width="1%">
        <col width="30%">
        <col width="69%">
        <col width="1%">
    </colgroup>

    <tbody>
    <tr class="row_header">
        <th class="tbl_header_left">
            <div class="border_left_grey">&nbsp;</div>
        </th>
        <th><?php /*echo __('Beneficiary Nominee') */?></th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php /*echo __('Name') */?></td>
        <td>
            <input type="text" class="inputbox" id="nomineeName" name="nomineeName">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php /*echo __('Relationship') */?></td>
        <td>
            <input type="text" class="inputbox" id="nomineeRelationship" name="nomineeRelationship">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php /*echo __('IC./Passport No.') */?></td>
        <td>
            <input type="text" class="inputbox" id="nomineeIc" name="nomineeIc">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php /*echo __('Contact No.') */?></td>
        <td>
            <input type="text" class="inputbox" id="nomineeContactNo" name="nomineeContactNo">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    </tbody>
</table>-->
<br>
<table cellspacing="0" cellpadding="0" class="tbl_form">
<colgroup>
    <col width="1%">
    <col width="53%">
    <col width="18%">
    <col width="3%">
    <col width="8%">
    <col width="8%">
    <col width="1%">
</colgroup>

<tbody>
<tr class="row_header">
    <th class="tbl_header_left">
        <div class="border_left_grey">&nbsp;</div>
    </th>
    <th colspan="5">
        <?php echo __('Accept Terms') ?> &amp; <?php echo __('Agreements') ?>    </th>
    <th class="tbl_content_right"><!--Step 1 of 3--></th>
    <th class="tbl_header_right">
        <div class="border_right_grey">&nbsp;</div>
    </th>
</tr>


<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td colspan="5">
        <p>
        <?php echo __('Below are the contractural terms and agreements that you are bound by as a client of MaximTrader. We recommend that you take the time to read each of them carefully.') ?></p>

        <p><strong>
            <?php echo __('Please check the boxes below to acknowledge your acceptance, agreement and understanding of these terms and agreements.') ?>
            </strong></p>

    </td>
    <td>&nbsp;</td>
</tr>

<!--<tr class="tbl_form_row_odd">
    
    <td><input type="checkbox" class="checkbox" id="terms_bis" name="terms_bis">
        <label for="terms_bis">Terms Of Business, Trading Policies &amp; Procedures</label></td>
    <td colspan="4">
        <a target="_blank" href="/download/termsOfBusiness">Download Agreement (343 KB PDF)</a>
    </td>
    
</tr>-->

<tr class="tbl_form_row_even">
    <td>&nbsp;</td>
    <td><input type="checkbox" class="checkbox" id="terms_risk" name="terms_risk">
        <label for="terms_risk"><?php echo __('MCL Risk Disclosure statement') ?> </label></td>
    <td colspan="4">
        <a target="_blank" href="/download/riskDisclosureStatement"><?php echo __('Download Agreement') ?> (381 KB PDF)</a>
    </td>
    <td>&nbsp;</td>
</tr>

<!--<tr class="tbl_form_row_odd">
    
    <td><input type="checkbox" class="checkbox" id="privateInvestmentAgreement" name="privateInvestmentAgreement">
        <label for="privateInvestmentAgreement">Private Investment Agreement</label></td>
    <td colspan="4">
        <a target="_blank" href="/download/privateInvestmentAgreement">Download Agreement (67 KB Doc)</a>
    </td>
    
</tr>-->

<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td colspan="5">

        <p>
            <?php echo __('I hereby attest and certify that the above information is complete and accurate and I agree to be bound by these terms and conditions.') ?>
            <?php echo __('I also authorise') ?>
            <strong>MaximTrader</strong>
            <?php echo __('to verify any or all of the foregoing information. This electronic signature has the same validity and effect as a signature affixed by hand.') ?>
        </p>

        <table align="center" cellspacing="0" cellpadding="0" style="border-style:hidden">
            <tbody><tr style="border-style:hidden">
                <td align="right" style="border-style:hidden" class="td_1st"><?php echo __('Name') ?>:</td>
                <td style="border-style:hidden" class="td_2nd"><input type="text" class="inputbox" value="" name="sign_name" id="sign_name"></td>
            </tr>
            <tr>
                <td align="right" style="border-style:hidden" class="td_1st"><?php echo __('Date') ?>:</td>
                <td style="border-style:hidden" class="td_2nd"><input type="text" style="background-color: #d9d9d9;" readonly="readonly" class="inputbox" value="<?php echo date("Y-m-d")?>" name="date"></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="border-style:hidden" colspan="2">
                    <input type="checkbox" style="float:left; margin-right:4px;" value="1" id="term_condition" name="term_condition">

                    <label><p>
                        <?php echo __('I understand that as an MaximTrader customer, it is my responsibility to review all necessary information about currency trading and the MaximTrader') ?>
                        <b><?php echo __('Terms and Conditions') ?></b>.
                        <?php echo __('I am aware of the risks associated with foreign exchange trading and will seek advice and further my education on foreign exchange prior to starting any trading activity.') ?>
                    </p></label>
                </td>
            </tr>
            <tr>
                <td valign="top" style="border-style:hidden" class="td_1st" colspan="2">&nbsp;</td>
            </tr>
        </tbody></table>
    </td>
    
</tr>

<tr class="tbl_listing_end">
    <td>&nbsp;</td>
    <td colspan="5" class="tbl_content_right">
             <input type="submit" name="" value="<?php echo __('Submit') ?>">
    </td>
    <td>&nbsp;</td>
</tr>
</tbody>
</table>

</form>