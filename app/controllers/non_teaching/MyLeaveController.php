<?php
session_start();

require_once __DIR__ . '/../../../db/config.php';
require_once __DIR__ . '/../../models/non_teaching/MyLeaveModel.php';

    class MyLeaveController{
        private $myLeaveModel;
    
        // Constructor to initialize the MyLeaveModel
        public function __construct($con) {
            $this->myLeaveModel = new MyLeaveModel($con);
        }

        public function index($id) {
            try {
                return $this->myLeaveModel->index($id);
            } catch (Exception $e) {
                echo "Error fetching leave requests: " . $e->getMessage();
                return [];
            }
        }
    }

    // instantiate the controller and call the index method to get the leave requests of the logged in user
    $myLeaveModel = new MyLeaveModel($con);
    $myLeaveController = new MyLeaveController($con);
    $leave_requests = $myLeaveController->index($_SESSION['id']);

?>