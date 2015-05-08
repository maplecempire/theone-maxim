<script type="text/javascript">
var isSubmitAjax = true;
var jform = null;
var datagrid = null;

$(function(){
	jform = $("#enquiryForm").validate({
		submitHandler: function(form) {
			if(isSubmitAjax){
				//alert("submit ajax");
			}else {
				//alert("not submit ajax");
				form.submit();
			}
		}
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