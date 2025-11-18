<?php
// LOAD ALL CONTROLLERS
require_once 'Controller/LecturerController.php';
require_once 'Controller/DepartmenController.php';
require_once 'Controller/CourseController.php';

// Default controller & action
$controller = $_GET['controller'] ?? 'lecturer';
$action     = $_GET['action'] ?? 'index';

// =========================
// ROUTER
// =========================
switch ($controller) {

    // ---------------------
    // LECTURER
    // ---------------------
    case 'lecturer':
        $ctrl = new LecturerController();
        break;

    // ---------------------
    // DEPARTMENT
    // ---------------------
    case 'department':
        $ctrl = new DepartmentController();
        break;

    // ---------------------
    // COURSE
    // ---------------------
    case 'course':
        $ctrl = new CourseController();
        break;

    // ---------------------
    // DEFAULT
    // ---------------------
    default:
        $ctrl = new LecturerController();
        break;
}

// Jalankan action
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    die("Action not found: $action");
}
?>
