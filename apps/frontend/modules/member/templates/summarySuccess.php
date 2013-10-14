<?php include('scripts.php'); ?>

<script type="text/javascript">
var packageStrings = "<option value=''></option>";
var datagrid = null;
var datagridAnnouncement = null;

$(function() {
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
            if ($(annoucementArr).length > popIndex) {
                popIndex++;
                loadContent(popIndex);
                centerPopup();
                loadPopup();
            }
        }
	});

    /*$("#popupContactClose, #popupContactClose2").click(function(){
        $("#youtubeFrame").remove();
    });*/
    /*datagrid = $("#datagridAnnouncement").r9jasonDataTable({
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
    });*/
    $(".news_desc_1").click(function(event){
        event.preventDefault();

        $("#news_desc_1").show(500);
        $(this).hide();
    });
    $(".deleteLink").button({
        icons: {
            primary: "ui-icon-circle-close"
        }
    }).click(function(event){
        event.preventDefault();
        var answer = confirm("Are you sure you want to remove this member?");
        if (answer){
            waiting()
            $("#distid").val($(this).attr("ref"));
            $("#frmDeleteMember").submit();
        }
    });
    $(".activeLink").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
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
                    error("<?php echo __("In-sufficient fund to purchase package.");?>");
                    $("#dgActivateMember_point").focus().select();
                } else if ($("#paymentTypeEPoint").is(':checked') == true && parseFloat($("#dgActivateMember_point").val()) > parseFloat($("#dgActivateMember_pointAvail").val())){
                    alert("In-sufficient CP1. " + $("#dgActivateMember_pointAvail").val());
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
        hide: 'fade',
        show: 'fade',
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
        $content = "You have not upload the documents below yet : <br><br><ul style='list-style:none outside none'>";

        if ($distributor->getFileBankPassBook() == "") {
            $content .= "<li>- Bank Account Proof</li>";
        }
        if ($distributor->getFileProofOfResidence() == "") {
            $content .= "<li>- Proof of Residence</li>";
        }
        if ($distributor->getFileNric() == "") {
            $content .= "<li>- Passport/IC</li>";
        }
        $content .= "</ul>";
    ?>
        $("#tdAnnouncement").html("<strong><?php echo $content;?></strong>");
        $("#dgAnnouncement").dialog("option", "title", "Document Upload");
        $("#dgAnnouncement").dialog("option", "height", "250");
        $("#dgAnnouncement").dialog("option", "width", "500");
        /*$("#dgAnnouncement").dialog("open");*/
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

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Summary') ?></span></td>
</tr>
<tr>
    <td><br>
        <?php if ($sf_flash->has('successMsg')): ?>
        <div class="ui-widget">
            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                 class="ui-state-highlight ui-corner-all">
                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                         class="ui-icon ui-icon-info"></span>
                    <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($sf_flash->has('errorMsg')): ?>
        <div class="ui-widget">
            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                 class="ui-state-error ui-corner-all">
                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                         class="ui-icon ui-icon-alert"></span>
                    <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
            </div>
        </div>
        <?php endif; ?>

    </td>
</tr>
<tr>
<td>

<table cellspacing="0" cellpadding="0" class="textarea1">
<tbody>
<tr>
<td>
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
        <th><?php echo __('Account Information') ?></th>
        <th class="tbl_content_right"></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Member ID') ?></td>
        <td><input size="40" type="text" readonly="readonly" value="<?php echo $distributor->getDistributorCode(); ?>"></td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('MT4 ID') ?></td>
        <!-- <td><input size="40" type="text" readonly="readonly" value="--><?php //echo $mt4Id; ?><!--"></td>-->
        <td>
            <style>
                .blue_tags {
                    background-color: #0099cc;
                    border-radius: 2px 2px 2px 2px;
                    box-shadow: 2px #004977;
                    border-color: transparent #0089E0 transparent transparent;
                    border-style: solid;
                }
                .green_tags {
                    background-color: #33ff33;
                    border-radius: 2px 2px 2px 2px;
                    box-shadow: 2px #66ff00;
                    border-color: transparent #66ff00 transparent transparent;
                    border-style: solid;
                }
                .red_tags {
                    background-color: #ff6666;
                    border-radius: 2px 2px 2px 2px;
                    box-shadow: 2px #ff3333;
                    border-color: transparent #ff3333 transparent transparent;
                    border-style: solid;
                }
                .gold_tags {
                    background-color: #ffff33;
                    border-radius: 2px 2px 2px 2px;
                    box-shadow: 2px #ffcc33;
                    border-color: transparent #ffcc33 transparent transparent;
                    border-style: solid;
                }
                .pink_tags {
                    background-color: #ff99ff;
                    border-radius: 2px 2px 2px 2px;
                    box-shadow: 2px #ffcc33;
                    border-color: transparent #cc00cc transparent transparent;
                    border-style: solid;
                }
                .white_tags {
                    background-color: #ffffff;
                    border-radius: 2px 2px 2px 2px;
                    box-shadow: 2px #ffcc33;
                    border-color: transparent #ffcc33 transparent transparent;
                    border-style: solid;
                }
            </style>

        <?php
        foreach ($distMt4s as $distMt4) {
            $joinDate = $distMt4->getCreatedOn();

            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $distMt4->getMt4UserName());
            $c->add(MlmRoiDividendPeer::IDX, 1);
            $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

            if ($mlmRoiDividendDB) {
                $joinDate = $mlmRoiDividendDB->getFirstDividendDate();

                $timevalue = strtotime($joinDate);
                $joinDate = date("Y-m-d h:i:s", strtotime("-1 months", $timevalue));
            }
            $arr = explode(" ", $joinDate);
            $joinDate = $arr[0];
            echo "<span style='margin:1px;' class='".$colorArr[$distMt4->getRankId()]."_tags'>".$distMt4->getMt4UserName()." [".$joinDate."]</span>&nbsp;";
        }
        ?>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Ranking') ?></td>
        <td><input size="40" type="text" readonly="readonly" value="<?php echo __($ranking); ?>"></td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('Status') ?></td>
        <td><input size="40" type="text" readonly="readonly" value="<?php echo $distributor->getStatusCode(); ?>"></td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Last Login') ?></td>
        <td><input size="40" type="text" readonly="readonly" value="<?php echo $lastLogin; ?>"></td>
        <td>&nbsp;</td>
    </tr>


    <!--<tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php /*echo __('Total Networks') */?></td>
        <td><input size="40" type="text" readonly="readonly" value="<?php /*echo $totalNetworks; */?>"></td>
        <td>&nbsp;</td>
    </tr>-->

    <!--<tr class="tbl_listing_end">
        <td colspan="4">
            &nbsp;
        </td>
    </tr>-->
    </tbody>
