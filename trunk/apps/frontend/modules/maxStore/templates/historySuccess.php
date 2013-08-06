<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    var datagrid = null;
    var datagridDetail = null;
    $(function() {
        datagridDetail = $("#datagridDetail").r9jasonDataTable({
            // online1DataTable extra params
            "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
            "extraParam" : function(aoData) { // pass extra params to server
                aoData.push({ "name": "filterHistoryId", "value": $("#txtHistoryId").val() });
            },
            "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server

            },

            // datatables params
            "bLengthChange": true,
            "bFilter": false,
            "bProcessing": true,
            "bServerSide": true,
            "bAutoWidth": false,
            "sAjaxSource": "/maxStore/historyDetailList",
            "sPaginationType": "full_numbers",
            "aaSorting": [
                [1,'desc']
            ],
            "aoColumns": [
                { "sName" : "detail.history_detail_id",  "bVisible": false},
                { "sName" : "product.product_name",  "bSortable": true},
                { "sName" : "detail.price",  "bSortable": true},
                { "sName" : "detail.qty",  "bSortable": true},
                { "sName" : "detail.total_amount", "bVisible" : true,  "bSortable": true}
            ]
        });
        datagrid = $("#datagrid").r9jasonDataTable({
            // online1DataTable extra params
            "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
            "extraParam" : function(aoData) { // pass extra params to server
                //aoData.push({ "name": "filterAction", "value": $("#search_action").val() });
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
            "sAjaxSource": "/maxStore/historyList",
            "sPaginationType": "full_numbers",
            "aaSorting": [
                [1,'desc']
            ],
            "aoColumns": [
                { "sName" : "history_id",  "bVisible": false},
                { "sName" : "created_on",  "bSortable": true, "fnRender": function ( oObj ) {
                    return "<a class='detailLink' ref='" + oObj.aData[0] + "' href='#'>" + oObj.aData[1] + "</a>";
                }},
                { "sName" : "total_amount",  "bSortable": true},
                { "sName" : "status_code", "bVisible" : true,  "bSortable": true}
            ]
        });
    }); // end function

    function reassignDatagridEventAttr() {
        $(".detailLink").click(function(event) {
            event.preventDefault();


            $("#txtHistoryId").val($(this).attr("ref"));
            $(".detailTable").show();
            datagridDetail.fnDraw();
        });
    }
</script>

<div class="ewallet_li">
    <a target="_self" class="navcontainer" href="<?php echo url_for("/maxStore")?>" style="color: rgb(0, 93, 154);">
        <?php echo __('MAX Store'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
        <a target="_self" class="navcontainer" href="<?php echo url_for("/maxStore/history")?>" style="color: rgb(134, 197, 51);">
        <?php echo __('Transaction History'); ?>
    </a>
</div>

<input type="hidden" id="txtHistoryId" value="0">
<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Transaction History') ?></span></td>
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
                    <th colspan="2"><?php echo __('Transaction History') ?></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="1%">
                    <col width="30%">
                    <col width="69%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <!--<tr>
                    <th class="tbl_header_left">
                        <div class="border_left_grey">&nbsp;</div>
                    </th>
                    <th colspan="2"><?php /*echo __('Forex Point Statement') */?></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>-->

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <br>
                        <table class="display" id="datagrid" border="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo __('History ID') ?></th>
                                <th><?php echo __('Date') ?></th>
                                <th><?php echo __('Total Amount') ?></th>
                                <th><?php echo __('Status Code') ?></th>
                            </tr>
                            </thead>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                </tbody>
            </table>

            <table cellspacing="0" cellpadding="0" class="tbl_form detailTable" style="display: none;">
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
                    <th><?php echo __('History Detail') ?></th>
                    <th class="tbl_content_right"></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="0" style="display: none;" class="detailTable">
                <colgroup>
                    <col width="1%">
                    <col width="30%">
                    <col width="69%">
                    <col width="1%">
                </colgroup>
                <tbody>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <br>
                        <table class="display" id="datagridDetail" border="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo __('History Detail ID') ?></th>
                                <th><?php echo __('Product Name') ?></th>
                                <th><?php echo __('Price') ?></th>
                                <th><?php echo __('Qty') ?></th>
                                <th><?php echo __('Total Amount') ?></th>
                            </tr>
                            </thead>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>