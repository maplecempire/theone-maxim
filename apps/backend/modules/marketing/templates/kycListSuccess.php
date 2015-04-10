<?php
use_helper('I18N');
?>
<link rel="stylesheet" href="/css/table.style.css">
<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
	jform = $("#enquiryForm").validate({
		submitHandler: function(form) {
			if(isSubmitAjax){
				//alert("submit ajax");
				datagrid.fnDraw();
			}else {
				//alert("not submit ajax");
				form.submit();
			}
		}
	});

	datagrid = $("#datagrid").r9jasonDataTable({
		// online1DataTable extra params
		"idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
		"extraParam" : function(aoData){ // pass extra params to server
			aoData.push( { "name": "filterDistcode", "value": $("#search_distCode").val()  } );
			aoData.push( { "name": "filterKycStatus", "value": $("#search_kycStatus").val()  } );
            aoData.push( { "name": "filterMt4Userame", "value": $("#search_mt4Username").val() } );
            aoData.push( { "name": "filterFullName", "value": $("#search_fullName").val() } );
            aoData.push( { "name": "filterEmail", "value": $("#search_email").val() } );
            aoData.push( { "name": "filterParentCode", "value": $("#search_parentCode").val() } );
            aoData.push( { "name": "filterStatusCode", "value": $("#search_statusCode").val() } );
            aoData.push( { "name": "filterContact", "value": $("#search_contact").val() } );
		},
		"reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
			reassignDatagridEventAttr();
		},
		
		// datatables params
		"bLengthChange": true,
		"bFilter": false,
		"bProcessing": true,
		"bServerSide": true,
        "bAutoWidth": false,
        "sScrollX": "100%",
        //"sScrollXInner": "150%",
		"sAjaxSource": "<?php echo url_for('marketingList/kycList') ?>",
		"sPaginationType": "full_numbers",
		"aoColumns": [
		              { "sName" : "dist.distributor_id", "bVisible" : false},
		              { "sName" : "dist.distributor_id",  "bSortable": false, "fnRender": function ( oObj ) {
                          var idx = 2;
                          $("#dgAddPanel").data("data_" + oObj.aData[0], {
                                distributor_id : oObj.aData[0]
                                , distributor_code : oObj.aData[idx++]
                                , kyc_status : oObj.aData[idx++]
                                , userpassword : oObj.aData[idx++]
                                , userpassword2 : oObj.aData[idx++]
                                , mt4_user_name : oObj.aData[idx++]
                                , mt4_password : oObj.aData[idx++]
                                , full_name : oObj.aData[idx++]
                                , nickname : oObj.aData[idx++]
                                , ic : oObj.aData[idx++]
                                , country : oObj.aData[idx++]
                                , address : oObj.aData[idx++]
                                , postcode : oObj.aData[idx++]
                                , email : oObj.aData[idx++]
                                , contact : oObj.aData[idx++]
                                , gender : oObj.aData[idx++]
                                , dob : oObj.aData[idx++]
                                , bank_name : oObj.aData[idx++]
                                , bank_acc_no : oObj.aData[idx++]
                                , bank_holder_name : oObj.aData[idx++]
                                , bank_swift_code : oObj.aData[idx++]
                                , visa_debit_card : oObj.aData[idx++]
                                , parent_nickname : oObj.aData[idx++]
                                , status_code : oObj.aData[idx++]
                                , created_on : oObj.aData[idx++]
                                , file_bank_pass_book : oObj.aData[idx++]
                                , file_proof_of_residence : oObj.aData[idx++]
                                , file_nric : oObj.aData[idx++]
                                , leader : oObj.aData[idx++]
                                , remark : oObj.aData[idx++]
                          });
		  				  return "<a id='editLink' href='#' title='KYC'>KYC</a>";
		  				}},
		              { "sName" : "dist.distributor_code",  "bSortable": true},
		              { "sName" : "dist.kyc_status",  "bSortable": true},
		              { "sName" : "tblUser.userpassword",  "bVisible": false},
		              { "sName" : "tblUser.userpassword2",  "bVisible": false},
		              { "sName" : "tblUser.userpassword2",  "bVisible": false},
		              { "sName" : "tblUser.userpassword2",  "bVisible": false},
		              /*{ "sName" : "dist.mt4_user_name",  "bSortable": false},
		              { "sName" : "dist.mt4_password",  "bSortable": false},*/
		              { "sName" : "dist.full_name",  "bSortable": true},
		              { "sName" : "dist.nickname",  "bVisible": false},
		              { "sName" : "dist.ic",  "bVisible": false},
		              { "sName" : "dist.country",  "bSortable": true},
		              { "sName" : "dist.address",  "bSortable": true},
		              { "sName" : "dist.postcode",  "bSortable": true},
		              { "sName" : "dist.email",  "bSortable": true},
		              { "sName" : "dist.contact",  "bSortable": true},
		              { "sName" : "dist.gender",  "bSortable": true},
		              { "sName" : "dist.dob",  "bSortable": true},
		              { "sName" : "dist.bank_name",  "bSortable": true},
		              { "sName" : "dist.bank_acc_no",  "bSortable": true},
		              { "sName" : "dist.bank_holder_name",  "bSortable": true},
		              { "sName" : "dist.bank_swift_code",  "bSortable": true},
		              { "sName" : "dist.visa_debit_card",  "bSortable": true},
		              { "sName" : "dist.upline_dist_code",  "bVisible": false},
		              { "sName" : "dist.status_code",  "bSortable": true},
		              { "sName" : "dist.created_on",  "bSortable": true}
		              , { "sName" : "dist.file_bank_pass_book",  "bSortable": true, "fnRender": function ( oObj ) {
                            if (oObj.aData[26] != "") {
                                return "<a href='<?php echo url_for("/marketing/downloadBankPassBook") ?>?q=" + oObj.aData[0] + "'><img src='/images/common/fileopen.png' alt='view file'></a>";
                            } else {
                                return "";
                            }
                      }}
		              , { "sName" : "dist.file_proof_of_residence",  "bSortable": true, "fnRender": function ( oObj ) {
                            if (oObj.aData[27] != "") {
                                return "<a href='<?php echo url_for("/marketing/downloadProofOfResidence") ?>?q=" + oObj.aData[0] + "'><img src='/images/common/fileopen.png' alt='view file'></a>";
                            } else {
                                return "";
                            }
                      }}
		              , { "sName" : "dist.file_nric",  "bSortable": true, "fnRender": function ( oObj ) {
                            if (oObj.aData[28] != "") {
                                return "<a href='<?php echo url_for("/marketing/downloadNric") ?>?q=" + oObj.aData[0] + "'><img src='/images/common/fileopen.png' alt='view file'></a>";
                            } else {
                                return "";
                            }
                      }}
                , { "sName" : "dist.created_on",  "bVisible": false}
                , { "sName" : "dist.remark",  "bVisible": false}
                , { "sName" : "dist.hide_genealogy",  "bVisible": false}
		]
	});

    $("#btnAdd").button({
        text: true
        , icons: {
            primary: 'ui-icon-circle-plus'
        }
    }).click(function(event){
        event.preventDefault();

        $("#dgAddPanelId").val("");
        $("#dgAddPanel").dialog("open");
    });

    $("#checkboxFullName").click(function(){
        if ($("#checkboxFullName").is(':checked')) {
            $("#dgAddPanelName").attr("readonly", false);
            $("#dgAddPanelName").css("color", "");
        } else {
            $("#dgAddPanelName").attr("readonly", true);
            $("#dgAddPanelName").css("color", "#686868");
        }
    });

    $("#checkboxMemberId").click(function(){
        if ($("#checkboxMemberId").is(':checked')) {
            $("#dgAddPanelDistCode").attr("readonly", false);
            $("#dgAddPanelDistCode").css("color", "");
        } else {
            $("#dgAddPanelDistCode").attr("readonly", true);
            $("#dgAddPanelDistCode").css("color", "#686868");
        }
    });
}); // end $(function())

