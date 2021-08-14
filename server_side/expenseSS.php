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
$table=" ( SELECT
EX.EXPENSE_ID,
EX.ORDER_ID                                                                ORDER_ID,
CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, EX.CREATE_DATE) ) , 103) CREATE_DATE,
(
    SELECT
        CONCAT(s.staffFirstname ,' ' , s.staffLastname)
    FROM
        Staff_TD s
    WHERE
        s.idStaff = EX.CREATE_BY ) CREATE_BY,
EX.UPDATE_DATE,
EX.UPDATE_BY,
EX.EXPENSE_BY,
EX.CUSTOMER,
CASE EX.CUSTOMER
    WHEN 0
    THEN
        (
            SELECT
                EXP.OTHER_CUSTOMER
            FROM
                EXPENSE_TD EXP
            WHERE
                EXP.EXPENSE_ID = EX.EXPENSE_ID )
    ELSE
          (
          SELECT
              CONCAT(p.firstName ,' ' , p.lastName)
          FROM
              PERSON_TD p
          WHERE
              p.idPerson = EX.CUSTOMER )
END CUSTOMER_NAME,
EX.DISCOUNT,
EX.AMOUNT,
EX.PRICE,
EX.EXPENSE_OTHER_ID,
EX.DEBT,
EX.MARKET_ID,
EX.INSTITUTE_ID ,
O.ORDER_NAME ,
dbo.toMoney(CONVERT(DECIMAL(10,2), ISNULL(AMOUNT,0) * ISNULL(PRICE,0))) SUM_OTHER ,
dbo.toMoney(EX.EXPENSE_AMOUNT)                                          EXPENSE_AMOUNT,
RB.idRiverBasin ,
A.idArea,
EX.DOC_NO,
EX.CANCELED ,
CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, EX.EXPENSE_DATE) ) , 103) EXPENSE_DATE ,
EX.BUSINESS_GROUP_ID,
EX.SUB_GROUP_ID
FROM
EXPENSE_TD EX
LEFT JOIN
ORDER_TD O
ON
EX.ORDER_ID = O.ORDER_ID
LEFT JOIN
EXPENSE_OTHER_TD EO
ON
EX.EXPENSE_OTHER_ID = EO.EXPENSE_OTHER_ID
INNER JOIN
INSTITUTE INS
ON
EX.INSTITUTE_ID = INS.INSTITUTE_ID
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
    EX.EXPENSE_OTHER_ID IS NULL
OR  EX.EXPENSE_OTHER_ID = 0)
UNION
SELECT
EX.EXPENSE_ID,
EX.ORDER_ID                                                                ORDER_ID,
CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, EX.CREATE_DATE) ) , 103) CREATE_DATE,
(
    SELECT
        CONCAT(s.staffFirstname ,' ' , s.staffLastname)
    FROM
        Staff_TD s
    WHERE
        s.idStaff = EX.CREATE_BY ) CREATE_BY,
EX.UPDATE_DATE,
EX.UPDATE_BY,
EX.EXPENSE_BY,
EX.CUSTOMER,
CASE EX.CUSTOMER
    WHEN 0
    THEN
        (
            SELECT
                EXP.OTHER_CUSTOMER
            FROM
                EXPENSE_TD EXP
            WHERE
                EXP.EXPENSE_ID = EX.EXPENSE_ID )
    ELSE
          (
          SELECT
              CONCAT(p.firstName ,' ' , p.lastName)
          FROM
              PERSON_TD p
          WHERE
              p.idPerson = EX.CUSTOMER )
