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
    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datepicker.css">
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
        <?php    include 'menuToggle.php';

        require '../util/RiverBasinDependent.php';
        require '../util/ProvinceDependent.php';
        include 'modal/addProduct.php';
        include 'modal/addIncomeOther.php';
        require '../util/loadPersonFromAgri.php';

        include 'modal/editIncome.php';
        include 'modal/addDebtInc.php';




        ?>


                            <input type="hidden" value="<?php echo$_SESSION['idStaff'];?>" id="idStaff">

    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn" id="main">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #f3e97a;color: black;">


                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                    <strong class="card-title">รายรับ</strong>
                                    <input type="hidden" value="<?php echo $_SESSION['idRiverBasin'] ?>" id="idRiverBasin_session">
                                    <input type="hidden" value="<?php echo $_SESSION['idarea'] ?>" id="idarea_session">
                                    <input type="hidden" value="<?php echo $_SESSION['pay'] ?>" id="pay_session">

                                    <input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>" id="AreaAll">
                                    <input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>" id="RBAll">
                                    <input type="hidden" value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">


                                </div>

                            </div>
                            </div>

                            <div class="card-body" style=" background-color: beige; ">
                                <div class="card">
                                <div class="card-header" style=" cursor: pointer; " data-toggle="collapse" data-target="#criteria" aria-expanded="false" aria-controls="criteria">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class="card-body multi-collapse collapse" id='criteria'>
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
                                            <div class="col-sm-6">
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
                                        <label class="col-sm-2 col-form-label">ขายตลาด</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="market_id">
                                                <option value="0">ทั้งหมด</option>
                                                    <?php
                                                                $sql2="select ins.*  from MARKET_COOPERATIVE_TD ins where 1=1";

                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["MARKET_ID"];
                                                                $name_pre=$row["MARKET_NAME"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }
                                                            ?>
                                            </select>
                                        </div>
                                        </div>



                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ผู้ซื้อ</label>
                                            <div class="col-sm-4">
                                             <select class="farmer-dropdown" name="customer_search" id="customer_search" style="width: 100%;">
                                                        <option value='0'>ทั้งหมด</option>

                                                    </select>
                                            </div>
                                            <label class="col-sm-2 col-form-label">ผู้ซื้อมิใช่สมาชิก</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="other_customer" id="other_customer" placeholder="" maxlength="200">
                                                    </div>
                                        </div>

                                        <div class="form-group row" >
                                            <label class="col-sm-2 col-form-label">สินค้า</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="product" id="product"  style="width: 100%;">
                                                </select>
                                            </div>

                                            <label class="col-sm-2 col-form-label">อื่นๆ</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="income_other_id"  style="width: 100%;">
                                                    <option value='0'>กรุณาเลือก</option>
                                                        <?php
                                                                $sql2="  SELECT INCOME_OTHER_ID, INCOME_DETAIL, STATUS, COMMENT, INSTITUTE_ID, TYPE FROM INCOME_OTHER_TD WHERE STATUS ='Y' AND INCOME_OTHER_ID <>0  ";
                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["INCOME_OTHER_ID"];
                                                                $name_pre=$row["INCOME_DETAIL"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }
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
                                                                <option value="N">ใช้งาน</option>
                                                                <option value="Y">ยกเลิก</option>
                                                    </select>

                                            </div>

                                        </div>
                                        <div class="form-group row">
                                                <div class="col-sm-5">
                                                </div>
                                            <div class="form-check-inline form-check col-sm-2" style=" margin-top: 10px; ">
                                                <label for="inline-radio2" class="debt_search">
                                                    <input type="checkbox" id="debt_search" name="debt" value="debt" class="form-check-input">ค้างชำระ
                                                </label>
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
                                                <button type="button" class="btn btn-primary " id="search_income"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 ">
                                                <button type="button" class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                            </div>
                                            <div class="col-md-5">
                                            </div>

                                        </div>


                                </div>

                                <div class="card"  id="addIncome">
                                    <div class="card-header" style=" cursor: pointer; " data-toggle="collapse" data-target="#income" aria-expanded="false" aria-controls="income">
                                        <strong class="card-title">เพิ่มรายรับ</strong>
                                    </div>
                                        <div class="card-body collapse show" id='income'>
                                    <form>
                                        <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;">
                                                        <?php
                                                            echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                                                        ?>
                                                        </select>
                                                </div>

                                                <label for="inputext" class="col-sm-2 col-form-label" style=" text-align: end; ">วันที่ :</label>
                                                        <div class="input-group date form_date col-md-3 receiveDateTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="receiveDate" data-link-format="dd-mm-yyyy">
                                                                    <input class="form-control" size="14" type="text" value="" readonly>
                                                                    <input class="form-control" size="14" type="hidden" id="receiveDate" value="" readonly>
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        </div>


                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
                                            <div class="col-sm-6">
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
                                            <label class="col-sm-2 col-form-label">ขายตลาด</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="market_id">
                                                    <option value="0">ทั้งหมด</option>
                                                    <?php
                                                                $sql2="select ins.*  from MARKET_COOPERATIVE_TD ins where 1=1";

                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["MARKET_ID"];
                                                                $name_pre=$row["MARKET_NAME"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }
                                                            ?>
                                                </select>
                                            </div>
                                            </div>

                                            <div class="form-group row">

                                                    <label class="col-sm-2 col-form-label">ผู้ซื้อ</label>
                                                    <div class="col-sm-4">
                                                    <select class="farmer-dropdown" name="customer" id="customer" style="width: 100%;">

                                                            </select>
                                                    </div>

                                                <label class="col-sm-2 col-form-label">ผู้ซื้อมิใช่สมาชิก</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="other_customer" id="other_customer" placeholder="" maxlength="200">
                                                    </div>

                                            </div>
                                            <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">เลขที่เอกสาร</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="doc_no" id="doc_no" maxlength="20" >

                                            </div>

                                        </div>
                                        <div class="form-group row">
                                                 <label class="col-sm-2 col-form-label">ประเภทรายรับ</label>
                                                <div class="form-check-inline form-check">
                                                    <label for="inline-radio1" class="form-check-label ">
                                                        <input type="radio" id="inline-radio1" name="pay_type" value="product" class="form-check-input" checked="checked">สินค้า
                                                    </label>
                                                    <label for="inline-radio2" class="form-check-label ">
                                                        <input type="radio" id="inline-radio2" name="pay_type" value="other" class="form-check-input">อื่นๆ
                                                    </label>

                                                </div>
                                            </div>
                                        <div id="product_div">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">สินค้า</label>
                                                <div class="col-sm-4">
                                                <select class="form-control"name="product_add" id="product_add"  style="width: 100%;">
                                                </select>
                                                </div>
                                                <label class="col-sm-2 col-form-label">คลัง : <span id="balance"></span></label>
                                                <button type="button" class="btn btn-primary " id="search_person"  data-toggle="modal" data-target="#addProduct" style="display:none"><i class="menu-icon fa fa-plus"></i>  เพิ่มสินค้า</button>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">จำนวน</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="amount" id="amount" placeholder="" min="0" step="1"  onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                                    </div>


                                                <label class="col-sm-2 col-form-label">ราคา</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="price" id ="price" placeholder=""  onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                                    </div>
                                                    <label class="col-sm-1 col-form-label">บาท</label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">ส่วนลด</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="discount"  id="discount" placeholder=""  min="0"   onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                                    </div>
                                                    <label class="col-sm-2 col-form-label">บาท</label>
                                            </div>

                                        </div>
                                        <div id="other_div" style="display: none;">


                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">อื่นๆ</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="income_other_id"  style="width: 100%;">

                                                    </select>

                                                </div>
                                                <button type="button" class="btn btn-primary col-sm-2" id="clear_person" data-toggle="modal" data-target="#addIncomeOther"><i class="menu-icon fa fa-add"> </i> เพิ่มรายรับอื่นๆ</button>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">เป็นเงิน</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="price" id="price" placeholder=""  min="0"   onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                                    </div>
                                                    <label class="col-sm-1 col-form-label">บาท</label>
                                            </div>
                                        </div>


                                            <div class="form-group row">
                                                    <div class="col-sm-5"></div>
                                                    <div class="col-sm-2"> <button type="button" id="addIncomeTmp" class="btn btn-primary col-sm-12" id="clear_person"><i class="menu-icon fa fa-add"> </i>  เพิ่มในรายการ</button>      </div>
                                                    <div class="col-sm-5"> </div>

                                            </div>
                                            <div class="form-group row" style="border: 1px solid rgba(0,0,0,.125);border-radius: 1rem;padding-top: 20px;background-color: honeydew;" id="displayItem">



                                            </div>
                                            <div class="form-group row">
                                            <div class="col-sm-8"></div>
                                                <label class="col-sm-2 col-form-label" style=" text-align: right; ">เป็นเงินทั้งหมด :</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="otherPay" id="otherPay" placeholder="" disabled>
                                                    </div>
                                                </div>
                                            <div class="form-group row">
                                                <div class="col-sm-8"></div>
                                                <label class="col-sm-2 col-form-label" style=" text-align: right; ">จ่ายเงิน :</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="receive_amount" id="receive_amount" placeholder=""  min="0"   onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                                    </div>



                                            </div>

                                            <div class="form-group row">
                                            <div class="col-sm-8"></div>
                                            <label class="col-sm-2 col-form-label"style=" text-align: right; ">ค้างชำระ :</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="debt"  id="debt" placeholder=""  min="0"   onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-5">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-primary " id="addIncomeBt"><i class="menu-icon fa fa-search"></i>  บันทึก</button>
                                                </div>
                                                <div class="col-md-1 ">
                                                    <button type="button" class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                                </div>
                                                <div class="col-md-5">
                                                </div>

                                            </div>
                                        </div>
                            </form>

                            <div class="card">
                            <div class="card-header" >
                                        <strong class="card-title">ตารางแสดงข้อมูลรายรับ</strong>
                                    </div>

                            <div class="card-body">
                                <table id="incomeTable" class="table table-striped table-bordered " style=" text-align: center;border-left-width: 0; width: 100%;">
                                    <thead>
                                        <tr style=" border-left-width: thick; ">

                                            <th style=" vertical-align: middle; ">วันที่</th>
                                            <th  style=" vertical-align: middle; ">เลขที่เอกสาร</th>
                                            <th  style=" vertical-align: middle; ">รายการ</th>
                                            <th  style=" vertical-align: middle; "> ราคา</th>
                                            <th  style=" vertical-align: middle; "> หน่วย</th>
                                            <th  style=" vertical-align: middle; "> จำนวนเงิน</th>
                                            <th  style=" vertical-align: middle; "> ส่วนลด</th>
                                            <th  style=" vertical-align: middle; "> รับเงิน</th>
                                            <th style=" vertical-align: middle; ">ยอดค้างชำระ </th>
                                            <th  style=" vertical-align: middle; "> ผู้ซื้อ</th>
                                            <th  style=" vertical-align: middle; "> ผู้รับเงิน</th>

                                            <th style=" vertical-align: middle; "> </th>
                                            <th style=" vertical-align: middle; "> </th>
                                        </tr>

                                    </thead>
                                             <tfoot>

                                                <tr>
                                                    <th colspan="9" style="text-align:right">ยอดเงินทั้งหมด :</th>
                                                    <th rowspan="1" colspan="3"  id="all_other"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="9" style="text-align:right">รับเงินทั้งหมด :</th>
                                                    <th rowspan="1" colspan="3" id="pay_all"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="9" style="text-align:right">ส่วนลดทั้งหมด :</th>
                                                    <th rowspan="1" colspan="3" id="all_discount"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="9" style="text-align:right">รวมค้างชำระ :</th>
                                                    <th id="debtOther" rowspan="1" colspan="3" ></th>
                                                </tr>
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



    <script src="../vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <script src="../vendors/datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
    <script src="../vendors/datetimepicker-master/js/bootstrap-datepicker-custom.js"></script>
    <script src="../vendors/datetimepicker-master/js/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
    <script src="../vendors/datetimepicker-master/js/locales/bootstrap-datetimepicker.th.js" charset="UTF-8"></script>

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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/incomeManagement.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/editIncome.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/addDebtInc.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/addIncomeOtherProduct.js"></script>






</body>

</html>
