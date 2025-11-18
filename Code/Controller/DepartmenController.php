<?php
// Memastikan kelas dasar Controller dan model yang diperlukan tersedia
require_once 'Controller/BaseController.php';
require_once 'Models/Departmen.php'; // Menggunakan nama file model yang tersedia: Departmen.php

// Kelas DepartmentController menangani semua permintaan terkait data Departemen
// Ini mewarisi fungsionalitas umum dari BaseController (seperti render dan redirect)
class DepartmentController extends BaseController {

    // Properti privat untuk menyimpan instance model Departemen
    private $model;

    // Konstruktor kelas
    public function __construct() {
        // Inisialisasi model Departemen
        $this->model = new Department();
    }

    // Metode default (action) untuk menampilkan daftar Departemen
    // Ini juga berfungsi sebagai mode tampilan utama atau inisiasi mode edit
    public function index() {
        $department = null; // Variabel untuk menyimpan data Departemen jika dalam mode edit

        // Cek apakah parameter 'id' ada di URL (misalnya, jika pengguna mengklik tombol edit)
        if (isset($_GET['id'])) {
            // Ambil data Departemen berdasarkan ID untuk mengisi form edit
            $department = $this->model->getById($_GET['id']);
        }

        // Ambil semua data departemen dari model
        $departments = $this->model->getAll();

        // Render view 'Departments' dan kirim data yang diperlukan
        $this->render('Departments', [
            'departments' => $departments, // Daftar semua departemen (untuk tabel)
            'department'  => $department   // Data departemen spesifik (untuk mengisi form edit)
        ]);
    }

    // Metode untuk menangani pembuatan Departemen baru
    public function create() {
        // Cek apakah request adalah POST (pengiriman data form)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Ambil dan susun data dari POST request
            $data = [
                'name'     => $_POST['name'],
                'building' => $_POST['building']
            ];

            // Panggil metode create pada model
            if ($this->model->create($data)) {
                // Redirect kembali ke halaman index setelah berhasil
                $this->redirect('index.php?controller=department&action=index');
            }
        }

        // Jika bukan POST, render view 'Departments' (mungkin untuk menampilkan form create)
        $this->render('Departments');
    }

    // Metode untuk menangani pengeditan Departemen
    public function edit() {
        // Validasi: Pastikan parameter 'id' tersedia
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=department&action=index');
        }

        // Ambil ID dari parameter URL
        $id = $_GET['id'];
        // Ambil data Departemen berdasarkan ID
        $department = $this->model->getById($id);

        // Validasi: Pastikan data departemen ditemukan
        if (!$department) {
            $this->redirect('index.php?controller=department&action=index');
        }

        // Cek apakah request adalah POST (pengiriman data form edit)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Ambil dan susun data yang diperbarui dari POST request
            $data = [
                'name'     => $_POST['name'],
                'building' => $_POST['building']
            ];

            // Panggil metode update pada model dengan ID dan data baru
            if ($this->model->update($id, $data)) {
                // Redirect kembali ke halaman index setelah berhasil
                $this->redirect('index.php?controller=department&action=index');
            }
        }

        // Jika bukan POST, tampilkan view dengan form edit yang sudah terisi
        $this->render('Departments', [
            'page'       => 'edit', // Memberi tahu view untuk menampilkan mode/form edit
            'department' => $department // Data departemen yang akan diedit
        ]);
    }

    // Metode untuk menangani penghapusan Departemen
    public function delete() {
        // Validasi: Pastikan parameter 'id' tersedia
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=department&action=index');
        }

        // Panggil metode delete pada model dengan ID dari parameter URL
        $this->model->delete($_GET['id']);
        // Redirect kembali ke halaman index setelah berhasil
        $this->redirect('index.php?controller=department&action=index');
    }
}