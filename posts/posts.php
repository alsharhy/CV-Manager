<?php
include '../public/db_connect.php';

// استرجاع البوستات من قاعدة البيانات
$result = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إدارة البوستات</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style-posts.css">
</head>

<body>
  <div class="admin-container">
    <div class="admin-header">
      <h2><i class="fas fa-newspaper"></i> إدارة البوستات</h2>
      <a href="add_post.php" class="add-btn">
        <i class="fas fa-plus-circle"></i> إضافة بوست جديد
      </a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="posts-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="post-card">
            <?php if ($row['image']): ?>
              <div class="post-image" style="background-image: url('../uploads/posts/<?= $row['image'] ?>')"></div>
            <?php else: ?>
              <div class="post-image default-image">
                <i class="fas fa-image"></i>
              </div>
            <?php endif; ?>

            <div class="post-content">
              <span class="post-category"><?= $row['category'] ?></span>
              <h3 class="post-title"><?= htmlspecialchars($row['title']) ?></h3>
              <p class="post-excerpt"><?= mb_substr(strip_tags($row['content']), 0, 150) ?>...</p>

              <div class="post-meta">
                <span><i class="far fa-calendar"></i> <?= date('Y-m-d', strtotime($row['created_at'])) ?></span>
              </div>
            </div>

            <div class="post-actions">
              <a href="edit_post.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                <i class="fas fa-edit"></i> تعديل
              </a>
              <a href="delete_post.php?id=<?= $row['id'] ?>" class="action-btn delete-btn" onclick="return confirm('هل أنت متأكد من حذف هذا البوست؟');">
                <i class="fas fa-trash"></i> حذف
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="empty-posts">
        <i class="fas fa-newspaper"></i>
        <p>لا يوجد بوستات لعرضها حالياً</p>
        <a href="add_post.php" class="add-btn">
          <i class="fas fa-plus-circle"></i> أضف أول بوست
        </a>
      </div>
    <?php endif; ?>
  </div>

  <div class="btn-container">
    <a class="back-btn" href="../public/dashboard.php">
      <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
    </a>
  </div>
  
</body>

</html>