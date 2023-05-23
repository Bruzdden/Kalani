<nav class="navbar">
       <div class="navbar_left">
		   <a href="index.php"><img class="halo" src="logo.svg" alt="Logo"></a>
		   <ul>
			   <li><a href="login.php">Calendar</a></li>
			   <li><a href="login.php">List</a></li>
			   <li><a href="#">Contact</a></li>
		   </ul>
	   </div>
		<div class="navbar_right">
		<div class="searchbar">
			<form action="graphqlShow.php" method="POST">
				<input type="text" name="search" placeholder="Search...">
				<button type="submit">Search</button>
			</form>
		</div>
        <div class="puser">
		<?php
			if (isset($_SESSION['idUser'])){
				echo '<div class="user">
					<button class="userbtn" id="button"><img  class="pfp" src="profile.png"></button>
					<ul class="userlist" id="list">
					<li class="listitem">
					<div class="logout">
					<button onclick="window.location.href=\'logout.php\'">Logout</button>
					</div></li></ul></div>';}
			else {
				echo '<div class="user">
					<button class="userbtn" id="button"><img class="pfp" src="profile.png" width="20px" height="20px"></button>
					<ul class="userlist" id="list">
					<li class="listitem">
						<div class="login">
							<button onclick="window.location.href=\'login.php\'">Login</button>
						</div>
					</li>
					<li class="listitem">
						<div class="register">
							<button onclick="window.location.href=\'register.php\'">Register</button>
						</div>
					</li>
				</ul></div>';}
		?>
		</div>
		</div>
	</nav>
    <style>

.navbar {
    background-color: #683E8C;
    color: #fff;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
	align-items: center;
    padding: 10px;
}

.navbar img {
    height: 50px;
}

.navbar_left ul, .navbar_right .searchbar{
	padding: 0 20px 0 20px;
}

.navbar_left, .navbar_right{
	display: flex;
	justify-content: center;
}

.navbar ul {
    display: flex;
    list-style: none;
    justify-content: center;
    align-items: center;
}

.navbar li {
    margin: 0 10px;
}

.navbar li a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s;
}
.navbar li a:hover {
    color: #ffd700;
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
    width: 200px;
}

.searchbar button[type="submit"] {
    padding: 5px 10px;
    background-color: #ffd700;
    color: #333;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
.user {
    position: relative; 
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 10px;
}
 
.userbtn {
    top: 20px;
    right: 20px;
    border: none;
    background-color: transparent;
    cursor: pointer;
}

.pfp {
    width:35px !important;
    height:35px !important;
}

.userlist {
    display: none; 
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1; 
    padding: 0;
    margin: 0;
    list-style: none;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}
  

.listitem {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}
  
.login button,
.logout button,
.register button {
    border: none;
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
  
.login button:hover,
.logout button:hover,
.register button:hover {
    background-color: #0062cc;
}

.login,
.logout,
.register,
.usermanagement {
    margin-left: 10px;
}

.login button,
.logout button,
.register button,
.usermanagement button {
    padding: 5px 10px;
    background-color: #ffd700;
    color: #333;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login button:hover,
.logout button:hover,
.register button:hover{
    background-color: #FFD25A;
}
	</style>