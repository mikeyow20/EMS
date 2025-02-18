<?php
// Fetch admin information
$stmt = $conn->prepare("SELECT * FROM admin WHERE id=:id");
$stmt->execute(['id' => $_SESSION['id']]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user roles
$stmt = $conn->prepare("SELECT p.name FROM permission_role pr JOIN permissions p ON pr.permission_id = p.id WHERE pr.group_id = :role_id");
$stmt->execute(['role_id' => $admin['role_id']]);
$userRoles = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'name');
$_SESSION['userRoles'] = $userRoles;

// Render Sidebar
function renderNavItem($link, $icon, $label) {
    echo "<li class='nav-item'><a class='nav-link' href='$link'><i class='$icon'></i>$label</a></li>";
}
?>
<div class="nav-left-sidebar sidebar-dark">
  <div class="menu-list">
    <nav class="navbar navbar-expand-lg navbar-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav flex-column">
          <li class="nav-divider">Menu</li>
          <?php renderNavItem('index.php', 'fa fa-fw fa-user-circle', 'Dashboard'); ?>

          <?php if (in_array('User', $userRoles)) renderNavItem('View_user.php', 'fa fa-user-plus', 'User Management'); ?>
          <?php if (in_array('Role', $userRoles)) renderNavItem('View_Role.php', 'fa fa-credit-card', 'Role Management'); ?>
          <?php if (in_array('Borrow', $userRoles)) renderNavItem('view_borrow.php', 'mdi mdi-google-wallet', 'Borrow Management'); ?>
          <?php if (in_array('Leaves', $userRoles)) renderNavItem('view_leaves.php', 'mdi mdi-calendar', 'Leaves Management'); ?>
          <?php if (in_array('Salary', $userRoles)) renderNavItem('view_salary.php', 'fa fa-credit-card', 'Salary Management'); ?>

          <?php if (in_array('Reports', $userRoles)): ?>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#submenu-reports" aria-expanded="false" aria-controls="submenu-reports">
              <i class="fas fa-file-alt"></i>Reports
            </a>
            <div id="submenu-reports" class="collapse">
              <ul class="nav flex-column">
                <?php renderNavItem('report_inc.php', '', 'New Employee Report'); ?>
                <?php renderNavItem('borrow_report.php', '', 'Borrow Report'); ?>
                <?php renderNavItem('app_report.php', '', 'Leave Approval Report'); ?>
                <?php renderNavItem('rem_leave.php', '', 'Pending Leaves Report'); ?>
                <?php renderNavItem('salary_slip_report.php', '', 'Salary Slip Report'); ?>
                <?php renderNavItem('salary_report.php', '', 'Salary Disbursement Report'); ?>
              </ul>
            </div>
          </li>
          <?php endif; ?>
          
          <?php renderNavItem('backup/backups.php', 'fab fa-stack-exchange', 'Backup Database'); ?>
          <?php renderNavItem('../logout.php', 'fas fa-lock', 'Logout'); ?>
        </ul>
      </div>
    </nav>
  </div>
</div>
