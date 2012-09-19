<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>

<style type="text/css">
.logoTooltip{
    cursor: pointer;
}
.tooltip{
    width:200px;
    border:1px solid black;
    padding:2px 5px;
    background:lightblue;
    position:absolute;
    top:-10px;
    left:50px;
    text-align:left;
    z-index:999;
    display:none;
}
</style>
<script type="text/javascript">
var packageStrings = "<option value=''></option>";
var datagrid = null;
$(function() {
    datagrid = $("#datagrid").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData){ // pass extra params to server
            aoData.push( { "name": "filterFullname", "value": $("#search_fullname").val()  } );
            /*aoData.push( { "name": "filterNickname", "value": $("#search_nickname").val()  } );*/
        },
        "reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
            reassignDatagridEventAttr();
        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "<?php echo url_for('member/pendingMemberList') ?>",
        "sPaginationType": "full_numbers",
        "aaSorting": [[7,'desc']],
        "aoColumns": [
		              { "sName" : "distributor_id", "bVisible" : false},
		              { "sName" : "distributor_id",  "bSortable": false, "fnRender": function ( oObj ) {
                            return "<a class='placementLink' id='placementLink' href='#'><?php echo __('Place Here');?></a>";
		  				}},
                        { "sName" : "created_on",  "bSortable": true},
                        { "sName" : "distributor_code",  "bSortable": true},
                        { "sName" : "full_name",  "bSortable": true},
                        { "sName" : "nickname",  "bVisible": false},
                        { "sName" : "ic",  "bSortable": true},
                        { "sName" : "rank_code",  "bSortable": true}
		]
    });

    $(".viewDetail").button({
        icons: {
            primary: "ui-icon-circle-zoomin"
        }
    }).click(function(event){
        waiting();
    });
    $(".placement").button({
        icons: {
            primary: "ui-icon-circle-plus"
        }
    }).click(function(event){
        event.preventDefault();
        $("#dgActivateMember").dialog("open");
        $("#uplineDistCode").val($(this).attr("uplineDistCode"));
        $("#uplinePosition").val($(this).attr("uplinePosition"));
    });
    $("#dgActivateMember").dialog("destroy");
    $("#dgActivateMember").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        width: 800,
        open: function() {
            datagrid.fnDraw();
        },
        close: function() {

        }
    });

    $(".logoTooltip").mouseover(function(e) {
        if ($('#tooltip').is(":hidden")) {
            var position = $(this).position();

            var top = position.top;
            var left = position.left + 100;

            $("#_distCode").html($(this).attr("distCode"));
            $("#_activeDatetime").html($(this).attr("activeDatetime"));
            $("#_rankCode").html($(this).attr("rankCode"));
            $("#_daily").html($(this).attr("daily"));
            $("#_carry_left").html($(this).attr("carry_left"));
            $("#_carry_right").html($(this).attr("carry_right"));
            $("#_sales_left").html($(this).attr("sales_left"));
            $("#_sales_right").html($(this).attr("sales_right"));
            $('#tooltip').css('top', top + "px");
            $('#tooltip').css('left', left + "px");
            $('#tooltip').fadeIn('500');
            $('#tooltip').fadeTo('10', 0.9);
        }
    }).mouseout(function() {
        $('#tooltip').hide();
    });
    <?php
        if ($errorSearch == true) {
            echo "alert('Invalid Trader ID.');";
        }
    ?>
});

function reassignDatagridEventAttr(){
    $(".placementLink").button({
        icons: {
            primary: "ui-icon-arrowthickstop-1-s"
        },
        text: false
    }).click(function(event){
		// stop event
		event.preventDefault();

		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		//var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(this).parent().parent().attr("id");
        $("#sponsorDistId").val(id);

        var sure = confirm("<?php echo __('Are you sure want to place this member into this position?') ?>");
        if (sure) {
            waiting();
            $("#doAction").val("save");
            $("#transferForm").submit();
        }
	});
}
</script>

<table>
    <tr>
        <td>
            <div class="ewallet_li">
                <a target="_self" class="navcontainer" href="/member/sponsorTree" style="color: rgb(0, 93, 154);">
                    <?php echo __('Sponsor Genealogy'); ?>
                </a>
                &nbsp;&nbsp;
                <img src="/images/arrow_blue_single_tab.gif">
                &nbsp;&nbsp;
                <a target="_self" class="navcontainer" href="/member/placementTree" style="color: rgb(134, 197, 51);">
                    <?php echo __('Placement Genealogy'); ?>
                </a>
                &nbsp;&nbsp;
                <img src="/images/arrow_blue_single_tab.gif">
                &nbsp;&nbsp;
                <a target="_self" class="navcontainer" href="/member/placementTree?p=stat" style="color: rgb(0, 93, 154);">
                    <?php echo __('Downline Stats'); ?>
                </a>
            </div>
        </td>
    </tr>
