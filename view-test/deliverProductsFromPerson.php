
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
    <link rel="stylesheet" href="./adminlte/AdminLTE-master/dist/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">
    <script type="text/javascript" src="../webcamjs/webcam.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php require '../connection/database.php'; ?>
    <?php 
        require '../service/sessionCheck.php';
    ?>

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
        <?php   //include 'header.php';
            require '../util/RiverBasinDependent.php';
            require '../util/typeOfAgri.php';
            require '../util/loadMarketList.php';
            require '../util/loadPersonFromAgri.php';
            require '../util/loadLogisticList.php';
            require '../view/modal/camera.php';

            $currentYears = date("Y-m-d h:i:s");
            $currentMonth = date("m");
            $yearsId;
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "
                SELECT TOP 1 idYearTB
                FROM YearTB
                WHERE dateStart < '".$currentYears."' and dateStop > '".$currentYears."'";
            $stmt = sqlsrv_query( $conn, $sql );
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $yearsId = $row["idYearTB"];
            }
        ?>
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-8 ">
                                        <strong class="card-title">ส่งมอบผลผลิตผ่านมือถือ</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ข้อมูลเกษตรกรผู้ส่งมอบผลผลิต </strong>
                                    </div>
                                    <div class="card-body" id='search'>
                                        <form class="form-horizontal" action="#" method="post" id="framer_form">
                                            <div class="form-group row">
                                                <label for="inputext" class="col-lg-2 col-form-label">พื้นที่เป้าหมาย : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="areaId" id="areaId">
                                                        <?php echo loadAreaDependentInCKDeliver($conn, '0', $_SESSION['AreaAll'], $yearsId); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-lg-2 col-form-label">เกษตรกร : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="farmer_Id" id="farmer_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ข้อมูลผลผลิตที่ส่งมอบ</strong>
                                    </div>
                                    <div class="card-body" id='search'>
                                        <form class="form-horizontal" action="#" method="post" id="deliverProduct_form">
                                            <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                                            <input type="hidden" id="monthId" name="monthId" value="<?php echo $currentMonth?>">
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">พืชสาขา : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="typeAgri_Id" id="typeAgri_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">ชนิดพืช :<span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="agri_Id" id="agri_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">พันธุ์พืช :</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="speciesId" id="speciesId">
                                                        <option value='0'>ไม่มี</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">ช่องทางการตลาด : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="market_Id" id="market_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">ปริมาณที่ส่งมอบ : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-2">
                                                    <input id="quality" name="quality" onkeypress="return isNumberKey(this,event)" placeholder="จำนวนผลผลิตที่ส่งมอบ" value="" class="form-control two-decimals" type="text">
                                                </div>
                                                <label for="inputext" class="col-lg-1 col-form-label" id="unitCodeProduct" name="unitCodeProduct"></label>
                                                <label for="inputext" class="col-lg-1 col-form-label">ปริมาณสูญเสีย</label>
                                                <div class="col-lg-2">
                                                    <input id="lossValue" name="lossValue" onkeypress="return isNumberKey(this,event)" placeholder="ปริมาณสูญเสีย" value="" class="form-control" type="text">
                                                </div>
                                                <label for="inputext" class="col-lg-1 col-form-label">ปริมาณสุทธิ</label>
                                                <div class="col-lg-2">
                                                    <input id="totalQuality" name="totalQuality" onkeypress="return isNumberKey(this,event)" placeholder="ปริมาณสุทธิ" value="" readonly class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">ราคาต่อหน่วย : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <input id="price" name="price" onkeypress="return isNumberKey(this,event)" placeholder="ราคาสินค้าต่อหน่วย" value="" class="form-control" type="text">
                                                </div>
                                                <label for="inputext" class="col-lg-2 col-form-label">บาท</label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">เกรดสินค้า :</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="gardProduct" id="gardProduct">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">มาตรฐาน :</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="standardProduct" id="standardProduct">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">มูลค่ารวม :</label>
                                                <div class="col-lg-4">
                                                    <input id="totalPricre" name="totalPricre" placeholder="ราคาสินค้าต่อหน่วย" value="" readonly class="form-control" type="text">
                                                </div>
                                                <label for="inputext" class="col-lg-2 col-form-label">บาท</label>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">วันที่เพาะปลูก : </label>
                                                <div class="input-group date form_date dateAll col-lg-3" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input3" data-link-format="dd-mm-yyyy">
                                                    <input class="form-control" size="14" type="text" value="" readonly>
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden" id="dtp_input3" name="dtp_input3" value="" /><br/>
                                                <label class="col-lg-4 col-form-label text-required ">(หากไม่ทราบหรือจำไม่ได้ ให้ระบุโดยการประมาณ)</label>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">วันที่เก็บผลผลิต : </label>
                                                <div class="input-group date form_date dateAll col-lg-3" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input4" data-link-format="dd-mm-yyyy">
                                                    <input class="form-control" size="14" type="text" value="" readonly>
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden" id="dtp_input4" name="dtp_input4" value="" /><br/>
                                                <label class="col-lg-4 col-form-label text-required ">(หากไม่ทราบหรือจำไม่ได้ ให้ระบุโดยการประมาณ)</label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">แปลงที่ปลูก :</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="landDetail" id="landDetail">
                                                        <option value='0'>กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                                <label class="col-lg-3 col-form-label text-required ">(แหล่งข้อมูลมาจากการสำรวจที่ดินรายแปลง)</label>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">วิธีการขนส่ง :</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control reset" name="logistic_Id" id="logistic_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                        <?php
                                                            echo loadLogisticList($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">รูปภาพประกอบ :</label>
                                                <div class="col-lg-4">
                                                    <input type="file" id="file" name="file" class="form-control-file" accept="image/*" style=" height: auto; ">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#camera" style=" margin-top: 20px; "><i class="fa fa-camera"></i> อัพโหลดผ่านมือถือ</button>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-2" ></div>
                                                <div class="col-lg-4" id="results">
                                                    <img class="mx-auto d-block basic-img" style=" height: 200px;float: left;">
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row form-group">
                                        </div>
                                        <div class="row form-group">
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-lg-1">
                                                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="addDeliverPerson" name="addDeliverPerson" role="button"> <i class="fa fa-dot-circle-o"></i> บันทึกส่งมอบสินค้า</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script src="../vendors/datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
    <script src="../vendors/datetimepicker-master/js/bootstrap-datepicker-custom.js"></script>
    <script src="../vendors/datetimepicker-master/js/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
    <script src="../vendors/datetimepicker-master/js/locales/bootstrap-datetimepicker.th.js" charset="UTF-8"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/deliverProductFromPersonJs.js"></script>
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
