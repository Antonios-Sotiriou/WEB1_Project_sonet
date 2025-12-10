<?php

function dbconnect() {
    $host = "localhost";
    $user = "guest";
    $pass = "Z3KDHonGY@vmRw0)";
    $db = "web1_project_sonet";
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        echo "Connection to database failed!".$conn->connect_error;
    }

    return $conn;
}

function userLogIn($conn, $info) {
    $email = htmlspecialchars($info["email"]);

    $retrieve_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $retrieve_user->bind_param("s", $email);
    $retrieve_user->execute();
    if ($retrieve_user == true) {

        $result = $retrieve_user->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($info["password"], $row["password"])) {
                session_start();
                $_SESSION["email"] = $row["email"];
                header("Location: home.php");
            } else {
                raise_error("Invalid password.");
            }
        } else {
            raise_error("User not found! Check your email address for type mistakes!");
        }
    }
    $retrieve_user->close();
    $result->close();
}

function verifyFirstName($firstName) {

    $first_name = trim($firstName);
    if ($first_name === '') {
        raise_error("First name is empty!");
        return NULL;
    }

    if (!ctype_alpha($first_name)) {
        raise_error("Special Charakters, spaces or numbers are not allowed in First name!");
        return NULL;
    }

    return $first_name;
}

function verifyLastName($lastName) {

    $last_name = trim($lastName);
    if ($last_name === '') {
        raise_error("Last name is empty!");
        return NULL;
    }

    if (!ctype_alpha($last_name)) {
        raise_error("Special Charakters, spaces or numbers are not allowed in Last name!");
        return NULL;
    }

    return $last_name;
}

