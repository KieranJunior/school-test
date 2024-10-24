<?php
session_start(); // Start the session
if (isset($_SESSION["user"])) {
    header("Location: search.php");
    exit(); // Use exit() to ensure no further code is executed
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Link to a custom stylesheet -->
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            require_once('database.php');
            $sql = "SELECT * FROM login_data WHERE email = '$email' ";
            $result = mysqli_query($con, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            // Check if user exists
            if ($user) {
                // Verify the password
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user"] = "yes"; // Set session variable
                    header("Location: search.php");
                    exit(); // Stop further execution
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>"; // Wrong password
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>"; // Email not found
            }
        }
        ?>
        
        <!-- Change action to submit to the same page -->
        <form action="" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit" required>
            </div>
        </form>
        <div><p>Create an account <a href="registration.php">Register here</a></p></div>
        
    </div>
</body>
</html>