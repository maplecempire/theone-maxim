<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    var datagrid = null;
    $(function() {
        datagrid = $("#datagrid").r9jasonDataTable({
                    // online1DataTable extra params
                    "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                    "extraParam" : function(aoData) { // pass extra params to server
                        aoData.push({ "name": "filterAction", "value": $("#search_action").val() });
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
                    "sAjaxSource": "/finance/ecashLogList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [0,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "account_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "credit", "bVisible" : true,  "bSortable": true},
                        { "sName" : "debit",  "bSortable": true},
                        { "sName" : "balance",  "bSortable": true},
                        { "sName" : "trnsaction_type",  "bSortable": true},
                        { "sName" : "created_on",  "bSortable": true},
                        { "sName" : "remark",  "bSortable": true}
                    ]
                });
    }); // end function

    function reassignDatagridEventAttr() {
        $("a[id=editLink]").click(function(event) {

        });
    }
</script>

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <!--<div class="sidenavi">
        <ul>
            <li><a href="/member/bonusDetails"><span><?php /*echo __('Bonus Details'); */?></span></a></li>
        </ul>
    </div>-->

    <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="portlet">
        <div class="portlet-header"><?php echo __('MT4 Credit Log') ?></div>
        <div class="portlet-content">
            <table class="display" id="datagrid" border="0" width="100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th><?php echo __('In') ?></th>
                    <th><?php echo __('Out') ?></th>
                    <th><?php echo __('Balance') ?></th>
                    <th><?php echo __('Transaction Type') ?></th>
                    <th><?php echo __('Date') ?></th>
                    <th><?php echo __('Remarks') ?></th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input size="15" type="text" id="search_action" value="" class="search_init"/></td>
                    <td></td>
                    <td></td>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>