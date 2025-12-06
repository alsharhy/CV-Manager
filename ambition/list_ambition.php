<?php
include '../public/db_connect.php';
$result = mysqli_query($conn, "SELECT * FROM ambitions");


$result_count = mysqli_query($conn, "SELECT COUNT(*) FROM ambitions");
$res=mysqli_num_rows($result);
?>
<div class="ambitions-container"> <?php echo "$res"?><div>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>قائمة الطموحات</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style-list_ambition.css">
</head>
<body>

<div class="ambitions-container">
  <div class="ambitions-header">
    <h2><i class="fas fa-bullseye"></i> قائمة الطموحات</h2>
    <a href="add_ambition.php" class="add-ambition-btn">
      <i class="fas fa-plus-circle"></i> إضافة طموح
    </a>
  </div>
  
  <div class="ambitions-controls">
    <div class="search-box">
      <input type="text" placeholder="ابحث في الطموحات...">
      <button><i class="fas fa-search"></i></button>
    </div>
    <div class="filter-buttons">
      <button class="filter-btn active"><i class="fas fa-layer-group"></i> الكل</button>
      <button class="filter-btn"><i class="fas fa-star"></i> مميز</button>
      <button class="filter-btn"><i class="fas fa-fire"></i> حديث</button>
    </div>
  </div>
  
  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="ambitions-grid">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="ambition-card">
          <div class="ambition-icon-container">
            <div class="ambition-id">ID: <?= $row['id'] ?></div>
            <div class="ambition-icon">
              <img src="<?= htmlspecialchars($row['icon_url']) ?>" alt="أيقونة الطموح" style="width: 60px; height: 60px; object-fit: contain;">
            </div>
          </div>
          
          <div class="ambition-content">
            <h3 class="ambition-title">
              <i class="fas fa-flag"></i> <?= htmlspecialchars($row['ambitions_title']) ?>
            </h3>
            
            <p class="ambition-description">
              <?= htmlspecialchars($row['ambitions_description']) ?>
            </p>
            
            <div class="ambition-actions">
              <a href="edit_ambition.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                <i class="fas fa-edit"></i> تعديل
              </a>
              <a href="delete_ambition.php?id=<?= $row['id'] ?>" class="action-btn delete-btn">
                <i class="fas fa-trash"></i> حذف
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="empty-ambitions">
      <i class="fas fa-bullseye"></i>
      <p>لا توجد طموحات مسجلة حالياً</p>
    </div>
  <?php endif; ?>
  
  <div class="btn-container">
    <a class="back-btn" href="../public/dashboard.php">
      <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
    </a>
  </div>
</div>


<script>
  // وظيفة البحث في الطموحات
  const searchInput = document.querySelector('.search-box input');
  const ambitionCards = document.querySelectorAll('.ambition-card');
  
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    
    ambitionCards.forEach(card => {
      const content = card.textContent.toLowerCase();
      if (content.includes(searchTerm)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
  
  // فلترة الطموحات
  const filterButtons = document.querySelectorAll('.filter-btn');
  
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      filterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      
      // هنا يمكن إضافة منطق الفلترة الحقيقي
      // هذا مثال بسيط للتوضيح فقط
      ambitionCards.forEach(card => {
        card.style.display = 'block';
      });
    });
  });
  
  // تأكيد الحذف
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
      if (!confirm('هل أنت متأكد أنك تريد حذف هذا الطموح؟ سيتم فقدان جميع بياناته بشكل دائم.')) {
        e.preventDefault();
      }
    });
  });
</script>

</body>
</html>