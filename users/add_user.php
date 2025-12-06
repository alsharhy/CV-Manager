<?php
include '../public/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $newUsername = mysqli_real_escape_string($conn, $_POST['newUsername']);
  $newUserPassword = mysqli_real_escape_string($conn, $_POST['newUserPassword']);


  // $sql = "INSERT INTO project (project_title, image_url, project_description,project_tags ) VALUES ('$project_title', '$image_url', '$project_description' ,'$project_tags')";
  // tast
  $sql = "INSERT INTO users (username, password ) VALUES ('$newUsername', '$newUserPassword')";
  if (mysqli_query($conn, $sql)) {
    header('Location: list_users.php');
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}

