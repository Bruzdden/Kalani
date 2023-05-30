<?php

// Requiring IDB Interface
require_once "IDB.php";

// Implement IDB Interface
class MySQLiDB implements IDB {
    //halo

    //private $dbport;
    public static $dns = null;
    public $connect;
    function __construct($file = 'db.ini') {

        if (!$settings = parse_ini_file($file, TRUE)) {
            throw new Exception('Unable to open ' . $file);
        }
        $this->dns = $settings['database']['driver']. ':host=' . $settings['database']['host']. ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : ''). ';dbname=' . $settings['database']['schema'];
        try {
            $this->connect = new PDO($this->dns, $settings['database']['username'], $settings['database']['password']);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        /*
        $this->dbhost = $dbHost;
        $this->dbuser = $dbUser;
        $this->dbpass = $dbPass;
        $this->dbname = $dbName;
        //$this->dbport = "";
        */
        /*
        $this->dbhost = "127.0.0.1";
        $this->dbuser = "root";
        $this->dbpass = "root";
        $this->dbname = "kalani";
        */
    }
    // Select what u want from database
    public function _select(string $table, array $fields = [], array $conditions = []): array {
        $sql = "SELECT " . (!empty($fields) ? implode(",", $fields) : "*") . " FROM " . $table;
        if (!empty($conditions)) {
            $where = " WHERE " . implode(" AND ", array_map(function($key, $value) {
                return "$key='" . mysqli_real_escape_string($this->connect, $value) . "'";
            }, array_keys($conditions), $conditions));
            $sql .= $where;
        }
        $result = mysqli_query($this->connect, $sql);
        if (!$result) {
            return [];
        }
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $rows;
    }
    // Insert into database
    public function _insert(string $table, array $data): bool {
        $keys = array_keys($data);
        $values = array_map(function ($value) {
            return "'" . $this->connect->real_escape_string($value) . "'";
        }, array_values($data));
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
        return mysqli_query($this->connect, $sql);
    }
    // Update database
    public function _update(string $table, string $primaryKey, int $id, array $data): bool {
        $set = array_map(function ($key, $value) {
            return "$key = '" . $this->connect->real_escape_string($value) . "'";
        }, array_keys($data), array_values($data));
        $set = implode(',', $set);
        $sql = "UPDATE $table SET $set WHERE $primaryKey = $id";
        return mysqli_query($this->connect, $sql);
    }
    // Delete from database
    public function _delete(string $table, int $id, string $primary_key = 'id'): bool {
        $sql = "DELETE FROM $table WHERE $primary_key = $id";
        return mysqli_query($this->connect, $sql);
    }
    // Delete from database more things
    public function _delete_anime(string $table, array $ids, array $primary_keys = ['id']): bool {
        $where = [];
        foreach ($primary_keys as $primary_key) {
            $where[] = "$primary_key = ?";
        }
        $where_clause = implode(' AND ', $where);
        $sql = "DELETE FROM $table WHERE $where_clause";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, str_repeat('i', count($ids)), ...$ids);
        return mysqli_stmt_execute($stmt);
    }
    public function _delete_user_after_time(string $table): bool {
        $sql = "DELETE FROM $table WHERE joinDate <= DATE_SUB(CURRENT_DATE(), INTERVAL 3 MINUTE)";
        return mysqli_query($this->connect, $sql);
    }
    // Return error message
    public function getLastError(): array {
        return array($this->connect->errno, $this->connect->sqlstate, $this->connect->error);
    }
}
