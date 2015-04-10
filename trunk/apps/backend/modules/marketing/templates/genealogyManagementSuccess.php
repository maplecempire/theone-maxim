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
            aoData.push( { "name": "filterFullName", "value": $("#search_fullName").val() } );
            aoData.push( { "name": "filterEmail", "value": $("#search_email").val() } );
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
                                , rank_code : oObj.aData[idx++]
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
                                , hide_genealogy : oObj.aData[idx++]
                          });
		  				  return "<a id='transferEpointLink' href='#' title='Action'>Action</a>";
		  				}},
		              { "sName" : "dist.distributor_code",  "bSortable": true},
		              { "sName" : "dist.rank_code",  "bVisible": false},
		              { "sName" : "tblUser.userpassword",  "bVisible": false},
		              { "sName" : "tblUser.userpassword2",  "bVisible": false},
		              { "sName" : "tblUser.userpassword2",  "bVisible": false},
		              { "sName" : "tblUser.userpassword2",  "bVisible": false},
		              /*{ "sName" : "dist.mt4_user_name",  "bSortable": true},
		              { "sName" : "dist.mt4_password",  "bSortable": true},*/
		              { "sName" : "dist.full_name",  "bSortable": true},
		              { "sName" : "dist.nickname",  "bVisible": false},
		              { "sName" : "dist.ic",  "bVisible": false},
		              { "sName" : "dist.country",  "bVisible": false},
		              { "sName" : "dist.address",  "bVisible": false},
		              { "sName" : "dist.postcode",  "bVisible": false},
		              { "sName" : "dist.email",  "bVisible": true},
		              { "sName" : "dist.contact",  "bVisible": false},
		              { "sName" : "dist.gender",  "bVisible": false},
		              { "sName" : "dist.dob",  "bVisible": false},
		              { "sName" : "dist.bank_name",  "bVisible": false},
		              { "sName" : "dist.bank_acc_no",  "bVisible": false},
		              { "sName" : "dist.bank_holder_name",  "bVisible": false},
		              { "sName" : "dist.bank_swift_code",  "bVisible": false},
		              { "sName" : "dist.visa_debit_card",  "bVisible": false},
		              { "sName" : "dist.upline_dist_code",  "bVisible": false},
		              { "sName" : "dist.status_code",  "bVisible": false},
		              { "sName" : "dist.created_on",  "bVisible": false},
		              { "sName" : "dist.created_on",  "bVisible": false},
		              { "sName" : "dist.created_on",  "bVisible": false},
		              { "sName" : "dist.created_on",  "bVisible": false},
		              { "sName" : "dist.created_on",  "bVisible": false},
                      { "sName" : "dist.remark",  "bVisible": false},
		              { "sName" : "dist.hide_genealogy",  "bSortable": true}
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
}); // end $(function())

//all event in detail datagrid need to reassign because, every remote call, the DOM will be restructure again.
function reassignDatagridEventAttr(){
	$("a[id=transferEpointLink]").click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");
        $("#dgAddPanelId").val(id);
        $("#dgAddPanel").dialog("open");
	});
}

</script>

<?php echo form_tag('admin/doLogin', 'id=loginForm') ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
<div class="portlet">
    <div class="portlet-header">Genealogy Management</div>
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
								<th>Package</th>
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
								<td></td>
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
                                <td></td>
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
					</td>
				</tr>
                <tr>
                    <td>
                        <textarea id="bulkContentTemp" name="bulkContentTemp" rows="10" cols="100"></textarea>
                        <br>
                        <button id="btnBulk">Submit</button>
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
    $("#btnBulk").click(function(event){
        event.preventDefault();
        $("#bulkContentHidden").val($("#bulkContentTemp").val());
        $("#unlockGenealogyForm").submit();
    });

    $("#dgAddPanel").dialog("destroy");
    $("#dgAddPanel").theoneDialog({
        width:700,
        open: function() {
            populateDgAddPanel();
        },
        close: function() {

        },
        buttons: {
            "Open Genealogy": function() {
                waiting();
                $.ajax({
                    type : 'POST',
                    url : "<?php echo url_for("/marketing/doUpdateHideGenealogy"); ?>",
                    dataType : 'json',
                    cache: false,
                    data: {
                        distId : $('#dgAddPanelId').val()
                        , toHideGenealogy : "N"
                    },
                    success : function(data) {
                        $("#dgAddPanel").dialog('close');
                        datagrid.fnDraw();
                        alert("Update Successful");
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Your login attempt was not successful. Please try again.");
                    }
                });
            },
            "Close Genealogy": function() {
                waiting();
                $.ajax({
                    type : 'POST',
                    url : "<?php echo url_for("/marketing/doUpdateHideGenealogy"); ?>",
                    dataType : 'json',
                    cache: false,
                    data: {
                        distId : $('#dgAddPanelId').val()
                        , toHideGenealogy : "Y"
                    },
                    success : function(data) {
                        $("#dgAddPanel").dialog('close');
                        datagrid.fnDraw();
                        alert("Update Successful");
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Your login attempt was not successful. Please try again.");
                    }
                });
            },
            "Reset Password": function() {
                waiting();
                $.ajax({
                    type : 'POST',
                    url : "<?php echo url_for("/marketing/doResetPassword"); ?>",
                    dataType : 'json',
                    cache: false,
                    data: {
                        distId : $('#dgAddPanelId').val()
                    },
                    success : function(data) {
                        $("#dgAddPanel").dialog('close');
                        datagrid.fnDraw();
                        alert("Update Successful");
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Your login attempt was not successful. Please try again.");
                    }
                });
            },
            Cancel: function() {
                $(this).dialog('close');
            }
        }
    });

});

function populateDgAddPanel() {
    $("#dgMsg").hide();
    $("#dgAddPanelUserName").attr("readonly", "readonly");
    var data = $("#dgAddPanel").data("data_" + $("#dgAddPanelId").val());
    $("#dgAddPanelDistCode").val(data.distributor_code);
    $("#dgAddPanelName").val(data.full_name);
    $("#dgAddPanelEmail").val(data.email);
    $("#dgAddPanelHideGenealogy").val(data.hide_genealogy);
}
</script>
<div id="dgAddPanel" style="display:none; width: 850px" title="Genealogy Management">
    <input type="hidden" id="dgAddPanelId">
    <table width="100%">
        <tr>
            <td colspan="3">
                <div class="ui-widget" id="dgMsg" style="display:none;">
                </div>
            </td>
        </tr>
    </table>
    <fieldset class="collapsible">
    <legend class="collapsible">Details</legend>
    <table cellpadding="3" cellspacing="3">
        <tr>
            <td width="30%">Distributor Code</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelDistCode" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>Name</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelName" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelEmail" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>Hide Genealogy</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelHideGenealogy" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>
    </table>
    </fieldset>
</div>
</form>

<form id="unlockGenealogyForm" method="post" name="unlockGenealogyForm" action="<?php echo url_for("/marketing/unlockBulkGenealogy")?>">
<textarea name="bulkContent" id="bulkContentHidden" rows="10" cols="100" style="display: none;"></textarea>
</form>