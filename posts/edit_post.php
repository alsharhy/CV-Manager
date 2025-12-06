<?php
session_start();
include '../public/db_connect.php';

// التحقق من وجود معرف البوست في الرابط
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "لم يتم تحديد البوست.";
    header("Location: posts.php");
    exit;
}

$post_id = $_GET['id'];
$post = null;

// جلب بيانات البوست الحالية
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $post = mysqli_fetch_assoc($result);
} else {
    $_SESSION['error'] = "لم يتم العثور على البوست المطلوب.";
    header("Location: posts.php");
    exit;
}

// معالجة تحديث البوست
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $current_image = $post['image']; // الصورة الحالية
    
    // معالجة رفع الصورة الجديدة إذا تم اختيارها
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
                // حذف الصورة القديمة إذا كانت موجودة
                if ($current_image) {
                    $old_image_path = $target_dir . $current_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                $current_image = $new_filename;
            }
        }
    }
    
    // تحديث البوست في قاعدة البيانات
    $update_sql = "UPDATE posts SET 
                  title = '$title',
                  content = '$content',
                  category = '$category',
                  image = '$current_image'
                  WHERE id = $post_id";
    
    if (mysqli_query($conn, $update_sql)) {
      header("Location: posts.php");
      $_SESSION['success'] = "تم تحديث البوست بنجاح!";
        // تحديث بيانات البوست بعد التحديث
        $result = mysqli_query($conn, "SELECT * FROM posts WHERE id = $post_id");
        $post = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "حدث خطأ أثناء تحديث البوست: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تعديل البوست</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style-edit_post.css">

</head>
<body>
  <div class="admin-container">
    <div class="admin-header">
      <h2><i class="fas fa-edit"></i> تعديل البوست</h2>
      <a href="posts.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> العودة للبوستات
      </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i> 
        <?php 
          echo $_SESSION['error']; 
          unset($_SESSION['error']);
        ?>
      </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> 
        <?php 
          echo $_SESSION['success']; 
          unset($_SESSION['success']);
        ?>
      </div>
    <?php endif; ?>

    <div class="post-form">
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="title"><i class="fas fa-heading"></i> عنوان البوست</label>
          <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($post['title']); ?>">
        </div>

        <div class="form-group">
          <label for="category"><i class="fas fa-tag"></i> التصنيف</label>
          <select id="category" name="category" required>
            <option value="">اختر التصنيف</option>
            <option value="تكنولوجيا" <?php if ($post['category'] == 'تكنولوجيا') echo 'selected'; ?>>تكنولوجيا</option>
            <option value="تعليم" <?php if ($post['category'] == 'تعليم') echo 'selected'; ?>>تعليم</option>
            <option value="صحة" <?php if ($post['category'] == 'صحة') echo 'selected'; ?>>صحة</option>
            <option value="رياضة" <?php if ($post['category'] == 'رياضة') echo 'selected'; ?>>رياضة</option>
            <option value="فنون" <?php if ($post['category'] == 'فنون') echo 'selected'; ?>>فنون</option>
          </select>
        </div>

        <div class="form-group">
          <label for="image"><i class="fas fa-image"></i> صورة البوست (اختياري)</label>
          <input type="file" id="image" name="image" accept="image/*">
          <?php if ($post['image']): ?>
            <div class="current-image">
              <p>الصورة الحالية:</p>
              <img src="../uploads/posts/<?php echo $post['image']; ?>" alt="صورة البوست">
            </div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label for="content"><i class="fas fa-align-left"></i> محتوى البوست</label>
          <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="submit-btn">
            <i class="fas fa-save"></i> حفظ التعديلات
          </button>
          <a href="posts.php" class="reset-btn">
            <i class="fas fa-times"></i> إلغاء
          </a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>