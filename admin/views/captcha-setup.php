<?php
if (!defined("ABSPATH")) {
    exit;
}

if(isset($_POST["submit"])){
    $captchaSetup = array();
    $captchaSetup["captchaTitle"] = esc_attr($_POST["captchaTitle"]);
    $captchaSetup["captchaWidth"] = intval($_POST["captchaWidth"]);
    $captchaSetup["captchaHeight"] = intval($_POST["captchaHeight"]);
    $captchaSetup["captchaType"] = isset($_POST["captchaType"]) ? esc_attr($_POST["captchaType"]) : "0" ;
    $captchaSetup["captchaLetterType"] = esc_attr($_POST["captchaLetterType"]);
    $captchaSetup["captchaBackgroundColor"] = esc_attr($_POST["captchaBackgroundColor"]);
    $captchaSetup["captchTextType"] = esc_attr($_POST["captchTextType"]);
    $captchaSetup["captchaCharacters"] = esc_attr($_POST["captchaCharacters"]);
    $captchaSetup["captchaFontColor"] = esc_attr($_POST["captchaFontColor"]);
    $captchaSetup["captchaFontSize"] = esc_attr($_POST["captchaFontSize"]);
    $captchaSetup["captchaRandomDotsColor"] = esc_attr($_POST["captchaRandomDotsColor"]);
    $captchaSetup["captchaRandomDots"] = esc_attr($_POST["captchaRandomDots"]);
    $captchaSetup["captchaLinesColor"] = esc_attr($_POST["captchaLinesColor"]);
    $captchaSetup["captchaLines"] = esc_attr($_POST["captchaLines"]);
    $captchaSetup["arithmeticWords"] = isset($_POST["arithmeticWords"]) ? "1" : "0";
    $captchaSetup["arithmeticSubtraction"] = isset($_POST["arithmeticSubtraction"]) ? "1" : "0";
    $captchaSetup["arithmeticMultiplication"] = isset($_POST["arithmeticMultiplication"]) ? "1" : "0";
    $captchaSetup["arithmeticDivision"] = isset($_POST["arithmeticDivision"]) ? "1" : "0";
    if(isset($_POST["arithmeticAddition"]) == "0" && $captchaSetup["arithmeticSubtraction"] == "0" && $captchaSetup["arithmeticMultiplication"] == "0" && $captchaSetup["arithmeticDivision"]  == "0"){
        $captchaSetup["arithmeticAddition"] = "1";
    }
    else{
        $captchaSetup["arithmeticAddition"] = isset($_POST["arithmeticAddition"]) ? "1" : "0";
    }
    if(isset($_POST["arithmeticNumbers"]) == "0" && $captchaSetup["arithmeticWords"] == "0"){
        $captchaSetup["arithmeticNumbers"] = "1";
    }
    else{
        $captchaSetup["arithmeticNumbers"] = isset($_POST["arithmeticNumbers"]) ? "1" : "0";
    }
        
    update_option("tzwsc_captchaSetup", serialize($captchaSetup));
}
$captchaSetupOption = get_option("tzwsc_captchaSetup");
if (!empty($captchaSetupOption)) {
    $captchaSetup = unserialize($captchaSetupOption);
}
?>
<div class="wrap">
    <h1><?php _e("Captcha Setup", TZWSC_TRANSLATIONS_STRINGS); ?></h1>
    <div class="update-nag bsf-update-nag"><a target="_blank" href="http://techezee.com/pricing/">Go for Premimum Editions</a></div>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="captchaTitle"><?php _e("Captcha Title", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td><input id="captchaTitle" name="captchaTitle" value="<?php echo $captchaSetup["captchaTitle"] != "" ? $captchaSetup["captchaTitle"] : "" ?>" class="regular-text" type="text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="captchaSize"><?php _e("Captcha Size", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <div class="color-option-size">
                            <input checked="checked" id="captchaWidth" name="captchaWidth" value="<?php echo $captchaSetup["captchaWidth"] != "" ? $captchaSetup["captchaWidth"] : "" ?>" maxlength="4" onkeypress="return isNumberKey(event)" class="tog input-size" type="text">
                            <label for="imageCaptchaWidth"><?php _e("Width ", TZWSC_TRANSLATIONS_STRINGS); ?>(px)</label>
                        </div>
                        <div class="color-option-size">
                            <input id="captchaHeight" name="captchaHeight" value="<?php echo $captchaSetup["captchaHeight"] != "" ? $captchaSetup["captchaHeight"] : "" ?>" maxlength="4" onkeypress="return isNumberKey(event)" class="tog input-size" type="text">
                            <label for="numericCaptchaHeight"><?php _e("Height ", TZWSC_TRANSLATIONS_STRINGS); ?>(px)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="captchaType"><?php _e("Captcha Type", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <div class="color-option-type">
                            <input id="imageCaptcha" name="captchaType" onclick="tzwsc_chooseCaptchaType()" value="1" <?php echo $captchaSetup["captchaType"] == 1 ? "checked='checked'" : "" ?> class="tog" type="radio">
                            <label for="imageCaptcha"><?php _e("Text/Image Captcha", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                        </div>
                        <div class="color-option-type">
                            <input id="numericCaptcha" name="captchaType" value="0" onclick="tzwsc_chooseCaptchaType()" <?php echo $captchaSetup["captchaType"] == 0 ? "checked='checked'" : "" ?> class="tog" type="radio">
                            <label for="numericCaptcha"><?php _e("Mathematics Captcha", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                        </div>
                    </td>
                </tr>
                <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaText"><?php _e("Captcha Text Type", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <select id="captchTextType" name="captchTextType" onchange="tzwsc_letterType();">
                            <option selected="selected" value="alphanumeric"><?php _e("Alphanumeric", TZWSC_TRANSLATIONS_STRINGS); ?></option>
                            <option value="alphabets"><?php _e("Alphabets", TZWSC_TRANSLATIONS_STRINGS); ?></option>
                            <option value="numeric"><?php _e("Numeric", TZWSC_TRANSLATIONS_STRINGS); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="divImageCaptcha" id="divLetterType" style="display:none;">
                    <th scope="row"><label for="captchaLetter"><?php _e("Captcha Letter Type", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <select id="captchaLetterType" name="captchaLetterType">
                            <option selected="selected" value="capitalSmall"><?php _e("Capital & Small", TZWSC_TRANSLATIONS_STRINGS); ?></option>
                            <option value="capital"><?php _e("Capital Letters", TZWSC_TRANSLATIONS_STRINGS); ?></option>
                            <option value="small"><?php _e("Small Letters", TZWSC_TRANSLATIONS_STRINGS); ?></option>
                        </select>
                    </td>
                </tr>
                 <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaBackgroundColor"><?php _e("Captcha Background Color", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td><input onfocus="chooseColor(this.id, this.value)" id="captchaBackgroundColor" name="captchaBackgroundColor" value="<?php echo $captchaSetup["captchaBackgroundColor"] != "" ? $captchaSetup["captchaBackgroundColor"] : "#ffffff" ?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaCharacters"><?php _e("Captcha Characters", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <select id="captchaCharacters" name="captchaCharacters">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected="selected">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </td>
                </tr>
                 <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaFontColor"><?php _e("Captcha Font Color", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td><input onfocus="chooseColor(this.id, this.value)" id="captchaFontColor" name="captchaFontColor" value="<?php echo $captchaSetup["captchaFontColor"] != "" ? $captchaSetup["captchaFontColor"] : "#ffffff" ?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaFontSize"><?php _e("Captcha Font Size", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <select id="captchaFontSize" name="captchaFontSize">
                            <?php for ($int = 1; $int <= 100; $int++) {
                                ?>
                                <option value="<?php echo $int; ?>"><?php echo $int; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaRandomDotsColor"><?php _e("Captcha Random Dots Color", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td><input onfocus="chooseColor(this.id, this.value)" id="captchaRandomDotsColor" name="captchaRandomDotsColor" value="<?php echo $captchaSetup["captchaRandomDotsColor"] != "" ? $captchaSetup["captchaRandomDotsColor"] : "#ffffff" ?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaRandomDots"><?php _e("Captcha Random Dots", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <select id="captchaRandomDots" name="captchaRandomDots">
                            <?php for ($integer = 0; $integer <= 200; $integer++) {
                                ?>
                                <option value="<?php echo $integer; ?>"><?php echo $integer; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaLinesColor"><?php _e("Captcha Lines Color", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td><input onfocus="chooseColor(this.id, this.value)" id="captchaLinesColor" name="captchaLinesColor" value="<?php echo $captchaSetup["captchaLinesColor"] != "" ? $captchaSetup["captchaLinesColor"] : "#ffffff" ?>" class="regular-text" type="text"></td>
                </tr>
                 <tr class="divImageCaptcha" style="display:none;">
                    <th scope="row"><label for="captchaLines"><?php _e("Captcha Lines", TZWSC_TRANSLATIONS_STRINGS); ?></label></th>
                    <td>
                        <select id="captchaLines" name="captchaLines">
                            <?php for ($lines = 0; $lines <= 100; $lines++) {
                                ?>
                                <option value="<?php echo $lines; ?>"><?php echo $lines; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                
                <tr class="divNumericCaptcha" style="display:none;"> 
                    <th scope="row"><?php _e("Arithmetic Operations", TZWSC_TRANSLATIONS_STRINGS); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Arithmetic Operations", TZWSC_TRANSLATIONS_STRINGS); ?></span></legend>
                            <label for="default_pingback_flag">
                                <input id="addCheck" name="arithmeticAddition" <?php echo $captchaSetup["arithmeticAddition"] == 1 ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Addition", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                            <label for="default_ping_status">
                                <input name="arithmeticSubtraction" <?php echo $captchaSetup["arithmeticSubtraction"] == 1 ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Subtraction ", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                            <label for="default_comment_status">
                                <input name="arithmeticMultiplication" <?php echo $captchaSetup["arithmeticMultiplication"] == 1 ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Multiplication", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                            <label for="default_comment_status">
                                <input name="arithmeticDivision" <?php echo $captchaSetup["arithmeticDivision"] == 1 ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Division", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                        </fieldset></td>
                </tr>
                <tr class="divNumericCaptcha" style="display:none;">
                    <th scope="row"><?php _e("Display Type", TZWSC_TRANSLATIONS_STRINGS); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Display Type", TZWSC_TRANSLATIONS_STRINGS); ?></span></legend>
                            <label for="numbers">
                                <input id="arithmeticNumbers" name="arithmeticNumbers" value="1" <?php echo $captchaSetup["arithmeticNumbers"] == 1 ? "checked='checked'" : "" ?> type="checkbox">
                                <?php _e("Numbers", TZWSC_TRANSLATIONS_STRINGS); ?></label>
                            <br>
                            <label for="default_ping_status">
                                <input id="arithmeticWords" name="arithmeticWords" disabled="disabled" value="1" type="checkbox">
                                <?php _e("Words ", TZWSC_TRANSLATIONS_STRINGS); ?></label> <span style="color:red;margin-left: 20px;">PRO</span>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php _e("Save Changes ", TZWSC_TRANSLATIONS_STRINGS); ?>" type="submit"></p>
    </form>
</div>