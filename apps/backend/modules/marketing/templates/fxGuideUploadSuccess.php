<link rel="stylesheet" type="text/css" href="/js/uploadify-v3.1/uploadify.css" />

<script type="text/javascript" src="/js/uploadify-v3.1/jquery.uploadify-3.1.min.js"></script>
<script type="text/javascript">
var jform = null;

$(function(){
    $('#file_upload_defxm2u').uploadify({
        'swf'      : '/js/uploadify-v3.1/uploadify.swf',
        'uploader' : '<?php echo url_for("/marketing/uploadify") ?>'
    });
    /*$('#file_upload_fxmarket2you').uploadify({
        'swf'      : '/js/uploadify-v3.1/uploadify.swf',
        'uploader' : "http://app.fxmarket2you.com/download/uploadify"
    });
    $('#file_upload_ofxglobal').uploadify({
        'swf'      : '/js/uploadify-v3.1/uploadify.swf',
        'uploader' : 'http://app.ofxltd.com/download/uploadify'
    });*/
}); // end $(function())

</script>

<?php echo form_tag('marketing/uploadify', 'id=uploadForm') ?>
<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
<div class="portlet">
    <div class="portlet-header">Fx Guide Upload</div>
    <div class="portlet-content">
	<table width="100%" border="0">
		<tr>
            <th class="caption">defxm2u.com</th>
			<td class="value">
                <input type="file" name="file_upload" id="file_upload_defxm2u" />
			</td>
		</tr>
		<tr>
            <th class="caption">fxmarket2you.com</th>
			<td class="value">
                <iframe name="fxmarket2youframe" src="http://app.fxmarket2you.com/download" frameborder="0" scrolling="auto" width="500" height="100" marginwidth="5" marginheight="5" ></iframe>
<!--                <input type="file" name="file_upload" id="file_upload_fxmarket2you" />-->
			</td>
		</tr>
		<tr>
            <th class="caption">ofxltd.com</th>
			<td class="value">
                <iframe name="ofxglobalframe" src="http://app.ofxltd.com/download" frameborder="0" scrolling="auto" width="500" height="100" marginwidth="5" marginheight="5" ></iframe>
<!--                <input type="file" name="file_upload" id="file_upload_ofxglobal" />-->
			</td>
		</tr>
	</table>
    </div>
</div>
</div>

</form>