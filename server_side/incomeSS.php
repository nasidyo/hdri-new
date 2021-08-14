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
$table=" (  SELECT
INC.INCOME_ID,
INC.ORDER_ID                                                                ORDER_ID,
CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, INC.RECEIVE_DATE) ) , 103) CREATE_DATE_STR,
INC.CREATE_DATE,
(
    SELECT
        CONCAT(s.staffFirstname ,' ' , s.staffLastname)
    FROM
        Staff_TD s
    WHERE
        s.idStaff = INC.CREATE_BY ) CREATE_BY,
INC.UPDATE_DATE,
INC.UPDATE_BY,
INC.RECEIVE_BY,
INC.CUSTOMER,
CASE INC.CUSTOMER
    WHEN 0
    THEN
        (
            SELECT
                INCP.OTHER_CUSTOMER
            FROM
                INCOME_TD INCP
            WHERE
                INCP.INCOME_ID = INC.INCOME_ID )
    ELSE
          (
          SELECT
              CONCAT(p.firstName ,' ' , p.lastName)
          FROM
              PERSON_TD p
          WHERE
              p.idPerson = INC.CUSTOMER )
END CUSTOMER_NAME,
INC.DISCOUNT,
INC.AMOUNT,
INC.PRICE,
INC.INCOME_OTHER_ID,
INC.DEBT,
INC.MARKET_ID,
INC.INSTITUTE_ID ,
O.ORDER_NAME ,
dbo.toMoney( case when CONVERT(DECIMAL(10,2), ISNULL(AMOUNT,0) * ISNULL(PRICE,0)) =0 then PRICE else  CONVERT(DECIMAL(10,2), ISNULL(AMOUNT,0) * ISNULL(PRICE,0)) end    ) SUM_OTHER ,
dbo.toMoney(INC.RECEIVE_AMOUNT)                                         RECEIVE_AMOUNT,
RB.idRiverBasin ,
A.idArea,
INC.DOC_NO,
INC.CANCELED ,
INC.BUSINESS_GROUP_ID,
INC.SUB_GROUP_ID ,
INC.RECEIVE_DATE
FROM
INCOME_TD INC
LEFT JOIN
ORDER_TD O
ON
INC.ORDER_ID = O.ORDER_ID
LEFT JOIN
INCOME_OTHER_TD EO
ON
INC.INCOME_OTHER_ID = EO.INCOME_OTHER_ID
INNER JOIN
INSTITUTE INS
ON
INC.INSTITUTE_ID = INS.INSTITUTE_ID
INNER JOIN
AREA A
ON
INS.AREA_ID = A.IDAREA
INNER JOIN
RIVERBASIN RB
ON
A.RIVERBASIN_IDRIVERBASIN = RB.IDRIVERBASIN
WHERE
(
    INC.INCOME_OTHER_ID IS NULL
OR  INC.INCOME_OTHER_ID =0)
UNION
SELECT
INC.INCOME_ID,
INC.ORDER_ID                                                                ORDER_ID,
CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, INC.RECEIVE_DATE) ) , 103) CREATE_DATE_STR,
INC.CREATE_DATE,
(
    SELECT
        CONCAT(s.staffFirstname ,' ' , s.staffLastname)
    FROM
        Staff_TD s
    WHERE
        s.idStaff = INC.CREATE_BY ) CREATE_BY,
INC.UPDATE_DATE,
INC.UPDATE_BY,
INC.RECEIVE_BY,
INC.CUSTOMER,
CASE INC.CUSTOMER
    WHEN 0
    THEN
        (
            SELECT
                INCP.OTHER_CUSTOMER
            FROM
                INCOME_TD INCP
            WHERE
                INCP.INCOME_ID = INC.INCOME_ID )
    ELSE
          (
          SELECT
              CONCAT(p.firstName ,' ' , p.lastName)
          FROM
              PERSON_TD p
          WHERE
              p.idPerson = INC.CUSTOMER )
