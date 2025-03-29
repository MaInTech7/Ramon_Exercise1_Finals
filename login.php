<?php
session_start();

$msg = '';
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $msg = "All fields are required!";
    } else {
        $query = "SELECT * FROM `users` WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                if ($row['user_type'] == 'user') {
                    $_SESSION['user'] = $row['email'];
                    $_SESSION['id'] = $row['id'];
                    header('location:user.php');
                } elseif ($row['user_type'] == 'admin') {
                    $_SESSION['admin'] = $row['email'];
                    $_SESSION['id'] = $row['id'];
                    header('location:admin.php');
                }
            } else {
                $msg = "Incorrect email or password!";
            }
        } else {
            $msg = "Incorrect email or password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login</h2>
                        <p class="text-danger text-center"><?= $msg ?></p>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary w-100">Login Now</button>
                        </form>
                        <p class="text-center mt-3">Don't have an Account? <a href="signup.php">Sign Up Now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
