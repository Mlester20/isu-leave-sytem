<?php
/**
 * API: Apply Leave (non-teaching)
 * Method : POST / GET
 * Called via AJAX from the Digital Leave Application form
 */

// Buffer ALL output — catches stray warnings/notices before JSON is sent
ob_start();

session_start();
header('Content-Type: application/json');

// Return PHP errors as JSON instead of HTML
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => "PHP Error [{$errno}]: {$errstr} in {$errfile} on line {$errline}"
    ]);
    exit;
});

set_exception_handler(function($e) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => "Exception: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine()
    ]);
    exit;
});

require_once __DIR__ . '/../../../app/middleware/auth.php';
allowOnly(['non_teaching']);

require_once __DIR__ . '/../../../db/config.php';
require_once __DIR__ . '/../../../app/controllers/non_teaching/ApplyLeaveController.php';

$controller = new ApplyLeaveController($con);
$userId     = $_SESSION['id'];
$action     = $_GET['action'] ?? 'store';

// Discard any stray output before sending the actual JSON response
ob_clean();

switch ($action) {

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
            exit;
        }
        echo $controller->store($_POST, $userId);
        break;

    case 'history':
        echo $controller->history($userId);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
        break;
}

ob_end_flush();
?>