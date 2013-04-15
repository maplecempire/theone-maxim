<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
    <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="-1">
    <link rel="shortcut icon" href="/favicon.ico"/>

    <?php use_helper('I18N') ?>
    <?php include('scripts.php'); ?>

    <link rel='stylesheet' id='nivocss-css'  href='/css/maxim/nivo-slider.css' type='text/css' media='all' />
    <link rel='stylesheet' id='styler-farbtastic-css'  href='/css/maxim/styler-farbtastic.css' type='text/css' media='all' />
    <link rel='stylesheet' id='wp-paginate-css'  href='/css/maxim/wp-paginate.css' type='text/css' media='screen' />

    <link rel="stylesheet" href="/css/style.css">

    <script type='text/javascript' src='/css/maxim/comment-reply.js'></script>
    <script type='text/javascript' src='/css/maxim/preloader.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.nivo.slider.js'></script>
    <script type='text/javascript' src='/css/maxim/bottomfix.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.quicksand.js'></script>
    <script type='text/javascript' src='/css/maxim/farbtastic.js'></script>

    <meta http-equiv="Content-Language" content="en-US">
    <style type="text/css" media="screen">
    .qtrans_flag span { display:none }
    .qtrans_flag { height:12px; width:18px; display:block }
    .qtrans_flag_and_text { padding-left:20px }
    a {
        background-color: transparent;
        color: #005D9A !important;
    }
    </style>
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">

	<script>
