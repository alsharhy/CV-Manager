<?php 
include("../public/db_connect.php");

$id =$_GET['id'];
$sql = "DELETE FROM messages WHERE id=$id";

if(mysqli_query($conn, $sql)){
  header('Location: list_messages.php');
}else{
  echo "Delete Filed";
}
?><?php 
include("../public/db_connect.php");

$id =$_GET['id'];
$sql = "DELETE FROM messages WHERE id=$id";

if(mysqli_query($conn, $sql)){
  header('Location: list_messages.php');
}else{
  echo "Delete Filed";
}
?>