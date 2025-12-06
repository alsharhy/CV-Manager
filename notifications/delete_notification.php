<?php
include '../public/db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM notifications WHERE id=$id";
if (mysqli_query($conn, $sql)) {
  header('Location: list_notifications.php');
} else {
  echo "خطأ: " . mysqli_error($conn);
  echo "Done Delete";
}
