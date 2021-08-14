<style>
  .hidescroll {
    overflow-y: auto;
  }

  .hidescroll::-webkit-scrollbar {
    display: none;
  }

  .hidescroll {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
  }

  .childActive {
    background-color: #5cb85c;
  }
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 hidescroll">
  <!-- Brand Logo -->
  <div class="row-md-3 m-1 p-1 text-center">
    <a href="dashboard.php">
      <img src="../images/logo.png" alt="Logo" width="150" height="150">
    </a>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel pb-3 mb-3 d-flex">
      <div class="info mx-auto">
        <span class="d-block text-white"><?php echo $_SESSION['fullName']; ?></span>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <?php
      $permssion = 'admin';
      if (isset($_SESSION['staffPermis'])) {
        $permssion = $_SESSION['staffPermis'];
      }
      $currentYears = date("Y-m-d h:i:s");
      $currentMonth = date("m");
      $path = $_SERVER['HTTP_REFERER'] . $_SERVER['PHP_SELF'];
      $file = basename($path);         // $file is set to "index.php"
      $file = basename($path, ".php"); // $file is set to "index"
      // $permssion = $_SESSION['staffPermis'];
      // if($permssion != 'admin'){
      ?>
      <input type="hidden" value="<?php echo $_SESSION['idRiverBasin'] ?>" id="idRiverBasin_session">
      <input type="hidden" value="<?php echo $_SESSION['idarea'] ?>" id="idarea_session">
      <input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>" id="AreaAll">
      <input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>" id="RBAll">
      <input type="hidden" value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">
      <input type="hidden" value="<?php echo  $_SESSION['idStaff']  ?>" id="staffId">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-header user-panel d-flex">ทะเบียนเกษตกร</li>
        <li class="nav-item">
          <a href="personChart.php" class="nav-link <?php echo ($file == 'personChart') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p class="text-white">
              สรุปภาพรวมข้อมูล
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="Agriculturaladd.php" class="nav-link <?php echo ($file == 'Agriculturaladd') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p class="text-white">
              จัดการข้อมูลเกษตรกร
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="addPersonView.php" class="nav-link <?php echo ($file == 'addPersonView') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-camera"></i>
            <p class="text-white">
              เพิ่มเกษตรกรผ่านมือถือ
            </p>
          </a>
        </li>
        <li class="nav-header user-panel d-flex mt-2">การผลิตและการตลาด</li>
        <li class="nav-item">
          <a href="showBasin.php" class="nav-link <?php echo ($file == 'showBasin' || $file == 'estimateProductLists' || $file == 'yearsListOfPlan' || $file == 'planProductListOfYears' || $file == 'addProductPlanOfYears' || $file == 'estimanteProductOfWeek' || $file == 'deliverProductListOfYear' || $file == 'deliverProductList' || $file == 'organizationManagement') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-bullseye"></i>
            <p class="text-white">
              เป้าหมายและส่งมอบ
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="deliverProductsFromPerson.php" class="nav-link <?php echo ($file == 'deliverProductsFromPerson') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-camera"></i>
            <p class="text-white">
              ส่งมอบผลผลิต
            </p>
          </a>
        </li>
        <li class="nav-header user-panel d-flex mt-2">ระบบบริหารการเงิน</li>
        <li class="nav-item <?php echo ($file == 'InstitutionManagement' || $file == 'personGroupManagement' || $file == 'personGroupMapping' || $file == 'businessGroup' || $file == 'AccountYearManagement') ? 'menu-open ' : ''; ?>">
          <a href="#" class="nav-link <?php echo ($file == 'InstitutionManagement') ? 'active ' : ''; ?>">
            <i class="nav-icon fas fa-money-bill"></i>
            <p class="text-white text-xs">
              จัดการข้อมูลสถาบันเกษตรกร
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="InstitutionManagement.php" class="nav-link <?php echo ($file == 'InstitutionManagement') ? 'childActive' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p class="text-white text-xs">จัดการข้อมูลสถาบันเกษตรกร</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="personGroupManagement.php" class="nav-link <?php echo ($file == 'personGroupManagement' || $file == 'personGroupMapping' || $file == 'businessGroup') ? 'childActive' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p class="text-white text-xs">จัดการสมาชิกสถาบันเกษตรกร</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="AccountYearManagement.php" class="nav-link <?php echo ($file == 'AccountYearManagement' || $file == 'organizationManagement') ? 'childActive' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p class="text-white text-xs">จัดการบัญชีปี</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>