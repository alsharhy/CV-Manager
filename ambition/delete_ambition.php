<?php
include '../public/db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM ambitions WHERE id=$id";
if (mysqli_query($conn, $sql)) {
  header('Location: list_ambition.php');
} else {
  echo "خطأ: " . mysqli_error($conn);
}
<?php
include '../public/db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM ambitions WHERE id=$id";
if (mysqli_query($conn, $sql)) {
  header('Location: list_ambition.php');
} else {
  echo "خطأ: " . mysqli_error($conn);
}
