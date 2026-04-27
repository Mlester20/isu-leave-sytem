<?php
  $name_parts = explode(' ', trim($_SESSION['full_name'] ?? 'ISU User'));
  $initials   = strtoupper(
      count($name_parts) >= 2
          ? $name_parts[0][0] . end($name_parts)[0]
          : $name_parts[0][0]
  );
  $full_name  = htmlspecialchars($_SESSION['full_name'] ?? 'ISU User');
  $role       = htmlspecialchars($_SESSION['role']      ?? 'Employee');

  $current    = basename($_SERVER['PHP_SELF']);
?>



<nav class="navbar navbar-expand-lg isu-navbar px-3 px-lg-4">

  <!-- ── Logo ──────────────────────────────────────────────────── -->
  <a class="navbar-brand" href="home.php">
    <div class="isu-logo-icon">
      <img src="../../../../storage/images/isu-logo.png" alt="ISU Logo" style="width:40px;height:40px;object-fit:contain;">
    </div>
    <div class="isu-logo-text">
      <span class="logo-title">ISU Leave System</span>
      <span class="logo-subtitle">Isabela State University</span>
    </div>
  </a>

  <!-- ── Mobile Toggler ────────────────────────────────────────── -->
  <button class="navbar-toggler ms-auto me-2 d-lg-none"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#isuNavCollapse"
          aria-controls="isuNavCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- ── Collapsible Content ───────────────────────────────────── -->
  <div class="collapse navbar-collapse" id="isuNavCollapse">

    <!-- Nav Links (center / left) -->
    <ul class="navbar-nav me-auto ms-lg-3">

      <li class="nav-item">
        <a class="nav-link <?= $current === 'dashboard.php' ? 'active' : '' ?>"
           href="home.php">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $current === 'my-leaves.php' ? 'active' : '' ?>"
           href="/leaves/my-leaves">
          <i class="bi bi-calendar2-check"></i> My Leaves
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $current === 'apply.php' ? 'active' : '' ?>"
           href="apply-leave.php">
          <i class="bi bi-pencil-square"></i> Apply
        </a>
      </li>

      <!-- Dropdown example -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?= in_array($current, ['history.php','reports.php']) ? 'active' : '' ?>"
           href="#"
           id="reportsDropdown"
           role="button"
           data-bs-toggle="dropdown"
           aria-expanded="false">
          <i class="bi bi-bar-chart-line"></i> Reports
        </a>
        <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
          <li>
            <a class="dropdown-item" href="/reports/history">
              <i class="bi bi-clock-history"></i> Leave History
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="/reports/summary">
              <i class="bi bi-file-earmark-bar-graph"></i> Summary Report
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="/reports/export">
              <i class="bi bi-download"></i> Export Data
            </a>
          </li>
        </ul>
      </li>

      <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
      <li class="nav-item">
        <a class="nav-link <?= $current === 'admin.php' ? 'active' : '' ?>"
           href="/admin">
          <i class="bi bi-shield-check"></i> Admin
        </a>
      </li>
      <?php endif; ?>

    </ul>

    <!-- Right-side extras -->
    <div class="d-flex align-items-center gap-2 isu-nav-extras">

      <!-- Notification Bell -->
      <a href="/notifications" class="isu-nav-icon-btn" title="Notifications">
        <i class="bi bi-bell" style="font-size:.9rem; color: var(--text-muted);"></i>
        <span class="badge-dot"></span>
      </a>

      <!-- User Dropdown -->
      <div class="dropdown">
        <a class="isu-user-btn dropdown-toggle"
           href="#"
           id="userDropdown"
           role="button"
           data-bs-toggle="dropdown"
           aria-expanded="false"
           style="text-decoration:none;">
          <div class="isu-user-avatar"><?= $initials ?></div>
          <div class="d-none d-md-flex flex-column text-start">
            <span class="isu-user-name"><?= $full_name ?></span>
            <span class="isu-user-role"><?= $role ?></span>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li>
            <a class="dropdown-item" href="settings.php">
              <i class="bi bi-person-circle"></i> My Profile
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="../../../../app/controllers/logout.php"
               style="color:#ff6b6b !important;" onclick="return confirm('Are you sure you want to sign out?');">
              <i class="bi bi-box-arrow-right" style="color:#ff6b6b;"></i> Sign Out
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div><!-- /.navbar-collapse -->

</nav>