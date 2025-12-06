<?php
include '../public/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "UPDATE users SET username='$username', password='$password' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header('Location: list_users.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>