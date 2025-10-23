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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/home_style.css">
    <link rel="stylesheet" href="css/post_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Post</title>
</head>
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
</html>