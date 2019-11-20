<?php
require_once('utils/db.php');
require_once('utils/cookie.php');

$cookie = get_cookie();
$response = array(
    'status' => 'logout',
);

if ($cookie) {
    $expiry_time = get_cookie_expiry_time();

    if (time() < $expiry_time) {
        $sql = "SELECT username FROM user WHERE cookie='$cookie'";
        $result = $db->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row['username']) {
                $response = array(
                    'status' => 'login',
                    'user' => $row['username'],
                );
            }
        }
    }
}

echo json_encode($response);
