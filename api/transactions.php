<?php
require_once('utils/db.php');
require_once('utils/cookie.php');
require_once('utils/request.php');

// if ($_SERVER["REQUEST_METHOD"] == "GET") {
// 	$user = get_user();

//     $sql = "SELECT DISTINCT transaction.idTransaction, title, posterUrl, dateTime, reviewStatus, durationMinutes
//             FROM transaction JOIN schedule JOIN film JOIN (
// 				SELECT transaction.idTransaction, idReview as reviewStatus
// 				FROM transaction LEFT JOIN review
// 				ON transaction.idTransaction = review.idTransaction)
// 			AS reviewcheck
//             WHERE
// 			transaction.idUser = ".$user['idUser']." AND
// 			transaction.idSchedule = schedule.idSchedule AND
// 			transaction.idTransaction = reviewcheck.idTransaction AND
// 			schedule.idFilm = film.idFilm
//             ORDER BY dateTime DESC";

//     $result = $db->query($sql);

//     $rows = array();
//     while ($row = $result->fetch_assoc()) {
// 		if (strtotime($row['dateTime']) + $row['durationMinutes'] > time())
// 			$row['reviewStatus'] = 'disabled';
// 		else if ($row['reviewStatus'] === null)
// 			$row['reviewStatus'] = 'ready';
// 		else
// 			$row['reviewStatus'] = 'submitted';
			
// 		$row['dateTime'] = date('F j, Y - h:i A', strtotime($row['dateTime']));
//         $rows[] = $row;
// 	}

//     echo json_encode($rows);
//     return http_response_code(200);
// }

// http_response_code(400);

  $getdata = callAPI("GET", "http://13.229.224.101:3000/transaksi/28", "");
  $resp = json_decode($getdata, true);
  $transactions = array();
  foreach ($resp["data"] as $trans) {
	$transactions[] = $trans;
  }
  echo(json_encode($transactions));
  return http_response_code(200);