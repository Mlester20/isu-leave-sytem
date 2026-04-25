<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="#" class="app-brand-link">
          <span class="app-brand-logo demo">
            <img src="../../../../storage/images/isu-logo.png" alt="ISU Leave System Logo" width="60" height="60" />
          </span>
          <span class="app-brand-text demo menu-text fw-semibold ms-2">ISU Leave System</span>
        </a>
        <!-- <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
          <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
        </a> -->
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">

        <!-- Dashboards -->
        <li class="menu-item">
          <a href="dashboard.php" class="menu-link">
            <i class="menu-icon icon-base ri ri-bar-chart-line"></i>
            <div data-i18n="Tables">Dashboard</div>
          </a>
        </li>

        <!-- Pages -->
        <li class="menu-header mt-7"><span class="menu-header-text">Lists</span></li>

        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-layout-left-line"></i>
            <div data-i18n="Departments">Departments</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="departments.php" class="menu-link">
                <div data-i18n="Categories">Manage Departments</div>
              </a>
            </li>
          </ul>
        </li>

        <li class="menu-item">
          <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-team-line"></i>
            <div data-i18n="Users">Users</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item"><a href="users.php" class="menu-link"><div>Users</div></a></li>
          </ul>
        </li>


        <!-- Forms & Tables -->
        <li class="menu-header mt-7"><span class="menu-header-text">Reports</span></li>

        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-radio-button-line"></i>
            <div data-i18n="Form Elements">Activities Log</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item"><a href="activities-log.php" class="menu-link"><div>Activities Log</div></a></li>
          </ul>
        </li>

        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-box-3-line"></i>
            <div data-i18n="Form Layouts">Audits</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item"><a href="audits.php" class="menu-link"><div>Audits</div></a></li>
          </ul>
        </li>
      </ul>
    </aside>
    <!-- / Menu -->

    <!-- Layout page -->
    <div class="layout-page">