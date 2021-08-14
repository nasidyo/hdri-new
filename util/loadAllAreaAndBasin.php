<?php 
  function loadAllAreaAndBasin ($conn) {
    $sql="  SELECT fbasin_id, fbasin_name 
    FROM vLinkAreaDetail
    WHERE target_area_type_id IN (3,10 ,5)
    GROUP BY fbasin_id, fbasin_name
    ORDER BY fbasin_name ASC";
    $stmt = sqlsrv_query( $conn, $sql );
    $data="<option value='0'>กรุณาเลือก</option>";
    $tempBasinId ='';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $sql2 =" SELECT target_id, target_area_type_title+' '+target_name as fullTargetName 
        FROM vLinkAreaDetail 
        WHERE fbasin_id = '".$row['fbasin_id']."' and target_area_type_id IN (3,10 ,5) 
        GROUP BY target_id, target_name , target_area_type_title
        ORDER BY target_id ASC";
        $stmt1 = sqlsrv_query( $conn, $sql2 );
        while( $row2 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
          $id_pre=$row2["target_id"];
          $name_pre= $row2["fullTargetName"];
          if($tempBasinId != $row['fbasin_id']){
              if($tempBasinId == ''){
                  $data.="<optgroup label='".$row['fbasin_name']."'>";
                  $tempBasinId = $row['fbasin_id'];
              }else{
                  $data.="</optgroup>";
                  $tempBasinId = $row['fbasin_id'];
                  $data.="<optgroup label='".$row['fbasin_name']."'>";
              }
              $data.= "<option value='$id_pre'> $name_pre</option>";
          }else{
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }
        }
        $data.="</optgroup>";
    }
    echo $data;
  }
?>