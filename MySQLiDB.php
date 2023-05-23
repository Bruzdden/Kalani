<?php

// Requiring IDB Interface
require_once "IDB.php";

// Implement IDB Interface
class MySQLiDB implements IDB {
    private $db;
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;

    //private $dbport;

    // Set variables of MySQLiDB
    public function __construct(){
        /*
        $this->dbhost = "eu-cdbr-west-03.cleardb.net";
        $this->dbuser = "be2b1c824379d3";
        $this->dbpass = "134e6006b6104cc";
        $this->dbname = "heroku_ad8d77f8147aa6f";
        //$this->dbport = "";
        */
        $this->dbhost = "127.0.0.1";
        $this->dbuser = "root";
        $this->dbpass = "root";
        $this->dbname = "kalani";
    }
    // Connect to database
    public function _connect() {
        $this->db = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        return null;
    }
    // Select what u want from database
    public function _select(string $table, array $fields = [], array $conditions = []): array {
        $sql = "SELECT " . (!empty($fields) ? implode(",", $fields) : "*") . " FROM " . $table;
        if (!empty($conditions)) {
            $where = " WHERE " . implode(" AND ", array_map(function($key, $value) {
                return "$key='" . mysqli_real_escape_string($this->db, $value) . "'";
            }, array_keys($conditions), $conditions));
            $sql .= $where;
        }
        $result = mysqli_query($this->db, $sql);
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
            return "'" . $this->db->real_escape_string($value) . "'";
        }, array_values($data));
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
        return mysqli_query($this->db, $sql);
    }
    // Update database
    public function _update(string $table, string $primaryKey, int $id, array $data): bool {
        $set = array_map(function ($key, $value) {
            return "$key = '" . $this->db->real_escape_string($value) . "'";
        }, array_keys($data), array_values($data));
        $set = implode(',', $set);
        $sql = "UPDATE $table SET $set WHERE $primaryKey = $id";
        return mysqli_query($this->db, $sql);
    }
    // Delete from database
    public function _delete(string $table, int $id, string $primary_key = 'id'): bool {
        $sql = "DELETE FROM $table WHERE $primary_key = $id";
        return mysqli_query($this->db, $sql);
    }
    // Delete from database more things
    public function _delete_anime(string $table, array $ids, array $primary_keys = ['id']): bool {
        $where = [];
        foreach ($primary_keys as $primary_key) {
            $where[] = "$primary_key = ?";
        }
        $where_clause = implode(' AND ', $where);
        $sql = "DELETE FROM $table WHERE $where_clause";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, str_repeat('i', count($ids)), ...$ids);
        return mysqli_stmt_execute($stmt);
    }
    public function _delete_user_after_time(string $table): bool {
        $sql = "DELETE FROM $table WHERE joinDate <= DATE_SUB(CURRENT_DATE(), INTERVAL 3 MINUTE) AND 'rank' IS NULL";
        return mysqli_query($this->db, $sql);
    }
    // Return error message
    public function getLastError(): array {
        return array($this->db->errno, $this->db->sqlstate, $this->db->error);
    }
}
