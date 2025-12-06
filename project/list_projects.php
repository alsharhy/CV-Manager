<?php
include '../public/db_connect.php';
$result = mysqli_query($conn, "SELECT * FROM projects");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>قائمة المشاريع</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style-list_project.css">
</head>
<body>

<div class="projects-container">
  <div class="projects-header">
    <h2><i class="fas fa-project-diagram"></i> قائمة المشاريع</h2>
    <a href="add_project.php" class="add-project-btn">
      <i class="fas fa-plus-circle"></i> إضافة مشروع
    </a>
  </div>
  
  <div class="projects-controls">
    <div class="search-box">
      <input type="text" placeholder="ابحث في المشاريع...">
      <button><i class="fas fa-search"></i></button>
    </div>
    <div class="filter-buttons">
      <button class="filter-btn active"><i class="fas fa-layer-group"></i> الكل</button>
      <button class="filter-btn"><i class="fas fa-star"></i> مميز</button>
      <button class="filter-btn"><i class="fas fa-fire"></i> حديث</button>
    </div>
  </div>
  
  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="projects-grid">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="project-card">
          <div class="project-image">
            <div class="project-id">ID: <?= $row['id'] ?></div>
            <img src="../uploads/project/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['project_title']) ?>">
          </div>
          
          <div class="project-content">
            <h3 class="project-title">
              <i class="fas fa-cube"></i> <?= htmlspecialchars($row['project_title']) ?>
            </h3>
            
            <p class="project-description">
              <?= htmlspecialchars($row['project_description']) ?>
            </p>
            
            <div class="project-tags">
              <?php 
                $tags = explode(',', $row['project_tags']);
                foreach ($tags as $tag):
                  $trimmed_tag = trim($tag);
                  if (!empty($trimmed_tag)):
              ?>
                <span class="project-tag"><?= htmlspecialchars($trimmed_tag) ?></span>
              <?php endif; endforeach; ?>
            </div>
            
            <div class="project-actions">
              <a href="edit_project.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                <i class="fas fa-edit"></i> تعديل
              </a>
              <a href="delete_project.php?id=<?= $row['id'] ?>" class="action-btn delete-btn">
                <i class="fas fa-trash"></i> حذف
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="empty-projects">
      <i class="fas fa-project-diagram"></i>
      <p>لا توجد مشاريع مسجلة حالياً</p>
    </div>
  <?php endif; ?>
  
  <div class="btn-container">
    <a class="back-btn" href="../public/dashboard.php">
      <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
    </a>
  </div>
</div>

<script>
  // وظيفة البحث في المشاريع
  const searchInput = document.querySelector('.search-box input');
  const projectCards = document.querySelectorAll('.project-card');
  
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    
    projectCards.forEach(card => {
      const content = card.textContent.toLowerCase();
      if (content.includes(searchTerm)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
  
  // فلترة المشاريع
  const filterButtons = document.querySelectorAll('.filter-btn');
  
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      filterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      
      // هنا يمكن إضافة منطق الفلترة الحقيقي
      // هذا مثال بسيط للتوضيح فقط
      projectCards.forEach(card => {
        card.style.display = 'block';
      });
    });
  });
  
  // تأكيد الحذف
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
      if (!confirm('هل أنت متأكد أنك تريد حذف هذا المشروع؟ سيتم فقدان جميع بياناته بشكل دائم.')) {
        e.preventDefault();
      }
    });
  });
</script>

</body>
</html>