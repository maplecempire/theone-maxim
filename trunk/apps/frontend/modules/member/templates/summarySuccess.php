<?php include('scripts.php'); ?>
<?php
$culture = $sf_user->getCulture();

?>

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
        var answer = confirm("<?php echo __("Are you sure you want to remove this member?") ?>");
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
    $(".placementLeftLink").button({
        icons: {
            primary: "ui-icon-arrow-1-sw"
        }
    }).click(function(event){
        event.preventDefault();
        var answer = confirm("<?php echo __("Are you sure you want to do auto placement (LEFT)?") ?>");
        if (answer){
            waiting()
            $("#autoDistid").val($(this).attr("ref"));
            $("#placement").val("<?php echo __("LEFT") ?>");
            $("#frmAutoPlacement").submit();
        }
    });
    $(".placementRightLink").button({
        icons: {
            primary: "ui-icon-arrow-1-se"
        }
    }).click(function(event){
        event.preventDefault();
        var answer = confirm("<?php echo __("Are you sure you want to do auto placement (RIGHT)?") ?>");
        if (answer){
            waiting()
            $("#autoDistid").val($(this).attr("ref"));
            $("#placement").val("<?php echo __("RIGHT") ?>");
            $("#frmAutoPlacement").submit();
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
                    alert("<?php echo __("In-sufficient CP1 amount") ?>: " + $("#dgActivateMember_pointAvail").val());
                    $("#dgActivateMember_point").focus().select();
                } else if ($("#paymentTypeECash").is(':checked') == true && parseFloat($("#dgActivateMember_point").val()) > parseFloat($("#dgActivateMember_ecash").val())){
                    alert("<?php echo __("In-sufficient MT4 Credit") ?>: " + $("#dgActivateMember_ecash").val());
                    $("#dgActivateMember_point").focus().select();
                } else {
                    if ($.trim($("#dgActivateMember_transactionPassword").val()) == "") {
                        error("<?php echo __("Security Password is empty") ?>");
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
                            error("<?php echo __("Server connection error.") ?>");
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
    <?php
    $modalFormAppear = "false";
    if ($notificationOfMaturity) {
        $modalFormAppear = "true";
    }
    ?>
    $("#dgMaturity").dialog("destroy");
    $("#dgMaturity").dialog({
        autoOpen : <?php echo $modalFormAppear;?>,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        width: 600,
        buttons: {
            "<?php echo __('Renew Contract') ?>": function() {
                if ($("#needToUp").val() == "Y") {
                    var answer = confirm("<?php echo __("Your balance in the MT4 has fallen below your initial capital investment amount, Please top-up if you want to continue to renew your contract.") ?> \n<?php echo __("Do you want to navigate to MT4 Reload page?") ?>");
                    if (answer){
                        window.location = "<?php echo url_for("/member/reloadTopup")?>";
                    }
                }
                var answer = confirm("<?php echo __("Are you sure want to renew your contract?") ?>");
                if (answer){
                    waiting();
                    $("#maturityAction").val("RENEW");
                    $("#maturityForm").submit();
                }
            },
            "<?php echo __('Terminate Contract') ?>": function() {
                var answer = confirm("<?php echo __("Are you sure want to terminate your contract?") ?>");
                if (answer){
                    waiting();
                    $("#maturityAction").val("WITHDRAW");
                    $("#maturityForm").submit();
                }
            },
            "<?php echo __('Close') ?>": function() {
                $(this).dialog('close');
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
                error("<?php echo __("Your login attempt was not successful. Please try again.") ?>");
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
        <!--<div class="ui-widget">
            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                 class="ui-state-highlight ui-corner-all">
                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                         class="ui-icon ui-icon-info"></span>
                    <strong>Dear Members,
<br>亲爱的会员,
<br>
<br>Our data centre experienced some technical problems at 2PM Malaysian time (GMT +8) today which resulted in loss of certain data.
<br>The system is presently down and we expect to restore the system by 9PM Malaysian time. Once the system is up, all members are kindly requested to re-key in all AGL and Maxim Trader transactions starting from 11AM today, 5 February 2015.
<br>
<br>很抱歉从今天下午2点(GMT+8)开始, 我们的数据中心出现了一些技术问题, 造成少许数据的丢失; 目前我们已经关闭系统服务器, 预计今天晚上9点会恢复正常; 一旦系统恢复, 请会员配合 - 如果您于今天(2015.2.5日)上午11点后有AGL或者马胜的入单或交易, 请重新操作.
<br>
<br>We truly apologize for any inconvenience caused.
<br>为此造成的不便,我们表示万分的抱歉!
<br>
<br>Thank you, 谢谢!
<br>CEO
<br>Maxim Trader
<br>马胜金融首席执行官</strong></p>
            </div>
        </div>-->
        <!--<div class="ui-widget">
            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                 class="ui-state-highlight ui-corner-all">
                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                         class="ui-icon ui-icon-info"></span>
                    <strong>SSS Promo Cut Off Date !!!
<br>
<br>Dear IMs and Partners,
<br>
<br>The SSS Promo which is opened to anyone and everyone to enjoy preferred R-Shares @$0.80 will officially end at 2359hrs on June 30th 2015.
<br>
<br>Thereafter, the SSS R-Shares will be @$1.50 per R-Share.
<br>
<br>HESITATE NO MORE..... TAKE ADVANTAGE OF THIS ONCE IN A LIFETIME OPPORTUNITY TO SUPER MAXIMIZE YOUR INVESTMENT !!!
<br>
<br>In Service
<br>Dr Andrew Lim
<br>CEO - MCL
<br>
<br>超级股票转换优惠最后截止日期!!!
<br>
<br>亲爱的会员及伙伴们:
<br>
<br>请注意: 当前对所有会员开放的以0.8美金一股认购R股的超级股票转换优惠计划最后的截止日期为2015.6.30日晚上23:59分.
<br>
<br>之后，股票转换优惠R股认购的价格将为1.5美金一股.
<br>
<br>请大家不要再犹豫! 抓住这千载难逢的好机会, 最大化的实现您的投资利润!!!
<br>
<br>敬上,
<br>Andrew Lim博士
<br>马胜金融集团首席执行官
<br>
<br>SSS 프로모션 컷 오프 데이트!!!
<br>
<br>친애하는 국제회원 및 파트너 여러분
<br>
<br>모두에게 열려있으며 주당 0.80 달러의 R-쉐어의 특혜를 주는SSS 프로모션이 공식적으로 2015년 6월 30일 23시 59분에 마감됩니다.
<br>
<br>더 이상 망설이지 마십시오….  귀하의 투자를 극대화 시킬 수 있는 이 일생 한번 올 이 최고의 기회를 잡으십시오!!!
<br>
<br>귀하를 위하는
<br>앤드류 림
<br>CEO - MCL
<br>
<br>SSSプロモ・カットオフ日!!!
<br>
<br>IMおよびパートナーのみなさん
<br>
<br>全員に公開され、誰もが0.80USDで好きなR-シェアを入手できたSSSプロモは、公式に2015年6月30日の23時59分に終了します。
<br>
<br>その後、SSS RシェアはR-シェアあたり1.50USDとなります。
<br>
<br>もう迷っている時間はありません……。一生に一度の、あなたの投資を強力に最大化するこの機会を生かしましょう。
<br>
<br>いつでもあなたのそばに
<br>アンドリュー・リム
<br>CEO-MCL</strong></p>
            </div>
        </div>-->
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
            /*$joinDate = $distMt4->getCreatedOn();

            $c = new Criteria();
            $c->add(MlmRoiDividendPeer::MT4_USER_NAME, $distMt4->getMt4UserName());
            $c->add(MlmRoiDividendPeer::IDX, 1);
            $mlmRoiDividendDB = MlmRoiDividendPeer::doSelectOne($c);

            if ($mlmRoiDividendDB) {
                $joinDate = $mlmRoiDividendDB->getFirstDividendDate();

                $timevalue = strtotime($joinDate);
                $joinDate = date("Y-m-d h:i:s", strtotime("-1 months", $timevalue));
            }*/
            $arr = explode(" ", $joinDate);
            $joinDate = $arr[0];
//            echo "<span style='margin:1px;' class='".$colorArr[$distMt4->getRankId()]."_tags'>".$distMt4->getMt4UserName()." [".$joinDate."]</span>&nbsp;";
            echo "<span style='margin:1px;' class='".$colorArr[$distMt4->getRankId()]."_tags'>".$distMt4->getMt4UserName()."</span>&nbsp;";
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

    <tr class="tbl_form_row_odd">
        <td>&nbsp;</td>
        <td><?php echo __('CP4 Account') ?></td>
        <td><input type="text" readonly="readonly" value="<?php echo number_format($cp4,2); ?>"></td>
        <td>&nbsp;</td>
    </tr>
<?php if ($distributor->getFromAbfx() == "N") { ?>
    <tr class="tbl_form_row_even">
        <td>&nbsp;</td>
        <td><?php echo __('RT Account') ?></td>
        <td><input type="text" readonly="readonly" value="<?php echo number_format($distributor->getRtwallet(),2); ?>"></td>
        <td>&nbsp;</td>
    </tr>
<?php } ?>
<?php if ($rp > 0) { ?>
    <tr class="tbl_form_row_even">
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

                            $hideRestructureButton = "";
                            $bonusService = new BonusService();
                            if ($bonusService->hideGenealogy() == true) {
                                $hideRestructureButton = "display:none";
                            }
                    echo "<tr class='row" . $trStyle . "'>
                    <td align='center'>" . $dist->getActiveDatetime() . "</td>
                    <td align='center' class='date'>" . $dist->getDistributorCode() . "</td>
                    <td align='center'>" . $dist->getFullName() . "</td>
                    <td align='center'>" .
                         link_to(__('Restructure'), 'member/placementTree?bePlacementId=' . $dist->getDistributorId(), array(
                                   'class' => 'activeLink',
                                   'style' => $hideRestructureButton,
                                   'ref' => $dist->getDistributorId(),
                                   'refCode' => $dist->getDistributorCode(),
                                   'refNickname' => $dist->getFullname(),
                                   'refCreatedDate' => $dist->getCreatedOn(),
                              )) . "&nbsp;" . link_to(__('Delete'), 'member/delete' , array(
                                      'class' => 'deleteLink',
                                      'style' => 'display:none',
                                      'ref' => $dist->getDistributorId()
                                                                         ))
                         . "&nbsp;" . link_to(__('Auto Left'), 'member/placementTree' , array(
                                      'class' => 'placementLeftLink',
                                      'ref' => $dist->getDistributorId(),
                                      'style' => 'display:none',
                                      'placement' => 'LEFT'))
                         . "&nbsp;" . link_to(__('Auto Right'), 'member/placementTree' , array(
                                      'class' => 'placementRightLink',
                                      'ref' => $dist->getDistributorId(),
                                      'style' => 'display:none',
                                      'placement' => 'RIGHT'
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

<form action="/member/doAutoplacement" id="frmAutoPlacement" name="frmAutoPlacement">
    <input type="hidden" id="autoDistid" name="distid">
    <input type="hidden" id="placement" name="placement">
</form>

<?php if ($notificationOfMaturity) { ?>
<form action="/maturityAccount/doMaturityAction" id="maturityForm" name="maturityForm">
    <input type="hidden" id="maturityNotificationId" name="maturityNotificationId" value="<?php echo $notificationOfMaturity->getNoticeId(); ?>">
    <input type="hidden" id="maturityAction" name="maturityAction" value="RENEW">
    <input type="hidden" id="maturityMt4Balance" name="maturityMt4Balance" value="<?php echo $mt4Balance; ?>">
    <input type="hidden" id="needToUp" name="needToUp" value="<?php echo $needTopup; ?>">
</form>
<div id="dgMaturity" style="display:none; width: 850px" title="<?php echo __("RENEWAL NOTICE")?>">
    <table width="100%">
        <tr>
            <td colspan="3">
                <p><?php echo __("Dear International Member")?>,</p>
                <br><strong>MT4: <?php echo $notificationOfMaturity->getMt4UserName(); ?></strong>
                <br><strong>Balance: <?php echo $mt4Balance. " (". $mt4BalanceDate .")"; ?></strong>
                <br>
                <br>
                <?php if ($culture == "cn") { ?>
                <p>请注意一旦您的合同期满，您将不再继续享受推荐和投资回报；为了继获得高额回报，我们将自动为您续期合同18个月。一旦续期，您将继续享受来自公司市场推荐制度所带来的奖金以及每月投资分红。</p>
                <br>
                <br><strong>1.	MT4余额低于初始本金</strong>
                <br>
                <br>注: 如果您的MT4余额低于您的初始入金，我们建议您充值至初始本金额度以继续享受由公司市场推荐制度产生的推荐奖金及投资分红。如果您未在合同到期日之前充值，您的账户将在合同到期日之后被暂时搁置，直到您充值至初始本金额度。一旦账户额度达到初始本金额度，您将重新开始享受推荐奖金及每月投资分红
                <br>
                <br><strong>2.	不继续合同</strong>
                <br>
                <br>如果您个人决定不再继续合同，请于公司网站会员专区选择“不再续期”选项。请按照要求填写“合同不再续期”表格并邮件至maturity@maximtrader.com. 您MT4账号中最后的余额（合同到期届时，投资本金等同于MT4交易账户中的最后余额），将会在合同到期日后14天之内转入您的CP3账户。公司会将您CP2与CP3款项全部支付给您，之后您的个人账户将会从系统中注销，因此您将不再享受马胜市场推荐制度所带来的任何获利。
                <br>
                <br><strong>3.	6个月不得重新加入</strong>
                <br>
                <br>如果您选择终止合同，公司严格规定6个月之内您将不得再次投资马胜，敬请遵守。
                <br>
                <br><strong>4.	欲知更多详情，欢迎邮件至maturity@maximtrader.com.</strong>
                <br>
                <br>谢谢！
                <br>
                <br>Andrew Lim 博士
                <br>首席执行官
                <br>马胜金融集团
                <?php } else if ($culture == "kr") { ?>
                <p>귀하의 계좌가 만기에 도달하면 더 이상 추천비와 투자 수익을 받으실 수 없음을 인지하시기 바랍니다. 높은 수익률을 계속 즐기시기 위해서 당사는 자동으로 18개월의 계약을 할 것입니다.  다른 방법으로는 홈페이지에 가셔서 “갱신” 옵션을 선택하실 수도 있습니다.  갱신하신 이후에는 당사의 추천 프로그램에 의해 제공되는 보너스와 월별 실적 수익을 받으실 수 있습니다.</p>
                <br>
                <br><strong>1.	MT4 구좌의 부족분</strong>
                <br>
                <br>MT4의 발란스가 초기 투자금에 미치지 못 할 경우에는 원금의 금액만큼 더 입금하셔야 당사의 추천 프로그램에 의한 보너스와 월별 실적 수익을 받으실 수 있습니다.  만기일까지 원금의 금액만큼 입금하시지 않을 경우, 원금의 금액만큼 입금하실때까지 계좌가 동결됩니다.  부족분을 입금하신 후에는, 입금일부터 추천 프로그램에 의한 보너스와 월별 실적 수익을 받으실 수 있습니다.
                <br>
                <br><strong>2.	계약을 갱신하지 않을 경우</strong>
                <br>
                <br>어떠한 이유에서든 귀하가 계약을 갱신하기를 원하지 않을 경우, 홈페이지에 가셔서 “비갱신” 옵션을 선택하십시오.  “비갱신” 양식을 작성하셔서 maturity@maximtrader.com으로 이메일을 보내주시기 바랍니다.  귀하의 최종 MT4 잔고 (만기일에 MT4 계좌에 표시되어 있는 원금에 대한 잔고)가 귀하의 CP3 계좌로 만기일로부터 14일 이내에 입금될 것입니다.  CP2와 CP3의 잔고를 평상시와 같은 방법으로 다음의 인출 사이클에 따라 인출하실 수 있습니다.  지급이 이루어지면 귀하의 계좌는 폐쇄됩니다.
                <br>
                <br><strong>3.	6개월 제외 조치</strong>
                <br>
                <br>계약을 갱신하지 않기로 결정하셨다면 만기일로부터 6개월 동안은 맥심 트레이더에 재 가입이 불가능합니다
                <br>
                <br><strong>4.	자세한 사항을 알고 싶으시면 maturity@maximtrader.com으로 이 메일 보내주시기 바랍니다.</strong>
                <br>
                <br>감사합니다.
                <br>
                <br>Dr. Andrew Lim
                <br>최고경영자
                <br>맥심 캐피탈 주식회사
                <?php } else if ($culture == "jp") { ?>
                <p>あなたのアカウントが満期を迎えると、今後紹介プログラムや投資プログラムからの権利を獲得することができなくなることにどうぞご注意ください。高いリターンを続けてお楽しみいただくために、私たちはあなたのアカウントの契約を自動的に18ヵ月延長します。またはあなたはウエブサイトに行き、「renew」を選択していただくこともできます。一度更新すると、紹介プログラムからのボーナスや、月間パフォーマンスに対するリターンをお受け取りいただけます。 </p>
                <br>
                <br><strong>1.	MT口座の不足</strong>
                <br>
                <br>もしあなたのMT4口座残高が初期の投資額を下回ると、私たちはあなたが引き続き紹介プログラムや月間のパフォーマンスリターンを楽しめるように、初期投資の金額にトップアップするようにお勧めしています。もしあなたが満期日までにトップアップしない場合、あなたのアカウントは完全にトップアップするまで保留となります。一度トップアップすれば、あなたは紹介プログラムや月間パフォーマンスリターンを受け取る権利を、トップアップした日から使うことができます。
                <br>
                <br><strong>2.	契約を更新しない場合</strong>
                <br>
                <br>どのような理由にしろ、もしあなたが契約を更新したくない場合は、どうぞ弊社のウエブサイトに行き、「non renewal」を選択してください。そしてさらに「non-renewal of contract」フォームを完成し、maturity@maximtrader.com.までeメールを送っていただく必要があります。あなたの最終的なMT4口座の残高（満期日におけるMT4口座の残高に示される初期投資金額）は満期日の14日以内に、CP3口座に入金されます。あなたはその後、あなたのCP2およびCP3の残高を通常の次の引き出しサイクルにて、引き出すことができます。一度引き出しが行われると口座は閉鎖されます。
                <br>
                <br><strong>3.	6ヵ月の除外措置</strong>
                <br>
                <br>一度あなたが契約の更新をしないことを決定すると、あなたはマキシムトレ   ーダーに満期日より6ヵ月は再登録することができなくなることにどうぞご注意ください。
                <br>
                <br><strong>4.	さらに説明が必要な場合は、どうぞmaturity@maximtrader.comにメールしてください。</strong>
                <br>
                <br>ありがとうございました。
                <br>
                <br>Andrew Lim 博士
                <br>最高経営責任者
                <br>マキシム・キャピタル・リミテッド
                <?php } else { ?>
                <p>Please note that once your account reaches maturity, you will not be entitled to earn from our referral and investment programs. In order to continue enjoying high returns, we will automatically renew your contract for another 18 months. Alternatively, you may also go into the website and select the ‘renew’ option. Once you renew, you will be entitled to earn the bonuses offered by our referral programs and earn monthly performance returns. </p>
                <br>
                <br><strong>1.	Shortfall in the MT4 account</strong>
                <br>
                <br>If your balance in the MT4 has fallen below your initial capital investment amount, we invite you to top-up to its original sum so that you can continue to be entitled to bonuses offered by our referral programs and enjoy monthly performance returns. If you do not top-up by the maturity date, your account will be put on hold until you fully top-up to its original sum. Once topped up, you will be entitled to our referral program and earn monthly performance returns from the date of top up.
                <br>
                <br><strong>2.	Non-renewal of contract</strong>
                <br>
                <br>For any reason, if you do not wish to renew your contract, please go to the website and select the ‘non-renewal’ option. You are also required to complete the ‘non-renewal of contract’ form and email to maturity@maximtrader.com. Your FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date) will then be credited into your CP3 account within 14 days after maturity date. You may then withdraw your CP2 and CP3 balances in the usual manner at the next withdrawal cycle. Once the payment is made, your account will be closed.
                <br>
                <br><strong>3.	Six months exclusion</strong>
                <br>
                <br>Please note if you decide not to renew your contract, you are not allowed to re-join Maximtrader for a period of 6 months after the maturity date.
                <br>
                <br><strong>4.	Please email to maturity@maximtrader.com if you need further clarifications.</strong>
                <br>
                <br>Thank you,
                <br>
                <br>Dr. Andrew Lim
                <br>Chief Executive Officer
                <br>Maxim Capital Limited
                <?php }  ?>
            </td>
        </tr>
    </table>
</div>
<?php } ?>