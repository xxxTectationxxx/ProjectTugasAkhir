<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

require_once __DIR__ . '/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $profile_photo = 'uploads/default-profile.jpg';
    if (!empty($_FILES['profile_photo']['name'])) {
        $photo = basename($_FILES['profile_photo']['name']);
        $target = "uploads/" . $photo;
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target)) {
            $profile_photo = $photo;
        }
    }
    $conn->query("INSERT INTO Users (username, email, password_hash, role, profile_photo) VALUES ('$name', '$email', '$password', 'user', '$profile_photo')");
    header("Location: index.php?success=Registrasi berhasil, silakan login");
    exit();
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
                            <h1 class="fs-4 card-title fw-bold mb-4">Register</h1>
                            <?php if (isset($_GET['success'])) echo "<div class='alert alert-success'>" . $_GET['success'] . "</div>"; ?>
                            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" autocomplete="off">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="name">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="" required autofocus />
                                    <div class="invalid-feedback">Name is required</div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="" required />
                                    <div class="invalid-feedback">Email is invalid</div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required />
                                    <div class="invalid-feedback">Password is required</div>
                                </div>
                                <p class="form-text text-muted mb-3">By registering you agree with our terms and condition.</p>
                                <div class="align-items-center d-flex">
                                    <button type="submit" class="btn btn-primary ms-auto">Register</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                Already have an account? <a href="index.php" class="text-dark">Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-muted">Copyright © <?php echo date('Y'); ?> — TriUpasedanaHouse</div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>

<?php $conn->close(); ?>