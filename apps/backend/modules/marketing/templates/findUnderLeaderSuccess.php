<?php
use_helper('I18N');
?>

<?php echo form_tag('admin/doLogin', 'id=loginForm') ?>

<script type="text/javascript">
var walletDatagrid = null;
$(function() {
    /*$('#debitAccountAmount').autoNumeric({
        mDec: 2
    });*/

    $("#optMember").change(function(event){
        waiting();
        $.ajax({
        	type : 'POST',
            url : "<?php echo url_for("/marketing/doFindUnderLeader"); ?>",
            dataType : 'json',
            cache: false,
            data: {
            	distId : $('#optMember').val()
            },
            success : function(data) {
                $.unblockUI();
                $("#leader").val(data.result);
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Your login attempt was not successful. Please try again.");
            }
        });
    });
});
</script>

<input type="hidden" id="distId" value="0">
<div style="padding: 10px; top: 30px; position: absolute; width: 1000px">
    <div class="portlet">
        <div class="portlet-header"><?php echo __('Find Leader') ?></div>
        <div class="portlet-content">
            <div id="divPIPS">
                <table class="display" id="datagridByMonth" border="0" width="100%">

                    <tr>
                        <td class="caption">Member ID</td>
                        <td class="value">
                            <select id="optMember">
                                <option></option>
                                <?php
                                    foreach ($dists as $dist) {
                                ?>
                                    <option value="<?php echo $dist->getDistributorId();?>"><?php echo $dist->getDistributorCode()."-".$dist->getFullname();?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="caption" style="width: 25%">Leader</td>
                        <td class="value">
                            <input type="text" name="leader" id="leader" value="" size="20">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

</form>