<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = '';
    if (isset($_GET['name'])) {
        $query = $db->real_escape_string($_GET['name']);
    }

    

    $curl = curl_init();

    $lastWeekDate = date_sub(date_create(), date_interval_create_from_date_string('7 days'));
    $lastWeekDate = date_format($lastWeekDate, 'Y-m-d');
    $currentDate = date_format(date_create(), 'Y-m-d');

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/discover/movie?api_key=7b0a11ef2d329f19bc4a57626fe8502e&language=en-US&sort_by=vote_count.desc&include_adult=false&include_video=false&page=1&primary_release_date.gte=".$lastWeekDate."&primary_release_date.lte=".$currentDate,
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
        // var_dump($resp);
        $films = array();
        foreach ($resp["results"] as $movie) {
            # code...
            $film = new stdClass();
            $film->id = $movie["id"];
            $film->poster = ("http://image.tmdb.org/t/p/w400".$movie["poster_path"]);
            // var_dump($film->poster);
            $film->title = $movie["original_title"];
            $film->score = $movie["vote_average"];
            array_push($films, $film);
            // var_dump($movie["original_title"]);
        }
        echo(json_encode($films));
        // var_dump($resp["results"][0]["poster_path"]);
        // var_dump($resp["results"][0]["id"]);
        // var_dump($resp["results"][0]["original_title"]);
        // var_dump($resp["results"][0]["vote_average"]);
    }
    return http_response_code(200);
}

http_response_code(400);
