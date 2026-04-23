<?php
session_start();

require_once __DIR__ . '/../models/UpdateProfileModel.php';
require_once __DIR__ . '/../../db/config.php';
require_once __DIR__ . '/../../helpers/message.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

$updateProfileModel = new UpdateProfileModel($con);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    
    // Get current user data
    $current_user = $updateProfileModel->getUserById($user_id);
    
    if (!$current_user) {
        setFlash("error", "User not found.");
        header("Location: " . $_POST['redirect_url'] ?? "../../index.php");
        exit();
    }

    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');
    $current_password = trim($_POST['current_password'] ?? '');

    // Validation
    $errors = [];

    // Validate current password
    if (!$updateProfileModel->verifyPassword($current_password, $current_user['password'])) {
        $errors[] = "Current password is incorrect.";
    }

    // Validate full name
    if ($full_name && strlen($full_name) < 3) {
        $errors[] = "Full name must be at least 3 characters.";
    }

    // Validate email
    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check if email already exists (excluding current user)
    if ($email && $email !== $current_user['email']) {
        $check_email = $updateProfileModel->con->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $check_email->bind_param("si", $email, $user_id);
        $check_email->execute();
        if ($check_email->get_result()->num_rows > 0) {
            $errors[] = "Email already exists.";
        }
    }

    // Validate password
    if ($password) {
        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        }
        if ($password !== $password_confirm) {
            $errors[] = "Passwords do not match.";
        }
    }

    if (empty($errors)) {
        // Prepare data for update
        $data = [];
        
        if ($full_name) {
            $data['full_name'] = $full_name;
        }
        
        if ($email) {
            $data['email'] = $email;
        }
        
        if ($password) {
            $data['password'] = $updateProfileModel->hashPassword($password);
        }

        // Perform update
        if ($updateProfileModel->updateProfile($user_id, $data)) {
            // Update session
            if ($full_name) {
                $_SESSION['full_name'] = $full_name;
            }
            if ($email) {
                $_SESSION['email'] = $email;
            }

            setFlash("success", "Profile updated successfully!");
        } else {
            setFlash("error", "Failed to update profile. Please try again.");
        }
    } else {
        setFlash("error", implode(" ", $errors));
    }

    // Redirect based on role
    $redirect_url = $_POST['redirect_url'] ?? "../../index.php";
    header("Location: " . $redirect_url);
    exit();
}

?>