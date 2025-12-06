<?php
session_start();
include '../public/db_connect.php';

// معالجة حذف السجلات
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    
    $sql = "SELECT image FROM information WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        if ($row['image']) {
            $image_path = "../uploads/image/" . $row['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        $delete_sql = "DELETE FROM information WHERE id = $id";
        if (mysqli_query($conn, $delete_sql)) {
            $_SESSION['success'] = "تم حذف السجل بنجاح!";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء الحذف: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "لم يتم العثور على السجل المطلوب.";
    }
    
    header("Location: list_information.php");
    exit;
}

// جلب جميع السجلات من قاعدة البيانات
$sql = "SELECT * FROM information ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المعلومات الشخصية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
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
            --edit-color: #8b5cf6;
            --transition: all 0.3s ease;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0c1a32 0%, #1a2b4d 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 40px 30px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--box-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .admin-header h2 {
            color: var(--accent-color);
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            right: 0;
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-color), transparent);
            border-radius: 3px;
        }

        .add-btn, .back-btn {
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

        .add-btn:hover, .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .info-card {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 15px;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--border-color);
            box-shadow: var(--box-shadow);
            position: relative;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .card-header {
            display: flex;
            align-items: center;
            padding: 20px;
            background: rgba(30, 41, 59, 0.5);
            border-bottom: 1px solid var(--border-color);
        }

        .profile-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            margin-left: 15px;
            border: 3px solid var(--accent-color);
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .default-image {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            width: 100%;
            height: 100%;
        }

        .default-image i {
            font-size: 2rem;
            color: var(--text-secondary);
            opacity: 0.5;
        }

        .person-name {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .card-content {
            padding: 20px;
        }

        .info-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-icon {
            min-width: 30px;
            font-size: 1.2rem;
            color: var(--accent-color);
        }

        .info-text {
            flex: 1;
        }

        .info-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 1.1rem;
        }

        .card-actions {
            display: flex;
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            background: rgba(15, 23, 42, 0.5);
            gap: 10px;
        }

        .action-btn {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            border: none;
            font-size: 0.95rem;
        }

        .edit-btn {
            background: linear-gradient(135deg, var(--edit-color) 0%, #7c3aed 100%);
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

        .empty-info {
            text-align: center;
            padding: 50px 20px;
            color: #94a3b8;
            font-size: 1.1rem;
            border: 2px dashed rgba(148, 163, 184, 0.3);
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.3);
            grid-column: 1 / -1;
        }

        .empty-info i {
            font-size: 3.5rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-info p {
            margin-bottom: 25px;
            font-size: 1.2rem;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.5s ease;
        }

        .alert-success {
            background: var(--success-color);
            color: white;
        }

        .alert-error {
            background: var(--danger-color);
            color: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* التجاوبية */
        @media (max-width: 768px) {
            .admin-container {
                padding: 25px 20px;
            }
            
            .admin-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .admin-header h2 {
                font-size: 1.8rem;
            }
            
            .admin-header::after {
                right: 50%;
                transform: translateX(50%);
                width: 150px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .card-actions {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .card-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-image {
                margin-left: 0;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h2><i class="fas fa-user-circle"></i> إدارة المعلومات الشخصية</h2>
            <a href="add_information.php" class="add-btn">
                <i class="fas fa-plus-circle"></i> إضافة معلومات جديدة
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> 
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> 
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="info-grid">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="info-card">
                        <div class="card-header">
                            <?php if ($row['image']): ?>
                                <div class="profile-image">
                                    <img src="../uploads/image/<?= $row['image'] ?>" alt="صورة الملف الشخصي">
                                </div>
                            <?php else: ?>
                                <div class="profile-image">
                                    <div class="default-image">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="person-name"><?= htmlspecialchars($row['name']) ?></div>
                        </div>
                        
                        <div class="card-content">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-text">
                                    <div class="info-label">رقم الهاتف</div>
                                    <div class="info-value"><?= htmlspecialchars($row['phone']) ?></div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-text">
                                    <div class="info-label">العنوان</div>
                                    <div class="info-value"><?= htmlspecialchars($row['address']) ?></div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-text">
                                    <div class="info-label">البريد الإلكتروني</div>
                                    <div class="info-value"><?= htmlspecialchars($row['email']) ?></div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-birthday-cake"></i>
                                </div>
                                <div class="info-text">
                                    <div class="info-label">تاريخ الميلاد</div>
                                    <div class="info-value"><?= htmlspecialchars($row['birthdate']) ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-actions">
                            <a href="edit_information.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> تحديث
                            </a>
                            <button class="action-btn delete-btn" onclick="confirmDelete(<?= $row['id'] ?>)">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-info">
                <i class="fas fa-user-slash"></i>
                <h3>لا توجد معلومات شخصية مسجلة</h3>
                <p>لم تقم بإضافة أي معلومات شخصية بعد. يمكنك البدء بإضافة معلومات جديدة.</p>
                <a href="add_information.php" class="add-btn">
                    <i class="fas fa-plus-circle"></i> إضافة معلومات جديدة
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('هل أنت متأكد من حذف هذه المعلومات؟ سيتم حذف جميع البيانات المرتبطة بها.')) {
                window.location.href = 'list_information.php?delete_id=' + id;
            }
        }
    </script>
</body>
</html>