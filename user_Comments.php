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
    echo "<link rel='stylesheet' href='css/user_comments.css'>";
?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>
    
    <p>
        <a id="go-back-link" class="btn btn-primary" href="admin_panel.php" role="button" id="cancel-btn">Go Back</a>
    </p>

    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $comments = fetchAllUserComments($conn, $id);
            $user = fetchUserById($conn,$id);
        }
    ?>

    <div class="text-center mx-auto" style="width: 80vw; border-bottom: 3px solid black; padding-bottom: 10px;">
        <h1>
            User <?php echo $user["first_name"]." ".$user["last_name"]?>
        </h1>
    </div>

    <form method="post">
    <div class="posts-container">
        <div class="article-main-container">
            <h1 style="text-align: center;">Comments list</h1>
            <?php  
            if(isset($comments))
                foreach($comments as $comment){
            ?>
            <div class="admin-panel-comment">
                <div>
                    <div class ="card md-4">
                        <div class="comment-id-container">
                            Comment ID: #<?php echo $comment["comm_id"]?>
                        </div>
                        <div class="comment-date-container">
                            <?php echo "Created at: ".date("d.m.Y, H:i", strtotime($comment["created_at"])); ?>
                        </div>
                        <div>
                            <p class="comment-content"><?php echo $comment["comm_content"]?></p>
                        </div>
                        <div class="post-footer">
                            <div class="admin-comment-actions-container">   
                                <div class="goto-comment-link-container">
                                    <a id="goto-comment-link" class="btn btn-primary" href="comment.php?id=<?php echo $comment['post_id']."#".$comment['comm_id']; ?>" role="button">Go to Comment</a>
                                </div>
                                <div class="delete-comment-container">
                                    <button class="delete-comment-button" type="submit" name="clickedComment" value="<?php echo $comment['comm_id']; ?>">
                                        Delete
                                    </button>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            else
                echo "<p style='text-align:center'>User has no Comments</p>";
            ?>
        </div>
    </div>
    
    </form>
</body>
</html>