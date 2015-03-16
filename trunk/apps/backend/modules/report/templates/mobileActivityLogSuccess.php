<style type="text/css">
    .remark {
        word-wrap: break-word;
    }
</style>

<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;
var dataList = {};
var remarkList = {};

$(function(){
	jform = $("#dataForm").validate({
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
            dataList = {};
            remarkList = {};
            aoData.push({ "name": "filterUsername", "value": $("#search_username").val()  });
            aoData.push({ "name": "filterIp", "value": $("#search_ip").val()  });
            aoData.push({ "name": "filterAction", "value": $("#search_action").val()  });
            aoData.push({ "name": "filterData", "value": $("#search_data").val()  });
            aoData.push({ "name": "filterRemark", "value": $("#search_remark").val()  });
            aoData.push({ "name": "filterDateFrom", "value": $("#txtDateFrom").val()  });
            aoData.push({ "name": "filterDateTo", "value": $("#txtDateTo").val()  });
        },
        "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
            reassignDatagridEventAttr()
        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "<?php echo url_for('reportList/mobileActivityLogList') ?>",
        "sPaginationType": "full_numbers",
        "aaSorting": [[1,'desc']],
        "aoColumns": [
            { "sName" : "a.log_id", "bVisible" : false},
            { "sName" : "a.created_on",  "bSortable": true},
            { "sName" : "b.username",  "bSortable": true},
            { "sName" : "a.access_ip",  "bSortable": false},
            { "sName" : "a.trans_action",  "bSortable": true, "fnRender": function ( oObj ) {
                return "<pre>" + oObj.aData[4] + "</pre>";
            }},
            { "sName" : "a.trans_data",  "bSortable": false, "fnRender": function ( oObj ) {
                dataList[oObj.aData[0]] = oObj.aData[5];
                return "<a href='javascript:void(0)' onclick='showDataMsg(" + oObj.aData[0] + ");'>show</a>";
            }},
            { "sName" : "a.remark",  "bSortable": false, "fnRender": function ( oObj ) {
                var val = oObj.aData[6];
                remarkList[oObj.aData[0]] = val;

                if (val.length > 40) {
                    return "<span class='remark' onclick='showRemarkMsg(" + oObj.aData[0] + ");' title='" + val + "'>" + val.substring(0, 37) + "...</span>";
                } else {
                    return "<span class='remark' onclick='showRemarkMsg(" + oObj.aData[0] + ");' title='" + val + "'>" + val + "</span>";
                }
            }}
        ]
    });

    $("#txtDateFrom").datepicker().datepicker("setDate", "-7d");
    $("#txtDateTo").datepicker();

    $("#btnSearch").click(function(event){
        event.preventDefault();
        datagrid.fnDraw();
    });
    $("#btnExport").click(function(event){
        event.preventDefault();
        datagrid.fnDraw();
    });
}); // end $(function())

//all event in detail datagrid need to reassign because, every remote call, the DOM will be restructure again.
function reassignDatagridEventAttr(){

}

function showDataMsg(id) {
    alert("<pre style='text-align: left; font-weight: normal;'>" + dataList[id] + "</pre>");
}

function showRemarkMsg(id) {
    alert("<div style='text-align: left;'><span style='word-wrap: break-word; font-weight: normal;'>" + remarkList[id] + "</span></div>");
}

</script>

<?php echo form_tag('report/mobileActivityLog', array("id" => "dataForm")) ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1000px">
<div class="portlet">
    <div class="portlet-header">Total Package Upgrade Report</div>
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
                    <td width="100">Date From</td>
                    <td width="1">:</td>
                    <td><input id="txtDateFrom" size="20" readonly="readonly" value="<?php echo date('Y-m-d');?>"></td>
                </tr>
                <tr>
                    <td>Date To</td>
                    <td>:</td>
                    <td><input id="txtDateTo" size="20" readonly="readonly" value="<?php echo date('Y-m-d');?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><button id="btnSearch">Search</button>&nbsp;<button id="btnExport" style="display: none">Export</button></td>
                </tr>
				<tr>
					<td colspan="3">
                    <div>
					<table class="display" id="datagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Username</th>
                            <th>Access IP</th>
                            <th>Action</th>
                            <th>Transfer Data</th>
                            <th>Remarks</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><input title="" size="10" type="text" id="search_username" value="" class="search_init"/></td>
                            <td><input title="" size="10" type="text" id="search_ip" value="" class="search_init"/></td>
                            <td><input title="" size="10" type="text" id="search_action" value="" class="search_init"/></td>
                            <td><input title="" size="10" type="text" id="search_data" value="" class="search_init"/></td>
                            <td><input title="" size="10" type="text" id="search_remark" value="" class="search_init"/></td>
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

</form>