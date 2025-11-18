<?php
require_once 'Controller/BaseController.php';
require_once 'Models/Departmen.php';

class DepartmentController extends BaseController {

    private $model;

    public function __construct() {
        $this->model = new Department();
    }

    public function index() {
        $department = null;

        if (isset($_GET['id'])) {
            $department = $this->model->getById($_GET['id']);
        }

        $departments = $this->model->getAll();

        $this->render('Departments', [
            'departments' => $departments,
            'department'  => $department
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'name'     => $_POST['name'],
                'building' => $_POST['building']
            ];

            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=department&action=index');
            }
        }

        $this->render('Departments');
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=department&action=index');
        }

        $id = $_GET['id'];
        $department = $this->model->getById($id);

        if (!$department) {
            $this->redirect('index.php?controller=department&action=index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'name'     => $_POST['name'],
                'building' => $_POST['building']
            ];

            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=department&action=index');
            }
        }

        $this->render('Departments', [
            'page'       => 'edit',
            'department' => $department
        ]);
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?controller=department&action=index');
        }

        $this->model->delete($_GET['id']);
        $this->redirect('index.php?controller=department&action=index');
    }
}