</table>

<div class="info_bottom_bg"></div>
<div class="clear"></div>
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
        <th><?php echo __('Your Account Point') ?></th>
        <th class="tbl_content_right"></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Currency') ?>:</td>
        <td><input type="text" readonly="readonly" value="<?php echo $currencyCode; ?>"></td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('CP1 Account') ?></td>
        <td><input type="text" readonly="readonly" value="<?php echo number_format($epoint,2); ?>"></td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('CP2 Account') ?></td>
        <td><input type="text" readonly="readonly" value="<?php echo number_format($ecash,2); ?>"></td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('CP3 Account') ?></td>
        <td><input type="text" readonly="readonly" value="<?php echo number_format($maintenancePoint,2); ?>"></td>
        <td>&nbsp;</td>
    </tr>

<?php if ($rp > 0) { ?>
    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('RP Account') ?></td>
        <td><input type="text" readonly="readonly" value="<?php echo number_format($rp,2); ?>"></td>
        <td>&nbsp;</td>
    </tr>
<?php } ?>
<?php
    if ($distributor->getDebitAccount() == "Y") {
        // hide from korea group
        $hide = false;
        $pos = strrpos($distributor->getTreeStructure(), "|255607|");
        if ($pos === false) { // note: three equal signs

        } else {
            $hide = true;
        }
        if ($hide == false) {
    ?>
    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('Debit Account') ?></td>
        <td><input type="text" readonly="readonly" value="<?php echo number_format($debitAccount,2); ?>"></td>
        <td>&nbsp;</td>
    </tr>
    <?php } ?>
<?php } ?>
    <!--<tr class="tbl_listing_end">
        <td colspan="4">
            &nbsp;
        </td>
    </tr>-->
    </tbody>
