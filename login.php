<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center">Login</h3>
            <?php
            if (isset($_POST['login'])) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
                if ($result->num_rows > 0) {
                    $_SESSION['username'] = $username;
                    header("Location: dashboard.php");
                } else {
                    echo "<div class='alert alert-danger'>Login gagal!</div>";
                }
            }
            ?>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button name="login" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>