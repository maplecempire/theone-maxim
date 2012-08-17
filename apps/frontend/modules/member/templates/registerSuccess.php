<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<head>
<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS Styles -->
<link rel="stylesheet" href="/css/style.css">
<style type="text/css">
h2 {
    padding: 5;
    margin: 0;
}
</style>
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

    $("#captchaimage").bind('click', function() {
        $.post('/captcha/newSession');
        $("#captchaimage").load('/captcha/imageRequest');
        return false;
    });

    $("#sponsorId").change(function() {
        if ($.trim($('#sponsorId').val()) != "") {
            verifySponsorId();
        }
    });

    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "No space please and don't leave it empty");

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
            "sponsorId" : {
                required: true
            },
            "userName" : {
                required : true,
                noSpace: true,
                minlength : 6,
                remote: "/member/verifyUserName"
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
            "leverage" : {
                required : true
            },
            "spread" : {
                required : true
            },
            "terms_ecn" : {
                required : true
            },
            "deposit_amount" : {
                required : true
            },
            "fullname" : {
                required : true,
                minlength : 2,
                remote: "/member/verifyFullName"
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
            "terms_cust_agreement" : {
                required : true
            },
            "terms_bis" : {
                required : true
            },
            "terms_risk" : {
                required : true
            },
            "terms_aml" : {
                required : true
            },
            "term_condition" : {
                required : true
            },
            "sig_name" : {
                required : true
            }
        },
        submitHandler: function(form) {
            if ($.trim($('#sponsorId').val()) == "") {
                alert("<?php echo __('Referrer ID cannot be blank') ?>.");
                $('#sponsorId').focus();
            } else {
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
        },
        success: function(label) {
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
                error("<?php echo __('Invalid Referrer ID') ?>");
                $('#sponsorId').focus();
                $("#sponsorName").val("");
            } else {
                $.unblockUI();
                $("#sponsorName").val(data.nickname);
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
        }
    });
}
function waiting() {
    $("#waitingLB h3").html("<h3>Loading...</h3><div id='loader' class='loader'><img id='img-loader' src='/images/loading.gif' alt='Loading'/></div>");

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
<body>
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request.  Please be patient.</h3>
</div>
<div id="wrapp_v2">
<div class="wrapper">
<!--this is header--><!-- #BeginLibraryItem "/Library/header.lbi" -->
<div id="google_translate_element" style="position:absolute; float: right; padding-right: 5px; padding-top: 3px; top:0px; right:30px"></div>
<script type="text/javascript">
  function googleTranslateElementInit() {
      new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,hi,id,ja,ko,vi,zh-CN', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<div id="header">
    <div id="logo"><a href="/home/login"><img src="/images/ofxglobal/logo.jpg"/></a></div>
    <span class="titleSpan"><strong>Serving Traders in <em class="titleEm">205</em> Countries Across <em
            class="titleEm">6</em> Continents</strong></span>

    <div class="clear"></div>
</div>
<!-- #EndLibraryItem --><!--header end here-->
<div class="clear"></div>
<!--- this is content--->
<div class="content">

<!--- aside end --->
<!--- content --->
<div class="areaContent" style="width : 98%">
<div class="clear"></div>
<div class="resultsWrap">
<!---form start--->
<form action="/member/doRegister" id="registerForm" method="post">
<table class='pbt_table' cellspacing="0" cellpadding="0" style="width : 100%">
<tr>
    <td colspan='2' style="width : 100%">
        <div class="split_section">
            <h2><?php echo __('Member Registration') ?></h2>
        </div>
    </td>
</tr>
<tr align="left" valign="top" id='input_ref'>
    <td class='td_1st'><?php echo __('Referrer ID') ?>&nbsp;</td>
    <td class='td_2nd'>
        <div>
            <div class='none' id='div_ref'>
                <input name="sponsorId" type="text" id="sponsorId" class="inputbox"/>
            </div>
        </div>
    </td>
</tr>
<tr align="left" valign="top">
    <td class='td_1st'><?php echo __('Referrer Name') ?>&nbsp;</td>
    <td class='td_2nd'>
        <div>
            <div class='none'>
                <input name="sponsorName" type="text" id="sponsorName" readonly="readonly" class="inputbox" style="background-color: #d9d9d9;"/>
            </div>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_username'>
    <td class='td_1st'><?php echo __('User Name') ?>&nbsp;</td>
    <td class='td_2nd'>
        <div>
            <input name="userName" type="text" id="userName" class="inputbox"/>
        </div>
        <div id='fielddesc__username' class='td_desc'>Please choose a unique username for your account. Username accepts
            3-32 characters, a-z, 0-9 and underscore (_) only.
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_password'>
    <td class='td_1st'><?php echo __('Set Password') ?></td>
    <td class='td_2nd'>
        <div>
            <input name="userpassword" type="password" id="userpassword" class="inputbox"/>
        </div>
        <div id='fielddesc__password' class='td_desc'>Please enter your password. Password accepts 4-32 characters, A-Z,
            a-z, 0-9 and underscore (_) only and must include at least one letter and one number. Password is also case
            sensitive.
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_password2'>
    <td class='td_1st'><?php echo __('Confirm Password') ?></td>
    <td class='td_2nd'>
        <div>
            <input name="confirmPassword" type="password" id="confirmPassword" class="inputbox"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_sec_password'>
    <td class='td_1st'><?php echo __('Security Password') ?></td>
    <td class='td_2nd'>
        <div>
            <input name="securityPassword" type="password" id="securityPassword" class="inputbox"/>
        </div>
        <div id='fielddesc__sec_password' class='td_desc'>Security Password is a separate password that is required when
            you withdraw money from your account. This is for security purposes to further protect your funds.<br/>
            <br/>
            Note: We strongly recommend that you choose a Security Password that is different from your login
            password.<br/>
            <br/>
            Security Password accepts 4-32 characters, A-Z, a-z, 0-9 and underscore (_) only and must include at least
            one letter and one number. Security Password is also case sensitive.
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_sec_password2'>
    <td class='td_1st'><?php echo __('Confirm Security Password') ?></td>
    <td class='td_2nd'>
        <div>
            <input name="confirmSecurityPassword" type="password" id="confirmSecurityPassword" class="inputbox"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top">
    <td colspan='2'>
        <div class="split_section">
            <h2><?php echo __('Trading Account Details') ?></h2>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_leverage'>
    <td class='td_1st'><?php echo __('Leverage') ?></td>
    <td class='td_2nd'>
        <div>
            <select name="leverage" class='inputbox' id="leverage">
                <option value="" selected="selected"><?php echo __('Please Select') ?></option>
                <option value="50">1:50</option>
                <option value="100">1:100</option>
                <option value="200">1:200</option>
                <option value="300">1:300</option>
                <option value="400">1:400</option>
                <option value="500">1:500</option>
            </select>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_spread'>
    <td class='td_1st'><?php echo __('Spread') ?></td>
    <td class='td_2nd'>
        <div class="td_desc">
            <select name="spread" class='inputbox' id="spread">
                <option value="" selected="selected"><?php echo __('Please Select') ?></option>
                <option value="F">Fixed Spread</option>
                <option value="V">Variable Spread</option>
                <option value="E">ECN Premier Spread</option>
            </select>
            <a name="iagree" id="iagree"></a>

            <div id='ecn_agreement' style='padding-top:10px; text-align:justify;' class='none'>Our ECN Premier Account
                requires a minimum deposit of USD500 (Fixed and Variable spread accounts require a minimum deposit of
                USD250).<br/>
                <br/>
                By registering for our ECN Premier Account you agree to have a 1 pip commission deducted from your
                account in real-time for the equivalent of every standard lot traded. (approximately USD10 per standard
                lot, USD1 per mini lot and USD0.10 per micro lot).<br/>
                <br/>
                We deduct this commission at the time you exit the trade. This commission is non-refundable.<br/>
                <br/>
                Once you trade the equivalent of 250 standard lots or more in a calendar month, you will qualify for a
                lower commission rate of USD8 per standard lot round trip traded (or equivalent thereof.) Therefore we
                will credit your account USD2 for each lot traded. <br/>
                <br/>
                For example, if you trade 300 standard lots during the month, we will credit your account with USD600 at
                the end of that month.<br/>
                <br/>

                <p class='center'>
                    <input type='checkbox' name='terms_ecn' checked='checked' id='terms_ecn' class='checkbox'/>
                    <label for='chk_terms_ecn'><span class='bold'>I Agree</span></label>
                </p>
            </div>
        </div>
        <div id='fielddesc__spread' class='td_desc'>We offer Fixed, Variable and ECN Premier spreads on our MT4 trading
            platform. Each option has its own distinct advantages. <a href='#' class='popup_content' rel='750x680'>Click
                here for more information</a></div>
    </td>
</tr>

<tr align="left" valign="top">
    <td colspan='2'>
        <div class="split_section">
            <h2><?php echo __('Deposit Information') ?></h2>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_deposit_currency'>
    <td class='td_1st'><?php echo __('Deposit Currency') ?></td>
    <td class='td_2nd'>
        <div>
            <select name="deposit_currency" class='inputbox' id="deposit_currency">
                <option value="USD" selected="selected">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
                <option value="AUD">AUD</option>
                <option value="SGD">SGD</option>
            </select>
        </div>
        <div id='fielddesc__deposit_currency' class='td_desc'>If a Money Manager handles your account, the currency of
            your account will match the currency that your Money Manager uses to make trades on your behalf. For
            example, if your manager trades in USD, your account will be in USD regardless of which currency you choose.
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_deposit_amount'>
    <td class='td_1st'><?php echo __('Deposit Amount') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="deposit_amount" class='inputbox' value="" id="deposit_amount"/>
        </div>
        <div id='fielddesc__deposit_amount' class='td_desc'></div>
    </td>
</tr>

<tr align="left" valign="top">
    <td colspan='2'>
        <div class="split_section">
            <h2><?php echo __('Personal Information') ?></h2>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_name'>
    <td class='td_1st'><?php echo __('Full Name') ?></td>
    <td class='td_2nd'>
        <div>
            <input name="fullname" type="text" id="fullname" class="inputbox"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_dob'>
    <td class='td_1st'><?php echo __('Date of Birth') ?></td>
    <td class='td_2nd'>
        <select id="dob_year"></select>
        <select id="dob_month"></select>
        <select id="dob_day"></select>
        <input name="dob" readonly="readonly" type="hidden" id="dob" class="bp_05"/>
    </td>
</tr>

<tr align="left" valign="top" id='input_address'>
    <td class='td_1st'><?php echo __('Address') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="address" class='inputbox' value="" id="address"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_address2'>
    <td class='td_1st'><?php echo __('Address') ?> 2&nbsp;</td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="address2" class='inputbox' value=""/>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_city'>
    <td class='td_1st'><?php echo __('City / Town') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="city" class='inputbox' value="" id="city"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_zip'>
    <td class='td_1st'><?php echo __('Zip / Postal Code') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="zip" class='inputbox' value="" id="zip"/>
        </div>
        <div id='fielddesc__zip' class='td_desc'>Please enter '0' if postal code is not applicable in your country.
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_state'>
    <td class='td_1st'><?php echo __('State / Province') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="state" class='inputbox' value="" id="state"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_country'>
<td class='td_1st'><?php echo __('Country') ?></td>
<td class='td_2nd'>
<div>
<?php include_component('component', 'countrySelectOption', array('countrySelected' => "Malaysia", 'countryName' => 'country', 'countryId' => 'country')) ?>
</div>
</td>
</tr>

<tr align="left" valign="top" id='input_gender'>
    <td class='td_1st'><?php echo __('Gender') ?></td>
    <td class='td_2nd'>
        <div>
            <select name="gender" class='inputbox'>
                <option value="" selected="selected">Please Select</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
        </div>
    </td>
</tr>

<tr align="left" valign="top">
    <td colspan='2'>
        <div class="split_section">
            <h2><?php echo __('Contact Details') ?></h2>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_phone_no'>
<td class='td_1st'><?php echo __('Telephone Number') ?></td>
<td class='td_2nd'>
<div>
    <input name="contactNumber" type="text" id="contactNumber" class="inputbox"/>
</div>
<div id='fielddesc__phone_no' class='td_desc'></div>
</td>
</tr>

<tr align="left" valign="top" id='input_email'>
    <td class='td_1st'><?php echo __('Primary Email') ?></td>
    <td class='td_2nd'>
        <div>
            <input name="email" type="text" id="email" class="inputbox"/>
        </div>
        <div id='fielddesc__email' class='td_desc'>Please enter a valid Email address. Note: If you use a Yahoo! email
            account, please also provide an Alternate Email below.
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_email2'>
    <td class='td_1st'><?php echo __('Retype your email') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="email2" class='inputbox' value="" id="email2"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top" id='input_alt_email'>
    <td class='td_1st'><?php echo __('Alternate Email') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="alt_email" class='inputbox' value="" id="alt_email"/>
        </div>
        <div id='fielddesc__alt_email' class='td_desc'>Alternate Email is required ONLY IF you use a Yahoo! email
            account as your primary Email. Note: Your Alternate Email cannot be a Yahoo! account. We recommend <a
                    href='http://mail.google.com' target='_blank'>Gmail</a> or <a href='http://www.live.com'
                                                                                  target='_blank'>Hotmail</a></div>
    </td>
</tr>

<tr align="left" valign="top" id='input_alt_email2'>
    <td class='td_1st'><?php echo __('Retype alternate email') ?></td>
    <td class='td_2nd'>
        <div>
            <input type="text" name="alt_email2" class='inputbox' value="" id="alt_email2"/>
        </div>
    </td>
</tr>

<tr align="left" valign="top">
    <td colspan='2'>
        <div class="split_section">
            <h2><?php echo __('Accept Terms & Agreements') ?></h2>
        </div>
    </td>
</tr>
<tr align="left" valign="top">
    <td></td>
    <td></td>
</tr>
<tr align="left" valign="top">
    <td colspan='2' class="td_1st">
        <div class="term_table_list_block">
            <table cellspacing="0" cellpadding="0">
                <tr class="">
                    <td colspan="3"><p>Below are the contractural terms and agreements that you are bound by as a client
                        of OFXGlobal. We recommend that you take the time to read each of them carefully.</p>

                        <p><strong>Please check the boxes below to acknowledge your acceptance, argeement and
                            understanding of these terms and agreements.</strong></p></td>
                </tr>
                <tr class='checkbox_bg row0 first'>
                    <td width="367"><input type='checkbox' name='terms_cust_agreement' id='terms_cust_agreement'
                                           class="checkbox"/>
                        <label for='terms_cust_agreement'>Customer Agreement</label></td>
                    <td width="321"><a href='/download/customerAgreement'
                                       target='_blank'>Download Agreement (272 KB PDF)</a></td>
                </tr>
                <tr class='checkbox_bg row1'>
                    <td width="367"><input type='checkbox' name='terms_bis' id='terms_bis' class="checkbox"/>
                        <label for='terms_bis'>Terms Of Business, Trading Policies & Procedures</label></td>
                    <td width="321"><a href='/download/termsOfBusiness' target='_blank'>Download
                        Agreement (343 KB PDF)</a></td>
                </tr>
                <tr class='checkbox_bg row0'>
                    <td width="367"><input type='checkbox' name='terms_risk' id='terms_risk' class="checkbox"/>
                        <label for='terms_risk'>Risk Disclosure Statement</label></td>
                    <td width="321"><a href='/download/riskDisclosureStatement'
                                       target='_blank'>Download Agreement (175 KB PDF)</a></td>
                </tr>
                <tr class='checkbox_bg row1 last'>
                    <td width="367"><input type='checkbox' name='terms_aml' id='terms_aml' class="checkbox"/>
                        <label for='terms_aml'>AML Policy</label></td>
                    <td width="321"><a href='/download/amlPolicy'
                                       target='_blank'>Download Agreement (228 KB PDF)</a></td>
                </tr>
                <tr class="tr_noborder">
                    <td colspan='2' class="corner-bot"></td>
                </tr>
            </table>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2" align="left" valign="top">
        <p>I hereby attest and certify that the above information is complete and accurate and I agree to be bound by
            these terms and conditions. I also authorise <strong>OFXGlobal</strong> to verify any or all of the
            foregoing information. This electronic signature has the same validity and effect as a signature affixed by
            hand.</p></td>
</tr>
<tr align="left" valign="top">
    <td class="td_1st" align="right"><?php echo __('Name') ?>:</td>
    <td class='td_2nd'><input type='text' name='sig_name' value="" class='inputbox'/></td>
</tr>

<tr align="left" valign="top">
    <td class="td_1st" align="right"><?php echo __('Date') ?>:</td>
    <td class='td_2nd'><input type='text' name='date' value="<?php echo date("Y-m-d")?>" class='inputbox' readonly='readonly' style="background-color: #d9d9d9;"/></td>
</tr>

<tr>
    <td colspan="2" align="left" valign="top">
        <input type='checkbox' name='term_condition' id='term_condition' value="1"
               style="float:left; margin-right:4px;"/>

        <label><p>I understand that as an OFXGlobal customer, it is my responsibility to review all necessary
            information about currency trading and the OFXGlobal <a href="/download/iBAgreement" target="_blank">Terms and Conditions</a>. I
            am aware of the risks associated with foreign exchange trading and will seek advice and further my education
            on foreign exchange prior to starting any trading activity.</p></label>
    </td>
</tr>
<tr id='input_captcha'>
    <td colspan="2" valign="top" class='td_1st'>
        <div style="margin:0 auto; width:100px;">
            <input style="padding:4px;" name="" type="submit" value="Submit"/>
        </div>
    </td>
    <td class='td_3rd'></td>
</tr>
</table>
<div class="clear"></div>
</form>
<div class="clear"></
<!---form end --->
</div>
</div>
<!--- contend end --->
<div class="push"></div>
<div class="clear"></div>
</div>
<!--- content end here--->
</div>
<div class="clear"></div>
<!--this is footer-->
<div id="footer" class="footer">
    <div class="copy">
        <address>
            Copyright © OFX Global, Privacy Statement | Terms and Conditions.
        </address>
    </div>
    <div class="clear"></div>
</div>
<!--footer is end here-->
<div class="clear"></div>
</div>
</body>


</html>