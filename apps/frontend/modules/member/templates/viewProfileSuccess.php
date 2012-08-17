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

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <div class="sidenavi">
        <ul>
            <li><a href="/member/viewProfile"><span><?php echo __('Account Information'); ?></span></a></li>
            <li><a href="/member/viewBankInformation"><span><?php echo __('Bank Account Information'); ?></span></a></li>
            <li><a href="/member/loginPassword"><span><?php echo __('Change Password'); ?></span></a></li>
            <li><a href="/member/transactionPassword"><span><?php echo __('Change Security Password'); ?></span></a></li>
        </ul>
    </div>

    <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="resultsWrap">
        <form id="registerForm" method="post" action="/member/updateProfile">
            <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                   align="center">
                <caption><?php echo __('Account Information') ?></caption>
                <tr>
                    <td colspan=2 align='center'>
                        <?php if ($sf_flash->has('successMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;"
                                         class="ui-icon ui-icon-info"></span>
                                    <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" width="650px" style="margin:0 auto">
                            <tr>
                                <td width="200px" class="caption"><span id="Label4"><strong><?php echo __('Referrer ID') ?></strong></span>
                                </td>
                                <td class="value">
                                    <input name="sponsorId" readonly="readonly" id="sponsorId" tabindex="1" size="30"
                                           value="<?php echo $sponsor->getDistributorCode() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption"><span id="Label25"><strong><?php echo __('Referrer Name') ?></strong></span></td>
                                <td class="value"><input name="sponsorName" readonly="readonly" id="sponsorName"
                                                         tabindex="2" size="30" value="<?php echo $sponsor->getFullname() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption"><span id="Label13"><strong><?php echo __('Full Name') ?></strong></span></td>
                                <td class="value"><input name="fullname" readonly="readonly" type="text" id="fullname" tabindex="5"
                                                         size="30" value="<?php echo $distDB->getFullName() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Country') ?></strong></span></td>
                                <td class="value">
                                    <?php include_component('component', 'countrySelectOption', array('countrySelected' => $distDB->getCountry(), 'countryName' => 'country', 'countryId' => 'country')) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Date of Birth') ?></strong></span></td>
                                <td class="value">
                                    <select id="dob_year"></select>
                                    <select id="dob_month"></select>
                                    <select id="dob_day"></select>
                                    <input name="dob" readonly="readonly" value="<?php echo $distDB->getDob() ?>" type="hidden" id="dob" class="bp_05"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Address') ?></strong></span></td>
                                <td class="value"><input name="address" type="text" id="address" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getAddress() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Address') ?> 2</strong></span></td>
                                <td class="value"><input name="address2" type="text" id="address2" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getAddress2() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('City / Town') ?></strong></span></td>
                                <td class="value"><input name="city" type="text" id="city" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getCity() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('State / Province') ?></strong></span></td>
                                <td class="value"><input name="state" type="text" id="state" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getState() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Zip / Postal Code') ?></strong></span></td>
                                <td class="value"><input name="zip" type="text" id="zip" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getPostcode() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Email') ?></strong></span></td>
                                <td class="value"><input name="email" type="text" id="email" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getEmail() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Alternate Email') ?></strong></span></td>
                                <td class="value"><input name="alt_email" type="text" id="alt_email" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getAlternateEmail() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Contact Number') ?></strong></span></td>
                                <td class="value"><input name="contactNumber" type="text" id="contactNumber" tabindex="13" size="30"
                                                         value="<?php echo $distDB->getContact() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Gender') ?></strong></span></td>
                                <td class="value">
                                    <table id="RadioButtonListSex" border="0">
                                        <tr>
                                            <td>
                                                <input id="rdoGender_0" type="radio" name="gender" value="M"
                                                       <?php
                                                            if ($distDB->getGender() == "M")
                                                                echo " checked='checked'";
                                                        ?>
                                                       /><label for="rdoGender_0"><font>
                                                <?php echo __('Male') ?></font></label>
                                            </td>
                                            <td><input id="rdoGender_1" type="radio" name="gender" value="F"
                                                    <?php
                                                        if ($distDB->getGender() == "F")
                                                            echo " checked='checked'";
                                                    ?>
                                                    /><label
                                                    for="rdoGender_1"><font><?php echo __('Female') ?></font></label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <button id="btnUpdate">Update</button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
        <div class="clear"></div>
        <form id="uploadForm" method="post" action="/member/doUploadFile" enctype="multipart/form-data">
            <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                   align="center">
                <caption><?php echo __('Upload Bank Pass Book, Proof of Residence and Passport/IC') ?></caption>
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" width="650px" style="margin:0 auto">
                            <tr>
                                <td class="caption"><span id="Label26"><strong><?php echo __('Bank Pass Book') ?></strong></span></td>
                                <td class="value">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background: none repeat scroll 0 0 #E9E9E9;">
                                                <?php echo input_file_tag('bankPassBook', array("id" => "bankPassBook", "name" => "bankPassBook")); ?>
                                            </td>
                                            <td style="background: none repeat scroll 0 0 #E9E9E9;">
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
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption"><span id="Label27"><strong><?php echo __('Proof of Residence') ?></strong></span></td>
                                <td class="value">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background: none repeat scroll 0 0 #E9E9E9;">
                                                <?php echo input_file_tag('proofOfResidence', array("id" => "proofOfResidence", "name" => "proofOfResidence")); ?>
                                            </td>
                                            <td style="background: none repeat scroll 0 0 #E9E9E9;">
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
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption"><span id="Label28"><strong><?php echo __('Passport/IC') ?></strong></span></td>
                                <td class="value">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background: none repeat scroll 0 0 #E9E9E9;">
                                                <?php echo input_file_tag('nric', array("id" => "nric", "name" => "nric")); ?>
                                            </td>
                                            <td style="background: none repeat scroll 0 0 #E9E9E9;">
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
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <font color="#dc143c">
                                    Note: Maximum upload size per file is 5 MB. Only pdf / bmp / jpg / jpeg / gif / png / tif / tiff / doc / docx / xls / xlsx formats are accepted.
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <button id="btnUpload">Upload</button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>