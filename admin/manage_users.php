<?php include '../includes/admin_nav.php' ?>

<div class="mb-5">
    <h2>Manajemen Pengguna</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT id, username, email, role FROM Users");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['role'] . "</td>
                        <td>
                            <a href='edit_user.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete_user.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus pengguna?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
            ?>

            <!-- Harderning : 
            <td>" . htmlspecialchars($row['username']) . "</td> -->
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>