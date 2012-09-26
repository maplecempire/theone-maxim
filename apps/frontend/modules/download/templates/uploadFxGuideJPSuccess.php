<?php include('scripts_backend.php'); date_default_timezone_set('America/New_York'); ?>
<script type="text/javascript">
var jform = null;
$("#btnUpload").click(function(){
    waiting();
});
</script>

<form id="uploadForm" method="post" action="/download/doUploadJapaneseGuide" enctype="multipart/form-data">

<table width="100%" border="0">
    <tr>
        <td class="value">
            <?php echo input_file_tag('fxguide', array("id" => "fxguide", "name" => "fxguide")); ?>
        </td>
    </tr>
    <tr>
        <td class="value">
            <button id="btnUpload">Upload</button>&nbsp;<?php if ($sf_flash->has('successMsg')): ?><font color="#dc143c"><?php echo $sf_flash->get('successMsg') ?></font><?php endif; ?>
        </td>
    </tr>
</table>
</form>