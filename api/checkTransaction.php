<?php
require_once('utils/soap.php');
require_once('utils/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function checkTransaction($account, $amount, $start)
    {
        $interval = new DateInterval('PT2M');
        $end = date_add(date_create($start), $interval);
        $end = date_format($end, 'Y-m-d H:i:s');
        
        return checkTransactionExist($account, $amount, $start, $end);
        
    }

    $_POST = json_decode(file_get_contents('php://input'), true);
    if (isset($_POST['account']) && isset($_POST['amount']) && isset($_POST['start'])) {
        $account = $db->real_escape_string($_POST['account']);
        $amount = $db->real_escape_string($_POST['amount']);
        $start = $db->real_escape_string($_POST['start']);
        $result = checkTransaction($account, $amount, $start);
        $result->end = $end;
        echo json_encode($result);
    }
}