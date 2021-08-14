<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบการบริหารจัดการด้านการเงินเกษตรกร</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="adminlte/AdminLTE-master/dist/css/adminlte.css">
    <link rel="stylesheet" href="adminlte/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../vendors/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="./adminlte/AdminLTE-master/dist/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php require '../connection/database.php'; ?>
    <?php require '../service/sessionCheck.php';?>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <h4 class="ml-3">เป้าหมายและส่งมอบ</h4>
    </ul>
  </nav>
  <!-- /.navbar -->


    <!-- Left Panel -->

    <?php include 'navbarTest.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div class="content-wrapper">

        <!-- Header-->
        <?php   include 'menuToggle.php';
            require '../util/RiverBasinDependent.php';
            require '../util/loadStatus.php';
            require '../util/loadYears.php';
            $permssion = $_SESSION['staffPermis'];
            $db = new Database();
            $conn=  $db->getConnection();
        ?>

    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-8 ">
                                        <strong class="card-title">ตารางพื้นที่เป้าหมาย</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class="card-body" id='search'>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">เลือกปีงบประมาณ</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"name="yearsOfPlan" id="yearsOfPlan">
                                                    <?php
                                                        echo loadYears($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                            $permssion = $_SESSION['staffPermis'];
                                            if ($permssion != 'staff' and $permssion != 'manager'){
                                        ?>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">พื้นที่ลุ่มน้ำ</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                                    <?php
                                                       // echo loadRiverDependent($conn);
                                                       echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">สถานะ</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="idStatus" id="idStatus">
                                                    <?php
                                                        echo loadStatuslist($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" id="permssion" name="permssion" value="<?php echo $permssion?>">
                                    <table id="basinTable" name="basinTable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>รหัสโครงการ</th>
                                                <th>ลุ่มน้ำ</th>
                                                <th>พื้นที่เป้าหมาย</th>
                                                <th>สถานะ</th>
                                                <th></th>
                                                <th>
                                                    <i class="fa fa-list-alt"style=" color: blue;"></i> วางแผนเป้าหมาย <br/>
                                                    <i class="fa fa-eye"style=" color: blue;"></i> แสดงเป้าหมาย <br/>
                                                    <i class="fa fa fa-calendar"style=" color: green;"></i> ประมาณผลผลิต <br/>
                                                    <i class="fa fa fa-truck"style=" color: red;"></i> ส่งมอบผลผลิต <br/>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->

            <div id="loader"></div>
        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->
    </div>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>


    <!-- <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script> -->
    <!-- <script src="../assets/js/dashboard.js"></script> -->
    <!-- <script src="../assets/js/widgets.js"></script> -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <!-- dataTable -->
    <script src="../assets/hrdi_js/moment.min.js"></script>
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/hrdi_js/basin.js"></script>
    <script src="adminlte/AdminLTE-master/dist/js/adminlte.js"></script>

    <!-- <script>
        (function($) {
            "use strict";

            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#1de9b6', '#03a9f5'],
                normalizeFunction: 'polynomial'
            });
        })(jQuery);
    </script> -->

</body>

</html>
