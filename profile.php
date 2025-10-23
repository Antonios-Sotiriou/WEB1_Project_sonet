<?php
    session_start();
    include("functions.php");

    $conn = dbconnect();

    // if (isset($_SESSION["email"])) {
        $GLOBALS["active_user"] = fetchCurrentUser($conn);

        if(isset($_POST["profileUpdate"])) {
            userUpdate($conn, $_POST, $GLOBALS);
        }
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/profile_style.css">
    <link rel="stylesheet" href="css/forms_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Profile</title>
</head>
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
        <form method="post" action="profile.php" enctype="multipart/form-data">

            <div class="input-group">
                <input type="text" name="firstName" id="first-name" placeholder="First Name">
                <label for="first-name"><?php echo $GLOBALS["active_user"]["first_name"] ?></label>
            </div>
            <div class="input-group">
                <input type="text" name="lastName" id="last-name" placeholder="Last Name">
                <label for="last-name"><?php echo $GLOBALS["active_user"]["last_name"] ?></label>
            </div>

            <div>
                <div>
                    <small class="custom-file-label" for="inputGroupFile">Upload a profile photo</small>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile" name="uploadPhoto">
                </div>
            </div>

            <input type="submit" class="btn-submit" value="Update" name="profileUpdate">
        </form>

        <p class="or">
        ---------- or --------
        </p>

        <div class="profile-cancel-btn">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Cancel</a>
        </div>
    </div>
</body>
</html>