</table>
<div class="info_bottom_bg"></div>
<div class="clear"></div>
<br>
<!--============================================================-->
<!--<table cellspacing="0" cellpadding="0" class="tbl_form">
    <colgroup>
        <col width="1%">
        <col width="23%">
        <col width="18%">
        <col width="13%">
        <col width="18%">
        <col width="18%">
        <col width="1%">
    </colgroup>

    <tbody>
    <tr class="row_header">
        <th class="tbl_header_left">
            <div class="border_left_grey">&nbsp;</div>
        </th>
        <th colspan="5">
            Transaction Limit
        </th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td colspan="5">
            You can change your funds transfer and bill payment limit by entering your desired limit in the "New Limit"
            column. <br><br>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><b>Transaction Type</b></td>
        <td><b>Maximum Limit (MYR)</b></td>
        <td>&nbsp;</td>
        <td><b>Existing Limit (MYR)</b></td>
        <td><b>New Limit (MYR)</b></td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>
            3rd Party SCB Funds Transfer:
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="60,000.00"></td>
        <td>
            <a href="https://ibank.standardchartered.com.my/nfs/ibank/preference_limit_detail_link.htm?a=doViewLimitDetail&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC"
               target="_blank">
                View limit detail
            </a>
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="60,000.00"></td>
        <td>
            <input type="text" maxlength="10" size="20" value="60,000.00" name="customerTxnLimitList[0].newLimit"
                   id="customerTxnLimitList[0].newLimit">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>
            Interbank Funds Transfer:
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="5,000.00"></td>
        <td>
            <a href="https://ibank.standardchartered.com.my/nfs/ibank/preference_limit_detail_link.htm?a=doViewLimitDetail&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC"
               target="_blank">
                View limit detail
            </a>
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="5,000.00"></td>
        <td>
            <input type="text" maxlength="10" size="20" value="5,000.00" name="customerTxnLimitList[1].newLimit"
                   id="customerTxnLimitList[1].newLimit">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td>
            Bill Payment:
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="5,000.00"></td>
        <td>
            <a href="https://ibank.standardchartered.com.my/nfs/ibank/preference_limit_detail_link.htm?a=doViewLimitDetail&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC"
               target="_blank">
                View limit detail
            </a>
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="5,000.00"></td>
        <td>
            <input type="text" maxlength="10" size="20" value="5,000.00" name="customerTxnLimitList[2].newLimit"
                   id="customerTxnLimitList[2].newLimit">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td>
            International Funds Transfer:
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="10,000.00"></td>
        <td>
            <a href="https://ibank.standardchartered.com.my/nfs/ibank/preference_limit_detail_link.htm?a=doViewLimitDetail&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC&amp;r=011859FD-ADA8-623A-1202-39E4601E69DC"
               target="_blank">
                View limit detail
            </a>
        </td>
        <td><input maxlength="10" size="20" readonly="readonly" value="10,000.00"></td>
        <td>
            <input type="text" maxlength="10" size="20" value="10,000.00" name="customerTxnLimitList[3].newLimit"
                   id="customerTxnLimitList[3].newLimit">
            &nbsp;
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="tbl_listing_end">
        <td>&nbsp;</td>
        <td class="tbl_content_right" colspan="5"></td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>-->
<!--============================================================-->

