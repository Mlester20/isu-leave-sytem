<?php
session_start();

require_once __DIR__ . '/../../../app/middleware/auth.php';
allowOnly(['non_teaching']);

// Fetch fresh user data (balance may have changed)
require_once __DIR__ . '/../../../db/config.php';

$userId = $_SESSION['id'];
$stmt   = $con->prepare("
    SELECT u.*, d.department_name
    FROM users u
    LEFT JOIN departments d ON u.department_id = d.id
    WHERE u.id = ?
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once __DIR__ . '/../../../helpers/title.php'; ?></title>
    <link rel="shortcut icon" href="../../../storage/images/isu-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../public/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/non_teaching/apply-leave.css">
</head>
<body>

    <!-- Navbar -->
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <div class="leave-wrapper">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1>Digital Leave Application</h1>
                <p>Separate filing page with auto-calculated leave days and a clean printable format.</p>
            </div>
            <a href="my_requests.php" class="btn-view-requests">
                <i class="bi bi-card-list"></i> View My Requests
            </a>
        </div>

        <!-- Info banner -->
        <div class="info-banner">
            <i class="bi bi-info-circle-fill fs-6"></i>
            Signature lines were removed for digital filing. Admin and Head approval are recorded in the system.
        </div>

        <!-- Form Card -->
        <div class="leave-card">
            <form id="leaveForm" novalidate>

                <!-- ── Employee Information ── -->
                <div class="section-label">
                    <i class="bi bi-person-badge"></i> Employee Information
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Employee Name</label>
                        <input type="text" class="form-control auto-filled" readonly
                               value="<?= htmlspecialchars($user['full_name']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Department / Office</label>
                        <input type="text" class="form-control auto-filled" readonly
                               value="<?= htmlspecialchars($user['department_name'] ?? '—') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control auto-filled" readonly
                               value="<?= htmlspecialchars($user['position'] ?? '—') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date Filed</label>
                        <input type="text" class="form-control auto-filled" readonly
                               value="<?= date('m/d/Y') ?>">
                    </div>
                </div>

                <!-- ── Leave Details ── -->
                <div class="section-label">
                    <i class="bi bi-calendar2-check"></i> Leave Details
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Leave Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="leave_type" id="leaveType" required>
                            <option value="Vacation" selected>Vacation</option>
                            <option value="Sick">Sick</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Commutation</label>
                        <select class="form-select" name="commutation" id="commutation">
                            <option value="Requested" selected>Requested</option>
                            <option value="Not Requested">Not Requested</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" id="startDate"
                               min="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="end_date" id="endDate"
                               min="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Days</label>
                        <input type="text" class="form-control auto-filled" id="totalDays"
                               name="days" readonly placeholder="—">
                        <p class="form-hint">
                            <i class="bi bi-calculator"></i>
                            Auto-calculated based on the inclusive start and end dates.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Available Balance</label>
                        <div class="balance-display">
                            <i class="bi bi-wallet2"></i>
                            <span>Vacation: <strong id="vacBal"><?= (int)$user['vacation_leave'] ?></strong></span>
                            <span class="sep">|</span>
                            <span>Sick: <strong id="sickBal"><?= (int)$user['sick_leave'] ?></strong></span>
                        </div>
                    </div>
                </div>

                <!-- ── Reason & Details ── -->
                <div class="section-label">
                    <i class="bi bi-pencil-square"></i> Reason & Details
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">
                            Specific Details / Purpose <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="attachment_note" id="specificDetails"
                                  placeholder="Example: medical checkup, seminar attendance, family matter, etc."
                                  required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">
                            Reason for Leave <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="reason" id="reasonLeave"
                                  placeholder="State the reason for your leave request."
                                  required></textarea>
                    </div>
                </div>

                <!-- ── Form Action Bar ── -->
                <div class="btn-form-bar">
                    <button type="submit" class="btn-isu-primary" id="submitBtn">
                        <span class="spinner-sm" id="submitSpinner"></span>
                        <i class="bi bi-send-fill" id="submitIcon"></i>
                        <span id="submitText">Submit Digital Leave Form</span>
                    </button>
                    <button type="button" class="btn-isu-secondary" id="printHistoryBtn">
                        <i class="bi bi-printer"></i> Print History
                    </button>
                </div>

            </form>
        </div><!-- /leave-card -->
    </div><!-- /leave-wrapper -->

    <!-- Toast Container -->
    <div id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/js/non_teaching/apply_leave.js"></script>
</body>
</html>