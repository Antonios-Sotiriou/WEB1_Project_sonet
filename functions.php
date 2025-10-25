<?php

function dbconnect() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "web1_project_sonet";
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        echo "Connection to database failed!".$conn->connect_error;
    }

    return $conn;
}

function userLogIn($conn, $info) {
    $email = htmlspecialchars($info["email"]);
    $password = $info["password"];
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

function userRegister($conn, $_post) {
    $first_name = trim($_post["firstName"]);
    if ($first_name === '') {
        echo "First name is empty";
        return;
    } else {
        if (ctype_alpha($first_name)) {

            $last_name = trim($_post["lastName"]);
            if ($last_name === '') {
                echo "Last name is empty";
                return;
            } else {
                if (ctype_alpha($last_name)) {

                    $email = filter_var($_post["email"], FILTER_VALIDATE_EMAIL);
                    $password = $_post["password"];
                    $password = md5($password);

                    $check_email = "SELECT * FROM users WHERE email='$email'";
                    $result = $conn->query($check_email);
                    if ($result->num_rows > 0) {
                        echo "Email address already exists!";
                    } else {
                        $insertQuery = "INSERT INTO users(first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
                        if ($conn->query($insertQuery) == TRUE) {
                            header("location: login.php");
                        } else {
                            echo "An error has occured!".htmlspecialchars($conn->error);
                        }
                    }
                } else {
                    echo "Special Charakters, spaces or numbers are not allowed in Last name!";
                }
            }
        } else {
            echo "Special Charakters, spaces or numbers are not allowed in First name!";
        }
    }
}

function userUpdate($conn, $_post, $globals) {
    $user_id = $globals["active_user"]["user_id"];

    if (!empty($_post["firstName"])) {
        if (ctype_alpha($_post["firstName"])) {
            $first_name = trim($_post["firstName"]);

            $insertQuery = "UPDATE users SET first_name = '$first_name' WHERE user_id = $user_id";
            if ($conn->query($insertQuery) == TRUE) {
                header("Location: profile.php");
            }
        }
    }
    if (!empty($_post["lastName"])) {
        if (ctype_alpha($_post["lastName"])) {
            $last_name = trim($_post["lastName"]);

            $insertQuery = "UPDATE users SET last_name = '$last_name' WHERE user_id = '$user_id'";
            if ($conn->query($insertQuery) == TRUE) {
                header("Location: profile.php");
            }
        }
    }

    if (!empty($_FILES["uploadPhoto"]["name"])) {

        if (in_array($_FILES["uploadPhoto"]["type"], allowedImages())) {

            $folder = 'media/'.$globals["active_user"]["md_email"].'/';
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
        } else {
            echo "<h3>Image format is not allowed. Use either jpg or png!</h3>";
        }
    }
}

function isAdmin($conn, $user_id) {
        $query = mysqli_query($conn, 
            "SELECT * FROM admins WHERE admins.user_id='$user_id'"
        );

        return mysqli_num_rows($query);
}

function fetchCurrentUser($conn) {

    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = mysqli_query($conn, 
            "SELECT users.user_id, users.first_name, users.last_name, users.email, prof_images.img_name 
            FROM users 
            LEFT JOIN prof_images ON users.user_id = prof_images.user_id 
            WHERE users.email='$email'"
        );

        while ($row = mysqli_fetch_array($query)) {
            $globals["user_id"] = $row["user_id"];
            $globals["first_name"] = $row["first_name"];
            $globals["last_name"] = $row["last_name"];
            $globals["email"] = $row["email"];
            $globals["md_email"] = md5($row["email"]);
            if (!empty($row["img_name"])) {
                $globals["profile_image"] = "media/".$globals["md_email"]."/".$row["img_name"];
            } else {
                $globals["profile_image"] = "images/default_user.jpg";
            }
        }
    } else {
        $globals["user_id"] = 0;
        $globals["first_name"] = "";
        $globals["last_name"] = "";
        $globals["email"] = "";
        $globals["profile_image"] = "images/default_user.jpg";
    }

    return $globals;
}

function createPost($conn, $_post, $globals) {
    $user_id = $GLOBALS["active_user"]["user_id"];
    $content = htmlspecialchars($_POST["post_content"]);
    $insertQuery = "INSERT INTO posts(user_id, post_content) VALUES ('$user_id', '$content')";
    if ($conn->query($insertQuery) == TRUE) {
        header("location: home.php");
    } else {
        echo "An error has occured!".htmlspecialchars($conn->error);
    }
}

function fetchPosts($conn) {
    $query = mysqli_query($conn,
        "SELECT posts.post_id, posts.created_at, posts.post_content, users.user_id, users.first_name, users.last_name, users.email, prof_images.img_name 
        FROM posts 
        JOIN users ON posts.user_id = users.user_id 
        LEFT JOIN prof_images ON posts.user_id = prof_images.user_id 
        ORDER BY posts.created_at DESC;"
    );

    while($row = $query->fetch_assoc()) {
        $posts[] = $row;
    }
    
    return $posts;
}

