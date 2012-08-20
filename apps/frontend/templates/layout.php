<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
    <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="-1">

    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>

    <?php use_helper('I18N') ?>
    <?php include('scripts.php'); ?>
    <!-- Google WebFonts -->
    <link rel="stylesheet" href="/css/style.css">

    <link rel="shortcut icon" href="/favicon.ico"/>

    <style type="text/css">
        .hiddenPic {
            display: none;
        }

        .ui-widget {
            font-family: Segoe UI, Arial, sans-serif;
            font-size: 0.9em;
        }

        .text {
            padding: 5px;
        }

        .ui-widget-content .display td {
            color: black !important;
        }

        .ui-widget-content .display a {
            color: #0066bb !important;
        }

        .font {
            font-size: 14px;
            color: #f9c81e;
            font-family: arial;
        }

        .error-font {
            font-size: 14px;
            color: #990033;
            font-family: arial;
        }

        .portlet {
            margin: 0 1em 1em 0;
        }

        .portlet-header {
            margin: 0.3em;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 0.5em;
        }

        .portlet-header .ui-icon {
            float: right;
        }

        .portlet-content {
            padding: 1em;
        }

        .ui-button {
            margin-left: -1px;
        }

        .ui-button-icon-only .ui-button-text {
            padding: 0.35em;
        }

        .ui-autocomplete-input {
            margin: 0;
            padding: 0.42em 0 0.47em 0.45em;
        }

        .ui-autocomplete {
            max-height: 200px;
            min-width: 180px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        }

            /* IE 6 doesn't support max-height
            * we use height instead, but this forces the menu to always be this tall
            */
        * html .ui-autocomplete {
            height: 200px;
        }
        .display td {
            font-size: 12px;
        }
    </style>

    <script type="text/javascript">
        var infoStyle = "<div style='margin-bottom: 20px; padding: 0 .7em;' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span><strong id='_msg'></strong></p></div>";
        var errorStyle = "<div style='padding: 0 .7em;' class='ui-state-error ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-alert'></span><strong id='_msg'></strong></p></div>";

        $(function() {
            $("button, input:submit, input:button").button();
            $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
                    .find(".portlet-header")
                    .addClass("ui-widget-header ui-corner-all")
                    .prepend("<a href='#' class='ui-dialog-titlebar-close ui-corner-all' role='button'><span class='ui-icon ui-icon-circle-triangle-n' style='padding-right: 2px'></span></a>")
                    .end()
                    .find(".portlet-content");

            $(".portlet-header .ui-icon").click(function() {
                $(this).toggleClass("ui-icon-circle-triangle-n").toggleClass("ui-icon-circle-triangle-s");
                $(this).parents(".portlet:first").find(".portlet-content").toggle("fast");
            });

            $("#btnLogout").click(function(){
                $("#formLogout").submit();
            });
        });

        function alert(data) {
            var msgs = "";
            if ($.isArray(data)) {
                jQuery.each(data, function(key, value) {
                    msgs = value + "<br>";
                });
            } else {
                msgs = data + "<br>";
            }

            var alertPanel = "<div style='margin-bottom: 20px; padding: 0 .7em;' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span>";
            alertPanel += msgs + "</p></div>";
            $("#waitingLB h3").html(alertPanel);
            $.blockUI({
                        message: $("#waitingLB")
                        , css: {
                            border: 'none',
                            padding: '5px',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            'border-radius': '10px',
                            opacity: .9
                        }});
            $(".blockOverlay").css("z-index", 1010);
            $(".blockPage").css("z-index", 1011);
            $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);
        }
        function error(data) {
            var msgs = "";
            if ($.isArray(data)) {
                jQuery.each(data, function(key, value) {
                    msgs = value + "<br>";
                });
            } else {
                msgs = data + "<br>";
            }

            var errorPanel = "<div style='padding: 0 .7em;' class='ui-state-error ui-corner-all'>";
            errorPanel += "<p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-alert'></span>";
            errorPanel += msgs + "</p></div>";
            $("#waitingLB h3").html(errorPanel);
            $.blockUI({
                        message: $("#waitingLB")
                        , css: {
                            border: 'none',
                            padding: '5px',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            'border-radius': '10px',
                            opacity: .9,
                            'min-width': '30%',
                            'width': '60%',
                            left: '25%',
                            top: '25%'
                        }});
            $(".blockOverlay").css("z-index", 1010);
            $(".blockPage").css("z-index", 1011);
            $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);
        }
        function waiting() {
            $("#waitingLB h3").html("<h3>Loading...</h3><div id='loader' class='loader'><img id='img-loader' src='/images/loading.gif' alt='Loading'/></div>");

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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<img src="/images/loading.gif" class="hiddenPic">

<form id="formLogout" action="/home/logout"></form>
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request. Please be patient.</h3>
</div>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td align="left">
<table class="tbl_layout" cellpadding="0" cellspacing="0">
<colgroup>
    <col width="1%">
    <col width="49%">
    <col width="49%">
    <col width="1%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td colspan="2">
        <table cellpadding="0" cellspacing="0">
            <colgroup>
                <col class="scb_colorbar1" width="20%">
                <col class="scb_colorbar2" width="10%">
                <col class="scb_colorbar3" width="15%">
                <col class="scb_colorbar4" width="5%">
                <col class="scb_colorbar5" width="50%">
            </colgroup>
            <tbody>
            <tr>
                <td class="scb_colorbar1">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="tbl_heading" cellpadding="0" cellspacing="0">
            <colgroup>
                <col width="17%">
                <col width="83%">
            </colgroup>
            <tbody>
            <tr>
                <td rowspan="2">
                    <img src="/images/logo.png" height="85">
                </td>
                <td class="txt_mainheading">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td class="txt_subheading"></td>
            </tr>
            </tbody>
        </table>
    </td>
    <td rowspan="3">&nbsp;</td>
</tr>
<tr>
    <th class="tbl_heading_left">
        <span style="" id="nameLabel">
        You are logged in as:
        </span>
        <span style="" id="nameTag">
        <b><?php echo $sf_user->getAttribute(Globals::SESSION_USERNAME); ?></b>
        </span>
    </th>
    <th class="tbl_heading_left">
        <span class="button" style="float: right;">
            <input type="button" value="Logout" name="Logout" id="btnLogout">
        </span>
    </th>
</tr>
<tr>
    <td colspan="2">
    <br>
    <table cellpadding="0" cellspacing="0">
    <colgroup>
        <col width="15%">
        <col width="75%">
        <col width="10%">
    </colgroup>
    <tbody>
    <tr>
        <td rowspan="3" valign="top">
            <!-- ############################ -->
            <!-- ######## LEFT PANEL ######## -->
            <!-- ############################ -->
            <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>

            <!-- ##################################### -->
            <!-- ##### ~ END LEFT PANEL END ~ ######## -->
            <!-- ##################################### -->
        </td>
        <td class="tbl_sprt_bottom">
            <?php echo $sf_data->getRaw('sf_content') ?>
        </td>
        <td rowspan="3">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    </td>
</tr>
<tr>
    <td></td>
    <td colspan="2">
        <br>
        <hr class="hr_heading">
        <br>
        Copyright © Maxim Trader
        &nbsp;<span class="txt_seperator">|</span>&nbsp;
        <img src="/images/maxim/arrow_blue_single_tab.gif">

        <a href="#" class="navcontainer_nav_1" id="nav_terms_conditions" target="_self">
            Terms &amp; Conditions
        </a>

        &nbsp;<span class="txt_seperator">|</span>&nbsp;

        <img src="/images/maxim/arrow_blue_single_tab.gif">
        <a href="#" target="_self">
            Data Protection and Privacy Policy
        </a>
    </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

</body>
</html>
