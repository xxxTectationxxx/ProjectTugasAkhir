<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once __DIR__ . '/config/config.php';

$room_id = $_GET['id'];
$room = $conn->query("SELECT * FROM Rooms WHERE id = $room_id")->fetch_assoc();
$images = $conn->query("SELECT image_path FROM RoomImages WHERE room_id = $room_id")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kamar - TriUpasedanaHouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
    .room-detail-image {
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    .carousel-inner {
        max-height: 400px;
        border-radius: 10px;
        overflow: hidden;
    }

    .carousel-item img {
        object-fit: cover;
        height: 400px;
        width: 100%;
        border-radius: 10px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.6); /* Darken background */
        border-radius: 50%;
        padding: 15px;
        transition: all 0.3s ease-in-out;
    }

    .carousel-control-prev-icon:hover,
    .carousel-control-next-icon:hover {
        background-color: rgba(0, 0, 0, 0.9);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }

    .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .card-body h5,
    .card-body p {
        color: #333;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

</head>
<body>
    <?php include __DIR__ . '/includes/user_nav.php'; ?>

    <div class="container mt-4">
        <h2>Detail Kamar: <?php echo $room['name']; ?></h2>
        <div class="card">
            <div id="roomCarousel<?php echo $room['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="admin/uploads/<?php echo $room['image']; ?>" class="d-block w-100 room-detail-image" alt="Kamar">
                    </div>
                    <?php foreach ($images as $index => $image): ?>
                        <div class="carousel-item">
                            <img src="admin/uploads/<?php echo $image['image_path']; ?>" class="d-block w-100 room-detail-image" alt="Gambar Kamar">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel<?php echo $room['id']; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel<?php echo $room['id']; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $room['name']; ?></h5>
                <p class="card-text"><?php echo $room['description']; ?></p>
                <p class="card-text"><strong>Harga:</strong> Rp <?php echo number_format($room['price'], 2); ?></p>
                <p class="card-text"><strong>Kapasitas:</strong> <?php echo $room['capacity']; ?> orang</p>
                <a href="dashboard.php#rooms-comments" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>