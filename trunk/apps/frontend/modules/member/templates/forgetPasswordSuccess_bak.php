<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
    <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="-1">

<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS Styles -->
<link rel="stylesheet" href="/css/style.css">
<style type="text/css">
h2 {
    padding: 5;
    margin: 0;
}

#footer {
    background: none repeat scroll 0 0 #333333;
    height: 50px;
    margin: 10px auto 0;
    width: 980px;
    bottom: 0px;
    position: fixed;
}
</style>
<script>
$(function() {
    $("#lang").change(function() {
        $("#langForm").submit();
    });

    $("#registerForm").validate({
        messages : {

        },
        rules : {
            "username" : {
                required : true
            },
            "email" : {
                required : true
                , email: true
            }
        },
        submitHandler: function(form) {
            form.submit();
        },
        success: function(label) {
            //label.addClass("valid").text("Valid captcha!")
        }
    });
});

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
</script>
</head>
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request.  Please be patient.</h3>
</div>
<div id="wrapp_v2">
<div class="wrapper">
<!--this is header--><!-- #BeginLibraryItem "/Library/header.lbi" -->
<div id="header">
    <div id="logo"><a href="/home/login"><img src="/images/ofxglobal/logo.jpg"/></a></div>
    <span class="titleSpan"><strong>Serving Traders in <em class="titleEm">205</em> Countries Across <em
            class="titleEm">6</em> Continents</strong></span>

    <div class="clear"></div>
</div>
<!-- #EndLibraryItem --><!--header end here-->
<div class="clear"></div>
<!--- this is content--->
<div class="content">

<!--- aside end --->
<!--- content --->
<div class="areaContent" style="width : 98%">
<div class="clear"></div>
<div class="resultsWrap">

<form action="/member/forgetPassword" id="registerForm" method="post">
<table cellspacing="0" cellpadding="0" width="650px">
    <tr>
        <td width="160px" class="caption">
            <strong><?php echo __('User Name'); ?></strong>
        </td>
        <td class="value">
            <input name="username" type="text" id="username" class="login_t73" value="<?php echo $username ?>"/>
        </td>
    </tr>
    <tr>
        <td width="160px" class="caption">
            <strong><?php echo __('Email'); ?></strong>
        </td>
        <td class="value">
            <input name="email" type="text" id="email" class="login_t73" value="<?php echo $email ?>"/>
        </td>
    </tr>
</table>

    <?php if ($sf_flash->has('errorMsg')) { ?>
        <div class="notification error">
            <p style="color: #ff0000;"><strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
        </div>
    <?php } elseif ($sf_flash->has('successMsg')) {  ?>
        <div class="notification success">
            <p style="color: #0066cc;"><strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
        </div>
    <?php } ?>
    <br>
    <button type="submit" class="right redbutton" id="btnRegister"><?php echo __('Send') ?></button>


</form>

            <div class="clear"></
<!---form end --->
</div>
</div>
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
        <address>
            Copyright © Maxim Trader, Privacy Statement | Terms and Conditions.
        </address>
    </div>
    <div class="clear"></div>
</div>
<!--footer is end here-->
<div class="clear"></div>
</div>
</body>


</html>