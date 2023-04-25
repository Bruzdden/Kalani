<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="calendar.css">
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<title>Kalani</title>
</head>

<body>

	<?php
	session_start();
	require_once("header.php");
	?>

	<section class="section">
		<h2>New</h2>

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
			<?php
			include 'calendar.php';

			$calendar = new Calendar();

			echo $calendar->show();
			?>
		</div>
	</section>
	<footer>
	<div class="container">
		<div class="row">
		<div class="col-sm-6">
			<h3>Contact Us</h3>
			<p>Email: l.divoch@seznam.cz</p>
			<p>Phone: ne</p>
		</div>
		<div class="col-sm-6">
			<h3>Follow Us</h3>
			<p><a href="https://twitter.com/MaxmilianDao">Twitter</a></p>
			<p><a href="#">Instagram</a></p>
		</div>
		</div>
	</div>
	</footer>
	<script src="script.js"></script>
</body>
</html>
