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
    <title>ระบบการบริหารจัดการข้อมูลเกษตรกร</title>
    <meta name="description" content="ส่งเสริมเป้าหมายการผลิต">
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
        $db = new Database();
        $conn=  $db->getConnection();
     require '../service/sessionCheck.php';
     include 'navbar.php';


  ?>



    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php  include 'menuToggle.php';
        require '../util/alltypeOfAgri.php';
        require '../util/loadProductStandardAll.php';
        require '../util/loadCountUnit.php';
        require '../util/RiverBasinDependent.php';
        require '../util/loadAllGradeProduct.php';
        require '../util/alltypeOfTargetPlan.php';
        include 'modal/addNewAgriPlan.php';
        include 'modal/editAgriPlan.php';
        ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>ส่งเสริมเป้าหมายการผลิต</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                    <ol class="breadcrumb text-right"></ol>
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
                            <div class="card-header" >


                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                    <strong class="card-title">ส่งเสริมเป้าหมายการผลิต </strong>
                                </div>

                                <div class="col-md-4 ">
                                </div>

                            </div>
                            </div>



                            <div class="card-body ">
                                <div class="card">
                                    <!-- <div class="card-header"> -->
                                    <div class="card-header search_td style=" cursor: pointer; " data-toggle="collapse" data-target="#criteria" aria-expanded="false" aria-controls="criteria">
                                        <strong class="card-title"><i class="menu-icon fa fa-search"></i> ค้นหา</strong>
                                    </div>
                                    <div class="card-body collapse" id='criteria'>
                                    <!-- <div class="card-body"> -->
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สาขาพืช</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="typeOfAgriSearch" id="typeOfAgriSearch" style="width:100%;">
                                                    <?php echo loadAllTypeOfAgri($conn) ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">ชนิดพืช</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="idAgriSearch" id="idAgriSearch" style="width:100%;">
                                                    <option value="0">กรุณาเลือก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary " id="searchBtn"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 ">
                                                <button type="button" class="btn btn-primary" id="clearBtn"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                            </div>
                                            <div class="col-md-5">
                                            </div>
                                        </div>
                                     </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" >
                                            <strong class="card-title">ตารางส่งเสริมเป้าหมายการผลิต</strong>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary " name="addAgriPlanBtn" id="addAgriPlanBtn"><i class="menu-icon fa fa-plus"></i> เพิ่มส่งเสริมเป้าหมายการผลิต</button>
                                            </div>
                                        </div>

                                        <table class="table table-striped table-bordered" id="datalistTargetAgriUnit">
                                            <thead>
                                                <tr style=" border-left-width: thick;">
                                                    <th style="  text-align: center; ">รหัส</th>
                                                    <th style="  text-align: center; ">สาขาพืช</th>
                                                    <th style="  text-align: center; ">ชนิดพืช</th>
                                                    <th style="  text-align: center; ">หน่วยนับ</th>
                                                    <th style="  text-align: center; ">แก้ไข/ลบ</th>
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
                </div>
            </div><!-- .animated -->
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="../assets/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/hrdi_js/validationPerson.js"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/js/slimselect.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/listTargetAgriUnitJs.js"></script>






</body>

</html>
