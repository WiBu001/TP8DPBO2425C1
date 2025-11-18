<?php
// Memastikan kelas dasar Controller dan model yang diperlukan tersedia
require_once 'Controller/BaseController.php';
require_once 'Models/Lecturer.php';

// Kelas LecturerController menangani semua permintaan terkait data Dosen/Staf Pengajar
// Ini mewarisi fungsionalitas umum dari BaseController
class LecturerController extends BaseController {
    // Properti privat untuk menyimpan instance model Lecturer
    private $lecturerModel;

    // Konstruktor kelas
    public function __construct() {
        // Inisialisasi model Lecturer
        $this->lecturerModel = new Lecturer();
    }

    // Metode default (action) untuk menampilkan daftar Dosen
    // Ini juga berfungsi sebagai mode tampilan utama atau inisiasi mode edit
    public function index() {
        $lecturer = null; // Variabel untuk menyimpan data Dosen jika dalam mode edit

        // Jika parameter 'id' ada di URL (misalnya, jika pengguna mengklik tombol edit)
        if (isset($_GET['id'])) {
            // Ambil data Dosen berdasarkan ID untuk mengisi form edit
            $lecturer = $this->lecturerModel->getById($_GET['id']);
        }

        // Ambil semua data dosen
        $lecturers = $this->lecturerModel->getAll();
        // Ambil semua data departemen (untuk dropdown, diasumsikan ada metode ini di model Lecturer)
        $departments = $this->lecturerModel->getDepartments();

        // Render view 'Lecturers' dan kirim data yang diperlukan
        $this->render('Lecturers', [
            'lecturers'   => $lecturers,     // Daftar semua dosen (untuk tabel)
            'lecturer'    => $lecturer,     // Data dosen spesifik (untuk mengisi form edit)
            'departments' => $departments   // Data departemen untuk dropdown pada form
        ]);
    }

    // Metode untuk menangani pembuatan Dosen baru
    public function create() {
        // Cek apakah request adalah POST (pengiriman data form)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Ambil dan susun data dari POST request, termasuk department_id
            $data = [
                'name'          => $_POST['name'],
                'nidn'          => $_POST['nidn'],
                'phone'         => $_POST['phone'],
                'join_date'     => $_POST['join_date'],
                'department_id' => $_POST['department_id']
            ];

            // Panggil metode create pada model
            if ($this->lecturerModel->create($data)) {
                // Redirect kembali ke halaman index setelah berhasil
                $this->redirect('index.php?controller=lecturer&action=index');
            }
        }

        // Ambil data departemen
        $departments = $this->lecturerModel->getDepartments();

        // Jika bukan POST, render view 'Lecturers' (mungkin untuk menampilkan form create)
        $this->render('Lecturers', [
            'departments' => $departments // Data departemen untuk dropdown
        ]);
    }

    // Metode untuk menangani pengeditan Dosen
    public function edit() {
        // Validasi: Pastikan parameter 'id' tersedia
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=lecturer&action=index');
        }

        // Ambil ID dari parameter URL
        $id = $_GET['id'];
        // Ambil data Dosen yang akan diedit
        $lecturer = $this->lecturerModel->getById($id);

        // Validasi: Pastikan data dosen ditemukan
        if (!$lecturer) {
            $this->redirect('index.php?controller=lecturer&action=index');
        }

        // Cek apakah request adalah POST (pengiriman data form edit)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Ambil dan susun data yang diperbarui dari POST request
            $data = [
                'name'          => $_POST['name'],
                'nidn'          => $_POST['nidn'],
                'phone'         => $_POST['phone'],
                'join_date'     => $_POST['join_date'],
                'department_id' => $_POST['department_id']
            ];

            // Panggil metode update pada model
            if ($this->lecturerModel->update($id, $data)) {
                // Redirect kembali ke halaman index setelah berhasil
                $this->redirect('index.php?controller=lecturer&action=index');
            }
        }

        // Ambil data departemen
        $departments = $this->lecturerModel->getDepartments();

        // Jika bukan POST, tampilkan view dengan form edit yang sudah terisi
        $this->render('Lecturers', [
            'page'        => 'edit',       // Memberi tahu view untuk menampilkan mode/form edit
            'lecturer'    => $lecturer,   // Data dosen yang akan diedit
            'departments' => $departments // Data departemen untuk dropdown
        ]);
    }

    // Metode untuk menangani penghapusan Dosen
    public function delete() {
        // Validasi: Pastikan parameter 'id' tersedia
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=lecturer&action=index');
        }

        // Ambil ID dari parameter URL
        $id = $_GET['id'];

        // Panggil metode delete pada model
        if ($this->lecturerModel->delete($id)) {
            // Redirect kembali ke halaman index setelah berhasil
            $this->redirect('index.php?controller=lecturer&action=index');
        }
    }
}
?>