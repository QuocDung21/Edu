<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

$select_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
$select_contents->execute([$tutor_id]);
$total_contents = $select_contents->rowCount();

$select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
$select_playlists->execute([$tutor_id]);
$total_playlists = $select_playlists->rowCount();

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
$select_likes->execute([$tutor_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
$select_comments->execute([$tutor_id]);
$total_comments = $select_comments->rowCount();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bảng điều khiển</title>

   <!-- Liên kết đến Font Awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến tập tin CSS tùy chỉnh  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section style="height: 100vh" class="dashboard">


   <h1 class="heading">Bảng điều khiển</h1>

   <div class="box-container">

      <div class="box">
         <h3>Chào mừng!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="profile.php" class="btn">Xem hồ sơ</a>
      </div>

      <div class="box">
         <h3><?= $total_contents; ?></h3>
         <p>Tổng số nội dung</p>
         <a href="add_content.php" class="btn">Thêm nội dung mới</a>
      </div>

      <div class="box">
         <h3><?= $total_playlists; ?></h3>
         <p>Tổng số danh sách phát</p>
         <a href="add_playlist.php" class="btn">Thêm danh sách phát mới</a>
      </div>

      <div class="box">
         <h3><?= $total_likes; ?></h3>
         <p>Tổng số lượt thích</p>
         <a href="contents.php" class="btn">Xem nội dung</a>
      </div>

      <div class="box">
         <h3><?= $total_comments; ?></h3>
         <p>Tổng số bình luận</p>
         <a href="comments.php" class="btn">Xem bình luận</a>
      </div>

      <div class="box">
         <h3>Lựa chọn nhanh</h3>
         <p>Đăng nhập hoặc đăng ký</p>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">Đăng nhập</a>
            <a href="register.php" class="option-btn">Đăng ký</a>
         </div>
      </div>

   </div>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
