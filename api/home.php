<?php
require_once('utils/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = '';
    if (isset($_GET['name'])) {
        $query = $db->real_escape_string($_GET['name']);
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
                t.idFilm = schedule.idFilm AND
                (dateTime BETWEEN NOW() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY))";
    
    $result = $db->query($sql);

    $response = array();
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    };

    echo json_encode($response);
    return http_response_code(200);
}

http_response_code(400);
