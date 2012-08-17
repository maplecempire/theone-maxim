<?php include('scripts.php'); ?>
<script type="text/javascript">
var datagridOpenTransaction = null;
var datagridBuyingHistory = null;
var datagridSellingHistory = null;
$(function() {
    $("#tradingForm").validate({
        messages : {

        },
        rules : {

        },
        submitHandler: function(form) {
            var buyAmount = $('#txtBuyAmount').autoNumericGet();
            var ecashBalance = $('#txtEcash').val();

            if (parseFloat(ecashBalance) < (parseFloat(buyAmount))) {
                alert("<?php echo __("In-sufficient E-Cash")?>");
                return false;
            }
            if (parseFloat(buyAmount) == 0) {
                alert("<?php echo __("Buy amount must be greater than 0")?>");
                return false;
            }

            $("#txtBuyAmount").val(buyAmount);
            form.submit();
        }
    });

    $("#btnBuy").button({
        icons: {
            primary: "ui-icon-cart"
        }
    });
    $('#txtBuyAmount').autoNumeric({
        mDec: 2
    });

    $("#goldTradingTabs").tabs().find(".ui-tabs-nav");

    datagridOpenTransaction = $("#datagridOpenTransaction").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData){ // pass extra params to server
        },
        "reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
            reassignDatagridOpenTransactionEventAttr();
        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "/eshare/openTransactionListing",
        "sPaginationType": "full_numbers",
        "aaSorting": [[5,'desc']],
        "aoColumns": [
                      { "sName" : "eshare_id", "bVisible" : false,  "bSortable": true},
                      { "sName" : "eshare_id", "bSortable": true},
                      { "sName" : "buy_price",  "bSortable": false},
                      { "sName" : "credit",  "bSortable": false},
                      { "sName" : "profit",  "bSortable": false},
                      { "sName" : "valid_sell_date",  "bSortable": false},
                      { "sName" : "eshare_id",  "bSortable": true,
                        "fnRender": function ( oObj ) {
                            <?php
                                if($validToSellShare == true){
                            ?>
                                if (oObj.aData[6]) {
                                    $("#datagridOpenTransaction").data("openTransaction_" + oObj.aData[0], oObj.aData);
                                    return "<a id='sellLink' href='#' style='color:red'><?php echo __('Sell', null, "goldTrading") ?></a>";
                                } else {
                                    return "";
                                }
                            <?php
                                } else {
                                    echo 'return ""';
                                }
                            ?>
                        }
                      }
        ]
    });

    datagridBuyingHistory = $("#datagridBuyingHistory").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData){ // pass extra params to server
        },
        "reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "/eshare/buyingHistoryListing",
        "sPaginationType": "full_numbers",
        "aaSorting": [[5,'desc']],
        "aoColumns": [
                      { "sName" : "eshare_id", "bVisible" : false,  "bSortable": true},
                      { "sName" : "eshare_id", "bSortable": true},
                      { "sName" : "credit",  "bSortable": true},
                      { "sName" : "buy_price",  "bSortable": true},
                      { "sName" : "created_on",  "bSortable": true}
        ]
    });

    datagridSellingHistory = $("#datagridSellingHistory").r9jasonDataTable({
        // online1DataTable extra params
        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
        "extraParam" : function(aoData){ // pass extra params to server
        },
        "reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
        },

        // datatables params
        "bLengthChange": true,
        "bFilter": false,
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "/eshare/sellingHistoryListing",
        "sPaginationType": "full_numbers",
        "aaSorting": [[6,'desc']],
        "aoColumns": [
                      { "sName" : "eshare_id", "bVisible" : false,  "bSortable": true},
                      { "sName" : "eshare_id", "bSortable": true},
                      { "sName" : "debit",  "bSortable": true},
                      { "sName" : "sell_price",  "bSortable": true},
                      { "sName" : "profit",  "bSortable": true},
                      { "sName" : "sell_date",  "bSortable": true}
        ]
    });

    $("#dgSellConfirmation").dialog("destroy");
    $("#dgSellConfirmation").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        height: 160,
        buttons: {
            "<?php echo __('Confirm') ?>": function() {
                $("#sellShareForm").submit();
                $(this).dialog('close');
            },
            "<?php echo __('Cancel') ?>": function() {
                $(this).dialog('close');
            }
        }
    });
})

