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
    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">

    <link rel="stylesheet" href="./adminlte/AdminLTE-master/dist/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php require '../connection/database.php'; ?>
    <?php require '../service/sessionCheck.php';?>

     <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

    <?php include 'navbarTest.php';?>

    <!-- Left Panel -->
    <!-- Right Panel -->

    <div class="content-wrapper">

        <!-- Header-->
        <?php include 'menuToggle.php';
            require '../util/typeOfAgri.php';
            require '../util/loadMonth.php';
            require '../util/loadMarketList.php';
            require '../util/loadPersonFromAgri.php';
            require '../util/loadAllProductGrade.php';
            require '../util/loadLogisticList.php';
            $permssion = $_SESSION['staffPermis'];
            $area_Id = $_GET['area_Id'];
            $yearsId = $_GET['yearsId'];
            $monthId = $_GET['monthId'];
            $db = new Database();
            $conn=  $db->getConnection();
        ?>
    <!-- .content -->
        <div class="content mt-3">
        <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-10 ">
                                        <strong class="card-title">การส่งมอบผลผลิตประจำเดือน</strong>
                                    </div>
                                    <div class="col-md-2 ">
                                        <a href="deliverProductListOfYear.php?area_Id=<?php echo $area_Id ?>&yearsId=<?php echo $yearsId?> " class="btn btn-secondary"><i class="fa ti-angle-double-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <!-- <div class="card-header"> -->
                                    <div class="card-header search_td" style=" cursor: pointer; " data-toggle="collapse" data-target="#criteria" aria-expanded="false" aria-controls="criteria">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <!-- <div class="card-body" id='search'> -->
                                    <div class="card-body collapse" id='criteria'>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="typeOfAgri_id" id="typeOfAgri_id" style="width:100%;">
                                                    <?php
                                                        echo loadTypeOfAgri($conn, $area_Id);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ชนิดพืช</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="agri" id="agri" style="width:100%;">
                                                    <option value='0'>กรุณาเลือก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">เกรดสินค้า :</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="gardProduct" id="gardProduct" style="width:100%;">
                                                    <option value='all'>เลือกทั้งหมด</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label for="inputext" class="col-sm-2 col-form-label">เกษตรกร :</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="farmer_Id" id="farmer_Id" style="width:100%;">
                                                    <option value='0'>กรุณาเลือก</option>
                                                    <?php
                                                        echo loadFarmerFromAgri($conn, $area_Id);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">ช่องทางการตลาด</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="market_id" id="market_id" style="width:100%;">
                                                    <option value='0'>กรุณาเลือก</option>
                                                    <?php
                                                        echo loadMarketList($conn, $area_Id);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary " id="search_person"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 ">
                                            </div>
                                            <div class="col-md-1 ">
                                                <button type="button" class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">การส่งมอบผลผลิต 
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
                                            ประจำเดือน [
                                                <?php
                                                    $monthName = '';
                                                    $monthSql = "( SELECT Month_name
                                                    FROM
                                                        MonthOfYear
                                                    WHERE
                                                        Month_id = '".$monthId."'
                                                    )";
                                                    $monthstmt = sqlsrv_query($conn, $monthSql);
                                                    if(sqlsrv_fetch( $monthstmt )) {
                                                        $monthName = sqlsrv_get_field( $monthstmt, 0);
                                                    }
                                                    echo $monthName;
                                                ?>
                                            ]
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>">
                                        <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                                        <input type="hidden" id="monthId" name="monthId" value="<?php echo $monthId?>">
                                        <input type="hidden" id="permssion" name="permssion" value="<?php echo $permssion?>">
                                        <?php
                                            $resultPlanStatusId = '1';
                                            $sqlStatusPlan = "( SELECT idSendStatus
                                            FROM
                                                SendStatusValue_TD
                                            WHERE
                                                Area_idArea = '".$area_Id."' and YearID = '".$yearsId."' and MonthID ='".$monthId."'
                                            )";
                                            $resultStautsPlan = sqlsrv_query($conn, $sqlStatusPlan);
                                            if(sqlsrv_fetch( $resultStautsPlan)) {
                                                $resultPlanStatusId = sqlsrv_get_field( $resultStautsPlan, 0);
                                            }
                                            if($resultPlanStatusId == ""){
                                                $resultPlanStatusId = '1';
                                            }
                                            $permssion = $_SESSION['staffPermis'];
                                        ?>
                                        <?php
                                            $checkDeliverProduct = 'N';
                                            $sqlCheckDeliverProduct = "( SELECT TOP 1 *
                                            FROM
                                                PersonMarket_TD
                                            WHERE
                                                Area_idArea = '".$area_Id."' and MonthNo != '".$monthId."'
                                            )";
                                            $resultCheckDeliverProduct = sqlsrv_query($conn, $sqlCheckDeliverProduct);
                                            if( !$resultCheckDeliverProduct ) {
                                                die( print_r( sqlsrv_errors(), true));
                                            }
                                            $rows = sqlsrv_has_rows($resultCheckDeliverProduct);
                                            if ($rows === true){
                                                $checkDeliverProduct = 'Y';
                                            }else{
                                                $checkDeliverProduct = 'N';
                                            } 
                                        ?>
                                        <input type="hidden" id="statusId" name="statusId" value="<?php echo $resultPlanStatusId?>">
                                        <div class="row menubar">
                                            <?php if (($permssion == 'staff' or $permssion == 'admin' or $permssion == 'powerUserMarket') and ($resultPlanStatusId == '1' or $resultPlanStatusId == '3')) {?>
                                                <div class="col col-sm-2">
                                                    <button type="button" class="btn btn-primary" href="javascript:void(0)" id="addNewBtn" name="addNewBtn" ><i class="fa fa-star"></i>&nbsp; เพิ่มรายการใหม่</button>
                                                </div>
                                                <div class="col col-lg-2">
                                                    <button type="button" class="btn btn-success" href="javascript:void(0)" id="sendPlanProduct" name="sendPlanProduct" ><i class="fa fa-magic"></i>&nbsp; ส่งมอบผลผลิต</button>
                                                </div>
                                                <?php if ($checkDeliverProduct == 'Y') {?>
                                                    <div class="col col-lg-2">
                                                        <button type="button" class="btn btn-info" href="javascript:void(0)" id="copyDeliverProductBtn" name="copyDeliverProductBtn" ><i class="fa fa-copy"></i>&nbsp; คัดลอกการส่งมอบ</button>
                                                    </div>
                                                <?php }?>
                                            <?php } ?>
                                            <?php if ($permssion != 'staff' and ($resultPlanStatusId == '4')) {?>
                                                <!-- <div class="col col-sm-2">
                                                    <button type="button" class="btn btn-primary" href="javascript:void(0)" id="confirmBtn" name="confirmBtn" ><i class="fa fa-star"></i>&nbsp; ยืนยันแผน </button>
                                                </div> -->
                                                <div class="col col-lg-2">
                                                    <button type="button" class="btn btn-success" href="javascript:void(0)" id="backToEditBtn" name="backToEditBtn" ><i class="fa fa-magic"></i>&nbsp; แจ้งแก้ไขข้อมูล</button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row form-group"></div>
                                        <table id="deliverProductList-Table" name="deliverProductList-Table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th><center>เลือกทั้งหมด <br/><input type="checkbox" class='checkall' id='checkall'></center></th>
                                                    <th><center>ว/ด/ป</center></th>
                                                    <th><center>รายชื่อเกษตรกร</center></th>
                                                    <th><center>พืชสาขา</center></th>
                                                    <th><center>ชนิดพืช</center></th>
                                                    <th><center>มาตราฐาน</center></th>
                                                    <th><center>เกรด</center></th>
                                                    <th style="width:10%"><center>ปริมาณ</center></th>
                                                    <th style="width:10%"><center>ราคาต่อหน่วย</center></th>
                                                    <th><center>มูลค่ารวม</center></th>
                                                    <th><center>ช่องทางตลาด</center></th>
                                                    <th><center>ผู้รับซื้อ</center></th>
                                                    <th style="width:13%"></th>
                                                    <th style="width:13%"></th>
                                                    <th style="width:13%" ></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">สรุปการส่งมอบผลผลิต
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
                                            ประจำเดือน [
                                                <?php
                                                    $monthName = '';
                                                    $monthSql = "( SELECT Month_name
                                                    FROM
                                                        MonthOfYear
                                                    WHERE
                                                        Month_id = '".$monthId."'
                                                    )";
                                                    $monthstmt = sqlsrv_query($conn, $monthSql);
                                                    if(sqlsrv_fetch( $monthstmt )) {
                                                        $monthName = sqlsrv_get_field( $monthstmt, 0);
                                                    }
                                                    echo $monthName;
                                                ?>
                                            ]
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <form class="form-horizontal" action="#" method="post" id="summaryProductPlan">
                                            <table class="table" id="dashTable">
                                                <thead>
                                                    <tr>
                                                        <th>สาขาพืช</th>
                                                        <th>ชนิดพืช</th>
                                                        <th>ประเภทตลาด</th>
                                                        <th>ปริมาณรวม</th>
                                                        <th>มูลค่ารวม</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
            <div id="loader"></div>
        </div> <!-- .content -->
        <?php include 'modal/editDeliverProductList.php';?>
        <?php include 'modal/editDeliverProduct.php';?>
        <?php include 'modal/copyDeliverProduct.php';?>
        <?php include 'modal/viewDeliverProduct.php';?>
        <?php include 'modal/addNewLogistic.php';?>
        <?php include 'modal/uploadImageDialog.php';?>
        
    </div><!-- /#right-panel -->

    <!-- Right Panel -->
</div>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>


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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="../vendors/datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
    <script src="../vendors/datetimepicker-master/js/bootstrap-datepicker-custom.js"></script>
    <script src="../vendors/datetimepicker-master/js/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
    <script src="../vendors/datetimepicker-master/js/locales/bootstrap-datetimepicker.th.js" charset="UTF-8"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/hrdi_js/deliverProductList.js"></script>
    <script src="../assets/hrdi_js/validatefield.js"></script>
    <script src="adminlte/AdminLTE-master/dist/js/adminlte.js"></script>

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
