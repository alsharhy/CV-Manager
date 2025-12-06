<?php
include '../public/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $qualification_title = mysqli_real_escape_string($conn, $_POST['qualification_title']);
  $qualification_description = mysqli_real_escape_string($conn, $_POST['qualification_description']);


    $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/qualification/";
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

  $sql = "INSERT INTO qualifications (qualification_title, qualification_description ,image ) 
  VALUES ('$qualification_title', '$qualification_description','$image')";

  if (mysqli_query($conn, $sql)) {

// ✨ إشعار بإضافة مشروع جديد
$notif_title = "طموح جديد";
$notif_message = "تمت إضافة طموح: $qualification_title";
$conn->query("INSERT INTO notifications (title, message) VALUES ('$notif_title', '$notif_message')");

    header('Location: list_qualification.php');
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
<?php
include '../public/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $qualification_title = mysqli_real_escape_string($conn, $_POST['qualification_title']);
  $qualification_description = mysqli_real_escape_string($conn, $_POST['qualification_description']);


    $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/qualification/";
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

  $sql = "INSERT INTO qualifications (qualification_title, qualification_description ,image ) 
  VALUES ('$qualification_title', '$qualification_description','$image')";

  if (mysqli_query($conn, $sql)) {

// ✨ إشعار بإضافة مشروع جديد
$notif_title = "طموح جديد";
$notif_message = "تمت إضافة طموح: $qualification_title";
$conn->query("INSERT INTO notifications (title, message) VALUES ('$notif_title', '$notif_message')");

    header('Location: list_qualification.php');
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
