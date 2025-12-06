<?php
include '../public/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);


  $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/image/";
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
  
  $sql = "INSERT INTO information (name, phone, address ,image ,email ,birthdate) 
  VALUES ('$name', '$phone', '$address' , '$image' ,'$email' ,'$birthdate')";
  if (mysqli_query($conn, $sql)) {
      header('Location: ../public/dashboard.php');

  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
