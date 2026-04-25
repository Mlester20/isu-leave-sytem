<?php
require_once __DIR__ . '/../../../app/controllers/admin/UsersController.php';
require_once __DIR__ . '/../../../helpers/message.php';
require_once __DIR__ . '/../../../app/middleware/auth.php';
allowOnly(['admin']);
?>

<!doctype html>
<html lang="en"
  class="layouts-menu-fixed layouts-compact"
  data-assets-path="../../../public/assets/"
  data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?php require_once __DIR__ . '/../../../helpers/title.php'; ?></title>
  <link rel="icon" type="image/x-icon" href="../../../storage/images/isu-logo.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../../public/assets/vendor/fonts/iconify-icons.css" />
  <link rel="stylesheet" href="../../../public/assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="../../../public/assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../../../public/assets/css/demo.css" />
  <link rel="stylesheet" href="../../../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../../../public/assets/vendor/libs/apex-charts/apex-charts.css" />
  <link rel="stylesheet" href="../../../public/css/admin-dashboard.css" />
  <script src="../../../public/assets/vendor/js/helpers.js"></script>
  <script src="../../../public/assets/js/config.js"></script>
</head>
<body>

  <?php require_once __DIR__ . '/layouts/sidebar.php'; ?>
  <?php require_once __DIR__ . '/layouts/topbar.php'; ?>

  <?php showFlash(); ?>
    
  <!-- button to trigger modal -->
    <div class="text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            Create User
        </button>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="employee_no" class="form-label">Employee No</label>
                                <input type="text" class="form-control" id="employee_no" name="employee_no" required>
                            </div>
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="head">Head</option>
                                    <option value="teaching">Teaching Staff</option>
                                    <option value="non_teaching">Non-Teaching Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="department_id" class="form-label">Department</label>
                                <select class="form-control" id="department_id" name="department_id" required>
                                    <option value="">Select Department</option>
                                    <?php foreach($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['department_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="vacation_leave" class="form-label">Vacation Leave</label>
                                <input type="number" class="form-control" id="vacation_leave" name="vacation_leave" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sick_leave" class="form-label">Sick Leave</label>
                                <input type="number" class="form-control" id="sick_leave" name="sick_leave" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="create_user" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update User Modal -->
    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="update_user_id" name="id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="update_full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="update_full_name" name="full_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="update_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="update_email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="update_role" class="form-label">Role</label>
                                <select class="form-control" id="update_role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="head">Head</option>
                                    <option value="teaching">Teaching Staff</option>
                                    <option value="non_teaching">Non-Teaching Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="update_department_id" class="form-label">Department</label>
                                <select class="form-control" id="update_department_id" name="department_id" required>
                                    <option value="">Select Department</option>
                                    <?php foreach($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['department_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="update_vacation_leave" class="form-label">Vacation Leave</label>
                                <input type="number" class="form-control" id="update_vacation_leave" name="vacation_leave" required>
                            </div>
                            <div class="col-md-6">
                                <label for="update_sick_leave" class="form-label">Sick Leave</label>
                                <input type="number" class="form-control" id="update_sick_leave" name="sick_leave" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="delete_user_id" name="id">
                        <p>Are you sure you want to delete this user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete_user" class="btn btn-danger">Delete User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Full Name</strong></label>
                        <p id="view_full_name"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Email</strong></label>
                        <p id="view_email"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Role</strong></label>
                        <p id="view_role"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Department</strong></label>
                        <p id="view_department"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Vacation Leave</strong></label>
                        <p id="view_vacation_leave"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Sick Leave</strong></label>
                        <p id="view_sick_leave"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <h5 class="card-header">Users</h5>
        <div class="table-responsive nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewUserModal" onclick="populateViewModal(<?= htmlspecialchars(json_encode($user)) ?>)">View</button>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#updateUserModal" onclick="populateUpdateModal(<?= htmlspecialchars(json_encode($user)) ?>)">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" onclick="populateDeleteModal(<?= htmlspecialchars($user['id']) ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

  <?php require_once __DIR__ . '/layouts/footer.php'; ?>

  <!-- ── Vendor scripts ── -->
  <script src="../../../public/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../../public/assets/vendor/libs/popper/popper.js"></script>
  <script src="../../../public/assets/vendor/js/bootstrap.js"></script>
  <script src="../../../public/assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="../../../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../../public/assets/vendor/js/menu.js"></script>
  <script src="../../../public/assets/js/main.js"></script>

  <!-- ── Chart.js ── -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
  <script src="../../../public/js/admin/dashboard.js"></script>
  <script src="../../../public/js/admin/users.js"></script>

</body>
</html>