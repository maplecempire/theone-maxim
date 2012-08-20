<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<head>
<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS Styles -->
<link rel="stylesheet" href="/css/style.css">

<script>
    $(function() {
        $('BODY').bgStretcher({
            images: ['/images/background/main-bg-011.jpg', '/images/background/main-bg-022.jpg', '/images/background/main-bg-031.jpg', '/images/background/main-bg-041.jpg'],
            imageWidth: 1024,
            imageHeight: 768,
            slideDirection: 'N',
            nextSlideDelay: 5500,
            transitionEffect: 'fade',
            anchoring: 'left center',
            anchoringImg: 'left center'
        });

        $("#lang").change(function() {
            $("#doAction").val("lang");
            $("#loginForm").submit();
        });

        $("#submitLink").click(function(event) {
            $("#loginForm").submit();
        });

        $("#username, #userpassword").keydown(function(e){
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) { //Enter keycode
                $("#submitLink").trigger("click");
            }
        });
        $("#loginForm").validate({
            rules: {

            },
            messages: {
            },
            submitHandler: function(form) {
                if ("" == $("#doAction").val()) {
                <?php if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_PROD) { ?>
                    if ($.trim($("#username").val()) == "") {
                        alert("Trader ID cannot be blank.");
                        $("#username").focus();
                        return false;
                    }
                    if ($.trim($("#userpassword").val()) == "") {
                        alert("Password cannot be blank.");
                        $("#userpassword").focus();
                        return false;
                    }
                    <?php } ?>
                }

                form.submit();
            }
        });
    });
</script>
</head>
<body class="login">
<div class="loginWrap">
<div class="loginFormWrap">
    <form action="/home/doLogin" id="loginForm" method="post">
        <input type="hidden" name="doAction" id="doAction" value="">

        <div class="notification error">
            <p style="color: red;"><strong>&nbsp;<?php if ($sf_flash->has('errorMsg')) { echo $sf_flash->get('errorMsg'); } ?></strong></p>
        </div>

        <label><?php echo __('User Name') ?></label>
        <input type="text" name="username" id="username" class="large" value="<?php echo $username; ?>">

        <div class="clear"></div>
        <label><?php echo __('Password') ?></label>
        <input type="password" name="userpassword" id="userpassword" class="large"
               value="<?php echo $userpassword; ?>">

        <!--<div class="clear"></div>
        <label><?php /*echo __('Language') */?></label>
        <select name="lang" id="lang">
            <option value="en"
                    <?php
/*                        if ($sf_user->getCulture() == "en")
                echo 'selected'
                    */?>
                    >English
            </option>
            <option value="cn"
                    <?php
/*                        if ($sf_user->getCulture() == "cn")
                echo 'selected'
                    */?>
                    >中文
            </option>
        </select>-->

        <div class="clear"></div>
    <div class="clear"></div>
</div>

<div class="btnWrap" id="btnWrap">
    <ul class="option">
        <li><a href="/member/register"><?php echo __('Register') ?></a></li>
        <li><a href="/member/forgetPassword"><?php echo __('Forget Password?') ?></a></li>
    </ul>
    <div class="btn">
        <?php
            if ($appSetting->getSettingValue() == '0') {
            ?>
            <a href="#" id="submitLink"><img src="/images/ofxglobal/login_btn.jpg" /></a>
<!--                <button type="submit"><img src="/images/ofxglobal/login_btn.jpg" /></button>-->
        <?php } ?>
        <!--            <a href="profile.html"><img src="images/login_btn.jpg"></a>-->
    </div>
    <div class="clear"></div>
</div>
</form>
<div class="clear"></div>
</div>

</body>
</html>

<script type="text/javascript">
$(function() {
    $("#dgAnnouncement").dialog("destroy");
    $("#dgAnnouncement").dialog({
        autoOpen : false,
        modal : true,
        resizable : false,
        closeOnEscape: false,
        hide: 'clip',
        show: 'slide',
        width: 650,
        open: function(event, ui) {
            $(".ui-dialog-titlebar-close").hide();
        },
        close: function() {

        }
    });
    <?php
    if ($appSetting->getSettingValue() == '1') {
        echo "$('#dgAnnouncement').dialog('open');";
    }
    ?>
})
</script>
<div id="dgAnnouncement" title="<?php echo __('Announcement') ?>" style="display:none;">
    <p>
        <span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 100px 0;"></span>
        <strong>OFX Global Application server maintenance</strong>
    </p>
    <p>Announcement:Please be informed that start from <b>Friday 27/07/2012</b> our website <a
            href="#">www.ofxglobal.com</a> will be closed for server upgrading until further
        notice.
    </p>
    <p>Please login to our company's official website <a href="http://www.ofxltd.com" style="color: #0063DC;">WWW.OFXLTD.COM</a>. All
        correspondences will only be through this website. Sorry for the inconvenience caused.

    <br><br>
    <b>From The Management</b>
    </p>
</div>