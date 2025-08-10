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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $capacity = $conn->real_escape_string($_POST['capacity']);
    $description = $conn->real_escape_string($_POST['description']);

    if (empty($_FILES['images']['name'][0])) {
        header("Location: manage_rooms.php?error=Minimal satu gambar harus diunggah");
        exit();
    }

    // Insert ke tabel Rooms dengan image utama
    $main_image = basename($_FILES['images']['name'][0]);
    $target_main = "uploads/" . $main_image;
    if (move_uploaded_file($_FILES['images']['tmp_name'][0], $target_main)) {
        $conn->query("INSERT INTO Rooms (name, description, price, capacity, image) VALUES ('$name', '$description', '$price', '$capacity', '$main_image')");
    } else {
        header("Location: manage_rooms.php?error=Gagal mengunggah gambar utama");
        exit();
    }
    $room_id = $conn->insert_id;

    // Tambahkan gambar tambahan ke RoomImages
    for ($i = 1; $i < count($_FILES['images']['name']); $i++) {
        $image = basename($_FILES['images']['name'][$i]);
        $target = "uploads/" . $image;
        if ($image && move_uploaded_file($_FILES['images']['tmp_name'][$i], $target)) {
            $conn->query("INSERT INTO RoomImages (room_id, image_path) VALUES ('$room_id', '$image')");
        } else {
            // Opsional: Lanjutkan meskipun ada gambar tambahan yang gagal
        }
    }
    header("Location: manage_rooms.php?success=Kamar ditambahkan");
    exit();
}

$conn->close();
?>