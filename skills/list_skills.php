<?php
include '../public/db_connect.php';

// حذف المهارة إذا تم الضغط على زر الحذف
if (isset($_GET['delete_skill'])) {
    $skill_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->bind_param("i", $skill_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $delete_message = "تم حذف المهارة بنجاح";
    }
}

// حذف الفئة بالكامل مع مهاراتها الفرعية
if (isset($_GET['delete_category'])) {
    $category_id = $_GET['id'];
    
    // حذف جميع المهارات المرتبطة بهذه الفئة أولاً
    $stmt = $conn->prepare("DELETE FROM skills WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    
    // ثم حذف الفئة نفسها
    $stmt = $conn->prepare("DELETE FROM skill_categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $delete_message = "تم حذف الفئة وجميع مهاراتها بنجاح";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>عرض المهارات | لوحة التحكم</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #2563eb;
      --secondary-color: #1e40af;
      --accent-color: #f59e0b;
      --light-color: #f8fafc;
      --dark-color: #0f172a;
      --gray-color: #64748b;
      --card-bg: rgba(30, 41, 59, 0.92);
      --transition: all 0.3s ease;
      --border-color: rgba(255, 255, 255, 0.1);
      --danger-color: #dc2626;
      --success-color: #10b981;
      --warning-color: #f59e0b;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Tajawal', sans-serif;
      background: linear-gradient(135deg, #0c1a32 0%, #1a2b4d 100%);
      color: var(--light-color);
      line-height: 1.6;
      overflow-x: hidden;
      min-height: 100vh;
      padding: 20px;
    }
    
    .dashboard-container {
      position: relative;
      max-width: 1400px;
      margin: 40px auto;
      padding: 40px 30px;
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      border: 1px solid var(--border-color);
    }
    
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 35px;
      padding-bottom: 25px;
      border-bottom: 1px solid var(--border-color);
      position: relative;
    }
    
    .dashboard-header::after {
      content: '';
      position: absolute;
      bottom: -1px;
      right: 0;
      width: 200px;
      height: 3px;
      background: linear-gradient(90deg, var(--accent-color), transparent);
      border-radius: 3px;
    }
    
    .dashboard-title {
      color: var(--accent-color);
      font-size: 2.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .btn {
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 30px;
      padding: 12px 25px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin: 5px;
      font-family: 'Tajawal', sans-serif;
      gap: 8px;
      text-decoration: none;
    }
    
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(37, 99, 235, 0.4);
    }
    
    .btn-primary {
      background: var(--primary-color);
    }
    
    .btn-primary:hover {
      background: var(--secondary-color);
    }
    
    .btn-danger {
      background: var(--danger-color);
    }
    
    .btn-danger:hover {
      background: #b91c1c;
      box-shadow: 0 10px 20px rgba(220, 38, 38, 0.4);
    }
    
    .btn-success {
      background: var(--success-color);
    }
    
    .btn-success:hover {
      background: #059669;
      box-shadow: 0 10px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-back {
      background: var(--gray-color);
    }
    
    .btn-back:hover {
      background: #475569;
      box-shadow: 0 10px 20px rgba(100, 116, 139, 0.4);
    }
    
    .btn-warning {
      background: var(--warning-color);
    }
    
    .btn-warning:hover {
      background: #d97706;
      box-shadow: 0 10px 20px rgba(245, 158, 11, 0.4);
    }
    
    .btn i {
      font-size: 14px;
    }
    
    .skills-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }
    
    .skill-category {
      background: rgba(15, 23, 42, 0.7);
      padding: 25px;
      border-radius: 15px;
      border: 1px solid var(--border-color);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .skill-category:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }
    
    .category-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid var(--border-color);
    }
    
    .category-title {
      color: var(--accent-color);
      font-size: 1.6rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .category-actions {
      display: flex;
      gap: 10px;
    }
    
    .skill-item {
      background: rgba(30, 41, 59, 0.5);
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 15px;
      border: 1px solid rgba(100, 116, 139, 0.3);
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: var(--transition);
    }
    
    .skill-item:hover {
      background: rgba(37, 99, 235, 0.15);
      border-color: var(--primary-color);
    }
    
    .skill-name {
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .skill-percent {
      font-weight: 700;
      color: var(--accent-color);
      font-size: 1.1rem;
    }
    
    .skill-actions {
      display: flex;
      gap: 10px;
    }
    
    .skill-btn {
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .progress-container {
      height: 8px;
      background: rgba(100, 116, 139, 0.2);
      border-radius: 4px;
      overflow: hidden;
      margin-top: 10px;
    }
    
    .progress-bar {
      height: 100%;
      background: linear-gradient(90deg, var(--accent-color), #fbbf24);
      border-radius: 4px;
      transition: width 1s ease-in-out;
    }
    
    .no-skills {
      text-align: center;
      padding: 50px 20px;
      grid-column: 1 / -1;
    }
    
    .no-skills i {
      font-size: 4rem;
      color: var(--gray-color);
      margin-bottom: 20px;
    }
    
    .no-skills h3 {
      color: var(--accent-color);
      font-size: 1.8rem;
      margin-bottom: 15px;
    }
    
    .alert-message {
      padding: 15px;
      background: var(--success-color);
      color: white;
      border-radius: 8px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: fadeIn 0.5s ease;
    }
    
    .alert-danger {
      background: var(--danger-color);
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .header-actions {
      display: flex;
      gap: 15px;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
      .skills-container {
        grid-template-columns: 1fr;
      }
      
      .dashboard-container {
        padding: 25px 20px;
      }
      
      .dashboard-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
      }
      
      .dashboard-title {
        font-size: 1.8rem;
      }
      
      .header-actions {
        flex-direction: column;
        align-items: center;
        width: 100%;
      }
      
      .btn {
        width: 100%;
      }
      
      .category-actions {
        flex-direction: column;
        width: 100%;
        margin-top: 10px;
      }
      
      .category-header {
        flex-direction: column;
        align-items: flex-start;
      }
    }
    
    @media (max-width: 480px) {
      .skill-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      
      .skill-actions {
        width: 100%;
        justify-content: space-between;
      }
      
      .skill-btn {
        flex: 1;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
  <div class="dashboard-container" id="dashboardContainer">
    <div class="dashboard-content">
      <div class="dashboard-header">
        <h2 class="dashboard-title"><i class="fas fa-star"></i> إدارة المهارات</h2>
        <div class="header-actions">
          <a href="../public/dashboard.php" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> العودة للوحة التحكم
          </a>
          <a href="add_skill.php" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة مهارة جديدة
          </a>
        </div>
      </div>

      <?php if (isset($delete_message)): ?>
        <div class="alert-message">
          <i class="fas fa-check-circle"></i> <?php echo $delete_message; ?>
        </div>
      <?php endif; ?>

      <div class="skills-container">
        <?php
        // استعلام لجلب جميع الفئات والمهارات
        $categories = $conn->query("SELECT * FROM skill_categories");
        
        if ($categories->num_rows > 0) {
          while ($category = $categories->fetch_assoc()) {
            echo '<div class="skill-category">';
            echo '<div class="category-header">';
            echo '<div>';
            echo '<h3 class="category-title"><i class="fas fa-folder"></i> ' . $category['category_name'] . '</h3>';
            echo '</div>';
            
            // إضافة أزرار إدارة الفئة
            echo '<div class="category-actions">';
            echo '<a href="edit_category.php?id=' . $category['id'] . '" class="btn btn-warning skill-btn"><i class="fas fa-edit"></i> تعديل الفئة</a>';
            echo '<a href="?delete_category=true&id=' . $category['id'] . '" class="btn btn-danger skill-btn" onclick="return confirmDeleteCategory(' . $category['id'] . ')"><i class="fas fa-trash"></i> حذف الفئة</a>';
            echo '</div>';
            echo '</div>';
            
            // جلب المهارات لهذه الفئة
            $skills = $conn->query("SELECT * FROM skills WHERE category_id = " . $category['id']);
            
            if ($skills->num_rows > 0) {
              while ($skill = $skills->fetch_assoc()) {
                echo '<div class="skill-item">';
                echo '<div class="skill-info">';
                echo '<div class="skill-name"><i class="fas fa-star"></i> ' . $skill['skill_name'] . '</div>';
                echo '<div class="progress-container">';
                echo '<div class="progress-bar" style="width: ' . $skill['percentage'] . '%"></div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="skill-percent">' . $skill['percentage'] . '%</div>';
                echo '<div class="skill-actions">';
                echo '<a href="edit_skill.php?id=' . $skill['id'] . '" class="btn btn-primary skill-btn"><i class="fas fa-edit"></i> تعديل</a>';
                echo '<a href="?delete_skill=true&id=' . $skill['id'] . '" class="btn btn-danger skill-btn" onclick="return confirm(\'هل أنت متأكد من حذف هذه المهارة؟\')"><i class="fas fa-trash"></i> حذف</a>';
                echo '</div>';
                echo '</div>';
              }
            } else {
              echo '<div class="no-skills-in-category" style="background: rgba(100, 116, 139, 0.2); padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 15px;">';
              echo '<i class="fas fa-info-circle"></i> لا توجد مهارات في هذه الفئة';
              echo '</div>';
            }
            
            echo '</div>';
          }
        } else {
          echo '<div class="no-skills">';
          echo '<i class="fas fa-star"></i>';
          echo '<h3>لا توجد فئات مهارات بعد</h3>';
          echo '<p>لم تقم بإضافة أي فئات مهارات بعد. يمكنك البدء بإضافة فئات جديدة.</p>';
          echo '<a href="add_category.php" class="btn btn-success" style="margin-top: 20px;"><i class="fas fa-plus"></i> إضافة فئة جديدة</a>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>

  <script>
    // إضافة رسوم متحركة لأشرطة التقدم
    document.addEventListener('DOMContentLoaded', function() {
      const progressBars = document.querySelectorAll('.progress-bar');
      
      progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        
        setTimeout(() => {
          bar.style.width = width;
        }, 300);
      });
    });
    
    // تأكيد حذف الفئة مع مهاراتها
    function confirmDeleteCategory(categoryId) {
      return confirm('هل أنت متأكد أنك تريد حذف هذه الفئة وجميع مهاراتها الفرعية؟ هذا الإجراء لا يمكن التراجع عنه.');
    }
    
    // إظهار رسالة تنبيه عند حذف الفئة
    <?php if (isset($_GET['delete_category'])): ?>
      setTimeout(() => {
        const alert = document.createElement('div');
        alert.className = 'alert-message alert-danger';
        alert.innerHTML = `
          <i class="fas fa-exclamation-triangle"></i> 
          سيتم حذف الفئة وجميع مهاراتها الفرعية بشكل دائم
        `;
        
        const container = document.querySelector('.dashboard-content');
        container.insertBefore(alert, container.firstChild);
        
        setTimeout(() => {
          alert.style.opacity = '0';
          setTimeout(() => alert.remove(), 500);
        }, 5000);
      }, 500);
    <?php endif; ?>
  </script>
</body>
</html>