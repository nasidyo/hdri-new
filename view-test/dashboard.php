<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="adminlte/AdminLTE-master/dist/css/adminlte.css">
    <link rel="stylesheet" href="adminlte/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../vendors/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./adminlte/AdminLTE-master/dist/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">



    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Left Panel -->

        <?php

        require '../connection/database.php';
        require '../service/sessionCheck.php';
        include 'navbarTest.php';
        $db = new Database();
        $conn =  $db->getConnection();
        ?>

        <!-- Left Panel -->

        <!-- Right Panel -->

        <div class="content-wrapper">

            <!-- Header-->
            <?php
            // include 'menuToggle.php';
            require '../util/RiverBasinDependent.php';
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "
        SELECT TOP 1 idYearTB
        FROM YearTB
        WHERE dateStart < '" . $currentYears . "' and dateStop > '" . $currentYears . "'";
            $stmt = sqlsrv_query($conn, $sql);
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $nowYearsId = $row["idYearTB"];
            }

            $permssion = 'admin';
            if (isset($_SESSION['staffPermis'])) {
                $permssion = $_SESSION['staffPermis'];
            }
            ?>



            <!-- .content -->
            <div class="content mt-3">
                <div class="animated fadeIn">
                    <?php if ($permssion == 'admin' || $permssion == 'powerUserMarket' || $permssion == 'powerUserAccount') { ?>
                        <div class="card">
                            <div class="card-header"> ข้อมูลผู้ใช้งานระบบ </div>
                            <div class="card-body">
                                <div id="system">
                                    <!--system zone -->
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card text-white bg-flat-color-1">
                                            <div class="card-body pb-0">
                                                <div class="dropdown float-right"></div>
                                                <h4 class="mb-0">
                                                    <p class="text-light">สถิติในการใช้งาน 5 อันดับแรก</p>
                                                </h4>
                                            </div>

                                            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                                <canvas id="username"></canvas>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card text-white bg-flat-color-3">
                                            <div class="card-body pb-0">
                                                <div class="dropdown float-right">
                                                </div>
                                                <h4 class="mb-0">
                                                    <p class="text-light">จำนวน Platform <span class="count">
                                                            <?php
                                                            $sql2 = " SELECT DISTINCT COUNT(*) OVER () AS TotalRecords FROM LogAccess_TD lt group by lt.platform ";
                                                            $stmt = sqlsrv_query($conn, $sql2);
                                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                                echo $row["TotalRecords"];
                                                            }
                                                            ?>
                                                        </span></p>
                                                </h4>

                                            </div>

                                            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                                <canvas id="platform"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card text-white bg-flat-color-4">
                                            <div class="card-body pb-0">
                                                <div class="dropdown float-right">
                                                </div>
                                                <h4 class="mb-0">
                                                    <p class="text-light">จำนวนผู้มีสิทธิใช้งานระบบ <span class="count">
                                                            <?php
                                                            $sql2 = " select count(*) staff from Staff_TD  ";
                                                            $stmt = sqlsrv_query($conn, $sql2);
                                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                                echo $row["staff"];
                                                            }
                                                            ?>
                                                        </span></p>
                                                </h4>

                                            </div>

                                            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                                <canvas id="staff"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END system zone -->
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($permssion == 'staff') { ?>
                        <div class="card">
                            <div class="card-header"> เลือกเป้าหมายพื้นที่</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label labelR">พื้นที่</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="idArea" id="idArea">
                                            <?php
                                            echo loadAreaDependentInSS($conn, $_SESSION['RBAll'], $_SESSION['AreaAll']);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="card">
                        <div class="card-header">มูลค่ารวมรายได้</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="clearfix">
                                                <div class="stat-widget-one">
                                                    <div class="stat-icon dib"><i class="ti-money text-primary border-primary"></i></div>
                                                    <div class="stat-content dib">
                                                        <div class="stat-text">มูลค่าส่งมอบรวมทั้งหมด</div>
                                                        <div class="stat-digit" id="totalIncome"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="clearfix">
                                                <div class="stat-widget-one">
                                                    <div class="stat-icon dib"><i class="ti-money text-Blue border-Blue"></i></div>
                                                    <div class="stat-content dib">
                                                        <div class="stat-text">มูลค่ารวมส่งมอบในปีงบประมาณปัจจุบัน</div>
                                                        <div class="stat-digit" id="totalIncomeInyears"></div>
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
                <div class="card">
                    <div class="card-header"> ข้อมูลด้านการผลิตและการตลาดประจำปีงบประมาณ
                        [ <?php
                            $yearsName = '';
                            $sql = "( SELECT nameYear
                                                FROM
                                                    YearTB
                                                WHERE
                                                    idYearTB = '" . $nowYearsId . "'
                                                )";
                            $stmtYears = sqlsrv_query($conn, $sql);
                            if (sqlsrv_fetch($stmtYears)) {
                                $yearsName = sqlsrv_get_field($stmtYears, 0);
                            }

                            echo $yearsName;
                            ?> ]</div>
                    <div class="card-body">
                        <div id="market">
                            <!-- <div class="form-group row"> -->
                            <input type="hidden" value="<?php echo $nowYearsId ?>" id="year_bugget">
                            <input type="hidden" value="<?php echo $permssion ?>" id="permssion">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">ภาพรวมมูลค่า</strong>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="barCharTotalOfYears"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">ภาพรวมปริมาณ</strong>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="barCharTotalOfYearsQulity"></canvas>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">ภาพรวมมูลค่าจำแนกตามสาขาพืช</strong>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="barCharTotalOfType"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">ภาพรวมปริมาณจำแนกตามสาขาพืช</strong>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="barCharTotalOfTypeQulity"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ปริมาณผลผลิตส่งมอบ</strong>
                                    </div>
                                    <div class="card-body">
                                        <div id='Plotly'></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ภาพรวมช่องทางการตลาดแต่ละพืช</strong>
                                    </div>
                                    <div class="card-body">
                                        <div id='Bubble'></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">เปรียบเทียบสัดส่วนมูลค่าเป้าหมายรายได้ตามช่องทางตลาด</strong>
                                        </div>
                                        <div class="card-body">
                                            <div id="text-empty-pieChartValue" style="text-align: center; width: 100%; height: 100%; position: absolute; left: 0; top: 100px; z-index: 20;">
                                                <b>ไม่มีข้อมูลในการแสดงกราฟ !</b>
                                            </div>
                                            <canvas id="pieChartValue"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong class="card-title">เปรียบเทียบสัดส่วนปริมาณเป้าหมายผลผลิตตามช่องทางตลาด</strong>
                                        </div>
                                        <div class="card-body">
                                            <div id="text-empty-pieChartVolume" style="text-align: center; width: 100%; height: 100%; position: absolute; left: 0; top: 100px; z-index: 20;">
                                                <b>ไม่มีข้อมูลในการแสดงกราฟ !</b>
                                            </div>
                                            <canvas id="pieChartVolume"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header"> ข้อมูลบริหารจัดการด้านการเงินกลุ่มเกษตรประจำปีงบประมาณ
                        [ <?php
                            $yearsName = '';
                            $sql = "( SELECT nameYear
                                                FROM
                                                    YearTB
                                                WHERE
                                                    idYearTB = '" . $nowYearsId . "'
                                                )";
                            $stmtYears = sqlsrv_query($conn, $sql);
                            if (sqlsrv_fetch($stmtYears)) {
                                $yearsName = sqlsrv_get_field($stmtYears, 0);
                            }

                            echo $yearsName;
                            ?> ]</div>
                    <div class="card-body">
                        <div id="account">
                            <!-- <div class="form-group row">
                                <label  class="col-sm-2 col-form-label">ปีบัญชี </label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="account_year" id="account_year">
                                        <?php
                                        $sql4 = " SELECT distinct year_text FROM AccountYear ";
                                        $stmt = sqlsrv_query($conn, $sql4);
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            $id_pre = $row["year_text"];
                                            $name_pre = $row["year_text"];
                                            echo "<option value='$id_pre'> $name_pre</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> -->


                            <div class="form-group row" style=" min-height: 400px; ">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="mb-3">รายรับ </h4>
                                            <canvas id="pieChartIncome" height="1355" width="1355" class="chartjs-render-monitor" style="display: block; height: 200px; width: 200px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3">รายจ่าย </h4>
                                            <canvas id="pieChartExpense" height="1355" width="1355" class="chartjs-render-monitor" style="display: block; height: 200px; width: 200px;"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3">ลูกหนี้การค้า </h4>
                                            <canvas id="pieChartIncomeDebt" height="1355" width="1355" class="chartjs-render-monitor" style="display: block; height: 200px; width: 200px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3">เจ้าหนี้ </h4>
                                            <canvas id="pieChartExpenseDebt" height="1355" width="1355" class="chartjs-render-monitor" style="display: block; height: 200px; width: 200px;"></canvas>
                                        </div>
                                    </div>
                                </div>


                            </div>



                            <div class="default-tab">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">กลุ่มวิสาหกิจชุมชน</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">กลุ่มพึ่งตนเอง</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">กลุ่มเตรียมสหกรณ์</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-test" role="tab" aria-controls="nav-contact" aria-selected="false">กลุ่มสหกรณ์</a>
                                    </div>
                                </nav>
                                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="card">
                                            <div class="card-header">สถาบันเกษตรกรกลุ่มวิสาหกิจชุมชน</div>
                                            <div class="card-body">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-bitcoin bg-primary p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="profit1"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">กำไรขั้นต้น</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body" style=" margin-top: -50px; ">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-desc bg-success p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="inc1"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายรับ</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-up bg-danger p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="ex1"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายจ่าย</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-warning bg-warning p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="incdebt1"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">ลูกหนี้การค้า</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-info bg-info p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="exdebt1"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">เจ้าหนี้</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="card">
                                            <div class="card-header">สถาบันเกษตรกรกลุ่มพึ่งตนเอง</div>
                                            <div class="card-body">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-bitcoin bg-primary p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="profit2"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">กำไรขั้นต้น</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body" style=" margin-top: -50px; ">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-desc bg-success p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="inc2"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายรับ</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-up bg-danger p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="ex2"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายจ่าย</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-warning bg-warning p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="incdebt2"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">ลูกหนี้การค้า</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-info bg-info p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="exdebt2"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">เจ้าหนี้</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="card">
                                            <div class="card-header">สถาบันเกษตรกรกลุ่มเตรียมสหกรณ์</div>
                                            <div class="card-body">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-bitcoin bg-primary p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="profit3"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">กำไรขั้นต้น</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body" style=" margin-top: -50px; ">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-desc bg-success p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="inc3"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายรับ</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-up bg-danger p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="ex3"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายจ่าย</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-warning bg-warning p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="incdebt3"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">ลูกหนี้การค้า</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-info bg-info p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="exdebt3"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">เจ้าหนี้</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-test" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="card">
                                            <div class="card-header">สถาบันเกษตรกรกลุ่มสหกรณ์</div>
                                            <div class="card-body">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-bitcoin bg-primary p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="profit4"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">กำไรขั้นต้น</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body" style=" margin-top: -50px; ">
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-desc bg-success p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="inc4"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายรับ</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-sort-up bg-danger p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="ex4"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">รายจ่าย</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-warning bg-warning p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="incdebt4"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">ลูกหนี้การค้า</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="clearfix">
                                                                <i class="fa fa-info bg-info p-3 font-2xl mr-3 float-left text-light"></i>
                                                                <div class="h5 text-secondary mb-0 mt-1" id="exdebt4"></div>
                                                                <div class="text-muted text-uppercase font-weight-bold font-xs small">เจ้าหนี้</div>
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
            </div>









        </div><!-- .animated -->

    </div> <!-- .content -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script>


    <script src="../assets/hrdi_js/AccountReport/dashN.js"></script>

    <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
    <script src="adminlte/AdminLTE-master/dist/js/adminlte.js"></script>
    <!-- <script src="../assets/hrdi_js/AccountReport/newBoxplot.js"></script>
    <script src="../assets/hrdi_js/AccountReport/newPlantBubble.js"></script> -->

    <!--  Chart js -->




</body>

</html>