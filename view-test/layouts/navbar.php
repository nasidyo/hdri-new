<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="personChart.php"><img src="<?php echo _BASE_URL_; ?>/images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="personChart.php"><img src="<?php echo _BASE_URL_; ?>/images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                      <!--  <a href="index.php"> <i class="menu-icon fa fa-dashboard"></i>Main Screen </a>-->
                      <a href="personChart.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart-o"></i>สรุปผลเกษตรกร</a>
                    </li>

                   <!--  <h3 class="menu-title">เมนู</h3>/.menu-title -->

                 <!--   <li class="menu-item-has-children ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>บัญชีรับ-จ่าย</a>
                       
                    </li>
         
                    <li class="menu-item-has-children ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>สมาชิกกลุ่ม</a>
                        
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>สินค้าขาดหาย</a>
                        
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="account.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>คณะกรรมการ</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="personChart.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>สรุปผลเกษตรกร</a>
                    </li>-->
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/Agriculturaladd.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>ข้อมูลเกษตร</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/addPersonView.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-plus"></i>เพิ่มเกษตร</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/editPersonView.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>แก้ไขเกษตร</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/CustomerMarket.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>CustomerMarket</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/Agricultural.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>Agricutural</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/ListTargetAgri.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>ListTargetAgri</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/RegisterAgri_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>RegisterAgri_TD</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/ListVillageLevel_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>ListVillageLevel_TD</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/ListTargetAgriUnitPlan.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>ListTargetAgriUnitPlan</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/LandDetail.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>LandDetail</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/PlantHouse.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>PlantHouse</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/YearTB.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>ปี</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/CustomerMaketPlan_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>CustomerMaketPlan_TD</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/Logistic_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>วิธีการขนส่ง</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/connection_status_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>สถานะการติดต่อ</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/position_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>ตำแหน่ง</a>
                    </li>
                    <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/Organization_TD.php" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil"></i>โครงสร้าง</a>
                    </li>

                    <h3 class="menu-title"><i class="menu-icon fa ti-stats-up"></i> การตลาด</h3><!-- /.menu-title -->
	                <li class="menu-item-has-children ">
                        <a href="<?php echo _BASE_URL_; ?>/view/showBasin.php" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa ti-target"></i>พื้นที่เป้าหมาย</a>
                    </li>

                    <li class="active">
                        <a  aria-haspopup="true" aria-expanded="false" href="?q=logout">LOGOUT</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->