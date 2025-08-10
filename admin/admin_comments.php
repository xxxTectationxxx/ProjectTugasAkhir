<?php include '../includes/admin_nav.php'; ?>

<h3 class="mt-4">Komentar Pengguna</h3>
<div class="card">
    <div class="card-body">
        <?php
        $sql = "SELECT c.id, u.username, c.message, c.created_at
                FROM Comments c
                JOIN Users u ON c.user_id = u.id
                ORDER BY c.created_at DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>No</th><th>Nama Pengguna</th><th>Komentar</th><th>Waktu</th></tr></thead><tbody>";
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['message']. "</td>
                        <td>" . date("d M Y H:i", strtotime($row['created_at'])) . "</td>
                      </tr>";
                $no++;
            }
            echo "</tbody></table></div>";
        } else {
            echo "<p class='text-muted'>Belum ada komentar.</p>";
        }

        // Hasil harderning 
        // <td>" . htmlspecialchars($row['username']) . "</td>
        // <td>" . htmlspecialchars($row['message']). "</td>

        $conn->close();
        ?>
    </div>
</div>

</div> <!-- tutup container dari admin_nav.php -->
</body>
</html>
