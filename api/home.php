<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = '';
    if (isset($_GET['name'])) {
        $query = $db->real_escape_string($_GET['name']);
    }

    

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=7b0a11ef2d329f19bc4a57626fe8502e",
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

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $resp = json_decode($response, true);
        // var_dump($resp["results"][0]["poster_path"]);
        // var_dump($resp["results"][0]["id"]);
        // var_dump($resp["results"][0]["original_title"]);
        // var_dump($resp["results"][0]["vote_average"]);
    }
    
    $sql = "SELECT DISTINCT t.idFilm, title, posterUrl, rating
            FROM (
                SELECT film.idFilm, title, posterUrl, CAST(avg(review.rating) AS DECIMAL(10,2)) AS rating
                FROM film JOIN schedule JOIN transaction JOIN review
                WHERE
                    film.idFilm = schedule.idFilm AND
                    schedule.idSchedule = transaction.idSchedule AND
                    transaction.idTransaction = review.idTransaction
                GROUP BY film.idFilm
            ) t, schedule
            WHERE
                t.idFilm = schedule.idFilm";
                //  AND
                // (dateTime BETWEEN NOW() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY))";
    
    $result = $db->query($sql);

    $response = array();
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    };

    echo json_encode($response);
    return http_response_code(200);
}

http_response_code(400);
