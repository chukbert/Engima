<?php
require_once('utils/db.php');
require_once('utils/cookie.php');
require_once('utils/request.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $idTransaksi = $db->real_escape_string($_POST['id']);
        $status = $db->real_escape_string($_POST['status']);
        
        $bod = new stdClass();
        $bod->idTransaksi = $idTransaksi;
        $bod->status = $status;

        $response = array();
        $resp = callAPI("POST", "http://13.229.224.101:3000/transaksichange", json_encode($bod));

        echo json_encode($resp);
        return;
    }
}
