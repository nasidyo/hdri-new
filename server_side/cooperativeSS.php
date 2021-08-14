<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
//$table = 'Person_TD';
$table=" Account_Records_View ";

// Table's primary key
$primaryKey = 'TMP_ID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'ORDER_DATE','dt' => 0),
    array( 'db' => 'DOC_NO','dt' => 1 ),
    array( 'db' => 'ORDER_NAME','dt' => 2 ),
    array( 'db' => 'AMOUNT','dt' => 3 ),
    array( 'db' => 'PRICE','dt' => 4 ),
    array( 'db' => 'DISCOUNT','dt' => 5 ),
    array( 'db' => 'TRAN_AMOUNT','dt' => 6 ),
    array( 'db' => 'SUM_OTHER','dt' => 7 ),
    array( 'db' => 'EX_DEBT','dt' => 8 ),
    array( 'db' => 'INC_DEBT','dt' => 9 ),
    array( 'db' => 'CUSTOMER_NAME','dt' => 10 ),
    array( 'db' => 'CREATE_BY','dt' => 11 ),
    array( 'db' => 'COMMENT','dt' => 12 ),
    array( 'db' => 'TRAN_TYPE','dt' => 13 ),
    array( 'db' => 'CANCELED','dt' => 14 )



);
$whereAll =' 1=1 ';

if (isset($_GET['idRiverBasin'])) {
        $idRiverBasin = (int)$_GET['idRiverBasin'];
        if($idRiverBasin>0){
            $whereAll.=' and idRiverBasin ='.$idRiverBasin;
        }


}
if (isset($_GET['idArea'])) {
    $idArea = (int)$_GET['idArea'];
    if($idArea>0){
        $whereAll.=' and idArea ='.$idArea;
    }
}
if (isset($_GET['institute_id'])) {
    $institute_id = $_GET['institute_id'];
    if($institute_id !=0 ){
        $whereAll.="and INSTITUTE_ID =".$institute_id ;
    }
}

if (isset($_GET['customer'])) {
    $customer = (int)$_GET['customer'];
    if($customer>0){
        $whereAll.=' and CUSTOMER ='.$customer;
    }

}
if (isset($_GET['other_customer'])) {
    $other_customer = $_GET['other_customer'];
    if($other_customer !="" &&  $other_customer != "undefined"){
        $whereAll.="and CUSTOMER_NAME like '%".$other_customer."%' " ;
    }

}


if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    if($order_id >0){
        $whereAll.="and ORDER_ID = ".$order_id ;
    }

}
if (isset($_GET['expense_other_id'])) {
    $expense_other_id = $_GET['expense_other_id'];
    if($expense_other_id >0){
        $whereAll.="and EXPENSE_OTHER_ID = ".$expense_other_id ;
    }

}
if (isset($_GET['income_other_id'])) {
    $income_other_id = $_GET['income_other_id'];
    if($income_other_id >0){
        $whereAll.=" and INCOME_OTHER_ID = ".$income_other_id ;
    }

}

if (isset($_GET['doc_no'])) {
    $doc_no = $_GET['doc_no'];
    if($doc_no !=""){
        $whereAll.=" and DOC_NO  like '%".$doc_no."%' " ;
    }

}

if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
    $fromDate = $_GET['fromDate'];
    $endDate = $_GET['toDate'];
    if($fromDate !="" &&  $endDate !=""){
        $whereAll.=" AND  CONVERT(DATE,ORDER_DATE,103)  >= CONVERT(DATE,'".$fromDate."' ,103) " ;
        $whereAll.=" AND CONVERT(DATE,ORDER_DATE,103) <= CONVERT(DATE,'".$endDate."' ,103) " ;
    }

}

if (isset($_GET['canceled'])) {
    $canceled = $_GET['canceled'];

    if($canceled !="" ){
        $whereAll.="and CANCELED = '".$canceled."'" ;
    }

}

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    if($type !="" ){
        $whereAll.="and TYPE = '".$type."'" ;
    }

}

if (isset($_GET['debt'])) {
    $debt = $_GET['debt'];

    if($debt =="Y" ){
        $whereAll.="and  ( EX_DEBT is not null and EX_DEBT > 0 or  INC_DEBT is not null and INC_DEBT > 0 )" ;
    }

}

if (isset($_GET['tran_type'])) {
    $tran_type = $_GET['tran_type'];
    if(count($tran_type) >0){
        $whereAll.=" and TRAN_TYPE in (" ;
        for ($x = 0; $x < count($tran_type); $x++) {
            $whereAll.= "'".$tran_type[$x]."'" ;
            if($x != (count($tran_type)-1)){
                $whereAll.= "," ;
            }
          }
          $whereAll.=" ) " ;
    }
}

if (isset($_GET['sub_group_id'])) {
    $sub_group_id = $_GET['sub_group_id'];

    if($sub_group_id >0 ){
        $whereAll.="and SUB_GROUP_ID = ".$sub_group_id ;
    }
}


if (isset($_GET['business_group_id'])) {
    $business_group_id = $_GET['business_group_id'];

    if($business_group_id >0 ){
        $whereAll.="and BUSINESS_GROUP_ID = ".$business_group_id ;
    }

}




// echo ' SELECT * from '.$table.' where '.$whereAll;
// SQL server connection information

$serverName = "db01.hrdi.or.th";
$userName = "farmer";
$userPassword = "F95uRw";
$dbName = "HRDI_Farmer";



$sql_details = array(
    'user' => $userName,
    'pass' => $userPassword,
    'db'   => $dbName,
    'host' => $serverName
);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

echo json_encode(
   // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
       SSP::complex (  $_GET, $sql_details, $table, $primaryKey, $columns, null,$whereAll)
);
