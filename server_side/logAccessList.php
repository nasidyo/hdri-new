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

$table=" ( SELECT la.log_idlogin, s.staffFirstname+' '+s.staffLastname as fullname, vld.department, la.ipAddress, la.platform, FORMAT(la.time_login, 'dd/MMMM/yyyy hh:mm tt', 'th') as datetime,
    s.idStaff, COALESCE(vld.org_lvl1_id,0) as org_lvl1_id
    FROM LogAccess_TD as la
    INNER JOIN Staff as s ON la.username = s.staffUsername
    LEFT JOIN vLoadDetailStaff as vld ON la.username = vld.usr
    ) LogAccess_TD ";

// Table's primary key
$primaryKey = 'log_idlogin';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'log_idlogin','dt' => 0),
    array( 'db' => 'fullname','dt' => 1 ),
    array( 'db' => 'department','dt' => 2 ),
    array( 'db' => 'ipAddress','dt' => 3 ),
    array( 'db' => 'platform','dt' => 4 ),
    array( 'db' => 'datetime','dt' => 5 ),
    array( 'db' => 'idStaff','dt' => 6 ),
    array( 'db' => 'org_lvl1_id','dt' => 7 ),
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
