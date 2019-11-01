<?php
require_once('utils/db.php');
require_once('utils/cookie.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $db->real_escape_string($_POST['username']);
    $email = $db->real_escape_string($_POST['email']);
    $phone = $db->real_escape_string($_POST['phoneNumber']);

    $sql = "SELECT * FROM user WHERE username='$username' OR email='$email' or phoneNumber='$phone'";
    $result = $db->query($sql);
    if ($result && $result->num_rows === 0) {
        $password = md5($_POST['password']);
        $file_path = $db->real_escape_string('/uploads/profile/' . md5(rand()) . '-' . $_FILES['file']['name']);

        if (preg_match("!image!", $_FILES['file']['type'])) {
            if (copy($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $file_path)) {
                $new_cookie = generate_cookie();

                $sql =
                    "INSERT INTO user (username, password, email, phoneNumber, profilePicture, cookie) "
                    . "VALUES ('$username', '$password', '$email', '$phone', '$file_path', '$new_cookie')";

                if ($db->query($sql) === true) {
                    $response = array(
                        'status' => 'ok',
                        'user' => $username,
                    );
                    http_response_code(201);
                    setcookie($LOGIN_COOKIE_NAME, $new_cookie, time() + $COOKIE_EXPIRY_TIME);

                    echo json_encode($response);
                    return;
                } else {
                    unlink($file_path);
                }
            } else {
                http_response_code(500);
                return;
            }
        }
    }
}

http_response_code(400);
