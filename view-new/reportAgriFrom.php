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
                    <h1 class="m-0 text-dark">ภาพรวมมูลค่าและปริมาณของแต่ละพื้นที่</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">ภาพรวมมูลค่าและปริมาณของแต่ละพื้นที่</li>
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
                                <label for="inputext"
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ปีงบประมาณ</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="year" id="year">
                                        <?php
                                            echo "<option value='0' selected > ทั้งหมด </option>";
                                            echo loadMonthOfYears($conn);
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputext"
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">สาขา</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="typeOfAgri_id" id="typeOfAgri_id">
                                        <?php
                                            echo loadTypeOfAgri($conn, $area_Id);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ชนิด</label>
                                <div class="col-sm-4">
                                    <select class="agri-dropdown" name="agriList" id="agriList" multiple="multiple"
                                        tabindex="1" size="5" style="width: 100%">
                                        <option value='0'>กรุณาเลือก</option>
                                    </select>
                                </div>
                                <label class="col-sm-4 col-form-label">(สามารถเลือกได้มากกว่า1ชนิด)</label>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">พันธุ์พืช
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="speciesId" id="speciesId">
                                        <option value='ALL'>ทั้งหมด</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputext"
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ลุ่มน้ำ</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="idRiverBasin" id="idRiverBasin">
                                        <?php  echo loadRiverDependent($conn);?>
                                    </select>
                                </div>

                            </div>
                            <!-- <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">พื้นที่เป้าหมาย</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="areaId" id="areaId">
                                        <option value='0'>กรุณาเลือก</option>
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
                            </div> -->
                            <div class="form-group row">
                                <label for="inputext"
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">จำนวนที่แสดง</label>
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
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary " id="search_reportIncome"><i
                                            class="menu-icon fa fa-search"></i> ออกรายงาน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">รายงานการเปรียบเทียบมูลค่าจากเป้าหมายรายได้กับมูลค่าการส่งมอบผลผลิตจำแนกจากพื้นที่</strong>
                        </div>
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-profile-tabQ" data-toggle="tab" href="#nav-profileQ" role="tab" aria-controls="nav-profile" aria-selected="false">กราฟเปรียบเทียบมูลค่าจากเป้าหมายรายได้กับมูลค่าการส่งมอบผลผลิตจำแนกจากพื้นที่</a>
                                    <a class="nav-item nav-link " id="nav-home-tabQ" data-toggle="tab" href="#nav-homeQ" role="tab" aria-controls="nav-home" aria-selected="true">ตารางเปรียบเทียบมูลค่าจากเป้าหมายรายได้กับมูลค่าการส่งมอบผลผลิตจำแนกจากพื้นที่</a>
                                </div>
                            </nav>
                            <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-profileQ" role="tabpanel" aria-labelledby="nav-profileQ">
                                    <canvas id="barChartValue"></canvas>
                                </div>
                                <div class="tab-pane fade" id="nav-homeQ" role="tabpanel" aria-labelledby="nav-home-tabQ">
                                    <div class="row col-sm-12" style="margin-bottom: 10px;">
                                        <div class="btn-group pull-right">	
                                            <button name="excel_totalBasinMarket" id="excel_totalBasinMarket" class="btn btn-success">Export Excel File</button>  
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="dashTableChartValue">
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
                </div><!-- /# column -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">รายงานการเปรียบเทียบปริมาณจากเป้าหมายรายได้กับปริมาณการส่งมอบผลผลิตจำแนกจากพื้นที่</strong>
                        </div>
                        <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-profile-tab2Q" data-toggle="tab" href="#nav-profile2Q" role="tab" aria-controls="nav-profile" aria-selected="false">กราฟเปรียบเทียบปริมาณจากเป้าหมายรายได้กับปริมาณการส่งมอบผลผลิตจำแนกจากพื้นที่</a>
                                <a class="nav-item nav-link " id="nav-home-tab2Q" data-toggle="tab" href="#nav-home2Q" role="tab" aria-controls="nav-home" aria-selected="true">ตารางเปรียบเทียบปริมาณจากเป้าหมายรายได้กับปริมาณการส่งมอบผลผลิตจำแนกจากพื้นที่</a>
                            </div>
                        </nav>

                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-profile2Q" role="tabpanel" aria-labelledby="nav-profile2Q">
                                    <canvas id="barChartAmount"></canvas>
                                </div>
                                <div class="tab-pane fade" id="nav-home2Q" role="tabpanel" aria-labelledby="nav-home-tab2Q">
                                    <div class="row col-sm-12" style="margin-bottom: 10px;">
                                        <div class="btn-group pull-right">	
                                            <button name="excel_totalAmount" id="excel_totalAmount" class="btn btn-success">Export Excel File</button>  
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="dashTableAmount">
                                            <thead>
                                            
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <!-- <canvas id="barChartAmount"></canvas>
                        </div> -->
                    </div>
                </div><!-- /# column -->
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
<script src="../assets/hrdi_js/reportAgriJs.js"></script>