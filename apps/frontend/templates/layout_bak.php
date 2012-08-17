<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>

<?php include('scripts.php'); date_default_timezone_set('America/New_York'); ?>
<!-- Google WebFonts -->
<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>

<style type="text/css">
.hiddenPic {
    display:none;
}
body {
    /*font: 12px "Arial";*/
    /*color: #e6e6e6;*/
    background: url("/images/base-bg2.png") repeat-x scroll center top #FFFFFF;
    color: #363636;
    font: 11px/1.5em Arial,Helvetica,sans-serif;
    letter-spacing: 0.03em;
    margin: 0;
    padding: 0;
}
/** {
    margin: 0;
    padding: 0;
}*/
label {
    font-weight: bold;
}
#header {
    height: 110px;
    overflow: hidden;
    position: relative;
}
#page, .middle {
    margin: 0 auto;
    width: 1000px;
}
#top-nav h3.title {
    color: #969696;
    cursor: pointer;
    float: left;
    margin: 6px 0 0;
}
#top-nav, #top-nav a, #top-nav h3 {
    font-size: 11px;
}
#top-nav, #top-nav a, #top-nav h3 {
    font-size: 10px !important;
    letter-spacing: 0 !important;
}
#top-nav {
    background: url("/images/top-nav-bg.gif") repeat-x scroll 0 0 #181818;
    height: 26px;
    position: relative;
    text-transform: uppercase;
    top: 0;
    width: 100%;
}
#top-nav, #top-nav a, #top-nav h3 {
    font-size: 11px;
}
a:link {
    text-decoration: none;
    font: 12px "Arial";
    font-weight: bold;
}
.ui-widget {
    font-family: Segoe UI,Arial,sans-serif;
    font-size: 0.9em;
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
.topMenu {
    background: none repeat scroll 0 0 #D19405;
    color: #f9c81e;
    padding: 5px 10px 5px 30px;
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
.ui-button { margin-left: -1px; }
.ui-button-icon-only .ui-button-text { padding: 0.35em; }
.ui-autocomplete-input { margin: 0; padding: 0.42em 0 0.47em 0.45em; }
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

</style>

<script type="text/javascript">
var infoStyle= "<div style='margin-bottom: 20px; padding: 0 .7em;' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span><strong id='_msg'></strong></p></div>";
var errorStyle= "<div style='padding: 0 .7em;' class='ui-state-error ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-alert'></span><strong id='_msg'></strong></p></div>";

$(function() {
    $("button, input:submit, input:button").button();
    $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
            .find(".portlet-header")
            .addClass("ui-widget-header ui-corner-all")
            .prepend("<a href='#' class='ui-dialog-titlebar-close ui-corner-all' role='button'><span class='ui-icon ui-icon-minusthick' style='padding-right: 3px'></span></a>")
            .end()
            .find(".portlet-content");

    $(".portlet-header .ui-icon").click(function() {
        $(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
        $(this).parents(".portlet:first").find(".portlet-content").toggle("fast");
    });
    $("#menu").accordion({
        active : <?php echo $sf_user->getAttribute(Globals::SESSION_MENU_IDX, 0) ?>,
        autoHeight:false,
        change: function(event, ui) {
            $.ajax({
                type : 'POST',
                url : "/home/updateMenuIdx",
                dataType : 'json',
                cache: false,
                data: {
                    menuIdx : $("#menu").accordion("option", "active")
                },
                success : function(data) {
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert("Your login attempt was not successful. Please try again.");
                }
            });
        }
    });

    /*setInterval(function() {
        refreshGoldSellPrice();
    }, <?php //echo Globals::REFRESH_GOLD_INTEVAL; ?>);
    refreshGoldSellPrice();*/
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
    alertPanel += msgs +"</p></div>";
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
    $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
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
    errorPanel += msgs +"</p></div>";
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
    $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
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
function _errorMsg(msg){
    $("#dgMsg").html(errorStyle);
    $("#_msg").html(msg);
    $("#dgMsg").show(500);
}
function _infoMsg(msg){
    $("#dgMsg").html(infoStyle);
    $("#_msg").html(msg);
    $("#dgMsg").show(500);
}
function _clearMsg(){
    $("#dgMsg").hide(500);
}
function refreshGoldSellPrice(){
    $.ajax({
        type : 'POST',
        url : "/gold/fetchGoldPrice",
        dataType : 'json',
        cache: false,
        data: {
        },
        success : function(data) {
            $("#layoutSpanGoldPrice").html(data.goldSell);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Your login attempt was not successful. Please try again.");
            window.location = "/home/login";
        }
    });
}
function openCertificateWindow(){
    var params  = 'width=891';
    params += ', height=637';
    params += ', top=0, left=0';
    //params += ', fullscreen=yes';
    //params += ', scrollbars=yes';

    newwin = window.open("/member/certificate",'cert', params);
    if (window.focus)
    {
        newwin.focus();
    }
}
</script>

<script type="text/javascript">

var currenttime = '<? print date("F d, Y H:i:s", time())?>' //PHP method of getting server date

var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)

function padlength(what){
var output=(what.toString().length==1)? "0"+what : what
return output
}

</script>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<img src="/images/loading.gif" class="hiddenPic">
<div id="top-nav">
    <div class="middle">
        <div class="block block-custom_mod block-top_bar block-id-132 clearfix  odd" id="block-custom_mod-0">
            <div class="block-inner">
                <h3 title="" class="title block-title">Choose your language &nbsp;&nbsp;<a href="<?php echo url_for("/home/language?lang=en")?>" style="color: #ffffff;">English</a> | <a href="<?php echo url_for("/home/language?lang=cn")?>" style="color: #ffffff;">中文</a> </h3>
            </div>
            <!-- /block-inner -->
            <div class="block-inner" style="float: right">
                <h3 title="" class="title block-title"><a href="<?php echo url_for("/home/logout")?>" style="color: #ffffff;"><?php echo __('Logout'); ?></a> </h3>
            </div>
        </div>
        <!-- /block -->
    </div>
</div>
<div id="waiting" style="display: none; position: fixed; right: 10px; top: 10px; z-index: 999;">
    <img src="/images/common/indicator.gif" title="Loader" alt="Loader" />
</div>
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request.  Please be patient.</h3>
</div>
<?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
    <tr>
        <td valign="top" width="250">
            <div id="menu">
                <h5><a href="#"><?php echo __('Account Summary'); ?></a></h5>
                <div>

                    <a href="/member/summary" title="Account Summary">

                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('Summary'); ?></a><br/>
                </div>
                <h3><a href="#"><?php echo __('Personal Profile'); ?></a></h3>
                <div>
                    <a href="/member/viewProfile" title="<?php echo __('View Profile'); ?>">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('View Profile'); ?></a><br/>

                    <a href="/member/loginPassword" title="Change Login Password">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('Change Password'); ?></a><br/>

                    <a href="/member/transactionPassword" title="Change Security Password">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('Change Trx Password'); ?></a><br/>

                </div>

                <h3><a href="#"><?php echo __('Finance'); ?></a></h3>
                <div>
                    <a href="/member/transferEcash" title="Summary">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('E-Cash Transfer'); ?></a><br/>

                    <a href="/member/ecashLog" title="Summary">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('E-Cash Log'); ?></a><br/>

                    <a href="/member/bonusDetails" title="Summary">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('Bonus Details'); ?></a><br/>

                </div>
                <h3><a href="#"><?php echo __('Bulletin'); ?></a></h3>
                <div>

                    <a href="/member/announcement" title="Summary">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('Announcements'); ?></a><br/>
                </div>
                <h3><a href="#"><?php echo __('Genealogy'); ?></a></h3>
                <div>
                    <a href="/member/sponsorTree" title="Summary">
                    <img src="/images/common/mycomputer.png" style="padding-bottom: 4px; vertical-align: middle;" border="0">
                    &nbsp;<?php echo __('Genealogy Tree'); ?></a><br/>

                </div>
            </div>
        </td>
        <td valign="top">
            <?php echo $sf_data->getRaw('sf_content') ?>
        </td>
    </tr>
</table>

</body>
</html>
