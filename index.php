<?php
session_start();

require_once 'controllers/authController.php';
require_once 'controllers/userController.php';
require_once 'controllers/AidController.php';


$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'acceuil';

switch ($controller) {
    case 'auth':
        $authController = new AuthController();
        if (method_exists($authController, $action)) {
            $authController->$action();
        } else {
            $authController->acceuil();
        }
        break;
    case 'user':
        $userController = new UserController();
        if (method_exists($userController, $action)) {
            $userController->$action();
        } else {
            $controller = new AidController();
            $controller->dashboard();
        }
        break;
    case 'aid':
        $aidController = new AidController();
        if(method_exists($aidController, $action)) {
            $aidController->$action();
        } else {
            $aidController->dashboard();
        }
        break;
   
    default:
        $authController = new AuthController();
        $authController->acceuil();
        break;
}
?>