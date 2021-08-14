<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $sql = "SELECT top 9 pt.firstName+' '+pt.lastName as fullname , pt.picName , a2.target_name , sum(pmt.TotalValue) as total
                FROM PersonMarket_TD pmt 
                INNER JOIN Person_TD pt ON pt.idPerson  = pmt.Person_idPerson 
                INNER JOIN Area a2 ON a2.idArea = pmt.Area_idArea 
                GROUP BY pt.firstName, pt.lastName, a2.target_name, pt.picName 
                ORDER BY total DESC";
    $stmt = sqlsrv_query( $conn, $sql);
    $data = '';
    $count = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        if($row['picName'] == '' || $row['picName'] == null) {
            $pic = "noavatar.png";
        }else{
            $pic = $row['picName'];
        }
        if($count == '0'){
            $data .= '<div class="row text-center mt-2">';
            $data .= '<div class="col-md-3 ml-5">
                    <img src="../img/Activity/'.$pic.'" alt="User Image" class="img-fluid rounded">
                    <a class="users-list-name mt-1" href="#">'.$row['fullname'].'</a>('.$row['target_name'].')
                    <span class="users-list-date">'.number_format($row['total']).' &#3647;</span>
                  </div>';
        }else{
            if($count%3 == 0){
                $data .= '</div><div class="row text-center mt-2">';
                $data .= '<div class="col-md-3 ml-5">
                    <img src="../img/Activity/'.$pic.'" alt="User Image" class="img-fluid rounded">
                    <a class="users-list-name mt-1" href="#">'.$row['fullname'].'</a>('.$row['target_name'].')
                    <span class="users-list-date">'.number_format($row['total']).' &#3647;</span>
                  </div>';
            }else{
                $data .= '<div class="col-md-3 ml-5">
                    <img src="../img/Activity/'.$pic.'" alt="User Image" class="img-fluid rounded">
                    <a class="users-list-name mt-1" href="#">'.$row['fullname'].'</a>('.$row['target_name'].')
                    <span class="users-list-date">'.number_format($row['total']).' &#3647;</span>
                  </div>';
            }
        }
        $count ++;
    }
    $data .= '</div>';
    echo $data;
?>