<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
$(function() {
    $("#topupPackageTypePaymentTypeEPoint").attr('checked', true);
    $("#topupPackageTypeSpanPaymentType").buttonset();

    $("#topup_packageType").change(function() {
        $("#topup_packageType_pointNeeded").val($("#topup_packageType").val());
        $("#packageTypeSelected").val($('#topup_packageType option:selected').attr("ref"));
    });
    $("#topupForm").validate({
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
            if ($("#topup_packageType_pointNeeded").val() == 0 || $("#topup_packageType_pointNeeded").val() == "") {
                error("In-sufficient fund to upgrade package.");
                $("#topup_packageType").focus().select();
            } else if ($("#topupPackageTypePaymentTypeEPoint").is(':checked') == true && parseFloat($("#topup_packageType").val()) > parseFloat($("#topup_pointAvail").val())){
                alert("In-sufficient Forex point. " + $("#topup_pointAvail").val());
                $("#topup_packageType").focus().select();
            } else if ($("#topupPackageTypePaymentTypeECash").is(':checked') == true && parseFloat($("#topup_packageType").val()) > parseFloat($("#topup_ecash").val())){
                alert("In-sufficient MT4 Credit. " + $("#topup_ecash").val());
                $("#topup_packageType").focus().select();
            } else {
                if ($.trim($("#transactionPassword").val()) == "") {
                    error("Security Password is empty");
                    $("#transactionPassword").focus();
                    return false;
                }
                waiting();
                form.submit();
            }
        }
    });

    $.ajax({
        type : 'POST',
        url : "/member/fetchTopupPackage",
        dataType : 'json',
        cache: false,
        data: {
        },
        success : function(data) {
            $.unblockUI();
            packageStrings = "";
            jQuery.each(data.package, function(key, value) {
                packageStrings += "<option value='" + value.price + "' ref='" + value.packageId + "'>" + value.name + "</option>";
            });

            $("#topup_packageType").html(packageStrings).trigger("change");

            $("#topup_pointAvail").val(data.point);
            $("#topup_ecash").val(data.ecash);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Server connection error.");
        }
    });
});
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Package Upgrade') ?></span></td>
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
            <form action="/member/packageUpgrade" id="topupForm" name="topupForm" method="post">
            <input type="hidden" id="topup_ecash">
            <input type="hidden" id="topup_pointAvail"/>
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
                    <th colspan="2"><?php echo __('Package Upgrade') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Package Upgrade To') ?></td>
                    <td>
                        <input type="hidden" name="packageTypeSelected" id="packageTypeSelected">
                        <select name="topup_packageType" id="topup_packageType">

                        </select>
                        <input type="text" disabled="disabled" id="topup_packageType_pointNeeded"size="10px"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <!--<tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Payment Type'); */?></td>
                    <td>
                        <input type="radio" id="topupPackageTypePaymentTypeEPoint" name="topupPackageTypePaymentType" value="epoint"/><label for="topupPackageTypePaymentTypeEPoint"><?php /*echo __('Forex Point') */?></label>
                        <input type="radio" id="topupPackageTypePaymentTypeECash" name="topupPackageTypePaymentType" value="ecash"/><label for="topupPackageTypePaymentTypeECash"><?php /*echo __('MT4 Credit') */?></label>
                    </td>
                    <td>&nbsp;</td>
                </tr>-->

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password'); ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"
                                           tabindex="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnTransfer"><?php echo __('Submit') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>

            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

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
                            "sAjaxSource": "/finance/packageUpgradeList",
                            "sPaginationType": "full_numbers",
                            "aaSorting": [
                                [1,'desc']
                            ],
                            "aoColumns": [
                                { "sName" : "dist_id", "bVisible" : false,  "bSortable": true},
                                { "sName" : "created_on",  "bSortable": true},
                                { "sName" : "transaction_code",  "bSortable": true},
                                { "sName" : "amount",  "bSortable": true},
                                { "sName" : "status_code",  "bSortable": true},
                                { "sName" : "remarks",  "bSortable": true}
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
                <th><?php echo __('Package Upgrade History') ?></th>
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
                <th><?php echo __('Date') ?></th>
                <th><?php echo __('Transaction Code') ?></th>
                <th><?php echo __('Amount') ?></th>
                <th><?php echo __('Status') ?></th>
                <th><?php echo __('Remarks') ?></th>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>