<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: index.php");
        exit();
    }
}

$conn = new mysqli("localhost", "root", "", "triupasedanahouse");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM Users WHERE email = '$email'");
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password_hash']) && $row['role'] == 'admin') {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header("Location: admin_dashboard.php");
            exit();
        }
    }
    $error = "Invalid email or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="description" content="Admin login page for TriUpasedanaHouse" />
    <title>Admin Login - TriUpasedanaHouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; border-radius: 10px; }
        .card-title { color: #1a3c34; }
        .btn-primary { background-color: #1a3c34; border-color: #1a3c34; }
        .btn-primary:hover { background-color: #14302a; border-color: #14302a; }
    </style>
</head>
<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                    <div class="text-center my-5">
                        <img src="../assets/images/pisbolong.png" alt="logo" width="120" />
                    </div>
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4">Admin Login</h1>
                            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                            <form method="POST" class="needs-validation" novalidate="" autocomplete="off">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="" required autofocus />
                                    <div class="invalid-feedback">Email is invalid</div>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-2 w-100">
                                        <label class="mb-2 text-muted" for="password">Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" required />
                                    <div class="invalid-feedback">Password is required</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary ms-auto">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-muted">Copyright © <?php echo date('Y'); ?> — TriUpasedanaHouse</div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/login.js"></script>
</body>
</html>

<?php $conn->close(); ?>