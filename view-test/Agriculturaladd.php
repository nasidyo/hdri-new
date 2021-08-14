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
    <link rel="stylesheet" href="../assets/css/slimselect.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../assets/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" href="../assets/css/responsive.dataTables.css">

    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../vendors/datetimepicker-master/css/bootstrap-datepicker.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


    <!-- Left Panel -->

    <?php
        require '../connection/database.php';
         require '../service/sessionCheck.php';
        
    ?>
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <h4 class="ml-3">เพิ่มแปลงเกษตรกร</h4>
                <input type="hidden" value="<?php echo $_SESSION['idRiverBasin'] ?>" id="idRiverBasin_session">
                <input type="hidden" value="<?php echo $_SESSION['idarea'] ?>" id="idarea_session">
                <input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>" id="AreaAll">
                <input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>" id="RBAll">
                <input type="hidden" value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">
            </ul>
        </nav>
        <!-- /.navbar -->

    <!-- Right Panel -->

    <div class="content-wrapper">

        <!-- Header-->
        <?php  
        include 'navbarTest.php';
        include 'menuToggle.php';
                include 'modal/addArg.php';
                include 'modal/editArg.php';
                include 'modal/addYearEarnPay.php';
                include 'modal/editYearEarnPay.php';

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
                                 <strong class="card-title">ตารางเกษตรกร</strong>

                                    <input name="idRiverBasin_taget" id="idRiverBasin_taget" type="hidden" value="<?php if (isset($_GET['idRiverBasin'])) { $idRiverBasin = (int)$_GET['idRiverBasin']; echo $idRiverBasin; } ?>" />
                                    <input name="idArea_taget" id="idArea_taget" type="hidden"  value="<?php if (isset($_GET['idArea'])) { $idArea = (int)$_GET['idArea']; echo $idArea; } ?>"/>
                                    <input name="idPerson_taget" id="idPerson_taget" type="hidden"  value="<?php if (isset($_GET['idPerson'])) { $idPerson = (int)$_GET['idPerson']; echo $idPerson; } ?>"/>

                                </div>

                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header collapsed" data-toggle="collapse" data-target="#criteria" aria-expanded="false" aria-controls="criteria">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class="card-body collapse" id='criteria'>
                                        <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                 <div class="col-sm-4">
                                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                                    <?php

                                                            echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);

                                                    ?>
                                                    </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
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
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สาขาพืช</label>
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
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ชนิดพืช</label>
                                            <div class="col-sm-8" style="padding: 10px 10px 10px 15px;">
                                            <select id="argi_group" multiple="multiple">
                                            </select>
                                        </div>


                                        </div>

                                       <!-- <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">การส่งเสริม</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="institute_id"  style="width: 100%;">

                                                        </select>

                                                    </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">กลุ่มเกษตรกร</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="isGroup" id="isGroup">
                                                    <option value=''>ทั้งหมด</option>
                                                    <option value='N'>ไม่เป็นสมาชิก</option>
                                                    <option value='Y'>เป็นสมาชิก</option>
                                                </select>
                                            </div>
                                        </div>-->
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-1" style=" text-align: center; padding-bottom: 10px; ">
                                                <button type="button"  class="btn btn-primary " id="search_person"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 " style=" text-align: center; padding-bottom: 10px; ">
                                                <button type="button"  class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                            </div>
                                            <div class="col-md-5">
                                            </div>

                                        </div>







                                </div>
                            <div class="card">
                            <div class="card-header">
                                <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <button type="button" class="btn btn-primary col-md-6" data-toggle="modal" data-target="#addFarmer"><i class="menu-icon fa fa-plus"></i>  เพิ่มเกษตรกร</button>


                                                </div>
                                            </div>
                                        <!--<div class="col-md-9">
                                            <div class="form-group row">
                                                 <label class="col-sm-2 col-form-label"></label>
                                                <div class="form-check-inline form-check">
                                                    <label for="inline-radio1" class="form-check-label ">
                                                        <input type="radio" id="inline-radio1" name="inline-radios" value="member" class="form-check-input" checked="checked">เกษตรที่ได้รับการส่งเสริม
                                                    </label>
                                                    <label for="inline-radio2" class="form-check-label ">
                                                        <input type="radio" id="inline-radio2" name="inline-radios" value="group" class="form-check-input">กลุ่มเกษตรกร
                                                    </label>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row"  id="Member">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-3 ">
                                                    <select class="form-control" id="MemberAction">

                                                        <option value=1>ได้รับการส่งเสริม</option>
                                                        <option value=2>ไม่ได้รับการส่งเสริม</option>
                                                    </select>

                                                </div>

                                            <div class="col-md-3">
                                                <button type="button" id="isMemberBt" class="btn btn-primary">ตกลง</button>
                                            </div>

                                        </div>

                                        <div class="form-group row " style="display: none;" id="MemberFarmer">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-3 ">
                                                    <select class="form-control" id="MemberFarmerAction">
                                                        <option value=1>เป็นกลุ่มเกษตรกร</option>
                                                        <option value=2>ไม่เป็นกลุ่มเกษตรกร</option>
                                                    </select>

                                                </div>

                                            <div class="col-md-3">
                                                <button type="button" id="isMemberFarmerBt" class="btn btn-primary">ตกลง</button>
                                            </div>-->

                                        </div>
                            </div>

                            <div class="card-body">
                                <table id="farmerTable" class="table table-striped table-bordered">

                                    <thead>
                                        <tr class="row">
                                           <div class="col-md-6 farmerTable_filter" style="float: right;text-align: end;">
                                                <div class="row"><label class="col-md-6" for="searchPerson">ค้นหาชื่อเกษตรกร:</label>   <input type="text" class="form-control form-control-sm col-md-6" id="searchPerson"></div>
                                            </div>

                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>เลขบัตรประจำตัว</th>
                                            <th>ชื่อ - สกุล</th>
                                            <th>พื้นที่ลุ่มน้ำ</th>
                                            <th>พื้นที่เป้าหมาย</th>
                                            <th>ชื่อบ้าน</th>
                                            <th></th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div><!-- .animated -->

        </div> <!-- .content -->
    </div><!-- /#right-panel -->
    <div id="loader"></div>

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
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/js/slimselect.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="../assets/js/dataTables.rowReorder.min.js"></script>
    <script src="../assets/js/dataTables.responsive.min.js"></script>

    <script src="../assets/js/resizeImage.js"></script>
    <script src="../assets/hrdi_js/arg.js"></script>
    <script src="adminlte/AdminLTE-master/dist/js/adminlte.js"></script>






</body>

</html>
