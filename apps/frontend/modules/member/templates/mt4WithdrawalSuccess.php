<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
var usdToMyr = <?php echo $usdToMyr;?>;
var handlingCharge = <?php echo $handlingCharge;?>;
var handlingChargeInUsd = <?php echo $handlingChargeInUsd;?>;
$(function() {
    $("#paymentType").change(function() {
        /*if ($(this).val() == "BANK") {
            $(".bankDisplay").show();
        } else {
            $(".bankDisplay").hide();
        }*/
        $("#cbo_mt4Amount").change();
    }).trigger("change");

    $("#cbo_mt4Amount").change(function() {
        var usd = $(this).val();
        var myr = usd * usdToMyr;

        var minHandlingFee = 0;
        var myrAmount = 0;
        var handlingFee = 0;
        var currencyCode = "USD";
        var grandAmount = 0;

        /*if ($("#paymentType").val() == "BANK") {
            currencyCode = "MYR";

            minHandlingFee = handlingChargeInUsd * usdToMyr;
            myrAmount = usd * usdToMyr;
            handlingFee = Math.round((myrAmount * handlingCharge / 100) * 100) / 100;
            if (handlingFee < minHandlingFee)
                handlingFee = minHandlingFee;

            grandAmount = myrAmount - handlingFee;
        } else if ($("#paymentType").val() == "VISA") {*/
            currencyCode = "USD";

            minHandlingFee = Math.round((usd * handlingCharge / 100) * 100) / 100;
            if (minHandlingFee < handlingChargeInUsd)
                handlingFee = handlingChargeInUsd;
            else
                handlingFee = minHandlingFee;

            grandAmount = usd - handlingFee;
        //}

        $("#myrCurrency").autoNumericSet(myrAmount);
        $("#handlingFee").autoNumericSet(handlingFee);
        $("#grandAmount").autoNumericSet(grandAmount);
        $(".currencyCode").html(currencyCode);
    }).trigger("change");

    $("#withdrawForm").validate({
                messages : {
                    transactionPassword: {
                        remote: "<?php echo __("Security Password is not valid")?>"
                    }
                },
                rules : {
                    "transactionPassword" : {
                        required : true
                        , remote: "/member/verifyTransactionPassword"
                    }
                },
                submitHandler: function(form) {
                    if ($("#mt4Id").val() == "") {
                        alert("MT4 status is pending.");
                        return false;
                    }
                    waiting();

                    form.submit();
                }
            });
});
</script>
<?php
    if ($toHideCp2Cp3Transfer == false) {
    ?>
<div class="ewallet_li">
	<a target="_self" class="navcontainer" href="/member/mt4Withdrawal" style="color: rgb(134, 197, 51);">
        <?php echo __('MT4 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/ecashWithdrawal");?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP2 Withdrawal'); ?>
    </a>
        &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/cp3Withdrawal");?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP3 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/maturityWithdrawal");?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP2 Withdrawal (Maturity)'); ?>
    </a>
    &nbsp;&nbsp;
