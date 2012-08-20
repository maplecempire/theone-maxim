<?php include('scripts.php'); ?>
<style type="text/css">
td.caption {
    background: none repeat scroll 0 0 #D9D9D9;
    border: 1px solid #FFFFFF;
    padding: 5px;
    width: 150px;
}
td.value {
    background: none repeat scroll 0 0 #E9E9E9;
    border: 1px solid #FFFFFF;
    padding: 5px;
}
</style>
<script type="text/javascript">
$(function() {
    $("#transferForm").validate({
        messages : {
            transactionPassword: {
                remote: "Security Password is not valid."
            }
        },
        rules : {
            "bankSlip" : {
                required : true
                , accept:true
            },
            "epointAmount" : {
                required : true
            },
            "transactionPassword" : {
                required : true,
                remote: "/member/verifyTransactionPassword"
            }
        },
        submitHandler: function(form) {
            waiting();
            var amount = $('#epointAmount').autoNumericGet();
            $("#epointAmount").val(amount);
            form.submit();
        }
    });
    $('#epointAmount').autoNumeric({
        mDec: 2
    });

    $("#dgBankReceipt").dialog("destroy");
    $("#dgBankReceipt").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        width: 700,
        height: 550,
        buttons: {
            "<?php echo __('Print') ?>": function() {
                var params  = 'width=891';
                params += ', height=637';
                params += ', top=0, left=0';

                newwin = window.open("<?php echo url_for("/member/printBankInformation?q=1231j32lkhljkewrw&p=")."/";?>" + $("#purchaseId").val(),'Bank Information', params);
                if (window.focus)
                {
                    newwin.focus();
                }
            }
            /*, "<?php //echo __('Submit') ?>": function() {
                $("#uploadForm").submit();
            }*/
        },
        open: function() {
        },
        close: function() {

        }
    });

    <?php if ($sf_flash->has('successMsg')): ?>
        $("#dgBankReceipt").dialog("open");
    <?php endif; ?>
});
</script>

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <?php //include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="resultsWrap">
        <?php echo form_tag('member/epointPurchase', array("enctype" => "multipart/form-data", "id" => "transferForm")) ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist">
            <caption><?php echo __('e-Point Purchase') ?></caption>
            <tr>
                <td colspan=2 align='center'>
                    <?php if ($sf_flash->has('banksuccessMsg')): ?>
                    <div class="ui-widget">
                        <div style="margin-top: 20px; padding: 0 .7em;"
                             class="ui-state-highlight ui-corner-all">
                            <p><span style="float: left; margin-right: .3em;"
                                     class="ui-icon ui-icon-info"></span>
                                <strong><?php echo $sf_flash->get('banksuccessMsg') ?></strong></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($sf_flash->has('errorMsg')): ?>
                    <div class="ui-widget">
                        <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-error ui-corner-all">
                            <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
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
                            <td width="160px" class="caption">
                                <strong><?php echo __('Trader ID'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="traderId" type="text" id="traderId" maxlength="50" disabled="disabled"
                                       value="<?php echo $distDB->getDistributorCode(); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="caption">
                                <strong><?php echo __('Trader Name'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="traderName" type="text" id="traderName" maxlength="50" disabled="disabled"
                                       value="<?php echo $distDB->getFullname(); ?>"/>
                            </td>
                        </tr>
                        <!--<tr>
                            <td class="caption">
                                <strong><?php /*echo __('Registered Time'); */?></strong>
                            </td>
                            <td class="value">
                                <input name="registeredTime" type="text" id="registeredTime" maxlength="50"
                                       disabled="disabled" value="<?php /*echo $distDB->getCreatedOn(); */?>"/>
                            </td>
                        </tr>-->
                        <tr>
                            <td class="caption">
                                <strong><?php echo __('Total e-Point'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="epointAmount" id="epointAmount"/>
                            </td>
                        </tr>
                        <!--<tr>
                            <td class="caption">
                                <strong><?php /*echo __('Upload Bank Transfer Slip'); */?></strong>
                            </td>
                            <td class="value">
                                <?php /*echo input_file_tag('fileNew', array("id" => "bankSlip", "name" => "bankSlip")) */?>
                            </td>
                        </tr>-->
                        <tr>
                            <td class="caption">
                                <strong><?php echo __('Security Password'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="transactionPassword" type="password" id="transactionPassword"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" align="right" valign="top"><font color="#dc143c">NOTE :</font>
                            </td>
                            <td colspan="1" align="left"><font color="#dc143c">e-Point is for package purchase, package upgrade and reload mt4 fund use only.
                                <br>e-Point is non-withdrawable.
                                <br><?php echo $systemCurrency?> 1 : 1 e-Point.&nbsp;</font>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan='3' align='center'>
                    <input type="submit" name="Button1" value="<?php echo __('Submit') ?>" language="javascript"
                           id="btnTransfer" tabindex="5"/>
                </td>
            </tr>
        </table>
        </form>
        <div class="clear"></div>

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
                    "sAjaxSource": "/finance/epointPurchaseHistoryList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [1,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "purchase_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "created_on",  "bSortable": true},
                        { "sName" : "amount",  "bSortable": true},
                        { "sName" : "payment_reference",  "bSortable": true},
                        { "sName" : "status_code",  "bSortable": true},
                        { "sName" : "remarks",  "bSortable": true},
                        { "sName" : "image_src",  "bSortable": false, "fnRender": function ( oObj ) {
                            $("#dgBankReceipt").data("data_" + oObj.aData[0], {
                                purchase_id : oObj.aData[0]
                                , created_on : oObj.aData[1]
                                , amount : oObj.aData[2]
                                , payment_reference : oObj.aData[3]
                                , status_code : oObj.aData[4]
                                , remarks : oObj.aData[5]
                                , image_src : oObj.aData[6]
                            });
                            return "<img src='" + oObj.aData[6] + "' style='display:none'><a class='detailLink' ref='" + oObj.aData[0] + "' href='#'>Detail</a>";
                        }}
                    ]
                });

                $(".detailLink").live("click", function(event) {
                    event.preventDefault();
                    var data = $("#dgBankReceipt").data("data_" + $(this).attr("ref"));
                    $("#depositAmountSpan").html(data.amount);
                    $("#paymentReferenceSpan").html(data.payment_reference);
                    $("#purchaseId").val(data.purchase_id);
                    $("#fancyImageLink").attr("href", data.image_src);
                    $("#fancyImageImg").attr("src", data.image_src);
                    $("#dgBankReceipt").dialog("open");
                });

                $("#uploadForm").validate({
                    messages : {
                        transactionPassword: {
                            remote: "Security Password is not valid."
                        }
                    },
                    rules : {
                        "bankSlip" : {
                            required : true
                            , accept:true
                        },
                        "transactionPassword" : {
                            required : true,
                            remote: "/member/verifyTransactionPassword"
                        }
                    },
                    submitHandler: function(form) {
                        waiting();
                        form.submit();
                    }
                });

                $("a[rel=image_group]").fancybox({
                    'transitionIn' : 'elastic',
                    'transitionOut' : 'none'
                });

                $("#btnUpload").button({
                    icons: {
                        primary: "ui-icon-circle-arrow-n"
                    }
                });
            }); // end function

            function reassignDatagridEventAttr() {
            }
        </script>

        <div class="portlet">
            <div class="portlet-header"><?php echo __('e-Point Purchase History') ?></div>
            <div class="portlet-content" style="min-height: 300px">

                <table class="display" id="datagrid" border="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?php echo __('Date') ?></th>
                        <th><?php echo __('e-Point purchase') ?></th>
                        <th><?php echo __('Reference No') ?></th>
                        <th><?php echo __('Status') ?></th>
                        <th><?php echo __('Remarks') ?></th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="dgBankReceipt" title="<?php echo __('Bank Information Detail') ?>" style="display:none;">
    <?php echo form_tag('member/uploadBankReceipt', array("enctype" => "multipart/form-data", "id" => "uploadForm")) ?>
    <input type="hidden" id="purchaseId" name="purchaseId" value="<?php echo $sf_flash->get('purchaseId'); ?>">
    <table cellspacing="0" cellpadding="0" width="650px" style="margin:0 auto">
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Deposit Amount'); ?></strong>
            </td>
            <td class="value" style="color: red">
                <?php echo $systemCurrency." "; ?>
                <span id="depositAmountSpan">
                    <?php echo $sf_flash->get('amount'); ?>
                </span>
            </td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Trading Currency on MT4'); ?></strong>
            </td>
            <td class="value"><?php echo $tradingCurrencyOnMT4; ?></td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Bank Name'); ?></strong>
            </td>
            <td class="value"><?php echo $bankName; ?></td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Bank Swift Code'); ?></strong>
            </td>
            <td class="value"><?php echo $bankSwiftCode; ?></td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Bank Account Holder'); ?></strong>
            </td>
            <td class="value"><?php echo $bankAccountHolder; ?></td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Bank Account Number'); ?></strong>
            </td>
            <td class="value"><?php echo $bankAccountNumber; ?></td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('City of Bank'); ?></strong>
            </td>
            <td class="value"><?php echo $cityOfBank; ?></td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Country of Bank'); ?></strong>
            </td>
            <td class="value"><?php echo $countryOfBank; ?></td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Payment Reference'); ?></strong>
            </td>
            <td class="value"><span id="paymentReferenceSpan" style="color: red"><?php echo $sf_flash->get('paymentReference'); ?></span>
            <br><br>Note: you must present this Payment Reference when making payment to the bank. THis PAYMENT
                REFERENCE NUMBER must be placed in the section where it says NO. KERETA / CAR NO.
                whenever it is applicable.
            </td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Upload Bank Receipt'); ?></strong>
            </td>
            <td class="value">
                <?php echo "<a id='fancyImageLink' rel='image_group' href=''>"; ?>
                    <img id='fancyImageImg' onerror="this.src='/images/common/not_available.gif';"
                     src="empty"
                     height="50">
                </a>
                <?php echo input_file_tag('fileNew', array("id" => "bankSlip", "name" => "bankSlip")); ?>
                <button id="btnUpload">Upload Bank Receipt</button>
            </td>
        </tr>
        <tr>
            <td class="caption">
                <strong><?php echo __('Security Password'); ?></strong>
            </td>
            <td class="value">
                <input name="transactionPassword" type="password"/>
            </td>
        </tr>
    </table>
    </form>
    <p>
    <?php echo $sf_flash->get('successMsg') ?>
</div>