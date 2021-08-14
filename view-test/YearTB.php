<?php
include_once('header.php');

$current_url = 'YearTB.php';

// print_r( YearTB::get_all() );

if( isset( $_POST['AddYearTB'] ) ) {
    $nameYear = $_POST['nameYear'];
    $idYearTB = $nameYear;
    $dateStart = $_POST['dateStart'];
    $dateStop = $_POST['dateStop'];
    if( '' != $idYearTB && '' != $nameYear && '' != $dateStart && '' != $dateStop ) {
        $params = array( $idYearTB, $nameYear, $dateStart, $dateStop, '' );
        (new YearTB)->insert( $params );
    }
}

if( isset( $_POST['EditYearTB'] ) ) {
    $nameYear = $_POST['nameYear'];
    $dateStart = $_POST['dateStart'];
    $dateStop = $_POST['dateStop'];
    $idYearTB = $_POST['idYearTB'];
    if( '' != $nameYear && '' != $dateStart && '' != $dateStop && '' != $idYearTB ) {
        $params = array( $nameYear, $dateStart, $dateStop, '', $idYearTB );
        (new YearTB)->update( $params );
    }
}

if( isset($_GET['delete']) ) {
    $idYearTB = $_GET['idYearTB'];
    if( '' != $idYearTB ) {
        $params = array( $idYearTB );
        (new YearTB)->delete( $params );
        echo '<script langquage="javascript">window.location="'.$current_url.'";</script>';
    }
}
?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Manage YearTB</h1>
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
                                 <strong class="card-title">YearTB</strong>
                                </div>
                                
                            </div>
                            </div>

                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body" id='criteria'>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if( !isset($_GET['edit']) ) : ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ปีงบประมาณ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="nameYear" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">วันที่เริ่มต้นปีงบประมาณ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="dateStart" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">วันที่สิ้นสุดปีงบประมาณ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="dateStop" value="" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="AddYearTB" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <?php else : ?>
                                            <?php 
                                            $idYearTB = $_GET['idYearTB'];
                                            $result = (new YearTB)->get_by_id( $idYearTB );
                                            // print_r( $result );
                                            ?>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ปีงบประมาณ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="nameYear" value="<?php echo $result['nameYear']; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">วันที่เริ่มต้นปีงบประมาณ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="dateStart" value="<?php echo $result["dateStart"]->date; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">วันที่สิ้นสุดปีงบประมาณ</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="dateStop" value="<?php echo $result['dateStop']->date; ?>" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" name="EditYearTB" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>
                                                    <input type="hidden" name="idYearTB" value="<?php echo $idYearTB; ?>" />
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
                                            <th>ปีงบประมาณ</th>
                                            <th>วันที่เริ่มต้นปีงบประมาณ</th>
                                            <th>วันที่สิ้นสุดปีงบประมาณ</th>
                                            <th><center>แก้ไข</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = (new YearTB)->get_all();
                                    // print_r( $result );
                                    foreach( $result AS $row ) {
                                        $id = $row["idYearTB"];
                                        echo '<tr>';
                                        echo '<td>'.$id.'</td>';
                                        echo '<td>'.$row["nameYear"].'</td>';
                                        echo '<td>'.$row["dateStart"]->date.'</td>';
                                        echo '<td>'.$row["dateStop"]->date.'</td>';
                                        echo '<td><center><a href="'.$current_url.'?edit&idYearTB='.$id.'"><span class="fa fa-pencil-square-o" style=" cursor: pointer;margin-right: 10px; color:blue;"></span></a></center> ';
                                        // echo '<a href="'.$current_url.'?delete&idYearTB='.$id.'" onclick="return confirm(\'Are you sure?\')"><span class="ti-trash"></span></a></td>';
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