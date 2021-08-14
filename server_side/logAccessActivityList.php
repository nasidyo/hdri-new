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
$idStaff = $_GET['idStaff'];

$table=" ( SELECT la.logUrl_id, s.staffFirstname+' '+s.staffLastname as fullname, la.url, FORMAT(la.time_log, 'dd/MMMM/yyyy hh:mm tt', 'th') as datetime,
    s.idStaff 
    FROM logAccessURL_TD as la
    INNER JOIN Staff as s ON la.idStaff = s.idStaff
    WHERE la.idStaff ='".$idStaff."'
    ) logAccessURL_TD ";

// Table's primary key
$primaryKey = 'logUrl_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'logUrl_id','dt' => 0),
    array( 'db' => 'fullname','dt' => 1 ),
    array( 'db' => 'url','dt' => 2 ),
    array( 'db' => 'datetime','dt' => 3 ),
);
$whereAll =' 1=1 ';

//echo ' SELECT * from '.$table.' where '.$whereAll;
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
