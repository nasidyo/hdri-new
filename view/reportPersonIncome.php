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

    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../vendors/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">


    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
    <?php require '../connection/database.php'; ?>
    <?php require '../service/sessionCheck.php';?>

    <!-- Left Panel -->

    <?php include 'navbar.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php   //include 'header.php';
            require '../util/typeOfAgri.php';
            require '../util/loadYears.php';
            require_once '../util/loadMonth.php';
            require '../util/loadPersonFromAgri.php';
            $area_Id = $_GET['area_Id'];
            $db = new Database();
            $conn=  $db->getConnection();
        ?>

        <!-- <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>เพิ่มแปลงเกษตร</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">เพิ่มแปลงเกษตร</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> -->
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-10 ">
                                        <strong class="card-title">รายงานรายได้เกษตรกร</strong>
                                    </div>
                                    <div class="col-md-2 ">
                                        <a href="basinReport.php" class="btn btn-secondary"><i class="fa ti-angle-double-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">รายงานรายได้เกษตรกรของพื้นที่ 
                                            [<?php
                                                $result = '';
                                                $sql = "( SELECT areaName
                                                FROM
                                                    Area
                                                WHERE
                                                    idArea = '".$area_Id."'
                                                )";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmt )) {
                                                    $result = sqlsrv_get_field( $stmt, 0);
                                                }

                                                echo $result;
                                            ?>]
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">เลือกปีงบประมาณ</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"name="yearsOfPlan" id="yearsOfPlan">
                                                    <?php
                                                        echo loadYears($conn, $area_Id);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id ?>">
                                        <input type="hidden" id="actionPage" name="actionPage" value="show">
                                        <form class="form-horizontal" action="#" method="post" id="reportPersonIncome">
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"name="typeOfAgri_id" id="typeOfAgri_id">
                                                        <?php
                                                            echo loadTypeOfAgri($conn, $area_Id);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"name="agri" id="agri">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เดือน</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"name="month_id" id="month_id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                        <?php
                                                            echo loadMonthOfTheYears($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกษตรกร :</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="farmer_Id" id="farmer_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                        <?php
                                                            echo loadFarmerFromAgri($conn, $area_Id);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-primary " id="search_reportIncome"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">รายงานรายได้ของเกษตรกร </strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-homeM" role="tabpanel" aria-labelledby="nav-home-tabM">
                                                <canvas id="barChartM"></canvas>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/reportPersonIncome.js"></script>


</body>

</html>
