<?php include('scripts.php'); ?>
<script type="text/javascript">
    var cardCharges = <?php echo Globals::IME_CHARGES; ?>;
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
        }, "Username must contain only letters, numbers, or dashes.");

        $("#registerForm").validate({
            messages : {
                transactionPassword: {
                    remote: "<?php echo __("Security Password is not valid")?>"
                },
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
                "transactionPassword" : {
                    required : true,
                    remote: "/member/verifyTransactionPassword"
                },
                "fullname" : {
                    required : true,
                    minlength : 2
                },
                "passportNumber" : {
                    required : true,
                    minlength : 2
                },
                "nationality" : {
                    required : true,
                    minlength : 2
                },
                "email" : {
                    required : true
                    , email: true
                },
                "contactNumber" : {
                    required : true
                }
            },
            submitHandler: function(form) {
                waiting();

                var epointBalance = $('#txtCp1').autoNumericGet();
                var ecashBalance = $('#txtCp2').autoNumericGet();
                var cp3Balance = $('#txtCp3').autoNumericGet();

                var value = $("#cardQty").val();
                var result = cardCharges * parseFloat(value);

                if ($("#payByOption").val() == "CP1") {
                    if (result > parseFloat(epointBalance)) {
                        alert("In-sufficient CP1");
                        return false;
                    }
                } else if ($("#payByOption").val() == "CP3") {
                    if (result > parseFloat(cp3Balance)) {
                        alert("In-sufficient CP3");
                        return false;
                    }
                } else {
                    if (result > parseFloat(ecashBalance)) {
                        alert("In-sufficient CP2");
                        return false;
                    }
                }
                form.submit();
            },
            success: function(label) {
            }
        });

        $("#btnSubmit").button({
            icons: {
                primary: "ui-icon-circle-check"
            }
        });
        $("#payByOption").change(function(event){
            var value = $(this).val();
            if (value == "CP1") {
                $("#trCP1").show();
                $("#trCP2").hide();
                $("#trCP3").hide();
            } else if (value == "CP2") {
                $("#trCP1").hide();
                $("#trCP2").show();
                $("#trCP3").hide();
            } else if (value == "CP3") {
                $("#trCP1").hide();
                $("#trCP2").hide();
                $("#trCP3").show();
            }
        });

        $("#cardQty").change(function(event){
            var value = $(this).val();
            var result = cardCharges * parseFloat(value);
            $("#subtotal").autoNumericSet(result);
        });

        $('#subtotal').autoNumeric({
            mDec: 2
        });
    });
</script>

