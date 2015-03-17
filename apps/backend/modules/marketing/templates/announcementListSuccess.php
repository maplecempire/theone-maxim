<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
	 $("#checkAll").click(function(){
        $('.announcementCheckbox').attr('checked', this.checked);
    });
    jform = $("#dataForm").validate({
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

    $("#btnUpdate").click(function() {
        waiting();
        isSubmitAjax = false;
        $("#dataForm").submit();
    });

	datagrid = $("#datagrid").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData) { // pass extra params to server
            aoData.push( { "name": "filterTitle", "value": $("#search_title").val()  } );
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
        "sAjaxSource": "<?php echo url_for("/marketingList/announcementList");?>",
        "sPaginationType": "full_numbers",
        "aaSorting": [
            [3,'asc'],
            [4,'desc'],
            [5,'desc']
        ],
        "aoColumns": [
            { "sName" : "announcement.id", "bVisible" : false,  "bSortable": true},
            { "sName" : "announcement.id",  "bSortable": false, "bVisible" : true, "fnRender": function ( oObj ) {
                return "<input type='checkbox' name='announcementId[]' value='" + oObj.aData[0] + "' class='announcementCheckbox'/>";
            }},
            { "sName" : "announcement.ns_title",  "bSortable": false,  "bVisible": true, "fnRender": function ( oObj ) {
                return "<a href='<?php echo url_for("/marketing/announcementDetail");?>?announcementId=" + oObj.aData[0] + "' style='color:#0088CF'>" + oObj.aData[2] + "</a>";
            }},
            { "sName" : "announcement.ns_status", "bVisible" : true,  "bSortable": true},
            { "sName" : "announcement.ns_start_date",  "bSortable": true},
            { "sName" : "announcement.ns_end_date",  "bSortable": true},
            { "sName" : "announcement.updated_on",  "bSortable": true},
        ]
    });

    $("#btnNew").button();
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

<?php echo form_tag('marketing/announcementList', array("id" => "dataForm")) ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
<div class="portlet">
    <div class="portlet-header">Announcement Listing</div>
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
                            <th>Title</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Last Modified</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="checkbox" id="checkAll" value=""/></td>
                            <td><input title="" size="20" type="text" id="search_title" value="" class="search_init"/></td>
                            <td>
                                <select id="search_statusCode">
                                    <option value="">All</option>
                                    <option value="<?php echo Globals::STATUS_ACTIVE ?>">ACTIVE</option>
                                    <option value="<?php echo Globals::STATUS_CLOSED ?>">CLOSED</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                    </table>
					</td>
				</tr>
                <tr>
                    <td>
                        <a href="<?php echo url_for("/marketing/announcementDetail");?>" id="btnNew">New Announcement</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select name="announcementStatus">
                            <option value="<?php echo Globals::STATUS_ACTIVE ?>">ACTIVE</option>
                            <option value="<?php echo Globals::STATUS_CLOSED ?>">CLOSED</option>
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