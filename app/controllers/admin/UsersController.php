<?php
session_start();
require_once __DIR__ . '/../../models/admin/UsersModel.php';
require_once __DIR__ . '/../../models/admin/DepartmentModel.php';
require_once __DIR__ . '/../../../db/config.php';
require_once __DIR__ . '/../Controller.php';
require_once __DIR__ . '/../../../helpers/message.php';
require_once __DIR__ . '/../../../helpers/activitiesLogger.php';

    class UsersController extends Controller {
        private $usersModel;
        private $departmentModel;
        private $activityLogger;

        public function __construct($con) {
            $this->usersModel = new UsersModel($con);
            $this->departmentModel = new DepartmentModel($con);
            $this->activityLogger = new ActivityLogger($con);
        }

        public function index() {
            try {
                return $this->usersModel->index();
            } catch (Exception $e) {
                echo "Error fetching users: " . $e->getMessage();
                return [];
            }
        }

        public function getDepartments() {
            try {
                return $this->departmentModel->index();
            } catch (Exception $e) {
                echo "Error fetching departments: " . $e->getMessage();
                return [];
            }
        }

        public function create($data) {
            try{
                $this->usersModel->create($data);
                $this->activityLogger->log($_SESSION['id'], $_SESSION['role'], 'CREATE', 'USERS', null, null, "User created: " . $data['full_name'], 'success');
                setFlash("success", "User created successfully.");
                header("location: ../../../../resources/views/admin/users.php");

                //make sure to exit after redirecting
                exit();
            } catch (Exception $e) {
                setFlash("error", "Error creating user: " . $e->getMessage());
                header("Location: /admin/users");
                exit();
            }
        }

        public function update($id, $data) {
            try{
                $this->usersModel->update($id, $data);
                $this->activityLogger->log($_SESSION['id'], $_SESSION['role'], 'UPDATE', 'USERS', $id, null, "User updated: " . $data['full_name'], 'success');
                setFlash("success", "User updated successfully.");
                header("location: ../../../../resources/views/admin/users.php");

                exit();
            } catch (Exception $e) {
                setFlash("error", "Error updating user: " . $e->getMessage());
                header("Location: /admin/users");
                exit();
            }
        }

        public function delete($id) {
            try{
                $this->usersModel->delete($id);
                $this->activityLogger->log($_SESSION['id'], $_SESSION['role'], 'DELETE', 'USERS', $id, null, "User deleted: " . $id, 'success');
                setFlash("success", "User deleted successfully.");
                header("location: ../../../../resources/views/admin/users.php");

                exit();
            } catch (Exception $e) {
                setFlash("error", "Error deleting user: " . $e->getMessage());
                header("Location: /admin/users");
                exit();
            }
        }

    }

    // Instantiate the controller
    $userModel = new UsersModel($con);
    $usersController = new UsersController($con);

    //get all users
    $users = $usersController->index();
    
    //get all departments
    $departments = $usersController->getDepartments();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['create_user'])){
            $usersController->create([
                'employee_no' => $_POST['employee_no'],
                'full_name' => $_POST['full_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $_POST['role'],
                'department_id' => $_POST['department_id'],
                'vacation_leave' => $_POST['vacation_leave'],
                'sick_leave' => $_POST['sick_leave'],
            ]);
        } elseif(isset($_POST['update_user'])){
            $usersController->update($_POST['id'], $_POST);
        } elseif(isset($_POST['delete_user'])){
            $usersController->delete($_POST['id']);
        }
    }

?>