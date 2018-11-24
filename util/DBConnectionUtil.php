<?php
$host = ":/cloudsql/helloworld-nhom2:us-central1:shareitdb";
$user = "nhom2";
$pass = "nhom2";
$db = "shareit";
$conn  = mysql_connect($host,$user,$pass);
mysql_set_charset('utf8',$conn);
if(!$conn ){
	die("khong the ket noi: " . mysql_error());
}else{
	$selectDB = mysql_select_db($db);
}
?>
