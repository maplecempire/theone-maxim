<?php
use_helper('I18N');
?>

<?php echo form_tag('admin/doLogin', 'id=loginForm') ?>
<input type="hidden" id="distId" value="0">
<div style="padding: 10px; top: 30px; position: absolute; width: 1000px">
    <div class="portlet">
        <div class="portlet-header"><?php echo __('Pips Bonus') ?></div>
        <div class="portlet-content">
            <div id="divPIPS">
                <table class="display" id="datagridByMonth" border="0" width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: left;"><?php echo __('Date') ?></th>
                        <th style="text-align: right;"><?php echo __('Pips Bonus') ?></th>
                        <th style="text-align: right;"><?php echo __('Credit Refund') ?></th>
                    </tr>
                    </thead>
                    <tbody id="pipsTbody">
                        <?php
                        $month = array();
                        $month["1"] = "January";
                        $month["2"] = "February";
                        $month["3"] = "March";
                        $month["4"] = "April";
                        $month["5"] = "May";
                        $month["6"] = "June";
                        $month["7"] = "July";
                        $month["8"] = "August";
                        $month["9"] = "September";
                        $month["10"] = "October";
                        $month["11"] = "November";
                        $month["12"] = "December";

                        $idx = 0;
                        $refId = "0";
                        foreach ($arr as $anode) {
                            echo "<tr class='odd'>
                                <td align='left'><a href='#' ref='".$anode["file_id"]."' class='monthLink'>" . $anode["year_traded"] . "-" . __($month[$anode["month_traded"]]) . "</a></td>
                                <td align='right' width='100'>" . number_format($bonusArr[$idx]['PIPS'], 2) . "</td>
                                <td align='right' width='100'>" . number_format($bonusArr[$idx]['CREDIT'], 2) . "</td>
                                </tr>";
                            $refId = $anode["file_id"];
                            $idx++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <script type="text/javascript">
                var datagrid = null;
                var bonusGroupDatagrid = null;
                var creditRefundGroupDatagrid = null;
                $(function() {
                    $(".monthLink").click(function(event){
                        event.preventDefault();
                        $("#search_file_id").val($(this).attr("ref"));
                        bonusGroupDatagrid.fnDraw();
                        creditRefundGroupDatagrid.fnDraw();
                        //datagrid.fnDraw();
                    });

                    bonusGroupDatagrid = $("#bonusGroupDatagrid").r9jasonDataTable({
                        // online1DataTable extra params
                        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                        "extraParam" : function(aoData) { // pass extra params to server
                            aoData.push({ "name": "filterUsername", "value": $("#search_upgradeUsername").val()  });
                            aoData.push({ "name": "filterMt4Id", "value": $("#search_mt4").val()  });
                            aoData.push({ "name": "filterReferId", "value": $("#search_file_id").val()  });
                            aoData.push({ "name": "filterFullname", "value": $("#search_fullname").val()  });
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
                        "sAjaxSource": "<?php echo url_for('financeList/mt4BonusGroupList') ?>",
                        "sPaginationType": "full_numbers",
                        "aoColumns": [
                            { "sName" : "dist.distributor_id", "bVisible" : false},
                            { "sName" : "dist.distributor_code",  "bSortable": true},
                            { "sName" : "dist.mt4_user_name",  "bSortable": true},
                            { "sName" : "dist.full_name",  "bSortable": true},
                            { "sName" : "pipsBonus",  "bSortable": true, "fnRender": function ( oObj ) {
                                return "<a id='viewLink' href='#'>" + oObj.aData[4] + "</a>";
                            }},
                            { "sName" : "creditRefund",  "bSortable": true, "fnRender": function ( oObj ) {
                                return "<a id='creditRefundViewLink' href='#'>" + oObj.aData[5] + "</a>";
                            }},
                            { "sName" : "dist.distributor_id",  "bSortable": true},
                            { "sName" : "bonus.month_traded",  "bSortable": true},
                            { "sName" : "bonus.month_traded",  "bSortable": false}
                        ]
                    });

                    /*creditRefundGroupDatagrid = $("#creditRefundGroupDatagrid").r9jasonDataTable({
                        // online1DataTable extra params
                        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                        "extraParam" : function(aoData) { // pass extra params to server
                            aoData.push({ "name": "filterUsername", "value": $("#search_upgradeUsername2").val()  });
                            aoData.push({ "name": "filterMt4Id", "value": $("#search_mt42").val()  });
                            aoData.push({ "name": "filterReferId", "value": $("#search_file_id").val()  });
                        },
                        "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                            reassignDatagridEventAttrForCreditRefund();
                        },

                        // datatables params
                        "bLengthChange": true,
                        "bFilter": false,
                        "bProcessing": true,
                        "bServerSide": true,
                        "bAutoWidth": false,
                        "sAjaxSource": "<?php //echo url_for('financeList/creditRefundGroupList') ?>",
                        "sPaginationType": "full_numbers",
                        "aoColumns": [
                            { "sName" : "dist.distributor_id", "bVisible" : false},
                            { "sName" : "dist.distributor_code",  "bSortable": true, "fnRender": function ( oObj ) {
                                return "<a id='creditRefundViewLink'>" + oObj.aData[1] + "</a>";
                            }},
                            { "sName" : "dist.mt4_user_name",  "bSortable": true},
                            { "sName" : "bonusAmount",  "bSortable": true},
                            { "sName" : "bonus.month_traded",  "bSortable": true}
                        ]
                    });*/

                    datagrid = $("#datagrid").r9jasonDataTable({
                                // online1DataTable extra params
                                "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                                "extraParam" : function(aoData) { // pass extra params to server
                                    //aoData.push({ "name": "filterUsername", "value": $("#search_upgradeUsername").val()  });
                                    //aoData.push({ "name": "filterMt4Id", "value": $("#search_mt4").val()  });
                                    //aoData.push({ "name": "filterStatusCode", "value": ""  });
                                    aoData.push({ "name": "filterDistId", "value": $("#dgDistId").val()  });
                                    aoData.push({ "name": "filterReferId", "value": $("#search_file_id").val()  });
                                    aoData.push({ "name": "filterCommissionType", "value": $("#dgBonusType").val()  });
                                },
                                "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                                },

                                // datatables params
                                "bLengthChange": true,
                                "bFilter": false,
                                "bProcessing": true,
                                "bServerSide": true,
                                "bAutoWidth": false,
                                "sAjaxSource": "<?php echo url_for('financeList/pipsBonusList') ?>",
                                "sPaginationType": "full_numbers",
                                "aoColumns": [
                                    { "sName" : "bonus.commission_id", "bVisible" : false},
                                    { "sName" : "dist.distributor_code",  "bSortable": true},
                                    { "sName" : "dist.mt4_user_name",  "bSortable": true},
                                    { "sName" : "bonus.commission_type",  "bSortable": true},
                                    { "sName" : "bonus.credit",  "bSortable": true},
                                    { "sName" : "bonus.remark",  "bVisible": false},
                                    { "sName" : "bonus.remark",  "bSortable": false},
                                    { "sName" : "bonus.month_traded",  "bSortable": true}
                                ]
                            });

                    $("#dgBonusPanel").dialog("destroy");
                    $("#dgBonusPanel").theoneDialog({
                        width:800,
                        height:500,
                        open: function() {
                        },
                        close: function() {

                        },
                        buttons: {
                            Close: function() {
                                $(this).dialog('close');
                            }
                        }
                    });

                    /*$("#bonusTabs").tabs().find(".ui-tabs-nav");*/
                }); // end $(function())

                function reassignDatagridEventAttr(){
                    $("a[id=viewLink]").click(function(event){
                        // stop event
                        event.preventDefault();

                        // event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
                        //var id = alert("id = " +$(event.target).parent().parent().attr("id"));
                        var id = $(event.target).parent().parent().attr("id");
                        $("#dgDistId").val(id);
                        $("#dgBonusType").val('<?php echo Globals::COMMISSION_TYPE_PIPS_BONUS ?>');
                        datagrid.fnDraw();
                        $("#dgBonusPanel").dialog("open");
                    });

                    $("a[id=creditRefundViewLink]").click(function(event){
                        // stop event
                        event.preventDefault();

                        // event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
                        //var id = alert("id = " +$(event.target).parent().parent().attr("id"));
                        var id = $(event.target).parent().parent().attr("id");
                        $("#dgDistId").val(id);
                        $("#dgBonusType").val('<?php echo Globals::COMMISSION_TYPE_CREDIT_REFUND ?>');
                        datagrid.fnDraw();
                        $("#dgBonusPanel").dialog("open");
                    });
                }
                function reassignDatagridEventAttrForCreditRefund(){
                    $("a[id=creditRefundViewLink]").click(function(event){
                        // stop event
                        event.preventDefault();

                        // event.target is <a> itself, parent() is <td>, while parent().parent() get <tr>
                        //var id = alert("id = " +$(event.target).parent().parent().attr("id"));
                        var id = $(event.target).parent().parent().attr("id");
                        $("#dgDistId").val(id);
                        $("#dgBonusType").val('<?php echo Globals::COMMISSION_TYPE_CREDIT_REFUND ?>');
                        datagrid.fnDraw();
                        $("#dgBonusPanel").dialog("open");
                    });
                }
            </script>
            <br>
            <!--<div id="bonusTabs">
            <ul>
                <li><a href="#tabs-pipsBonus"><?php /*echo __('Pips Bonus') */?></a></li>
                <li><a href="#tabs-creditRefund"><?php /*echo __('Credit Refund') */?></a></li>
            </ul>-->
            <div id="tabs-pipsBonus">
                <input type="hidden" id="search_file_id" value="<?php echo $refId;?>">
                <table class="display" id="bonusGroupDatagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id [hidden]</th>
                        <th>e-Trader</th>
                        <th>MT4</th>
                        <th>Full Name</th>
                        <th>Pips Bonus</th>
                        <th>Credit Refund</th>
                        <th>Total</th>
                        <th>Month</th>
                        <th>Leader</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input title="" size="10" type="text" id="search_upgradeUsername" value="" class="search_init"/></td>
                        <td><input title="" size="10" type="text" id="search_mt4" value="" class="search_init"/></td>
                        <td><input title="" size="10" type="text" id="search_fullname" value="" class="search_init"/></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                </table>
            </div>
            <!--<div id="tabs-creditRefund">
                <table class="display" id="creditRefundGroupDatagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id [hidden]</th>
                        <th>e-Trader</th>
                        <th>MT4</th>
                        <th>Amount</th>
                        <th>Month</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input title="" size="10" type="text" id="search_upgradeUsername2" value="" class="search_init"/></td>
                        <td><input title="" size="10" type="text" id="search_mt42" value="" class="search_init"/></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                </table>
            </div>
            </div>-->
        </div>
    </div>
</div>

<div id="dgBonusPanel" style="display:none; width: 850px" title="Bonus Information Detail">
    <input type="hidden" id="dgDistId" value="1">
    <input type="hidden" id="dgBonusType" value="<?php echo Globals::COMMISSION_TYPE_PIPS_BONUS ?>">
    <table class="display" id="datagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>id [hidden]</th>
            <th>e-Trader</th>
            <th>MT4</th>
            <th>Commission Type</th>
            <th>Amount</th>
            <th>Remarks</th>
            <th>Description</th>
            <th>Month</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
    </table>
</div>
</form>