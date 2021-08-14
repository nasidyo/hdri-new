<?php

class Database{
    function getConnection(){
        $conn =null;
        $serverName = "db01.hrdi.or.th";
        $userName = "farmer";
        $userPassword = "F95uRw";
        $dbName = "HRDI_Farmer";
        $connectionInfo = array("Database"=>$dbName, 
                                "UID"=>$userName, 
                                "PWD"=>$userPassword, 
                                "MultipleActiveResultSets"=>true,
                                "CharacterSet" =>"UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        return $conn;
    }
    
}


  

?>