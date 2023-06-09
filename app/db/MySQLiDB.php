<?php

// Requiring IDB Interface
require_once "IDB.php";

// Implement IDB Interface
class MySQLiDB implements IDB {
    private $db;
    
    function __construct() {
        $host = getenv('DB_HOST');
        $username = getenv('DB_UN');
        $password = getenv('DB_PW');
        $schema = getenv('DB_SCHEMA');
        $mysqli = new mysqli($host, $username, $password, $schema);

        if ($mysqli->connect_error) {
            die('Connect Error: ' . $mysqli->connect_error);
        }

        $this->db = $mysqli;
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
        $sql = "DELETE FROM $table WHERE joinDate <= DATE_SUB(CURRENT_DATE(), INTERVAL 3 MINUTE)";
        return mysqli_query($this->db, $sql);
    }
    
    // Return error message
    public function getLastError(): array {
        return array($this->db->errno, $this->db->sqlstate, $this->db->error);
    }
}
