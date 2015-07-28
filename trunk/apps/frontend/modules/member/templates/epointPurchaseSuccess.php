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
                remote: "<?php echo __("Security Password is not valid")?>"
            }
        },
        rules : {
            /*"bankSlip" : {
                required : true,
                accept:'docx?|pdf|bmp|jpg|jpeg|gif|png|tif|tiff|xls|xlsx'
            },*/
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
            var paymentMethod = $('#paymentMethod').val();
            if (paymentMethod == "PG" && amount > 50000) {
                error("<?php echo __('Maximum Payment RMB 50,000 per transaction') ?>");
                return false;
            } else if (paymentMethod == "PaP" && amount > 200000) {
                error("<?php echo __('Maximum Payment RMB 200,000 per transaction') ?>");
                return false;
            }
            $("#epointAmount").val(amount);
            form.submit();
        }
    });
    $('#epointAmount').autoNumeric({
        mDec: 2
    });

    $('#paymentMethod').change(function(){
        var paymentMethod = $(this).val();
        if (paymentMethod == "GOZ") {
            $("#tr_channelid").show();
            $("#li_note").hide();
            $("#currencyCode").val("RMB");
        } else if (paymentMethod == "PG") {
            $("#tr_channelid").hide();
            $("#li_note").show();
            $("#currencyCode").val("RMB");
        }  else if (paymentMethod == "PaP") {
            $("#tr_channelid").hide();
            $("#li_note").hide();
            $("#currencyCode").val("RMB");
        } else {
            $("#tr_channelid").hide();
            $("#li_note").hide();
            $("#currencyCode").val("USD");
        }
    }).trigger("change");

    $("#dgBankReceipt").dialog("destroy");
    $("#dgBankReceipt").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        width: 700,
        height: 580,
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

    <?php if ($sf_flash->has('successMsg') && $pg == "N") { ?>
        $("#dgBankReceipt").dialog("open");
    <?php } ?>
});
</script>

