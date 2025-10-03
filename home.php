<?php
    session_start();
    include("functions.php");

    $conn = dbconnect();

    $GLOBALS["active_user"] = fetchCurrentUser($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Home</title>
</head>
<body class="body-fluid">

    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav-bar">
        <div class="container-fluid">

            <a class="navbar-brand" href="home.php" id="nav-app-name">Sonet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <?php echo $GLOBALS["active_user"]["first_name"].' '.$GLOBALS["active_user"]["last_name"] ?>
    
                <ul class="navbar-nav">

                   <!-- REGISTER OR LOGIN -->
                    <?php
                        if (!isset($_SESSION["email"])) {

                            echo "<li class='nav-item'>
                                    <a class='nav-link' href='register.php'>Register</a>
                                </li>";

                            echo "<li class='nav-item'>
                                    <a class='nav-link' href='login.php'>Login</a>
                                </li>";
                        }
                    ?>

                    <div class="user-image-container" id="user-image">
                        <img class="navbar-user-image" src= <?php echo $GLOBALS["active_user"]["profile_image"] ?> alt="" width="30" height="24">
                    </div>

                    <li class="nav-item dropdown" id="dropdown-menu-id">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" id="drop-down-window">

                            <!-- REGISTER OR LOGIN -->
                                <?php
                                    if (!isset($_SESSION["email"])) {

                                        echo "<li>
                                                <a class='dropdown-item' href='register.php'>Register</a>
                                            </li>";

                                        echo "<li>
                                                <a class='dropdown-item' href='login.php'>Login</a>
                                            </li>";
                                    } else {

                                        echo "<li>
                                                <a class='dropdown-item' href='post.php'>Post</a>
                                            </li>";

                                        echo "<li>
                                                <a class='dropdown-item' href='profile.php'>Profile</a>
                                            </li>";

                                        echo "<li>
                                                <a class='dropdown-item' href='admin_panel.php'>Admin Panel</a>
                                            </li>";
                                        
                                        echo "<li>
                                                <a class='dropdown-item' href='logout.php'>Logout</a>
                                            </li>";
                                    }
                                ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php $posts = fetchPosts(); ?>

    <div class="posts-container">

        <?php foreach($posts as $post) { ?>

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
                                <?php echo $post["first_name"].' '.$post["last_name"] ?>
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

                        <!-- The Buttons at the footer of the Post. -->
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

        <?php
            }
        ?>
    </div>

    <script type="text/javascript" src="scripts_js/like_dislike.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
