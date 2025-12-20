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
    

    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $posts = fetchAllUserPosts($conn, $id);
            $comments = fetchAllUserComments($conn, $id);
            $user = fetchUserById($conn,$id);
        }
    ?>
    <form method="post">
    <div>
        <h1>Posts of <?php echo $user["first_name"]." ".$user["last_name"]?></h1>
        <?php  
        if(isset($posts))
            foreach($posts as $post){
        ?>
        <div style="margin-top: 25px;">
            <div>
            <b>Post with id: #<?php echo $post["post_id"]?></b>
                <div style="padding: 5px;margin: 5px;width: 50%;background-color:white">
                    <p><?php echo $post["post_content"]?></p>
                    <div style="text-align: right;">
                        <button type="submit" name="clickedPost" value="<?php echo $post['post_id']; ?>"
                                style="background-color: rgb(200, 0, 0); color: white; border: 1px solid black; border-radius: 4px;">
                                Delete Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        else
            echo "User has no Posts";
        ?>
    </div>

    <div>
        <h1>Comments of <?php echo $user["first_name"]." ".$user["last_name"]?></h1>
        <?php  
        if(isset($comments))
            foreach($comments as $comment){
        ?>
        <div style="margin-top: 25px;">
            <div>
            <b>Comment with id: #<?php echo $comment["comm_id"]?></b>
                <div style="padding: 5px;margin: 5px;width: 50%;background-color:white">
                    <p><?php echo $comment["comm_content"]?></p>
                    <div style="text-align: right;">
                        <button type="submit" name="clickedComment" value="<?php echo $comment['comm_id']; ?>"
                                style="background-color: rgb(200, 0, 0); color: white; border: 1px solid black; border-radius: 4px;">
                                Delete Comment
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        else
            echo "User has no Comments";
        ?>
    </div>
    </form>
    <p>
        <a href="admin_panel.php">Go back.</a>
    </p>
    

    <script type="text/javascript" src="scripts_js/like_dislike.js"></script>

</body>
</html>