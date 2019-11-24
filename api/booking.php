<?php
error_reporting(E_ERROR | E_PARSE);
require_once('utils/db.php');
require_once('utils/cookie.php');

function get_schedule_information($idSchedule)
{
    global $db;

    $sql = "SELECT title, dateTime, maxSeats, price
            FROM film, schedule
            WHERE
                film.idFilm = schedule.idFilm AND
                schedule.idSchedule = $idSchedule";

    $result = $db->query($sql);
    $response = $result->fetch_assoc();
    $response['dateTime'] = date('F j, Y - h:i A', strtotime($response['dateTime']));

    $sql = "SELECT seatNumber
            FROM transaction, schedule
            WHERE
                transaction.idSchedule = schedule.idSchedule AND
                schedule.idSchedule = $idSchedule";

    $result = $db->query($sql);
    $response['takenSeats'] = array();
    while ($data = $result->fetch_assoc()) {
        $response['takenSeats'][] = (int) $data['seatNumber'];
    }

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

        $sql = "SELECT idTransaction
            FROM schedule, transaction
            WHERE
                schedule.idSchedule = transaction.idSchedule AND
                schedule.idSchedule = $idSchedule AND
                transaction.seatNumber = $seatNumber";

        $result = $db->query($sql);

        $response = array();
        $success = false;
        if ($result && $result->num_rows === 0) {
            $sql = "INSERT INTO transaction (idUser, idSchedule, seatNumber)
                    VALUES ($idUser, $idSchedule, $seatNumber)";

            if ($db->query($sql)) {
                $response['status'] = 'success';
                http_response_code(201);
            } else {
                $response['status'] = 'failed';
                http_response_code(500);
            }
        } else {
            $response['status'] = 'failed';
            http_response_code(409);
        }

        $response['data'] = get_schedule_information($idSchedule);
        echo json_encode($response);
        return;
    }
}

// If all return fails
return http_response_code(400);
