<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Hồ sơ</title>

   <!-- Liên kết đến font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến file css tùy chỉnh -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section  class="profile" style="height: 100vh;" >

   <h1 class="heading">Chi tiết hồ sơ</h1>

   <div class="details">

      <div class="user">
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <p>Học viên</p>
         <a href="update.php" class="inline-btn">Cập nhật hồ sơ</a>
      </div>

      <div class="box-container">

         <div class="box">
            <div class="flex">
               <i class="fas fa-bookmark"></i>
               <div>
                  <h3><?= $total_bookmarked; ?></h3>
                  <span>Playlists đã lưu</span>
               </div>
            </div>
            <a href="#" class="inline-btn">Xem playlists</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-heart"></i>
               <div>
                  <h3><?= $total_likes; ?></h3>
                  <span>Video đã thích</span>
               </div>
            </div>
            <a href="#" class="inline-btn">Xem đã thích</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-comment"></i>
               <div>
                  <h3><?= $total_comments; ?></h3>
                  <span>Bình luận video</span>
               </div>
            </div>
            <a href="#" class="inline-btn">Xem bình luận</a>
         </div>

      </div>

   </div>

</section>

<!-- Phần footer -->

<footer class="footer">

   &copy; bản quyền @ 2022 bởi <span>mr. web designer</span> | đã được bảo lưu!

</footer>

<!-- Phần footer kết thúc -->

<!-- Liên kết đến file js tùy chỉnh -->
<script src="js/script.js"></script>
   
</body>
</html>
