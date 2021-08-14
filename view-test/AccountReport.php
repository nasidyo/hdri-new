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
        <?php   //include 'header.php';
            require '../util/RiverBasinDependent.php';
            $db = new Database();
            $conn=  $db->getConnection();
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
                                        <strong class="card-title">งบแสดงฐานะการเงิน</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class="card-body" id='criteria'>
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
                                            <label class="col-sm-2 col-form-label">ปีบัญชี</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="account_year_id"  style="width: 100%;">


                                                        </select>
                                                    </div>
                                        </div>

                                        <div class="form-group row justify-content-md-center">

                                            <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" id="search">ค้นหา</button>
                                                    <button  type="button" class="btn btn-primary" onClick="window.location.reload();">ล้าง</button>
                                                </div>

                                        </div>



                                    </div>
                            </div>

                            <div id="report">
                            <div class="card"  >
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <div class="col-md-8 ">
                                            <strong class="card-title">งบแสดงฐานะการเงิน</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                        <table id="AccountTable" class="table table-bordered dataTable no-footer" style="text-align: center; border-left-width: 0px; width: 1115px;" role="grid" aria-describedby="AccountTable_info">
                                            <thead>
                                                <tr style=" border-left-width: thick; " role="row">
                                                <th style="vertical-align: middle; width: 76px;" class="sorting_desc" tabindex="0" aria-controls="AccountTable" rowspan="1" colspan="1" aria-sort="descending" aria-label="รหัส: activate to sort column ascending">รายการ</th>
                                                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="AccountTable" rowspan="1" colspan="1" aria-label="พื้นที่ลุ่มน้ำ: activate to sort column ascending">บาท</th>

                                            </thead>


                                         <tbody>
                                             <tr role="row">
                                                <td style="font-weight: 900;text-align: end;">สินทรัพย์</td>
                                                <td class="numItem" t="s"></td>
                                            </tr>
                                            <tr role="row">
                                                <td   style="text-align: start;" >เงินสดและเงินฝากธนาคร</td>
                                                <td class="numItem" t="s"><span id="money"></span></td>
                                            </tr>
                                            <tr role="row">
                                                <td  style="text-align: start;">ลูกหนี้ระยะสั้น - สุทธิ</td>
                                                <td class="numItem" t="s"><span id="inc_debt"></span></td>
                                            </tr>
                                            <tr role="row">
                                                <td style="font-weight: 900;text-align: center;">รวมทรัพย์สินหมุนเวียน</td>
                                                <td class="numItem" t="s"></td>
                                            </tr>

                                            <tr role="row">
                                                <td style="font-weight: 900;text-align: end;">หนี้สินและทุนของสหกรณ์</td>
                                                <td class="numItem" t="s"></td>
                                            </tr>

                                            <tr role="row">
                                                <td style="text-align: start;">เจ้าหนี้การค้า</td>
                                                <td  class="numItem" t="s"><span id="ex_debt"></span></td>
                                            </tr>

                                            <tr role="row">
                                                <td style="font-weight: 900;text-align: end;">ทุนของสหกรณ์</td>
                                                <td class="numItem" t="s"></td>
                                            </tr>
                                            <tr role="row">
                                                <td style="text-align:start;">ทุนเรือนหุ้น ( มูลค่าหุ้นละ 10.00 บาท)</td>
                                                <td class="numItem" t="s"></td>
                                            </tr>
                                            <tr role="row">
                                                <td style="text-align:start;">หุ้นที่ชำระเต็มมูลค่าแล้ว</td>
                                                <td class="numItem" t="s"><span id="stocksValue"></span></td>
                                            </tr>
                                            <tr role="row">
                                                <td style="text-align:start;">เงินฝากออมทรัพย์</td>
                                                <td class="numItem" t="s"><span id="savingValue"></span></td>
                                            </tr>

                                            <tr role="row">
                                                <td style="font-weight: 900;text-align: end;">รวมทรัพย์สิน </td>
                                                <td class="numItem" t="s"><span id="other_net"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <div class="col-md-8 ">
                                            <strong class="card-title">งบกำไรขาดทุน</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                        <table id="MoneyTable" class="table table-bordered dataTable no-footer" style="text-align: center; border-left-width: 0px; width: 1115px;" role="grid" aria-describedby="MoneyTable_info">
                                            <thead>
                                                <tr style=" border-left-width: thick; " role="row">
                                                <th style="vertical-align: middle; width: 76px;" class="sorting_desc" tabindex="0" aria-controls="MoneyTable" rowspan="1" colspan="1" aria-sort="descending" aria-label=" activate to sort column ascending">รายการ</th>
                                                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="MoneyTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">ธุระกิจ</th>
                                                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="MoneyTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">บาท</th>
                                                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="MoneyTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">%</th>

                                            </thead>


                                         <tbody>
                                             <tr role="row">
                                                <td style="font-weight: 900;text-align: end;">ขาย/บริการ</td>
                                                <td class="numItem" t="s"></td>
                                                <td class="numItem" t="s"><span id="income_all"></span></td>
                                                <td class="numItem" t="s"><span id="allPer"></span></td>
                                            </tr>
                                            <tr role="row"   >
                                                <td style="text-align: start;">ต้นทุน</td>
                                                <td class="numItem" t="s"></td>
                                                <td class="numItem" t="s"><span id="expense_all"></span></td>
                                                <td class="numItem" t="s"><span id="exPer"></span></td>
                                            </tr>
                                            <tr role="row" >
                                                <td style="text-align: start;">กำไรขั้นต้น</td>
                                                <td class="numItem"></td>
                                                <td class="numItem" t="s"><span id="diff"></span></td>
                                                <td class="numItem" t="s"><span id="diffPer"></span></td>
                                            </tr>
                                            <tr role="row">
                                                <td  style="text-align: end;" ><span style="font-weight: 900;text-align: start;">รายได้เฉพาะธุรกิจ</span></td>
                                                <td  style="text-align: end;" id="bg_name1" s="alignment: { wrapText: '1' }"></td>
                                                <td class="numItem" t="s"><span id="incomePer" s="alignment: { wrapText: '1' }"></span></td>
                                                <td class="numItem" t="s"><span id="incomePerGB" s="alignment: { wrapText: '1' }"></span></td>
                                            </tr>
                                            <tr role="row" >
                                                <td style="text-align: end;" ><span style="font-weight: 900;text-align: start;">รายจ่ายเฉพาะธุรกิจ</span></td>
                                                <td  style="text-align: end;" id="bg_name2"></td>
                                                <td class="numItem" t="s"><span id="expense"></span></td>
                                                <td class="numItem" t="s"><span id="exPerGB"></span></td>
                                            </tr>
                                            <tr role="row" >
                                                <td style="text-align: end;"><span style="font-weight: 900;text-align: start;">กำไรเฉพาะธุรกิจ</span></td>
                                                <td  style="text-align: end;" id="bg_name3"></td>
                                                <td class="numItem" t="s"><span id="diff_am"></span></td>
                                                <td class="numItem" t="s"><span id="diff_amP"></span></td>
                                            </tr>
                                            <tr role="row" >
                                                <td style="text-align: end;" ><span style="font-weight: 900;text-align: start;">รายได้อื่น</span></td>
                                                <td  style="text-align: end;" id="bg_name4"></td>
                                                <td class="numItem" t="s"><span id="incomeOther"></span></td>
                                                <td class="numItem" t="s"><span id="incomeOtherP"></span></td>
                                            </tr>
                                            <tr role="row" >
                                                <td style="text-align: end;" ><span style="font-weight: 900;text-align: start;">ค่าใช้จ่ายในการดำเนินงาน</span></td>
                                                <td  style="text-align: end;" id="bg_name5"></td>
                                                <td class="numItem" t="s"><span id="expenseOther"></span></td>
                                                <td class="numItem" t="s"><span id="expenseOtherP"></span></td>
                                            </tr>
                                            <tr role="row" style="font-weight: 900;text-align: end;">
                                                <td >กำไรสุทธิ</td>
                                                <td  style="text-align: end;"></td>
                                                <td class="numItem" t="s"><span id="result"></span></td>
                                                <td class="numItem" t="s"><span id="resultP"></span></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="detail">


                            </div>

                            <div id="incOtherPerBG">


                            </div>
                            <div id="exOtherPerBG">


                            </div>
                            <div id="incOther">


                            </div>
                            <div id="exOther">


                            </div>
                        </div>

                            <div class="form-group row justify-content-md-center">

                                <div class="col-md-3">
                                     <button type="button" class="btn btn-primary" id="export">Export</button>


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

    <script src="../assets/tableExport/tableExport.js"></script>
    <script type="text/javascript" src="/assets/tableExport/jquery.base64.js"></script>


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
    <script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/cpexcel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/cpexcel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/shim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.core.min.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.extendscript.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.extendscript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.min.map"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.mini.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.mini.min.map"></script>-->

    <script src="../assets/hrdi_js/AccountReport/accountReport.js"></script>
</body>

</html>
