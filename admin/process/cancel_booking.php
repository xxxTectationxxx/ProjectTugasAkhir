<?php
require_once '../../config/config.php';

if (isset($_GET['id'])) {
    $booking_id = (int)$_GET['id'];
    $sql = "UPDATE Pemesanan SET status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        $message = "Pemesanan berhasil dibatalkan!";
        $success = true;
    } else {
        $message = "Gagal membatalkan pemesanan.";
        $success = false;
    }
    $stmt->close();
} else {
    $message = "ID pemesanan tidak valid.";
    $success = false;
}

$conn->close();
header("Location: ../approve_bookings.php?message=" . urlencode($message) . "&success=" . ($success ? '1' : '0'));
exit();
?>