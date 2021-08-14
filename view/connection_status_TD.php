<?php
include_once('header.php');

$current_url = 'connection_status_TD.php';

// print_r( connection_status_TD::get_all() );

if( isset( $_POST['Addconnection_status_TD'] ) ) {
    $conn_status_name = $_POST['conn_status_name'];
    $X = $_POST['X'];
    if( '' != $conn_status_name ) {
        $params = array( $conn_status_name );
        (new connection_status_TD)->insert( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset( $_POST['Editconnection_status_TD'] ) ) {
    $conn_status_name = $_POST['conn_status_name'];
    $conn_status_id = $_POST['conn_status_id'];
    if( '' != $conn_status_name && '' != $conn_status_id ) {
        $params = array( $conn_status_name, $conn_status_id );
        (new connection_status_TD)->update( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset($_GET['delete']) ) {
    $conn_status_id = $_GET['conn_status_id'];
    if( '' != $conn_status_id ) {
        $params = array( $conn_status_id );
        (new connection_status_TD)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>สถานะการติดต่อ</h1>
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
                                 <strong class="card-title">สถานะการติดต่อ</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if( !isset($_GET['edit']) ) : ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สถานะการติดต่อ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="conn_status_name" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="Addconnection_status_TD" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $conn_status_id = $_GET['conn_status_id'];
                                            $result = (new connection_status_TD)->get_by_id( $conn_status_id );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">สถานะการติดต่อ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="conn_status_name" value="<?php echo $result["conn_status_name"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="Editconnection_status_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> แก้ไขข้อมูล</button>
                                                    <input type="hidden" name="conn_status_id" value="<?php echo $conn_status_id; ?>" />
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="connection_status_TD.php" class="btn btn-primary">ยกเลิก</a>
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
                                            <!-- <th>รหัสสถานะการติดต่อ</th> -->
                                            <th>สถานะการติดต่อ</th>
                                            <th><center>แก้ไข</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = (new connection_status_TD)->get_all();
                                    foreach( $result AS $row ) {
                                        $id = $row["conn_status_id"];
                                        echo '<tr>';
                                        // echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["conn_status_name"].'</td>';
                                        echo '<td><center><a href="'.$current_url.'?edit&conn_status_id='.$id.'"><span class="fa fa-pencil-square-o" style=" cursor: pointer;margin-right: 10px; color:blue;"></span></a></center> ';
                                        // echo '<a href="'.$current_url.'?delete&conn_status_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash" style=" cursor: pointer; margin-right: 10px; color:red; "></span></a></td>';
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