<?php
    session_start();
    include("functions.php");

    $conn = dbconnect();

    if (isset($_SESSION["email"])) {
        $GLOBALS["active_user"] = fetchCurrentUser($conn);

        if(isset($_POST["postCreate"])) {
            createPost($conn, $_POST, $GLOBALS);
        }
    }
?>

<?php
    displayHeader("profile", "css/post_style.css");
    echo "<link rel='stylesheet' href='css/home_style.css'> ";
?>

<body>

    <?php include_once("shared/navbar.php"); ?>

    <div class="post-create-container">
        <div class="article-main-container">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="post-header">
                        
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="user-post-image" alt="" id="user-post-image">
                        
                        <div class="user-post-info">
                            <?php
                                echo $GLOBALS["active_user"]["first_name"].''.$GLOBALS["active_user"]["last_name"];
                            ?>
                        </div>
                    </div>

                    <div class="container" id="signIn">

                        <h1 class="form-title">What would you like to publish?</h1>
                        <form method="post" action="post.php">
                            <div class="input-group">
                                <textarea class="form-control" aria-label="With textarea" name="post_content"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary" id="post-btn" name="postCreate">Post</button>
                                <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Cancel</a>
                            </div>
                        </form>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</body>
