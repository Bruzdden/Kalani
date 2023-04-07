<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Website</title>
	<style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			font-family: Arial, sans-serif;
		}

		.navbar {
			background-color: #333;
			color: #fff;
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			padding: 10px;
		}

		.navbar img {
			height: 50px;
		}

		.navbar ul {
			display: flex;
			list-style: none;
		}

		.navbar li {
			margin: 0 10px;
		}

		.navbar li a {
			color: #fff;
			text-decoration: none;
		}

		.searchbar {
			display: flex;
			align-items: center;
		}

		.searchbar input[type="text"] {
			padding: 5px;
			border: none;
			border-radius: 3px;
			margin-right: 5px;
		}

		.searchbar button {
			padding: 5px 10px;
			border: none;
			border-radius: 3px;
			background-color: #4CAF50;
			color: #fff;
			cursor: pointer;
		}

		.section {
			display: flex;
			flex-wrap: wrap;
			padding: 10px;
			margin: 10px 0;
		}

		.section h2 {
			font-size: 24px;
			font-weight: bold;
			flex-basis: 100%;
			margin: 10px 0;
		}

		.item {
			display: flex;
			flex-direction: column;
			flex-basis: calc(20% - 20px);
			margin: 10px;
			border: 1px solid #ccc;
			padding: 10px;
			border-radius: 5px;
		}

		.item img {
			width: 100%;
			height: 150px;
			object-fit: cover;
			margin-bottom: 10px;
		}

		.item h3 {
			font-size: 16px;
			font-weight: bold;
			margin: 0;
			text-align: center;
		}

		.calendar {
			flex-basis: calc(30% - 20px);
			margin: 10px;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}

		.calendar h2 {
			font-size: 24px;
			font-weight: bold;
			margin: 10px 0;
		}

		.calendar iframe {
			width: 100%;
			height: 500px;
			border: none;
		}

		@media screen and (max-width: 768px) {
			.section {
				flex-direction: column;
			}

			.item {
				flex-basis: calc(50% - 20px);
			}

			.calendar {
				flex-basis: 100%;
			}
		}
	</style>
</head>
<body>

	<div class="navbar">
		<img src="logo.png" alt="Logo">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Calendar</a></li>
			<li><a href="#">List</a></li>
			<li><a href="#">Contact</a></li>
		</ul>

		<div class="searchbar">
			<input type="text" placeholder="Search...">
			<button>Search</button>
		</div>
		<div class="register">
			<button onclick="window.location.href='register.php'">Register</button>
		</div>
	</div>

	<div class="section">
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
	</div>

	<div class="section">
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
		<div class="calendar">
			<h2>Calendar</h2>
			<iframe src="https://calendar.google.com/calendar/embed?src=YOUR_CALENDAR_ID_HERE&ctz=Europe%2FLondon" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>

</body>
</html>
