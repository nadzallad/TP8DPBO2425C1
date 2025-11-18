<?php
// Enable error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load class dan controller
include_once("views/Template.php");
include_once("models/DB.php");
include_once("models/Department.php");
include_once("models/Lecturer.php");
include_once("controllers/DepartmentController.php");
include_once("controllers/LecturerController.php");


// Tentukan controller dan action
$controller = $_GET['controller'] ?? 'department';
$action = $_GET['action'] ?? 'index';

// Routing controller berdasarkan parameter controller
switch($controller) {
    case 'department':
        $ctrl = new DepartmentController();
        break;
    case 'lecturer':
        $ctrl = new LecturerController();
        break;
    default:
        $ctrl = new DepartmentController();
        break;
    

}

// Routing action perdasarkan parameter action
switch($action) {
    case 'index':
        $ctrl->index();
        break;

    case 'add':
        $ctrl->add();
        break;

    case 'edit':
        $id = $_GET['id'] ?? null;
        $ctrl->edit();
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        $ctrl->delete();
        break;

    default:
        $ctrl->index();
        break;
}
