<?php include('scripts.php'); ?>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Fund Management Contract') ?></span></td>
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
            <table cellspacing="0" cellpadding="0" class="textarea1">
                <tbody>
                <tr>
                    <td>

                        <table cellspacing="0" cellpadding="0" class="tbl_form">
                            <colgroup>
                                <col width="1%">
                                <col width="30%">
                                <col width="69%">
                                <col width="1%">
                            </colgroup>
                            <tbody>
                            <tr>
                                <th class="tbl_header_left">
                                    <div class="border_left_grey">&nbsp;</div>
                                </th>
                                <th><?php echo __('Fund Management Performance') ?></th>
                                <th class="tbl_content_right"></th>
                                <th class="tbl_header_right">
                                    <div class="border_right_grey">&nbsp;</div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table class="pbl_table" cellpadding="3" cellspacing="3">
                                        <tbody>
                                        <colgroup>
                                            <col width="5%">
                                            <col width="20%">
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="25%">
                                        </colgroup>
                                        <tr class="pbl_header">
                                            <td><?php echo __('') ?></td>
                                            <td><?php echo __('MT4 ID') ?></td>
                                            <td><?php echo __('Unrealized Profit') ?></td>
                                            <td><?php echo __('Realized Profit') ?></td>
                                            <td><?php echo __('Private Investment Agreement') ?></td>
                                        </tr>
                                        <?php
                                        if (count($fundManagements) > 0) {
                                            $trStyle = "1";
                                            $idx = 1;
                                            foreach ($fundManagements as $fundManagement) {
                                                if ($trStyle == "1") {
                                                    $trStyle = "0";
                                                } else {
                                                    $trStyle = "1";
                                                }

                                                echo "<tr class='row" . $trStyle . "'>
                                <td align='center'>" . $idx++ . "</td>
                                <td align='center'><a href='#' class='linkMt4' ref='" . $fundManagement['mt4_user_name'] . "'>" . $fundManagement['mt4_user_name'] . "</a></td>
                                <td align='center'>" . number_format($fundManagement['unrealized_profit'], 2) . "</td>
                                <td align='center'>" . number_format($fundManagement['realized_rofit'], 2) . "</td>";

                                            if ($fundManagement['contract'] != "") {
                                            ?>
                                                <td align='center'>
                                                    <a href="<?php echo url_for("/download/privateInvestmentAgreementContract?q=".$fundManagement['contract']) ?>">
                                                        <img src="/images/common/fileopen.png" alt="view file">
                                                    </a>
                                                </td>
                                            <?php
                                                } else {
                                                    echo "<td align='center'></td>";
                                                }

                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr class='odd' align='center'><td colspan='5'>" . __('No data available in table') . "</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        $(function() {
                                            $(".linkMt4").click(function(event) {
                                                event.preventDefault();
                                                var mt4Id = $(this).attr("ref");

                                                $("#divMt4Roi").html("<img src='/images/common/indicator.gif'>");
                                                $("#divMt4Roi").show();

                                                $.ajax({
                                                            type : 'POST',
                                                            url : "/finance/fetchRoiList",
                                                            dataType : 'json',
                                                            cache: false,
                                                            data: {
                                                                mt4UserId : mt4Id
                                                            },
                                                            success : function(data) {
                                                                $.unblockUI();
                                                                var table = "<table class='pbl_table' cellpadding='3' cellspacing='3'><tbody><colgroup>";
                                                                table += "<col width='5%'>";
                                                                table += "<col width='20%'>";
                                                                table += "<col width='20%'>";
                                                                table += "<col width='20%'>";
                                                                table += "<col width='20%'>";
                                                                table += "<col width='20%'>";
                                                                table += "<col width='15%'>";
                                                                table += "</colgroup>";
                                                                table += "<tr class='pbl_header'>";
                                                                table += "<td></td>";
                                                                table += "<td><?php echo __('Next Performance Return Date')?></td>";
                                                                table += "<td><?php echo __('Package')?></td>";
                                                                table += "<td><?php echo __('MT4 Balance')?></td>";
                                                                table += "<td><?php echo __('Performance')?> %</td>";
                                                                table += "<td><?php echo __('Total Profit')?></td>";
                                                                table += "<td><?php echo __('Status')?></td>";
                                                                table += "</tr>";

                                                                var trStyle = "1";
                                                                var idx = 1;
                                                                jQuery.each(data.mlmRoiDividends, function(key, value) {
                                                                    if (trStyle == "1") {
                                                                        trStyle = "0";
                                                                    } else {
                                                                        trStyle = "1";
                                                                    }
                                                                    table += "<tr class='row" + trStyle + "'>";
                                                                    table += "<td align='center'>" + value[0] + "</td>";
                                                                    table += "<td align='center'>" + value[1] + "</td>";
                                                                    table += "<td align='right'>" + value[2] + "</td>";
                                                                    table += "<td align='right'>" + value[3] + "</td>";
                                                                    table += "<td align='right'>" + value[4] + "</td>";
                                                                    table += "<td align='right'>" + value[5] + "</td>";
                                                                    table += "<td align='center'>" + value[6] + "</td>";
                                                                    table += "</tr>";
                                                                });

                                                                table += "</tbody></table>";
                                                                $("#divMt4Roi").html(table);
                                                            },
                                                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                                                alert("Server connection error.");
                                                            }
                                                        });
                                            });

                                            $(".linkMt4:first").trigger("click");
                                        });

                                    </script>
                                    <div id="divMt4Roi" style="display: none;"><img src="/images/common/indicator.gif">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>