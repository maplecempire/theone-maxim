<?php use_helper('I18N') ?>
<script type='text/javascript' src='/js/deployJava.js'></script>
<script type="text/javascript">
var datagridOpenTransaction = null;
var datagridBuyingHistory = null;
var datagridSellingHistory = null;
$(function() {
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
        "sAjaxSource": "/gold/openTransactionListing",
        "sPaginationType": "full_numbers",
        "aaSorting": [[5,'desc']],
        "aoColumns": [
                      { "sName" : "f_id", "bVisible" : false,  "bSortable": true},
                      { "sName" : "f_id", "bSortable": true},
                      { "sName" : "f_price",  "bSortable": true},
                      { "sName" : "f_gram",  "bSortable": true},
                      { "sName" : "marginUsed",  "bSortable": true},
                      { "sName" : "f_created_datetime",  "bSortable": true},
                      { "sName" : "unrealizedProfitLoss",  "bSortable": true},
                      { "sName" : "f_id",  "bSortable": true,
                        "fnRender": function ( oObj ) {
                            <?php
                                //if($tbl_setting->getFValue()=='0' && $account->getFBalance() >= 5){
                                if($tbl_setting->getFValue()=='0'){
                            ?>
                                $("#datagridOpenTransaction").data("openTransaction_" + oObj.aData[0], oObj.aData);
                                return "<a id='sellLink' href='#' style='color:red'><?php echo __('Sell', null, "goldTrading") ?></a>";
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
        "sAjaxSource": "/gold/buyingHistoryListing",
        "sPaginationType": "full_numbers",
        "aaSorting": [[5,'desc']],
        "aoColumns": [
                      { "sName" : "ledger.f_id", "bVisible" : false,  "bSortable": true},
                      { "sName" : "ledger.f_id", "bSortable": true},
                      { "sName" : "ledger.f_gram",  "bSortable": true},
                      { "sName" : "ledger.f_original_price",  "bSortable": true},
                      { "sName" : "marginUsed",  "bSortable": true},
                      { "sName" : "ledger.f_created_datetime",  "bSortable": true}
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
        "sAjaxSource": "/gold/sellingHistoryListing",
        "sPaginationType": "full_numbers",
        "aaSorting": [[6,'desc']],
        "aoColumns": [
                      { "sName" : "ledger.f_id", "bVisible" : false,  "bSortable": true},
                      { "sName" : "ledger.f_id", "bSortable": true},
                      { "sName" : "ledger.f_gram",  "bSortable": true},
                      { "sName" : "ledger.f_sell_price",  "bSortable": true},
                      { "sName" : "marginUsed",  "bSortable": true},
                      { "sName" : "ledger.f_profit",  "bSortable": true},
                      { "sName" : "ledger.f_created_datetime",  "bSortable": true}
        ]
    });

    $("#goldTradingTabs").tabs().find(".ui-tabs-nav");

    $("#txtBuyAmount").numeric({
        decimal:false
        , minValue:0
    });

    $("#btnGoldBuy").click(function(event){
        $(this).attr("disabled", true);

        var buyAmount = $("#txtBuyAmount").val();
        if (buyAmount == 0) {
            alert("<?php echo __('Quantity to buy cannot be zero', null, "goldTrading") ?>.");
            $("#txtBuyAmount").focus().select();
            $("#btnGoldBuy").attr("disabled", false);
        } else {
            var currentGoldPrice = $("#spanGoldSell").html();
            var goldAmount = $("#txtBuyAmount").val();
            var totalAmount = Math.ceil(currentGoldPrice * goldAmount * 100) / 100;

            var sure = confirm("<?php echo __('Current Gold Price(buy)', null, "goldTrading") ?>:" + currentGoldPrice + "\n<?php echo __('Paper Gold purchase quantity', null, "goldTrading") ?>:" + goldAmount + "(<?php echo __('g') ?>)\n<?php echo __('Trading Margin Required', null, "goldTrading") ?>:" + totalAmount + "\n<?php echo __('Confirm Purchase?', null, "goldTrading") ?>");
            if (sure) {
                doBuyGold();
            } else {
                $("#btnGoldBuy").attr("disabled", false);
            }
        }
    });
    setInterval(function() {
        refreshPageData();
    }, <?php echo Globals::REFRESH_GOLD_INTEVAL; ?>);
});

function doBuyGold() {
    $.ajax({
        type : 'POST',
        url : "/gold/doBuygold",
        dataType : 'json',
        cache: false,
        data: {
            gp : $("#spanGoldSell").html()
            , q : $("#txtBuyAmount").val()
        },
        success : function(data) {
            if (data.error) {
                if (data.errorType == "REFRESH") {
                    var currentGoldPrice = data.goldSell;
                    var goldAmount = $("#txtBuyAmount").val();
                    var totalAmount = Math.ceil(currentGoldPrice * goldAmount * 100) / 100;

                    var sure = confirm("<?php echo __('Latest Gold Price(sell)', null, "goldTrading") ?>:" + currentGoldPrice + "\n<?php echo __('Paper Gold purchase quantity', null, "goldTrading") ?>:" + goldAmount + "(<?php echo __('g', null, "goldTrading") ?>)\n<?php echo __('Trading Margin Required', null, "goldTrading") ?>:" + totalAmount + "\n<?php echo __('Confirm Purchase?', null, "goldTrading") ?>");
                    if (sure) {
                        $("#spanGoldSell").html(data.goldSell);
                        doBuyGold();
                    }
                } else {
                    alert(data.errorMsg);
                    $("#btnGoldBuy").attr("disabled", false);
                }
            } else {
                $("#btnGoldBuy").attr("disabled", false);
                alert("<?php echo __('Transaction Successfully', null, "goldTrading") ?>.");
                refreshPageData();
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
        }
    });
}
function refreshPageData() {
    datagridOpenTransaction.fnDraw();
    datagridBuyingHistory.fnDraw();
    datagridSellingHistory.fnDraw();

    $.ajax({
        type : 'POST',
        url : "/gold/fetchTradingData",
        dataType : 'json',
        cache: false,
        data: {
        },
        success : function(data) {
            $("#spanAveragePriceBuy").html(data.averagePriceBuy);
            $("#spanGoldBuy").html(data.goldBuy);
            $("#spanGoldSell").html(data.goldSell);
            $("#spanPaperGoldQuantity").html(data.paperGoldQuantity);
            $("#spanTradingMarginAvailable").html(data.tradingMarginAvailable);
            $("#spanTradingMarginBalance").html(data.tradingMarginBalance);
            $("#spanUnrealizedProfitLoss").html(data.unrealizedProfitLoss);
            $("#spanEcash").html(data.ecash);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
            window.location = "/home/login";
        }
    });
}
function getCookie(Name) {
    var search = Name + "="
    if (document.cookie.length > 0) {
        // if there are any cookies
        offset = document.cookie.indexOf(search)
        if (offset != -1) {
            // if cookie exists
            offset += search.length
            // set index of beginning of value
            end = document.cookie.indexOf(";", offset)
            // set index of end of cookie value
            if (end == -1)
                end = document.cookie.length
            return unescape(document.cookie.substring(offset, end))
        }
    } else {
        return ""
    }
}

function reassignDatagridOpenTransactionEventAttr(){
	$("a[id=sellLink]").click(function(event){
		// stop event
		event.preventDefault();
		// event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
		// var id = alert("id = " +$(event.target).parent().parent().attr("id"));
		var id = $(event.target).parent().parent().attr("id");

        var data = $("#datagridOpenTransaction").data("openTransaction_" + id);
        $("#dgSellGold_transactionId").val(id);
        $('#dgSellGold_remainingPaperGold').val(data[3]);
        $('#dgSellGold_weSell').val($("#spanGoldSell").html());
        $('#dgSellGold_weBuy').val($("#spanGoldBuy").html());
        $('#dgSellGold_quantityToSell').val(data[3]);
        $('#dgSellGold_oriPrice').val(data[2]);

        $("#dgSellGold").dialog("open");
	});
}

</SCRIPT>

<form action="/member/doGoldTrading" method="post" id="registerForm" class="cmxform">
    <table cellpadding="0" cellspacing="5" align="center" border="0" width="90%">
        <tr>
            <td>
                <!--<SCRIPT LANGUAGE="JavaScript">
                    document.writeln("<APPLET codebase=\"http://www.galmarley.com/ChartApp/\" code=\"com.bullionvault.chart.run.ChartApp.class\" name=\"Galmarley Chart\" archive=\"ChartApp.jar\" width=\"400\" height=\"300\">");
                    document.writeln("<PARAM name=\"cookie\" value=\"" + getCookie("email") + "\">");
                    document.writeln("Your browser does not have Java installed.  Please install using <A HREF=\"http://java.com/en/download/help/win_auto.jsp\">Sun's</A> rapid, easy installer website.");
                    document.writeln("</APPLET>");
                </SCRIPT>-->

                <script type="text/javascript">
                    try
                    {
				  		var attributes = {
						  	name: 'chartApplet',
				  			codebase: 'http://www.galmarley.com/ChartApp/',
				  			archive: 'ChartApp.jar?t=20110421013926',
							code: 'com.bullionvault.chart.run.ChartApp.class',
							mayscript: true,
							height: '300', width: '400'
						} ;
						var parameters = {
							locale: 'en',
							displayMode: 'BullionVault',
							currency: 'menu.currency.USD" />',

							goRealtime: true,
							Series: 'menu.series.spotgold'
						} ;
						deployJava.writeAppletTag( attributes, parameters, 1.4 );
					}
					catch(ex)
					{

					}
                </script>

            </td>
            <td valign="top" align="left">
                <table width="96%" height="317" cellspacing="0" cellpadding="1" border="0" align="center"
                       class="tkclass" id="TableInfo">

                    <tbody>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <font color='white'><?php echo __('Trading Margin Available', null, "goldTrading") ?>：</font>
                        </td>
                        <td>
                            <font color="#ff9200"><span
                                    id="MyGoldAccount1_Label8">$</span><span id="spanTradingMarginAvailable"><?php echo $goldDto->getTradingMarginAvailable()?></span>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <font color='white'><?php echo __('Trading Margin Balance', null, "goldTrading") ?>：</font>
                        </td>
                        <td>
                            <font color="#ff9200"><span
                                    id="MyGoldAccount1_Label1">$</span><span id="spanTradingMarginBalance"><?php echo $goldDto->getTradingMarginBalance()?></span>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <font color='white'><?php echo __('Paper Gold Quantity (g)', null, "goldTrading") ?>：</font>
                        </td>
                        <td>
                            <font color="#ff9200"> <span id="spanPaperGoldQuantity"><?php echo $goldDto->getPaperGoldQuantity()?></span><span
                                    id="MyGoldAccount1_Label3"> <?php echo __('g', null, "goldTrading") ?></span></font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <font color='white'><?php echo __('Average Price (Buy)', null, "goldTrading") ?>：</font>
                        </td>
                        <td>
                            <font color="#ff9200">
                                <span id="MyGoldAccount1_Label5">$</span><span id="spanAveragePriceBuy"><?php echo $goldDto->getAveragePriceBuy()?></span>
                                <span
                                        id="MyGoldAccount1_Label4">/<?php echo __('g', null, "goldTrading") ?></span></font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <font color='white'><?php echo __('Unrealized Profit/Loss', null, "goldTrading") ?>：</font>
                        </td>
                        <td>
                            <font color="#ff9200"><span
                                    id="MyGoldAccount1_Label6">$</span><span id="spanUnrealizedProfitLoss"><?php echo $goldDto->getUnrealizedProfitLoss4Decimals()?></span>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 38%; white-space: nowrap;">
                            <font color='white'><?php echo __('E-Cash', null, "goldTrading") ?>：</font>
                        </td>
                        <td>
                            <font color="#ff9200"><span
                                    id="MyGoldAccount1_Label2">$</span><span id="spanEcash"><?php echo $goldDto->getEcash()?></span></font>
                        </td>
                    </tr>

                    <tr>
                        <td valign="baseline" align="right">
                            <font color='white'><?php echo __('We sell', null, "goldTrading") ?>：</font>
                        </td>
                        <td valign="baseline" align="left">
                            <span style="color:#FF9200;" id="Label4">$</span><span style="color:#FF9200;"
                                                                                   id="spanGoldSell"><?php echo $goldDto->getGoldSell()?></span><span
                                style="color:#FF9200;" id="Labelusdbuy">/<?php echo __('g', null, "goldTrading") ?></span>&nbsp;<input
                                type="text"
                                style="width:80px;"
                                id="txtBuyAmount" maxlength="4"
                                name="txtBuyAmount"><span
                                id="Labelgram"><font color='white'><?php echo __('gram', null, "goldTrading") ?></font></span>&nbsp;&nbsp;
                                    <?php
                                    //if($tbl_setting->getFValue()=='0' && $account->getFBalance() >= 5){
                                    if($tbl_setting->getFValue()=='0'){
                                    ?>
                                        <input type="button" class="bp_20" id="btnGoldBuy" value="<?php echo __('Buy', null, "goldTrading") ?>" name="btnGoldBuy">
                                    <?php
                                        }
                                    ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="baseline" align="right">
                            <font color='white'><?php echo __('We buy', null, "goldTrading") ?>：</font>
                        </td>
                        <td valign="baseline" align="left">
                            <span style="color:#FF9200;" id="Label2">$</span><span style="color:#FF9200;"
                                                                                   id="spanGoldBuy"><?php echo $goldDto->getGoldBuy()?></span><span
                                style="color:#FF9200;" id="Label5">/<?php echo __('g', null, "goldTrading") ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
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
                                <th><?php echo __('Price($/g)', null, 'goldTrading') ?></th>
                                <th><?php echo __('Quantity(g)', null, 'goldTrading') ?></th>
                                <th><?php echo __('Price(g)', null, 'goldTrading') ?></th>
                                <th><?php echo __('Purchase Date', null, 'goldTrading') ?></th>
                                <th><?php echo __('Unrealized Profit/Loss($)', null, 'goldTrading') ?></th>
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
                                <th><?php echo __('Quantity(g)', null, 'goldTrading') ?></th>
                                <th><?php echo __('Buy Price($/g)', null, 'goldTrading') ?></th>
                                <th><?php echo __('Margin Used($)', null, 'goldTrading') ?></th>
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
                                <th><?php echo __('Quantity(g)', null, 'goldTrading') ?></th>
                                <th><?php echo __('Sell Price($/g)', null, 'goldTrading') ?></th>
                                <th><?php echo __('Margin Returned', null, 'goldTrading') ?></th>
                                <th><?php echo __('Realised Profit/Loss', null, 'goldTrading') ?></th>
                                <th><?php echo __('Sell Date', null, 'goldTrading') ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    var modalPosition;
    if ($.browser.msie) {
        modalPosition = [740, 150];
    } else {
        modalPosition = "center"
    }
    $("#dgSellGold").dialog("destroy");
    $("#dgSellGold").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        position: modalPosition,
        hide: 'clip',
        width: 400,
        buttons: {
            "<?php echo __('Cancel') ?>": function() {
                $(this).dialog('close');
            },
            "<?php echo __('Submit') ?>": function() {
                if ($("#dgSellGold_quantityToSell").val() == 0) {
                    alert("<?php echo __('Quantity to sell cannot be zero', null, "goldTrading") ?>.");
                    $("#dgSellGold_quantityToSell").focus().select();
                } else if (parseFloat($("#dgSellGold_quantityToSell").val()) > parseFloat($("#dgSellGold_remainingPaperGold").val())){
                    alert("<?php echo __('In-sufficient gold remaining', null, "goldTrading") ?>.");
                    $("#dgSellGold_quantityToSell").focus().select();
                } else {
                    var currentGoldPrice = $("#dgSellGold_weBuy").val();
                    var goldAmount = $("#dgSellGold_quantityToSell").val();

                    var marginReturn = parseFloat(goldAmount) * parseFloat(currentGoldPrice);
                    var profitLost = parseFloat(goldAmount) * parseFloat($("#dgSellGold_oriPrice").val());
                    profitLost = marginReturn - profitLost;

                    marginReturn = Math.ceil(marginReturn * 100) / 100;
                    profitLost = Math.ceil(profitLost * 100) / 100;

                    var sure = confirm("<?php echo __('Current Gold Price(sell)', null, "goldTrading") ?>:" + currentGoldPrice + "\n<?php echo __('Amount', null, "goldTrading") ?>:" + goldAmount + "(<?php echo __('g', null, "goldTrading") ?>)\n<?php echo __('Margin Returned', null, "goldTrading") ?>:" + marginReturn + "\n<?php echo __('Trading Profit / Loss', null, "goldTrading") ?>:" + profitLost + "\n<?php echo __('Click OK to proceed?', null, "goldTrading") ?>");
                    if (sure) {
                        doSellgold();
                    }
                }
            }
        },
        open: function() {
            $('#dgSellGold_quantityToSell').focus().select();
        },
        close: function() {

        }
    });
})
function doSellgold(){
    $.ajax({
        type : 'POST',
        url : "/gold/doSellgold",
        dataType : 'json',
        cache: false,
        data: {
            id : $("#dgSellGold_transactionId").val()
            , gp : $("#dgSellGold_weBuy").val()
            , q : $("#dgSellGold_quantityToSell").val()
        },
        success : function(data) {
            if (data.error) {
                if (data.errorType == "REFRESH") {
                    var currentGoldPrice = data.goldBuy;
                    var goldAmount = $("#dgSellGold_quantityToSell").val();

                    var marginReturn = parseFloat(goldAmount) * parseFloat(currentGoldPrice);
                    var profitLost = parseFloat(goldAmount) * parseFloat($("#dgSellGold_oriPrice").val());
                    profitLost = marginReturn - profitLost;

                    marginReturn = Math.ceil(marginReturn * 100) / 100;
                    profitLost = Math.ceil(profitLost * 100) / 100;

                    var sure = confirm("<?php echo __('Latest gold price(sell)', null, "goldTrading") ?>:" + currentGoldPrice + "\n<?php echo __('Amount', null, "goldTrading") ?>:" + goldAmount + "(<?php echo __('g', null, "goldTrading") ?>)\n<?php echo __('Margin Returned', null, "goldTrading") ?>:" + marginReturn + "\n<?php echo __('Trading Profit / Loss', null, "goldTrading") ?>:" + profitLost + "\n<?php echo __('Click OK to proceed?', null, "goldTrading") ?>");
                    //var sure = confirm("Latest gold price " + data.goldBuy + ". Do you want to continue?");
                    if (sure) {
                        $("#dgSellGold_weBuy").val(data.goldBuy);
                        doSellgold();
                    }
                } else {
                    alert(data.errorMsg);
                    $("#dgSellGold").dialog("close");
                }
            } else {
                $("#dgSellGold").dialog("close");
                refreshPageData();
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
        }
    });
}
<?php
    if($tbl_setting->getFValue()=='1'){
       echo 'alert("'.__('Gold Market Closed.').'");';
    }
?>
</script>
<div id="dgSellGold" title="<?php echo __('Sell Gold', null, "goldTrading") ?>" style="display:none;">
    <input type="hidden" id="dgSellGold_oriPrice">
    <table cellspacing="5">
        <tr>
            <td class="text"><label><?php echo __('Transaction ID', null, "goldTrading") ?></label></td>
            <td>:</td>
            <td><input type="text" readonly="readonly" id="dgSellGold_transactionId" value="<?php echo $pin; ?>" class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Remaining Paper Gold', null, "goldTrading") ?></label></td>
            <td>:</td>
            <td><input type="text" readonly="readonly" id="dgSellGold_remainingPaperGold" class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('We sell', null, "goldTrading") ?></label></td>
            <td>:</td>
            <td><input type="text" readonly="readonly" id="dgSellGold_weSell" class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('We buy', null, "goldTrading") ?></label></td>
            <td>:</td>
            <td><input type="text" readonly="readonly" id="dgSellGold_weBuy" class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Quantity to sell', null, "goldTrading") ?></label></td>
            <td>:</td>
            <td><input type="text" id="dgSellGold_quantityToSell" class="text ui-widget-content ui-corner-all" readonly="readonly"/></td>
        </tr>
    </table>
</div>