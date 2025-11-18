<?php
require_once 'Models/DB.php';

class Lecturer extends DB {
    protected $table = 'lecturers';

    public function getAll() {
        // === ORIGINAL CODE TETAP ADA ===
        $sql = "SELECT l.*, d.name AS department_name 
                FROM {$this->table} l 
                LEFT JOIN departments d ON l.department_id = d.id";

        $result = $this->conn->query($sql);
        $lecturers = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lecturers[] = $row;
            }
        }

        return $lecturers;
    }

    public function getById($id) {
        // === ORIGINAL CODE TETAP ADA ===
        $sql = "SELECT l.*, d.name AS department_name 
                FROM {$this->table} l
                LEFT JOIN departments d ON l.department_id = d.id
                WHERE l.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function create($data) {
        // === TAMBAHAN department_id ===
        $sql = "INSERT INTO {$this->table} (name, nidn, phone, join_date, department_id)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi",
            $data['name'],
            $data['nidn'],
            $data['phone'],
            $data['join_date'],
            $data['department_id'] // TAMBAHAN
        );

        return $stmt->execute();
    }

    public function update($id, $data) {
        // === TAMBAHAN department_id ===
        $sql = "UPDATE {$this->table}
                SET name = ?, nidn = ?, phone = ?, join_date = ?, department_id = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ssssii",
            $data['name'],
            $data['nidn'],
            $data['phone'],
            $data['join_date'],
            $data['department_id'], // TAMBAHAN
            $id
        );

        return $stmt->execute();
    }

    public function delete($id) {
        // ORIGINAL CODE
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ==========================
    // TAMBAHAN: Ambil daftar department
    // ==========================
    public function getDepartments() {
        $sql = "SELECT * FROM departments ORDER BY name ASC";
        $result = $this->conn->query($sql);

        $departments = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $departments[] = $row;
            }
        }

        return $departments;
    }
}
?>
