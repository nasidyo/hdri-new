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
    <title>ระบบการบริหารจัดการด้านการเงินเกษตรกร</title>
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
    <link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
    <?php require '../connection/database.php'; ?>
    <?php require '../service/sessionCheck.php';?>

    <!-- Left Panel -->

    <?php include 'navbar.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php include 'menuToggle.php';
            require '../util/typeOfAgri.php';
            require '../util/loadMonth.php';
            require '../util/loadMarketTypeList.php';
            include 'modal/editPlanProductFromList.php';
            include 'modal/editTargetPromo.php';

            $area_Id = $_GET['area_Id'];
            $yearsId = $_GET['yearsId'];
            $actionValue = $_GET['action'];
            $permssion = $_SESSION['staffPermis'];
            $db = new Database();
            $conn=  $db->getConnection();
        ?>
        <?php
            $resultPlanStatusId = '';
            $sqlStatusPlan = "( SELECT idStatusPlan
            FROM
                SendStatusPlan_TD
            WHERE
                Area_idArea = '".$area_Id."' and YearID = '".$yearsId."'
            )";
            $resultStautsPlan = sqlsrv_query($conn, $sqlStatusPlan);
            if(sqlsrv_fetch( $resultStautsPlan )) {
                $resultPlanStatusId = sqlsrv_get_field( $resultStautsPlan, 0);
            }else{
                $resultPlanStatusId = '1';
            }
            $permssion = $_SESSION['staffPermis'];
        ?>
        <!-- <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>เพิ่มแปลงเกษตร</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">เพิ่มแปลงเกษตร</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> -->
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-10 ">
                                        <strong class="card-title">ตารางการวางแผนเป้าหมายรายได้และผลผลิต</strong>
                                    </div>
                                    <div class="col-md-2 ">
                                        <a href="yearsListOfPlan.php?area_Id=<?php echo $area_Id?>&yearsId=<?php echo $yearsId?>" class="btn btn-secondary"><i class="fa ti-angle-double-left"></i> Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <!-- <div class="card-header"> -->
                                    <div class="card-header search_td" style=" cursor: pointer; " data-toggle="collapse" data-target="#criteria" aria-expanded="false" aria-controls="criteria">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <!-- <div class="card-body" id='search'> -->
                                    <div class="card-body collapse" id='criteria'>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="typeOfAgri_idSearch" id="typeOfAgri_idSearch" style="width:100%;">
                                                    <?php
                                                        echo loadTypeOfAgri($conn, $area_Id);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ชนิดพืช</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="agriSearch" id="agriSearch" style="width:100%;">
                                                    <option value='0'>กรุณาเลือก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">เดือน</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="month_id" id="month_id" style="width:100%;">
                                                    <option value='0'>กรุณาเลือก</option>
                                                    <?php
                                                        echo loadMonthOfTheYears($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputext" class="col-sm-2 col-form-label">ช่องทางการตลาด</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="marketSearch" id="marketSearch" style="width:100%;">
                                                    <?php
                                                        echo loadMarketTypeList($conn, $area_Id);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">เป้าหมายรายได้และผลผลิตประจำปี 
                                           [ <?php
                                                $yearsName = '';
                                                $sql = "( SELECT nameYear
                                                FROM
                                                    YearTB
                                                WHERE
                                                    idYearTB = '".$yearsId."'
                                                )";
                                                $stmtYears = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmtYears )) {
                                                    $yearsName = sqlsrv_get_field( $stmtYears, 0);
                                                }

                                                echo $yearsName;
                                            ?>  ]
                                            [<?php
                                                $result = '';
                                                $sql = "( SELECT areaName
                                                FROM
                                                    Area
                                                WHERE
                                                    idArea = '".$area_Id."'
                                                )";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmt )) {
                                                    $result = sqlsrv_get_field( $stmt, 0);
                                                }

                                                echo $result;
                                            ?>]
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>">
                                        <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                                        <input type="hidden" id="permssion" name="permssion" value="<?php echo $permssion?>">
                                        <input type="hidden" id="actionValue" name="actionValue" value="<?php echo $resultPlanStatusId?>">
                                        <div class="row menubar">
                                            <?php if (($permssion == 'staff' or $permssion == 'admin' or $permssion == 'powerUserMarket') and ($resultPlanStatusId == '1' or $resultPlanStatusId == '3')) {?>
                                                <div class="col col-sm-2">
                                                    <button type="button" class="btn btn-primary " href="javascript:void(0)" id="addNewBtn" name="addNewBtn" ><i class="fa fa-edit"></i>&nbsp; เพิ่มรายการใหม่</button>
                                                </div>
                                                <div class="col col-lg-2">
                                                    <button type="button" class="btn btn-success" href="javascript:void(0)" id="sendPlanProduct" name="sendPlanProduct" ><i class="fa fa-magic"></i>&nbsp; ส่งมอบแผน</button>
                                                </div>
                                            <?php } ?>
                                            <?php if ( ($permssion == 'manager' or $permssion == 'admin' or $permssion == 'powerUserMarket') and $resultPlanStatusId == '2') {?>
                                                <div class="col col-sm-2">
                                                    <button type="button" class="btn btn-primary" href="javascript:void(0)" id="confirmBtn" name="confirmBtn" ><i class="fa fa-star"></i>&nbsp; อนุมัติแผน </button>
                                                </div>
                                                <div class="col col-lg-2">
                                                    <button type="button" class="btn btn-success" href="javascript:void(0)" id="backToEditBtn" name="backToEditBtn" ><i class="fa fa-magic"></i>&nbsp; แจ้งแก้ไขแผน</button>
                                                </div>
                                            <?php } ?>

                                            <?php if ( ($permssion == 'manager' or $permssion == 'powerUserMarket' or $permssion == 'admin') and $resultPlanStatusId == '4') {?>
                                                <div class="col col-lg-2">
                                                    <button type="button" class="btn btn-success" href="javascript:void(0)" id="backToEditBtn" name="backToEditBtn" ><i class="fa fa-magic"></i>&nbsp; แจ้งแก้ไขแผน</button>
                                                </div>
                                            <?php } ?>

                                        </div>
                                        <div class="row form-group">
                                        </div>
                                            <table id="yearOfPlanList-Table" name="yearOfPlanList-Table" class="table table-striped table-bordered dataTable">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <!-- <th></th> -->
                                                        <th><center>เลือกทั้งหมด <br/><input type="checkbox" class='checkall' id='checkall'></center></th>
                                                        <th><center>เดือน</center></th>
                                                        <th><center>สาขาพืช</center></th>
                                                        <th><center>ชนิดพืช</center></th>
                                                        <!-- <th>มาตราฐาน</th> -->
                                                        <th><center>ช่องทางตลาด</center></th>
                                                        <th><center>ผู้รับซื้อ</center></th>
                                                        <th><center>หน่วย</center></th> <!-- 10 -->
                                                        <th><center>ปริมาณ</center></th>
                                                        <th><center>ราคาต่อหน่วย</center></th>
                                                        <th><center>มูลค่ารวม</center></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><center>ลุ่มน้ำ</center></th>
                                                        <th><center>พื้นที่เป้าหมาย</center></th>
                                                        <th><center>ปี พ.ศ</center></th>
                                                        <th><center>โครงการ</center></th>
                                                        <th><center>พื้นที่</center></th>

                                                        <!-- <th>ปริมาณ</th>
                                                        <th>ราคาต่อหน่วย</th> -->

                                                        <th>จำนวน</th>
                                                        <th>พื้นที่ (ไร่)</th>
                                                        <th>โรงเรือน </th>
                                                        <th>ต้น</th>
                                                        <th>ตัว</th>
                                                        <th>ฟาร์ม</th>
                                                        <th>ปริมาณ</th>
                                                        <th>ราคาต่อหน่วย</th>

                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <!-- <tfoot style='background: beige;'>
                                                    <tr>
                                                        <th colspan="10" style="text-align:right" class="dt-header-center">ปริมาณรวม :</th>
                                                        <th></th>
                                                        <th style="text-align:right" class="dt-header-center">มูลค่ารวม :</th>
                                                        <th colspan="3"></th>
                                                    </tr>
                                                </tfoot> -->
                                            </table>
                                        <!-- <div class="row form-group" style="float: right;">
                                            <div class="col col-sm-12" id="editBtn">
                                                <button type="button" class="btn btn-primary" href="javascript:void(0)" id="editOnTableBtn" name="editOnTableBtn" ><i class="fa fa-edit"></i>&nbsp; แก้ไขทั้งหมด</button>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">สรุปการวางแผน ประจำปี 
                                            [ <?php
                                                $yearsName = '';
                                                $sql = "( SELECT nameYear
                                                FROM
                                                    YearTB
                                                WHERE
                                                    idYearTB = '".$yearsId."'
                                                )";
                                                $stmtYears = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmtYears )) {
                                                    $yearsName = sqlsrv_get_field( $stmtYears, 0);
                                                }

                                                echo $yearsName;
                                            ?>  ]
                                            [<?php
                                                $result = '';
                                                $sql = "( SELECT areaName
                                                FROM
                                                    Area
                                                WHERE
                                                    idArea = '".$area_Id."'
                                                )";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if(sqlsrv_fetch( $stmt )) {
                                                    $result = sqlsrv_get_field( $stmt, 0);
                                                }

                                                echo $result;
                                            ?>]
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <form class="form-horizontal" action="#" method="post" id="summaryProductPlan">
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="summaryTypeOfAgri_Id" id="summaryTypeOfAgri_Id">
                                                        <?php
                                                            echo loadTypeOfAgri($conn, $area_Id);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"name="summaryAgri_Id" id="summaryAgri_Id">
                                                        <option value='0'>กรุณาเลือก</option>
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
                                            <table class="table" id="dashTable">
                                                <thead>
                                                    <tr>
                                                        <th>สาขาพืช</th>
                                                        <th>ชนิดพืช</th>
                                                        <th>ประเภทตลาด</th>
                                                        <th>ปริมาณรวม</th>
                                                        <th>มูลค่ารวม</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </form>
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


    <!-- <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script> -->
    <!-- <script src="../assets/js/dashboard.js"></script> -->
    <!-- <script src="../assets/js/widgets.js"></script> -->
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.min.js"></script>
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
    <script src="../assets/hrdi_js/planProductOfyears.js"></script>
    <script src="../assets/hrdi_js/validatefield.js"></script>

    <!-- <script>
        (function($) {
            "use strict";

            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#1de9b6', '#03a9f5'],
                normalizeFunction: 'polynomial'
            });
        })(jQuery);
    </script> -->

</body>

</html>
