<?php
include '../public/db_connect.php';
$result = mysqli_query($conn, "SELECT * FROM qualifications");
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>قائمة المؤهلات</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-bg: #0f172a;
      --card-bg: rgba(30, 41, 59, 0.92);
      --accent-color: #0ea5e9;
      --text-primary: #f1f5f9;
      --text-secondary: #cbd5e1;
      --border-color: rgba(255, 255, 255, 0.08);
      --success-color: #10b981;
      --danger-color: #ef4444;
      --qualification-color: #0ea5e9;
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #0c1a32 0%, #1a2b4d 100%);
      min-height: 100vh;
      padding: 20px;
      color: var(--text-primary);
      line-height: 1.6;
    }
    
    .qualifications-container {
      max-width: 1400px;
      margin: 40px auto;
      padding: 40px 30px;
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(10px);
      border: 1px solid var(--border-color);
    }
    
    .qualifications-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 35px;
      padding-bottom: 25px;
      border-bottom: 1px solid var(--border-color);
      position: relative;
    }
    
    .qualifications-header h2 {
      color: var(--accent-color);
      font-size: 2.2rem;
      font-weight: 600;
      letter-spacing: -0.5px;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .qualifications-header::after {
      content: '';
      position: absolute;
      bottom: -1px;
      right: 0;
      width: 200px;
      height: 3px;
      background: linear-gradient(90deg, var(--accent-color), transparent);
      border-radius: 3px;
    }
    
    .add-qualification-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 25px;
      background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
      color: white;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
      border: none;
      cursor: pointer;
      gap: 10px;
      font-size: 1.05rem;
    }
    
    .add-qualification-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .qualifications-controls {
      display: flex;
      justify-content: space-between;
      margin-bottom: 25px;
      gap: 15px;
      flex-wrap: wrap;
    }
    
    .search-box {
      display: flex;
      background: rgba(15, 23, 42, 0.7);
      border-radius: 50px;
      padding: 10px 20px;
      border: 1px solid var(--border-color);
      width: 300px;
    }
    
    .search-box input {
      background: transparent;
      border: none;
      color: var(--text-primary);
      padding: 8px 12px;
      width: 100%;
      font-size: 1rem;
    }
    
    .search-box input:focus {
      outline: none;
    }
    
    .search-box button {
      background: transparent;
      border: none;
      color: var(--accent-color);
      cursor: pointer;
      font-size: 1.2rem;
      padding: 0 5px;
    }
    
    .filter-buttons {
      display: flex;
      gap: 10px;
    }
    
    .filter-btn {
      padding: 10px 20px;
      background: rgba(15, 23, 42, 0.7);
      color: var(--text-secondary);
      border: 1px solid var(--border-color);
      border-radius: 50px;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
      background: var(--accent-color);
      color: white;
      border-color: var(--accent-color);
    }
    
    .qualifications-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 30px;
      margin-top: 20px;
    }
    
    .qualification-card {
      background: rgba(15, 23, 42, 0.7);
      border-radius: 15px;
      overflow: hidden;
      transition: var(--transition);
      border: 1px solid var(--border-color);
      position: relative;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .qualification-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      border-color: rgba(14, 165, 233, 0.3);
    }
    
    .qualification-image {
      width: 100%;
      height: 220px;
      overflow: hidden;
      position: relative;
    }
    
    .qualification-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: var(--transition);
    }
    
    .qualification-card:hover .qualification-image img {
      transform: scale(1.05);
    }
    
    .qualification-content {
      padding: 25px;
    }
    
    .qualification-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 15px;
      color: var(--accent-color);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .qualification-description {
      color: var(--text-secondary);
      margin-bottom: 20px;
      line-height: 1.7;
      min-height: 100px;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 4;
      -webkit-box-orient: vertical;
    }
    
    .qualification-id {
      position: absolute;
      top: 15px;
      left: 15px;
      background: var(--accent-color);
      color: white;
      font-size: 0.85rem;
      padding: 3px 12px;
      border-radius: 20px;
      font-weight: bold;
      z-index: 2;
    }
    
    .qualification-actions {
      display: flex;
      gap: 12px;
      padding-top: 15px;
      border-top: 1px solid var(--border-color);
    }
    
    .action-btn {
      flex: 1;
      padding: 12px;
      border-radius: 10px;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      border: none;
      font-size: 1rem;
    }
    
    .edit-btn {
      background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
      color: white;
    }
    
    .delete-btn {
      background: linear-gradient(135deg, var(--danger-color) 0%, #b91c1c 100%);
      color: white;
    }
    
    .action-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .back-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 14px 28px;
      background: linear-gradient(135deg, var(--accent-color) 0%, #0284c7 100%);
      color: white;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
      border: none;
      cursor: pointer;
      gap: 10px;
      margin: 40px auto 20px;
      font-size: 1.05rem;
    }
    
    .back-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
    }
    
    .btn-container {
      text-align: center;
      margin-top: 30px;
    }
    
    .empty-qualifications {
      text-align: center;
      padding: 50px 20px;
      color: #94a3b8;
      font-size: 1.1rem;
      border: 2px dashed rgba(148, 163, 184, 0.3);
      border-radius: 12px;
      background: rgba(15, 23, 42, 0.3);
      grid-column: 1 / -1;
    }
    
    .empty-qualifications i {
      font-size: 3.5rem;
      margin-bottom: 20px;
      opacity: 0.5;
    }
    
    @media (max-width: 768px) {
      .qualifications-container {
        margin: 20px auto;
        padding: 25px 20px;
      }
      
      .qualifications-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
      }
      
      .qualifications-header h2 {
        font-size: 1.8rem;
      }
      
      .qualifications-header::after {
        right: 50%;
        transform: translateX(50%);
        width: 150px;
      }
      
      .qualifications-controls {
        flex-direction: column;
        align-items: stretch;
      }
      
      .search-box {
        width: 100%;
      }
      
      .filter-buttons {
        justify-content: center;
        flex-wrap: wrap;
      }
      
      .qualifications-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<div class="qualifications-container">
  <div class="qualifications-header">
    <h2><i class="fas fa-graduation-cap"></i> قائمة المؤهلات</h2>
    <a href="../public/dashboard.php/#qualificationForm" class="add-qualification-btn">
      <i class="fas fa-plus-circle"></i> إضافة مؤهل
    </a>
  </div>
  
  <div class="qualifications-controls">
    <div class="search-box">
      <input type="text" placeholder="ابحث في المؤهلات...">
      <button><i class="fas fa-search"></i></button>
    </div>
    <div class="filter-buttons">
      <button class="filter-btn active"><i class="fas fa-layer-group"></i> الكل</button>
      <button class="filter-btn"><i class="fas fa-star"></i> مميز</button>
      <button class="filter-btn"><i class="fas fa-fire"></i> حديث</button>
    </div>
  </div>
  
  <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="qualifications-grid">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="qualification-card">
          <div class="qualification-image">
            <?php if (!empty($row['image'])): ?>
              <img src="../uploads/qualification/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['qualification_title']) ?>">
            <?php else: ?>
              <div style="background: #0c1a32; height: 100%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-graduation-cap" style="font-size: 3rem; color: #0ea5e9;"></i>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="qualification-content">
            <div class="qualification-id">ID: <?= $row['id'] ?></div>
            <h3 class="qualification-title">
              <i class="fas fa-certificate"></i> <?= htmlspecialchars($row['qualification_title']) ?>
            </h3>
            
            <p class="qualification-description">
              <?= htmlspecialchars($row['qualification_description']) ?>
            </p>
            
            <div class="qualification-actions">
              <a href="edit_qualifications.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                <i class="fas fa-edit"></i> تعديل
              </a>
              <a href="delete_qualifications.php?id=<?= $row['id'] ?>" class="action-btn delete-btn">
                <i class="fas fa-trash"></i> حذف
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="empty-qualifications">
      <i class="fas fa-graduation-cap"></i>
      <p>لا توجد مؤهلات مسجلة حالياً</p>
    </div>
  <?php endif; ?>
  
  <div class="btn-container">
    <a class="back-btn" href="../public/dashboard.php">
      <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
    </a>
  </div>
</div>

<script>
  // وظيفة البحث في المؤهلات
  const searchInput = document.querySelector('.search-box input');
  const qualificationCards = document.querySelectorAll('.qualification-card');
  
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    
    qualificationCards.forEach(card => {
      const content = card.textContent.toLowerCase();
      if (content.includes(searchTerm)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
  
  // فلترة المؤهلات
  const filterButtons = document.querySelectorAll('.filter-btn');
  
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      filterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      
      // هنا يمكن إضافة منطق الفلترة الحقيقي
      qualificationCards.forEach(card => {
        card.style.display = 'block';
      });
    });
  });
  
  // تأكيد الحذف
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
      if (!confirm('هل أنت متأكد أنك تريد حذف هذا المؤهل؟ سيتم فقدان جميع بياناته بشكل دائم.')) {
        e.preventDefault();
      }
    });
  });
</script>

</body>
</html>