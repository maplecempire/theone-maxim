<?php include('scripts.php'); ?>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Exchange Rate') ?></span></td>
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
        <h3>FMC Announcement</h3>
        <br>Following consultations with our International Members and all those concerned and having listened carefully to  all the viewpoints offered for and against.
        <br>
        <br>The Board herein now complies with its legal obligation to give 14 days clear notice of the long overdue introduction of the Fund Management Costs (FMC)10% scheme. Recognising that this our FMC fee is one of the lowest in the market place and that at this stage of our infancy we have managed to survive without it, to date, yet still honoured our commitments to you to date, plus our Monthly returns being higher than most, we therefore look forward to your support and understanding please.
        <br>
        <br>Therefore, 14 days from the date of this Posting of this Notice at the back office, the following  Policy must be observed and adhered to please.
        <br>
        <br>Example;
        <br>
        <br>Pay in: US$5500.00
        <br>CP credit: US$5000.00
        <br>
        <br>This shall also apply to existing Members whom open fresh accounts, as our system will be flagged to ensure the correct amount is paid in, inclusive of FMC.
        <br>
        <br>A full Explanation Sheet is being prepared and is available upon your request at Legal Watch, found at the members area at the back office. Please do allow yourself to be fully updated as you deserve to be and we truly thank you for you patronage through our time of infancy and look forward to your support.
        <br>
        <br>DATE POSTED:
        <br>29 July 2014.
        <br>
        <br>..............................
        <br>For and on behalf of
        <br>The BOARD OF DIRECTORS, Maxim Capital Ltd.
        <br>
        <br>
        <table class="pbl_table" cellpadding="3" cellspacing="3">
            <tbody>
            <tr class="pbl_header">
                <td><?php echo __('Country') ?></td>
                <td><?php echo __('Purchase') ?></td>
                <td><?php echo __('Withdraw') ?></td>
            </tr>
            <!--<tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Australia Dollars" alt=""
                                                        src="/css/maxim/flag/3.gif"><br>Australia Dollars
                </p></td>
                <td valign="middle"><p align="center">1.10</p></td>
                <td valign="middle"><p align="center">0.90</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Brunei Dollars" alt=""
                                                        src="/css/maxim/flag/5.gif"><br>Brunei Dollars</p></td>
                <td valign="middle"><p align="center">1.40</p></td>
                <td valign="middle"><p align="center">1.18</p></td>
            </tr>-->
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Cambodia" alt=""
                                                        src="/css/maxim/flag/22.gif"><br>Cambodia</p></td>
                <td valign="middle"><p align="center">KHR4,500.00</p></td>
                <td valign="middle"><p align="center">KHR4,100.00</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="China Yuan" alt=""
                                                        src="/css/maxim/flag/8.gif"><br>China Yuan

                </p></td>
                <td valign="middle"><p align="center">RMB7.00</p></td>
                <td valign="middle"><p align="center">RMB6.30</p></td>
            </tr>
            <!--<tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Euro" alt=""
                                                        src="/css/maxim/flag/2.gif"><br>Euro</p></td>
                <td valign="middle"><p align="center">0.85</p></td>
                <td valign="middle"><p align="center">0.75</p></td>
            </tr>-->
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Hong Kong Dollars" alt=""
                                                        src="/css/maxim/flag/9.gif"><br>Hong Kong Dollars

                </p></td>
                <td valign="middle"><p align="center">HKD8.5</p></td>
                <td valign="middle"><p align="center">HKD7.80</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="India Rupees" alt=""
                                                        src="/css/maxim/flag/16.gif"><br>India Rupees
                </p></td>
                <td valign="middle"><p align="center">INR75.00</p></td>
                <td valign="middle"><p align="center">INR68.00</p></td>
            </tr>
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Indonesia Rupiahs" alt=""
                                                        src="/css/maxim/flag/19.gif"><br>Indonesia Rupiahs</p></td>
                <td valign="middle"><p align="center">R13,500.00</p></td>
                <td valign="middle"><p align="center">R11,000.00</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Japan Yen" alt=""
                                                        src="/css/maxim/flag/17.gif"><br>Japan Yen</p></td>
