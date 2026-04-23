<?php
session_start();

require_once __DIR__ . '/../../../app/middleware/auth.php';
require_once __DIR__ . '/../../../app/models/UpdateProfileModel.php';
require_once __DIR__ . '/../../../db/config.php';
require_once __DIR__ . '/../../../helpers/message.php';

allowOnly(['non_teaching']);

$updateProfileModel = new UpdateProfileModel($con);
$user = $updateProfileModel->getUserById($_SESSION['id']);
?>

<!doctype html>
<html lang="en"
  class="layouts-menu-fixed layouts-compact"
  data-assets-path="../../../public/assets/"
  data-template="vertical-menu-template-free">
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

<?php include __DIR__ . '/../non_teaching/partials/navbar.php'; ?>

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-12">
        <h4 class="py-3 mb-4 text-center mt-4">Account / Profile Settings</h4>
      </div>
    </div>

    <div class="row">
      <!-- Left Column: Profile Information -->
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body text-center">
            <!-- Profile Avatar with Initials -->
            <div class="mb-3">
              <?php
              $initials = '';
              $names = explode(' ', trim($user['full_name']));
              foreach ($names as $name) {
                $initials .= strtoupper(substr($name, 0, 1));
              }
              $initials = substr($initials, 0, 2);
              
              // Generate color based on initials
              $colors = ['#007bff', '#28a745', '#dc3545', '#fd7e14', '#6f42c1', '#20c997', '#17a2b8', '#e83e8c'];
              $colorIndex = (ord($initials[0]) + (isset($initials[1]) ? ord($initials[1]) : 0)) % count($colors);
              $bgColor = $colors[$colorIndex];
              ?>
              <div style="width: 120px; height: 120px; border-radius: 50%; background-color: <?php echo $bgColor; ?>; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 48px; color: white; font-weight: bold;">
                <?php echo htmlspecialchars($initials); ?>
              </div>
            </div>

            <h5 class="card-title mt-3 mb-1"><?php echo htmlspecialchars($user['full_name']); ?></h5>

            <div class="text-muted small mb-3"><?php echo htmlspecialchars($user['email']); ?></div>

            <div class="mb-3">
              <span class="badge bg-primary"><?php echo htmlspecialchars(ucfirst($user['role'])); ?></span>
            </div>

            <hr>

            <div class="mb-3 text-start">
              <div class="row mb-3">
                <div class="col-6">
                  <small class="d-block text-muted mb-1">Employee No.</small>
                  <span class="fw-semibold"><?php echo htmlspecialchars($user['employee_no']); ?></span>
                </div>
                <div class="col-6">
                  <small class="d-block text-muted mb-1">Department</small>
                  <span class="fw-semibold"><?php echo htmlspecialchars($user['department']); ?></span>
                </div>
              </div>
              <small class="d-block text-muted mb-1">Member Since</small>
              <span class="fw-semibold"><?php echo date('M d, Y', strtotime($user['created_at'] ?? date('Y-m-d'))); ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Update Profile -->
      <div class="col-md-8">
        <?php
        $message = getFlash("success");
        if ($message) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . htmlspecialchars($message) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        
        $error = getFlash("error");
        if ($error) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . htmlspecialchars($error) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        ?>

        <div class="card mb-4">
          <h5 class="card-header">Update Profile</h5>
          <div class="card-body">
            <form method="POST" action="../../../app/controllers/UpdateProfile.php">
              <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

              <h6 class="mb-3 text-muted">BASIC INFORMATION</h6>

              <div class="mb-3">
                <label class="form-label" for="full_name">Full Name</label>
                <input type="text" id="full_name" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" placeholder="Enter your full name">
              </div>

              <div class="mb-3">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Enter your email">
              </div>

              <hr>

              <h6 class="mb-3 text-muted">SECURITY SETTINGS</h6>

              <div class="mb-3">
                <label class="form-label" for="current_password">Current Password <span class="text-danger">*</span></label>
                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter your current password" required>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label" for="password">New Password</label>
                  <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password">
                  <small class="text-muted">Leave blank to keep current password</small>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label" for="password_confirm">Confirm New Password</label>
                  <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Confirm new password">
                </div>
              </div>

              <div class="mt-4">
                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                <a href="home.php" class="btn btn-outline-secondary">Cancel</a>
                </form>
              </div>
            </div>
          </div>
    </div>
  </div>


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
