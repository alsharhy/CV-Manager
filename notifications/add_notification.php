<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة إشعار جديد</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style-add_notification.css">

</head>
<body>
    <div class="notification-container">
        <div class="notification-header">
            <h2><i class="fas fa-bell"></i> إضافة إشعار جديد</h2>
            <a href="list_notifications.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> العودة للإشعارات
            </a>
        </div>

        <form method="POST" class="notification-form">
            <div class="form-group">
                <label for="title"><i class="fas fa-heading"></i> عنوان الإشعار</label>
                <input type="text" id="title" name="title" placeholder="أدخل عنواناً واضحاً للإشعار" required>
            </div>

            <div class="form-group">
                <label for="message"><i class="fas fa-comment-alt"></i> محتوى الإشعار</label>
                <textarea id="message" name="message" placeholder="أدخل محتوى الإشعار بالتفصيل..." required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> إرسال الإشعار
                </button>
                <button type="reset" class="reset-btn">
                    <i class="fas fa-redo"></i> إعادة تعيين
                </button>
            </div>
        </form>

        <div class="notification-preview">
            <div class="preview-header">
                <div class="preview-title">معاينة الإشعار</div>
                <div class="preview-badge">جديد</div>
            </div>
            <div class="preview-content">
                سيظهر محتوى الإشعار هنا بعد الكتابة...
            </div>
        </div>
    </div>

    <script>
        // معاينة الإشعار في الوقت الحقيقي
        const titleInput = document.getElementById('title');
        const messageInput = document.getElementById('message');
        const previewTitle = document.querySelector('.preview-title');
        const previewContent = document.querySelector('.preview-content');

        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value || "عنوان الإشعار";
        });

        messageInput.addEventListener('input', function() {
            previewContent.textContent = this.value || "سيظهر محتوى الإشعار هنا بعد الكتابة...";
        });
    </script>
</body>
</html>