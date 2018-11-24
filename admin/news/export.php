<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php'; ?>
<?php
if(isset($_POST['export'])){
	$output = "";
	$sql = "SELECT m.id AS id, m.name AS newsName, n.name AS catName, username, m.active AS active, m.picture AS picture FROM news AS m INNER JOIN cat_list AS n ON m.cat_id = n.id INNER JOIN users AS p ON m.created_by = p.id ORDER BY m.id DESC";
	$rs = mysql_query($sql);
	if(mysql_num_rows($rs) > 0){
		
	$output .= '
	<table border=1>
	    <thead>
	        <tr>
	            <th>ID</th>
	            <th>Tên tin</th>
	            <th>Danh mục tin</th>
	            <th>Người thêm</th>
	            <th>Trạng thái</th>
	            <th>Hình ảnh</th>
	        </tr>
	    </thead>
	    <tbody>';
		while($arNews = mysql_fetch_assoc($rs)){
			$id = $arNews['id'];
	        $news_name = $arNews['newsName'];
	        $picture = $arNews['picture'];
	        $cat_name = $arNews['catName'];
	        $active = $arNews['active'];
	        $username = $arNews['username'];	
		$output .= '
			<tr>
				<td>'.$id.'</td>
				<td>'.$news_name.'</td>
				<td>'.$cat_name.'</td>
				<td>'.$username.'</td>
				<td>'.$active.'</td>
				<td>'.$picture.'</td>
			</tr>';
		}
	$output .= '	
   		</tbody>
	</table>';
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=news.xls");
	echo $output;
	}
}elseif(isset($_POST['export-counter'])){
	$output = "";
	$sql = "SELECT m.id AS id, m.name AS newsName, n.name AS catName, username, counter, m.active AS active, m.picture AS picture FROM news AS m INNER JOIN cat_list AS n ON m.cat_id = n.id INNER JOIN users AS p ON m.created_by = p.id ORDER BY counter DESC";
	$rs = mysql_query($sql);
	if(mysql_num_rows($rs) > 0){
		
	$output .= '
	<table border=1>
	    <thead>
	        <tr>
	            <th>ID</th>
	            <th>Tên tin</th>
	            <th>Danh mục tin</th>
	            <th>Người thêm</th>
	            <th>Lượt đọc</th>
	            <th>Trạng thái</th>
	            <th>Hình ảnh</th>
	        </tr>
	    </thead>
	    <tbody>';
		while($arNews = mysql_fetch_assoc($rs)){
			$id = $arNews['id'];
	        $news_name = $arNews['newsName'];
	        $picture = $arNews['picture'];
	        $cat_name = $arNews['catName'];
	        $active = $arNews['active'];
	        $counter = $arNews['counter'];
	        $username = $arNews['username'];	
		$output .= '
			<tr>
				<td>'.$id.'</td>
				<td>'.$news_name.'</td>
				<td>'.$cat_name.'</td>
				<td>'.$username.'</td>
				<td>'.$counter.'</td>
				<td>'.$active.'</td>
				<td>'.$picture.'</td>
			</tr>';
		}
	$output .= '	
   		</tbody>
	</table>';
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=news-counter.xls");
	echo $output;
	}
}
?>
