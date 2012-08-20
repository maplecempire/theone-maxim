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
                        remote: "Security Password is not valid."
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

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <!--<div class="sidenavi">
        <ul>
            <li><a href="/member/viewProfile"><span><?php /*echo __('Account Information'); */?></span></a></li>
            <li><a href="/member/viewBankInformation"><span><?php /*echo __('Bank Account Information'); */?></span></a></li>
            <li><a href="/member/loginPassword"><span><?php /*echo __('Change Password'); */?></span></a></li>
            <li><a href="/member/transactionPassword"><span><?php /*echo __('Change Security Password'); */?></span></a></li>
        </ul>
    </div>-->

    <?php //include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="resultsWrap">
        <form action="/member/mt4Withdrawal" id="withdrawForm" name="withdrawForm" method="post">

            <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                    align="center">
                <caption><?php echo __('MT4 Withdrawal') ?></caption>
                <tr>
                    <td colspan=2 align='center'>
                        <?php if ($sf_flash->has('successMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;"
                                         class="ui-icon ui-icon-info"></span>
                                    <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($sf_flash->has('errorMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;"
                                 class="ui-state-error ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;"
                                         class="ui-icon ui-icon-alert"></span>
                                    <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" width="650px" style="margin:0 auto">
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('MT4 ID'); ?></strong>
                                </td>
                                <td class="value">
                                    <input name="mt4Id" id="mt4Id" disabled="disabled" value="<?php echo $distributorDB->getMt4UserName(); ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('Payment Type'); ?></strong>
                                </td>
                                <td class="value">
                                    <select name="paymentType" id="paymentType">
                                        <option value='VISA'>VISA Cash Card</option>
                                        <option value='BANK'>Local Bank Transfer</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('MT4 Fund Withdrawal Amount In USD'); ?></strong>
                                </td>
                                <td class="value">
                                    <select name="mt4Amount" id="cbo_mt4Amount">
                                        <?php
                                            if ($distributorDB->getMt4UserName() != null) {
                                                for ($i = 100; $i <= 10000; $i = $i + 100) {
                                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                                }
                                                for ($i = 20000; $i <= 50000; $i = $i + 10000) {
                                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr class="bankDisplay" style="display: none;">
                                <td class="caption">
                                    <strong><?php echo __('USD convert to MYR ').$usdToMyr; ?></strong>
                                </td>
                                <td class="value">
                                    <input name="myrCurrency" id="myrCurrency" disabled="disabled" value=""/>
                                    <span class="currencyCode"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('Bank Charges') ?></strong>
                                </td>
                                <td class="value">
                                    <input name="handlingFee" id="handlingFee" disabled="disabled" value=""/>
                                    <span class="currencyCode"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('Grand Amount') ?></strong>
                                </td>
                                <td class="value">
                                    <input name="grandAmount" id="grandAmount" disabled="disabled" value=""/>
                                    <span class="currencyCode"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('Security Password'); ?></strong>
                                </td>
                                <td class="value">
                                    <input name="transactionPassword" type="password" id="transactionPassword"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" valign="top">
                                    <font color="#dc143c">NOTE :</font>
                                </td>
                                <td colspan='2' align="left">
                                    <!--<font color="#dc143c">VISA Cash Card base on USD, Local Bank Transfer base on MYR <br>Handling fee <?php /*echo $handlingCharge*/?>% or USD <?php /*echo $handlingChargeInUsd*/?> whichever is higher</font>-->
                                    <font color="#dc143c">Minimum withdrawal amount : USD 100<br>Processing time : 5-7 working days<br>Bank charges : Minimum USD <?php echo $handlingChargeInUsd?> depends on your corresponding banks</font>
                                </td>
                            </tr>

                            <tr>
                                <td colspan=2 align='center'>
                                    <input type="submit" name="Button1" value="<?php echo __('Submit') ?>"
                                           language="javascript"
                                           id="btnTransfer"/>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>

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
                        { "sName" : "handling_fee",  "bSortable": true},
                        { "sName" : "grand_amount",  "bSortable": true},
                        { "sName" : "payment_type",  "bSortable": true},
                        { "sName" : "status_code",  "bSortable": true},
                        { "sName" : "remarks",  "bSortable": true}
                    ]
                });
            }); // end function

            function reassignDatagridEventAttr() {
            }
        </script>

        <div class="portlet">
            <div class="portlet-header"><?php echo __('MT4 Withdrawal Status') ?></div>
            <div class="portlet-content">

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
            </div>
        </div>
    </div>
</div>
