<?php
include_once('header.php');

$current_url = 'Organization_TD.php';

// print_r( Organization_TD::get_all() );

if( isset( $_POST['AddOrganization_TD'] ) ) {
    $idArea = $_POST['idArea'];
    $idPerson = $_POST['idPerson'];
    $position_id = $_POST['position_id'];
    $year = $_POST['year'];
    if( '0' != $idArea && '0' != $idPerson && '0' != $position_id ) {
        $params = array( $idArea, $idPerson, $position_id, $year );
        (new Organization_TD)->insert( $params );
    }
}

if( isset( $_POST['EditOrganization_TD'] ) ) {
    $idArea = $_POST['idArea'];
    $idPerson = $_POST['idPerson'];
    $position_id = $_POST['position_id'];
    $year = $_POST['year'];
    $organization_id = $_POST['organization_id'];
    if( '0' != $idArea && '0' != $idPerson && '0' != $position_id && '' != $organization_id ) {
        $params = array( $idArea, $idPerson, $position_id, $year, $organization_id );
        (new Organization_TD)->update( $params );
    }
}

if( isset($_GET['delete']) ) {
    $organization_id = $_GET['organization_id'];
    if( '' != $organization_id ) {
        $params = array( $organization_id );
        (new Organization_TD)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>โครงสร้างกลุ่มเกษตกร</h1>
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

        <div id="Organization_TD" class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                           
                            
                            <div class="row justify-content-between">
                                <div class="col-md-8 ">
                                 <strong class="card-title">โครงสร้างกลุ่มเกษตกร</strong>
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
                                                <label for="inputext" class="col-sm-2 col-form-label">ตำแหน่ง</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="position_id" id="position_id">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new position_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["position_id"].'">'.$row["position_name"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ปีพศ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="year" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddOrganization_TD" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $organization_id = $_GET['organization_id'];
                                            $result = (new Organization_TD)->get_by_id( $organization_id );
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
                                                <label for="inputext" class="col-sm-2 col-form-label">เกษตรกร</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idPerson" id="idPerson">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Person_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idPerson"].'" '.( $row["idPerson"] == $result['idPerson'] ? 'selected' : '' ).'>'.$row["firstName"].' '.$row["lastName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ตำแหน่ง</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="position_id" id="position_id">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new position_TD)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["position_id"].'" '.( $row["position_id"] == $result['position_id'] ? 'selected' : '' ).'>'.$row["position_name"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ปีพศ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="year" value="<?php echo $result['year']; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditOrganization_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>" />
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
                                            <th>รหัสโครงสร้าง</th>
                                            <th>พื้นที่</th>
                                            <th>เกษตรกร</th>
                                            <th>ตำแหน่ง</th>
                                            <th>ปี</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = (new Organization_TD)->get_all();
                                    foreach( $result AS $row ) {
                                        $id = $row["organization_id"];
                                        echo '<tr>';
                                        echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["areaName"].'</td>';
                                        echo '<td>'.$row["firstName"].' '.$row["lastName"].'</td>';
                                        echo '<td>'.$row["position_name"].'</td>';
                                        echo '<td>'.$row["year"].'</td>';
                                        echo '<td><a href="'.$current_url.'?edit&organization_id='.$id.'"><span class="ti-pencil"></span></a> ';
                                        echo '<a href="'.$current_url.'?delete&organization_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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