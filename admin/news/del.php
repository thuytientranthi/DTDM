<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<script type="text/javascript">
    document.title = "Delete News | VinaEnter Edu";
</script>
<?php
    if(isset($_POST['submit'])){
        if(!isset($_POST['checkid'])){
            $message ="Bạn chưa chọn tin muốn xóa";
            header("location:/admin/news/?msg=". urlencode($message));
            die();
        }
        $val = $_POST['checkid'];
        while(list ($key,$value) = @each($val)){
            $queryOldStory = "SELECT * FROM news WHERE id = $value";
            $resultOldStory = mysql_query($queryOldStory);
            $arOldStory = mysql_fetch_assoc($resultOldStory);
            $fileNameOld = $arOldStory['picture'];
            if($fileNameOld != ''){
                $filePath = $_SERVER['DOCUMENT_ROOT'].'/files/'.$fileNameOld;
                unlink($filePath);
            }
            if(is_array($arOldStory)){
                $sqlDel = "DELETE n,c FROM news as n left join comment as c on n.id = c.news_id WHERE n.id = $value or c.news_id = $value";
                $result = mysql_query($sqlDel);
            }
        }
?>
<script type="text/javascript">
    window.location.href = "/admin/news/?&msg=Bạn đã xóa tin thành công";
</script>
<?php    
        die();   
    }
    if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id']) || !isset($_GET['page']) || !preg_match("/^[0-9]+$/", $_GET['page'])){
        $message ="Id / page tin không phù hợp";
        header("Location: /admin/news/?msg=". urlencode($message));
        die();
    }
    $page = $_GET['page'];
    $id = $_GET['id'];
    $queryOldStory = "SELECT * FROM news WHERE id = {$id}";
    $resultOldStory = mysql_query($queryOldStory);
    $arOldStory = mysql_fetch_assoc($resultOldStory);
    if(is_array($arOldStory)){
        $fileNameOld = $arOldStory['picture'];
        if($fileNameOld != ''){
            $filePath = $_SERVER['DOCUMENT_ROOT'].'/files/'.$fileNameOld;
            unlink($filePath);
        }
        $query2 = "SELECT username FROM users AS m INNER JOIN news AS n ON m.id = n.created_by WHERE n.id = {$id}";
        $ketqua2 = mysql_query($query2);
        $arUser = mysql_fetch_assoc($ketqua2);
        if($arUser['username'] != $_SESSION['userInfo']['username'] && $_SESSION['userInfo']['username'] != 'admin'){
            $message ="Bạn không có quyền xóa bài viết của user khác";
            header("Location:/admin/news/?msg=". urlencode($message));
            die();
        }
        $query = "DELETE n,c FROM news as n left join comment as c on n.id = c.news_id WHERE n.id = {$id} or c.news_id = {$id}";
        $result = mysql_query($query);
        
        if($result){
            $message="Xóa tin thành công";
            header("Location:/admin/news/?page={$page}&msg=". urlencode($message));
            die();
        }else{
            $message ="Xóa tin thất bại";
            header("Location:/admin/news/?msg=". urlencode($message));
            die();
        }
    }else{
        $message ="Không tồn tại id tin này";
        header("Location:/admin/news/?msg=". urlencode($message));
        die();
    }
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>