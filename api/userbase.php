<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $count = 0;

    $sql = "SELECT COUNT(username) FROM user";
    if (isset($_GET['username'])) {
        $count++;
        if ($count == 1) $sql .= " WHERE ";
        else $sql .= " AND ";
        $username = $db->real_escape_string($_GET['username']);
        $sql .= "username='$username'";
    }

    if (isset($_GET['email'])) {
        $count++;
        if ($count == 1) $sql .= " WHERE ";
        else $sql .= " AND ";
        $email = $db->real_escape_string($_GET['email']);
        $sql .= "email='$email'";
    }

    if (isset($_GET['phoneNumber'])) {
        $count++;
        if ($count == 1) $sql .= " WHERE ";
        else $sql .= " AND ";
        $phone = $db->real_escape_string($_GET['phoneNumber']);
        $sql .= "phoneNumber='$phone'";
    }

    $result = $db->query($sql);
    $row = $result->fetch_array();
    echo json_encode(array(
        'count' => $row[0]
    ));
}
