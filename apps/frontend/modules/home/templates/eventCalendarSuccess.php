<?php
$culture = $sf_user->getCulture();
?>

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
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">

    <link rel="stylesheet" type="text/css" href="/template/inspinia/css/plugins/fullcalendar/fullcalendar.css"/>
    <link rel="stylesheet" type="text/css" media="print" href="/template/inspinia/css/plugins/fullcalendar/fullcalendar.print.css"/>
    <link rel="stylesheet" type="text/css" href="/js/jquery/timepicker/jquery-ui-timepicker-addon.css"/>

    <meta http-equiv="Content-Language" content="en-US">
    <style type="text/css">
html {
    background: none repeat scroll 0 0 -moz-dialog;
    font: 3mm tahoma,arial,helvetica,sans-serif;
}
#feedBody {
    -moz-padding-start: 30px;
    background: none repeat scroll 0 0 -moz-field;
    border: 1px solid threedshadow;
    margin: 2em auto;
    padding: 3em;
}
#feedHeaderContainer {
    background-color: infobackground;
    border: 1px solid threedshadow;
    border-radius: 10px 10px 10px 10px;
    margin: -4em auto 0;
}
#feedHeader {
    -moz-margin-end: 1em;
    -moz-margin-start: 1.4em;
    -moz-padding-start: 2.9em;
    color: infotext;
    font-size: 110%;
    margin-bottom: 1em;
    margin-top: 4.9em;
}
#feedIntroText {
    display: none;
}
#feedHeader[dir="rtl"] {
    background-position: 100% 10%;
}
#feedHeader[firstrun="true"] #feedIntroText {
    -moz-padding-start: 0.6em;
    display: block;
    padding-top: 0.1em;
}
#feedHeader[firstrun="true"] > #feedSubscribeLine {
    -moz-padding-start: 1.8em;
}
#feedSubscribeLine {
    padding-top: 0.2em;
}
#feedHeaderContainer {
    display: none;
}
body {
    color: -moz-fieldtext;
    font: message-box;
    margin: 0;
    padding: 0 3em;
}
h1 {
    border-bottom: 2px solid threedlightshadow;
    font-size: 160%;
    margin: 0 0 0.2em;
}
h2 {
    color: threeddarkshadow;
    font-size: 110%;
    font-weight: normal;
    margin: 0 0 0.6em;
}
#feedTitleLink {
    -moz-margin-end: 0;
    -moz-margin-start: 0.6em;
    float: right;
    margin-bottom: 0;
    margin-top: 0;
}
a[href] img {
    border: medium none;
}
#feedTitleContainer {
    -moz-margin-end: 0.6em;
    -moz-margin-start: 0;
    margin-bottom: 0;
    margin-top: 0;
}
#feedTitleImage {
    -moz-margin-end: 0;
    -moz-margin-start: 0.6em;
    margin-bottom: 0;
    margin-top: 0;
    max-height: 150px;
    max-width: 300px;
}
.feedEntryContent {
    font-size: 110%;
}
.link {
    color: #0000FF;
    cursor: pointer;
    text-decoration: underline;
}
.link:hover:active {
    color: #FF0000;
}
.lastUpdated {
    font-size: 85%;
    font-weight: normal;
}
.type-icon {
    height: 16px;
    vertical-align: bottom;
    width: 16px;
}
.enclosures {
    background: none repeat scroll 0 0 -moz-dialog;
    border: 1px solid threedshadow;
    margin: 1em auto;
    padding: 1em;
}
.enclosure {
    margin-left: 2px;
    vertical-align: middle;
}
ul, ol {
    list-style: none outside none;
    margin: 0;
    color: black;
}
.news_date {
    padding-top: 10px;
    font-weight: bold;
    font-size: 13px;
}
#qtranslate-chooser {
    font-size: small;
}
#qtranslate-chooser a {
    padding-left: 20px;
}
#calendar span {
    color: #ffffff;
    font-size: small;
}
#detailForm table * {
    font-size: small;
    text-align: left;
}
.caption {
    font-weight: bold;
}
.fc-event-container {
    cursor: pointer;;
}
</style>
</head>

<body class="home blog"> 
<noscript>
	<!-- display message if java is turned off -->	
	<div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>	
</noscript>

