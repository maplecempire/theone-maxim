<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
    <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="-1">
    <link rel="shortcut icon" href="/favicon.ico"/>

    <?php use_helper('I18N') ?>
    <?php include('scripts.php'); ?>
    <link rel='stylesheet' id='nivocss-css'  href='/css/maxim/nivo-slider.css' type='text/css' media='all' />
    <link rel='stylesheet' id='styler-farbtastic-css'  href='/css/maxim/styler-farbtastic.css' type='text/css' media='all' />
    <link rel='stylesheet' id='wp-paginate-css'  href='/css/maxim/wp-paginate.css' type='text/css' media='screen' />

    <link rel="stylesheet" href="/css/style.css">

    <script type='text/javascript' src='/css/maxim/comment-reply.js'></script>
    <script type='text/javascript' src='/css/maxim/preloader.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.nivo.slider.js'></script>
    <script type='text/javascript' src='/css/maxim/bottomfix.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.quicksand.js'></script>
    <script type='text/javascript' src='/css/maxim/farbtastic.js'></script>

    <meta http-equiv="Content-Language" content="en-US">
    <style type="text/css" media="screen">
    .qtrans_flag span { display:none }
    .qtrans_flag { height:12px; width:18px; display:block }
    .qtrans_flag_and_text { padding-left:20px }
    a {
        background-color: transparent;
        color: #005D9A !important;
    }
    </style>
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">
</head>

<body class="home blog">

<div id="waitingLB" style="display:none; cursor: default">
    <h3 style="width: 100%; padding-left: 0px; background-color:inherit; color: black; line-height:0px; margin-top: 0px">We are processing your request. Please be patient.</h3>
</div>

<noscript>
    <!-- display message if java is turned off -->
    <div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>
</noscript>

<div id="wrapper">
    <div style="display: inline; width: 666px; overflow: hidden; margin-right: 0px;" id="page">
        <div id="content">

            <?php include_component('component', 'multiLanguage', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            <div class="qtrans_widget_end"></div>
            <div style="clear:both;"><br></div>

            <table cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="1%">
                    <col width="99%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <tr>
                    <td rowspan="3">&nbsp;</td>
                    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('System Maintenance (12am - 1am)') ?></span></td>
                    <td rowspan="3">&nbsp;</td>
                </tr>
                <tr>
                <td>
                <table cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td class="tbl_content_top" colspan="3">
                        <table cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td colspan="3">
                                    <span class="txt_error">&nbsp;<?php if ($sf_flash->has('errorMsg')) { echo $sf_flash->get('errorMsg'); } ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="tbl_content_top">
                                    <table border="0" width="256" cellspacing="0" cellpadding="0" class="tbl_login_grey_bg">
                                        <colgroup>
                                            <col width="1%">
                                            <col width="30%">
                                            <col width="61%">
                                            <col width="2%">
                                            <col width="1%">
                                        </colgroup>
                                        <tbody>
                                        <tr>
                                            <th class="tbl_header_left"><img border="0" src="/images/maxim/hdr-gry-left.gif"></th>
                                            <th class="tbl_content_left" colspan="3"><?php echo __('Secure login') ?> &nbsp;<img src="/images/maxim/ico_secure_sml.gif"></th>
                                            <th class="tbl_header_right"><img border="0" src="/images/maxim/hdr-gry-right.gif"></th>
                                        </tr>

                                        <tr height="20">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr height="24">
                                            <td></td>
                                            <td colspan="3">
                                                <div class="ui-widget">
                                                    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                                         class="ui-state-error ui-corner-all">
                                                        <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                                                      class="ui-icon ui-icon-alert"></span>
                                                            <strong><?php echo __("We are sorry as Maxim Partner is under maintenance! Please come back after 1am!") ?></strong></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr height="30">
                                            <td></td>
                                            <td></td>
                                            <td colspan="2"><img class="arwList" src="/images/maxim/arrow_blue_single_tab.gif">
                                            <td></td>
                                        </tr>
                                        <tr height="36">
                                            <td align="center" colspan="5">
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
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
                </table>

<!--                    ####################################################            -->
        <table cellpadding="0" cellspacing="0">
            <tbody>

            <tr>
                <td class="tbl_content_top">
                    <table class="tbl_info_grey_bg" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <th class="tbl_header_left"><img src="/images/maxim/hdr-gry-left.gif"></th>
                            <th colspan="2">New to Maxim Trader?</th>
                            <th class="tbl_header_right"><img src="/images/maxim/hdr-gry-right.gif"></th>
                        </tr>
                        </tbody>
                    </table>

                    <table class="tbl_info_grey_bg_overall" cellpadding="0" cellspacing="0">
                        <colgroup>
                            <col width="1%">
                            <col width="4%">
                            <col width="94%">
                            <col width="1%">
                        </colgroup>
                        <tbody>
                        <tr>
                            <td></td>
                            <td class="tbl_content_top"><br>
                                <img src="/images/maxim/arrow_blue_single_tab.gif">
                            </td>
                            <td><br>
                                <a href="<?php echo url_for("/member/register")?>"><b>Self Registration</b></a> <span class="txt_new">IT'S EASY!!</span>
                                <p>
                                    <a href="<?php echo url_for("/member/register")?>">Click
                                        here</a> to instantly register as Maxim Trader Member. </p>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><br></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <br>
                                <br>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="tbl_notice_end">
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            </tbody>
        </table>
<!--                    ####################################################            -->
                </td>
                </tr>
                </tbody>
                </table>
            <?php include_component('component', 'footerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
        </div>
    </div>

    <div style="margin-left: 0px;" id="sidebar">
        <div id="sidebar-color"></div>
        <div id="sidebar-border"></div>
        <div id="sidebar-light"></div>
        <div id="sidebar-texture"></div>

        <div id="sidebar-content">

            <div id="logo"><a href="<?php echo url_for("/home")?>"><img src="/images/logo.png"></a></div>
            <div id="menu">
                <?php include_component('component', 'homeLeftMenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            </div>
            <div id="primary" class="widget-area" role="complementary">
                <ul class="xoxo">
                </ul>
            </div>
            <!-- #primary .widget-area -->
        </div>

        <div id="sidebar-bottom">
            <ul></ul>
            <p style="text-align: center;">© 2013 maximtrader.com <br> All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>