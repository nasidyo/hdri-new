<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $year='';
 if (isset($_GET['year'])) {
    $year = $_GET['year'];
  }

$name='';
if (isset($_GET['name'])) {
    $name = $_GET['name'];
}
$area='';
if (isset($_GET['area'])) {
    $area = $_GET['area'];
}
 $sql2=" SELECT
 tmp.year_text,
 tmp.name ,
 SUM (tmp.income_debt) income_debt ,
 SUM (tmp.ex_debt )    expense_debt
FROM
 (
     SELECT DISTINCT
         ay.year_text ,
         ms_ins.name,
         ISNULL( SUM (income.DEBT), 0) income_debt ,
         0                                       ex_debt

     FROM
         ms_institute ms_ins
     LEFT JOIN
         INSTITUTE ins
     ON
         ms_ins.name = ins.INSTITUTE_NAME
     LEFT JOIN
         INCOME_TD income
     ON
         ins.INSTITUTE_ID = income.INSTITUTE_ID
     LEFT JOIN
         SubPersonGroup sp
     ON
         ins.INSTITUTE_ID =sp.institute_id
     INNER JOIN
         AccountYear ay
     ON
         sp.sub_group_id = ay.sub_group_id
         where income.CANCELED <> 'Y' AND income.RECEIVE_DATE  >= ay.account_year_start AND income.RECEIVE_DATE  <=   ay.account_year_end
                    and ay.year_text= '".$year."'";
    if($area != 0 || $area != ''){
        $sql2.="  and ins.AREA_ID = '".$area."' ";
    }

    $sql2.=" GROUP BY
         ms_ins.name,
         ay.year_text
     UNION
     SELECT DISTINCT
         ay.year_text ,
         ms_ins.name,
         0                                   income_debt ,
         ISNULL( SUM (ex.DEBT), 0) ex_debt

     FROM
         ms_institute ms_ins
     LEFT JOIN
         INSTITUTE ins
     ON
         ms_ins.name = ins.INSTITUTE_NAME
     LEFT JOIN
         EXPENSE_TD ex
     ON
         ins.INSTITUTE_ID = ex.INSTITUTE_ID
     LEFT JOIN
         SubPersonGroup sp
     ON
         ins.INSTITUTE_ID =sp.institute_id
     INNER JOIN
         AccountYear ay
     ON
         sp.sub_group_id = ay.sub_group_id
         where ex.CANCELED <> 'Y' AND ex.EXPENSE_DATE  >= ay.account_year_start AND ex.EXPENSE_DATE  <=   ay.account_year_end
                    and ay.year_text= '".$year."'";
    if($area != 0 || $area != ''){
        $sql2.="  and ins.AREA_ID = '".$area."' ";
    }
    $sql2.=" GROUP BY
         ms_ins.name,
         ay.year_text ) tmp
                    where name = '".$name."'
            GROUP BY
            tmp.year_text,
            tmp.name   ";


 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['income_debt'] = $row['income_debt'];
    $row_array['expense_debt'] = $row['expense_debt'];
    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
