<?php
include '../public/db_connect.php';

// في حالة إرسال النموذج (تعديل)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $project_title = mysqli_real_escape_string($conn, $_POST['project_title']);
    $project_description = mysqli_real_escape_string($conn, $_POST['project_description']);
    $project_tags = mysqli_real_escape_string($conn, $_POST['project_tags']);

    // معالجة تحميل الصورة
    $image = $project['image']; // الصورة القديمة

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/project/';
        $fileName = basename($_FILES['image']['name']);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($image && file_exists($uploadDir . $image)) {
                unlink($uploadDir . $image);
            }
            $image = $newFileName;
        } else {
            echo "خطأ في تحميل الصورة.";
            exit;
        }
    }

    $sql = "UPDATE projects SET 
                project_title='$project_title', 
                image='$image', 
                project_description='$project_description', 
                project_tags='$project_tags' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: list_projects.php');
        exit;
    } else {
        echo "خطأ في التحديث: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    exit;
}

// في حالة الفتح (عرض البيانات)
$id = (int)$_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM projects WHERE id=$id");
$project = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>تعديل مشروع</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-bg: #0f172a;
      --card-bg: rgba(30, 41, 59, 0.92);
      --accent-color: #3b82f6;
      --text-primary: #f1f5f9;
      --text-secondary: #cbd5e1;
      --border-color: rgba(255, 255, 255, 0.08);
      --success-color: #10b981;
      --danger-color: #ef4444;
      --warning-color: #f59e0b;
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: var(--text-primary);
      line-height: 1.6;
    }

    .edit-project-container {
      max-width: 800px;
      width: 100%;
      padding: 40px 35px;
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(10px);
      border: 1px solid var(--border-color);
      position: relative;
      overflow: hidden;
    }

    .edit-project-container::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      height: 100%;
      width: 4px;
      background: var(--accent-color);
      opacity: 0.8;
    }

    .edit-header {
      text-align: center;
      margin-bottom: 35px;
      position: relative;
      padding-bottom: 20px;
    }

    .edit-header h2 {
      color: var(--accent-color);
      font-size: 2.2rem;
      font-weight: 600;
      letter-spacing: -0.5px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .edit-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      right: 50%;
      transform: translateX(50%);
      width: 120px;
      height: 3px;
      background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
      border-radius: 3px;
    }

    .image-preview-container {
      text-align: center;
      margin-bottom: 30px;
    }

    .image-preview {
      width: 100%;
      max-width: 400px;
      height: 250px;
      background-color: rgba(15, 23, 42, 0.5);
      border-radius: 12px;
      margin: 0 auto 20px;
      overflow: hidden;
      position: relative;
      border: 2px dashed var(--border-color);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .image-preview img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .image-preview-placeholder {
      color: var(--text-secondary);
      font-size: 1.1rem;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 10px;
      font-weight: 600;
      color: var(--accent-color);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .input-with-icon {
      position: relative;
    }

    .input-with-icon i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--accent-color);
    }

    .form-control {
      width: 100%;
      padding: 15px 20px 15px 50px;
      background: rgba(15, 23, 42, 0.7);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      color: var(--text-primary);
      font-size: 1.05rem;
      transition: var(--transition);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--accent-color);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    textarea.form-control {
      min-height: 150px;
      resize: vertical;
      padding: 15px;
    }

    .tags-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }

    .tag {
      background: rgba(59, 130, 246, 0.15);
      color: var(--accent-color);
      padding: 5px 15px;
      border-radius: 50px;
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .tag i {
      cursor: pointer;
      transition: var(--transition);
    }

    .tag i:hover {
      color: var(--danger-color);
    }

    .submit-btn {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-top: 15px;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .submit-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 25px;
      background: linear-gradient(135deg, var(--accent-color) 0%, #2563eb 100%);
      color: white;
      text-decoration: none;
      border-radius: 12px;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
      border: none;
      cursor: pointer;
      gap: 10px;
      margin-top: 20px;
      font-size: 1rem;
      width: 100%;
    }

    .back-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    .action-buttons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .delete-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 25px;
      background: linear-gradient(135deg, var(--danger-color) 0%, #b91c1c 100%);
      color: white;
      text-decoration: none;
      border-radius: 12px;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
      border: none;
      cursor: pointer;
      gap: 10px;
      font-size: 1rem;
      flex: 1;
    }

    .delete-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .update-btn {
      flex: 2;
    }

    @media (max-width: 768px) {
      .edit-project-container {
        padding: 30px 25px;
      }

      .edit-header h2 {
        font-size: 1.8rem;
      }

      .image-preview {
        height: 200px;
      }

      .action-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>

  <div class="edit-project-container">
    <div class="edit-header">
      <h2><i class="fas fa-edit"></i> تعديل المشروع</h2>
    </div>

    <form action="" method="POST" class="edit-project-form" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $project['id'] ?>">

      <div class="form-group">
        <label for="project_title"><i class="fas fa-heading"></i> عنوان المشروع</label>
        <div class="input-with-icon">
          <i class="fas fa-heading"></i>
          <input
            type="text"
            id="project_title"
            name="project_title"
            class="form-control"
            value="<?= htmlspecialchars($project['project_title']) ?>"
            placeholder="أدخل عنوان المشروع"
            required>
        </div>
      </div>

      <div class="form-group">
        <label for="image"><i class="fas fa-image"></i> صورة المشروع</label>
        <div class="input-with-icon">
          <i class="fas fa-image"></i>
          <input
            type="file"
            id="image"
            name="image"
            class="form-control"
            accept="image/*">
        </div>

        <div class="image-preview-container">
          <h4>معاينة الصورة:</h4>
          <div class="image-preview" id="imagePreview">
            <?php if (!empty($project['image'])): ?>
              <img src="../uploads/project/<?= htmlspecialchars($project['image']) ?>" alt="معاينة مشروع">
            <?php else: ?>
              <div class="image-preview-placeholder">
                <i class="fas fa-image fa-3x"></i>
                <p>لم يتم اختيار صورة بعد</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="project_description"><i class="fas fa-align-left"></i> وصف المشروع</label>
        <textarea
          id="project_description"
          name="project_description"
          class="form-control"
          placeholder="أدخل وصف المشروع"
          required><?= htmlspecialchars($project['project_description']) ?></textarea>
      </div>

      <div class="form-group">
        <label for="project_tags"><i class="fas fa-tags"></i> وسوم المشروع</label>
        <div class="input-with-icon">
          <i class="fas fa-tag"></i>
          <input
            type="text"
            id="project_tags"
            name="project_tags"
            class="form-control"
            value="<?= htmlspecialchars($project['project_tags']) ?>"
            placeholder="أدخل وسوم المشروع مفصولة بفواصل"
            required>
        </div>
        <small>أمثلة: تصميم, تطوير, ويب, تطبيقات</small>

        <div class="tags-container" id="tagsContainer">
          <!-- سيتم إضافة الوسوم هنا ديناميكيًا -->
        </div>
      </div>

      <div class="action-buttons">
        <button type="submit" class="submit-btn update-btn">
          <i class="fas fa-save"></i> حفظ التعديلات
        </button>
        <a href="delete_project.php?id=<?= $project['id'] ?>" class="delete-btn">
          <i class="fas fa-trash"></i> حذف المشروع
        </a>
      </div>
    </form>

    <a href="list_projects.php" class="back-btn">
      <i class="fas fa-arrow-right"></i> العودة إلى القائمة
    </a>
  </div>

  <script>
    // تحديث معاينة الصورة عند اختيار ملف
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="معاينة مشروع">`;
            }
            reader.readAsDataURL(file);
        } else {
            // إذا لم يتم اختيار ملف، نعرض الصورة الحالية (إن وجدت) أو العنصر النائب
            <?php if (!empty($project['image'])): ?>
                imagePreview.innerHTML = `<img src="../uploads/project/<?= $project['image'] ?>" alt="معاينة مشروع">`;
            <?php else: ?>
                imagePreview.innerHTML = `
                    <div class="image-preview-placeholder">
                        <i class="fas fa-image fa-3x"></i>
                        <p>لم يتم اختيار صورة بعد</p>
                    </div>
                `;
            <?php endif; ?>
        }
    });

    // معالجة وسوم المشروع
    const tagsInput = document.getElementById('project_tags');
    const tagsContainer = document.getElementById('tagsContainer');

    function updateTagsDisplay() {
      const tags = tagsInput.value.split(',').map(tag => tag.trim()).filter(tag => tag);
      tagsContainer.innerHTML = '';

      tags.forEach(tag => {
        const tagElement = document.createElement('div');
        tagElement.className = 'tag';
        tagElement.innerHTML = `
        ${tag}
        <i class="fas fa-times" data-tag="${tag}"></i>
      `;
        tagsContainer.appendChild(tagElement);
      });

      // إضافة حدث لحذف الوسم
      document.querySelectorAll('.tag i').forEach(icon => {
        icon.addEventListener('click', function() {
          const tagToRemove = this.getAttribute('data-tag');
          const currentTags = tagsInput.value.split(',').map(tag => tag.trim()).filter(tag => tag);
          const updatedTags = currentTags.filter(tag => tag !== tagToRemove);
          tagsInput.value = updatedTags.join(', ');
          updateTagsDisplay();
        });
      });
    }

    // تحديث العرض عند التحميل
    updateTagsDisplay();

    // تحديث الوسوم عند تغيير الإدخال
    tagsInput.addEventListener('input', updateTagsDisplay);

    // تأكيد الحذف
    const deleteBtn = document.querySelector('.delete-btn');
    if (deleteBtn) {
      deleteBtn.addEventListener('click', function(e) {
        if (!confirm('هل أنت متأكد أنك تريد حذف هذا المشروع؟ سيتم فقدان جميع بياناته بشكل دائم.')) {
          e.preventDefault();
        }
      });
    }
  </script>

</body>

</html>