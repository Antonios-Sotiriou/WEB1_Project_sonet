<?php
    include("functions.php");

    $conn = dbconnect();

    $GLOBALS["active_user"] = fetchCurrentUser($conn);

    if (isset($_POST["signUp"])) {
        userRegister($conn, $_POST);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/forms_style.css">

    <title>Register</title>
</head>
<body>

    <?php include_once("shared/navbar.php"); ?>

    <div class="register-container" id="signup">

        <div id="register-photo-container">
            <img id="register-photo" src="images/default_user.jpg" alt="">
        </div>

        <h1 class="form-title">Register</h1>
        <form action="" method="post">
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