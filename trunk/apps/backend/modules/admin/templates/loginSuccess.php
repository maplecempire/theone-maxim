<?php include('scripts_backend.php'); ?>
<link rel='stylesheet' href='/css/admin.css' type='text/css'/>
<link rel='stylesheet' href='/css/main2.css' type='text/css'/>

<script>
$(function() {
    var test = $("#loginForm").validate({
        rules: {
            <?php if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_PROD) { ?>
            "modlgn_username": {
                required: true
            },
            "modlgn_passwd": {
                required: true
            }
            <?php } ?>
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $("#modlgn_username").focus();
});
</script>

<div id="ap-login">
    <div id="content-box">
        <div class="padding" style="padding: 100px">
            <div class="login" id="element-box">
                <div>
                    <p>
                        <h3><b>MAXIM TRADER ADMINISTRATOR LOGIN PAGE</b></h3>
                    </p>
                    <div class="panel" id="section-box">
                        <div class="jpane-slider">
                                <?php echo form_tag('admin/doLogin', 'id=loginForm') ?>
                                <p id="form-login-username">
                                    <label for="modlgn_username">Username</label>
                                    <input type="text" size="15" class="inputbox"
                                           id="modlgn_username" name="modlgn_username">
                                </p>

                                <p id="form-login-password">
                                    <label for="modlgn_passwd">Password</label>
                                    <input type="password" size="15" class="inputbox"
                                           id="modlgn_passwd" name="modlgn_passwd">
                                </p>

                                <p>
                                    <?php if ($sf_flash->has('errorMsg')): ?>
                                        <span class="error-font"><?php echo $sf_flash->get('errorMsg') ?></span>
                                    <?php endif; ?>
                                </p>

                                <div class="button_holder">
                                    <div class="button1">
                                        <div class="next">
                                            <input type="submit" name="Button1" value="<?php echo __('Login') ?>" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="clr"></div>
                        </div>

                    </div>

                    <p class="home-page">
                        <a href="/">Return to site Home Page</a>
                    </p>

                    <div class="clr"></div>
                </div>
                <div id="ap-login-logo">
                    <span id="ap-login-icon"></span>
                </div>
            </div>
            <noscript>
                Warning! JavaScript must be enabled for proper operation of the Administrator back-end.
            </noscript>
            <div class="clr"></div>
        </div>
    </div>
</div>