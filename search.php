<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/header.php'; ?>
  <section id="contentSection">
    <div class="row">
      <?php if(isset($_GET['msg'])){ ?><p style="color: red; text-align: center;"><?php echo urldecode($_GET['msg']); ?></p><?php } ?>
      <div class="col-lg-8 col-md-8 col-sm-8">
        <?php
          if(isset($_POST['submit'])){
            $search = $_POST['search']; 
            if(empty($search)){
              $message ="Vui lòng nhập thông tin tìm kiếm";
              header("location:/search.php?msg=". urlencode($message));
              die();
            }
            $sql = "SELECT COUNT(*) AS total FROM news AS n INNER JOIN cat_list AS c ON n.cat_id = c.id INNER JOIN users AS u ON n.created_by = u.id WHERE (n.id LIKE '%{$search}%' OR n.name LIKE '%{$search}%' OR c.name LIKE '%{$search}%' OR username LIKE '%{$search}%') AND n.active = 1 ORDER BY n.id";
            $rs = mysql_query($sql);
            $arTotal = mysql_fetch_assoc($rs);
            $total = $arTotal['total'];
        ?>    
        <div class="left_content">
          <ol class="breadcrumb">
            <li><a>Tìm kiếm</a></li>
            <li><a>Có <span style="color:green;"><?php echo $total; ?></span> kết quả tìm kiếm với từ khóa: <span style="color:red"><?php echo $search; ?></span></a></li>
          </ol>
        </div>
        <div class="loading-div"><img src="/templates/share/images/ajax-loader.gif" ></div>
        <div class="single_post_content_left" search="<?php echo $search; ?>" id="results">
          
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content" page="<?php echo $current_page; ?>">
          <?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/leftbar.php'; ?>
        </aside>
      </div>
    </div>
    <script type="text/javascript">
      document.title = "Tìm kiếm với từ khóa <?php echo $search; ?>";
    </script>
  <?php 
    }
  ?>
  </section>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/footer.php'; ?>