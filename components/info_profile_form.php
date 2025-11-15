<?php
    echo '
        <div class="container-fluid row text-center m-1">
            <div class="col col-12 col-md-6">First name</div>
            <div class="col col-12 col-md-6 linear-bg">'.$user_info["first_name"].'</div>
        </div>

        <div class="container-fluid row text-center m-1">
            <div class="col col-12 col-md-6">Last name</div>
            <div class="col col-12 col-md-6 linear-bg">'.$user_info["last_name"].'</div>
        </div>

        <div class="container-fluid row text-center m-1">
            <div class="col col-12 col-md-6">Date joined</div>
            <div class="col col-12 col-md-6 linear-bg">'.date("d.m.Y", strtotime($user_info["date_joined"])).'</div>
        </div>

        <div class="container-fluid row text-center m-1">
            <div class="col col-12 col-md-6">Total Posts</div>
            <div class="col col-12 col-md-6 linear-bg">'.$total_posts.'</div>
        </div>

        <p class="or">
        ------------------------
        </p>

        <div class="profile-cancel-btn text-center">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Home</a>
        </div>';
?>