<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/header.php'; ?>
  <section id="contentSection">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="left_content">
          <div class="contact_area">
            <h2>Liên hệ</h2>
            <?php
              if(isset($_GET['msg'])){
            ?>
            <strong style="color: red; font-size: 15px"><?php echo urldecode($_GET['msg']); ?></strong>
            <?php
              }
            ?>
            <p>Nếu có thắc mắc hoặc góp ý, vui lòng liên hệ với chúng tôi theo thông tin dưới đây.</p>
            <?php
              if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $email = $_POST['email'];
                $website = $_POST['website'];
                $message = $_POST['message'];
                if(empty($name) || empty($email) || empty($website) || empty($message)){
                  $message ="Vui lòng nhập đủ thông tin";
                  header("location:/contact.php?msg=". urlencode($message));
                  die();
                }elseif(!preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $website) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email) || preg_match('/[@#$%*!]/', $name)){
                  $message ="Vui lòng nhập đúng thông tin name / email / website";
                  header("location:/contact.php?msg=". urlencode($message));
                  die();
                }else{
                  $query = "INSERT INTO contact(name, email, website, content) VALUES ('{$name}', '{$email}', '{$website}', '{$message}')";
                  $result = mysql_query($query);
                  if($result){
                    $message ="Bạn đã gửi liên hệ thành công";
                    header("location:/contact.php?msg=". urlencode($message));
                    die();
                  }else{
                    $message ="Có lỗi xảy ra!";
                    header("location:/contact.php?msg=". urlencode($message));
                    die();
                  }
                }
              }
            ?>
            <form action="" class="contact_form" method="post" id="sendemail">
              <ol>
                <li>
                  <label for="name">Họ tên (required)</label>
                  <input class="form-control" type="text" name="name" placeholder="Name*">
                </li>
                <li>
                  <label for="name">Email (required)</label>
                  <input class="form-control" type="email" name="email" placeholder="Email*">
                </li>
                <li>
                  <label for="name">Website (required)</label>
                  <input class="form-control" type="text" name="website" placeholder="Website*">
                </li>
                <li>
                  <label for="name">Nội dung (required)</label>
                  <textarea class="form-control" name="message" cols="30" rows="5" placeholder="Message*"></textarea>
                </li>
                <input type="submit" name="submit" value="Send Message">
            </form>
            <script type="text/javascript">
            $(document).ready(function(){
              $('#sendemail').validate({
                rules:{
                  "name": {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                  },
                  "email": {
                    required: true,
                    email: true
                  },
                  "website": {
                    required:true,
                    url: true
                  },
                  "message":{
                    required: true
                  }
                },
                messages: {
                  "name": {
                    required: 'Vui lòng nhập tên',
                    minlength: 'Vui lòng nhập lớn hơn 6 kí tự',
                    maxlength: 'Vui lòng nhập tên không dài quá 20 kí tự'
                  },
                  "email": {
                    required: 'Vui lòng nhập email',
                    email: 'Vui lòng nhập đúng định dạng email'
                  },
                  "website": {
                    required:"Vui lòng nhập website",
                    url: 'Vui lòng nhập đúng định dạng website'
                  },
                  "message":{
                    required: "Vui lòng nhập nội dung liên hệ"
                  }
                }
              });
            });
          </script>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content">
          <?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/leftbar.php'; ?>
        </aside>
      </div>
    </div>
  </section>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/templates/share/inc/footer.php'; ?>