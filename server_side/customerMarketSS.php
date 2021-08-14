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
                $table = " (SELECT
                       '' as row_number,
                    cm.idCustomerMarket,
                    cm.Customer_idCustomer,
                    cm.Market_idMarket,
                    cm.Area_idArea,
                    c.c_name,
                    m.nameMarket,
                    a.areaName,
                    rb.idRiverBasin,
                    c.c_phone
                FROM
                    CustomerMarket_TD cm
                INNER JOIN
                    Customer_TD c
                ON
                    cm.Customer_idCustomer = c.idCustomer
                INNER JOIN
                    Market_TD m
                ON
                    cm.Market_idMarket = m.idMarket
                INNER JOIN
                    Area a
                ON
                    cm.Area_idArea = a.idArea
                INNER JOIN
                    RiverBasin rb
                ON
                    a.RiverBasin_idRiverBasin = rb.idRiverBasin
                
                ) CustomerMarket_TD ";

// Table's primary key
$primaryKey = 'idCustomerMarket';

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
        'db' => 'areaName',
        'dt' => 1
    ),
    array(
        'db' => 'nameMarket',
        'dt' => 2
    ),
    array(
        'db' => 'c_name',
        'dt' => 3
    ),
    array(
        'db' => 'c_phone',
        'dt' => 4
    ),
    array(
        'db' => 'idCustomerMarket',
        'dt' => 5
    )
);
$whereAll = ' 1=1 ';
$staffPermis = $_GET['staffPermis'];
$areaAll = $_GET['areaAll'];

if (isset($_GET['idRiverBasin'])) {
    $idRiverBasin = (int) $_GET['idRiverBasin'];
    if ($idRiverBasin > 0) {
        $whereAll .= ' and idRiverBasin =' . $idRiverBasin;
    }
}

if (isset($_GET['idArea'])) {
    $idArea = (int) $_GET['idArea'];
    if ($idArea > 0) {
        $whereAll .= " and Area_idArea = '" . $idArea."'";
    }else{
        if($staffPermis == 'staff'){
            $whereAll .= " and Area_idArea IN (".$areaAll.")";
        }
    }
}

if (isset($_GET['idMarket'])) {
    $idMarket = (int) $_GET['idMarket'];
    if ($idMarket > 0) {
        $whereAll .= ' and Market_idMarket =' . $idMarket;
    }
}

if (isset($_GET['customer_id'])) {
    $customer_id = (int) $_GET['customer_id'];
    if ($customer_id > 0) {
        $whereAll .= ' and Customer_idCustomer =' . $customer_id;
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
