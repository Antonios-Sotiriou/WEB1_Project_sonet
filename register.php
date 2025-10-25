<?php
    include("functions.php");

    $conn = dbconnect();

    $GLOBALS["active_user"] = fetchCurrentUser($conn);

    if (isset($_POST["signUp"])) {
        userRegister($conn, $_POST);
    }
?>

<?php displayHeader("register", "css/forms_style.css"); ?>

<body>

    <?php include_once("shared/navbar.php"); ?>

    <div class="register-container" id="signup">

        <div id="register-photo-container">
            <img id="register-photo" src="images/default_user.jpg" alt="">
        </div>

        <h1 class="form-title">Register</h1>
        <form action="register.php" method="post">
            <div class="input-group">
                <input type="text" name="firstName" id="first-name" placeholder="First Name" value=<?php echo $_POST["firstName"] ?? ""; ?>>
                <label for="first-name">First Name</label>
            </div>
            <div class="input-group">
                <input type="text" name="lastName" id="last-name" placeholder="Last Name" value=<?php echo $_POST["lastName"] ?? ""; ?>>
                <label for="last-name">Last Name</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" value=<?php echo $_POST["email"] ?? ""; ?>>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password", id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn-submit" value="signUp" name="signUp">
        </form>

        <p class="or">
            ---------- or ----------
        </p>

        <div class="row text-center links">
            <p class="links-already-text">Already have an Account?</p>
            <a href="login.php" class="sign-actions" id="Sign-in-link">Sign In</a>
        </div>

        <div class="register-return-to-home-btn-container">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Return to Homepage</a>
        </div>
    </div>
</body>
