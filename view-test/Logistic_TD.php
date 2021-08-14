<?php
include_once('header.php');

$current_url = 'Logistic_TD.php';

// print_r( Logistic_TD::get_all() );

if( isset( $_POST['AddLogistic_TD'] ) ) {
    $logistic_name = $_POST['logistic_name'];
    $X = $_POST['X'];
    if( '' != $logistic_name ) {
        $params = array( $logistic_name );
        (new Logistic_TD)->insert( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset( $_POST['EditLogistic_TD'] ) ) {
    $logistic_name = $_POST['logistic_name'];
    $logistic_id = $_POST['logistic_id'];
    if( '' != $logistic_name && '' != $logistic_id ) {
        $params = array( $logistic_name, $logistic_id );
        (new Logistic_TD)->update( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}

if( isset($_GET['delete']) ) {
    $logistic_id = $_GET['logistic_id'];
    if( '' != $logistic_id ) {
        $params = array( $logistic_id );
        (new Logistic_TD)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>วิธีการขนส่ง</h1>
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
                                 <strong class="card-title">วิธีการขนส่ง</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if( !isset($_GET['edit']) ) : ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">วิธีการขนส่ง</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="logistic_name" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddLogistic_TD" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $logistic_id = $_GET['logistic_id'];
                                            $result = (new Logistic_TD)->get_by_id( $logistic_id );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">วิธีการขนส่ง</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="logistic_name" value="<?php echo $result["logistic_name"]; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditLogistic_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> แก้ไขข้อมูล</button>
                                                    <input type="hidden" name="logistic_id" value="<?php echo $logistic_id; ?>" />
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="Logistic_TD.php" class="btn btn-primary">ยกเลิก</a>
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
                                            <!-- <th>รหัสการขนส่ง</th> -->
                                            <th>วิธีการขนส่ง</th>
                                            <th><center>แก้ไข</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = (new Logistic_TD)->get_all();
                                    foreach( $result AS $row ) {
                                        $id = $row["logistic_id"];
                                        echo '<tr>';
                                        // echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["logistic_name"].'</td>';
                                        echo '<td><center><a href="'.$current_url.'?edit&logistic_id='.$id.'"><span class="fa fa-pencil-square-o" style=" cursor: pointer;margin-right: 10px; color:blue;"></span></a></center> ';
                                        // echo '<a href="'.$current_url.'?delete&logistic_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash" class="ti-trash" style=" cursor: pointer; margin-right: 10px; color:red;"></span></a></td>';
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