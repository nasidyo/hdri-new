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

/*
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
// $table = 'Person_TD';
                $table = " ( SELECT
 '' as row_number,
    cmp.idCustomerMaketplan,
    cmp.Customer_idCustomer,
    cmp.Area_idArea,
    cmp.plan_Year,
    cmp.Agri_idAgri,
    cmp.agri_weekplan_amount,
    cmp.unit_id,
    cmp.agri_spect,
    cmp.TypeOfStand_idTypeOfStand,
    cmp.Logistic_idLogistic,
    cmp.Refund_period,
    cmp.conn_status_id,
    cmp.update_date,
    c.c_name,
    a.areaName,
    concat(ag.nameArgi ,
    CASE
        WHEN ag.speciesArgi IS NULL
        THEN ''
        WHEN ag.speciesArgi=''
        THEN ''
        ELSE concat('(พันธุ์ :', ag.speciesArgi,')')
    END ) nameArgi,
    cu.nameCountUnit ,
    tos.nameTypeOfStand ,
    lt.logistic_name ,
    conn.conn_status_name,
    a.RiverBasin_idRiverBasin
FROM
    CustomerMaketPlan_TD cmp
INNER JOIN
    Customer_TD c
ON
    cmp.Customer_idCustomer = c.idCustomer
INNER JOIN
    Area a
ON
    cmp.Area_idArea =a.idArea
INNER JOIN
    Agri_TD ag
ON
    cmp.Agri_idAgri = ag.idAgri
INNER JOIN
    CountUnit cu
ON
    cmp.unit_id = cu.idCountUnit
INNER JOIN
    TypeOfStand tos
ON
    cmp.TypeOfStand_idTypeOfStand = tos.idTypeOfStand
INNER JOIN
    Logistic_TD lt
ON
    cmp.Logistic_idLogistic = lt.logistic_id
INNER JOIN
    connection_status_TD conn
ON
    c.c_status = conn.conn_status_id

                ) CustomerMarketPlan_TD ";

// Table's primary key
$primaryKey = 'idCustomerMaketplan';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array(
        'db' => 'row_number',
        'dt' => 0
    ),
    array(
        'db' => 'c_name',
        'dt' => 1
    ),
    array(
        'db' => 'areaName',
        'dt' => 2
    ),
    array(
        'db' => 'nameArgi',
        'dt' => 3
    ),
    array(
        'db' => 'nameCountUnit',
        'dt' => 4
    ),
    array(
        'db' => 'nameTypeOfStand',
        'dt' => 5
    ),
    array(
        'db' => 'logistic_name',
        'dt' => 6
    ),
    array(
        'db' => 'conn_status_name',
        'dt' => 7
    ),
    array(
        'db' => 'idCustomerMaketplan',
        'dt' => 8
    )
);
$whereAll = ' 1=1 ';
if (isset($_GET['idRiverBasin'])) {
    $idRiverBasin = (int) $_GET['idRiverBasin'];
    if ($idRiverBasin > 0) {
        $whereAll .= ' and RiverBasin_idRiverBasin =' . $idRiverBasin;
    }
}
if (isset($_GET['idArea'])) {
    $idArea = (int) $_GET['idArea'];
    if ($idArea > 0) {
        $whereAll .= " and Area_idArea = '" . $idArea."'";
    }
}

//echo ' SELECT * from ' . $table . ' where ' . $whereAll;
// SQL server connection information

$serverName = "db01.hrdi.or.th";
$userName = "farmer";
$userPassword = "F95uRw";
$dbName = "HRDI_Farmer";

$sql_details = array(
    'user' => $userName,
    'pass' => $userPassword,
    'db' => $dbName,
    'host' => $serverName
);
/*
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require ('ssp.class.php');

echo json_encode(
    // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $whereAll));
