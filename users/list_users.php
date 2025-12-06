<?php
include '../public/db_connect.php';
$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>قائمة المستخدمين</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style-list_users.css">
</head>
<body>

<div class="users-container">
  <div class="users-header">
    <h2><i class="fas fa-users-cog"></i> قائمة المستخدمين</h2>
    <a href="add_user.php" class="add-user-btn">
      <i class="fas fa-plus-circle"></i> إضافة مستخدم
    </a>
  </div>
  
  <div class="search-box">
    <input type="text" placeholder="ابحث في المستخدمين...">
    <button><i class="fas fa-search"></i></button>
  </div>
  
  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="users-grid">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="user-card">
          <div class="user-header">
            <div class="user-avatar">
              <?= strtoupper(substr($row['username'], 0, 1)) ?>
            </div>
            <div class="user-info">
              <div class="user-name"><?= htmlspecialchars($row['username']) ?></div>
              <div class="user-id">ID: <?= $row['id'] ?></div>
            </div>
          </div>
          
          <div class="user-details">
            <div class="detail-row">
              <div class="detail-label">
                <i class="fas fa-user"></i>
                اسم المستخدم:
              </div>
              <div class="detail-value">
                <?= htmlspecialchars($row['username']) ?>
              </div>
            </div>
            
            <div class="detail-row">
              <div class="detail-label">
                <i class="fas fa-lock"></i>
                كلمة المرور:
              </div>
              <div class="detail-value">
                <span class="password-display" data-password="<?= htmlspecialchars($row['password']) ?>">••••••••</span>
                <button class="password-toggle">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
          
          <div class="user-actions">
            <a href="edit_user.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
              <i class="fas fa-edit"></i> Edit
            </a>
            <a href="delete_user.php?id=<?= $row['id'] ?>" class="action-btn delete-btn">
              <i class="fas fa-trash"></i> Delete
            </a>
            </a>

            <a href="block_user.php?id=4&action=block" class="action-btn edit-btn">
              <i class="fas fa-trash"></i> block
            </a>

          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="empty-users">
      <i class="fas fa-user-slash"></i>
      <p>لا يوجد مستخدمين مسجلين حالياً</p>
    </div>
  <?php endif; ?>
  
  <div class="btn-container">
    <a class="back-btn" href="../public/dashboard.php">
      <i class="fas fa-arrow-right"></i> Back To  Control  
    </a>
  </div>
</div>

<script>
  // وظيفة إظهار/إخفاء كلمة المرور
  document.querySelectorAll('.password-toggle').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const displayElement = this.previousElementSibling;
      const password = displayElement.dataset.password;
      
      if (displayElement.textContent === '••••••••') {
        displayElement.textContent = password;
        this.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        displayElement.textContent = '••••••••';
        this.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });
  });
  
  // وظيفة البحث في المستخدمين
  const searchInput = document.querySelector('.search-box input');
  const userCards = document.querySelectorAll('.user-card');
  
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    
    userCards.forEach(card => {
      const content = card.textContent.toLowerCase();
      if (content.includes(searchTerm)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
  
  // تأكيد الحذف
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
      if (!confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم؟')) {
        e.preventDefault();
      }
    });
  });
</script>

</body>
</html>