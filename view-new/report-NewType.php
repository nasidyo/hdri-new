<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $yearsId = "2563";
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];
    require '../util/loadYears.php';
    // include '../util/loadBtnTypeOAgri.php'
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">ภาพรวมสาขาพืช</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">ภาพรวมสาขาพืช</li>
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
                        <h5 class="card-title">ปีงบประมาณ</h5></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputext" class="col-sm-2 col-form-label">เลือกปีงบประมาณ</label>
                                <div class="col-sm-5">
                                    <select class="form-control"name="yearsOfPlan" id="yearsOfPlan">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <!-- start Header -->
                        <div class="card-header">
                            <h5 class="card-title" id="titleButtomSection">สาขาพืช</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                      <!-- start body -->
                        <div class="card-body">
                            <div id="sectionBtnSelecte"></div>
                        </div>
                    </div>
                </div>
            </div>
</div>
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <!-- start Header -->
                        <div class="card-header">
                            <h5 class="card-title">มูลค่าส่งมอบผลผลิตของสถาบัน รายสาขาพืช จำแนกตามช่องทางการตลาด ปีงบประมาณ พ.ศ. <?php
                                                $yearsName = '';
                                                $sql = "( SELECT nameYear
                                                FROM
                                                    YearTB
                                                WHERE
                                                    idYearTB = '".$yearsId."'
                                                )";
                                                $stmtYears = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmtYears )) {
                                                    $yearsName = sqlsrv_get_field( $stmtYears, 0);
                                                }

                                                echo $yearsName;
                                            ?> </h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                      <!-- start body -->
                        <div class="card-body">
                            <div class="row col-sm-12" style="margin-bottom: 10px;">
                                <div class="btn-group pull-right">	
                                    <button name="excel_totalMarket" id="excel_totalMarket" class="btn btn-success">Export Excel File</button>  
                                </div>
                            </div>
                            <div class="table-responsive">
                                  <!-- <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>"> -->
                                  <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                                  <input type="hidden" id="typeAgri" name="typeAgri" value="0">
                                  <input type="hidden" id="permssion" name="permssion" value="<?php echo $permssion?>">
                                  <table id="totalMarket" class="table m-0 table-bordered" style="text-align: center;">
                                        <thead>
                                          <tr>
                                              <th rowspan="2">
                                                    รายสาขา
                                              </th>
                                              <th colspan="2">ตลาดข้อตกลง</th>
                                              <th colspan="2">ตลาดโครงการหลวง</th>
                                              <th colspan="2">ตลาดอุทยานหลวงฯ</th>
                                              <th colspan="2">ตลาดท้องถิ่น</th>
                                              <th colspan="2">ตลาดออนไลน์</th>
                                              <th colspan="2">บริโภค</th>
                                              <th colspan="2" >รวม</th>
                                          </tr>
                                          <tr>
                                              <th>ปริมาณ</th>
                                              <th>มูลค่า</th>
                                              <th>ปริมาณ</th>
                                              <th>มูลค่า</th>
                                              <th>ปริมาณ</th>
                                              <th>มูลค่า</th>
                                              <th>ปริมาณ</th>
                                              <th>มูลค่า</th>
                                              <th>ปริมาณ</th>
                                              <th>มูลค่า</th>
                                              <th>ปริมาณ</th>
                                              <th>มูลค่า</th>
                                              <th >ปริมาณ</th>
                                              <th >มูลค่า</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="row">
                <!-- left col -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title" id="titleTotalAgriChart">สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของสถาบัน จำแนกรายสาขาพืช</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <!-- <div class="chart tab-pane active" id="totalAgri-chart" style="position: relative; height: 300px;"> -->
                                <div class="chart tab-pane active" id="totalAgri-chart" style="position: relative;">
                                  <canvas id="totalAgri-chart-canvas"></canvas>
                                  <!-- <canvas id="totalAgri-chart-canvas" height="300" style="height: 300px;"></canvas> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right col -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title" id="titleMarketChart">สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของสถาบัน จำแนกตามช่องทางการตลาด</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <!-- <div class="chart tab-pane active" id="market-chart" style="position: relative; height: 300px;">
                                    <canvas id="market-chart-canvas" height="300" style="height: 300px;"></canvas> -->
                                <div class="chart tab-pane active" id="market-chart" style="position: relative;">
                                    <canvas id="market-chart-canvas"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <!-- start Header -->
                        <div class="card-header">
                            <h5 class="card-title" id="titleMonthyChart" >มูลค่าเป้าหมายและส่งมอบผลผลิตของสถาบัน จำแนกรายเดือน</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                      <!-- start body -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="chart tab-pane active" id="market-chart" style="position: relative;">
                                    <canvas id="monthy-chart-canvas" height="400" style="height: 400px;"></canvas>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="totalMonthy" class="table m-0 table-bordered" style="text-align: center; background: honeydew;">
                                    <thead></thead>
                                    <tbody></tbody>
                                </table>
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
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script src="../assets/hrdi_js/DashBoard-New/report-newTJs.js"></script>