<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giáo viên</title>

   <!-- Liên kết đến Font Awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến tập tin CSS tùy chỉnh  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Phần section để hiển thị danh sách giáo viên bắt đầu  -->

<section class="teachers">

   <h1 class="heading">Giáo viên chuyên môn</h1>

   <form action="search_tutor.php" method="post" class="search-tutor">
      <input type="text" name="search_tutor" maxlength="100" placeholder="Tìm kiếm giáo viên..." required>
      <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
   </form>

   <div class="box-container">

      <div class="box offer">
         <h3>Trở thành giáo viên</h3>
         <p>Trở thành giáo viên để chia sẻ các bài giảng đến mọi người</p>
         <a href="admin/register.php" class="inline-btn">Bắt đầu</a>
      </div>

      <?php
         $select_tutors = $conn->prepare("SELECT * FROM `tutors`");
         $select_tutors->execute();
         if($select_tutors->rowCount() > 0){
            while($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)){

               $tutor_id = $fetch_tutor['id'];

               $count_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
               $count_playlists->execute([$tutor_id]);
               $total_playlists = $count_playlists->rowCount();

               $count_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
               $count_contents->execute([$tutor_id]);
               $total_contents = $count_contents->rowCount();

               $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
               $count_likes->execute([$tutor_id]);
               $total_likes = $count_likes->rowCount();

               $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
               $count_comments->execute([$tutor_id]);
               $total_comments = $count_comments->rowCount();
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_tutor['profession']; ?></span>
            </div>
         </div>
         <p>Danh sách phát : <span><?= $total_playlists; ?></span></p>
         <p>Tổng số video : <span><?= $total_contents ?></span></p>
         <p>Tổng số lượt thích : <span><?= $total_likes ?></span></p>
         <p>Tổng số bình luận : <span><?= $total_comments ?></span></p>
         <form action="tutor_profile.php" method="post">
            <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
            <input type="submit" value="Xem hồ sơ" name="tutor_fetch" class="inline-btn">
         </form>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">Không tìm thấy giáo viên!</p>';
         }
      ?>

   </div>

</section>

<!-- Kết thúc phần section để hiển thị danh sách giáo viên -->

<?php include 'components/footer.php'; ?>    

<!-- Liên kết đến tập tin js tùy chỉnh  -->
<script src="js/script.js"></script>
   
</body>
</html>