function reassignDatagridOpenTransactionEventAttr(){
	$("a[id=sellLink]").click(function(event){
		// stop event
		event.preventDefault();
		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		// var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");
        $("#shareId").val(id);
        $("#dgSellConfirmation").dialog("open");
	});
}
</script>

<div style="padding: 10px; top: 30px; width: 98%">
    <table>
        <?php if ($sf_flash->has('successMsg')): ?>
        <tr>
            <td>
                <div class="ui-widget">
                    <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-highlight ui-corner-all">
                        <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
                        <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                    </div>
                </div>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>
                <div class="portlet">
                    <div class="portlet-header"><?php echo __('Cash Flow Point Chart') ?></div>
                    <div class="portlet-content">
                        <div id="placeholder" style="width:600px;height:300px"></div>
                    </div>
                </div>
            </td>
            <td valign="top">
                <table width="96%" height="250" cellspacing="0" cellpadding="1" border="0" align="center" id="tableInfo">
                    <tbody>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <strong><?php echo __('Paper e-Share Quantity', null, "goldTrading") ?>：</strong>
                        </td>
                        <td>
                            <font color="#61210B"> <span id="spanPaperGoldQuantity"><?php echo number_format($eshareTradingDto->getPaperEshareQuantity(),0)?></span>
                            <span id="MyGoldAccount1_Label3"> <?php echo __('unit', null, "goldTrading") ?></span></font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <strong><?php echo __('Average Price (Buy)', null, "goldTrading") ?>：</strong>
                        </td>
                        <td>
                            <font color="#61210B">
                                <span id="MyGoldAccount1_Label5">$</span><span id="spanAveragePriceBuy"><?php echo number_format($eshareTradingDto->getAveragePriceBuy(),2)?></span>
                                <span id="MyGoldAccount1_Label4">/<?php echo __('unit', null, "goldTrading") ?></span></font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <strong><?php echo __('Unrealized Profit/Loss', null, "goldTrading") ?>：</strong>
                        </td>
                        <td>
                            <font color="#61210B"><span
                                    id="MyGoldAccount1_Label6">$</span><span id="spanUnrealizedProfitLoss"><?php echo number_format($eshareTradingDto->getUnrealizedProfitLoss(),2)?></span>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <strong><?php echo __('E-Cash', null, "goldTrading") ?>：</strong>
                        </td>
                        <td>
                            <font color="#61210B">
                                <span id="MyGoldAccount1_Label2">$</span>
                                <span id="spanEcash"><?php echo number_format($eshareTradingDto->getEcash(),2)?></span>
                                <input type="hidden" id="txtEcash" value="<?php echo $eshareTradingDto->getEcash()?>">
                            </font>
                        </td>
                    </tr>

                    <tr>
                        <td valign="baseline" align="right">
                            <strong><?php echo __('We sell', null, "goldTrading") ?>：</strong>
                        </td>
                        <td valign="baseline" align="left">
                            <form action="/eshare/buyShare" id="tradingForm" method="post">
                                <span style="color:#61210B;" id="Label4">$</span>
                                <span style="color:#61210B;" id="spanGoldSell"><?php echo $eshareTradingDto->getEsharePrice()?></span>
                                <span style="color:#61210B;" id="Labelusdbuy">/<?php echo __('unit', null, "goldTrading") ?></span>&nbsp;
                                <input type="text" style="width:80px;" id="txtBuyAmount" name="txtBuyAmount">
                                <span id="Labelgram"><strong><?php echo __('USD', null, "goldTrading") ?></strong></span>&nbsp;&nbsp;

                                    <?php
                                    if($validToBuyShare == true){
                                    ?>
                                        <button id="btnBuy"><?php echo __('Buy', null, "goldTrading") ?></button>
                                    <?php
                                        }
                                    ?>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
<form action="/eshare/sellShare" id="sellShareForm" method="post">
    <input type="hidden" name="shareId" id="shareId" value="">
