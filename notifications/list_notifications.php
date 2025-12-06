<?php
include '../public/db_connect.php';
$result = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>قائمة الإشعارات</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style-list_notifications.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

  <div class="notifications-container">
    <div class="notifications-header">
      <h2><i class="fas fa-bell"></i> قائمة الإشعارات</h2>
    </div>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="notification <?= $row['is_read'] ? '' : 'unread' ?>">
          <h3><i class="fas fa-<?= $row['is_read'] ? 'envelope-open' : 'envelope' ?>"></i> <?= htmlspecialchars($row['title']) ?></h3>
          <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
          <div class="time"><i class="far fa-clock"></i> <?= $row['created_at'] ?></div>


          <div class="btn-delete">
            <button class="action-btn delete-btn">
              <a class="btn delete" href="delete_notification.php?id=<?= $row['id'] ?>">
                <i class="fas fa-trash"></i> حذف
              </a>
            </button>
          </div>
        </div>

      <?php endwhile; ?>
    <?php else: ?>
      <div class="empty-notifications">
        <i class="far fa-bell-slash"></i>
        <p>لا توجد إشعارات حالياً</p>
      </div>
    <?php endif; ?>

    <div class="btn-container">
      <a class="back-btn" href="../public/dashboard.php">
        <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
      </a>
    </div>
  </div>

</body>

</html>