function handleUserLike($post_id, $user_id) {

    $query_likes = mysqli_query($GLOBALS["conn"], "SELECT post_id, user_id FROM likes WHERE likes.post_id = '$post_id' AND likes.user_id = '$user_id'");
    if (!mysqli_num_rows($query_likes)) {
        // User not in likes, add him.
        $query_likes = mysqli_query($GLOBALS["conn"], "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')");

        // check if user is in dislikes. If yes remove him. A user can't like and dislike a post at the same time.
        $query_dislikes = mysqli_query($GLOBALS["conn"], "SELECT post_id, user_id FROM dislikes WHERE dislikes.post_id = '$post_id' AND dislikes.user_id = '$user_id'");
        if (mysqli_num_rows($query_dislikes)) {
            // User in dislikes. Remove him.
            $query_dislikes = mysqli_query($GLOBALS["conn"], "DELETE FROM dislikes WHERE dislikes.post_id = '$post_id' AND dislikes.user_id = '$user_id'");
        }
    } else {
        // User in likes, remove him.
        $query_likes = mysqli_query($GLOBALS["conn"], "DELETE FROM likes WHERE likes.post_id = '$post_id' AND likes.user_id = '$user_id'");
    }
}

function handleUserDislike($post_id, $user_id) {

    $query_dislikes = mysqli_query($GLOBALS["conn"], "SELECT post_id, user_id FROM dislikes WHERE dislikes.post_id = '$post_id' AND dislikes.user_id = '$user_id'");
    if (!mysqli_num_rows($query_dislikes)) {
        // User not in dislikes, add him.
        $query_dislikes = mysqli_query($GLOBALS["conn"], "INSERT INTO dislikes (post_id, user_id) VALUES ('$post_id', '$user_id')");

        // check if user is in likes. If yes remove him. A user can't like and dislike a post at the same time.
        $query_likes = mysqli_query($GLOBALS["conn"], "SELECT post_id, user_id FROM likes WHERE likes.post_id = '$post_id' AND likes.user_id = '$user_id'");
        if (mysqli_num_rows($query_likes)) {
            // User in likes. Remove him.
            $query_likes = mysqli_query($GLOBALS["conn"], "DELETE FROM likes WHERE likes.post_id = '$post_id' AND likes.user_id = '$user_id'");
        }
    } else {
        // User in dislikes, remove him.
        $query_dislikes = mysqli_query($GLOBALS["conn"], "DELETE FROM dislikes WHERE dislikes.post_id = '$post_id' AND dislikes.user_id = '$user_id'");
    }
}

function fetchTotalLikes($conn, $post_id) {
    $query_likes_total = mysqli_query($GLOBALS["conn"], "SELECT * FROM likes WHERE likes.post_id = $post_id");

    return mysqli_num_rows($query_likes_total);
}
function fetchTotalDislikes($conn, $post_id) {
    $query_dislikes_total = mysqli_query($GLOBALS["conn"], "SELECT * FROM dislikes WHERE dislikes.post_id = $post_id");

    return mysqli_num_rows($query_dislikes_total);
}
function fetchTotalComments($conn, $post_id) {
    $query_comments_total = mysqli_query($GLOBALS["conn"], "SELECT * FROM comments WHERE comments.post_id = $post_id");

    return mysqli_num_rows($query_comments_total);
}
function userInLikes($user_id, $post_id) {
    $query = mysqli_query($GLOBALS["conn"], "SELECT user_id FROM likes WHERE likes.user_id = $user_id AND likes.post_id = $post_id");

    return mysqli_num_rows($query);
}
function userInDislikes($user_id, $post_id) {
    $query = mysqli_query($GLOBALS["conn"], "SELECT user_id FROM dislikes WHERE dislikes.user_id = $user_id AND dislikes.post_id = $post_id");

    return mysqli_num_rows($query);
}
function userInComments($user_id, $post_id) {
    $query = mysqli_query($GLOBALS["conn"], "SELECT user_id FROM comments WHERE comments.user_id = $user_id AND comments.post_id = $post_id");

    return mysqli_num_rows($query);
}

function allowedImages() {
    $allowed = array (
        "image/pjpeg","image/jpeg", "image/JPG", 
        "image/X-PNG", "image/PNG", "image/png","image/x-png",
        // "image/bmp", "image/BMP"
    );
    
    return $allowed;
}

// Funtions which help us avoiding repeating our self. ######################################################
function displayHeader($page_title, $style_css) {
    echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>

            <link rel='stylesheet' href='$style_css'>

            <title>$page_title</title>
        </head>
        </html>
    ";
}

// Display update profile form ######################################################
function updateProfileForm($globals) {
    echo '<form method="post" action="profile.php" enctype="multipart/form-data">

        <div class="input-group">
            <input type="text" name="firstName" id="first-name" placeholder="First Name">
            <label for="first-name"><?php echo $globals["active_user"]["first_name"] ?></label>
        </div>
        <div class="input-group">
            <input type="text" name="lastName" id="last-name" placeholder="Last Name">
            <label for="last-name"><?php echo $globals["active_user"]["last_name"] ?></label>
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
    </form>';
}

// Helper Functions ######################################################
function enableDebugging() {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}
?>