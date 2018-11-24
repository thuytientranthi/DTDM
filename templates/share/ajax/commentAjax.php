<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DBConnectionUtil.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/CheckUserCommentUtil.php';
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$content = $_POST['acontent'];
	$userid = $_POST['auserid'];
	$member = $_POST['amember'];
	$id = $_POST['aid'];
	if($member > 0){
		$active = 1;
	}else{
		$active = 0;
	}
	$sql = "INSERT INTO comment(content, news_id, user_id, active) VALUES('{$content}', '{$id}', '{$userid}', '{$active}')";
	$result =mysql_query($sql);
?>
<?php
	if($member == 0){
?>
<div class="xetduyet"><i class="glyphicon glyphicon-pushpin"></i>&nbsp;&nbsp;<span>Bình luận của bạn đang chờ xét duyệt.</span></div>
<fieldset class="cmt" style="display: none;">
	<legend><h2>Comment <i class="glyphicon glyphicon-comment"></i></h2></legend>
	<table>
		<tr>
			<td>Content</td>
			<td><textarea name="contentComment" class="comment_content" style="width: 400%;"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" class="submit_comment" name="submit" value="Bình luận"></td>
		</tr>
	</table>
</fieldset>
<?php 
	}else{ 
		$sql = "SELECT c.id as id, username, avatar, n.date_create as date_create, content, google_id FROM comment AS c inner join users as u ON c.user_id = u.id inner JOIN news AS n ON c.news_id = n.id WHERE c.news_id = {$id} AND c.active = 1 and c.parent_id = 0 ORDER BY c.id DESC limit 1";
		$rs =mysql_query($sql);
		$ar = mysql_fetch_assoc($rs);
		$message = nl2br($content);
?>
	<li>
		<?php
		if($ar['google_id'] != ""){ 
		?>
		<img class="img_cmt" src="<?php echo $img; ?>" width="40" height="40" />
		<?php }else{ ?>
		<?php 
		if($ar['avatar'] != ""){
			$img = $ar['avatar'];
		}elseif($member == 1){
			$img = "find_user.png";
		}elseif($member == 0){
			$img = "userpic.gif";
		}
		?>
		<img class="img_cmt" src="/files/<?php echo $img; ?>" width="40" height="40" />
		<?php } ?>
		<div>
			<b><?php echo $ar['username']; ?></b><small>&nbsp;<?php echo $ar['date_create']; ?>&nbsp;<a style="display: " id-repshow="<?php echo $ar['id']; ?>" href="javascript:void(0)" class="rep-ashow" title="Replay" id="rep-ashow<?php echo $ar['id']; ?>">Replay</a>
				<a style="display: none" id-rephide="<?php echo $ar['id']; ?>" href="javascript:void(0)" class="rep-ahide" title="Hide" id="rep-ahide<?php echo $ar['id']; ?>">Hide</a>
			</small>
			<p class="content_cmt"><?php echo $message; ?></p>
		</div>
		<?php
		$sqlCount = "SELECT COUNT(*) AS total FROM comment WHERE active = 1 AND parent_id = {$ar['id']}";
		$result =mysql_query($sqlCount);
		$arCount = mysql_fetch_assoc($result);
		?>
		<div>
			<a href="javascript:void(0)" idshow="<?php echo $ar['id']; ?>" id="showcmt<?php echo $ar['id']; ?>" class="showcmt" title="Show">Show <i id="total<?php echo $ar['id']; ?>"><?php echo $arCount['total']; ?></i> rep bình luận</a>
		</div>
	      <!-- hien thi rep binh luan -->
	      <ul style="display: none ;" class="repcomment<?php echo $ar['id']; ?>">
	        <?php
	          $sql2 = "SELECT username, avatar, c.date_create as date_create, content FROM comment AS c inner join users as u on c.user_id = u.id WHERE c.active = 1 AND c.parent_id = '{$ar['id']}'";
	          $result2 =mysql_query($sql2);
	          while($arReplay = mysql_fetch_assoc($result2)){
	            $messageRep = nl2br($arReplay['content']);
	        ?>
	        <li>
        	<?php
        		if($ar['google_id'] != ""){ 
			?>
			<img class="img_cmt" src="<?php echo $img; ?>" width="40" height="40" />
				<?php }else{ ?>
	          <?php 
	            if($arReplay['avatar'] != ""){
	              $img = $arReplay['avatar'];
	            }elseif($member == 1){
	              $img = "find_user.png";
	            }elseif($member == 0){
	              $img = "userpic.gif";
	            } 
			?>
			<img class="img_cmt" src="/files/<?php echo $img; ?>" width="40" height="40" />
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
	      <div class="kquarep<?php echo $ar['id']; ?>">
	        <fieldset id="replay_cmt" userid="<?php echo $userid; ?>" total="<?php echo $arCount['total']; ?>" member="<?php echo $member; ?>" class="replay_cmt<?php echo $ar['id']; ?>" style="display: none;">
	          <legend>Your Replay</legend>
	          <form style="display: " action="javascript:void(0)">
	            <table>
	              <tr>
	                <td>Content&nbsp;</td>
	                <td class="replay"><textarea required="" id="content_replay" class="content_replay<?php echo $ar['id']; ?>" style="width: 470px; height: 24px"></textarea></td>
	              </tr>
	              <tr>
	                <td></td>
	                <td><input type="submit" name="submit" class="btn-success submit_replay" id_news="<?php echo $id; ?>" idcmtrep="<?php echo $ar['id']; ?>" value="Replay"></td>
	              </tr>
	            </table>
	           </form> 
	        </fieldset>
	      </div>
	</li>
<?php } ?>