</form>
<div id="goldTradingTabs">
    <ul>
        <li>
            <a href="#tabs-openTransactions"><?php echo __('Open Transactions', null, 'goldTrading') ?></a>
        </li>
        <li><a href="#tabs-buyingHistory"><?php echo __('Buying History', null, 'goldTrading') ?></a>
        </li>
        <li><a href="#tabs-sellingHistory"><?php echo __('Selling History', null, 'goldTrading') ?></a>
        </li>
    </ul>
    <div id="tabs-openTransactions">
        <table class="display" id="datagridOpenTransaction" border="0" width="90%">
            <thead>
            <tr>
                <th>id [hidden]</th>
                <th><?php echo __('Transaction ID', null, 'goldTrading') ?></th>
                <th><?php echo __('Price($/unit)', null, 'goldTrading') ?></th>
                <th><?php echo __('Quantity(unit)', null, 'goldTrading') ?></th>
                <th><?php echo __('Unrealized Profit/Loss($)', null, 'goldTrading') ?></th>
                <th><?php echo __('Valid Sell Date', null, 'goldTrading') ?></th>
                <th><?php echo __('Action', null, 'goldTrading') ?></th>
            </tr>
            </thead>
        </table>
    </div>
    <!--################    Buying History  ###################-->
    <div id="tabs-buyingHistory">
        <table class="display" id="datagridBuyingHistory" border="0" width="90%">
            <thead>
            <tr>
                <th>id [hidden]</th>
                <th><?php echo __('Transaction ID', null, 'goldTrading') ?></th>
                <th><?php echo __('Quantity(unit)', null, 'goldTrading') ?></th>
                <th><?php echo __('Buy Price($/unit)', null, 'goldTrading') ?></th>
                <th><?php echo __('Buy Date', null, 'goldTrading') ?></th>
            </tr>
            </thead>
        </table>
    </div>
    <!--##############  Selling History  #####################-->
    <div id="tabs-sellingHistory">
        <table class="display" id="datagridSellingHistory" border="0" width="90%">
            <thead>
            <tr>
                <th>id [hidden]</th>
                <th><?php echo __('Transaction ID', null, 'goldTrading') ?></th>
                <th><?php echo __('Quantity(unit)', null, 'goldTrading') ?></th>
                <th><?php echo __('Sell Price($/g)', null, 'goldTrading') ?></th>
                <th><?php echo __('Realised Profit/Loss', null, 'goldTrading') ?></th>
                <th><?php echo __('Sell Date', null, 'goldTrading') ?></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div id="dgSellConfirmation" title="Sell e-Share?" style="display:none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to sell e-share?</p>
</div>

<?php
$str = "";
foreach ($eshareLogs as $eshareLog):
    if ($str != "") {
        $str .= ",";
    }
    $milisec = strtotime($eshareLog['created_on']) * 1000;
    $str .= "[".$milisec.",".$eshareLog['share_value']."]";
endforeach;
?>
<script type="text/javascript">
    $(function () {
        var cos = [<?php echo $str;?>];

        var plot = $.plot($("#placeholder"),
                [
                    { data: cos, label: "tune" }
                ], {
                    series: {
                        lines: { show: true },
                        points: { show: true }
                    },
                    grid: { hoverable: true, clickable: true },
                    xaxes: [ { mode: 'time', ticks: 14 } ],
                    yaxis: { min: 0, max: 0.6, ticks: 12 }
                });

        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                        position: 'absolute',
                        display: 'none',
                        top: y + 5,
                        left: x + 5,
                        border: '1px solid #fdd',
                        padding: '2px',
                        'background-color': '#fee',
                        opacity: 0.80
                    }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $("#placeholder").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));

            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

                    var currentTime = new Date(parseInt(x));
                    var month = currentTime.getMonth() + 1;
                    var day = currentTime.getDate();
                    var year = currentTime.getFullYear();

                    showTooltip(item.pageX, item.pageY, year + "-" + month + "-" + day + " , " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });

        $("#placeholder").bind("plotclick", function (event, pos, item) {
            if (item) {
                $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
                plot.highlight(item.series, item.datapoint);
            }
        });
    });
</script>
