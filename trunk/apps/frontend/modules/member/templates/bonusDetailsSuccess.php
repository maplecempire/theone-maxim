<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    var datagrid = null;
    var datagridDetail = null;
    $(function() {
        datagrid = $("#datagrid").r9jasonDataTable({
            // online1DataTable extra params
            "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
            "extraParam" : function(aoData) { // pass extra params to server

            },
            "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                reassignDatagridDetailEventAttr();
            },

            // datatables params
            "bLengthChange": true,
            "bFilter": false,
            "bProcessing": true,
            "bServerSide": true,
            "bAutoWidth": false,
            "sAjaxSource": "/finance/bonusDetailLogList",
            "sPaginationType": "full_numbers",
            "aaSorting": [
                [0,'desc']
            ],
            "aoColumns": [
                { "sName" : "commission.created_on",  "bSortable": true},
                { "sName" : "_DRB",  "bSortable": true, "fnRender": function ( oObj ) {
                    return "<a class='detailLink' ref='" + oObj.aData[0] + "' transaction='DRB' href='#'>" + oObj.aData[1] + "</a>";
                }},
                { "sName" : "_GDB",  "bSortable": true, "fnRender": function ( oObj ) {
                    return "<a class='detailLink' ref='" + oObj.aData[0] + "' transaction='GDB' href='#'>" + oObj.aData[2] + "</a>";
                }},
                { "sName" : "_PIPS_BONUS",  "bSortable": true, "fnRender": function ( oObj ) {
                    return "<a class='detailLink' ref='" + oObj.aData[0] + "' transaction='PIPS_BONUS' href='#'>" + oObj.aData[3] + "</a>";
                }},
                { "sName" : "_SPECIAL_BONUS",  "bSortable": true, "fnRender": function ( oObj ) {
                    return "<a class='detailLink' ref='" + oObj.aData[0] + "' transaction='SPECIAL_BONUS' href='#'>" + oObj.aData[4] + "</a>";
                }},
                { "sName" : "SUB_TOTAL",  "bSortable": true}
            ]
        });
    }); // end function

    function reassignDatagridDetailEventAttr() {
        $(".detailLink").click(function(event) {
            event.preventDefault();

            $("#textboxQueryDate").val($(this).attr("ref"));
            $("#textboxQueryAction").val($(this).attr("transaction"));
            $("#divBonusDetail").show();
            datagridDetail.fnDraw();
        });
    }
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Commission Details') ?></span></td>
    </tr>
    <tr>
        <td><br></td>
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
                    <th><?php echo __('Commission Details') ?></th>
                    <th class="tbl_content_right"></th>
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
                                <th><?php echo __('Date') ?></th>
                                <th><?php echo __('Direct Referrer Bonus') ?></th>
                                <th><?php echo __('Group Development Bonus') ?></th>
                                <th><?php echo __('Generation Bonus') ?></th>
                                <th><?php echo __('Special Bonus') ?></th>
                                <th><?php echo __('Sub Total') ?></th>
                            </tr>
                            </thead>
                        </table>

                        <div class="info_bottom_bg"></div>
                        <div class="clear"></div>
                        <br>

                        <script type="text/javascript" language="javascript">

                        $(function() {
                            datagridDetail = $("#datagridDetail").r9jasonDataTable({
                                // online1DataTable extra params
                                "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                                "extraParam" : function(aoData) { // pass extra params to server
                                    aoData.push({ "name": "filterAction", "value": $("#textboxQueryAction").val() });
                                    aoData.push({ "name": "filterDate", "value": $("#textboxQueryDate").val() });
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
                                "sAjaxSource": "/finance/bonusDetailList",
                                "sPaginationType": "full_numbers",
                                "aaSorting": [
                                    [0,'desc']
                                ],
                                "aoColumns": [
                                    { "sName" : "created_on",  "bSortable": true},
                                    { "sName" : "credit", "bVisible" : true,  "bSortable": true},
                                    { "sName" : "debit",  "bSortable": true},
                                    { "sName" : "balance",  "bSortable": true},
                                    { "sName" : "remark",  "bSortable": true}
                                ]
                            });
                        }); // end function

                        function reassignDatagridEventAttr() {
                            $("a[id=editLink]").click(function(event) {

                            });
                        }
                    </script>
                    <div id="divBonusDetail" style="display: none">
                        <input type="hidden" id="textboxQueryDate">
                        <input type="hidden" id="textboxQueryAction">
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
                            <th colspan="2"><?php echo __('Bonus Details') ?></th>
                            <th class="tbl_header_right">
                                <div class="border_right_grey">&nbsp;</div>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <table class="display" id="datagridDetail" border="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo __('Date') ?></th>
                            <th><?php echo __('Credit') ?></th>
                            <th><?php echo __('Debit') ?></th>
                            <th><?php echo __('Balance') ?></th>
                            <th><?php echo __('Remarks') ?></th>
                        </tr>
                        </thead>
                    </table>
                    </div>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>