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

	<link rel="stylesheet" href="../assets/css/hrdi.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>


    <!-- Left Panel -->

    <?php 
	require '../connection/database.php';
	require '../service/sessionCheck.php';
	include 'navbar.php';


    require '../util/RiverBasinDependent.php';
    require '../util/typeOfAgri.php';

    $db = new Database();
    $conn=  $db->getConnection();
    ?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php //include 'header.php';?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>สรุปรายงาน</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">สรุปรายงาน</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">
                </div>
                <div class="card">
                    <div class="card-body">
                         <div class="form-group row">
                            <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ลุ่มน้ำ</label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                        <?php  echo loadRiverDependent($conn);?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                                    <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">พื้นที่</label>
                                    <div class="col-sm-8">
                                        <select class="form-control"name="idArea" id="area">

                                        </select>
                                    </div>
                        </div>
                        <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ปีงบประมาณ</label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="year" id="year">

                                                    <?php
                                                        $sql5="select *  from YearTB ";
                                                        $stmt = sqlsrv_query( $conn, $sql5 );
                                                        echo "<option value='0' selected > ทั้งหมด </option>";
                                                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                          $id_pre=$row["idYearTB"];
                                                          $name_pre=$row["nameYear"];
                                                          $defaultYear = $row["defaultYear"];
                                                          if( $defaultYear =='Y'){
                                                            echo "<option value='$id_pre' selected > $name_pre</option>";
                                                          }else{
                                                                echo "<option value='$id_pre'> $name_pre</option>";
                                                          }

                                                        }
                                                      ?>

                                    </select>
                                </div>
                            </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">รายงานการเปรียบเทียบมูลค่าการส่งมอบผลผลิตตามลุ่มน้ำและตลาด</strong>
                            </div>
                            <div class="card-body">
                            <canvas id="pieChartValue"></canvas>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">รายงานการเปรียบเทียบปริมาณการส่งมอบผลผลิตตามลุ่มน้ำและตลาด</strong>
                            </div>
                            <div class="card-body">
                            <canvas id="pieChartVolume"></canvas>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div>

            </div><!-- .animated -->

        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>


    <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/widgets.js"></script>
    <script src="../vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <!-- dataTable -->
   <!-- <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>-->
    <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script>

    <script src="../assets/hrdi_js/viewPMByMK.js"></script>
     <!--  Chart js -->



</body>

</html>
