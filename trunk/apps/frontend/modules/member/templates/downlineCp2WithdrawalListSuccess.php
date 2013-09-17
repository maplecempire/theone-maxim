<?php include('scripts.php'); ?>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Downline CP2 Withdrawal') ?></span></td>
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
            <script type="text/javascript" language="javascript">
            var datagrid = null;
            $(function() {
                datagrid = $("#datagrid").r9jasonDataTable({
                    // online1DataTable extra params
                    "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                    "extraParam" : function(aoData) { // pass extra params to server
                        aoData.push({ "name": "filterMemberId", "value": $("#search_memberId").val() });
                        aoData.push({ "name": "filterStatusCode", "value": $("#search_combo_statusCode").val() });
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
                    "sAjaxSource": "/finance/downlineCp2WithdrawalList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [7,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "withdrawal.dist_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "dist.distributor_code", "bVisible" : true,  "bSortable": true},
                        { "sName" : "withdrawal.deduct",  "bSortable": true},
                        { "sName" : "withdrawal.amount",  "bSortable": true},
                        { "sName" : "withdrawal.bank_in_to",  "bSortable": true},
                        { "sName" : "withdrawal.status_code",  "bSortable": true},
                        { "sName" : "withdrawal.remarks",  "bSortable": true},
                        { "sName" : "withdrawal.created_on",  "bSortable": true}
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
                <th><?php echo __('CP3 Withdrawal Status') ?></th>
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
                <th><?php echo __('Member ID') ?></th>
                <th><?php echo __('Withdrawal') ?></th>
                <th><?php echo __('Amount') ?></th>
                <th><?php echo __('Credit To') ?></th>
                <th><?php echo __('Status') ?></th>
                <th><?php echo __('Remarks') ?></th>
                <th><?php echo __('Date') ?></th>
            </tr>
            <tr>
                <td></td>
                <td><input size="10" type="text" id="search_memberId" value="" class="search_init"/></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <select id="search_combo_statusCode">
                        <option value="">All</option>
                        <option value="PENDING" selected="selected">PENDING</option>
                        <option value="PROCESSING">PROCESSING</option>
                        <option value="REJECTED">REJECTED</option>
                        <option value="PAID">PAID</option>
                    </select>
                </td>
                <td></td>
                <td></td>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>