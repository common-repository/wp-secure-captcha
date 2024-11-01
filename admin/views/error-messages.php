<?php
if (!defined("ABSPATH")) {
    exit;
}
$errorMessagesOption = get_option("tzwsc_errorMessages");
if (!empty($errorMessagesOption)) {
    $errorMessages = unserialize($errorMessagesOption);
}
?>
<div class="wrap">
    <h1><?php _e("Error Messages", TZWSC_TRANSLATIONS_STRINGS); ?></h1>
    <div class="update-nag bsf-update-nag"><a target="_blank" href="http://techezee.com/pricing/">Go for Premimum Editions</a></div>
    <form  method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="captchaMismatch"><?php _e("Mis Match Captcha", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td><textarea disabled="disabled" id="captchaMismatch" name="captchaMismatch" rows="3" cols="75"><?php echo $errorMessages["captchaMismatch"] != "" ? $errorMessages["captchaMismatch"] : "Invalid Captcha. Kindly try again."; ?></textarea> <span style="color:red;margin-left: 20px;">PRO</span></td>
                </tr>
                <tr>
                    <th scope="row"><label for="captchaEmpty"><?php _e("Empty Captcha", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td><textarea disabled="disabled" id="emptyCaptcha" name="emptyCaptcha" rows="3" cols="75"><?php echo $errorMessages["emptyCaptcha"] != "" ? $errorMessages["emptyCaptcha"] : "Empty Captcha. Kindly try again."; ?></textarea> <span style="color:red;margin-left: 20px;">PRO</span></td>
                </tr>
            </tbody>
        </table>
        
    </form>
</div>