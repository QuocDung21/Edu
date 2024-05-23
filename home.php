<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
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
   <title>Trang chủ</title>

   <!-- Liên kết đến font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến file css tùy chỉnh -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Phần lựa chọn nhanh bắt đầu -->

<section class="quick-select">

   <h1 class="heading">Các tùy chọn nhanh</h1>

   <div class="box-container">

      <?php
         if($user_id != ''){
      ?>
      <div class="box">
         <h3 class="title">Thích và bình luận</h3>
         <p>Tổng số lượt thích: <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">Xem thích</a>
         <p>Tổng số bình luận: <span><?= $total_comments; ?></span></p>
         <a href="comments.php" class="inline-btn">Xem bình luận</a>
         <p>Playlist đã lưu: <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">Xem bookmark</a>
      </div>
      <?php
         }else{ 
      ?>
      <div class="box" style="text-align: center;">
         <h3 class="title">Vui lòng đăng nhập hoặc đăng ký</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">Đăng nhập</a>
            <a href="register.php" class="option-btn">Đăng ký</a>
         </div>
      </div>
      <?php
      }
      ?>

      <div class="box tutor">
         <h3 class="title">Trở thành giáo viên</h3>
         <p>Đăng ký để có thể cùng chia sẻ các bài giảng.</p>
         <a href="admin/register.php" class="inline-btn">Bắt đầu</a>
      </div>

   </div>

</section>

<!-- Phần lựa chọn nhanh kết thúc -->

<!-- Phần khóa học bắt đầu -->

<section class="courses">

   <h1 class="heading">Các khóa học mới nhất</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC LIMIT 6");
         $select_courses->execute(['active']);
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$fetch_course['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">Xem playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Chưa có khóa học nào được thêm!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-option-btn">Xem thêm</a>
   </div>

</section>

<!-- Phần khóa học kết thúc -->

<!-- Phần footer bắt đầu -->
<?php include 'components/footer.php'; ?>
<!-- Phần footer kết thúc -->

<!-- Liên kết đến file js tùy chỉnh -->
<script src="js/script.js"></script>
   
</body>
</html>
