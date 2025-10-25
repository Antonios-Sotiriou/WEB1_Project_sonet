<?php
    session_start();
    include("functions.php");

    $conn = dbconnect();

    $GLOBALS["active_user"] = fetchCurrentUser($conn);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["profileUpdate"])) {
            userUpdate($conn, $_POST, $GLOBALS);
        }
    }
?>

<?php
    displayHeader("profile", "css/profile_style.css");
    echo "<link rel='stylesheet' href='css/forms_style.css'> ";
?>

<body>

    <?php include_once("shared/navbar.php"); ?>

    <div class="container" id="profile-update-container">

        <div class="profile-photo-container">
            <?php
                if (isset($_SESSION["email"])) {
            ?>
                    <img class="profile-photo" src=<?php echo $GLOBALS["active_user"]["profile_image"] ?> alt="">
            <?php
                } else {
                    echo '<img class="profile-photo" src="images/default_user.jpg" alt="">';
                }
            ?>
        </div>

        <h1 class="form-title">Profile</h1>
        <?php
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                if (($_GET["firstName"] === $GLOBALS["active_user"]["first_name"]) && ($_GET["lastName"] === $GLOBALS["active_user"]["last_name"])) {
                    updateProfileForm($GLOBALS);
                } else {
                    echo "Displaying User Profile";
                }
            }
        ?>

        <p class="or">
        ---------- or ----------
        </p>

        <div class="profile-cancel-btn text-center">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Cancel</a>
        </div>
    </div>
</body>
