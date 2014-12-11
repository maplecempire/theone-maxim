<?php include('scripts.php'); ?>

<script type="text/javascript">
    $(function() {
        $("#transferForm").validate({
            messages : {
                transactionPassword: {
                    remote: "<?php echo __("Security Password is not valid")?>"
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
                form.submit();
            }
        });

        $("#sponsorId").change(function() {
            if ($.trim($('#sponsorId').val()) != "") {
                verifySponsorId();
            }
        });
    });


    function verifySponsorId() {
        waiting();
        $.ajax({
            type : 'POST',
		    url : "/member/verifySameStructure",
            dataType : 'json',
            cache: false,
            data: {
                sponsorId : $('#sponsorId').val(),
                distId : $('#distId').val()
            },
            success : function(data) {
                if (data == null || data == "") {
                    if (confirm("<?php echo __('Invalid User Name or Invalid Tree Structure. Proceed with caution. Continue?')?>")) {
                        $.unblockUI();
                    } else {
                        $('#sponsorId').val("");
                        $('#sponsorId').focus();
                    }
                } else {
                    $.unblockUI();
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                error("Your login attempt was not successful. Please try again.");
            }
        });
    }
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Change Referrer ID') ?></span></td>
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
            <form action="<?php echo url_for("/member/changeSponsorB")?>" id="transferForm" name="transferForm" method="post">
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
                    <th colspan="2"><?php echo __('Change Referrer ID') ?>.</th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Direct Downline'); ?></td>
                    <td>
                        <select name="distId" id="distId" tabindex="1">
                            <?php
                                if (count($distDDs) >= 1) {
                                    foreach ($distDDs as $distDD) {
                                        echo "<option value='".$distDD->getDistributorId()."'>".$distDD->getDistributorCode()."</option>";
                                    }
                                } else {
                                    echo "<option value=''>--</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('New Referrer ID'); ?></td>
                    <td>
                        <input name="sponsorId" type="text" id="sponsorId" tabindex="2"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password'); ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword" tabindex="3"/>
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
        </td>
    </tr>
    </tbody>
</table>