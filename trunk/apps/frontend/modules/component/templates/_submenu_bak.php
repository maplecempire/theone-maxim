<style type="text/css">
.checkboxError {
    background: #ff6;
    border: 1px dotted red;
    outline: thin solid red;
}
.menu li {
    float: left;
    line-height: 20px;
    list-style: none outside none;
    width: 200px;
    padding-left: 20px;
}
.menu_title {
    color: #CCAD5A;
    padding-left: 0px !important;
}
</style>
<script type="text/javascript">
$(function() {
    $("#submenuPaymentTypeEPoint").attr('checked', true);
    $("#submenuSpanPaymentType").buttonset();

    $("#dgPackagePurchase_point").change(function() {
        $("#dgPackagePurchase_pointNeeded").val($("#dgPackagePurchase_point").val());
    });

    $("#dgTermCondition").dialog("destroy");
    $("#dgTermCondition").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        closeOnEscape: false,
        hide: 'clip',
        show: 'slide',
        width: 650,
        buttons: {
            "<?php echo __('Submit') ?>": function() {
                var error = false;
                $(".checkboxError").removeClass("checkboxError");

                //console.log($("#terms_cust_agreement").is(':checked'));
                if ($("#terms_cust_agreement").is(':checked') == false) {
                    $("#terms_cust_agreement").addClass("checkboxError");
                    error = true;
                }
                if ($("#terms_bis").is(':checked') == false) {
                    $("#terms_bis").addClass("checkboxError");
                    error = true;
                }
                if ($("#terms_risk").is(':checked') == false) {
                    $("#terms_risk").addClass("checkboxError");
                    error = true;
                }
                if ($("#terms_aml").is(':checked') == false) {
                    $("#terms_aml").addClass("checkboxError");
                    error = true;
                }
                if ($("#term_condition").is(':checked') == false) {
                    $("#term_condition").addClass("checkboxError");
                    error = true;
                }

                if (error == false) {
                    waiting();
                    $("#submitTermCondition").submit();
                }
            }
        },
        open: function(event, ui) {
            $(".ui-dialog-titlebar-close").hide();
        },
        close: function() {

        }
    });

    $("#dgPackagePurchase").dialog("destroy");
    $("#dgPackagePurchase").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        hide: 'clip',
        show: 'slide',
        width: 400,
        buttons: {
            "<?php echo __('Cancel') ?>": function() {
                $(this).dialog('close');
            },
            "<?php echo __('Submit') ?>": function() {
                if ($("#dgPackagePurchase_pointNeeded").val() == 0 || $("#dgPackagePurchase_pointNeeded").val() == "") {
                    error("In-sufficient fund to purchase package.");
                    $("#dgPackagePurchase_point").focus().select();
                } else if ($("#paymentTypeEPoint").is(':checked') == true && parseFloat($("#dgPackagePurchase_point").val()) > parseFloat($("#dgPackagePurchase_pointAvail").val())) {
                    alert("In-sufficient Forex point. " + $("#dgPackagePurchase_pointAvail").val());
                    $("#dgPackagePurchase_point").focus().select();
                } else if ($("#paymentTypeECash").is(':checked') == true && parseFloat($("#dgPackagePurchase_point").val()) > parseFloat($("#dgPackagePurchase_ecash").val())) {
                    alert("In-sufficient MT4 Credit. " + $("#dgPackagePurchase_ecash").val());
                    $("#dgPackagePurchase_point").focus().select();
                } else {
                    if ($.trim($("#dgPackagePurchase_transactionPassword").val()) == "") {
                        error("Security Password is empty");
                        $("#dgPackagePurchase_transactionPassword").focus();
                        return false;
                    }
                    waiting();
                    $.ajax({
                        type : 'POST',
                        url : "/member/activateMember",
                        dataType : 'json',
                        cache: false,
                        data: {
                            packageId : $('#dgPackagePurchase_point option:selected').attr("ref")
                            , transactionPassword : $('#dgPackagePurchase_transactionPassword').val()
//                            , sponsorId : $('#distributorId').val()
                            , paymentType : "epoint"
//                            , paymentType : $("input[name='submenuPaymentType']:checked").val()
                        },
                        success : function(data) {
                            if (data.error == false) {
                                window.location = "<?php echo url_for('/member/summary') ?>";
                                $.unblockUI();
                            } else {
                                error(data.errorMsg);
                                $("#dgPackagePurchase_transactionPassword").focus().select();
                            }
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            error("Server connection error.");
                        }
                    });
                }
            }
        },
        open: function() {

        },
        close: function() {

        }
    });

    $("#linkPackagePurchase").click(function(event) {
        event.preventDefault();
        waiting();
<!--        $("#distributorId").val('--><?php //echo $distDB->getDistributorId(); ?><!--');-->
        $("#dgPackagePurchase_shareholderId").val("<?php echo $distDB->getDistributorCode(); ?>");
        $("#dgPackagePurchase_alias").val("<?php echo $distDB->getFullname(); ?>");
        $("#dgPackagePurchase_registeredTime").val('<?php echo $distDB->getCreatedOn(); ?>');
        $.ajax({
            type : 'POST',
            url : "/member/fetchPackage",
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

                $("#dgPackagePurchase").dialog("open");

                $("#dgPackagePurchase_point").html(packageStrings).trigger("change");

                $("#dgPackagePurchase_pointAvail").val(data.point);
                $("#dgPackagePurchase_ecash").val(data.ecash);
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Server connection error.");
            }
        });
    });

    <?php
    if ($openTermCondition == true) {
        echo "$('#dgTermCondition').dialog('open');";
    }
    ?>
});
</script>

