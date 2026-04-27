<?php
require_once __DIR__ . '/../../../db/config.php';
require_once __DIR__ . '/../../../helpers/message.php';
require_once __DIR__ . '/../../../app/models/non_teaching/ApplyLeaveModel.php';

class ApplyLeaveController {

    private ApplyLeaveModel $model;

    public function __construct($con) {
        $this->model = new ApplyLeaveModel($con);
    }

    /**
     * Submit a new leave application (called via AJAX)
     */
    public function store($postData, $userId) {
        // --- Sanitize & fill ---
        $data = $this->model->fill($postData);
        $data['employee_id'] = (int) $userId;

        // --- Validate required fields ---
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $this->json(false, implode(' ', $errors));
        }

        // --- Check sufficient balance ---
        $balance = $this->model->getBalance($userId);

        if ($data['leave_type'] === 'Vacation' && $data['days'] > $balance['vacation_leave']) {
            return $this->json(false, 'Insufficient vacation leave balance.');
        }

        if ($data['leave_type'] === 'Sick' && $data['days'] > $balance['sick_leave']) {
            return $this->json(false, 'Insufficient sick leave balance.');
        }

        // --- Persist ---
        $leaveId = $this->model->create($data);

        if (!$leaveId) {
            return $this->json(false, 'Failed to submit leave request. Please try again.');
        }

        // --- Deduct balance ---
        // $this->model->deductBalance($userId, $data['leave_type'], $data['days']);

        // --- Update session balance ---
        $newBalance = $this->model->getBalance($userId);
        $_SESSION['vacation_leave'] = $newBalance['vacation_leave'];
        $_SESSION['sick_leave']     = $newBalance['sick_leave'];

        return $this->json(true, 'Leave application submitted successfully!', [
            'leave_id'       => $leaveId,
            'vacation_leave' => $newBalance['vacation_leave'],
            'sick_leave'     => $newBalance['sick_leave'],
        ]);
    }

    /**
     * Return all leave requests for the logged-in user
     */
    public function history($userId) {
        $records = $this->model->getByEmployee($userId);
        return $this->json(true, 'Leave history retrieved.', ['records' => $records]);
    }

    /**
     * Validate form fields
     */
    private function validate($data) {
        $errors = [];

        if (empty($data['leave_type']))  $errors[] = 'Leave type is required.';
        if (empty($data['start_date']))  $errors[] = 'Start date is required.';
        if (empty($data['end_date']))    $errors[] = 'End date is required.';
        if (empty($data['reason']))      $errors[] = 'Reason for leave is required.';
        if (empty($data['days']) || $data['days'] <= 0) $errors[] = 'Invalid number of days.';

        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            if (strtotime($data['end_date']) < strtotime($data['start_date'])) {
                $errors[] = 'End date cannot be before start date.';
            }
        }

        return $errors;
    }

    /**
     * Output a JSON response
     */
    private function json($success, $message, $data = []) {
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }
}
?>