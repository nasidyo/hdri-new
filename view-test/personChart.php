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

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <h4 class="ml-3">จัดการข้อมูลเกษตรกร</h4>
    </ul>
  </nav>
  <!-- /.navbar -->

    <?php ;

    require '../connection/database.php';
    require '../service/sessionCheck.php';
    include 'navbarTest.php';
    require '../util/RiverBasinDependent.php';
    $db = new Database();
    $conn=  $db->getConnection();
    ?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div class="content-wrapper">

    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">ภาพรวม</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                    <div class="card" style=" font-size: smaller; ">
                                            <div class="card-body">
                                            <?php
                                             $plots=0;
                                             $rai=0;
                                                $sql2=" SELECT ";
                                                $sql2.="FORMAT( SUM( CONVERT( INT, ISNULL(l.unit1, 0 ))),'###,###,###' )plots , ";
                                                $sql2.=" FORMAT(SUM( CONVERT( INT, ISNULL( l.unit2, 0 )))+(SUM( CONVERT( INT, ISNULL( l.unit3, 0 )))/4)+(SUM( CONVERT( INT, ISNULL( l.unit4, 0 )))/400),'###,###,###' ) rai ";
                                                $sql2.="  FROM ";
                                                $sql2.="  Land_TD l  ";

                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

                                                    $plots=$row["plots"];
                                                    $rai=$row["rai"];
                                                }
                                            ?>
                                                <div class="stat-widget-one">
                                                    <div class="stat-icon dib"><i class="ti-direction text-primary border-primary"></i></div>
                                                        <div class="stat-content dib">
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large" step="any">พื้นที่ทั้งหมด : <?php echo $plots.'  แปลง' ?></div>
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large" step="any">จำนวน : <?php echo $rai.'  ไร่' ?></div>

                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="card" style=" font-size: smaller; ">
                                            <div class="card-body">
                                            <?php
                                             $member=0;
                                             $person=0;
                                             $percent=0;
                                                $sql2="  SELECT DISTINCT ";
                                                $sql2 .="     FORMAT( ";
                                                $sql2 .="    ( ";
                                                $sql2 .="        SELECT COUNT(p.idPerson) all_member FROM RiverBasin r LEFT JOIN Person_TD p ON r.idRiverBasin = p.RiverBasin_idRiverBasin ";
                  
                                      
                                                $sql2 .="           ),'###,###,###')       AS person , ";
                                                $sql2 .="    FORMAT(COUNT ( p.idPerson ) ,'###,###,###') AS member , ";
                                                $sql2 .="    FORMAT( CAST ( ROUND( (COUNT(p.idPerson)* 100.0 / ";
                                                $sql2 .="    ( ";
                                                $sql2 .="        SELECT ";
                                                $sql2 .="            COUNT(*) ";
                                                $sql2 .="        FROM ";
                                                $sql2 .="            Person_TD )) ,2) AS DECIMAL(18,2) ),'##.##' ) AS percentTD ";
                                                $sql2 .="    FROM ";
                                                $sql2 .="        RiverBasin rb ";
                                                $sql2 .="    LEFT JOIN ";
                                                $sql2 .="        Area a ";
                                                $sql2 .="    ON ";
                                                $sql2 .="        rb.idRiverBasin =a.RiverBasin_idRiverBasin ";
                                                $sql2 .="    LEFT JOIN ";
                                                $sql2 .="        RegisterAgri_TD ra ";
                                                $sql2 .="    ON ";
                                                $sql2 .="        a.idArea = ra.idArea ";
                                                $sql2 .="    LEFT JOIN ";
                                                $sql2 .="        Person_TD p ";
                                                $sql2 .="    ON ";
                                                $sql2 .="        ra.idPerson = p.idPerson ";

                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                    $member=$row["member"];
                                                    $person=$row["person"];
                                                    $percent=$row["percentTD"];
                                                }
                                            ?>
                                                <div class="stat-widget-one">
                                                    <div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
                                                        <div class="stat-content dib">
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large">เกษตรกรทั้งหมด : <?php echo $person.'  คน' ?></div>
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large">เกษตรกรที่ได้รับการส่งเสริม : <?php echo $member.'  คน' ?></div>
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large">ร้อยละ : <?php echo $percent ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card" style=" font-size: smaller; ">
                                            <div class="card-body">
                                            <?php
                                             $member=0;
                                             $person=0;
                                             $percent=0;
                                                $sql2=" SELECT ";
                                                $sql2 .="  (  ";
                                                $sql2 .="      SELECT  ";
                                                $sql2 .="          FORMAT( COUNT ( idPerson),'###,###,###' ) FROM RiverBasin r LEFT JOIN Person_TD p ON r.idRiverBasin = p.RiverBasin_idRiverBasin ) AS person ,  ";
                                                $sql2 .="  FORMAT(  ";
                                                $sql2 .="  (  ";
                                                $sql2 .="      SELECT  ";
                                                $sql2 .="          COUNT(t.person_id)  ";
                                                $sql2 .="      FROM  ";
                                                $sql2 .="          (  ";
                                                $sql2 .="              SELECT DISTINCT  ";
                                                $sql2 .="                  pg.person_id  ";
                                                $sql2 .="              FROM  ";
                                                $sql2 .="                  PersonGroup_TD pg ,  ";
                                                $sql2 .="                  INSTITUTE ins,  ";
                                                $sql2 .="                  Area a ,  ";
                                                $sql2 .="                  RiverBasin rb  ";
                                                $sql2 .="              WHERE  ";
                                                $sql2 .="                  pg.institute_id = ins.INSTITUTE_ID  ";
                                                $sql2 .="             AND ins.AREA_ID = a.idArea  ";
                                                $sql2 .="              AND a.RiverBasin_idRiverBasin = rb.idRiverBasin ) AS t ),'###,###,###' ) AS member  ";
                                                $sql2 .="  ,  ";
                                                $sql2 .="  FORMAT( CAST ( ROUND( (  ";
                                                $sql2 .="                           (  ";
                                                $sql2 .="                           SELECT  ";
                                                $sql2 .="                               COUNT(t.person_id)  ";
                                                $sql2 .="                           FROM  ";
                                                $sql2 .="                               (  ";
                                                $sql2 .="                                   SELECT DISTINCT  ";
                                                $sql2 .="                                       pg.person_id  ";
                                                $sql2 .="                                   FROM  ";
                                                $sql2 .="                                       PersonGroup_TD pg ,  ";
                                                $sql2 .="                                       INSTITUTE ins,  ";
                                                $sql2 .="                                       Area a ,  ";
                                                $sql2 .="                                       RiverBasin rb  ";
                                                $sql2 .="                                   WHERE  ";
                                                $sql2 .="                                       pg.institute_id = ins.INSTITUTE_ID  ";
                                                $sql2 .="                                   AND ins.AREA_ID = a.idArea  ";
                                                $sql2 .="                                   AND a.RiverBasin_idRiverBasin = rb.idRiverBasin ) AS t ) *  ";
                                                $sql2 .="                         100.0 /  ";
                                                $sql2 .="                         (  ";
                                                $sql2 .="                             SELECT  ";
                                                $sql2 .="                                 COUNT(*)  ";
                                                $sql2 .="                             FROM  ";
                                                $sql2 .="                                 Person_TD )) ,2) AS DECIMAL(18,2) ),'##.##' ) AS percentTD  ";
                                                $sql2 .="  FROM  ";
                                                $sql2 .="      Person_TD p1  ";

                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                    $member=$row["member"];
                                                    $person=$row["person"];
                                                    $percent=$row["percentTD"];
                                                }
                                            ?>
                                                <div class="stat-widget-one">
                                                    <div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
                                                        <div class="stat-content dib">
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large">เกษตรกรทั้งหมด : <?php echo $person.'  คน' ?></div>
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large">เป็นสมาชิกกลุ่ม : <?php echo $member.'  คน' ?></div>
                                                            <div class="text-muted text-uppercase font-weight-bold font-lg large">ร้อยละ : <?php echo $percent ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card">
                    <div class="card-body">
                         <div class="form-group row">
                            <label for="inputext" class="col-sm-2 col-form-label text-muted text-uppercase font-weight-bold font-lg large">ลุ่มน้ำ</label>
                                <div class="col-sm-4">
                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                        <?php  echo loadRiverDependent($conn);?>
                                    </select>
                                </div>
                            </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">สัดส่วนจำนวนเกษตรกรจากที่ดินรายแปลงกับเกษตรกรที่ได้รับการส่งเสริม</strong>
                            </div>
                            <div class="card-body">

                            <div class="default-tab">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-profile-tabM" data-toggle="tab" href="#nav-profileM" role="tab" aria-controls="nav-profile" aria-selected="false">ตารางแสดงสัดส่วนจำนวนเกษตรกรกับเกษตรกรที่ได้รับการส่งเสริม</a>
                                            <a class="nav-item nav-link " id="nav-home-tabM" data-toggle="tab" href="#nav-homeM" role="tab" aria-controls="nav-home" aria-selected="true">กราฟแสดงสัดส่วนจำนวนเกษตรกรกับเกษตรกรที่ได้รับการส่งเสริม</a>


                                        </div>
                                    </nav>
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">

                                    <div class="tab-pane fade show active" id="nav-profileM" role="tabpanel" aria-labelledby="nav-profile-tabM">
                                        <table class="table" id="dashTableM">
                                            <thead>

                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        </div>

                                        <div class="tab-pane fade" id="nav-homeM" role="tabpanel" aria-labelledby="nav-home-tabM">
                                            <canvas id="barChartM"></canvas>
                                        </div>


                                    </div>

                                </div>





                            </div>
                        </div>
                    </div><!-- /# column -->
                </div>



                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">สัดส่วนจำนวนเกษตรกรจากที่ดินรายแปลงกับเกษตรกรที่เป็นสมาชิกกลุ่ม</strong>
                            </div>
                            <div class="card-body">

                            <div class="default-tab">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                         <a class="nav-item nav-link active" id="nav-profile-tabG" data-toggle="tab" href="#nav-profileG" role="tab" aria-controls="nav-profileG" aria-selected="false">ตารางแสดงสัดส่วนจำนวนเกษตรกรกับเกษตรกรที่เป็นสมาชิกกลุ่ม</a>
                                         <a class="nav-item nav-link " id="nav-home-tabG" data-toggle="tab" href="#nav-homeG" role="tab" aria-controls="nav-homeG" aria-selected="true">กราฟแสดงสัดส่วนจำนวนเกษตรกรกับเกษตรกรที่เป็นสมาชิกกลุ่ม</a>


                                        </div>
                                    </nav>
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">

                                    <div class="tab-pane fade show active" id="nav-profileG" role="tabpanel" aria-labelledby="nav-profile-tabG">
                                        <table class="table" id="dashTableG">
                                            <thead>

                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        </div>

                                        <div class="tab-pane fade" id="nav-homeG" role="tabpanel" aria-labelledby="nav-home-tabG">
                                            <canvas id="barChartG"></canvas>
                                        </div>


                                    </div>

                                </div>





                            </div>
                        </div>
                    </div><!-- /# column -->
                </div>


            </div><!-- .animated -->

        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->
</div>
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
    <script src="../vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="../assets/hrdi_js/chartFamer.js"></script>
    <script src="adminlte/AdminLTE-master/dist/js/adminlte.js"></script>

    <!-- dataTable -->
   <!-- <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>-->

     <!--  Chart js -->





</body>

</html>
