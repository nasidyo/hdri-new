<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();

  $year='';
  if (isset($_GET['year'])) {
     $year = $_GET['year'];
   }

   $old_year='';
   if (isset($_GET['old_year'])) {
      $old_year = $_GET['old_year'];
    }


    $ins_taget='';
    if (isset($_GET['ins_taget'])) {
       $ins_taget = $_GET['ins_taget'];
     }


 $sql2=" SELECT
 sp.institute_id,
 ins.INSTITUTE_NAME,
 arv.TRAN_TYPE,
 SUM( arv.TRAN_AMOUNT)                                   MONEY ,
 SUM(arv.EX_DEBT) EX_DEBT,
 SUM(arv.INC_DEBT) INC_DEBT, ";
 if($old_year==''){
    $sql2.=" concat(dbo.Month_TH(MONTH( CONVERT(DATE, arv.ORDER_DATE,103))),'-', YEAR( CONVERT(DATE, arv.ORDER_DATE,103))) Month_TH , ";
 }
 if($old_year!='' &&  $ins_taget !=""){
    $sql2.="
    ay.year_text year ";
 }else{
    $sql2.="
    ay.year_text ,
    YEAR( CONVERT(DATE, arv.ORDER_DATE,103)) year ";
 }

 $sql2.="
FROM
 Account_Records_View arv ,
 area a ,
 SubPersonGroup sp ,
 AccountYear ay,
 INSTITUTE ins
WHERE
 arv.idArea = a.idArea
AND arv.SUB_GROUP_ID = sp.sub_group_id
AND arv.SUB_GROUP_ID = ay.sub_group_id
AND sp.institute_id =ins.INSTITUTE_ID ";
if($old_year ==''){
    $sql2.=" AND  CONVERT(DATE, arv.ORDER_DATE,103) >=  DATEADD(YEAR, 543, ay.account_year_start) AND ay.year_text = '".$year."' ";
}else{
    $sql2.="AND  CONVERT(DATE, arv.ORDER_DATE,103) >=  DATEADD(YEAR, 543, ay.account_year_start) ";
}
$sql2.="
AND  CONVERT(DATE, arv.ORDER_DATE,103) <=  DATEADD(YEAR, 543, ay.account_year_end)

and  arv.CANCELED <> 'Y' ";
if( $ins_taget !=''){
    $sql2.=" and ins.INSTITUTE_NAME = '".$ins_taget."'";
}

$sql2.="
GROUP BY
 sp.institute_id,
 ins.INSTITUTE_NAME,
 arv.TRAN_TYPE, ";
 if($old_year==''){
    $sql2.=" MONTH( CONVERT(DATE, arv.ORDER_DATE,103)), ";
 }

 if($old_year!='' &&  $ins_taget !=""){
    $sql2.="
    ay.year_text
   ORDER BY
   ay.year_text ";
 }else{
    $sql2.="
    YEAR( CONVERT(DATE, arv.ORDER_DATE,103)),
    ay.year_text
   ORDER BY
   YEAR( CONVERT(DATE, arv.ORDER_DATE,103)) ";
 }


if($old_year==''){
    $sql2.=" , MONTH( CONVERT(DATE, arv.ORDER_DATE,103)) ";
 }

 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['institute_id'] = $row['institute_id'];
    $row_array['INSTITUTE_NAME'] = $row['INSTITUTE_NAME'];
    $row_array['TRAN_TYPE'] = $row['TRAN_TYPE'];

    $row_array['MONEY'] = $row['MONEY'];
    $row_array['EX_DEBT'] = $row['EX_DEBT'];
    $row_array['INC_DEBT'] = $row['INC_DEBT'];
    $row_array['year'] = $row['year'];
    if($old_year ==''){
        $row_array['Month_TH'] = $row['Month_TH'];
    }

    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
