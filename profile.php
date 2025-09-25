<?php
    session_start();
    include("connect.php");

    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE users.email='$email'");
        while ($row = mysqli_fetch_array($query)) {
                $GLOBALS["user_id"] = $row["id"];
                $GLOBALS["first_name"] = $row["first_name"];
                $GLOBALS["last_name"] = $row["last_name"];
                $GLOBALS["email"] = $row["email"];
                $user_id = $row["id"];
        }
        if(isset($_POST["postCreate"])) {
            echo "TEST CASE REACHED";
            $content = $_POST["content"];
            $insertQuery = "INSERT INTO posts(user_id, content) VALUES ('$user_id', '$content')";
            if ($conn->query($insertQuery) == TRUE) {
                echo "$content";
                // header("location: home.php");
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

    <link rel="stylesheet" href="css/profile_style.css">
    <link rel="stylesheet" href="css/forms_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <div class="container" id="profile-update-container">

        <div class="profile-photo-container">
            <img class="profile-photo" src="images/default_user.jpg" alt="">
        </div>

        <h1 class="form-title">Profile</h1>
        <form method="post" action="profile.php">

            <div class="input-group">
                <input type="text" name="firstName" id="first-name" placeholder="First Name" required>
                <label for="first-name">First Name</label>
            </div>
            <div class="input-group">
                <input type="text" name="lastName" id="last-name" placeholder="Last Name" required>
                <label for="last-name">Last Name</label>
            </div>

            <div>
                <div>
                    <small class="custom-file-label" for="inputGroupFile">Upload a profile photo</small>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile">
                </div>
            </div>

            <input type="submit" class="btn-submit" value="Update" name="Update">
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