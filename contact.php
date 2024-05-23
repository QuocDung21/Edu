<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $name = $_POST['name']; 
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email']; 
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number']; 
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg']; 
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_contact->execute([$name, $email, $number, $msg]);

   if($select_contact->rowCount() > 0){
      $message[] = 'Tin nhắn đã được gửi!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
      $insert_message->execute([$name, $email, $number, $msg]);
      $message[] = 'Tin nhắn đã được gửi thành công!';
   }

}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Liên hệ</title>

   <!-- Liên kết đến Font Awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến tập tin CSS tùy chỉnh  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Phần section để hiển thị thông tin liên hệ bắt đầu  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3>Liên hệ</h3>
         <input type="text" placeholder="Nhập tên của bạn" required maxlength="100" name="name" class="box">
         <input type="email" placeholder="Nhập email của bạn" required maxlength="100" name="email" class="box">
         <input type="number" min="0" max="9999999999" placeholder="Nhập số điện thoại của bạn" required maxlength="10" name="number" class="box">
         <textarea name="msg" class="box" placeholder="Nhập nội dung tin nhắn của bạn" required cols="30" rows="10" maxlength="1000"></textarea>
         <input type="submit" value="Gửi tin nhắn" class="inline-btn" name="submit">
      </form>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>Số điện thoại</h3>
         <a href="tel:1234567890">123-456-7890</a>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>Địa chỉ email</h3>
         <a href="mailto:admin@gmail.com">admin@gmail.come</a>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>Địa chỉ văn phòng</h3>
         <a href="#">Spkt Vĩnh Long</a>
      </div>


   </div>

</section>

<!-- Kết thúc phần section để hiển thị thông tin liên hệ -->

<?php include 'components/footer.php'; ?>  

<!-- Liên kết đến tập tin js tùy chỉnh  -->
<script src="js/script.js"></script>
   
</body>
</html>
