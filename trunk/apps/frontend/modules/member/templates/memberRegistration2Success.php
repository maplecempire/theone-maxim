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
            /*"terms_bis" : {
                required : true
            },*/
            "terms_risk" : {
                required : true
            },
            "term_condition" : {
                required : true
            },
            "sig_name" : {
                required : true
            }
            /*"privateInvestmentAgreement" : {
                required : true
            }*/
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        },
        success: function(label) {
        }
    });
});
</script>

<form action="/member/doMemberRegistration" id="registerForm" method="post">

<table cellspacing="0" cellpadding="0">
<colgroup>
    <col width="1%">
    <col width="99%">
    <col width="1%">
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
        <th>Account Login Details</th>
        <th class="tbl_content_right"><!--Step 1 of 3--></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>User Name</td>
        <td>
            <input type="text" class="inputbox" id="userName" name="userName">
            &nbsp;
            <br>Please choose a unique username for your account. Username accepts
            3-32 characters, a-z, 0-9 and underscore (_) only.
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>Set Password</td>
        <td>
            <input type="password" class="inputbox" id="userpassword" name="userpassword">
            <br>enter your password. Password accepts 4-32 characters, A-Z,
            a-z, 0-9 and underscore (_) only and must include at least one letter and one number. Password is also case
            sensitive.
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Confirm Password:</td>
        <td>
            <input type="password" class="inputbox" id="confirmPassword" name="confirmPassword">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>Security Password</td>
        <td>
            <input type="password" class="inputbox" id="securityPassword" name="securityPassword">
            <br>Security Password is a separate password that is required when
            you withdraw money from your account. This is for security purposes to further protect your funds.
            <br>
            Note: We strongly recommend that you choose a Security Password that is different from your login
            password.
            <br>
            Security Password accepts 4-32 characters, A-Z, a-z, 0-9 and underscore (_) only and must include at least
            one letter and one number. Security Password is also case sensitive.
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Confirm Security Password:</td>
        <td>
            <input type="password" class="inputbox" id="confirmSecurityPassword" name="confirmSecurityPassword">
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

<!--<table cellspacing="0" cellpadding="0" class="tbl_form">
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
            <select id="leverage" class="inputbox" name="leverage">
                <option selected="selected" value="">Please Select</option>
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
                <select id="deposit_currency" class="inputbox" name="deposit_currency">
                    <option selected="selected" value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="AUD">AUD</option>
                    <option value="SGD">SGD</option>
                </select>
            </div>
            <div class="td_desc" id="fielddesc__deposit_currency">If a Money Manager handles your account, the currency of
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
                <input type="text" id="deposit_amount" value="" class="inputbox" name="deposit_amount">
            </div>
            <div class="td_desc" id="fielddesc__deposit_amount"></div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_listing_end">
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    </tbody>
</table>-->

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
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
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
            <br>Please enter '0' if postal code is not applicable in your country.
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
            <?php include_component('component', 'countrySelectOption', array('countrySelected' => "Malaysia", 'countryName' => 'country', 'countryId' => 'country')) ?>
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Gender') ?></td>
        <td>
            <select name="gender" class='inputbox'>
                <option value="" selected="selected">Please Select</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
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
        <th>Contact Details</th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Telephone Number</td>
        <td>
            <input type="text" class="inputbox" id="contactNumber" name="contactNumber">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>Primary Email</td>
        <td>
            <div>
                <input type="text" class="inputbox" id="email" name="email">
            </div>
            <div class="td_desc" id="fielddesc__email">Please enter a valid Email address. Note: If you use a Yahoo! email
                account, please also provide an Alternate Email below.
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Retype your email</td>
        <td>
            <input type="text" id="email2" value="" class="inputbox" name="email2">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>Alternate Email</td>
        <td>
            <div>
                <input type="text" id="alt_email" value="" class="inputbox" name="alt_email">
            </div>
            <div class="td_desc" id="fielddesc__alt_email">Alternate Email is required ONLY IF you use a Yahoo! email
                account as your primary Email. Note: Your Alternate Email cannot be a Yahoo! account. We recommend <a target="_blank" href="http://mail.google.com">Gmail</a> or <a target="_blank" href="http://www.live.com">Hotmail</a>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Retype alternate email</td>
        <td>
            <input type="text" id="alt_email2" value="" class="inputbox" name="alt_email2">
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
        <th>Selected Package</th>
        <th></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>


    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>Package</td>
        <td>
            <input type="text" class="inputbox" id="packageName" name="packageName" value="<?php echo $selectedPackage->getPackageName();?>" readonly="readonly">
            <input type="hidden" class="inputbox" id="packageId" name="packageId" value="<?php echo $selectedPackage->getPackageId();?>" readonly="readonly">
            <input type="hidden" class="inputbox" id="productCode" name="productCode" value="<?php echo $productCode;?>" readonly="readonly">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>


    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>Placement Position</td>
        <td>
            <div style="width:350px;">
                <input type="radio" id="radio_position1_0" checked="checked" value="0" name="position1"><label for="radio_position1_2">Manual</label>&nbsp;
                <input type="radio" id="radio_position1_1" value="1" name="position1"><label for="radio_position1_1">Auto Left</label>&nbsp;
                <input type="radio" id="radio_position1_2" value="2" name="position1"> <label for="radio_position1_2">Auto Right</label>
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
        Accept Terms &amp; Agreements    </th>
    <th class="tbl_header_right">
        <div class="border_right_grey">&nbsp;</div>
    </th>
