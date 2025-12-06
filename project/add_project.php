<?php
include '../public/db_connect.php';
// session_start();

// // استدعاء اسم المستخدم أو البريد من الجلسة
// $user_id = $_SESSION['user_id'] ?? null;

// // التحقق مما إذا كان محظورًا
// if ($user_id) {
//     $check_block = mysqli_query($conn, "SELECT is_blocked FROM users WHERE id = $user_id");
//     $row = mysqli_fetch_assoc($check_block);
    
//     if ($row && $row['is_blocked'] == 1) {
//         die("<div style='color: red; font-weight: bold;'>تم حظرك من إضافة البيانات. يرجى الاتصال بالإدارة.</div>");
//     }
// }





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $project_title = mysqli_real_escape_string($conn, $_POST['project_title']);
  // $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
  $project_description = mysqli_real_escape_string($conn, $_POST['project_description']);
  $project_tags = mysqli_real_escape_string($conn, $_POST['project_tags']);


    $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/project/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // التحقق من أن الملف صورة
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
      // إنشاء اسم فريد للصورة
      $new_filename = uniqid() . '.' . $imageFileType;
      $target_path = $target_dir . $new_filename;
      
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
        $image = $new_filename;
      }
    }
  }

  $sql = "INSERT INTO projects (project_title,image, project_description,project_tags ) VALUES ('$project_title', '$image', '$project_description' ,'$project_tags')";
  // tast
  // $sql = "INSERT INTO project (project_title, image_url, project_description ,project_tags ) VALUES ('llll', 'nnjkk', 'gjhjbh' ,'ghjlglhjg')";
  if (mysqli_query($conn, $sql)) {

// ✨ إشعار بإضافة مشروع جديد
$notif_title = "مشروع جديد";
$notif_message = "تمت إضافة مشروع: $project_title";
$conn->query("INSERT INTO notifications (title, message) VALUES ('$notif_title', '$notif_message')");

    header('Location: list_projects.php');
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