//all event in detail datagrid need to reassign because, every remote call, the DOM will be restructure again.
function reassignDatagridEventAttr(){
	$("a[id=editLink]").click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");
        $("#dgAddPanelId").val(id);
        $("#dgAddPanel").dialog("open");
	});
	$("a[id=resendPasswordLink]").click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");

        var answer = confirm("Are you sure want to send Password to the member?");
        if (answer){
            waiting();
            $.ajax({
                type : 'POST',
                url : "<?php echo url_for('marketing/doSendMemberPassword') ?>",
                dataType : 'json',
                cache: false,
                data: {
                    distId : id
                },
                success : function(data) {
                    if (data.error) {
                        alert(data.errorMsg);
                    } else {
                        alert("Password send Successfully.");
                    }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Server connection error.");
                }
            });
        }
	});
	$("a[id=resendMt4Link]").click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");
        var answer = confirm("Are you sure want to send MT4 Password to the member?");
        if (answer){
            waiting();
            $.ajax({
                type : 'POST',
                url : "<?php echo url_for('marketing/doSendMemberMT4') ?>",
                dataType : 'json',
                cache: false,
                data: {
                    distId : id
                },
                success : function(data) {
                    if (data.error) {
                        alert(data.errorMsg);
                    } else {
                        alert("Password send Successfully.");
                    }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Server connection error.");
                }
            });
        }
	});
}

