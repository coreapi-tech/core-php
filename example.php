<?php

require_once 'vendor/autoload.php';

$token = 'affkqjjnfnafnjj';

$coreapi = new Coreapi\Tools($token);

$ip = 'ip';

$geoUser = $coreapi->get_user_geo($ip);

$emailInfo = $coreapi->get_email_info('email');

$phoneInfo = $coreapi->get_phone_info('phone');

$smsAuth = $coreapi->send_sms_auth('phone', 'code', 'en');

?>