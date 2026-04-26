<?php
session_start();

require_once __DIR__ . '/../../models/admin/DepartmentModel.php';
require_once __DIR__ . '/../../../db/config.php';
require_once __DIR__ . '/../../../helpers/message.php';
require_once __DIR__ . '/../../../helpers/activitiesLogger.php';
require_once __DIR__ . '/../Controller.php';

    class DepartmentController extends Controller{
        private $departmentModel;
        private $activityLogger;

        public function __construct($con){
            $this->departmentModel = new DepartmentModel($con);
            $this->activityLogger = new ActivityLogger($con);
        }

        public function index(){
            return $this->departmentModel->index();
        }

        public function create($data){
            try{
                $this->departmentModel->create($data);
                $this->activityLogger->log($_SESSION['id'], $_SESSION['role'], 'CREATE', 'DEPARTMENT', null, null, "Department created: " . $data['name'], 'success');
                
                setFlash("success", "Department created successfully.");
                header("location: ../../../../resources/views/admin/departments.php");
                exit();
            }catch(Exception $e){
                echo "Error creating department: " . $e->getMessage();
            }
        }

        public function update($id, $data){
                try{
                    $this->departmentModel->update($id, $data);
                    $this->activityLogger->log($_SESSION['id'], $_SESSION['role'], 'UPDATE', 'DEPARTMENT', $id, null, "Department updated: " . $data['name'], 'success');
                    setFlash("success", "Department updated successfully.");
                    header("location: ../../../../resources/views/admin/departments.php");
                    exit();
                }catch(Exception $e){
                    echo "Error updating department: " . $e->getMessage();
                }
        }   

        public function delete($id){
            try{
                $this->departmentModel->delete($id);
                $this->activityLogger->log($_SESSION['id'], $_SESSION['role'], 'DELETE', 'DEPARTMENT', $id, null, "Department deleted: ID " . $id, 'success');
                setFlash("success", "Department deleted successfully.");
                header("location: ../../../../resources/views/admin/departments.php");
                exit();
            }catch(Exception $e){
                echo "Error deleting department: " . $e->getMessage();
            }
        }
    }

    //bootstrap the controller
    $departmentModel = new DepartmentModel($con);
    $departmentController = new DepartmentController($con);

    $departments = $departmentController->index();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['create_department'])){
            $departmentController->create([
                'department_name' => $_POST['department_name']
            ]);
        }
        if(isset($_POST['update_department'])){
            $departmentController->update($_POST['id'], $_POST);
        }
        if(isset($_POST['delete_department'])){
            $departmentController->delete($_POST['id']);
        }
    }

?>