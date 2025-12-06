<?php
include '../public/db_connect.php';

// التحقق من وجود معرف
if (!isset($_GET['id'])) {
    header("Location: list_contact.php");
    exit();
}

$id = $_GET['id'];

// جلب بيانات التواصل الحالية
$sql = "SELECT * FROM contact WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: list_contact.php");
    exit();
}

$contact = $result->fetch_assoc();

// إذا تم إرسال النموذج (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جمع البيانات من النموذج
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $facebook_url = $_POST['facebook_url'];
    $telegram_url = $_POST['telegram_url'];
    $instagram_url = $_POST['instagram_url'];
    $whatsapp_url = $_POST['whatsapp_url'];
    $threads_url = $_POST['threads_url'];

    // تحديث البيانات
    $update_sql = "UPDATE contact SET email=?, phone=?, location=?, facebook_url=?, telegram_url=?, instagram_url=?, whatsapp_url=?, threads_url=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssssi", $email, $phone, $location, $facebook_url, $telegram_url, $instagram_url, $whatsapp_url, $threads_url, $id);

    if ($update_stmt->execute()) {
        header("Location: list_contact.php?success=1");
        exit();
    } else {
        $error = "حدث خطأ أثناء التحديث: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تعديل معلومات التواصل</title>
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

        .edit-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px 30px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--box-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }

        .edit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .edit-header h2 {
            color: var(--accent-color);
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .edit-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            right: 0;
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-color), transparent);
            border-radius: 3px;
        }

        .form-container {
            padding: 0 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--accent-color);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.1rem;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border-radius: 10px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .btn-container {
            display: flex;
            gap: 20px;
            margin-top: 35px;
        }

        .btn {
            flex: 1;
            padding: 16px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .save-btn {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
        }

        .save-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .cancel-btn {
            background: linear-gradient(135deg, var(--danger-color) 0%, #b91c1c 100%);
            color: white;
        }

        .cancel-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            color: #fecaca;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .success-message {
            background: rgba(16, 185, 129, 0.2);
            color: #a7f3d0;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        @media (max-width: 768px) {
            .edit-container {
                padding: 30px 20px;
            }
            
            .edit-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .edit-header h2 {
                font-size: 1.8rem;
            }
            
            .edit-header::after {
                right: 50%;
                transform: translateX(50%);
                width: 150px;
            }
            
            .btn-container {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="edit-container">
        <div class="edit-header">
            <h2><i class="fas fa-edit"></i> تعديل معلومات التواصل</h2>
        </div>

        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">تم تحديث معلومات التواصل بنجاح!</div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($contact['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> رقم الهاتف</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($contact['phone']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="location"><i class="fas fa-map-marker-alt"></i> الموقع</label>
                    <input type="text" id="location" name="location" value="<?= htmlspecialchars($contact['location']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="facebook_url"><i class="fab fa-facebook-f"></i> رابط فيسبوك</label>
                    <input type="url" id="facebook_url" name="facebook_url" value="<?= htmlspecialchars($contact['facebook_url']) ?>">
                </div>

                <div class="form-group">
                    <label for="telegram_url"><i class="fab fa-telegram"></i> رابط تلجرام</label>
                    <input type="url" id="telegram_url" name="telegram_url" value="<?= htmlspecialchars($contact['telegram_url']) ?>">
                </div>

                <div class="form-group">
                    <label for="instagram_url"><i class="fab fa-instagram"></i> رابط انستجرام</label>
                    <input type="url" id="instagram_url" name="instagram_url" value="<?= htmlspecialchars($contact['instagram_url']) ?>">
                </div>

                <div class="form-group">
                    <label for="whatsapp_url"><i class="fab fa-whatsapp"></i> رابط واتساب</label>
                    <input type="url" id="whatsapp_url" name="whatsapp_url" value="<?= htmlspecialchars($contact['whatsapp_url']) ?>">
                </div>

                <div class="form-group">
                    <label for="threads_url"><i class="fas fa-comment-dots"></i> رابط ثريد</label>
                    <input type="url" id="threads_url" name="threads_url" value="<?= htmlspecialchars($contact['threads_url']) ?>">
                </div>

                <div class="btn-container">
                    <a href="list_contact.php" class="btn cancel-btn">
                        <i class="fas fa-times"></i> إلغاء
                    </a>
                    <button type="submit" class="btn save-btn">
                        <i class="fas fa-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>