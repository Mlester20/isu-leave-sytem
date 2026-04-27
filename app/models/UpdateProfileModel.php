<?php
require_once __DIR__ . '/BaseModel.php';

class UpdateProfileModel extends BaseModel {
    protected $table = 'users';
    protected $department = 'departments';
    /**
     * Get user by ID
     */
    public function getUserById($id) {
        try{
            $sql = "SELECT 
                u.*, 
                d.department_name as department
                FROM {$this->table} u
                LEFT JOIN {$this->department} d ON u.department_id = d.id
                WHERE u.id = ? 
                LIMIT 1
                ";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Error fetching user by ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user profile - only allows updating full_name, email, password, department
     * Does NOT allow updating: employee_no, role, vacation_leave, sick_leave
     */
    public function updateProfile($id, $data) {
        try {
            // Allowed fields to update
            $allowed_fields = ['full_name', 'email', 'password', 'department'];
            
            // Build dynamic SQL
            $updates = [];
            $types = '';
            $params = [];

            foreach ($allowed_fields as $field) {
                if (isset($data[$field]) && $data[$field] !== '') {
                    $updates[] = "{$field} = ?";
                    $params[] = $data[$field];
                    
                    // Determine type for bind_param
                    if ($field === 'password') {
                        $types .= 's'; // password is hashed string
                    } else {
                        $types .= 's'; // all are strings
                    }
                }
            }

            // Add timestamp
            $updates[] = "updated_at = ?";
            $params[] = date('Y-m-d');
            $types .= 's';

            // Add ID to params
            $params[] = $id;
            $types .= 'i';

            if (empty($updates)) {
                return false;
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $updates) . " WHERE id = ?";
            $stmt = $this->con->prepare($sql);

            // Bind parameters dynamically
            $stmt->bind_param($types, ...$params);
            $result = $stmt->execute();

            return $result;
        } catch (Exception $e) {
            error_log("Error updating profile: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Hash password for secure storage
     */
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verify password against hash
     */
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}

?>