<?php 
include '../includes/admin_nav.php' 
?>

<div class="mb-5">
    <h2>Setujui Pemesanan</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pengguna</th>
                <th>Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT p.id, u.username, r.name, p.checkin_date, p.checkout_date
                                    FROM Pemesanan p
                                    JOIN Users u ON p.user_id = u.id
                                    JOIN Rooms r ON p.room_id = r.id
                                    WHERE p.status = 'pending'");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>{$row['checkin_date']}</td>
                        <td>{$row['checkout_date']}</td>
                        <td>
                            <a href='process/approve_booking.php?id={$row['id']}' class='btn btn-sm btn-success'>Setujui</a>
                            <a href='process/cancel_booking.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin batalkan pemesanan?\")'>Batalkan</a>
                        </td>
                      </tr>";
            }
            ?>
            
            <!-- harderning -->
            <!-- <td>" . htmlspecialchars($row['username']) . "</td> -->
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>