</script>

<?php echo form_tag('admin/doLogin', 'id=loginForm') ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
<div class="portlet">
    <div class="portlet-header">KYC Listing</div>
    <div class="portlet-content">
	<table width="100%" border="0">
		<tr>
			<td>
			<table width="100%">
				<tr>
					<td>
                    <div style="width: 1050px">
					<table class="display" id="datagrid" border="0" width="100%">
                        <thead>
                            <tr>
								<th>id [hidden]</th>
                                <th>&nbsp;</th>
								<th>Distributor Code</th>
								<th>KYC Status</th>
								<th>Password</th>
								<th>Security Password</th>
								<th>MT4 ID</th>
								<th>MT4 Password</th>
								<th>Full Name</th>
								<th>Nick Name</th>
								<th>IC</th>
								<th>Country</th>
								<th>Address</th>
								<th>Postcode</th>
								<th>Email</th>
								<th>Contact</th>
								<th>Gender</th>
								<th>DOB</th>
								<th>Bank Name</th>
								<th>Bank Account No.</th>
								<th>Bank Holder Name</th>
								<th>Bank Swift Code</th>
								<th>Visa Debit Card</th>
								<th>Referral</th>
								<th>Status</th>
								<th>Add Date</th>
								<th>Bank Account Proof</th>
								<th>Proof of Residence</th>
								<th>NRIC</th>
								<th>Leader</th>
								<th>Remark</th>
								<th>Hide Genealogy</th>
							</tr>
                            <tr>
                                <td></td>
                                <td></td>
								<td><input title="" size="10" type="text" id="search_distCode" value="" class="search_init"/></td>
								<td>
                                    <select id="search_kycStatus" class="search_init">
                                        <option value="PENDING">PENDING</option>
                                        <option value="APPROVE">APPROVE</option>
                                        <option value="KIV">KIV</option>
                                        <option value="DISAPPROVE">DISAPPROVE</option>
                                        <option value="ALL">ALL</option>
                                    </select>
								<td></td>
                                <td></td>
                                <td><input title="" size="10" type="text" id="search_mt4Username" value="" class="search_init"/></td>
                                <td></td>
                                <td><input title="" size="10" type="text" id="search_fullName" value="" class="search_init"/></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input title="" size="10" type="text" id="search_email" value="" class="search_init"/></td>
                                <td><input title="" size="10" type="text" id="search_contact" value="" class="search_init"/></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input title="" size="10" type="text" id="search_parentCode" value="" class="search_init"/></td>
                                <td><input title="" size="10" type="text" id="search_statusCode" value="" class="search_init"/></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
							</tr>
                        </thead>
                    </table>
                    </div>
                    <div>
                        <button id="btnAdd" style="display: none">Add</button>
                    </div>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
    </div>
</div>
</div>
<script type="text/javascript">
$(function(){
    $("#dgAddPanel").dialog("destroy");
    $("#dgAddPanel").theoneDialog({
        width:700,
        open: function() {
            populateDgAddPanel();
        },
        close: function() {

        },
        buttons: {
            <?php if ($sf_user->hasCredential(array(AP::AL_READONLY), false)) {
            } else {
            ?>

            Approve: function() {
                submitKiv("APPROVE");
            },
            KIV: function() {
                submitKiv("KIV");
            },
            Disapprove: function() {
                submitKiv("DISAPPROVE");
            },
            <?php } ?>
            Close: function() {
                $(this).dialog('close');
            }
        }
    });
});