<div class="menu">
    <ul>
        <li class="menu_title">Home</li>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/summary"><?php echo __('Summary'); ?></a></li>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_PENDING) { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="#" id="linkPackagePurchase">Package Purchase</a></li>
        <?php } ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/epointPurchase">Forex Point Purchase</a></li>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/packageUpgrade">Package Upgrade</a></li>
        <?php } ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/epointLog"><?php echo __('Forex Point Log'); ?></a></li>
        <?php } ?>
    </ul>
    <ul>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/reloadTopup">Reload MT4 Fund</a></li>
        <?php } ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/mt4Withdrawal">MT4 Withdrawal</a></li>
        <?php } ?>
    </ul>
    <ul>
        <li class="menu_title">Profile</li>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/viewProfile"><span><?php echo __('Account Information'); ?></span></a></li>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/viewBankInformation"><span><?php echo __('Bank Account Information'); ?></span></a></li>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/loginPassword"><span><?php echo __('Change Password'); ?></span></a></li>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/transactionPassword"><span><?php echo __('Change Security Password'); ?></span></a></li>
    </ul>
    <ul>
        <li class="menu_title">Hierarchy</li>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/sponsorTree"><span><?php echo __('Genealogy'); ?></span></a></li>
    </ul>
    <ul>
        <li class="menu_title">Bonus</li>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="/member/bonusDetails"><span><?php echo __('Bonus Details'); ?></span></a></li>
    </ul>
    <ul>
        <li class="menu_title">Download</li>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="<?php echo url_for("/member/downloadMt4?q=" . rand()) ?>">Download MT4 Platform</a></li>
        <?php } ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="<?php echo url_for("/download/downloadGuide?q=" . rand()) ?>">Download Daily FX Guide</a></li>
        <?php } ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorCode() != "demo123") { ?>
        <li><img src="/images/maxim/arrow_blue_single_tab.gif">
            <a href="<?php echo url_for("/download/downloadMt4Pro") ?>"><?php echo __('Download MT4 Pro'); ?></a></li>
        <?php } ?>
    </ul>
