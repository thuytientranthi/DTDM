<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<script type="text/javascript">
    document.title = "Delete Contact | VinaEnter Edu";
</script>
<?php
    if(isset($_POST['submit'])){
        if(!isset($_POST['checkid'])){
            $message = "Bạn chưa chọn liên hệ muốn xóa";
            header("location:/admin/contact/?msg=". urlencode($message));
            die();
        }
        $val = $_POST['checkid'];
        while(list ($key,$value) = @each($val)){
            $sqlDel = "DELETE FROM contact WHERE id = $value";
            $result = mysql_query($sqlDel);
        }
?>
<script type="text/javascript">
    window.location.href = "/admin/contact/?&msg=Bạn đã xóa liên hệ thành công";
</script>
<?php    
        die();   
    }
    if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id']) || !isset($_GET['page']) || !preg_match("/^[0-9]+$/", $_GET['page'])){
        $message = "Id / page liên hệ không phù hợp";
        header("Location: /admin/contact/?msg=". urlencode($message));
        die();
    }
    $page = $_GET['page'];
    $id = $_GET['id'];
    $sql = "SELECT COUNT(*) AS count FROM contact WHERE id = {$id}";
    $rs = mysql_query($sql);
    $arCount = mysql_fetch_assoc($rs);
    if($arCount['count'] > 0){
        $query = "DELETE FROM contact WHERE id = {$id}";
        $result = mysql_query($query);
        if($result){
            $message = "Xóa liên hệ thành công";
            header("Location:/admin/contact/?page={$page}&msg=". urlencode($message));
            die();
        }else{
            $message = "Xóa liên hệ thất bại";
            header("Location:/admin/contact/?msg=". urlencode($message));
            die();
        }
    }else{
        $message = "Không tồn tại id liên hệ này";
        header("Location:/admin/contact/?msg=". urlencode($message));
        die();
    }
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>