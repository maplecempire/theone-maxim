<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    $(function() {
        $("#cbo_cp3Amount").change(function(){
            var ecashFinal = $("#cbo_cp3Amount").autoNumericGet() - 30;
            $("#ecashFinal").autoNumericSet(ecashFinal);
        }).change();

        $("#withdrawForm").validate({
            messages : {
                transactionPassword: {
                    remote: "<?php echo __("Security Password is not valid")?>"
                }
            },
            rules : {

            },
            submitHandler: function(form) {
                var withdrawAmount = parseFloat($("#cbo_cp3Amount").autoNumericGet());
                $("#cbo_cp3Amount").val(withdrawAmount);
                form.submit();
            }
        });

        $('#cbo_cp3Amount').autoNumeric({
            mDec: 2
        });
    });
</script>

<div class="ewallet_li">
	<a target="_self" class="navcontainer" href="/member/mt4Withdrawal" style="color: rgb(0, 93, 154);">
        <?php echo __('MT4 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/ecashWithdrawal");?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP2 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/cp3Withdrawal");?>" style="color: rgb(134, 197, 51);">
        <?php echo __('CP3 Withdrawal'); ?>
    </a>
</div>

<input type="hidden" id="iaccountChecking" value="<?php echo $toApplyIaccount?>">
<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('CP3 Withdrawal') ?></span></td>
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
            <form action="/member/cp3Withdrawal2" id="withdrawForm" name="withdrawForm" method="post">
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
                    <th colspan="2"><?php echo __('CP3 Withdrawal') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Member ID'); ?></td>
                    <td>
                        <select name="memberId" id="memberId" tabindex="2">
                            <option value="295704">Behnho2</option>
                            <option value="301904">bobwu63</option>
                            <option value="284946">CHICKADEE1</option>
                            <option value="262109">chiyun</option>
                            <option value="274455">chongkheecheong</option>
                            <option value="307397">chongyeesun100</option>
                            <option value="285440">CSYSEK888</option>
                            <option value="301180">hui1965</option>
                            <option value="257378">JOJOYP-MY</option>
                            <option value="558">kashventure</option>
                            <option value="256376">KIMPLANETSA</option>
                            <option value="270170">leeahfong</option>
                            <option value="271432">linpaopi</option>
                            <option value="311781">peterin</option>
                            <option value="304239">pohengguan</option>
                            <option value="261642">prowprow</option>
                            <option value="306783">sferguson12</option>
                            <option value="289970">Shin191</option>
                            <option value="307468">sydul6</option>
                            <option value="271249">vision54</option>
                            <option value="280143">WINGHONG</option>
                            <option value="271892">yapchuanweng</option>
                            <option value="257459">YUEN257</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP3 Withdrawal Amount'); ?></td>
                    <td>
                        <input name="cp3Amount" id="cbo_cp3Amount" tabindex="2"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('After handling fee'); ?>
                    </td>
                    <td>
                        <input name="ecashFinal" type="text" id="ecashFinal" readonly="readonly" tabindex="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Credit To'); ?>
                    </td>
                    <td>
                        <select name="bankInTo" id="bankInTo">
                            <option value="<?php echo Globals::WITHDRAWAL_LOCAL_BANK; ?>" <?php echo $disable;?>><?php echo __('Local Bank Transfer'); ?></option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td colspan="2" valign="top">
                         &nbsp;
                        <font color="#dc143c"> <?php echo __('NOTE :') ?></font>
                        <br>
                        <ol style="color: #dc143c; padding-left: 20px;">
                            <li><?php echo __('Minimum withdrawal amount is USD100') ?></li>
                            <li><?php echo __('Withdrawal request must be done during the first 7 days of each month') ?></li>
                            <li><?php echo __('Processing time will be at least 3 days') ?></li>
                            <li><?php echo __('Payout will be by the 15th of each month') ?></li>
                            <li><?php echo __('Handling Fee is USD30') ?></li>
                            <li><?php echo __('All withdrawals shall be paid out based on current days\' prevailing exchange rate and subject to local bank charges') ?></li>
                            <li><?php echo __('Payout time for monthly CP2 withdrawals to be credited to your account:') ?>
                                <ul>
                                    <li style="padding-left: 15px;"><?php echo __('Local bank accounts - by 25th') . " ".__('(Excluding non-working days)')  ?></li>
                                    <li style="padding-left: 15px;"><?php echo __('i-Account - by 11th') . " ".__('(Excluding non-working days)')  ?></li>
<!--                                    <li style="padding-left: 15px;">--><?php //echo __('Money Trac - by 20th') ?><!--</li>-->
                                </ul>
                            </li>
                        </ol>

                        <!--<div class="ui-widget" style="display: none" id="moneyTracNote">
                            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                              class="ui-icon ui-icon-info"></span>
                                    <strong><?php /*echo __("For community transfers, kindly go to \"<strong>Add Community Member</strong>\" and fill in <br>
                                    <ol>
                                        <li>Customer Name: Maxim Capital Limited</li>
                                        <li>Customer Number: 000028911</li>
                                        <li>Customer Email Address: finance@maximtrader.com</li>
                                    </ol>
                                    Tick \"Receive Funds From this Customer\" and Send Connection Request"); */?></strong>
                                    <br>
                                    </p>
                            </div>
                        </div>-->

                        <div class="ui-widget" style="display: none" id="moneyTracNote2">
                            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                              class="ui-icon ui-icon-info"></span>

                                    <strong>Latest info regarding MoneyTrac:</strong>
                                    <br>
                                    <br>For time being, we withdrawals from MoneyTrac to local Malaysian accounts only available for (master/visa)
                                    <br>
                                    <br>1) MBB Debit Card
                                    <br>2) PBB Saving Acc Debit Card
                                    <br>3) HSBC Debit Card
                                    <br>
                                    <br>Not to
                                    <br>CIMB, Hong Leong Bank, RHB
                                    </p>
                            </div>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnTransfer"><?php echo __('Submit') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                </tbody>
            </table>

            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <script type="text/javascript" language="javascript">
            var datagrid = null;
            $(function() {
                datagrid = $("#datagrid").r9jasonDataTable({
                    // online1DataTable extra params
                    "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                    "extraParam" : function(aoData) { // pass extra params to server
                    },
                    "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                        reassignDatagridEventAttr();
                    },

                    // datatables params
                    "bLengthChange": true,
                    "bFilter": false,
                    "bProcessing": true,
                    "bServerSide": true,
                    "bAutoWidth": false,
                    "sAjaxSource": "/finance/cp3WithdrawalList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [6,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "dist_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "deduct",  "bSortable": true},
                        { "sName" : "amount",  "bSortable": true},
                        { "sName" : "bank_in_to",  "bSortable": true},
                        { "sName" : "status_code",  "bSortable": true},
                        { "sName" : "remarks",  "bSortable": true},
                        { "sName" : "created_on",  "bSortable": true}
                    ]
                });
            }); // end function

            function reassignDatagridEventAttr() {
            }
        </script>

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
                <th><?php echo __('CP3 Withdrawal Status') ?></th>
                <th class="tbl_content_right"></th>
                <th class="tbl_header_right">
                    <div class="border_right_grey">&nbsp;</div>
                </th>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="display" id="datagrid" border="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th><?php echo __('Withdrawal') ?></th>
                <th><?php echo __('Amount') ?></th>
                <th><?php echo __('Credit To') ?></th>
                <th><?php echo __('Status') ?></th>
                <th><?php echo __('Remarks') ?></th>
                <th><?php echo __('Date') ?></th>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>