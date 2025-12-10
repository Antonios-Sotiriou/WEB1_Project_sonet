<?php
    session_start();
    include("components/functions.php");

    $conn = dbconnect();
    $post_id = intval($_GET['id']);

    $GLOBALS["active_user"] = fetchCurrentUser($conn);

    if (isset($_SESSION["email"])) {
        $GLOBALS["active_user"] = fetchCurrentUser($conn);

        if(isset($_POST["commentCreate"])) {
            createComment($conn, $post_id, $GLOBALS["active_user"]["user_id"], $_POST["comm_content"]);
        }
    }
?>

<?php displayHeader("home", "css/home_style.css"); ?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>

    <?php $post = fetchPostsById($conn,$post_id); ?>

    <div class="posts-container">
        <?php 
            if($post!=null ) {
                include_once("components/post_body.php");
 
                if ($GLOBALS["active_user"]["user_id"] != 0) {
        ?>
            <!-- Add comment -->
            <div class="article-main-container">
                
                <div class="card mb-4">
                    <div class="card-body">
                        
                        <div class="container" id="signIn">

                            <h3 class="form-title">Would you like to comment?</h3>
                            <form method="post" action="comment.php?id=<?php echo $post_id; ?>">
                                <div class="input-group">
                                    <textarea class="form-control" aria-label="With textarea" name="comm_content"></textarea>
                                </div>

                                <div class="pt-1">
                                    <button type="submit" class="btn btn-primary" id="post-btn" name="commentCreate">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php
                }
            } else { 
                echo "Post could not be found";
            }
        ?>
    </div>
    <!-- Print comments -->
    <div class="posts-container">

        <?php $comments = fetchComments($conn,$post_id); ?>

        <?php if($comments!=null ) {?>
            <?php foreach($comments as $comment) { ?>

                <div class="article-main-container">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="post-header">
                                
                                <img class ="user-post-image"
                                    src   = <?php 
                                                if (isset($comment["img_name"])) {
                                                    echo "media/".md5($comment["email"])."/".$comment["img_name"]; 
                                                } else {
                                                    echo "images/default_user.jpg";  
                                                }
                                            ?>
                                >
                                <div class="user-post-info">
                                    <a class="post-user-profile-link"
                                    href=<?php 
                                            echo "profile.php?firstName=".$comment["first_name"].'&lastName='.$comment["last_name"].'&user_id='.$comment["user_id"]; 
                                        ?> >
                                        <?php echo $comment["first_name"].' '.$comment["last_name"]; ?>
                                    </a>
                                    <div class="text-muted small"><?php echo date("d.m.Y, H:i", strtotime($comment["created_at"])); ?></div>
                                </div>
                            </div>
                        
                            <p>
                                <div style="text"><?php echo $comment["comm_content"]; ?></div>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
    
    <script type="text/javascript" src="scripts_js/like_dislike.js"></script>

</body>
</html>