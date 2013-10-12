<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    $(function() {
        $("#topupForm").validate({
            messages : {
                transactionPassword: {
                    remote: "Security Password is not valid."
                }
            },
            rules : {
                "transactionPassword" : {
                    required : true
                }
            },
            submitHandler: function(form) {
                waiting();
                form.submit();
            }
        });
    });
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Security Password is required') ?></span></td>
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
            <form action="/member/securityPasswordRequired" id="topupForm" name="topupForm" method="post">
                <input type="hidden" name="doAction" value="<?php echo $doAction?>">
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
                        <th colspan="2"><?php echo __('Please key in your security password') ?></th>
                        <th class="tbl_header_right">
                            <div class="border_right_grey">&nbsp;</div>
                        </th>
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
                        <td></td>
                        <td align="right">
                            <button id="btSubmit"><?php echo __('Submit') ?></button>
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