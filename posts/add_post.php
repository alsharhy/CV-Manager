<?php
session_start();
include '../public/db_connect.php';

// التحقق من صلاحيات المستخدم
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
//   header("Location: login.php");
//   exit;
// }

// معالجة إضافة البوست
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $content = mysqli_real_escape_string($conn, $_POST['content']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  
  // معالجة رفع الصورة
  $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/posts/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // التحقق من أن الملف صورة
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
      // إنشاء اسم فريد للصورة
      $new_filename = uniqid() . '.' . $imageFileType;
      $target_path = $target_dir . $new_filename;
      
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
        $image = $new_filename;
      }
    }
  }
  
  // إضافة البوست إلى قاعدة البيانات
  $sql = "INSERT INTO posts (title, content, image, category) 
          VALUES ('$title', '$content', '$image', '$category')";
  
  if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "تم إضافة البوست بنجاح!";
    header("Location: posts.php");
    exit;
  } else {
    $_SESSION['error'] = "حدث خطأ أثناء إضافة البوست: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إضافة بوست جديد</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style-posts.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header">
      <h2><i class="fas fa-plus-circle"></i> إضافة بوست جديد</h2>
      <a href="posts.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> العودة للبوستات
      </a>
    </div>

    <div class="post-form">
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="title"><i class="fas fa-heading"></i> عنوان البوست</label>
          <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
          <label for="category"><i class="fas fa-tag"></i> التصنيف</label>
          <select id="category" name="category" required>
            <option value="">اختر التصنيف</option>
            <option value="تكنولوجيا">تكنولوجيا</option>
            <option value="أمن سبراني">أمن سيبراني</option>
            <option value="ذكاء اصطناعي">ذكاء اصطناعي</option>
            <option value="رياضة">رياضة</option>
            <option value="لغات برمجية">لغات برمجية</option>
            <option value="حيل برمجية">حيل برمجية </option>
          </select>
        </div>

        <div class="form-group">
          <label for="image"><i class="fas fa-image"></i> صورة البوست (اختياري)</label>
          <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="form-group">
          <label for="content"><i class="fas fa-align-left"></i> محتوى البوست</label>
          <textarea id="content" name="content" rows="10" required></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="submit-btn">
            <i class="fas fa-save"></i> حفظ البوست
          </button>
          <button type="reset" class="reset-btn">
            <i class="fas fa-redo"></i> إعادة تعيين
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>