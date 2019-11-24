<?php
require_once('utils/soap.php');

function generateVA($account)
{
    return generateVirtualAccount($account);
}

// if ($_SERVER["REQUEST_METHOD"] == "GET") {
//     $idSchedule = '';
//     if (isset($_GET['id']))
//         $idSchedule = $db->real_escape_string($_GET['id']);
//     else return http_response_code(404);

//     echo json_encode(generateVirtualAccount($account));
//     return http_response_code(200);
// }


// var_dump(generateVA(1));