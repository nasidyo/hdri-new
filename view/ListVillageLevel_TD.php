<?php
include_once('header.php');

$current_url = 'ListVillageLevel_TD.php';

// print_r( ListVillageLevel_TD::get_all() );

if( isset( $_POST['AddListVillageLevel_TD'] ) ) {
    $idArea = $_POST['idArea'];
    $idGroupVillage = $_POST['idGroupVillage'];
    $level = $_POST['level'];
    if( '0' != $idArea && '0' != $idGroupVillage && '' != $level ) {
        $params = array( $idArea, $idGroupVillage, $level );
        (new ListVillageLevel_TD)->insert( $params );
    }
}

if( isset( $_POST['EditListVillageLevel_TD'] ) ) {
    $idArea = $_POST['idArea'];
    $idGroupVillage = $_POST['idGroupVillage'];
    $level = $_POST['level'];
    $list_vill_level_id = $_POST['list_vill_level_id'];
    if( '0' != $idArea && '0' != $idGroupVillage && '' != $list_vill_level_id ) {
        $params = array( $idArea, $idGroupVillage, $level, $list_vill_level_id );
        (new ListVillageLevel_TD)->update( $params );
    }
}

if( isset($_GET['delete']) ) {

    $list_vill_level_id = $_GET['list_vill_level_id'];
    if( '' != $list_vill_level_id ) {
        $params = array( $list_vill_level_id );
        (new ListVillageLevel_TD)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Manage ListVillageLevel_TD</h1>
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

        <div id="ListVillageLevel_TD" class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                           
                            
                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                 <strong class="card-title">ListVillageLevel_TD</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if( !isset($_GET['edit']) ) : ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idArea" id="idArea">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Area)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idArea"].'">'.$row["areaName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หมู่บ้าน</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idGroupVillage" id="idGroupVillage">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new GroupVillage)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idGroupVillage"].'">'.$row["nameGroupVillage"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ระดับการส่งเสริม</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="level" id="level">
                                                        <option value="">กรุณาเลือก</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                        <option value="E">E</option>
                                                        <option value="F">F</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddListVillageLevel_TD" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $list_vill_level_id = $_GET['list_vill_level_id'];
                                            $result = (new ListVillageLevel_TD)->get_by_id( $list_vill_level_id );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idArea" id="idArea">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Area)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idArea"].'" '.( $row["idArea"] == $result['idArea'] ? 'selected' : '' ).'>'.$row["areaName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หมู่บ้าน</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idGroupVillage" id="idGroupVillage">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new GroupVillage)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idGroupVillage"].'" '.( $row["idGroupVillage"] == $result['idGroupVillage'] ? 'selected' : '' ).'>'.$row["nameGroupVillage"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ระดับการส่งเสริม</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="level" id="level">
                                                        <option value="">กรุณาเลือก</option>
                                                        <option value="A" <?php echo ( 'A' == $result['level'] ? 'selected' : '' ); ?>>A</option>
                                                        <option value="B" <?php echo ( 'B' == $result['level'] ? 'selected' : '' ); ?>>B</option>
                                                        <option value="C" <?php echo ( 'C' == $result['level'] ? 'selected' : '' ); ?>>C</option>
                                                        <option value="D" <?php echo ( 'D' == $result['level'] ? 'selected' : '' ); ?>>D</option>
                                                        <option value="E" <?php echo ( 'E' == $result['level'] ? 'selected' : '' ); ?>>E</option>
                                                        <option value="F" <?php echo ( 'F' == $result['level'] ? 'selected' : '' ); ?>>F</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditListVillageLevel_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="list_vill_level_id" value="<?php echo $list_vill_level_id; ?>" />
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                       </form>
                                       
                                </div>
                            <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-bordered datatables">
                                    <thead>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>พื้นที่</th>
                                            <th>หมู่บ้าน</th>
                                            <th>ระดับการส่งเสริม</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach( (new ListVillageLevel_TD)->get_all() AS $row ) {
                                        $id = $row["list_vill_level_id"];
                                        echo '<tr>';
                                        echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["areaName"].'</td>';
                                        $result = (new GroupVillage)->get_by_id( $row["idGroupVillage"] );
                                        echo '<td>'.$result['nameGroupVillage'].'</td>';
                                        echo '<td>'.$row['level'].'</td>';
                                        echo '<td><a href="'.$current_url.'?edit&list_vill_level_id='.$id.'"><span class="ti-pencil"></span></a> ';
                                        echo '<a href="'.$current_url.'?delete&list_vill_level_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
                                        echo '</tr>';
                                    }
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