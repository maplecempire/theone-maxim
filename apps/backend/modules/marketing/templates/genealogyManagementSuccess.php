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
            url : "<?php echo url_for("/marketing/doCheckGenealogy"); ?>",
            dataType : 'json',
            cache: false,
            data: {
            	distId : $('#optMember').val()
            },
            success : function(data) {
                $.unblockUI();
                $("#hideGenealogy").val(data.result);
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Your login attempt was not successful. Please try again.");
            }
        });
    });

    $("#btnSubmit").button().click(function(event){
        event.preventDefault();

        /*var amount = $('#debitAccountAmount').autoNumericGet();

        if (amount <= 0) {
            alert("Amount must be greater than 0");
            return false;
        }*/

        waiting();
    	$.ajax({
        	type : 'POST',
            url : "<?php echo url_for("/marketing/doUpdateHideGenealogy"); ?>",
            dataType : 'json',
            cache: false,
            data: {
            	distId : $('#optMember').val()
            	, toHideGenealogy : $('#toHideGenealogy').val()
            },
            success : function(data) {
                alert("Update Successful");
                $("#hideGenealogy").val($('#toHideGenealogy').val());
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
        <div class="portlet-header"><?php echo __('Genealogy Management') ?></div>
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
                        <td class="caption" style="width: 25%">Hide Genealogy</td>
                        <td class="value">
                            <input type="text" name="hideGenealogy" id="hideGenealogy" value="0" size="20">
                        </td>
                    </tr>
                    <tr>
                        <td class="caption">To Hide Genealogy</td>
                        <td class="value">
                            <select id="toHideGenealogy" name="toHideGenealogy">
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <button id="btnSubmit"><?php echo __('Submit') ?></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

</form>