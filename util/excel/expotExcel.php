<?php
$file_name =$_POST['filename'].".xls";
$excel_file=$_POST['data'];
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file_name");
echo $excel_file;
 ?>  