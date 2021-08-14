<?php
include_once('header.php');

$current_url = 'ListTargetAgriUnitPlan.php';

// print_r( ListTargetAgriUnitPlan::get_all() );

if( isset( $_POST['AddListTargetAgriUnitPlan'] ) ) {
    $idAgri = $_POST['idAgri'];
    $idCountUnit = $_POST['idCountUnit'];
    $idTypeOfArgi = $_POST['idTypeOfArgi'];
    if('' == $idAgri || $idAgri == '0' || $idCountUnit == '' || $idCountUnit == '0' || $idTypeOfArgi == '' || $idTypeOfArgi == '0'){
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน")</script>';
    }
    if( '0' != $idAgri && '' != $idCountUnit ) {
        $params = array( $idAgri, $idCountUnit );
        (new ListTargetAgriUnitPlan)->insert( $params );
    }
    echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
}

if( isset( $_POST['EditListTargetAgriUnitPlan'] ) ) {
    $idAgri = $_POST['idAgri'];
    $idCountUnit = $_POST['idCountUnit'];
    $unit_plan_id = $_POST['unit_plan_id'];
    $idTypeOfArgi = $_POST['idTypeOfArgi'];
    if('' != $idAgri && $idAgri != '0' && $idCountUnit != '' && $idCountUnit !='0' && $idTypeOfArgi != '' && $idTypeOfArgi != '0'){
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน")</script>';
    }
    if( '0' != $idAgri && '' != $idCountUnit && '' != $unit_plan_id ) {
        $params = array( $idAgri, $idCountUnit, $unit_plan_id );
        (new ListTargetAgriUnitPlan)->update( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset($_GET['delete']) ) {
    $unit_plan_id = $_GET['unit_plan_id'];
    if( '' != $unit_plan_id ) {
        $params = array( $unit_plan_id );
        (new ListTargetAgriUnitPlan)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>ส่งเสริมเป้าหมายการผลิต</h1>
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

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                    <div class="card">
                            <div class="card-header search_td" style=" cursor: pointer; " data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="search">
                                <strong class="card-title"><i class="menu-icon fa fa-search"></i> ค้นหา</strong>
                            </div>
                            <div class="card-body collapse" id='search'>
                                <form action="<?php $current_url?>" method="post" id="search">
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="idTypeOfArgiSearch" id="idTypeOfArgiSearch">
                                            <option value="null">กรุณาเลือก</option>
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
                                            <select class="form-control" name="idAgriSearch" id="idAgriSearch">
                                                <option value="null">กรุณาเลือก</option>
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
                                 <strong class="card-title">ส่งเสริมเป้าหมายการผลิต</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idTypeOfArgi" id="idTypeOfArgi">
                                                    <option value="">กรุณาเลือก</option>
                                                    <?php
                                                    foreach( (new TypeOfArgi)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfArgi"].'">'.$row["nameTypeOfArgi"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idAgri" id="idAgri">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Agricultural)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idAgri"].'">'.$row["nameArgi"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หน่วยนับ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idCountUnit" id="idCountUnit">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new TypeOfTarget)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idTypeOfTarget"].'">'.$row["nameTypeOfTarget"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>

                                            <div class="row" id="test">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddListTargetAgriUnitPlan" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>
                                                </div>
                                            </div>
                                       </form>
                                       
                                </div>
                            <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-bordered datatables" id="datalistTargetAgriUnit">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>สาขาพืช</th>
                                            <th>ชนิดพืช</th>
                                            <th>หน่วยนับ</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // foreach( (new ListTargetAgriUnitPlan)->get_all() AS $row ) {
                                        //     $id = $row["unit_plan_id"];
                                        //     echo '<tr>';
                                        //     echo '<td>'.$id.'</td>';
                                        //     echo '<td>'.$row["nameArgi"].'</td>';
                                        //     echo '<td>'.$row["nameCountUnit"].'</td>';
                                        //     echo '<td><i class=" fa fa-pencil-square-o" id="editListTargetAgriUnit" style=" cursor: pointer;margin-right: 10px;">';
                                        //     echo '<a href="'.$current_url.'?delete&unit_plan_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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
<script src="../assets/hrdi_js/listTargetAgriUnitJs.js"></script>