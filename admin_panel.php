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
        deleteUser($conn,$_POST['clicked']);
    }
?>

<?php displayHeader("admin_panel", "css/home_style.css"); ?>

<body class="body-fluid">

    <?php include_once("components/navbar.php"); ?>
    
    <h1 style="margin-top: 40px; margin-left: 40px;">
        List of all users
    </h1>

    <?php $users = fetchAllUsers($conn); ?>

    <table class="table table-striped">
        <form method="post">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Email</th>
                <th scope="col">Admin</th>
                <th scope="col">Posts and Comments List</th>
                <th scope="col">Delete User</th>
            </tr>
        </thead>
        <tbody>

        <?php 
            $counter = 1;
            if (!empty($users)) {
                foreach($users as $user) {
        ?>
                    <tr>
                        <th scope="row"><?php echo $user["user_id"] ?></th>
                        <td><?php echo $user["first_name"] ?></td>
                        <td><?php echo $user["last_name"] ?></td>
                        <td><?php echo $user["email"] ?></td>
                        <td><?php echo isAdmin($conn,$user["user_id"]) ? 'Yes' : 'No' ?></td>
                        <td><a href="user_PostsAndComments.php?id=<?php echo $user['user_id']; ?>">
                                Click here to see users Posts And Comments
                            </a>
                        </td>
                        <td><?php
                            echo '<button type="submit" name="clicked" value="'.$user["user_id"].'"
                                style="background-color: rgb(200, 0, 0); color: white; border: 1px solid black; border-radius: 4px;">
                                    Delete
                                </button>';
                            ?>
                        </td>
                    </tr>
        <?php            
                }
           }
        ?>

        </tbody>
        </form>
    </table>

    <script type="text/javascript" src="scripts_js/like_dislike.js"></script>

</body>
</html>