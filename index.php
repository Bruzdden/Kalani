<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>My Website</title>
</head>
<body>

	<div class="navbar">
		<img src="logo.png" alt="Logo">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="login.php">Calendar</a></li>
			<li><a href="login.php">List</a></li>
			<li><a href="#">Contact</a></li>
		</ul>

		<div class="searchbar">
			<input type="text" placeholder="Search...">
			<button>Search</button>
		</div>
		<div class="login">
			<button onclick="window.location.href='login.php'">Login</button>
		</div>
		<div class="logout">
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>
		<div class="register">
			<button onclick="window.location.href='register.php'">Register</button>
		</div>
		<div class="usermanagement">
			<button onclick="window.location.href='UserManagement.php'">UM</button>
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
	<footer>
	<div class="container">
		<div class="row">
		<div class="col-sm-6">
			<h3>Contact Us</h3>
			<p>Email: contact@mywebsite.com</p>
			<p>Phone: 555-123-4567</p>
			<p>Address: 123 Main St, Anytown USA</p>
		</div>
		<div class="col-sm-6">
			<h3>Follow Us</h3>
			<p><a href="#">Facebook</a></p>
			<p><a href="#">Twitter</a></p>
			<p><a href="#">Instagram</a></p>
		</div>
		</div>
	</div>
	</footer>



</body>
</html>
