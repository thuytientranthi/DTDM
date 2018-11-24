<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/ConstantUtil.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/util/Utf8ToLatinUtil.php'; ?>
<?php
function highlight_word($content, $word) {
  $replace = '<span style="background-color: #FF0;">' . $word . '</span>'; 
  $content = str_ireplace( $word, $replace, $content ); 
  return $content; 
}
?>
<ul class="business_catgnav">
  <?php 
    if(isset($_GET['search'])){
      $search = $_GET['search'];
    }
    $sql = "SELECT COUNT(*) AS total FROM news AS n INNER JOIN cat_list AS c ON n.cat_id = c.id INNER JOIN users AS u ON n.created_by = u.id WHERE n.active = 1 AND (n.id LIKE '%{$search}%' OR n.name LIKE '%{$search}%' OR c.name LIKE '%{$search}%' OR username LIKE '%{$search}%') OR preview LIKE '%{$search}%' ORDER BY n.id";
    $rs = mysql_query($sql);
    $arTotal = mysql_fetch_assoc($rs);
    $total = $arTotal['total'];
    if($total > 0){
      $row_count = ROW_COUNT5;
      $num_link = 3;
      if(isset($_GET['page']) && is_numeric($_GET['page'])){
        $current_page = $_GET['page'];
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
      $query = "SELECT m.id AS id, m.name AS newsName, m.date_create as date_create, counter, n.name AS catName, username, m.picture AS picture, preview FROM news AS m INNER JOIN cat_list AS n ON m.cat_id = n.id INNER JOIN users AS p ON m.created_by = p.id WHERE (m.id LIKE '%{$search}%' OR m.name LIKE '%{$search}%' OR n.name LIKE '%{$search}%' OR username LIKE '%{$search}%' OR preview LIKE '%{$search}%') and m.active = 1 ORDER BY m.id DESC LIMIT {$offset},{$row_count}";
      $result = mysql_query($query);
      while($ar = mysql_fetch_assoc($result)){
        $id = $ar['id'];
        $news_name = $ar['newsName'];
        $picture = $ar['picture'];
        $cat_name = $ar['catName'];
        $username = $ar['username'];
        $counter = $ar['counter'];
        $preview = $ar['preview'];
        $date_create = $ar['date_create'];
        $urlDetail = '/detail.php?id='.$id;
      ?>
  <li>
    <figure class="bsbig_fig" style="width: 204%;"> <a title="<?php echo $news_name; ?>" href="<?php echo $urlDetail; ?>" class="featured_img"><?php if($picture != ""){ ?><img id="imgrs" alt="" src="/files/<?php echo $picture; ?>" class="img-responsive" /><?php } ?><span class="overlay"></span> </a>
      <div class="cu">
        <figcaption> <a title="<?php echo $news_name; ?>" href="<?php echo $urlDetail; ?>"><?php echo highlight_word($news_name,$search); ?></a> </figcaption>
        <span class="inf"><i class="fa fa-tags"></i>&nbsp;<strong style="color:red;"><?php echo highlight_word($cat_name, $search); ?></strong>&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo highlight_word($username, $search); ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($date_create)) ?></strong></i>&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;<strong style="color:#d083cf;"><?php echo $counter; ?></strong></i></span>
        <p><?php echo highlight_word($preview, $search); ?></p>
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
        $pagination .= '<li class="first"><a href="#" id="1" title="First">&laquo;</a></li>';
        $pagination .= '<li><a href="#" id="'.$previous_link.'" title="Previous">&lt;</a></li>'; 
        for($i = ($current_page-2); $i < $current_page; $i++){
          if($i > 0){
            $pagination .= '<li><a href="#" id="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
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
          $pagination .= '<li><a href="#" id="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
        }
      }
      if($current_page < $total_page){ 
        $next_link = $current_page + 1;
        $pagination .= '<li><a href="#" id="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
        $pagination .= '<li class="last"><a href="#" id="'.$total_page.'" title="Last">&raquo;</a></li>'; //last link
      }
      $pagination .= '</ul>'; 
    }
    return $pagination;
  }
  echo paginate_function($row_count, $current_page, $total, $total_page);
  ?>
</div>
<?php }else{ ?>
<p style="color: red;font-size: 15px;">Không có kết quả tìm kiếm nào</p>
<?php } ?>
