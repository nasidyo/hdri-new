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
                    <h1 class="m-0 text-dark">ภาพรวมรายได้เกษตรกร</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">ภาพรวมรายได้เกษตรกร</li>
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
                                            <div class="col-md-4">
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
<script src="../assets/hrdi_js/incomeReport.js"></script>