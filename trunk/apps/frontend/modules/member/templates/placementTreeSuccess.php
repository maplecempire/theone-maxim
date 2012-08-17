<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>
<script type="text/javascript">
var packageStrings = "<option value=''></option>";
var datagrid = null;
$(function() {
    datagrid = $("#datagrid").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData){ // pass extra params to server
            aoData.push( { "name": "filterFullname", "value": $("#search_fullname").val()  } );
            aoData.push( { "name": "filterNickname", "value": $("#search_nickname").val()  } );
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
		              { "sName" : "distributor_code",  "bSortable": true},
		              { "sName" : "full_name",  "bSortable": true},
		              { "sName" : "nickname",  "bSortable": true},
		              { "sName" : "ic",  "bSortable": true},
		              { "sName" : "rank_code",  "bSortable": true},
		              { "sName" : "created_on",  "bSortable": true}
		]
    });

    $(".viewDetail").button({
        icons: {
            primary: "ui-icon-circle-zoomin"
        }
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
<div class="portlet">
    <div class="portlet-header"><?php echo __('Placement Tree') ?></div>
    <div class="portlet-content">

<form action="/member/placementTree" id="transferForm" method="post">
    <input type="hidden" name="uplineDistCode" id="uplineDistCode">
    <input type="hidden" name="uplinePosition" id="uplinePosition">
    <input type="hidden" name="sponsorDistId" id="sponsorDistId">
    <input type="hidden" name="doAction" id="doAction">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td colspan="18" align="left"><?php echo __("Trader ID")?>&nbsp;
                    <input size="8" type="text" id="distcode" name="distcode" value="<?php echo $distcode ?>"/>
                    <input type="submit" value="<?php echo __('Search') ?>" id="btnSearch" name="btnSearch"/>
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
            <td colspan="18" align="center"><img src="/images/logo.png" style="height:80px"></td>
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
                    $textStr .= "<br>".$distDB->getCreatedOn();
                    $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                    $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                    $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                    $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[0]['_left_this_month_sales'],0)." | ".number_format($anode[0]['_right_this_month_sales'],0);
                    $textStr .= "<br>";
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
            <td colspan="6" align="center"><img src="/images/logo.png" style="height:80px"></td>
            <td colspan="6" align="center"></td>
            <td colspan="6" align="center"><img src="/images/logo.png" style="height:80px"></td>
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
                    $textStr .= "<br>".$distDB->getCreatedOn();
                    $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                    $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                    $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                    $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[1]['_left_this_month_sales'],0)." | ".number_format($anode[1]['_right_this_month_sales'],0);
                    $textStr .= "<br>";
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
                    $textStr .= "<br>".$distDB->getCreatedOn();
                    $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                    $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                    $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                    $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[2]['_left_this_month_sales'],0)." | ".number_format($anode[2]['_right_this_month_sales'],0);
                    $textStr .= "<br>";
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
            <td colspan="2" align="center"><img src="/images/logo.png" style="height:80px"></td>
            <td colspan="2" align="center"></td>
            <td colspan="2" align="center"><img src="/images/logo.png" style="height:80px"></td>
            <td colspan="2" align="center"></td>
            <td colspan="2" align="center"></td>
            <td colspan="2" align="center"></td>
            <td colspan="2" align="center"><img src="/images/logo.png" style="height:80px"></td>
            <td colspan="2" align="center"></td>
            <td colspan="2" align="center"><img src="/images/logo.png" style="height:80px"></td>
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
                    $textStr .= "<br>".$distDB->getCreatedOn();
                    $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                    $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                    $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                    $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[3]['_left_this_month_sales'],0)." | ".number_format($anode[3]['_right_this_month_sales'],0);
                    $textStr .= "<br>";
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
                    $textStr .= "<br>".$distDB->getCreatedOn();
                    $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                    $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                    $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                    $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[4]['_left_this_month_sales'],0)." | ".number_format($anode[4]['_right_this_month_sales'],0);
                    $textStr .= "<br>";
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
                    $textStr .= "<br>".$distDB->getCreatedOn();
                    $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                    $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                    $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                    $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[5]['_left_this_month_sales'],0)." | ".number_format($anode[5]['_right_this_month_sales'],0);
                    $textStr .= "<br>";
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
                    $textStr .= "<br>".$distDB->getCreatedOn();
                    $textStr .= "<br>".__('Package Rank').": ".__($distDB->getRankCode());
                    $textStr .= "<br>".__('Daily Max').": ".number_format($distPairingLedgerDB->getFlushLimit(),0);
                    $textStr .= "<br>".__('Carry Forward CPS').": ".number_format($distPairingLedgerDB->getLeftBalance(),0)." | ".number_format($distPairingLedgerDB->getRightBalance(),0);
                    $textStr .= "<br>".__('This Month CPS').": ".number_format($anode[6]['_left_this_month_sales'],0)." | ".number_format($anode[6]['_right_this_month_sales'],0);
                    $textStr .= "<br>";
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
</form>
</div>
</div>

<div id="dgActivateMember" title="<?php echo __('Activate Trader') ?>" style="display:none;">
    <table class="display" id="datagrid" border="0" width="100%">
        <thead>
        <tr>
            <th>distributor_id[hidden]</th>
            <th width="30px"></th>
            <th><?php echo __('Member Id') ?></th>
            <th><?php echo __('Full Name') ?></th>
            <th><?php echo __('Alias') ?></th>
            <th><?php echo __('Passport/ID Card No') ?></th>
            <th><?php echo __('Package Rank') ?></th>
            <th><?php echo __('Registered Date') ?></th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><input size="15" type="text" id="search_fullname" value="" class="search_init" /></td>
            <td><input size="15" type="text" id="search_nickname" value="" class="search_init" /></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
    </table>
</div>