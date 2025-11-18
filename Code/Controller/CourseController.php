<?php
require_once 'Controller/BaseController.php';
require_once 'Models/Course.php';
require_once 'Models/Lecturer.php';

class CourseController extends BaseController {

    private $model;
    private $lecturerModel;

    public function __construct() {
        $this->model = new Course();
        $this->lecturerModel = new Lecturer();
    }

    public function index() {
        $course = null;

        // Jika klik tombol edit
        if (isset($_GET['id'])) {
            $course = $this->model->getById($_GET['id']);
        }

        // Ambil semua data courses & lecturers (untuk dropdown)
        $courses   = $this->model->getAll();
        $lecturers = $this->lecturerModel->getAll();

        // Kirim data ke view
        $this->render('Courses', [
            'courses'   => $courses,
            'course'    => $course,     // data untuk mode edit
            'lecturers' => $lecturers   // agar dropdown tetap muncul
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            $this->redirect("index.php?controller=course&action=index");
        }

        $this->render("Courses", [
            "page" => "create",
            "lecturers" => $this->lecturerModel->getAll()
        ]);
    }

    public function edit() {
        $id = $_GET['id'];
        $course = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            $this->redirect("index.php?controller=course&action=index");
        }

        $this->render("Courses", [
            "page" => "edit",
            "course" => $course,
            "lecturers" => $this->lecturerModel->getAll()
        ]);
    }

    public function delete() {
        $this->model->delete($_GET['id']);
        $this->redirect("index.php?controller=course&action=index");
    }
}
