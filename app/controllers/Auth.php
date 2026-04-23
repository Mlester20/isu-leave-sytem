<?php
session_start();

require_once __DIR__ . '/../../db/config.php';
require_once __DIR__ . '/../models/AuthModel.php';
require_once __DIR__ . '/../../helpers/message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $authModel = new AuthModel($con);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $row = $authModel->getUserByEmail($email);

    if ($row && $authModel->verifyPassword($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['full_name'] = $row['full_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];

        // ✅ REDIRECT
        if ($_SESSION['role'] === 'admin') {
            header("Location: ../../resources/views/admin/dashboard.php");
        } 
        else if ($_SESSION['role'] === 'non_teaching') {
            header("Location: ../../resources/views/non_teaching/home.php");
        } 
        else if ($_SESSION['role'] === 'teaching') {
            header("Location: ../../resources/views/teaching/home.php");
        }
        exit();

    } else {
        setFlash("error", "Invalid email or password. Please try again.");
        header("Location: ../../index.php");
        exit();
    }
}