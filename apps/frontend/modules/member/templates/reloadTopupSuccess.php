<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    $(function() {
        $("#cbo_topupAmount").change(function(){
            /*var result = parseFloat($(this).val()) * <?php //echo $usdToMyr;?>;*/
            var result = parseFloat($(this).val());
            var epointBalance = $('#epointBalance').val();
            $("#convertedAmount").autoNumericSet(result);
            $("#epointBalanceDisplay").autoNumericSet(epointBalance - result);
        });
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
                        if ($("#topupId").val() == "") {
                            alert("MT4 status is pending.");
                            return false;
                        }
                        var epointBalance = $('#epointBalance').val();
<!--                        var mt4Amount = $('#cbo_topupAmount').val() * --><?php //echo $usdToMyr;?><!--;-->
                        var mt4Amount = $('#cbo_topupAmount').val();

                        if (parseFloat(mt4Amount) > parseFloat(epointBalance)) {
                            alert("In-sufficient e-Point");
                            return false;
                        }
                        waiting();

                        form.submit();
                    }
                });
        $("#cbo_topupAmount").trigger("change");
    });
</script>

<div class="aside">
    <?php //include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
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
        <form action="/member/reloadTopup" id="withdrawForm" name="withdrawForm" method="post">

            <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                    align="center">
                <caption><?php echo __('Reload MT4 Fund') ?></caption>
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
                                    <input name="topupId" id="topupId" tabindex="1" disabled="disabled" value="<?php echo $distributorDB->getMt4UserName(); ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('Reload MT4 Fund'); ?></strong>
                                </td>
                                <td class="value">
                                    <input name="epointBalance" id="epointBalance" type="hidden"
                                           value="<?php echo $ledgerEpointBalance; ?>"/>

                                    <select name="mt4Amount" id="cbo_topupAmount" tabindex="2">
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
                                    <!--&nbsp;USD-->
                                    &nbsp;<?php echo $systemCurrency; ?>
                                </td>
                            </tr>
                            <tr style="display: none;">
                                <td class="caption">
                                    <strong>USD convert to MYR <?php echo $usdToMyr;?></strong>
                                </td>
                                <td class="value">
                                    <input name="convertedAmount" id="convertedAmount" disabled="disabled" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong>e-Point Balance</strong>
                                </td>
                                <td class="value">
                                    <input name="epointBalanceDisplay" id="epointBalanceDisplay" disabled="disabled" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('Security Password'); ?></strong>
                                </td>
                                <td class="value">
                                    <input name="transactionPassword" type="password" id="transactionPassword"
                                           tabindex="3"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' align="center">
                                    <font color="#dc143c"><?php echo __('Note : MT4 Fund Reload will take 2 business days. ') ?></font>
                                </td>
                            </tr>

                            <tr>
                                <td colspan=2 align='center'>
                                    <input type="submit" name="Button1" value="<?php echo __('Submit') ?>"
                                           language="javascript"
                                           id="btnTransfer" tabindex="5"/>
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
                    "sAjaxSource": "/finance/reloadMT4FundList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [1,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "dist_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "created_on",  "bSortable": true},
                        { "sName" : "amount",  "bSortable": true},
                        { "sName" : "status_code",  "bSortable": true},
                        { "sName" : "remarks",  "bSortable": true}
                    ]
                });
            }); // end function

            function reassignDatagridEventAttr() {
            }
        </script>

        <div class="portlet">
            <div class="portlet-header"><?php echo __('Reload MT4 Fund Status') ?></div>
            <div class="portlet-content">

                <table class="display" id="datagrid" border="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?php echo __('Date') ?></th>
                        <th><?php echo __('Amount') ?></th>
                        <th><?php echo __('Status') ?></th>
                        <th><?php echo __('Remarks') ?></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>