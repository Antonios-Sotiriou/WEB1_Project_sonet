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
?>