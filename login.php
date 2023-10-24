<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include './include/db.php';

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user data from the database
    $sql = "SELECT user_id, username, password_hash FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $db_username, $db_password);
        $stmt->fetch();

        if (password_verify($password, $db_password)) {
            // Successful login
            // set session
            include './include/session.php';
            setUserLoggedIn($user_id, $username);
            // redirect
            header("location: index.php");
        } else {
            // Incorrect password
            $showError = "Incorrect Password";
        }
    } else {
        // User not found
        $showError = "User not found";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './components/header.php'; ?>
    <title>Login</title>
</head>

<body>
    <?php include './components/navbar.php'; ?>
    <?php if ($showError) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> <?= $showError ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="container my-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Login to continue!</h2>
                <form id="login-form" action="login.php" method="post">
                    <div class="mb-3 form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Log In</button>
                </form>
                <a class="text-dark" href="signup.php">Don't have an account? SignUp here!</a>
            </div>
        </div>
    </div>
    <?php include './components/footer.php'; ?>
    <!-- <script src="assests/js/login.js"></script> -->
</body>

</html>