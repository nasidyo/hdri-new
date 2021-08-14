<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];

    // require '../service/sessionCheck.php';
    require '../util/typeOfAgri.php';
    require '../util/loadYears.php';
    require_once '../util/loadMonth.php';
    require '../util/loadPersonFromAgri.php';
    $area_Id = $_GET['area_Id'];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">ภาพรวมลุ่มน้ำ</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-10 ">
                                    <strong class="card-title">รายงานรายได้เกษตรกร</strong>
                                </div>
                                <div class="col-md-2 ">
                                    <a href="basinReport.php" class="btn btn-secondary"><i
                                            class="fa ti-angle-double-left"></i> Back</a>
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
                                            <select class="form-control" name="yearsOfPlan" id="yearsOfPlan">
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
                                                <select class="form-control" name="typeOfAgri_id" id="typeOfAgri_id">
                                                    <?php
                                                            echo loadTypeOfAgri($conn, $area_Id);
                                                        ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ชนิดพืช</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="agri" id="agri">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">เดือน</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="month_id" id="month_id">
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
                                            <label for="inputext" class="col-sm-2 col-form-label">รายได้ระหว่าง</label>
                                            <div class="col-lg-2">
                                                <input id="incomeStart" name="incomeStart" onkeypress="return isNumberKey(this,event)" placeholder="เริ่มต้น" value="" class="form-control reset" type="text">
                                            </div>
                                            <label class="col-form-lable">-</label>
                                            <div class="col-lg-2">
                                                <input id="incomeEnd" name="incomeEnd" onkeypress="return isNumberKey(this,event)" placeholder="จนถึง" value="" class="form-control reset" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">จำนวนที่แสดง</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="showUnit" id="showUnit">
                                                    <option value='5'>5</option>
                                                    <option value='10'>10</option>
                                                    <option value='15'>15</option>
                                                    <option value='20'>20</option>
                                                    <option value='0'>ทั้งหมด</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary "
                                                    id="search_reportIncome"><i class="menu-icon fa fa-search"></i>
                                                    ค้นหา</button>
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
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-profile-tabM" data-toggle="tab" href="#nav-profileM" role="tab" aria-controls="nav-profile" aria-selected="false">กราฟแสดงรายได้เกษตกร</a>
                                            <a class="nav-item nav-link " id="nav-home-tabM" data-toggle="tab" href="#nav-homeM" role="tab" aria-controls="nav-home" aria-selected="true">ตารางแสดงรายได้เกษตกร</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-profileM" role="tabpanel" aria-labelledby="nav-profile-tabM">
                                            <canvas id="barChartM"></canvas>
                                        </div>
                                        <div class="tab-pane fade" id="nav-homeM" role="tabpanel" aria-labelledby="nav-home-tabM">
                                            <div class="row col-sm-12" style="margin-bottom: 10px;">
                                                <div class="btn-group pull-right">	
                                                    <button name="excel_totalMonthy" id="excel_totalMonthy" class="btn btn-success">Export Excel File</button>  
                                                </div>
                                            </div>
                                            <table class="table table-striped table-bordered " id="dashTableM">
                                                <thead>
                                                    <th>ชื่อ-นามสกุล</th>
                                                    <th>รายได้รวม</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-body">
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-homeM" role="tabpanel"
                                            aria-labelledby="nav-home-tabM">
                                            <canvas id="barChartM"></canvas>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</div>
<!-- /.row (main row) -->
<!-- /.content-wrapper -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="./dist/js/pages/dashboard.js"></script> -->
<?php include './includes/footer.php' ?>
<script src="../assets/js/main.js"></script>
<script src="../vendors/select2/dist/js/select2.min.js"></script>
<script src="../assets/hrdi_js/reportPersonIncome.js"></script>
<script src="../assets/hrdi_js/validatefield.js"></script>