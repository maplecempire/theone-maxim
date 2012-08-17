<?php include('scripts.php'); ?>
<script type="text/javascript">
var packageStrings = "<option value=''></option>";
var datagrid = null;
var datagridAnnouncement = null;
$(function() {
    datagrid = $("#datagridAnnouncement").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData) { // pass extra params to server

        },
        "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
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
        "aaSorting": [
            [4,'desc']
        ],
        "aoColumns": [
            { "sName" : "announcement_id",  "bVisible": false},
            { "sName" : "title",  "bSortable": false, "fnRender": function (oObj) {
                return "<a class='announcementLink' refId='" + oObj.aData[0] + "' href='#' style='color: #0000ff;'>" + oObj.aData[1] + "</a>";
            }},
            { "sName" : "created_on",  "bSortable": false}
        ]
    });

    $(".deleteLink").button({
        icons: {
            primary: "ui-icon-circle-close"
        }
    });
    $(".activeLink").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    }).click(function(event) {
        event.preventDefault();
        waiting();
//        $("#distributorId").val($(this).attr("ref"));
        $("#dgActivateMember_shareholderId").val($(this).attr("refCode"));
        $("#dgActivateMember_alias").val($(this).attr("refNickname"));
        $("#dgActivateMember_registeredTime").val($(this).attr("refCreatedDate"));
        $.ajax({
            type : 'POST',
            url : "/member/fetchPackage",
            dataType : 'json',
            cache: false,
            data: {
            },
            success : function(data) {
                $.unblockUI();
                packageStrings = "";
                jQuery.each(data.package, function(key, value) {
                    packageStrings += "<option value='" + value.price + "' ref='" + value.packageId + "'>" + value.name + "</option>";
                });

                $("#dgActivateMember").dialog("open");

                $("#dgActivateMember_point").html(packageStrings).trigger("change");

                $("#dgActivateMember_pointAvail").val(data.point);
                $("#dgActivateMember_ecash").val(data.ecash);
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Server connection error.");
            }
        });
    });

    $("#dgActivateMember").dialog("destroy");
    $("#dgActivateMember").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        width: 400,
        buttons: {
            "<?php echo __('Cancel') ?>": function() {
                $(this).dialog('close');
            },
            "<?php echo __('Submit') ?>": function() {
                if ($("#dgActivateMember_pointNeeded").val() == 0 || $("#dgActivateMember_pointNeeded").val() == "") {
                    error("In-sufficient fund to purchase package.");
                    $("#dgActivateMember_point").focus().select();
                } else if ($("#paymentTypeEPoint").is(':checked') == true && parseFloat($("#dgActivateMember_point").val()) > parseFloat($("#dgActivateMember_pointAvail").val())){
                    alert("In-sufficient e-point. " + $("#dgActivateMember_pointAvail").val());
                    $("#dgActivateMember_point").focus().select();
                } else if ($("#paymentTypeECash").is(':checked') == true && parseFloat($("#dgActivateMember_point").val()) > parseFloat($("#dgActivateMember_ecash").val())){
                    alert("In-sufficient MT4 Credit. " + $("#dgActivateMember_ecash").val());
                    $("#dgActivateMember_point").focus().select();
                } else {
                    if ($.trim($("#dgActivateMember_transactionPassword").val()) == "") {
                        error("Security Password is empty");
                        $("#dgActivateMember_transactionPassword").focus();
                        return false;
                    }
                    waiting();
                    $.ajax({
                        type : 'POST',
                        url : "/member/activateMember",
                        dataType : 'json',
                        cache: false,
                        data: {
                            packageId : $('#dgActivateMember_point option:selected').attr("ref")
                            , transactionPassword : $('#dgActivateMember_transactionPassword').val()
//                            , sponsorId : $('#distributorId').val()
                            , paymentType : "epoint"
//                            , paymentType : $("input[name='paymentType']:checked").val()
                        },
                        success : function(data) {
                            if (data.error == false) {
                                window.location = "<?php echo url_for('/member/summary') ?>";
                                $.unblockUI();
                            } else {
                                error(data.errorMsg);
                                $("#dgActivateMember_transactionPassword").focus().select();
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            error("Server connection error.");
                        }
                    });
                }
            }
        },
        open: function() {

        },
        close: function() {

        }
    });

    $("#dgActivateMember_point").change(function() {
        $("#dgActivateMember_pointNeeded").val($("#dgActivateMember_point").val());
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
                    "<?php echo __('Close') ?>": function() {
                        $(this).dialog('close');
                    }
                },
                open: function() {

                },
                close: function() {

                }
            });

    $("#reinvestGapLink").live("click", function(event) {
        event.preventDefault();
        $("#dgReinvestCps").dialog("open");
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
                error("Your login attempt was not successful. Please try again.");
            }
        });
    });

    $("#paymentTypeEPoint").attr('checked', true);
    $("#spanPaymentType").buttonset();

    <?php
    if ($distributor->getFileBankPassBook() == "" || $distributor->getFileProofOfResidence() == ""  || $distributor->getFileNric() == "") {
        $content = "You have not upload the documents below yet : <br><br><ul>";

        if ($distributor->getFileBankPassBook() == "") {
            $content .= "<li>Bank Pass Book</li>";
        }
        if ($distributor->getFileProofOfResidence() == "") {
            $content .= "<li>Proof of Residence</li>";
        }
        if ($distributor->getFileNric() == "") {
            $content .= "<li>Passport/IC</li>";
        }
        $content .= "</ul>";
    ?>
        $("#tdAnnouncement").html("<strong><?php echo $content;?></strong>");
        $("#dgAnnouncement").dialog("option", "title", "Document Upload");
        $("#dgAnnouncement").dialog("option", "height", "250");
        $("#dgAnnouncement").dialog("option", "width", "500");
        $("#dgAnnouncement").dialog("open");
    <?php
    }
    ?>

    /*$.ajax({
        type : 'POST',
        url : "/member/fetchAnnouncementById",
        dataType : 'json',
        cache: false,
        data: {
            announcementId : 11
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
    });*/

});
function reassignDatagridAnnouncementEventAttr() {

}
</script>
<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>
<!--- aside end --->
<!--- content --->
<div class="areaContent">
    <div class="resultsWrap">
    <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                    align="center">
        <caption><?php echo $fullName?>, welcome to OFX Global Malaysia.</caption>

        <tr>
            <td colspan=2 align='center'>
                <?php if ($sf_flash->has('successMsg')): ?>
                <div class="ui-widget">
                    <div style="margin-top: 20px; padding: 0 .7em;"
                         class="ui-state-highlight ui-corner-all">
                        <p><span style="float: left; margin-right: .3em;"
                                 class="ui-icon ui-icon-info"></span>
                            <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($sf_flash->has('errorMsg')): ?>
                <div class="ui-widget">
                    <div style="margin-top: 20px; padding: 0 .7em;"
                         class="ui-state-error ui-corner-all">
                        <p><span style="float: left; margin-right: .3em;"
                                 class="ui-icon ui-icon-alert"></span>
                            <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                    </div>
                </div>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    </div>
    <div class="clear"></div>

    <div class="resultsViewer">
        <form action="/member/activateMember" method="post" id="memberForm">
