<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<script type="text/javascript">
    document.title = "Delete User | VinaEnter Edu";
</script>
<?php
    if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id']) || !isset($_GET['page']) || !preg_match("/^[0-9]+$/", $_GET['page'])){
        $message ="Id / page người dùng không phù hợp";
        header("Location: /admin/user/?msg=". urlencode($message));
        die();
    }
    $page = $_GET['page'];
    $id = $_GET['id'];
    $query2 = "SELECT * FROM users WHERE id = {$id}";
    $ketqua2 = mysql_query($query2);
    $arUser = mysql_fetch_assoc($ketqua2);
    if($arUser['username'] == 'admin' && $_SESSION['userInfo']['username'] != 'admin'){
        $message ="Bạn không có quyền xóa admin";
        header("Location:/admin/user/?msg=". urlencode($message));
        die();
    }elseif($arUser['username'] == 'admin' && $_SESSION['userInfo']['username'] == 'admin'){
        $message ="Bạn không nên xóa admin";
        header("Location:/admin/user/?msg=". urlencode($message));
        die();
    }elseif((($arUser['username'] != $_SESSION['userInfo']['username']) && $arUser['member'] !=0) && $_SESSION['userInfo']['username'] != "admin"){
        $message ="Bạn không có quyền xóa user khác";
        header("Location:/admin/user/?msg=". urlencode($message));
        die();
    }elseif($arUser['username'] == $_SESSION['userInfo']['username']){
        $message = "Bạn không có quyền xóa tài khoản của mình";
        header("Location:/admin/user/?msg=". urlencode($message));
        die();
    }
    $sql = "SELECT COUNT(*) AS count FROM users WHERE id = {$id} ";
    $rs = mysql_query($sql);
    $arCount = mysql_fetch_assoc($rs);
    if($arCount['count'] > 0){
        $sql1 = "SELECT avatar from users where id = {$id}";
        $rs1 = mysql_query($sql1);
        $arAvatar = mysql_fetch_assoc($rs1);
        $fileNameOld = $arAvatar['avatar'];
        if(is_array($arAvatar)){
            if($fileNameOld != ''){
                $filePath = $_SERVER['DOCUMENT_ROOT'].'/files/'.$fileNameOld;
                unlink($filePath);
            }
        }
        $query = "DELETE u,c FROM users as u left join comment as c on u.id = c.user_id WHERE u.id = {$id}";
        $result = mysql_query($query);
        if($result){
            $message ="Xóa người dùng thành công";
            header("Location:/admin/user/?page={$page}&msg=". urlencode($message));
            die();
        }else{
            $message ="Có lỗi trong quá trình xử lý";
            header("Location:/admin/user/?msg=". urlencode($message));
            die();
        }
    }else{
        $message ="Không tồn tại người dùng này";
        header("Location:/admin/user/?&msg=". urlencode($message));
        die();
    }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/footer.php'; ?>