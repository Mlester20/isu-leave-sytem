<?php
require_once __DIR__ . '/../BaseModel.php';

class ApplyLeaveModel extends BaseModel {
    protected $table = 'leave_requests';

    /**
     * Create a new leave request
     */
    public function create($data) {
        global $con;

        $stmt = $con->prepare("
            INSERT INTO leave_requests 
                (employee_id, leave_type, days, start_date, end_date, reason, attachment_note, status, created_at)
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, 'Pending HRMO', NOW())
        ");

        $stmt->bind_param(
            'isdssss',
            $data['employee_id'],
            $data['leave_type'],
            $data['days'],
            $data['start_date'],
            $data['end_date'],
            $data['reason'],
            $data['attachment_note']
        );

        if ($stmt->execute()) {
            return $con->insert_id;
        }

        return false;
    }

    /**
     * Find a leave request by ID
     */
    public function find($id) {
        global $con;

        $stmt = $con->prepare("
            SELECT lr.*, u.full_name, u.position, d.department_name,
                   u.vacation_leave, u.sick_leave
            FROM leave_requests lr
            JOIN users u ON lr.employee_id = u.id
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE lr.id = ?
        ");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Fill and validate model data from the form
     */
    public function fill($data) {
        $allowed = ['employee_id', 'leave_type', 'days', 'start_date', 'end_date', 'reason', 'attachment_note'];
        $filled  = [];

        foreach ($allowed as $field) {
            $filled[$field] = isset($data[$field]) ? trim($data[$field]) : null;
        }

        return $filled;
    }

    /**
     * Get all leave requests of a specific employee
     */
    public function getByEmployee($employee_id) {
        global $con;

        $stmt = $con->prepare("
            SELECT * FROM leave_requests
            WHERE employee_id = ?
            ORDER BY created_at DESC
        ");

        $stmt->bind_param('i', $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Deduct leave balance from the user after successful request
     */
    public function deductBalance($employee_id, $leave_type, $days) {
        global $con;

        $column = $leave_type === 'Vacation' ? 'vacation_leave' : 'sick_leave';

        $stmt = $con->prepare("
            UPDATE users
            SET {$column} = {$column} - ?
            WHERE id = ?
        ");

        $stmt->bind_param('di', $days, $employee_id);
        return $stmt->execute();
    }

    /**
     * Get current leave balances for a user
     */
    public function getBalance($employee_id) {
        global $con;

        $stmt = $con->prepare("
            SELECT vacation_leave, sick_leave FROM users WHERE id = ?
        ");

        $stmt->bind_param('i', $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
?>