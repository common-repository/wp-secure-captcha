<?php
if (!defined( "ABSPATH" )) {
    exit;
}
$captchaSetup = array();
$captchaSetup["captchaTitle"] = "Enter Captcha";
$captchaSetup["captchaWidth"] = "140";
$captchaSetup["captchaHeight"] = "60";
$captchaSetup["captchaLetterType"] = "capitalSmall";
$captchaSetup["captchaType"] = 1;
$captchaSetup["captchaBackgroundColor"] = "#bdbdbd";
$captchaSetup["captchTextType"] = "alphanumeric";
$captchaSetup["captchaCharacters"] = 4;
$captchaSetup["captchaFontColor"] = "#441dd1";
$captchaSetup["captchaFontSize"] = 32;
$captchaSetup["captchaRandomDotsColor"] = "#331fcc";
$captchaSetup["captchaRandomDots"] = 4;
$captchaSetup["captchaLinesColor"] = "#331fcc";
$captchaSetup["captchaLines"] = 3;
$captchaSetup["arithmeticNumbers"] = 1;
$captchaSetup["arithmeticWords"] = 0;
$captchaSetup["arithmeticAddition"] = 1;
$captchaSetup["arithmeticSubtraction"] = 1;
$captchaSetup["arithmeticMultiplication"] = 0;
$captchaSetup["arithmeticDivision"] = 0;

$enableCaptchaFor = array();
$enableCaptchaFor[0] = "wplf";  
$enableCaptchaFor[1] = "wprf";   

$errorMessages = array();
$errorMessages["captchaMismatch"] = "Invalid Captcha. Kindly try again.";
$errorMessages["emptyCaptcha"] = "Empty Captcha. Kindly try again.";

if(!get_option( "tzwsc_captchaSetup" )){
    update_option( "tzwsc_captchaSetup", serialize($captchaSetup));
}
if(!get_option( "tzwsc_enableCaptchaFor" )){
    update_option( "tzwsc_enableCaptchaFor", serialize($enableCaptchaFor));
}
if(!get_option( "tzwsc_errorMessages" )){
    update_option( "tzwsc_errorMessages", serialize($errorMessages));
}




