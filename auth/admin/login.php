<?php
    session_start();
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Form</title>
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
					Account Login
				</span>
                <?php
                    if(isset($_POST['login'])){
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        if(empty($username) || empty($password)){
                        	$message ="Vui lòng nhập đầy đủ thông tin";
                            header("location:/auth/admin/login.php?msg=". urlencode($message));
                            die();
                        }
                        $password = md5($_POST['password']);    
                        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND member = 1";
                        $result = mysql_query($query);
                        $arUser = mysql_fetch_assoc($result);
                        if(is_array($arUser)){
                            $_SESSION['userInfo'] = $arUser;
                            header("location:/admin/");
                            die();
                        }else{
                        	$message = "Sai tên đăng nhập hoặc mật khẩu";
                            header("location:/auth/admin/login.php?msg=". urlencode($message));
                            die();
                        }
                    }
                if(isset($_GET['msg'])){
                ?>
                    <p style="background: yellow; color: red; font-weight: bold;text-align: center;" ><?php echo urldecode($_GET['msg']); ?></p>
                <?php
                    }
                ?>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="User name">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn" type="submit" name="login" value="Login" />
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
	if(isset($_SESSION['userInfo'])){ 
		header("location:/admin/");
	}
?>
<?php
    ob_end_flush();
?>
