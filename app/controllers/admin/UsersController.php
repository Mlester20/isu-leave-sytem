<?php
session_start();
require_once __DIR__ . '/../../models/admin/UsersModel.php';
require_once __DIR__ . '/../../../db/config.php';
require_once __DIR__ . '/../Controller.php';
require_once __DIR__ . '/../../../helpers/message.php';

    class UsersController extends Controller {
        private $usersModel;

        public function __construct($con) {
            $this->usersModel = new UsersModel($con);
        }

        public function index() {
            try {
                return $this->usersModel->index();
            } catch (Exception $e) {
                echo "Error fetching users: " . $e->getMessage();
                return [];
            }
        }

        public function create($data) {
            try{
                $this->usersModel->create($data);
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

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['create_user'])){
            $usersController->create([
                'employee_no' => $_POST['employee_no'],
                'full_name' => $_POST['full_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $_POST['role'],
                'department' => $_POST['department'],
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