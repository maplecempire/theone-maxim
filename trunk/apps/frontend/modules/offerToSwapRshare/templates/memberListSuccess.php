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
            "sAjaxSource": "/offerToSwapRshare/downlineMemberList",
            "sPaginationType": "full_numbers",
            "aoColumns": [
                { "sName" : "roi.dist_id",  "bVisible": false},
                { "sName" : "roi.mt4_user_name",  "bSortable": false},
                { "sName" : "dist.distributor_code",  "bSortable": false},
                { "sName" : "dist.full_name",  "bSortable": false},
                { "sName" : "dist.contact",  "bSortable": false},
                { "sName" : "dist.email",  "bSortable": false}
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
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Member List - SSS') ?></span></td>
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
                    <th><?php echo __('Member List - SSS') ?></th>
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

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <br>
                        <table class="display" id="datagrid" border="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo __('Member ID') ?></th>
                                <th><?php echo __('MT4 ID') ?></th>
                                <th><?php echo __('Member ID') ?></th>
                                <th><?php echo __('Full Name') ?></th>
                                <th><?php echo __('Contact Number') ?></th>
                                <th><?php echo __('Email') ?></th>
<!--                                <th>--><?php //echo __('Remaining ROI') ?><!--</th>-->
<!--                                <th>--><?php //echo __('Converted') ?><!--</th>-->
<!--                                <th>--><?php //echo __('Formula') ?><!--</th>-->
<!--                                <th>--><?php //echo __('Total Share Converted') ?><!--</th>-->
                            </tr>
                            </thead>
                        </table>

                        <div class="info_bottom_bg"></div>
                        <div class="clear"></div>
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>