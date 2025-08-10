<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Cek apakah email tersedia untuk reset
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "triupasedanahouse");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['reset_email'];
    $password = $_POST['password'];
    $confirm = $_POST['password_confirm'];

    if ($password !== $confirm) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE Users SET password_hash = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            unset($_SESSION['reset_email']);
            header("Location: index.php?reset=success");
            exit();
        } else {
            $error = "Gagal mereset password. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="description" content="This is a login page template based on Bootstrap 5" />
    <title>Bootstrap 5 Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
</head>
<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                    <div class="text-center my-5">
                        <img src="assets/images/pisbolong.png" alt="logo" width="100" />
                    </div>
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4">Reset Password</h1>
                            <form method="POST" class="needs-validation" novalidate="" autocomplete="off">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="password">New Password</label>
                                    <input id="password" type="password" class="form-control" name="password" value="" required autofocus />
                                    <div class="invalid-feedback">Password is required</div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="password-confirm">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirm" required />
                                    <div class="invalid-feedback">Please confirm your new password</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" name="logout_devices" id="logout" class="form-check-input" />
                                        <label for="logout" class="form-check-label">Logout all devices</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary ms-auto">Reset Password</button>
                                </div>
                            </form>
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="text-center mt-5 text-muted">Copyright © 2025 — TriUpasedanaHouse</div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/login.js"></script>
</body>
</html>

<?php $conn->close(); ?>