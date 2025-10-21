<?php
session_start();
include("functions.php");

$GLOBALS["conn"] = dbconnect();

if (isset($_POST["post_id"])) {

    if (isset($_POST["like_post"])) {
        handleUserLike($_POST["post_id"], $_POST["user_id"]);
    } else if (isset($_POST["dislike_post"])) {
        handleUserDislike($_POST["post_id"], $_POST["user_id"]);
    }

    $request_data = array(
        "user_id" => $_POST["user_id"],
        "post_id" => $_POST["post_id"],
        "total_likes" =>  fetchTotalLikes($GLOBALS["conn"], $_POST["post_id"]), 
        "total_dislikes" => fetchTotalDislikes($GLOBALS["conn"], $_POST["post_id"])
    );

    echo json_encode($request_data); 
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

?>