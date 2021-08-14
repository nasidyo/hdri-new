<?php


function loadRiverDependent($conn){
    $sql2=" SELECT rb.idRiverBasin, rb.nameRiverBasin FROM RiverBasin rb where rb.idRiverBasin not in (1,22) ";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data="<option value='0'>กรุณาเลือก</option>";
     
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["idRiverBasin"];
      $name_pre=$row["nameRiverBasin"];
      $data.= "<option value='$id_pre'> $name_pre</option>";
    }
   echo  $data;
}

function loadRiverDependentBySS($conn,$idRiverBasin){
    $sql2=" SELECT rb.idRiverBasin, rb.nameRiverBasin FROM RiverBasin rb  where 1=1 ";
    $data="<option value='0'>กรุณาเลือก</option>";
    if($idRiverBasin!="" && $idRiverBasin!=0){
        $sql2 .="and rb.idRiverBasin = ".$idRiverBasin;
        $data="";
    }

    $stmt = sqlsrv_query( $conn, $sql2 );

    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["idRiverBasin"];
      $name_pre=$row["nameRiverBasin"];
      $data.= "<option value='$id_pre'> $name_pre</option>";
    }
   echo  $data;
}


function loadAreaDependentBySS($conn,$idRiverBasin ,$idArea){
    $sql2="  SELECT idArea, areaName FROM Area WHERE target_area_type_id in (3,10 ,5) ";
    $data="";
    if($idRiverBasin!=0 && $idRiverBasin!=""){
        $sql2.="and RiverBasin_idRiverBasin =".$idRiverBasin;
    }
     if($idArea!="" && $idArea!=0){
        $sql2 .="and idArea  = ".$idArea;
    }else{
        $data.="<option value='0'>กรุณาเลือก</option>";
    }
    $stmt = sqlsrv_query( $conn, $sql2 );
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["idArea"];
      $name_pre=$row["areaName"];
      $data.= "<option value='$id_pre'> $name_pre</option>";
    }
   echo  $data;
}



function loadRiverDependentInSS($conn,$idRiverBasin){
    $sql2=" SELECT fbasin_id, fbasin_name FROM vLinkAreaDetail rb  where 1=1 ";
    if($idRiverBasin!="" && $idRiverBasin!=0){
        $sql2.="and rb.fbasin_id  in ( ".$idRiverBasin." )";
    }
    $sql2.="GROUP BY fbasin_id, fbasin_name 
    ORDER BY fbasin_name DESC";

    $stmt = sqlsrv_query( $conn, $sql2 );
    $data="<option value='0'>กรุณาเลือก</option>";
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["fbasin_id"];
      $name_pre=$row["fbasin_name"];
      $data.= "<option value='$id_pre'> $name_pre</option>";
    }
   echo  $data;
}


function loadAreaDependentInSS($conn,$idRiverBasin ,$idArea){
    $sql2="  SELECT idArea, areaName FROM Area WHERE target_area_type_id in (3,10 ,5) ";
    $data="";
    if($idRiverBasin!=0 || $idRiverBasin!=""){
        $sql2.="and RiverBasin_idRiverBasin in (".$idRiverBasin.")";
    }
    if($idArea!="" || $idArea!=0){
        $sql2 .="and idArea in (".$idArea.")";
    }else{
        $data.="<option value='0'>กรุณาเลือก</option>";
    }
    $stmt = sqlsrv_query( $conn, $sql2 );
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["idArea"];
      $name_pre=$row["areaName"];
      $data.= "<option value='$id_pre'> $name_pre</option>";
    }
   echo  $data;
}

function loadAllBasin ($conn){
  $sql2="  SELECT fbasin_id, fbasin_name 
      FROM vLinkAreaDetail 
      GROUP BY fbasin_id, fbasin_name
      ORDER BY fbasin_name ASC";
  $stmt = sqlsrv_query( $conn, $sql2 );
  $data="<option value='0'>กรุณาเลือก</option>";
  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre=$row["fbasin_id"];
    $name_pre=$row["fbasin_name"];
    $data.= "<option value='$id_pre'> $name_pre</option>";
  }
 echo  $data;
}

function loadAreaDependentInCKDeliver ($conn,$idRiverBasin ,$idArea, $yearId){
  $sql2="  SELECT a.idArea, a.areaName 
          FROM Area a
          INNER JOIN SendStatusPlan_TD sp ON a.idArea = sp.Area_idArea 
          WHERE target_area_type_id in (3,10 ,5) and sp.YearID = '".$yearId."' and sp.idStatusPlan = '4'";
  $data="";
  if($idRiverBasin!=0 && $idRiverBasin!=""){
      $sql2.="and a.RiverBasin_idRiverBasin in (".$idRiverBasin.")";
  }
  if($idArea != 0 || $idArea != null){
      $sql2 .="and a.idArea  in  (".$idArea.")";
      $data.="<option value='0'>กรุณาเลือก</option>";
  }else{
    $data.="<option value='0'>กรุณาเลือก</option>";
  }
  $stmt = sqlsrv_query( $conn, $sql2 );
  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre=$row["idArea"];
    $name_pre=$row["areaName"];
    $data.= "<option value='$id_pre'> $name_pre</option>";
  }
 echo  $data;
}

?>
