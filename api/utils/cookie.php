<?php
require_once('utils/db.php');

$LOGIN_COOKIE_NAME = "engimaUser";
$COOKIE_EXPIRY_TIME = 3600;

function generate_cookie()
{
    global $COOKIE_EXPIRY_TIME;

    $auth = array(rand() => time() + $COOKIE_EXPIRY_TIME);
    $new_cookie = base64_encode(json_encode($auth));

    return $new_cookie;
}

function get_cookie()
{
    global $LOGIN_COOKIE_NAME;

    if (!isset($_COOKIE[$LOGIN_COOKIE_NAME])) {
        return null;
    }
    return $_COOKIE[$LOGIN_COOKIE_NAME];
}

function get_cookie_expiry_time()
{
    $cookie = get_cookie();
    $auth = json_decode(base64_decode($cookie));

    foreach ($auth as $_ => $value) {
        $expiry_time = $value;
    }

    return $expiry_time;
}

function get_user()
{
    global $db;

    $cookie = get_cookie();
    $sql = "SELECT *
            FROM user
            WHERE cookie = '$cookie'";

    $result = $db->query($sql);
    return $result->fetch_assoc();
}
