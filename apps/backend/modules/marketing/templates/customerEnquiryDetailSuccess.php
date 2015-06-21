<?php
// auto-generated by sfPropelCrud
// date: 2012/04/20 19:13:40
?>
<?php use_helper('Object') ?>
<?php use_helper('I18N') ?>
<!-- TinyMCE -->
<link rel="stylesheet" href="/css/table.style.css">
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
$(function() {
    $("#btnSave").button({
            icons: {
                primary: "ui-icon-circle-check"
            }
        });
    $("#btnOpen").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    }).click(function(event){
       event.preventDefault();
       $.ajax({
            type : 'POST',
            url : "<?php echo url_for("/marketing/doUpdateHideGenealogy"); ?>",
            dataType : 'json',
            cache: false,
            data: {
                distId : "<?php echo $mlmCustomerEnquiry->getDistributorId(); ?>"
                , toHideGenealogy : "N"
            },
            success : function(data) {
                alert("Update Successful");
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Your login attempt was not successful. Please try again.");
            }
        });
    });
    $("#btnClose").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    }).click(function(event){
       event.preventDefault();
       $.ajax({
            type : 'POST',
            url : "<?php echo url_for("/marketing/doUpdateHideGenealogy"); ?>",
            dataType : 'json',
            cache: false,
            data: {
                distId : "<?php echo $mlmCustomerEnquiry->getDistributorId(); ?>"
                , toHideGenealogy : "Y"
            },
            success : function(data) {
                alert("Update Successful");
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Your login attempt was not successful. Please try again.");
            }
        });
    });
});
</script>

<script type="text/javascript" language="javascript">
$(function() {
    $("#csForm").validate({
        messages : {
            transactionPassword: {
                remote: "Security Password is not valid."
            }
        },
        rules : {
            "transactionPassword" : {
                required : true
                , remote: "/member/verifyTransactionPassword"
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        }
    });

    $("a[id=editLink]").click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");
        $("#dgAddPanelId").val(id);
        $("#dgAddPanel").dialog("open");
	});

    $("#dgAddPanel").dialog("destroy");
    $("#dgAddPanel").theoneDialog({
        width:700,
        open: function() {
        },
        close: function() {

        },
        buttons: {

            Close: function() {
                $(this).dialog('close');
            }
        }
    });
});

tinyMCE.init({
    // General options
    mode : "exact",
    elements : "message",
    theme : "simple",
    width: "100%"
});
</script>

