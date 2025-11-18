<?php
require_once 'Models/DB.php';

class Course extends DB {
    protected $table = "courses";

    public function getAll() {
        $sql = "SELECT c.*, l.name AS lecturer_name 
                FROM courses c 
                LEFT JOIN lecturers l ON c.lecturer_id = l.id";

        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO courses (course_name, credit, lecturer_id) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sii", $data['course_name'], $data['credit'], $data['lecturer_id']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare(
            "UPDATE courses SET course_name=?, credit=?, lecturer_id=? WHERE id=?"
        );
        $stmt->bind_param("siii", $data['course_name'], $data['credit'], $data['lecturer_id'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