</td>
</tr>
<tr>
    <td></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<?php
    if ($distributor->getStatusCode() == Globals::STATUS_ACTIVE && $distributor->getPlacementTreeStructure() != null) { ?>
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
        <th colspan="2"><?php echo __('Immediate Member Restructuring') ?></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>

    <tr>
        <td colspan="4">
            <table class="pbl_table" cellpadding="3" cellspacing="3">
                <tbody>
                <tr class="pbl_header">
                    <td><?php echo __('Registered Date') ?></td>
                    <td><?php echo __('Member ID') ?></td>
                    <td><?php echo __('Name') ?></td>
                    <td><?php echo __('Action') ?></td>
                </tr>
                <?php
                    if (count($pendingDistributors) > 0) {
                        $trStyle = "1";
                        foreach ($pendingDistributors as $dist) {
                            if ($trStyle == "1") {
                                $trStyle = "0";
                            } else {
                                $trStyle = "1";
                            }

                    echo "<tr class='row" . $trStyle . "'>
                    <td align='center'>" . $dist->getCreatedOn() . "</td>
                    <td align='center' class='date'>" . $dist->getDistributorCode() . "</td>
                    <td align='center'>" . $dist->getFullName() . "</td>
                    <td align='center'>" . link_to(__('Restructure'), 'member/placementTree?bePlacementId=' . $dist->getDistributorId(), array(
                                   'class' => 'activeLink',
                                   'ref' => $dist->getDistributorId(),
                                   'refCode' => $dist->getDistributorCode(),
                                   'refNickname' => $dist->getFullname(),
                                   'refCreatedDate' => $dist->getCreatedOn(),
                              )) . "&nbsp;" . link_to(__('Delete'), 'member/delete' , array(
                                      'class' => 'deleteLink',
                                      'style' => 'display:none',
                                      'ref' => $dist->getDistributorId()
                                                                         )) . "</td></tr>";
                            }
                        } else {
                            echo "<tr class='odd' align='center'><td colspan='4'>" . __('No data available in table') . "</td></tr>";
                        }
                ?>
                </tbody>
            </table>
            <div><?php echo count($pendingDistributors);?> <?php echo __('records') ?>.</div>
        </td>
    </tr>
    </tbody>
</table>
<?php } ?>

<br>
<br>
<!--<table cellspacing="0" cellpadding="0" class="tbl_form">
    <colgroup>
        <col width="1%">
        <col width="30%">
        <col width="69%">
        <col width="1%">
    </colgroup>
    <tbody>
    <tr>
        <td colspan="4">
            <table class="pbl_table" cellpadding="3" cellspacing="3">
                <tr class="pbl_header">
                    <td colspan="2"><?php /*echo __('Maxim Trader Currency Whole Seller Market Currency Rate as effective from 10th Sep 2013:') */?></td>
                </tr>
                <tbody>
                <tr class="row0"><td>1. </td><td>Malaysia RM - RM3.30 / RM3.60                    </td></tr>
                <tr class="row1"><td>2. </td><td>Thailand Baht - B33/ B36                         </td></tr>
                <tr class="row0"><td>3. </td><td>Indonesia Rupiah - R11,000 / R12,000             </td></tr>
                <tr class="row1"><td>4. </td><td>China RMB - RMB6.30 / RMB7.00                    </td></tr>
                <tr class="row0"><td>5. </td><td>Taiwan New Dollar - NTD31 / NTD34                </td></tr>
                <tr class="row1"><td>6. </td><td>Hong Kong Dollar - HKD7.8/HKD8.5                 </td></tr>
                <tr class="row0"><td>7. </td><td>Japanese Yen - JPY                               </td></tr>
                <tr class="row1"><td>8. </td><td>Korean Won - KRW1,150/KRW1,250                   </td></tr>
                <tr class="row0"><td>9. </td><td>Phillipine Peso - PHP45/PHP50                    </td></tr>
                <tr class="row1"><td>10.</td><td>Singapore Dollar - SGD1.28/SGD1.40               </td></tr>
                <tr class="row0"><td>11.</td><td>Cambodia Riel - KHR4,100/KHR4,500                </td></tr>
                <tr class="row1"><td>12.</td><td>Vietnam Dong - VND22,000/VND24,000               </td></tr>
                <tr class="row0"><td>13.</td><td>India Rupee - INR68/INR75                        </td></tr>
                <tr class="row1"><td>14.</td><td>USD - USD1/USD1.1</td></tr>
<!--                <tr class="row1"><td>15.</td><td>AUD - AUD1.1/AUD1.2    </td></tr>-->
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>-->

<form action="/member/delete" id="frmDeleteMember" name="frmDeleteMember">
    <input type="hidden" id="distid" name="distid">
</form>
<div class="info_bottom_bg"></div>
<div class="clear"></div>
<br>