<?php

include '../components/connect.php';

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ? LIMIT 1");
   $select_tutor->execute([$email, $pass]);
   $row = $select_tutor->fetch(PDO::FETCH_ASSOC);
   
   if($select_tutor->rowCount() > 0){
     setcookie('tutor_id', $row['id'], time() + 60*60*24*30, '/');
     header('location:dashboard.php');
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
   <title>Đăng nhập</title>

   <!-- Liên kết đến font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến file css tùy chỉnh -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="padding-left: 0;">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- Phần bắt đầu phần đăng nhập -->

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>Chào mừng trở lại!</h3>
      <p>Email của bạn <span>*</span></p>
      <input type="email" name="email" placeholder="Nhập email của bạn" maxlength="20" required class="box">
      <p>Mật khẩu của bạn <span>*</span></p>
      <input type="password" name="pass" placeholder="Nhập mật khẩu của bạn" maxlength="20" required class="box">
      <p class="link">Chưa có tài khoản? <a href="register.php">Đăng ký mới</a></p>
      <input type="submit" name="submit" value="Đăng nhập ngay" class="btn">
   </form>

</section>

<!-- Phần kết thúc phần đăng nhập -->

<!-- Phần script -->

<script>

let darkMode = localStorage.getItem('dark-mode');
let body = document.body;

const enabelDarkMode = () =>{
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}else{
   disableDarkMode();
}

</script>
   
</body>
</html>
