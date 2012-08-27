<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>

<meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
<meta http-equiv="CACHE-CONTROL" content="NO-STORE">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta http-equiv="EXPIRES" content="-1">

<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>

<link rel="stylesheet" type="text/css" href="/css/style.css" media="all">
<link rel="stylesheet" type="text/css" href="/css/button.css" media="all">
<link rel="shortcut icon" href="/favicon.ico"/>

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
    <h3>We are processing your request. Please be patient.</h3>
</div>
<form action="/member/doRegister" id="registerForm" method="post">
<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td align="left">
<table class="tbl_layout" cellpadding="0" cellspacing="0">
<colgroup>
    <col width="1%">
    <col width="98%">
    <col width="1%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td>


        <table cellpadding="0" cellspacing="0">
            <colgroup>
                <col class="scb_colorbar1" width="20%">
                <col class="scb_colorbar2" width="10%">
                <col class="scb_colorbar3" width="15%">
                <col class="scb_colorbar4" width="5%">
                <col class="scb_colorbar5" width="50%">
            </colgroup>
            <tbody>
            <tr>
                <td class="scb_colorbar1">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="tbl_heading" cellpadding="0" cellspacing="0">
            <colgroup>
                <col width="17%">
                <col width="83%">
            </colgroup>
            <tbody>
            <tr>
                <td rowspan="2">
                    <img src="/images/logo.png" height="85">
                </td>
                <td class="txt_mainheading">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td class="txt_subheading">

                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <hr class="hr_heading">
    </td>
    <td rowspan="3">&nbsp;</td>
</tr>
<tr>
<td><br>
<table cellpadding="0" cellspacing="0">
<colgroup>
    <col width="10%">
    <col width="80%">
    <col width="10%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td class="tbl_sprt_bottom"><span class="txt_title">Member Registration</span></td>
    <td rowspan="3">&nbsp;</td>
</tr>
<tr>
    <td><br>
    </td>
