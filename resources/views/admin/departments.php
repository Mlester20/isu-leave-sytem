<?php
require_once __DIR__ . '/../../../app/controllers/admin/DepartmentsController.php';
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

    <!-- show message -->
    <?php showFlash(); ?>

    <!-- button to triggered the modal -->
    <div class="text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
            <i class="iconify-icons bx/bxs-plus-circle"></i> Add Department
        </button>
    </div>

    <!-- Add Department Modal -->
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="departmentName" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="departmentName" name="department_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="create_department" class="btn btn-primary">Create Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Department Modal -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="editDepartmentId" name="id">
                        <div class="mb-3">
                            <label for="editDepartmentName" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="editDepartmentName" name="department_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update_department" class="btn btn-primary">Update Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Department Form (Hidden) -->
    <form id="deleteDepartmentForm" action="" method="POST" style="display: none;">
        <input type="hidden" id="deleteDepartmentId" name="id">
        <input type="hidden" name="delete_department" value="1">
    </form>


    <div class="card mt-4">
        <h5 class="card-header">Manage Departments</h5>
        <div class="table-responsive nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($departments as $department): ?>
                        <tr>
                            <td><?php echo $department['id']; ?></td>
                            <td><?php echo $department['department_name']; ?></td>
                            <td><?php echo $department['created_at']; ?></td>
                            <td>
                                <!-- button to triggered update modal -->
                                <button type="button" class="btn btn-sm btn-warning btn-edit" 
                                        data-id="<?php echo $department['id']; ?>" 
                                        data-name="<?php echo htmlspecialchars($department['department_name']); ?>"
                                        data-bs-toggle="modal" data-bs-target="#editDepartmentModal">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-delete" 
                                        data-id="<?php echo $department['id']; ?>">
                                    Delete
                                </button>
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

  <script>
    // Handle Edit button click
    document.querySelectorAll('.btn-edit').forEach(btn => {
      btn.addEventListener('click', function() {
        const departmentId = this.getAttribute('data-id');
        const departmentName = this.getAttribute('data-name');
        
        document.getElementById('editDepartmentId').value = departmentId;
        document.getElementById('editDepartmentName').value = departmentName;
      });
    });

    // Handle Delete button click
    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.addEventListener('click', function() {
        const departmentId = this.getAttribute('data-id');
        
        if(confirm('Are you sure you want to delete this department?')) {
          document.getElementById('deleteDepartmentId').value = departmentId;
          document.getElementById('deleteDepartmentForm').submit();
        }
      });
    });
  </script>

</body>
</html>