</div>
<div id="dgPackagePurchase" title="<?php echo __('Activate Trader') ?>" style="display:none;">
    <input type="hidden" id="dgPackagePurchase_ecash">
    <input type="hidden" id="dgPackagePurchase_pointAvail"/>
    <table cellspacing="5" cellpadding="3">
        <tr>
            <td class="text" width="30%"><label><?php echo __('Trader ID') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgPackagePurchase_shareholderId"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Full Name') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgPackagePurchase_alias"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Registered Time') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgPackagePurchase_registeredTime"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Package Type') ?></label></td>
            <td>:</td>
            <td>
                <select name="dgPackagePurchase_point" id="dgPackagePurchase_point"
                        class='text ui-widget-content ui-corner-all'>

                </select>
                <input type="text" disabled="disabled" id="dgPackagePurchase_pointNeeded"
                       class="text ui-widget-content ui-corner-all" size="10px"/>
            </td>
        </tr>
        <tr style="display: none;">
            <td class="text"><label><?php echo __('Payment Type') ?></label></td>
            <td>:</td>
            <td>
                <span id="submenuSpanPaymentType">
                    <input type="radio" id="submenuPaymentTypeEPoint" name="submenuPaymentType_bak"
                           value="epoint"/><label for="submenuPaymentTypeEPoint"><?php echo __('Forex Point') ?></label>
                    <input type="radio" id="submenuPaymentTypeECash" name="submenuPaymentType_bak" value="ecash"/><label
                        for="submenuPaymentTypeECash"><?php echo __('MT4 Credit') ?></label>
                </span>
            </td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Security Password') ?></label></td>
            <td>:</td>
            <td><input type="password" id="dgPackagePurchase_transactionPassword"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
    </table>
</div>

<div id="dgTermCondition" title="<?php echo __('Term and Condition') ?>" style="display:none;">
    <table>
        <tr align="left" valign="top">
            <td colspan='2' class="td_1st">
                <div class="term_table_list_block">
                    <table cellspacing="0" cellpadding="0">
                        <tr class="">
                            <td colspan="3"><p>Below are the contractural terms and agreements that you are bound by as
                                a client
                                of Maxim Trader. We recommend that you take the time to read each of them carefully.</p>

                                <p><strong>Please check the boxes below to acknowledge your acceptance, argeement and
                                    understanding of these terms and agreements.</strong></p></td>
                        </tr>
                        <tr class='checkbox_bg row0 first'>
                            <td width="367"><input type='checkbox' name='terms_cust_agreement' id='terms_cust_agreement'
                                                   class="checkbox"/>
                                <label for='terms_cust_agreement'>Customer Agreement</label></td>
                            <td width="321"><a href='/download/customerAgreement' style="color: blue"
                                               target='_blank'>Download Agreement (272 KB PDF)</a></td>
                        </tr>
                        <tr class='checkbox_bg row1'>
                            <td width="367"><input type='checkbox' name='terms_bis' id='terms_bis' class="checkbox"/>
                                <label for='terms_bis'>Terms Of Business, Trading Policies & Procedures</label></td>
                            <td width="321"><a href='/download/termsOfBusiness' style="color: blue" target='_blank'>Download
                                Agreement (343 KB PDF)</a></td>
                        </tr>
                        <tr class='checkbox_bg row0'>
                            <td width="367"><input type='checkbox' name='terms_risk' id='terms_risk' class="checkbox"/>
                                <label for='terms_risk'>Risk Disclosure Statement</label></td>
                            <td width="321"><a href='/download/riskDisclosureStatement' style="color: blue"
                                               target='_blank'>Download Agreement (175 KB PDF)</a></td>
                        </tr>
                        <tr class='checkbox_bg row1 last'>
                            <td width="367"><input type='checkbox' name='terms_aml' id='terms_aml' class="checkbox"/>
                                <label for='terms_aml'>AML Policy</label></td>
                            <td width="321"><a href='/download/amlPolicy' style="color: blue"
                                               target='_blank'>Download Agreement (228 KB PDF)</a></td>
                        </tr>
                        <tr class="tr_noborder">
                            <td colspan='2' class="corner-bot"></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">
                <p>I hereby attest and certify that the above information is complete and accurate and I agree to be
                    bound by
                    these terms and conditions. I also authorise <strong>Maxim Trader</strong> to verify any or all of
                    the
                    foregoing information. This electronic signature has the same validity and effect as a signature
                    affixed by
                    hand.</p></td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">
                <input type='checkbox' name='term_condition' id='term_condition' value="1"
                       style="float:left; margin-right:4px;"/>

                <label><p>I understand that as an Maxim Trader customer, it is my responsibility to review all necessary
                    information about currency trading and the Maxim Trader <a href="/download/iBAgreement" style="color: blue" target="_blank">Terms and Conditions</a>. I
                    am aware of the risks associated with foreign exchange trading and will seek advice and further my education
                    on foreign exchange prior to starting any trading activity.</p></label>
            </td>
        </tr>
    </table>
</div>

<form name="submitTermCondition" id="submitTermCondition" action="/member/updateTermCondition">

</form>