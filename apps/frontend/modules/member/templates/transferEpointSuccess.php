<?php include('scripts.php'); ?>

<script type="text/javascript">
    $(function() {
        $("#transferForm").validate({
            messages : {
                transactionPassword: {
                    remote: "Security Password is not valid."
                }
            },
            rules : {
                "sponsorId" : {
                    required: true
                    //, minlength : 8
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
                var epointBalance = $('#epointBalance').autoNumericGet();
                console.log(amount);
                console.log(epointBalance);
                if (parseFloat(epointBalance) < (parseFloat(amount) + parseFloat($("#processFee").val()))) {
                    alert("<?php echo __("In-sufficient E-Point")?>");
                    return false;
                }

                $("#epointAmount").val(amount);
                form.submit();
            }
        });

        $("#sponsorId").change(function() {
            if ($.trim($('#sponsorId').val()) != "") {
                verifySponsorId();
            }
        });

        $('#epointAmount').autoNumeric({
            mDec: 2
        });
    });

    function verifySponsorId() {
        waiting();
        $.ajax({
            type : 'POST',
            url : "/member/verifySponsorId",
            dataType : 'json',
            cache: false,
            data: {
                sponsorId : $('#sponsorId').val()
            },
            success : function(data) {
                if (data == null || data == "") {
                    alert("Invalid sponsor ID");
                    $('#sponsorId').focus();
                    $("#sponsorName").html("");
                } else {
                    $.unblockUI();
                    $("#sponsorName").html(data.nickname);
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Your login attempt was not successful. Please try again.");
            }
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

<form action="/member/transferEpoint" id="transferForm" name="transferForm" method="post">
<input type="hidden" id="processFee" value="<?php echo $processFee?>">
<div class="areaContent">
    <div class="resultsWrap">
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist">
            <caption><?php echo __('e-Point Transfer') ?></caption>
            <tr>
                <td colspan=2 align='center'>
                    <?php if ($sf_flash->has('successMsg')): ?>
                    <div class="ui-widget">
                        <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-highlight ui-corner-all">
                            <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
                                <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
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
                                <strong><?php echo __('Transfer To Trader ID'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="sponsorId" type="text" id="sponsorId" tabindex="1"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="caption">
                                <strong><?php echo __('Trader Name'); ?></strong>
                            </td>
                            <td class="value">
                                <strong><span id="sponsorName"></span></strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="caption">
                                <strong><?php echo __('e-Point Balance'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="epointBalance" id="epointBalance" tabindex="2" disabled="disabled"
                                       value="<?php echo number_format($ledgerAccountBalance, 2); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="caption">
                                <strong><?php echo __('Transfer e-Point Amount'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="epointAmount" id="epointAmount" tabindex="3"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="caption">
                                <strong><?php echo __('Security Password'); ?></strong>
                            </td>
                            <td class="value">
                                <input name="transactionPassword" type="password" id="transactionPassword"
                                       tabindex="4"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan=3><font color="#dc143c"> <?php
                            if ($processFee != 0)
                    echo __('every transfer action need to pay USD%1%.00 processing fees', array('%1%' => $processFee));
                    ?></font></td>
            </tr>
            <tr>
                <td colspan='3' align='center'>
                    <button><?php echo __('Submit') ?></button>
                </td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>
</div>

</form>
