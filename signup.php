<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include './include/db.php';

    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // check if user exists
    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1){
        $showError = "Username Already Exists";
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password_hash);

        if ($stmt->execute()) {
            // Successful signup

            $user_id = $stmt->insert_id;    // last insert id

            include './include/session.php';
            // set session
            setUserLoggedIn($user_id, $username);
            // redirect
            header("location: index.php");
        } else {
            // Signup failed
            $showError = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './components/header.php';?>
    <title>Sign Up</title>
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
                <h2>Sign Up</h2>
                <form action="signup.php" method="post">
                    <div class="mb-3 form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" minlength="3" maxlength="12" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" minlength="3" maxlength="12" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
                <a class="text-dark" href="login.php">Already have an account? Login here!</a>
            </div>
        </div>
    </div>
    <?php include './components/footer.php';?>
</body>

</html>