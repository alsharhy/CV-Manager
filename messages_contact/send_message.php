
<?php
include("../public/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $subject = mysqli_real_escape_string($conn, $_POST['subject']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  $sql = "INSERT INTO messages (name, email, subject, message)
          VALUES ('$name', '$email', '$subject', '$message')";

  if (mysqli_query($conn, $sql)) {
    $notif_title = " رسالة جديدة من $name";
$notif_message = "الموضوع: $subject\nالبريد: $email\nالرسالة:\n$message";
$conn->query("INSERT INTO notifications (title, message) VALUES ('$notif_title', '$notif_message')");
  header('Location: ../public/index.php');
  } else {
    echo "حدث خطأ أثناء الإرسال: " . mysqli_error($conn);
  }
}
?>

