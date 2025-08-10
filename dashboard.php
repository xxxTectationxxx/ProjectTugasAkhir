<?php
session_start();
if (empty($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

require_once __DIR__ . '/config/config.php';

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT username, email, profile_photo FROM Users WHERE id = $user_id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        // Proses update profil
        $new_username = $conn->real_escape_string($_POST['username']);
        $profile_photo = $user['profile_photo'];
        if (!empty($_FILES['profile_photo']['name'])) {
            $photo = basename($_FILES['profile_photo']['name']);
            $target = "uploads/" . $photo;
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target)) {
                $profile_photo = $photo;
                $_SESSION['profile_photo'] = $profile_photo;
            }
        }
        $conn->query("UPDATE Users SET username = '$new_username', profile_photo = '$profile_photo' WHERE id = $user_id");
        $_SESSION['username'] = $new_username;
        header("Location: dashboard.php?success=Profil diperbarui");
        exit();
    } elseif (isset($_POST['add_comment'])) {
        // Proses komentar
        $message = $conn->real_escape_string($_POST['message']);
        $conn->query("INSERT INTO Comments (user_id, message) VALUES ('$user_id', '$message')");
        header("Location: dashboard.php?success=Komentar berhasil ditambahkan");
        exit();
    } elseif (isset($_POST['edit_comment_id']) && isset($_POST['edit_message'])) {
        $comment_id = intval($_POST['edit_comment_id']);
        $new_message = $conn->real_escape_string($_POST['edit_message']);
        $cek = $conn->query("SELECT id FROM Comments WHERE id = $comment_id AND user_id = $user_id");
        if ($cek->num_rows > 0) {
            $conn->query("UPDATE Comments SET message = '$new_message' WHERE id = $comment_id");
            header("Location: dashboard.php?success=Komentar berhasil diubah#rooms-comments");
            exit();
        } else {
            header("Location: dashboard.php?error=Gagal mengedit komentar#rooms-comments");
            exit();
        }
    } elseif (isset($_POST['delete_comment_id'])) {
        $comment_id = intval($_POST['delete_comment_id']);
        $cek = $conn->query("SELECT id FROM Comments WHERE id = $comment_id AND user_id = $user_id");
        if ($cek->num_rows > 0) {
            $conn->query("DELETE FROM Comments WHERE id = $comment_id");
            header("Location: dashboard.php?success=Komentar berhasil dihapus#rooms-comments");
            exit();
        } else {
            header("Location: dashboard.php?error=Gagal menghapus komentar#rooms-comments");
            exit();
        }
    }


}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TriUpasedanaHouse - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .tab-content {
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .room-card {
            margin-bottom: 20px;
            transition: transform 0.2s;
            cursor: pointer;
        }
        .room-card:hover {
            transform: translateY(-5px);
        }
        .booking-table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        .room-image {
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        .modal-content img {
            max-width: 100%;
            height: auto;
        }
        .owl-carousel .item img {
            height: 200px;
            object-fit: cover;
        }
        .comment-card {
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #007bff;
        }
        .comment-card p {
            margin: 0 0 10px;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/includes/user_nav.php'; ?>

    <div class="container mt-4">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                <?php echo $_GET['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                // Tutup alert setelah 3 detik
                setTimeout(() => {
                    const alertBox = document.getElementById('successAlert');
                    if (alertBox) {
                        new bootstrap.Alert(alertBox).close();
                    }
                }, 3000);

                // Hapus parameter ?success dari URL agar tidak muncul lagi saat reload
                if (window.history.replaceState) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('success');
                    window.history.replaceState({}, document.title, url.toString());
                }
            </script>
        <?php endif; ?>


        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Beranda</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Edit Profil</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="book-tab" data-bs-toggle="tab" data-bs-target="#book" type="button" role="tab">Pesan Kamar</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rooms-comments-tab" data-bs-toggle="tab" data-bs-target="#rooms-comments" type="button" role="tab">Kamar & Komentar</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Beranda -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <?php
                            $foto_path = 'uploads/' . $user['profile_photo'];
                            if (!empty($user['profile_photo']) && file_exists($foto_path)) {
                                $foto = $foto_path;
                            } else {
                                $foto = 'uploads/default-profile.jpg';
                            }

                        ?>
                        <img src="<?php echo $foto; ?>" alt="Profile" class="rounded-circle profile-img" style="width: 150px; height: 150px; object-fit: cover;">
                        <h2 class="card-title mt-3">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>

                        <!-- // Harderning -->
                        <!-- <h2 class="card-title mt-3">Selamat Datang, < ?php echo htmlspecialchars($_SESSION['username']); ?>!</h2> -->
                        
                        <p class="card-text">Hari ini adalah <?php echo date('l, d F Y, H:i A'); ?> WIB. Jelajahi kamar kami dan nikmati pengalaman menginap yang nyaman.</p>
                    </div>
                </div>

                <div class="card booking-table mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Pemesanan Anda</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kamar</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query("SELECT p.id, r.name, p.checkin_date, p.checkout_date, p.status
                                                        FROM Pemesanan p
                                                        JOIN Rooms r ON p.room_id = r.id
                                                        WHERE p.user_id = $user_id
                                                        ORDER BY p.created_at DESC LIMIT 5");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>" . $row['name'] . "</td>
                                            <td>{$row['checkin_date']}</td>
                                            <td>{$row['checkout_date']}</td>
                                            <td>" . $row['status'] . "</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Profil -->
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                            $foto_path = 'uploads/' . $user['profile_photo'];
                            if (!empty($user['profile_photo']) && file_exists($foto_path)) {
                                $foto = $foto_path;
                            } else {
                                $foto = 'uploads/default-profile.jpg';
                            }
                        ?>
                        <img src="<?php echo $foto; ?>" alt="Profile" class="rounded-circle profile-img" style="width: 150px; height: 150px; object-fit: cover;">
                        <h2 class="card-title mt-3">Edit Profil</h2>
                        <form method="POST" enctype="multipart/form-data" class="mt-3">
                            <input type="hidden" name="update_profile" value="1">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
                                <!-- <input type="text" name="username" class="form-control" value="< ?php echo htmlspecialchars($user['username']); ?>" required> -->
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                                <small class="text-muted">Opsional, biarkan kosong untuk mempertahankan foto saat ini</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pesan Kamar -->
            <div class="tab-pane fade" id="book" role="tabpanel" aria-labelledby="book-tab">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Pesan Kamar</h2>
                        <form method="POST" action="process/process_booking.php" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Kamar</label>
                                <select name="room_id" class="form-control" required>
                                    <?php
                                    $result = $conn->query("SELECT id, name FROM Rooms");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>" . $row['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Check-in</label>
                                <input type="date" name="checkin_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Check-out</label>
                                <input type="date" name="checkout_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Identitas</label>
                                <select name="identity_type" class="form-control" required>
                                    <option value="KTP">KTP</option>
                                    <option value="PASPOR">Paspor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Identitas</label>
                                <input type="text" name="identity_number" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Negara</label>
                                <input type="text" name="country" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone_number" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Pesan Kamar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kamar & Komentar -->
            <div class="tab-pane fade" id="rooms-comments" role="tabpanel" aria-labelledby="rooms-comments-tab">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Lihat Kamar</h2>
                        <div class="row">
                            <?php
                            $result = $conn->query("SELECT r.id, r.name, r.description, r.price, r.image, r.capacity
                                                    FROM Rooms r");
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='col-md-4'>
                                        <div class='card room-card' data-bs-toggle='modal' data-bs-target='#imageModal' data-image='admin/uploads/" . $row['image'] . "'>
                                            <img src='admin/uploads/" . $row['image'] . "' class='room-image' alt='Kamar'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>" . $row['name'] . "</h5>
                                                <p class='card-text'><strong>Harga:</strong> Rp " . number_format($row['price'], 2) . "</p>
                                                <p class='card-text'><strong>Kapasitas:</strong> {$row['capacity']} orang</p>
                                                <a href='room_detail.php?id={$row['id']}' class='btn btn-primary'>View More</a>
                                            </div>
                                        </div>
                                      </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Komentar Anda</h2>
                        <form method="POST" action="" class="mb-4">
                            <input type="hidden" name="add_comment" value="1">
                            <div class="mb-3">
                                <label class="form-label">Komentar</label>
                                <textarea name="message" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                        </form>

                        <div class="comment-section">
                            <?php
                            $result = $conn->query("SELECT c.id, u.username, c.message, c.created_at
                                                    FROM Comments c
                                                    JOIN Users u ON c.user_id = u.id
                                                    ORDER BY c.created_at DESC");
                            if ($result && $result->num_rows > 0) {
                               while ($row = $result->fetch_assoc()) {
                                    $isOwner = $row['username'] === $_SESSION['username'];
                                    echo "<div class='comment-card w-100'>";
                                    echo "<h6 class='card-subtitle mb-2 text-muted'>Oleh: " . $row['username'] . " | " . date('d M Y H:i', strtotime($row['created_at'])) . "</h6>";
                                    // echo "<h6 class='card-subtitle mb-2 text-muted'>Oleh: " . htmlspecialchars($row['username']) . " | " . date('d M Y H:i', strtotime($row['created_at'])) . "</h6>";

                                    // Jika user adalah pemilik komentar & sedang mengedit
                                    if ($isOwner && isset($_GET['edit']) && $_GET['edit'] == $row['id']) {
                                        echo "<form method='POST'>
                                                <input type='hidden' name='edit_comment_id' value='{$row['id']}'>
                                                <textarea name='edit_message' class='form-control mb-2'>" . $row['message'] . "</textarea>
                                                <button type='submit' class='btn btn-success btn-sm'>Simpan</button>
                                                <a href='dashboard.php#rooms-comments' class='btn btn-secondary btn-sm'>Batal</a>
                                            </form>";
                                    } else {
                                        echo "<p class='card-text'>" . $row['message'] . "</p>";
                                        // echo "<p class='card-text'>" . htmlspecialchars($row['message']) . "</p>";
                                        if ($isOwner) {
                                            echo "<a href='dashboard.php?edit={$row['id']}#rooms-comments' class='btn btn-sm btn-outline-primary me-1'>Edit</a>";
                                            echo "<form method='POST' style='display:inline-block' onsubmit=\"return confirm('Yakin ingin menghapus komentar ini?');\">
                                                    <input type='hidden' name='delete_comment_id' value='{$row['id']}'>
                                                    <button type='submit' class='btn btn-sm btn-outline-danger'>Hapus</button>
                                                </form>";
                                        }
                                    }

                                    echo "</div>";
                                }
                            } else {
                                echo "<p class='text-center text-muted'>Belum ada komentar.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Pop-up Gambar -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="" id="modalImage" class="img-fluid" alt="Gambar Kamar">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var roomCards = document.querySelectorAll('.room-card');
            var modalImage = document.getElementById('modalImage');
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));

            roomCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    var imageSrc = this.getAttribute('data-image');
                    modalImage.src = imageSrc;
                    imageModal.show();
                });
            });

            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                responsive: {
                    0: { items: 1 },
                    600: { items: 2 },
                    1000: { items: 3 }
                }
            });
        });
    </script>
</body>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const hash = window.location.hash;
    if (hash) {
        const tabTrigger = document.querySelector(`button[data-bs-target="${hash}"]`);
        if (tabTrigger) {
            const tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }
});
</script>

</html>

<?php $conn->close(); ?>