END CUSTOMER_NAME,
EX.DISCOUNT,
EX.AMOUNT,
EX.PRICE,
EX.EXPENSE_OTHER_ID,
EX.DEBT,
EX.MARKET_ID,
EX.INSTITUTE_ID ,
EO.EXPENSE_DETAIL                                                       ORDER_NAME ,
dbo.toMoney( case when CONVERT(DECIMAL(10,2), ISNULL(AMOUNT,0) * ISNULL(PRICE,0)) =0 then PRICE else  CONVERT(DECIMAL(10,2), ISNULL(AMOUNT,0) * ISNULL(PRICE,0)) end    ) SUM_OTHER ,
dbo.toMoney(EX.EXPENSE_AMOUNT)                                          EXPENSE_AMOUNT,
RB.idRiverBasin ,
A.idArea,
EX.DOC_NO,
EX.CANCELED ,
CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, EX.EXPENSE_DATE) ) , 103) EXPENSE_DATE ,
    EX.BUSINESS_GROUP_ID,
EX.SUB_GROUP_ID
FROM
EXPENSE_TD EX
LEFT JOIN
ORDER_TD O
ON
EX.ORDER_ID = O.ORDER_ID
LEFT JOIN
EXPENSE_OTHER_TD EO
ON
EX.EXPENSE_OTHER_ID = EO.EXPENSE_OTHER_ID
INNER JOIN
INSTITUTE INS
ON
EX.INSTITUTE_ID = INS.INSTITUTE_ID
INNER JOIN
AREA A
ON
INS.AREA_ID = A.IDAREA
INNER JOIN
RIVERBASIN RB
ON
A.RIVERBASIN_IDRIVERBASIN = RB.IDRIVERBASIN
WHERE
EX.EXPENSE_OTHER_ID <> 0
        ) EXPENSE_TD ";

// Table's primary key
$primaryKey = 'EXPENSE_ID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'EXPENSE_DATE','dt' => 0),
    array( 'db' => 'DOC_NO','dt' => 1 ),
    array( 'db' => 'ORDER_NAME','dt' => 2 ),
    array( 'db' => 'PRICE','dt' => 3 ),
    array( 'db' => 'AMOUNT','dt' => 4 ),
    array( 'db' => 'SUM_OTHER','dt' => 5 ),
    array( 'db' => 'DISCOUNT','dt' => 6 ),
    array( 'db' => 'EXPENSE_AMOUNT','dt' => 7 ),
    array( 'db' => 'DEBT','dt' => 8 ),
    array( 'db' => 'CUSTOMER_NAME','dt' => 9 ),
    array( 'db' => 'CREATE_BY','dt' => 10 ),
    array( 'db' => 'CANCELED','dt' => 11 ),
    array( 'db' => 'EXPENSE_ID','dt' => 12 ),

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
if (isset($_GET['expense_by'])) {
    $expense_by = $_GET['expense_by'];
    if($expense_by !="" &&  $expense_by != "undefined"){
        $whereAll.="and CREATE_BY like '%".$expense_by."%' " ;
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
        $whereAll.=" AND  CONVERT(DATE,EXPENSE_DATE,103)  >= CONVERT(DATE,'".$fromDate."' ,103) " ;
        $whereAll.=" AND CONVERT(DATE,EXPENSE_DATE,103) <= CONVERT(DATE,'".$endDate."' ,103) " ;
    }

}

if (isset($_GET['canceled'])) {
    $canceled = $_GET['canceled'];

    if($canceled !="" ){
        $whereAll.=" and CANCELED = '".$canceled."'" ;
    }

}
if (isset($_GET['debt'])) {
    $debt = $_GET['debt'];

    if($debt =="Y" ){
        $whereAll.=" and DEBT is not null and DEBT > 0 " ;
    }

}


if (isset($_GET['sub_group_id'])) {
    $sub_group_id = $_GET['sub_group_id'];

    if($sub_group_id >0 ){
        $whereAll.=" and SUB_GROUP_ID = ".$sub_group_id ;
    }
}


if (isset($_GET['business_group_id'])) {
    $business_group_id = $_GET['business_group_id'];

    if($business_group_id >0 ){
        $whereAll.=" and BUSINESS_GROUP_ID = ".$business_group_id ;
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