</tr>
<tr>
<td>
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
        <th>Account Login Details</th>
        <th class="tbl_content_right"><!--Step 1 of 3--></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>
    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Referrer ID') ?></td>
        <td>
            <input name="sponsorId" type="text" id="sponsorId" class="inputbox"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Referrer Name') ?></td>
        <td>
            <input name="sponsorName" type="text" id="sponsorName" readonly="readonly" class="inputbox" style="background-color: #d9d9d9;"/>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('User Name') ?></td>
        <td>
            <input name="userName" type="text" id="userName" class="inputbox"/>
            &nbsp;
            <br/>Please choose a unique username for your account. Username accepts
            3-32 characters, a-z, 0-9 and underscore (_) only.
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Set Password') ?></td>
        <td>
            <input name="userpassword" type="password" id="userpassword" class="inputbox"/>
            <br/>enter your password. Password accepts 4-32 characters, A-Z,
            a-z, 0-9 and underscore (_) only and must include at least one letter and one number. Password is also case
            sensitive.
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Confirm Password') ?>:</td>
        <td>
            <input name="confirmPassword" type="password" id="confirmPassword" class="inputbox"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Security Password') ?></td>
        <td>
            <input name="securityPassword" type="password" id="securityPassword" class="inputbox"/>
            <br/>Security Password is a separate password that is required when
            you withdraw money from your account. This is for security purposes to further protect your funds.<br/>
            <br/>
            Note: We strongly recommend that you choose a Security Password that is different from your login
            password.<br/>
            <br/>
            Security Password accepts 4-32 characters, A-Z, a-z, 0-9 and underscore (_) only and must include at least
            one letter and one number. Security Password is also case sensitive.
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Confirm Security Password') ?>:</td>
        <td>
            <input name="confirmSecurityPassword" type="password" id="confirmSecurityPassword" class="inputbox"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_listing_end">
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    </tbody>
</table>

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
        <th>Trading Account Details</th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Leverage</td>
        <td>
            <select name="leverage" class='inputbox' id="leverage">
                <option value="" selected="selected"><?php echo __('Please Select') ?></option>
                <option value="50">1:50</option>
                <option value="100">1:100</option>
                <option value="200">1:200</option>
                <option value="300">1:300</option>
                <option value="400">1:400</option>
                <option value="500">1:500</option>
            </select>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>Spread</td>
        <td>
            <div class="td_desc">
                <select id="spread" class="inputbox" name="spread">
                    <option selected="selected" value="">Please Select</option>
                    <option value="F">Fixed Spread</option>
                    <option value="V">Variable Spread</option>
                    <option value="E">ECN Premier Spread</option>
                </select>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_listing_end">
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    </tbody>
</table>

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
        <th>Deposit Information</th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Deposit Currency</td>
        <td>
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
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>Deposit Amount</td>
        <td>
            <div>
                <input type="text" name="deposit_amount" class='inputbox' value="" id="deposit_amount"/>
            </div>
            <div id='fielddesc__deposit_amount' class='td_desc'></div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_listing_end">
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    </tbody>
</table>

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
        <th>Contact Details</th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Telephone Number') ?></td>
        <td>
            <input name="contactNumber" type="text" id="contactNumber" class="inputbox"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Primary Email') ?></td>
        <td>
            <div>
                <input name="email" type="text" id="email" class="inputbox"/>
            </div>
            <div id='fielddesc__email' class='td_desc'>Please enter a valid Email address. Note: If you use a Yahoo! email
                account, please also provide an Alternate Email below.
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Retype your email') ?></td>
        <td>
            <input type="text" name="email2" class='inputbox' value="" id="email2"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Alternate Email') ?></td>
        <td>
            <div>
                <input type="text" name="alt_email" class='inputbox' value="" id="alt_email"/>
            </div>
            <div id='fielddesc__alt_email' class='td_desc'>Alternate Email is required ONLY IF you use a Yahoo! email
                account as your primary Email. Note: Your Alternate Email cannot be a Yahoo! account. We recommend <a
                        href='http://mail.google.com' target='_blank'>Gmail</a> or <a href='http://www.live.com'
                                                                                      target='_blank'>Hotmail</a>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Retype alternate email') ?></td>
        <td>
            <input type="text" name="alt_email2" class='inputbox' value="" id="alt_email2"/>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_listing_end">
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    </tbody>
</table>

<table cellspacing="0" cellpadding="0" class="tbl_form">
<colgroup>
    <col width="1%">
    <col width="23%">
    <col width="18%">
    <col width="13%">
    <col width="18%">
    <col width="18%">
    <col width="1%">
</colgroup>

<tbody>
<tr class="row_header">
    <th class="tbl_header_left">
        <div class="border_left_grey">&nbsp;</div>
    </th>
    <th colspan="5">
        <?php echo __('Accept Terms & Agreements') ?>
    </th>
    <th class="tbl_header_right">
        <div class="border_right_grey">&nbsp;</div>
    </th>
</tr>


<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td colspan="5">
        <p>Below are the contractural terms and agreements that you are bound by as a client
        of OFXGlobal. We recommend that you take the time to read each of them carefully.</p>
        <br>
        <p><strong>Please check the boxes below to acknowledge your acceptance, argeement and
            understanding of these terms and agreements.</strong></p>
        <br>
    </td>
    <td>&nbsp;</td>
</tr>

<tr class="tbl_form_row_even">
    <td>&nbsp;</td>
    <td><input type='checkbox' name='terms_cust_agreement' id='terms_cust_agreement' class="checkbox"/>
        <label for='terms_cust_agreement'>Customer Agreement</label></td>
    <td colspan="4">
        <a href='/download/customerAgreement' target='_blank'>Download Agreement (272 KB PDF)</a>
    </td>
    <td>&nbsp;</td>
</tr>

