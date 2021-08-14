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
    <title>ระบบการบริหารจัดการข้อมูบเกษตรกร</title>
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


    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link rel="stylesheet" href="../assets/css/slimselect.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../assets/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="../webcamjs/webcam.min.js"></script>
</head>

<body>


    <!-- Left Panel -->

    <?php //include 'navbar.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php  // include 'header.php';
              require '../connection/database.php';
              require '../util/RiverBasinDependent.php';
              require '../util/ProvinceDependent.php';
              require '../view/modal/camera.php';
              require '../util/loadYearsOfPlan.php';
              require '../util/loadMonth.php';
              require '../view/modal/addYearEarnPay.php';


              $db = new Database();
              $conn=  $db->getConnection();
              $person_id=0;
            if(isset($_GET['person_id'])){
              $person_id =$_GET['person_id'];
            }



              ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>ข้อมูลเกษตรกร</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8" style="display: none;">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">ข้อมูลเกษตรกร</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">


                            <div class="row justify-content-between">
                                <div class="col-md-8 " style=" display: none; ">
                                 <strong class="card-title">ตารางข้อมูลเกษตรกร</strong>

                                </div>

                            </div>
                            </div>


                            <div class="card">
                                <div class="card-body">
                                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="editFarmer">
                                          <div class="card-body">
                                              <div class="card" style=" display: none; ">
                                              <div class="card-header">
                                                <strong class="card-title">พื้นที่</strong>
                                              </div>
                                           <div class="card-body">
                                                <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ <span style=" color: red; " >*</span></label>
                                                <div class="col-sm-4">
                                                      <select class="form-control"name="idRiverBasin" id="idRiverBasin" disabled>
                                                      <?php
                                                       echo loadRiverDependent($conn);
                                                        ?>
                                                      </select>

                                                </div>
                                                  </div>
                                                  <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">พื้นที่ <span style=" color: red; ">*</span></label>
                                                <div class="col-sm-8">
                                                  <select class="form-control"name="idArea" id="area" disabled>

                                                      </select>
                                                </div>
                                              </div>
                                              <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">ชื่อบ้าน</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"name="idGroupVillage" id="idGroupVillage" disabled>

                                                    </select>
                                                </div>
                                            </div>

                                                <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">สาขาพืชที่ส่งเสริม</label>
                                                        <div class="col-sm-8">
                                                        <select id="argi_group_type" multiple="multiple" disabled>
                                                        <?php
                                                          $sql2="select *  from TypeOfArgi_TD";
                                                          $stmt = sqlsrv_query( $conn, $sql2 );

                                                          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                            $id_pre=$row["idTypeOfArgi"];
                                                            $name_pre=$row["nameTypeOfArgi"];
                                                            echo "<option value='$id_pre' > $name_pre</option>";
                                                          }
                                                        ?>
                                                        </select>

                                                    </div>
                                                  </div>
                                                 <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">ชนิดพืชที่ส่งเสริม</label>
                                                        <div class="col-sm-8" style="padding: 10px 10px 10px 15px;">
                                                          <select id="argi_group" multiple="multiple" disabled>
                                                          </select>
                                                        </div>


                                                  </div>

                                              </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                  <strong class="card-title">ข้อมูลเกษตรกร</strong>
                                                </div>
                                                <div class="card-body">
                                              <div class="form-group row">
                                              <label for="inputext" class="col-sm-2 col-form-label">รูปเกษตรกร</label>
                                              <div class="col-sm-4" id="results">
                                                  <img class="mx-auto d-block basic-img"   style="float: left;" src='../images/noPic.jpg'>
                                              </div>
                                              <div class="col-sm-2">
                                                <!--<input type="file" id="file" name="file" class="form-control-file" accept="image/*" style="height: auto; ">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#camera" style=" margin-top: 20px; "><i class="fa fa-camera"></i></button>-->
                                              </div>
                                              <div class="col-sm-4">
                                              <div style="width:300px;margin:auto;">
                                                    <div id="qrcode"></div>
                                                </div>
                                                <input type="hidden" id="path" name="path" disabled>
                                              </div>

                                              </div>
                                              <div class="form-group row">
                                              <label for="inputext" class="col-sm-2 col-form-label"  style=" display: none; ">รหัสเกษตรกร</label>
                                              <div class="col-sm-4">
                                                <input type="text" class="form-control" name="argnumber" placeholder="รหัสเกษตรกร" readonly value= "<?php echo $person_id ?>"  style=" display: none; " >
                                              </div>
                                              <label for="inputext" class="col-sm-2 col-form-label">เลขที่บัตรประชาชน</label>
                                              <div class="col-sm-4">
                                                <input type="text" class="form-control" name="argid" placeholder="เลขที่บัตรประชาชน" maxlength="13" disabled>
                                              </div>
                                              </div>

                                            <div class="form-group row">
                                              <label class="col-sm-2 col-form-label">ชื่อ-สกุล <span style=" color: red; ">*</span></label>
                                                  <div class="col-sm-2">
                                                  <select class="form-control"name="argpre" disabled>
                                                  <?php
                                                      $sql2="select *  from Prefix_TD";
                                                      $stmt = sqlsrv_query( $conn, $sql2 );

                                                      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                        $id_pre=$row["idPrefix"];
                                                        $name_pre=$row["prefixNameTh"];
                                                        echo "<option value='$id_pre'> $name_pre</option>";
                                                      }
                                                    ?>
                                                  </select>
                                                  </div>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" name="argname" placeholder="ชื่อ" disabled>
                                              </div>
                                              <div class="col-sm-4">
                                                <input type="text" class="form-control" name="argsurname" placeholder="นามสกุล" disabled>
                                              </div>
                                              </div>
                                              <div class="form-group row">
                                              <label for="inputext" class="col-sm-2 col-form-label" style=" text-align: end; ">ปีเกิด</label>
                                                    <div class="input-group date form_date col-md-3 argbirthTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="argbirth" data-link-format="dd-mm-yyyy">
                                                                <input class="form-control" size="14" type="text" value="" disabled>
                                                                <input class="form-control" size="14" type="hidden" id="argbirth" value="" disabled>
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    </div>

                                                    <label  class="col-sm-2 col-form-label">สถานะปัจจุบัน</label>
                                                    <div class="col-sm-4">
                                                            <select class="form-control"name="statusPerson" id="statusPerson">
                                                                <option value='มีชีวิตอยู่'>มีชีวิตอยู่</option>
                                                                <option value='เสียชีวิต'>เสียชีวิต</option>
                                                                <option value='แจ้งลบข้อมูล'>แจ้งลบข้อมูล</option>
                                                            </select>
                                                    </div>

                                            </div>
                                          </div>
                                        </div>

                                        <div class="card">
                                          <div class="card-header">
                                            <strong class="card-title">ที่อยู่เกษตรกร</strong>
                                          </div>
                                          <div class="card-body">
                                          <div class="form-group row">
                                              <label  class="col-sm-2 col-form-label">รหัสไปรษณีย์</label>
                                              <div class="col-sm-2">
                                                <input type="number" class="form-control" name="argzip_code" placeholder="รหัสไปรษณีย์" disabled>
                                              </div>
                                              <label  class="col-sm-1 col-form-label">จังหวัด </label>
                                              <div class="col-sm-3">

                                                <select class="form-control"name="argprovince" id="argprovince" disabled>
                                                      <?php
                                                        echo loadProvinceDependent($conn);
                                                        ?>
                                                      </select>
                                              </div>
                                              <label  class="col-sm-1 col-form-label">อำเภอ </label>
                                              <div class="col-sm-3">

                                                <select class="form-control"name="argdist" id="argdist" disabled>

                                                  </select>
                                              </div>
                                            </div>


                                            <div class="form-group row">

                                            <label  class="col-sm-2 col-form-label">ตำบล </label>
                                              <div class="col-sm-2">

                                                <select class="form-control"name="argsub" id="argsub" disabled>

                                                    </select>
                                              </div>

                                            <label  class="col-sm-2 col-form-label">ชื่อหมู่บ้าน</label>
                                              <div class="col-sm-3">

                                                <select class="form-control"name="argmoo_name" id="argmoo_name" disabled>

                                                  </select>
                                              </div>


                                            </div>

                                            <div class="form-group row">

                                            <label  class="col-sm-2 col-form-label">บ้านเลขที่</label>
                                              <div class="col-sm-2">
                                                <input type="text" class="form-control" name="argno" placeholder="บ้านเลขที่" disabled>
                                              </div>

                                              <label  class="col-sm-1 col-form-label">หมู่ที่</label>
                                              <div class="col-sm-2">
                                                <input type="number" class="form-control" name="argmoo_no" placeholder="หมู่ที่" disabled>
                                              </div>
                                            <label  class="col-sm-1 col-form-label">หย่อม</label>
                                              <div class="col-sm-2">
                                                <input type="text" class="form-control" name="argsub_moo" placeholder="หย่อม" disabled>
                                              </div>


                                            </div>

                                            <div class="form-group row" >
                                            <label  class="col-sm-2 col-form-label"  style=" display: none; ">ถนน</label>
                                              <div class="col-sm-2"  style=" display: none; ">
                                                <input type="text" class="form-control" name="road" placeholder="ถนน" disabled>
                                              </div>
                                              <label  class="col-sm-2 col-form-label">เบอร์โทร</label>
                                              <div class="col-sm-2">
                                                <input type="text" class="form-control" name="argTel" placeholder="เบอร์โทร" disabled>
                                              </div>
                                              <label  class="col-sm-1 col-form-label"  style=" display: none; ">อีเมล์</label>
                                                <div class="col-sm-3" style=" display: none; ">
                                                  <input type="text"   class="form-control" name="argEmail" placeholder="อีเมล์" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" disabled>
                                                </div>
                                              </div>


                                          </div>
                                        </div>



                                        <div class="card">
                                          <div class="card-header">
                                            <strong class="card-title">ข้อมูลอื่นๆ</strong>
                                          </div>
                                          <div class="card-body">
                                            <div class="form-group row">
                                              <label  class="col-sm-2 col-form-label">อาชีพหลัก </label>
                                              <div class="col-sm-4">

                                                <select class="form-control"name="occupFirst" disabled>
                                                    <?php
                                                        $sql4="select *  from Occup";
                                                        $stmt = sqlsrv_query( $conn, $sql4 );

                                                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                          $id_pre=$row["idOccup"];
                                                          $name_pre=$row["occupName"];
                                                          echo "<option value='$id_pre'> $name_pre</option>";
                                                        }
                                                      ?>
                                                    </select>

                                              </div>
                                            <label  class="col-sm-2 col-form-label">อาชีพรอง </label>
                                              <div class="col-sm-4">

                                                <select class="form-control"name="occupSecond" disabled>
                                                    <?php
                                                        $sql5="select *  from Occup";
                                                        $stmt = sqlsrv_query( $conn, $sql5 );

                                                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                          $id_pre=$row["idOccup"];
                                                          $name_pre=$row["occupName"];
                                                          echo "<option value='$id_pre'> $name_pre</option>";
                                                        }
                                                      ?>
                                                    </select>
                                              </div>
                                            </div>

                                          </div>
                                        </div>

                                        <div class="card"  style=" display: none; ">
                                            <div class="card-header">
                                            <strong class="card-title">เงินรายได้ - รายจ่าย</strong>
                                            </div>
                                            <div class="card-body">
                                                    <div class="row" style=" float: right;margin: 10px; ">
                                                        <div class="cal-sm-10"></div>
                                                       <!-- <div class="cal-sm-2"> <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#addYearEarnPay" style=" width: inherit; " >เพิ่มรายรับ/จ่ายต่อปี</button></div>-->

                                                    </div>
                                                    <div class="table-responsive">
                                                            <table class="table table-striped " id="earnpay">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" style='text-align: center;'>ลำดับ</th>
                                                                            <th scope="col"  style='text-align: center;'>ปี</th>
                                                                            <th scope="col"  style='text-align: center;'>รายได้</th>
                                                                            <th scope="col"  style='text-align: center;'>รายจ่าย</th>
                                                                            <th scope="col" >ลบ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                          <div class="card-header">
                                            <strong class="card-title">การถึอครองที่ดิน</strong>
                                          </div>
                                          <div class="card-body">
                                            <div class="form-group row">
                                                <label  class="col-sm-2 col-form-label">จำนวนแปลง</label>
                                                <div class="col-sm-4">
                                                  <input type="number" class="form-control" name="plots" placeholder="จำนวนแปลง" disabled>
                                                </div>
                                              <label  class="col-sm-2 col-form-label">จำนวนไร่</label>
                                                <div class="col-sm-4">
                                                  <input type="number" class="form-control" name="rai" placeholder="จำนวนไร่" disabled>
                                                </div>
                                              </div>
                                              <div class="form-group row">
                                                <label  class="col-sm-2 col-form-label">จำนวนงาน</label>
                                                <div class="col-sm-4">
                                                  <input type="number" class="form-control" name="ngan" placeholder="จำนวนงาน" disabled>
                                                </div>
                                              <label  class="col-sm-2 col-form-label">จำนวนตารางวา</label>
                                                <div class="col-sm-4">
                                                  <input type="number" class="form-control" name="sqaure_wa" placeholder="จำนวนตารางวา" disabled>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                        <div class="card-header">
                                          <strong class="card-title">รายละเอียดส่งมอบผลผลิต</strong>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal" action="#" method="post" id="summaryProductPlan">
                                            <input type="hidden" id="area_Id" name="area_Id" value="">
                                                <div class="form-group row">
                                                    <label for="inputext" class="col-sm-2 col-form-label">เลือกปีงบประมาณ</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"name="yearsOfPlan" id="yearsOfPlan">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputext" class="col-sm-2 col-form-label">เดือน</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control"name="summaryMonth_id" id="summaryMonth_id">
                                                            <option value='0'>กรุณาเลือก</option>
                                                            <?php
                                                                echo loadMonthOfTheYears($conn);
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row table-responsive">
                                                    <table class="table" id="dashTable">
                                                        <thead>
                                                            <tr>
                                                                <th>สาขาพืช</th>
                                                                <th>ชนิดพืช</th>
                                                                <th>ปริมาณรวม</th>
                                                                <th>ราคารวม</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                      </div>

                                        <div class="card">
                                            <div class="card-header">
                                              <strong class="card-title">ข้อมูลรายแปลง</strong>
                                            </div>
                                            <div class="card-body">
                                              <div class="form-group row">
                                                <ul class="list-group col-md-12" id="landDetail">
                                                </ul>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="card">
                                            <div class="card-header">
                                            <strong class="card-title">การเป็นสมาชิกกลุ่ม</strong>
                                            </div>
                                            <div class="card-body">
                                            <div class="form-group row">
                                                <ul class="list-group col-md-12" id="personGroup">
                                                </ul>
                                            </div>
                                        </div>
                                        </div>


                                      <div class="row">
                                              <div class="col-md-4">
                                              </div>
                                              <div class="col-md-4">
                                              </div>
                                              <div class="col-md-4">
                                                    <div class="col-md-4">
                                                       <!-- <button type="button" class="btn btn-primary" id="updatePersonBtn" style=" width: inherit; " >บันทึก</button>-->
                                                      </div>

                                                      <div class="col-md-4">
                                                          <br>
                                                      </div>

                                                      <div class="col-md-4">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style=" width: inherit;display: none; ">ยกเลิก</button>
                                                      </div>

                                              </div>
                                      </div>


                                      </div>

                                </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->

    </div> <!-- .content -->
</div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>




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

    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/js/slimselect.min.js"></script>
    <script src="../assets/js/resizeImage.js"></script>
    <script src="../assets/hrdi_js/editfarmer.js"></script>







</body>

</html>
