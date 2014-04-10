<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
	jform = $("#enquiryForm").validate({
		submitHandler: function(form) {
			if(isSubmitAjax){
				datagrid.fnDraw();
			}else {
				form.submit();
			}
		}
	});

	datagrid = $("#datagrid").r9jasonDataTable({
		// online1DataTable extra params
		"idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
		"extraParam" : function(aoData){ // pass extra params to server
			aoData.push( { "name": "filterDistcode", "value": $("#search_distCode").val()  } );
            aoData.push( { "name": "filterMt4Userame", "value": $("#search_mt4Username").val() } );
            aoData.push( { "name": "filterFullName", "value": $("#search_fullName").val() } );
            aoData.push( { "name": "filterEmail", "value": $("#search_email").val() } );
            aoData.push( { "name": "filterParentCode", "value": $("#search_parentCode").val() } );
            aoData.push( { "name": "filterStatusCode", "value": $("#search_statusCode").val() } );
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
		"sAjaxSource": "<?php echo url_for('marketingList/rpList') ?>",
		"sPaginationType": "full_numbers",
		"aoColumns": [
		              { "sName" : "dist.distributor_id", "bVisible" : false},
		              { "sName" : "dist.distributor_id",  "bSortable": false, "fnRender": function ( oObj ) {
                          var idx = 2;
                          $("#dgAddPanel").data("data_" + oObj.aData[0], {
                                distributor_id : oObj.aData[0]
                                , distributor_code : oObj.aData[idx++]
                                , rp : oObj.aData[idx++]
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
                                /*, visa_debit_card : oObj.aData[idx++]*/
                                , parent_nickname : oObj.aData[idx++]
                                , status_code : oObj.aData[idx++]
                                , created_on : oObj.aData[idx++]
                          });
		  				  return "<a id='transferEpointLink' href='#' title='Recall Rolling Point'>Recall RP</a>";
		  				}},
		              { "sName" : "dist.distributor_code",  "bSortable": true},
		              { "sName" : "rp.TOTAL_ROLLING_POINT",  "bSortable": false, "fnRender": function ( oObj ) {
                            return "<a id='historyListLink' href='#' title='History List'>" + oObj.aData[3] + "</a>";
                      }},
		              { "sName" : "dist.rank_code",  "bSortable": true},
		              { "sName" : "tblUser.userpassword",  "bSortable": true},
		              { "sName" : "tblUser.userpassword2",  "bSortable": true},
		              { "sName" : "tblUser.userpassword2",  "bSortable": true},
		              { "sName" : "tblUser.userpassword2",  "bSortable": true},
		              /*{ "sName" : "dist.mt4_user_name",  "bSortable": true},
		              { "sName" : "dist.mt4_password",  "bSortable": true},*/
		              { "sName" : "dist.full_name",  "bSortable": true},
		              { "sName" : "dist.nickname",  "bSortable": true},
		              { "sName" : "dist.ic",  "bSortable": true},
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
		              /*{ "sName" : "dist.visa_debit_card",  "bSortable": true},*/
		              { "sName" : "dist.upline_dist_code",  "bSortable": true},
		              { "sName" : "dist.status_code",  "bSortable": true},
		              { "sName" : "dist.created_on",  "bSortable": true}
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
	$("a[id=historyListLink]").click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");
        $("#dgHistoryListId").val(id);
        $("#dgHistoryListPanel").dialog("open");
	});
}

</script>

<?php echo form_tag('admin/doLogin', 'id=loginForm') ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
<div class="portlet">
    <div class="portlet-header">Recall RP</div>
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
								<th>RP</th>
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
								<!--<th>Visa Debit Card</th>-->
								<th>Referral</th>
								<th>Status</th>
								<th>Add Date</th>
							</tr>
                            <tr>
                                <td></td>
                                <td></td>
								<td><input title="" size="10" type="text" id="search_distCode" value="" class="search_init"/></td>
								<td></td>
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
                                <!--<td></td>-->
                                <td></td>
                                <td></td>
                                <td><input title="" size="10" type="text" id="search_parentCode" value="" class="search_init"/></td>
                                <td><input title="" size="10" type="text" id="search_statusCode" value="" class="search_init"/></td>
                                <td></td>
							</tr>
                        </thead>
                    </table>
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
            Submit: function() {
                var doAction = $("#doAction").val();
                var msg = "Are you sure want to Recall Rolling Point?";

                var answer = confirm(msg);
                if (answer){
                    waiting();

                    var amount = $('#epointAmount').autoNumericGet();
                    $("#epointAmount").val(amount);

                    if (amount == "" || amount <= 0) {
                        alert("Amount cannot be blank.");
                        $("#epointAmount").focus().select();
                    } else {
                        $.ajax({
                            type : 'POST',
                            url : "<?php echo url_for('finance/doEpointTransfer') ?>",
                            dataType : 'json',
                            cache: false,
                            data: {
                                distId : $('#dgAddPanelId').val()
                                , epointAmount : $('#epointAmount').val()
                                , internalRemark : $('#internalRemark').val()
                                , doAction : doAction
                            },
                            success : function(data) {
                                if (data.error) {
                                    alert(data.errorMsg);
                                } else {
                                    $("#dgAddPanel").dialog('close');
                                    datagrid.fnDraw();
                                    alert("Record Save Successfully.");
                                }
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("Server connection error.");
                            }
                        });
                    }
                }
            },
            <?php } ?>
            Close: function() {
                $(this).dialog('close');
            }
        }
    });

    $('#epointAmount').autoNumeric({
        mDec: 2
    });
});

