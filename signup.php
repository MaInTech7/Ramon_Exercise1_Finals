<?php
session_start();
$msg = '';
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    if (empty($name) || empty($email) || empty($password) || empty($cpassword)) {
        $msg = "All fields are required!";
    } elseif ($password !== $cpassword) {
        $msg = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $_SESSION['email'] = $email;
        $_SESSION['user_type'] = $user_type;
        header('location:' . ($user_type === 'admin' ? 'admin.php' : 'user.php'));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Sign Up</h2>
                        <p class="text-danger text-center"><?= $msg ?></p>
                        <form action="signup.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_type" class="form-label">User Type</label>
                                <select name="user_type" id="user_type" class="form-select">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="cpassword" class="form-label">Confirm Password</label>
                                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm your password" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary w-100">Sign Up Now</button>
                        </form>
                        <p class="text-center mt-3">Already have an Account? <a href="signin.php">Login Now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
