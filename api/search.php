<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = '';
    if (isset($_GET['name'])) {
        $query = $db->real_escape_string($_GET['name']);
    }

    $sql = "SELECT film.idFilm, title, posterUrl, CAST(avg(review.rating) AS DECIMAL(10,2)) AS rating, synopsis
            FROM film JOIN schedule JOIN transaction JOIN review
            WHERE
                film.idFilm = schedule.idFilm AND
                schedule.idSchedule = transaction.idSchedule AND
                transaction.idTransaction = review.idTransaction AND
                title LIKE '%$query%'
            GROUP BY film.idFilm";

    $result = $db->query($sql);

    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    $response = array(
        'query' => $query,
        'results' => $rows
    );

    echo json_encode($response);
    return http_response_code(200);
}

http_response_code(400);
