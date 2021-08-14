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

    <?php include 'navbar.php';?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php   //include 'header.php'; 
        
        require '../connection/database.php';
        require '../util/RiverBasinDependent.php';
        require '../util/ProvinceDependent.php';
        ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>รายรับ</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">รายรับ</li>
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
                            <div class="card-header" style=" background-color: darkolivegreen; color: white; ">
                           
                            
                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                    <strong class="card-title">รายรับ </strong>
                                </div>
                                
                                <div class="col-md-4 ">
                                </div>
                                
                            </div>
                            </div>
                            <div class="card-body " style=" background-color: olivedrab; " >
                                <div class="card">
                                    <div class="card-header" style=" cursor: pointer; " data-toggle="collapse" data-target="#criteria" aria-expanded="false" aria-controls="criteria">
                                        <strong class="card-title">ค้นหา</strong>
                                    </div>
                                    <div class=" collapse card-body multi-collapse" id='criteria'>
                                        <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">พื้นที่ลุ่มน้ำ</label>
                                                 <div class="col-sm-4">
                                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                                    <?php
                                                         echo loadRiverDependent($conn);
                                                    ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="idArea" id="area">
                                                
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ผู้ซื้อ</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="cust" id="cust">
                                                
                                                    </select>
                                            </div>
                                        </div>

                            



                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สินค้า</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="perduct" id="perduct">
                                                
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">วันที่</label>
                                            <div class="col-sm-8">
                                               <div class="col-sm-2"></div>
                                               <div class="col-sm-4"><input type="text" class="form-control" name="searchFromDate" placeholder="วันที่เริ่มต้น"></div>
                                               <div class="col-sm-4"><input type="text" class="form-control" name="searchToDate" placeholder="วันที่สิ้นสุด"></div>
                                               <div class="col-sm-2"></div>
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


                                <div class="card" >
                                    <div class="card-header" style=" cursor: pointer; " data-toggle="collapse" data-target="#income" aria-expanded="false" aria-controls="income">
                                        <strong class="card-title">เพิ่มรายรับ</strong>
                                    </div>
                                        <div class="card-body multi-collapse" id='income'>
                                        <form>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">สหกรณ์</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="areaId" placeholder="สหกรณ์">
                                                    </div>

                                                <label class="col-sm-2 col-form-label">วันที่</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="date" placeholder="">
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">ได้รับเงินจากสมาชิก</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="custmer" placeholder="">
                                                    </div>
                                              
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">รับเงินจากมิใช่สมาชิก</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="custmer" placeholder="">
                                                    </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">สินค้า</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control"name="perduct" id="perduct">
                                                    
                                                        </select>
                                                </div>
                                                <label class="col-sm-1 col-form-label">คลัง :45</label>


                                                <label class="col-sm-1 col-form-label">จำนวน</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" class="form-control" name="custmer" placeholder="">
                                                    </div>
                                                  

                                                <label class="col-sm-1 col-form-label">ราคา</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="custmer" placeholder="">
                                                    </div>
                                                    <button type="button" class="btn btn-primary col-sm-1" id="clear_person"><i class="menu-icon fa fa-add"> </i>  เพิ่ม</button>      
                                                    
                                               
                                            </div>

                                            <div class="form-group row" style="border: 1px solid rgba(0,0,0,.125);border-radius: 1rem;padding-top: 20px;">
                                                <div class="col-sm-4">
                                                    <div class="card">
                                                    <div class="card-header-td">
                                                        <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true" style=" color: red; ">&times;</span>
                                                                </button>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="stat-widget-one">
                                                                <div class="stat-content dib">
                                                                
                                                                    <div class="stat-digit">อาหารหมูเนื้อ (กระสอบ)</div>
                                                                    <div class="">จำนวน 5 หน่วย</div>
                                                                    <div class="">ราคา 300 บาท</div>
                                                                    <div class="">รวม 1,500 บาท</div>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="card">
                                                        <div class="card-header-td">
                                                        <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true" style=" color: red; ">&times;</span>
                                                                </button>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="stat-widget-one">
                                                                
                                                                <div class="stat-content dib">
                                                                    <div class="stat-digit">อาหารไก่ไข 100M (กระสอบ)</div>
                                                                    <div class="">ราคา 390 บาท</div>
                                                                    <div class="">จำนวน 7 หน่วย</div>
                                                                    <div class="">รวม 2,730 บาท</div>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-5">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-primary " id="search_person"><i class="menu-icon fa fa-search"></i>  บันทึก</button>
                                                </div>
                                                <div class="col-md-1 ">
                                                    <button type="button" class="btn btn-primary" id="clear_person"><i class="menu-icon fa fa-refresh"> </i>  ล้าง</button>
                                                </div>
                                                <div class="col-md-5">
                                                </div>

                                            </div>
                                        </form>

                                        
                                    </div>
                                       
                                </div>
                                


                            <div class="card">
                            <div class="card-body">


                                        <table id="cooperativeTable" class="table table-striped table-bordered" style=" text-align: center;border-left-width: 0; ">
                                            <thead>
                                                <tr style=" border-left-width: thick; ">
                                                    <th style=" vertical-align: middle; ">วันที่</th>
                                                    <th  style=" vertical-align: middle; ">เลขที่เอกสาร</th>
                                                    <th  style=" vertical-align: middle; ">รายการ</th>
                                                    <th  style=" vertical-align: middle; "> ราคา</th>
                                                    <th  style=" vertical-align: middle; "> จำนวน</th>
                                                    <th  style=" vertical-align: middle; "> เป็นเงิน</th>
                                                    <th  style=" vertical-align: middle; "> ผู้รับเงิน</th>
                                                    <th style=" vertical-align: middle; "> หมายเหตุ</th>
                                                </tr>
                                            
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>18/08/60</td>
                                                    <td>ก 01</td>
                                                    <td>อาหารหมูเนื้อ (กระสอบ)</td>
                                                    <td>300</td>
                                                    <td>5</td>
                                                    <td>1500</td> 
                                                    <td>นาย xxxx xxxx</td>
                                                    <td> - </td>
                                                </tr>
                                                <tr>
                                                    <td>18/08/60</td>
                                                    <td>ก 02</td>
                                                    <td>อาหารไก่ไข 100M  (กระสอบ)</td>
                                                    <td>390</td>
                                                    <td>7</td>
                                                    <td>2,730</td> 
                                                    <td>นาย xxxx xxxx</td>
                                                    <td> - </td>
                                                </tr>
                                            
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

    <!-- Right Panel -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>


    <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/widgets.js"></script>
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
    <script src="../assets/js/slimselect.min.js"></script>
    <script src="../assets/hrdi_js/cooperativeJS/cooperative.js"></script>
    
 
   



</body>

</html>
