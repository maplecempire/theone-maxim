<?php include('scripts.php'); ?>

<link rel="stylesheet" type="text/css" href="/template/inspinia/font-awesome/css/font-awesome.min.css" />

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __("Download Materials") ?></span></td>
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
                <?php
                while ($uploadMaterialRS->next()) {
                    $r = $uploadMaterialRS->getRow();

                    $thumbnail = $r["file_thumbnail"];
                    $thumbnailClass = "fa fa-file-o";
                    $thumbnailDesc = "File";

                    if ($thumbnail == "txt") {
                        $thumbnailClass = "fa fa-file-text-o";
                        $thumbnailDesc = "Document";
                    } else if ($thumbnail == "img") {
                        $thumbnailClass = "fa fa-file-image-o";
                        $thumbnailDesc = "Image";
                    } else if ($thumbnail == "pdf") {
                        $thumbnailClass = "fa fa-file-pdf-o";
                        $thumbnailDesc = "ZIP / RAR";
                    } else if ($thumbnail == "zip") {
                        $thumbnailClass = "fa fa-file-zip-o";
                        $thumbnailDesc = "PDF";
                    } else if ($thumbnail == "exe") {
                        $thumbnailClass = "fa fa-floppy-o";
                        $thumbnailDesc = "Software";
                    }
                ?>
                    <tr>
                        <td>
                            <a href="<?php echo url_for("/download/downloadMaterial?q=" . $r["id"]) ?>"><i class="<?php echo $thumbnailClass ?>" title="<?php echo $thumbnailDesc ?>" style="font-size: 2em;"></i>&nbsp;&nbsp;&nbsp;<span><?php echo __($r["file_name"]) ?><?php echo strlen($r["description"]) ? " - " . __($r["description"]) : "" ?> (<?php echo __($r["file_size"]) ?>)</span></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>