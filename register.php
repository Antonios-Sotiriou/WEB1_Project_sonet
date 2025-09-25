<?php
    include "connect.php";

    if (isset($_POST["signUp"])) {
        $first_name = $_POST["firstName"];
        $last_name = $_POST["lastName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password = md5($password);

        $check_email = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($check_email);
        if ($result->num_rows > 0) {
            echo "Email address already exists!";
        } else {
            $insertQuery = "INSERT INTO users(first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
            if ($conn->query($insertQuery) == TRUE) {
                header("location: login.html");
            } else {
                echo "An error has occured!".$conn->error;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/forms_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Register</title>
</head>
<body>
    <div class="register-container" id="signup">

        <div id="register-photo-container">
            <img id="register-photo" src="images/default_user.jpg" alt="">
        </div>

        <h1 class="form-title">Register</h1>
        <form action="register.php" method="post">
            <div class="input-group">
                <input type="text" name="firstName" id="first-name" placeholder="First Name" required>
                <label for="first-name">First Name</label>
            </div>
            <div class="input-group">
                <input type="text" name="lastName" id="last-name" placeholder="Last Name" required>
                <label for="last-name">Last Name</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password", id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn-submit" value="Sign Up" name="signUp">
        </form>

        <p class="or">
            ---------- or ----------
        </p>

        <div class="links">
            <p>Already have an Account?</p><br>
            <a href="login.php" class="sign-actions" id="Sign-in-link">Sign In</a>
        </div>

        <div class="register-return-to-home-btn-container">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Return to Homepage</a>
        </div>
    </div>
</body>
</html>