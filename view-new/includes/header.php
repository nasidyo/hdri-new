<!DOCTYPE html>
<html>
<?php 
  $url = basename($_SERVER["SCRIPT_FILENAME"], '.php');
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <link rel="icon" href="upload/title_icon.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<?php 
  include('includes/functions.php');
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  
?>

<?php
     require '../connection/database.php';
     require './service/sessionCheck.php';
?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <!-- <a href="index3.html" class="nav-link">Home</a> -->
                    <a href="index.php" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <!-- <a href="index.php" class="brand-link text-center"> -->
            <a href="index.php" class="brand-link text-center">
                <div class="row-md-3">
                    <span class="brand-text font-weight-bold">สารสนเทศด้านการตลาด</span>
                </div>
            </a>


            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block">Admin</a>
          </div>
        </div> -->

                <!-- Sidebar Menu -->



                <!-- <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php if ($url == 'index') { echo "active"; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    รายงานภาพรวม
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav> -->

                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">รายงาน</a>
                    </div>
                </div> -->

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php if ($url == 'index') { echo "active"; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item has-treeview <?php if($url == 'report-new' || $url == 'report-Basin' || $url == 'report-NewFilter' || $url == 'report-NewType' || $url == 'report-NewAgri' || $url == 'report-Target' || $url == 'report-NewProject') {echo "menu-open" ;} ?>">
                            <a href="#"
                                class="nav-link <?php if($url == 'report-new' || $url == 'report-Basin' || $url == 'report-NewFilter' || $url == 'report-NewType' || $url == 'report-NewAgri' || $url == 'report-Target' || $url == 'report-NewProject') {echo "active" ;} ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    รายงานภาพรวม
                                    <i class="right fas fa-angle-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="report-new.php"
                                        class="nav-link <?php if ($url == 'report-new') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            ภาพรวมสถาบัน
                                        </p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="report-Basin.php"
                                        class="nav-link <?php if ($url == 'report-Basin') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            ภาพรวมลุ่มน้ำ
                                        </p>
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="report-NewFilter.php"
                                        class="nav-link <?php if ($url == 'report-NewFilter' || $url == 'report-Target') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            ภาพรวมลุ่มน้ำ
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="report-NewProject.php"
                                        class="nav-link <?php if ($url == 'report-NewProject' || $url == 'report-Target') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            ภาพรวมโครงการ
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="report-NewType.php"
                                        class="nav-link <?php if ($url == 'report-NewType' || $url == 'report-NewAgri') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            ภาพรวมสาขาพืช
                                        </p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="report-NewAgri.php"
                                        class="nav-link">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p> ภาพรวมรายพืช </p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="mutipleReport.php" class="nav-link <?php if ($url == 'mutipleReport') { echo "active"; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    รายงานแผนผล
                                </p>
                            </a>
                        </li>

                        <li
                            class="nav-item has-treeview <?php if($url == 'viewReport' || $url == 'viewReportN' || $url == 'viewPMByMK' ||$url == 'basinReport' || $url == 'reportPersonIncome' || $url == 'incomeReport' || $url == 'reportAgriFrom' || $url == 'reportPlotly' || $url == 'farmerReport') {echo "menu-open" ;} ?>">
                            <a href="#"
                                class="nav-link <?php if($url == 'viewReport' || $url == 'viewReportN' || $url == 'viewPMByMK' ||$url == 'basinReport' || $url == 'reportPersonIncome' || $url == 'incomeReport' || $url == 'reportAgriFrom' || $url == 'reportPlotly' || $url == 'farmerReport' ) {echo "active" ;} ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    รายงานเพิ่มเติม
                                    <i class="right fas fa-angle-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="viewReport.php"
                                        class="nav-link <?php if ($url == 'viewReport') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                           เป้าหมายผลผลิต
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="viewReportN.php"
                                        class="nav-link <?php if ($url == 'viewReportN') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            รายได้และส่งมอบผลผลิต
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="viewPMByMK.php"
                                        class="nav-link <?php if ($url == 'viewPMByMK') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            ช่องทางตลาด
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="basinReport.php"
                                        class="nav-link <?php if ($url == 'basinReport' || $url == 'reportPersonIncome') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            รายได้ของเกษตกร
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="incomeReport.php"
                                        class="nav-link <?php if ($url == 'incomeReport') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            รายได้ของผลผลิต
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="reportAgriFrom.php"
                                        class="nav-link <?php if ($url == 'reportAgriFrom') { echo "active"; } ?>">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            รายได้ของพื้นที่
                                        </p>
                                    </a>
                                </li>
                                <li class= "nav-item">
                                    <a href="farmerReport.php" class="nav-link <?php if ($url == 'farmerReport') { echo "active";} ?>">
                                    <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            การส่งมอบของเกษตกร
                                        </p>
                                    </a>
                                </li>
                                <!-- <li class= "nav-item">
                                    <a href="mutipleReport.php" class="nav-link <?php if ($url == 'mutipleReport') { echo "active";} ?>">
                                    <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            รายงานใหม่
                                        </p>
                                    </a>
                                </li> -->

                                <!-- <?php if ($_SESSION['staffPermis'] != 'staff'){?>
                                    <li class="nav-item">
                                        <a href="reportPlotly.php"
                                            class="nav-link <?php if ($url == 'reportPlotly') { echo "active"; } ?>">
                                            <i class="nav-icon far fa-circle nav-icon"></i>
                                            <p>
                                            ภาพรวมปริมาณผลผลิตส่งแต่ละช่องทางตลาด
                                            </p>
                                        </a>
                                    </li>
                                <?php } ?> -->
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="dashboard2.php" class="nav-link <?php if ($url == 'dashboard2') { echo "active"; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard-new
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="report2.php" class="nav-link <?php if ($url == 'report2') { echo "active"; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    ภาพรวม-new
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="report3.php" class="nav-link <?php if ($url == 'report3') { echo "active"; } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    ภาพรวมสาขาพืช-new
                                </p>
                            </a>
                        </li>
                        <!-- -->
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>