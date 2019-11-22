<?php
$dbhost = "localhost";
$dbuser = "wbd";
$dbpass = "wbd";
$dbname = "WBDdatabase";

global $db;

$db = new mysqli();
$db->connect($dbhost, $dbuser, $dbpass, $dbname);
$db->set_charset("utf8");

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}
