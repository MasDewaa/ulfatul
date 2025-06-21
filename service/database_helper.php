<?php
// Database helper functions for MySQL/PostgreSQL compatibility

class DatabaseHelper {
    private $db;
    private $db_type;
    
    public function __construct($db, $db_type = 'postgresql') {
        $this->db = $db;
        $this->db_type = $db_type;
    }
    
    // Execute query and return result
    public function query($sql, $params = []) {
        if ($this->db_type === 'postgresql') {
            return $this->pdoQuery($sql, $params);
        } else {
            return $this->mysqliQuery($sql, $params);
        }
    }
    
    // PDO query execution
    private function pdoQuery($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            error_log("PDO Query Error: " . $e->getMessage());
            return false;
        }
    }
    
    // MySQLi query execution
    private function mysqliQuery($sql, $params = []) {
        // Simple parameter replacement for MySQLi
        foreach ($params as $param) {
            $sql = preg_replace('/\?/', "'" . $this->db->real_escape_string($param) . "'", $sql, 1);
        }
        return $this->db->query($sql);
    }
    
    // Fetch all rows
    public function fetchAll($sql, $params = []) {
        $result = $this->query($sql, $params);
        if ($this->db_type === 'postgresql') {
            return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
        } else {
            $rows = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
            return $rows;
        }
    }
    
    // Fetch single row
    public function fetchOne($sql, $params = []) {
        $result = $this->query($sql, $params);
        if ($this->db_type === 'postgresql') {
            return $result ? $result->fetch(PDO::FETCH_ASSOC) : false;
        } else {
            return $result ? $result->fetch_assoc() : false;
        }
    }
    
    // Insert data and return last insert ID
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        if ($this->db_type === 'postgresql') {
            $sql .= " RETURNING id";
            $result = $this->query($sql, array_values($data));
            return $result ? $result->fetch(PDO::FETCH_ASSOC)['id'] : false;
        } else {
            $this->query($sql, array_values($data));
            return $this->db->insert_id;
        }
    }
    
    // Update data
    public function update($table, $data, $where, $where_params = []) {
        $set_clause = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE $table SET $set_clause WHERE $where";
        
        $params = array_merge(array_values($data), $where_params);
        return $this->query($sql, $params);
    }
    
    // Delete data
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql, $params);
    }
    
    // Get row count
    public function rowCount($result) {
        if ($this->db_type === 'postgresql') {
            return $result ? $result->rowCount() : 0;
        } else {
            return $result ? $result->num_rows : 0;
        }
    }
}

// Global database helper instance
global $db_helper;
$db_helper = new DatabaseHelper($db, $db_type);
?> 