END CUSTOMER_NAME,
INC.DISCOUNT,
INC.AMOUNT,
INC.PRICE,
INC.INCOME_OTHER_ID,
INC.DEBT,
INC.MARKET_ID,
INC.INSTITUTE_ID ,
EO.INCOME_DETAIL  ORDER_NAME ,
dbo.toMoney( case when CONVERT(DECIMAL(10,2), ISNULL(AMOUNT,0) * ISNULL(PRICE,0)) =0 then PRICE else  CONVERT(DECIMAL(10,2), ISNULL(AMOUNT,0) * ISNULL(PRICE,0)) end    ) SUM_OTHER ,
dbo.toMoney(INC.RECEIVE_AMOUNT)                                         RECEIVE_AMOUNT,
RB.idRiverBasin ,
A.idArea,
INC.DOC_NO,
INC.CANCELED ,
INC.BUSINESS_GROUP_ID,
INC.SUB_GROUP_ID ,
INC.RECEIVE_DATE
FROM
INCOME_TD INC
LEFT JOIN
ORDER_TD O
ON
INC.ORDER_ID = O.ORDER_ID
LEFT JOIN
INCOME_OTHER_TD EO
ON
INC.INCOME_OTHER_ID = EO.INCOME_OTHER_ID
INNER JOIN
INSTITUTE INS
ON
INC.INSTITUTE_ID = INS.INSTITUTE_ID
INNER JOIN
AREA A
ON
INS.AREA_ID = A.IDAREA
INNER JOIN
RIVERBASIN RB
ON
A.RIVERBASIN_IDRIVERBASIN = RB.IDRIVERBASIN
WHERE

INC.INCOME_OTHER_ID <> 0 ) INCOME_TD ";

// Table's primary key
$primaryKey = 'INCOME_ID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'CREATE_DATE_STR','dt' => 0),
    array( 'db' => 'DOC_NO','dt' => 1 ),
    array( 'db' => 'ORDER_NAME','dt' => 2 ),
    array( 'db' => 'PRICE','dt' => 3 ),
    array( 'db' => 'AMOUNT','dt' => 4 ),
    array( 'db' => 'SUM_OTHER','dt' => 5 ),
    array( 'db' => 'DISCOUNT','dt' => 6 ),
    array( 'db' => 'RECEIVE_AMOUNT','dt' => 7 ),
    array( 'db' => 'DEBT','dt' => 8 ),
    array( 'db' => 'CUSTOMER_NAME','dt' => 9 ),
    array( 'db' => 'CREATE_BY','dt' => 10 ),
    array( 'db' => 'CANCELED','dt' => 11 ),
    array( 'db' => 'INCOME_ID','dt' => 12 ),




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

if (isset($_GET['id'])) {
    $INSTITUTE_ID = (int)$_GET['id'];
    if($INSTITUTE_ID>0){
        $whereAll.=' and INSTITUTE_ID ='.$INSTITUTE_ID;
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
if (isset($_GET['receive_by'])) {
    $receive_by = $_GET['receive_by'];
    if($receive_by !="" &&  $receive_by != "undefined"){
        $whereAll.="and CREATE_BY like '%".$receive_by."%' " ;
    }

}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    if($order_id >0){
        $whereAll.="and ORDER_ID = ".$order_id ;
    }

}

if (isset($_GET['income_other_id'])) {
    $income_other_id = $_GET['income_other_id'];
    if($income_other_id >0){
        $whereAll.="and INCOME_OTHER_ID = ".$income_other_id ;
    }

}
if (isset($_GET['doc_no'])) {
    $doc_no = $_GET['doc_no'];
    if($doc_no !=""){
        $whereAll.=" and DOC_NO  like '%".$doc_no."%' " ;
    }

}

if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
    $fromDate =$_GET['fromDate'];
    $endDate = $_GET['toDate'];
    if($fromDate !="" &&  $endDate !=""){
        $whereAll.=" and RECEIVE_DATE >= '".$fromDate."' and RECEIVE_DATE <= '".$endDate."'" ;
    }

}

if (isset($_GET['canceled'])) {
    $canceled = $_GET['canceled'];

    if($canceled !="" ){
        $whereAll.="and CANCELED = '".$canceled."'" ;
    }

}

if (isset($_GET['market_id'])) {
    $market_id = $_GET['market_id'];

    if($market_id !=0 ){
        $whereAll.="and MARKET_ID = '".$market_id."'" ;
    }

}
if (isset($_GET['debt'])) {
    $debt = $_GET['debt'];

    if($debt =="Y" ){
        $whereAll.="and DEBT is not null and DEBT > 0 " ;
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
