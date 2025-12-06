<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
    <link rel="stylesheet" href="style-login.css">
    
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>تسجيل الدخول</h2>
                <p>لوحة تحكم هكـتُور</p>
            </div>
            
            <form id="loginForm" action="../users/check_login.php" method="POST">
                <div class="form-group">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="أدخل اسم المستخدم" required>
                </div>
                
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" >
                </div>
                
                <button type="submit" class="btn-login">تسجيل الدخول</button>
                
                <!-- <div id="errorMessage" class="error-message">اسم المستخدم أو كلمة المرور غير صحيحة</div> -->
            </form>
            
            <div class="login-footer">
                <p>نسيت كلمة المرور؟ <a href="#">انقر هنا</a></p>
            </div>
        </div>
    </div>
    

</script>
</body>
</html><!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 
    <link rel="stylesheet" href="style-login.css">
    
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>تسجيل الدخول</h2>
                <p>لوحة تحكم هكـتُور</p>
            </div>
            
            <form id="loginForm" action="../users/check_login.php" method="POST">
                <div class="form-group">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="أدخل اسم المستخدم" required>
                </div>
                
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" >
                </div>
                
                <button type="submit" class="btn-login">تسجيل الدخول</button>
                
                <!-- <div id="errorMessage" class="error-message">اسم المستخدم أو كلمة المرور غير صحيحة</div> -->
            </form>
            
            <div class="login-footer">
                <p>نسيت كلمة المرور؟ <a href="#">انقر هنا</a></p>
            </div>
        </div>
    </div>
    

</script>
</body>
</html>