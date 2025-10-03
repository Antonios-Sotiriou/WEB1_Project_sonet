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

function fetchCurrentUser($conn) {

    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = mysqli_query($conn, "SELECT users.user_id, users.first_name, users.last_name, users.email, prof_images.img_name FROM users LEFT JOIN prof_images ON users.user_id = prof_images.user_id WHERE users.email='$email'");
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

function fetchPosts() {
    $conn = dbconnect();
    $query = mysqli_query($conn, "SELECT * FROM posts AS p JOIN users AS u ON p.user_id = u.user_id ORDER BY p.created_at DESC;");

    while($row = $query->fetch_assoc()) {
        $posts[] = $row;
    }
    
    return $posts;
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
        "image/bmp", "image/BMP"
    );
    
    return $allowed;
}

// Helper Functions ######################################################

function enableDebugging() {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

function print_FILES_Keysvals() {
    foreach (array_keys($_FILES) as $key) {
        echo $key.' {<br>';
        foreach(array_keys($_FILES[$key]) as $inner_key) {
            echo $inner_key."  :  ".$_FILES[$key][$inner_key]."<br>";
        }
        echo "}";
    }
}
function print_GLOBALS_Keysvals() {
    foreach (array_keys($GLOBALS) as $key) {
        echo $key.' {<br>';

        foreach(array_keys($GLOBALS[$key]) as $inner_key) {
            if (!empty($inner_key)) {
                echo $inner_key."  :  ".$GLOBALS[$key][$inner_key]."<br>";
            }
        }
        echo "}";
    }
}
?>