<!--                <td valign="middle" colspan="2"><p align="center">JPY (FOLLOW BANK RATE based on weekly)</p></td>-->
                <td valign="middle"><p align="center">JPY150.00</p></td>
                <td valign="middle"><p align="center">N/A</p></td>
            </tr>
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Korea(South) Won" alt=""
                                                        src="/css/maxim/flag/18.gif"><br>Korea(South) Won<br>
                </p></td>
                <td valign="middle"><p align="center">KRW1,150.00</p></td>
                <td valign="middle"><p align="center">KRW1,050.00</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Malaysia Ringgit" alt=""
                                                        src="/css/maxim/flag/7.gif"><br>Malaysia Ringgit

                </p></td>
                <td valign="middle"><p align="center">RM3.60</p></td>
                <td valign="middle"><p align="center">N/A</p></td>
            </tr>
            <!--<tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Macau Patacas" alt=""
                                                        src="/css/maxim/flag/10.gif"><br>Macau Patacas
                </p></td>
                <td valign="middle"><p align="center">8.60</p></td>
                <td valign="middle"><p align="center">7.40</p></td>
            </tr>

            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="New Zealand Dollars" alt=""
                                                        src="/css/maxim/flag/6.gif"><br>New Zealand Dollars</p></td>
                <td valign="middle"><p align="center">1.40</p></td>
                <td valign="middle"><p align="center">1.20</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Nigeria" alt=""
                                                        src="/css/maxim/flag/23.gif"><br>Nigeria</p></td>
                <td valign="middle"><p align="center">175.00</p></td>
                <td valign="middle"><p align="center">150.00</p></td>
            </tr>-->
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Philippines Pesos" alt=""
                                                        src="/css/maxim/flag/15.gif"><br>Philippines Pesos</p></td>
                <td valign="middle"><p align="center">PHP50.00</p></td>
                <td valign="middle"><p align="center">PHP45.00</p></td>
            </tr>
            <!--<tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Russia Rubles" alt=""
                                                        src="/css/maxim/flag/12.gif"><br>Russia Rubles</p></td>
                <td valign="middle"><p align="center">34.80</p></td>
                <td valign="middle"><p align="center">30.00</p></td>
            </tr>-->
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Singapore Dollars" alt=""
                                                        src="/css/maxim/flag/4.gif"><br>Singapore Dollars</p></td>
                <td valign="middle"><p align="center">SGD1.40</p></td>
                <td valign="middle"><p align="center">SGD1.28</p></td>
            </tr>
            <!--<tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="South Africa Rand" alt=""
                                                        src="/css/maxim/flag/11.gif"><br>South Africa Rand</p></td>
                <td valign="middle"><p align="center">8.70</p></td>
                <td valign="middle"><p align="center">7.50</p></td>
            </tr>
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Switzerland" alt=""
                                                        src="/css/maxim/flag/25.gif"><br>Switzerland</p></td>
                <td valign="middle"><p align="center">1.00</p></td>
                <td valign="middle"><p align="center">0.90</p></td>
            </tr>-->
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Taiwan New Dollars" alt=""
                                                        src="/css/maxim/flag/13.gif"><br>Taiwan New Dollars</p></td>
                <td valign="middle"><p align="center">NTD34.00</p></td>
                <td valign="middle"><p align="center">NTD31.00</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Thailand Baht" alt=""
                                                        src="/css/maxim/flag/14.gif"><br>Thailand Baht</p></td>
                <td valign="middle"><p align="center">B36</p></td>
                <td valign="middle"><p align="center">B33</p></td>
            </tr>
            <!--<tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Turkey" alt=""
                                                        src="/css/maxim/flag/24.gif"><br>Turkey</p></td>
                <td valign="middle"><p align="center">1.90</p></td>
                <td valign="middle"><p align="center">1.60</p></td>
            </tr>
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="United Kingdom Pounds" alt=""
                                                        src="/css/maxim/flag/1.gif"><br>United Kingdom Pounds
                </p></td>
                <td valign="middle" color="#28eb13"><p align="center">0.69</p></td>
                <td valign="middle"><p align="center">0.59</p></td>
            </tr>-->
            <tr class="row0">
                <td valign="middle"><p align="center"><img width="90" height="45" title="United State" alt=""
                                                        src="/css/maxim/flag/21.gif"><br>United State Dollar
                </p></td>
                <td valign="middle" color="#28eb13"><p align="center">USD1.10</p></td>
                <td valign="middle"><p align="center">USD1.00</p></td>
            </tr>
            <tr class="row1">
                <td valign="middle"><p align="center"><img width="90" height="45" title="Vietnam Dong" alt=""
                                                        src="/css/maxim/flag/20.gif"><br>Vietnam Dong</p></td>
                <td valign="middle"><p align="center">VND24,000.00</p></td>
                <td valign="middle"><p align="center">VND22,000.00</p></td>
            </tr>
            </tbody>
        </table>
        <br><strong>(Modified on 21st July 2014)</strong>
    </td>
</tr>
</tbody>
</table>