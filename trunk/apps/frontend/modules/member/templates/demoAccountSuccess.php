<?php include('scripts.php'); ?>
<script>
jQuery(document).ready(function() {
    jQuery("#btnSubmit").click(function(event){
        event.preventDefault();
        var serializeForm = jQuery("#ajaxForm").serialize();
        jQuery.ajax({
            type:'POST',
            url:"/member/openDemoAccount",
            dataType:'json',
            cache:false,
            data: {
                "your-email" : "abc"
            },
            success:function (data) {
                if (data.error == true) {
                    alert(data.errorMsg);
                } else {
                    alert("Your application has been submitted.");
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Server connection error.");
            }
        });
    });
});
</script>

<form action="http://partner.maximtrader.com/member/openDemoAccount" id="ajaxForm" method="post" class="ajax_form">
    <fieldset>
        <h3>Open Demo Account</h3>
        <br>
        <p>
            <label for="f-name">First Name</label>

            <input name="f-name" id="f-name" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">Last Name</label>

            <input name="l-name" id="l-name" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">Title</label>

            <input name="title" id="title" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">Passport</label>

            <input name="ssnumber" id="ssnumber" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">Email</label>

            <input name="your-email" id="your-email" class="text_input is_empty" type="text" value="">
        </p>

        <p>
            <label for="f-name">Phone Number</label>

            <input name="phone-number" id="phone-number" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">Address</label>

            <input name="address-1" id="address-1" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name"></label>

            <input name="address-2" id="address-2" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">City</label>

            <input name="city" id="city" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">State</label>

            <input name="state" id="state" class="text_input is_empty" type="text" value="">
        </p>
        <p>
            <label for="f-name">Country</label>

            <input name="countrylist" id="countrylist" class="text_input is_empty" type="text" value="">
        </p>



        <p class="" id="element_avia_i_have_read_the_general_terms_and_conditions_and_i_agree" style="display: inline;">
            <input name="agreeofRiskDisclosure" class="input_checkbox is_empty" type="checkbox" id="avia_i_have_read_the_general_terms_and_conditions_and_i_agree" value="true">
        </p>
        <p class="" style="display: inline;">
            <label for="avia_i_have_read_the_general_terms_and_conditions_and_i_agree">I have read the <a href="http://partner.maximtrader.com/download/riskDisclosureStatement" target="_blank">general terms and conditions</a> and I agree!*</label>
        </p>

        <p><input type="button" id="btnSubmit" class="button" value="Submit"></p></fieldset>
</form>