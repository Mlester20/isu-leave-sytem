<?php
require_once __DIR__ . '/../app/models/BaseModel.php';

class ActivityLogger extends BaseModel{
    public function log($user_id, $role, $action, $module, $reference_id = null, $reference_table = null, $description = '', $status = 'success') {
        try {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
            $status_flag = ($status === 'success') ? 1 : 0;

            $sql = "INSERT INTO activites_log 
                    (user_id, role, action, module, reference_id, reference_table, description, ip_address, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->con->prepare($sql);

            if (!$stmt) {
                throw new Exception($this->con->error);
            }

            $stmt->bind_param(
                "isssisisi",
                $user_id,
                $role,
                $action,
                $module,
                $reference_id,
                $reference_table,
                $description,
                $ip,
                $status_flag
            );

            $stmt->execute();
            $stmt->close();

        } catch (Exception $e) {
            error_log("Error logging activity: " . $e->getMessage());
        }
    }
}

?>