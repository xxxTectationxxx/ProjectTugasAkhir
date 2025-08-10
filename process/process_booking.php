<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $room_id = $conn->real_escape_string($_POST['room_id']);
    $checkin_date = $conn->real_escape_string($_POST['checkin_date']);
    $checkout_date = $conn->real_escape_string($_POST['checkout_date']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $identity_type = $conn->real_escape_string($_POST['identity_type']);
    $identity_number = $conn->real_escape_string($_POST['identity_number']);
    $country = $conn->real_escape_string($_POST['country']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $address = $conn->real_escape_string($_POST['address']);

    $conn->query("INSERT INTO Pemesanan (user_id, room_id, full_name, identity_type, identity_number, country, phone_number, address, checkin_date, checkout_date, status)
                  VALUES ('$user_id', '$room_id', '$full_name', '$identity_type', '$identity_number', '$country', '$phone_number', '$address', '$checkin_date', '$checkout_date', 'pending')");
    header("Location: ../dashboard.php?tab=home&success=Pemesanan berhasil dibuat");
    exit();
}

$conn->close();
?>