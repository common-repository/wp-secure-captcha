<?php

if (!defined("ABSPATH")) {
    exit;
}

$captchaSetupOption = get_option("tzwsc_captchaSetup");
if (!empty($captchaSetupOption)) {
    $captchaSetup = unserialize($captchaSetupOption);
}
$captchaWidth = $captchaSetup["captchaWidth"] != "" ? $captchaSetup["captchaWidth"] : "";
$captchaHeight = $captchaSetup["captchaHeight"] != "" ? $captchaSetup["captchaHeight"] : "";
$captchaCharacters = $captchaSetup["captchaCharacters"] != "" ? $captchaSetup["captchaCharacters"] : "";
$captchaTitle = $captchaSetup["captchaTitle"] != "" ? $captchaSetup["captchaTitle"] : "";
$captchaBackgroundColor = $captchaSetup["captchaBackgroundColor"] != "" ? $captchaSetup["captchaBackgroundColor"] : "";
$captchaType = $captchaSetup["captchaType"] != "" ? $captchaSetup["captchaType"] : "";
$captchaLetterType = $captchaSetup["captchaLetterType"] != "" ? $captchaSetup["captchaLetterType"] : "";
$captchTextType = $captchaSetup["captchTextType"] != "" ? $captchaSetup["captchTextType"] : "";
$captchaFontColor = $captchaSetup["captchaFontColor"] != "" ? $captchaSetup["captchaFontColor"] : "";
$captchaFontSize = $captchaSetup["captchaFontSize"] != "" ? $captchaSetup["captchaFontSize"] : "";
$captchaRandomDotsColor = $captchaSetup["captchaRandomDotsColor"] != "" ? $captchaSetup["captchaRandomDotsColor"] : "";
$captchaRandomDots = $captchaSetup["captchaRandomDots"] != "" ? $captchaSetup["captchaRandomDots"] : "";
$captchaLinesColor = $captchaSetup["captchaLinesColor"] != "" ? $captchaSetup["captchaLinesColor"] : "";
$captchaLines = $captchaSetup["captchaLines"] != "" ? $captchaSetup["captchaLines"] : "";

if ($captchTextType == "alphanumeric") {
    switch ($captchaLetterType) {
        case "capital":
            $codeText = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case "small":
            $codeText = "1234567890abcdfghjkmnpqrstvwxyz";
            break;
        case "capitalSmall":
            $codeText = "1234567890abcdfghjkmnpqrstvwxyzABCEFGHJKMNPRSTVWXYZ";
            break;
        default:
            $codeText = "1234567890abcdfghjkmnpqrstvwxyz";
            break;
    }
} elseif ($captchTextType == "alphabets") {
    switch ($captchaLetterType) {
        case "capital":
            $codeText = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case "small":
            $codeText = "abcdfghjkmnpqrstvwxyz";
            break;
        case "capitalSmall":
            $codeText = "abcdfghjkmnpqrstvwxyzABCEFGHJKMNPRSTVWXYZ";
            break;
        default:
            $codeText = "abcdefghijklmnopqrstuvwxyz";
            break;
    }
} elseif ($captchTextType == "numeric") {
    $codeText = "0123456789";
} else {
    $codeText = "0123456789";
}

$cagCaptcha = "";
$captchaChars = 0;
while ($captchaChars < $captchaCharacters) {
    $cagCaptcha .= substr($codeText, mt_rand(0, strlen($codeText) - 1), 1);
    $captchaChars++;
}

$image = imagecreatetruecolor($captchaWidth, $captchaHeight);
$font = TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "fonts/font.ttf";

$captchaBGColor = hexrgb($captchaBackgroundColor);
$captchaBGColors = imagecolorallocate($image, $captchaBGColor["red"], $captchaBGColor["green"], $captchaBGColor["blue"]);
imagefill($image, 0, 0, $captchaBGColors);

$captchaFontColorDisplay = hexrgb($captchaFontColor);
$captchaTextColor = imagecolorallocate($image, $captchaFontColorDisplay["red"], $captchaFontColorDisplay["green"], $captchaFontColorDisplay["blue"]);

$dotsColor = hexrgb($captchaRandomDotsColor);
$captchaDotsColor = imagecolorallocate($image, $dotsColor["red"], $dotsColor["green"], $dotsColor["blue"]);

for ($dots = 0; $dots < $captchaRandomDots; $dots++) {
    imagefilledellipse($image, mt_rand(0, $captchaWidth), mt_rand(0, $captchaHeight), 2, 3, $captchaDotsColor);
}

$linesColor = hexrgb($captchaLinesColor);
$captchaLineColor = imagecolorallocate($image, $linesColor["red"], $linesColor["green"], $linesColor["blue"]);

for ($lines = 0; $lines < $captchaLines; $lines++) {
    imageline($image, mt_rand(0, $captchaWidth), mt_rand(0, $captchaHeight), mt_rand(0, $captchaWidth), mt_rand(0, $captchaHeight), $captchaLineColor);
}

$textbox = imagettfbbox($captchaFontSize, 0, $font, $cagCaptcha);
$x = ($captchaWidth - $textbox[4]) / 2;
$y = ($captchaHeight - $textbox[5]) / 2;
imagettftext($image, $captchaFontSize, 0, $x, $y, $captchaTextColor, $font, $cagCaptcha);

header("Content-Type: image/jpeg");
imagejpeg($image);
imagedestroy($image);
$_SESSION["textCaptcha"] = $cagCaptcha;

function hexrgb($hexstr) {
    $int = hexdec($hexstr);
    return array("red" => 0xFF & ($int >> 0x10),
        "green" => 0xFF & ($int >> 0x8),
        "blue" => 0xFF & $int);
}

