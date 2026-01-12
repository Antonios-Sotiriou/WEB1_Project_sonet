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

    if (isset($_POST['clicked'])) {
        if ($_POST['clicked'] == $GLOBALS["active_user"]["user_id"]) {
            raise_error("You can't delete your self.");
        } else {
            deleteUser($conn,$_POST['clicked']);
            echo "<h3 style='text-align: center;'>User succesfully deleted.</h3>";
        }
    }
?>

<?php displayHeader("admin_panel", "css/home_style.css");
    echo "<link rel='stylesheet' href='css/admin_panel.css'> ";
?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>
    
    <h1 style="margin-top: 40px;text-align:center;">
        List of all users
    </h1>

    <?php $users = fetchAllUsers($conn); ?>

    <?php foreach($users as $user) { ?>
        <div class="admin-panel-main-container card flex-row">
            <div class="user-admin-panel-image-container">
                <img class ="user-admin-panel-image"
                        src   = <?php 
                            if (isset($user["img_name"])) {
                                echo "media/".md5($user["email"])."/".$user["img_name"]; 
                            } else {
                                echo "images/default_user.jpg";  
                            }
                        ?>
                >
            </div>
            <div class="user-admin-panel-info">
                <?php
                    echo "<div class='individual-info'>ID: ".$user["user_id"]."</div>";
                    echo "<div class='individual-info'>Name: ".$user["first_name"]." ".$user["last_name"]."</div>";
                    echo "<div class='individual-info'>Email: ".$user["email"]."</div>";
                    echo "<div class='individual-info'>"."Date Joined: ".date("d.m.Y, H:i", strtotime($user["date_joined"]))."</div>";
                    $is_admin = isAdmin($conn,$user["user_id"]) ? "Yes" : "No";
                    echo "<div class='individual-info'>Admin: ".$is_admin."</div>";
                    echo "<div class='individual-info'>Comments: ".fetchUserTotalComments($conn, $user["user_id"])."</div>";
                    echo "<div class='individual-info'>Posts: ".fetchUserTotalPosts($conn, $user["user_id"])."</div>";
                ?>
            </div>
            <div class="admin-panel-user-actions-container">
                <div class="goto-link-container">
                    <a id="goto-link" class="btn btn-primary" href="user_Comments.php?id=<?php echo $user['user_id']; ?>" role="button">Go to Comments</a>
                </div>
                <div class="goto-link-container">
                    <a id="goto-link" class="btn btn-primary" href="user_Posts.php?id=<?php echo $user['user_id']; ?>" role="button">Go to Posts</a>
                </div>
                <div class="delete-user-container">
                    <form method="post">
                        <button class="delete-user-button" type="submit" name="clicked" value="<?php echo $user['user_id']; ?>">
                            Delete
                        </button>              
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</body>
</html>