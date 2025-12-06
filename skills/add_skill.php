<?php
include '../public/db_connect.php';

// إضافة الفئة
if (isset($_POST['add_category'])) {
  $cat_name = $_POST['category_name'];
  $stmt = $conn->prepare("INSERT INTO skill_categories (category_name) VALUES (?)");
  $stmt->bind_param("s", $cat_name);
  $stmt->execute();
  header("Location: list_skills.php");
}

// إضافة مهارة فرعية
if (isset($_POST['add_skill'])) {
  $cat_id = $_POST['category_id'];
  $skill = $_POST['skill_name'];
  $percent = $_POST['percentage'];
  $stmt = $conn->prepare("INSERT INTO skills (category_id, skill_name, percentage) VALUES (?, ?, ?)");
  $stmt->bind_param("isi", $cat_id, $skill, $percent);
  $stmt->execute();
  echo "تمت إضافة المهارة<br>";
}
?>