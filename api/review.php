<?php
require_once('utils/db.php');
require_once('utils/cookie.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = '';
    if (isset($_GET['id']))
        $query = $db->real_escape_string($_GET['id']);
        
	$sql = "SELECT transaction.idTransaction
            FROM transaction JOIN review
            WHERE
                transaction.idTransaction = review.idTransaction AND
                transaction.idTransaction = ".$query;
                
    $result = $db->query($sql);
    
    if ($result && $result->num_rows > 0) {
		$sql = "SELECT DISTINCT transaction.idTransaction, title, rating, comment
            FROM transaction JOIN schedule JOIN film JOIN review
            WHERE
                transaction.idSchedule = schedule.idSchedule AND
                schedule.idFilm = film.idFilm AND
                transaction.idTransaction = review.idTransaction AND
                transaction.idTransaction = ".$query;
        $result = $db->query($sql);
        $result = $result->fetch_assoc();
        $result['submitted'] = True;
	} else {
		$sql = "SELECT DISTINCT transaction.idTransaction, title
            FROM transaction JOIN schedule JOIN film
            WHERE
                transaction.idSchedule = schedule.idSchedule AND
                schedule.idFilm = film.idFilm AND
                transaction.idTransaction = ".$query;
        $result = $db->query($sql);
        $result = $result->fetch_assoc();
        $result['rating'] = NULL;
        $result['comment'] = NULL;
        $result['submitted'] = False;
	}

    echo json_encode($result);
    return http_response_code(200);
    
} else if ($_SERVER["REQUEST_METHOD"] == "POST") { //Update atau Insert
	$_POST = json_decode(file_get_contents('php://input'), true);
	$query = '';
    if (isset($_POST['idTransaction']))
        $query = $db->real_escape_string($_POST['idTransaction']);

    echo $_POST['delete'];
    if (isset($_POST['delete'])){       
        $sql = "DELETE from review where idTransaction = ".$query;
        $result = $db->query($sql);
        return http_response_code(200);
    }
        
    $sql = "SELECT transaction.idTransaction
            FROM transaction JOIN review
            WHERE
                transaction.idTransaction = review.idTransaction AND
                transaction.idTransaction = ".$query;
                
    $result = $db->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $comment = $_POST['comment'];
        $rating = $_POST['rating'];
		$sql = "UPDATE review SET comment = '$comment',
			    rating = $rating 
			    WHERE idTransaction = $query";
        $result = $db->query($sql);
	} else {
        $comment = $_POST['comment'];
        $rating = $_POST['rating'];
		$sql = "INSERT into review(idTransaction, rating, comment) VALUES (
                $query,
                $rating,
                '$comment')";
        $result = $db->query($sql);
	}

    return http_response_code(200);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
	$_DELETE = json_decode(file_get_contents('php://input'), true);
    if (isset($_DELETE['id']))
        $query = $db->real_escape_string($_DELETE['id']);

    $sql = "DELETE from review where idTransaction = ".$query;
                
    $result = $db->query($sql);
    return http_response_code(200);
}

http_response_code(400);

