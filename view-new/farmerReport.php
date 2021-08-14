<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];

    // require '../service/sessionCheck.php';
    require '../util/loadYearsPlan.php';
    require '../util/typeOfAgri.php';
    require '../util/RiverBasinDependent.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">รายงานการส่งมอบผลผลิตของเกษตกร</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">รายงานการส่งมอบผลผลิตของเกษตกร</li>
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
                                    <div class="col-md-8 ">
                                        <strong class="card-title">รายงานการส่งมอบผลผลิตของเกษตรกร</strong>
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
                                            <label class="col-sm-2 col-form-label">มาตราฐาน</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="typeofStandardId" id="typeofStandardId">
                                                    <option value='ALL'>ทั้งหมด</option>
                                                    <option value='0'>ไม่มี</option>
                                                    <option value='1'>GAP</option>
                                                    <option value='2'>ORGANIC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary " id="search_reportIncome"><i class="menu-icon fa fa-search"></i> ออกรายงาน</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">การส่งมอบผลผลิตของเกษตร</strong>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="barChartValue"></canvas>
                                    </div>
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
<script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/select2/dist/js/select2.min.js"></script>
<script src="../assets/hrdi_js/farmerReport.js"></script>