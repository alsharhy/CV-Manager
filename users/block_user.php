<?php
include '../public/db_connect.php';

$id = intval($_GET['id']);
$action = $_GET['action'];

if ($action == 'block') {
    mysqli_query($conn, "UPDATE users SET is_blocked = 1 WHERE id = $id");
} elseif ($action == 'unblock') {
    mysqli_query($conn, "UPDATE users SET is_blocked = 0 WHERE id = $id");
}

header("Location: users.php");
exit;
?>