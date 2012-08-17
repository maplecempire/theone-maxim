<?php include('scripts.php'); ?>
<script type="text/javascript" language="javascript">
$(function() {
    $("#passwordForm").validate({
        messages : {
            newPassword2: {
                equalTo: "Please enter the same password as above"
            }
        },
        rules : {
            "oldPassword" : {
                required : true,
                minlength : 3
            },
            "newPassword" : {
                required : true,
                minlength : 3
            },
            "newPassword2" : {
                required : true,
                minlength : 3,
                equalTo: "#newPassword"
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        }
    });
    $("#btnUpdate").button({
        icons: {
            primary: "ui-icon-disk"
        }
    });
});
</script>

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <div class="sidenavi">
        <ul>
            <li><a href="/member/viewProfile"><span><?php echo __('Account Information'); ?></span></a></li>
            <li><a href="/member/viewBankInformation"><span><?php echo __('Bank Account Information'); ?></span></a></li>
            <li><a href="/member/loginPassword"><span><?php echo __('Change Password'); ?></span></a></li>
            <li><a href="/member/transactionPassword"><span><?php echo __('Change Security Password'); ?></span></a></li>
        </ul>
    </div>

    <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<form action="/member/transactionPassword" id="passwordForm" method="post">
<div class="areaContent">
    <div class="resultsWrap">
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist">
            <caption><?php echo __('Change Security Password') ?></caption>
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
                        <td class="caption">
                            <strong><?php echo __('Old Security Password'); ?></strong>
                        </td>
                        <td class="value">
                            <input name="oldPassword" type="password" id="oldPassword" tabindex="1" />
                        </td>
                    </tr>
                    <tr>
                        <td class="caption">
                            <strong><?php echo __('New Security Password'); ?></strong>
                        </td>
                        <td class="value">
                            <input name="newPassword" type="password" id="newPassword" tabindex="2" />
                        </td>
                    </tr>
                    <tr>
                        <td class="caption">
                            <strong><?php echo __('Re-enter Security Password'); ?></strong>
                        </td>
                        <td class="value">
                            <input name="newPassword2" type="password" id="newPassword2" tabindex="3" />
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td colspan=2 align='center'>
                    <button id="btnUpdate"><?php echo __('Change Security Password') ?></button>
<!--                    <input type="submit" name="Button1" value="--><?php //echo __('Change Transaction Password') ?><!--" language="javascript" id="btnPassword" tabindex="4"/>-->
                </td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>
</div>

</form>