<?php
include_once('header.php');

$current_url = 'position_TD.php';

// print_r( position_TD::get_all() );

if( isset( $_POST['Addposition_TD'] ) ) {
    $position_name = $_POST['position_name'];
    if( '' != $position_name ) {
        $params = array( $position_name );
        (new position_TD)->insert( $params );
    }
}

if( isset( $_POST['Editposition_TD'] ) ) {
    $position_name = $_POST['position_name'];
    $position_id = $_POST['position_id'];
    if( '' != $position_name && '' != $position_id ) {
        $params = array( $position_name, $position_id );
        (new position_TD)->update( $params );
    }
}

if( isset($_GET['delete']) ) {
    $position_id = $_GET['position_id'];
    if( '' != $position_id ) {
        $params = array( $position_id );
        (new position_TD)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Manage position_TD</h1>
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
                                 <strong class="card-title">ตำแหน่ง</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if( !isset($_GET['edit']) ) : ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ชื่อตำแหน่ง</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="position_name" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="Addposition_TD" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $position_id = $_GET['position_id'];
                                            $result = (new position_TD)->get_by_id( $position_id );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ชื่อตำแหน่ง</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="position_name" value="<?php echo $result['position_name']; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="Editposition_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="position_id" value="<?php echo $position_id; ?>" />
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
                                            <th>รหัสชื่อตำแหน่ง</th>
                                            <th>ชื่อตำแหน่ง</th>
                                            <th>แก้ไข/ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = (new position_TD)->get_all();
                                    foreach( $result AS $row ) {
                                        $id = $row["position_id"];
                                        echo '<tr>';
                                        echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["position_name"].'</td>';
                                        echo '<td><a href="'.$current_url.'?edit&position_id='.$id.'"><span class="ti-pencil"></span></a> ';
                                        echo '<a href="'.$current_url.'?delete&position_id='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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