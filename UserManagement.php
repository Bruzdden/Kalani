<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] ."/app/db/MySQLiDB.php");



// Create a new MySQLiDB instance
$db = new MySQLiDB();


// Check if the user is logged in and has rank 1
$users = $db->_select('user',[], array("name" => $_SESSION["name"]));
if (count($users)){
    $user = $users[0];
    if (!isset($_SESSION['name']) || $user['rank'] != 2) {
        header('Location: /app/login/login.php');
        exit();
    }
}


 

// Check if the delete form has been submitted
if (isset($_POST['delete_user'])) {
    $idUser = $_POST['user_id'];
    $result = $db->_delete('user', $idUser, 'idUser');
    if ($result) {
        echo "User deleted successfully";
    } else {
        $error = $db->getLastError();
        echo "Error deleting user: " . print_r($error, true);
    }
// Check if the make admin form has been submitted
} else if (isset($_POST['make_admin'])) {
    $idUser = $_POST['user_id'];
    $result = $db->_update('user', 'idUser', $idUser, ['rank' => 2]);
    if ($result) {
        echo "User rank updated successfully";
    } else {
        $error = $db->getLastError();
        echo "Error updating user: " . print_r($error, true);
    }
// Check if the derank admin form has been submitted
} else if (isset($_POST['derank_user'])) {
    $idUser = $_POST['user_id'];
    $result = $db->_update('user', 'idUser', $idUser, ['rank' => 1]);
    if ($result) {
        echo "User rank updated successfully";
    } else {
        $error = $db->getLastError();
        echo "Error updating user: " . print_r($error, true);
    }
} else if (isset($_POST['activate_user'])) {
    $idUser = $_POST['user_id'];
    $result = $db->_update('user', 'idUser', $idUser, ['rank' => 1]);
    if ($result) {
        echo "User activated successfully";
    } else {
        $error = $db->getLastError();
        echo "Error updating user: " . print_r($error, true);
    }
} else if (isset($_POST['deactivate_user'])) {
    $idUser = $_POST['user_id'];
    $result = $db->_update('user', 'idUser', $idUser, ['rank' => 0]);
    if ($result) {
        echo "User deactivated successfully";
    } else {
        $error = $db->getLastError();
        echo "Error updating user: " . print_r($error, true);
    }
}

// Select the names of users from the "user" table
$users = $db->_select('user',[], []);

// Generate an HTML table with the user names and delete/make admin buttons
echo '<table class="user-table">';
echo '<thead><tr><th>ID</th><th>User Name</th><th>Email</th><th>Join Date</th><th>Rank</th><th>Action</th></tr></thead>';
echo '<tbody>';
foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . $user['idUser'] . '</td>';
    echo '<td>' . $user['name'] . '</td>';
    echo '<td>' . $user['email'] . '</td>';
    echo '<td>' . $user['joinDate'] . '</td>';
    echo '<td>' . $user['rank'] . '</td>';
    echo '<td>';
    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
    echo '<input type="hidden" name="user_id" value="' . $user['idUser'] . '">';
    echo '<button class="delete-button" name="delete_user">Delete</button>';
    if ($user['rank'] == 1) {
        echo '<button class="make-admin-button" name="make_admin">Make Admin</button>';
    }
    if ($user['rank'] == 2) {
        echo '<button class="derank-button" name="derank_user">Derank</button>';
    }
    if ($user['rank'] == 0){
        echo '<button class="activate-user-button" name="activate_user">Activate</button>';
    }
    if ($user['rank'] != 0){
        echo '<button class="derank-button" name="deactivate_user">Deactivate</button>';
    }
    echo '</form>';
    echo '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
?>

<style>
.user-table {
  margin: 0 auto;
  width: 80%;
  max-width: 1000px;
  border-collapse: collapse;
}
.user-table td, .user-table th {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: left;
}
.user-table th {
  background-color: #f2f2f2;
}
.delete-button {
  margin-left: 20px;
  background-color: #f44336;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 8px 16px;
  cursor: pointer;
}
.delete-button:hover {
  background-color: #d32f2f;
}
.make-admin-button {
  margin-left: 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 8px 16px;
  cursor: pointer;
}
.make-admin-button:hover {
  background-color: #3e8e41;
}
.derank-button{
  margin-left: 20px;
  background-color: #f44336;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 8px 16px;
  cursor: pointer;
}
.derank-button:hover{
  background-color: #d32f2f;
}
.activate-user-button {
    margin-left: 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 16px;
    cursor: pointer;
}
.activate-user-button:hover {
    background-color: #3e8e41;
}
@media screen and (max-width: 600px) {
  .user-table {
    width: 100%;
  }
}
</style>
