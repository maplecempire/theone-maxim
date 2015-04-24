<?php use_helper('I18N') ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Maxim Partner</title>

    <link href="/template/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/template/inspinia/css/animate.css" rel="stylesheet">
    <link href="/template/inspinia/css/style.css" rel="stylesheet">

    <style type="text/css">
        .recaptcha_input_area input[type="text"] {
            min-height: 10px !important;
        }
    </style>
</head>
<body class="gray-bg">

<noscript>
    <!-- display message if java is turned off -->
    <div style="width: 100%; background-color: #ff0000; color: #fff; text-align: center; padding: 3px 0px;">
        Please turn on javascript in your browser for the maximum user experience!
    </div>
    <br/>
</noscript>

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div>
            <img alt="Maxim Partner" src="/images/logo.png" style="width: 220px;">
        </div>

        <h3><?php echo __('Login to your account') ?></h3>

        <?php include_component('component', 'alert', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>

        <form class="m-t" role="form" id="loginForm" name="loginForm" action="/mylexin/doLogin" method="post">
            <input type="hidden" name="q" value="<?php echo $doAction;?>">
            <input type="hidden" name="a" value="<?php echo $token;?>">
            <div class="form-group">
                <input type="text" id="username" name="username" class="form-control" placeholder="<?php echo __("User Name") ?>" required="" size="100">
            </div>

            <div class="form-group">
                <input type="password" id="userpassword" name="userpassword" class="form-control" placeholder="<?php echo __("Password") ?>" required="" size="100">
            </div>

            <?php
                /*echo "<p>";
                require_once('recaptchalib.php');
                $publickey = "6LfhJtYSAAAAAAMifW42AIEE0qnNgOEFIDB0sqwt"; // you got this from the signup page
                echo recaptcha_get_html($publickey);
                echo "</p>";*/
             ?>

            <button type="submit" id="submitLink" name="Login" class="btn btn-primary block full-width m-b"><?php echo __("Sign In") ?></button>
        </form>

        <p class="m-t"> <small>&copy; 2013 Maxim Partner | All rights reserved.</small> </p>
    </div>
</div>

<!-- javascript -->
<script type="text/javascript" src="/template/inspinia/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="/template/inspinia/js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="/template/inspinia/js/plugins/validate/jquery.validate.min.js"></script>

<script type="text/javascript">
    $(function () {
        $("#username, #userpassword").keydown(function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) { //Enter keycode
                $("#submitLink").trigger("click");
            }
        });

        $("#submitLink").click(function () {
            $("#loginForm").submit();
        });

        $("#loginForm").validate({
            rules: {
                <?php if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_PROD) { ?>
                username: {
                    required: true
                },
                userpassword: {
                    required: true
                }
                <?php } ?>
            },
            messages: {},
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>
<!-- javascript -->

</body>
</html>