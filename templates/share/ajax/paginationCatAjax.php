<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/ConstantUtil.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/Utf8ToLatinUtil.php'; ?>
<ul class="business_catgnav">
	<?php
	if(isset($_POST['cat_id'])){
		$cat_id = $_POST['cat_id'];
	}
	$row_count = ROW_COUNT5;
	$num_link = 3;
	$sql = "SELECT COUNT(*) totalNews FROM news as n inner join cat_list as c on n.cat_id = c.id WHERE (n.cat_id = {$cat_id} or c.parent_id = {$cat_id}) AND n.active = 1";
	$result = mysql_query($sql);
	$arTotal = mysql_fetch_assoc($result);
	$total = $arTotal['totalNews'];
	if($total > 0){
		if(isset($_POST['page']) && is_numeric($_POST['page'])){
			$current_page = $_POST['page'];
		}else{
			$current_page = 1;
		}
		$offset = ($current_page - 1) * $row_count;
		$total_page = ceil($total / $row_count);
		if($current_page > $num_link){
			$start = $current_page - ($num_link - 1);
		}else{
			$start = 1;
		}
		if(($current_page + $num_link) <= $total_page){
			$end = $current_page + ($num_link-1);
		}else{
			$end = $total_page;
		}
		$sql = "SELECT n.id as id, n.name as name, picture, date_create, counter, username, preview from news as n inner join users as u on n.created_by = u.id inner join cat_list as c on n.cat_id = c.id where (n.cat_id = {$cat_id} or c.parent_id = {$cat_id}) AND n.active = 1 order by n.id desc limit {$offset}, {$row_count}";
		$rs = mysql_query($sql);
		while($ar = mysql_fetch_assoc($rs)){
			$urlDetail = '/detail.php?id='.$ar['id'];
			?>
		<li>
			<figure class="bsbig_fig" style="width: 204%;"> <a title="<?php echo $ar['name']; ?>" href="<?php echo $urlDetail; ?>" class="featured_img"><?php if($ar['picture'] != ""){ ?><img id="imgrs" alt="" src="/files/<?php echo $ar['picture']; ?>" class="img-responsive" /><?php } ?><span class="overlay"></span> </a>
				<div class="cu">
					<figcaption> <a title="<?php echo $ar['name']; ?>" href="<?php echo $urlDetail; ?>"><?php echo $ar['name']; ?></a> </figcaption>
					<span class="inf"><i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $ar['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($ar['date_create'])) ?></strong></i>&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;<strong style="color:#d083cf;"><?php echo $ar['counter']; ?></strong></i></span>
					<p><?php echo $ar['preview']; ?></p>
				</div>
			</figure>
		</li>
	<?php } ?>
</ul>
<div class="pagination">
	<?php
	function paginate_function($row_count, $current_page, $total, $total_page)
	{
	    $pagination = '';
	    if($total_page > 0 && $total_page != 1 && $current_page <= $total_page){ 
	        $pagination .= '<ul>';
	        $right_links    = $current_page + 3; 
	        $previous       = $current_page - 3; 
	        $next           = $current_page + 1; 
	        $first_link     = true; 
	        if($current_page > 1){
				$previous_link = $current_page - 1;
	            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>';
	            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; 
	                for($i = ($current_page-2); $i < $current_page; $i++){
	                    if($i > 0){
	                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
	                    }
	                }   
	            $first_link = false; 
	        }
	        if($first_link){
	            $pagination .= '<li class="first active">'.$current_page.'</li>';
	        }elseif($current_page == $total_page){
	            $pagination .= '<li class="last active">'.$current_page.'</li>';
	        }else{ 
	            $pagination .= '<li class="active">'.$current_page.'</li>';
	        }      
	        for($i = $current_page+1; $i < $right_links ; $i++){ 
	            if($i<=$total_page){
	                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
	            }
	        }
	        if($current_page < $total_page){ 
				$next_link = $current_page + 1;
                $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                $pagination .= '<li class="last"><a href="#" data-page="'.$total_page.'" title="Last">&raquo;</a></li>'; //last link
	        }
	        $pagination .= '</ul>'; 
	    }
	    return $pagination;
	}
	echo paginate_function($row_count, $current_page, $total, $total_page);
	?>
</div>
<?php }else{ ?>
<p style="color: red;font-size: 15px;">Không có tin nào trong danh mục này</p>
<?php } ?>