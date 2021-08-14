
<?php 
    require_once '../connection/database.php';
   $report= new ReportService();
   $idArea ="";
   if (isset($_GET['idArea'])) {
     $idArea =$_GET['idArea'];
    }
    $report->loadPersonMarketByArgiReport($idArea);

    Class ReportService{
        public function loadPersonMarketByArgiReport($idArea){
            $sql  =" SELECT  ";
            $sql  .=" ta.nameTypeOfArgi,  ";
            $sql  .=" ta.idTypeOfArgi,  ";
            $sql  .="    SUM( isNull(pm.Volumn,0))  Volumn,  ";
            $sql  .="    SUM( isNull(pm.Value,0) )     Value, ";
            $sql  .="   SUM( isNull(pm.TotalValue,0)) TotalValue  ";          
            $sql  .="  FROM  ";
            $sql  .="      PersonMarket_TD pm  ";
            $sql  .="  right  JOIN  ";
            $sql  .="   TypeOfArgi_TD ta  ";
            $sql  .="  ON  ";
            $sql  .="      pm.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi  ";
            $sql  .="  left JOIN  ";
            $sql  .="      MonthOfYear m  ";
            $sql  .="  ON  ";
            $sql  .="  m.Month_id = pm.MonthNo  ";
            if($idArea != ""){
                $sql  .="  m.Area_idArea = ? ";
            }

            $sql  .="  GROUP BY  ";
            $sql  .="    ta.idTypeOfArgi,  ta.nameTypeOfArgi  ";
         
            $return_arr = array();
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql ,array($idArea) );

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $row_array['idTypeOfArgi'] = $row['idTypeOfArgi'];
                $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];
                $row_array['Volumn'] = $row['Volumn'];
                $row_array['Value'] = $row['Value'];
                $row_array['TotalValue'] = $row['TotalValue'];
                array_push($return_arr, $row_array);
   
            }
            sqlsrv_close($conn);
            echo json_encode($return_arr);
          

         }


         
        



    
}



?>