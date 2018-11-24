<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
	$id = $_GET['aid'];
	$active = $_GET['aactive'];
	if($active == 1){
		$img = '/templates/admin/assets/img/deactive.gif';
		$active = 0;
	}else{
		$img = '/templates/admin/assets/img/active.gif';
		$active = 1;
	}
	$sql = "UPDATE users SET active = {$active} WHERE id = {$id}";
	$result = mysql_query($sql);

	$sql1 = "SELECT count(*) as totalUser from users where active = 0";
    $rs1 = mysql_query($sql1);
    $arUser = mysql_fetch_assoc($rs1);
    $totalUser = $arUser['totalUser'];

	$result = $img."***".$totalUser;
	echo $result;	
?>