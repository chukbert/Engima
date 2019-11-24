<?php

function callAPI($method, $url, $data)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
    ));


    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)));
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }
    }

    

    $result = curl_exec($curl);
    $err = curl_error($curl);

    if (!$result) {
        die("Connection Failure");
    }
    curl_close($curl);
    return $result;
}

// $bod = new stdClass();
// $bod->idUser = "5";
// $bod->akunVirtual = "3000";
// $bod->idFilm = "9";
// $bod->idSchedule = "15";
// $bod->seatNumber = "2";
// $bod->waktu = "2019-11-18 00:00:00";
// $bod->status = "pending";

// $resp = callAPI("POST", "http://localhost:3000/transaksi", json_encode($bod));
// $resp = callAPI("POST", "http://13.229.224.101:3000/transaksi", json_encode($bod));
// callAPI("GET", "http://13.229.224.101:3000/seats/62", false);
