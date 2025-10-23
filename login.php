<?php
    include("functions.php");

    $conn = dbconnect();

    if (isset($_POST["signIn"])) {
        $email = htmlspecialchars($_POST["email"]);
        $password = $_POST["password"];
        $password = md5($password);

        $retrieve_user = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($retrieve_user);
        if ($result->num_rows > 0) {
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION["email"] = $row["email"];
            header("Location: home.php");
        } else {
            echo "User not found! Check your email and password for type mistakes!";
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

    <title>Login</title>
</head>
<body>

    <div class="login-container" id="signIn">

        <div id="login-photo-container">
            <img id="login-photo" src="images/default_user.jpg" alt="">
        </div>

        <h1 class="form-title">Sign In</h1>
        <form method="post" action="login.php">
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <input type="submit" class="btn-submit" value="Sign In" name="signIn">
        </form>

        <p class="or">
        ----------or--------
        </p>

        <div class="links">
            <p>Don't have account yet?</p>
            <a href="register.php" class="sign-actions" id="sign-up-link">Sign Up</button>
        </div>

        <div class="login-return-to-home-btn-container">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Return to Homepage</a>
        </div>
    </div>
    
</body>
</html>