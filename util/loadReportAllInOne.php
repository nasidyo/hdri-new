<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sqlSelect1 = '';
    $sqlSelect2 = '';
    $sqlGroup = '';
    $sqlLabel = '';
    $sqlseq = '';
    $row_count = 0;

    $areaList = '';
    if (isset($_POST['areaList'])) {
        $areaList = $_POST['areaList'];
    }
    $agriList = '';
    if (isset($_POST['agriList'])) {
        $agriList = $_POST['agriList'];
    }
    $marketList = '';
    if (isset($_POST['marketList'])) {
        $marketList = $_POST['marketList'];
    }
    if (isset($_POST['years'])) {
        $years = $_POST['years'];
    }

    if($_POST["axisYL"]){
        $axisYL = $_POST["axisYL"];
        if($axisYL == 5 || $axisYL == 1){
            $sqlSelect1 = "Total";
        }else if ($axisYL == 2 || $axisYL == 3){
            $sqlSelect1 = "Weight";
        }else if ($axisYL == 4){
            $sqlSelect1 = "Price";
        }
    }

    if($_POST["axisYR"]){
        $axisYR = $_POST["axisYR"];
        if($axisYR == 5 || $axisYR == 1 ){
            $sqlSelect2 = "Total";
        }else if ($axisYR == 2 || $axisYR == 3){
            $sqlSelect2 = "Weight";
        }else if ($axisYR == 4){
            $sqlSelect2 = "Price";
        }
    }

    if($_POST["axisX"]){
        $axisX = $_POST["axisX"];
        if($axisX == 6){
            $sqlGroup = "yearId";
            $sqlLabel = "displayYear";
        }else if ($axisX == 1){
            $sqlGroup = "Month_id";
            $sqlLabel = "Month_name";
            $sqlseq = 'Month_seq';
        }else if ($axisX == 2){
            $sqlGroup = "idRiverBasin";
            $sqlLabel = "nameRiverBasin";
            $sqlseq = 'nameRiverBasin';
        }else if ($axisX == 3){
            $sqlGroup = "idArea";
            $sqlLabel = "target_name";
            
        }else if ($axisX == 4){
            $sqlGroup = "target_area_type_id";
            $sqlLabel = "target_area_type_title";
        }else if ($axisX == 5){
            $sqlGroup = "idMarket";
            $sqlLabel = "nameMarket";
        }else if ($axisX == 7){
            $sqlGroup = "TypeOfArgi_idTypeOfArgi";
            $sqlLabel = "nameTypeOfArgi";
        }else if ($axisX == 8){
            $sqlGroup = "idAgri";
            $sqlLabel = "nameArgi";
            // $sqlseq = ' ';
        }
    }

    $sql = "SELECT ";
    if($axisX == 8){
        if($agriList == ''){ 
            $sql .= "TOP 20 ";
        }
    }
    // $sql .= $sqlSelect1.', '.$sqlSelect2.', t1.'.$sqlGroup1;
    if(($axisYL == '5' || $axisYL == '2') && ($axisYR =='5' || $axisYR == '2')){
        $sql .= "COALESCE(SUM(vtp.".$sqlSelect1."),0) as value1, COALESCE(SUM(vtp.".$sqlSelect2."),0) as value2, vtp.".$sqlGroup." , vtp.".$sqlLabel." as Label";
        if($sqlseq != ''){
            $sql.=" , vtp.".$sqlseq." ";
        }
        $sql .= " FROM viewTargetPlan_TD vtp ";
        $sql .= "WHERE vtp.idTargetPlan IS NOT NULL";
        if($years != '0'){ $sql .= " AND vtp.yearId = ".$years." ";}
        if($areaList != ''){ 
            $imploded_arr = implode(',', $areaList );
            $sql .=" AND vtp.idArea in (".$imploded_arr.")";
        }
        if($agriList != ''){ 
            $imploded_arr = implode(',', $agriList );
            $sql .=" AND vtp.idAgri in (".$imploded_arr.")";
        }
        if($marketList != ''){ 
            $imploded_arr = implode(',', $marketList );
            $sql .=" AND vtp.idMarket in (".$imploded_arr.")";
        }

        $sql .= " GROUP BY vtp.".$sqlGroup.", vtp.".$sqlLabel." ";
        if($sqlseq != ''){
            $sql.=" , vtp.".$sqlseq." ";
        }
        $sql .= "ORDER BY ";
        if($axisX != 8){
            if($sqlseq != ''){
                $sql.=" vtp.".$sqlseq." ";
            }else{
                $sql.=" vtp.".$sqlGroup." ";
            }
        }else{
            $sql.=" value1 DESC";
        }
    }else if(($axisYL == '1' || $axisYL == '3' || $axisYL == '4') && ($axisYR =='1' || $axisYR == '3'|| $axisYR == '4')) {
        if($axisYL == '4'){
            $sql .= "COALESCE((SUM(vtm.Total)/SUM(vtm.Weight)),0) as value1, COALESCE(SUM(vtm.".$sqlSelect2."),0) as value2, vtm.".$sqlGroup." , vtm.".$sqlLabel." as Label";
        }else if ($axisYR == '4'){
            $sql .= "COALESCE(SUM(vtm.".$sqlSelect1."),0) as value1, COALESCE((SUM(vtm.Total)/SUM(vtm.Weight)),0) as value2, vtm.".$sqlGroup." , vtm.".$sqlLabel." as Label";
        }else{
            $sql .= "COALESCE(SUM(vtm.".$sqlSelect1."),0) as value1, COALESCE(SUM(vtm.".$sqlSelect2."),0) as value2, vtm.".$sqlGroup." , vtm.".$sqlLabel." as Label";
        }
        if($sqlseq != ''){
            $sql.=" , vtm.".$sqlseq." ";
        }
        $sql .= " FROM viewPersonMarket_TD vtm ";
        $sql .= "WHERE vtm.idPersonMarket IS NOT NULL";
        if($years != '0'){ $sql .= " AND vtm.yearId = ".$years." ";}
        if($areaList != ''){ 
            $imploded_arr = implode(',', $areaList );
            $sql .=" AND vtm.idArea in (".$imploded_arr.")";
        }
        if($agriList != ''){ 
            $imploded_arr = implode(',', $agriList );
            $sql .=" AND vtm.idAgri in (".$imploded_arr.")";
        }
        if($marketList != ''){ 
            $imploded_arr = implode(',', $marketList );
            $sql .=" AND vtm.idMarket in (".$imploded_arr.")";
        }
        $sql .= " GROUP BY vtm.".$sqlGroup.", vtm.".$sqlLabel." ";
        if($sqlseq != ''){
            $sql.=" , vtm.".$sqlseq." ";
        }
        $sql .= "ORDER BY ";
        if($axisX != 8){
            if($sqlseq != ''){
                $sql.=" vtm.".$sqlseq." ";
            }else{
                $sql.=" vtm.".$sqlGroup." ";
            }
        }else{
            $sql.=" value1 DESC";
        }
    }else{
        if($axisYL == '5' || $axisYL == '2' ){ // targetplan
            $sql .= " COALESCE(t1.value1,0) as value1 , COALESCE(t2.value2,0) as value2, t1.".$sqlGroup.", t1.Label ";
            $sql .= "FROM (SELECT SUM(vtp.".$sqlSelect1.") as value1, vtp.".$sqlGroup." , vtp.".$sqlLabel." as Label ";
            if($sqlseq != ''){
                $sql.=" , vtp.".$sqlseq." ";
            }
            $sql.="FROM viewTargetPlan_TD vtp ";
            $sql .= "WHERE vtp.idTargetPlan IS NOT NULL";
            if($years != '0'){ $sql .= " AND vtp.yearId = ".$years." ";}
            if($areaList != ''){ 
                $imploded_arr = implode(',', $areaList );
                $sql .=" AND vtp.idArea in (".$imploded_arr.")";
            }
            if($agriList != ''){ 
                $imploded_arr = implode(',', $agriList );
                $sql .=" AND vtp.idAgri in (".$imploded_arr.")";
            }
            if($marketList != ''){ 
                $imploded_arr = implode(',', $marketList );
                $sql .=" AND vtp.idMarket in (".$imploded_arr.")";
            }
            $sql .= " GROUP BY vtp.".$sqlGroup.", vtp.".$sqlLabel;
            if($sqlseq != ''){
                $sql.=" , vtp.".$sqlseq." ";
            }
            $sql .= " ) t1, (";
            if($axisYR == '4'){
                $sql .= " SELECT COALESCE((SUM(vtm.Total)/SUM(vtm.Weight)),0) as value2, vtm.".$sqlGroup." 
                    FROM viewPersonMarket_TD vtm ";
                $sql .= "WHERE vtm.idPersonMarket IS NOT NULL";
                if($years != '0'){ $sql .= " AND vtm.yearId = ".$years." ";}
                if($areaList != ''){ 
                    $imploded_arr = implode(',', $areaList );
                    $sql .=" AND vtm.idArea in (".$imploded_arr.")";
                }
                if($agriList != ''){ 
                    $imploded_arr = implode(',', $agriList );
                    $sql .=" AND vtm.idAgri in (".$imploded_arr.")";
                }
                if($marketList != ''){ 
                    $imploded_arr = implode(',', $marketList );
                    $sql .=" AND vtm.idMarket in (".$imploded_arr.")";
                }
                $sql .= " GROUP BY vtm.".$sqlGroup.", vtm.".$sqlLabel. " ) t2
                WHERE t1.".$sqlGroup." = t2.".$sqlGroup;
                $sql .= " ORDER BY ";
                if($axisX != 8){
                    if($sqlseq != ''){
                        $sql.=" t1.".$sqlseq." ";
                    }else{
                        $sql.=" t1.".$sqlGroup." ";
                    }
                }else{
                    $sql.=" value1 DESC";
                }
            }else{
                $sql .= " SELECT COALESCE(SUM(vtm.".$sqlSelect2."),0) as value2, vtm.".$sqlGroup." 
                FROM viewPersonMarket_TD vtm ";
                $sql .= "WHERE vtm.idPersonMarket IS NOT NULL";
                if($years != '0'){ $sql .= " AND vtm.yearId = ".$years." ";}
                if($areaList != ''){ 
                    $imploded_arr = implode(',', $areaList );
                    $sql .=" AND vtm.idArea in (".$imploded_arr.")";
                }
                if($agriList != ''){ 
                    $imploded_arr = implode(',', $agriList );
                    $sql .=" AND vtm.idAgri in (".$imploded_arr.")";
                }
                if($marketList != ''){ 
                    $imploded_arr = implode(',', $marketList );
                    $sql .=" AND vtm.idMarket in (".$imploded_arr.")";
                }
                $sql .= " GROUP BY vtm.".$sqlGroup.", vtm.".$sqlLabel. " ) t2
                WHERE t1.".$sqlGroup." = t2.".$sqlGroup;
                $sql .= " ORDER BY ";
                if($axisX != 8){
                    if($sqlseq != ''){
                        $sql.=" t1.".$sqlseq." ";
                    }else{
                        $sql.=" t1.".$sqlGroup." ";
                    }
                }else{
                    $sql .= " value1 DESC";
                }
                
            }
        }else if($axisYL == '1' || $axisYL == '3' || $axisYL == '4'){ // personMarket
            $sql .= " COALESCE(t2.value1,0) as value1 , COALESCE(t1.value2,0) as value2 , t1.".$sqlGroup.", t1.Label ";
            $sql .= "FROM (SELECT COALESCE(SUM(vtp.".$sqlSelect2."),0) as value2, vtp.".$sqlGroup." , vtp.".$sqlLabel." as Label ";
            if($sqlseq != ''){
                $sql.=" , vtp.".$sqlseq." ";
            }
            $sql.="FROM viewTargetPlan_TD vtp ";
            $sql .= "WHERE vtp.idTargetPlan IS NOT NULL";
            if($years != '0'){ $sql .= " AND vtp.yearId = ".$years." ";}
            if($areaList != ''){ 
                $imploded_arr = implode(',', $areaList );
                $sql .=" AND vtp.idArea in (".$imploded_arr.")";
            }
            if($agriList != ''){ 
                $imploded_arr = implode(',', $agriList );
                $sql .=" AND vtp.idAgri in (".$imploded_arr.")";
            }
            if($marketList != ''){ 
                $imploded_arr = implode(',', $marketList );
                $sql .=" AND vtp.idMarket in (".$imploded_arr.")";
            }
            $sql .= " GROUP BY vtp.".$sqlGroup.", vtp.".$sqlLabel;
            if($sqlseq != ''){
                $sql.=" , vtp.".$sqlseq." ";
            }
            $sql.=") t1, (";

            if($axisYL == '4'){
                $sql .= " SELECT COALESCE((SUM(vtm.Total)/SUM(vtm.Weight)),0) as value1, vtm.".$sqlGroup." 
                    FROM viewPersonMarket_TD vtm ";
                $sql .= "WHERE vtm.idPersonMarket IS NOT NULL";
                if($years != '0'){ $sql .= " AND vtm.yearId = ".$years." ";}
                if($areaList != ''){ 
                    $imploded_arr = implode(',', $areaList );
                    $sql .=" AND vtm.idArea in (".$imploded_arr.")";
                }
                if($agriList != ''){ 
                    $imploded_arr = implode(',', $agriList );
                    $sql .=" AND vtm.idAgri in (".$imploded_arr.")";
                }
                if($marketList != ''){ 
                    $imploded_arr = implode(',', $marketList );
                    $sql .=" AND vtm.idMarket in (".$imploded_arr.")";
                }
                $sql .= " GROUP BY vtm.".$sqlGroup.", vtm.".$sqlLabel. " ) t2
                WHERE t1.".$sqlGroup." = t2.".$sqlGroup;
                $sql .= " ORDER BY ";
                if($axisX != 8){
                    if($sqlseq != ''){
                        $sql.=" t1.".$sqlseq." ";
                    }else{
                        $sql.=" t1.".$sqlGroup." ";
                    }
                }else{
                    $sql .= " value1 DESC";
                }
            }else{
                $sql .= " SELECT COALESCE(SUM(vtm.".$sqlSelect1."),0) as value1, vtm.".$sqlGroup." 
                FROM viewPersonMarket_TD vtm ";
                $sql .= "WHERE vtm.idPersonMarket IS NOT NULL";
                if($years != '0'){ $sql .= " AND vtm.yearId = ".$years." ";}
                if($areaList != ''){ 
                    $imploded_arr = implode(',', $areaList );
                    $sql .=" AND vtm.idArea in (".$imploded_arr.")";
                }
                if($agriList != ''){ 
                    $imploded_arr = implode(',', $agriList );
                    $sql .=" AND vtm.idAgri in (".$imploded_arr.")";
                }
                if($marketList != ''){ 
                    $imploded_arr = implode(',', $marketList );
                    $sql .=" AND vtm.idMarket in (".$imploded_arr.")";
                }
                $sql .= " GROUP BY vtm.".$sqlGroup.", vtm.".$sqlLabel. " ) t2
                WHERE t1.".$sqlGroup." = t2.".$sqlGroup;
                $sql .= " ORDER BY";
                if($axisX != 8){
                    if($sqlseq != ''){
                        $sql.=" t1.".$sqlseq." ";
                    }else{
                        $sql.=" t1.".$sqlGroup." ";
                    }
                }else{
                    $sql .= " value1 DESC";
                }
            }
        }
    }

    // echo $sql;
    $stmt = sqlsrv_query( $conn, $sql);
    $return_arr = array();
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        // $value1 = $row['value1'];
        // $value2 = $row['value2'];
        $row_array['value1'] = $row['value1'];
        $row_array['value2'] = $row['value2'];
        $row_array['Label'] = $row['Label'];
        array_push($return_arr, $row_array);
    }
    echo json_encode($return_arr);
?>