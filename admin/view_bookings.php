<?php include '../includes/admin_nav.php' ?>
<div class="mb-5">
    <h2>Data Pemesanan</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pengguna</th>
                <th>Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>No. Identitas</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT p.id, u.username, r.name, p.checkin_date, p.checkout_date, p.status, p.identity_number, p.address
                                    FROM Pemesanan p
                                    JOIN Users u ON p.user_id = u.id
                                    JOIN Rooms r ON p.room_id = r.id");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>{$row['checkin_date']}</td>
                        <td>{$row['checkout_date']}</td>
                        <td>" . $row['status'] . "</td>
                        <td>" . $row['identity_number'] . "</td>
                        <td>" . $row['address'] . "</td>
                      </tr>";
            }
            ?>

            <!-- Harderning : 
            <td>" . htmlspecialchars($row['username']) . "</td> -->
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>