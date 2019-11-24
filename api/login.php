<?php
require_once('utils/db.php');
require_once('utils/cookie.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $db->real_escape_string($_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT username, password FROM user WHERE email='$email'";
    $result = $db->query($sql);
    if ($result && $result->num_rows === 1) {
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        if ($row['password'] !== $password) {
            $response = array(
                'error' => 'Wrong password!',
            );
            http_response_code(403);

            echo json_encode($response);
            return;
        }

        $new_cookie = generate_cookie();
        $sql = "UPDATE user SET cookie='$new_cookie' WHERE email='$email' AND password='$password'";

        if ($db->query($sql) === true) {
            $response = array(
                'status' => 'ok',
                'user' => $row['username'],
            );
            http_response_code(200);
            setcookie($LOGIN_COOKIE_NAME, $new_cookie, time() + $COOKIE_EXPIRY_TIME);

            echo json_encode($response);
            return;
        }
    } else {
        $response = array(
            'error' => 'User does not exist!',
        );
        http_response_code(400);

        echo json_encode($response);
        return;
    }
}

http_response_code(403);
