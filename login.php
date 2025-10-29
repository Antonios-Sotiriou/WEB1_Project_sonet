<?php
    include("functions.php");

    $conn = dbconnect();

    $GLOBALS["active_user"] = fetchCurrentUser($conn);

    if (isset($_POST["signIn"])) {
        userLogIn($conn, $_POST);
    }
?>

<?php
    displayHeader("profile", "css/forms_style.css");
?>

    <?php include_once("shared/navbar.php"); ?>

    <div class="login-container" id="signIn">

        <div id="login-photo-container">
            <img id="login-photo" src="images/default_user.jpg" alt="">
        </div>

        <h1 class="form-title">Sign In</h1>
        <form method="post" action="login.php">
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" value=<?php echo $_POST["email"] ?? ""; ?>>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <input type="submit" class="btn-submit" value="Sign In" name="signIn">
        </form>

        <p class="or">
            ---------- or ----------
        </p>

        <div class="row text-center links">
            <p class="links-already-text">Don't have account yet?</p>
            <a href="register.php" class="sign-actions" id="sign-up-link">Sign Up</button>
        </div>

        <div class="login-return-to-home-btn-container">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Return to Homepage</a>
        </div>
    </div>
    
</body>
