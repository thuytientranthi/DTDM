<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
	session_start();
	$sql = "SELECT * FROM users WHERE email='".$_POST["email"]."'";
	$result = mysql_query($sql);
	if(!empty(mysql_fetch_assoc($result))){
		$sql2 = "UPDATE users SET google_id='".$_POST["id"]."' WHERE email='".$_POST["email"]."'";
	}else{
		$sql2 = "INSERT INTO users (username, email, avatar, member, google_id) VALUES ('".$_POST["name"]."', '".$_POST["email"]."', '".$_POST["avatar"]."', '0', '".$_POST["id"]."')";
	}
	mysql_query($sql2);
	$_SESSION["userGG"] = array("id" => $_POST["id"], "username" => $_POST["name"], "email" => $_POST["email"], "avatar" => $_POST["avatar"], "active" => 1);
?>