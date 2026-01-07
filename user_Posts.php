<?php
    session_start();
    include("components/functions.php");

    $conn = dbconnect();

    if (isset($_SESSION["email"])) {
        $GLOBALS["active_user"] = fetchCurrentUser($conn);

        if (!isAdmin($conn, $GLOBALS["active_user"]["user_id"])) {
            header("HTTP/1:1 404 Not Found");
            die();
        }
    } else {
        header("HTTP/1:1 404 Not Found");
        die();
    }

    if (isset($_POST['clickedPost'])) {
        deletePost($conn,$_POST['clickedPost']);
    }
    if(isset($_POST['clickedComment'])){
        deleteComment($conn,$_POST['clickedComment']);
    }
?>

<?php displayHeader("admin_panel", "css/home_style.css");
    echo "<link rel='stylesheet' href='css/user_posts.css'>";
?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>
    
    <p>
        <a id="go-back-link" class="btn btn-primary" href="admin_panel.php" role="button" id="cancel-btn">Go Back</a>
    </p>

    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $posts = fetchAllUserPosts($conn, $id);
            $user = fetchUserById($conn,$id);
        }
    ?>

    <div class="text-center mx-auto" style="width: 80vw; border-bottom: 3px solid black; padding-bottom: 10px;">
        <h1>
            User <?php echo $user["first_name"]." ".$user["last_name"]?>
        </h1>
    </div>
    <h1 style="text-align: center;">Posts list</h1>

    <form method="post">
        <div class="posts-container">
            <div class="article-main-container">
                <?php  
                if(isset($posts))
                    foreach($posts as $post){
                ?>
                <div class="admin-panel-post">
                    <div class ="card md-4">
                        <div class="post-id-container">
                            Post ID: #<?php echo $post["post_id"]?>
                        </div>
                        <div class="post-date-container">
                            <?php echo "Created at: ".date("d.m.Y, H:i", strtotime($post["created_at"])); ?>
                        </div>
                        <div>
                            <p class="post-content"><?php echo $post["post_content"]?></p>
                        </div>

                        <div class="post-footer">
                            <div class="post-footer-info-container">
                                <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_likes_info"; ?> >
                                    <?php echo fetchTotalLikes($conn, $post["post_id"])." Likes"; ?>
                                </div>
                                <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_comments_info"; ?>>
                                    <?php echo fetchTotalComments($conn, $post["post_id"])." Comments"; ?>
                                </div>
                                <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_dislikes_info"; ?>>
                                    <?php echo fetchTotalDislikes($conn, $post["post_id"])." Dislikes"; ?>
                                </div>
                            </div>
                            <div class="admin-post-actions-container">
                                <div class="col-md" style="display: flex; align-items: center;">
                                    <a id="goto-post-link" class="btn btn-primary" href="comment.php?id=<?php echo $post['post_id']; ?>" role="button">Go to Post</a>
                                </div>
                                <div class="delete-post-container">
                                    <button class="delete-post-button" type="submit" name="clickedPost" value="<?php echo $post['post_id']; ?>">
                                        Delete Post
                                    </button>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                else
                    echo "<p style='text-align:center'>User has no Posts</p>";
                ?>
            </div>
        </div>
    </form>
</body>
</html>