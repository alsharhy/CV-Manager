<?php
include 'db_connect.php';

$ip = $_SERVER['REMOTE_ADDR'];
$page = $_SERVER['REQUEST_URI'];
$now = date('Y-m-d H:i:s');
$sql = "INSERT INTO site_visits (ip_address, visit_time, page) VALUES ('$ip', '$now', '$page')";
mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>مطور ويب مبتدىء | هكتُـور</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <style>
    @font-face {
      font-family: 'GE_SS_Two_Medium';
      src: url('fonts/GE_SS_Two_Medium.otf') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    :root {
      --primary-color: #2563eb;
      --primary-light: #3b82f6;
      --primary-dark: #1e40af;
      --accent-color: #f59e0b;
      --accent-light: #fbbf24;
      --accent-dark: #d97706;
      --light-color: #f8fafc;
      --dark-color: #0f172a;
      --darker-color: #0c1a32;
      --gray-color: #64748b;
      --light-gray: #e2e8f0;
      --transition: all 0.3s ease;
      --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --radius: 16px;
      --glass: rgba(30, 41, 59, 0.85);
      --glass-border: rgba(255, 255, 255, 0.15);
      --card-gradient: linear-gradient(145deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'GE_SS_Two_Medium', 'Tajawal', sans-serif;
      background: linear-gradient(135deg, var(--darker-color) 0%, var(--dark-color) 100%);
      color: var(--light-color);
      line-height: 1.7;
      overflow-x: hidden;
      background-attachment: fixed;
      background-size: cover;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at center, rgba(37, 99, 235, 0.1) 0%, rgba(15, 23, 42, 0) 70%);
      z-index: -1;
    }

    .container {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 25px;
    }

    /* الترويسة المحسنة */
    header {
      background: rgba(15, 23, 42, 0.95);
      backdrop-filter: blur(12px);
      padding: 15px 0;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      border-bottom: 1px solid rgba(37, 99, 235, 0.3);
      transition: var(--transition);
    }

    header.scrolled {
      padding: 10px 0;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--accent-color);
      display: flex;
      align-items: center;
      transition: var(--transition);
    }

    .logo i {
      margin-left: 10px;
      transition: transform 0.5s ease;
    }

    .logo:hover i {
      transform: rotate(15deg);
    }

    .nav-links {
      display: flex;
      list-style: none;
    }

    .nav-links li {
      margin-left: 25px;
      position: relative;
    }

    .nav-links a {
      color: var(--light-color);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
      padding: 8px 12px;
      border-radius: 5px;
      display: block;
      font-size: 1.1rem;
      position: relative;
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: 0;
      right: 0;
      width: 0;
      height: 2px;
      background: var(--accent-color);
      transition: var(--transition);
    }

    .nav-links a:hover::after,
    .nav-links a.active::after {
      width: 100%;
      left: 0;
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: var(--accent-color);
    }

    /* القسم الرئيسي المحسن */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 150px 0 50px;
      position: relative;
      overflow: hidden;
    }

    .hero-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      gap: 60px;
    }

    .hero-text {
      flex: 1;
      position: relative;
      z-index: 2;
      animation: fadeInLeft 1s ease;
    }

    .hero-image {
      flex: 1;
      display: flex;
      justify-content: center;
      position: relative;
      z-index: 2;
      animation: fadeInRight 1s ease;
    }

    .profile-img {
      width: 380px;
      height: 380px;
      border-radius: 50%;
      border: 5px solid var(--primary-color);
      overflow: hidden;
      position: relative;
      box-shadow: 0 15px 40px rgba(37, 99, 235, 0.5);
      animation: float 6s ease-in-out infinite;
      transition: transform 0.5s ease;
    }

    .profile-img:hover {
      transform: scale(1.03);
      box-shadow: 0 20px 50px rgba(37, 99, 235, 0.6);
    }

    .profile-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .profile-img:hover img {
      transform: scale(1.05);
    }

    .hero-text h1 {
      font-size: 3.8rem;
      margin-bottom: 20px;
      line-height: 1.2;
      background: linear-gradient(to right, var(--light-color), var(--accent-color));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-text h1 span {
      display: block;
      background: linear-gradient(to right, var(--accent-color), var(--accent-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .title {
      font-size: 1.8rem;
      color: var(--accent-color);
      margin-bottom: 30px;
      position: relative;
      display: inline-block;
      padding-bottom: 10px;
    }

    .title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(to right, var(--primary-color), var(--accent-color));
      border-radius: 2px;
    }

    .hero-brief {
      background: var(--glass);
      padding: 30px;
      border-radius: var(--radius);
      border-left: 4px solid var(--accent-color);
      margin-top: 25px;
      backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--shadow);
      animation: fadeInUp 1s ease;
    }

    .btn {
      display: inline-block;
      padding: 14px 32px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: white;
      border-radius: var(--radius);
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      border: none;
      margin-top: 30px;
      font-size: 1.1rem;
      position: relative;
      overflow: hidden;
      z-index: 1;
      box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 0;
      height: 100%;
      background: rgba(255, 255, 255, 0.15);
      transition: width 0.5s ease;
      z-index: -1;
    }

    .btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(37, 99, 235, 0.5);
    }

    .btn:hover::before {
      width: 100%;
    }

    .dashboard-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 1000;
      width: 65px;
      height: 65px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      cursor: pointer;
      box-shadow: 0 5px 20px rgba(37, 99, 235, 0.6);
      transition: var(--transition);
      animation: pulse 2s infinite;
    }

    .dashboard-toggle:hover {
      transform: scale(1.1) rotate(15deg);
      box-shadow: 0 8px 25px rgba(37, 99, 235, 0.8);
      animation: none;
    }

    /* قسم المعلومات الشخصية المحسن */
    .personal-info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-top: 60px;
      animation: fadeInUp 1.2s ease;
    }

    .personal-info-item {
      background: var(--card-gradient);
      backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
      border-radius: var(--radius);
      padding: 25px;
      display: flex;
      align-items: center;
      gap: 20px;
      transition: var(--transition);
      box-shadow: var(--shadow);
    }

    .personal-info-item:hover {
      transform: translateY(-8px);
      background: linear-gradient(145deg, rgba(37, 99, 235, 0.25), rgba(15, 23, 42, 0.9));
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
      border-color: rgba(59, 130, 246, 0.4);
    }

    .personal-info-icon {
      width: 65px;
      height: 65px;
      background: rgba(37, 99, 235, 0.25);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      color: var(--accent-color);
      transition: var(--transition);
    }

    .personal-info-item:hover .personal-info-icon {
      background: rgba(245, 158, 11, 0.25);
      transform: rotate(15deg);
    }

    .personal-info-content h4 {
      color: var(--accent-color);
      margin-bottom: 8px;
      font-size: 1.3rem;
    }

    /* الأقسام المحسنة */
    section {
      padding: 120px 0;
      position: relative;
    }

    .section-title {
      text-align: center;
      margin-bottom: 70px;
      position: relative;
    }

    .section-title h2 {
      font-size: 2.8rem;
      display: inline-block;
      padding-bottom: 15px;
      position: relative;
      background: linear-gradient(to right, var(--light-color), var(--accent-color));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .section-title h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 5px;
      background: linear-gradient(to right, var(--primary-color), var(--accent-color));
      border-radius: 3px;
    }

    /* نبذة عني المحسنة */
    .about-content {
      display: flex;
      gap: 50px;
      align-items: center;
      background: var(--card-gradient);
      backdrop-filter: blur(12px);
      padding: 50px;
      border-radius: var(--radius);
      border: 1px solid var(--glass-border);
      box-shadow: var(--shadow);
      animation: fadeInUp 0.8s ease;
    }

    .about-text {
      flex: 1;
    }

    .about-text h3 {
      font-size: 1.9rem;
      margin-bottom: 25px;
      color: var(--accent-color);
      position: relative;
      padding-bottom: 12px;
    }

    .about-text h3::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 70px;
      height: 4px;
      background: var(--primary-color);
      border-radius: 2px;
    }

    /* مشاريعي ومؤهلاتي المحسنة */
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 35px;
    }

    .project-card {
      background: var(--card-gradient);
      border-radius: var(--radius);
      overflow: hidden;
      transition: var(--transition);
      position: relative;
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(12px);
      transform: translateY(30px);
      opacity: 0;
      animation: fadeInUp 0.6s forwards;
      box-shadow: var(--shadow);
    }

    .project-card.visible {
      transform: translateY(0);
      opacity: 1;
    }

    .project-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      border-color: rgba(59, 130, 246, 0.5);
    }

    .project-image {
      height: 220px;
      overflow: hidden;
      position: relative;
    }

    .project-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.4));
      z-index: 1;
    }

    .project-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.7s ease;
    }

    .project-card:hover .project-image img {
      transform: scale(1.15);
    }

    .project-content {
      padding: 25px;
    }

    .project-content h3 {
      font-size: 1.6rem;
      margin-bottom: 15px;
      color: var(--accent-color);
    }

    .project-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 20px;
    }

    .project-tag {
      background: rgba(37, 99, 235, 0.25);
      color: var(--light-color);
      padding: 7px 18px;
      border-radius: 20px;
      font-size: 0.95rem;
      transition: var(--transition);
      border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .project-tag:hover {
      background: rgba(37, 99, 235, 0.4);
      transform: translateY(-3px);
      border-color: var(--primary-color);
    }

    /* طموحاتي المحسنة */
    .aspirations-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
      gap: 30px;
    }

    .aspiration-item {
      background: var(--card-gradient);
      padding: 30px;
      border-radius: var(--radius);
      display: flex;
      align-items: flex-start;
      gap: 20px;
      transition: var(--transition);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(12px);
      transform: translateY(30px);
      opacity: 0;
      animation: fadeInUp 0.6s forwards;
      box-shadow: var(--shadow);
    }

    .aspiration-item.visible {
      transform: translateY(0);
      opacity: 1;
    }

    .aspiration-item:hover {
      transform: translateY(-10px);
      background: linear-gradient(145deg, rgba(37, 99, 235, 0.3), rgba(15, 23, 42, 0.9));
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
      border-color: rgba(59, 130, 246, 0.4);
    }

    .aspiration-icon {
      font-size: 2.2rem;
      color: var(--accent-color);
      min-width: 55px;
      display: flex;
      justify-content: center;
      transition: var(--transition);
    }

    .aspiration-item:hover .aspiration-icon {
      transform: scale(1.2);
      color: var(--accent-light);
    }

    .aspiration-item div h4 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      color: var(--accent-color);
    }

    /* المهارات المحسنة */
    .skills-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
      gap: 35px;
    }

    .skill-category {
      background: var(--card-gradient);
      padding: 35px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      transition: var(--transition);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(12px);
      transform: translateY(30px);
      opacity: 0;
      animation: fadeInUp 0.6s forwards;
    }

    .skill-category.visible {
      transform: translateY(0);
      opacity: 1;
    }

    .skill-category:hover {
      transform: translateY(-15px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      border-color: rgba(59, 130, 246, 0.5);
    }

    .skill-category h3 {
      font-size: 1.6rem;
      margin-bottom: 30px;
      color: var(--accent-color);
      display: flex;
      align-items: center;
      padding-bottom: 15px;
      border-bottom: 2px solid rgba(59, 130, 246, 0.3);
    }

    .skill-category h3 i {
      margin-left: 12px;
      transition: transform 0.5s ease;
    }

    .skill-category:hover h3 i {
      transform: rotate(15deg);
    }

    .skill-item {
      margin-bottom: 30px;
    }

    .skill-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 12px;
      font-size: 1.1rem;
    }

    .skill-bar {
      height: 14px;
      background: rgba(100, 116, 139, 0.2);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: inset 0 2px 5px rgba(0,0,0,0.2);
    }

    .skill-progress {
      height: 100%;
      background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
      border-radius: 10px;
      position: relative;
      transition: width 1.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }

    .skill-progress::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.01));
    }

    /* التواصل المحسن */
    .contact-container {
      display: flex;
      gap: 50px;
      margin-top: 50px;
    }

    .contact-info {
      flex: 1;
      background: var(--card-gradient);
      padding: 35px;
      border-radius: var(--radius);
      border-left: 5px solid var(--accent-color);
      backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
      box-shadow: var(--shadow);
    }

    .contact-info h3 {
      color: var(--accent-color);
      margin-bottom: 25px;
      font-size: 1.9rem;
      padding-bottom: 15px;
      border-bottom: 2px solid rgba(59, 130, 246, 0.3);
    }

    .contact-item {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
      gap: 25px;
    }

    .contact-icon {
      width: 70px;
      height: 70px;
      background: rgba(37, 99, 235, 0.25);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      color: var(--accent-color);
      transition: var(--transition);
    }

    .contact-item:hover .contact-icon {
      background: rgba(245, 158, 11, 0.25);
      transform: rotate(15deg);
    }

    .social-links {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 25px;
      margin-top: 50px;
    }

    .social-link {
      width: 75px;
      height: 75px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--card-gradient);
      color: white;
      font-size: 2rem;
      transition: var(--transition);
      text-decoration: none;
      border: 2px solid var(--glass-border);
      backdrop-filter: blur(12px);
      box-shadow: var(--shadow);
    }

    .social-link:hover {
      transform: translateY(-12px) scale(1.1);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .social-link.whatsapp:hover {
      background: linear-gradient(135deg, #25D366, #128C7E);
      border-color: #25D366;
    }

    .social-link.facebook:hover {
      background: linear-gradient(135deg, #1877F2, #0e5a9d);
      border-color: #1877F2;
    }

    .social-link.telegram:hover {
      background: linear-gradient(135deg, #0088CC, #006699);
      border-color: #0088CC;
    }

    .social-link.instagram:hover {
      background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
      border-color: #dc2743;
    }

    .social-link.threads:hover {
      background: linear-gradient(135deg, #000000, #333333);
      border-color: #000000;
    }


   .form-contact {
      margin-top: 30px;
      background: var(--card-gradient);
      padding: 45px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      width: 100%;
      backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
    }

    .form-control {
      width: 100%;
      padding: 16px;
      margin-bottom: 25px;
      border: 2px solid var(--glass-border);
      border-radius: 10px;
      font-family: 'GE_SS_Two_Medium', sans-serif;
      font-size: 1.05rem;
      transition: var(--transition);
      background: rgba(255, 255, 255, 0.07);
      color: var(--light-color);
    }

    .form-control:focus {
      border-color: var(--primary-color);
      outline: none;
      background: rgba(255, 255, 255, 0.12);
      box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.25);
    }

    textarea.form-control {
      min-height: 170px;
      resize: vertical;
    }

    .btn-submit {
      padding: 16px 30px;
      border-radius: var(--radius);
      text-decoration: none;
      font-size: 1.1rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      transition: all 0.3s ease;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: white;
      border: none;
      font-family: 'GE_SS_Two_Medium', sans-serif;
      cursor: pointer;
      width: 100%;
      font-weight: 600;
      box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
    }

    .btn-submit:hover {
      background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(37, 99, 235, 0.5);
    }

    /* الفوتر المحسن */
    footer {
      background: rgba(15, 23, 42, 0.95);
      padding: 40px 0;
      text-align: center;
      margin-top: 80px;
      border-top: 1px solid rgba(37, 99, 235, 0.3);
      border-radius: var(--radius) var(--radius) 0 0;
      position: relative;
      backdrop-filter: blur(12px);
    }

    footer::before {
      content: '';
      position: absolute;
      top: -5px;
      left: 50%;
      transform: translateX(-50%);
      width: 80%;
      height: 5px;
      background: linear-gradient(to right, var(--primary-color), var(--accent-color));
      border-radius: 5px;
    }

    footer p {
      font-size: 1.2rem;
      color: var(--accent-color);
    }

    /* التأثيرات */
    @keyframes float {
      0% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-25px);
      }
      100% {
        transform: translateY(0px);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7);
      }
      70% {
        box-shadow: 0 0 0 20px rgba(37, 99, 235, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
      }
    }

    /* التكيف مع الشاشات الصغيرة */
    @media (max-width: 1200px) {
      .hero-content {
        flex-direction: column-reverse;
        text-align: center;
      }
      .hero-text {
        margin-top: 50px;
      }
      .about-content {
        flex-direction: column;
      }
      .profile-img {
        width: 320px;
        height: 320px;
      }
      .hero-text h1 {
        font-size: 3.2rem;
      }
      .contact-container {
        flex-direction: column;
      }
      .section-title h2 {
        font-size: 2.4rem;
      }
    }

    @media (max-width: 768px) {
      .nav-links {
        display: none;
      }
      .section-title h2 {
        font-size: 2.1rem;
      }
      .hero-text h1 {
        font-size: 2.5rem;
      }
      .title {
        font-size: 1.5rem;
      }
      .mobile-menu-btn {
        display: block;
        font-size: 1.8rem;
        color: white;
        background: none;
        border: none;
        cursor: pointer;
      }
      .personal-info-item {
        padding: 20px;
      }
      .form-contact {
        padding: 30px;
      }
    }

    @media (max-width: 480px) {
      .hero-text h1 {
        font-size: 2rem;
      }
      .profile-img {
        width: 280px;
        height: 280px;
      }
      .section-title h2 {
        font-size: 1.8rem;
      }
      .contact-icon {
        width: 60px;
        height: 60px;
        font-size: 1.4rem;
      }
      .social-link {
        width: 65px;
        height: 65px;
        font-size: 1.8rem;
      }
    }
  </style>
</head>

<body>
  <!-- الترويسة -->
  <header id="header">
    <div class="container">
      <nav>
        <div class="logo">
          <i class="fas fa-code"></i>
          <span>هكـتُور</span>
        </div>
        <ul class="nav-links">
          <li><a href="#home" class="active">الرئيسية</a></li>
          <li><a href="#about">نبذة عني</a></li>
          <li><a href="#qualifications">مؤهلاتي</a></li>
          <li><a href="#aspirations">طموحاتي</a></li>
          <li><a href="#projects">مشاريعي</a></li>
          <li><a href="#skills">المهارات</a></li>
          <li><a href="#contact">التواصل</a></li>
        </ul>
        <button class="mobile-menu-btn">
          <i class="fas fa-bars"></i>
        </button>
      </nav>
    </div>
  </header>

  <!-- القسم الرئيسي -->
  <section class="hero" id="home">
    <div class="container">
      <div class="hero-content">
        <div class="hero-image">
          <div class="profile-img">
            <?php
            $query = "SELECT * FROM information ORDER BY created_at DESC LIMIT 1";
            $result = mysqli_query($conn, $query);
            if ($row = mysqli_fetch_assoc($result)) {
              echo '<img src="../uploads/image/' . $row['image'] . '" alt="الصورة الشخصية">';
            }
            ?>
          </div>
        </div>
        <div class="hero-text">
          <h1>الشارحي <span>هكـتُور</span></h1>
          <div class="title">مطور ويب مبتدىء</div>
          <p>أنا مطور ويب متخصص في إنشاء تطبيقات ويب حديثة وسريعة الاستجابة. أعمل مع أحدث التقنيات لتقديم حلول رقمية مبتكرة.</p>
          <div class="hero-brief">
            <p>أمتلك خبرة جيدة  في تطوير الويب، تخصصت في React وNode.js. أسعى لخلق تجارب مستخدم استثنائية مع أفضل ممارسات البرمجة.</p>
          </div>
          <a href="#contact" class="btn">تواصل معي <i class="fas fa-arrow-left"></i></a>
        </div>
      </div>
    </div>

    <!-- قسم المعلومات الشخصية -->
    <div class="container">
      <div class="personal-info-grid">
        <?php
        $query = "SELECT * FROM information ORDER BY created_at DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
        ?>
          <div class="personal-info-item">
            <div class="personal-info-icon">
              <i class="fas fa-user"></i>
            </div>
            <div class="personal-info-content">
              <h4>الاسم الكامل</h4>
              <p><?= $row['name'] ?></p>
            </div>
          </div>

          <div class="personal-info-item">
            <div class="personal-info-icon">
              <i class="fas fa-phone"></i>
            </div>
            <div class="personal-info-content">
              <h4>الهاتف</h4>
              <p><?= $row['phone'] ?></p>
            </div>
          </div>

          <div class="personal-info-item">
            <div class="personal-info-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="personal-info-content">
              <h4>البريد الإلكتروني</h4>
              <p><?= $row['email'] ?></p>
            </div>
          </div>

          <div class="personal-info-item">
            <div class="personal-info-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="personal-info-content">
              <h4>العنوان</h4>
              <p><?= $row['address'] ?></p>
            </div>
          </div>

          <div class="personal-info-item">
            <div class="personal-info-icon">
              <i class="fas fa-calendar"></i>
            </div>
            <div class="personal-info-content">
              <h4>تاريخ الميلاد</h4>
              <p><?= $row['birthdate'] ?></p>
            </div>
          </div>
        <?php
        } else {
          echo "<p>لا توجد معلومات متاحة</p>";
        }
        ?>
      </div>
    </div>
  </section>

  <!-- نبذة عني -->
  <section id="about">
    <div class="container">
      <div class="section-title">
        <h2>نبذة عني</h2>
      </div>
      <div class="about-content">
        <div class="about-text">
          <h3>من أنا؟</h3>
          <p>أنا ضيف الله الشارحي، مطور ويب شغوف بالتقنية. أتمتع بخبرة في تطوير مواقع وتطبيقات ويب متكاملة وحلول فعّالة.</p>
          <h3>رؤيتي</h3>
          <p>أسعى لإنشاء حلول رقمية تواكب العصر وتترك أثراً إيجابياً في المجتمع.</p>
          <h3>مبادئي</h3>
          <p>الجودة، الإبداع، الالتزام بالمواعيد، والاهتمام بأدق التفاصيل هي أساس عملي في كل مشروع.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- مؤهلاتي   -->
  <section id="qualifications">
    <div class="container">
      <div class="section-title">
        <h2>مؤهلاتي</h2>
      </div>
      <div class="projects-grid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM qualifications");
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="project-card">';
          echo '<div class="project-image">';
          echo '<img src="../uploads/qualification/' . $row['image'] . '" alt="' . $row['qualification_title'] . '">';
          echo '</div>';
          echo '<div class="project-content">';
          echo '<h3>' . $row['qualification_title'] . '</h3>';
          echo '<p>' . $row['qualification_description'] . '</p>';
          if (!empty($row['qualification_tags'])) {
            echo '<div class="project-tags">';
            $tags = explode(',', $row['qualification_tags']);
            foreach ($tags as $tag) {
              echo '<span class="project-tag">' . trim($tag) . '</span>';
            }
            echo '</div>';
          }
          echo '</div></div>';
        }
        ?>
      </div>
    </div>
  </section>

  <!-- طموحاتي -->
  <section id="aspirations">
    <div class="container">
      <div class="section-title">
        <h2>طموحاتي</h2>
      </div>
      <div class="aspirations-content">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM ambitions");
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="aspiration-item">';
          echo '<div class="aspiration-icon"><i class="' . $row['icon_url'] . '"></i></div>';
          echo '<div>';
          echo '<h4>' . $row['ambitions_title'] . '</h4>';
          echo '<p>' . $row['ambitions_description'] . '</p>';
          echo '</div></div>';
        }
        ?>
      </div>
    </div>
  </section>
  
  
  <!-- مشاريعي -->
  <section id="projects">
    <div class="container">
      <div class="section-title">
        <h2>مشاريعي</h2>
      </div>
      <div class="projects-grid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM projects ORDER BY created_at DESC");
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="project-card">';
          echo '<div class="project-image">';
          echo '<img src="../uploads/project/' . $row['image'] . '" alt="' . $row['project_title'] . '">';
          echo '</div>';
          echo '<div class="project-content">';
          echo '<h3>' . $row['project_title'] . '</h3>';
          echo '<p>' . $row['project_description'] . '</p>';
          if (!empty($row['project_tags'])) {
            echo '<div class="project-tags">';
            $tags = explode(',', $row['project_tags']);
            foreach ($tags as $tag) {
              echo '<span class="project-tag">' . trim($tag) . '</span>';
            }
            echo '</div>';
          }
          echo '</div></div>';
        }
        ?>
      </div>
    </div>
  </section>

  <!-- المهارات -->
  <section id="skills">
    <div class="container">
      <div class="section-title"><h2>المهارات</h2></div>
      <div class="skills-container">
        <?php 
        $categories = $conn->query("SELECT * FROM skill_categories");
        while ($cat = $categories->fetch_assoc()): 
        ?>
          <div class="skill-category">
            <h3><i class="fas fa-laptop-code"></i> <?= htmlspecialchars($cat['category_name']) ?></h3>
            <?php
              $skills = $conn->prepare("SELECT * FROM skills WHERE category_id = ?");
              $skills->bind_param("i", $cat['id']);
              $skills->execute();
              $result = $skills->get_result();
              while ($skill = $result->fetch_assoc()):
            ?>
              <div class="skill-item">
                <div class="skill-info">
                  <span><?= htmlspecialchars($skill['skill_name']) ?></span>
                  <span><?= $skill['percentage'] ?>%</span>
                </div>
                <div class="skill-bar">
                  <div class="skill-progress" style="width: <?= $skill['percentage'] ?>%;"></div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>

  <!-- التواصل -->
  <section id="contact">
    <div class="container">
      <div class="section-title">
        <h2>التواصل</h2>
      </div>
      <div class="contact-container">
        <?php
        $query = "SELECT * FROM information ORDER BY created_at DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
        ?>
          <div class="contact-info">
            <h3>بيانات التواصل</h3>
            <div class="contact-item">
              <div class="contact-icon"><i class="fas fa-envelope"></i></div>
              <div>
                <h4>البريد</h4>
                <p><?= htmlspecialchars($row['email']) ?></p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon"><i class="fas fa-phone"></i></div>
              <div>
                <h4>الهاتف</h4>
                <p><?= htmlspecialchars($row['phone']) ?></p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
              <div>
                <h4>الموقع</h4>
                <p><?= htmlspecialchars($row['address']) ?></p>
              </div>
            </div>
          </div>
        <?php } ?>
        
        <div class="form-contact-info">
          <form action="../messages_contact/send_message.php" method="POST" class="form-contact">
            <input type="text" name="name" class="form-control" placeholder="الاسم" required>
            <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني" required>
            <input type="text" name="subject" class="form-control" placeholder="الموضوع" required>
            <textarea name="message" class="form-control" placeholder="رسالتك" required></textarea>
            <div class="btn-group">
              <button type="submit" class="btn-submit">إرسال <i class="fas fa-paper-plane"></i></button>
            </div>
          </form>
        </div>
      </div>

      <?php
      $query_links = "SELECT * FROM contact ORDER BY created_at DESC LIMIT 1";
      $result_links = mysqli_query($conn, $query_links);
      if ($row_links = mysqli_fetch_assoc($result_links)) {
      ?>
        <div class="social-links">
          <a href="<?= $row_links['whatsapp_url'] ?>" class="social-link whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
          <a href="<?= $row_links['facebook_url'] ?>" class="social-link facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a href="<?= $row_links['telegram_url'] ?>" class="social-link telegram" target="_blank"><i class="fab fa-telegram"></i></a>
          <a href="<?= $row_links['instagram_url'] ?>" class="social-link instagram" target="_blank"><i class="fab fa-instagram"></i></a>
          <a href="<?= $row_links['threads_url'] ?>" class="social-link threads" target="_blank"><i class="fab fa-threads"></i></a>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- الفوتر -->
  <footer>
    <div class="container">
      <p>جميع الحقوق محفوظة &copy; <span id="current-year"></span> | تصميم وتطوير هكـتُور</p>
    </div>
  </footer>

  <!-- زر فتح لوحة التحكم -->
  <div class="dashboard-toggle" id="dashboardToggle">
    <i class="fas fa-cog"></i>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // تحديث سنة حقوق النشر
      document.getElementById('current-year').textContent = new Date().getFullYear();

      // التمرير السلس للروابط
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            window.scrollTo({
              top: target.offsetTop - 70,
              behavior: 'smooth'
            });
          }
        });
      });

      // تغيير لون الترويسة عند التمرير
      window.addEventListener('scroll', function() {
        const header = document.getElementById('header');
        if (window.scrollY > 100) {
          header.classList.add('scrolled');
        } else {
          header.classList.remove('scrolled');
        }
      });

      // ظهور العناصر عند التمرير
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, {
        threshold: 0.1
      });

      document.querySelectorAll('.project-card, .aspiration-item, .skill-category').forEach(item => {
        observer.observe(item);
      });

      // فتح لوحة التحكم
      document.getElementById('dashboardToggle').addEventListener('click', () => {
        window.location.href = 'public/login.php';
      });
      
      // تحريك أشرطة المهارات عند ظهورها
      const skillBars = document.querySelectorAll('.skill-progress');
      const skillObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const bar = entry.target;
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
              bar.style.width = width;
            }, 300);
          }
        });
      }, {
        threshold: 0.2
      });
      
      skillBars.forEach(bar => {
        skillObserver.observe(bar);
      });
    });
  </script>
</body>
</html>