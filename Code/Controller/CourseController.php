<?php
// Memastikan kelas dasar Controller dan model yang diperlukan tersedia
require_once 'Controller/BaseController.php';
require_once 'Models/Course.php';
require_once 'Models/Lecturer.php';

// Kelas CourseController menangani logika untuk mata kuliah (Courses)
// Ini mewarisi fungsionalitas umum dari BaseController
class CourseController extends BaseController {

    // Properti privat untuk menyimpan instance model Course dan Lecturer
    private $model; // Model untuk data Course
    private $lecturerModel; // Model untuk data Lecturer

    // Konstruktor kelas
    public function __construct() {
        // Inisialisasi model Course dan Lecturer
        $this->model = new Course();
        $this->lecturerModel = new Lecturer();
    }

    // Metode default (action) untuk menampilkan daftar Courses
    public function index() {
        $course = null; // Variabel untuk menyimpan data Course jika dalam mode edit

        // Jika parameter 'id' ada di URL (misalnya, jika pengguna mengklik tombol edit)
        if (isset($_GET['id'])) {
            // Ambil data Course berdasarkan ID untuk ditampilkan di form edit
            $course = $this->model->getById($_GET['id']);
        }

        // Ambil semua data courses
        $courses   = $this->model->getAll();
        // Ambil semua data lecturers (biasanya untuk digunakan di dropdown/select box)
        $lecturers = $this->lecturerModel->getAll();

        // Render view 'Courses' dan kirim data yang diperlukan
        $this->render('Courses', [
            'courses'   => $courses,     // Daftar semua courses
            'course'    => $course,     // Data course spesifik (hanya terisi jika mode edit)
            'lecturers' => $lecturers   // Daftar lecturers untuk dropdown
        ]);
    }

    // Metode untuk menangani pembuatan Course baru
    public function create() {
        // Cek apakah request adalah POST (pengiriman data form)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Panggil metode create pada model dengan data dari form
            $this->model->create($_POST);
            // Redirect kembali ke halaman index setelah berhasil
            $this->redirect("index.php?controller=course&action=index");
        }

        // Jika bukan POST, tampilkan view dengan form untuk membuat Course baru
        $this->render("Courses", [
            "page" => "create", // Mungkin digunakan di view untuk menampilkan form create
            "lecturers" => $this->lecturerModel->getAll() // Data lecturers untuk dropdown
        ]);
    }

    // Metode untuk menangani pengeditan Course
    public function edit() {
        // Ambil ID dari parameter URL
        $id = $_GET['id'];
        // Ambil data Course yang akan diedit
        $course = $this->model->getById($id);

        // Cek apakah request adalah POST (pengiriman data form edit)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Panggil metode update pada model dengan ID dan data dari form
            $this->model->update($id, $_POST);
            // Redirect kembali ke halaman index setelah berhasil
            $this->redirect("index.php?controller=course&action=index");
        }

        // Jika bukan POST, tampilkan view dengan form untuk mengedit Course
        $this->render("Courses", [
            "page" => "edit", // Mungkin digunakan di view untuk menampilkan form edit
            "course" => $course, // Data course yang akan diedit
            "lecturers" => $this->lecturerModel->getAll() // Data lecturers untuk dropdown
        ]);
    }

    // Metode untuk menangani penghapusan Course
    public function delete() {
        // Panggil metode delete pada model dengan ID dari parameter URL
        $this->model->delete($_GET['id']);
        // Redirect kembali ke halaman index setelah berhasil
        $this->redirect("index.php?controller=course&action=index");
    }
}