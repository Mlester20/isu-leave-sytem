<?php
require_once __DIR__ . '/../../../app/controllers/non_teaching/MyLeaveController.php';
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

    <!-- table contents -->
    <div class="container mt-5">
        <h2>My Leave Requests</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Filled At</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($leave_requests as $request): ?>
                    <tr>
                        <td><?= $request['id'] ?></td>
                        <td><?= $request['employee_name'] ?></td>
                        <td><?= $request['leave_type'] ?></td>
                        <td><?= $request['created_at'] ?></td>
                        <td><?= $request['start_date'] ?></td>
                        <td><?= $request['end_date'] ?></td>
                        <td>
                            <span class="badge bg-<?= $request['status'] === 'Approved' ? 'success' : ($request['status'] === 'Rejected' ? 'danger' : 'warning') ?>">
                                <?= $request['status'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewLeaveModal" onclick="viewLeaveDetails(<?= htmlspecialchars(json_encode($request)) ?>)">
                                <i class="bi bi-eye"></i> View
                            </button>
                        </td>
                    </tr>
                
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- View Leave Modal -->
    <div class="modal fade" id="viewLeaveModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-text"></i> Leave Request Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Employee Information Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-badge"></i> Employee Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Employee Name</label>
                                <p class="fw-medium" id="modal_employee_name">—</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Date Filed</label>
                                <p class="fw-medium" id="modal_created_at">—</p>
                            </div>
                        </div>
                    </div>

                    <!-- Leave Details Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-calendar2-check"></i> Leave Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Leave Type</label>
                                <p class="fw-medium" id="modal_leave_type">—</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Total Days</label>
                                <p class="fw-medium" id="modal_days">—</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Start Date</label>
                                <p class="fw-medium" id="modal_start_date">—</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">End Date</label>
                                <p class="fw-medium" id="modal_end_date">—</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reason & Details Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square"></i> Reason & Details</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-muted small">Specific Details / Purpose</label>
                                <p id="modal_attachment_note" style="white-space: pre-wrap; word-break: break-word;">—</p>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">Reason for Leave</label>
                                <p id="modal_reason" style="white-space: pre-wrap; word-break: break-word;">—</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status & Approval Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-check-circle"></i> Status & Approval</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Current Status</label>
                                <p id="modal_status" class="fw-medium">—</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">HRMO Remark</label>
                                <p id="modal_hrmo_remark" style="white-space: pre-wrap;">—</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Head Remark</label>
                                <p id="modal_head_remark" style="white-space: pre-wrap;">—</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printLeaveDetails()">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewLeaveDetails(leaveData) {
            // Populate modal fields
            document.getElementById('modal_employee_name').textContent = leaveData.employee_name || '—';
            document.getElementById('modal_created_at').textContent = formatDate(leaveData.created_at) || '—';
            document.getElementById('modal_leave_type').textContent = leaveData.leave_type || '—';
            document.getElementById('modal_days').textContent = leaveData.days || '—';
            document.getElementById('modal_start_date').textContent = formatDate(leaveData.start_date) || '—';
            document.getElementById('modal_end_date').textContent = formatDate(leaveData.end_date) || '—';
            document.getElementById('modal_attachment_note').textContent = leaveData.attachment_note || '—';
            document.getElementById('modal_reason').textContent = leaveData.reason || '—';
            document.getElementById('modal_status').textContent = leaveData.status || '—';
            document.getElementById('modal_hrmo_remark').textContent = leaveData.hrmo_remark || '—';
            document.getElementById('modal_head_remark').textContent = leaveData.head_remark || '—';

            // Store leave data for print functionality
            window.currentLeaveData = leaveData;
        }

        function formatDate(dateString) {
            if (!dateString) return '—';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', options);
        }

        function printLeaveDetails() {
            const data = window.currentLeaveData;
            if (!data) return;

            const printWindow = window.open('', '', 'height=600,width=800');
            const htmlContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Leave Request - ${data.id}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
                        .header { border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 10px; }
                        .section { margin-bottom: 20px; }
                        .section-title { font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
                        .row { display: flex; margin-bottom: 10px; }
                        .col { flex: 1; }
                        .label { font-weight: bold; color: #555; }
                        .value { margin-top: 2px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h2>Leave Request Details</h2>
                        <p>Request ID: ${data.id}</p>
                    </div>

                    <div class="section">
                        <div class="section-title">Employee Information</div>
                        <div class="row">
                            <div class="col">
                                <div class="label">Employee Name:</div>
                                <div class="value">${data.employee_name}</div>
                            </div>
                            <div class="col">
                                <div class="label">Date Filed:</div>
                                <div class="value">${formatDate(data.created_at)}</div>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Leave Details</div>
                        <div class="row">
                            <div class="col">
                                <div class="label">Leave Type:</div>
                                <div class="value">${data.leave_type}</div>
                            </div>
                            <div class="col">
                                <div class="label">Total Days:</div>
                                <div class="value">${data.days}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="label">Start Date:</div>
                                <div class="value">${formatDate(data.start_date)}</div>
                            </div>
                            <div class="col">
                                <div class="label">End Date:</div>
                                <div class="value">${formatDate(data.end_date)}</div>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Reason & Details</div>
                        <div class="row">
                            <div class="col">
                                <div class="label">Specific Details / Purpose:</div>
                                <div class="value">${data.attachment_note || '—'}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="label">Reason for Leave:</div>
                                <div class="value">${data.reason}</div>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Status & Approval</div>
                        <div class="row">
                            <div class="col">
                                <div class="label">Current Status:</div>
                                <div class="value">${data.status}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="label">HRMO Remark:</div>
                                <div class="value">${data.hrmo_remark || '—'}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="label">Head Remark:</div>
                                <div class="value">${data.head_remark || '—'}</div>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            `;
            printWindow.document.write(htmlContent);
            printWindow.document.close();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 250);
        }
    </script>
</body>
</html>