<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td><input type='checkbox' name='terms_bis' id='terms_bis' class="checkbox"/>
        <label for='terms_bis'>Terms Of Business, Trading Policies & Procedures</label></td>
    <td colspan="4">
        <a href='/download/termsOfBusiness' target='_blank'>Download Agreement (343 KB PDF)</a>
    </td>
    <td>&nbsp;</td>
</tr>

<tr class="tbl_form_row_even">
    <td>&nbsp;</td>
    <td><input type='checkbox' name='terms_risk' id='terms_risk' class="checkbox"/>
        <label for='terms_cust_agreement'>Risk Disclosure Statement</label></td>
    <td colspan="4">
        <a href='/download/riskDisclosureStatement' target='_blank'>Download Agreement (175 KB PDF)</a>
    </td>
    <td>&nbsp;</td>
</tr>

<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td><input type='checkbox' name='terms_aml' id='terms_aml' class="checkbox"/>
        <label for='terms_bis'>AML Policy</label></td>
    <td colspan="4">
        <a href='/download/amlPolicy' target='_blank'>Download Agreement (228 KB PDF)</a>
    </td>
    <td>&nbsp;</td>
</tr>

<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td colspan="5">
        <br>
        <p>I hereby attest and certify that the above information is complete and accurate and I agree to be bound by
            these terms and conditions. I also authorise <strong>OFXGlobal</strong> to verify any or all of the
            foregoing information. This electronic signature has the same validity and effect as a signature affixed by
            hand.</p>

        <table cellpadding="0" cellspacing="0" align="center" style="border-style:hidden">
            <tr style="border-style:hidden">
                <td class="td_1st" align="right" style="border-style:hidden"><?php echo __('Name') ?>:</td>
                <td class='td_2nd' style="border-style:hidden"><input type='text' name='sig_name' value="" class='inputbox'/></td>
            </tr>
            <tr>
                <td class="td_1st" align="right" style="border-style:hidden"><?php echo __('Date') ?>:</td>
                <td class='td_2nd' style="border-style:hidden"><input type='text' name='date' value="<?php echo date("Y-m-d")?>" class='inputbox' readonly='readonly' style="background-color: #d9d9d9;"/></td>
            </tr>
            <tr>
                <td colspan="2" align="left" valign="top" style="border-style:hidden">
                    <input type='checkbox' name='term_condition' id='term_condition' value="1"
                           style="float:left; margin-right:4px;"/>

                    <label><p>I understand that as an OFXGlobal customer, it is my responsibility to review all necessary
                        information about currency trading and the OFXGlobal <a href="/download/iBAgreement" target="_blank">Terms and Conditions</a>. I
                        am aware of the risks associated with foreign exchange trading and will seek advice and further my education
                        on foreign exchange prior to starting any trading activity.</p></label>
                </td>
            </tr>
            <tr>
                <td colspan="2" valign="top" class='td_1st' style="border-style:hidden">&nbsp;</td>
            </tr>
        </table>
    </td>
    <td>&nbsp;</td>
</tr>

<tr class="tbl_listing_end">
    <td>&nbsp;</td>
    <td class="tbl_content_right" colspan="5">
        <span class="button">
             <input type="submit" value="Submit" name="">
        </span>
    </td>
    <td>&nbsp;</td>
</tr>
</tbody>
</table>

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
</td>
</tr>
<tr>
    <td>
        <br>
        <br>
        <br>
        <br>
        <hr class="hr_heading">
        <br>
        Copyright © Maxim Trader
        &nbsp;<span class="txt_seperator">|</span>&nbsp;
        <img src="/images/maxim/arrow_blue_single_tab.gif">

        <a href="#" class="navcontainer_nav_1" id="nav_terms_conditions" target="_self">
            Terms &amp; Conditions
        </a>

        &nbsp;<span class="txt_seperator">|</span>&nbsp;

        <img src="/images/maxim/arrow_blue_single_tab.gif">
        <a href="#" target="_self">
            Data Protection and Privacy Policy
        </a>
    </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</form>

</body>
</html>