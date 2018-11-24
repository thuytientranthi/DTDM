<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/util/ConstantUtil.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/util/Utf8ToLatinUtil.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/util/CheckUserCommentUtil.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>ShareIT | Vinaenter Edu</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="/templates/share/images/share.png">
  <script src="/templates/share/assets/js/jquery.min.js"></script>
  <script src="/templates/share/assets/js/bootstrap.min.js"></script>
  <script src="/templates/share/assets/js/wow.min.js"></script>  
  <script src="/templates/share/assets/js/slick.min.js"></script> 
  <script src="/templates/share/assets/js/jquery.li-scroller.1.0.js"></script> 
  <script src="/templates/share/assets/js/jquery.newsTicker.min.js"></script> 
  <script src="/templates/share/assets/js/jquery.fancybox.pack.js"></script> 
  <script src="/templates/share/assets/js/custom.js"></script>
  <script src="/library/jquery/jquery.validate.min.js"></script>
  <script src="/library/jquery/ajax.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/animate.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/font.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/li-scroller.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/slick.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/jquery.fancybox.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/theme.css">
  <link rel="stylesheet" type="text/css" href="/templates/share/assets/css/style.css">
</head>
<body>
  <?php
  function sw_get_current_weekday() {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $weekday = date("l");
    $weekday = strtolower($weekday);
    switch($weekday) {
      case 'monday':
      $weekday = 'Thứ hai';
      break;
      case 'tuesday':
      $weekday = 'Thứ ba';
      break;
      case 'wednesday':
      $weekday = 'Thứ tư';
      break;
      case 'thursday':
      $weekday = 'Thứ năm';
      break;
      case 'friday':
      $weekday = 'Thứ sáu';
      break;
      case 'saturday':
      $weekday = 'Thứ bảy';
      break;
      default:
      $weekday = 'Chủ nhật';
      break;
    }
    echo $weekday.', Ngày '.date('d/m/Y');
  }
  ?>
  <a class="scrollToTop" href="javascript:void(0)"><i class="fa fa-angle-up"></i></a>
  <div class="container">
    <header id="header">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="header_top">
            <div class="header_top_left">
              <ul class="top_nav">
                <li></li>
                <li></li>
              </ul>
            </div>
            <div class="header_top_right">
              <p><span class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                <?php sw_get_current_weekday(); ?> || <span id="clock"></span></p>
              </div>
              <script>
                function startTime() {
                  var today = new Date();
                  var h = today.getHours();
                  var m = today.getMinutes();
                  var s = today.getSeconds();
                  m = checkTime(m);
                  s = checkTime(s);

                  document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
                  var t = setTimeout(startTime, 500);
                }
                function checkTime(i) {
                  if (i < 10) {i = "0" + i}; 
                  return i;
                }
                document.querySelector('body').addEventListener("load", startTime());
              </script>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="header_bottom">
              <div class="logo_area"><a href="/index.php" class="logo">SHAREIT-VNE</a></div>
              <div><a target="_blank" href="https://vinaenter.edu.vn"><img src="/templates/share/images/logo.png"></a></div>
            </div>
          </div>
        </div>
      </header>
      <section id="navArea">
        <nav class="navbar navbar-inverse" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav main_nav">
              <li><a href="/index.php" title="Trang chủ"><span class="fa fa-home desktop-home"></span><span class="mobile-show">Home</span></a></li>
              <?php
                $sql = "SELECT * FROM cat_list WHERE parent_id = 0";
                $rs = mysql_query($sql);
                while($arCat = mysql_fetch_assoc($rs)){
                  $urlCat = '/cat.php?id='.$arCat['id'];
                  $catId = $arCat['id'];
              ?>
              <li class="dropdown"><a href="<?php echo $urlCat; ?>" title="<?php echo $arCat['name']; ?>"><?php echo $arCat['name']; ?></a>
                <ul class="dropdown-menu" role="menu">
                <?php 
                $query = "SELECT * FROM cat_list WHERE parent_id = {$catId} ";
                $result = mysql_query($query);
                  while ($ro = mysql_fetch_assoc($result)){
                    $urlCat1 = '/cat.php?id='.$ro['id'];
                    $id = $ro['id'];
                ?>
                <li><a href="<?php echo $urlCat1; ?>" title="<?php echo $ro['name']; ?>"><?php echo $ro['name']; ?></a></li>
                <?php 
                  }
                ?>
                </ul>
              </li>
              <?php
                }
              ?>
              <li><a href="/contact.php" title="Liên hệ">Contact</a></li>
              <li class="login">
                <?php if(!isset($_SESSION['userComment']) && !isset($_SESSION['userGG'])){ ?>
                <a title="Đăng nhập" href="/auth/share/login.php">Login</a>
                <?php }elseif(isset($_SESSION['userComment'])){$urlSlugEdit = '/auth/share/edit.php?id='.$_SESSION['userComment']['id']; ?>
                <li class="login2">   
                  <a class="tkus" href="javascript:void(0)" title="Tài khoản"><img class="us" width="40" height="40" src="/files/<?php echo $_SESSION['userComment']['avatar']; ?>" /></a>
                  <div class="drop-down" style="display: none;">
                    <strong class="na">Name: <span style="color: red;"><?php echo $_SESSION['userComment']['username'] ?></span></strong>
                    <strong class="me">Email: <span style="color: red;"><?php echo $_SESSION['userComment']['email'] ?></span></strong>
                    <div class="clr"></div>
                    <div class="tt"> 
                      <a href="<?php echo $urlSlugEdit; ?>" title="Chỉnh sửa" class="chinhsua" />Chỉnh sửa</a>
                      <a href="/auth/share/logout.php" title="Đăng xuất" class="dangxuat" />Đăng xuất</a>
                    </div>
                  </div>
                </li> 
                <?php }elseif(isset($_SESSION['userGG'])){ ?>
                  <li class="login2">   
                  <a class="tkus" href="javascript:void(0)" title="Tài khoản"><img class="us" width="40" height="40" src="<?php echo $_SESSION['userGG']['avatar']; ?>" /></a>
                  <div class="drop-down" style="display: none;">
                    <strong class="na">Name: <span style="color: red;"><?php echo $_SESSION['userGG']['username'] ?></span></strong>
                    <strong class="me">Email: <span style="color: red;"><?php echo $_SESSION['userGG']['email'] ?></span></strong>
                    <div class="clr"></div>
                    <div class="tt"> 
                      <a href="/auth/share/logout.php" title="Đăng xuất" class="dangxuat" />Đăng xuất</a>
                    </div>
                  </div>
                </li>
              <?php } ?>
              </li>
            </ul>
            <script type="text/javascript">
              var url = window.location;
              $('ul.nav a').filter(function () {
                return this.href == url;
              }).parents('li').addClass('active');
            </script>
          </div>
        </nav>
      </section>
      <section id="newsSection">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="latest_newsarea"> <span>Tin mới nhất</span>
              <ul id="ticker01" class="news_sticker">
                <?php
                  $sql = "SELECT id, picture, name FROM news where active = 1 ORDER BY id DESC LIMIT 5";
                  $rs = mysql_query($sql);
                  while($arNews = mysql_fetch_assoc($rs)){
                    $url = '/detail.php?id='.$arNews['id'];
                ?>
                <li><a href="<?php echo $url; ?>" title="<?php echo $arNews['name']; ?>"><img src="/files/<?php echo $arNews['picture']; ?>" alt=""><?php echo $arNews['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="social_area">
                <ul class="social_nav">
                  <li class="facebook"><a href="/auth/share/login.php"></a></li>
                  <li class="googleplus"><a href="/auth/share/login.php"></a></li>
                </ul>
              	<form style="display:inline;" action="/search.php" method="post" class="tk">
                	<input type="text" name="search" class="form-control1" placeholder="Nhập từ khóa tìm kiếm" />
                	<button type="submit" name="submit" class="btn-danger"><i class="glyphicon glyphicon-search"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>