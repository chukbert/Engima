<?php
$dbhost = "35.240.201.66";
$dbuser = "engima";
$dbpass = "123";
$dbname = "WBDdatabase";

global $db;

$db = new mysqli();
$db->connect($dbhost, $dbuser, $dbpass, $dbname);
$db->set_charset("utf8");

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}
