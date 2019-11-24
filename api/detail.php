<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idFilm = '';
    if (isset($_GET['id'])) {
        $idFilm = $db->real_escape_string($_GET['id']);
    }

    // $sql = "SELECT idFilm, title, posterUrl, durationMinutes, releaseDate, synopsis
    //         FROM film WHERE film.idFilm = $idFilm";

    // $result = $db->query($sql);

    $curl = curl_init();

    $lastWeekDate = date_sub(date_create(), date_interval_create_from_date_string('7 days'));
    $lastWeekDate = date_format($lastWeekDate, 'Y-m-d');
    $currentDate = date_format(date_create(), 'Y-m-d');

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$idFilm."?api_key=7b0a11ef2d329f19bc4a57626fe8502e&language=en-US",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{}",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if (!$err) {
        $movie = json_decode($response, true);
        $film = new stdClass();
        $film->title = $movie["original_title"];
        $film->poster = "http://image.tmdb.org/t/p/w400".$movie["poster_path"];
        $film->synopsis = $movie["overview"];
        $film->rating = $movie["vote_average"];
        $film->durationMinutes = $movie["runtime"];
        $film->releaseDate = $movie["release_date"];
        $genres = array();
        foreach ($movie["genres"] as $genre) {
            array_push($genres, $genre["name"]);
        }
        $film->genres = $genres;

        $sql = "SELECT idSchedule 
                FROM schedule
                WHERE idFilm = ".$idFilm;


        $result = $db->query($sql);

        if (!$result->fetch_assoc()) {
            $date = date_format(date_create($movie["release_date"]), 'Y-m-d H:i:s');
            for ($i=0; $i <7; $i++) {
                $temp = date_add(date_create($date), date_interval_create_from_date_string('1 days'));
                $date = date_format($temp, 'Y-m-d H:i:s');
                $sql = "INSERT INTO `schedule` (`idFilm`, `dateTime`, `maxSeats`, `price`) 
                        VALUES ('".$idFilm."', '".$date."', '20', '45000')";
                if ($db->query($sql)) {
                    http_response_code(201);
                } else {
                    http_response_code(500);
                }
            }
        }


        $sql = "SELECT s.idSchedule, s.dateTime, (s.maxSeats - count(t.seatNumber)) as availableSeats 
                FROM schedule s LEFT JOIN transaction t 
                ON s.idSchedule = t.idSchedule 
                WHERE s.idFilm = $idFilm GROUP BY s.idSchedule";

        
        $result = $db->query($sql);
        $schedules = array();
        while ($schedule = $result->fetch_assoc()) {
            $schedule['date'] = date('F j, Y', strtotime($schedule['dateTime']));
            $schedule['time'] = date('h:i A', strtotime($schedule['dateTime']));
            unset($schedule['dateTime']);
            $schedules[] = $schedule;
        }
        $film->schedules = $schedules;

        

    //     $sql = "SELECT username, rating, comment, profilePicture
    //             FROM film JOIN schedule JOIN transaction JOIN review JOIN user
    //             WHERE
    //                 film.idFilm = schedule.idFilm AND
    //                 schedule.idSchedule = transaction.idSchedule AND
    //                 transaction.idTransaction = review.idTransaction AND
    //                 transaction.idUser = user.idUser AND
    //                 film.idFilm = $idFilm";

    //     $result = $db->query($sql);

    //     $totalRating = 0;
    //     $reviews = array();
    //     while ($review = $result->fetch_assoc()) {
    //         $totalRating += $review['rating'];
    //         $reviews[] = $review;
    //     }
    //     $response['rating'] = sprintf('%0.2f',  $totalRating / count($reviews));
    //     $response['reviews'] = $reviews;


        echo json_encode($film);
        return http_response_code(200);
    } else {
        return http_response_code(404);
    }
}

http_response_code(400);
