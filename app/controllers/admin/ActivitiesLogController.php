<?php
session_start();

require_once __DIR__ . '/../../models/admin/ActivitiesLogModel.php';
require_once __DIR__ . '/../../../db/config.php';

    class ActivitiesLogController {
        private $activitiesLogModel;

        public function __construct($con) {
            $this->activitiesLogModel = new ActivitiesLogModel($con);
        }

        public function index() {
            try {
                return $this->activitiesLogModel->index();
            } catch (Exception $e) {
                echo "Error fetching activity logs: " . $e->getMessage();
                return [];
            }
        }
    }

    // bootstrap the controller and fetch logs
    $activitiesLogController = new ActivitiesLogController($con);
    $logsModel = new ActivitiesLogModel($con);
    $logs = $activitiesLogController->index();

?>