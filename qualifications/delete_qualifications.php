<?php
include '../public/db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM qualifications WHERE id=$id";
if (mysqli_query($conn, $sql)) {
  header('Location: list_qualification.php');
} else {
  echo "خطأ: " . mysqli_error($conn);
  echo "Done Delete";
}
