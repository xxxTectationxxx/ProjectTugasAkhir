<?php
$conn = new mysqli("localhost", "root", "", "triupasedanahouse");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>