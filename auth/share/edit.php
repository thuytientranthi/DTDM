<?php
    session_start();
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit Form</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/templates/auth/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/templates/auth/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/templates/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/templates/auth/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/templates/auth/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/templates/auth/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/templates/auth/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/templates/auth/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/templates/auth/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/templates/auth/css/util.css">
	<link rel="stylesheet" type="text/css" href="/templates/auth/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<?php
        $sql = "SELECT picture FROM slide";
        $rs = mysql_query($sql);
        $num = mysql_num_rows($rs);
        while($arBackground = mysql_fetch_assoc($rs)){
            $ar[] = $arBackground['picture'];
        }
        $bk = array_rand($ar);
        $background = $ar[$bk];
    ?>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('/files/<?php echo $background; ?>');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Edit Account
				</span>
				<?php
					$err = "";
					if(!isset($_SESSION['userComment'])){
						$message = "Bạn chưa đăng nhập";
						header("location:/index.php?msg=". urlencode($message));
						die();
					}
					$sql = "SELECT * FROM users WHERE id = {$_SESSION['userComment']['id']}";
					$result = mysql_query($sql);
					$arUser = mysql_fetch_assoc($result);
					$oldavatar = $arUser['avatar'];
					$urlSlugEdit = '/auth/share/edit.php?id='.$_SESSION["userComment"]["id"];
					$urlSlug = '/index.php';
					if(isset($_POST['submit'])){
						$name = $_POST['username'];
						$password = $_POST['password'];
						$email = $_POST['email'];
	                	$check = $_POST['xoa'];
						if(empty($email) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)){
							$message = "Vui lòng nhập đầy đủ và phù hợp thông tin";
							header("location:$urlSlugEdit?msg=". urlencode($message));
							die();
						}
						$newName = $oldavatar;
						if($check || $_FILES['avatar']['name'] != ''){
	                        $path_root = $_SERVER['DOCUMENT_ROOT'];
	                        unlink($path_root.'/files/'.$newName);
	                        $newName = "";
	                    }
	                    if($_FILES['avatar']['name'] != ''){
	                        $namePicture = $_FILES['avatar']['name'];
	                        $arName = explode('.',$namePicture);
	                        $typeFile = end($arName);
	                        $newName = 'VNE-Story-'.time().'.'.$typeFile;
	                        $tmp_name = $_FILES['avatar']['tmp_name'];
	                        $path_root = $_SERVER['DOCUMENT_ROOT'];
	                        $path_upload = $path_root.'/files/'.$newName;
	                        $move_upload = move_uploaded_file($tmp_name,$path_upload);
	                    }
	                    if($password == ""){
	                    	$query2 = "UPDATE users SET username = '{$name}', avatar = '{$newName}', email = '{$email}' WHERE id = {$_SESSION['userComment']['id']}";
		                    $result2 = mysql_query($query2);
		                    if($result2){
		                    	$message = "Chỉnh sửa thành công. Vui lòng đăng nhập lại để cập nhật thông tin";
		                        header("location:$urlSlug?msg=". urlencode($message));
		                        die();
		                    }else{
		                        echo '<p>Có lỗi trong quá trình xử lý</p>';
		                        die();
		                    }
	                    }else{
	                    	$password = md5($password);
	                    	$query2 = "UPDATE users SET username = '{$name}', password = '{$password}', avatar = '{$newName}', email = '{$email}' WHERE id = {$_SESSION['userComment']['id']}";
		                    $result2 = mysql_query($query2);
		                    if($result2){
		                    	$message = "Chỉnh sửa thành công. Vui lòng đăng nhập lại để cập nhật thông tin";
		                        header("Location:$urlSlug?msg=". urlencode($message));
		                        die();
		                    }else{
		                        echo '<p>Có lỗi trong quá trình xử lý</p>';
		                        die();
		                    }
	                    } 					
					}
				?>
				<?php
	                if(isset($_GET['msg'])){
	            ?>
	            <p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p>
	            <?php
	                }
	            ?>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post" enctype="multipart/form-data">
					<p style="color:red;text-align:center"><?php echo $err; ?></p>
					<div class="wrap-input100">
						<input style="background: darkgrey;" class="input100" type="text" name="username" placeholder="User name" value="<?php echo $arUser['username']; ?>" readonly />
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>
					<div class="wrap-input100">
						<input class="input100" type="password" name="password" placeholder="Password" />
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter email">
						<input class="input100" type="email" name="email" placeholder="Email" value="<?php echo $arUser['email']; ?>" />
					</div>
					<?php 
						if($arUser['avatar'] != ""){
					?>
					<div class="wrap-input100">
						<img style="margin-left: 20%;" src="/files/<?php echo $arUser['avatar']; ?>" alt="<?php echo $arUser['avatar']; ?>" width="90" height="90" /><br />
						<input style="margin-left: 20%;" type="checkbox" name="xoa" value="xoa" /> Xóa ảnh cũ<br />
						<input class="input100" type="file" name="avatar" />
					</div>
					<?php
						}else{
					?>
					<div class="wrap-input100">
						<input class="input100" type="file" name="avatar" />
					</div>
					<?php } ?>
					<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn" type="submit" name="submit" value="Submit" />
						<a href="/index.php" title="Quay về trang chủ" class="login100-form-btn">Quay lại</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="/templates/auth/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/templates/auth/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="/templates/auth/vendor/bootstrap/js/popper.js"></script>
	<script src="/templates/auth/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/templates/auth/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/templates/auth/vendor/daterangepicker/moment.min.js"></script>
	<script src="/templates/auth/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="/templates/auth/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="/templates/auth/js/main.js"></script>

</body>
</html>
<?php
    ob_end_flush();
?>