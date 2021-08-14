<?php 
    function loadGradeOfProduct($conn, $argi_id ,$area_Id){
        $sql2 = "
          SELECT gd.idGrade, gd.codeGrade
          FROM list_taget_agri ltg, Grade gd
          WHERE ltg.grade = gd.idGrade 
          and agri_id = '".$argi_id."' 
          and area_id = '".$area_Id."'";
        $stmt = sqlsrv_query( $conn, $sql2 );
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $id_pre=$row["idGrade"];
          $name_pre=$row["codeGrade"];
          $data .= "<option value='$id_pre'> $name_pre</option>";
        }
      echo $data;
    }

    function loadStandardOfProduct($conn, $argi_id ,$area_Id){
        // $sql2 = "
        //   SELECT gd.idGrade, gd.codeGrade
        //   FROM list_taget_agri ltg, Grade gd
        //   WHERE ltg.grade = gd.idGrade 
        //   and agri_id = '".$argi_id."' 
        //   and area_id = '".$area_Id."'";
        // $stmt = sqlsrv_query( $conn, $sql2 );
        // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        //   $id_pre=$row["idGrade"];
        //   $name_pre=$row["codeGrade"];
        //   $data .= "<option value='$id_pre'> $name_pre</option>";
        // }
        echo $data;
    }

    function loadUnitCodeOfProduct($conn, $argi_id){
        $sql2 = "
          SELECT Cun.nameCountUnit
          FROM Agri_TD ag, CountUnit cun
          WHERE ag.unit_id = cun.idCountUnit 
          and ag.agri_id = '".$argi_id."'";
        $stmt = sqlsrv_query( $conn, $sql2 );
        $data = sqlsrv_get_field( $stmt, 0);
        echo $data;
    }
?>