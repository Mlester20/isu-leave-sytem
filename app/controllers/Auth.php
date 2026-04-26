<?php
session_start();

require_once __DIR__ . '/../../db/config.php';
require_once __DIR__ . '/../models/AuthModel.php';
require_once __DIR__ . '/../../helpers/message.php';
require_once __DIR__ . '/../../helpers/activitiesLogger.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $authModel = new AuthModel($con);
    $logger = new ActivityLogger($con);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $row = $authModel->getUserByEmail($email);

    if ($row && $authModel->verifyPassword($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['full_name'] = $row['full_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];

        // Log the successful login activity
        $logger->log(
            $row['id'],
            $row['role'],
            'LOGIN',
            'AUTH',
            null,
            null,
            $row['full_name'] . ' logged in',
            'success'
        );

        // ✅ REDIRECT
        if ($_SESSION['role'] === 'admin') {
            header("Location: ../../resources/views/admin/dashboard.php");
        } 
        else if ($_SESSION['role'] === 'non_teaching') {
            header("Location: ../../resources/views/non_teaching/home.php");
        } 
        else if ($_SESSION['role'] === 'teaching') {
            header("Location: ../../resources/views/teaching/home.php");
        }else if($_SESSION['role'] === 'head'){
            header("Location: ../../resources/views/hr_admin/home.php");
        }
         else {
            header("Location: ../../index.php"); // Default fallback for unknown roles
        }
        exit();

    } else {

        // Log the failed login attempt
        $logger->log(
            null,
            'user',
            'LOGIN',
            'AUTH',
            null,
            null,
            'Failed login attempt: ' . $email,
            'failed'
        );

        setFlash("error", "Invalid email or password. Please try again.");
        header("Location: ../../index.php");
        exit();
    }
}