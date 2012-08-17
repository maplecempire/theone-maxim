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
        "extraParam" : function(aoData) { // pass extra params to server
            aoData.push({ "name": "filterUsername", "value": $("#search_username").val()  } );
            aoData.push({ "name": "statusCode", "value": $("#search_combo_statusCode").val()  });
        },
        "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sScrollX": "100%",
        "sAjaxSource": "<?php echo url_for('admin/withdrawList') ?>",
        "sPaginationType": "full_numbers",
        "aoColumns": [
            { "sName" : "withdraw.withdraw_id", "bVisible" : false},
            { "sName" : "withdraw.dist_id",  "bSortable": false, "bVisible" : true, "fnRender": function ( oObj ) {
                if (oObj.aData[6] == "PENDING" || oObj.aData[6] == "PROCESSING") {
                    return "<input type='checkbox' name='withdrawId[]' value='" + oObj.aData[0] + "' />";
                }
                return "";
            }},
            { "sName" : "dist.distributor_code",  "bSortable": true, "fnRender": function ( oObj ) {
                if (oObj.aData[6] == "REJECTED")
                    return oObj.aData[2];
                return "<a id='editLink' href='<?php echo url_for('finance/withdrawalEdit?q=dsf453fsdfasf1sxfsdfs&withdrawId=') ?>/" + oObj.aData[0] + "'>" + oObj.aData[2] + "</a>";
            }},
            { "sName" : "dist.full_name",  "bSortable": true},
            { "sName" : "withdraw.deduct",  "bSortable": true},
            { "sName" : "accountLedger._ecash",  "bSortable": true},
            { "sName" : "withdraw.status_code",  "bSortable": true},
            { "sName" : "withdraw.created_on",  "bSortable": true}
            , { "sName" : "dist.ic",  "bSortable": true}
            , { "sName" : "dist.email",  "bSortable": true}
            , { "sName" : "dist.contact",  "bSortable": true}
            , { "sName" : "dist.bank_name",  "bSortable": true}
            , { "sName" : "dist.bank_acc_no",  "bSortable": true}
            , { "sName" : "dist.bank_holder_name",  "bSortable": true}
            , { "sName" : "dist.rank_code",  "bSortable": true}
            , { "sName" : "withdraw.remarks",  "bSortable": true}
            , { "sName" : "withdraw.dist_id",  "bVisible": true}
        ]
    });
    $("#btnUpdate").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    })
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
}

</script>

<?php echo form_tag('finance/ecashWithdrawal', 'id=loginForm') ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1400px">
<div class="portlet">
    <div class="portlet-header">Ecash Withdrawal Listing</div>
    <div class="portlet-content">
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
	<table width="100%" border="0">
		<tr>
			<td>
			<table width="100%">
				<tr>
					<td>
                    <div style="width: 1350px">
					<table class="display" id="datagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th>withdrawal id [hidden]</th>
                            <th></th>
                            <th>Shareholder</th>
                            <th>Name</th>
                            <th>Withdraw</th>
                            <th>e-Cash</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>IC</th>
                            <th>Email</th>
                            <th>Contact No</th>
                            <th width="30%">Bank Name</th>
                            <th>Bank Account No</th>
                            <th>Bank Holder Name</th>
                            <th>Rank Code</th>
                            <th>Remarks</th>
                            <th width="15%">Group Leader</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><input title="" size="10" type="text" id="search_username" value="" class="search_init"/></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <select id="search_combo_statusCode">
                                    <option value="PENDING">PENDING</option>
                                    <option value="PROCESSING">PROCESSING</option>
                                    <option value="REJECTED">REJECTED</option>
                                    <option value="PAID">PAID</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
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
			</table>
                <select name="withdrawStatus">
                    <option value="PROCESSING">PROCESSING</option>
                    <!--<option value="REJECTED">REJECTED</option>-->
                    <option value="PAID">PAID</option>
                </select>
                <button id="btnUpdate">Update</button>
			</td>
		</tr>
	</table>
    </div>
</div>
</div>

</form>