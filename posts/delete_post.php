<?php
session_start();
include '../public/db_connect.php';

// التحقق من وجود معرف البوست في الرابط
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    
    // جلب معلومات البوست للحصول على اسم الصورة
    $sql = "SELECT image FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    
    if ($post) {
        // حذف الصورة إذا كانت موجودة
        if ($post['image']) {
            $image_path = "../uploads/posts/" . $post['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        // حذف البوست من قاعدة البيانات
        $delete_sql = "DELETE FROM posts WHERE id = $post_id";
        if (mysqli_query($conn, $delete_sql)) {
            $_SESSION['success'] = "تم حذف البوست بنجاح!";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء حذف البوست: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "لم يتم العثور على البوست المطلوب.";
    }
} else {
    $_SESSION['error'] = "لم يتم تحديد البوست المراد حذفه.";
}

// إعادة التوجيه إلى صفحة إدارة البوستات
header("Location: posts.php");
exit;
?><?php
session_start();
include '../public/db_connect.php';

// التحقق من وجود معرف البوست في الرابط
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    
    // جلب معلومات البوست للحصول على اسم الصورة
    $sql = "SELECT image FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    
    if ($post) {
        // حذف الصورة إذا كانت موجودة
        if ($post['image']) {
            $image_path = "../uploads/posts/" . $post['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        // حذف البوست من قاعدة البيانات
        $delete_sql = "DELETE FROM posts WHERE id = $post_id";
        if (mysqli_query($conn, $delete_sql)) {
            $_SESSION['success'] = "تم حذف البوست بنجاح!";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء حذف البوست: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "لم يتم العثور على البوست المطلوب.";
    }
} else {
    $_SESSION['error'] = "لم يتم تحديد البوست المراد حذفه.";
}

// إعادة التوجيه إلى صفحة إدارة البوستات
header("Location: posts.php");
exit;
?>