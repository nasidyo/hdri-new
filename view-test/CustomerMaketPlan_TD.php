<?php
include_once('header.php');
require '../util/RiverBasinDependent.php';
$db = new Database();
$conn=  $db->getConnection();
$current_url = 'CustomerMaketPlan_TD.php';

if( isset( $_POST['AddCustomerMaketPlan_TD'] ) ) {
    $idCustomer = $_POST['idCustomer'];
    $idArea = $_POST['idArea'];
    $plan_Year = $_POST['plan_Year'];
    $idAgri = $_POST['idAgri'];
    $agri_weekplan_amount = $_POST['agri_weekplan_amount'];
    $idCountUnit = $_POST['idCountUnit'];
    $agri_spect = $_POST['agri_spect'];
    $idTypeOfStand = $_POST['idTypeOfStand'];
    $logistic_id = $_POST['logistic_id'];
    $Refund_period = $_POST['Refund_period'];
    $conn_status_id = $_POST['conn_status_id'];
    $update_date = $_POST['update_date'];
    if( '0' != $idArea && '0' != $idArea ) {
        $params = array( $idCustomer, $idArea, $plan_Year, $idAgri, $agri_weekplan_amount, $idCountUnit, $agri_spect, $idTypeOfStand, $logistic_id, $Refund_period, $conn_status_id, $update_date );
        (new CustomerMaketPlan_TD)->insert( $params );
    }
}

if( isset( $_POST['EditCustomerMaketPlan_TD'] ) ) {
    $idCustomer = $_POST['idCustomer'];
    $idArea = $_POST['idArea'];
    $plan_Year = $_POST['plan_Year'];
    $idAgri = $_POST['idAgri'];
    $agri_weekplan_amount = $_POST['agri_weekplan_amount'];
    $idCountUnit = $_POST['idCountUnit'];
    $agri_spect = $_POST['agri_spect'];
    $idTypeOfStand = $_POST['idTypeOfStand'];
    $logistic_id = $_POST['logistic_id'];
    $Refund_period = $_POST['Refund_period'];
    $conn_status_id = $_POST['conn_status_id'];
    $idCustomerMaketplan = $_POST['idCustomerMaketplan'];
    $update_date = $_POST['update_date'];
    if( '0' != $idCustomer && '0' != $idArea && '' != $idCustomerMaketplan ) {
        $params = array( $idCustomer, $idArea, $plan_Year, $idAgri, $agri_weekplan_amount, $idCountUnit, $agri_spect, $idTypeOfStand, $logistic_id, $Refund_period, $conn_status_id, $update_date, $idCustomerMaketplan );
        (new CustomerMaketPlan_TD)->update( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset($_GET['delete']) ) {
    $idCustomerMaketplan = $_GET['idCustomerMaketplan'];
    if( '' != $idCustomerMaketplan ) {
        $params = array( $idCustomerMaketplan );
        (new CustomerMaketPlan_TD)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>ข้อมูลการรับซื้อสินค้า</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"><?php if( isset($_GET['edit']) ) { ?><a href="<?php echo $current_url; ?>" class="btn btn-secondary">Back</a><?php } ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn" id="CustomerMaketPlan_TD">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header search_td" style=" cursor: pointer; " data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="search">
                                <strong class="card-title"><i class="menu-icon fa fa-search"></i> ค้นหา</strong>
                            </div>
                            <div class="card-body collapse" id='search'>
                                <form action="<?php $current_url?>" method="post" >
                                    <input type="hidden" name="searchForm" value="N" />
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"name="idRiverBasinSearch" id="idRiverBasinSearch">
                                                <?php
                                                    echo loadRiverDependent($conn);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="inputext" class="col-sm-2 col-form-label">พื้นที่ :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="idAreaSearch" id="idAreaSearch" >
                                                <option value='null'>กรุณาเลือก</option>
                                                <?php
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-2">
                                            <button type="button" id="searchBtn" name="searchBtn" class="btn btn-primary"> <i class="fa fa-search"></i>&nbsp; ค้นหา</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                           
                            
                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                 <strong class="card-title">ข้อมูลการรับซื้อสินค้า</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idRiverBasin" id="idRiverBasin">
                                                        <option value="null">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new MainBasin)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idRiverBasin"].'">'.$row["nameRiverBasin"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idArea" id="idArea">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลูกค้า</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idCustomer" id="idCustomer">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ปีที่วางแผน</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="plan_Year" name="plan_Year" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idTypeOfArgi" id="idTypeOfArgi">
                                                    <?php
                                                    foreach( (new TypeOfArgi)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfArgi"].'">'.$row["nameTypeOfArgi"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idAgri" id="idAgri">
                                                        <option value="0">กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">จำนวนที่ต้องการต่อสัปดาห์</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="agri_weekplan_amount" name="agri_weekplan_amount" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หน่วยนับ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idCountUnit" id="idCountUnit">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new CountUnit)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idCountUnit"].'">'.$row["nameCountUnit"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สเปคสินค้าที่ต้องการ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="agri_spect" id="agri_spect" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">มาตรฐาน</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idTypeOfStand" id="idTypeOfStand">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new TypeOfStand)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idTypeOfStand"].'">'.$row["nameTypeOfStand"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">การขนส่ง</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="logistic_id" id="logistic_id">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Logistic_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["logistic_id"].'">'.$row["logistic_name"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ระยะเวลาคืนเงิน</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Refund_period" id="Refund_period" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สถานะการติดต่อ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="conn_status_id" id="conn_status_id">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new connection_status_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["conn_status_id"].'">'.$row["conn_status_name"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">วันที่อัพเดทรายการ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="update_date" id="update_date" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row" id="test">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddCustomerMaketPlan_TD" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditCustomerMaketPlan_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="idCustomerMaketplan" value="<?php echo $idCustomerMaketplan; ?>" />
                                                </div>
                                            </div> -->
                                       </form>
                                       
                                </div>
                            <div class="card">
                            <div class="card-body">
                                <table id="customerMakerPlan-Table" class="table table-striped table-bordered datatables">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ลูกค้า</th>
                                            <th>พื้นที่</th>
                                            <th>ชนิดพืช</th>
                                            <th>หน่วยนับ</th>
                                            <th>มาตรฐาน</th>
                                            <th>การขนส่ง</th>
                                            <th>สถานะการติดต่อ</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // $result = (new CustomerMaketPlan_TD)->get_all();
                                    // foreach( $result AS $row ) {
                                    //     $id = $row["idCustomerMaketplan"];
                                    //     echo '<tr>';
                                    //     echo '<td>'.$id.'</td>';
                                    //     echo '<td>'.$row["c_name"].'</td>';
                                    //     echo '<td>'.$row["areaName"].'</td>';
                                    //     echo '<td>'.$row["nameArgi"].'</td>';
                                    //     echo '<td>'.$row["nameCountUnit"].'</td>';
                                    //     echo '<td>'.$row["nameTypeOfStand"].'</td>';
                                    //     echo '<td>'.$row["logistic_name"].'</td>';
                                    //     echo '<td>'.$row["conn_status_name"].'</td>';
                                    //     echo '<td><i class=" fa fa-pencil-square-o" id="editCustomerMarketPlan" style=" cursor: pointer;margin-right: 10px;"> ';
                                    //     echo '<a href="'.$current_url.'?delete&idCustomerMaketplan='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
                                    //     echo '</tr>';
                                    // }
                                    ?>
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

<?php include_once('layouts/footer.php');?>
<script src="../assets/hrdi_js/customerMarketPlanJs.js"></script>