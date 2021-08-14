<?php
include_once('header.php');

$current_url = 'PlantHouse.php';

// print_r( PlantHouse::get_all() );

if( isset( $_POST['AddPlantHouse'] ) ) {
    $idArea = $_POST['idArea'];
    $idLand = $_POST['idLand'];
    $houseNumber = $_POST['houseNumber'];
    $X = $_POST['X'];
    if( '0' != $idArea && '0' != $idLand ) {
        $params = array( $idArea, $idLand, $houseNumber );
        (new PlantHouse)->insert( $params );
    }
}

if( isset( $_POST['EditPlantHouse'] ) ) {
    $idArea = $_POST['idArea'];
    $idLand = $_POST['idLand'];
    $houseNumber = $_POST['houseNumber'];
    $X = $_POST['X'];
    $plantHouse_Id = $_POST['plantHouse_Id'];
    if( '0' != $idArea && '0' != $idLand && '' != $plantHouse_Id ) {
        $params = array( $idArea, $idLand, $houseNumber, $plantHouse_Id );
        (new PlantHouse)->update( $params );
    }
}

if( isset($_GET['delete']) ) {
    $plantHouse_Id = $_GET['plantHouse_Id'];
    if( '' != $plantHouse_Id ) {
        $params = array( $plantHouse_Id );
        (new PlantHouse)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Manage PlantHouse</h1>
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
                                 <strong class="card-title">PlantHouse</strong>
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
                                                <label for="inputext" class="col-sm-2 col-form-label">หมายเลขแปลง</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idLand" id="idLand">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Land_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idLand"].'">'.$row["idLand"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หมายเลขโรงเรือน</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="houseNumber" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddPlantHouse" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $plantHouse_Id = $_GET['plantHouse_Id'];
                                            $result = (new PlantHouse)->get_by_id( $plantHouse_Id );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idArea" id="idArea">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Area)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idArea"].'" '.( $row["idArea"] == $result['Area_idArea'] ? 'selected' : '' ).'>'.$row["areaName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หมายเลขแปลง</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idLand" id="idLand">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Land_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idLand"].'" '.( $row["idLand"] == $result['idLand'] ? 'selected' : '' ).'>'.$row["idLand"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">หมายเลขโรงเรือน</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="houseNumber" value="<?php echo $result["houseNumber"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditPlantHouse" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="plantHouse_Id" value="<?php echo $plantHouse_Id; ?>" />
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
                                            <th>หมายเลขแปลง</th>
                                            <th>หมายเลขโรงเรือน</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = (new PlantHouse)->get_all();
                                    foreach( $result AS $row ) {
                                        $id = $row["plantHouse_Id"];
                                        echo '<tr>';
                                        echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["areaName"].'</td>';
                                        echo '<td>'.$row["idLand"].'</td>';
                                        echo '<td>'.$row["houseNumber"].'</td>';
                                        echo '<td><a href="'.$current_url.'?edit&plantHouse_Id='.$id.'"><span class="ti-pencil"></span></a> ';
                                        echo '<a href="'.$current_url.'?delete&plantHouse_Id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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