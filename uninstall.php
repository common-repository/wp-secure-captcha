<?php
if (!defined("ABSPATH")) {
    exit;
}
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
else{
	delete_option( "tzwsc_captchaSetup" );
	delete_option( "tzwsc_enableCaptchaFor" );
	delete_option( "tzwsc_errorMessages" );
}


