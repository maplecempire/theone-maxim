<?php include('scripts.php'); ?>
<script type="text/javascript">
    var packageStrings = "<option value=''></option>";
    var datagrid = null;
    var datagridDetail = null;
    var pipsDatagrid = null;
    $(function() {
        datagridDetail = $("#datagridDetail").r9jasonDataTable({
            // online1DataTable extra params
            "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
            "extraParam" : function(aoData) { // pass extra params to server
                //aoData.push({ "name": "filterAction", "value": $("#filterAction").val() });
                aoData.push({ "name": "filterMonth", "value": $("#search_month").val()  });
                aoData.push({ "name": "filterYear", "value": $("#search_year").val()  });
                aoData.push({ "name": "filterBonusType", "value": $("#divBonusType").data("BONUS_TYPE")  });
            },
            "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                reassigndatagridDetailEventAttr();
            },
            // datatables params
            "bLengthChange": true,
            "bFilter": false,
            "bProcessing": true,
            "bServerSide": true,
            "bAutoWidth": false,
            "sAjaxSource": "/member/bonusDetailList",
            "sPaginationType": "full_numbers",
            "aaSorting": [
                [1,'desc']
            ],
            "aoColumns": [
                { "sName" : "commission_id",  "bVisible": false},
                { "sName" : "created_on",  "bSortable": true},
                { "sName" : "commission_type",  "bSortable": true, "bVisible" : true, "fnRender": function ( oObj ) {
                    if (oObj.aData[2] == "DRB") {
                        return "RB";
                    }
                    return oObj.aData[2];
                }},
                { "sName" : "credit",  "bSortable": true},
                { "sName" : "debit",  "bSortable": true},
                { "sName" : "remark",  "bSortable": false},
                { "sName" : "remark",  "bVisible": false}
            ]
        });

        $(".activeLink").click(function(event) {
            event.preventDefault();
            //$("#filterAction").val($(this).attr("ref"));

            /*if ($(this).attr("ref") == "BY_MONTH") {
                $("#divDRB").hide(500);
                $("#divBonusType").show(500);
            } else {
                $("#divDRB").show(500);
                $("#divBonusType").hide(500);
            }*/

            $("#divBonusType").data("BONUS_TYPE", $(this).attr("ref"));
            if ($(this).attr("ref") == "<?php echo Globals::COMMISSION_TYPE_PIPS_BONUS?>") {
                $("#divBonusType").show(500);
                $("#divPip").show(500);
                $("#divDRB").hide(500);
                $(".tdPipsBonus").show();
                $(".tdCreditRefund").hide();
                $(".tdRbBonus").hide();
                pipsDatagrid.fnDraw();
            } else if ($(this).attr("ref") == "<?php echo Globals::COMMISSION_TYPE_CREDIT_REFUND?>") {
                $("#divBonusType").show(500);
                $("#divPip").show(500);
                $("#divDRB").hide(500);
                $(".tdPipsBonus").hide();
                $(".tdCreditRefund").show();
                $(".tdRbBonus").hide();
                pipsDatagrid.fnDraw();
            } else {
                $("#divBonusType").show(500);
                $("#divPip").hide(500);
                $("#divDRB").show(500);
                $(".tdPipsBonus").hide();
                $(".tdCreditRefund").hide();
                $(".tdRbBonus").show();
                datagridDetail.fnDraw();
            }
        });
        $("#divBonusType").data("BONUS_TYPE", "DRB");
    });
    function reassigndatagridDetailEventAttr() {

    }
</script>

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <div class="sidenavi">
        <ul>
            <li><a href="/member/bonusDetails"><span><?php echo __('Bonus Details'); ?></span></a></li>

        </ul>
    </div>

    <?php //include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<form action="/member/bonusDetails" id="bonusForm" method="post">
    <input type="hidden" id="filterAction" value="DRB">