function userRegister($conn, $_post) {

    $first_name = verifyFirstName($_post["firstName"]);
    if (empty($first_name)) {
        return;
    }

    $last_name = verifyLastName($_post["lastName"]);
    if (empty($last_name)) {
        return;
    }

    if ($_post["password"] === $_post["repeat_password"]) {

        if (strlen($_post["password"]) < 6) {
            raise_error("Password must be at least 6 characters long.");
            return;
        }

        $email = filter_var($_post["email"], FILTER_VALIDATE_EMAIL);
        $hash = password_hash($_post["password"], PASSWORD_DEFAULT);

        $check_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();

        if ($check_email) {

            $result = $check_email->get_result();

            if ($result->num_rows > 0) {
                raise_error("Email address already exists!");
            } else {
                $insertQuery = $conn->prepare("INSERT INTO users(first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
                $insertQuery->bind_param("ssss", $first_name, $last_name, $email, $hash);
                $insertQuery->execute();
                if ($insertQuery == TRUE) {
                    $insertQuery->close();
                    header("location: login.php");
                } else {
                    raise_error("An error has occured!".htmlspecialchars($conn->error));
                }
            }
        }
        $check_email->close();
        $result->close();
    } else {
        raise_error('Passwords not matching. Please check for typing mistakes.');
    }
}

function userUpdate($conn, $_post, $user): int {
    $error = 0;
    $user_id = $user["user_id"];
    $queries_array = array();

    if (!empty($_post["firstName"])) {
        $first_name = verifyFirstName($_post["firstName"]);
        if (empty($first_name)) {
            $error = 1;
        } else {
            $queries_array[] = $conn->prepare("UPDATE users SET first_name = '$first_name' WHERE user_id = $user_id");
        }
    }

    if (!empty($_post["lastName"])) {
        $last_name = verifyLastName($_post["lastName"]);
        if (empty($last_name)) {
            $error = 1;
        } else {
            $queries_array[] = $conn->prepare("UPDATE users SET last_name = '$last_name' WHERE user_id = '$user_id'");
        }
    }

    if (!empty($_FILES["uploadPhoto"]["name"])) {

        if (!uploadImage($conn, $_FILES["uploadPhoto"], $user)) {
            raise_error("File update failed!");
            $error = 1;
        }
    }
    if ($error) {
        return 0;
    } else {
        foreach ($queries_array as $query) {
            $query->execute();
            $query->close();
        }
    }
    header('Location: profile.php?firstName='.$user["first_name"].'&lastName='.$last_name.'&user_id='.$user_id);
    return 1;
}

function uploadImage($conn, $img, $user): int {
    $check = getimagesize($img["tmp_name"]);
    if ($check === false) {
        raise_error("File is not an image.");
        return 0;
    }

    if (!in_array($img["type"], allowedImages())) {
        raise_error("Image format is not allowed"); 
        return 0;
    }   

    $folder = 'media/'.$user["md_email"].'/';
    $destination = $folder.''.$_FILES["uploadPhoto"]["name"];

    if (!is_dir($folder)) {
        mkdir($folder, recursive: true);
    }

    if (move_uploaded_file($_FILES["uploadPhoto"]["tmp_name"], $destination)) {
        $img_name = $_FILES["uploadPhoto"]["name"];

        $check_entry = $conn->prepare("SELECT * FROM prof_images WHERE user_id = ?");
        $check_entry->bind_param("i", $user["user_id"]);
        $check_entry->execute();

        if ($check_entry == true) {
            $result = $check_entry->get_result();
            $check_entry->close();

            if ($result->num_rows > 0) {
                $result->close();

                $updateQuery = $conn->prepare("UPDATE prof_images SET img_name = ? WHERE user_id = ?");
                $updateQuery->bind_param("si", $img_name, $user["user_id"]);
                $updateQuery->execute();
                if ($updateQuery == false) {
                    return 0;
                }
                $updateQuery->close();
                header('Location: profile.php?firstName='.$user["first_name"].'&lastName='.$user["last_name"].'&user_id='.$user["user_id"]);
            } else {
                $result->close();

                $insertQuery = $conn->prepare("INSERT INTO prof_images (user_id, img_name) VALUES (?, ?)");
                $insertQuery->bind_param("is", $user["user_id"], $img_name);
                $insertQuery->execute();
                if ($insertQuery == false) {
                    return 0;
                }
                $insertQuery->close();
                header('Location: profile.php?firstName='.$user["first_name"].'&lastName='.$user["last_name"].'&user_id='.$user["user_id"]);
            }
        } else {
            return 0;
        }
    } else {
        return 0;
    }

    return 1;
}

function allowedImages() {
    $allowed = array (
        "image/pjpeg","image/jpeg", "image/JPG", 
        "image/X-PNG", "image/PNG", "image/png","image/x-png",
        // "image/bmp", "image/BMP"
    );
    
    return $allowed;
}

function isAdmin($conn, $user_id): int {
    $query = mysqli_query($conn, 
        "SELECT * FROM admins WHERE admins.user_id='$user_id'"
    );

    return mysqli_num_rows($query);
}

function fetchCurrentUser($conn) {

    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = $conn->prepare( 
            "SELECT users.user_id, users.first_name, users.last_name, users.email, prof_images.img_name 
            FROM users 
            LEFT JOIN prof_images ON users.user_id = prof_images.user_id 
            WHERE users.email=?"
        );
        $query->execute([$email]);
        printObjectMethods($query);
        if ($query == true) {

            $result = $query->get_result();

            while ($row = $result->fetch_assoc()) {
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
            $result->close();
        }
    } else {
        $globals["user_id"] = 0;
        $globals["first_name"] = "";
        $globals["last_name"] = "";
        $globals["email"] = "";
        $globals["profile_image"] = "images/default_user.jpg";
    }
    $query->close();

    return $globals;
}

function fetchUserProfilePhoto($conn, $user_id) {
    $query = mysqli_query($conn, 
        "SELECT users.email, prof_images.img_name FROM users LEFT JOIN prof_images ON prof_images.user_id = users.user_id WHERE users.user_id = '$user_id'"
    );

    if (mysqli_num_rows($query)) {
        while ($row = mysqli_fetch_array($query)) {
            $email = $row["email"];
            if (empty($row["img_name"])) {
                return "images/default_user.jpg";
            }
            $img_name = $row["img_name"];
        }
    } else {
        return "";
    }

    return "media/".md5($email)."/".$img_name;
}

function fetchUserTotalPosts($conn, $user_id) : int {
    $query = mysqli_query($conn,
        "SELECT * FROM posts WHERE posts.user_id = $user_id"
    );

    if (mysqli_num_rows($query)) {
        return mysqli_num_rows($query);
    }

    return 0;
}

function fetchUserInfo($conn, $user_id) {
    $query = mysqli_query($conn,
        "SELECT first_name, last_name, date_joined FROM users WHERE users.user_id = $user_id"
    );

    if (mysqli_num_rows($query)) {
        while ($row = mysqli_fetch_array($query)) {
            $user_info["first_name"] = $row["first_name"];
            $user_info["last_name"] = $row["last_name"];
            $user_info["date_joined"] = $row["date_joined"];
        }
    } else {
        return "User not found.";
    }

    return $user_info;
}

function createPost($conn, $_post, $globals) {
    $user_id = $globals["active_user"]["user_id"];
    $content = htmlspecialchars(trim($_POST["post_content"]));

    if (empty($content)) {
        raise_error("Post content is empty.");
        return;
    }
    $insertQuery = "INSERT INTO posts(user_id, post_content) VALUES ('$user_id', '$content')";
    if ($conn->query($insertQuery) == TRUE) {
        header("location: home.php");
    } else {
        raise_error("An error has occured!".htmlspecialchars($conn->error));
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

    $posts = NULL;
    if ($query->num_rows != 0) {
        while($row = $query->fetch_assoc()) {
            $posts[] = $row;
        }
    }
    
    return $posts;
}

function fetchPostsById($conn,$post_id) {
    $query = mysqli_query($conn,
        "SELECT posts.post_id, posts.created_at, posts.post_content, users.user_id, users.first_name, users.last_name, users.email, prof_images.img_name 
        FROM posts 
        JOIN users ON posts.user_id = users.user_id 
        LEFT JOIN prof_images ON posts.user_id = prof_images.user_id 
        WHERE posts.post_id = $post_id"
    );

    while($row = $query->fetch_assoc()) {
        $post[] = $row;
    }
    
    if(isset($post))
        return $post[0];

    return null;
}

function createComment($conn, $post_id, $content, $user_id): int {
    $content = htmlspecialchars(trim($content));
    if (empty($content)) {
        raise_error("Comment content is empty.");
        return 0;
    }
    $insertQuery = "INSERT INTO comments(post_id, user_id, comm_content) VALUES ($post_id,'$user_id','$content')";
    if ($conn->query($insertQuery) == TRUE) {
        echo "$content";
        header("location: comment.php?id=$post_id");
    } else {
        raise_error("An error has occured!".$conn->error);
    }
    return 1;
}

function fetchComments($conn,$post_id) {
    $post_id = intval($post_id);

    // SQL query joins comments with users to show commenter info
    $sql = mysqli_query($conn,
        "SELECT 
            comments.comm_id,
            comments.created_at,
            comments.comm_content,
            users.user_id,
            users.first_name,
            users.last_name,
            users.email,
            prof_images.img_name
        FROM comments
        JOIN users ON comments.user_id = users.user_id
        LEFT JOIN prof_images ON comments.user_id = prof_images.user_id
        WHERE comments.post_id = $post_id
        ORDER BY comments.created_at DESC
    ");

    while ($row = $sql->fetch_assoc()) {
        $comments[] = $row;
    }

    if(isset($comments))
        return $comments;

    return null;
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

function fetchTotalLikes($conn, $post_id): int {
    $query_likes_total = mysqli_query($GLOBALS["conn"], "SELECT * FROM likes WHERE likes.post_id = $post_id");

    return mysqli_num_rows($query_likes_total);
}
function fetchTotalDislikes($conn, $post_id): int {
    $query_dislikes_total = mysqli_query($GLOBALS["conn"], "SELECT * FROM dislikes WHERE dislikes.post_id = $post_id");

    return mysqli_num_rows($query_dislikes_total);
}
function fetchTotalComments($conn, $post_id): int {
    $query_comments_total = mysqli_query($GLOBALS["conn"], "SELECT * FROM comments WHERE comments.post_id = $post_id");

    return mysqli_num_rows($query_comments_total);
}
function userInLikes($user_id, $post_id): int {
    $query = mysqli_query($GLOBALS["conn"], "SELECT user_id FROM likes WHERE likes.user_id = $user_id AND likes.post_id = $post_id");

    return mysqli_num_rows($query);
}
function userInDislikes($user_id, $post_id): int {
    $query = mysqli_query($GLOBALS["conn"], "SELECT user_id FROM dislikes WHERE dislikes.user_id = $user_id AND dislikes.post_id = $post_id");

    return mysqli_num_rows($query);
}
function userInComments($user_id, $post_id): int {
    $query = mysqli_query($GLOBALS["conn"], "SELECT user_id FROM comments WHERE comments.user_id = $user_id AND comments.post_id = $post_id");

    return mysqli_num_rows($query);
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

// Helper Functions ######################################################
function raise_error($error_message) {
    echo "<h3 style='text-align: center;'>".$error_message."</h3>";
}
function enableDebugging() {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}
function printObjectMethods($obj) {
    $methods_array = get_class_methods($obj);
    print_r($obj);
    echo "<br><br>";
    echo $obj->field_count;
    echo "<br><br>";


    echo "Object Methods {<br>";
    foreach ($methods_array as $method) {
        echo "&nbsp&nbsp&nbsp&nbsp".$method."<br>";
    }
    echo "}<br><br>";
}
?>