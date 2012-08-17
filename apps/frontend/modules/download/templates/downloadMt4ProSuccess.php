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

    });
</script>

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="resultsWrap">
        <?php echo form_tag('member/downloadMt4Pro', array("enctype" => "multipart/form-data", "id" => "transferForm")) ?>
        <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist">
            <caption><?php echo __('Download Mt4 Pro') ?></caption>
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
                    <table class="pbt_table">
                        <tbody>
                        <tr>
                            <td rowspan="3"><img src="/images/mt4_ps.jpg"></td>
                            <td>Meta Trader 4 (MT4) is one of the best Forex trading platforms in the world with its
                                advanced charting package and user-friendly interface, MT4 is ideal for traders whatever
                                your experience.
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="/download/mt4Pro">Click to DOWNLOAD Meta Trader 4 Pro</a>
                                <br>
                                <a href="/download/mt4ProUserGuide">Click to DOWNLOAD Meta Trader 4 Pro User Guide</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        </form>
        <div class="clear"></div>
    </div>
</div>