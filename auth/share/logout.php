<?php
    session_start();
    ob_start();
    if(isset($_SESSION['userComment'])){
        unset($_SESSION['userComment']);
    }elseif(isset($_SESSION['userGG'])){
    	unset($_SESSION['userGG']);
    }
?>
<script type="text/javascript" src="https://mail.google.com/mail/u/0/?logout&hl=en"></script>
<script type="text/javascript">
	window.location.href = "/index.php";
</script>
<?php ob_end_flush(); ?>