<?php echo form_tag('marketing/doCustomerEnquiryDetail') ?>
<input type="hidden" name="enquiryId" value="<?php echo $mlmCustomerEnquiry->getEnquiryId(); ?>">
<div style="padding: 10px; top: 10px; width: 98%">
    <div class="portlet">
        <div class="portlet-header">Customer Enquiry</div>
        <div class="portlet-content" style="width: 98%">
            <?php $distributorDB = MlmDistributorPeer::retrieveByPK($mlmCustomerEnquiry->getDistributorId());
            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $mlmCustomerEnquiry->getDistributorId());
            $mlmDistMt4s = MlmDistMt4Peer::doSelect($c);
            ?>
            <h3>Title: <?php echo $mlmCustomerEnquiry->getTitle(); ?></h3>
            <h3>Contact No: <?php echo $mlmCustomerEnquiry->getContactNo(); ?></h3>
            <h3>Leader: <?php
                $leaderArrs = explode(",", Globals::GROUP_LEADER);
                $leader = "";
                for ($i = 0; $i < count($leaderArrs); $i++) {
                    $pos = strrpos($distributorDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $distLeader = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                        if ($distLeader) {
                            $leader = $distLeader->getDistributorCode();
                        }
                        break;
                    }
                }
                echo $leader; ?></h3>
            <h3>MT4: <?php
                foreach ($mlmDistMt4s as $mlmDistMt4) {
                    echo $mlmDistMt4->getMt4UserName()."@".$mlmDistMt4->getMt4Password(). "<br>";
                }
             ?></h3>
            <h3>From ABFX: <?php echo $distributorDB->getFromAbfx(); ?></h3>
            <h3><a id='editLink' href='#' title='Member Details'>Member Details</a></h3>

            <table class="sf_admin_list" cellpadding="3" width="100%">
                <tr>
                    <td colspan="2">
                        <?php if ($sf_flash->has('successMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-highlight ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
                                    <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($sf_flash->has('errorMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-error ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
                                    <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                foreach ($mlmCustomerEnquiryDetails as $mlmCustomerEnquiryDetail) {
                    if ($mlmCustomerEnquiryDetail->getReplyFrom() == "ADMIN")
                        $class = "color: #0088CF";
                    else
                        $class = "";
                ?>
                <tr style="<?php echo $class;?>">
                    <td class="caption" style="width: 20%">
                        <?php
                            if ($mlmCustomerEnquiryDetail->getReplyFrom() == "ADMIN")
                                echo $mlmCustomerEnquiryDetail->getReplyFrom();
                            else
                                echo $distributorDB->getDistributorCode();
                        ?>
                    </td>
                    <td class="value" style="width: 45%">
                        <?php echo $mlmCustomerEnquiryDetail->getMessage();?>
                    </td>
                </tr>
                <?php } ?>
                <tr class="tbl_form_row_even">
                    <td>
                        <?php echo __('Message') ?>
                    </td>
                    <td>
                        <textarea rows="3" cols="3" id="message" name="message"><?php echo $message; ?></textarea>
                    </td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>
                        <?php echo __('Category') ?>
                    </td>
                    <td>
                        <?php
	                        $arr = array();
	                        $arr['Genealogy'] = 'Genealogy';
	                        $arr['User Profile/Credentials'] = 'User Profile/Credentials';
	                        $arr['Deposit/CP Points'] = 'Deposit/CP Points';
	                        $arr['Investment Returns/Bonuses'] = 'Investment Returns/Bonuses';
	                        $arr['MT4 Withdrawal/Reload/Trading'] = 'MT4 Withdrawal/Reload/Trading';
	                        $arr['Withdrawal Issues'] = 'Withdrawal Issues';
	                        $arr['Contract Maturity'] = 'Contract Maturity';
	                        $arr['Maxim Visa Card'] = 'Maxim Visa Card';
	                        $arr['Events/Promotions'] = 'Events/Promotions';	                        
	                        $arr['Decline Auto Swap'] = 'Decline Auto Swap';
	                        $arr['Others'] = 'Others';
	                        echo select_tag('category', options_for_select($arr, $mlmCustomerEnquiry->getCategory()));
	                     ?>
                    </td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>
                        <?php echo __('Status') ?>
                    </td>
                    <td>
                        <?php
	                        $arr = array();
	                        $arr['PENDING'] = 'PENDING';
	                        $arr['PROCESSING'] = 'PROCESSING';
	                        $arr['SOLVED'] = 'SOLVED';
	                        echo select_tag('status_code', options_for_select($arr, $mlmCustomerEnquiry->getStatusCode()));
	                     ?>
                    </td>
                </tr>
            </table>
            <hr/>
            <button id="btnSave">Save</button>
            <button id="btnOpen">Open Genealogy</button>
            <button id="btnClose">Close Genealogy</button>
        </div>
    </div>
</div>
</form>

<div id="dgAddPanel" style="display:none; width: 850px" title="Member Details">
    <input type="hidden" id="dgAddPanelId">
    <table width="100%">
        <tr>
            <td colspan="3">
                <div class="ui-widget" id="dgMsg" style="display:none;">
                </div>
            </td>
        </tr>
    </table>
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
            <td><?php echo __('Full Name') ?></td>
            <td><input name="fullname" readonly="readonly" type="text" id="fullname" tabindexBak="5"
                                     size="30" value="<?php
            $distDB = $distributorDB;
            echo $distDB->getFullName() ?>"/>
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
            <td><input name="dob" value="<?php echo $distDB->getDob() ?>" type="text" id="dob" class="bp_05"/></td>
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
                <select id="gender">
                    <option value=""></option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
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
            <td><?php echo __('Country') ?></td>
            <td><?php include_component('component', 'countrySelectOption', array('countrySelected' => $distDB->getBankCountry(), 'countryName' => 'bankCountry', 'countryId' => 'bankCountry')) ?></td>
            <td>&nbsp;</td>
        </tr>

        <tr class="tbl_form_row_odd">
            <td>&nbsp;</td>
            <td><?php echo __('Currency') ?></td>
            <td><input name="bankAccountCurrency" type="text" id="bankAccountCurrency" size="30"
                                                 value="<?php echo $distDB->getBankAccountCurrency() ?>"/>
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
            <td><?php echo __('Bank Code') ?></td>
            <td><input name="bankCode" type="text" id="bankCode" size="30"
                                                 value="<?php echo $distDB->getBankCode() ?>"/>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr class="tbl_form_row_even">
            <td>&nbsp;</td>
            <td><?php echo __('Maxim Trader VISA Debit Card') ?></td>
            <td>
                <input name="visaDebitCard" type="text" id="visaDebitCard" size="30" maxlength="16"
                                                 value="<?php echo $distDB->getVisaDebitCard() ?>"/>
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
        <tr>
            <th class="tbl_header_left">
                <div class="border_left_grey">&nbsp;</div>
            </th>
            <th><?php echo __('i-Account Details') ?></th>
            <th class="tbl_content_right"></th>
            <th class="tbl_header_right">
                <div class="border_right_grey">&nbsp;</div>
            </th>
        </tr>

        <tr class="tbl_form_row_odd">
            <td>&nbsp;</td>
            <td><?php echo __('Account Name') ?></td>
            <td>
                <input name="iaccountUsername" type="text" id="iaccountUsername" size="30"
                                                 value="<?php echo $distDB->getIaccountUsername() ?>"/>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr class="tbl_form_row_even">
            <td>&nbsp;</td>
            <td><?php echo __('Account Number') ?></td>
            <td>
                <input name="iaccount" type="text" id="iaccount" size="30" maxlength="16"
                                                 value="<?php echo $distDB->getIaccount() ?>"/>
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
                <div id="divFileBankPassBook">
                    <a href="<?php echo url_for("/download/bankPassBook?q=".rand()) ?>" id="anchorFileBankPassBook">
                        <img src="/images/common/fileopen.png" alt="view file">
                    </a>
                </div>

                <span style="color: red;" id="spanFileBankPassBook">Not uploaded</span>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr class="tbl_form_row_even">
            <td>&nbsp;</td>
            <td>
                <?php echo __('Proof of Residence') ?>
            </td>
            <td>
                <div id="divProofOfResidence">
                <a href="<?php echo url_for("/download/proofOfResidence?q=".rand()) ?>" id="anchorProofOfResidence">
                    <img src="/images/common/fileopen.png" alt="view file">
                </a>
                </div>

                <span style="color: red;" id="spanProofOfResidence">Not uploaded</span>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr class="tbl_form_row_odd">
            <td>&nbsp;</td>
            <td>
                <?php echo __('Passport/Photo ID') ?>
            </td>
            <td>
                <div id="divNric">
                <a href="<?php echo url_for("/marketing/nric?q=".rand()) ?>" id="anchorNric">
                    <img src="/images/common/fileopen.png" alt="view file">
                </a>
                </div>

                <span style="color: red;" id="spanNric">Not uploaded</span>
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
        <tr>
            <th class="tbl_header_left">
                <div class="border_left_grey">&nbsp;</div>
            </th>
            <th colspan="2"><?php echo __('Internal Remark') ?></th>
            <!--<th class="tbl_content_right"></th>-->
            <th class="tbl_header_right">
                <div class="border_right_grey">&nbsp;</div>
            </th>
        </tr>

        <tr class="tbl_form_row_odd">
            <td>&nbsp;</td>
            <td><?php echo __('Internal Remark') ?></td>
            <td>
                <textarea id="remark" rows="3" cols="50"></textarea>
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
        <tr>
            <th class="tbl_header_left">
                <div class="border_left_grey">&nbsp;</div>
            </th>
            <th colspan="2"><?php echo __('KYC Remark') ?></th>
            <!--<th class="tbl_content_right"></th>-->
            <th class="tbl_header_right">
                <div class="border_right_grey">&nbsp;</div>
            </th>
        </tr>

        <tr class="tbl_form_row_odd">
            <td>&nbsp;</td>
            <td><?php echo __('KYC Status') ?></td>
            <td>
                <input name="kycStatus" type="text" id="kycStatus" size="30" maxlength="16"/>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr class="tbl_form_row_odd">
            <td>&nbsp;</td>
            <td><?php echo __('KYC Remark') ?>&nbsp;<span style="color: red">**</span></td>
            <td>
                <textarea id="kycRemark" rows="3" cols="50"></textarea>
            </td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>
</div>
