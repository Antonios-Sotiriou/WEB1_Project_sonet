<?php
    session_start();
    include("components/functions.php");

    $conn = dbconnect();

    $GLOBALS["active_user"] = fetchCurrentUser($conn);
?>

<?php displayHeader("home", "css/home_style.css"); ?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>

    <?php $posts = fetchPosts($conn); ?>

    <div class="posts-container">

        <?php 
           if (!empty($posts)) {
                foreach($posts as $post) {
                    include("components/post_body.php");
                }
           }
        ?>
    </div>

    <script type="text/javascript" src="scripts_js/like_dislike.js"></script>

</body>
</html>
