<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<script type="text/javascript">
    document.title = "Delete Comment | VinaEnter Edu";
</script>
<?php
    if(isset($_POST['submit'])){
        if(!isset($_POST['checkid'])){
            $message ="Bạn chưa chọn bình luận muốn xóa";
            header("location:/admin/comment/?msg=". urlencode($message));
            die();
        }
        $val = $_POST['checkid'];
        while(list ($key,$value) = @each($val)){
            $sqlDel = "DELETE FROM comment WHERE id = $value or parent_id = $value";
            $result = mysql_query($sqlDel);
        }
?>
<script type="text/javascript">
    window.location.href = "/admin/comment/?&msg=Bạn đã xóa comment thành công";
</script>
<?php    
        die();   
    }
    if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id']) || !isset($_GET['page']) || !preg_match("/^[0-9]+$/", $_GET['page'])){
        $message ="Id / page bình luận không phù hợp";
        header("Location: /admin/comment/?msg=". urlencode($message));
        die();
    }
    $page = $_GET['page'];
    $id = $_GET['id'];
    $sql = "SELECT COUNT(*) AS count FROM comment WHERE id = {$id} or parent_id = {$id}";
    $rs = mysql_query($sql);
    $arCount = mysql_fetch_assoc($rs);
    if($arCount['count'] > 0){
        $query = "DELETE FROM comment WHERE id = {$id} or parent_id = {$id}";
        $result = mysql_query($query);
        if($result){
            $message ="Xóa bình luận thành công";
            header("Location:/admin/comment/?page={$page}&msg=". urlencode($message));
            die();
        }else{
            $message ="Xóa bình luận thất bại";
            header("Location:/admin/comment/?msg=". urlencode($message));
            die();
        }
    }else{
        $message ="Không tồn tại id bình luận này";
        header("Location:/admin/comment/?msg=". urlencode($message));
        die();
    }
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>