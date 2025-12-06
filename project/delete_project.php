<?php
include '../public/db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM projects WHERE id=$id";
if (mysqli_query($conn, $sql)) {
  header('Location: list_projects.php');
} else {
  echo "خطأ: " . mysqli_error($conn);
  echo "Done Delete";
}
<?php
include '../public/db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM projects WHERE id=$id";
if (mysqli_query($conn, $sql)) {
  header('Location: list_projects.php');
} else {
  echo "خطأ: " . mysqli_error($conn);
  echo "Done Delete";
}
