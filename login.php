<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{         
   $user_id = '';
}

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
   if($select_user->rowCount() > 0){
     setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
     header('location:home.php');
   }else{
      $message[] = 'Email hoặc mật khẩu không đúng!';
   }

}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang chủ</title>

   <!-- Liên kết đến font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến file css tùy chỉnh -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>Chào mừng trở lại!</h3>
      <p>Email của bạn <span>*</span></p>
      <input type="email" name="email" placeholder="Nhập email của bạn" maxlength="50" required class="box">
      <p>Mật khẩu của bạn <span>*</span></p>
      <input type="password" name="pass" placeholder="Nhập mật khẩu của bạn" maxlength="20" required class="box">
      <p class="link">Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
      <input type="submit" name="submit" value="Đăng nhập ngay" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- Liên kết đến file js tùy chỉnh -->
<script src="js/script.js"></script>
   
</body>
</html>
