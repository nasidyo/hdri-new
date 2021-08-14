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

    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datepicker.css">


    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link rel="stylesheet" href="../assets/css/slimselect.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="../webcamjs/webcam.min.js"></script>
    <link rel="stylesheet" href="../assets/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">



</head>

<body>


    <!-- Left Panel -->

    <?php
     require '../connection/database.php';
     require '../service/sessionCheck.php';
    include 'navbar.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php
         include 'menuToggle.php';
              require '../util/RiverBasinDependent.php';
              require '../util/ProvinceDependent.php';
              require '../view/modal/camera.php';
              require '../view/modal/addYearEarnPay.php';

              $db = new Database();
              $conn=  $db->getConnection();
              ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>เพิ่มข้อมูลเกษตรกร</h1>
                            <input type="hidden" value="<?php echo $_SESSION['idRiverBasin'] ?>" id="idRiverBasin_session">
                             <input type="hidden" value="<?php echo $_SESSION['idarea'] ?>" id="idarea_session">
                             <input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>" id="AreaAll">
                             <input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>" id="RBAll">
                             <input type="hidden" value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">เพิ่มข้อมูลเกษตรกร</li>
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
                                <div class="col-md-8 ">
                                 <strong class="card-title">ตารางข้อมูลเกษตรกร</strong>

                                </div>

                            </div>
                            </div>


                            <div class="card">
                                <div class="card-body">
                                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="addFarmerForm">
             <div class="card-body">
               <div class="card">
                <div class="card-header">
                  <strong class="card-title">พื้นที่</strong>
                </div>
                <div class="card-body">
                  <div class="form-group row">
                  <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ <span style=" color: red; ">*</span></label>
                  <div class="col-sm-4">
                        <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                            <?php
                                echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                            ?>
                        </select>

                  </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">พื้นที่ <span style=" color: red; ">*</span></label>
                      <div class="col-sm-8">
                        <select class="form-control"name="idArea" id="area">
                                                 <?php
                                                        echo loadAreaDependentInSS($conn,$_SESSION['RBAll'],$_SESSION['AreaAll']);
                                                    ?>
                            </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ชื่อบ้าน</label>
                    <div class="col-sm-8">
                        <select class="form-control"name="idGroupVillage" id="idGroupVillage">

                        </select>
                    </div>
                </div>



                <div class="form-group row" style=" display: none; ">
                      <label class="col-sm-2 col-form-label">สาขาพืชที่ส่งเสริม</label>
                      <div class="col-sm-8">
                      <select id="argi_group_type" multiple="multiple">
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
                <div class="form-group row" style=" display: none; ">
                      <label class="col-sm-2 col-form-label">ชนิดพืชที่ส่งเสริม</label>
                      <div class="col-sm-8" style="padding: 10px 10px 10px 15px;">
                        <select id="argi_group" multiple="multiple">
                        </select>
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
                    <img class="mx-auto d-block basic-img"   style=" max-width:300px;max-height: 300px;float: left;" src='../images/noPic.jpg' >
                 </div>
                 <div class="col-sm-4">
                    <input type="file" id="file" name="file" class="form-control-file" accept="image/*" style=" height: auto; ">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#camera" style=" margin-top: 20px; "><i class="fa fa-camera"></i></button>
                 </div>


                </div>
                <div class="form-group row">
                 <label for="inputext" class="col-sm-2 col-form-label" style=" display: none; ">รหัสเกษตรกร</label>
                 <div class="col-sm-4" style=" display: none; ">
                   <input type="text" class="form-control" name="argnumber" placeholder="รหัสเกษตรกร" readonly >
                 </div>
                 <label for="inputext" class="col-sm-2 col-form-label">เลขที่บัตรประชาชน</label>
                 <div class="col-sm-4">
                   <input type="text" class="form-control" name="argid" placeholder="เลขที่บัตรประชาชน"  pattern="/^-?\d+\.?\d*$/"  onKeyPress="if(this.value.length==13) return false;"  onkeydown="javascript: return event.keyCode == 69 ? false : true" >
                 </div>
                </div>

               <div class="form-group row">
                 <label class="col-sm-2 col-form-label">ชื่อ-สกุล <span style=" color: red; ">*</span></label>
                    <div class="col-sm-2">
                     <select class="form-control"name="argpre">
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
                   <input type="text" class="form-control" name="argname" placeholder="ชื่อ"  maxlength="50">
                 </div>
                 <div class="col-sm-4">
                   <input type="text" class="form-control" name="argsurname" placeholder="นามสกุล"  maxlength="50">
                 </div>
                </div>
               <div class="form-group row">
               <!--<label  class="col-sm-2 col-form-label">ปีเกิด</label>
                 <div class="col-sm-4">

                   <input type="text" class="form-control" name="argbirth" placeholder="ปีเกิด">
                 </div>-->
                 <label for="inputext" class="col-sm-2 col-form-label" style=" text-align: end; ">ปีเกิด</label>
                    <div class="input-group date form_date col-md-3 argbirthTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="argbirth" data-link-format="dd-mm-yyyy">
                                <input class="form-control" size="14" type="text" value="" readonly>
                                <input class="form-control" size="14" type="hidden" id="argbirth" value="" readonly>
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
                   <input type="number" class="form-control" name="argzip_code" placeholder="รหัสไปรษณีย์" pattern="/^-?\d+\.?\d*$/"  onKeyPress="if(this.value.length==5) return false;"  onkeydown="javascript: return event.keyCode == 69 ? false : true">
                 </div>
                 <label  class="col-sm-1 col-form-label">จังหวัด </label>
                 <div class="col-sm-3">

                   <select class="form-control"name="argprovince" id="argprovince">
                        <?php
                          echo loadProvinceDependent($conn);
                          ?>
                        </select>
                 </div>
                 <label  class="col-sm-1 col-form-label">อำเภอ </label>
                 <div class="col-sm-3">

                   <select class="form-control"name="argdist" id="argdist">

                    </select>
                 </div>
               </div>


              <div class="form-group row">

              <label  class="col-sm-2 col-form-label">ตำบล </label>
                 <div class="col-sm-2">

                   <select class="form-control"name="argsub" id="argsub">

                      </select>
                 </div>

              <label  class="col-sm-2 col-form-label">ชื่อหมู่บ้าน</label>
                 <div class="col-sm-3">

                   <select class="form-control"name="argmoo_name" id="argmoo_name">

                    </select>
                 </div>


               </div>

               <div class="form-group row">

               <label  class="col-sm-2 col-form-label">บ้านเลขที่</label>
                 <div class="col-sm-2">
                   <input type="text" class="form-control" name="argno" placeholder="บ้านเลขที่" maxlength="100">
                 </div>

                 <label  class="col-sm-1 col-form-label">หมู่ที่</label>
                 <div class="col-sm-2">
                   <input type="number" class="form-control" name="argmoo_no" placeholder="หมู่ที่"  onkeydown="javascript: return event.keyCode == 69 ? false : true">
                 </div>
               <label  class="col-sm-1 col-form-label">หย่อม</label>
                 <div class="col-sm-2">
                   <input type="text" class="form-control" name="argsub_moo" placeholder="หย่อม"  maxlength="100">
                 </div>


               </div>

              <div class="form-group row">
              <label  class="col-sm-2 col-form-label" style=" display: none; ">ถนน</label>
                 <div class="col-sm-2">
                   <input type="text" class="form-control" name="road" placeholder="ถนน" style=" display: none; ">
                 </div>
                 <label  class="col-sm-2 col-form-label">เบอร์โทร</label>
                 <div class="col-sm-2">
                   <input type="text" class="form-control" name="argTel" placeholder="เบอร์โทร"  pattern="/^-?\d+\.?\d*$/"  onKeyPress="if(this.value.length==10) return false;" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                 </div>
                <label  class="col-sm-1 col-form-label" style=" display: none; ">อีเมล์</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" style=" display: none; " name="argEmail" placeholder="อีเมล์" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
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

                   <select class="form-control"name="occupFirst">
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

                   <select class="form-control"name="occupSecond">
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

          <div class="card" style=" display: none; ">
                                            <div class="card-header">
                                            <strong class="card-title">เงินรายได้ - รายจ่าย</strong>
                                            </div>
                                            <div class="card-body">
                                                    <div class="row" style=" float: right;margin: 10px; ">
                                                        <div class="cal-sm-10"></div>
                                                        <div class="cal-sm-2"> <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#addYearEarnPay" style=" width: inherit; " >เพิ่มรายรับ/จ่ายต่อปี</button></div>

                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="earnpay">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" style='text-align: center;'>ลำดับ</th>
                                                                            <th scope="col"  style='text-align: center;'>ปี</th>
                                                                            <th scope="col"  style='text-align: center;'>รายได้</th>
                                                                            <th scope="col"  style='text-align: center;'>รายจ่าย</th>
                                                                            <th scope="col"  >ลบ</th>
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
                    <input type="number" class="form-control" name="plots" placeholder="จำนวนแปลง" placeholder="จำนวนแปลง" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                  </div>
                <label  class="col-sm-2 col-form-label">จำนวนไร่</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" name="rai" placeholder="จำนวนไร่" placeholder="จำนวนแปลง" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                  </div>
                </div>
                <div class="form-group row">
                  <label  class="col-sm-2 col-form-label">จำนวนงาน</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" name="ngan" placeholder="จำนวนงาน" placeholder="จำนวนแปลง" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                  </div>
                <label  class="col-sm-2 col-form-label">จำนวนตารางวา</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" name="sqaure_wa" placeholder="จำนวนตารางวา" placeholder="จำนวนแปลง" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                  </div>
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
                            <button type="button" class="btn btn-primary" id="addPersonBtn" style=" width: inherit; ">บันทึก</button>
                        </div>
                        <div class="col-md-4">
                            <br>
                        </div>
                         <div class="col-md-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style=" width: inherit; ">ยกเลิก</button>
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





    <script src="../assets/hrdi_js/validationPerson.js"></script>
    <script src="../assets/js/slimselect.min.js"></script>
    <script src="../assets/hrdi_js/addfarmer.js"></script>

</body>

</html>
