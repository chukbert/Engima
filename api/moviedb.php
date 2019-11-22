<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = '';
    if (isset($_GET['name']))
        $query = $db->real_escape_string($_GET['name']);

    

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