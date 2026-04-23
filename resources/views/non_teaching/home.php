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
    <title>Document</title>
</head>
<body>
    
    <h1>Welcome to Non-Teaching Home Page</h1>
    <p>Hello, <?php echo $_SESSION['full_name']; ?>! You are logged in as a non-teaching staff member.</p>
    <a href="../../../app/controllers/logout.php">Logout</a>

</body>
</html>