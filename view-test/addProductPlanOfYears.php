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
    <title>ระบบการบริหารจัดการด้านการเงินเกษตรกร</title>
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
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">

    <!-- <link rel="stylesheet" href="../assets/css/select2.min.css"> -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php require '../connection/database.php'; ?>
    <?php require '../service/sessionCheck.php';?>

    <!-- Left Panel -->

    <?php include 'navbarTest.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div class="content-wrapper">

        <!-- Header-->
        <?php   include 'menuToggle.php';
            require '../util/typeOfAgri.php';
            require '../util/loadMonth.php';
            require '../util/loadMarketList.php';
            require '../util/loadMarketTypeList.php';
            require '../util/loadMonthInput.php';
            $area_Id = $_GET['area_Id'];
            $yearsId = $_GET['yearsId'];
            $actionValue = $_GET['action'];
            $db = new Database();
            $conn=  $db->getConnection();
        ?>

        <!-- <div class="breadcrumbs">
            <div class="col-lg-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>เพิ่มแปลงเกษตร</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">เพิ่มแปลงเกษตร</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> -->
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-10 ">
                                        <strong class="card-title">วางแผนเป้าหมายรายได้และผลผลิตประจำปี 
                                           [ <?php
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
                                            ?>  ]
                                            [<?php
                                                $result = '';
                                                $sql = "( SELECT areaName
                                                FROM
                                                    Area
                                                WHERE
                                                    idArea = '".$area_Id."'
                                                )";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmt )) {
                                                    $result = sqlsrv_get_field( $stmt, 0);
                                                }

                                                echo $result;
                                            ?>]
                                        </strong>
                                    </div>
                                    <div class="col-md-2 ">
                                        <a href="yearsListOfPlan.php?area_Id=<?php echo $area_Id?>&yearsId=<?php echo $yearsId?>" class="btn btn-secondary"><i class="fa ti-angle-double-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="#" method="post" id="form_Agri">
                                    <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>">
                                    <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                                    <input type="hidden" id="actionValue" name="actionValue" value="<?php echo $actionValue?>">
                                    <input type="hidden" id="action" name="action" value="add">
                                    <div class="row form-group">
                                        <label for="inputext" class="col-lg-2 col-form-label">สาขาพืช : <span style=" color: red; ">*</span> </label>
                                        <div class="col-lg-4">
                                            <select class="form-control addfield" name="typeOfAgri_id" id="typeOfAgri_id">
                                                <?php
                                                    echo loadTypeOfAgri($conn, $area_Id);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">ชนิดพืช : <span style=" color: red; ">*</span> </label>
                                        <div class="col-lg-4">
                                            <select class="form-control addfield"name="agri" id="agri">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">พันธุ์พืช :</label>
                                        <div class="col-lg-4">
                                            <select class="form-control addfield"name="speciesId" id="speciesId">
                                                <option value='0'>ไม่มี</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">มาตราฐาน :</label>
                                        <div class="col-lg-4">
                                            <select class="form-control addfield" name="standardProduct" id="standardProduct">
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- <div class="row form-group">
                                        <div class="col-lg-2 col-form-label">
                                            <label for="plan-plant" class="pr-1 form-control-label">ปริมาณรายปี : <span style=" color: red; ">*</span> </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="totalQuality" name="totalQuality" onkeypress="return isNumberKey(this,event)" placeholder="จำนวนเป้าหมาย" value="" class="form-control addfield" type="text">
                                        </div>
                                        <label for="inputext" class="col-lg-2 col-form-label" id="unitCodeProduct" name="unitCodeProduct"></label>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-2 col-form-label">
                                            <label for="plan-plant" class="pr-1 form-control-label">ราคาต่อหน่วย : <span style=" color: red; ">*</span> </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="pricePerProduct" name="pricePerProduct" onkeypress="return isNumberKey(this,event)" placeholder="ราคาต่อหน่วยของผลผลิต" value="" class="form-control addfield" type="text">
                                        </div>
                                        <div class="col-lg-2 col-form-label">
                                            <label for="plan-plant" class="pr-1 form-control-label">บาท</label>
                                        </div>
                                    </div> -->
                                    <div class="row form-group">
                                        <div class="col-lg-2 col-form-label">
                                            <label for="plan-plant addfield" class="pr-1 form-control-label">เดือนที่กำหนด : <span style=" color: red; ">*</span> </label>
                                        </div>
                                    </div>
                                    <div class="monthy-of-price">
                                        <?php 
                                            echo loadMonthInput($conn); 
                                        ?>
                                        <!-- <div class="row form-group">
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-1 col-form-label">
                                                <label for="plan-plant" class="form-control-label">ตุลาคม</label>
                                            </div>
                                            <div class="col-form-label">
                                                <label for="plan-plant" class="form-control-label">ปริมาณ</label>
                                            </div>
                                            <div class="col-lg-1">
                                                <input id="totalpriceOfPlan" name="totalpriceOfPlan" placeholder="ปริมาณ" value="" class="form-control" type="text">
                                            </div>
                                            <div class="col-form-label">
                                                <label for="plan-plant" class="form-control-label">ราคาต่อหน่วย</label>
                                            </div>
                                            <div class="col-lg-1">
                                                <input id="totalpriceOfPlan" name="totalpriceOfPlan" placeholder="ราคาต่อหน่วย" value="" class="form-control" type="text">
                                            </div>
                                            <div class="col-form-label">
                                                <label for="plan-plant" class="form-control-label">รวม</label>
                                            </div>
                                            <div class="col-lg-1">
                                                <input id="totalpriceOfPlan" name="totalpriceOfPlan" placeholder="0" value="" class="form-control" type="text" readonly="readonly">
                                            </div>
                                        </div> -->
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-lg-2 col-form-label">
                                            <label for="plan-plant" class="pr-1 form-control-label">ช่องทางตลาด : <span style=" color: red; ">*</span> </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="marketList-dropdown addfield" name="marketList" multiple="multiple" id="marketList" tabindex="1" size="5" style="width: 100%">
                                                <?php
                                                    echo loadMarketList($conn, $area_Id);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="row form-group">
                                        <div class="col-lg-2 col-form-label">
                                            <label for="plan-plant" class="pr-1 form-control-label ">มูลค่ารายปี : </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="totalpriceOfPlan" name="totalpriceOfPlan" placeholder="ประมาณการราคาทั้งหมด" value="" class="form-control" type="text" readonly="readonly">
                                        </div>
                                        <div class="col-lg-1 col-form-label">
                                            <label for="plan-plant" class="pr-1 form-control-label">บาท </label>
                                        </div>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                        <div class="card" name="support_card" id="support_card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-8 ">
                                        <strong class="card-title">ข้อมูลการส่งเสริมเป้าหมายรายได้และการผลิต</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" name="support_part" id="support_part">
                                <div name="support_parts" id="support_parts"></div>
                                <div class="row form-group">
                                    <!-- <div class="col-sm-3">
                                        <a class="btn btn-primary" href="javascript:void(0)" id="addPlanProductBtn" name="addPlanProductBtn" role="button"> <i class="fa fa-dot-circle-o"></i> บันทึกเป้าหมายรายได้และผลผลิต</a>
                                    </div> -->
                                    <div class="col-sm-1">
                                        <a class="btn btn-success btn-sm" href="javascript:void(0)" id="addPlanProductBtn" name="addPlanProductBtn" role="button"><i class="fa ti-shopping-cart"> เพิ่มข้อมูล</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card" name="examplePlan_card" id="examplePlan_card" >
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-8 ">
                                        <strong class="card-title">ข้อมูลการวางแผน</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" name="examplePlan_body" id="examplePlan_body">
                                <div class="row form-group">
                                    <table class="table" id="examplePlan-Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">ชนิดพืช</th>
                                                <th style="width: 10%">เดือน</th>
                                                <!-- <th style="width: 10%">มาตราฐาน</th> -->
                                                <th style="width: 10%">ช่องทางตลาด</th>
                                                <th style="width: 15%">รายชื่อลูกค้า</th>
                                                <th style="width: 10%">ปริมาณ</th>
                                                <th style="width: 10%">ราคาต่อหน่วย</th>
                                                <th style="width: 10%;">มูลค่ารวม</th>
                                                <th style="width: 8%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <a class="btn btn-info" href="javascript:void(0)" id="editallIntableBtn" name="editallIntableBtn" role="button" style="float: right"> <i class="fa fa-save"></i> แก้ไขทั้งหมด</a>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <a class="btn btn-primary" href="javascript:void(0)" id="addPlanListProductBtn" name="addPlanListProductBtn" role="button"> <i class="fa fa-dot-circle-o"></i> บันทึกเป้าหมายรายได้และผลผลิต</a>
                                    </div>
                                    <div class="col-sm-1">
                                        <a class="btn btn-danger" href="javascript:void(0)" id="resetValueInpage" name="resetValueInpage" role="button"> <i class="fa fa-times"></i> ยกเลิก</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="card">
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="col-md-4">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary" id="addPersonBtn" style=" width: inherit; ">บันทึก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div><!-- .animated -->
            <div id="loader"></div>
        </div> <!-- .content -->
    </div><!-- /#right-panel -->
</div>
    <!-- Right Panel -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="adminlte/AdminLTE-master/dist/js/adminlte.js"></script>

    <!-- <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script> -->
    <!-- <script src="../assets/js/dashboard.js"></script> -->
    <!-- <script src="../assets/js/widgets.js"></script> -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <!-- dataTable -->
    <script src="../assets/hrdi_js/moment.min.js"></script>
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- <script src="../vendors/select2/dist/js/i18n/th.js"></script> -->
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <!-- <script src="../assets/js/select2.min.js"></script> -->
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/hrdi_js/planProductOfyears.js"></script>
    <script src="../assets/hrdi_js/validatefield.js"></script>

    <!-- <script>
        (function($) {
            "use strict";

            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#1de9b6', '#03a9f5'],
                normalizeFunction: 'polynomial'
            });
        })(jQuery);
    </script> -->

</body>

</html>
