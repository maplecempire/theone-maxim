<?php include('scripts.php'); ?>

<script type="text/javascript">
$(function() {
    $(".fundManagementLink").click(function(event){
        event.preventDefault();
        var location = $(this).attr("href");

        window.open(location);
    });
});
</script>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Fund Management Report') ?></span></td>
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
                <td>
                    <!--<a id='imgGroup' href='/images/chart/mte1.png'>
                        <img src="/images/chart/mte1.png" style="width:600px">
                    </a>-->
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <a class='fundManagementLink' href="<?php echo url_for("/download/downloadFundManagementReport?p=Nov_2013") ?>"><span><?php echo __('Click to DOWNLOAD Fund Management Report Nov 2013') ?></span></a>
                </td>
            </tr>

            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>