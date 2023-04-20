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

	<nav class="navbar">
		<img class="halo" src="logo.svg" alt="Logo">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="login.php">Calendar</a></li>
			<li><a href="login.php">List</a></li>
			<li><a href="#">Contact</a></li>
		</ul>

		<div class="searchbar">
			<form action="graphql.php" method="POST">
				<input type="text" name="search" placeholder="Search...">
				<button type="submit">Search</button>
			</form>
		</div>
		<div class="logout">
			<button onclick="window.location.href='logout.php'">Logout</button>
		</div>
		<div class="user">
			<button class="userbtn" id="button"><img src="profile.png"></button>
			<ul class="userlist" id="list">
				<li class="listitem">
					<div class="login">
						<button onclick="window.location.href='login.php'">Login</button>
					</div>
				</li>
				<li class="listitem">
					<div class="register">
						<button onclick="window.location.href='register.php'">Registerr</button>
					</div>
				</li>
			</ul>
		</div>
	</nav>

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
