<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "triupasedanahouse");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$conn->query("DELETE FROM RoomImages WHERE room_id = $id");
$conn->query("DELETE FROM Rooms WHERE id = $id");
header("Location: manage_rooms.php?success=Kamar dihapus");
exit();

$conn->close();
?>