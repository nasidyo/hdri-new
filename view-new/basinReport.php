<?php 
    include 'includes/header.php'; 
    // $yearsId = $_GET['yearsId'];
    $db = new Database();
    $conn=  $db->getConnection();
    $permssion = $_SESSION['staffPermis'];

    // require '../service/sessionCheck.php';
    require '../util/RiverBasinDependent.php';
    // require '../util/typeOfAgri.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">ภาพรวมลุ่มน้ำ</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                                    <strong class="card-title">ตารางพื้นที่เป้าหมาย</strong>
                                </div>
                            </div>
                        </div>
                        <?php
                                $permssion = $_SESSION['staffPermis'];
                                if ($permssion == 'admin' or $permssion == 'powerUser'){
                             ?>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">ค้นหา</strong>
                                </div>
                                <div class="card-body" id='search'>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">พื้นที่ลุ่มน้ำ</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="idRiverBasin" id="idRiverBasin">
                                                <?php
                                                          //  echo loadRiverDependent($conn);
                                                          echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <table id="basinTable" name="basinTable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>รหัสโครงการ</th>
                                                <th>ลุ่มน้ำ</th>
                                                <th>พื้นที่เป้าหมาย</th>
                                            </tr>
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
    </section>

</div>
<!-- /.row (main row) -->
<!-- /.content-wrapper -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="./dist/js/pages/dashboard.js"></script> -->
<?php include './includes/footer.php' ?>
<script src="../assets/js/main.js"></script>
<script src="../vendors/select2/dist/js/select2.min.js"></script>
<script src="../assets/hrdi_js/basinReport.js"></script>