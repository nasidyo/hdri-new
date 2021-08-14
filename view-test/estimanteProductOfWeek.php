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

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>

        <?php require '../connection/database.php'; ?> <?php require '../service/sessionCheck.php'; ?> <?php include 'navbarTest.php' ?>
        <div class="content-wrapper">


            <!-- Header-->
            <?php include 'menuToggle.php';
            require '../util/loadYearsOfPlan.php';
            $area_Id = $_GET['area_Id'];
            $yearsId = $_GET['yearsId'];
            $monthId = $_GET['monthId'];
            $permssion = $_SESSION['staffPermis'];
            $idOutputValue = $_GET['idOutputValue'];
            $db = new Database();
            $conn =  $db->getConnection();
            ?>
            <!-- .content -->
            <div class="content mt-3">

                <div class="animated fadeIn">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <div class="col-md-10 ">
                                            <strong class="card-title">ตารางประมาณการผลผลิตประจำเดือน</strong>
                                        </div>
                                        <div class="col-md-2 ">
                                            <a href="estimateProductLists.php?area_Id=<?php echo $area_Id ?>&yearsId=<?php echo $yearsId ?> " class="btn btn-secondary"><i class="fa ti-angle-double-left"></i> Back</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">ประมาณการผลผลิตประจำ เดือน
                                                [<?php
                                                    $monthName = '';
                                                    $monthSql = "( SELECT Month_name
                                                FROM
                                                    MonthOfYear
                                                WHERE
                                                    Month_id = '" . $monthId . "'
                                                )";
                                                    $monthstmt = sqlsrv_query($conn, $monthSql);
                                                    if (sqlsrv_fetch($monthstmt)) {
                                                        $monthName = sqlsrv_get_field($monthstmt, 0);
                                                    }
                                                    echo $monthName;
                                                    ?>]
                                                ปี
                                                [<?php
                                                    $yearsName = '';
                                                    $yearssql = "( SELECT nameYear
                                                FROM
                                                    YearTB
                                                WHERE
                                                    idYearTB = '" . $yearsId . "'
                                                )";
                                                    $stmtYears = sqlsrv_query($conn, $yearssql);
                                                    if (sqlsrv_fetch($stmtYears)) {
                                                        $yearsName = sqlsrv_get_field($stmtYears, 0);
                                                    }

                                                    echo $yearsName;
                                                    ?>]
                                                [<?php
                                                    $result = '';
                                                    $sql = "( SELECT areaName
                                                FROM
                                                    Area
                                                WHERE
                                                    idArea = '" . $area_Id . "'
                                                )";
                                                    $stmt = sqlsrv_query($conn, $sql);
                                                    if (sqlsrv_fetch($stmt)) {
                                                        $result = sqlsrv_get_field($stmt, 0);
                                                    }

                                                    echo $result;
                                                    ?>]
                                            </strong>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id ?>">
                                            <input type="hidden" id="monthId" name="monthId" value="<?php echo $monthId ?>">
                                            <input type="hidden" id="permssion" name="permssion" value="<?php echo $permssion ?>">
                                            <input type="hidden" id="idOutputValue" name="idOutputValue" value="<?php echo $idOutputValue ?>">
                                            <table id="estimateProductOfWeekList-Table" name="estimateProductOfWeekList-Table" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>สาขาพืช</th>
                                                        <th>ชนิดพืช</th>
                                                        <th>ประจำสัปดาห์ที่</th>
                                                        <th>ปริมาณ</th>
                                                        <th>ราคาต่อหน่วย</th>
                                                        <th>มูลค่ารวม</th>
                                                        <!-- <th></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot style='background: beige;'>
                                                    <tr>
                                                        <th colspan="3" style="text-align:right" class="dt-header-center">ปริมาณรวม :</th>
                                                        <th></th>
                                                        <th style="text-align:right" class="dt-header-center">มูลค่ารวม :</th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!-- <div class="row form-group" style="float: right;">
                                            <div class="col col-sm-12">
                                                <button type="button" class="btn btn-primary" href="javascript:void(0)" id="editOnTableBtn" name="editOnTableBtn" ><i class="fa fa-edit"></i>&nbsp; แก้ไขทั้งหมด</button>
                                            </div>
                                        </div> -->
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
    </div>
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
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/hrdi_js/estimateProductOfWeekList.js"></script>
    <script src="../assets/hrdi_js/validatefield.js"></script>
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