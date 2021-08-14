<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];

    // require '../service/sessionCheck.php';
    require '../util/RiverBasinDependent.php';
    require '../util/typeOfAgri.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">การส่งมอบและตลาด</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">การส่งมอบและตลาด</li>
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
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ลุ่มน้ำ</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="idRiverBasin" id="idRiverBasin">
                                        <?php  echo loadRiverDependent($conn);?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputext"
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">พื้นที่</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idArea" id="area">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputext"
                                    class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ปีงบประมาณ</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="year" id="year">

                                        <?php
                                                        $sql5="select *  from YearTB ";
                                                        $stmt = sqlsrv_query( $conn, $sql5 );
                                                        echo "<option value='0' selected > ทั้งหมด </option>";
                                                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                          $id_pre=$row["idYearTB"];
                                                          $name_pre=$row["nameYear"];
                                                          $defaultYear = $row["defaultYear"];
                                                          if( $defaultYear =='Y'){
                                                            echo "<option value='$id_pre' selected > $name_pre</option>";
                                                          }else{
                                                                echo "<option value='$id_pre'> $name_pre</option>";
                                                          }

                                                        }
                                                      ?>

                                    </select>
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
                        <strong class="card-title">รายงานการเปรียบเทียบมูลค่าการส่งมอบผลผลิตตามลุ่มน้ำและตลาด</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChartValue"></canvas>
                    </div>
                </div>
            </div><!-- /# column -->
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">รายงานการเปรียบเทียบปริมาณการส่งมอบผลผลิตตามลุ่มน้ำและตลาด</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChartVolume"></canvas>
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
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script src="../vendors/select2/dist/js/select2.min.js"></script>
<script src="../assets/hrdi_js/viewPMByMK.js"></script>