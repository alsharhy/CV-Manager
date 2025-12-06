<?php
include "../db_connect.php";


session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// تحقق من وجود المستخدم
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    // $_SESSION['username'] = $username;
    header("Location: ../public/dashboard.php");
    exit();
} else {
   // ✨ إشعار بمحاولة دخول من غير أدمن
        $ip = $_SERVER['REMOTE_ADDR'];
        $title = " محاولة دخول إلى لوحة التحكم";
        $message = "الاسم: $username من IP: $ip";
        $conn->query("INSERT INTO notifications (title, message) VALUES ('$title', '$message')");
    // إذا لم يوجد، أعد المستخدم إلى login.html مع رسالة خطأ
    header("Location: login.html?error=اسم المستخدم أو كلمة المرور غير صحيحة");
    exit();
}
?>