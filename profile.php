<?php
    session_start();
    include("functions.php");

    $conn = dbconnect();

    // if (isset($_SESSION["email"])) {
        $GLOBALS["active_user"] = fetchCurrentUser($conn);

        if(isset($_POST["profileUpdate"])) {
            $user_id = $GLOBALS["active_user"]["user_id"];

            if (!empty($_POST["firstName"])) {
                $first_name = $_POST["firstName"];
                $insertQuery = "UPDATE users SET first_name = '$first_name' WHERE id = $user_id";
                if ($conn->query($insertQuery) == TRUE) {
                    header("Location: profile.php");
                }
            }
            if (!empty($_POST["lastName"])) {
                $last_name = $_POST["lastName"];
                $insertQuery = "UPDATE users SET last_name = '$last_name' WHERE id = '$user_id'";
                if ($conn->query($insertQuery) == TRUE) {
                    header("Location: profile.php");
                }
            }

            if (!empty($_FILES["uploadPhoto"]["name"])) {
                // HERE WE MUST CHECK IF USER UPLOADED CORRECT IMAGE TYPE.
                $folder = 'media/'.$GLOBALS["active_user"]["md_email"].'/';
                $destination = $folder.''.$_FILES["uploadPhoto"]["name"];

                if (!is_dir($folder)) {
                    mkdir($folder, recursive: true);
                }

                if (move_uploaded_file($_FILES["uploadPhoto"]["tmp_name"], $destination)) {
                    $img_name = $_FILES["uploadPhoto"]["name"];

                    $check_entry = "SELECT * FROM prof_images WHERE user_id='$user_id'";
                    $result = $conn->query($check_entry);
                    if ($result->num_rows > 0) {
                        $updateQuery = "UPDATE prof_images SET img_name = '$img_name' WHERE user_id = '$user_id'";
                        if ($conn->query($updateQuery) == TRUE) {
                            header("Location: profile.php");
                        } else {
                            echo "<h3>File update failed!!!</h3>";
                        }
                    } else {
                        $insertQuery = "INSERT INTO prof_images (user_id, img_name) VALUES ('$user_id', '$img_name')";
                        if ($conn->query($insertQuery) == TRUE) {
                            header("Location: profile.php");
                        }
                    }
                } else {
                    echo "<h3>File upload failed!!!</h3>";
                }
            }
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