<?php

if (!defined("ABSPATH")) {
    exit;
}

$captchaSetupOption = get_option("tzwsc_captchaSetup");
if (!empty($captchaSetupOption)) {
    $captchaSetup = unserialize($captchaSetupOption);
}

$enableCaptcha = get_option("tzwsc_enableCaptchaFor");
if (!empty($enableCaptcha)) {
    $enableCaptchaFor = unserialize($enableCaptcha);
}

if (!empty($enableCaptcha) && in_array("wplf", $enableCaptchaFor)) {
    add_action("login_form", "tzwsc_loginFormCaptcha");
    add_filter("authenticate", "tzwsc_loginFormCaptchaErrors", 21, 1);
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

if (!empty($enableCaptcha) && in_array("wpfpf", $enableCaptchaFor)) {
    add_action("lostpassword_form", "tzwsc_loginFormCaptcha");
    add_action("allow_password_reset", "tzwsc_forgetPasswordError", 1);
}

if (!empty($enableCaptcha) && in_array("wpcf", $enableCaptchaFor)) {
    add_action("comment_form_after_fields", "tzwsc_loginFormCaptcha");
    add_action("pre_comment_on_post", "tzwsc_commentFormError");
}

function tzwsc_commentFormError() {
    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);

        if ((!isset($_REQUEST["numericCaptchaField"]) || "" == $_REQUEST["numericCaptchaField"])) {
            wp_die($errorMessages["emptyCaptcha"]);
        } elseif (isset($_REQUEST["numericCaptchaResult"]) && isset($_REQUEST["numericCaptchaField"])) {

            if (0 === strcasecmp(trim(base64_decode($_REQUEST["numericCaptchaResult"])), $_REQUEST["numericCaptchaField"])) {
                return $user;
            } else {
                $_SESSION["tzwsc_login_form"] = false;
                if ("" == $_REQUEST["numericCaptchaField"]) {
                    wp_die($errorMessages["emptyCaptcha"]);
                } else {
                    wp_die($errorMessages["captchaMismatch"]);
                }
            }
        }
    }
}

function tzwsc_loginFormCaptcha() {
    if (isset($_SESSION["tzwsc_login_form"])) {
        unset($_SESSION["tzwsc_login_form"]);
    }
?>
<p>
<?php
    tzwsc_loginFormMathCaptcha();
    ?>
</p>
    <?php
}

