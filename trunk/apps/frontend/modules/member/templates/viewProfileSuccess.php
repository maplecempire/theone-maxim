<?php include('scripts.php'); ?>
<script>
$(function() {
    $.populateDOB({
        dobYear : $("#dob_year")
        ,dobMonth : $("#dob_month")
        ,dobDay : $("#dob_day")
        ,dobFull : $("#dob")
        ,defaultValue : $("#dob").val()
    });

    $("#registerForm").validate({
        rules : {
            /*"fullname" : {
                required : true,
                minlength : 2
            },*/
            "ic" : {
                required : true,
                minlength : 3
            },
            "address" : {
                required : true,
                minlength : 3
            },
            "postcode" : {
                required : true,
                minlength : 3
            },
            "email" : {
                required : true
                , email: true
            },
            "contactNumber" : {
                required : true
                , minlength : 10
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
    $("#uploadForm").validate({
        rules : {
            "bankPassBook" : {
                required: "#bankPassBook.length > 0",
                minlength : 3,
                accept:'docx?|pdf|bmp|jpg|jpeg|gif|png|tif|tiff|xls|xlsx'
            },
            "proofOfResidence" : {
                required: "#proofOfResidence.length > 0",
                minlength : 3,
                accept:'docx?|pdf|bmp|jpg|jpeg|gif|png|tif|tiff|xls|xlsx'
            },
            "nric" : {
                required: "#nric.length > 0",
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
    $("#btnUpdate").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    });
    $("#btnUpload").button({
        icons: {
            primary: "ui-icon-circle-arrow-n"
        }
    });

    jQuery.validator.addMethod("latinRegex", function(value, element) {
        return this.optional(element) || /[a-zA-Z\-\'\ ]/i.test(value);
    }, "This field only accept latin word, numbers, or dashes.");

    $("#bankForm").validate({
        messages : {
            transactionPassword: {
                remote: "<?php echo __("Security Password is not valid")?>"
            }
        },
        rules : {
            "bankName" : {
                required : true,
                minlength : 3
            },
            "bankAccNo" : {
                required : true,
                minlength : 3
            },
            "bankHolderName" : {
                required : true,
                minlength : 3
            },
            "bankAddress" : {
                required : true
                <?php
                if ($distDB->getCountry() == "China (PRC)" || $distDB->getCountry() == "Taiwan") {

                } else {
                ?>
                , latinRegex: true
                <?php } ?>
            },
            "bankBranchName" : {
                required : true
                <?php
                if ($distDB->getCountry() == "China (PRC)" || $distDB->getCountry() == "Taiwan") {

                } else {
                ?>
                , latinRegex: true
                <?php } ?>
            },
            "transactionPassword" : {
                required : true,
                remote: "/member/verifyTransactionPassword"
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
    $("#moneyTracForm").validate({
        messages : {
            transactionPassword: {
                remote: "<?php echo __("Security Password is not valid")?>"
            }
        },
        rules : {
            "moneyTracUsername" : {
                required : true
            },
            "moneyTracCustomerId" : {
                required : true
            },
            "transactionPassword" : {
                required : true,
                remote: "/member/verifyTransactionPassword"
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

    $("#btnBankUpdate").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    });
    $("#btnMoneyTrac").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    });

    $("#passwordForm").validate({
        messages : {
            newPassword2: {
                equalTo: "Please enter the same password as above"
            }
        },
        rules : {
            "oldPassword" : {
                required : true,
                minlength : 3
            },
            "newPassword" : {
                required : true,
                minlength : 3
            },
            "newPassword2" : {
                required : true,
                minlength : 3,
                equalTo: "#newPassword"
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        }
    });

    $("#btnPasswordUpdate").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    });

    $("#btnBeneficiaryUpdate").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    });

    $("#securityPasswordForm").validate({
        messages : {
            newSecurityPassword2: {
                equalTo: "Please enter the same password as above"
            }
        },
        rules : {
            "oldSecurityPassword" : {
                required : true,
                minlength : 3
            },
            "newSecurityPassword" : {
                required : true,
                minlength : 3
            },
            "newSecurityPassword2" : {
                required : true,
                minlength : 3,
                equalTo: "#newSecurityPassword"
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        }
    });
    $("#btnSecurityUpdate").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    });
});
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Personal Information') ?></span></td>
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
            <form id="registerForm" method="post" action="/member/updateProfile">
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
                    <th><?php echo __('Personal Detail') ?></th>
                    <th class="tbl_content_right"></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <!--<tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Referrer ID') */?></td>
                    <td><input name="sponsorId" readonly="readonly" id="sponsorId" tabindexBak="1" size="30"
                               value="<?php /*echo $sponsor->getDistributorCode() */?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Referrer Name') */?></td>
                    <td><input name="sponsorName" readonly="readonly" id="sponsorName"
                                             tabindexBak="2" size="30" value="<?php /*echo $sponsor->getFullname() */?>"/></td>
                    <td>&nbsp;</td>
                </tr>-->

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Full Name') ?></td>
                    <td><input name="fullname" readonly="readonly" type="text" id="fullname" tabindexBak="5"
                                             size="30" value="<?php echo $distDB->getFullName() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Country') ?></td>
                    <td><?php include_component('component', 'countrySelectOption', array('countrySelected' => $distDB->getCountry(), 'countryName' => 'country', 'countryId' => 'country')) ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Date of Birth') ?></td>
                    <td><select id="dob_year"></select>
                        <select id="dob_month"></select>
                        <select id="dob_day"></select>
                        <input name="dob" readonly="readonly" value="<?php echo $distDB->getDob() ?>" type="hidden" id="dob" class="bp_05"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Address') ?></td>
                    <td>
                        <input name="address" type="text" id="address" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getAddress() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td>
                        <input name="address2" type="text" id="address2" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getAddress2() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('City / Town') ?></td>
                    <td>
                        <input name="city" type="text" id="city" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getCity() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('State / Province') ?></td>
                    <td>
                        <input name="state" type="text" id="state" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getState() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Zip / Postal Code') ?></td>
                    <td>
                        <input name="zip" type="text" id="zip" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getPostcode() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Email') ?></td>
                    <td>
                        <input name="email" type="text" id="email" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getEmail() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Alternate Email') ?></td>
                    <td>
                        <input name="alt_email" type="text" id="alt_email" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getAlternateEmail() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Contact Number') ?></td>
                    <td>
                        <input name="contactNumber" type="text" id="contactNumber" tabindexBak="13" size="30"
                                             value="<?php echo $distDB->getContact() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Gender') ?></td>
                    <td>
                        <input id="rdoGender_0" type="radio" name="gender" value="M"
                               <?php
                                    if ($distDB->getGender() == "M")
                                        echo " checked='checked'";
                                ?>
                               /><label for="rdoGender_0"><font>
                        <?php echo __('Male') ?></font></label>
                        &nbsp;&nbsp;
                        <input id="rdoGender_1" type="radio" name="gender" value="F"
                        <?php
                            if ($distDB->getGender() == "F")
                                echo " checked='checked'";
                        ?>
                        /><label
                        for="rdoGender_1"><font><?php echo __('Female') ?></font></label>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnUpdate"><?php echo __('Update') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            </form>
            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <form action="/member/updateBeneficiary" id="updateBeneficiaryForm" method="post">
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
                    <th><?php echo __('Beneficiary Nominee') ?></th>
                    <th></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>


                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Name') ?></td>
                    <td>
                        <input type="text" class="inputbox" id="nomineeName" name="nomineeName" value="<?php echo $distDB->getNomineeName() ?>">
                        &nbsp;
                    </td>
                    <td>&nbsp;</td>
                </tr>


                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Relationship') ?></td>
                    <td>
                        <input type="text" class="inputbox" id="nomineeRelationship" name="nomineeRelationship" value="<?php echo $distDB->getNomineeRelationship() ?>">
                        &nbsp;
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('IC./Passport No.') ?></td>
                    <td>
                        <input type="text" class="inputbox" id="nomineeIc" name="nomineeIc" value="<?php echo $distDB->getNomineeIc() ?>">
                        &nbsp;
                    </td>
                    <td>&nbsp;</td>
                </tr>


                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Contact No.') ?></td>
                    <td>
                        <input type="text" class="inputbox" id="nomineeContactNo" name="nomineeContactNo" value="<?php echo $distDB->getNomineeContactNo() ?>">
                        &nbsp;
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnBeneficiaryUpdate"><?php echo __('Update') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            </form>
            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
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
                    <th><?php echo __('Affiliate Setting') ?></th>
                    <th></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>


                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Affiliate Link') ?></td>
                    <td>
                        <input type="text" class="inputbox" id="affiliateLink" size="40" name="affiliateLink" value="<?php echo "http://partner.maximtrader.com/a/".$distDB->getDistributorCode() ?>">
                        &nbsp;
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <form action="/member/loginPassword" id="passwordForm" method="post">
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
                    <th colspan="2"><?php echo __('Change Account login Password') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Old Login Password'); ?></td>
                    <td><input name="oldPassword" type="password" id="oldPassword" tabindexBak="1"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('New Login Password') ?></td>
                    <td><input name="newPassword" type="password" id="newPassword" tabindexBak="2"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Re-enter Login Password'); ?></td>
                    <td><input name="newPassword2" type="password" id="newPassword2" tabindexBak="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnPasswordUpdate"><?php echo __('Update') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <form action="/member/transactionPassword" id="securityPasswordForm" method="post">
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
                    <th colspan="2"><?php echo __('Change Security Password') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Old Security Password'); ?></td>
                    <td>
                        <input name="oldSecurityPassword" type="password" id="oldSecurityPassword" tabindexBak="1" />
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('New Security Password') ?></td>
                    <td>
                        <input name="newSecurityPassword" type="password" id="newSecurityPassword" tabindexBak="2" />
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Re-enter Security Password'); ?></td>
                    <td>
                        <input name="newSecurityPassword2" type="password" id="newSecurityPassword2" tabindexBak="3" />
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnSecurityUpdate"><?php echo __('Update') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <form id="bankForm" method="post" action="/member/updateBankInformation">
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
                    <th><?php echo __('Bank Account Details') ?></th>
                    <th class="tbl_content_right"></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Name') ?></td>
                    <td><input name="bankName" type="text" id="bankName"
                             size="30" value="<?php echo $distDB->getBankName() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Branch') ?></td>
                    <td><input name="bankBranchName" type="text" id="bankBranchName" size="30"
                                                         value="<?php echo $distDB->getBankBranchName() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Address') ?></td>
                    <td><input name="bankAddress" type="text" id="bankAddress" size="30"
                                                         value="<?php echo $distDB->getBankAddress() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Account Number') ?></td>
                    <td><input name="bankAccNo" type="text" id="bankAccNo" size="30"
                                                         value="<?php echo $distDB->getBankAccNo() ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <!--<tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Re-Confirm Bank Account Number') */?></td>
                    <td><input name="rebankAccNo" type="text" id="rebankAccNo" size="30"
                                                         value=""/>
                    </td>
                    <td>&nbsp;</td>
                </tr>-->

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Account Holder Name') ?></td>
                    <td><input name="bankHolderName" type="text" id="bankHolderName" size="30"
                                                         value="<?php echo $distDB->getBankHolderName() ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Swift Code / ABA') ?></td>
                    <td><input name="bankSwiftCode" type="text" id="bankSwiftCode" size="30"
                                                         value="<?php echo $distDB->getBankSwiftCode() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Maxim Trader VISA Debit Card') ?></td>
                    <td>
                        <input name="visaDebitCard" type="text" id="visaDebitCard" size="30" maxlength="16"
                                                         value="<?php echo $distDB->getVisaDebitCard() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <!--<tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('EZY Account ID') */?></td>
                    <td>
                        <input name="ezyCashCard" type="text" id="ezyCashCard" size="30" maxlength="16"
                                                         value="<?php /*echo $distDB->getEzyCashCard() */?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>-->

                <!--<tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Chinatrust Bank Visa Debit Card') */?></td>
                    <td>
                        <input name="visaDebitCard" type="text" id="visaDebitCard" size="30" maxlength="16"
                                                         value="<?php /*echo $distDB->getVisaDebitCard() */?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Re-Confirm Chinatrust Bank Visa Debit Card') */?></td>
                    <td>
                        <input name="revisaDebitCard" type="text" id="revisaDebitCard" size="30" maxlength="16"
                                                         value=""/>
                    </td>
                    <td>&nbsp;</td>
                </tr>-->

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password') ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword" size="30"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnBankUpdate"><?php echo __('Update') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <form id="moneyTracForm" method="post" action="/member/updateMoneyTrac">
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
                    <th><?php echo __('Money Trac Details') ?></th>
                    <th class="tbl_content_right"></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('MoneyTrac Username') ?></td>
                    <td>
                        <input name="moneyTracUsername" type="text" id="moneyTracUsername" size="30"
                                                         value="<?php echo $distDB->getMoneytracUsername() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('MoneyTrac Account Number') ?></td>
                    <td>
                        <input name="moneyTracCustomerId" type="text" id="moneyTracCustomerId" size="30"
                                                         value="<?php echo $distDB->getMoneytracCustomerId() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password') ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="mtTransactionPassword" size="30"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnMoneyTrac"><?php echo __('Update') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <form id="uploadForm" method="post" action="/member/doUploadFile" enctype="multipart/form-data">
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
                    <th colspan="2"><?php echo __('Upload Bank Account Proof, Proof of Residence and Passport/Photo ID') ?></th>
                    <!--<th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Bank Account Proof') ?>
                    </td>
                    <td>
                        <?php echo input_file_tag('bankPassBook', array("id" => "bankPassBook", "name" => "bankPassBook")); ?>
                        <?php
                        if ($distDB->getFileBankPassBook() != "") {
                        ?>
                            <a href="<?php echo url_for("/download/bankPassBook?q=".rand()) ?>">
                                <img src="/images/common/fileopen.png" alt="view file">
                            </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Proof of Residence') ?>
                    </td>
                    <td>
                        <?php echo input_file_tag('proofOfResidence', array("id" => "proofOfResidence", "name" => "proofOfResidence")); ?>
                        <?php
                        if ($distDB->getFileProofOfResidence() != "") {
                        ?>
                            <a href="<?php echo url_for("/download/proofOfResidence?q=".rand()) ?>">
                                <img src="/images/common/fileopen.png" alt="view file">
                            </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Passport/Photo ID') ?>
                    </td>
                    <td>
                        <?php echo input_file_tag('nric', array("id" => "nric", "name" => "nric")); ?>
                        <?php
                        if ($distDB->getFileNric() != "") {
                        ?>
                            <a href="<?php echo url_for("/download/nric?q=".rand()) ?>">
                                <img src="/images/common/fileopen.png" alt="view file">
                            </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td colspan="5">
                        <font color="#dc143c">
                        <?php echo __('Note: Maximum upload size per file is 5 MB. Only pdf / bmp / jpg / jpeg / gif / png / tif / tiff / doc / docx / xls / xlsx formats are accepted.') ?>
                        </font>
                    </td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnUpload"><?php echo __('Update') ?></button>
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