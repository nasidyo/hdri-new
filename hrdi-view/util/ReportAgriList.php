<?php 
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $idRiverBasin =0;
    if (isset($_POST['idRiverBasin'])) {
        $idRiverBasin =$_POST['idRiverBasin'];
    }
    if (isset($_POST['years_Id'])) {
        $years_Id = $_POST['years_Id'];
    }
    if (isset($_POST['typeOfAgri_id'])) {
        $typeOfAgri_id = $_POST['typeOfAgri_id'];
    }
    $agriList = '';
    if (isset($_POST['agriList'])) {
        $agriList = $_POST['agriList'];
    }
    if (isset($_POST['speciesId'])) {
        $speciesId = $_POST['speciesId'];
    }
    if (isset($_POST['speciesId'])) {
        $speciesId = $_POST['speciesId'];
    }
    if (isset($_POST['showUnit'])) {
        $showUnit = $_POST['showUnit'];
    }
    $sql = "SELECT temp.target_name, SUM(temp.totalsell) totalsell, SUM(temp.totalplan) totalplan, SUM(temp.totalQulitysell) totalQulitysell, SUM(temp.totalQulityplan) totalQulityplan 
        FROM (SELECT DISTINCT ";
        if ($showUnit != '0'){
            $sql .= "TOP ".$showUnit;
        }
        $sql.=" mtg.target_name , ISNULL(sum(pmt.TotalValue), 0) totalsell, 0 totalplan, ISNULL(sum(pmt.Volumn), 0) totalQulitysell, 0 totalQulityplan
            FROM PersonMarket_TD pmt
            INNER JOIN MainTarget mtg ON pmt.Area_idArea = mtg.idArea
            WHERE pmt.idPersonMarket IS NOT NULL ";
            if ($years_Id != '0'){
                $sql.=" and pmt.YearID = '".$years_Id."'";
            }
            if($typeOfAgri_id != '0'){
                $sql.=" and pmt.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
            }
            if($idRiverBasin != '0'){
                $sql.=" and mtg.idRiverBasin = '".$idRiverBasin."'";
            }
            if($agriList != ''){
                $imploded_arr = implode(',', $agriList);
                $sql.=" and pmt.Agri_idAgri in (".$imploded_arr.")";
            }
            if($speciesId != 'ALL'){
                $sql .=" and pmt.species_Id = '".$speciesId."'";
            }
        $sql.=" GROUP by mtg.target_name 
            UNION 
            SELECT DISTINCT ";
            if ($showUnit != '0'){
                $sql .= "TOP ".$showUnit;
            }
        $sql.=" mtg2.target_name , 0 totalsell, ISNULL(sum(tp.Total), 0) totalplan, 0 totalQulitysell, ISNULL(sum(tp.Weight), 0) totalQulityplan
            FROM TargetPlan_TD tp
            INNER JOIN MainTarget mtg2 ON tp.Area_idArea = mtg2.idArea
            WHERE tp.idTargetPlan IS NOT NULL ";
            if ($years_Id != '0'){
                $sql.=" and tp.YearTarget_YearID = '".$years_Id."'";
            }
            if($typeOfAgri_id != '0'){
                $sql.=" and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
            }
            if($idRiverBasin != '0'){
                $sql.=" and mtg2.idRiverBasin = '".$idRiverBasin."'";
            }
            if($agriList != ''){
                $imploded_arr = implode(',', $agriList);
                $sql.=" and tp.Agri_idAgri in (".$imploded_arr.")";
            }
            if($speciesId != 'ALL'){
                $sql .=" and tp.species_Id = '".$speciesId."'";
            }
            $sql.=" GROUP by mtg2.target_name ) temp
            GROUP by temp.target_name 
            ORDER BY totalsell DESC, totalplan DESC";

    $return_arr = array();
    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['target_name'] = $row['target_name'];
        $row_array['totalsell'] = $row['totalsell'];
        $row_array['totalplan'] = $row['totalplan'];
        $row_array['totalQulitysell'] = $row['totalQulitysell'];
        $row_array['totalQulityplan'] = $row['totalQulityplan'];
        array_push($return_arr, $row_array);

    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>