<?php
    session_start();
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
?>
<?php 
	if(isset($_SESSION['userComment']) || isset($_SESION['userGG'])){ 
		header("location:/index.php");
	} 
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

	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<meta name="google-signin-client_id" content="173179092334-sqnl5sri6euiouccqhfvjd75f92asl8r.apps.googleusercontent.com" />

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
					Account Login Comment
				</span>
                <?php
                    if(isset($_POST['login'])){
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        if(empty($username) || empty($password)){
                            header("location:/auth/share/login.php?msg=Vui lòng nhập đầy đủ thông tin");
                            die();
                        }
                        $password = md5($_POST['password']);    
                        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND member = 0";
                        $result = mysql_query($query);
                        $arUser = mysql_fetch_assoc($result);
                        if(is_array($arUser)){
                            $_SESSION['userComment'] = $arUser;
                            header("Location:/index.php");
                            die();
                        }else{
                            header("Location:/auth/share/login.php?msg=Error");
                            die();
                        }
                    }
                if(isset($_GET['msg']) == 'Error'){
                ?>
                    <p style="background: yellow; color: red; font-weight: bold;text-align: center;" ><?php echo 'Sai tên đăng nhập hoặc mật khẩu' ?></p>
                <?php
                    }
                ?>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">
                <?php
	                if(isset($_GET['msgg'])){
	            ?>
	            <p style="color: red; text-align: center;"><?php echo $_GET['msgg']; ?></p>
	            <?php
	                }
	            ?>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="User name">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					
						<a class="forgot" href="/auth/share/forgot.php" title="Quên mật khẩu">Forgot passwor?</a>
					<div class="container-login100-form-btn m-t-32">
						<span class="g-signin2" data-onsuccess="onSignIn"></span>
					</div>
					<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn" type="submit" name="login" value="Login" />
						<a class="login100-form-btn" href="/auth/share/resign.php" title="Đăng ký">Sign up?</a>
					</div>
				</form>
                <script type="text/javascript">
                  	function onSignIn(googleUser) {
                        var profile = googleUser.getBasicProfile();
                        if(profile){
                            $.ajax({
                                type: 'POST',
                                url: '/auth/share/login_gg.php',
                                data: {id:profile.getId(), name:profile.getName(), email:profile.getEmail(), avatar:profile.getImageUrl()}
                            }).done(function(data){
                                window.location.href = '/index.php';
                            });
                        }
                    }
                </script>
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