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
        <?php include 'menuToggle.php';
            require '../util/loadYearsPlan.php';
            require '../util/typeOfAgri.php';
            require '../util/RiverBasinDependent.php';
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
                                        <strong class="card-title">รายงานรายได้ผลผลิต</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ปีงบประมาณ</strong>
                                    </div>
                                    <div class="card-body" id='search'>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">เลือกปีงบประมาณ</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"name="yearsOfPlan" id="yearsOfPlan">
                                                    <?php
                                                        echo loadMonthOfYears($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class="card-body" id='search'>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">พื้นที่ลุ่มน้ำ</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                                    <?php
                                                        echo loadRiverDependent($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">พื้นที่เป้าหมาย</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="areaId" id="areaId">
                                                    <option value='0'>กรุณาเลือก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">สาขา</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="typeOfAgri_id" id="typeOfAgri_id">
                                                    <?php
                                                        echo loadTypeOfAgri($conn, null);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ชนิด</label>
                                            <div class="col-sm-4">
                                                <select class="agri-dropdown" name="agriList" id="agriList" multiple="multiple" tabindex="1" size="5" style="width: 100%">
                                                    <option value='0'>กรุณาเลือก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พันธุ์พืช :</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="speciesId" id="speciesId">
                                                    <option value='ALL'>ทั้งหมด</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">เกรด</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="typeOfGradeId" id="typeOfGradeId">
                                                    <option value='ALL'>กรุณาเลือก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">มาตราฐาน</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="typeofStandardId" id="typeofStandardId">
                                                    <option value='ALL'>กรุณาเลือก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary " id="search_reportIncome"><i class="menu-icon fa fa-search"></i> ออกรายงาน</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">รายงานปริมาณผลผลิต</strong>
                                    </div>
                                    <div class="card-body">
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-profile-tabQ" data-toggle="tab" href="#nav-profileQ" role="tab" aria-controls="nav-profile" aria-selected="false">กราฟแสดงปริมาณการส่งมอบผลผลิต</a>
                                                <a class="nav-item nav-link " id="nav-home-tabQ" data-toggle="tab" href="#nav-homeQ" role="tab" aria-controls="nav-home" aria-selected="true">ตารางแสดงปริมาณการส่งมอบผลผลิต</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-profileQ" role="tabpanel" aria-labelledby="nav-profileQ">
                                                <canvas id="barChartQ"></canvas>
                                            </div>
                                            <div class="tab-pane fade" id="nav-homeQ" role="tabpanel" aria-labelledby="nav-home-tabQ">
                                                <table class="table table-striped table-bordered" id="dashTableQ">
                                                    <thead>
                                                    
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">รายงานรายได้ผลผลิต</strong>
                                </div>
                                <div class="card-body">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-profile-tabM" data-toggle="tab" href="#nav-profileM" role="tab" aria-controls="nav-profile" aria-selected="false">กราฟแสดงมูลค่าการส่งมอบผลผลิต</a>
                                            <a class="nav-item nav-link " id="nav-home-tabM" data-toggle="tab" href="#nav-homeM" role="tab" aria-controls="nav-home" aria-selected="true">ตารางแสดงมูลค่าการส่งมอบผลผลิต</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-profileM" role="tabpanel" aria-labelledby="nav-profile-tabM">
                                            <canvas id="barChartM"></canvas>
                                        </div>
                                        <div class="tab-pane fade" id="nav-homeM" role="tabpanel" aria-labelledby="nav-home-tabM">
                                            <table class="table table-striped table-bordered " id="dashTableM">
                                                <thead>
                                                
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
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


    <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/hrdi_js/incomeReport.js"></script>
    
</body>

</html>
