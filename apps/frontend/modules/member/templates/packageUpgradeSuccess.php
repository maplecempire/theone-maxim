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

<div class="aside">
    <?php //include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <!--<div class="sidenavi">
        <ul>
            <li><a href="/member/viewProfile"><span><?php /*echo __('Account Information'); */?></span></a></li>
            <li><a href="/member/viewBankInformation"><span><?php /*echo __('Bank Account Information'); */?></span></a></li>
            <li><a href="/member/loginPassword"><span><?php /*echo __('Change Password'); */?></span></a></li>
            <li><a href="/member/transactionPassword"><span><?php /*echo __('Change Security Password'); */?></span></a></li>
        </ul>
    </div>-->

    <?php //include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="resultsWrap">
        <form action="/member/packageUpgrade" id="topupForm" name="topupForm" method="post">
            <input type="hidden" id="topup_ecash">
            <input type="hidden" id="topup_pointAvail"/>

            <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                    align="center">
                <caption><?php echo __('Package Upgrade') ?></caption>
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
                                <td class="caption"><label><?php echo __('Package Upgrade To') ?></label></td>
                                <td class="value">
                                    <input type="hidden" name="packageTypeSelected" id="packageTypeSelected">
                                    <select name="topup_packageType" id="topup_packageType">

                                    </select>
                                    <input type="text" disabled="disabled" id="topup_packageType_pointNeeded"size="10px"/>
                                </td>
                            </tr>
                            <tr style="display: none;">
                                <td class="caption"><label><?php echo __('Payment Type') ?></label></td>
                                <td class="value">
                                    <span id="topupPackageTypeSpanPaymentType">
                                        <input type="radio" id="topupPackageTypePaymentTypeEPoint" name="topupPackageTypePaymentType" value="epoint"/><label for="topupPackageTypePaymentTypeEPoint"><?php echo __('Forex Point') ?></label>
                                        <input type="radio" id="topupPackageTypePaymentTypeECash" name="topupPackageTypePaymentType" value="ecash"/><label for="topupPackageTypePaymentTypeECash"><?php echo __('MT4 Credit') ?></label>
                                    </span>
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
                                    &nbsp;
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

        <div class="portlet">
            <div class="portlet-header"><?php echo __('Package Upgrade History') ?></div>
            <div class="portlet-content">

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
            </div>
        </div>
    </div>
</div>