</table>


<form action="/member/placementTree" id="transferForm" method="post">
    <input type="hidden" name="uplineDistCode" id="uplineDistCode">
    <input type="hidden" name="uplinePosition" id="uplinePosition">
    <input type="hidden" name="sponsorDistId" id="sponsorDistId">
    <input type="hidden" name="doAction" id="doAction">
    <input type="hidden" name="p" id="<?php echo $pageDirection; ?>">

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td><br></td>
</tr>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title">Placement Genealogy</span></td>
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
    <div id="tooltip" class="tooltip">
        <table class="statsNode" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td><b id="_distCode"></b></td>
                <td colspan="2" id="_activeDatetime"></td>
            </tr>
            <tr>
                <td><?php echo __('Package Rank');?></td>
                <td colspan="2" id="_rankCode"></td>
            </tr>
            <tr>
                <td><?php echo __('Daily Max');?></td>
                <td colspan="2" id="_daily"></td>
            </tr>
            <tr>
                <td></td>
                <td>Left</td>
                <td>Right</td>
            </tr>
            <tr>
                <td><?php echo __('Carry Forward');?></td>
                <td id="_carry_left"></td>
                <td id="_carry_right"></td>
            </tr>
            <tr>
                <td><?php echo __('This Month Sales');?></td>
                <td id="_sales_left"></td>
                <td id="_sales_right"></td>
            </tr>
            </tbody>
        </table>
    </div>
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tbody>
                <tr>
                    <td colspan="18" align="left"><?php echo __("Trader ID")?>&nbsp;
                        <input size="8" type="text" id="distcode" name="distcode" value="<?php echo $distcode ?>"/>
                        <button id="btnSearch"><?php echo __('Search') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            <tr>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="5.5%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
            </tr>
            <tr>
                <?php
                    $imgStr = "";
                    if ($distDB->getRankCode())



                    $distCode = $anode[0]['distCode'];
                    $availableButton = $anode[0]['_available'];
                    $textStr = "";
                    $classAndAttr = "";
                    if ($distCode != "") {
                        $distDB = $anode[0]['_self'];
                        $distPairingLedgerDB = $anode[0]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        //$textStr = $distDB->getNickName();
                        //$textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
                        //$textStr .= "<br>".$distDB->getCreatedOn();
                        //$textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                        //$textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                        //$textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                        //$textStr .= "<br>".__('This Month CPS').": ".number_format($anode[0]['_left_this_month_sales'],0)." | ".number_format($anode[0]['_right_this_month_sales'],0);
                        //$textStr .= "<br>";
                        $classAndAttr .= " class='logoTooltip'";
                        $classAndAttr .= " distCode='".$distCode."'";
                        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
                        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
                        $classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
                        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
                        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
                        $classAndAttr .= " sales_left='".number_format($anode[0]['_left_this_month_sales'],0)."'";
                        $classAndAttr .= " sales_right='".number_format($anode[0]['_right_this_month_sales'],0)."'";
                    }
                ?>
                <td colspan="18" align="center"><img src="/css/maxim/tree/head.png" <?php echo $classAndAttr;?>></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="18" align="center">
                    <strong>
                    <?php
                    $distCode = $anode[0]['distCode'];
                    $availableButton = $anode[0]['_available'];
                    $textStr = "";
                    if ($distCode != "") {
                        $distDB = $anode[0]['_self'];
                        $distPairingLedgerDB = $anode[0]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        $textStr = $distDB->getNickName();
                        $textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
                        //$textStr .= "<br>".$distDB->getCreatedOn();
                        //$textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                        //$textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                        //$textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                        //$textStr .= "<br>".__('This Month CPS').": ".number_format($anode[0]['_left_this_month_sales'],0)." | ".number_format($anode[0]['_right_this_month_sales'],0);
                        //$textStr .= "<br>";
                    ?>
                    <?php
                    } else if ($availableButton == true) {
                        $textStr .= "<br><a href='#' class='placement'>".__('Available')."</a>";
                    }

                    echo $textStr;
                    ?>
                    </strong>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="6" style="border-right:1mm solid #2284C6; border-bottom:1mm solid #2284C6">&nbsp;</td>
                <td colspan="6" style="border-bottom:1mm solid #2284C6">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="6" style="border-left:1mm solid #2284C6">&nbsp;</td>
                <td colspan="6" style="border-right:1mm solid #2284C6">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <?php
                    $distCode = $anode[1]['distCode'];
                    $availableButton = $anode[1]['_available'];
                    $textStr = "";
                    $classAndAttr = "";
                    if ($distCode != "") {
                        $distDB = $anode[1]['_self'];
                        $distPairingLedgerDB = $anode[1]['_dist_pairing_ledger'];

                        $classAndAttr .= " class='logoTooltip'";
                        $classAndAttr .= " distCode='".$distCode."'";
                        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
                        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
                        $classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
                        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
                        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
                        $classAndAttr .= " sales_left='".number_format($anode[1]['_left_this_month_sales'],0)."'";
                        $classAndAttr .= " sales_right='".number_format($anode[1]['_right_this_month_sales'],0)."'";
                    }
                ?>
                <td colspan="6" align="center"><img src="/css/maxim/tree/head.png" <?php echo $classAndAttr;?>></td>
                <td colspan="6" align="center"></td>
                <?php
                    $distCode = $anode[2]['distCode'];
                    $availableButton = $anode[2]['_available'];
                    $textStr = "";
                    $classAndAttr = "";
                    if ($distCode != "") {
                        $distDB = $anode[2]['_self'];
                        $distPairingLedgerDB = $anode[2]['_dist_pairing_ledger'];

                        $classAndAttr .= " class='logoTooltip'";
                        $classAndAttr .= " distCode='".$distCode."'";
                        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
                        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
                        $classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
                        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
                        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
                        $classAndAttr .= " sales_left='".number_format($anode[2]['_left_this_month_sales'],0)."'";
                        $classAndAttr .= " sales_right='".number_format($anode[2]['_right_this_month_sales'],0)."'";
                    }
                ?>
                <td colspan="6" align="center"><img src="/css/maxim/tree/head.png" <?php echo $classAndAttr;?>></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" align="center">
                    <strong>
                    <?php
                    $distCode = $anode[1]['distCode'];
                    $availableButton = $anode[1]['_available'];
                    $textStr = "";
                    if ($distCode != "") {
                        $distDB = $anode[1]['_self'];
                        $distPairingLedgerDB = $anode[1]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        $textStr = $distDB->getNickName();
                        $textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
//                        $textStr .= "<br>".$distDB->getCreatedOn();
//                        $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
//                        $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
//                        $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
//                        $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[1]['_left_this_month_sales'],0)." | ".number_format($anode[1]['_right_this_month_sales'],0);
//                        $textStr .= "<br>";
                    } else if ($availableButton == true) {
                        $textStr .= "<br><a href='#' class='placement' uplinePosition='LEFT' uplineDistCode='".$anode[0]['distCode']."'>".__('Available')."</a>";
                    }

                    echo $textStr;
                    ?>
                    </strong>
                </td>
                <td colspan="6" align="center"></td>
                <td colspan="6" align="center">
                    <strong>
                    <?php
                    $distCode = $anode[2]['distCode'];
                    $availableButton = $anode[2]['_available'];
                    $textStr = "";
                    if ($distCode != "") {
                        $distDB = $anode[2]['_self'];
                        $distPairingLedgerDB = $anode[2]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        $textStr = $distDB->getNickName();
                        $textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
//                        $textStr .= "<br>".$distDB->getCreatedOn();
//                        $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
//                        $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
//                        $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
//                        $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[2]['_left_this_month_sales'],0)." | ".number_format($anode[2]['_right_this_month_sales'],0);
//                        $textStr .= "<br>";
                    } else if ($availableButton == true) {
                        $textStr .= "<br><a href='#' class='placement' uplinePosition='RIGHT' uplineDistCode='".$anode[0]['distCode']."'>".__('Available')."</a>";
                    }

                    echo $textStr;
                    ?>
                    </strong>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2" style="border-right:1mm solid #2284C6; border-bottom:1mm solid #2284C6">&nbsp;</td>
                <td colspan="2" style="border-bottom:1mm solid #2284C6">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2" style="border-right:1mm solid #2284C6; border-bottom:1mm solid #2284C6">&nbsp;</td>
                <td colspan="2" style="border-bottom:1mm solid #2284C6">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2" style="border-left:1mm solid #2284C6">&nbsp;</td>
                <td colspan="2" style="border-right:1mm solid #2284C6">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2" style="border-left:1mm solid #2284C6">&nbsp;</td>
                <td colspan="2" style="border-right:1mm solid #2284C6">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <?php
                    $distCode = $anode[3]['distCode'];
                    $availableButton = $anode[3]['_available'];
                    $textStr = "";
                    $classAndAttr = "";
                    if ($distCode != "") {
                        $distDB = $anode[3]['_self'];
                        $distPairingLedgerDB = $anode[3]['_dist_pairing_ledger'];

                        $classAndAttr .= " class='logoTooltip'";
                        $classAndAttr .= " distCode='".$distCode."'";
                        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
                        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
                        $classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
                        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
                        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
                        $classAndAttr .= " sales_left='".number_format($anode[3]['_left_this_month_sales'],0)."'";
                        $classAndAttr .= " sales_right='".number_format($anode[3]['_right_this_month_sales'],0)."'";
                    }
                ?>
                <td colspan="2" align="center"><img src="/css/maxim/tree/head.png" <?php echo $classAndAttr;?>></td>
                <td colspan="2" align="center"></td>

                <?php
                    $distCode = $anode[4]['distCode'];
                    $availableButton = $anode[4]['_available'];
                    $textStr = "";
                    $classAndAttr = "";
                    if ($distCode != "") {
                        $distDB = $anode[4]['_self'];
                        $distPairingLedgerDB = $anode[4]['_dist_pairing_ledger'];

                        $classAndAttr .= " class='logoTooltip'";
                        $classAndAttr .= " distCode='".$distCode."'";
                        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
                        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
                        $classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
                        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
                        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
                        $classAndAttr .= " sales_left='".number_format($anode[4]['_left_this_month_sales'],0)."'";
                        $classAndAttr .= " sales_right='".number_format($anode[4]['_right_this_month_sales'],0)."'";
                    }
                ?>
                <td colspan="2" align="center"><img src="/css/maxim/tree/head.png" <?php echo $classAndAttr;?>></td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center"></td>
                <?php
                    $distCode = $anode[5]['distCode'];
                    $availableButton = $anode[5]['_available'];
                    $textStr = "";
                    $classAndAttr = "";
                    if ($distCode != "") {
                        $distDB = $anode[5]['_self'];
                        $distPairingLedgerDB = $anode[5]['_dist_pairing_ledger'];

                        $classAndAttr .= " class='logoTooltip'";
                        $classAndAttr .= " distCode='".$distCode."'";
                        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
                        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
                        $classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
                        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
                        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
                        $classAndAttr .= " sales_left='".number_format($anode[5]['_left_this_month_sales'],0)."'";
                        $classAndAttr .= " sales_right='".number_format($anode[5]['_right_this_month_sales'],0)."'";
                    }
                ?>
                <td colspan="2" align="center"><img src="/css/maxim/tree/head.png" <?php echo $classAndAttr;?>></td>
                <td colspan="2" align="center"></td>
                <?php
                    $distCode = $anode[6]['distCode'];
                    $availableButton = $anode[6]['_available'];
                    $textStr = "";
                    $classAndAttr = "";
                    if ($distCode != "") {
                        $distDB = $anode[6]['_self'];
                        $distPairingLedgerDB = $anode[6]['_dist_pairing_ledger'];

                        $classAndAttr .= " class='logoTooltip'";
                        $classAndAttr .= " distCode='".$distCode."'";
                        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
                        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
                        $classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
                        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
                        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
                        $classAndAttr .= " sales_left='".number_format($anode[6]['_left_this_month_sales'],0)."'";
                        $classAndAttr .= " sales_right='".number_format($anode[6]['_right_this_month_sales'],0)."'";
                    }
                ?>
                <td colspan="2" align="center"><img src="/css/maxim/tree/head.png" <?php echo $classAndAttr;?>></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center" >
                <strong>
                    <?php
                    $distCode = $anode[3]['distCode'];
                    $availableButton = $anode[3]['_available'];
                    $textStr = "";
                    if ($distCode != "") {
                        $distDB = $anode[3]['_self'];
                        $distPairingLedgerDB = $anode[3]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        $textStr = $distDB->getNickName();
                        $textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
//                        $textStr .= "<br>".$distDB->getCreatedOn();
//                        $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
//                        $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
//                        $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
//                        $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[3]['_left_this_month_sales'],0)." | ".number_format($anode[3]['_right_this_month_sales'],0);
//                        $textStr .= "<br>";
                    } else if ($availableButton == true) {
                        $textStr .= "<br><a href='#' class='placement' uplinePosition='LEFT' uplineDistCode='".$anode[1]['distCode']."'>".__('Available')."</a>";
                    }

                    echo $textStr;
                    ?>
                    </strong>
                </td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center">
                    <strong>
                    <?php
                    $distCode = $anode[4]['distCode'];
                    $availableButton = $anode[4]['_available'];
                    $textStr = "";
                    if ($distCode != "") {
                        $distDB = $anode[4]['_self'];
                        $distPairingLedgerDB = $anode[4]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        $textStr = $distDB->getNickName();
                        $textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
//                        $textStr .= "<br>".$distDB->getCreatedOn();
//                        $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
//                        $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
//                        $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
//                        $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[4]['_left_this_month_sales'],0)." | ".number_format($anode[4]['_right_this_month_sales'],0);
//                        $textStr .= "<br>";
                    } else if ($availableButton == true) {
                        $textStr .= "<br><a href='#' class='placement' uplinePosition='RIGHT' uplineDistCode='".$anode[1]['distCode']."'>".__('Available')."</a>";
                    }

                    echo $textStr;
                    ?>
                    </strong>
                </td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center">
                    <strong>
                    <?php
                    $distCode = $anode[5]['distCode'];
                    $availableButton = $anode[5]['_available'];
                    $textStr = "";
                    if ($distCode != "") {
                        $distDB = $anode[5]['_self'];
                        $distPairingLedgerDB = $anode[5]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        $textStr = $distDB->getNickName();
                        $textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
//                        $textStr .= "<br>".$distDB->getCreatedOn();
//                        $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
//                        $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
//                        $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
//                        $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[5]['_left_this_month_sales'],0)." | ".number_format($anode[5]['_right_this_month_sales'],0);
//                        $textStr .= "<br>";
                    } else if ($availableButton == true) {
                        $textStr .= "<br><a href='#' class='placement' uplinePosition='LEFT' uplineDistCode='".$anode[2]['distCode']."'>".__('Available')."</a>";
                    }

                    echo $textStr;
                    ?>
                    </strong>
                </td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center">
                    <strong>
                    <?php
                    $distCode = $anode[6]['distCode'];
                    $availableButton = $anode[6]['_available'];
                    $textStr = "";
                    if ($distCode != "") {
                        $distDB = $anode[6]['_self'];
                        $distPairingLedgerDB = $anode[6]['_dist_pairing_ledger'];
                        //$timeStamp = strtotime($distDB->getCreatedOn());
                        //$dateString = date(Globals::FULL_DATETIME_FORMAT, $timeStamp);

                        $textStr = $distDB->getNickName();
                        $textStr .= "<br><a href='".url_for("/member/placementTree?distcode=".$distCode)."' class='viewDetail'>".$distCode."</a>";
//                        $textStr .= "<br>".$distDB->getCreatedOn();
//                        $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
//                        $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
//                        $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
//                        $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[6]['_left_this_month_sales'],0)." | ".number_format($anode[6]['_right_this_month_sales'],0);
//                        $textStr .= "<br>";
                    } else if ($availableButton == true) {
                        $textStr .= "<br><a href='#' class='placement' uplinePosition='RIGHT' uplineDistCode='".$anode[2]['distCode']."'>".__('Available')."</a>";
                    }

                    echo $textStr;
                    ?>
                    </strong>
                </td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>
</form>

<div id="dgActivateMember" title="<?php echo __('Activate Trader') ?>" style="display:none;">
    <table class="display" id="datagrid" border="0" width="100%">
        <thead>
        <tr>
            <th>distributor_id[hidden]</th>
            <th width="30px"></th>
            <th><?php echo __('Registered Date') ?></th>
            <th><?php echo __('Member') ?></th>
            <th><?php echo __('Full Name') ?></th>
            <th><?php echo __('Alias') ?></th>
            <th><?php echo __('Passport/ID Card No') ?></th>
            <th><?php echo __('Package Rank') ?></th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><input size="15" type="text" id="search_fullname" value="" class="search_init" /></td>
            <td><input size="15" type="text" id="search_nickname" value="" class="search_init" /></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
    </table>
</div>