</div>
<?php } ?>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('MT4 Withdrawal') ?></span></td>
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
            <form action="/member/mt4Withdrawal" id="withdrawForm" name="withdrawForm" method="post">
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
                    <th colspan="2"><?php echo __('MT4 Withdrawal') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('MT4 ID'); ?></td>
                    <td>
                        <select name="mt4Id" id="mt4Id" tabindex="1">
                            <?php
                                if (count($distMt4DBs) >= 1) {
                                    foreach ($distMt4DBs as $distMt4DB) {
                                        echo "<option value='".$distMt4DB->getMt4UserName()."'>".$distMt4DB->getMt4UserName()."</option>";
                                    }
                                } else {
                                    echo "<option value=''>--</option>";
                                }
                            ?>
                        </select>
                        <!--<input name="mt4Id" id="mt4Id" disabled="disabled" value="<?php /*//echo $distributorDB->getMt4UserName(); */?>"/>-->
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even" style="display: none;">
                    <td>&nbsp;</td>
                    <td><?php echo __('Payment Type'); ?></td>
                    <td>
                        <select name="paymentType" id="paymentType">
                            <option value='VISA'><?php echo __('Maxim Trader VISA Debit Card'); ?></option>
                            <option value='BANK'><?php echo __('Local Bank Transfer'); ?></option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('MT4 Fund Withdrawal Amount In USD'); ?></td>
                    <td>
                        <select name="mt4Amount" id="cbo_mt4Amount" style="text-align:right">
                            <?php
                                //if ($distributorDB->getMt4UserName() != null) {
                                for ($i = 100; $i <= 10000; $i = $i + 100) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                for ($i = 10500; $i <= 100000; $i = $i + 500) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                //}
                            ?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even"  style="display: none;">
                    <td>&nbsp;</td>
                    <td><?php echo __('USD convert to MYR ').$usdToMyr; ?></td>
                    <td>
                        <input name="myrCurrency" id="myrCurrency" disabled="disabled" value=""/>
                        <span class="currencyCode"></span>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd" style="display: none;">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Bank Charges') ?>
                    </td>
                    <td>
                        <input name="handlingFee" id="handlingFee" disabled="disabled" value=""/>
                        <span class="currencyCode"></span>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even" style="display: none;">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Grand Amount') ?>
                    </td>
                    <td>
                        <input name="grandAmount" id="grandAmount" disabled="disabled" value=""/>
                        <span class="currencyCode"></span>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Security Password'); ?>
                    </td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td align="right" valign="top">
                        <font color="#dc143c">
                            <?php echo __('NOTE :') ?> &nbsp;
                        </font>
                    </td>
                    <td align="left">
                        <!--<font color="#dc143c"><?php /*echo __('NOTE : Minimum withdrawal amount : USD 100<br>Processing time : 5-7 working days<br>Bank charges : Minimum USD '.$handlingChargeInUsd.' depends on your corresponding banks') */?></font>-->
                        <font color="#dc143c">
                            1. <?php echo __('Minimum withdrawal amount : USD 100') ?><br>
                            2. <?php echo __('Processing time : 3 working days') ?><br>
                            3. <?php echo __('Please close your floating trading before you submit withdrawal') ?><br>
                            4. <?php echo __('MT4 Withdrawal will be credited into CP3 account') ?>
                        </font>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnTransfer"><?php echo __('Submit') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>

            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <script type="text/javascript" language="javascript">
            var datagrid = null;
            $(function() {
                datagrid = $("#datagrid").r9jasonDataTable({
                    // online1DataTable extra params
                    "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                    "extraParam" : function(aoData) { // pass extra params to server
                    },
                    "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                        reassignDatagridEventAttr();
                    },

                    // datatables params
                    "bLengthChange": true,
                    "bFilter": false,
                    "bProcessing": true,
                    "bServerSide": true,
                    "bAutoWidth": false,
                    "sAjaxSource": "/finance/mt4WithdrawalList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [2,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "dist_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "currency_code", "bVisible" : false,  "bSortable": true},
                        { "sName" : "created_on",  "bSortable": true},
                        { "sName" : "amount_requested",  "bSortable": true},
                        { "sName" : "handling_fee",  "bVisible": false},
                        { "sName" : "grand_amount",  "bVisible": false},
                        { "sName" : "payment_type",  "bVisible": false},
                        { "sName" : "status_code",  "bSortable": true},
                        { "sName" : "remarks",  "bSortable": true}
                    ]
                });
            }); // end function

            function reassignDatagridEventAttr() {
            }
        </script>

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
                <th><?php echo __('MT4 Withdrawal Status') ?></th>
                <th class="tbl_content_right"></th>
                <th class="tbl_header_right">
                    <div class="border_right_grey">&nbsp;</div>
                </th>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="display" id="datagrid" border="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th><?php echo __('Currency Code') ?></th>
                <th><?php echo __('Date') ?></th>
                <th><?php echo __('Amount Requested (USD)') ?></th>
                <th><?php echo __('Bank Charges (USD)') ?></th>
                <th><?php echo __('Grand Amount (USD)') ?></th>
                <th><?php echo __('Payment Type') ?></th>
                <th><?php echo __('Status') ?></th>
                <th><?php echo __('Remarks') ?></th>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>