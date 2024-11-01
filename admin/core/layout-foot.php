<?php
if (!defined("ABSPATH")) {
    exit;
}
$captchaSetupOption = get_option("tzwsc_captchaSetup");
if (!empty($captchaSetupOption)) {
    $captchaSetup = unserialize($captchaSetupOption);
}
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#captchaLetterType").val("<?php echo $captchaSetup["captchaLetterType"] != "" ? $captchaSetup["captchaLetterType"] : "" ?>");
        jQuery("#captchTextType").val("<?php echo $captchaSetup["captchTextType"] != "" ? $captchaSetup["captchTextType"] : "" ?>");
        jQuery("#captchaCharacters").val("<?php echo $captchaSetup["captchaCharacters"] != "" ? $captchaSetup["captchaCharacters"] : "" ?>");
        jQuery("#captchaFontSize").val("<?php echo $captchaSetup["captchaFontSize"] != "" ? $captchaSetup["captchaFontSize"] : "" ?>");
        jQuery("#captchaRandomDots").val("<?php echo $captchaSetup["captchaRandomDots"] != "" ? $captchaSetup["captchaRandomDots"] : "" ?>");
        jQuery("#captchaLines").val("<?php echo $captchaSetup["captchaLines"] != "" ? $captchaSetup["captchaLines"] : "" ?>");
        tzwsc_chooseCaptchaType();    
        tzwsc_letterType();
        tzwsc_cf7Shortcode();
    });

    function tzwsc_chooseCaptchaType() {
        if (jQuery("input[name='captchaType']:checked").val() == 1) {
            jQuery(".divNumericCaptcha").hide();
            jQuery(".divImageCaptcha").show();
        } else {
            jQuery(".divImageCaptcha").hide();
            jQuery(".divNumericCaptcha").show();
        }
        if (jQuery("#captchTextType").val() == "numeric" ){
            jQuery("#divLetterType").hide();
        }
    }
    function tzwsc_letterType() {
       
        if (jQuery("#captchTextType").val() != "numeric" && jQuery("input[name='captchaType']:checked").val() == 1) {
            jQuery("#divLetterType").show();
        } else {
            jQuery("#divLetterType").hide();
        }
    }
    function isNumberKey(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    }
    function tzwsc_chooseColor(pickerId, value) {
        jQuery("#" + pickerId).colpick
                ({
                    layout: "hex",
                    colorScheme: "dark",
                    color: value,
                    onChange: function (hsb, hex, rgb, el, bySetColor)
                    {
                        if (!bySetColor)
                            jQuery(el).val("#" + hex);
                    }
                }).keyup(function ()
        {
            jQuery(this).colpickSetColor("#" + this.value);
        });
    }
    function tzwsc_cf7Shortcode(){
       if(jQuery(".cf7Checkbox").prop("checked")){
           jQuery("#labelcf7Capthca").show();
        }
        else{
            jQuery("#labelcf7Capthca").hide();
        }
    }
</script>  
