<?php
require_once 'config/database.php';

abstract class DB {
    protected $conn;
    protected $table;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    abstract public function getAll();
    abstract public function getById($id);
    abstract public function create($data);
    abstract public function update($id, $data);
    abstract public function delete($id);
}
?>