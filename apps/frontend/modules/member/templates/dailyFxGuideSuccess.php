<?php include('scripts.php'); ?>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __("Download Daily FX Guide") ?></span></td>
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
        <table class="pbt_table">
            <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url_for("/download/downloadGuide?a=CN&q=" . rand()) ?>"><span><?php echo __("Click to DOWNLOAD Daily Fx Guide (Chinese)") ?></span></a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url_for("/download/downloadGuide?a=EN&q=" . rand()) ?>"><span><?php echo __("Click to DOWNLOAD Daily Fx Guide (English)") ?></span></a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url_for("/download/downloadGuide?a=JP&q=" . rand()) ?>"><span><?php echo __("Click to DOWNLOAD Daily Fx Guide (Japanese)") ?></span></a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo url_for("/download/downloadGuide?a=KR&q=" . rand()) ?>"><span><?php echo __("Click to DOWNLOAD Daily Fx Guide (Korean)") ?></span></a>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>