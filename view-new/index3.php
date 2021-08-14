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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">มูลค่าการจำหน่ายจำแนกตามสาขาและแหล่งตลาด</h5>

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
                                        <canvas id="market-canvas" height="100" style="height: 100px;"></canvas>
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
                                                <th>สาขา</th>
                                                <th>ตลาดข้อตกลง</th>
                                                <th>ตลาดโครงการหลวง</th>
                                                <th>ตลาดท้องถิ่น</th>
                                                <th>ตลาดอุทยานหลวงฯ</th>
                                                <th>รวม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ไม้ดอก</td>
                                                <td></td>
                                                <td></td>
                                                <td>5,192</td>
                                                <td>125,307</td>
                                                <td>131,499</td>
                                            </tr>
                                            <tr>
                                                <td>ไม้ผล</td>
                                                <td></td>
                                                <td></td>
                                                <td>3,561,185</td>
                                                <td></td>
                                                <td>3,561,185</td>
                                            </tr>
                                            <tr>
                                                <td>ปศุสัตว์</td>
                                                <td></td>
                                                <td></td>
                                                <td>428,221</td>
                                                <td></td>
                                                <td>428,221</td>
                                            </tr>
                                            <tr>
                                                <td>ผลิตภัณฑ์แปรรูป</td>
                                                <td>2,290</td>
                                                <td></td>
                                                <td>32,910</td>
                                                <td></td>
                                                <td>35,200</td>
                                            </tr>
                                            <tr>
                                                <td>ผัก</td>
                                                <td>434,998</td>
                                                <td>665,934</td>
                                                <td>1,259,808</td>
                                                <td></td>
                                                <td>2,360,740</td>
                                            </tr>
                                            <tr>
                                                <td>พีซไร่</td>
                                                <td></td>
                                                <td></td>
                                                <td>215,220</td>
                                                <td></td>
                                                <td>215,220</td>
                                            </tr>
                                            <tr>
                                                <td>อื่นๆ</td>
                                                <td></td>
                                                <td></td>
                                                <td>740,214</td>
                                                <td></td>
                                                <td>740,214</td>
                                            </tr>
                                            <tr class="bg bg-cyan">
                                                <td class="text-bold">รวม</td>
                                                <td>437,288</td>
                                                <td>665,934</td>
                                                <td>6,243,750</td>
                                                <td>125,307</td>
                                                <td>7,472,279</td>
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

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">ราคาเฉลี่ยต่ำสุด สูงสุด [พืชผัก]</h5>

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
                                        <canvas id="market-average-canvas" height="100" style="height: 100px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">แนวโน้มราคาผลผลิต [หน่อไม้ฝรั่ง]</h5>

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
                                        <canvas id="product-trend-canvas" height="400" style="height: 400px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <div class="row card-footer">
                            <div class="col-lg-5">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0 text-center">
                                            <thead>
                                                <tr class="bg bg-primary">
                                                    <th>ปี พ.ศ.</th>
                                                    <th>เดือน</th>
                                                    <th>ปริมาณ</th>
                                                    <th>ราคาเฉลี่ยจากการส่งมอบ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2562</td>
                                                    <td>ต.ค.</td>
                                                    <td>591</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>พ.ย.</td>
                                                    <td>360</td>
                                                    <td>140</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>ธ.ค.</td>
                                                    <td>323</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td>2563</td>
                                                    <td>ม.ค.</td>
                                                    <td>485</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>ก.พ.</td>
                                                    <td>406</td>
                                                    <td>145</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>มี.ค.</td>
                                                    <td>745</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>เม.ย.</td>
                                                    <td>1,012</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>พ.ค.</td>
                                                    <td>1,034</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>ก.ค.</td>
                                                    <td>917</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>ส.ค.</td>
                                                    <td>755</td>
                                                    <td>150</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>ก.ย.</td>
                                                    <td>834</td>
                                                    <td>150</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>

                            <section class="col-lg-7 connectedSortable">
                                <!-- Custom tabs (Charts with tabs)-->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-chart-pie mr-1"></i>
                                            ปริมาณผลผลิตและราคาจากการส่งมอบ
                                        </h3>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <!-- Morris chart - Sales -->
                                            <div class="chart tab-pane active" id="mix-chart" style="position: relative; height: 300px;">
                                                <canvas id="more-product-canvas" height="400" style="height: 400px;"></canvas>
                                            </div>
                                        </div>
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </section>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>


            </div>
        </div>
        <!-- /.row (main row) -->
    </section>
</div><!-- /.container-fluid -->
<!-- /.content-wrapper -->
<!-- <script src="dist/js/pages/index3.js"></script> -->
<?php include 'includes/footer.php' ?>
<script src="../assets/hrdi_js/DashBoard-New/dashboard3.js"></script>