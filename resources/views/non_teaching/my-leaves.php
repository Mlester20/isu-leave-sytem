<?php
session_start();

require_once __DIR__ . '/../../../app/middleware/auth.php';
allowOnly(['non_teaching']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php require_once __DIR__ . '/../../../helpers/title.php'; ?> </title>
    <link rel="shortcut icon" href="../../../storage/images/isu-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../public/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <!-- navbar -->
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>