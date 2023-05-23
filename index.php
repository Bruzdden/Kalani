<?php
session_start();

require_once "MySQLiDB.php";
// Create a new MySQLiDB instance
$db = new MySQLiDB();

// Connect to the database
$db->_connect();

$select = $db->_select('user', array(), array());
    if (count($select) == 1){
	$delete = $db->_delete_user_after_time('user');
	if (!$delete) {
		$error = $db->getLastError();
		echo "Error deleting user: " . print_r($error, true);
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="calendar.css">
	<link rel="stylsheet" type="text/css" href="/vendor/benhall14/php-calendar/html/css/calendar.min.css">
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<title>Kalani</title>
</head>

<body>

	<?php
	require_once("header.php");

	?>
	<img src="kalani.png" alt="kalani" width="100%" height="500px">

	<?php
	//require_once("graphql.php");

	?>

	<section class="section">
		<h2>5 New Anime</h2>

		<div class="item">
			<img src="item1.jpg" alt="Item 1">
			<h3>Item 1</h3>
		</div>

		<div class="item">
			<img src="item2.jpg" alt="Item 2">
			<h3>Item 2</h3>
		</div>

		<div class="item">
			<img src="item3.jpg" alt="Item 3">
			<h3>Item 3</h3>
		</div>

		<div class="item">
			<img src="item4.jpg" alt="Item 4">
			<h3>Item 4</h3>
		</div>

		<div class="item">
			<img src="item5.jpg" alt="Item 5">
			<h3>Item 5</h3>
		</div>
	</section>

	<section class="section">
		<h2>Popular</h2>

		<div class="item">
			<img src="item6.jpg" alt="Item 6">
			<h3>Item 6</h3>
		</div>

		<div class="item">
			<img src="item7.jpg" alt="Item 7">
			<h3>Item 7</h3>
		</div>

		<div class="item">
			<img src="item8.jpg" alt="Item 8">
			<h3>Item 8</h3>
		</div>

		<div class="item">
			<img src="item9.jpg" alt="Item 9">
			<h3>Item 9</h3>
		</div>
			<div class="item">
				<img src="item10.jpg" alt="Item 10">
				<h3>Item 10</h3>
			</div>
		</div>

		<div class="section">
			<form method="post"><input type="hidden" name="next" value="next"><button type="submit" name="next">next</button></form>
			<?php
			require __DIR__ . '/vendor/autoload.php';
			use benhall14\phpCalendar\Calendar as Calendar;
			
			$calendar = new Calendar;
			$calendar->stylesheet();

			$select = $db->_select('anime', [], ['idUser' => $_SESSION['idUser']]);
			foreach ($select as $anime) {
				$airingDate = date("Y-m-d", strtotime($anime["airingDate"]));
				$idAnime = (string)$anime["idAnime"];
				$sumary = ($idAnime . "</br>" . $airingDate . "</br>");
				$events[] = array(
					'start' =>  $airingDate,
					'end' =>  $airingDate,
					'mask' => true,
					'summary' => $sumary,
				);
				
			}
			$calendar->addEvents($events);
			$calendar->display();
			
			
		
			
			?>
		</div>
	</section>
	<footer>
	<div class="container">
		<div class="row">
		<div class="col-sm-6">
			<h3>Contact Us</h3>
			<p>Email: l.divoch@seznam.cz</p>
			<p>Phone: +420 776 394 802</p>
		</div>
		<div class="col-sm-6">
			<h3>Follow Us</h3>
			<p><a href="#">Instagram</a></p>
		</div>
		</div>
	</div>
	</footer>
	<script src="script.js"></script>
</body>
</html>