</tr>


<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td colspan="5">
        <p>Below are the contractural terms and agreements that you are bound by as a client
        of MaximTrader. We recommend that you take the time to read each of them carefully.</p>

        <p><strong>Please check the boxes below to acknowledge your acceptance, argeement and
            understanding of these terms and agreements.</strong></p>

    </td>
    <td>&nbsp;</td>
</tr>

<!--<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td><input type="checkbox" class="checkbox" id="terms_bis" name="terms_bis">
        <label for="terms_bis">Terms Of Business, Trading Policies &amp; Procedures</label></td>
    <td colspan="4">
        <a target="_blank" href="/download/termsOfBusiness">Download Agreement (343 KB PDF)</a>
    </td>
    <td>&nbsp;</td>
</tr>-->

<tr class="tbl_form_row_even">
    <td>&nbsp;</td>
    <td><input type="checkbox" class="checkbox" id="terms_risk" name="terms_risk">
        <label for="terms_risk">MTL Risk Disclosure statement"</label></td>
    <td colspan="4">
        <a target="_blank" href="/download/riskDisclosureStatement">Download Agreement (381 KB PDF)</a>
    </td>
    <td>&nbsp;</td>
</tr>

<!--<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td><input type="checkbox" class="checkbox" id="privateInvestmentAgreement" name="privateInvestmentAgreement">
        <label for="privateInvestmentAgreement">Private Investment Agreement</label></td>
    <td colspan="4">
        <a target="_blank" href="/download/privateInvestmentAgreement">Download Agreement (67 KB Doc)</a>
    </td>
    <td>&nbsp;</td>
</tr>-->

<tr class="tbl_form_row_odd">
    <td>&nbsp;</td>
    <td colspan="5">

        <p>I hereby attest and certify that the above information is complete and accurate and I agree to be bound by
            these terms and conditions. I also authorise <strong>MaximTrader</strong> to verify any or all of the
            foregoing information. This electronic signature has the same validity and effect as a signature affixed by
            hand.</p>

        <table align="center" cellspacing="0" cellpadding="0" style="border-style:hidden">
            <tbody><tr style="border-style:hidden">
                <td align="right" style="border-style:hidden" class="td_1st">Name:</td>
                <td style="border-style:hidden" class="td_2nd"><input type="text" class="inputbox" value="" name="sig_name"></td>
            </tr>
            <tr>
                <td align="right" style="border-style:hidden" class="td_1st">Date:</td>
                <td style="border-style:hidden" class="td_2nd"><input type="text" style="background-color: #d9d9d9;" readonly="readonly" class="inputbox" value="2012-08-24" name="date"></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="border-style:hidden" colspan="2">
                    <input type="checkbox" style="float:left; margin-right:4px;" value="1" id="term_condition" name="term_condition">

                    <label><p>I understand that as an MaximTrader customer, it is my responsibility to review all necessary
                        information about currency trading and the MaximTrader <b>Terms and Conditions</b>. I
                        <!--information about currency trading and the MaximTrader <a target="_blank" href="/download/iBAgreement">Terms and Conditions</a>. I-->
                        am aware of the risks associated with foreign exchange trading and will seek advice and further my education
                        on foreign exchange prior to starting any trading activity.</p></label>
                </td>
            </tr>
            <tr>
                <td valign="top" style="border-style:hidden" class="td_1st" colspan="2">&nbsp;</td>
            </tr>
        </tbody></table>
    </td>
    <td>&nbsp;</td>
</tr>

<tr class="tbl_listing_end">
    <td>&nbsp;</td>
    <td colspan="5" class="tbl_content_right">
        <span class="button">
             <input type="submit" name="" value="Submit">
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
</form>