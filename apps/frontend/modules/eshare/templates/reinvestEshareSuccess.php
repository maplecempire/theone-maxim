<?php include('scripts.php'); ?>
<script type="text/javascript">

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
})
</script>

<form action="/eshare/buyShare" id="tradingForm" method="post">
<input type="hidden" name="buyType" value="maintenance">
<div style="padding: 10px; top: 30px; width: 98%">
<div class="portlet">
    <div class="portlet-header"><?php echo __('Reinvest e-Share') ?></div>
    <div class="portlet-content">

<table cellpadding="2" cellspacing="5" align="center" border="0">
    <tbody>
        <?php if ($sf_flash->has('successMsg')): ?>
        <tr>
            <td colspan="2">
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
            <td align="right" style="width: 38%; white-space: nowrap;">
                <strong><?php echo __('Paper e-Share Quantity', null, "goldTrading") ?>：</strong>
            </td>
            <td>
                <font color="#61210B">
                    <span id="spanPaperGoldQuantity"><?php echo number_format($eshareTradingDto->getPaperEshareQuantity(),0)?></span>
                    <span id="MyGoldAccount1_Label3"> <?php echo __('unit', null, "goldTrading") ?></span>
                </font>
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
                <strong><?php echo __('Maintenance Balance', null, "goldTrading") ?>：</strong>
            </td>
            <td>
                <font color="#61210B">
                    <span id="MyGoldAccount1_Label2">$</span>
                    <span id="spanEcash"><?php echo number_format($maintenance,2)?></span>
                    <input type="hidden" id="txtEcash" value="<?php echo $maintenance?>">
                </font>
            </td>
        </tr>

        <tr>
            <td valign="baseline" align="right">
                <strong><?php echo __('We sell', null, "goldTrading") ?>：</strong>
            </td>
            <td valign="baseline" align="left">
                <span style="color:#61210B;" id="Label4">$</span>
                <span style="color:#61210B;" id="spanGoldSell"><?php echo $eshareTradingDto->getEsharePrice()?></span>
                <span style="color:#61210B;" id="Labelusdbuy">/<?php echo __('unit', null, "goldTrading") ?></span>&nbsp;
                <input type="text" style="width:80px;" id="txtBuyAmount" name="txtBuyAmount">
                <span id="Labelgram"><strong><?php echo __('USD', null, "goldTrading") ?></strong></span>&nbsp;&nbsp;

                    <?php
                    if($validToBuyShare == true){
                    ?>
                        <br><button id="btnBuy"><?php echo __('Buy', null, "goldTrading") ?></button>
                    <?php
                        }
                    ?>
            </td>
        </tr>
        </tbody>
</table>
    </div>
</div>
</div>
</form>