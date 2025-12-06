<?php
include '../public/db_connect.php';
$result = mysqli_query($conn, "SELECT * FROM contact");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>قائمة معلومات التواصل</title>
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
      --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      --facebook-color: #3b5998;
      --telegram-color: #0088cc;
      --instagram-color: #e1306c;
      --whatsapp-color: #25D366;
      --threads-color: #000000;
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

    .contacts-container {
      max-width: 1400px;
      margin: 40px auto;
      padding: 40px 30px;
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: var(--box-shadow);
      backdrop-filter: blur(10px);
      border: 1px solid var(--border-color);
    }

    .contacts-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 35px;
      padding-bottom: 25px;
      border-bottom: 1px solid var(--border-color);
      position: relative;
    }

    .contacts-header h2 {
      color: var(--accent-color);
      font-size: 2.2rem;
      font-weight: 600;
      letter-spacing: -0.5px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .contacts-header::after {
      content: '';
      position: absolute;
      bottom: -1px;
      right: 0;
      width: 200px;
      height: 3px;
      background: linear-gradient(90deg, var(--accent-color), transparent);
      border-radius: 3px;
    }

    .contacts-controls {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding: 0 10px;
    }

    .search-box {
      display: flex;
      width: 350px;
      background: rgba(15, 23, 42, 0.5);
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid var(--border-color);
    }

    .search-box input {
      flex: 1;
      padding: 12px 20px;
      background: transparent;
      border: none;
      color: var(--text-primary);
      font-size: 1rem;
    }

    .search-box input:focus {
      outline: none;
    }

    .search-box button {
      background: var(--accent-color);
      color: white;
      border: none;
      padding: 0 20px;
      cursor: pointer;
      transition: var(--transition);
    }

    .search-box button:hover {
      background: #2563eb;
    }

    .add-contact-btn {
      background: var(--success-color);
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .add-contact-btn:hover {
      background: #059669;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .contacts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 25px;
      margin-top: 20px;
    }

    .contact-card {
      background: rgba(15, 23, 42, 0.7);
      border-radius: 15px;
      overflow: hidden;
      border: 1px solid var(--border-color);
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .contact-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
    }

    .contact-id {
      background: rgba(15, 23, 42, 0.5);
      padding: 10px 20px;
      font-size: 0.9rem;
      color: var(--text-secondary);
      border-bottom: 1px solid var(--border-color);
    }

    .contact-header {
      display: flex;
      align-items: center;
      padding: 20px;
      gap: 15px;
      border-bottom: 1px solid var(--border-color);
    }

    .contact-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--accent-color) 0%, #2563eb 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
    }

    .contact-title {
      flex: 1;
    }

    .contact-name {
      font-weight: 600;
      font-size: 1.3rem;
      color: var(--text-primary);
    }

    .contact-details {
      padding: 20px;
    }

    .detail-item {
      display: flex;
      margin-bottom: 20px;
      padding-bottom: 20px;
      border-bottom: 1px solid var(--border-color);
    }

    .detail-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .detail-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-left: 15px;
      flex-shrink: 0;
      color: white;
      font-size: 1rem;
    }

    .email-icon {
      background: var(--danger-color);
    }

    .phone-icon {
      background: var(--success-color);
    }

    .location-icon {
      background: var(--warning-color);
    }

    .facebook-icon {
      background: var(--facebook-color);
    }

    .telegram-icon {
      background: var(--telegram-color);
    }

    .instagram-icon {
      background: var(--instagram-color);
    }

    .whatsapp-icon {
      background: var(--whatsapp-color);
    }

    .threads-icon {
      background: var(--threads-color);
    }

    .detail-content {
      flex: 1;
    }

    .detail-label {
      font-weight: 600;
      color: var(--text-secondary);
      font-size: 0.9rem;
      margin-bottom: 5px;
    }

    .detail-value {
      color: var(--text-primary);
      word-break: break-all;
    }

    .detail-value a {
      color: var(--accent-color);
      text-decoration: none;
      transition: var(--transition);
    }

    .detail-value a:hover {
      color: #93c5fd;
      text-decoration: underline;
    }

    .social-links {
      display: flex;
      justify-content: center;
      padding: 15px 0;
      border-top: 1px solid var(--border-color);
      margin: 0 20px;
    }

    .social-link {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 5px;
      color: white;
      font-size: 1.1rem;
      text-decoration: none;
      transition: var(--transition);
    }

    .social-link:hover {
      transform: translateY(-3px);
      opacity: 0.9;
    }

    .facebook {
      background: var(--facebook-color);
    }

    .telegram {
      background: var(--telegram-color);
    }

    .instagram {
      background: var(--instagram-color);
    }

    .whatsapp {
      background: var(--whatsapp-color);
    }

    .threads {
      background: var(--threads-color);
    }

    .contact-actions {
      display: flex;
      padding: 15px 20px;
      background: rgba(15, 23, 42, 0.5);
      border-top: 1px solid var(--border-color);
      gap: 15px;
    }

    .action-btn {
      flex: 1;
      padding: 12px;
      border-radius: 10px;
      text-align: center;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 0.95rem;
    }

    .edit-btn {
      background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
      color: white;
    }

    .edit-btn:hover {
      background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
    }

    .delete-btn {
      background: linear-gradient(135deg, var(--danger-color) 0%, #b91c1c 100%);
      color: white;
    }

    .delete-btn:hover {
      background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
    }

    .empty-contacts {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-secondary);
      border: 2px dashed var(--border-color);
      border-radius: 15px;
      margin-top: 20px;
    }

    .empty-contacts i {
      font-size: 4rem;
      margin-bottom: 20px;
      opacity: 0.3;
    }

    .empty-contacts p {
      font-size: 1.3rem;
      margin: 0;
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--accent-color);
      color: white;
      padding: 14px 30px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      margin-top: 30px;
    }

    .back-btn:hover {
      background: #2563eb;
      transform: translateX(5px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-container {
      text-align: center;
      margin-top: 30px;
    }

    /* التجاوبية */
    @media (max-width: 992px) {
      .contacts-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .contacts-container {
        padding: 30px 20px;
      }
      
      .contacts-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
      }
      
      .contacts-header h2 {
        font-size: 1.8rem;
      }
      
      .contacts-header::after {
        right: 50%;
        transform: translateX(50%);
        width: 150px;
      }
      
      .contacts-controls {
        flex-direction: column;
        gap: 20px;
      }
      
      .search-box {
        width: 100%;
      }
      
      .add-contact-btn {
        width: 100%;
      }
      
      .contacts-grid {
        grid-template-columns: 1fr;
      }
      
      .contact-actions {
        flex-direction: column;
      }
    }

    @media (max-width: 480px) {
      .contact-header {
        flex-direction: column;
        text-align: center;
      }
      
      .detail-item {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }
      
      .detail-icon {
        margin-left: 0;
        margin-bottom: 15px;
      }
    }
  </style>
</head>

<body>

  <div class="contacts-container">
    <div class="contacts-header">
      <h2><i class="fas fa-address-book"></i> قائمة معلومات التواصل</h2>
      <button class="add-contact-btn">
        <i class="fas fa-plus"></i> إضافة معلومات جديدة
      </button>
    </div>

    <div class="contacts-controls">
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="ابحث في معلومات التواصل...">
        <button id="searchBtn"><i class="fas fa-search"></i></button>
      </div>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="contacts-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="contact-card">
            <div class="contact-id">ID: <?= $row['id'] ?></div>

            <div class="contact-header">
              <div class="contact-icon">
                <i class="fas fa-address-card"></i>
              </div>
              <div class="contact-title">
                <div class="contact-name">معلومات التواصل</div>
              </div>
            </div>

            <div class="contact-details">
              <div class="detail-item">
                <div class="detail-icon email-icon">
                  <i class="fas fa-envelope"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">البريد الإلكتروني</div>
                  <div class="detail-value">
                    <a href="mailto:<?= htmlspecialchars($row['email']) ?>">
                      <?= htmlspecialchars($row['email']) ?>
                    </a>
                  </div>
                </div>
              </div>

              <div class="detail-item">
                <div class="detail-icon phone-icon">
                  <i class="fas fa-phone"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">رقم الهاتف</div>
                  <div class="detail-value">
                    <a href="tel:<?= htmlspecialchars($row['phone']) ?>">
                      <?= htmlspecialchars($row['phone']) ?>
                    </a>
                  </div>
                </div>
              </div>

              <div class="detail-item">
                <div class="detail-icon location-icon">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">الموقع</div>
                  <div class="detail-value"><?= htmlspecialchars($row['location']) ?></div>
                </div>
              </div>

              <div class="detail-item">
                <div class="detail-icon facebook-icon">
                  <i class="fab fa-facebook-f"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">حساب فيسبوك</div>
                  <div class="detail-value">
                    <a href="<?= htmlspecialchars($row['facebook_url']) ?>" target="_blank">
                      <?= htmlspecialchars($row['facebook_url']) ?>
                    </a>
                  </div>
                </div>
              </div>

              <div class="detail-item">
                <div class="detail-icon telegram-icon">
                  <i class="fab fa-telegram"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">حساب تلجرام</div>
                  <div class="detail-value">
                    <a href="<?= htmlspecialchars($row['telegram_url']) ?>" target="_blank">
                      <?= htmlspecialchars($row['telegram_url']) ?>
                    </a>
                  </div>
                </div>
              </div>

              <div class="detail-item">
                <div class="detail-icon instagram-icon">
                  <i class="fab fa-instagram"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">حساب انستجرام</div>
                  <div class="detail-value">
                    <a href="<?= htmlspecialchars($row['instagram_url']) ?>" target="_blank">
                      <?= htmlspecialchars($row['instagram_url']) ?>
                    </a>
                  </div>
                </div>
              </div>

              <div class="detail-item">
                <div class="detail-icon whatsapp-icon">
                  <i class="fab fa-whatsapp"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">حساب واتساب</div>
                  <div class="detail-value">
                    <a href="<?= htmlspecialchars($row['whatsapp_url']) ?>" target="_blank">
                      <?= htmlspecialchars($row['whatsapp_url']) ?>
                    </a>
                  </div>
                </div>
              </div>

              <div class="detail-item">
                <div class="detail-icon threads-icon">
                  <i class="fas fa-comment-dots"></i>
                </div>
                <div class="detail-content">
                  <div class="detail-label">حساب ثريد</div>
                  <div class="detail-value">
                    <a href="<?= htmlspecialchars($row['threads_url']) ?>" target="_blank">
                      <?= htmlspecialchars($row['threads_url']) ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="social-links">
              <?php if (!empty($row['facebook_url'])): ?>
                <a href="<?= htmlspecialchars($row['facebook_url']) ?>" class="social-link facebook" target="_blank">
                  <i class="fab fa-facebook-f"></i></a>
              <?php endif; ?>
              <?php if (!empty($row['telegram_url'])): ?>
                <a href="<?= htmlspecialchars($row['telegram_url']) ?>" class="social-link telegram" target="_blank">
                  <i class="fab fa-telegram"></i></a>
              <?php endif; ?>
              <?php if (!empty($row['instagram_url'])): ?>
                <a href="<?= htmlspecialchars($row['instagram_url']) ?>" class="social-link instagram" target="_blank">
                  <i class="fab fa-instagram"></i></a>
              <?php endif; ?>
              <?php if (!empty($row['whatsapp_url'])): ?>
                <a href="<?= htmlspecialchars($row['whatsapp_url']) ?>" class="social-link whatsapp" target="_blank">
                  <i class="fab fa-whatsapp"></i></a>
              <?php endif; ?>
              <?php if (!empty($row['threads_url'])): ?>
                <a href="<?= htmlspecialchars($row['threads_url']) ?>" class="social-link threads" target="_blank">
                  <i class="fas fa-comment-dots"></i></a>
              <?php endif; ?>
            </div>

            <div class="contact-actions">
              <a href="edit_contact.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                <i class="fas fa-edit"></i> تعديل
              </a>
              <a href="delete_contact.php?id=<?= $row['id'] ?>" class="action-btn delete-btn" onclick="return confirm('هل أنت متأكد أنك تريد حذف معلومات التواصل هذه؟')">
                <i class="fas fa-trash"></i> حذف
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="empty-contacts">
        <i class="fas fa-address-book"></i>
        <p>لا توجد معلومات تواصل مسجلة حالياً</p>
      </div>
    <?php endif; ?>

    <div class="btn-container">
      <a class="back-btn" href="../public/dashboard.php">
        <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
      </a>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const contactCards = document.querySelectorAll('.contact-card');
      
      searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        contactCards.forEach(card => {
          const content = card.textContent.toLowerCase();
          if (content.includes(searchTerm)) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }
        });
      });
      
      document.getElementById('searchBtn').addEventListener('click', function() {
        searchInput.focus();
      });
    });
  </script>

</body>

</html>