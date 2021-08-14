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
                    <h1 class="m-0 text-dark">ภาพรวมปริมาณผลผลิตส่งแต่ละช่องทางตลาด</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">ภาพรวมปริมาณผลผลิตส่งแต่ละช่องทางตลาด</li>
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
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary " id="search_reportIncome"><i class="menu-icon fa fa-search"></i> ออกรายงาน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">ภาพรวมปริมาณผลผลิตส่งแต่ละช่องทางตลาด</strong>
                        </div>
                        <div class="card-body">
                            <div id='Plotly'><!-- Plotly chart will be drawn inside this DIV --></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">ภาพรวมช่องทางการตลาดแต่ละพืช</strong>
                        </div>
                        <div class="card-body">
                            <div id='Bubble'><!-- Plotly chart will be drawn inside this DIV --></div>
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
<script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
<script src="../assets/hrdi_js/AccountReport/newBoxplot.js"></script>
<script src="../assets/hrdi_js/AccountReport/newPlantBubble.js"></script>