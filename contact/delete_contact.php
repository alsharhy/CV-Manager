<?php
include '../public/db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM contact WHERE id=$id";
if (mysqli_query($conn, $sql)) {
  header('Location: list_contact.php');
} else {
  echo "خطأ: " . mysqli_error($conn);
  echo "Done Delete";
}
