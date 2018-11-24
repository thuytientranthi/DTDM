<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/header.php'; ?>
  <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <?php
          if(!isset($_GET['id']) || !preg_match("/^[0-9]+$/", $_GET['id'])){
            $message = "Id danh mục không phù hợp";
            header("Location: /?msg=". urlencode($message));
            die();
          }
          $cat_id = $_GET['id'];
          $query = "SELECT * FROM cat_list WHERE id = {$cat_id}";
          $result = mysql_query($query);
          $row = mysql_fetch_assoc($result);
          $cat_name = $row['name'];
        ?>
        <script type="text/javascript">
          document.title = "<?php echo $cat_name; ?>";
        </script>
        <div class="left_content">
          <ol class="breadcrumb">
            <li><a href="/index.php">Home</a></li>
            <li><a><?php echo $cat_name; ?></a></li>
          </ol>
        </div>
        <div class="loading-div"><img src="/templates/share/images/ajax-loader.gif" ></div>
        <div class="single_post_content_left" id="results1" cat_id="<?php echo $cat_id; ?>"></div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content">
          <?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/leftbar.php'; ?>
        </aside>
      </div>
    </div>
  </section>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/footer.php'; ?>