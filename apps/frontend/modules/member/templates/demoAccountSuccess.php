<style type="text/css">
h1, h2, h3, h4, h5, h6, tr.pricing-row td, #top .portfolio-title, .callout .content-area, .avia-big-box .avia-innerbox {
    font-family: Terminal Dosis;
}
h3 {
    font-size: 22px;
    line-height: 1.1em;
    margin-bottom: 8px;
}
h1, h2, h3, h4, h5, h6 {
    font-weight: normal;
}

.text_input {
    border-color: #E1E1E1;
    color: #919191;
    max-width: 100%;
    outline: medium none;
    padding: 6px 4px;
    font-size: 13px;
}
label {
    color: #919191;
}
</style>
<?php include('scripts.php'); ?>
<script>

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

    $("#ajaxForm").validate({
        messages : {
            "f-name": {
                remote: "<?php echo __('First Name already in use') ?>."
            },
            "l-name": {
                remote: "<?php echo __('Last Name already in use') ?>."
            }
        },
        rules : {
            "f-name" : {
                required : true,
                latinRegex: true,
                minlength : 2
            },
            "dob" : {
                required : true
            },
            "your-email" : {
                required : true
                , email: true
            },
            "agreeofRiskDisclosure" : {
                required : true
            }
        },
        submitHandler: function(form) {
            waiting();
            var serializeForm = $("#ajaxForm").serialize();
            $.ajax({
                type:'POST',
                url:"/member/openDemoAccount",
                dataType:'json',
                cache:false,
                data: serializeForm,
                success:function (data) {
                    $.unblockUI;
                    if (data.error == true) {
                        alert(data.errorMsg);
                    } else {
                        $("#ajaxForm").reset();
                        alert("Your application has been submitted.");
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Server connection error.");
                }
            });
        },
        success: function(label) {
        }
    });
});
</script>

<form action="http://partner.maximtrader.com/member/openDemoAccount" id="ajaxForm" method="post" class="ajax_form">
    <h3>Open Demo Account</h3>

    <table cellpadding="3" cellspacing="3">
        <tr>
            <td><label for="f-name">First Name</label></td>
            <td><input name="f-name" id="f-name" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">Last Name</label></td>
            <td><input name="l-name" id="l-name" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">Title</label></td>
            <td><input name="title" id="title" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">Date of Birth</label></td>
            <td>
                <select id="dob_year" name="dob_year"></select>
                <select id="dob_month" name="dob_month"></select>
                <select id="dob_day" name="dob_day"></select>
                <input name="dob" readonly="readonly" type="hidden" id="dob" class="bp_05"/>
            </td>
        </tr>
        <tr>
            <td><label for="f-name">Passport</label></td>
            <td><input name="ssnumber" id="ssnumber" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">Email</label></td>
            <td><input name="your-email" id="your-email" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">Phone Number</label></td>
            <td><input name="phone-number" id="phone-number" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">Address</label></td>
            <td><input name="address-1" id="address-1" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name"></label></td>
            <td><input name="address-2" id="address-2" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">City</label></td>
            <td><input name="city" id="city" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">State</label></td>
            <td><input name="state" id="state" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td><label for="f-name">Country</label></td>
            <td><input name="countrylist" id="countrylist" class="text_input is_empty" type="text" value="" size="30"></td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                <p class="" id="element_avia_i_have_read_the_general_terms_and_conditions_and_i_agree" style="display: inline;">
                    <input name="agreeofRiskDisclosure" class="input_checkbox is_empty" type="checkbox" id="avia_i_have_read_the_general_terms_and_conditions_and_i_agree" value="true">
                </p>
                <p class="" style="display: inline;">
                    <label for="avia_i_have_read_the_general_terms_and_conditions_and_i_agree">I have read the <a href="http://partner.maximtrader.com/download/riskDisclosureStatement" target="_blank">general terms and conditions</a> and I agree!*</label>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button id="btnSubmit" class="button">Submit</button>
            </td>
        </tr>
    </table>
</form>