<form action="/imeRegistration/doSubmit" id="registerForm" method="post">
    <table cellspacing="0" cellpadding="0">
        <colgroup>
            <col width="1%">
            <col width="99%">
            <col width="1%">
        </colgroup>
        <tbody>
        <tr>
            <td rowspan="3">&nbsp;</td>
            <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('IME Early Bird PROMOtion till June 20th 2013') ?></span>
            </td>
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
                                <tr class="row_header">
                                    <th class="tbl_header_left">
                                        <div class="border_left_grey">&nbsp;</div>
                                    </th>
                                    <th><?php echo __('IME Registration') ?></th>
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
                                    <td><?php echo __('Full Name (Chinese)') ?></td>
                                    <td>
                                        <input name="fullnameChinese" type="text" id="fullnameChinese" class="inputbox"/>
                                        &nbsp;
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_odd">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Passport Number') ?></td>
                                    <td>
                                        <input type="text" class="inputbox" id="passportNumber" name="passportNumber">
                                        &nbsp;
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_even">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Nationality') ?></td>
                                    <td>
                                        <input type="text" class="inputbox" id="nationality" name="nationality">
                                        &nbsp;
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_odd">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Contact Number') ?></td>
                                    <td>
                                        <input type="text" class="inputbox" id="contactNumber" name="contactNumber">
                                        &nbsp;
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>


                                <tr class="tbl_form_row_even">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Email') ?></td>
                                    <td>
                                        <input type="text" class="inputbox" id="email" name="email">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="">
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
                                    <th><?php echo __('Payment') ?></th>
                                    <th></th>
                                    <th class="tbl_header_right">
                                        <div class="border_right_grey">&nbsp;</div>
                                    </th>
                                </tr>
                                <tr class="tbl_form_row_odd">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Charges (USD)') ?></td>
                                    <td>
                                        <input type="text" id="debitCardCharges" size="30" readonly="readonly"
                                                             value="<?php echo number_format($imeCharges, 2) ?>"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_even">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Total Ticket Applied') ?></td>
                                    <td>
                                        <select id="cardQty" name="cardQty">
                                            <?php for ($i=1; $i<=10; $i++) { ?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_odd">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Sub Total') ?></td>
                                    <td>
                                        <input type="text" id="subtotal" size="30" readonly="readonly"
                                                             value="<?php echo number_format($imeCharges, 2) ?>"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_even">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Pay By') ?></td>
                                    <td>
                                        <select id="payByOption" name="payByOption">
                                            <option value="CP1">CP1</option>
                                            <option value="CP2">CP2</option>
                                            <option value="CP3">CP3</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_odd" id="trCP1">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('CP1 Account') ?></td>
                                    <td>
                                        <input type="text" id="txtCp1" size="30" readonly="readonly"
                                                             value="<?php echo number_format($epointBalance,2) ?>"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="tbl_form_row_odd" id="trCP2" style="display: none;">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('CP2 Account') ?></td>
                                    <td>
                                        <input type="text" id="txtCp2" size="30" readonly="readonly"
                                                             value="<?php echo number_format($ecashBalance,2) ?>"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="tbl_form_row_odd" id="trCP3" style="display: none;">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('CP3 Account') ?></td>
                                    <td>
                                        <input type="text" id="txtCp3" size="30" readonly="readonly"
                                                             value="<?php echo number_format($cp3Balance,2) ?>"/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="tbl_form_row_even">
                                    <td>&nbsp;</td>
                                    <td><?php echo __('Security Password'); ?></td>
                                    <td>
                                        <input name="transactionPassword" type="password" id="transactionPassword"/>
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

                                <tr class="">
                                    <td>&nbsp;</td>
                                    <td colspan="5" class="tbl_content_right">
                                        <button id="btnSubmit"><?php echo __('Submit') ?></button>
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

                <h3>Terms and Conditions</h3>
                <br>
                <table cellpadding="3" cellspacing="3">
                    <tr><td>•</td><td>	This ticket is valid only for the IME to be held on August 5th to 8th in Macau, China</td></tr>
                    <tr><td>•</td><td>	This ticket is inclusive of airport transfer to hotel</td></tr>
                    <tr><td>•</td><td>	This ticket includes 3 nights (August 5th, 6th, 7th) accommodations on twin sharing basis</td></tr>
                    <tr><td>•</td><td>	This ticket is inclusive of all the activities of IME</td></tr>
                    <tr><td>•</td><td>	This ticket is transferable</td></tr>
                    <tr><td valign="top">•</td><td>	This ticket includes entry to August 6th conference where we will have talks by financial experts from USA, China, Malaysia, Hong Kong and Singapore</td></tr>
                    <tr><td>•</td><td>	This ticket also includes an invitation to attend our Gala Dinner Nite on August 6th</td></tr>
                    <tr><td>•</td><td>	This ticket does not include airline ticket</td></tr>
                </table>

                <h3>IME Guide</h3>
                <br>
                <p>
                    We do recommend that members arrange their flight to arrive <strong>no later than 2pm on August 5th 2013.</strong>
                    <br>
                    <br>
                    Upon arrival, please look for our Maxim Hostess who will arrange your airport transfer to Venetian Macau Hotel. If you cannot find our Maxim Hostess, please look for the Venetian Macau Hotel counter and take the free transfer to the hotel.
                    <br>
                    <br>
                    <strong>Day 1 (Aug 5th)</strong>
                    <br>
                    <br>
                    Registration and issuance of IME ID Tag & Assigning of Rooms
                    <br>
                    7.30 – 9.30	An Evening with Jim Rogers
                    <br>
                    <br>
                    <strong>Day 2 (Aug 6th)</strong>
                    <br>
                    <br>
                </p>
                <table cellpadding="3" cellspacing="3">
                    <tr><td>11.00am</td><td>Arrival of Guests-of Honor & Members</td></tr>
                    <tr><td>12.00noon</td><td>Buffet Lunch</td></tr>
                    <tr><td>2.00pm-6.30pm</td><td>Speakers:
                        <br>Prof Larry Lang Xian Ping
                        <br>Yuan Ya Shen
                        <br>Daniel Ang
                    </td></tr>
                    <tr><td>7.30pm</td><td>Gala Celebration Dinner</td></td></tr>
                </table>
                <br>
                <br>
                <strong>Day 3 (Aug 7th)</strong>
                <br>
                <br>
                Free & Easy
                <br>
                <br>
                <strong>Day 4 (Aug 8th)</strong>
                <br>
                <br>
                Departure & Sending off
                <br>
                <br>

                Dressing for Day 1 & 2 is Formal for both Men and Ladies
                <br>
                <br>
                Do make sure that you have the necessary visa to visit Macau SAR, China

            </td>
        </tr>
        </tbody>
    </table>
</form>