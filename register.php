<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/'.$rename;

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   
   if($select_user->rowCount() > 0){
      $message[] = 'Email đã tồn tại!';
   }else{
      if($pass != $cpass){
         $message[] = 'Mật khẩu xác nhận không khớp!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image) VALUES(?,?,?,?,?)");
         $insert_user->execute([$id, $name, $email, $cpass, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);
         
         $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
         $verify_user->execute([$email, $pass]);
         $row = $verify_user->fetch(PDO::FETCH_ASSOC);
         
         if($verify_user->rowCount() > 0){
            setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
            header('location:home.php');
         }
      }
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

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>Tạo tài khoản</h3>
      <div class="flex">
         <div class="col">
            <p>Tên của bạn <span>*</span></p>
            <input type="text" name="name" placeholder="Nhập tên của bạn" maxlength="50" required class="box">
            <p>Email của bạn <span>*</span></p>
            <input type="email" name="email" placeholder="Nhập email của bạn" maxlength="20" required class="box">
         </div>
         <div class="col">
            <p>Mật khẩu của bạn <span>*</span></p>
            <input type="password" name="pass" placeholder="Nhập mật khẩu của bạn" maxlength="20" required class="box">
            <p>Xác nhận mật khẩu <span>*</span></p>
            <input type="password" name="cpass" placeholder="Xác nhận mật khẩu của bạn" maxlength="20" required class="box">
         </div>
      </div>
      <p>Chọn hình ảnh <span>*</span></p>
      <input type="file" name="image" accept="image/*" required class="box">
      <p class="link">Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
      <input type="submit" name="submit" value="Đăng ký ngay" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- Liên kết đến file js tùy chỉnh -->
<script src="js/script.js"></script>
   
</body>
</html>
