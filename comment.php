<?php
    session_start();
    include("components/functions.php");

    $conn = dbconnect();
    $post_id = intval($_GET['id']);

    $GLOBALS["active_user"] = fetchCurrentUser($conn);

    if (isset($_SESSION["email"])) {
        $GLOBALS["active_user"] = fetchCurrentUser($conn);

        if(isset($_POST["commentCreate"])) {
            $user_id = $GLOBALS["active_user"]["user_id"];
            $content = $_POST["comm_content"];
            $insertQuery = "INSERT INTO comments(post_id,user_id, comm_content) VALUES ($post_id,'$user_id','$content')";
            if ($conn->query($insertQuery) == TRUE) {
                echo "$content";
                header("location: comment.php?id=$post_id");
            } else {
                echo "An error has occured!".$conn->error;
            }
        }
    }
?>

<?php displayHeader("home", "css/home_style.css"); ?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>

    <?php $post = fetchPostsById($conn,$post_id); ?>

    <?php if($post!=null ) {?>
        <div class="posts-container">
            <div class="article-main-container">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="post-header">
                            
                            <img class ="user-post-image"
                                    src   = <?php 
                                            if (isset($post["img_name"])) {
                                                echo "media/".md5($post["email"])."/".$post["img_name"]; 
                                            } else {
                                                echo "images/default_user.jpg";  
                                            }
                                            ?>
                            >
                            <div class="user-post-info">
                                <a class="post-user-profile-link"
                                    href=<?php 
                                        echo "profile.php?firstName=".$post["first_name"].'&lastName='.$post["last_name"].'&user_id='.$post["user_id"]; 
                                    ?> >
                                    <?php echo $post["first_name"].' '.$post["last_name"]; ?>
                                </a>
                                <div class="text-muted small"><?php echo $post["created_at"] ?></div>
                            </div>
                        </div>
                    
                        <p>
                            <div style="text"><?php echo $post["post_content"] ?></div>
                        </p>
                    </div>

                    <!-- The infos above the Buttons at the footer of the Post. -->
                    <div class="post-footer">
                        <div class="post-footer-info-container">
                            <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_likes_info" ?> >
                                <?php echo fetchTotalLikes($GLOBALS["conn"], $post["post_id"])." Likes" ?>
                            </div>
                            <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_comments_info" ?>>
                                <?php echo fetchTotalComments($GLOBALS["conn"], $post["post_id"])." Comments" ?>
                            </div>
                            <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_dislikes_info" ?>>
                                <?php echo fetchTotalDislikes($GLOBALS["conn"], $post["post_id"])." Dislikes" ?>
                            </div>
                        </div>

                        <!-- The Buttons at the footer of the Post. (like, comment, dislike). -->
                        <div class="post-footer-interactions-container">

                            <div class="post-footer-interactions">
                                <input type     = "image"
                                        class   = "post-interactions-image" 
                                        src     = <?php 
                                                        if (userInLikes($GLOBALS["active_user"]["user_id"], $post["post_id"])) {
                                                            echo "images/alreadyliked.png";
                                                        } else {
                                                            echo "images/like.png"; 
                                                        }
                                                    ?>
                                        id      = <?php echo "post_".$post["post_id"]."_like_img" ?> 
                                        name    = "like_post" 
                                        user_id = <?php echo $GLOBALS["active_user"]["user_id"] ?>
                                        post_id = <?php echo $post["post_id"] ?>
                                >
                            </div>

                            <div class="post-footer-interactions">
                                <div>
                                    <a href="comment.php?id=<?php echo $post['post_id']; ?>"> <!-- Änderung to work with comments -->
                                        <img class  ="post-interactions-image"
                                            src     = <?php 
                                                        if (userInComments($GLOBALS["active_user"]["user_id"], $post["post_id"])) {
                                                            echo "images/alreadycommented.png"; 
                                                        } else {
                                                            echo "images/comment.png"; 
                                                        }
                                                    ?>
                                            id      = <?php echo "post_".$post["post_id"]."_comments_img" ?> 
                                            name    = "comment_post" 
                                            user_id = <?php echo $GLOBALS["active_user"]["user_id"] ?>
                                            post_id = <?php echo $post["post_id"] ?>
                                        >
                                    </a>
                                </div>
                            </div>

                            <div class="post-footer-interactions">
                                <input type   = "image" 
                                        class = "post-interactions-image" 
                                        src     = <?php 
                                                        if (userInDislikes($GLOBALS["active_user"]["user_id"], $post["post_id"])) {
                                                            echo "images/alreadydisliked.png";
                                                        } else {
                                                            echo "images/dislike.png"; 
                                                        }
                                                    ?>
                                        id    = <?php echo "post_".$post["post_id"]."_dislike_img" ?>
                                        name  = "dislike_post" 
                                        user_id = <?php echo $GLOBALS["active_user"]["user_id"] ?>
                                        post_id = <?php echo $post["post_id"] ?>  
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    
    <!-- Add comment -->
    <div class="article-main-container">
        
            <div class="card mb-4">
                <div class="card-body">
                    
                    <div class="container" id="signIn">

                        <h3 class="form-title">Whould you like to comment?</h3>
                        <form method="post" action="comment.php?id=<?php echo $post_id; ?>">
                            <div class="input-group">
                                <textarea class="form-control" aria-label="With textarea" name="comm_content"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary" id="post-btn" name="commentCreate">Post</button>
                            </div>
                        </form>

                    </div>
                    
                </div>
            </div>
        
    </div>

    <?php 
    }
    else 
        echo "Post could not be found";
    ?>

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
                                </div>
                            </div>
                        
                            <p>
                                <div style="text"><?php echo $comment["comm_content"] ?></div>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        <?php
        }
        ?>
    </div>
    
    <script type="text/javascript" src="scripts_js/like_dislike.js"></script>

</body>
</html>
