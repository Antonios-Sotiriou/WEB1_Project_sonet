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

<?php displayHeader("admin_panel", "css/home_style.css"); ?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>
    
    <p>
        <a href="admin_panel.php"> /Previous page</a>
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
            <div style="margin-top: 25px;">
                <div>
                <b>Comment with id: #<?php echo $comment["comm_id"]?></b>
                    <div class ="card md-4">
                        <div class="text-muted small">
                            <?php echo "Comment created at: ".date("d.m.Y, H:i", strtotime($comment["created_at"])); ?>
                        </div>
                        <div>
                            <p  style="padding: 15px;"><?php echo $comment["comm_content"]?></p>
                        </div>
                        <div class="post-footer">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md" style="display: flex; align-items: center;">
                                        <a href="comment.php?id=<?php echo $comment['post_id']."#".$comment['comm_id']; ?>">
                                            Find Comment
                                        </a>
                                    </div>
                                    <div class="col-md" style="text-align: right;">
                                        <button type="submit" name="clickedComment" value="<?php echo $comment['comm_id']; ?>"
                                                style="background-color: rgb(255, 52, 52); color: white; border: 1px solid #0a53be; border-radius: 4px;
                                                margin: 6px">
                                                Delete Comment
                                        </button>
                                    </div>
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
    

    <script type="text/javascript" src="scripts_js/like_dislike.js"></script>

</body>
</html>