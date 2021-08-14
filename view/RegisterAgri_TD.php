<?php
include_once('header.php');

$current_url = 'RegisterAgri_TD.php';

if( isset( $_POST['AddRegisterAgri_TD'] ) ) {
    $idPersons = $_POST['idPersons'];
    $idArea = $_POST['idArea'];
    $idAgri = $_POST['idAgri'];
    $register_year = $_POST['register_year'];
    if( '' != $idPersons && '0' != $idArea && '0' != $idAgri ) {
        $idPersons = explode(',', $idPersons);
        foreach( $idPersons AS $idPerson ) {
            $params = array( $idPerson, $idArea, $idAgri, $register_year );
            (new RegisterAgri_TD)->insert( $params );
        }
    }
}

if( isset( $_POST['EditRegisterAgri_TD'] ) ) {
    $idPerson = $_POST['idPerson'];
    $idArea = $_POST['idArea'];
    $idAgri = $_POST['idAgri'];
    $register_year = $_POST['register_year'];
    $regisAgri_id = $_POST['regisAgri_id'];
    if( '0' != $idPerson && '0' != $idArea && '0' != $idAgri && '' != $regisAgri_id ) {
        $params = array( $idPerson, $idArea, $idAgri, $register_year, $regisAgri_id );
        (new RegisterAgri_TD)->update( $params );
    }
}

if( isset($_GET['delete']) ) {

    $regisAgri_id = $_GET['regisAgri_id'];
    if( '' != $regisAgri_id ) {
        $params = array( $regisAgri_id );
        (new RegisterAgri_TD)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>การส่งเสริมพืช</h1>
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

        <div class="animated fadeIn" id="RegisterAgri_TD">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
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
                                 <strong class="card-title">การส่งเสริมพืช</strong>
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
                                                        // foreach( (new Area)->get_all() AS $row ) {
                                                        //     echo '<option value="'.$row["idArea"].'">'.$row["areaName"].'</option>';
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
                                                    foreach( (new TypeOfArgi)->get_all() AS $row ) {
                                                        echo '<option value="'.$row["idTypeOfArgi"].'">'.$row["nameTypeOfArgi"].'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พืชที่ส่งเสริม</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idAgri" id="idAgri">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        // foreach( (new Agricultural)->get_all() AS $row ) {
                                                        //     echo '<option value="'.$row["idAgri"].'">'.$row["nameArgi"].'</option>';
                                                        // }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ปีที่ส่งเสริม</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="register_year" name="register_year" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกษตรกร</label>
                                                <div class="col-sm-4">
                                                    <!-- <select class="form-control" name="idPerson" id="idPerson"> -->
                                                    <select class="form-control selectpicker multiselect" multiple data-live-search="true" name="idPerson" id="idPerson">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        ?>
                                                    </select>
                                                    <input type="hidden" name="idPersons" id="multiselectvalues" value="" />
                                                </div>
                                            </div>
                                            <div class="row" id="test">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddRegisterAgri_TD" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <!-- <?php 
                                            $regisAgri_id = $_GET['regisAgri_id'];
                                            $customer = (new RegisterAgri_TD)->get_by_id( $regisAgri_id );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idArea" id="idArea">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Area)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idArea"].'" '.( $row["idArea"] == $customer['idArea'] ? 'selected' : '' ).'>'.$row["areaName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
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
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">พืชที่ส่งเสริม</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idAgri" id="idAgri">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Agricultural)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idAgri"].'" '.( $row["idAgri"] == $customer['idAgri'] ? 'selected' : '' ).'>'.$row["nameArgi"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ปีที่ส่งเสริม</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="register_year" value="<?php echo $result['register_year']; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">เกษตรกร</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" name="idPerson" id="idPerson">
                                                        <option value="">กรุณาเลือก</option>
                                                        <?php
                                                        foreach( (new Person)->get_all() AS $row ) {
                                                            echo '<option value="'.$row["idPerson"].'" '.( $row["idPerson"] == $customer['idPerson'] ? 'selected' : '' ).'>'.$row["firstName"].' '.$row["lastName"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditRegisterAgri_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="regisAgri_id" value="<?php echo $regisAgri_id; ?>" />
                                                </div>
                                            </div> -->
                                       </form>
                                       
                                </div>
                            <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-bordered datatables" id="datatableRegister">
                                    <thead>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>พื้นที่</th>
                                            <th>พืชที่ส่งเสริม</th>
                                            <th>ปีที่ส่งเสริม</th>
                                            <th>เกษตรกร</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // foreach( (new RegisterAgri_TD)->get_all() AS $row ) {
                                        //     $id = $row["regisAgri_id"];
                                        //     echo '<tr>';
                                        //     echo '<td>'.$id.'</td>';
                                        //     echo '<td>'.$row["areaName"].'</td>';
                                        //     echo '<td>'.$row["nameArgi"].'</td>';
                                        //     echo '<td>'.$row["register_year"].'</td>';
                                        //     echo '<td>'.$row["firstName"].' '.$row["lastName"].'</td>';
                                        //     echo '<td><i class=" fa fa-pencil-square-o" id="editRegisterAgri" style=" cursor: pointer;margin-right: 10px;"></i> ';
                                        //     echo '<a href="'.$current_url.'?delete&regisAgri_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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
<script src="../assets/hrdi_js/registerAgriJs.js"></script>
