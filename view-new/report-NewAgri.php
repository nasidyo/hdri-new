<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $yearsId = $_GET['yearsId'];
    $agriId = $_GET['agriId'];
    $typeAgri = "3";
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];
    // include '../util/loadBtnTypeOAgri.php'
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">ภาพรวมรายพืช</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item "><a href="report-NewFilter.php">ภาพรวมสาขาพืช</a></li>
                        <li class="breadcrumb-item active">ภาพรวมรายพืช</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
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
                        <div class="card-body">
                            <div id="sectionBtnSelecte"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> มูลค่าส่งมอบผลผลิต จำแนกตามช่องทางการตลาด ของพืช [ <?php $agriName = '';
                                                $sql = "( SELECT nameArgi
                                                FROM
                                                    Agri_TD
                                                WHERE
                                                    idAgri = '".$agriId."'
                                                )";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmt )) {
                                                    $agriName = sqlsrv_get_field( $stmt, 0);
                                                }
                                                echo $agriName;?> ] ประจำปีงบประมาณ 

                                                <?php $yearsName = '';
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

                                                    echo $yearsName;?>
                        </h5>
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
                        <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId; ?>">
                        <input type="hidden" id="agriId" name="agriId" value="<?php echo $agriId; ?>">
                        <input type="hidden" id="typeAgri" name="typeAgri" value="<?php echo $typeAgri; ?>">
                        <input type="hidden" id="permssion" name="permssion" value="<?php echo $permssion?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart tab-pane active" id="marketSale-chart" style="position: relative;">
                                        <canvas id="marketSale-chart-canvas"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table id="table-MarketSale" class="table m-0 table-bordered" style="text-align: center;">
                                        <thead>
                                            <th>ช่องทางตลาด</th>
                                            <th>ปริมาณ</th>
                                            <th>มูลค่า</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
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
                        <h5 class="card-title" id="cardHeaderPieChart">ราคาขายต่อกิโลกรัม จำแนกตามช่องทางการตลาด</h5>
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
                            <div class="chart tab-pane active" id="salePerMarket-chart" style="position: relative;">
                                <canvas id="salePerMarket-chart-canvas"></canvas>
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
                        <h5 class="card-title" id="nextmonthPricelineChart">แนวโน้มราคาขายในเดือนถัดไป</h5>
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
                            <div class="chart tab-pane active" id="nextMonthline-chart" style="position: relative;">
                                <canvas id="nextMonthline-chart-canvas"></canvas>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script src="../assets/hrdi_js/DashBoard-New/report-newAg.js"></script>