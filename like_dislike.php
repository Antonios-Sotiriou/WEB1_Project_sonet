<?php
session_start();
include("functions.php");

$GLOBALS["conn"] = dbconnect();

if (isset($_POST["post_id"])) {

    if (isset($_POST["like_post"])) {
        echo handleUserLike($_POST["post_id"], $_POST["user_id"]);
    }
}

function handleUserLike($post_id, $user_id) {
    
    $request_data = array(
        "user_id" => $user_id,
        "post_id" => $post_id,
        "user_like" => 0,
        "total_likes" => 0, 
        "total_dislikes" => 0
    );

    $query_likes = mysqli_query($GLOBALS["conn"], "SELECT post_id, user_id FROM likes WHERE likes.post_id = '$post_id' AND likes.user_id = '$user_id'");
    if (!mysqli_num_rows($query_likes)) {
        // User not in likes, add him.
        $query_likes = mysqli_query($GLOBALS["conn"], "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')");
        $request_data["user_like"] = 1;

        // check if user is in dislikes. If yes remove him. A user can't like and dislike a post at the same time.
        $query_dislikes = mysqli_query($GLOBALS["conn"], "SELECT post_id, user_id FROM dislikes WHERE dislikes.post_id = '$post_id' AND dislikes.user_id = '$user_id'");
        if (mysqli_num_rows($query_dislikes)) {
            // User in dislikes. Remove him.
            $query_likes = mysqli_query($GLOBALS["conn"], "DELETE FROM dislikes WHERE dislikes.post_id = '$post_id' AND dislikes.user_id = '$user_id'");

            // fetch the total number of dislikes on the post.
            $request_data["total_dislikes"] = fetchTotalDislikes($GLOBALS["conn"], $post_id);
        }
    } else {
        // User in likes, remove him.
        $query_likes = mysqli_query($GLOBALS["conn"], "DELETE FROM likes WHERE likes.post_id = '$post_id' AND likes.user_id = '$user_id'");
    }

    // fetch the total number of likes on the post.
    $request_data["total_likes"] = fetchTotalLikes($GLOBALS["conn"], $post_id);

    return json_encode($request_data);
}

?>