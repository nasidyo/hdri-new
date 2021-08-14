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
    <link rel="stylesheet" href="adminlte/AdminLTE-master/dist/css/adminlte.css">
    <link rel="stylesheet" href="adminlte/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../vendors/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="../assets/css/hrdi.css">   
    <link rel="stylesheet" href="../assets/css/slimselect.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../assets/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">
    <link rel="stylesheet" href="../assets/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="./adminlte/AdminLTE-master/dist/css/style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


    <!-- Left Panel -->

    <?php
         require '../connection/database.php';
         require '../service/sessionCheck.php';
        include 'navbarTest.php';
        if($conn==""){
            $db = new Database();
            $conn=  $db->getConnection();
        }
    ?>

    <!-- Left Panel -->
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <h4 class="ml-3">บริหารจัดการปีบัญชี</h4>
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
        <?php   include 'menuToggle.php';
        require '../util/RiverBasinDependent.php';
        include '../view/modal/addAccountYear.php'  ;
        include '../view/modal/EditAccountYear.php'
              ?>

    <!-- .content -->
    <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style=" background-color: darkolivegreen; color: white; ">


                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                    <strong class="card-title">บริหารจัดการปีบัญชี </strong>
                                </div>

                                <div class="col-md-4 ">
                                </div>

                            </div>
                            </div>
                            <div class="card-body " style=" " >
                                <div class="card">
                                <div class="card-header" style=" cursor: pointer; " data-toggle="collapse" data-target="#criteria" aria-expanded="true" aria-controls="criteria">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class=" collapse card-body multi-collapse show" id='criteria'>
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
                                                <select class="form-control"name="idArea" id="idArea">
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
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary " id="search_person"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 ">
                                                <button type="button" class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                            </div>
                                            <div class="col-md-5">
                                            </div>

                                        </div>


                                </div>
                            <div class="card">
                            <div class="card-body">

                                        <button type="button" style=" float: right; margin-bottom: 10px; " class="btn btn-primary" id="AddAccountYear" data-toggle="modal" data-target="#AddAccountYear"><i class="menu-icon fa fa-plus"> </i>  เพื่มปีบัญชี</button>
                                        <table id="AccountYearTable" class="table table-striped table-bordered" style="text-align: center;border-left-width: 0px;width: 100%; ">
                                            <thead>
                                                <tr style=" border-left-width: thick; ">
                                                    <th  style=" vertical-align: middle; ">ปีบัญชี</th>
                                                    <th  style=" vertical-align: middle; ">พื้นที่</th>
                                                    <th  style=" vertical-align: middle; ">เงินสด</th>
                                                    <th  style=" vertical-align: middle; ">เงินในธนาคาร</th>
                                                    <th  style=" vertical-align: middle; ">จำนวนหุ้น</th>
                                                    <th  style=" vertical-align: middle; ">มูลค่าหุ้น</th>
                                                    <th  style=" vertical-align: middle; ">สถานะ</th>
                                                    <th style=" vertical-align: middle; ">แก้ไข/โครงสร้าง</th>
                                                    <th style=" vertical-align: middle; "></th>
                                                </tr>
                                            </thead>


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
</div>
    <!-- Right Panel -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
    <!-- dataTable -->
    <script src="../assets/hrdi_js/moment.min.js"></script>
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="../assets-test/hrdi_js/cooperativeJS/accountYear.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/addAccountYear.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/editAccountYear.js"></script>
    <script src="adminlte/AdminLTE-master/dist/js/adminlte.js"></script>

</body>

</html>
