<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
   $select_tutor->execute([$tutor_id]);
   $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

   $prev_pass = $fetch_tutor['password'];
   $prev_image = $fetch_tutor['image'];

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $profession = $_POST['profession'];
   $profession = filter_var($profession, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `tutors` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $tutor_id]);
      $message[] = 'Tên người dùng đã được cập nhật thành công!';
   }

   // if(!empty($profession)){
   //    $update_profession = $conn->prepare("UPDATE `tutors` SET profession = ? WHERE id = ?");
   //    $update_profession->execute([$profession, $tutor_id]);
   //    $message[] = 'Chuyên nghiệp đã được cập nhật thành công!';
   // }

   if(!empty($email)){
      $select_email = $conn->prepare("SELECT email FROM `tutors` WHERE id = ? AND email = ?");
      $select_email->execute([$tutor_id, $email]);
      if($select_email->rowCount() > 0){
         $message[] = 'Email đã tồn tại!';
      }else{
         $update_email = $conn->prepare("UPDATE `tutors` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $tutor_id]);
         $message[] = 'Email đã được cập nhật thành công!';
      }
   }

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'Kích thước hình ảnh quá lớn!';
      }else{
         $update_image = $conn->prepare("UPDATE `tutors` SET `image` = ? WHERE id = ?");
         $update_image->execute([$rename, $tutor_id]);
         move_uploaded_file($image_tmp_name, $image_folder);
         if($prev_image != '' AND $prev_image != $rename){
            unlink('../uploaded_files/'.$prev_image);
         }
         $message[] = 'Hình ảnh đã được cập nhật thành công!';
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'Mật khẩu cũ không khớp!';
      }elseif($new_pass != $cpass){
         $message[] = 'Mật khẩu xác nhận không khớp!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `tutors` SET password = ? WHERE id = ?");
            $update_pass->execute([$cpass, $tutor_id]);
            $message[] = 'Mật khẩu đã được cập nhật thành công!';
         }else{
            $message[] = 'Vui lòng nhập mật khẩu mới!';
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
   <title>Cập Nhật Hồ Sơ</title>

   <!-- Liên kết đến Font Awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Liên kết đến tập tin CSS tùy chỉnh  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<!-- Phần section để cập nhật thông tin hồ sơ  -->

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>Cập Nhật Hồ Sơ</h3>
      <div class="flex">
         <div class="col">
            <p>Tên của bạn </p>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50"  class="box">
            <p style="display:none">Chuyên nghiệp của bạn </p>
            <select style="display:none" name="profession" class="box">
               <option value="teacher" selected><?= $fetch_profile['profession']; ?></option>
               <option value="developer">Lập trình viên</option>
               <option value="desginer">Thiết kế</option>
               <option value="musician">Nhạc sĩ</option>
               <option value="biologist">Nhà sinh vật học</option>
               <option value="teacher">Giáo viên</option>
               <option value="engineer">Kỹ sư</option>
               <option value="lawyer">Luật sư</option>
               <option value="accountant">Kế toán</option>
               <option value="doctor">Bác sĩ</option>
               <option value="journalist">Nhà báo</option>
               <option value="photographer">Nhiếp ảnh gia</option>
            </select>
            <p>Email của bạn </p>
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="20"  class="box">
         </div>
         <div class="col">
            <p>Mật khẩu cũ :</p>
            <input type="password" name="old_pass" placeholder="Nhập mật khẩu cũ của bạn" maxlength="20"  class="box">
            <p>Mật khẩu mới :</p>
            <input type="password" name="new_pass" placeholder="Nhập mật khẩu mới của bạn" maxlength="20"  class="box">
            <p>Xác nhận mật khẩu mới :</p>
            <input type="password" name="cpass" placeholder="Xác nhận mật khẩu mới của bạn" maxlength="20"  class="box">
         </div>
      </div>
      <p>Cập nhật hình ảnh :</p>
      <input type="file" name="image" accept="image/*"  class="box">
      <input type="submit" name="submit" value="Cập Nhật Ngay" class="btn">
   </form>

</section>

<!-- Kết thúc phần section để cập nhật thông tin -->

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
