<?php
    session_start();
    include("components/functions.php");

    $conn = dbconnect();

    $GLOBALS["active_user"] = fetchCurrentUser($conn);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["profileUpdate"])) {
            userUpdate($conn, $_POST, $GLOBALS["active_user"]);
        }
    }
?>

<?php
    displayHeader("profile", "css/profile_style.css");
    echo "<link rel='stylesheet' href='css/forms_style.css'> ";
?>

<body>

    <?php include_once("components/navbar.php"); ?>

    <div class="container" id="profile-update-container">

        <div class="profile-photo-container">
            <?php
                if ($_SERVER["REQUEST_METHOD"] === "GET") {
                    if ($_GET["user_id"] === $GLOBALS["active_user"]["user_id"]) {
                        echo '<img class="profile-photo" src='.$GLOBALS["active_user"]["profile_image"].' alt="">';
                    } else {
                        $profile_image = fetchUserProfilePhoto($conn, $_GET["user_id"]);
                        if (empty($profile_image)) {
                            // Log a threat at this point with timestamp, active user credentials and all other usefull informations.
                            echo "User does not exist. Possible threat detection! Reporting...";
                            die();
                        }
                        echo '<img class="profile-photo" src='.$profile_image.' alt="">';
                    }
                } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    echo '<img class="profile-photo" src='.$GLOBALS["active_user"]["profile_image"].' alt="">';
                }
            ?>
        </div>

        <h1 class="form-title">Profile</h1>
        <?php
            if ($_SERVER["REQUEST_METHOD"] === "GET") {

                if ($_GET["user_id"] === $GLOBALS["active_user"]["user_id"]) {
                    include("components/update_profile_form.php");
                } else {
                    $user_info = fetchUserInfo($conn, $_GET["user_id"]);
                    $total_posts = fetchUserTotalPosts($conn, $_GET["user_id"]);
                    include("components/info_profile_form.php");
                }
            } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

                include("components/update_profile_form.php");
            }
        ?>
    </div>
</body>
