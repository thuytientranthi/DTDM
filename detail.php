<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/header.php'; ?>
  <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <div class="single_page">
            <ol class="breadcrumb">
              <?php
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $id = $_GET['id'];
                //tăng lượt đọc
                $sql = "UPDATE news SET counter = (counter + 1) WHERE id = {$id}";
                $result = mysql_query($sql);
                $sql = "SELECT COUNT(*) AS total FROM news WHERE id = {$id} AND active = 1";
                $rs = mysql_query($sql);
                $arTotal = mysql_fetch_assoc($rs);
                $total = $arTotal['total'];
                if($total == 0){
                  $message ="Không có tin này";
                  header("Location: /?msg=". urlencode($message));
                  die();
                }
                $sql = "SELECT COUNT(*) AS totalComment FROM comment WHERE news_id = {$id}";
                $rs = mysql_query($sql);
                $arCount = mysql_fetch_assoc($rs);
                $totalComment = $arCount['totalComment'];
                $query = "SELECT c.id as idCat, n.name as nameNews, picture, detail, counter, date_create, c.name as nameCat, username FROM news as n inner join cat_list as c on n.cat_id = c.id inner join users as u on n.created_by = u.id WHERE n.id = {$id} AND n.active = 1";
                $result = mysql_query($query);
                $arNews = mysql_fetch_assoc($result);
              ?>
              <script type="text/javascript">
                document.title = "<?php echo $arNews['nameNews'] ?>";
              </script>
              <li><a href="/index.php">Home</a></li>
              <li><a title="<?php echo $arNews['nameCat']; ?>" href="/cat.php?id=<?php echo $arNews['idCat']; ?>"><strong style="color:#d083cf;"><?php echo $arNews['nameCat'] ?></strong></a></li>
            </ol>
            <h1><?php echo $arNews['nameNews']; ?></h1>
            <div class="post_commentbox">
              <i class="fa fa-tags">&nbsp;<strong style="color:red;"></i><?php echo $arNews['nameCat']; ?></strong>&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;<strong style="color:green;"><?php echo $arNews['username']; ?></strong>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<strong style="color:#d083cf;"><?php echo date("d/m/Y", strtotime($arNews['date_create'])) ?></strong></i>&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;<strong style="color:#d083cf;"><?php echo $arNews['counter']; ?></strong></i>
            </div>
            <div class="single_page_content"><?php if($arNews['picture'] != ""){ ?><img class="img-center" src="/files/<?php echo $arNews['picture']; ?>" alt="" /><?php } ?>
              <p><?php echo $arNews['detail'] ?></p>
            <?php
              //
              $sql = "SELECT COUNT(*) AS count FROM news WHERE cat_id = {$arNews['idCat']} AND id != {$id} AND active = 1";
              $rs = mysql_query($sql);
              $arCount = mysql_fetch_assoc($rs);
              if($arCount['count'] >= 1){ 
            ?>
            <!-- tin lien quan -->
            <div class="related_post">
              <h2>Tin liên quan <i class="fa fa-thumbs-o-up"></i></h2>
              <ul class="spost_nav wow fadeInDown animated">
                <?php
                  $query2 = "SELECT id, picture, name FROM news WHERE cat_id = {$arNews['idCat']} AND id != {$id} AND active = 1 ORDER BY id DESC LIMIT 3";
                  $result2 = mysql_query($query2);
                  while($row2 = mysql_fetch_assoc($result2)){
                    $picture = $row2['picture'];
                    $news_id = $row2['id'];
                    $name = $row2['name'];
                    $urlSlugDetail = '/detail.php?id='.$row2['id'];
                ?>
                <li>
                  <div class="media"> 
                    <a class="media-left" title="<?php echo $name; ?>" href="<?php echo $urlSlugDetail; ?>"><?php if($picture != ""){ ?><img src="/files/<?php echo $picture; ?>" alt="" /><?php } ?></a>
                    <div class="media-body"> <a class="catg_title" title="<?php echo $name; ?>" href="<?php echo $urlSlugDetail; ?>"><?php echo $name; ?></a> </div>
                  </div>
                </li>
                 <?php } ?>
              </ul>
            </div>
            <div class="clr"></div>
            <?php
              }
            ?>
            <!-- form binh luan -->
            <div class="article">
              <div class="kqua">
                <fieldset class="cmt" id="kqua" style="display: <?php echo $an; ?>">
                  <legend><h2>Bình luận <i class="glyphicon glyphicon-comment"></i></h2></legend>
                    <form action="javascript:void(0)">
                      <table>
                        <tr>
                          <td>Content&nbsp;</td>
                          <td>
                            <?php 
                              if(isset($_SESSION['userComment'])){ 
                                $userId = $_SESSION['userComment']['id'];
                                $member = 0;
                              }elseif(isset($_SESSION['userGG'])){
                                $qr = "SELECT id from users where google_id = {$_SESSION['userGG']['id']}";
                                $re = mysql_query($qr);
                                $arrId = mysql_fetch_assoc($re);
                                $users_id = $arrId['id'];
                                $userId = $users_id;
                                $member = 0;
                              }elseif(isset($_SESSION['userInfo'])){
                                $userId = $_SESSION['userInfo']['id'];
                                $member = 1;
                              }
                            ?>
                            <textarea name="contentComment" required="" class="comment_content" member="<?php echo $member; ?>" uid="<?php echo $userId; ?>"></textarea>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td><input type="submit" class="btn-success submit_comment" new_id="<?php echo $_GET['id'] ?>" name="submit" value="Bình luận"></td>
                        </tr>
                      </table>
                    </form>
                </fieldset>
              </div>
              <p style="font-weight:bold; text-align: center;color: red;"><?php echo $err; ?></p>
              <!-- hien thi binh luan -->
              <fieldset class="oldcmt">
                <legend><h2>Những bình luận trước <i class="glyphicon glyphicon-comment"></i></h2></legend>
                  <ul id="binhluan">
                    <?php
                      $sql1 = "SELECT c.id as id, username, avatar, c.date_create as date_create, content, member, google_id FROM comment AS c inner join users as u ON c.user_id = u.id inner JOIN news AS n ON c.news_id = n.id WHERE c.news_id = {$id} AND c.active = 1 and c.parent_id = 0 ORDER BY c.id DESC";
                      $result1 = mysql_query($sql1);
                      if(mysql_num_rows($result1) == 0){
                        echo '<strong style="color: red">Chưa có bình luận nào</strong>';
                      }else{
                        while($arComment = mysql_fetch_assoc($result1)){
                          $message = nl2br($arComment['content']);
                    ?>
                    <li>
                      <?php  
                        if($arComment['avatar'] != ""){
                          $img = $arComment['avatar'];
                        }elseif($arComment['member'] == 1){
                          $img = "find_user.png";
                        }elseif($arComment['member'] == 0){
                          $img = "userpic.gif";
                        }
                      ?>
                      <?php
                      if($arComment['google_id'] != ""){
                      ?>
                      <img class="img_cmt" src="<?php echo $arComment['avatar']; ?>" width="40" height="40" />
                      <?php }else{ ?> 
                      <img class="img_cmt" src="/files/<?php echo $img; ?>" width="40" height="40" />
                      <?php } ?>
                      <div>
                        <b><?php echo $arComment['username']; ?></b><small>&nbsp;<?php echo $arComment['date_create']; ?>&nbsp;<a style="display: <?php echo $an; ?>" id-repshow="<?php echo $arComment['id']; ?>" href="javascript:void(0)" class="rep-ashow" title="Replay" id="rep-ashow<?php echo $arComment['id']; ?>">Replay</a>
                        <a style="display: <?php echo $an; ?>" id-rephide="<?php echo $arComment['id']; ?>" href="javascript:void(0)" class="rep-ahide" title="Hide" id="rep-ahide<?php echo $arComment['id']; ?>">Hide</a>
                        </small>
                        <p class="content_cmt"><?php echo $message; ?></p>
                      </div>
                      <?php
                        $sqlCount = "SELECT COUNT(*) AS total FROM comment WHERE active = 1 AND parent_id = {$arComment['id']}";
                        $result = mysql_query($sqlCount);
                        $arCount = mysql_fetch_assoc($result);
                      ?>
                      <div>
                        <a href="javascript:void(0)" idshow="<?php echo $arComment['id']; ?>" id="showcmt<?php echo $arComment['id']; ?>" class="showcmt" title="Show">Show <i id="total<?php echo $arComment['id']; ?>"><?php echo $arCount['total']; ?></i> rep bình luận</a>
                      </div>
                      <!-- hien thi rep binh luan -->
                      <ul style="display: none;" class="repcomment<?php echo $arComment['id']; ?>">
                        <?php
                          $sql2 = "SELECT username, avatar, c.date_create as date_create, content, member, google_id FROM comment AS c inner JOIN users as u on c.user_id = u.id WHERE c.active = 1 AND c.parent_id = '{$arComment['id']}'";
                          $result2 = mysql_query($sql2);
                          while($arReplay = mysql_fetch_assoc($result2)){
                            $messageRep = nl2br($arReplay['content']);
                        ?>
                        <li>
                          <?php 
                            if($arReplay['avatar'] != ""){
                              $img = $arReplay['avatar'];
                            }elseif($arReplay['member'] == 1){
                              $img = "find_user.png";
                            }elseif($arReplay['member'] == 0){
                              $img = "userpic.gif";
                            } 
                          ?> 
                          <?php
                          if($arReplay['google_id'] != ""){
                          ?>
                          <img class="img_cmt" src="<?php echo $arReplay['avatar']; ?>" width="30" height="30" />
                          <?php }else{ ?>
                          <img class="img_cmt" src="/files/<?php echo $img; ?>" width="30" height="30" />
                          <?php } ?>
                          <div>
                            <b><?php echo $arReplay['username']; ?></b><small>&nbsp;<?php echo $arReplay['date_create']; ?></small>
                            <p class="cmt_replay"><?php echo $messageRep; ?></p>
                          </div>
                        </li>
                        <?php
                          }
                        ?>
                        <div class="clr"></div>
                      </ul>
                      <!-- form rep binh luan -->
                      <div class="kquarep<?php echo $arComment['id']; ?>">
                        <?php 
                          if(isset($_SESSION['userComment'])){ 
                            $userId = $_SESSION['userComment']['id'];
                            $member = 0;
                          }elseif(isset($_SESSION['userGG'])){
                            $qr1 = "SELECT id from users where google_id = {$_SESSION['userGG']['id']}";
                            $re1 = mysql_query($qr1);
                            $arrId1 = mysql_fetch_assoc($re1);
                            $users_id1 = $arrId1['id'];
                            $userId = $users_id1;
                            $member = 0;
                          }elseif(isset($_SESSION['userInfo'])){
                            $userId = $_SESSION['userInfo']['id'];
                            $member = 1;
                          }
                        ?>
                        <fieldset id="replay_cmt" userid="<?php echo $userId; ?>" total="<?php echo $arCount['total']; ?>" member="<?php echo $member; ?>" class="replay_cmt<?php echo $arComment['id']; ?>" style="display: none;">
                          <legend>Your Replay</legend>
                          <form style="display: <?php echo $an; ?>" action="javascript:void(0)">
                            <table>
                              <tr>
                                <td>Content&nbsp;</td>
                                <td class="replay"><textarea required="" id="content_replay" class="content_replay<?php echo $arComment['id']; ?>" style="width: 470px; height: 24px"></textarea></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td><input type="submit" name="submit" class="btn-success submit_replay" id_news="<?php echo $_GET['id'] ?>" idcmtrep="<?php echo $arComment['id']; ?>" value="Replay"></td>
                              </tr>
                            </table>
                           </form> 
                        </fieldset>
                      </div>
                    </li>
                    <?php
                      }
                    }
                    ?>
                    <div class="clr"></div>
                  </ul>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
      <!-- tin truoc do -->
      <nav class="nav-slit"> 
        <?php
          $query21 = "SELECT id, picture, name FROM news WHERE id < ($id) AND active = 1 order by id desc LIMIT 1";
          $result21 = mysql_query($query21);
          $row21 = mysql_fetch_assoc($result21);
          $picture1 = $row21['picture'];
          $news_id1 = $row21['id'];
          $name1 = $row21['name'];
          $urlSlugDetail1 = '/detail.php?id='.$news_id1;
          $sql1 = "SELECT min(id) as min from news where active = 1";
          $rs1 = mysql_query($sql1);
          $ar1 = mysql_fetch_assoc($rs1);
          $min = $ar1['min'];
          if($id > $min){
        ?>
        <a class="prev" title="<?php echo $name1; ?>" href="<?php echo $urlSlugDetail1; ?>"> <span class="icon-wrap"><i class="fa fa-angle-left"></i></span>
        <div>
          <h3><?php echo $name1; ?></h3>
          <?php if($picture1 != ""){ ?><img src="/files/<?php echo $picture1; ?>" alt="" /><?php } ?></div>
        </a> 
        <?php } ?>
        <!-- tin sau no -->
        <?php
          $query22 = "SELECT * FROM news where id > {$id} AND active = 1 LIMIT 1";
          $result22 = mysql_query($query22);
          $row22 = mysql_fetch_assoc($result22);
          $picture2 = $row22['picture'];
          $news_id2 = $row22['id'];
          $name2 = $row22['name'];
          $urlSlugDetail2 = '/detail.php?id='.$news_id2;
          $sql2 = "SELECT max(id) as max from news where active = 1";
          $rs2 = mysql_query($sql2);
          $ar2 = mysql_fetch_assoc($rs2);
          $max = $ar2['max'];
          if($id < $max){
        ?>
        <a class="next" title="<?php echo $name2; ?>" href="<?php echo $urlSlugDetail2; ?>"> <span class="icon-wrap"><i class="fa fa-angle-right"></i></span>
        <div>
          <h3><?php echo $name2; ?></h3>
          <?php if($picture2 != ""){ ?><img src="/files/<?php echo $picture2; ?>"" alt="" /><?php } ?></div>
        </a>
        <?php } ?>
      </nav>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content">
          <?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/leftbar.php'; ?>
        </aside>
      </div>
  </div>
  </section>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/footer.php'; ?>