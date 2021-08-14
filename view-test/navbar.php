<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="dashboard.php"><img src="../images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="dashboard.php"><img src="../images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php
                        $permssion = 'admin';
                        if(isset($_SESSION['staffPermis'])){
                            $permssion = $_SESSION['staffPermis'];
                        }
                        $currentYears = date("Y-m-d h:i:s");
                        $currentMonth = date("m");
                        // $permssion = $_SESSION['staffPermis'];
                        // if($permssion != 'admin'){
							
                    ?>
					         <input type="hidden" value="<?php echo $_SESSION['idRiverBasin'] ?>" id="idRiverBasin_session">
                             <input type="hidden" value="<?php echo $_SESSION['idarea'] ?>" id="idarea_session">
                             <input type="hidden" value="<?php echo $_SESSION['AreaAll'] ?>" id="AreaAll">
                             <input type="hidden" value="<?php echo $_SESSION['RBAll'] ?>" id="RBAll">
                             <input type="hidden" value="<?php echo $_SESSION['staffPermis'] ?>" id="staffPermis">
                             <input type="hidden" value="<?php echo  $_SESSION['idStaff']  ?>" id="staffId">
                      <li class="active menu-title" style="text-align: center;color: cadetblue;font-size: 12px"><?php echo$_SESSION['fullName'];?></li>

                            <!-- <h3 class="menu-title"><i class="menu-icon fa ti-package"></i> จัดการข้อมูลพืช</h3>
                            <li class="menu-item-has-children ">
                                <a href="Agricultural.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลพืช</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="ListTargetAgri.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการพืชและพื้นที่</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="RegisterAgri_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการการส่งเสริมพืช</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="ListTargetAgriUnitPlan.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการส่งเสริมเป้าหมายการผลิต</a>
                            </li> -->

                            <!-- <h3 class="menu-title"><i class="menu-icon fa ti-shopping-cart"></i> จัดการข้อมูลลูกค้าและตลาด</h3>
                            <li class="menu-item-has-children ">
                                <a href="CustomerMarket.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลลูกค้า</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="connection_status_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลสถาณะลูกค้า</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="CustomerMaketPlan_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลการรับซื้อสินค้า</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="Logistic_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลการขนส่ง</a>
                            </li> -->


                            <!-- <h3 class="menu-title"><i class="menu-icon fa ti-settings"></i> จัดการข้อมูลเบื้องต้น</h3>
                            <li class="menu-item-has-children">
                                <a href="PlantHouse.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลโรงเรือน</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="LandDetail.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลพื้นที่เกษตกร</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="ListVillageLevel_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการมาตราฐานของหมู่บ้าน</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="YearTB.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการข้อมูลปีงบประมาณ</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="position_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการตำแหน่งกลุ่มเกษตกร</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="Organization_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>จัดการโครงสร้างกลุ่มเกษตกร</a>
                            </li> -->
                    <?php
                        //}
                    ?>
                    <!-- <h3 class="menu-title"><i class="menu-icon fa ti-stats-up"></i> สรุปผลเกษตรกร</h3>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>เกษตรกร</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-bar-chart-o"></i><a href="personChart.php">สรุปผลเกษตรกร</a></li>
                            <li><i class="menu-icon fa fa-users"></i><a href="Agriculturaladd.php">ข้อมูลเกษตร</a></li>
                            <li><i class="menu-icon fa fa-plus"></i><a href="addPersonView.php">เพิ่มเกษตร</a></li>
                            <li><i class="menu-icon fa fa-pencil"></i><a href="editPersonView.php">แก้ไขเกษตร</a></li>
                        </ul>
                    </li> -->
                    <?php
                    $personMenu = array('admin','bussiness','manager','powerUser','powerUserMarket','staff','powerUserAccount');
                    if(is_numeric(array_search($permssion, $personMenu,true))){

                    ?>
                    <h3 class="menu-title"> ทะเบียนเกษตกร</h3>
                            <li class="menu-item-has-children "  >
                                <a href="personChart.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa ti-stats-up" style=" color: aqua; " ></i>สรุปภาพรวมข้อมูล</a>
                            </li>
                            <li class="menu-item-has-children " >
                                <a href="Agriculturaladd.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users" style=" color: burlywood; " ></i>จัดการข้อมูลเกษตรกร</a>
                            </li>

<?php 

	if($permssion!="bussiness"){

?>
			   <li class="menu-item-has-children "   >
                                <a href="addPersonView.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-camera" style=" color: #ea2c62; "></i>เพิ่มเกษตรกรผ่านมือถือ</a>
                            </li>
<?php 
}
?>
                           
                            <!-- <li class="menu-item-has-children ">
                                <a href="RegisterAgri_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>จัดการเกษตกรที่รับการส่งเสริม</a>
                            </li> -->


                            <!-- <li><i class="menu-item-has-children fa fa-bar-chart-o"></i><a href="personChart.php">สรุปผลเกษตรกร</a></li> -->
                            <!-- <li><i class="menu-item-has-children fa fa-users"></i><a href="Agriculturaladd.php">ข้อมูลเกษตร</a></li>
                            <li><i class="menu-item-has-children fa fa-plus"></i><a href="addPersonView.php">เพิ่มเกษตร</a></li>
                            <li><i class="menu-item-has-children fa fa-pencil"></i><a href="editPersonView.php">แก้ไขเกษตร</a></li> -->
                    </li>
                    <?php } ?>


                    <?php
                        $marketPlantMenu = array('admin','manager','powerUserMarket','staff');
                        if(is_numeric(array_search($permssion, $marketPlantMenu,true))){
                    ?>
                            <!-- <h3 class="menu-title"><i class="menu-icon fa ti-stats-up"></i> การตลาด</h3>
                            <li class="menu-item-has-children dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>การตลาด</a>
                                <ul class="sub-menu children dropdown-menu">
                                    <li><i class="menu-icon fa ti-target"></i><a href="showBasin.php">พื้นที่เป้าหมาย</a></li>
                                </ul>
                            </li> -->
                            <h3 class="menu-title"> การผลิตและการตลาด</h3>
                            <li class="menu-item-has-children ">
                                <a href="showBasin.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa ti-target" style=" color: #ff9a8c; "></i>เป้าหมายและส่งมอบ</a>
                            </li>
                        <?php
                            $db = new Database();
                            $conn = $db->getConnection();
                            $sql = "
                            SELECT TOP 1 idYearTB
                            FROM YearTB
                            WHERE dateStart < '".$currentYears."' and dateStop > '".$currentYears."'";
                            $stmt = sqlsrv_query($conn, $sql);
                            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                $nowYearsId = $row["idYearTB"];
                            }

                            $sql1 = "
                            SELECT *
                            FROM SendStatusPlan_TD
                            WHERE idStatusPlan = '4' and YearID = '".$nowYearsId."' and Area_idArea in (".$_SESSION['AreaAll'].")";
                            $stmt1 = sqlsrv_query($conn, $sql1);
                            $rows = sqlsrv_has_rows($stmt1);
                            if ($rows === true){
                                $adminAndStaffMenu = array('admin','staff');
                                if(is_numeric(array_search($permssion, $adminAndStaffMenu,true))){
                            ?>
                                    <li class="menu-item-has-children ">
                                        <a href="deliverProductsFromPerson.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa ti-camera" style=" color: #ff9a8c; "></i>ส่งมอบผลผลิตผ่านมือถือ</a>
                                    </li>
                        <?php
                                }
                            }
                        ?>
                    <?php
                        }

                        $accountingMenu = array('admin','framerAgent','powerUserAccount');
                        if(is_numeric(array_search($permssion, $accountingMenu,true))){
                    ?>
                    <h3 class="menu-title"> ระบบบริหารการเงิน</h3>
					
					  <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"  style=" color: #799351; " ></i>จัดการข้อมูลสถาบันเกษตรกร</a>
                            <ul class="sub-menu children dropdown-menu">
                               <li><i class="menu-icon fa fa-caret-right" ></i><a href="InstitutionManagement.php">จัดการข้อมูลสถาบันเกษตรกร</a></li>
							   
                                <li><i class="menu-icon fa fa-caret-right" ></i><a href="personGroupManagement.php">จัดการสมาชิกสถาบันเกษตรกร</a></li>

				 <li><i class="menu-icon fa fa-caret-right" ></i><a href="AccountYearManagement.php">จัดการปีบัญชี</a></li>
                              
                            </ul>
                        </li>

                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"  style=" color: #799351; " ></i>ระบบจัดการข้อมูลการเงิน</a>
                            <ul class="sub-menu children dropdown-menu">
                                
                                <li><i class="menu-icon fa fa-caret-right"  ></i><a href="ExpenseManagement.php">การจัดการรายจ่าย</a></li>
                                <li><i class="menu-icon fa fa-caret-right"  ></i><a href="IncomeManagement.php">การจัดการรายรับ</a></li>
								<li><i class="menu-icon fa fa-caret-right"></i><a href="ExpenseOther.php">จัดการรายจ่ายอื่นๆ</a></li>
								<li><i class="menu-icon fa fa-caret-right"></i><a href="IncomeOther.php">จัดการรายรับอื่นๆ</a></li>
                                <li><i class="menu-icon fa fa-caret-right" ></i><a href="StoreManagement.php">จัดการคลังสินค้า</a></li>
                               
                            </ul>
                        </li>
						
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money" style=" color: #799351; "></i>สรุปรายการบัญชี</a>
                            <ul class="sub-menu children dropdown-menu">
                                
								<li><i class="menu-icon fa fa-caret-right"   ></i><a href="CooperativeManagement.php">สรุปบัญชีรายรับรายจ่าย</a></li>
                                <li><i class="menu-icon fa fa-caret-right" ></i><a href="AccountReport.php">สรุปรายงานการเงิน</a></li>
                            </ul>
                        </li>
                            <!-- <li class="menu-item-has-children ">
                                <a href="InstitutionManagement.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-sitemap"></i>จัดการสถาบัน</a>
                            </li> -->
                            <!-- <li class="menu-item-has-children ">
                                <a href="personGroupManagement.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>จัดการกลุ่มเกษตรกร</a>
                            </li> -->
                            <!-- <li class="menu-item-has-children ">
                                <a href="CooperativeManagement.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>บัญชีรายรับรายจ่าย</a>
                            </li>
                            <li class="menu-item-has-children ">
                                <a href="ExpenseManagement.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>จัดการรายจ่าย</a>
                            </li>
                            <li class="menu-item-has-children ">
                                <a href="IncomeManagement.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>จัดการรายรับ</a>
                            </li> -->
                            <!-- <li class="menu-item-has-children ">
                                <a href="StoreManagement.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-bag"></i>จัดการคลังสินค้า</a>
                            </li>
                            <li class="menu-item-has-children ">
                                <a href="ExpenseOther.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>จัดการรายจ่ายอื่นๆ</a>
                            </li> -->
                    </li>
                    <?php
                        }
                        $reportMenu = array('admin','bussiness','manager','powerUser','powerUserMarket','staff','powerUserAccount');
                        if(is_numeric(array_search($permssion, $reportMenu,true))){
                    ?>
                    <h3 class="menu-title"> รายงาน</h3>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart-o" style=" color: #ffa36c; "></i>สรุปรายงาน</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-caret-right"  ></i><a href="viewReport.php">เปรียบเทียบเป้าหมายและส่งมอบตามลุ่มน้ำ</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="viewReportN.php">เปรียบเทียบเป้าหมายและส่งมอบตามลุ่มน้ำและสาขาพืช</a></li>
                            <li><i class="menu-icon fa fa-caret-right"  ></i><a href="viewPMByMK.php">การส่งมอบและตลาด</a></li>
                            <li><i class="menu-icon fa fa-caret-right"  ></i><a href="basinReport.php">ข้อมูลรายได้เกษตกร</a></li>
                            <li><i class="menu-icon fa fa-caret-right"  ></i><a href="incomeReport.php">ภาพรวมรายได้เกษตรกร</a></li>
                            <li><i class="menu-icon fa fa-caret-right"  ></i><a href="reportAgriFrom.php">ภาพรวมมูลค่าและปริมาณของแต่ละพื้นที่</a></li>
                            <?php if ($_SESSION['staffPermis'] != 'staff'){?>
                                <li><i class="menu-icon fa fa-caret-right"  ></i><a href="reportPlotly.php">ภาพรวมปริมาณผลผลิตส่งแต่ละช่องทางตลาด</a></li>
                                <!-- <li><i class="menu-icon fa fa-caret-right"  ></i><a href="reportBubble.php">ภาพรวมช่องทางการตลาดแต่ละพืช</a></li> -->
                            <?php } ?>
                        </ul>
                    </li>
                    <?php
                        }
                        $dataMenu = array('admin','powerUserMarket','staff');
                        if(is_numeric(array_search($permssion, $dataMenu,true))){

                    ?>
                    <h3 class="menu-title"> จัดการข้อมูล</h3>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pagelines" style=" color: #799351; "></i>ข้อมูลพืชที่ได้รับการส่งเสริม</a>
                        <ul class="sub-menu children dropdown-menu">
                        <?php

                            $data1Menu = array('admin','powerUserMarket');
                            if(is_numeric(array_search($permssion, $data1Menu,true))){
                         ?>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="AgriculturalN.php">จัดการข้อมูลพืช</a></li>
                      <?php } ?>
                            <!-- <li><i class="menu-icon fa fa-caret-right"></i><a href="ListTargetAgriN.php">จัดการพืชและพื้นที่</a></li> -->

                          <?php
                           $data2Menu = array('admin','powerUserMarket');
                           if(is_numeric(array_search($permssion, $data2Menu,true))){
                          ?>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="mangeGradeProduct.php">จัดการเกรด</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="ListTargetAgriUnitPlanN.php">จัดการหน่วยนับการส่งเสริม</a></li>
                           <?php } ?>
                            <!-- <li><i class="menu-icon fa fa-caret-right"></i><a href="RegisterAgri_TD.php">การส่งเสริมชนิดพืช</a></li> -->
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa ti-shopping-cart" style=" color: #a20a0a; " ></i>ตลาดและผู้รับซื้อ</a>
                        <ul class="sub-menu children dropdown-menu">
                        <?php
                            if(is_numeric(array_search($permssion, $data1Menu,true))){
                        ?>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="customer.php">ข้อมูลผู้รับซื้อ</a></li>
                        <?php 
                            }
                        ?>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="CustomerMarket_TD.php">ตลาดและพื้นที่</a></li>
                        <?php
                            if(is_numeric(array_search($permssion, $data1Menu,true))){
                        ?>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="CustomerMarketPlan_TDX.php">การรับซื้อผลผลิต</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="connection_status_TD.php">เพิ่มสถานะผู้รับซื้อ</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="Logistic_TD.php">เพิ่มประเภทการขนส่ง</a></li>
                        <?php 
                            }
                        ?>
                        </ul>
                    </li>
                    <?php

                        $dataAdminMenu = array('admin');
                        if(is_numeric(array_search($permssion, $dataAdminMenu,true))){

                    ?>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-map-marker" style=" color: #706897; "  ></i>ข้อมูลรายแปลง</a>
                        <ul class="sub-menu children dropdown-menu">
                               <li><i class="menu-icon fa fa-caret-right"></i><a href="PlantHouseN.php">จัดการข้อมูลโรงเรือน</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="LandDetailN.php">จัดการข้อมูลแปลงเกษตรกร</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="ListVillageLevelN.php">จัดการข้อมูลระดับหมู่บ้าน</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="LandDetailMap.php">แผนที่ข้อมูลรายแปลง</a></li>
                            <!-- <li><i class="menu-icon fa fa-caret-right"></i><a href="position_TD.php">จัดการตำแหน่งกลุ่มเกษตกร</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="Organization_TD.php">จัดการโครงสร้างกลุ่มเกษตกร</a></li> -->
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa ti-settings" style=" color: #ea2c62; "  ></i>จัดการข้อมูลระบบ</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="YearTBN.php">ข้อมูลปีงบประมาณ</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="manageUser.php">ข้อมูลผู้ใช้งาน</a></li>
                            <li><i class="menu-icon fa fa-caret-right"></i><a href="systemsLogAccess.php">การเข้าใช้งานระบบ</a></li>
                        </ul>
                    </li>
                    <?php
                        }
                    }
                    ?>
                    <li class="active">
                        <a  aria-haspopup="true" aria-expanded="false" href="?q=logout">ออกจากระบบ</a>
                    </li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->
