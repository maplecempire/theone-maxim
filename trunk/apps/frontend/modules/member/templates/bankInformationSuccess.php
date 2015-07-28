<?php include('scripts.php'); ?>
<style type="text/css">
.tbl_form td {
    height: 20px;
}
</style>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Bank Account Information') ?></span></td>
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
        <table border="0" cellspacing="0" width="99%"
               style="border-collapse:collapse;border:1px solid rgb(0,0,0);font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgb(51,51,51);line-height:15px">
            <tbody>
            <tr>
                <th colspan="2"
                    style="color:rgb(0,0,0);background-color:rgb(221,221,221);padding:3px 7px;border:1px solid rgb(170,170,170)">
                    Czech Republic (USD)
                </th>
            </tr>
            <tr>
                <td width="30%" style="padding:3px 7px;border:1px solid rgb(170,170,170)">Bank:</td>
                <td width="69%" style="padding:3px 7px;border:1px solid rgb(170,170,170)">CESKA SPORITELNA A.S.</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Address:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">PRAGUE 62, OLBRACHTOVA 14000</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Account No:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">CZ77 0800 0000 0000 0635 2242</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Account Name:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Global Transaction Services (HK) Limited
                </td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Account Holder Address:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Room 2705 Richmond Commercial Building 109
                    Argyle Street Mongkok, Kowloon, 0000, Hong Kong
                </td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">IBAN:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">CZ77 0800 0000 0000 0635 2242</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">SWIFT BIC:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">GIBACZPX</td>
            </tr>
            <tr>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Your Reference:</td>
                <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">9120028849</td>
            </tr>
            <tr>
                <td colspan="2" style="padding:3px 7px;border:1px solid rgb(170,170,170)"><span
                        style="font-style:italic;color:rgb(255,0,0)">Your Reference (9120028849) should be entered first in the narrative of the sending bank's payment instructions, before any other references.<span
                        class="HOEnZb"><font color="#888888"><br><br></font></span></span></td>
            </tr>
            </tbody>
        </table>

            <table cellspacing="0" cellpadding="0" class="tbl_form" style="display: none;">
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
                    <th colspan="2"><?php echo __('Maxim Capital Limited USD Account') ?></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Name') ?></td>
                    <td class="value"><?php echo $bankName; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Bank Swift Code'); ?>
                    </td>
                    <td class="value"><?php echo $bankSwiftCode; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('IBAN'); ?>
                    </td>
                    <td class="value"><?php echo $iban; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Bank Account Holder'); ?>
                    </td>
                    <td class="value"><?php echo $bankAccountHolder; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Bank Account Number'); ?>
                    </td>
                    <td class="value"><?php echo $bankAccountNumber; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('City of Bank'); ?>
                    </td>
                    <td class="value"><?php echo $cityOfBank; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Country of Bank'); ?>
                    </td>
                    <td class="value"><?php echo $countryOfBank; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td class="caption" colspan="2">
                        <span style="color: #dc143c">
<!--                            --><?php //echo __('NOTE: Please write at REFERENCE : Maxim Capital Limited - 9120028849'); ?><!--</span>-->
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>

            <br>
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
                    <th colspan="2"><?php echo __('Global Transaction Services') ?></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Phone Number') ?></td>
                    <td class="value">+1 678-264-2350</td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td valign="top"><?php echo __('Beneficiary Address') ?></td>
                    <td class="value">820 Marshview Close
                        <br>Roswell, GA 30076-3285
                        <br>USA</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <?php
            $toHide = true;
            if ($distDB->getCountry() != "Thailand" && $toHide == false) { ?>
            <br>
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
                    <th colspan="2"><?php echo __('Maxim Capital Limited Thai Baht Account') ?></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Name') ?></td>
                    <td class="value"><?php echo $bankName2; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Bank Swift Code'); ?>
                    </td>
                    <td class="value"><?php echo $bankSwiftCode2; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Bank Account Holder'); ?>
                    </td>
                    <td class="value"><?php echo $bankAccountHolder2; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Bank Account Number'); ?>
                    </td>
                    <td class="value"><?php echo $bankAccountNumber2; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('City of Bank'); ?>
                    </td>
                    <td class="value"><?php echo $cityOfBank2; ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td width="160px" class="caption">
                        <?php echo __('Country of Bank'); ?>
                    </td>
                    <td class="value"><?php echo $countryOfBank2; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td class="caption" colspan="2">
                        <span style="color: #dc143c">
                            NOTE: USD1 : Baht31
                        </span>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <?php } ?>
        </td>
    </tr>

    <!--<tr>
        <td>
            <br>
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
                    <th colspan="2"><?php /*echo __('Maxim Capital Limited EzyAccount') */?></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('EzyAccount ID') */?></td>
                    <td class="value">36496</td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Email Address') */?></td>
                    <td class="value">finance@maximtrader.com</td>
                    <td>&nbsp;</td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>-->
    </tbody>
</table>