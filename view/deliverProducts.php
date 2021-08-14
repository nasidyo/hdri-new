
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
    <!-- <link rel="stylesheet" href="../assets/css/select2.min.css"> -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
    <?php require '../connection/database.php'; ?>
    <?php 
        require '../service/sessionCheck.php';
    ?>

    <!-- Left Panel -->

    <?php include 'navbar.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php   include 'menuToggle.php';
            require '../util/RiverBasinDependent.php';
            require '../util/typeOfAgri.php';
            require '../util/loadMarketList.php';
            require '../util/loadPersonFromAgri.php';
            require '../util/loadLogisticList.php';
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
                                        <strong class="card-title">ส่งมอบผลผลิต 
                                            [ <?php
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
                                            ?> ] 
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
                                    <div class="col-md-2 ">
                                        <a href="deliverProductList.php?yearsId=<?php echo $yearsId ?>&monthId=<?php echo $monthId ?>&area_Id=<?php echo $area_Id ?>" class="btn btn-secondary"><i class="fa ti-angle-double-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ข้อมูลเกษตรกรผู้ส่งมอบผลผลิต</strong>
                                    </div>
                                    <div class="card-body" id='search'>
                                        <form class="form-horizontal" action="#" method="post" id="framer_form">
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">เกษตรกร : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="farmer-dropdown" name="farmer_Id" id="farmer_Id" style="width: 100%;">
                                                        <option value='0'>กรุณาเลือก</option>
                                                        <?php
                                                            echo loadFarmerFromAgri($conn, $area_Id);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-1">
                                                    <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="addNewPerson" name="addNewPerson" role="button"><i class="fa fa-plus"></i> เพิ่มเกษตรกร</a>
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
                                            <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>">
                                            <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                                            <input type="hidden" id="monthId" name="monthId" value="<?php echo $monthId?>">
                                            <input type="hidden" id="idStaff" name="idStaff" value="<?php echo $_SESSION['idStaff']?>">
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">วันที่ส่งมอบผลผลิต : <span style=" color: red; ">*</span> </label>
                                                <div class="input-group date form_date dateNow col-md-3" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                                    <input class="form-control" size="14" type="text" value="" readonly>
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden" id="dtp_input2" name="dtp_input2" value="" /><br/>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">พืชสาขา : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="typeAgri_Id" id="typeAgri_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">ชนิดพืช : <span style=" color: red; ">*</span> </label>
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
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">เกรดสินค้า :</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control reset"name="gardProduct" id="gardProduct">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">มาตรฐาน :</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control reset"name="standardProduct" id="standardProduct">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">ช่องทางการตลาด : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <select class="form-control"name="market_Id" id="market_Id">
                                                        <option value='0'>กรุณาเลือก</option>
                                                        <?php
                                                            echo loadMarketList($conn, $area_Id);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">ปริมาณที่ส่งมอบ : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-2">
                                                    <input id="quality" name="quality" onkeypress="return isNumberKey(this,event)" placeholder="จำนวนผลผลิตที่ส่งมอบ" value="" class="form-control two-decimals reset" type="text">
                                                </div>
                                                <label for="inputext" class="col-lg-1 col-form-label" id="unitCodeProduct" name="unitCodeProduct"></label>
                                                <label for="inputext" class="col-lg-1 col-form-label">ปริมาณสูญเสีย</label>
                                                <div class="col-lg-2">
                                                    <input id="lossValue" name="lossValue" onkeypress="return isNumberKey(this,event)" placeholder="ปริมาณสูญเสีย" value="" class="form-control reset" type="text">
                                                </div>
                                                <label for="inputext" class="col-lg-1 col-form-label">ปริมาณสุทธิ</label>
                                                <div class="col-lg-2">
                                                    <input id="totalQuality" name="totalQuality" onkeypress="return isNumberKey(this,event)" placeholder="ปริมาณสุทธิ" value="" readonly class="form-control reset" type="text">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">ราคาต่อหน่วย : <span style=" color: red; ">*</span> </label>
                                                <div class="col-lg-4">
                                                    <input id="price" name="price" onkeypress="return isNumberKey(this,event)" placeholder="ราคาสินค้าต่อหน่วย" value="" class="form-control reset" type="text">
                                                </div>
                                                <label for="inputext" class="col-lg-2 col-form-label">บาท</label>
                                            </div>
                                            <div class="row form-group">
                                                <label for="inputext" class="col-lg-2 col-form-label">มูลค่ารวม :</label>
                                                <div class="col-lg-4">
                                                    <input id="totalPricre" name="totalPricre" placeholder="ราคาสินค้าต่อหน่วย" value="" readonly class="form-control reset" type="text">
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
                                                    <select class="form-control reset" name="landDetail" id="landDetail">
                                                        <option value='0'>กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                                <label class="col-lg-4 col-form-label text-required ">(แหล่งข้อมูลมาจากการสำรวจที่ดินรายแปลง)</label>
                                                    <!-- <i class="fa fa-info-circle icon-info" data-toggle="tooltip" title="แหล่งข้อมูลมาจากการสำรวจที่ดินรายแปลง"></i> -->
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
                                                <!-- <div class="col-lg-1">
                                                    <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="addNewLogistic" name="addNewLogistic" role="button"><i class="fa fa-plus"></i> เพิ่มวิธีการขนส่ง</a>
                                                </div> -->
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-2">
                                                    <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="uploadImageOpen" name="uploadImageOpen" role="button"><i class="fa fa-plus"></i> อัพโหลดรูปภาพประกอบ</a>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-2"></div>
                                                <div class="col-sm-6">
                                                        <table class="table" id="imageTable" style="width:100%">
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-lg-1">
                                                    <a class="btn btn-success btn-sm" href="javascript:void(0)" id="addDeliverProduct" name="addDeliverProduct" role="button"><i class="fa ti-shopping-cart"> เพิ่มข้อมูล</i></a>
                                                </div>
                                            </div>
                                        </form>

                                        <table class="table" id="dashTable">
                                            <thead>
                                                <tr>
                                                    <th>วัน/เดือน/ปี</th>
                                                    <th>เกษตรกร</th>
                                                    <th>ชนิดพืช</th>
                                                    <th>มาตรฐาน</th>
                                                    <th>เกรด</th>
                                                    <th>ปริมาณ</th>
                                                    <th>ปริมาณสูญเสีย</th>
                                                    <th>ปริมาณสุทธิ</th>
                                                    <th>ราคาต่อหน่วย</th>
                                                    <th>มูลค่า</th>
                                                    <th>ตลาด</th>
                                                    <th>ผู้รับซื้อ</th>
                                                    <th style="width: 13%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div class="row form-group">
                                        </div>
                                        <div class="row form-group">
                                        </div>
                                        <div class="row form-group">
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-lg-3">
                                                <a class="btn btn-primary" href="javascript:void(0)" id="addDeliverPerson" name="addDeliverPerson" role="button"> <i class="fa fa-dot-circle-o"></i> บันทึกการส่งมอบสินค้า</a>
                                            </div>
                                            <div class="col col-lg-1">
                                                <a class="btn btn-danger" href="javascript:void(0)" id="resetValueInpage" name="resetValueInpage" role="button"> <i class="fa fa-times"></i> ยกเลิก</a>
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
        <?php include 'modal/addNewPerson.php';?>
        <?php include 'modal/addNewLogistic.php';?>
        <?php include 'modal/uploadImageDialog.php';?>
        <?php include 'modal/showListimageDalog.php';?>
    </div><!-- /#right-panel -->

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

    <!-- <script src="../vendors/select2/dist/js/i18n/th.js"></script> -->
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <!-- <script src="../assets/js/select2.min.js"></script> -->
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/hrdi_js/deliverProducts.js"></script>
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
