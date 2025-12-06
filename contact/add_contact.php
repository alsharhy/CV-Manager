<?php
include '../public/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $instagram_url = mysqli_real_escape_string($conn, $_POST['instagram_url']);
  $telegram_url = mysqli_real_escape_string($conn, $_POST['telegram_url']);
  $facebook_url = mysqli_real_escape_string($conn, $_POST['facebook_url']);
  $threads_url = mysqli_real_escape_string($conn, $_POST['threads_url']);
  $whatsapp_url = mysqli_real_escape_string($conn, $_POST['whatsapp_url']);

  $sql = "INSERT INTO contact (email, phone, location,instagram_url ,telegram_url ,facebook_url ,whatsapp_url ,threads_url ) 
  VALUES ('$email', '$phone', '$location' ,'$instagram_url','$telegram_url','$facebook_url' ,'$whatsapp_url','$threads_url')";
  if (mysqli_query($conn, $sql)) {
      header('Location: list_contact.php');

  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
