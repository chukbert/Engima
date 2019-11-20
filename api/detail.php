<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idFilm = '';
    if (isset($_GET['id'])) {
        $idFilm = $db->real_escape_string($_GET['id']);
    }

    $sql = "SELECT idFilm, title, posterUrl, durationMinutes, releaseDate, synopsis
            FROM film WHERE film.idFilm = $idFilm";

    $result = $db->query($sql);
    if ($response = $result->fetch_assoc()) {
        $response['releaseDate'] = date('F j, Y', strtotime($response['releaseDate']));

        $sql = "SELECT genre FROM filmgenre, genre 
        WHERE filmgenre.idFilm = $idFilm AND filmGenre.idGenre = genre.idGenre";
        $result = $db->query($sql);
        $genres = array();
        while ($genre = $result->fetch_assoc()) {
            $genres[] = $genre['genre'];
        }
        $response['genres'] = $genres;

        $sql = "SELECT schedule.idSchedule, dateTime, (maxSeats - count(seatNumber)) as availableSeats
                FROM schedule, transaction
                WHERE
                    schedule.idFilm = $idFilm AND
                    schedule.idSchedule = transaction.idSchedule
                GROUP BY schedule.idSchedule";

        $result = $db->query($sql);
        $schedules = array();
        while ($schedule = $result->fetch_assoc()) {
            $schedule['date'] = date('F j, Y', strtotime($schedule['dateTime']));
            $schedule['time'] = date('h:i A', strtotime($schedule['dateTime']));
            unset($schedule['dateTime']);
            $schedules[] = $schedule;
        }
        $response['schedules'] = $schedules;

        $sql = "SELECT username, rating, comment, profilePicture
                FROM film JOIN schedule JOIN transaction JOIN review JOIN user
                WHERE
                    film.idFilm = schedule.idFilm AND
                    schedule.idSchedule = transaction.idSchedule AND
                    transaction.idTransaction = review.idTransaction AND
                    transaction.idUser = user.idUser AND
                    film.idFilm = $idFilm";

        $result = $db->query($sql);

        $totalRating = 0;
        $reviews = array();
        while ($review = $result->fetch_assoc()) {
            $totalRating += $review['rating'];
            $reviews[] = $review;
        }
        $response['rating'] = sprintf('%0.2f', $totalRating / count($reviews));
        $response['reviews'] = $reviews;

        echo json_encode($response);
        return http_response_code(200);
    } else {
        return http_response_code(404);
    }
}

http_response_code(400);
