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
                    <div class="text-muted small"><?php echo date("d.m.Y, H:i", strtotime($post["created_at"])); ?></div>
                </div>
            </div>
        
            <p>
                <div style="text"><?php echo $post["post_content"]; ?></div>
            </p>
        </div>

        <!-- The infos above the Buttons at the footer of the Post. -->
        <div class="post-footer">
            <div class="post-footer-info-container">
                <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_likes_info"; ?> >
                    <?php echo fetchTotalLikes($GLOBALS["conn"], $post["post_id"])." Likes"; ?>
                </div>
                <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_comments_info"; ?>>
                    <?php echo fetchTotalComments($GLOBALS["conn"], $post["post_id"])." Comments"; ?>
                </div>
                <div class="post-footer-info" id=<?php echo "post_".$post["post_id"]."_dislikes_info"; ?>>
                    <?php echo fetchTotalDislikes($GLOBALS["conn"], $post["post_id"])." Dislikes"; ?>
                </div>
            </div>

            <!-- The Buttons at the footer of the Post. (like, comment, dislike). -->
            <div class="post-footer-interactions-container">

                <div class="post-footer-interactions">
                    <input type     = "image"
                            class   = "post-interactions-image" 
                            src     = <?php 
                                if (userInLikes($GLOBALS["conn"], $GLOBALS["active_user"]["user_id"], $post["post_id"])) {
                                    echo "images/alreadyliked.png";
                                } else {
                                    echo "images/like.png"; 
                                }
                            ?>
                            id      = <?php echo "post_".$post["post_id"]."_like_img"; ?> 
                            name    = "like_post" 
                            user_id = <?php echo $GLOBALS["active_user"]["user_id"]; ?>
                            post_id = <?php echo $post["post_id"]; ?>
                    >
                </div>

                <div class="post-footer-interactions">
                    <div>
                        <a href="comment.php?id=<?php echo $post['post_id']; ?>"> <!-- Änderung to work with comments -->
                            <img class  ="post-interactions-image"
                                src     = <?php 
                                    if (userInComments($GLOBALS["conn"], $GLOBALS["active_user"]["user_id"], $post["post_id"])) {
                                        echo "images/alreadycommented.png"; 
                                    } else {
                                        echo "images/comment.png"; 
                                    }
                                ?>
                                id      = <?php echo "post_".$post["post_id"]."_comments_img"; ?> 
                                name    = "comment_post" 
                                user_id = <?php echo $GLOBALS["active_user"]["user_id"]; ?>
                                post_id = <?php echo $post["post_id"]; ?>
                            >
                        </a>
                    </div>
                </div>

                <div class="post-footer-interactions">
                    <input type     = "image" 
                            class   = "post-interactions-image" 
                            src     = <?php 
                                if (userInDislikes($GLOBALS["conn"], $GLOBALS["active_user"]["user_id"], $post["post_id"])) {
                                    echo "images/alreadydisliked.png";
                                } else {
                                    echo "images/dislike.png"; 
                                }
                            ?>
                            id      = <?php echo "post_".$post["post_id"]."_dislike_img"; ?>
                            name    = "dislike_post" 
                            user_id = <?php echo $GLOBALS["active_user"]["user_id"]; ?>
                            post_id = <?php echo $post["post_id"]; ?>  
                    >
                </div>
            </div>
        </div>
    </div>
</div>