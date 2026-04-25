<?php

require_once __DIR__ . '/../../../app/controllers/admin/ActivitiesLogController.php';
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

  <div class="card">
    <h5 class="card-header">Activities Log</h5>
    <div class="table-responsive nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>   
                    <th>Action</th>
                    <th>Ip Address</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['user_full_name']); ?></td>
                        <td><?php echo htmlspecialchars($log['user_role']); ?></td>
                        <td><?php echo htmlspecialchars($log['action']); ?></td>
                        <td><?php echo htmlspecialchars($log['ip_address']); ?></td>
                        <td>
                            <?php if ($log['status'] == 1): ?>
                                <span class="badge bg-success">Success</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Failed</span>
                            <?php endif; ?>
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

</body>
</html>