function tzwsc_loginFormCaptchaErrors($user = NULL) {
    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);
    }
    if (!isset($_POST["wp-submit"])) {
        return $user;
    }

    if (!function_exists("is_plugin_active")) {
        require_once( ABSPATH . "wp-admin/includes/plugin.php" );
    }

    if (isset($_SESSION["tzwsc_login_form"]) && true === $_SESSION["tzwsc_login_form"]) {
        return $user;
    }

    if ((!isset($_REQUEST["numericCaptchaField"]) || "" == $_REQUEST["numericCaptchaField"])) {
        $error = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
        wp_clear_auth_cookie();
        return $error;
    } elseif (isset($_REQUEST["numericCaptchaResult"]) && isset($_REQUEST["numericCaptchaField"])) {

        if (0 === strcasecmp(trim(base64_decode($_REQUEST["numericCaptchaResult"])), $_REQUEST["numericCaptchaField"])) {
            return $user;
        } else {
            $_SESSION["tzwsc_login_form"] = false;
            if ("" == $_REQUEST["numericCaptchaField"]) {
                $error = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
                wp_clear_auth_cookie();
                return $error;
            } else {
                $error = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["captchaMismatch"]);
                wp_clear_auth_cookie();
                return $error;
            }
            return $error;
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

function tzwsc_registrationFormError($user, $email, $errors) {

    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);

        if ((!isset($_REQUEST["numericCaptchaField"]) || "" == $_REQUEST["numericCaptchaField"])) {
            $errors->add("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
        } elseif (isset($_REQUEST["numericCaptchaResult"]) && isset($_REQUEST["numericCaptchaField"])) {

            if (0 === strcasecmp(trim(base64_decode($_REQUEST["numericCaptchaResult"])), $_REQUEST["numericCaptchaField"])) {
                return $user;
            } else {
                $_SESSION["tzwsc_login_form"] = false;
                if ("" == $_REQUEST["numericCaptchaField"]) {
                    $errors->add("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
                } else {
                    $errors->add("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["captchaMismatch"]);
                }
            }
        }
    }
}

function tzwsc_forgetPasswordError($user) {
    $errorMessagesValue = get_option("tzwsc_errorMessages");
    if (!empty($errorMessagesValue)) {
        $errorMessages = unserialize($errorMessagesValue);

        if ((!isset($_REQUEST["numericCaptchaField"]) || "" == $_REQUEST["numericCaptchaField"])) {
            $errors = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
        } elseif (isset($_REQUEST["numericCaptchaResult"]) && isset($_REQUEST["numericCaptchaField"])) {

            if (0 === strcasecmp(trim(base64_decode($_REQUEST["numericCaptchaResult"])), $_REQUEST["numericCaptchaField"])) {
                return $user;
            } else {
                $_SESSION["tzwsc_login_form"] = false;
                if ("" == $_REQUEST["numericCaptchaField"]) {
                    $errors = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["emptyCaptcha"]);
                } else {
                    $errors = new WP_Error("captcha_wrong", "<strong>ERROR</strong>: " . $errorMessages["captchaMismatch"]);
                }
            }
        }
    }
    return $errors;
}

function tzwsc_loginFormMathCaptcha() {

    $captchaSetupOption = get_option("tzwsc_captchaSetup");
    if (!empty($captchaSetupOption)) {
        $captchaSetup = unserialize($captchaSetupOption);
    }
    $numericCaptchaOperaton = array();
    if ($captchaSetup["arithmeticAddition"] == 1) {
        $numericCaptchaOperaton[] = "&#43;";
    }
    if ($captchaSetup["arithmeticSubtraction"] == 1) {
        $numericCaptchaOperaton[] = "&minus;";
    }
    if ($captchaSetup["arithmeticMultiplication"] == 1) {
        $numericCaptchaOperaton[] = "&times;";
    }
    if ($captchaSetup["arithmeticDivision"] == 1) {
        $numericCaptchaOperaton[] = "&divide;";
    }

    $currentOpertation = rand(0, count($numericCaptchaOperaton) - 1);

    $generateNumber = array();
    $generateNumber[0] = rand(1, 9);
    $generateNumber[1] = rand(1, 9);

    switch ($numericCaptchaOperaton[$currentOpertation]) {
        case "&#43;":
            $generateNumber[2] = $generateNumber[0] + $generateNumber[1];
            break;
        case "&minus;":
            if ($generateNumber[0] < $generateNumber[1]) {
                $number = $generateNumber[0];
                $generateNumber[0] = $generateNumber[1];
                $generateNumber[1] = $number;
            }
            $generateNumber[2] = $generateNumber[0] - $generateNumber[1];
            break;
        case "&times;":
            $generateNumber[2] = $generateNumber[0] * $generateNumber[1];
            break;
        case "&divide;":
            $generateNumber[2] = $generateNumber[0] / $generateNumber[1];
            break;
    }

    $numberOrWord = array();
    if ($captchaSetup["arithmeticNumbers"] == 1) {
        $numberOrWord[] = "numbers";
    }

    $captchaStrings = rand(0, 2);
    $captchaFormat = array();

    $captchaCount = count($numberOrWord) - 1;
    for ($char = 0; $char < 3; $char ++) {
        $captchaFormat[] = $captchaStrings == $char ? "input" : $numberOrWord[mt_rand(0, $captchaCount)];
    }
    $numCaptcha = array();

    foreach ($captchaFormat as $key => $format) {
        switch ($format) {
            case "input":
                $numCaptcha[] = '<input style="display:inline;font-size: 12px;width: 40px;" id="numericCaptchaField" name="numericCaptchaField" type="text" autocomplete="off" value="" maxlength="2" size="2" />';
                break;
            case "number":
            default:
                $numCaptcha[] = $generateNumber[$key];
                break;
        }
    }
    $captchaTitle = $captchaSetup["captchaTitle"] != "" ? $captchaSetup["captchaTitle"] : "";
    $checkCaptcha = '<span><label>';
    $checkCaptcha .= '<label for="captcha">' . $captchaTitle . '<br>';
    $checkCaptcha .= '<span> ' . $numCaptcha[0] . ' </span>';
    $checkCaptcha .= '<span> ' . $numericCaptchaOperaton[$currentOpertation] . ' </span>';
    $checkCaptcha .= '<span> ' . $numCaptcha[1] . ' </span>';
    $checkCaptcha .= '<span>&nbsp;=&nbsp;</span>';
    $checkCaptcha .= '<span> ' . $numCaptcha[2] . ' </span>';
    $checkCaptcha .= '<input type="hidden" id="numericCaptchaResult" name="numericCaptchaResult" value="' . base64_encode($generateNumber[$captchaStrings]) . '" />';
    $checkCaptcha .= '</label></span>';

    echo $checkCaptcha;
}


