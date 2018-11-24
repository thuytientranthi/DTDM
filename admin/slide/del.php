<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<script type="text/javascript">
    document.title = "Delete Slide | VinaEnter Edu";
</script>
<?php
    if(isset($_POST['submit'])){
        if(!isset($_POST['checkid'])){
            $message = "Bạn chưa chọn slide muốn xóa";
            header("Location:/admin/slide/?msg=". urlencode($message));
            die();
        }
        $val = $_POST['checkid'];
        while(list ($key,$value) = @each($val)){
            $query2 = "SELECT * FROM slide WHERE id = $value ";
            $result2 = mysql_query($query2);
            $row2 = mysql_fetch_assoc($result2);
            $fileNameOld = $row2['picture'];
            if($fileNameOld != ''){
                $filePath = $_SERVER['DOCUMENT_ROOT'].'/files/'.$fileNameOld;
                unlink($filePath);
            }
            if(is_array($row2)){
                $sqlDel = "DELETE FROM slide WHERE id = $value";
                $result = mysql_query($sqlDel);
            }
        }
?>
<script type="text/javascript">
    window.location.href = "/admin/slide/?&msg=Bạn đã xóa slide thành công";
</script>
<?php    
        die();   
    }
    if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id']) || !isset($_GET['page']) || !preg_match("/^[0-9]+$/", $_GET['page'])){
        $message = "Id / page slide không phù hợp";
        header("Location: /admin/slide/?msg=". urlencode($message));
        die();
    }
    $page = $_GET['page'];
    $id = $_GET['id'];
    $query2 = "SELECT * FROM slide WHERE id = {$id} ";
    $result2 = mysql_query($query2);
    $row2 = mysql_fetch_assoc($result2);
    $fileNameOld = $row2['picture'];
    if(is_array($row2)){
        if($fileNameOld != ''){
            $filePath = $_SERVER['DOCUMENT_ROOT'].'/files/'.$fileNameOld;
            unlink($filePath);
        }
        $query = "DELETE FROM slide WHERE id = {$id}";
        $result = mysql_query($query);
        
        if($result){
            $message ="Xóa slide thành công";
            header("Location:/admin/slide/?page={$page}&msg=". urlencode($message));
            die();
        }else{
            $message ="Xóa slide thất bại";
            header("Location:/admin/slide/?msg=". urlencode($message));
            die();
        }
    }else{
        $message ="Không tồn tại id slide này";
        header("Location:/admin/slide/?msg=". urlencode($message));
        die();
    } 
    
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>