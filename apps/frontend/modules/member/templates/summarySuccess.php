<?php include('scripts.php'); ?>

<style type="text/css">
#popupContact {
    top: -100px !important;
}
</style>

<script type='text/javascript' src='/js/popup.js'></script>
<script type="text/javascript">
var packageStrings = "<option value=''></option>";
var datagrid = null;
var datagridAnnouncement = null;
var annoucementArr = [];
annoucementArr.push({
    poptitle:'Maxim Trader Incentive For February 2013 - Bangkok March Workshop (BMW) 马胜金融集团 2013年二月奖励计划 - 曼谷投资检讨会 2013年2月インセンティブ·プラン - バンコク投資レビュー',
    news_date:'18 FEB 2013',
    news_desc:'<br><br><a target="_blank" href="#"><img width="460" border="0" alt="Maxim Trader" src="/images/email/Bangkok_March_Workshop.jpg"></a><br>'
});
annoucementArr.push({
    poptitle:'Apply EzyCash Card Now!!!',
    news_date:'20 FEB 2013',
    news_desc:'<br><br><a target="_self" href="/member/applyEzyCashCard"><img width="460" border="0" alt="Maxim Trader" src="/images/email/apply_ezycash_card_debit_card.png"></a>Start from today Maxim Trader clients may <a href="/member/applyEzyCashCard" style="color: #3333ff;">apply an EzyAccount</a> anytime.<br><br>EzyAccount is an extremely secure and convenient way for you to send and receive money from Maxim Trader.'
});
<?php
$culture = $sf_user->getCulture();
$postfix = "_english";
if ($culture == "en")
        $postfix = "_english";
    else if ($culture == "jp")
        $postfix = "_english";
    else
        $postfix = "_chinese";
?>
annoucementArr.push({
    poptitle:'Maxim Trader to participate in the 10th CHINA GUANGZHOU INTERNATIONAL INVESTMENT AND FINANCE EXPO 第十届广州国际投资理财金融博览会 2013年3月5-7日',
    news_date:'21 FEB 2013',
    news_desc:'<br><br><a target="_blank" href="#"><img width="460" border="0" alt="Maxim Trader" src="/images/email/maxim_international<?php echo $postfix;?>.jpg"></a><br>'
});

