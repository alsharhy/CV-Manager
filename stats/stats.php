<?php
include '../public/db_connect.php';

// جلب جميع الإحصائيات باستخدام استعلام واحد فقط لتحسين الأداء
$sql = "SELECT 
    (SELECT COUNT(*) FROM site_visits) AS total_visits,
    (SELECT COUNT(DISTINCT ip_address) FROM site_visits) AS unique_visitors,
    (SELECT COUNT(*) FROM site_visits WHERE DATE(visit_time) = CURDATE()) AS today_visits,
    (SELECT COUNT(*) FROM users) AS users_count,
    (SELECT COUNT(*) FROM notifications) AS notificatins_count,
    (SELECT COUNT(*) FROM messages) AS message_count,
        (SELECT COUNT(*) FROM posts) AS posts_count";

$result = mysqli_query($conn, $sql);
$stats = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>إحصائيات الموقع</title>
  <link rel="stylesheet" href="style-stats.css">

</head>

<body>
  <div class="stats-container">
    <h3>📊 إحصائيات الموقع</h3>
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">👁️</div>
        <div class="stat-title">الزيارات الكلية</div>
        <div class="stat-value"><?= $stats['total_visits'] ?></div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-title">الزوار الفريدون</div>
        <div class="stat-value"><?= $stats['unique_visitors'] ?></div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-title">زيارات اليوم</div>
        <div class="stat-value"><?= $stats['today_visits'] ?></div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">👑</div>
        <div class="stat-title">عدد الأدمن</div>
        <div class="stat-value"><?= $stats['users_count'] ?></div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">✉️</div>
        <div class="stat-title">رسائل الاشعارات</div>
        <div class="stat-value"><?= $stats['notificatins_count'] ?></div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">💬</div>
        <div class="stat-title"> رسائل التواصل</div>
        <div class="stat-value"><?= $stats['message_count'] ?></div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">💬</div>
        <div class="stat-title"> عدد البوستات </div>
        <div class="stat-value"><?= $stats['posts_count'] ?></div>
      </div>
    </div>



  </div>

  <div class="btn-container">
    <a class="back-btn" href="../public/dashboard.php">
      <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
    </a>
  </div>
</body>

</html>