<div class="ewallet_li">
	<a target="_self" class="navcontainer" href="<?php echo url_for("/member/transferEpoint")?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP1 Transfer'); ?>
    </a>
    &nbsp;&nbsp;

    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
	<a target="_self" class="navcontainer" href="<?php echo url_for("/member/transferCp2")?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP2 Transfer'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
	<a target="_self" class="navcontainer" href="<?php echo url_for("/member/transferCp3")?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP3 Transfer'); ?>
    </a>

    &nbsp;&nbsp;

    <?php
    if ($toHideCp2Cp3Transfer == false) {
    ?>
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/convertEcashToEpoint") ?>" style="color: rgb(0, 93, 154);">
        <?php echo __('Convert CP2 To CP1'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;

    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/convertCp3ToCp1")?>" style="color: rgb(0, 93, 154);">
        <?php echo __('Convert CP3 To CP1'); ?>
    </a>
    <?php } ?>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;

    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/epointPurchase")?>" style="color: rgb(134, 197, 51);">
        <?php echo __('Funds Deposit'); ?>
    </a>
</div>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Funds Deposit') ?></span></td>
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
            <?php echo form_tag('member/epointPurchase', array("enctype" => "multipart/form-data", "id" => "transferForm")) ?>
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
                    <th colspan="2"><?php echo __('Funds Deposit') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Member ID'); ?></td>
                    <td>
                        <input name="traderId" type="text" id="traderId" maxlength="50" disabled="disabled"
                                       value="<?php echo $distDB->getDistributorCode(); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Member Name') ?></td>
                    <td>
                        <input name="traderName" type="text" id="traderName" maxlength="50" disabled="disabled"
                                       value="<?php echo $distDB->getFullname(); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Currency Code'); ?></td>
                    <td>
                        <input name="currencyCode" id="currencyCode" readonly="readonly"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Total Fund Deposited'); ?></td>
                    <td>
                        <input name="epointAmount" id="epointAmount"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Payment Method'); ?></td>
                    <td>
                        <?php
                        $disabled = "";
                        $disabledPaP = "";
                        $disabledIps = "";
                        if ($distDB->getDistributorId() == 1 || $distDB->getDistributorId() == 2 || $distDB->getDistributorId() == 161 || $distDB->getDistributorId() == 595
                            || $distDB->getDistributorId() == 682 || $distDB->getDistributorId() == 255670 || $distDB->getDistributorId() == 317571 || $distDB->getDistributorId() == 317572 || $distDB->getDistributorId() == 259794) {

                        } else {
                            $disabled = "disabled='disabled'";
                        }
                        if ($distDB->getDistributorId() == 1 || $distDB->getDistributorId() == 2 || $distDB->getDistributorId() == 135 || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 135 || $distDB->getDistributorId() == 273302 || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 256205) {

                        } else {
                            $disabledPaP = "disabled='disabled'";
                        }
                        if ($distDB->getDistributorId() == 1 || $distDB->getDistributorId() == 2 || $distDB->getDistributorId() == 286347) {

                        } else {
                            $disabledIps = "disabled='disabled'";
                        }
                        $disabledIps = "";
                        $disabledPaP = "";
                        ?>
                        <select name="paymentMethod" id="paymentMethod">
                            <option value="LB"><?php echo __("Bank Transfer");?></option>
<!--                            <option value="PG" --><?php //echo $disabledIps;?><!-->--><?php //echo __("IPS"); ?><!-- 环迅支付</option>-->
                            <option value="GOZ" <?php echo $disabled;?>><?php echo __("Online Payment Gateway");?></option>
<!--                            <option value="PaP" --><?php //echo $disabledPaP;?><!-->--><?php //echo __("Payment Asia");?><!--</option>-->
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even" id="tr_channelid" style="display: none;">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank'); ?></td>
                    <td>
                        <select name="channelid" id="channelid">
                            <option value="ABC">中国农业银行</option>
                            <option value="CCB">中国建设银行</option>
                            <option value="CIB">兴业银行</option>
                            <option value="CMB">招商银行</option>
                            <option value="CMBC">民生银行</option>
                            <option value="HXB">华夏银行</option>
                            <option value="ICBC">中国工商银行</option>
                            <option value="BOCSH">中国银行</option>
                            <option value="COMM">交通银行</option>
                            <option value="SPDB">浦发银行</option>
                            <option value="GDB">广发银行</option>
                            <option value="SDB">深圳发展银行</option>
                            <option value="POSTGC">中国邮政储蓄</option>
                            <option value="SHRCB">上海农村商业银行</option>
                            <option value="BOB">北京银行</option>
                            <option value="GZCB">广州商业银行</option>
                            <option value="CEB">光大银行</option>
                            <option value="BOWZ">温州银行</option>
                            <option value="CNCB">中信银行</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password'); ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td colspan="2" valign="top">
                                     &nbsp;
                                    <font color="#dc143c"> <?php echo __('NOTE :') ?></font>
                                    <br>
                                    <ol style="color: #dc143c; padding-left: 20px;">
                                        <li><?php echo __('Funds Deposited will be credited into CP1 Account.') ?></li>
                                        <li><?php echo __('CP1 is ONLY for package purchase, package upgrade, MT4 account reload and is NON-WITHDRAWABLE.') ?></li>
                                        <li><?php echo $systemCurrency?> <?php echo __('1 equals to 1 value of CP1'); ?>.&nbsp;</li>
                                        <li><?php echo __('Payment via credit card is subject to an extra 5% charge') ?></li>
                                        <li id="li_note"><?php echo __('Maximum Payment RMB 50,000 per transaction') ?></li>
                                    </ol>
                                </td>
                            </tr>
                        </table>
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
                                , bank_id : oObj.aData[7]
                            });
                            return "<img src='" + oObj.aData[6] + "' style='display:none'><a class='detailLink' ref='" + oObj.aData[0] + "' href='#'><?php echo __("Details"); ?></a>";
                        }},
                        { "sName" : "bank_id", "bVisible" : false,  "bSortable": true}
                    ]
                });

                $(".detailLink").live("click", function(event) {
                    event.preventDefault();
                    var data = $("#dgBankReceipt").data("data_" + $(this).attr("ref"));
                    $("#depositAmountSpan").html(data.amount);
                    $("#paymentReferenceSpan").html(data.payment_reference);
                    $("#purchaseId").val(data.purchase_id);
                    if (data.image_src != "") {
                        $(".fancyImageLink").show();
<!--                        $("#fancyImageLink").attr("href", "--><?php //echo url_for("/download/bankslip?q=".rand()) ?><!--" + "/p/" + data.purchase_id);-->
                        $("#fancyImageLink").attr("href", data.image_src);
                    } else {
                        $(".fancyImageLink").hide();
                    }
                    $("#fancyImageImg").attr("src", data.image_src);

                    $("#bankId").val(data.bank_id).change();

                    $("#dgBankReceipt").dialog("open");
                });

                $("#uploadForm").validate({
                    messages : {
                        transactionPassword: {
                            remote: "<?php echo __("Security Password is not valid")?>"
                        }
                    },
                    rules : {
                        "bankSlip" : {
                            required : true
                            , accept:'docx?|pdf|bmp|jpg|jpeg|gif|png|tif|tiff|xls|xlsx'
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

                $("#bankId").live("change", function() {
                    $("#bankSwiftCodeText").html($("#bankId option:selected").attr("bankSwiftCodeText"));
                    $("#ibanText").html($("#bankId option:selected").attr("ibanText"));
                    $("#bankAccountHolderText").html($("#bankId option:selected").attr("bankAccountHolderText"));
                    $("#bankAccountNumberText").html($("#bankId option:selected").attr("bankAccountNumberText"));
                    $("#cityOfBankText").html($("#bankId option:selected").attr("cityOfBankText"));
                    $("#countryOfBankText").html($("#bankId option:selected").attr("countryOfBankText"));
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
                <th><?php echo __('Funds Deposit History') ?></th>
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
                <th><?php echo __('Funds Deposit') ?></th>
                <th><?php echo __('Reference No') ?></th>
                <th><?php echo __('Status') ?></th>
                <th><?php echo __('Remarks') ?></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>

<div id="dgBankReceipt" title="<?php echo __('Bank Information Detail') ?>" style="display:none;">
    <?php echo form_tag('member/uploadBankReceipt', array("enctype" => "multipart/form-data", "id" => "uploadForm")) ?>
    <input type="hidden" id="purchaseId" name="purchaseId" value="<?php echo $sf_flash->get('purchaseId'); ?>">

    <?php echo $sf_flash->get('successMsg') ?>
    <p>
    <table cellspacing="0" cellpadding="0" width="650px" style="margin:0 auto">
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Deposit Amount'); ?></strong>
            </td>
            <td class="value" style="color: red">
                <?php //echo $systemCurrency." "; ?>
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
            <td colspan="2">
                 <table border="0" cellspacing="0" width="99%"
               style="border-collapse:collapse;border:1px solid rgb(0,0,0);font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgb(51,51,51);line-height:15px">
            <tbody>
            <tr>
                <th colspan="2"
                    style="color:rgb(0,0,0);background-color:rgb(221,221,221);padding:3px 7px;border:1px solid rgb(170,170,170)">
                    Czech Republic (USD)
                </th>
            </tr>
            <tr>
                <td width="30%" style="padding:3px 7px;border:1px solid rgb(170,170,170)">Bank:</td>
                <td width="69%" style="padding:3px 7px;border:1px solid rgb(170,170,170)">CESKA SPORITELNA A.S.</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Address:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">PRAGUE 62, OLBRACHTOVA 14000, Czech Republic</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Account No:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">CZ77 0800 0000 0000 0635 2242</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Account Name:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Global Transaction Services (HK) Limited
                </td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Account Holder Address:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Room 2705 Richmond Commercial Building 109
                    Argyle Street Mongkok, Kowloon, 0000, Hong Kong
                </td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">IBAN:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">CZ77 0800 0000 0000 0635 2242</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">SWIFT BIC:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">GIBACZPX</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Please Remark:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">9120028849</td>
            </tr>
            <tr style="display: none;">
                <td colspan="2" style="padding:3px 7px;border:1px solid rgb(170,170,170)"><span
                        style="font-style:italic;color:rgb(255,0,0)">Your Reference (9120028849) should be entered first in the narrative of the sending bank's payment instructions, before any other references.<span
                        class="HOEnZb"><font color="#888888"><br><br></font></span></span></td>
            </tr>
            </tbody>
        </table>
            </td>
        </tr>
        <tr>
            <td width="160px" class="caption">
                <strong><?php echo __('Upload Bank Receipt'); ?></strong>
            </td>
            <td class="value">
                <?php /*echo "<a id='fancyImageLink' rel='image_group' href=''>"; */?><!--
                    <img id='fancyImageImg' onerror="this.src='/images/common/not_available.gif';"
                     src="empty"
                     height="50">
                </a>-->

                <a href="#" id="fancyImageLink" class="fancyImageLink" target="_blank">
                    <img src="/images/common/fileopen.png" alt="view file" class="fancyImageLink">
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
</div>