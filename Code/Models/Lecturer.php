<?php
// Memastikan kelas dasar koneksi database (DB) tersedia
require_once 'Models/DB.php';

// Kelas Lecturer adalah model yang bertanggung jawab untuk interaksi data dosen
// Ini mewarisi fungsionalitas dasar koneksi database dari kelas DB
class Lecturer extends DB {
    // Mendefinisikan nama tabel database yang digunakan oleh model ini
    protected $table = 'lecturers';

    /**
     * Mengambil semua data dosen dari tabel lecturers.
     * Melakukan LEFT JOIN dengan tabel departments untuk menyertakan nama departemen.
     * @return array Daftar semua dosen dengan nama departemen.
     */
    public function getAll() {
        // Query SQL untuk mengambil semua kolom dari lecturers (l) dan nama departemen (department_name)
        $sql = "SELECT l.*, d.name AS department_name 
                FROM {$this->table} l 
                LEFT JOIN departments d ON l.department_id = d.id";

        // Mengeksekusi query
        $result = $this->conn->query($sql);
        $lecturers = [];

        // Memeriksa hasil dan mengambil semua baris data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lecturers[] = $row;
            }
        }

        return $lecturers;
    }

    /**
     * Mengambil satu data dosen berdasarkan ID.
     * Melakukan LEFT JOIN dengan departments dan menggunakan prepared statement.
     * @param int $id ID dosen
     * @return array|null Data dosen atau null jika tidak ditemukan.
     */
    public function getById($id) {
        // Query SQL untuk mengambil dosen spesifik, menyertakan nama departemen
        $sql = "SELECT l.*, d.name AS department_name 
                FROM {$this->table} l
                LEFT JOIN departments d ON l.department_id = d.id
                WHERE l.id = ?";

        // Mempersiapkan statement SQL
        $stmt = $this->conn->prepare($sql);
        // Mengikat parameter ID (i = integer)
        $stmt->bind_param("i", $id);

        // Mengeksekusi statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Mengembalikan data jika ditemukan
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    /**
     * Menyimpan data dosen baru ke database.
     * Termasuk kolom department_id. Menggunakan prepared statement.
     * @param array $data Data dosen baru.
     * @return bool Hasil eksekusi.
     */
    public function create($data) {
        // Statement INSERT termasuk department_id
        $sql = "INSERT INTO {$this->table} (name, nidn, phone, join_date, department_id)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        // Mengikat 4 string (name, nidn, phone, join_date) dan 1 integer (department_id)
        $stmt->bind_param("ssssi",
            $data['name'],
            $data['nidn'],
            $data['phone'],
            $data['join_date'],
            $data['department_id']
        );

        // Mengeksekusi statement
        return $stmt->execute();
    }

    /**
     * Memperbarui data dosen yang sudah ada berdasarkan ID.
     * Termasuk pembaruan department_id. Menggunakan prepared statement.
     * @param int $id ID dosen yang akan diperbarui.
     * @param array $data Data dosen yang diperbarui.
     * @return bool Hasil eksekusi.
     */
    public function update($id, $data) {
        // Statement UPDATE termasuk department_id
        $sql = "UPDATE {$this->table}
                SET name = ?, nidn = ?, phone = ?, join_date = ?, department_id = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        // Mengikat 4 string, 1 integer (department_id), dan 1 integer (id)
        $stmt->bind_param("ssssii",
            $data['name'],
            $data['nidn'],
            $data['phone'],
            $data['join_date'],
            $data['department_id'],
            $id // ID untuk klausa WHERE
        );

        // Mengeksekusi statement
        return $stmt->execute();
    }

    /**
     * Menghapus data dosen berdasarkan ID.
     * Menggunakan prepared statement.
     * @param int $id ID dosen yang akan dihapus.
     * @return bool Hasil eksekusi.
     */
    public function delete($id) {
        // Statement DELETE
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        // Mengikat parameter ID (i = integer)
        $stmt->bind_param("i", $id);
        // Mengeksekusi statement
        return $stmt->execute();
    }

    // ==========================
    // TAMBAHAN: FUNGSI UTILITAS
    // ==========================
    /**
     * Mengambil semua daftar departemen.
     * Ini digunakan oleh Controller untuk mengisi dropdown (select box) pada form.
     * @return array Daftar semua departemen.
     */
    public function getDepartments() {
        $sql = "SELECT * FROM departments ORDER BY name ASC";
        $result = $this->conn->query($sql);

        $departments = [];

        // Mengambil semua hasil
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $departments[] = $row;
            }
        }

        return $departments;
    }
}
?>