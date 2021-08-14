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
        <?php   include 'menuToggle.php';
        require '../util/RiverBasinDependent.php';
        include '../view/modal/addInsitute.php'  ;
        include '../view/modal/editInsitute.php'
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
                                    <strong class="card-title">บริหารจัดการข้อมูลสถาบัน </strong>
                                    <input type="hidden" value="<?php echo $_SESSION['idRiverBasin'] ?>" id="idRiverBasin_session">
                                    <input type="hidden" value="<?php echo $_SESSION['idarea'] ?>" id="idarea_session">
                                    <input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>" id="AreaAll">
                                    <input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>" id="RBAll">
                                    <input type="hidden" value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">
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
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary " id="search_person"><i class="menu-icon fa fa-search"></i>  ค้นหา</button>
                                            </div>
                                            <div class="col-md-1 ">

                                            </div>
                                            <div class="col-md-5">
                                            </div>

                                        </div>


                                </div>
                            <div class="card">
                            <div class="card-body">

                                        <button type="button" class="btn btn-primary" id="addInstitute" data-toggle="modal" data-target="#addInstitute"><i class="menu-icon fa fa-plus"> </i>  เพื่มสถาบัน</button>
                                        <table id="InstituteTable" class="table table-striped table-bordered" style=" text-align: center;border-left-width: 0; ">
                                            <thead>
                                                <tr style=" border-left-width: thick; ">
                                                    <th style=" vertical-align: middle; ">รหัส</th>
                                                    <th style=" vertical-align: middle; ">ลุ่มน้ำ</th>
                                                    <th  style=" vertical-align: middle; ">พื้นที่</th>
                                                    <th  style=" vertical-align: middle; ">สถาบันเกษตรกร</th>
                                                    <th style=" vertical-align: middle; ">แก้ไข/ลบ</th>

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
    <script src="../assets/hrdi_js/cooperativeJS/institute.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/addinstitute.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/editinstitute.js"></script>


</body>

</html>
