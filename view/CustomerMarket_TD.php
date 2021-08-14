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
<title>การจัดการข้อมูลผู้รับซื้อ</title>
<meta name="description" content="การจัดการข้อมูลผู้รับซื้อ">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="apple-touch-icon" href="apple-icon.png">
<link rel="shortcut icon" href="favicon.ico">

<link rel="stylesheet"
	href="../vendors/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet"
	href="../vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet"
	href="../vendors/themify-icons/css/themify-icons.css">
<link rel="stylesheet"
	href="../vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet"
	href="../vendors/selectFX/css/cs-skin-elastic.css">
<link rel="stylesheet" href="../vendors/jqvmap/dist/jqvmap.min.css">
<link rel="stylesheet"
	href="../vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">


<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/hrdi.css">
<link rel="stylesheet" href="../assets/css/slimselect.min.css">
<link
	href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800'
	rel='stylesheet' type='text/css'>
<link rel="stylesheet"
	href="../assets/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="../vendors/select2/dist/css/select2.css">

</head>

<body>


	<!-- Left Panel -->

    <?php
    require '../connection/database.php';
    // if ($conn == null) {
        $db = new Database();
        $conn = $db->getConnection();
    // }
    require '../service/sessionCheck.php';
    include 'navbar.php';
   

    ?>



    <!-- Left Panel -->

	<!-- Right Panel -->

	<div id="right-panel" class="right-panel">

		<!-- Header-->
		
        <?php
        include 'menuToggle.php';
        // include 'header.php';
        require '../util/loadPersonFromAgri.php';
        require '../util/RiverBasinDependent.php';
        require '../util/ProvinceDependent.php';

        include 'modal/addCustomerMarketTD.php';
        include 'modal/editCustomerMarketTD.php';

        ?>

        <div class="breadcrumbs">
			<div class="col-sm-4">
				<div class="page-header float-left">
					<div class="page-title">
						<h1>จัดการตลาดและพื้นที่</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							
							<input type="hidden" value="<?php echo$_SESSION['idStaff']?>"
								id="idStaff">
							<input type="hidden"
								value="<?php echo $_SESSION['idRiverBasin'] ?>"
								id="idRiverBasin_session">
							<input type="hidden" value="<?php echo $_SESSION['idarea'] ?>"
								id="idarea_session">
							<input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>"
								id="AreaAll">
							<input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>"
								id="RBAll">
							<input type="hidden"
								value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">
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
							<div class="card-header">


								<div class="row justify-content-between">
									<div class="col-md-8 ">
										<strong class="card-title">จัดการตลาดและพื้นที่ </strong>
									</div>

									<div class="col-md-4 "></div>

								</div>
							</div>



							<div class="card-body ">
								<div class="card">
									<div class="card-header search_td" style="cursor: pointer;"
										data-toggle="collapse" data-target="#criteria"
										aria-expanded="false" aria-controls="criteria">
										<strong class="card-title"><i class="menu-icon fa fa-search"></i>
											ค้นหา</strong>
									</div>
									<div class="card-body collapse" id='criteria'>

										<div class="form-group row">
											<label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
											<div class="col-sm-4">
												<select class="form-control" name="idRiverBasin"
													id="idRiverBasin">
													<!-- <option value="0">กรุณาเลือก</option> -->
                                                    <?php echo loadRiverDependentInSS($conn, $_SESSION['RBAll']); ?>
                                                    </select>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">พื้นที่</label>
											<div class="col-sm-8">
												<select class="form-control" name="idArea" id="idArea">
                                                <!-- <?php
                                                    echo loadAreaDependentInSS($conn, $_SESSION['RBAll'], $_SESSION['AreaAll']);
                                                ?> -->
                                                </select>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">ช่องทางตลาด</label>
											<div class="col-sm-8">
												<select class="form-control" name="idMarket" id="idMarket" style="width: 100%;">
                                               <?php
                                                    $sql2="select *  from Market_TD";
                                                    echo "<option value=0 >กรุณาเลือก</option>";
                                                    $stmt = sqlsrv_query( $conn, $sql2 );
    
                                                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                    $id_pre=$row["idMarket"];
                                                    $name_pre=$row["nameMarket"];
                                                    echo "<option value='$id_pre' > $name_pre</option>";
                                                }
                                                ?>
                                                </select>
											</div>
										</div>
										
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">รายชื่อผู้รับซื้อ</label>
											<div class="col-sm-8">
												<select class="form-control" name="customer_id" id="customer_id" style="width: 100%;">
                                                <?php
                                                    $sql2="select *  from Customer_TD";
                                                    echo "<option value=0 >กรุณาเลือก</option>";
                                                    $stmt = sqlsrv_query( $conn, $sql2 );
    
                                                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                    $id_pre=$row["idCustomer"];
                                                    $name_pre=$row["c_name"];
                                                    echo "<option value='$id_pre' > $name_pre</option>";
                                                }
                                                ?>
                                                </select>
											</div>
										</div>
										
										
										<div class="form-group row">
											<div class="col-md-5"></div>
											<div class="col-md-1">
												<button type="button" class="btn btn-primary "
													id="search_customer">
													<i class="menu-icon fa fa-search"></i> ค้นหา
												</button>
											</div>
											<div class="col-md-1 ">
												<button type="button" class="btn btn-primary"
													id="clear_customer">
													<i class="menu-icon fa fa-refresh"> </i> ล้าง
												</button>
											</div>
											<div class="col-md-5"></div>

										</div>


									</div>

									<div class="card">
										<div class="card-header">
											<strong class="card-title">ตารางข้อมูลตลาดและพื้นที่</strong>
										</div>

										<div class="card-body">

											<div class="form-group row">
												<div class="col-md-5"></div>
												<div class="col-md-5"></div>
												<div class="col-md-2">
												 <button type="button" class="btn btn-primary " id="addCustomerMarketbtn"  data-toggle="modal" data-target="#addCustomerMarket"><i class="menu-icon fa fa-plus"></i>  เพิ่มตลาดกับพื้นที่</button>
												</div>
											</div>

											<table id="customerMarketTable"
												class="table table-striped table-bordered"
												style="border-left-width: 0;width: 100%;">
												<thead>
													<tr style="border-left-width: thick;">
														<th style="text-align: center;">ลำดับ    </th>
														<th style="text-align: center;">พื้นที่     </th>
														<th style="text-align: center;">ช่องทางตลาด </th> 
														<th style="text-align: center;">รายชื่อผู้รับซื้อ </th>
														<th style="text-align: center;">เบอร์โทรศัพท์   </th>
														<th style="text-align: center;">รหัส   </th>
														<th style="text-align: center;"></th>

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
				<!-- .animated -->

			</div>
			<!-- .content -->
		</div>
		<!-- /#right-panel -->

		<!-- Right Panel -->

		<script src="../vendors/jquery/dist/jquery.min.js"></script>
		<script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
		<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="../assets/js/main.js"></script>

		<!-- dataTable -->
		<script src="../assets/hrdi_js/moment.min.js"></script>
		<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
		<script
			src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script
			src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
		<script
			src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
		<script
			src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
		<script
			src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
		<script
			src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script
			src="../assets/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
		<script src="../assets/hrdi_js/validationPerson.js"></script>
		<script src="../assets/hrdi_js/jquery.qrcode.min.js"></script>
		<script src="../assets/js/slimselect.min.js"></script>
		<script src="../vendors/select2/dist/js/select2.min.js"></script>
		<script src="../assets/hrdi_js/CustomerMarket/customerMarketManagement.js"></script>
		<script src="../assets/hrdi_js/CustomerMarket/addCustomerMarket.js"></script>
		<script src="../assets/hrdi_js/CustomerMarket/editCustomerMarket.js"></script>

</body>

</html>