<div class="areaContent">
    <div class="resultsWrap">
    <div class="portlet">
        <div class="portlet-header"><?php echo __('Bonus Categories') ?></div>
        <div class="portlet-content">

            <table class="display" id="datagrid" border="0" width="100%">
                <thead>
                <tr align="center">
                    <th><?php echo __('Bonus') ?></th>
                    <th style="text-align: right;"><?php echo __('Amount') ?></th>
                    <th style="text-align: center;"><?php echo __('View Details') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php

                echo "<tr class='odd'>
                <td>" . __('RB') . "</td>
                <td align='right'>" . $dsb . "</td>
                <td align='center'>" . link_to(__('Details'), '#', array(
                                                                        'class' => 'activeLink',
                                                                        'ref' => 'DRB'
                                                                   )) . "</td></tr>";

                echo "<tr class='even'>
                <td>" . __('PIPS') . "</td>
                <td align='right'>" . $pipsBonus . "</td>
                <td align='center'>" . link_to(__('Details'), '#', array(
                                                                        'class' => 'activeLink',
                                                                        'ref' => Globals::COMMISSION_TYPE_PIPS_BONUS
                                                                   ))
                     . "</td></tr>";

                echo "<tr class='odd'>
                <td>" . __('CREDIT REFUND') . "</td>
                <td align='right'>" . $creditRefund . "</td>
                <td align='center'>" . link_to(__('Details'), '#', array(
                                                                        'class' => 'activeLink',
                                                                        'ref' => Globals::COMMISSION_TYPE_CREDIT_REFUND
                                                                   ))
                     . "</td></tr>";

                echo "<tr class='even'>
                <td><strong>" . __('Total') . "</strong></td>
                <td align='right'><strong>" . $total . "</strong></td><td></td></tr>";
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="portlet">
        <div class="portlet-header"><?php echo __('Bonus Details') ?></div>
        <div class="portlet-content">
            <div id="divBonusType" style="display: inline;">
                <table class="display" id="datagridByMonth" border="0" width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: center;"><?php echo __('Date') ?></th>
                        <th style="text-align: right; width: 100px; display: none" class='tdPipsBonus'><?php echo __('Pips Bonus') ?></th>
                        <th style="text-align: right; width: 100px; display: none" class='tdCreditRefund'><?php echo __('Credit Refund') ?></th>
                        <th style="text-align: right; width: 100px;" class='tdRbBonus'><?php echo __('RB Bonus') ?></th>
                    </tr>
                    </thead>
                    <tbody>
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

                        $showYear = "";
                        $showMonth = "";
                        foreach ($anode as $arr) {
                            echo "<tr class='odd'>
                                <td align='center'><a href='#' refMonth='".$arr["month"]."' refYear='".$arr["year"]."' class='monthLink'>" . $arr["year"] . "-" . __($month[$arr["month"]]) ."</a></td>
                                <td align='right' class='tdPipsBonus' style='display: none'>".number_format($arr["pips_bonus"], 2)."</td>
                                <td align='right' class='tdCreditRefund' style='display: none'>".number_format($arr["credit_refund"], 2)."</td>
                                <td align='right' class='tdRbBonus'>".number_format($arr["rb_bonus"], 2)."</td>
                                </tr>";

                            $showYear = $arr["year"];
                            $showMonth = $arr["month"];
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <br>
            <script type="text/javascript">
                $(function() {
                    $(".monthLink").click(function(event){
                        event.preventDefault();
                        $("#search_month").val($(this).attr("refMonth"));
                        $("#search_year").val($(this).attr("refYear"));

                        if ($("#divBonusType").data("BONUS_TYPE") == "DRB")  {
                            datagridDetail.fnDraw();
                        } else {
                            pipsDatagrid.fnDraw();
                        }
                    });

                    pipsDatagrid = $("#pipsDatagrid").r9jasonDataTable({
                        // online1DataTable extra params
                        "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                        "extraParam" : function(aoData) { // pass extra params to server
                            aoData.push({ "name": "filterMonth", "value": $("#search_month").val()  });
                            aoData.push({ "name": "filterYear", "value": $("#search_year").val()  });
                            /*aoData.push({ "name": "filterBonusType", "value": $("#divBonusType").data("BONUS_TYPE")  });*/
                        },
                        "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                        },

                        // datatables params
                        "bLengthChange": true,
                        "bFilter": false,
                        "bProcessing": true,
                        "bServerSide": true,
                        "bAutoWidth": false,
                        "sAjaxSource": "<?php echo url_for('finance/pipsBonusList') ?>",
                        "sPaginationType": "full_numbers",
                        "aoColumns": [
                            { "sName" : "bonus.commission_id", "bVisible" : false},
                            { "sName" : "bonus.month_traded",  "bSortable": true},
                            { "sName" : "bonus.remark",  "bSortable": false},
                            { "sName" : "bonus.credit",  "bSortable": true}
                        ]
                    });
                }); // end $(function())

            </script>
            <div id="divPip" style="display: none;">
                <input type="hidden" id="search_month" value="<?php echo $showMonth;?>">
                <input type="hidden" id="search_year" value="<?php echo $showYear;?>">
                <table class="display" id="pipsDatagrid" border="0" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id [hidden]</th>
                        <th>Month</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                </table>
            </div>
            <div id="divDRB">
                <table class="display" id="datagridDetail" border="0" width="100%">
                    <thead>
                    <tr>
                        <th>Detail Id[hidden]</th>
                        <th><?php echo __('Date') ?></th>
                        <th><?php echo __('Commission Type') ?></th>
                        <th><?php echo __('Credit') ?></th>
                        <th><?php echo __('Debit') ?></th>
                        <th><?php echo __('Remark') ?></th>
                        <th><?php echo __('MT4 Status') ?></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    </div>
</div>

</form>