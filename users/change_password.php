
<?php
// الاتصال بقاعدة البيانات
include '../public/db_connect.php';

if (isset($_POST['change'])) {
    $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // التحقق من أن كلمة المرور الجديدة وتأكيدها متطابقتين
    if ($new_password !== $confirm_password) {
        echo "كلمة المرور الجديدة وتأكيدها غير متطابقتين.";
        exit;
    }

    // التحقق من وجود المستخدم وكلمة المرور القديمة
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$old_password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // تحديث كلمة المرور
        $update_sql = "UPDATE users SET password='$new_password' WHERE username='$username'";
        if (mysqli_query($conn, $update_sql)) {
            header('Location: list_users.php');
        } else {
            echo "حدث خطأ أثناء تحديث كلمة المرور.";
        }
    } else {
        echo "اسم المستخدم أو كلمة المرور القديمة غير صحيحة.";
    }
}
?>


