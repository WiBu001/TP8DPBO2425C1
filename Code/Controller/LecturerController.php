<?php
require_once 'Controller/BaseController.php';
require_once 'Models/Lecturer.php';

class LecturerController extends BaseController {
    private $lecturerModel;

    public function __construct() {
        $this->lecturerModel = new Lecturer();
    }

    public function index() {
        $lecturer = null;

        // Jika klik tombol edit (pakai id di index)
        if (isset($_GET['id'])) {
            $lecturer = $this->lecturerModel->getById($_GET['id']);
        }

        $lecturers = $this->lecturerModel->getAll();
        $departments = $this->lecturerModel->getDepartments();

        $this->render('Lecturers', [
            'lecturers'   => $lecturers,
            'lecturer'    => $lecturer,
            'departments' => $departments   // <-- Tambahkan department untuk dropdown
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'name'          => $_POST['name'],
                'nidn'          => $_POST['nidn'],
                'phone'         => $_POST['phone'],
                'join_date'     => $_POST['join_date'],
                'department_id' => $_POST['department_id']  // <-- Tambahan
            ];

            if ($this->lecturerModel->create($data)) {
                $this->redirect('index.php?controller=lecturer&action=index');
            }
        }

        $departments = $this->lecturerModel->getDepartments();

        $this->render('Lecturers', [
            'departments' => $departments
        ]);
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=lecturer&action=index');
        }

        $id = $_GET['id'];
        $lecturer = $this->lecturerModel->getById($id);

        if (!$lecturer) {
            $this->redirect('index.php?controller=lecturer&action=index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'name'          => $_POST['name'],
                'nidn'          => $_POST['nidn'],
                'phone'         => $_POST['phone'],
                'join_date'     => $_POST['join_date'],
                'department_id' => $_POST['department_id'] // <-- Tambahan
            ];

            if ($this->lecturerModel->update($id, $data)) {
                $this->redirect('index.php?controller=lecturer&action=index');
            }
        }

        $departments = $this->lecturerModel->getDepartments();

        $this->render('Lecturers', [
            'page'        => 'edit',
            'lecturer'    => $lecturer,
            'departments' => $departments
        ]);
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=lecturer&action=index');
        }

        $id = $_GET['id'];

        if ($this->lecturerModel->delete($id)) {
            $this->redirect('index.php?controller=lecturer&action=index');
        }
    }
}
?>
