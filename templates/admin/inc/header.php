<?php
    session_start();
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/CheckUserUtil.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/util/ConstantUtil.php';
    
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>AdminCP | VinaEnter Edu</title>
    <link rel="shortcut icon" type="image/ico" href="/templates/admin/assets/img/reading.png">
    <!-- BOOTSTRAP STYLES-->
    <link href="/templates/admin/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="/templates/admin/assets/css/coin-slider.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="/templates/admin/assets/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- CUSTOM STYLES-->
    <link href="/templates/admin/assets/css/custom.css" rel="stylesheet" />
    <script type="text/javascript" src="/library/jquery/jquery-3.3.1.min.js"></script> 
    
    <script type="text/javascript" src="/library/jquery/ajax.js"></script> 
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="/templates/admin/assets/js/bootstrap.min.js" ></script>
    <script src="/templates/admin/assets/js/coin-slider.min.js" ></script>
    <script src="/templates/admin/assets/js/script.js" ></script>
    <!-- METISMENU SCRIPTS -->
    <script src="/templates/admin/assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="/templates/admin/assets/js/custom.js" ></script>
    <script type="text/javascript" src="/library/jquery/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/library/ckeditor/ckeditor.js"></script> 
    <script type="text/javascript" src="/library/ckfinder/ckfinder.js"></script> 
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/admin/index.php">VinaEnter Edu</a>
            </div>
            <?php
                if(isset($_SESSION['userInfo'])){
                    $fullname = $_SESSION['userInfo']['fullname'];
            ?>
            <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;">
             Xin chào, <b><?php echo $fullname  ?></b> &nbsp; 
             <a href="/auth/admin/logout.php" class="btn btn-danger square-btn-adjust" title="Đăng xuất">Đăng xuất</a> 
            </div>
            <?php
                }
            ?>
        </nav>
        <!-- /. NAV TOP  -->