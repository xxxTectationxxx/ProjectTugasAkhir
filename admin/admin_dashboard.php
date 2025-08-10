<?php include '../includes/admin_nav.php' ?>
   <div class="container mt-4">
    <div class="row">
        <!-- Statistik Kartu -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <?php
                    $user_count = $conn->query("SELECT COUNT(*) as count FROM Users")->fetch_assoc()['count'];
                    echo "<h3 class='card-text'>$user_count</h3>";
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Pemesanan</h5>
                    <?php
                    $booking_count = $conn->query("SELECT COUNT(*) as count FROM Pemesanan")->fetch_assoc()['count'];
                    echo "<h3 class='card-text'>$booking_count</h3>";
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Kamar</h5>
                    <?php
                    $room_count = $conn->query("SELECT COUNT(*) as count FROM Rooms")->fetch_assoc()['count'];
                    echo "<h3 class='card-text'>$room_count</h3>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Selamat Datang -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Selamat Datang, Admin!</h2>
            <p class="card-text">Hari ini adalah <?php echo date('l, d F Y, H:i A', strtotime('05:42 PM WIB')); ?> WIB. Kelola hotel Anda dengan mudah melalui dashboard ini.</p>
            <p class="card-text">Gunakan menu di atas untuk mengelola pengguna, pemesanan, dan kamar. Pastikan semua data diperbarui secara berkala.</p>
        </div>
    </div>

    <!-- Pemesanan Terbaru -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Pemesanan Terbaru</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pengguna</th>
                        <th>Kamar</th>
                        <th>Check-in</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT p.id, u.username, r.name, p.checkin_date, p.status
                                            FROM Pemesanan p
                                            JOIN Users u ON p.user_id = u.id
                                            JOIN Rooms r ON p.room_id = r.id
                                            ORDER BY p.created_at DESC LIMIT 5");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . $row['username'] . "</td>
                                <td>" . $row['name'] . "</td>
                                <td>{$row['checkin_date']}</td>
                                <td>" . $row['status'] . "</td>
                              </tr>";
                    }

                    // Harderning : <td>" . htmlspecialchars($row['username']) . "</td>
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


