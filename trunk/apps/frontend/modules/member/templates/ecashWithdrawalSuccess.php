<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    $(function() {
        $("#cbo_ecashAmount").change(function(){
            var ecashFinal = $("#cbo_ecashAmount").val() * 0.95;

            $("#ecashFinal").autoNumericSet(ecashFinal);
        }).change();
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
                        waiting();
                        var ecashBalance = $('#ecashBalance').autoNumericGet();
                        var withdrawAmount = parseFloat($("#cbo_ecashAmount").val());

                        if (withdrawAmount > parseFloat(ecashBalance)) {
                            alert("In-sufficient E-Cash");
                            return false;
                        }

                        form.submit();
                    }
                });
    });
</script>

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <div class="sidenavi">
        <ul>
            <li><a href="/member/viewProfile"><span><?php echo __('Account Information'); ?></span></a></li>
            <li><a href="/member/viewBankInformation"><span><?php echo __('Bank Account Information'); ?></span></a></li>
            <li><a href="/member/loginPassword"><span><?php echo __('Change Password'); ?></span></a></li>
            <li><a href="/member/transactionPassword"><span><?php echo __('Change Security Password'); ?></span></a></li>
        </ul>
    </div>

    <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="resultsWrap">
        <form action="/member/ecashWithdrawal" id="withdrawForm" name="withdrawForm" method="post">

            <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                    align="center">
                <caption><?php echo __('e-Cash Withdrawal') ?></caption>
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
                                    <strong><?php echo __('e-Cash Balance'); ?></strong>
                                </td>
                                <td class="value">
                                    <input name="ecashBalance" id="ecashBalance" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($ledgerAccountBalance, 2); ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('e-Cash Withdrawal Amount'); ?></strong>
                                </td>
                                <td class="value">
                                    <select name="ecashAmount" id="cbo_ecashAmount" tabindex="2">
                                        <option value="200">200</option>
                                        <option value="500">500</option>
                                        <option value="1000">1,000</option>
                                        <option value="1500">1,500</option>
                                        <option value="2000">2,000</option>
                                        <option value="2500">2,500</option>
                                        <option value="3000">3,000</option>
                                        <option value="3500">3,500</option>
                                        <option value="4000">4,000</option>
                                        <option value="4500">4,500</option>
                                        <option value="5000">5,000</option>
                                        <?php
                                            for ($i = 6000; $i <= 100000; $i = $i + 1000) {
                                                echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                            }

                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="caption">
                                    <strong><?php echo __('After 5% handling fee'); ?></strong>
                                </td>
                                <td class="value">
                                    <input name="ecashFinal" type="text" id="ecashFinal" readonly="readonly"
                                           tabindex="3"/>
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
                                    <font color="#dc143c"> <?php echo __('Note : charge 5% handling fees when e-Cash withdrawal requested. ') ?></font>
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
                            "sAjaxSource": "/finance/ecashWithdrawalList",
                            "sPaginationType": "full_numbers",
                            "aaSorting": [
                                [5,'desc']
                            ],
                            "aoColumns": [
                                { "sName" : "dist_id", "bVisible" : false,  "bSortable": true},
                                { "sName" : "deduct",  "bSortable": true},
                                { "sName" : "amount",  "bSortable": true},
                                { "sName" : "status_code",  "bSortable": true},
                                { "sName" : "remarks",  "bSortable": true},
                                { "sName" : "created_on",  "bSortable": true}
                            ]
                        });
            }); // end function

            function reassignDatagridEventAttr() {
            }
        </script>

        <div class="portlet">
            <div class="portlet-header"><?php echo __('e-Cash Withdrawal Status') ?></div>
            <div class="portlet-content">

                <table class="display" id="datagrid" border="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?php echo __('Withdrawal') ?></th>
                        <th><?php echo __('Amount') ?></th>
                        <th><?php echo __('Status') ?></th>
                        <th><?php echo __('Remarks') ?></th>
                        <th><?php echo __('Date') ?></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
