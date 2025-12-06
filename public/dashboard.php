<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم | هكـتُور</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style-dashboard.css">
</head>

<body>
  <!-- لوحة التحكم -->
  <div class="dashboard-container" id="dashboardContainer">
    <div class="dashboard-content">
      <div class="dashboard-header">
        <h2 class="dashboard-title"><i class="fas fa-cogs"></i> لوحة التحكم</h2>
        <div>
          <button class="btn-submit" id="logoutBtn">
            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
          </button>
          <button class="close-dashboard" id="closeDashboard">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>

      <?php
      include '../public/db_connect.php';
      $sql = ("SELECT COUNT(*) as unread_count FROM notifications WHERE is_read = 0");
      $notif_result = mysqli_query($conn, $sql);
      $notif = $notif_result->fetch_assoc();
      $notif_count = $notif['unread_count'];
      $new_notif_result = mysqli_query($conn, "SELECT * FROM notifications WHERE is_new = 1");
      $new_notif_count = mysqli_num_rows($new_notif_result);
      ?>

      <div class="btn_head">
        <a href="../notifications/list_notifications.php">
          <i class="fas fa-bell"></i> الإشعارات (<?= $notif_count ?>)
        </a>
        <a href="../messages_contact/list_messages.php">
          <i class="fas fa-inbox"></i> صندوق الوارد
        </a>
        <a href="../notifications/add_notification.php">
          <i class="fas fa-paper-plane"></i> إرسال إشعارات
        </a>
        <a href="../stats/stats.php">
          <i class="fas fa-chart-line"></i> الزوار
        </a>
        <a href="../posts/posts.php">
          <i class="fas fa-newspaper"></i> المقالات
        </a>
      </div>

      <div id="notificationAlert" class="notification-alert" style="display: none;">
        <i class="fas fa-bell"></i>
        <span id="alertMessage"></span>
      </div>

      <div class="dashboard-grid">
        <!-- إدارة المعلومات الشخصية -->
        <div class="dashboard-section">
          <h3><i class="fas fa-user-circle"></i> إدارة المعلومات الشخصية</h3>
          <form id="projectForm" action="../information/information.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
              <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> الاسم الكامل</label>
                <input type="text" id="name" name="name" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="image"><i class="fas fa-image"></i> الصورة الشخصية</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> رقم الهاتف</label>
                <input type="number" id="phone" name="phone" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="address"><i class="fas fa-map-marker-alt"></i> العنوان</label>
                <input type="text" id="address" name="address" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label for="birthdate"><i class="fas fa-map-marker-alt"></i> تاريخ الميلاد</label>
              <input type="date" id="birthdate" name="birthdate" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="email"><i class="fas fa-envelope"></i> البريد الالكتروني</label>
              <input type="text" id="email" name="email" class="form-control" required>
            </div>

            <div class="section-buttons">
              <button type="submit" class="btn-submit">
                <i class="fas fa-plus"></i> إضافة المعلومات
              </button>
              <a href="../information/list_information.php" class="btn-submit">
                <i class="fas fa-eye"></i> قائمة المعلومات الشخصية 
              </a>
            </div>
          </form>
        </div>

        <!-- إدارة المشاريع -->
        <div class="dashboard-section">
          <h3><i class="fas fa-project-diagram"></i> إدارة المشاريع</h3>
          <form id="projectForm" action="../project/add_project.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
              <div class="form-group">
                <label for="projectTitle"><i class="fas fa-heading"></i> عنوان المشروع</label>
                <input type="text" id="projectTitle" name="project_title" class="form-control" placeholder="أدخل عنوان المشروع">
              </div>
              <div class="form-group">
                <label for="image"><i class="fas fa-image"></i> صورة البوست (اختياري)</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
              </div>
            </div>

            <div class="form-group">
              <label for="projectDescription"><i class="fas fa-align-left"></i> وصف المشروع</label>
              <textarea id="projectDescription" name="project_description" class="form-control" placeholder="أدخل وصف المشروع"></textarea>
            </div>

            <div class="form-group">
              <label for="projectTags"><i class="fas fa-tags"></i> وسوم المشروع (مفصولة بفاصلة)</label>
              <input type="text" id="projectTags" name="project_tags" class="form-control" placeholder="مثال: React, Node.js, MongoDB">
            </div>

            <div class="section-buttons">
              <button type="submit" class="btn-submit">
                <i class="fas fa-plus"></i> إضافة مشروع
              </button>
              <a href="../project/list_projects.php" class="btn-submit">
                <i class="fas fa-eye"></i> عرض المشاريع
              </a>
            </div>
          </form>
        </div>

        <!-- إدارة المؤهلات -->
        <div class="dashboard-section">
          <h3><i class="fas fa-graduation-cap"></i> إدارة المؤهلات</h3>
          <form id="qualificationForm" action="../qualifications/add_qualifications.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="qualificationTitle"><i class="fas fa-heading"></i> عنوان المؤهل</label>
              <input type="text" id="qualificationTitle" name="qualification_title" class="form-control" placeholder="أدخل عنوان المؤهل">
            </div>

            <div class="form-group">
              <label for="image"><i class="fas fa-image"></i> صورة المؤهل (اختياري)</label>
              <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
              <label for="qualificationDescription"><i class="fas fa-align-left"></i> وصف المؤهل</label>
              <input type="text" id="qualificationDescription" name="qualification_description" class="form-control" placeholder="أدخل وصف المؤهل"></input>
            </div>

            <div class="section-buttons">
              <button type="submit" class="btn-submit">
                <i class="fas fa-plus"></i> إضافة مؤهل
              </button>
              <a href="../qualifications/list_qualification.php" class="btn-submit">
                <i class="fas fa-eye"></i> عرض المؤهلات
              </a>
            </div>
          </form>
        </div>

        <!-- إدارة الطموحات -->
        <div class="dashboard-section">
          <h3><i class="fas fa-rocket"></i> إدارة الطموحات</h3>
          <form id="aspirationForm" action="../ambition/add_ambition.php" method="POST">
            <div class="form-group">
              <label for="aspirationTitle"><i class="fas fa-heading"></i> عنوان الطموح</label>
              <input type="text" id="aspirationTitle" name="ambitions_title" class="form-control" placeholder="أدخل عنوان الطموح">
            </div>

            <div class="form-group">
              <label for="aspirationDescription"><i class="fas fa-align-left"></i> وصف الطموح</label>
              <input type="text" id="aspirationDescription" name="ambitions_description" class="form-control" placeholder="أدخل وصف الطموح"></input>
            </div>

            <div class="form-group">
              <label for="aspirationIcon"><i class="fas fa-icons"></i> أيقونة الطموح (اختياري)</label>
              <select id="aspirationIcon" name="icon_url" class="form-control">
                <option value="fas fa-rocket">صاروخ</option>
                <option value="fas fa-globe">كرة أرضية</option>
                <option value="fas fa-graduation-cap">قبعة تخرج</option>
                <option value="fas fa-lightbulb">فكرة</option>
                <option value="fas fa-chart-line">نمو</option>
              </select>
            </div>

            <div class="section-buttons">
              <button type="submit" class="btn-submit">
                <i class="fas fa-plus"></i> إضافة طموح
              </button>
              <a href="../ambition/list_ambition.php" class="btn-submit">
                <i class="fas fa-eye"></i> عرض الطموحات
              </a>
            </div>
          </form>
        </div>

        <!-- إدارة المهارات -->
        <div class="dashboard-section">
          <h3><i class="fas fa-star"></i> إدارة المهارات</h3>

          <!-- إضافة فئة مهارات جديدة -->
          <h4><i class="fas fa-folder-plus"></i> إضافة فئة مهارات جديدة</h4>
          <form method="post" action="../skills/add_skill.php">
            <div class="form-group">
              <label for="category_name"><i class="fas fa-heading"></i> اسم الفئة</label>
              <input type="text" id="category_name" name="category_name" class="form-control" placeholder="اسم الفئة (مثلًا: تطوير الواجهة الأمامية)" required>
            </div>
            <div class="section-buttons">
              <button type="submit" name="add_category" class="btn-submit">
                <i class="fas fa-plus"></i> إضافة الفئة
              </button>
            </div>
          </form>

          <hr style="margin: 25px 0; border-color: var(--border-color);">

          <!-- إضافة مهارة فرعية -->
          <h4><i class="fas fa-star"></i> إضافة مهارة فرعية</h4>
          <form method="post" action="../skills/add_skill.php">
            <div class="form-group">
              <label for="category_id"><i class="fas fa-folder"></i> اختر الفئة</label>
              <select name="category_id" id="category_id" class="form-control" required>
                <option disabled selected>اختر الفئة</option>
                <?php
                $res = $conn->query("SELECT * FROM skill_categories");
                while ($row = $res->fetch_assoc()) {
                  echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="skill_name"><i class="fas fa-heading"></i> اسم المهارة</label>
                <input type="text" id="skill_name" name="skill_name" class="form-control" placeholder="اسم المهارة (مثلاً: HTML)" required>
              </div>
              <div class="form-group">
                <label for="percentage"><i class="fas fa-percent"></i> النسبة</label>
                <input type="number" id="percentage" name="percentage" class="form-control" placeholder="النسبة %" min="0" max="100" required>
              </div>
            </div>

            <div class="section-buttons">
              <button type="submit" name="add_skill" class="btn-submit">
                <i class="fas fa-plus"></i> إضافة المهارة
              </button>
              <a href="../skills/list_skills.php" class="btn-submit">
                <i class="fas fa-eye"></i> عرض المهارات
              </a>
            </div>
          </form>
        </div>

        <!-- إدارة المستخدمين -->
        <div class="dashboard-section">
          <h3><i class="fas fa-users-cog"></i> إدارة المستخدمين</h3>

          <h4><i class="fas fa-key"></i> تغيير كلمة المرور</h4>
          <form id="changePasswordForm" action="../users/change_password.php" method="POST">
            <div class="form-group">
              <label for="username"><i class="fas fa-user"></i> اسم المستخدم</label>
              <input type="text" id="username" name="username" class="form-control" placeholder="أدخل اسم المستخدم">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="old_password"><i class="fas fa-lock"></i> كلمة المرور الحالية</label>
                <input type="password" id="old_password" name="old_password" class="form-control" placeholder="أدخل كلمة المرور الحالية">
              </div>
              <div class="form-group">
                <label for="new_password"><i class="fas fa-key"></i> كلمة المرور الجديدة</label>
                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="أدخل كلمة المرور الجديدة">
              </div>
            </div>

            <div class="form-group">
              <label for="confirm_password"><i class="fas fa-check-circle"></i> تأكيد كلمة المرور الجديدة</label>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="أكد كلمة المرور الجديدة">
            </div>

            <div class="section-buttons">
              <button type="submit" class="btn-submit" name="change">
                <i class="fas fa-key"></i> تغيير كلمة المرور
              </button>
            </div>
          </form>

          <!-- إضافة مستخدم جديد -->
          <h4><i class="fas fa-user-plus"></i> إضافة مستخدم جديد</h4>
          <form id="addUserForm" action="../users/add_user.php" method="POST">
            <div class="form-row">
              <div class="form-group">
                <label for="newUsername"><i class="fas fa-user"></i> اسم المستخدم</label>
                <input type="text" id="newUsername" name="newUsername" class="form-control" placeholder="أدخل اسم مستخدم جديد">
              </div>
              <div class="form-group">
                <label for="newUserPassword"><i class="fas fa-lock"></i> كلمة المرور</label>
                <input type="password" id="newUserPassword" name="newUserPassword" class="form-control" placeholder="أدخل كلمة المرور">
              </div>
            </div>

            <div class="section-buttons">
              <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> إضافة مستخدم
              </button>
              <a href="../users/list_users.php" class="btn-submit">
                <i class="fas fa-eye"></i> عرض المستخدمين
              </a>
            </div>
          </form>

          <!-- إضافة معلومات التواصل -->
          <h4><i class="fas fa-address-book"></i> إضافة معلومات التواصل</h4>
          <form id="addUserForm" action="../contact/add_contact.php" method="POST">
            <div class="form-row">
              <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> الايميل</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="أدخل الايميل">
              </div>
              <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> رقم الهاتف</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="أدخل رقم الهاتف">
              </div>
            </div>

            <div class="form-group">
              <label for="location"><i class="fas fa-map-marker-alt"></i> الموقع</label>
              <input type="text" id="location" name="location" class="form-control" placeholder="أدخل الموقع">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="instagram_url"><i class="fab fa-instagram"></i> رابط انستجرام</label>
                <input type="text" id="instagram_url" name="instagram_url" class="form-control" placeholder="أدخل رابط انستجرام">
              </div>


              <div class="form-row">
                <div class="form-group">
                  <label for="whatsapp_url"><i class="fab fa-whatsapp"></i> رابط واتساب</label>
                  <input type="text" id="whatsapp_url" name="whatsapp_url" class="form-control" placeholder="أدخل رابط واتساب">
                </div>

                <div class="form-group">
                  <label for="telegram_url"><i class="fab fa-telegram"></i> رابط تلجرام</label>
                  <input type="text" id="telegram_url" name="telegram_url" class="form-control" placeholder="أدخل رابط تلجرام">
                </div>
              </div>

              <div class="form-group">
                <label for="facebook_url"><i class="fab fa-facebook"></i> رابط فيسبوك</label>
                <input type="text" id="facebook_url" name="facebook_url" class="form-control" placeholder="أدخل رابط فيسبوك">
              </div>

              <div class="form-group">
                <label for="threads_url"><i class="fab fa-twitter"></i> رابط ثريد</label>
                <input type="text" id="threads_url" name="threads_url" class="form-control" placeholder="أدخل رابط ثريد">
              </div>

              <div class="section-buttons">
                <button type="submit" class="btn-submit">
                  <i class="fas fa-plus"></i> إضافة معلومات التواصل
                </button>

                <a href="../contact/list_contact.php" class="btn-submit">
                  <i class="fas fa-eye"></i> عرض معلومات التواصل
                </a>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('logoutBtn').addEventListener('click', () => {
      window.location.href = 'index.php';
    });

    // عرض تنبيه الإشعارات الجديدة
    <?php if ($new_notif_count > 0): ?>
      document.addEventListener('DOMContentLoaded', function() {
        const alertElement = document.getElementById('notificationAlert');
        const messageElement = document.getElementById('alertMessage');

        // عرض التنبيه
        alertElement.style.display = 'flex';
        messageElement.textContent = 'لديك <?php echo $new_notif_count; ?> إشعار جديد';

        // إخفاء التنبيه بعد 3 ثوان
        setTimeout(() => {
          alertElement.style.opacity = '0';
          alertElement.style.transform = 'translateY(-20px)';

          // تحديث قاعدة البيانات بعد عرض التنبيه
          fetch('update_notifications.php')
            .then(response => response.text())
            .then(data => console.log('تم تحديث الإشعارات'))
            .catch(error => console.error('حدث خطأ:', error));

        }, 3000);
      });
    <?php endif; ?>
  </script>

</body>

</html>