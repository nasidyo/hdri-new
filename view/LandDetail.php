<?php
include_once('header.php');

$current_url = 'LandDetail.php';

// print_r( LandDetail::get_all() );

if( isset( $_POST['AddLandDetail'] ) ) {
    $idPerson = $_POST['idPerson'];
    $Land_NO = $_POST['Land_NO'];
    $X = $_POST['X'];
    $Y = $_POST['Y'];
    $Z = $_POST['Z'];
    $basin_quality_class = $_POST['basin_quality_class'];
    $forest_area_classified = $_POST['forest_area_classified'];
    $forest_type = $_POST['forest_type'];
    $forest_name = $_POST['forest_name'];
    $unit1 = $_POST['unit1'];
    $unit2 = $_POST['unit2'];
    $unit3 = $_POST['unit3'];
    $unit4 = $_POST['unit4'];
    if( '0' != $idPerson ) {
        $params = array( $idPerson, $Land_NO, $X, $Y, $Z, $basin_quality_class, $forest_area_classified, $forest_type, $forest_name, $unit1, $unit2, $unit3, $unit4 );
        (new LandDetail)->insert( $params );
    }
}

if( isset( $_POST['EditLandDetail'] ) ) {
    $idPerson = $_POST['idPerson'];
    $Land_NO = $_POST['Land_NO'];
    $X = $_POST['X'];
    $Y = $_POST['Y'];
    $Z = $_POST['Z'];
    $basin_quality_class = $_POST['basin_quality_class'];
    $forest_area_classified = $_POST['forest_area_classified'];
    $forest_type = $_POST['forest_type'];
    $forest_name = $_POST['forest_name'];
    $unit1 = $_POST['unit1'];
    $unit2 = $_POST['unit2'];
    $unit3 = $_POST['unit3'];
    $unit4 = $_POST['unit4'];
    $land_detail_id = $_POST['land_detail_id'];
    if( '0' != $idPerson && '' != $land_detail_id ) {
        $params = array( $idPerson, $Land_NO, $X, $Y, $Z, $basin_quality_class, $forest_area_classified, $forest_type, $forest_name, $unit1, $unit2, $unit3, $unit4, $land_detail_id );
        (new LandDetail)->update( $params );
    }
}

if( isset($_GET['delete']) ) {
    $land_detail_id = $_GET['land_detail_id'];
    if( '' != $land_detail_id ) {
        $params = array( $land_detail_id );
        (new LandDetail)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Manage LandDetail</h1>
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
                            <div class="card-header">
                           
                            
                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                 <strong class="card-title">LandDetail</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if( !isset($_GET['edit']) ) : ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกษตรกร</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idPerson" id="idPerson">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Person_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idPerson"].'">'.$row["firstName"].' '.$row["lastName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">รหัสแปลง</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Land_NO" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พิกัด X</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="X" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พิกัด Y</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Y" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พิกัด Z</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Z" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">basin_quality_class</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="basin_quality_class" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">forest_area_classified</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="forest_area_classified" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">forest_type</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="forest_type" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">forest_name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="forest_name" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">จำนวนไร</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit1" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">จำนวนงาน</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit2" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">จำนวนวา</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit3" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">unit4</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit4" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddLandDetail" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $land_detail_id = $_GET['land_detail_id'];
                                            $customer = (new LandDetail)->get_by_id( $land_detail_id );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกษตรกร</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idPerson" id="idPerson">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Person_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idPerson"].'" '.( $row["idPerson"] == $customer['idPerson'] ? 'selected' : '' ).'>'.$row["firstName"].' '.$row["lastName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">รหัสแปลง</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Land_NO" value="<?php echo $row["land_no"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พิกัด X</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="X" value="<?php echo $row["x"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พิกัด Y</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Y" value="<?php echo $row["y"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พิกัด Z</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Z" value="<?php echo $row["z"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">basin_quality_class</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="basin_quality_class" value="<?php echo $row["basin_quality_class"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">forest_area_classified</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="forest_area_classified" value="<?php echo $row["forest_area_classified"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">forest_type</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="forest_type" value="<?php echo $row["forest_type"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">forest_name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="forest_name" value="<?php echo $row["forest_name"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">จำนวนไร</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit1" value="<?php echo $row["unit1"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">จำนวนงาน</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit2" value="<?php echo $row["unit2"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">จำนวนวา</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit3" value="<?php echo $row["unit3"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">unit4</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="unit4" value="<?php echo $row["unit4"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditLandDetail" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="land_detail_id" value="<?php echo $land_detail_id; ?>" />
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
                                            <th>เกษตรกร</th>
                                            <th>รหัสแปลง</th>
                                            <th>basin_quality_class</th>
                                            <th>forest_area_classified</th>
                                            <th>forest_type</th>
                                            <th>forest_name</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach( (new LandDetail)->get_all() AS $row ) {
                                        $id = $row["land_detail_id"];
                                        echo '<tr>';
                                        echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["firstName"].' '.$row["lastName"].'</td>';
                                        echo '<td>'.$row["land_no"].'</td>';
                                        echo '<td>'.$row["basin_quality_class"].'</td>';
                                        echo '<td>'.$row["forest_area_classified"].'</td>';
                                        echo '<td>'.$row["forest_type"].'</td>';
                                        echo '<td>'.$row["forest_name"].'</td>';
                                        echo '<td><a href="'.$current_url.'?edit&land_detail_id='.$id.'"><span class="ti-pencil"></span></a> ';
                                        echo '<a href="'.$current_url.'?delete&land_detail_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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