<div id="wrapper">
    <div id="page">
        <div id="content">

            <?php include_component('component', 'multiLanguage', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>

            <br>
            <h1 id="feedTitleText" style="margin-right: 135px;"><?php echo __('Event Calendar') ?></h1>
            <br>

            <div id='calendar'></div>

            <br>
            <i>* <?php echo __("Click an item in calendar to view event details.") ?></i>
            <br><br>

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

<div id="eventDetailsPopup" style="display: none;">

    <br>

    <form id="detailForm" method="post" action="#">

        <table width="100%" border="0">
            <tr>
                <td class="caption" style="width: 86px;"><?php echo __("Event Title") ?></td>
                <td style="width: 1%;">:&nbsp;</td>
                <td class="value">
                    <span id="event_title">-</span>
                </td>
            </tr>
            <tr>
                <td class="caption" style="vertical-align: top;"><?php echo __("Event Details") ?></td>
                <td style="vertical-align: top;">:&nbsp;</td>
                <td class="value">
                    <span id="event_detail">-</span>
                </td>
            </tr>
            <tr>
                <td class="caption"><?php echo __("All Day") ?></td>
                <td>:&nbsp;</td>
                <td class="value">
                    <input type="checkbox" id="all_day" name="all_day" value="Y">
                </td>
            </tr>
            <tr>
                <td class="caption"><?php echo __("Date Start") ?></td>
                <td>:&nbsp;</td>
                <td class="value">
                    <span id="date_start">-</span>
                </td>
            </tr>
            <tr>
                <td class="caption"><?php echo __("Date End") ?></td>
                <td>:&nbsp;</td>
                <td class="value">
                    <span id="date_end">-</span>
                </td>
            </tr>
        </table>
    </form>

    <br>
    <button type="button" onclick="$.unblockUI();"><?php echo __("Close") ?></button>
    <br><br>

</div>

<script type='text/javascript' src='/css/maxim/comment-reply.js'></script>
<script type='text/javascript' src='/css/maxim/preloader.js'></script>
<script type='text/javascript' src='/css/maxim/jquery.nivo.slider.js'></script>
<script type='text/javascript' src='/css/maxim/bottomfix.js'></script>
<script type='text/javascript' src='/css/maxim/jquery.quicksand.js'></script>
<script type='text/javascript' src='/css/maxim/farbtastic.js'></script>

<script type="text/javascript">
    $(function() {
        /*
         *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
         */
        $('.fancybox-thumbs').fancybox({
            prevEffect : 'none',
            nextEffect : 'none',

            closeBtn  : false,
            arrows    : false,
            nextClick : true,
            "autoScale": false,
            // if fancybox 2.x
            fitToView: false,
            helpers : {
                thumbs : {
                    width  : 50,
                    height : 50
                }
            }
        });
    });
</script>

<script type="text/javascript" src="/template/inspinia/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="/template/inspinia/js/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" src="/template/inspinia/js/plugins/fullcalendar/moment.min.js"></script>
<script type="text/javascript" src="/template/inspinia/js/plugins/fullcalendar/fullcalendar.min.js"></script>

<script type="text/javascript">
    var j = $.noConflict();

    j(function(j) {
        // Init calendar.
        j("#calendar").fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: {
                url: "<?php echo url_for("home/eventCalendar") ?>",
                type: 'POST',
                data: {
                    act: "load"
                },
                error: function () {
                }
            },
            eventClick: function(calEvent, jsEvent, view) {
                showEvent(calEvent);
            }
        });
    });

    function showEvent(event) {
        var form = $("#detailForm");

        $("#event_title", form).html(event.title);
        $("#event_detail", form).html(event.detail);
        $("#date_start", form).html(event.start.format("YYYY-MM-DD HH:mm"));
        $("#date_end", form).html(event.end.format("YYYY-MM-DD HH:mm"));
        $("#all_day", form).prop("checked", (event.all_day == "Y"));

        $.blockUI({
            message: $("#eventDetailsPopup"),
            css: {
                border: 'none',
                padding: '5px',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                'border-radius': '10px',
                opacity: .9
            }
        })

        $(".blockPage").css("z-index", 1011);
        $(".blockPage").css("cursor", "default");

        $(".blockOverlay").css("z-index", 1010);
        $(".blockOverlay").css("cursor", "default");
        $('.blockOverlay').attr('title', '[ Click anywhere to dismiss ]').click($.unblockUI);
    }

    $("#all_day").click(function() {
        return false;
    });
</script>

</body>
</html>