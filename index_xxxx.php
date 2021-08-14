<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=tis-620">
<?php
/*
$username = $_POST["username"];
$pass = $_POST["password"];
*/
$username ="farmer@hrdi.or.th";
$pass="F95uRw";

if($username !=null and $pass !=null)
{
$server = "ad01.hrdi.or.th"; //dc1-nu
$user = "farmer@hrdi.or.th";
// connect to active directory
$ad = ldap_connect($server);
if(!$ad) {
die("Connect not connect to ".$server);
// include("chk_login_db.php");
echo "ไม่สามารถติดต่อ server มหาลัยเพื่อตรวจสอบรหัสผ่านได้";
exit();
} else { 
$b = @ldap_bind($ad,$username,$pass);
echo $b;
if(!$b) {
die("<br><br>
<div align='center'> ท่านกรอกรหัสผ่านผิดพลาด
<br>
</div>
<meta http-equiv='refresh' content='3 ;url=index.php'>");
} else { 

//login ผ่านแล้วมาทำไรก็ว่าไป
session_start();


} 

echo "<script type=text/javascript>";
echo "alert('ยินดีต้อนรับ ')";
echo "</script>";
echo "<meta http-equiv='refresh' content='0 ;url= index.php?case_i=13'>";	
exit();
}

}
?>