function submitKiv(statusCode) {
    waiting();
    if ($.trim($('#kycRemark').val()) == "") {
        error("KIY Remark cannot be blank");
    } else {
        $.ajax({
            type : 'POST',
            url : "<?php echo url_for("/marketing/updateKIV"); ?>",
            dataType : 'json',
            cache: false,
            data: {
                distId : $('#dgAddPanelId').val()
                , kycRemark : $('#kycRemark').val()
                , kycStatus : statusCode
            },
            success : function(data) {
                $("#dgAddPanel").dialog('close');
                datagrid.fnDraw();
                alert("Record Save Successfully.");
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Your login attempt was not successful. Please try again.");
            }
        });
    }
}
function populateDgAddPanel() {
    waiting();
    $.ajax({
        type : 'POST',
        url : "<?php echo url_for("/marketing/retrievePersonalProfile"); ?>",
        dataType : 'json',
        cache: false,
        data: {
            distId : $('#dgAddPanelId').val()
        },
        success : function(data) {
            $("#divFileBankPassBook").hide();
            $("#spanFileBankPassBook").hide();
            $("#divProofOfResidence").hide();
            $("#spanProofOfResidence").hide();
            $("#divNric").hide();
            $("#spanNric").hide();

            $("#fullname").val(data.fullName);
            $("#countryId").val(data.country);
            $("#dob").val(data.dob);
            $("#address").val(data.address);
            $("#address2").val(data.address2);
            $("#city").val(data.city);
            $("#state").val(data.state);
            $("#email").val(data.email);
            $("#alt_email").val(data.alternateEmail);
            $("#contactNumber").val(data.contact);
            $("#gender").val(data.gender);
            $("#nomineeName").val(data.nomineeName);
            $("#nomineeRelationship").val(data.nomineeRelationship);
            $("#nomineeIc").val(data.nomineeIc);
            $("#nomineeContactNo").val(data.nomineeContactNo);
            $("#bankName").val(data.bankName);
            $("#bankBranchName").val(data.bankBranchName);
            $("#bankAddress").val(data.bankAddress);
            $("#countryId").val(data.bankCountry);
            $("#bankAccountCurrency").val(data.bankAccountCurrency);
            $("#bankAccNo").val(data.bankAccNo);
            $("#bankHolderName").val(data.bankHolderName);
            $("#bankSwiftCode").val(data.bankSwiftCode);
            $("#bankCode").val(data.bankCode);
            $("#bankCode").val(data.bankCode);
            $("#visaDebitCard").val(data.visaDebitCard);
            $("#iaccountUsername").val(data.iaccountUsername);
            $("#iaccount").val(data.iaccount);

            if (data.fileBankPassBook != "" && data.fileBankPassBook != null) {
                $("#divFileBankPassBook").show();
                $("#anchorFileBankPassBook").attr("href", "/backend.php/marketing/bankPassBook?q=" + $('#dgAddPanelId').val());
            } else {
                $("#spanFileBankPassBook").show();
            }
            if (data.fileProofOfResidence != "" && data.fileProofOfResidence != null) {
                $("#divProofOfResidence").show();
                $("#anchorProofOfResidence").attr("href", "/backend.php/marketing/proofOfResidence?q=" + $('#dgAddPanelId').val());
            } else {
                $("#spanProofOfResidence").show();
            }
            if (data.fileNric != "" && data.fileNric != null) {
                $("#divNric").show();
                $("#anchorNric").attr("href", "/backend.php/marketing/nric?q=" + $('#dgAddPanelId').val());
            } else {
                $("#spanNric").show();
            }
            $("#remark").val(data.remark);
            $("#kycRemark").val(data.kycRemark);
            $("#kycStatus").val(data.kycStatus);
            $.unblockUI();
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
        }
    });
}
</script>
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
            $distDB = new MlmDistributor();
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
</form>