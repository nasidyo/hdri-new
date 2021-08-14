<?php
include 'header.php';

require '../util/RiverBasinDependent.php';
$db = new Database();
$conn=  $db->getConnection();
$current_url = 'CustomerMarket.php';

if( isset( $_POST['AddCustomerMarket'] ) ) {
    $idCustomers = $_POST['idCustomers'];
    $idMarket = $_POST['idMarket'];
    $idArea = $_POST['idArea'];
    if( '' != $idCustomers && '0' != $idMarket && '0' != $idArea ) {
        $idCustomers = explode(',', $idCustomers);
        foreach( $idCustomers AS $idCustomer ) {
            $params = array( $idCustomer, $idMarket, $idArea );
            (new CustomerMarket)->insert( $params );
        }
    }
    echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
}
if( isset( $_POST['EditCustomerMarket'] ) ) {
    $idCustomer = $_POST['idCustomer'];
    $idMarket = $_POST['idMarket'];
    $idArea = $_POST['idArea'];
    $idCustomerMarket = $_POST['idCustomerMarket'];
    if( '0' != $idCustomer && '0' != $idMarket && '0' != $idArea && '' != $idCustomerMarket ) {
        $params = array( $idCustomer, $idMarket, $idArea, $idCustomerMarket );
        (new CustomerMarket)->update( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset($_GET['delete']) ) {
    $idCustomerMarket = $_GET['idCustomerMarket'];
    if( '' != $idCustomerMarket ) {
        $params = array( $idCustomerMarket );
        CustomerMarket::delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
    $_POST = array();
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>จัดการตลาดและพื้นที่</h1>
                    </div>
                </div>
            </div>
            <!-- <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"><?php if( isset($_GET['edit']) ) { ?><a href="<?php echo $current_url; ?>" class="btn btn-secondary">Back</a><?php } ?></li>
                        </ol>
                    </div>
                </div>
            </div> -->
        </div>
    <!-- .content -->
        <div class="content mt-3 page-customer-market">

        <div class="animated fadeIn" id="CustomerMarket">
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
                                        <div class="col-sm-1">
                                            <button type="button" id="searchBtn" name="searchBtn" class="btn btn-primary"> <i class="fa fa-search"></i>&nbsp; ค้นหา</button>
                                        </div>
                                        <div class="col-md-1 "></div>
                                        <div class="col-md-1 ">
                                            <button type="button" class="btn btn-primary" id="clear_Search">  ยกเลิก</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                           
                            
                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                 <strong class="card-title">จัดการตลาดและพื้นที่</strong>
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
                                                        <option value="0">กรุณาเลือก</option>
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
                                                    <option value="null">กรุณาเลือก</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ช่องทางตลาด</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idMarket" id="idMarket">
                                                    <option value="0">กรุณาเลือก</option>
                                                    <?php
                                                    foreach( (new Market)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idMarket"].'">'.$row["nameMarket"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>

                                                <!-- <div class="col-sm-1">
                                                    <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="addNewMarket" name="addNewMarket" role="button"><i class="fa fa-plus"></i> เพิ่มตลาดใหม่</a>
                                                </div> -->
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">รายชื่อผู้รับซื้อ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control selectpicker multiselect" multiple data-live-search="true" name="idCustomer" id="idCustomer">
                                                    <option value="null">กรุณาเลือก</option>
                                                    <?php
                                                    foreach( (new Customer)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idCustomer"].'">'.$row["c_name"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                    <input type="hidden" name="idCustomers" id="multiselectvalues" value="" />
                                                </div>
                                                <!-- <div class="col-sm-1">
                                                    <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="addNewCustomer" name="addNewCustomer" role="button"><i class="fa fa-plus"></i> เพิ่มลูกค้าใหม่</a>
                                                </div> -->
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1" id="test">
                                                    <button type="submit" name="AddCustomerMarket" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>
                                                </div>
                                                <div class="col-md-1 "></div>
                                                <div class="col-md-1 ">
                                                    <button type="button" class="btn btn-primary" id="clear_field">  ยกเลิก</button>
                                                </div>
                                            </div>
<!--                                             
                                                <?php 
                                                $idCustomerMarket = $_GET['idCustomerMarket'];
                                                $customer = (new CustomerMarket)->get_by_id( $idCustomerMarket );
                                                ?>
                                                <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">รายชื่อลูกค้า</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idCustomer" id="idCustomer">
                                                    <?php
                                                    foreach( (new Customer)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idCustomer"].'" '.( $row["idCustomer"] == $customer['idCustomer'] ? 'selected' : '' ).'>'.$row["c_name"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idArea" id="idArea">
                                                    <?php
                                                    foreach( (new Area)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idArea"].'" '.( $row["idArea"] == $customer['idArea'] ? 'selected' : '' ).'>'.$row["areaName"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">รายชื่อตลาด</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idMarket" id="idMarket">
                                                    <?php
                                                    foreach( (new Market)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idMarket"].'" '.( $row["idMarket"] == $customer['idMarket'] ? 'selected' : '' ).'>'.$row["nameMarket"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditCustomerMarket" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="idCustomerMarket" value="<?php echo $idCustomerMarket; ?>" />
                                                </div>
                                            </div>
                                             -->
                                       </form>
                                       
                                </div>
                            <div class="card">
                            <div class="card-body">
                                <table id="customerMarketTable" class="table table-striped table-bordered datatables">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>พื้นที่</th>
                                            <th>ช่องทางตลาด</th>
                                            <th>ชื่อผู้รับซื้อ</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // foreach( (new CustomerMarket)->get_all() AS $row ) {
                                    //     $id = $row["idCustomerMarket"];
                                    //     echo '<tr>';
                                    //     echo '<td>'.$id.'</td>';
                                    //     echo '<td>'.$row["areaName"].'</td>';
                                    //     echo '<td>'.$row["nameMarket"].'</td>';
                                    //     echo '<td>'.$row["c_name"].'</td>';
                                    //     // echo '<td><a href="'.$current_url.'?edit&idCustomerMarket='.$id.'"><span class="ti-pencil"></span></a> ';
                                    //     echo '<td><i class=" fa fa-pencil-square-o" id="editCustomerMarket" style=" cursor: pointer;margin-right: 10px;">';
                                    //     echo '<a href="'.$current_url.'?delete&idCustomerMarket='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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
        <?php include 'modal/addNewMarket.php';?>
        <?php include 'modal/addNewCustomer.php';?>
    </div><!-- /#right-panel -->

<?php include_once('layouts/footer.php');?>
<script src="../assets/hrdi_js/customerMarketJs.js"></script>