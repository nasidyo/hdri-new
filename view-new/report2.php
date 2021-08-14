<?php include 'includes/header.php'; 
    $db = new Database();
    $conn=  $db->getConnection();
    require '../util/loadYears.php';?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">รายงานภาพรวม</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">รายงานภาพรวม</li>
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
                            <h5 class="card-title">ปีงบประมาณ</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                                <label for="inputext" class="col-sm-2 col-form-label">เลือกปีงบประมาณ</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="yearsOfPlan" id="yearsOfPlan">
                                        <?php
                                            echo loadYears($conn);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">รายงานภาพรวม</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="row col-lg-12">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-4">
                                        <!-- small box -->
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3>
                                                    <div id="totalPerson"></div>
                                                </h3>

                                                <p>เกษตรกรได้รับการส่งเสริมทั้งหมด</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>
                                                    <div id="totalPersonDeliver"></div>
                                                </h3>
                                                <p>เกษตรกรได้รับการส่งเสริมที่ส่งมอบ</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <div class="col-lg-4"></div>
                                    <!-- /.col -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link " id="nav-quantity-tab" data-toggle="tab"
                                                href="#nav-quantity" role="tab" aria-controls="nav-quantity"
                                                aria-selected="false">ตารางแสดงข้อมูลปริมาณ</a>
                                            <a class="nav-item nav-link active" id="nav-cost-tab" data-toggle="tab"
                                                href="#nav-cost" role="tab" aria-controls="nav-cost"
                                                aria-selected="true">ตารางแสดงข้อมูลมูลค่า</a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade" id="nav-quantity" role="tabpanel"
                                            aria-labelledby="nav-quantity">
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมโครงการ</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="projectQuantity"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid" aria-describedby="projectQuantity_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>โครงการ</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>โครงการ</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมลุ่มน้ำ</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="basinQuantity"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid" aria-describedby="basinQuantity_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ลุ่มน้ำ</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>ลุ่มน้ำ</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมรายสาขา</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="typeAgriQuantity"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid"
                                                                    aria-describedby="typeAgriQuantity_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมช่องทางการตลาด</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="typeMarketTypeQuantity"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid"
                                                                    aria-describedby="typeMarketTypeQuantity_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>ปริมาณ</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">รายได้สะสม</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">
                                                                <div class="chart tab-pane active"
                                                                    style="position: relative;">
                                                                    <canvas id="monthy-chart-canvasQ" height="400"
                                                                        style="height: 400px;"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show active" id="nav-cost" role="tabpanel"
                                            aria-labelledby="nav-cost">
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมโครงการ</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="projectCost"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid" aria-describedby="projectCost_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>โครงการ</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>โครงการ</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมลุ่มน้ำ</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <!-- <table class="table table-striped table-bordered dataTable" id="projectCost"> -->
                                                                <table id="basinCost"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid" aria-describedby="basinCost_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ลุ่มน้ำ</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>ลุ่มน้ำ</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมรายสาขา</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="typeAgriCost"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid" aria-describedby="typeAgriCost_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ภาพรวมช่องทางการตลาด</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="marketTypeCost"
                                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                                    role="grid" aria-describedby="marketTypeCost_info">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>สาขา</th>
                                                                            <th>มูลค่า</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">รายได้สะสม</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">
                                                                <div class="chart tab-pane active"
                                                                    style="position: relative;">
                                                                    <canvas id="monthy-chart-canvasC" height="400"
                                                                        style="height: 400px;"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="loader"></div>

</div>
<!-- /.row (main row) -->
<!-- /.content-wrapper -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<?php include './includes/footer.php' ?>
<script src="../assets/js/main.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="../vendors/select2/dist/js/select2.min.js"></script>

<script src="../assets/hrdi_js/DashBoard-New/dashboard-newJs.js"></script>