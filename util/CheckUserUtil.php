<?php
    if(!isset($_SESSION['userInfo'])){
        header("location:/auth/admin/login.php");
        die();
    }
?>