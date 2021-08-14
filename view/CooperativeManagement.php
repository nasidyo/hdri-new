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
    <title>การจัดการสหกรณ์</title>
    <meta name="description" content="การจัดการสหกรณ์">
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


    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link rel="stylesheet" href="../assets/css/slimselect.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../assets/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">

</head>

<body>


    <!-- Left Panel -->

    <?php
     require '../connection/database.php';
     require '../service/sessionCheck.php';
    include 'navbar.php';


    if($conn==""){
        $db = new Database();
        $conn=  $db->getConnection();
    }
    ?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php
         include 'menuToggle.php';


        require '../util/RiverBasinDependent.php';
        require '../util/ProvinceDependent.php';
        require '../util/loadPersonFromAgri.php';

        ?>

    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn" id="main">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">


                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                 <strong class="card-title">บัญชีรายรับรายจ่ายสหกรณ์</strong>
                                 <input type="hidden" value="<?php echo $_SESSION['idRiverBasin'] ?>" id="idRiverBasin_session">
                                    <input type="hidden" value="<?php echo $_SESSION['idarea'] ?>" id="idarea_session">
                                    <input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>" id="AreaAll">
                                    <input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>" id="RBAll">
                                    <input type="hidden" value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">
                                </div>

                            </div>
                            </div>


                            <div class="card-body" >
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class="card-body" id='criteria'>
                                        <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;">
                                                        <?php
                                                              echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                                                        ?>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="idArea" id="idArea"  style="width: 100%;">
                                                <?php
                                                       echo loadAreaDependentInSS($conn,$_SESSION['RBAll'],$_SESSION['AreaAll']);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถาบันเกษตรกร</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="institute_id"  style="width: 100%;">

                                                        </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">กลุ่มเกษตรกร</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="sub_group_id"  style="width: 100%;">


                                                        </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">กลุ่มธุระกิจ</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="business_group_id"  style="width: 100%;">


                                                        </select>

                                                    </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ผู้รับเงิน</label>
                                            <div class="col-sm-4">
                                             <select class="farmer-dropdown" name="customer_search" id="customer_search" style="width: 100%;">

                                                    </select>
                                            </div>
                                            <label class="col-sm-2 col-form-label">ผู้รับเงินมิใช่สมาชิก</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="other_customer" id="other_customer" placeholder="">
                                                    </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สินค้า</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="product" id="product"  style="width: 100%;">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                        <label class="col-sm-2 col-form-label">รายจ่ายอื่นๆ</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="expense_other_id"  style="width: 100%;">
                                                        <!--<option value='0'>กรุณาเลือก</option>-->
                                                        <?php /*
                                                                $sql2="  SELECT EXPENSE_OTHER_ID, EXPENSE_DETAIL, STATUS, COMMENT FROM EXPENSE_OTHER_TD where  STATUS ='Y' and EXPENSE_OTHER_ID <> 0 ";
                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["EXPENSE_OTHER_ID"];
                                                                $name_pre=$row["EXPENSE_DETAIL"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }*/
                                                            ?>
                                                        </select>

                                                </div>
                                                <div class="col-sm-4">
                                                            </div>

                                                <label class="col-sm-2 col-form-label">รายรับอื่นๆ</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="income_other_id"  style="width: 100%;">
                                                       <!-- <option value='0'>กรุณาเลือก</option>-->
                                                        <?php /*
                                                                $sql2=" SELECT INCOME_OTHER_ID, INCOME_DETAIL, STATUS, COMMENT, INSTITUTE_ID FROM INCOME_OTHER_TD WHERE STATUS='Y'  ";
                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["INCOME_OTHER_ID"];
                                                                $name_pre=$row["INCOME_DETAIL"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }*/
                                                            ?>
                                                        </select>

                                                </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">เลขที่เอกสาร</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="doc_no" id="doc_no">

                                            </div>
                                            <label class="col-sm-2 col-form-label">รายการยกเลิก</label>
                                            <div class="col-sm-4">
                                                    <select class="form-control" id="canceled"  style="width: 100%;" >
                                                                <option value="">ทั้งหมด</option>
                                                                <option value="N" selected >ใช้งาน</option>
                                                                <option value="Y">ยกเลิก</option>
                                                    </select>

                                            </div>

                                        </div>

                                        <div class="form-group row">
                                                 <label class="col-sm-2 col-form-label">ประเภทรายการ</label>
                                                <div class="form-check-inline form-check" style=" margin: 0 5% 0; margin-top: 10px;">
                                                    <label for="inline-radio1" class="RECEIVE ">
                                                        <input type="checkbox" id="RECEIVE" name="RECEIVE" value="RECEIVE" class="form-check-input">รายรับ
                                                    </label>

                                                </div>
                                                <div class="form-check-inline form-check" style="margin: 0 5% 0; margin-top: 10px;">

                                                    <label for="inline-radio2" class="EXPENCE">
                                                        <input type="checkbox" id="EXPENCE" name="EXPENCE" value="EXPENCE" class="form-check-input">รายจ่าย
                                                    </label>
                                                </div>
                                            <div class="form-check-inline form-check" style="margin: 0 5% 0; margin-top: 10px; ">
                                                <label for="inline-radio2" class="debt">
                                                    <input type="checkbox" id="debt" name="debt" value="debt" class="form-check-input">ค้างชำระ
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ประเภทรายการ</label>
                                                <div class="col-sm-4">
                                                        <select class="form-control" id="type"  style="width: 100%;" >
                                                                    <option value="" selected>ทั้งหมด</option>
                                                                    <option value="B" >ฝากถอนธนาคาร</option>
                                                                    <option value="S">หุ้น</option>
                                                                    <option value="A">ออมทรัทย์</option>
                                                                    <option value="I">ดอกเบี้ยออมทรัทย์</option>
                                                        </select>

                                                </div>
                                        </div>


                                        <div class="form-group row">



                                            <label for="inputext" class="col-sm-2 col-form-label" style=" text-align: end; ">วันที่เริ่มต้น :</label>
                                                <div class="input-group date form_date col-md-3 searchFromDateTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="searchFromDate" data-link-format="dd-mm-yyyy">
                                                            <input class="form-control" size="14" type="text" value="" readonly>
                                                            <input class="form-control" size="14" type="hidden" id="searchFromDate" value="" readonly>
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>

                                                <label for="inputext" class="col-sm-2 col-form-label" style=" text-align: end; ">วันที่สิ้นสุด :</label>
                                                <div class="input-group date form_date col-md-3 searchToDateTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="searchToDate" data-link-format="dd-mm-yyyy">
                                                            <input class="form-control" size="14" type="text" value="" readonly>
                                                            <input class="form-control" size="14" type="hidden" id="searchToDate" value="" readonly>
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>

                                            </div>

                                        <div class="form-group row">
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary " id="search_cooperative"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 ">
                                              <!--  <button type="button" class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>-->
                                            </div>
                                            <div class="col-md-5">
                                            </div>

                                        </div>






                                    </div>


                                </div>
                              <!--  <div class="card">
                                    <div class="card-header">
                                         <strong class="card-title">สรุป</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" style="font-weight: bold;">พื้นที่</label>
                                            <label class="col-sm-4 col-form-label">แม่สอง</label>


                                            <label class="col-sm-2 col-form-label" style="font-weight: bold;">วันที่</label>
                                            <label class="col-sm-2 col-form-label">01/01/2020 ถึง 01/06/2020</label>
                                            <label class="col-sm-2 col-form-label"></label>
                                            <label class="col-sm-2 col-form-label" style="font-weight: bold;">ผู้ซื้อ</label>
                                            <label class="col-sm-2 col-form-label">ทั้งหมด</label>

                                            <label class="col-sm-2 col-form-label" style="font-weight: bold;">สินค้า/บริการ</label>
                                            <label class="col-sm-6 col-form-label">ทั้งหมด</label>


                                            <label class="col-sm-2 col-form-label" style="font-weight: bold;">รายรับรวม</label>
                                            <label class="col-sm-2 col-form-label">4,230 บาท</label>
                                            <label class="col-sm-2 col-form-label">12 หน่วย</label>
                                            <label class="col-sm-6 col-form-label"></label>

                                            <label class="col-sm-2 col-form-label" style="font-weight: bold;">รายจ่ายรวม</label>
                                            <label class="col-sm-2 col-form-label">10,800 บาท</label>
                                            <label class="col-sm-2 col-form-label">30 หน่วย</label>
                                            <label class="col-sm-6 col-form-label"></label>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary " id="search_person"><i class="menu-icon fa fa-print"></i>  รายงาน </button>
                                            </div>

                                            <div class="col-md-5">
                                            </div>

                                        </div>

                                    </div>





                                </div>-->



                            <div class="card">
                            <div class="card-header">
                                         <strong class="card-title">ตารางแสดงรายรับ - รายจ่าย</strong>
                                    </div>
                            <div class="card-body">

                            <table id="cooperativeTable" class="table table-striped table-bordered " style=" text-align: center;border-left-width: 0; width: 100%;">
                                        <thead>
                                            <tr style=" border-left-width: thick; ">
                                                <th  style=" vertical-align: middle; ">วันที่</th>
                                                <th  style=" vertical-align: middle; ">เลขที่เอกสาร</th>
                                                <th  style=" vertical-align: middle; ">รายการ</th>
                                                <th  style=" vertical-align: middle; ">ปริมาณ</th>
                                                <th  style=" vertical-align: middle; ">ราคา</th>
                                                <th  style=" vertical-align: middle; ">ส่วนลด</th>
                                                <th  style=" vertical-align: middle; ">จำนวนเงิน</th>
                                                <th  style=" vertical-align: middle; ">ยอดเงิน</th>
                                                <th  style=" vertical-align: middle; ">เจ้าหนี้การค้า</th>
                                                <th  style=" vertical-align: middle; ">ลูกหนี้การค้า</th>
                                                <th  style=" vertical-align: middle; ">ลูกค้า</th>
                                                <th  style=" vertical-align: middle; ">เจ้าหน้าที่</th>
                                                <th  style=" vertical-align: middle; ">หมายเหตุ</th>

                                                <th  style=" vertical-align: middle; "></th>
                                                <th  style=" vertical-align: middle; "></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                            <tfoot>
                                           <!-- <tr>
                                                    <th colspan="10" style="text-align:right">ยอดเงินทั้งหมด :</th>
                                                    <th rowspan="1" colspan="2"  id="all_other"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="10" style="text-align:right">รับเงินทั้งหมด :</th>
                                                    <th rowspan="1" colspan="2" id="pay_all"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="10" style="text-align:right">ส่วนลดทั้งหมด :</th>
                                                    <th rowspan="1" colspan="2" id="all_discount"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="10" style="text-align:right">รวมเจ้าหนี้การค้า :</th>
                                                    <th id="debt_ex" rowspan="1" colspan="2" ></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="10" style="text-align:right">รวมลูกหนี้การค้า :</th>
                                                    <th id="debt_inc" rowspan="1" colspan="2" ></th>
                                                </tr>-->
                                            </tfoot>

                                    </table>

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

    <!-- Right Panel -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <!-- dataTable -->
    <script src="../assets/hrdi_js/moment.min.js"></script>
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <script src="../assets/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/hrdi_js/validationPerson.js"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/cooperative.js"></script>






</body>

</html>
