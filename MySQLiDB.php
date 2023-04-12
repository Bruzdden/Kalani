<?php
require_once "IDB.php";

class MySQLiDB implements IDB {
    private $db;
    
    public function _connect(string $dbhost = "", string $dbuser = "", string $dbpass = "", string $dbname = ""){
        $this->db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        return null;
    }
    
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
    
    
    public function _insert(string $table, array $data): bool {
        $keys = array_keys($data);
        $values = array_map(function ($value) {
            return "'" . $this->db->real_escape_string($value) . "'";
        }, array_values($data));
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
        return mysqli_query($this->db, $sql);
    }
    
    public function _update(string $table, string $primaryKey, int $id, array $data): bool {
        $set = array_map(function ($key, $value) {
            return "$key = '" . $this->db->real_escape_string($value) . "'";
        }, array_keys($data), array_values($data));
        $set = implode(',', $set);
        $sql = "UPDATE $table SET $set WHERE $primaryKey = $id";
        return mysqli_query($this->db, $sql);
    }
    
    
    public function _delete(string $table, int $id, string $primary_key = 'id'): bool {
        $sql = "DELETE FROM $table WHERE $primary_key = $id";
        return mysqli_query($this->db, $sql);
    }

    public function getLastError(): array {
        return array($this->db->errno, $this->db->sqlstate, $this->db->error);
    }
}
