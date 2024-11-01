<?php
if (!defined("ABSPATH")) {
    exit;
}

$enableCaptcha = get_option("tzwsc_enableCaptchaFor");
if (!empty($enableCaptcha)) {
    $enableCaptchaFor = unserialize($enableCaptcha);
}
if (!empty($enableCaptcha) && in_array("wplf", $enableCaptchaFor)) {
    add_action("login_form", "tzwsc_loginFormCaptcha");
    add_filter("authenticate", "tzwsc_loginFormCaptchaErrors", 21, 1);
}

function tzwsc_loginFormCaptcha() {
    $captchaSetupValue = get_option("tzwsc_captchaSetup");
    if (!empty($captchaSetupValue)) {
        $captchaSetup = unserialize($captchaSetupValue);
    }
    ?>
    <p>
        <label for="captcha"><?php echo $captchaSetup["captchaTitle"] != "" ? $captchaSetup["captchaTitle"] : ""; ?><br>
        <input type="text" name="captchaField" id="captchaField" aria-describedby="login_error" class="input" value="" size="20"></label>
        <img src="<?php echo admin_url("admin-ajax.php") . "?textCaptcha=" . rand(111, 99999); ?>" id="textCaptchaImage"  />
        <img onclick="tzwsc_captchaRefresh();"  style="cursor:pointer;" alt="Refresh" height="16" width="16" src="<?php echo plugins_url("/assets/images/refresh.png", (dirname(__FILE__))) ?>"/>

    </p>
    <script type="text/javascript">
        function tzwsc_captchaRefresh()
        {
            var newNumber = Math.floor((Math.random() * 99999) + 1);
            jQuery("#textCaptchaImage").attr("src", "<?php echo admin_url("admin-ajax.php") . "?textCaptcha="; ?>" + newNumber);
            return true;
        }
    </script>
    <?php
}

function tzwsc_loginFormCaptchaErrors($user = NULL) {
    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);
    }
    $errorMessage = tzwsc_loginFormCaptchaErrorsType();
    if ($errorMessage) {
        if ($errorMessage == "empty") {
            $error = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
        } else if ($errorMessage == "invalid") {
            $error = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["captchaMismatch"]);
        }
        return $error;
    } elseif (isset($_REQUEST["captchaField"]) && isset($_SESSION["textCaptcha"])) {
        $captchaField = trim(esc_attr($_REQUEST["captchaField"]));
        if ($captchaField === $_SESSION["textCaptcha"]) {
            return $user;
        }
    } else {
        if (isset($_REQUEST["log"]) && isset($_REQUEST["pwd"])) {
            $error = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
            return $error;
        } else {
            return $user;
        }
    }
}

if (!empty($enableCaptcha) && in_array("wprf", $enableCaptchaFor)) {
    if (is_multisite()) {
        add_action("signup_extra_fields", "tzwsc_loginFormCaptcha");
        add_action("wpmu_signup_user_notification", "tzwsc_registrationFormError", 10, 3);
    } else {
        add_action("register_form", "tzwsc_loginFormCaptcha");
        add_action("register_post", "tzwsc_registrationFormError", 10, 3);
    }
}

function tzwsc_registrationFormError($user, $email, $errors) {
    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);
    }
    $errorMessage = tzwsc_loginFormCaptchaErrorsType();
    if ($errorMessage) {
        if (is_multisite()) {
            if ($errorMessage == "empty") {
                wp_die("<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
            } else if ($errorMessage == "invalid") {
                wp_die("<strong>ERROR</strong>: " . $errorMessages["captchaMismatch"]);
            }
        } else {
            if ($errorMessage == "empty") {
                $errors->add("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
            } else if ($errorMessage == "invalid") {
                $errors->add("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["captchaMismatch"]);
            }
        }
    }
}

if (!empty($enableCaptcha) && in_array("wpfpf", $enableCaptchaFor)) {
    add_action("lostpassword_form", "tzwsc_loginFormCaptcha");
    add_action("allow_password_reset", "tzwsc_forgetPasswordError", 1);
}

function tzwsc_forgetPasswordError($user) {
    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);
    }
    $errorMessage = tzwsc_loginFormCaptchaErrorsType();
    if ($errorMessage) {
        if ($errorMessage == "empty") {
            $errors = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
        } else if ($errorMessage == "invalid") {
            $errors = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["captchaMismatch"]);
        }
        return $errors;
    }
    return $user;
}

if (!empty($enableCaptcha) && in_array("wpcf", $enableCaptchaFor)) {
    add_action("comment_form_after_fields", "tzwsc_loginFormCaptcha");
    add_action("pre_comment_on_post", "tzwsc_commentFormError");
}

function tzwsc_commentFormError() {
    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);
    }
    $errorMessage = tzwsc_loginFormCaptchaErrorsType();
    if ($errorMessage) {
        if ($errorMessage == "empty") {
            wp_die($errorMessages["emptyCaptcha"]);
        } else if ($errorMessage == "invalid") {
            wp_die($errorMessages["captchaMismatch"]);
        }
    } else {
        return;
    }
}

function tzwsc_loginFormCaptchaErrorsType($errors = NULL) {
    if (isset($_REQUEST["captchaField"])) {
        $captchaField = trim(esc_attr($_REQUEST["captchaField"]));
        if (strlen($captchaField) <= 0) {
            $errors = "empty";
        } else {
            if (isset($_SESSION["textCaptcha"])) {
                if ($captchaField != $_SESSION["textCaptcha"]) {
                    $errors = "invalid";
                } else {
                    
                }
            }
        }
    }
    return $errors;
}
