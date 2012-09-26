<?php include('scripts_backend.php'); date_default_timezone_set('America/New_York'); ?>
<script type="text/javascript">
var jform = null;
$("#btnUpload").click(function(){
    waiting();

});

function waiting() {
    /*$("#waitingLB h3").html("<h3>Loading...</h3><div id='loader' class='loader'><img id='img-loader' src='/images/loading.gif' alt='Loading'/></div>");*/
    $("#waitingLB h3").html("<h3 style='width: 100%; padding-left: 0px; background-color:inherit; color: black; line-height:0px; margin-top: 20px;'>Loading...</h3><div id='loader' class='loader'><img id='img-loader' src='/images/loading.gif' alt='Loading'/></div>");

    $.blockUI({
                message: $("#waitingLB")
                , css: {
                    border: 'none',
                    padding: '5px',
                    'background-color': '#fff',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    'border-radius': '10px',
                    opacity: .8,
                    color: '#000'
                }});
    $(".blockOverlay").css("z-index", 1010);
    $(".blockPage").css("z-index", 1011);
}
</script>

<form id="uploadForm" method="post" action="/download/doUploadJapaneseGuide" enctype="multipart/form-data">
<div id="waitingLB" style="display:none; cursor: default">
    <h3 style="width: 100%; padding-left: 0px; background-color:inherit; color: black; line-height:0px; margin-top: 0px">We are processing your request. Please be patient.</h3>
</div>
<table width="100%" border="0">
    <tr>
        <td class="value">
            <?php echo input_file_tag('fxguide', array("id" => "fxguide", "name" => "fxguide")); ?>
        </td>
    </tr>
    <tr>
        <td class="value" id="tdValue">
            <button id="btnUpload">Upload</button>&nbsp;<?php if ($sf_flash->has('successMsg')): ?><font color="#dc143c"><?php echo $sf_flash->get('successMsg') ?></font><?php endif; ?>
        </td>
    </tr>
</table>
</form>