<?php
include '../public/db_connect.php';

// جلب بيانات المهارة المراد تعديلها
$skill_id = isset($_GET['id']) ? $_GET['id'] : null;
$skill = null;

if ($skill_id) {
    $stmt = $conn->prepare("SELECT * FROM skills WHERE id = ?");
    $stmt->bind_param("i", $skill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $skill = $result->fetch_assoc();
}

// معالجة تحديث المهارة
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $skill_name = $_POST['skill_name'];
    $percentage = $_POST['percentage'];
    $category_id = $_POST['category_id'];
    
    $stmt = $conn->prepare("UPDATE skills SET skill_name=?, percentage=?, category_id=? WHERE id=?");
    $stmt->bind_param("siii", $skill_name, $percentage, $category_id, $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $update_message = "تم تحديث المهارة بنجاح";
        // جلب البيانات المحدثة
        $stmt = $conn->prepare("SELECT * FROM skills WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $skill = $result->fetch_assoc();
    } else {
        $update_error = "حدث خطأ أثناء تحديث المهارة";
    }
}

// جلب جميع الفئات
$categories = $conn->query("SELECT * FROM skill_categories");
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
  <title>تعديل المهارة | لوحة التحكم</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style-edit_skill.css">

</head>
<body>
  <div class="dashboard-container">
    <div class="dashboard-header">
      <h2 class="dashboard-title"><i class="fas fa-edit"></i> تعديل المهارة</h2>
      <a href="list_skills.php" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> العودة لقائمة المهارات
      </a>
    </div>

    <?php if (isset($update_message)): ?>
      <div class="alert-message">
        <i class="fas fa-check-circle"></i> <?php echo $update_message; ?>
      </div>
    <?php endif; ?>
    
    <?php if (isset($update_error)): ?>
      <div class="alert-message alert-error">
        <i class="fas fa-exclamation-circle"></i> <?php echo $update_error; ?>
      </div>
    <?php endif; ?>
    
    <?php if ($skill): ?>
      <form method="POST">
        <input type="hidden" name="id" value="<?php echo $skill['id']; ?>">
        
        <div class="form-group">
          <label for="category_id"><i class="fas fa-folder"></i> الفئة</label>
          <select name="category_id" id="category_id" class="form-control" required>
            <?php while ($category = $categories->fetch_assoc()): ?>
              <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $skill['category_id'] ? 'selected' : ''; ?>>
                <?php echo $category['category_name']; ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        
        <div class="form-group">
          <label for="skill_name"><i class="fas fa-star"></i> اسم المهارة</label>
          <input type="text" id="skill_name" name="skill_name" class="form-control" 
                 value="<?php echo htmlspecialchars($skill['skill_name']); ?>" required>
        </div>
        
        <div class="form-group">
          <label for="percentage"><i class="fas fa-percent"></i> النسبة المئوية</label>
          <input type="number" id="percentage" name="percentage" class="form-control" 
                 min="0" max="100" value="<?php echo $skill['percentage']; ?>" required>
          <small>يجب أن تكون القيمة بين 0 و 100</small>
        </div>
        
        <div class="section-buttons">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> حفظ التعديلات
          </button>
          <a href="list_skills.php" class="btn btn-back">
            <i class="fas fa-times"></i> إلغاء
          </a>
        </div>
      </form>
    <?php else: ?>
      <div class="alert-message alert-error">
        <i class="fas fa-exclamation-circle"></i> لم يتم العثور على المهارة المطلوبة
      </div>
      <div class="section-buttons">
        <a href="list_skills.php" class="btn btn-back">
          <i class="fas fa-arrow-left"></i> العودة لقائمة المهارات
        </a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>