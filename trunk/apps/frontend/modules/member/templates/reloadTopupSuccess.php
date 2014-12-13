<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    $(function() {
        /*$("#cbo_topupAmount").change(function(){
            *//*var result = parseFloat($(this).val()) * <?php //echo $usdToMyr;?>;*//*
            var result = parseFloat($(this).val());
            var epointBalance = $('#epointBalance').val();
            $("#convertedAmount").autoNumericSet(result);
        });*/
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
                if ($("#mt4UserName").val() == "") {
                    alert("MT4 status is pending.");
                    return false;
                }
                var epointBalance = $('#epointBalance').val();
                var mt4Amount = $('#mt4Amount').autoNumericGet();

                if (parseFloat(mt4Amount) > parseFloat(epointBalance)) {
                    error("In-sufficient CP1");
                    return false;
                }
                waiting();
                $('#mt4Amount').val(mt4Amount);
                form.submit();
            }
        });
        /*$("#cbo_topupAmount").trigger("change");*/

        $('#mt4Amount').autoNumeric({
            mDec: 2
        });
    });
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Reload MT4 Fund') ?></span></td>
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
            <form action="/member/reloadTopup" id="withdrawForm" name="withdrawForm" method="post">
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
                    <th colspan="2"><?php echo __('Reload MT4 Fund') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('MT4 ID'); ?></td>
                    <td>
                        <select name="mt4UserName" id="mt4UserName" tabindex="1">
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
                        <!--<input name="mt4UserName" id="mt4UserName" tabindex="1" disabled="disabled" value="<?php /*//echo $distributorDB->getMt4UserName(); */?>"/>-->
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr style="display: none;">
                    <td>&nbsp;</td>
                    <td>
                        <strong>USD convert to MYR <?php echo $usdToMyr;?></strong>
                    </td>
                    <td>
                        <input name="convertedAmount" id="convertedAmount" disabled="disabled" value=""/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Reload MT4 Fund'); ?></td>
                    <td>
                        <input name="epointBalance" id="epointBalance" type="hidden"
                               value="<?php echo $ledgerEpointBalance; ?>"/>

                        <input name="mt4Amount" id="mt4Amount" type="text" value=""/>
                        <!--<select name="mt4Amount" id="cbo_topupAmount" tabindex="2">
                            <?php
/*                                    for ($i = 100; $i <= 10000; $i = $i + 100) {
                                        echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                    }
                                    for ($i = 20000; $i <= 50000; $i = $i + 10000) {
                                        echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                    }
                            */?>
                        </select>-->
                        <!--&nbsp;USD-->
                        &nbsp;<?php echo $systemCurrency; ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP1 Balance'); ?></td>
                    <td>
                        <input name="epointBalanceDisplay" id="epointBalanceDisplay" disabled="disabled" value="<?php echo number_format($ledgerEpointBalance,2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password'); ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2" align="center">
                        <font color="#dc143c"><?php echo __('Note : MT4 Fund Reload will take 2 business days') ?></font>
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
                    "sAjaxSource": "/finance/reloadMT4FundList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [1,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "dist_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "created_on",  "bSortable": true},
                        { "sName" : "mt4_user_name",  "bSortable": true},
                        { "sName" : "amount",  "bSortable": true},
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
                <th><?php echo __('Reload MT4 Fund Status') ?></th>
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
                <th><?php echo __('Date') ?></th>
                <th><?php echo __('MT4 ID') ?></th>
                <th><?php echo __('Amount') ?></th>
                <th><?php echo __('Status') ?></th>
                <th><?php echo __('Remarks') ?></th>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>