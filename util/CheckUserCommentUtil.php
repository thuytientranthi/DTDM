<?php
	$err = "";
	$an = "none";
	if(!isset($_SESSION['userComment']) && !isset($_SESSION['userGG']) && !isset($_SESSION['userInfo'])){
		$an = "none";
		$err = "Bạn cần đăng nhập để được comment vào đây";
	}elseif((isset($_SESSION['userComment']) && $_SESSION['userComment']['active'] == 0) || ((isset($_SESSION['userGG']) && $_SESSION['userGG']['active'] == 0)) || ((isset($_SESSION['userInfo']) && $_SESSION['userInfo']['active'] == 0))){
		$an = "none";
		$err = "Tài khoản này đã có những bình luận không hay nên đã bị chặn chức năng này";
	}elseif(isset($_SESSION['userComment']) || isset($_SESSION['userGG']) || isset($_SESSION['userInfo'])){
		$an = "";
	}
?>