$(function() {
    $("#lang").change(function() {
        $("#langForm").submit();
    });

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
    }, "Username must contain only letters, numbers, or dashes.");

    $("#registerForm").validate({
        messages : {
            confirmPassword: {
                equalTo: "<?php echo __('Please enter the same password as above') ?>"
            },
            userName: {
                remote: "<?php echo __('User Name already in use') ?>."
            },
            captcha: "<br><?php echo __('Correct captcha is required') ?>.",
            fullname: {
                remote: "<?php echo __('Full Name already in use') ?>."
            }
        },
        rules : {
            "userName" : {
                required : true,
                noSpace: true,
                loginRegex: true,
                minlength : 6,
                remote: "/member/verifyUserName"
            },
            "sponsorId" : {
                required : true
            },
            "captcha" : {
                required: true,
                remote: "/captcha/process"
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
                minlength : 2
//                , remote: "/member/verifyFullName"
            },
            "dob" : {
                required : true
            },
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
            "email" : {
                required : true
                , email: true
            },
            "email2" : {
                required : true,
                equalTo: "#email"
            },
            "terms_risk" : {
                required : true
            },
            "term_condition" : {
                required : true
            },
            "sign_name" : {
                required : true
            }
        },
        submitHandler: function(form) {
            waiting();
            $.ajax({
                type : 'POST',
                url : "/member/verifySponsorId",
                dataType : 'json',
                cache: false,
                data: {
                    sponsorId : $('#sponsorId').val()
                },
                success : function(data) {
                    waiting();
                    if (data == null || data == "") {
                        alert("<?php echo __('Invalid Referral ID') ?>");
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
        },
        success: function(label) {
        }
    });

    $("#sponsorId").change(function() {
        if ($.trim($('#sponsorId').val()) != "") {
            verifySponsorId();
        }
    });
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
        },
        success : function(data) {
            if (data == null || data == "") {
                error("<?php echo __('Invalid Referral ID') ?>");
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
function waiting() {
    $("#waitingLB h3").html("<h3 style='float: none; text-align: center; font-size: inherit; font-weight: bold;'>Loading...</h3><div id='loader' class='loader' style='text-align: center;'><img id='img-loader' src='/images/loading.gif' alt='Loading' style='text-align: center;'/></div>");

    $.blockUI({
                message: $("#waitingLB")
                , css: {
                    border: 'none',
                    padding: '5px',
                    'background-color': '#fff',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    'border-radius': '10px',
                    opacity: .8,
                    color: '#000'
                }});
    $(".blockOverlay").css("z-index", 1010);
    $(".blockPage").css("z-index", 1011);
}
function alert(data) {
    var msgs = "";
    if ($.isArray(data)) {
        jQuery.each(data, function(key, value) {
            msgs = value + "<br>";
        });
    } else {
        msgs = data + "<br>";
    }

    var alertPanel = "<div style='margin-bottom: 20px; padding: 1em;' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span>";
    alertPanel += msgs + "</p></div>";
    $("#waitingLB h3").html(alertPanel);
    $.blockUI({
                message: $("#waitingLB")
                , css: {
                    border: 'none',
                    padding: '5px',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    'border-radius': '10px',
                    opacity: .9
                }});
    $(".blockOverlay").css("z-index", 1010);
    $(".blockPage").css("z-index", 1011);
    $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);
}
function error(data) {
    var msgs = "";
    if ($.isArray(data)) {
        jQuery.each(data, function(key, value) {
            msgs = value + "<br>";
        });
    } else {
        msgs = data + "<br>";
    }

    var errorPanel = "<div style='padding: 1em' class='ui-state-error ui-corner-all'>";
    errorPanel += "<p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-alert'></span>";
    errorPanel += msgs + "</p></div>";
    $("#waitingLB h3").html(errorPanel);
    $.blockUI({
                message: $("#waitingLB")
                , css: {
                    border: 'none',
                    padding: '5px',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    'border-radius': '10px',
                    opacity: .9,
                    'min-width': '30%',
                    'width': '60%',
                    left: '25%',
                    top: '25%'
                }});
    $(".blockOverlay").css("z-index", 1010);
    $(".blockPage").css("z-index", 1011);
    $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);
}
</script>
</head>
<img src="/images/loading.gif" style="display: none;">

<body class="home blog">
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request. Please be patient.</h3>
</div>
<noscript>
	<!-- display message if java is turned off -->
	<div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>
</noscript>

<div id="wrapper">
    <div id="page">
        <div id="content">

            <?php include_component('component', 'multiLanguage', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            <div class="qtrans_widget_end"></div>
            <div style="clear:both;"><br></div>

<form action="/member/doRegister" id="registerForm" method="post">
<table cellspacing="0" cellpadding="0">
<colgroup>
    <col width="1%">
    <col width="99%">
    <col width="1%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td class="tbl_sprt_bottom"><span class="txt_title">Registration</span></td>
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
        <th colspan="2"><?php echo __('Referral') ?></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Referral ID') ?></td>
        <td>
            <input type="text" class="inputbox" id="sponsorId" name="sponsorId" value="<?php //echo $sponsorId;?>">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Referral Name') ?></td>
        <td>
            <input type="text" class="inputbox" id="sponsorName" name="sponsorName" value="<?php //echo $sponsorName;?>" readonly="readonly">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>
<br>

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
        <td><?php echo __('Address') ?> 2&nbsp;</td>
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
                <td style="border-style:hidden" class="td_2nd"><input type="text" class="inputbox" value="" name="sign_name"></td>
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

<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td class="tbl_content_right">
        <div id="captchaimage" style="height: 32; width: 100">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" id="refreshimg" title="Click to refresh image"><img src="/captcha/image?<?php echo time(); ?>" width="90" height="30" alt="Captcha image" style="border-style: none"/></a>
        </div>

        <?php
          //require_once('recaptchalib.php');
          //$publickey = "6LfhJtYSAAAAAAMifW42AIEE0qnNgOEFIDB0sqwt"; // you got this from the signup page
          //echo recaptcha_get_html($publickey);
        ?>
    </td>
    <td colspan="3"><input name="captcha" type="text" id="captcha" class="login_t73" size="10"/></td>
    <td>&nbsp;</td>
</tr>
<tr class="tbl_listing_end">
    <td>&nbsp;</td>
    <td colspan="5" class="tbl_content_right">
         <span class="button">
             <input type="submit" name="" value="<?php echo __('Submit') ?>">
        </span>
    </td>
    <td>&nbsp;</td>
</tr>
</tbody>
</table>

</form>
</td>
</tr>

<tr>
    <td></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>


            <!-- announcement popup   -->
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">

    <div class="content_line" style="position: absolute; bottom: 170px;"></div>
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <div style="position: absolute; bottom: 10px; padding-right: 40px;">
        <?php include_component('component', 'footerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    </div>
        </div>
    </div>


    <div style="margin-left: 0px;" id="sidebar">
        <div id="sidebar-color"></div>
        <div id="sidebar-border"></div>
        <div id="sidebar-light"></div>
        <div id="sidebar-texture"></div>

        <div id="sidebar-content">

            <div id="logo"><a href="<?php echo url_for("/home")?>"><img src="/images/logo.png"></a></div>
            <div id="menu">
                <?php include_component('component', 'homeLeftMenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            </div>
            <div id="primary" class="widget-area" role="complementary">
                <ul class="xoxo">
                </ul>
            </div>
            <!-- #primary .widget-area -->
        </div>

        <div id="sidebar-bottom">
            <ul></ul>
            <p style="text-align: center;">© 2013 maximtrader.com <br> All rights reserved.</p>
        </div>
    </div>
</div>

</body>
</html>