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
                required: "#bankPassBook.length > 0",
                minlength : 3,
                accept:'docx?|pdf|bmp|jpg|jpeg|gif|png|tif|tiff|xls|xlsx'
            },
            "nric" : {
                required: "#bankPassBook.length > 0",
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
            primary: "ui-icon-disk"
        }
    });
    $("#btnUpload").button({
        icons: {
            primary: "ui-icon-circle-arrow-n"
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

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Referrer ID') ?></td>
                    <td><input name="sponsorId" readonly="readonly" id="sponsorId" tabindex="1" size="30"
                               value="<?php echo $sponsor->getDistributorCode() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Referrer Name') ?></td>
                    <td><input name="sponsorName" readonly="readonly" id="sponsorName"
                                             tabindex="2" size="30" value="<?php echo $sponsor->getFullname() ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Full Name') ?></td>
                    <td><input name="fullname" readonly="readonly" type="text" id="fullname" tabindex="5"
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
                        <input name="address" type="text" id="address" tabindex="13" size="30"
                                             value="<?php echo $distDB->getAddress() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Address') ?> 2</td>
                    <td>
                        <input name="address2" type="text" id="address2" tabindex="13" size="30"
                                             value="<?php echo $distDB->getAddress2() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('City / Town') ?></td>
                    <td>
                        <input name="city" type="text" id="city" tabindex="13" size="30"
                                             value="<?php echo $distDB->getCity() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('State / Province') ?></td>
                    <td>
                        <input name="state" type="text" id="state" tabindex="13" size="30"
                                             value="<?php echo $distDB->getState() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Zip / Postal Code') ?></td>
                    <td>
                        <input name="zip" type="text" id="zip" tabindex="13" size="30"
                                             value="<?php echo $distDB->getPostcode() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Email') ?></td>
                    <td>
                        <input name="email" type="text" id="email" tabindex="13" size="30"
                                             value="<?php echo $distDB->getEmail() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Alternate Email') ?></td>
                    <td>
                        <input name="alt_email" type="text" id="alt_email" tabindex="13" size="30"
                                             value="<?php echo $distDB->getAlternateEmail() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Contact Number') ?></td>
                    <td>
                        <input name="contactNumber" type="text" id="contactNumber" tabindex="13" size="30"
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
                        <button id="btnUpdate">Update</button>
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
                    <th colspan="2"><?php echo __('Upload Bank Pass Book, Proof of Residence and Passport/Photo ID') ?></th>
                    <!--<th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Bank Pass Book') ?>
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
                        Note: Maximum upload size per file is 5 MB. Only pdf / bmp / jpg / jpeg / gif / png / tif / tiff / doc / docx / xls / xlsx formats are accepted.
                        </font>
                    </td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnUpload">Upload</button>
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