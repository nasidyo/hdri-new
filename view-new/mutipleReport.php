<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $yearsId = "2564";
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];
    require '../util/loadYearsDefault.php';
    require '../util/loadAllAreaDropdown.php';
    require '../util/loadAllArgiDropdown.php';
    require '../util/loadAllMarketDropdown.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">รายงานแผนผล</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">รายงานแผนผล</li>
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
                    <!-- start Header -->
                        <div class="card-header">
                        <h5 class="card-title">ตัวเลือกสำหรับคัดกรองข้อมูล</h5></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label">เลือกปีงบประมาณ</label>
                                <div class="col-sm-5">
                                    <select class="form-control"name="yearsOfPlan" id="yearsOfPlan">
                                        <option value="0">กรุณาเลือก</option>
                                        <?php
                                            echo loadYears($conn);
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label">เลือกพื้นที่</label>
                                <div class="col-sm-4">

                                    <select class="area-dropdown" name="areaList" id="areaList" multiple="multiple" tabindex="1" size="5" style="width: 100%">
                                        <?php
                                            echo loadAllareaDropdown($conn);
                                        ?>
                                    </select>
                                </div>
                                <label class="col-sm-3 col-form-label">(สามารถเลือกได้มากกว่า1)</label>
                            </div>
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label">เลือกชนิดพืช</label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="agriList" id="agriList" multiple="multiple" tabindex="1" size="5" style="width: 100%">
                                        <?php
                                            echo loadAllargiDropdown($conn);
                                        ?>
                                    </select>
                                </div>
                                <label class="col-sm-3 col-form-label">(สามารถเลือกได้มากกว่า1)</label>
                            </div>
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label">เลือกประเภทตลาด</label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="marketList" id="marketList" multiple="multiple" tabindex="1" size="5" style="width: 100%">
                                        <?php
                                            echo loadAllMarketDropdown($conn);
                                        ?>
                                    </select>
                                </div>
                                <label class="col-sm-3 col-form-label">(สามารถเลือกได้มากกว่า1)</label>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary " id="search_reportIncome"><i class="menu-icon fa fa-search"></i>  กรองข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="card">
                        <div class="card-header">
                            <center><h5 class="card-title">ตัวเลือกแกนY</h5></center>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <button type="button" onclick='return reportNewF.a1_onclick(5)' class="btn btn-block btn-default report1 report" id="axes1Y_5">มูลค่าแผน</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a1_onclick(1)" class="btn btn-block btn-default report1 report active" id="axes1Y_1">มูลค่าผล</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a1_onclick(2)" class="btn btn-block btn-default report1 report" id="axes1Y_2">ปริมาณแผน</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a1_onclick(3)" class="btn btn-block btn-default report1 report" id="axes1Y_3">ปริมาณผล</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a1_onclick(4)" class="btn btn-block btn-default report1 report" id="axes1Y_4">ราคาต่อหน่วย</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">รายงาน</h5>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="chart tab-pane active" id="mix-chart">
                                    <canvas id="compare-price-canvas">
                                    </canvas>
                                </div>
                                <!-- <div class="chart tab-pane active" id="mix-chart" style="position: relative; height: 300px;">
                                    <canvas id="compare-price-canvas" height="400"
                                        style="height: 400px;">
                                    </canvas>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card">
                        <div class="card-header">
                            <center><h5 class="card-title">ตัวเลือกแกนY</h5></center>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a2_onclick(5)" class="btn btn-block btn-default report2 report active" id="axes2Y_5">มูลค่าแผน</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a2_onclick(1)" class="btn btn-block btn-default report2 report" id="axes2Y_1">มูลค่าผล</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a2_onclick(2)" class="btn btn-block btn-default report2 report" id="axes2Y_2">ปริมาณแผน</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a2_onclick(3)" class="btn btn-block btn-default report2 report" id="axes2Y_3">ปริมาณผล</button>
                            </div>
                            <div class="form-group row">
                                <button type="button" onclick="return reportNewF.a2_onclick(4)" class="btn btn-block btn-default report2 report" id="axes2Y_4">ราคาต่อหน่วย</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">ตาราง</h5>
                        </div>
                        <div class="card-body">
                            <div class="row col-sm-12" style="margin-bottom: 10px;">
                                <div class="btn-group pull-right">	
                                    <button name="excel_totalMarket" id="excel_totalMarket" class="btn btn-success">Export Excel File</button>  
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="totalMonthyFB" class="table m-0 table-bordered" style="text-align: center; background: honeydew;">
                                    <thead></thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">ตัวเลือกแกนX</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report" onclick="return reportNewF.a3_onclick(6)" id="axesX_6">รายปี</button>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report active" onclick="return reportNewF.a3_onclick(1)" id="axesX_1">รายเดือน</button>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report" onclick="return reportNewF.a3_onclick(2)" id="axesX_2">รายลุ่มน้ำ</button>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report" onclick="return reportNewF.a3_onclick(3)" id="axesX_3">รายพื้นที่</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report" onclick="return reportNewF.a3_onclick(4)" id="axesX_4">รายโครงการ</button>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report" onclick="return reportNewF.a3_onclick(5)" id="axesX_5">รายประเภทตลาด</button>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report" onclick="return reportNewF.a3_onclick(7)" id="axesX_7">รายสาขาพืช</button>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <button type="button" class="btn btn-block btn-default report3 report" onclick="return reportNewF.a3_onclick(8)" id="axesX_8">รายพืช</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="loader">
        <!-- <i class="fas fa-3x fa-sync-alt fa-spin"></i>
        <div class="text-bold pt-2">Loading...</div> -->
    </div>
</div>
<!-- /.row (main row) -->
<!-- /.content-wrapper -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="./dist/js/pages/dashboard.js"></script> -->
<?php include './includes/footer.php' ?>
<script src="../assets/js/main.js"></script>
<script src="../vendors/select2/dist/js/select2.min.js"></script>
<script src="../assets/hrdi_js/DashBoard-New/mutipleReport.js"></script>