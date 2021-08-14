<?php
include 'header.php';

$current_url = 'Agricultural.php';

if( isset( $_POST['AddAgricultural'] ) ) {
    $nameArgi = $_POST['nameArgi'];
    $idTypeOfStand = $_POST['idTypeOfStand'];
    $idTypeOfArgi = $_POST['idTypeOfArgi'];
    $idGrowLocate = $_POST['idGrowLocate'];
    //$codeGrade = $_POST['codeGrade'];
    $idCountUnit = $_POST['idCountUnit'];
    $speciesArgi = $_POST['speciesArgi'];
    if('' == $nameArgi || $idTypeOfArgi == '0' || $idTypeOfArgi == ''){
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน")</script>';
    }
    if( '' != $nameArgi && $idTypeOfArgi != '0' && $idTypeOfArgi != '') {
        $params = array( $nameArgi, $idTypeOfStand, $idTypeOfArgi, $idGrowLocate, $idCountUnit, $speciesArgi );
        (new Agricultural)->insert( $params );
    }
}

if( isset( $_POST['EditAgricultural'] ) ) {
    $nameArgi = $_POST['nameArgi'];
    $idTypeOfStand = $_POST['idTypeOfStand'];
    $idTypeOfArgi = $_POST['idTypeOfArgi'];
    $idGrowLocate = $_POST['idGrowLocate'];
    //$codeGrade = $_POST['codeGrade'];
    $idCountUnit = $_POST['idCountUnit'];
    $speciesArgi = $_POST['speciesArgi'];
    $idAgri = $_POST['idAgri'];
    if('' == $nameArgi || $idTypeOfArgi == '0'){
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน")</script>';
    }
    if( '' != $nameArgi && '' != $idAgri ) {
        $params = array( $nameArgi, $idTypeOfStand, $idTypeOfArgi, $idGrowLocate,  $idCountUnit, $speciesArgi, $idAgri );
        (new Agricultural)->update( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset($_GET['delete']) ) {

    $idAgri = $_GET['idAgri'];
    if( '' != $idAgri ) {
        $params = array( $idAgri );
        (new Agricultural)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
if (isset($_POST['searchForm'])){
    echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>ข้อมูลพืชที่ได้รับการส่งเสริม</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>ข้อมูลพืช</h1>
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
        </div> -->
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card" >
                            <div class="card-header search_td" style=" cursor: pointer; " data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="search">
                                <strong class="card-title"><i class="menu-icon fa fa-search"></i> ค้นหา</strong>
                            </div>
                            <div class="card-body collapse" id='search'>
                                <form action="<?php $current_url?>" method="post" >
                                    <input type="hidden" name="searchForm" value="N" />
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"name="typeOfAgri_id" id="typeOfAgri_id">
                                                <option value='null'>กรุณาเลือก</option>
                                                <?php
                                                    foreach( (new TypeOfArgi)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfArgi"].'">'.$row["nameTypeOfArgi"].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="inputext" class="col-sm-2 col-form-label">ลักษณะเพาะปลูก :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="typeOfGrowId" id="typeOfGrowId" >
                                                <option value='null'>กรุณาเลือก</option>
                                                <?php
                                                    foreach( (new GrowLocate_TD)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idGrowLocate"].'">'.$row["nameGrowLocate"].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">มาตรฐานพืช :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"name="idTypeOfStand" id="idTypeOfStand">
                                                <option value='null'>กรุณาเลือก</option>
                                                <?php
                                                    foreach( (new TypeOfStand)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfStand"].'" '.( $row["idTypeOfStand"] == $result['idTypeOfStand'] ? 'selected' : '' ).'>'.$row["nameTypeOfStand"].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">เกรดสินค้า :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"name="gardProduct" id="gardProduct">
                                                <option value='all'>เลือกทั้งหมด</option>
                                                <?php
                                                    // foreach( (new Grade)->get_all() AS $row ) {
                                                    //     echo '<option value="'.$row["codeGrade"].'" '.( $row["codeGrade"] == $result['Grade_codeGrade'] ? 'selected' : '' ).'>'.$row["codeGrade"].'</option>';
                                                    // }
                                                ?>
                                            </select>
                                        </div>
                                    </div> -->
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
                                 <strong class="card-title">ข้อมูลพืชที่ได้รับการส่งเสริม</strong>
                                </div>
                                
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if( !isset($_GET['edit']) ) : ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="nameArgi" value="" class="form-control" />
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พันธ์ุพืช</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="speciesArgi" id='speciesArgi' value="" class="form-control" />
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
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลักษณะเพาะปลูก</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idGrowLocate" id="idGrowLocate">
                                                    <?php
                                                    foreach( (new GrowLocate_TD)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idGrowLocate"].'">'.$row["nameGrowLocate"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">มาตรฐานพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idTypeOfStand" id="idTypeOfStand">
                                                    <?php
                                                    foreach( (new TypeOfStand)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfStand"].'" '.( $row["idTypeOfStand"] == $result['idTypeOfStand'] ? 'selected' : '' ).'>'.$row["nameTypeOfStand"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกรดของพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="codeGrade" id="codeGrade">
                                                    <?php
                                                    // foreach( (new Grade)->get_all() AS $row ) {
                                                    //     echo '<option value="'.$row["codeGrade"].'" '.( $row["codeGrade"] == $result['Grade_codeGrade'] ? 'selected' : '' ).'>'.$row["codeGrade"].'</option>';
                                                    // }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หน่วยวัดปริมาณ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idCountUnit" id="idCountUnit">
                                                    <?php
                                                    foreach( (new CountUnit)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idCountUnit"].'">'.$row["nameCountUnit"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" >
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddAgricultural" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $idAgri = $_GET['idAgri'];
                                            $result = (new Agricultural)-> get_by_id( $idAgri );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="nameArgi" value="<?php echo $result['nameArgi']; ?>" class="form-control" />
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พันธ์ุพืช</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="speciesArgi" id='speciesArgi' value="<?php echo $result['speciesArgi']; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idTypeOfArgi" id="idTypeOfArgi">
                                                    <?php
                                                    foreach( (new TypeOfArgi)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfArgi"].'" '.( $row["idTypeOfArgi"] == $result['idTypeOfArgi'] ? 'selected' : '' ).'>'.$row["nameTypeOfArgi"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลักษณะเพาะปลูก</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idGrowLocate" id="idGrowLocate">
                                                    <?php
                                                    foreach( (new GrowLocate_TD)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idGrowLocate"].'" '.( $row["idGrowLocate"] == $result['idGrowLocate'] ? 'selected' : '' ).'>'.$row["nameGrowLocate"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">มาตรฐานพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idTypeOfStand" id="idTypeOfStand">
                                                    <?php
                                                    foreach( (new TypeOfStand)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfStand"].'" '.( $row["idTypeOfStand"] == $result['idTypeOfStand'] ? 'selected' : '' ).'>'.$row["nameTypeOfStand"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกรดของพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="codeGrade" id="codeGrade">
                                                    <?php
                                                    // foreach( (new Grade)->get_all() AS $row ) {
                                                    //     echo '<option value="'.$row["codeGrade"].'" '.( $row["codeGrade"] == $result['Grade_codeGrade'] ? 'selected' : '' ).'>'.$row["codeGrade"].'</option>';
                                                    // }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หน่วยวัดปริมาณ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idCountUnit" id="idCountUnit">
                                                    <?php
                                                    foreach( (new CountUnit)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idCountUnit"].'" '.( $row["idCountUnit"] == $result['idCountUnit'] ? 'selected' : '' ).'>'.$row["nameCountUnit"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditAgricultural" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> แก้ไขข้อมูล</button>
                                                    <input type="hidden" name="idAgri" value="<?php echo $idAgri; ?>" />
                                                </div>
                                                <div class="col-md-3">
                                                    <!-- <button type="submit" name="EditAgricultural" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button> -->
                                                    <?php if( isset($_GET['edit']) ) { ?><a href="<?php echo $current_url; ?>" class="btn btn-primary">ยกเลิก</a><?php } ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                       </form>
                                       
                                </div>
                            <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-bordered" id="tableAgricultural">
                                    <thead>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>ชนิดพืช</th>
                                            <th>สาขาพืช</th>
                                            <th>ลักษณะเพาะปลูก</th>
                                            <th>มาตรฐาน</th>
                                            <th>หน่วยวัด</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // if(){
                                            // foreach( (new Agricultural)->get_all() AS $row ) {
                                            //     $id = $row["idAgri"];
                                            //     echo '<tr>';
                                            //     echo '<td>'.$id.'</td>';
                                            //     echo '<td>'.$row["nameArgi"].'</td>';
                                            //     echo '<td>'.$row["nameTypeOfArgi"].'</td>';
                                            //     echo '<td>'.$row["nameGrowLocate"].'</td>';
                                            //     echo '<td>'.$row["nameTypeOfStand"].'</td>';
                                            //     echo '<td>'.$row["Grade_codeGrade"].'</td>';
                                            //     echo '<td>'.$row["nameCountUnit"].'</td>';
                                            //     echo '<td><a href="'.$current_url.'?edit&idAgri='.$id.'"><span class="ti-pencil"></span></a> ';
                                            //     echo '<a href="'.$current_url.'?delete&idAgri='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
                                            //     echo '</tr>';
                                            // }
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
<script src="../assets/hrdi_js/agricultural.js"></script>