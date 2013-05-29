<?php include('scripts.php'); ?>
<script type="text/javascript">
    var packageStrings = "<option value=''></option>";
    var datagrid = null;
    var datagridDetail = null;
    var pipsDatagrid = null;
    var datagridFundManagementReturn = null;
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
            if ($(this).attr("ref") == "<?php echo Globals::COMMISSION_TYPE_CREDIT_REFUND?>") {
                $("#divBonusType").show(500);
                $("#divPip").show(500);
                $("#divDRB").hide(500);
                $("#divFundManagementReturn").hide(500);
                $(".tdPipsBonus").hide();
                $(".tdCreditRefund").show();
                $(".tdFundDividend").hide();
                $(".tdRbBonus").hide();
                $(".tdPairingBonus").hide();
                $(".tdSpecialBonus").hide();
                pipsDatagrid.fnDraw();
            }
        });
        $("#divBonusType").data("BONUS_TYPE", "DRB");
    });
    function reassigndatagridDetailEventAttr() {

    }
</script>

<form action="/member/bonusDetails" id="bonusForm" method="post">
    <input type="hidden" id="filterAction" value="DRB">

    <table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Pips Rebate Detail') ?></span></td>
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

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <br>
                        <div id="divBonusType" style="display: inline;">
                            <table class="display" id="datagridByMonth" border="0" width="100%">
                                <thead>
                                <tr>
                                    <th style="text-align: center;"><?php echo __('Date') ?></th>
                                    <th style="text-align: center;" class='tdCreditRefund'><?php echo __('Pips Rebate') ?></th>
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
                                            <td align='right' class='tdCreditRefund'>".number_format($arr["credit_refund"], 2)."</td>
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
                                    //console.log($("#divBonusType").data("BONUS_TYPE"));

                                    pipsDatagrid.fnDraw();
                                });

                                pipsDatagrid = $("#pipsDatagrid").r9jasonDataTable({
                                    // online1DataTable extra params
                                    "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                                    "extraParam" : function(aoData) { // pass extra params to server
                                        aoData.push({ "name": "filterMonth", "value": $("#search_month").val()  });
                                        aoData.push({ "name": "filterYear", "value": $("#search_year").val()  });
                                        aoData.push({ "name": "filterBonusType", "value": "CREDIT_REFUND"  });
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
                        <div id="divPip" style="display: inline;">
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

                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

</form>