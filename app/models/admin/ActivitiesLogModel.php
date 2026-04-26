<?php
require_once __DIR__ . '/../BaseModel.php';

    class ActivitiesLogModel extends BaseModel{
        protected $activities_log = 'activites_log';
        protected $users = 'users';

        public function index(){
            try{
                $query = "
                    SELECT al.*, 
                    u.full_name as user_full_name,
                    u.role as user_role,
                    DATE_FORMAT(al.created_at, '%Y-%m-%d %H:%i:%s') as formatted_created_at
                    FROM {$this->activities_log} al
                    LEFT JOIN {$this->users} u ON al.user_id = u.id
                    ORDER BY al.created_at DESC
                ";
                $stmt = $this->con->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $logs = [];

                while($row = $result->fetch_assoc()){
                    $logs[] = $row;
                }
                $stmt->close();
                return $logs;
            }catch(Exception $e){
                throw new Exception("Error fetching activity logs: " . $e->getMessage());
            }
        }
    }

?>