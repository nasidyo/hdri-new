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
    <title>การจัดกลุ่มเกษตรกร</title>
    <meta name="description" content="การจัดกลุ่มเกษตรกร">
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
    <link rel="stylesheet" href="../assets/css/bootstrap-switch.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-toggle.min.css">

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
        require '../util/loadPersonFromAgri.php';

        require 'modal/confirmMember.php';

        ?>

        <div class="breadcrumbs">
            <div class="col-sm-8">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>การจัดสมาชิก <span id="sub_group_name"></span></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">

                            <input type="hidden" value="<?php echo$_SESSION['idStaff'];?>" id="idStaff">
                            <input type="hidden" value="<?php echo $_GET['sub_group_id'];?>" id="sub_group_id">
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn" id="main">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #f3e97a;color: black;">


                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                    <strong class="card-title">การจัดสมาชิก</strong>
                                    <input type="hidden" value="<?php echo $_GET['institute_id'] ?>" id="institute_id">
                                    <input type="hidden" value="<?php echo $_GET['idArea'] ?>" id="idArea">
                                </div>

                            </div>
                            </div>

                            <div class="card-body" style=" background-color: beige; ">
                                <div class="card">
                                <div class="card-header" style=" cursor: pointer; " data-toggle="collapse" data-target="#criteria" aria-expanded="false" aria-controls="criteria">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class="card-body multi-collapse show" id='criteria'>

                                    <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">ชื่อ-สกุล</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"name="person_group_name" id="person_group_name"  style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">สถานะ</label>
                                            <div class="col-sm-8">
                                                <select id="status" class="form-control">
                                                    <option value="N">ทั้งหมด</option>
                                                    <option value="Y">เป็นสมาชิก</option>

                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group row">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary " id="search_person"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 ">
                                                <button type="button" class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                            </div>
                                            <div class="col-md-1 ">
                                                <button type="button" class="btn btn-primary" id="home"><i class="menu-icon fa fa-back"> </i> กลับหน้าหลัก</button>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                </div>


                            <div class="card">
                            <div class="card-header" >
                                        <strong class="card-title">ตารางแสดงข้อมูล <span id="sub_group_name_2"></span></strong>
                                    </div>
                            <div class="card-body">
                                <table id="PersonTable" class="table table-striped table-bordered " style=" text-align: center;border-left-width: 0; width: 100%;">

                                    <thead>
                                        <tr style=" border-left-width: thick; ">
                                            <th  style=" vertical-align: middle; ">เลขบัตรประจำตัวประชาชน</th>
                                            <th  style=" vertical-align: middle; ">ชื่อ - สกุล</th>
                                            <th  style=" vertical-align: middle; ">จำนวนหุ้น</th>
                                            <th  style=" vertical-align: middle; ">เงินฝากออมทรัพย์</th>
                                            <th  style=" vertical-align: middle; ">สถานะ</th>
                                            <th  style=" vertical-align: middle; "></th>
                                            <th  style=" vertical-align: middle; ">ข้อมูลเกษตรกร</th>



                                        </tr>

                                    </thead>

                                </table>



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

    <script src="../assets/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/hrdi_js/validationPerson.js"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/switchJS/bootstrap-switch.js"></script>
    <script src="../assets/js/bootstrap-toggle.min.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/PersonGroupMapping.js"></script>





</body>

</html>