<!--            <input type="hidden" id="distributorId">-->

            <div style="padding: 10px; top: 30px; width: 98%">

                <!--<div class="portlet">
                    <div class="portlet-header"><?php /*echo __('Inactive Traders') */?></div>
                    <div class="portlet-content">

                        <table class="display" id="datagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <th><?php /*echo __('Trader ID') */?></th>
                                <th><?php /*echo __('Alias') */?></th>
                                <th><?php /*echo __('Registered Time') */?></th>
                                <th><?php /*echo __('Action') */?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
/*                            if (count($pendingDistributors) > 0) {
                                $trStyle = "even";
                                foreach ($pendingDistributors as $dist) {
                                    if ($trStyle == "even") {
                                        $trStyle = "odd";
                                    } else {
                                        $trStyle = "even";
                                    }

                                    echo "<tr class='" . $trStyle . "'>
				        <td>" . $dist->getDistributorCode() . "</td><td>" . $dist->getNickname() . "</td>
				        <td>" . $dist->getCreatedOn() . "</td>
				        <td>" . link_to(__('Active'), '#', array(
                                       'class' => 'activeLink',
                                       'ref' => $dist->getDistributorId(),
                                       'refCode' => $dist->getDistributorCode(),
                                       'refNickname' => $dist->getFullname(),
                                       'refCreatedDate' => $dist->getCreatedOn(),
                                  )) . "&nbsp;" . link_to(__('Delete'), 'member/delete?distid=' . $dist->getDistributorId(), array(
                                          'class' => 'deleteLink',
                                          'confirm=Are you sure you want to remove?'
                                                                             )) . "</td></tr>";
                                }
                            } else {
                                echo "<tr class='odd' align='center'><td colspan='4'>" . __('No data available in table') . "</td></tr>";
                            }
                            */?>
                            </tbody>
                        </table>
                    </div>
                </div>-->

                <div class="portlet">
                    <div class="portlet-header"><?php echo __('Announcements') ?></div>
                    <div class="portlet-content">
                        <table class="display" id="datagridAnnouncement" border="0" width="100%" cellpadding="0"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th>Announcement Id[hidden]</th>
                                <th><?php echo __('Title') ?></th>
                                <th width="25%"><?php echo __('Date') ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="dgActivateMember" title="<?php echo __('Activate Trader') ?>" style="display:none;">
    <input type="hidden" id="dgActivateMember_ecash">
    <input type="hidden" id="dgActivateMember_pointAvail"/>
    <table cellspacing="5" cellpadding="3">
        <tr>
            <td class="text" width="30%"><label><?php echo __('Trader ID') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgActivateMember_shareholderId"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Full Name') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgActivateMember_alias"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Registered Time') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgActivateMember_registeredTime"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Package Type') ?></label></td>
            <td>:</td>
            <td>
                <select name="dgActivateMember_point" id="dgActivateMember_point"
                        class='text ui-widget-content ui-corner-all'>

                </select>
                <input type="text" disabled="disabled" id="dgActivateMember_pointNeeded"
                       class="text ui-widget-content ui-corner-all" size="10px"/>
            </td>
        </tr>
        <tr style="display: none">
            <td class="text"><label><?php echo __('Payment Type') ?></label></td>
            <td>:</td>
            <td>
                <span id="spanPaymentType">
                    <input type="radio" id="paymentTypeEPoint" name="paymentType" value="epoint"/><label for="paymentTypeEPoint"><?php echo __('e-Point') ?></label>
                    <input type="radio" id="paymentTypeECash" name="paymentType" value="ecash"/><label for="paymentTypeECash"><?php echo __('MT4 Credit') ?></label>
                </span>
            </td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Security Password') ?></label></td>
            <td>:</td>
            <td><input type="password" id="dgActivateMember_transactionPassword"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
    </table>
</div>

<div id="dgAnnouncement" title="<?php echo __('Announcements') ?>" style="display:none;">
    <table cellspacing="5">
        <tr>
            <td class="text" id="tdAnnouncement"></td>
    </table>
</div>