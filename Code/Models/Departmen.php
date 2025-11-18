<?php
require_once 'Models/DB.php';

class Department extends DB {
    protected $table = 'departments';

    public function getAll() {
        return $this->conn->query("SELECT * FROM departments")->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM departments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO departments (name, building) VALUES (?, ?)");
        $stmt->bind_param("ss", $data['name'], $data['building']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE departments SET name=?, building=? WHERE id=?");
        $stmt->bind_param("ssi", $data['name'], $data['building'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM departments WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