function populateDgAddPanel() {
    $("#dgMsg").hide();
    $("#dgAddPanelUserName").attr("readonly", "readonly");
    var data = $("#dgAddPanel").data("data_" + $("#dgAddPanelId").val());
    $("#dgAddPanelDistCode").val(data.distributor_code);
    $("#dgAddPanelmt4_user_name").val(data.mt4_user_name);
    $("#dgAddPanelmt4_password").val(data.mt4_password);
    $("#dgAddPanelName").val(data.full_name);
    $("#dgAddPanelEmail").val(data.email);
    $("#epointAmount").val("0").focus().select();
}
</script>
<div id="dgAddPanel" style="display:none; width: 850px" title="Recall RP">
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
        </tr>
        <tr>
            <td>MT4 ID</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelmt4_user_name" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>MT4 Password</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelmt4_password" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelName" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
            <td>Email</td>
            <td>:</td>
            <td><input type="text" id="dgAddPanelEmail" class="text ui-widget-content ui-corner-all" readonly="readonly" size="25"></td>
        </tr>

        <tr>
            <td>Total CP1</td>
            <td>:</td>
            <td><input name="epointAmount" id="epointAmount" class="text ui-widget-content ui-corner-all" size="25"/></td>
        </tr>


        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td colspan="4"><input name="internalRemark" id="internalRemark" class="text ui-widget-content ui-corner-all" size="50"/></td>
        </tr>

        <tr style="display: none;">
            <td>Action</td>
            <td>:</td>
            <td>
                <select id="doAction" name="doAction">
<!--                    <option value="transfer">Transfer Rolling Point</option>-->
                    <option value="RECALL">Recall Rolling Point</option>
<!--                    <option value="epoint">Transfer CP1</option>-->
                </select>
            </td>
        </tr>
    </table>
    </fieldset>
</div>
</form>


<script type="text/javascript">
$(function(){
    var datagridHistory =  $("#datagridHistory").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData){ // pass extra params to server
            aoData.push( { "name": "filterDistId", "value": $("#dgHistoryListId").val()  } );
            aoData.push( { "name": "filterAccountType", "value": $("#search_accountType").val()  } );
            aoData.push( { "name": "filterTransactionType", "value": $("#search_transactionType").val() } );
        },
        "reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server

        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sScrollX": "100%",
        //"sScrollXInner": "150%",
        "sAjaxSource": "<?php echo url_for('marketingList/rpLogList') ?>",
        "sPaginationType": "full_numbers",
        "aaSorting": [
            [0,'desc']
        ],
        "aoColumns": [
            { "sName" : "account.created_on",  "bSortable": true},
            { "sName" : "account.account_type",  "bSortable": true},
            { "sName" : "account.transaction_type",  "bSortable": true},
            { "sName" : "account.credit", "bVisible" : true,  "bSortable": true},
            { "sName" : "account.debit",  "bSortable": true},
            { "sName" : "account.balance",  "bSortable": true},
            { "sName" : "appUser.username",  "bSortable": true},
            { "sName" : "account.remark",  "bSortable": true},
            { "sName" : "account.internal_remark",  "bSortable": true}
        ]
    });
    $("#dgHistoryListPanel").dialog("destroy");
    $("#dgHistoryListPanel").theoneDialog({
        width:700,
        open: function() {
            datagridHistory.fnDraw();
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
</script>
<div id="dgHistoryListPanel" style="display:none; width: 850px" title="RP History List">
    <input type="hidden" id="dgHistoryListId">
    <table class="display" id="datagridHistory" border="0" style="width: 850px">
        <thead>
            <tr>
                <th><?php echo 'Date' ?></th>
                <th><?php echo 'Account Type' ?></th>
                <th><?php echo 'Transaction Type' ?></th>
                <th><?php echo 'In' ?></th>
                <th><?php echo 'Out' ?></th>
                <th><?php echo 'Balance' ?></th>
                <th><?php echo 'Created By' ?></th>
                <th><?php echo 'Remarks' ?></th>
                <th><?php echo 'Internal Remarks' ?></th>
            </tr>
            <tr>
                <td></td>
                <td><input size="10" type="text" id="search_accountType" value="" class="search_init"/></td>
                <td><input size="10" type="text" id="search_transactionType" value="" class="search_init"/></td>
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