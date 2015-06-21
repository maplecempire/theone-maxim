<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
	 $("#checkAll").click(function(){
        $('.enquiryCheckbox').attr('checked', this.checked);
    });
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
        "extraParam" : function(aoData) { // pass extra params to server
            aoData.push( { "name": "filterCategory", "value": $("#search_category").val()  } );
            aoData.push( { "name": "filterDistCode", "value": $("#search_distCode").val()  } );
            aoData.push( { "name": "filterSubject", "value": $("#search_subject").val()  } );
            aoData.push( { "name": "filterStatusCode", "value": $("#search_statusCode").val()  } );
        },
        "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
            reassignDatagridEventAttr();
        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "<?php echo url_for("/marketingList/customerEnquiryList");?>",
        "sPaginationType": "full_numbers",
        "aaSorting": [
            [3,'desc']
        ],
        "aoColumns": [
            { "sName" : "customer.enquiry_id", "bVisible" : false,  "bSortable": true},
            { "sName" : "customer.enquiry_id",  "bSortable": false, "bVisible" : true, "fnRender": function ( oObj ) {
                return "<input type='checkbox' name='enquiryId[]' value='" + oObj.aData[0] + "' class='enquiryCheckbox'/>";                
            }},
            { "sName" : "customer.category",  "bSortable": true},
            { "sName" : "customer.created_on", "bVisible" : true,  "bSortable": true},
            { "sName" : "dist.distributor_code",  "bSortable": true},
            { "sName" : "customer.title",  "bSortable": true},
            { "sName" : "customer.distributor_updated",  "bSortable": true},
            { "sName" : "customer.admin_read",  "bVisible": true, "fnRender": function ( oObj ) {
                if (oObj.aData[7] == "Read") {
                    return "<a href='<?php echo url_for("/marketing/customerEnquiryDetail");?>?enquiryId=" + oObj.aData[0] + "'>Read</a>";
                } else if (oObj.aData[7] == "Unread") {
                    return "<a href='<?php echo url_for("/marketing/customerEnquiryDetail");?>?enquiryId=" + oObj.aData[0] + "' style='color:#0088CF'>Unread</a>";
                }
            }},
            { "sName" : "customer.status_code",  "bSortable": true}
        ]
    });

    $("#btnNewMessage").button();
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

<?php echo form_tag('marketing/customerEnquiryList', 'id=loginForm') ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
<div class="portlet">
    <div class="portlet-header">Customer Enquiry Listing</div>
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
					<table class="display" id="datagrid" border="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Member ID</th>
                            <th>Subject</th>
                            <th>Last Reply</th>
                            <th>Read / Unread</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="checkbox" id="checkAll" value=""/></td>
                            <td>
                            <select name='search_category' id='search_category'>
	                        	<option value=''>All Category</option>
	                        	<option value='Genealogy'>Genealogy</option>
	                        	<option value='User Profile/Credentials'>User Profile/Credentials</option>
	                        	<option value='Deposit/CP Points'>Deposit/CP Points</option>
	                        	<option value='Investment Returns/Bonuses'>Investment Returns/Bonuses</option>
	                        	<option value='MT4 Withdrawal/Reload/Trading'>MT4 Withdrawal/Reload/Trading</option>
	                        	<option value='Withdrawal Issues'>Withdrawal Issues</option>
	                        	<option value='Contract Maturity'>Contract Maturity</option>
	                        	<option value='Maxim Visa Card'>Maxim Visa Card</option>
	                        	<option value='Events/Promotions'>Events/Promotions</option>
	                        	<option value='Decline Auto Swap'>Decline Auto Swap</option>
	                        	<option value='Others'>Others</option>
	                        </select>
                            </td>
                            <td></td>
                            <td><input title="" size="20" type="text" id="search_distCode" value="" class="search_init"/></td>
                            <td><input title="" size="20" type="text" id="search_subject" value="" class="search_init"/></td>
                            <td></td>
                            <td></td>
                            <td>
                            <select id="search_statusCode">
                                <option value="">All</option>
                                <option value="PENDING">PENDING</option>
                                <option value="PROCESSING">PROCESSING</option>
                                <option value="SOLVED">SOLVED</option>
                            </select>
                            </td>
                        </tr>
                        </thead>
                    </table>
					</td>
				</tr>
                <tr>
                    <td>
                        <a href="<?php echo url_for("/marketing/customerEnquiryAdd");?>" id="btnNewMessage">New Message</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select name="enquiryStatus">
                            <option value="PENDING">PENDING</option>
                            <option value="PROCESSING">PROCESSING</option>
                            <option value="SOLVED">SOLVED</option>
		                </select>
		                <button id="btnUpdate">Update</button>
                    </td>
                </tr>
			</table>
			</td>
		</tr>
	</table>
    </div>
</div>
</div>
</form>