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
om.org_map_id,
om.account_year_id,
om.org_id,
om.person_id ,
-- concat( pt.prefixNameTh ,' ',p.firstName,' ',p.lastName ) fullname,
CASE
WHEN pt.idPrefix = 10
        THEN p.firstName +' '+ p.lastName
ELSE pt.prefixNameTh + p.firstName +' '+ p.lastName
END fullname,
mo.org_name,
ay.year_text,
ay.sub_group_id
FROM
OrganizationMap om ,
AccountYear ay,
PersonGroup_TD pg,
ms_organization mo ,
Person_TD p ,
Prefix_TD pt
WHERE
om.account_year_id =ay.account_year_id
AND om.person_id = pg.person_id
AND pg.person_id = p.idPerson
AND om.org_id = mo.org_id
AND p.Prefix_idPrefix = pt.idPrefix  ) OrganizationMap ";

// Table's primary key
$primaryKey = 'org_map_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'fullname','dt' => 0),
    array( 'db' => 'org_name','dt' => 1 ),
    array( 'db' => 'org_map_id','dt' => 2)
);

$whereAll =' 1=1 ';


if (isset($_GET['account_year_id'])) {
    $account_year_id = $_GET['account_year_id'];
    if($account_year_id!="0"){
        $whereAll.=" and account_year_id =".$account_year_id;
    }


}
if (isset($_GET['account_sub_group_idyear_id'])) {
    $sub_group_id = $_GET['sub_group_id'];
    if($sub_group_id!="0"){
        $whereAll.=" and sub_group_id =".$sub_group_id;
    }


}



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
