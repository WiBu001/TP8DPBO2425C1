<?php
// Memastikan kelas dasar koneksi database (DB) tersedia
require_once 'Models/DB.php';

// Kelas Department adalah model yang bertanggung jawab untuk interaksi data departemen
// Ini mewarisi fungsionalitas dasar koneksi database dari kelas DB
class Department extends DB {
    // Mendefinisikan nama tabel database yang digunakan oleh model ini
    protected $table = 'departments';

    /**
     * Mengambil semua data departemen dari tabel 'departments'.
     * @return array Hasil query dalam bentuk array asosiatif.
     */
    public function getAll() {
        // Mengeksekusi query SELECT * dan mengembalikan semua baris sebagai array asosiatif
        return $this->conn->query("SELECT * FROM departments")->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Mengambil satu data departemen berdasarkan ID.
     * Menggunakan prepared statement untuk keamanan.
     * @param int $id ID departemen
     * @return array|null Data departemen atau null jika tidak ditemukan.
     */
    public function getById($id) {
        // Mempersiapkan statement SQL: SELECT dengan placeholder (?)
        $stmt = $this->conn->prepare("SELECT * FROM departments WHERE id = ?");
        // Mengikat parameter ID (i = integer)
        $stmt->bind_param("i", $id);
        // Mengeksekusi statement
        $stmt->execute();
        // Mendapatkan hasil dan mengembalikan baris pertama sebagai array asosiatif
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Menyimpan data departemen baru ke database.
     * Menggunakan prepared statement untuk mencegah SQL injection.
     * @param array $data Data departemen baru (name, building).
     * @return bool Hasil eksekusi (true jika berhasil, false jika gagal).
     */
    public function create($data) {
        // Mempersiapkan statement INSERT dengan placeholder (?)
        $stmt = $this->conn->prepare("INSERT INTO departments (name, building) VALUES (?, ?)");
        // Mengikat parameter (ss = dua string)
        $stmt->bind_param("ss", $data['name'], $data['building']);
        // Mengeksekusi statement
        return $stmt->execute();
    }

    /**
     * Memperbarui data departemen yang sudah ada berdasarkan ID.
     * Menggunakan prepared statement.
     * @param int $id ID departemen yang akan diperbarui.
     * @param array $data Data departemen yang diperbarui.
     * @return bool Hasil eksekusi.
     */
    public function update($id, $data) {
        // Mempersiapkan statement UPDATE dengan placeholder (?)
        $stmt = $this->conn->prepare("UPDATE departments SET name=?, building=? WHERE id=?");
        // Mengikat parameter (ss = dua string, i = integer untuk ID)
        $stmt->bind_param("ssi", $data['name'], $data['building'], $id);
        // Mengeksekusi statement
        return $stmt->execute();
    }

    /**
     * Menghapus data departemen berdasarkan ID.
     * Menggunakan prepared statement.
     * @param int $id ID departemen yang akan dihapus.
     * @return bool Hasil eksekusi.
     */
    public function delete($id) {
        // Mempersiapkan statement DELETE dengan placeholder (?)
        $stmt = $this->conn->prepare("DELETE FROM departments WHERE id=?");
        // Mengikat parameter ID (i = integer)
        $stmt->bind_param("i", $id);
        // Mengeksekusi statement
        return $stmt->execute();
    }
}