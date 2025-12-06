<?php
include("../public/db_connect.php");
$result = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at DESC");


// تحديث كل الرسائل إلى مقروءة
$update = "UPDATE messages SET is_read = 1 WHERE is_read = 0";
mysqli_query($conn, $update);

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>الرسائل الواردة</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style_messages.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

  <div class="messages-container">
    <div class="messages-header">
      <h2><i class="fas fa-envelope"></i> الرسائل الواردة</h2>
    </div>

    <div class="messages-controls">
      <div class="search-box">
        <input type="text" placeholder="ابحث في الرسائل...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="filter-buttons">
        <button class="filter-btn active"><i class="fas fa-inbox"></i> الكل</button>
        <button class="filter-btn"><i class="fas fa-envelope"></i> غير المقروءة</button>
        <button class="filter-btn"><i class="fas fa-star"></i> المهمة</button>
      </div>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="message">
          <div class="message-header">
            <div class="sender-info">
              <div class="sender-name">
                <i class="fas fa-user"></i>
                <?= htmlspecialchars($row['name']) ?>
              </div>
              <div class="sender-email">
                <i class="fas fa-envelope"></i>
                <?= htmlspecialchars($row['email']) ?>
              </div>
            </div>
            <div class="message-time">
              <i class="far fa-clock"></i>
              <?= $row['created_at'] ?>
            </div>
          </div>

          <div class="message-subject">
            <i class="fas fa-tag"></i>
            <?= htmlspecialchars($row['subject']) ?>
          </div>

          <div class="message-content">
            <?= nl2br(htmlspecialchars($row['message'])) ?>
          </div>

          <?php if ($row['is_read'] == 0): ?>
            <span class="badge bg-danger">جديدة</span>
          <?php else: ?>
            <span class="badge bg-success">مقروءة</span>
          <?php endif; ?>

          <div class="message-actions">
            <button class="action-btn reply-btn">
              <a class="btn reply" href="#?id=<?= $row['id'] ?>">
                <i class="fas fa-reply"></i> رد
              </a>
            </button>

            <button class="action-btn delete-btn">
              <a class="btn delete" href="delete_message.php?id=<?= $row['id'] ?>">
                <i class="fas fa-trash"></i> حذف
              </a>
            </button>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="empty-messages">
        <i class="fas fa-inbox"></i>
        <p>لا توجد رسائل واردة حالياً</p>
      </div>
    <?php endif; ?>

    <div class="btn-container">
      <a class="back-btn" href="../public/dashboard.php">
        <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
      </a>
    </div>
  </div>

  <script>
    // البحث في الرسائل
    const searchInput = document.querySelector('.search-box input');
    const messages = document.querySelectorAll('.message');

    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();

      messages.forEach(message => {
        const content = message.textContent.toLowerCase();
        if (content.includes(searchTerm)) {
          message.style.display = 'block';
        } else {
          message.style.display = 'none';
        }
      });
    });

    // فلترة الرسائل
    const filterButtons = document.querySelectorAll('.filter-btn');

    filterButtons.forEach(button => {
      button.addEventListener('click', function() {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        // هنا يمكن إضافة منطق الفلترة الحقيقي
        // هذا مثال بسيط للتوضيح فقط
        messages.forEach(message => {
          message.style.display = 'block';
        });
      });
    });

    // تفاعل أزرار الحذف والرد
    // const deleteButtons = document.querySelectorAll('.delete-btn');
    // const replyButtons = document.querySelectorAll('.reply-btn');

    // deleteButtons.forEach(button => {
    //   button.addEventListener('click', function() {
    //     const message = this.closest('.message');
    //     if (confirm('هل أنت متأكد من حذف هذه الرسالة؟')) {
    //       message.style.opacity = '0';
    //       setTimeout(() => {
    //         message.style.display = 'none';
    //       }, 300);
    //     }
    //   });
    // });

    replyButtons.forEach(button => {
      button.addEventListener('click', function() {
        const email = this.closest('.message').querySelector('.sender-email').textContent.trim();
        alert(`سيتم فتح نافذة للرد على: ${email}`);
        // في التطبيق الحقيقي سيتم فتح نافذة الرد
      });
    });
  </script>

</body>

</html>