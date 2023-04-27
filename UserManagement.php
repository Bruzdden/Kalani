<?php
session_start();

// Check if the user is logged in and has rank 1
if (!isset($_SESSION['name']) || $_SESSION['rank'] != 1) {
    header('Location: login.php');
    exit();
}

//It needs mysqlidb class so this will include it
require_once 'mysqlidb.php';



// Create a new MySQLiDB instance
$db = new MySQLiDB();

// Connect to the database
$db->_connect();


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
    $result = $db->_update('user', 'idUser', $idUser, ['rank' => 1]);
    if ($result) {
        echo "User rank updated successfully";
    } else {
        $error = $db->getLastError();
        echo "Error updating user: " . print_r($error, true);
    }
// Check if the derank admin form has been submitted
} else if (isset($_POST['derank_user'])) {
    $idUser = $_POST['user_id'];
    $result = $db->_update('user', 'idUser', $idUser, ['rank' => null]);
    if ($result) {
        echo "User rank updated successfully";
    } else {
        $error = $db->getLastError();
        echo "Error updating user: " . print_r($error, true);
    }
}

// Select the names of users from the "user" table
$users = $db->_select('user', ['idUser', 'name', 'rank']);

// Generate an HTML table with the user names and delete/make admin buttons
echo '<table class="user-table">';
echo '<thead><tr><th>User Name</th><th>Action</th></tr></thead>';
echo '<tbody>';
foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . $user['name'] . '</td>';
    echo '<td>';
    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
    echo '<input type="hidden" name="user_id" value="' . $user['idUser'] . '">';
    echo '<button class="delete-button" name="delete_user">Delete</button>';
    if (empty($user['rank'])) {
        echo '<button class="make-admin-button" name="make_admin">Make Admin</button>';
    }
    if (!empty($user['rank'])) {
        echo '<button class="derank-button" name="derank_user">Derank</button>';
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
  max-width: 800px;
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
@media screen and (max-width: 600px) {
  .user-table {
    width: 100%;
  }
}
</style>
