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
        include 'modal/addฺBankAccount.php';
        include 'modal/editBankAccount.php';



        ?>


    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn" id="main">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" style=" background-color: beige; ">
                            <div class="card">
                            <div class="card-header" >

                            <input type="hidden" value="<?php echo $_GET['sub_group_id'];?>" id="sub_group_id">

                                <div><strong class="card-title">ข้อมูลบัญชีธนาคาร <span id="sub_group_name_2"></span></strong></div>
                            </div>
                            <div class="card-body">
                            <div><button type="button" class="btn btn-primary" id="add_person" style=" float: right;margin: 10px; "   data-toggle="modal" data-target="#AddBankAccount"><i class="menu-icon fa fa-plus"> </i>  เพิ่มบัญชีธนาคาร</button> <button type="button" class="btn btn-primary" id="home" style="  float: right;margin: 10px; " >กลับหน้าหลัก</button></div>
                                <table id="bankAccountTable" class="table table-striped table-bordered " style=" text-align: center;border-left-width: 0; width: 100%;">

                                    <thead>
                                        <tr style=" border-left-width: thick; ">
                                            <th  style=" vertical-align: middle; ">เลขบัญชี</th>
                                            <th  style=" vertical-align: middle; ">ชื่อธนาคาร</th>
                                            <th  style=" vertical-align: middle; ">สถานะ</th>
                                            <th  style=" vertical-align: middle; "></th>
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
    <script src="../assets/js/bootstrap-toggle.min.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/BankAccount.js"></script>





</body>

</html>
