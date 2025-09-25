<?php
    session_start();
    include("connect.php");

    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE users.email='$email'");
        while ($row = mysqli_fetch_array($query)) {
                $GLOBALS["user_id"] = $row["id"];
                $GLOBALS["first_name"] = $row["first_name"];
                $GLOBALS["last_name"] = $row["last_name"];
                $GLOBALS["email"] = $row["email"];
                // $GLOBALS["profile_photo_url"] = $row["profile_photo_url"];
        }
    }
?>
<?php
    $names = ["Antonios", "Georgios", "Panagiotis", "Nikolaos", "Artemisia"];
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

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php" id="nav-app-name">Sonet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
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

                    <div class="container" id="user-image">
                        <img src="images/default_user.jpg" alt="" width="30" height="24">
                    </div>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

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

    <div class="posts-container">
        <!-- <div class="col"> -->
            <div class="article-main-container">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="post-header" style="display: flex;">
                            
                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="user-post-image" alt="" id="user-post-image">
                            
                            <div class="user-post-info">
                                Kenneth Frazier
                                <div class="text-muted small">3 days ago</div>
                            </div>
                        </div>
                    
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus finibus commodo bibendum. Vivamus laoreet blandit odio, vel finibus quam dictum ut.
                        </p>
                    </div>

                    <!-- The infos above the Buttons at the footer of the Post. -->
                    <div class="post-footer">
                        <div class="post-footer-info-container">
                            <div class="post-footer-info">
                                123 Likes
                            </div>
                            <div class="post-footer-info">
                                12 Comments
                            </div>
                            <div class="post-footer-info">
                                32 Dislikes
                            </div>
                        </div>

                        <!-- The Buttons at the footer of the Post. -->
                        <div class="post-footer-interactions-container">

                            <div class="post-footer-interactions">
                                <form action="" method="post">
                                    <input type="image" alt="" class="post-interactions-image" src="images/like.png">
                                </form>
                            </div>

                            <div class="post-footer-interactions">
                                <input type="image" class="post-interactions-image" src="images/comment.png" alt="">
                            </div>

                            <div class="post-footer-interactions">
                                <form action="" method="post">
                                    <input type="image" alt="" class="post-interactions-image" src="images/dislike.png">
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>

    <div style="text-align:center; padding:15%;">
        <p style="font-size:50px; font-weight:bold;">
            Hello
            <?php
                if (isset($_SESSION["email"])) {
                    $email = $_SESSION["email"];
                    $query = mysqli_query($conn, "SELECT * FROM users WHERE users.email='$email'");
                    while ($row = mysqli_fetch_array($query)) {
                        echo $GLOBALS["first_name"].''.$GLOBALS["last_name"];
                    }
                } else {
                    echo "You are not Logged in!";
                }
            ?>
        </p>
    </div>

    <!-- <?php foreach($names as $name) { ?>
        <h1>
            <?= $name ?>
        </h1>
    <?php } ?> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>