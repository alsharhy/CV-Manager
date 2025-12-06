<?php
include '../public/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $ambitions_title = mysqli_real_escape_string($conn, $_POST['ambitions_title']);
  $ambitions_description = mysqli_real_escape_string($conn, $_POST['ambitions_description']);
  $icon_url = mysqli_real_escape_string($conn, $_POST['icon_url']);
  $sql = "INSERT INTO ambitions (ambitions_title,ambitions_description ,icon_url) VALUES ('$ambitions_title','$ambitions_description' ,'$icon_url')";
  if (mysqli_query($conn, $sql)) {
    header('Location: list_ambition.php');
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
