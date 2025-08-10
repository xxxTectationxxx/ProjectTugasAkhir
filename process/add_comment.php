<!-- <?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $message = $conn->real_escape_string($_POST['message']);
    $conn->query("INSERT INTO Comments (user_id, message) VALUES ('$user_id', '$message')");
    header("Location: ../dashboard.php?tab=comments&success=Komentar berhasil ditambahkan");
    exit();
}

$conn->close();
?> -->