var popIndex = 1;
$(function() {
    loadContent(popIndex);

    centerPopup();
    loadPopup();

	$("#popupContactClose,#popupContactClose2,#backgroundPopup").click(function(){
		disablePopup();
        if ($(annoucementArr).length > popIndex) {
            popIndex++;
            loadContent(popIndex);
            centerPopup();
            loadPopup();
        }
	});
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
    });
    $(".activeLink").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    }).click(function(event) {
        /*event.preventDefault();
        waiting();
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
        });*/
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
function loadContent(popIndex) {
    var obj = annoucementArr[popIndex -1];
    $(".poptitle").html(obj.poptitle);
    $(".news_date").html(obj.news_date);
    $(".news_desc").html(obj.news_desc);
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
        <td><?php echo __('User Name') ?></td>
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
        <td><input size="40" type="text" readonly="readonly" value="<?php echo $ranking; ?>"></td>
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
        <th><?php echo __('Inactive Traders') ?></th>
        <th class="tbl_content_right"></th>
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
                    <td><?php echo __('Username') ?></td>
                    <td><?php echo __('Full Name') ?></td>
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
                    <td>" . $dist->getCreatedOn() . "</td>
                    <td class='date'>" . $dist->getDistributorCode() . "</td><td>" . $dist->getFullName() . "</td>
                    <td>" . link_to(__('Active'), 'member/purchasePackage?p=' . $dist->getDistributorId(), array(
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
                ?>
                </tbody>
            </table>
            <div><?php echo count($pendingDistributors);?> <?php echo __('records') ?>.</div>
        </td>
    </tr>
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
        <th><?php echo __('Fund Management Listing') ?></th>
        <th class="tbl_content_right"></th>
        <th class="tbl_header_right">
            <div class="border_right_grey">&nbsp;</div>
        </th>
    </tr>
    <tr>
        <td colspan="4">
            <table class="pbl_table" cellpadding="3" cellspacing="3">
                <tbody>
                <colgroup>
                    <col width="5%">
                    <col width="45%">
                    <col width="25%">
                    <col width="25%">
                </colgroup>
                <tr class="pbl_header">
                    <td><?php echo __('') ?></td>
                    <td><?php echo __('MT4 ID') ?></td>
                    <td><?php echo __('Unrealized Profit') ?></td>
                    <td><?php echo __('Realized Profit') ?></td>
                </tr>
                <?php
                    if (count($fundManagements) > 0) {
                        $trStyle = "1";
                        $idx = 1;
                        foreach ($fundManagements as $fundManagement) {
                            if ($trStyle == "1") {
                                $trStyle = "0";
                            } else {
                                $trStyle = "1";
                            }

                                echo "<tr class='row" . $trStyle . "'>
                                <td align='center'>" . $idx++ . "</td>
                                <td align='center'><a href='#' class='linkMt4' ref='".$fundManagement['mt4_user_name']."'>" . $fundManagement['mt4_user_name'] . "</a></td>
                                <td align='right'>" . number_format($fundManagement['unrealized_profit'], 2) . "</td>
                                <td align='right'>" . number_format($fundManagement['realized_rofit'], 2) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr class='odd' align='center'><td colspan='4'>" . __('No data available in table') . "</td></tr>";
                        }
                ?>
                </tbody>
            </table>
            <script type="text/javascript">
                $(function() {
                    $(".linkMt4").click(function(event){
                        event.preventDefault();
                        var mt4Id = $(this).attr("ref");

                        $("#divMt4Roi").html("<img src='/images/common/indicator.gif'>");
                        $("#divMt4Roi").show();

                        $.ajax({
                            type : 'POST',
                            url : "/finance/fetchRoiList",
                            dataType : 'json',
                            cache: false,
                            data: {
                                mt4UserId : mt4Id
                            },
                            success : function(data) {
                                $.unblockUI();
                                var table = "<table class='pbl_table' cellpadding='3' cellspacing='3'><tbody><colgroup>";
                                table += "<col width='5%'>";
                                table += "<col width='20%'>";
                                table += "<col width='20%'>";
                                table += "<col width='20%'>";
                                table += "<col width='20%'>";
                                table += "<col width='15%'>";
                                table += "</colgroup>";
                                table += "<tr class='pbl_header'>";
                                table += "<td></td>";
                                table += "<td>Dividend Date</td>";
                                table += "<td>Amount</td>";
                                table += "<td>ROI Percentage</td>";
                                table += "<td>Dividend Amount</td>";
                                table += "<td>Status</td>";
                                table += "</tr>";

                                var trStyle = "1";
                                var idx = 1;
                                jQuery.each(data.mlmRoiDividends, function(key, value) {
                                    if (trStyle == "1") {
                                        trStyle = "0";
                                    } else {
                                        trStyle = "1";
                                    }
                                    table += "<tr class='row" + trStyle + "'>";
                                    table += "<td align='center'>" + value[0] + "</td>";
                                    table += "<td align='center'>" + value[1] + "</td>";
                                    table += "<td align='right'>" + value[2] + "</td>";
                                    table += "<td align='right'>" + value[3] + "</td>";
                                    table += "<td align='right'>" + value[4] + "</td>";
                                    table += "<td align='center'>" + value[5] + "</td>";
                                    table += "</tr>";
                                });

                                table += "</tbody></table>";
                                $("#divMt4Roi").html(table);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("Server connection error.");
                            }
                        });
                    });
                });

            </script>
            <div id="divMt4Roi" style="display: none;"><img src="/images/common/indicator.gif"></div>
        </td>
    </tr>
    </tbody>
</table>
<!--- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --->
<!--- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --->
<!--- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --->
<!--- aside end --->
<!--- content --->
<div class="areaContent" style="display: none;">
    <div class="resultsWrap">

    </div>
    <div class="clear"></div>

    <div class="resultsViewer">
        <form action="/member/activateMember" method="post" id="memberForm">
<!--            <input type="hidden" id="distributorId">-->

            <div style="padding: 10px; top: 30px; width: 98%">

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
                    <input type="radio" id="paymentTypeEPoint" name="paymentType" value="epoint"/><label for="paymentTypeEPoint"><?php echo __('CP1') ?></label>
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

<!--####################################################################################################-->
<!--####################################################################################################-->
<!--####################################################################################################-->
<!--####################################################################################################-->
<?php
$tempDisable = true;
if ($tempDisable == true) { ?>
<div style="position: absolute; display: none;" id="popupContact">
    <h1><?php echo __('Latest News') ?></h1>
    <a id="popupContactClose"><?php echo __('CLOSE') ?></a>

    <p id="contactArea">
        <!--<img src='http://www.abfxtrader.com/ablive/nimages/site/eidalfitr-2012.jpg' />-->
    </p>

    <div class="popdivider"></div>

    <?php
    $culture = $sf_user->getCulture();
    //foreach ($announcements as $announcement) { ?>
    <div class="popinfo1">
        <!--<a href="<?php /*echo url_for("/member/announcement?id=".$announcement->getAnnouncementId())*/?>">-->
            <div class="poptitle"><?php
                /*if ($culture == "en")
                    echo $announcement->getTitle();
                else if ($culture == "jp")
                    echo $announcement->getTitleJp();
                else
                    echo $announcement->getTitleCn();*/
                ?>
            Maxim Trader Incentive For February 2013 - Bangkok March Workshop (BMW) 马胜金融集团 2013年二月奖励计划 - 曼谷投资检讨会 2013年2月インセンティブ·プラン - バンコク投資レビュー
            </div>
        <!--</a>-->

        <div class="news_date">
        <?php
            $dateUtil = new DateUtil();
            //$currentDate = $dateUtil->formatDate("Y-m-d", $announcement->getCreatedOn());
            //echo $currentDate;
            echo "18 FEB 2013";
            ?>
        </div>
        <div class="news_desc">
            <?php
            /*if ($culture == "en")
                echo $announcement->getShortContent();
            else if ($culture == "jp")
                echo $announcement->getShortContentJp();
            else
                echo $announcement->getShortContentCn();*/

            ?>

            <br><br><a target="_blank" href="#"><img width="460" border="0" alt="Maxim Trader" src="http://partner.maximtrader.com/images/email/Bangkok_March_Workshop.jpg"></a><br>
        </div>
    </div>
    <div class="popdivider"></div>
    <?php //} ?>
    <p></p>
    <a id="popupContactClose2"><?php echo __('CLOSE') ?></a><br>
</div>
<div style="height: 572px; opacity: 0.7; display: none;" id="backgroundPopup"></div>
<?php } ?>