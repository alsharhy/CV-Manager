<?php
include '../public/db_connect.php';
$id = (int)$_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل المستخدم</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style-edit_user.css">
</head>
<body>

<div class="edit-user-container">
  <div class="edit-header">
    <h2><i class="fas fa-user-edit"></i> تعديل المستخدم</h2>
  </div>
  
  <div class="user-avatar">
    <?= strtoupper(substr($user['username'], 0, 1)) ?>
  </div>
  
  <form action="update_user.php" method="POST" class="edit-user-form">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    
    <div class="form-group">
      <label for="username"><i class="fas fa-user"></i> اسم المستخدم</label>
      <div class="input-with-icon">
        <i class="fas fa-user"></i>
        <input 
          type="text" 
          id="username" 
          name="username" 
          class="form-control" 
          value="<?= htmlspecialchars($user['username']) ?>" 
          placeholder="أدخل اسم المستخدم الجديد"
          required
        >
      </div>
    </div>
    
    <div class="form-group">
      <label for="password"><i class="fas fa-lock"></i> كلمة المرور</label>
      <div class="input-with-icon">
        <input 
          type="password" 
          id="password" 
          name="password" 
          class="form-control" 
          value="<?= htmlspecialchars($user['password']) ?>" 
          placeholder="أدخل كلمة المرور الجديدة"
          required
          style="padding-right: 50px;"
        >
        <button type="button" class="password-toggle" id="passwordToggle">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>
    
    <div class="action-buttons">
      <button type="submit" class="submit-btn update-btn">
        <i class="fas fa-save"></i> حفظ التعديلات
      </button>
      <a href="delete_user.php?id=<?= $user['id'] ?>" class="delete-btn">
        <i class="fas fa-trash"></i> حذف المستخدم
      </a>
    </div>
  </form>
  
  <a href="list_users.php" class="back-btn">
    <i class="fas fa-arrow-right"></i> العودة إلى القائمة
  </a>
</div>

<script>
  // إظهار/إخفاء كلمة المرور
  const passwordInput = document.getElementById('password');
  const passwordToggle = document.getElementById('passwordToggle');
  
  passwordToggle.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
      passwordInput.type = 'password';
      passwordToggle.innerHTML = '<i class="fas fa-eye"></i>';
    }
  });
  
  // تأكيد الحذف
  const deleteBtn = document.querySelector('.delete-btn');
  if (deleteBtn) {
    deleteBtn.addEventListener('click', function(e) {
      if (!confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم؟ سيتم فقدان جميع بياناته بشكل دائم.')) {
        e.preventDefault();
      }
    });
  }
</script>

</body>
</html>