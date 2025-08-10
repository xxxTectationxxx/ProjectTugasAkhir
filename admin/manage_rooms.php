<?php include '../includes/admin_nav.php' ?>

<div class="mb-5">
    <h2>Kelola Kamar</h2>
    <form method="POST" action="add_room.php" enctype="multipart/form-data" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Nama Kamar" required>
            </div>
            <div class="col-md-6">
                <input type="number" name="price" class="form-control" placeholder="Harga" step="0.01" required>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <input type="number" name="capacity" class="form-control" placeholder="Kapasitas" required>
            </div>
            <div class="col-md-6">
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                <small class="text-muted">Upload minimal 1 gambar utama dan tambahan (opsional)</small>
            </div>
        </div>
        <textarea name="description" class="form-control mt-2" placeholder="Deskripsi Kamar" rows="3"></textarea>
        <button type="submit" class="btn btn-primary mt-2">Tambah Kamar</button>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kapasitas</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT id, name, price, capacity, image FROM Rooms");
            while ($row = $result->fetch_assoc()) {
                $images = $conn->query("SELECT image_path FROM RoomImages WHERE room_id = {$row['id']}")->fetch_all(MYSQLI_ASSOC);
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . $row['name'] . "</td>
                        <td>{$row['price']}</td>
                        <td>{$row['capacity']}</td>
                        <td>";
                if ($row['image']) {
                    echo "<img src='uploads/" . $row['image'] . "' width='50' class='me-2'>";
                }
                foreach ($images as $image) {
                    echo "<img src='uploads/" . $image['image_path'] . "' width='50' class='me-2'>";
                }
                echo "</td>
                        <td>
                            <a href='edit_room.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete_room.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus kamar?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>