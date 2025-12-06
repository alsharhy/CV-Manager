<?php
session_start();
include '../public/db_connect.php';

// التحقق من وجود معرف السجل في الرابط
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "لم يتم تحديد السجل.";
    header("Location: list_information.php");
    exit;
}

$id = $_GET['id'];
$info = null;

// جلب بيانات السجل الحالية
$sql = "SELECT * FROM information WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $info = mysqli_fetch_assoc($result);
} else {
    $_SESSION['error'] = "لم يتم العثور على السجل المطلوب.";
    header("Location: list_information.php");
    exit;
}

// معالجة تحديث السجل
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $current_image = $info['image']; // الصورة الحالية
    
    // معالجة رفع الصورة الجديدة إذا تم اختيارها
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/image/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // التحقق من أن الملف صورة
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // إنشاء اسم فريد للصورة
            $new_filename = uniqid() . '.' . $imageFileType;
            $target_path = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($current_image) {
                    $old_image_path = $target_dir . $current_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                $current_image = $new_filename;
            }
        }
    }
    
    // تحديث السجل في قاعدة البيانات
    $update_sql = "UPDATE information SET 
                  name = '$name',
                  phone = '$phone',
                  address = '$address',
                  email = '$email',
                  birthdate = '$birthdate',
                  image = '$current_image'
                  WHERE id = $id";
    
    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['success'] = "تم تحديث المعلومات بنجاح!";
        // تحديث بيانات السجل بعد التحديث
        $result = mysqli_query($conn, "SELECT * FROM information WHERE id = $id");
        $info = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "حدث خطأ أثناء التحديث: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديث المعلومات الشخصية</title>
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
            max-width: 800px;
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

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(100, 116, 139, 0.3);
            border: none;
            cursor: pointer;
            gap: 10px;
            font-size: 1.05rem;
        }

        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        }

        .info-form {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid var(--border-color);
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--accent-color);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .current-image {
            margin-top: 15px;
            padding: 15px;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 10px;
            border: 1px solid var(--border-color);
        }

        .current-image img {
            max-width: 200px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid var(--border-color);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .submit-btn, .cancel-btn {
            flex: 1;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
            border: none;
        }

        .cancel-btn {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .cancel-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
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
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h2><i class="fas fa-user-edit"></i> تحديث المعلومات الشخصية</h2>
            <a href="list_information.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> العودة للقائمة
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

        <div class="info-form">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> الاسم الكامل</label>
                    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($info['name']) ?>">
                </div>

                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> رقم الهاتف</label>
                    <input type="text" id="phone" name="phone" required value="<?= htmlspecialchars($info['phone']) ?>">
                </div>

                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> العنوان</label>
                    <input type="text" id="address" name="address" required value="<?= htmlspecialchars($info['address']) ?>">
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($info['email']) ?>">
                </div>

                <div class="form-group">
                    <label for="birthdate"><i class="fas fa-birthday-cake"></i> تاريخ الميلاد</label>
                    <input type="date" id="birthdate" name="birthdate" required value="<?= htmlspecialchars($info['birthdate']) ?>">
                </div>

                <div class="form-group">
                    <label for="image"><i class="fas fa-image"></i> الصورة الشخصية</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <?php if ($info['image']): ?>
                        <div class="current-image">
                            <p>الصورة الحالية:</p>
                            <img src="../uploads/image/<?= $info['image'] ?>" alt="الصورة الشخصية">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i> حفظ التحديثات
                    </button>
                    <a href="list_information.php" class="cancel-btn">
                        <i class="fas fa-times"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>