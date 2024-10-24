<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Sets the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Makes the page responsive -->
    <title>Registration Form</title> <!-- Title of the page displayed in the browser tab -->
    <!-- Link to Bootstrap CSS for styling the form -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> <!-- Link to a custom stylesheet -->
</head>

<body>
    <div class="container"> <!-- Container for Bootstrap styling -->
        <?php
        // Check if the form is submitted by checking if the 'submit' button was clicked
        if (isset($_POST['submit'])) {
            // Get the input values from the form
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeat = $_POST["repeat_password"];

            // Encrypt the password for security
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Initialize an array to hold error messages
            $errors = array();

            // Validate that all fields are filled out
            if (empty($fullname) || empty($email) || empty($password) || empty($repeat)) {
                array_push($errors, "All fields are required");
            }
            // Validate the email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid"); // Error message for invalid email
            }
            // Check that the password is at least 8 characters long
            if (strlen($password) < 8) {
                array_push($errors, "Password MUST be minimum 8 characters"); // Error for short password
            }
            // Ensure the password and repeat password match
            if ($password !== $repeat) {
                array_push($errors, "Passwords must match"); // Error for mismatched passwords
            }

            // Include the database connection file
            require_once "database.php";
            // Prepare a SQL statement to check if the email already exists
            $sql = "SELECT * FROM login_data WHERE email = '$email' "; // Select records with the submitted email
            $result = mysqli_query($con, $sql); // Execute the query
            $row_count = mysqli_num_rows($result); // Get the number of rows returned
            // If any rows are found, it means the email is already in use
            if ($row_count > 0) {
                array_push($errors, "Email already exists!"); // Error for existing email
            }

            // Check if there are any error messages
            if (count($errors) > 0) {
                // Display each error message in an alert box
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                // If no errors, prepare to insert the new user into the database
                $sql = "INSERT INTO login_data(full_name, email, password) VALUES (?, ?, ?)"; // SQL for inserting data
                $stmt = mysqli_stmt_init($con); // Initialize a statement for prepared statements
                $prepare_stmt = mysqli_stmt_prepare($stmt, $sql); // Prepare the SQL statement
                // Check if the preparation was successful
                if ($prepare_stmt) {
                    // Bind the input parameters to the SQL statement
                    mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $password_hash); // Bind three string parameters
                    mysqli_stmt_execute($stmt); // Execute the statement
                    // Display a success message
                    echo "<div class='alert alert-success'>You are registered successfully</div>";
                } else {
                    die("Something went wrong"); // Handle error if the statement preparation fails
                }
            }
        }
        ?>
        <!-- HTML form for user registration -->
        <form action="" method="post">
            <h3>Register now</h3>
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" placeholder="Full Name:" autocomplete="off"
                    required> <!-- Input for full name -->
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email:" autocomplete="off" required>
                <!-- Input for email -->
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password:" autocomplete="off"
                    required> <!-- Input for password -->
            </div>
            <div class="form-group">
                <input type="password" name="repeat_password" class="form-control" placeholder="Repeat Password:"
                    autocomplete="off" required> <!-- Input for confirming password -->
            </div>
            <div class="form-btns">
                <input type="submit" class="btn btn-primary" value="Register" name="submit"> <!-- Submit button -->
            </div>
            <p>already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>

</body>

</html>