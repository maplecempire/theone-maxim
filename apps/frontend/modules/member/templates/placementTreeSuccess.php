<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>

<style type="text/css">
.logoTooltip{
    cursor: pointer;
}
.tooltip{
    width:300px;
    border:1px solid black;
    padding:2px 5px;
    background:lightblue;
    position:fixed;
    /*top:200px;*/
    /*right:200px;*/
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
            var top = e.clientY - 20;
            var left = e.screenX + 50;

            $("#_distCode").html($(this).attr("distCode"));
            $("#_activeDatetime").html($(this).attr("activeDatetime"));
            $("#_rankCode").html($(this).attr("rankCode"));
            $("#_daily").html($(this).attr("daily"));
            $("#_carry_left").html($(this).attr("carry_left"));
            $("#_carry_right").html($(this).attr("carry_right"));
            $("#_sales_left").html($(this).attr("sales_left"));
            $("#_sales_right").html($(this).attr("sales_right"));
            $("#_accumulate_left").html($(this).attr("accumulate_left"));
            $("#_accumulate_right").html($(this).attr("accumulate_right"));
            $("#_today_left").html($(this).attr("today_left"));
            $("#_today_right").html($(this).attr("today_right"));
            //$("#__id").html($(this).attr("_id"));
            $('#tooltip').css('top', top + "px");
            $('#tooltip').css('left', left + "px");
            $('#tooltip').fadeIn('10');
//            $('#tooltip').fadeTo('10', 0.9);
        }
    }).mouseout(function() {
        $('#tooltip').hide();
    });
    
    $(".network-register").click(function(event){
        event.preventDefault();
        var url = $(this).attr("href");
        var bePlacementId = $("#bePlacementId").val();
        var bePlacementDistCode = $("#bePlacementDistCode").val();

        if (bePlacementDistCode != "") {
            var sure = confirm("<?php echo __('Are you sure want to place this ');?>" + bePlacementDistCode + " <?php echo __('into this position?') ?>");
            if (sure) {
                waiting();
                $("#distcode").remove();
                $("#registerForm").attr("action", url + "&bePlacementId=" + bePlacementId);
                $("#registerForm").submit();
            }
        } else {
            $("#distcode").remove();
            $("#registerForm").attr("action", url + "&bePlacementId=" + bePlacementId);
            $("#registerForm").submit();
        }
    });
    
    <?php
        if ($errorSearch == true) {
            echo "alert('Invalid Member ID.');";
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
            $("#registerForm").submit();
        }
	});
}
</script>


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
</tbody>
</table>

<form action="/member/placementTree" id="registerForm" method="post">
    <input type="hidden" name="bePlacementId" id="bePlacementId" value="<?php echo $bePlacementId;?>">
    <input type="hidden" name="bePlacementDistCode" id="bePlacementDistCode" value="<?php echo $bePlacementDistCode;?>">
    <input type="hidden" name="uplineDistCode" id="uplineDistCode">
    <input type="hidden" name="uplinePosition" id="uplinePosition">
    <input type="hidden" name="sponsorDistId" id="sponsorDistId">
    <input type="hidden" name="doAction" id="doAction">
    <input type="hidden" name="p" id="<?php echo $pageDirection; ?>">
        <?php echo __("Member ID")?>&nbsp;<input size="20" id="distcode" name="distcode" value="<?php echo $distcode ?>"/>&nbsp;<button id="btnSearch"><?php echo __('Search') ?></button>
        <br>
</form>

<div id="dgActivateMember" title="<?php echo __('Activate Member') ?>" style="display:none;">
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

<link rel='stylesheet' type='text/css' media='screen' href='/css/network/network.css'/>

<div style="width: 600px;">
<div style="width: 60px; margin-left: 268px; text-align:center; float:left;" class="stats-node">
    <div id="tooltip" class="tooltip">
        <table class="statsNode placementTree" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td><b id="_distCode"></b></td>
                <td><?php echo __('Left');?></td>
                <td><?php echo __('Right');?></td>
            </tr>
            <tr>
                <td><?php echo __('Accumulate Group BV');?></td>
                <td id="_accumulate_left"></td>
                <td id="_accumulate_right"></td>
            </tr>
            <tr>
                <td><?php echo __('Today Group BV');?></td>
                <td id="_today_left"></td>
                <td id="_today_right"></td>
            </tr>
            <tr>
                <td><?php echo __('Carry Forward');?></td>
                <td id="_carry_left"></td>
                <td id="_carry_right"></td>
            </tr>
            <tr>
                <td><?php echo __('Today Total Group BV');?></td>
                <td id="_sales_left"></td>
                <td id="_sales_right"></td>
            </tr>
            <!--<tr>
                <td><?php /*echo __('Referrer ID');*/?></td>
                <td id="_referrer_id" colspan="2"></td>
            </tr>-->
            </tbody>
        </table>
    </div>

