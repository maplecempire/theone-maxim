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

<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request. Please be patient.</h3>
</div>
<div id="wrapp_v2">
    <div class="wrapper">
        <!--this is header--><!-- #BeginLibraryItem "/Library/header.lbi" -->
        <div id="header">
            <div id="logo"><a href="/member/summary"><img src="/images/ofxglobal/logo.jpg" alt="Maxim Trader"></a>
            </div>
            <span class="titleSpan"><strong>Serving Traders in <em class="titleEm">205</em> Countries Across <em
                    class="titleEm">6</em> Continents</strong></span>

            <div class="clear"></div>
            <div id="naviWrap">
                <div id="navi_left"></div>
                <div id="navi">
                    <ul class="sf-menu">
                        <li><a href="/member/summary" class=""><?php echo __('Home'); ?></a></li>
                        <li><a href="/member/viewProfile" class=""><?php echo __('Profile'); ?></a></li>
                        <li><a href="/member/sponsorTree" class=""><?php echo __('Genealogy'); ?></a></li>
                        <li><a href="/member/bonusDetails"><?php echo __('Bonus Details'); ?></a></li>
                        <li class="last"><a href="<?php echo url_for("/home/logout")?>"><?php echo __('Logout'); ?></a>
                        </li>
                    </ul>
                </div>
        </div>
        <!-- #EndLibraryItem --><!--header end here-->
        <div class="clear"></div>
        <!--- this is content--->
        <div class="content">
            <!--- aside--->
            <?php echo $sf_data->getRaw('sf_content') ?>

            <!--- contend end --->
            <div class="push"></div>
            <div class="clear"></div>
        </div>
        <!--- content end here--->
    </div>

    <div class="clear"></div>
    <!--this is footer-->
    <div id="footer" class="footer">
        <div class="copy">
            <address>Copyright © Maxim Trader, Privacy Statement | Terms and Conditions.</address>
        </div>
        <div class="clear"></div>
    </div>
    <!--footer is end here-->
    <div class="clear"></div>
</div>

</body>
</html>
