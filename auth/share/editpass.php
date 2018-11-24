<?php
    session_start();
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Forgot Form</title>
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
					Forgot Password
				</span>
				<?php
					if(!isset($_SESSION['id'])){
						$message = "Bạn chưa yêu cầu lấy lại mật khẩu";
						header("location:/auth/share.login.php?msgg=".urlencode($message));
						die();
					}
					$id = $_GET['id'];
					if($_GET['id'] != $_SESSION['id']){
						$message = "Bạn không có quyền sửa mật khẩu của người dùng khác";
						header("location:/auth/share.login.php?msgg=".urlencode($message));
						die();
					}
					$err = "";
					$password = "";
					if(isset($_POST['submit'])){
						$password = $_POST['password'];
						$confirm_password = $_POST['confirm_password'];
						if(empty($password) || empty($confirm_password)){
							$err = "Vui lòng nhập password / confirm_password phù hợp";
						}elseif(!preg_match("/^[a-z0-9_-]{6,18}$/", $password)){
							$err = "Vui lòng nhập đúng định dạng password";
						}elseif($password != $confirm_password){
							$err = "Vui lòng nhập đúng password";
						}else{
							$password = md5($password);
	                        $sql = "UPDATE users set password = '{$password}' where id = {$id}";
	                        $rs = mysql_query($sql);
	                        if($rs){
	                        	unset($_SESSION['id']);
	                        	$message = "Mật khẩu của bạn đã thay đổi thành công";
	                            header("location:/index.php?msg=".urlencode($message));
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
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">
					<p style="color:red;text-align:center"><?php echo $err; ?></p>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="password" name="password" minlength="6" placeholder="Password" />
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter confirm_password">
						<input class="input100" type="password" name="confirm_password" minlength="6" placeholder="Confirm Password" />
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn" type="submit" name="submit" value="Forgot Password" />
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