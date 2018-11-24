<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/header.php'; ?>
<script type="text/javascript">
    document.title = "Delete Cat | VinaEnter Edu";
</script>
<?php   
    if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id'])){
        $message = "Id danh mục không phù hợp";
        header("Location: /admin/cat/?msg=" . urlencode($message));
        die();
    }
    $catId = $_GET['id'];
    $sql = "SELECT COUNT(*) AS count FROM cat_list WHERE id = {$catId}";
    $rs = mysql_query($sql);
    $arCount = mysql_fetch_assoc($rs);
    if($arCount['count'] > 0){
    	// xóa ảnh
        $queryOldStory = "SELECT picture FROM cat_list as c left join news as n on c.id = n.cat_id WHERE n.cat_id = {$catId} or c.parent_id = {$catId}";
        $resultOldStory = mysql_query($queryOldStory);
        if(mysql_num_rows($resultOldStory) > 0){
        	while($arOldStory = mysql_fetch_assoc($resultOldStory)){
	            $fileNameOld[] = $arOldStory['picture'];
	        }
	        foreach ($fileNameOld as $key => $value) {
	        	unlink($_SERVER['DOCUMENT_ROOT'].'/files/'.$value);
	        }        
	    }
        $queryDelCat = "DELETE c, n, cm FROM cat_list as c left join news as n on c.id = n.cat_id left join comment as cm on n.id = cm.news_id WHERE c.id = {$catId} or c.parent_id = {$catId} or n.cat_id = {$catId}";
        $resultDelCat = mysql_query($queryDelCat);
        if($resultDelCat){
            $message = "Xóa thành công";
            header("Location:/admin/cat/index.php?msg=" . urlencode($message));
            die();
        }else{
            $message ="Có lỗi trong quá trình xử lý";
            header("Location:/admin/cat/index.php?msg=" . urlencode($message));
            die();
        }
    }else{
        $message ="Không tồn tại danh mục này";
        header("Location:/admin/cat/index.php?&msg=" . urlencode($message));
        die();
    }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/admin/inc/footer.php'; ?>