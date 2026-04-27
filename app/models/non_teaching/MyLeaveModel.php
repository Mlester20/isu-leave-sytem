<?php
require_once __DIR__ . '/../BaseModel.php';

    class MyLeaveModel extends BaseModel{
        protected $leave_requests = 'leave_requests';
        protected $users = 'users';

        //pass the id of the user to get the leave requests of that user
        public function index($id){
            try{
                $stmt = $this->con->prepare("
                    SELECT lr.*,
                    u.full_name AS employee_name
                    FROM {$this->leave_requests} AS lr
                    JOIN {$this->users} AS u ON lr.employee_id = u.id
                    WHERE lr.employee_id = ?
                    ORDER BY lr.created_at DESC
                ");
                
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $leave_requests = $result->fetch_all(MYSQLI_ASSOC);
                
                return $leave_requests;
            }catch(Exception $e){
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
    }

?>