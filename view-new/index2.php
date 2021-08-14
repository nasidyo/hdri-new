<?php include 'includes/header.php'; ?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                <section class="col-lg-7 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                ปริมาณและมูลค่ารวมของผลผลิตรายสาขา และความแตกต่างจากปีที่ผ่านมา
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="mix-chart" style="position: relative; height: 300px;">
                                    <canvas id="mix-product-canvas" height="400" style="height: 400px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>

                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>สาขา</th>
                                            <th>ปริมาณ</th>
                                            <th>มูลค่า</th>
                                            <th>เปลี่ยนแปลง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ปศุสัตว์</td>
                                            <td>6,538.00</td>
                                            <td>42,559.00</td>
                                            <td>
                                                <span class="float-weight-bold text-warning">
                                                    <i class="fas fa-arrow-left text-sm"></i> 0%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ผัก</td>
                                            <td>114,054.00</td>
                                            <td>211,605.00</td>
                                            <td>
                                                <span class="float-weight-bold text-success">
                                                    <i class="fas fa-arrow-up text-sm"></i> 10%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>พืซไร่</td>
                                            <td>87,868.00</td>
                                            <td>107,983.00</td>
                                            <td>
                                                <span class="float-weight-bold text-success">
                                                    <i class="fas fa-arrow-up text-sm"></i> 7%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ไม้ผล</td>
                                            <td>41,398.00</td>
                                            <td>92,118.00</td>
                                            <td>
                                                <span class="float-weight-bold text-danger">
                                                    <i class="fas fa-arrow-down text-sm"></i> 3%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>อื่นๆ</td>
                                            <td>6,538.00</td>
                                            <td>42,559.00</td>
                                            <td>
                                                <span class="float-weight-bold text-warning">
                                                    <i class="fas fa-arrow-left text-sm"></i> 0%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="bg bg-cyan">
                                            <td>รวม</td>
                                            <td>252,111.00</td>
                                            <td>468,837.00</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>

                <!-- /.row -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">ปริมาณผลผลิตจำแนกตามสาขาพืซเป็นรายเดือน [พืชผัก]</h5>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas id="month-product-canvas" height="400" style="height: 400px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <div class="card-footer">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>ชนิดพืซ</th>
                                                <th>ม.ค.</th>
                                                <th>ก.พ.</th>
                                                <th>มี.ค.</th>
                                                <th>เม.ย.</th>
                                                <th>พ.ค.</th>
                                                <th>มิ.ย.</th>
                                                <th>ก.ค.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ฟักทองญี่ปุ่น</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>3,788</td>
                                                <td>5,443</td>
                                            </tr>
                                            <tr>
                                                <td>หน่อไม้ฝรั่ง</td>
                                                <td>1,999</td>
                                                <td>1,001</td>
                                                <td>1,443</td>
                                                <td>533</td>
                                                <td>87</td>
                                                <td>1,167</td>
                                                <td>106</td>
                                            </tr>
                                            <tr>
                                                <td>คะน้า</td>
                                                <td>591</td>
                                                <td>360</td>
                                                <td>323</td>
                                                <td>485</td>
                                                <td>406</td>
                                                <td>746</td>
                                                <td>1,012</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.row (main row) -->
    </section>
</div><!-- /.container-fluid -->
<!-- /.content-wrapper -->
<!-- <script src="dist/js/pages/dashboard2.js"></script> -->
<?php include 'includes/footer.php' ?>
<script src="../assets/hrdi_js/DashBoard-New/dashboard2.js"></script>