<?php
if (!defined("ABSPATH")) {
    exit;
}
if (isset($_POST["submit"])) {
    $enableCaptchaFor = array();
    $enableCaptcha = $_POST['enableCaptcha'];
    foreach ($enableCaptcha as $value) {
        array_push($enableCaptchaFor, $value);
    }
    update_option("tzwsc_enableCaptchaFor", serialize($enableCaptchaFor));
}
$enableCaptchaForOption = get_option("tzwsc_enableCaptchaFor");
if (!empty($enableCaptchaForOption)) {
    $enableCaptchaFor = unserialize($enableCaptchaForOption);
}
?>
<div class="wrap">
    <h1><?php _e("Enable Captcha", TZWSC_TRANSLATIONS_STRINGS); ?></h1>
    <div class="update-nag bsf-update-nag"><a target="_blank" href="http://techezee.com/pricing/">Go for Premimum Editions</a></div>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php _e("Enable Captcha For", TZWSC_TRANSLATIONS_STRINGS); ?></th>
                    <td>
                        <p>WordPress</p>
                        <br>
                        <fieldset>
                            <label for="wpLoginForm">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wplf" <?php echo !empty($enableCaptchaForOption) && in_array("wplf", $enableCaptchaFor) ? "checked='checked'" : "" ?>  type="checkbox">
                                <?php _e("Login Form", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                            <label for="wpRegistrationForm">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wprf" <?php echo !empty($enableCaptchaForOption) && in_array("wprf", $enableCaptchaFor) ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Registration Form", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                            <label for="wpCommentsForm">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wpcf" <?php echo !empty($enableCaptchaForOption) && in_array("wpcf", $enableCaptchaFor) ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Comments Form", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                            <label for="wpForgetPassword">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wpfpf" <?php echo !empty($enableCaptchaForOption) && in_array("wpfpf", $enableCaptchaFor) ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Forget Password Form", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                        </fieldset>
                        <br>
                        <p>WooCommerce</p>
			<br>
                        <fieldset>
                            <label for="wcLoginForm">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wclf" disabled="disabled" type="checkbox">
                                <?php _e("Login Form", TZWSC_TRANSLATIONS_STRINGS); ?> </label> <span style="color:red;margin-left: 20px;">PRO</span>
                            <br>
                            <label for="wcRegistrationForm">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wcrf" disabled="disabled" type="checkbox">
                                <?php _e("Registration Form", TZWSC_TRANSLATIONS_STRINGS); ?></label><span style="color:red;margin-left: 20px;">PRO</span>
                            <br>
                            <label for="wcForgetPassword">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wcfpf" disabled="disabled" type="checkbox">
                                <?php _e("Forget Password Form", TZWSC_TRANSLATIONS_STRINGS); ?></label> <span style="color:red;margin-left: 20px;">PRO</span>
                            <br>
                             <label for="wcCheckoutPage">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="wccout" disabled="disabled" type="checkbox">
                                <?php _e("Checkout Page", TZWSC_TRANSLATIONS_STRINGS); ?></label> <span style="color:red;margin-left: 20px;">PRO</span>
                            <br>
                        </fieldset>
                         <br>
                        <p>Contact Form 7</p>
			<br>
                        <fieldset>
                            <label for="wpContactForm7">
                                <input id="enableCaptcha" name="enableCaptcha[]" value="cf7" disabled="disabled" type="checkbox" class="cf7Checkbox" onclick="tzwsc_cf7Shortcode()">
                                <?php _e("Contact Form", TZWSC_TRANSLATIONS_STRINGS); ?></label> <span style="color:red;margin-left: 20px;">PRO</span>
                            <br>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php _e("Save Changes ", TZWSC_TRANSLATIONS_STRINGS); ?>" type="submit"></p>
    </form>
</div>