<?php
    $apService = new ApService();

    $distCode = $anode[0]['distCode'];
    $availableButton = $anode[0]['_available'];
    $textStr = "";
    $classAndAttr = "";
    $headColor = "";
    if ($distCode != "") {
        $distDB = $anode[0]['_self'];
        if ($hideDistGroup == true) {
            if ($apService->blockGenealogy($sf_user->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }

        $pos = strrpos($distDB->getPlacementTreeStructure(), "|339377|");
        if ($pos === false) { // note: three equal signs

        } else {
            if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 1 || $sf_user->getAttribute(Globals::SESSION_DISTID) == 339377) {

            } else {
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $headColor = $colorArr[$distDB->getRankId()]."_";
        //$distPairingLedgerDB = $anode[0]['_dist_pairing_ledger'];
        $classAndAttr .= " class='logoTooltip'";
        $classAndAttr .= " distCode='".$distCode."'";
        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
        //$classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
/*        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[0]['_left_this_month_sales'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[0]['_right_this_month_sales'],0)."'";*/
        $classAndAttr .= " accumulate_left='".number_format($anode[0]['_accumulate_left'],0)."'";
        $classAndAttr .= " accumulate_right='".number_format($anode[0]['_accumulate_right'],0)."'";
        $classAndAttr .= " today_left='".number_format($anode[0]['_today_left'],0)."'";
        $classAndAttr .= " today_right='".number_format($anode[0]['_today_right'],0)."'";
        $classAndAttr .= " carry_left='".number_format($anode[0]['_carry_left'],0)."'";
        $classAndAttr .= " carry_right='".number_format($anode[0]['_carry_right'],0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[0]['_sales_left'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[0]['_sales_right'],0)."'";
//        $classAndAttr .= " referrer_id='".$distDB->getUplineDistCode()."'";
    }
?>
<div class="network-top-more-node">
    <?php if ($isTop == false) {
        $topDist = MlmDistributorPeer::retrieveByPK($distDB->getTreeUplineDistId());
        if (!$topDist) {
            $topDist = new MlmDistributor();
        }
    ?>
        <a href="<?php echo url_for("/member/placementTree?distcode=".$topDist->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>"></a>
    <?php } ?>
</div>
    <a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>" style="font-size: 14px; font-weight: bold;">
        <!--<img rel="<?php /*echo $distDB->getDistributorCode()*/?>" src="/css/network/<?php /*echo $headColor; */?>head.png" --><?php /*echo $classAndAttr;*/?>
        <?php
            if ($distCode != "Restricted to view member information") {
                $pos = strrpos($distDB->getPlacementTreeStructure(), "|259817|");
                $pos2 = strrpos($distDB->getPlacementTreeStructure(), "|165|");
                $pos3 = strrpos($distDB->getPlacementTreeStructure(), "|132|");
                $pos4 = strrpos($distDB->getPlacementTreeStructure(), "|264504|");
                $isRemoveUS = false;
                $distCode = $distDB->getDistributorCode();
                $userDB = AppUserPeer::retrieveByPk($distDB->getUserId());
                $userName = $userDB->getUsername();
                if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -1);
                    if ($lastChar == "_") {
                        $distCode = substr($distCode, 0, -1);

                        $lastChar = substr($userName, -1);
                        if ($lastChar == "_") {
                            $userName = substr($userName, 0, -1);
                        }
                    }
                }

                $posDUS = strrpos($distDB->getPlacementTreeStructure(), "|317307|");
                $posDUS2 = strrpos($distDB->getPlacementTreeStructure(), "|254827|");
                if ($posDUS === true || $isRemoveUS == true) {
                    $lastChar = substr($distCode, -2);
                    if ($lastChar == "__") {
                        $distCode = substr($distCode, 0, -2);

                        $lastChar = substr($userName, -2);
                        if ($lastChar == "__") {
                            $userName = substr($userName, 0, -2);
                        }
                    }
                }

                echo $distCode." (".$userName.")";
            } else {
                echo $distDB->getDistributorCode();
            }
        ?>
    </a><br>

    <!--<div class="network-username"><?php /*echo $distDB->getDistributorCode()*/?></div>
    <div align="center" class="network-button-wraper"><a class="network-add-investment"
                                                         href="<?php /*echo url_for("/member/upgradePackageViaTree?distcode=".$distDB->getDistributorCode()) */?>">Add Investment</a>
    </div>-->
</div>
<div style="clear:both;"></div>
<div style="width: 300px; margin-left: 148px; float:left; height: 27px;">
    <div style="width: 2px; overflow-x: hidden; margin-left: 149px; height: 25px;"
         class="stats-node-line-up stats-node-line"></div>
    <div style="width: 302px; margin-left:-1px; overflow-y: hidden; height: 2px;"
         class="stats-node-line-side stats-node-line"></div>
</div>
<div style="clear:both;"></div>
<div style="width: 2px; overflow-x: hidden; margin-left: 147px; float:left; height: 25px;"
     class="stats-node-line-up stats-node-line"></div>
<div style="width: 2px; overflow-x: hidden; margin-left: 298px; float:left; height: 25px;"
     class="stats-node-line-up stats-node-line"></div>
<div style="clear:both;"></div>

<?php
    $distCode = $anode[1]['distCode'];
    $availableButton = $anode[1]['_available'];
    $textStr = "";
    $classAndAttr = "";
    $headColor = "";
    if ($distCode != "") {
        $distDB = $anode[1]['_self'];
        if ($hideDistGroup == true) {
            if ($apService->blockGenealogy($sf_user->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $pos = strrpos($distDB->getPlacementTreeStructure(), "|339377|");
        if ($pos === false) { // note: three equal signs

        } else {
            if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 1 || $sf_user->getAttribute(Globals::SESSION_DISTID) == 339377) {

            } else {
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $headColor = $colorArr[$distDB->getRankId()]."_";
        //$distPairingLedgerDB = $anode[1]['_dist_pairing_ledger'];

        $classAndAttr .= " class='logoTooltip'";
        $classAndAttr .= " distCode='".$distCode."'";
        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
        //$classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
/*        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[1]['_left_this_month_sales'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[1]['_right_this_month_sales'],0)."'";*/
        $classAndAttr .= " accumulate_left='".number_format($anode[1]['_accumulate_left'],0)."'";
        $classAndAttr .= " accumulate_right='".number_format($anode[1]['_accumulate_right'],0)."'";
        $classAndAttr .= " today_left='".number_format($anode[1]['_today_left'],0)."'";
        $classAndAttr .= " today_right='".number_format($anode[1]['_today_right'],0)."'";
        $classAndAttr .= " carry_left='".number_format($anode[1]['_carry_left'],0)."'";
        $classAndAttr .= " carry_right='".number_format($anode[1]['_carry_right'],0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[1]['_sales_left'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[1]['_sales_right'],0)."'";
//        $classAndAttr .= " referrer_id='".$distDB->getUplineDistCode()."'";
    }
?>

<div style="width: 60px; margin-left: 118px; text-align:center; float:left;" class="stats-node">
    <?php if ($distCode != "") { ?>
    <a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>" style="font-size: 14px; font-weight: bold;">
            <!--<img rel="<?php /*echo $distDB->getDistributorCode()*/?>" src="/css/network/<?php /*echo $headColor; */?>head.png" --><?php /*echo $classAndAttr;*/?>
            <?php
            if ($distCode != "Restricted to view member information") {
                $pos = strrpos($distDB->getPlacementTreeStructure(), "|259817|");
                $pos2 = strrpos($distDB->getPlacementTreeStructure(), "|165|");
                $pos3 = strrpos($distDB->getPlacementTreeStructure(), "|132|");
                $pos4 = strrpos($distDB->getPlacementTreeStructure(), "|264504|");
                $isRemoveUS = false;
                $distCode = $distDB->getDistributorCode();
                $userDB = AppUserPeer::retrieveByPk($distDB->getUserId());
                $userName = $userDB->getUsername();
                if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -1);
                    if ($lastChar == "_") {
                        $distCode = substr($distCode, 0, -1);

                        $lastChar = substr($userName, -1);
                        if ($lastChar == "_") {
                            $userName = substr($userName, 0, -1);
                        }
                    }
                }

                $posDUS = strrpos($distDB->getPlacementTreeStructure(), "|317307|");
                $posDUS2 = strrpos($distDB->getPlacementTreeStructure(), "|254827|");
                if ($posDUS === false && $posDUS2 === false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -2);
                    if ($lastChar == "__") {
                        $distCode = substr($distCode, 0, -2);

                        $lastChar = substr($userName, -2);
                        if ($lastChar == "__") {
                            $userName = substr($userName, 0, -2);
                        }
                    }
                }
                echo $distCode." (".$userName.")";
            } else {
                echo $distDB->getDistributorCode();
            }
        ?>
            </a><br>

    <!--<div class="network-username"><?php /*echo $distDB->getDistributorCode()*/?></div>
    <div align="center" class="network-button-wraper"><a class="network-add-investment"
                                                         href="<?php /*echo url_for("/member/upgradePackageViaTree?distcode=".$distDB->getDistributorCode()) */?>">Add Investment</a></div>-->
    <?php } else if ($availableButton == true) { ?>
        <div align="center" class="network-button-wraper"><a href="<?php echo url_for("/member/purchasePackageViaTree?distcode=".$anode[0]['distCode']."&position=left") ?>" class="network-register"><?php echo __('Register') ?></a>
        </div>
    <?php }?>
</div>

<?php
    $distCode = $anode[2]['distCode'];
    $availableButton = $anode[2]['_available'];
    $textStr = "";
    $classAndAttr = "";
    $headColor = "";
    if ($distCode != "") {
        $distDB = $anode[2]['_self'];
        if ($hideDistGroup == true) {
            if ($apService->blockGenealogy($sf_user->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }

        $pos = strrpos($distDB->getPlacementTreeStructure(), "|339377|");
        if ($pos === false) { // note: three equal signs

        } else {
            if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 1 || $sf_user->getAttribute(Globals::SESSION_DISTID) == 339377) {

            } else {
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $headColor = $colorArr[$distDB->getRankId()]."_";
        //$distPairingLedgerDB = $anode[2]['_dist_pairing_ledger'];

        $classAndAttr .= " class='logoTooltip'";
        $classAndAttr .= " distCode='".$distCode."'";
        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
        //$classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
/*        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[2]['_left_this_month_sales'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[2]['_right_this_month_sales'],0)."'";*/
        $classAndAttr .= " accumulate_left='".number_format($anode[2]['_accumulate_left'],0)."'";
        $classAndAttr .= " accumulate_right='".number_format($anode[2]['_accumulate_right'],0)."'";
        $classAndAttr .= " today_left='".number_format($anode[2]['_today_left'],0)."'";
        $classAndAttr .= " today_right='".number_format($anode[2]['_today_right'],0)."'";
        $classAndAttr .= " carry_left='".number_format($anode[2]['_carry_left'],0)."'";
        $classAndAttr .= " carry_right='".number_format($anode[2]['_carry_right'],0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[2]['_sales_left'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[2]['_sales_right'],0)."'";
//        $classAndAttr .= " referrer_id='".$distDB->getUplineDistCode()."'";
    }
?>
<div style="width: 60px; margin-left: 240px; text-align:center; float:left;" class="stats-node">
    <?php if ($distCode != "") { ?>
    <a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()) ?>" style="font-size: 14px; font-weight: bold;">
            <!--<img rel="<?php /*echo $distDB->getDistributorCode()*/?>" src="/css/network/<?php /*echo $headColor; */?>head.png" --><?php /*echo $classAndAttr;*/?>
            <?php
            if ($distCode != "Restricted to view member information") {
                $pos = strrpos($distDB->getPlacementTreeStructure(), "|259817|");
                $pos2 = strrpos($distDB->getPlacementTreeStructure(), "|165|");
                $pos3 = strrpos($distDB->getPlacementTreeStructure(), "|132|");
                $pos4 = strrpos($distDB->getPlacementTreeStructure(), "|264504|");
                $isRemoveUS = false;
                $distCode = $distDB->getDistributorCode();
                $userDB = AppUserPeer::retrieveByPk($distDB->getUserId());
                $userName = $userDB->getUsername();
                if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -1);
                    if ($lastChar == "_") {
                        $distCode = substr($distCode, 0, -1);

                        $lastChar = substr($userName, -1);
                        if ($lastChar == "_") {
                            $userName = substr($userName, 0, -1);
                        }
                    }
                }

                $posDUS = strrpos($distDB->getPlacementTreeStructure(), "|317307|");
                $posDUS2 = strrpos($distDB->getPlacementTreeStructure(), "|254827|");
                if ($posDUS === false && $posDUS2 === false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -2);
                    if ($lastChar == "__") {
                        $distCode = substr($distCode, 0, -2);

                        $lastChar = substr($userName, -2);
                        if ($lastChar == "__") {
                            $userName = substr($userName, 0, -2);
                        }
                    }
                }
                echo $distCode." (".$userName.")";
            } else {
                echo $distDB->getDistributorCode();
            }
        ?>
            </a><br>

    <!--<div class="network-username"><?php /*echo $distDB->getDistributorCode()*/?></div>
    <div align="center" class="network-button-wraper"><a class="network-add-investment"
                                                         href="<?php /*echo url_for("/member/upgradePackageViaTree?distcode=".$distDB->getDistributorCode()) */?>">Add Investment</a></div>-->
    <?php } else if ($availableButton == true) { ?>
        <div align="center" class="network-button-wraper"><a href="<?php echo url_for("/member/purchasePackageViaTree?distcode=".$anode[0]['distCode']."&position=right") ?>" class="network-register"><?php echo __('Register') ?></a>
        </div>
    <?php }?>
</div>
<div style="clear:both;"></div>
<div style="width: 150px; margin-left: 73px; float:left; height: 27px;">
<?php
if ($anode[1]['distCode'] != "") { ?>
    <div style="width: 2px; overflow-x: hidden; margin-left: 74px; height: 25px;"
         class="stats-node-line-up stats-node-line"></div>
    <div style="width: 152px; margin-left:-1px; overflow-y: hidden; height: 2px;"
         class="stats-node-line-side stats-node-line"></div>
    <?php } else { ?>
    <div style="clear:both;">&nbsp;</div>
    <div style="clear:both;">&nbsp;</div>
    <?php } ?>
</div>
<div style="width: 150px; margin-left: 150px; float:left; height: 27px;">
    <?php if ($anode[2]['distCode'] != "") { ?>
    <div style="width: 2px; overflow-x: hidden; margin-left: 74px; height: 25px;"
         class="stats-node-line-up stats-node-line"></div>
    <div style="width: 152px; margin-left:-1px; overflow-y: hidden; height: 2px;"
         class="stats-node-line-side stats-node-line"></div>
    <?php } else { ?>
    <div style="clear:both;">&nbsp;</div>
    <div style="clear:both;">&nbsp;</div>
    <?php } ?>
</div>
<div style="clear:both;"></div>

<?php if ($anode[1]['distCode'] != "") { ?>
<div style="width: 2px; overflow-x: hidden; margin-left: 72px; float:left; height: 25px;"
     class="stats-node-line-up stats-node-line"></div>
<div style="width: 2px; overflow-x: hidden; margin-left: 148px; float:left; height: 25px;"
     class="stats-node-line-up stats-node-line"></div>
<?php } else { ?>
<div style="width: 2px; overflow-x: hidden; margin-left: 72px; float:left; height: 25px;">&nbsp;</div>
<div style="width: 2px; overflow-x: hidden; margin-left: 148px; float:left; height: 25px;">&nbsp;</div>
<?php } ?>
<?php if ($anode[2]['distCode'] != "") { ?>
<div style="width: 2px; overflow-x: hidden; margin-left: 148px; float:left; height: 25px;"
     class="stats-node-line-up stats-node-line"></div>
<div style="width: 2px; overflow-x: hidden; margin-left: 148px; float:left; height: 25px;"
     class="stats-node-line-up stats-node-line"></div>
<?php } else { ?>
<div style="width: 2px; overflow-x: hidden; margin-left: 148px; float:left; height: 25px;">&nbsp;</div>
<div style="width: 2px; overflow-x: hidden; margin-left: 148px; float:left; height: 25px;">&nbsp;</div>
<?php } ?>
<div style="clear:both;"></div>

<?php
    $distCode = $anode[3]['distCode'];
    $availableButton = $anode[3]['_available'];
    $textStr = "";
    $classAndAttr = "";
    $headColor = "";
    if ($distCode != "") {
        $distDB = $anode[3]['_self'];
        if ($hideDistGroup == true) {
            if ($apService->blockGenealogy($sf_user->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }

        $pos = strrpos($distDB->getPlacementTreeStructure(), "|339377|");
        if ($pos === false) { // note: three equal signs

        } else {
            if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 1 || $sf_user->getAttribute(Globals::SESSION_DISTID) == 339377) {

            } else {
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $headColor = $colorArr[$distDB->getRankId()]."_";
        //$distPairingLedgerDB = $anode[3]['_dist_pairing_ledger'];

        $classAndAttr .= " class='logoTooltip'";
        $classAndAttr .= " distCode='".$distCode."'";
        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
        //$classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
/*        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[3]['_left_this_month_sales'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[3]['_right_this_month_sales'],0)."'";*/
        $classAndAttr .= " accumulate_left='".number_format($anode[3]['_accumulate_left'],0)."'";
        $classAndAttr .= " accumulate_right='".number_format($anode[3]['_accumulate_right'],0)."'";
        $classAndAttr .= " today_left='".number_format($anode[3]['_today_left'],0)."'";
        $classAndAttr .= " today_right='".number_format($anode[3]['_today_right'],0)."'";
        $classAndAttr .= " carry_left='".number_format($anode[3]['_carry_left'],0)."'";
        $classAndAttr .= " carry_right='".number_format($anode[3]['_carry_right'],0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[3]['_sales_left'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[3]['_sales_right'],0)."'";
//        $classAndAttr .= " referrer_id='".$distDB->getUplineDistCode()."'";
    }
?>
<div style="width: 60px; margin-left: 43px; text-align:center; float:left;" class="stats-node">
    <?php if ($distCode != "") { ?>
    <a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>" style="font-size: 14px; font-weight: bold;">
            <!--<img rel="<?php /*echo $distDB->getDistributorCode()*/?>" src="/css/network/<?php /*echo $headColor; */?>head.png" --><?php /*echo $classAndAttr;*/?>
            <?php
            if ($distCode != "Restricted to view member information") {
                $pos = strrpos($distDB->getPlacementTreeStructure(), "|259817|");
                $pos2 = strrpos($distDB->getPlacementTreeStructure(), "|165|");
                $pos3 = strrpos($distDB->getPlacementTreeStructure(), "|132|");
                $pos4 = strrpos($distDB->getPlacementTreeStructure(), "|264504|");
                $isRemoveUS = false;
                $distCode = $distDB->getDistributorCode();
                $userDB = AppUserPeer::retrieveByPk($distDB->getUserId());
                $userName = $userDB->getUsername();
                if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -1);
                    if ($lastChar == "_") {
                        $distCode = substr($distCode, 0, -1);

                        $lastChar = substr($userName, -1);
                        if ($lastChar == "_") {
                            $userName = substr($userName, 0, -1);
                        }
                    }
                }

                $posDUS = strrpos($distDB->getPlacementTreeStructure(), "|317307|");
                $posDUS2 = strrpos($distDB->getPlacementTreeStructure(), "|254827|");
                if ($posDUS === false && $posDUS2 === false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -2);
                    if ($lastChar == "__") {
                        $distCode = substr($distCode, 0, -2);

                        $lastChar = substr($userName, -2);
                        if ($lastChar == "__") {
                            $userName = substr($userName, 0, -2);
                        }
                    }
                }
                echo $distCode." (".$userName.")";
            } else {
                echo $distDB->getDistributorCode();
            }
        ?>
            </a><br>

    <!--<div class="network-username"><?php /*echo $distDB->getDistributorCode()*/?></div>
    <div align="center" class="network-button-wraper"><a class="network-add-investment"
                                                         href="<?php /*echo url_for("/member/upgradePackageViaTree?distcode=".$distDB->getDistributorCode()) */?>">Add Investment</a></div>-->
    <div class="network-bottom-more-node"><a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>"></a></div>
    <?php } else if ($availableButton == true) { ?>
        <div align="center" class="network-button-wraper"><a href="<?php echo url_for("/member/purchasePackageViaTree?distcode=".$anode[1]['distCode']."&position=left") ?>" class="network-register"><?php echo __('Register') ?></a>
        </div>
    <?php } else { ?>
        <div style="clear:both;">&nbsp;</div>
    <?php }  ?>
</div>

<?php
    $distCode = $anode[4]['distCode'];
    $availableButton = $anode[4]['_available'];
    $textStr = "";
    $headColor = "";
    $classAndAttr = "";
    if ($distCode != "") {
        $distDB = $anode[4]['_self'];
        if ($hideDistGroup == true) {
            if ($apService->blockGenealogy($sf_user->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }

        $pos = strrpos($distDB->getPlacementTreeStructure(), "|339377|");
        if ($pos === false) { // note: three equal signs

        } else {
            if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 1 || $sf_user->getAttribute(Globals::SESSION_DISTID) == 339377) {

            } else {
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $headColor = $colorArr[$distDB->getRankId()]."_";
        //$distPairingLedgerDB = $anode[4]['_dist_pairing_ledger'];

        $classAndAttr .= " class='logoTooltip'";
        $classAndAttr .= " distCode='".$distCode."'";
        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
        //$classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
/*        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[4]['_left_this_month_sales'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[4]['_right_this_month_sales'],0)."'";*/
        $classAndAttr .= " accumulate_left='".number_format($anode[4]['_accumulate_left'],0)."'";
        $classAndAttr .= " accumulate_right='".number_format($anode[4]['_accumulate_right'],0)."'";
        $classAndAttr .= " today_left='".number_format($anode[4]['_today_left'],0)."'";
        $classAndAttr .= " today_right='".number_format($anode[4]['_today_right'],0)."'";
        $classAndAttr .= " carry_left='".number_format($anode[4]['_carry_left'],0)."'";
        $classAndAttr .= " carry_right='".number_format($anode[4]['_carry_right'],0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[4]['_sales_left'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[4]['_sales_right'],0)."'";
//        $classAndAttr .= " referrer_id='".$distDB->getUplineDistCode()."'";
    }
?>
<div style="width: 60px; margin-left: 90px; text-align:center; float:left;" class="stats-node">
    <?php if ($distCode != "") { ?>
    <a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>" style="font-size: 14px; font-weight: bold;">
            <!--<img rel="<?php /*echo $distDB->getDistributorCode()*/?>" src="/css/network/<?php /*echo $headColor; */?>head.png" --><?php /*echo $classAndAttr;*/?>
            <?php
            if ($distCode != "Restricted to view member information") {
                $pos = strrpos($distDB->getPlacementTreeStructure(), "|259817|");
                $pos2 = strrpos($distDB->getPlacementTreeStructure(), "|165|");
                $pos3 = strrpos($distDB->getPlacementTreeStructure(), "|132|");
                $pos4 = strrpos($distDB->getPlacementTreeStructure(), "|264504|");
                $isRemoveUS = false;
                $distCode = $distDB->getDistributorCode();
                $userDB = AppUserPeer::retrieveByPk($distDB->getUserId());
                $userName = $userDB->getUsername();
                if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -1);
                    if ($lastChar == "_") {
                        $distCode = substr($distCode, 0, -1);

                        $lastChar = substr($userName, -1);
                        if ($lastChar == "_") {
                            $userName = substr($userName, 0, -1);
                        }
                    }
                }

                $posDUS = strrpos($distDB->getPlacementTreeStructure(), "|317307|");
                $posDUS2 = strrpos($distDB->getPlacementTreeStructure(), "|254827|");
                if ($posDUS === false && $posDUS2 === false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -2);
                    if ($lastChar == "__") {
                        $distCode = substr($distCode, 0, -2);

                        $lastChar = substr($userName, -2);
                        if ($lastChar == "__") {
                            $userName = substr($userName, 0, -2);
                        }
                    }
                }
                echo $distCode." (".$userName.")";
            } else {
                echo $distDB->getDistributorCode();
            }
        ?>
            </a><br>

    <!--<div class="network-username"><?php /*echo $distDB->getDistributorCode()*/?></div>
    <div align="center" class="network-button-wraper"><a class="network-add-investment"
                                                         href="<?php /*echo url_for("/member/upgradePackageViaTree?distcode=".$distDB->getDistributorCode()) */?>">Add Investment</a></div>-->
    <div class="network-bottom-more-node"><a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>"></a></div>
    <?php } else if ($availableButton == true) { ?>
        <div align="center" class="network-button-wraper"><a href="<?php echo url_for("/member/purchasePackageViaTree?distcode=".$anode[1]['distCode']."&position=right") ?>" class="network-register"><?php echo __('Register') ?></a>
        </div>
    <?php } else { ?>
        <div style="clear:both;">&nbsp;</div>
    <?php }  ?>
</div>

<?php
    $distCode = $anode[5]['distCode'];
    $availableButton = $anode[5]['_available'];
    $textStr = "";
    $classAndAttr = "";
    $headColor = "";
    if ($distCode != "") {
        $distDB = $anode[5]['_self'];
        if ($hideDistGroup == true) {
            if ($apService->blockGenealogy($sf_user->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }

        $pos = strrpos($distDB->getPlacementTreeStructure(), "|339377|");
        if ($pos === false) { // note: three equal signs

        } else {
            if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 1 || $sf_user->getAttribute(Globals::SESSION_DISTID) == 339377) {

            } else {
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $headColor = $colorArr[$distDB->getRankId()]."_";
        //$distPairingLedgerDB = $anode[5]['_dist_pairing_ledger'];

        $classAndAttr .= " class='logoTooltip'";
        $classAndAttr .= " distCode='".$distCode."'";
        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
        //$classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
/*        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[5]['_left_this_month_sales'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[5]['_right_this_month_sales'],0)."'";*/
        $classAndAttr .= " accumulate_left='".number_format($anode[5]['_accumulate_left'],0)."'";
        $classAndAttr .= " accumulate_right='".number_format($anode[5]['_accumulate_right'],0)."'";
        $classAndAttr .= " today_left='".number_format($anode[5]['_today_left'],0)."'";
        $classAndAttr .= " today_right='".number_format($anode[5]['_today_right'],0)."'";
        $classAndAttr .= " carry_left='".number_format($anode[5]['_carry_left'],0)."'";
        $classAndAttr .= " carry_right='".number_format($anode[5]['_carry_right'],0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[5]['_sales_left'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[5]['_sales_right'],0)."'";
//        $classAndAttr .= " referrer_id='".$distDB->getUplineDistCode()."'";
    }
?>
<div style="width: 60px; margin-left: 90px; text-align:center; float:left;" class="stats-node">
    <?php if ($distCode != "") { ?>
    <a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>" style="font-size: 14px; font-weight: bold;">
            <!--<img rel="<?php /*echo $distDB->getDistributorCode()*/?>" src="/css/network/<?php /*echo $headColor; */?>head.png" --><?php /*echo $classAndAttr;*/?>
            <?php
            if ($distCode != "Restricted to view member information") {
                $pos = strrpos($distDB->getPlacementTreeStructure(), "|259817|");
                $pos2 = strrpos($distDB->getPlacementTreeStructure(), "|165|");
                $pos3 = strrpos($distDB->getPlacementTreeStructure(), "|132|");
                $pos4 = strrpos($distDB->getPlacementTreeStructure(), "|264504|");
                $isRemoveUS = false;
                $distCode = $distDB->getDistributorCode();
                $userDB = AppUserPeer::retrieveByPk($distDB->getUserId());
                $userName = $userDB->getUsername();
                if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -1);
                    if ($lastChar == "_") {
                        $distCode = substr($distCode, 0, -1);

                        $lastChar = substr($userName, -1);
                        if ($lastChar == "_") {
                            $userName = substr($userName, 0, -1);
                        }
                    }
                }

                $posDUS = strrpos($distDB->getPlacementTreeStructure(), "|317307|");
                $posDUS2 = strrpos($distDB->getPlacementTreeStructure(), "|254827|");
                if ($posDUS === false && $posDUS2 === false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -2);
                    if ($lastChar == "__") {
                        $distCode = substr($distCode, 0, -2);

                        $lastChar = substr($userName, -2);
                        if ($lastChar == "__") {
                            $userName = substr($userName, 0, -2);
                        }
                    }
                }
                echo $distCode." (".$userName.")";
            } else {
                echo $distDB->getDistributorCode();
            }
        ?>
            </a><br>

    <!--<div class="network-username"><?php /*echo $distDB->getDistributorCode()*/?></div>
    <div align="center" class="network-button-wraper"><a class="network-add-investment"
                                                         href="<?php /*echo url_for("/member/upgradePackageViaTree?distcode=".$distDB->getDistributorCode()) */?>">Add Investment</a></div>-->
    <div class="network-bottom-more-node"><a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>"></a></div>
    <?php } else if ($availableButton == true) { ?>
        <div align="center" class="network-button-wraper"><a href="<?php echo url_for("/member/purchasePackageViaTree?distcode=".$anode[2]['distCode']."&position=left") ?>" class="network-register"><?php echo __('Register') ?></a>
        </div>
    <?php } else { ?>
        <div style="clear:both;">&nbsp;</div>
    <?php }  ?>
</div>

<?php
    $distCode = $anode[6]['distCode'];
    $availableButton = $anode[6]['_available'];
    $textStr = "";
    $classAndAttr = "";
    $headColor = "";
    if ($distCode != "") {
        $distDB = $anode[6]['_self'];
        if ($hideDistGroup == true) {
            if ($apService->blockGenealogy($sf_user->getAttribute(Globals::SESSION_DISTID), $distDB->getPlacementTreeStructure()) == true) { // note: three equal signs
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }

        $pos = strrpos($distDB->getPlacementTreeStructure(), "|339377|");
        if ($pos === false) { // note: three equal signs

        } else {
            if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 1 || $sf_user->getAttribute(Globals::SESSION_DISTID) == 339377) {

            } else {
                $distCode = "Restricted to view member information";
                $distDB->setDistributorCode($distCode);
            }
        }
        $headColor = $colorArr[$distDB->getRankId()]."_";
        //$distPairingLedgerDB = $anode[6]['_dist_pairing_ledger'];

        $classAndAttr .= " class='logoTooltip'";
        $classAndAttr .= " distCode='".$distCode."'";
        $classAndAttr .= " activeDatetime='".$distDB->getActiveDatetime()."'";
        $classAndAttr .= " rankCode='".$distDB->getRankCode()."'";
        //$classAndAttr .= " daily='".number_format($distPairingLedgerDB->getFlushLimit(),0)."'";
/*        $classAndAttr .= " carry_left='".number_format($distPairingLedgerDB->getLeftBalance(),0)."'";
        $classAndAttr .= " carry_right='".number_format($distPairingLedgerDB->getRightBalance(),0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[6]['_left_this_month_sales'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[6]['_right_this_month_sales'],0)."'";*/
        $classAndAttr .= " accumulate_left='".number_format($anode[6]['_accumulate_left'],0)."'";
        $classAndAttr .= " accumulate_right='".number_format($anode[6]['_accumulate_right'],0)."'";
        $classAndAttr .= " today_left='".number_format($anode[6]['_today_left'],0)."'";
        $classAndAttr .= " today_right='".number_format($anode[6]['_today_right'],0)."'";
        $classAndAttr .= " carry_left='".number_format($anode[6]['_carry_left'],0)."'";
        $classAndAttr .= " carry_right='".number_format($anode[6]['_carry_right'],0)."'";
        $classAndAttr .= " sales_left='".number_format($anode[6]['_sales_left'],0)."'";
        $classAndAttr .= " sales_right='".number_format($anode[6]['_sales_right'],0)."'";
//        $classAndAttr .= " referrer_id='".$distDB->getUplineDistCode()."'";
    }
?>
<div style="width: 60px; margin-left: 90px; text-align:center; float:left;" class="stats-node">
    <?php if ($distCode != "") { ?>
    <a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>" style="font-size: 14px; font-weight: bold;">
            <!--<img rel="<?php /*echo $distDB->getDistributorCode()*/?>" src="/css/network/<?php /*echo $headColor; */?>head.png" --><?php /*echo $classAndAttr;*/?>
            <?php
            if ($distCode != "Restricted to view member information") {
                $pos = strrpos($distDB->getPlacementTreeStructure(), "|259817|");
                $pos2 = strrpos($distDB->getPlacementTreeStructure(), "|165|");
                $pos3 = strrpos($distDB->getPlacementTreeStructure(), "|132|");
                $pos4 = strrpos($distDB->getPlacementTreeStructure(), "|264504|");
                $isRemoveUS = false;
                $distCode = $distDB->getDistributorCode();
                $userDB = AppUserPeer::retrieveByPk($distDB->getUserId());
                $userName = $userDB->getUsername();
                if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -1);
                    if ($lastChar == "_") {
                        $distCode = substr($distCode, 0, -1);

                        $lastChar = substr($userName, -1);
                        if ($lastChar == "_") {
                            $userName = substr($userName, 0, -1);
                        }
                    }
                }

                $posDUS = strrpos($distDB->getPlacementTreeStructure(), "|317307|");
                $posDUS2 = strrpos($distDB->getPlacementTreeStructure(), "|254827|");
                if ($posDUS === false && $posDUS2 === false) { // note: three equal signs

                } else {
                    $lastChar = substr($distCode, -2);
                    if ($lastChar == "__") {
                        $distCode = substr($distCode, 0, -2);

                        $lastChar = substr($userName, -2);
                        if ($lastChar == "__") {
                            $userName = substr($userName, 0, -2);
                        }
                    }
                }

                echo $distCode." (".$userName.")";
            } else {
                echo $distDB->getDistributorCode();
            }
        ?>
        </a><br>

    <!--<div class="network-username"><?php /*echo $distDB->getDistributorCode()*/?></div>
    <div align="center" class="network-button-wraper"><a class="network-add-investment"
                                                         href="<?php /*echo url_for("/member/upgradePackageViaTree?distcode=".$distDB->getDistributorCode()) */?>">Add Investment</a></div>-->
    <div class="network-bottom-more-node"><a href="<?php echo url_for("/member/placementTree?distcode=".$distDB->getDistributorCode()."&bePlacementId=".$bePlacementId) ?>"></a></div>
    <?php } else if ($availableButton == true) { ?>
        <div align="center" class="network-button-wraper"><a href="<?php echo url_for("/member/purchasePackageViaTree?distcode=".$anode[2]['distCode']."&position=right") ?>" class="network-register"><?php echo __('Register') ?></a>
        </div>
    <?php } else { ?>
        <div style="clear:both;">&nbsp;</div>
    <?php }  ?>
</div>
<div style="clear:both;"></div>

</div>