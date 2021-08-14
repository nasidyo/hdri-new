<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];

    // require '../service/sessionCheck.php';
    require '../util/RiverBasinDependent.php';
    require '../util/typeOfAgri.php';
    require '../util/loadYearsPlan.php';
    require '../util/loadMonth.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">รายงานเป้าหมายรายได้และส่งมอบผลผลิต จำแนกรายพืช</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">เป้าหมายรายได้และส่งมอบผลผลิต จำแนกรายพืช</li>
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
                        <div class="card-body">
                            <div class="form-group row">
                                    <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ปีงบประมาณ</label>
                                    <div class="col-sm-4">
                                        <select class="form-control"name="year" id="year">
                                            <?php
                                                echo "<option value='0' selected > ทั้งหมด </option>";
                                                echo loadMonthOfYears($conn);
                                            ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ลุ่มน้ำ</label>
                                    <div class="col-sm-4">
                                        <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                            <?php  echo loadRiverDependent($conn);?>
                                        </select>
                                    </div>

                            </div>
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">พื้นที่เป้าหมาย</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="areaId" id="areaId">
                                        <option value='0'>กรุณาเลือก</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">สาขา</label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="typeOfAgri_id" id="typeOfAgri_id">
                                        <?php
                                            echo loadTypeOfAgri($conn, $area_Id);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ชนิด</label>
                                <div class="col-sm-4">
                                    <select class="agri-dropdown" name="agriList" id="agriList" multiple="multiple" tabindex="1" size="5" style="width: 100%">
                                        <option value='0'>กรุณาเลือก</option>
                                    </select>
                                </div>
                                <label class="col-sm-4 col-form-label">(สามารถเลือกได้มากกว่า1ชนิด)</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">พันธุ์พืช </label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="speciesId" id="speciesId">
                                        <option value='ALL'>ทั้งหมด</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">เดือน</label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="month_id" id="month_id">
                                        <option value='0'>กรุณาเลือก</option>
                                        <?php
                                            echo loadMonthOfTheYears($conn);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary " id="search_reportIncome"><i class="menu-icon fa fa-search"></i> ออกรายงาน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">เปรียบเทียบมูลค่าเป้าหมายและมูลค่าการส่งมอบผลผลิต จำแนกรายพืช</strong>
                    </div>
                    <div class="card-body">
                    <canvas id="barChartValue"></canvas>
                    </div>
                </div>
            </div><!-- /# column -->
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">เปรียบเทียบปริมาณเป้าหมายและปริมาณการส่งมอบผลผลิต จำแนกรายพืช</strong>
                    </div>
                    <div class="card-body">
                    <canvas id="barChartVolume"></canvas>
                    </div>
                </div>
            </div><!-- /# column -->
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
<script src="../assets/hrdi_js/viewReportN.js"></script>
