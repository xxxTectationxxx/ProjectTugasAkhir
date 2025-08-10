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
$room = $conn->query("SELECT * FROM Rooms WHERE id = $id")->fetch_assoc();
$existing_images = $conn->query("SELECT image_path FROM RoomImages WHERE room_id = $id")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $capacity = $conn->real_escape_string($_POST['capacity']);
    $description = $conn->real_escape_string($_POST['description']);

    // Handle main image
    $main_image = $room['image'];
    if (!empty($_FILES['images']['name'][0])) {
        $new_main_image = basename($_FILES['images']['name'][0]);
        $target_main = "uploads/" . $new_main_image;
        if (move_uploaded_file($_FILES['images']['tmp_name'][0], $target_main)) {
            $main_image = $new_main_image;
        }
    }
    $conn->query("UPDATE Rooms SET name = '$name', description = '$description', price = '$price', capacity = '$capacity', image = '$main_image' WHERE id = $id");

    // Handle additional images
    for ($i = 1; $i < count($_FILES['images']['name']); $i++) {
        $image = basename($_FILES['images']['name'][$i]);
        $target = "uploads/" . $image;
        if ($image && move_uploaded_file($_FILES['images']['tmp_name'][$i], $target)) {
            $conn->query("INSERT INTO RoomImages (room_id, image_path) VALUES ('$id', '$image')");
        }
    }
    header("Location: manage_rooms.php?success=Kamar diperbarui");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Kamar</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Kamar</label>
                <input type="text" name="name" class="form-control" value="<?php echo $room['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" value="<?php echo $room['price']; ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="capacity" class="form-control" value="<?php echo $room['capacity']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"><?php echo $room['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Utama</label>
                <input type="file" name="images[]" class="form-control" accept="image/*">
                <?php if ($room['image']) echo "<img src='uploads/" . $room['image'] . "' width='100' class='mt-2'>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Tambahan</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                <?php foreach ($existing_images as $image) echo "<img src='uploads/" . $image['image_path'] . "' width='100' class='mt-2 me-2'>"; ?>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="manage_rooms.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>