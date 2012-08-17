<?php include('scripts.php'); ?>
<script type="text/javascript">
var packageStrings = "<option value=''></option>";
var datagrid = null;
var datagridAnnouncement = null;
$(function() {
    datagrid = $("#datagridAnnouncement").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData){ // pass extra params to server

        },
        "reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
            reassignDatagridAnnouncementEventAttr();
        },
        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "/member/announcementList",
        "sPaginationType": "full_numbers",
        "aaSorting": [[4,'desc']],
        "aoColumns": [
                      { "sName" : "announcement_id",  "bVisible": false},
                        { "sName" : "title",  "bSortable": false, "fnRender": function ( oObj ) {
                            return "<a class='announcementLink' refId='" + oObj.aData[0] + "' href='#' style='color: #0000ff;'>" + oObj.aData[1] + "</a>";
		  		        }},
                      { "sName" : "created_on",  "bSortable": false}
        ]
    });

    $("#dgAnnouncement").dialog("destroy");
    $("#dgAnnouncement").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        width: 700,
        height: 500,
        buttons: {
            "<?php echo __('Cancel') ?>": function() {
                $(this).dialog('close');
            }
        },
        open: function() {

        },
        close: function() {

        }
    });

    $(".announcementLink").live("click", function(event) {
        event.preventDefault();
        $("#dgAnnouncement").data("refId", $(this).attr("refId"));

        waiting();
        $.ajax({
            type : 'POST',
            url : "/member/fetchAnnouncementById",
            dataType : 'json',
            cache: false,
            data: {
                announcementId : $('#dgAnnouncement').data("refId")
            },
            success : function(data) {
                $.unblockUI();
                $("#dgAnnouncement").dialog("open");
                $("#tdAnnouncement").html("<strong>" + data.content + "</strong>");
                $("#dgAnnouncement").dialog("option", "title", data.title);
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Your login attempt was not successful. Please try again.");
            }
        });
    });
    $("#paymentTypeEPoint").attr('checked', true);
    $("#spanPaymentType").buttonset();
});
function reassignDatagridAnnouncementEventAttr(){
	$("a[id=editLink]").click(function(event){

	});
}
</script>

<div style="padding: 10px; top: 30px; width: 98%">
<div class="portlet">
    <div class="portlet-header"><?php echo __('Announcements') ?></div>
    <div class="portlet-content">
            <table class="display" id="datagridAnnouncement" border="0" width="100%">
                <thead>
                <tr>
                    <th>Announcement Id[hidden]</th>
                    <th><?php echo __('Title') ?></th>
                    <th width="20%"><?php echo __('Date') ?></th>
                </tr>
                </thead>
            </table>
    </div>
</div>
</div>

<div id="dgAnnouncement" title="<?php echo __('Announcements') ?>" style="display:none;">
    <table cellspacing="5">
        <tr>
            <td class="text" id="tdAnnouncement"></td>
    </table>
</div>