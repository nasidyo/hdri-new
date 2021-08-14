<?php
include_once('header.php');

$current_url = 'ListTargetAgri.php';

if( isset( $_POST['AddListTargetAgri'] ) ) {
    $idArea = $_POST['idArea'];
    $idAgri = $_POST['idAgri'];
    $idTypeOfArgi = $_POST['idTypeOfArgi'];
    $idGrades = $_POST['idGrades'];
    $idRiverBasin = $_POST['idRiverBasin'];
    if('' == $idRiverBasin || $idRiverBasin == '0' || $idArea == '' || $idArea == '0' || $idAgri == '' || $idAgri == '0' || $idTypeOfArgi == '' || $idTypeOfArgi == '0'){
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน")</script>';
    }
    if('' != $idRiverBasin && $idRiverBasin != '0' &&  $idArea != '' && $idArea != '0' && $idAgri != '' && $idAgri != '0' && $idTypeOfArgi != '' && $idTypeOfArgi != '0') {
        $idGrades = explode(',', $idGrades);
        foreach( $idGrades AS $idGrade ) {
            $params = array( $idArea, $idAgri, $idTypeOfArgi, $idGrade);
            (new ListTargetAgri)->insert( $params );
        }
    }
    echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
}

if( isset( $_POST['EditListTargetAgri'] ) ) {
    $idArea = $_POST['idArea'];
    $idAgri = $_POST['idAgri'];
    $idTypeOfArgi = $_POST['idTypeOfArgi'];
    $idGrade = $_POST['idGrade'];
    $idRiverBasin = $_POST['idRiverBasin'];
    $list_taget_agri_id = $_POST['list_taget_agri_id'];
    if('' == $idRiverBasin || $idRiverBasin == '0' || $idArea == '' || $idArea == '0' || $idAgri == '' || $idAgri == '0' || $idTypeOfArgi == '' || $idTypeOfArgi == '0'){
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน")</script>';
    }
    if('' != $list_taget_agri_id && '' != $idRiverBasin && $idRiverBasin != '0' &&  $idArea != '' && $idArea != '0' && $idAgri != '' && $idAgri != '0' && $idTypeOfArgi != '' && $idTypeOfArgi != '0') {
        $params = array( $idArea, $idAgri, $idTypeOfArgi, $idGrade, $list_taget_agri_id );
        (new ListTargetAgri)->update( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset($_GET['delete']) ) {

    $list_taget_agri_id = $_GET['list_taget_agri_id'];
    if( '' != $list_taget_agri_id ) {
        $params = array( $list_taget_agri_id );
        (new ListTargetAgri)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>จัดการพืชและพื้นที่</h1>
                    </div>
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
        <!-- </div> -->
    <!-- .content -->
        <div class="content mt-3">

        <div class="animated fadeIn" id="ListTargetAgri">
                <div class="row">

                    <div class="col-md-12">
                    <div class="card" >
                            <div class="card-header search_td" style=" cursor: pointer; " data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="search">
                                <strong class="card-title"><i class="menu-icon fa fa-search"></i> ค้นหา</strong>
                            </div>
                            <div class="card-body collapse" id='search'>
                                <form action="<?php $current_url?>" method="post" id="search">
                                    <input type="hidden" name="searchForm" value="N" />
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="idRiverBasinSearch" id="idRiverBasinSearch">
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
                                            <select class="form-control" name="idAreaSearch" id="idAreaSearch">
                                                <option value="null">กรุณาเลือก</option>
                                            </select>
                                        </div>
                                    </div>
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
                                 <strong class="card-title">พืชและพื้นที่</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php 
                                            //if( !isset($_GET['edit']) ) : 
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idRiverBasin" id="idRiverBasin">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new MainBasin)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idRiverBasin"].'">'.$row["nameRiverBasin"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idArea" id="idArea">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        // foreach( (new Area)->get_all() AS $row ) {
                                                        //     echo '<option value="'.$row["idArea"].'">'.$row["areaName"].'</option>';
                                                        // }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
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
                                                <label for="inputext" class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idAgri" id="idAgri">
                                                        <option value="0">กรุณาเลือก</option>
                                                        <?php
                                                        // foreach( (new Agricultural)->get_all() AS $row ) {
                                                        //     echo '<option value="'.$row["idAgri"].'">'.$row["nameArgi"].'</option>';
                                                        // }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 requie">
                                                    <label for="inputext" class="col-sm-2 col-form-label">*</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกรด</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control selectpicker multiselect" data-live-search="true" multiple name="idGrade" id="idGrade">
                                                        <?php
                                                        foreach( (new Grade)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idGrade"].'">'.$row["codeGrade"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" name="idGrades" id="multiselectvalues" value="" />
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สถานะ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="0">กรุณาเลือก</option>
                                                        <option value="N">N</option>
                                                        <option value="Y">Y</option>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="row" id="test">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddListTargetAgri" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>
                                                </div>
                                            </div>
                                            <?php
                                                //else : 
                                            ?>
                                            <?php 
                                            // $list_taget_agri_id = $_GET['list_taget_agri_id'];
                                            // $result = (new ListTargetAgri)->get_by_id( $list_taget_agri_id );
                                            ?>
                                            <!-- <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idRiverBasin" id="idRiverBasin">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                            // foreach( (new MainBasin)->get_all() AS $row ) {
                                                            //     echo '<option value="'.$row["idRiverBasin"].'">'.$row["nameRiverBasin"].'</option>';
                                                            //     echo '<option value="'.$row["idRiverBasin"].'" '.( $row["idRiverBasin"] == $result['RiverBasin_idRiverBasin'] ? 'selected' : '' ).'>'.$row["nameRiverBasin"].'</option>';
                                                            // }
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
                                                        // foreach( (new Area)->get_all() AS $row ) {
                                                        //     echo '<option value="'.$row["idArea"].'" '.( $row["idArea"] == $result['idArea'] ? 'selected' : '' ).'>'.$row["areaName"].'</option>';
                                                        // }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สาขาพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idTypeOfArgi" id="idTypeOfArgi">
                                                    <?php
                                                        // foreach( (new TypeOfArgi)->get_all() AS $row ) {
                                                        //     echo '<option value="'.$row["idTypeOfArgi"].'" '.( $row["idTypeOfArgi"] == $result['idTypeOfArgi'] ? 'selected' : '' ).'>'.$row["nameTypeOfArgi"].'</option>';
                                                        // }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ชนิดพืช</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idAgri" id="idAgri">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        // foreach( (new Agricultural)->get_all() AS $row ) {
                                                        //     echo '<option value="'.$row["idAgri"].'" '.( $row["idAgri"] == $result['idAgri'] ? 'selected' : '' ).'>'.$row["nameArgi"].'</option>';
                                                        // }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกรด</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idGrade" id="idGrade">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Grade)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idGrade"].'" '.( $row["idGrade"] == $result['idGrade'] ? 'selected' : '' ).'>'.$row["codeGrade"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สถานะ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="">กรุณาเลือก</option>
                                                        <option value="N" <?php echo ( 'N' == $result['status'] ? 'selected' : '' ); ?>>N</option>
                                                        <option value="Y" <?php echo ( 'Y' == $result['status'] ? 'selected' : '' ); ?>>Y</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditListTargetAgri" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="list_taget_agri_id" value="<?php echo $list_taget_agri_id; ?>" />
                                                </div>
                                            </div> -->
                                            <?php
                                            // endif;
                                            ?>
                                       </form>
                                       
                                </div>
                            <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-bordered datatables" id="listTargetAgri-table">
                                    <thead>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>พื้นที่</th>
                                            <th>สาขาพืช</th>
                                            <th>ชนิดพืช</th>
                                            <th>เกรด</th>
                                            <!-- <th>สถานะ</th> -->
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // foreach( (new ListTargetAgri)->get_all() AS $row ) {
                                    //     $id = $row["list_taget_agri_id"];
                                    //     echo '<tr>';
                                    //     echo '<td>'.$id.'</td>';
                                    //     echo '<td>'.$row["areaName"].'</td>';
                                    //     echo '<td>'.$row["nameTypeOfArgi"].'</td>';
                                    //     echo '<td>'.$row["nameArgi"].'</td>';
                                    //     echo '<td>'.$row["codeGrade"].'</td>';
                                    //     echo '<td>'.$row["status"].'</td>';
                                    //     //echo '<td><a href="'.$current_url.'?edit&list_taget_agri_id='.$id.'"><span class="ti-pencil"></span></a> ';
                                    //     echo '<td><i class=" fa fa-pencil-square-o" id="editListTargetAgri" style=" cursor: pointer;margin-right: 10px;"></i>';
                                    //     echo '<a href="'.$current_url.'?delete&list_taget_agri_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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
<script src="../assets/hrdi_js/targetAgriJs.js"></script>
