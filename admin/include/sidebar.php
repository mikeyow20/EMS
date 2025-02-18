<?php
   //error_reporting(0);
   require_once('../assets/constants/config.php');
   require_once('../assets/constants/check-login.php');
   require_once('../assets/constants/fetch-my-info.php');
   
   // Fetch admin details
   $stmt = $conn->prepare("SELECT * FROM admin WHERE id='" . $_SESSION['id'] . "'");
   $stmt->execute();
   $admin = $stmt->fetch(PDO::FETCH_ASSOC);
   
   // Fetch roles based on admin role
   $stmt = $conn->prepare("SELECT * FROM `permission_role` WHERE group_id='" . $admin['role_id'] . "'");
   $stmt->execute();
   $roles = $stmt->fetchAll();
   
   // Fetch and store permissions
   $setroles = [];
   foreach ($roles as $role) {
       $stmt = $conn->prepare("SELECT * FROM `permissions` WHERE id='" . $role['permission_id'] . "'");
       $stmt->execute();
       $per = $stmt->fetchAll();
       array_push($setroles, $per[0]['name']);
   }
   
   $_SESSION['userroles'] = $setroles;
   $userroles = $_SESSION['userroles'];
   
   // Get current page name
   $current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
   .nav-item.active a {
      background-color: #242849;
      color: white;
   }
</style>

<?php if ($admin['admin_user'] == '1') { ?>
<div class="nav-left-sidebar sidebar-dark">
   <div class="menu-list">
      <nav class="navbar navbar-expand-lg navbar-light">
         <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
            <li class="nav-divider">Menu</li>
               <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                  <a class="nav-link" href="index.php"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
               </li>
               <li class="nav-item <?php echo ($current_page == 'View_user.php') ? 'active' : ''; ?>">
                  <a class="nav-link" href="View_user.php"><i class="fa fa-user-plus"></i>Employee Management<span class="badge badge-success">6</span></a>
               </li>
               <li class="nav-item <?php echo ($current_page == 'View_Role.php') ? 'active' : ''; ?>">
                  <a class="nav-link" href="View_Role.php"><i class="fa fa-credit-card"></i>Role Management<span class="badge badge-success">6</span></a>
               </li>
               <li class="nav-item <?php echo ($current_page == 'view_borrow.php') ? 'active' : ''; ?>">
                  <a class="nav-link" href="view_borrow.php"><i class="mdi mdi-google-wallet"></i>Borrow Management<span class="badge badge-success">6</span></a>
               </li>
               <li class="nav-item <?php echo ($current_page == 'view_leaves.php') ? 'active' : ''; ?>">
                  <a class="nav-link" href="view_leaves.php"><i class="mdi mdi-calendar"></i>Leaves Management<span class="badge badge-success">6</span></a>
               </li>
               <li class="nav-item <?php echo ($current_page == 'view_salary.php') ? 'active' : ''; ?>">
                  <a class="nav-link" href="view_salary.php"><i class="fa fa-credit-card"></i>Salary Management<span class="badge badge-success">6</span></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-file-alt"></i>Report</a>
                  <div id="submenu-4" class="collapse submenu">
                     <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="report_inc.php">New Employee</a></li>
                        <li class="nav-item"><a class="nav-link" href="borrow_report.php">Borrow Report</a></li>
                        <li class="nav-item"><a class="nav-link" href="app_report.php">Leave Approval Report</a></li>
                        <li class="nav-item"><a class="nav-link" href="rem_leave.php">Pending Leaves Report</a></li>
                        <li class="nav-item"><a class="nav-link" href="salary_slip_report.php">Salary Slip</a></li>
                        <li class="nav-item"><a class="nav-link" href="salary_report.php">Salary Disbursement Report</a></li>
                     </ul>
                  </div>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="backup/backups.php"><i class="fab fa-stack-exchange"></i>Backup Database<span class="badge badge-success">6</span></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="../logout.php"><i class="fas fa-lock"></i>Logout<span class="badge badge-success">6</span></a>
               </li>
            </ul>
         </div>
      </nav>
   </div>
</div>
<?php } ?>

<?php if ($admin['admin_user'] == '0') { ?>
<div class="nav-left-sidebar sidebar-dark">
   <div class="menu-list">
      <nav class="navbar navbar-expand-lg navbar-light">
         <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
               <li class="nav-divider">Menu</li>
               <li class="nav-item">
                  <a class="nav-link active" href="index.php"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
               </li>
               
               <?php if (isset($userroles)) { ?>
                  <?php if (in_array('User', $userroles)) { ?>
                     <li class="nav-item">
                        <a class="nav-link" href="View_user.php"><i class="fa fa-user-plus"></i>User Management<span class="badge badge-success">6</span></a>
                     </li>
                  <?php } ?>
                  <?php if (in_array('Role', $userroles)) { ?>
                     <li class="nav-item">
                        <a class="nav-link" href="View_Role.php"><i class="fa fa-credit-card"></i>Role Management<span class="badge badge-success">6</span></a>
                     </li>
                  <?php } ?>
                  <?php if (in_array('Borrow', $userroles)) { ?>
                     <li class="nav-item">
                        <a class="nav-link" href="view_borrow.php"><i class="mdi mdi-google-wallet"></i>Borrow Management<span class="badge badge-success">6</span></a>
                     </li>
                  <?php } ?>
                  <?php if (in_array('Leaves', $userroles)) { ?>
                     <li class="nav-item">
                        <a class="nav-link" href="view_leaves.php"><i class="mdi mdi-calendar"></i>Leaves Management<span class="badge badge-success">6</span></a>
                     </li>
                  <?php } ?>
                  <?php if (in_array('Salary', $userroles)) { ?>
                     <li class="nav-item">
                        <a class="nav-link" href="view_salary.php"><i class="fa fa-credit-card"></i>Salary Management<span class="badge badge-success">6</span></a>
                     </li>
                  <?php } ?>
                  <?php if (in_array('Reports', $userroles)) { ?>
                     <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-file-alt"></i>Report</a>
                        <div id="submenu-4" class="collapse submenu">
                           <ul class="nav flex-column">
                              <li class="nav-item"><a class="nav-link" href="report_inc.php">New Employee</a></li>
                              <li class="nav-item"><a class="nav-link" href="borrow_report.php">Borrow Report</a></li>
                              <li class="nav-item"><a class="nav-link" href="app_report.php">Leave Approval Report</a></li>
                              <li class="nav-item"><a class="nav-link" href="rem_leave.php">Pending Leaves Report</a></li>
                              <li class="nav-item"><a class="nav-link" href="salary_slip_report.php">Salary Slip</a></li>
                              <li class="nav-item"><a class="nav-link" href="salary_report.php">Salary Disbursement Report</a></li>
                           </ul>
                        </div>
                     </li>
                  <?php } ?>
                  <?php if (in_array('Settings', $userroles)) { ?>
                     <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-sun"></i>Setting</a>
                        <div id="submenu-2" class="collapse submenu">
                           <ul class="nav flex-column">
                              <li class="nav-item"><a class="nav-link" href="backups.php">Backup Database</a></li>
                           </ul>
                        </div>
                     </li>
                  <?php } ?>
               <?php } ?>
               
               <li class="nav-item">
                  <a class="nav-link" href="../logout.php"><i class="fas fa-lock"></i>Logout<span class="badge badge-success">6</span></a>
               </li>
            </ul>
         </div>
      </nav>
   </div>
</div>
<?php } ?>