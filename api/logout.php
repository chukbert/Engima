<?php
require_once('utils/cookie.php');

$expiry_time = get_cookie_expiry_time();
if (isset($_COOKIE[$LOGIN_COOKIE_NAME])) {
    unset($_COOKIE[$LOGIN_COOKIE_NAME]);
    setcookie($LOGIN_COOKIE_NAME, '', time() - $COOKIE_EXPIRY_TIME);
}

http_response_code(200);
