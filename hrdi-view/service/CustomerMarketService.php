<?php
require_once '../connection/database.php';
require_once '../model/CustomerMarketM.php';

Class CustomerMarketService{
    public function addCustomerMarket($CustomerMarketM){
        $sql  =" INSERT";
        $sql  .="  INTO CustomerMarket_TD (Market_idMarket, Customer_idCustomer ,Area_idArea ) VALUES (  ?, ?, ? );";
        
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $CustomerMarketM->getIdMarket(),
            $CustomerMarketM->getIdCustomer(),
            $CustomerMarketM->getIdArea()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
        
    }
    
    public function updateCustomerMarket($CustomerMarketM){
        $sql  =" UPDATE";
       
        $sql  .="     CustomerMarket_TD ";
        $sql  .=" SET ";
        $sql  .="     Customer_idCustomer = ?, ";
        $sql  .="     Market_idMarket = ?, ";
        $sql  .="     Area_idArea = ? ";
        $sql  .="  WHERE  ";
        $sql  .="     idCustomerMarket = ?  ";
      
        $db = new Database();
        $conn=  $db->getConnection();
        $params =array(
            $CustomerMarketM->getIdCustomer(),
            $CustomerMarketM->getIdMarket(),
            $CustomerMarketM->getIdArea(),      
            $CustomerMarketM->getIdCustomerMarket()
        );
        $stmt = sqlsrv_prepare( $conn, $sql, $params);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    
    public function loadCustomerMarket($Id){
        
        $sql  ="  SELECT      ";
        $sql  .="   cm.idCustomerMarket, ";
        $sql  .="     cm.Customer_idCustomer, ";
        $sql  .="     cm.Market_idMarket, ";
        $sql  .="        cm.Area_idArea, ";
        $sql  .="     rb.idRiverBasin ";
        $sql  .="         FROM ";
        $sql  .="     CustomerMarket_TD cm, ";
        $sql  .="         Area a , ";
        $sql  .="      RiverBasin rb ";
        $sql  .="         WHERE ";
        $sql  .="      cm.Area_idArea = a.idArea ";
        $sql  .="   AND a.RiverBasin_idRiverBasin = rb.idRiverBasin  ";
        $sql  .="  and idCustomerMarket = ?   ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));
        
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        
        $CustomerMarketM = new CustomerMarketM();
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $CustomerMarketM->setIdCustomerMarket($row['idCustomerMarket']);
            $CustomerMarketM->setIdCustomer($row['Customer_idCustomer']);
            $CustomerMarketM->setIdMarket($row['Market_idMarket']);
            $CustomerMarketM->setIdArea($row['Area_idArea']);
            $CustomerMarketM->setIdRiverBasin($row['idRiverBasin']);
            
         
        }
        echo json_encode($CustomerMarketM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
        
    }
    
    public function delCustomerMarket($id){
        
        $sql  =" DELETE FROM CustomerMarket_TD WHERE idCustomerMarket = ? ";
        
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        
        
    }
    
    
    
}


?>
