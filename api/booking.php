<?php
error_reporting(E_ERROR | E_PARSE);
require_once('utils/db.php');
require_once('utils/cookie.php');
require_once('utils/request.php');
require_once('generateVA.php');

function get_schedule_information($idSchedule)
{
    global $db;

    //title dari api
    $sql = "SELECT dateTime, maxSeats, price, idFilm
            FROM schedule
            WHERE schedule.idSchedule = $idSchedule";

    $result = $db->query($sql);
    $response = $result->fetch_assoc();
    $response['dateTime'] = date('F j, Y - h:i A', strtotime($response['dateTime']));

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$response['idFilm']."?api_key=7b0a11ef2d329f19bc4a57626fe8502e&language=en-US",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{}",
    ));

    $resp = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    $movie = json_decode($resp, true);

    $response['title'] = $movie["original_title"];

    // $sql = "SELECT seatNumber
    //         FROM transaction, schedule
    //         WHERE
    //             transaction.idSchedule = schedule.idSchedule AND
    //             schedule.idSchedule = $idSchedule";

    // $result = $db->query($sql);
    $resTaken = callAPI("GET", "http://13.229.224.101:3000/seats/".$idSchedule, false);
    $taken = json_decode($resTaken, true);
    $response['takenSeats'] = $taken["data"];

    return $response;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idSchedule = '';
    if (isset($_GET['id'])) {
        $idSchedule = $db->real_escape_string($_GET['id']);
    } else {
        return http_response_code(404);
    }

    echo json_encode(get_schedule_information($idSchedule));
    return http_response_code(200);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if (isset($_POST['id']) && isset($_POST['seat'])) {
        $idUser = get_user()['idUser'];

        $idSchedule = $db->real_escape_string($_POST['id']);
        $seatNumber = $db->real_escape_string($_POST['seat']);

        $sql = "SELECT dateTime, maxSeats, price, idFilm
            FROM schedule
            WHERE schedule.idSchedule = $idSchedule";

        $result = $db->query($sql);
        $response = $result->fetch_assoc();

        $virtual = generateVA(3)->return;
        $bod = new stdClass();
        $bod->idUser = $idUser;
        $bod->akunVirtual = $virtual;
        $bod->idFilm = $response['idFilm'];
        $bod->idSchedule = $idSchedule;
        $bod->seatNumber = $seatNumber;
        $bod->waktu = date_format(date_create(), 'Y-m-d H:i:s');
        $bod->status = "pending";
        
        $response = array();
        $response['status'] = 'success';
        $resp = callAPI("POST", "http://13.229.224.101:3000/transaksi", json_encode($bod));
        $response['idTransaksi'] = json_decode($resp, true)["id"];
        $response['va'] = $virtual;
        
        echo json_encode($response);
        return;
    }
}

// If all return fails
return http_response_code(400);
