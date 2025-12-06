<?php
include '../public/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $ambitions_title = mysqli_real_escape_string($conn, $_POST['ambitions_title']);
    $ambitions_description = mysqli_real_escape_string($conn, $_POST['ambitions_description']);
    $icon_url = mysqli_real_escape_string($conn, $_POST['icon_url']);

    $sql = "UPDATE ambitions SET 
                ambitions_title='$ambitions_title', 
                ambitions_description='$ambitions_description', 
                icon_url='$icon_url' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: list_ambition.php');
        exit;
    } else {
        echo "خطأ في التحديث: " . mysqli_error($conn);
    }

    exit;
}

$id = (int)$_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM ambitions WHERE id=$id");
$ambition = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل الطموح</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style-edit_ambition.css">

</head>
<body>

<div class="ambition-container">
  <div class="edit-header">
    <h2><i class="fas fa-bullseye"></i> تعديل الطموح</h2>
  </div>
  
  <div class="ambition-id">ID: <?= $ambition['id'] ?></div>
  
  <form action="" method="POST" class="ambition-form">
    <input type="hidden" name="id" value="<?= $ambition['id'] ?>">
    
    <div class="icon-preview-container">
      <div class="icon-preview" id="iconPreview">
        <?php if (!empty($ambition['icon_url'])): ?>
          <img src="<?= htmlspecialchars($ambition['icon_url']) ?>" alt="معاينة أيقونة الطموح">
        <?php else: ?>
          <div class="icon-preview-placeholder">
            <i class="fas fa-image fa-3x"></i>
            <p>لم يتم اختيار أيقونة بعد</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
    
    <div class="form-group">
      <label for="icon_url"><i class="fas fa-link"></i> رابط الأيقونة</label>
      <div class="input-with-icon">
        <i class="fas fa-link"></i>
        <input 
          type="url" 
          id="icon_url" 
          name="icon_url" 
          class="form-control" 
          value="<?= htmlspecialchars($ambition['icon_url']) ?>" 
          placeholder="أدخل رابط الأيقونة"
          required
        >
      </div>
    </div>
    
    <div class="form-group">
      <label for="ambitions_title"><i class="fas fa-heading"></i> عنوان الطموح</label>
      <div class="input-with-icon">
        <i class="fas fa-heading"></i>
        <input 
          type="text" 
          id="ambitions_title" 
          name="ambitions_title" 
          class="form-control" 
          value="<?= htmlspecialchars($ambition['ambitions_title']) ?>" 
          placeholder="أدخل عنوان الطموح"
          required
        >
      </div>
    </div>
    
    <div class="form-group">
      <label for="ambitions_description"><i class="fas fa-align-left"></i> وصف الطموح</label>
      <textarea 
        id="ambitions_description" 
        name="ambitions_description" 
        class="form-control" 
        placeholder="أدخل وصف الطموح"
        required
      ><?= htmlspecialchars($ambition['ambitions_description']) ?></textarea>
    </div>
    
    <div class="action-buttons">
      <button type="submit" class="submit-btn update-btn">
        <i class="fas fa-save"></i> حفظ التعديلات
      </button>
      <a href="delete_ambition.php?id=<?= $ambition['id'] ?>" class="delete-btn">
        <i class="fas fa-trash"></i> حذف الطموح
      </a>
    </div>
  </form>
  
  <a href="list_ambition.php" class="back-btn">
    <i class="fas fa-arrow-right"></i> العودة إلى القائمة
  </a>
</div>

<script>
  // تحديث معاينة الأيقونة عند تغيير الرابط
  const iconUrlInput = document.getElementById('icon_url');
  const iconPreview = document.getElementById('iconPreview');
  
  iconUrlInput.addEventListener('input', function() {
    if (this.value) {
      iconPreview.innerHTML = `<img src="${this.value}" alt="معاينة أيقونة الطموح">`;
    } else {
      iconPreview.innerHTML = `
        <div class="icon-preview-placeholder">
          <i class="fas fa-image fa-3x"></i>
          <p>لم يتم اختيار أيقونة بعد</p>
        </div>
      `;
    }
  });
  
  // تأكيد الحذف
  const deleteBtn = document.querySelector('.delete-btn');
  if (deleteBtn) {
    deleteBtn.addEventListener('click', function(e) {
      if (!confirm('هل أنت متأكد أنك تريد حذف هذا الطموح؟ سيتم فقدان جميع بياناته بشكل دائم.')) {
        e.preventDefault();
      }
    });
  }
</script>

</body>
</html>