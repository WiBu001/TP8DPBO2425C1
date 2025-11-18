<?php
// Memastikan kelas dasar koneksi database (DB) tersedia
require_once 'Models/DB.php';

// Kelas Course adalah model yang bertanggung jawab untuk interaksi data mata kuliah (courses)
// Ini mewarisi fungsionalitas dasar koneksi database dan query dari kelas DB
class Course extends DB {
    // Mendefinisikan nama tabel database yang digunakan oleh model ini
    protected $table = "courses";

    /**
     * Mengambil semua data mata kuliah dari tabel courses.
     * Melakukan JOIN dengan tabel lecturers untuk menyertakan nama dosen.
     * @return array Hasil query dalam bentuk array asosiatif.
     */
    public function getAll() {
        // Query SQL untuk mengambil semua kolom dari courses (c)
        // dan nama dosen (lecturer_name) dari lecturers (l)
        $sql = "SELECT c.*, l.name AS lecturer_name 
                FROM courses c 
                LEFT JOIN lecturers l ON c.lecturer_id = l.id";

        // Mengeksekusi query dan mengembalikan semua baris sebagai array asosiatif
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Mengambil satu data mata kuliah berdasarkan ID.
     * Menggunakan prepared statement untuk keamanan.
     * @param int $id ID mata kuliah
     * @return array|null Data mata kuliah atau null jika tidak ditemukan.
     */
    public function getById($id) {
        // Mempersiapkan statement SQL untuk mencegah SQL injection
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id=?");
        // Mengikat parameter ID (i = integer)
        $stmt->bind_param("i", $id);
        // Mengeksekusi statement
        $stmt->execute();
        // Mendapatkan hasil dan mengembalikan baris pertama sebagai array asosiatif
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Menyimpan data mata kuliah baru ke database.
     * Menggunakan prepared statement.
     * @param array $data Data mata kuliah baru (course_name, credit, lecturer_id).
     * @return bool Hasil eksekusi (true jika berhasil, false jika gagal).
     */
    public function create($data) {
        // Mempersiapkan statement INSERT
        $stmt = $this->conn->prepare(
            "INSERT INTO courses (course_name, credit, lecturer_id) VALUES (?, ?, ?)"
        );
        // Mengikat parameter (s = string, i = integer)
        $stmt->bind_param("sii", $data['course_name'], $data['credit'], $data['lecturer_id']);
        // Mengeksekusi statement
        return $stmt->execute();
    }

    /**
     * Memperbarui data mata kuliah yang sudah ada berdasarkan ID.
     * Menggunakan prepared statement.
     * @param int $id ID mata kuliah yang akan diperbarui.
     * @param array $data Data mata kuliah yang diperbarui.
     * @return bool Hasil eksekusi.
     */
    public function update($id, $data) {
        // Mempersiapkan statement UPDATE
        $stmt = $this->conn->prepare(
            "UPDATE courses SET course_name=?, credit=?, lecturer_id=? WHERE id=?"
        );
        // Mengikat parameter (s = string, i = integer)
        $stmt->bind_param("siii", $data['course_name'], $data['credit'], $data['lecturer_id'], $id);
        // Mengeksekusi statement
        return $stmt->execute();
    }

    /**
     * Menghapus data mata kuliah berdasarkan ID.
     * Menggunakan prepared statement.
     * @param int $id ID mata kuliah yang akan dihapus.
     * @return bool Hasil eksekusi.
     */
    public function delete($id) {
        // Mempersiapkan statement DELETE
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id=?");
        // Mengikat parameter ID (i = integer)
        $stmt->bind_param("i", $id);
        // Mengeksekusi statement
        return $stmt->execute();
    }
}