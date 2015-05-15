<link rel="stylesheet" type="text/css" href="/js/uploadify-v3.1/uploadify.css" />
<link rel="stylesheet" type="text/css" href="/template/inspinia/font-awesome/css/font-awesome.min.css" />

<script type="text/javascript" src="/js/uploadify-v3.1/jquery.uploadify-3.1.min.js"></script>
<script type="text/javascript">
    var datagrid = null;

    $(function(){
        datagrid = $("#datagrid").r9jasonDataTable({
            // online1DataTable extra params
            "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
            "extraParam" : function(aoData){ // pass extra params to server
//                aoData.push( { "name": "filterFilename", "value": $("#search_filename").val()  } );
            },
            "reassignEvent" : function(){ // extra function for reassignEvent when JSON is back from server
//                reassignDatagridEventAttr();
            },

            // datatables params
            "bLengthChange": true,
            "bFilter": false,
            "bProcessing": true,
            "bServerSide": true,
            "bAutoWidth": false,
            "sScrollX": "100%",
            //"sScrollXInner": "150%",
            "sAjaxSource": "<?php echo url_for('marketingList/uploadMaterialList') ?>",
            "sPaginationType": "full_numbers",
            "aaSorting": [
                [1,'desc']
            ],
            "aoColumns": [
                { "sName" : "a.id", "bVisible" : false},
                { "sName" : "a.created_on",  "bSortable": true},
                { "sName" : "a.file_name",  "bSortable": true},
                { "sName" : "a.file_thumbnail",  "bSortable": true, "fnRender": function(oObj) {
                    var thumbnail = oObj.aData[3];
                    var thumbnailClass = "fa fa-file-o";
                    var thumbnailDesc = "File";

                    if (thumbnail == "txt") {
                        thumbnailClass = "fa fa-file-text-o";
                        thumbnailDesc = "Document";
                    } else if (thumbnail == "img") {
                        thumbnailClass = "fa fa-file-image-o";
                        thumbnailDesc = "Image";
                    } else if (thumbnail == "pdf") {
                        thumbnailClass = "fa fa-file-pdf-o";
                        thumbnailDesc = "ZIP / RAR";
                    } else if (thumbnail == "zip") {
                        thumbnailClass = "fa fa-file-zip-o";
                        thumbnailDesc = "PDF";
                    } else if (thumbnail == "exe") {
                        thumbnailClass = "fa fa-floppy-o";
                        thumbnailDesc = "Software";
                    }

                    return '<i class="' + thumbnailClass + '" style="font-size: 2em;"></i>&nbsp;&nbsp;&nbsp;' + thumbnailDesc;
                }},
                { "sName" : "a.description",  "bSortable": false},
                { "sName" : "a.status_code",  "bSortable": false},
                { "sName" : "a.id",  "bSortable": false, "fnRender": function(oObj) {
                    return '<a href="javascript:void(0);" onclick="deleteFile(this);" ref="' + oObj.aData[0] + '">Delete</a>';
                }}
            ]
        });

        $("#uploadForm").validate({
            messages : {
            },
            rules : {
                "file_name" : {
                    required: true
                },
                "file_upload" : {
                    required: true
                }
            },
            submitHandler: function(form) {
                if (confirm("Confirm upload file?")) {
                    waiting();
                    form.submit();
                }

                return false;
            }
        });

        $("#file_thumbnail").change(function() {
            var selected = $(this).val();
            var preview = $("#thumbnail-preview");

            if (selected == "txt") {
                preview.attr("class", "fa fa-file-text-o");
            } else if (selected == "img") {
                preview.attr("class", "fa fa-file-image-o");
            } else if (selected == "pdf") {
                preview.attr("class", "fa fa-file-pdf-o");
            } else if (selected == "zip") {
                preview.attr("class", "fa fa-file-zip-o");
            } else if (selected == "exe") {
                preview.attr("class", "fa fa-floppy-o");
            } else {
                preview.attr("class", "fa fa-file-o");
            }

        });
    }); // end $(function())

    function deleteFile(obj) {
        if (confirm("Confirm delete selected file?")) {
            waiting();

            $.ajax({
                type : 'POST',
                url : "<?php echo url_for("/marketing/uploadMaterial") ?>",
                dataType : 'json',
                cache: false,
                data: {
                    act : "delete",
                    ref : $(obj).attr("ref")
                },
                success : function(data) {
                    if (data == null || data == "") {
                        error("Unable to delete file. Please try again later.");
                    } else {
                        alert(data);
                    }

                    datagrid.fnDraw();
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    error("Your login attempt was not successful. Please try again.");
                }
            });
        }
    }

</script>

<form id="uploadForm" method="post" action="<?php echo url_for("/marketing/uploadMaterial")?>"  enctype="multipart/form-data">
    <div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
        <div class="portlet">
            <div class="portlet-header">Upload Material</div>
            <div class="portlet-content">

                <table width="100%" border="0">
                    <tr>
                        <td colspan="2"><br>
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
                        <th class="caption">File Name</th>
                        <td class="value">
                            <input type="text" id="file_name" name="file_name" size="80">
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">Description</th>
                        <td class="value">
                            <textarea id="description" name="description" rows="3" cols="80"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">Status</th>
                        <td class="value">
                            <select id="status_code" name="status_code">
                                <option value="<?php echo Globals::STATUS_ACTIVE ?>"><?php echo Globals::STATUS_ACTIVE ?></option>
                                <option value="<?php echo Globals::STATUS_INACTIVE ?>"><?php echo Globals::STATUS_INACTIVE ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">Thumbnail</th>
                        <td class="value">
                            <select id="file_thumbnail" name="file_thumbnail">
                                <option value="">File</option>
                                <option value="txt">Document</option>
                                <option value="img">Image</option>
                                <option value="zip">ZIP / RAR</option>
                                <option value="pdf">PDF</option>
                                <option value="exe">Software</option>
                            </select>
                            <br><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<i id="thumbnail-preview" class="fa fa-file-o" style="font-size: 4em;"></i>
                            <br><br>
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">File</th>
                        <td class="value">
                            <?php echo input_file_tag('file_upload', array("id" => "file_upload", "name" => "file_upload")); ?>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button id="btnUpload">Upload</button>
                        </td>
                    </tr>
                </table>

                <br>
                <hr>

                <table width="100%">
                    <tr>
                        <td>
                            <div style="width: 1050px">
                                <h3>Uploaded Materials</h3>
                                <table class="display" id="datagrid" border="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>[id]</th>
                                        <th>Uploaded Date</th>
                                        <th>File Name</th>
                                        <th>Thumbnail</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</form>