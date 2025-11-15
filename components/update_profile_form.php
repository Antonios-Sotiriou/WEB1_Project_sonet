<?php
    echo '
        <form method="post" action="profile.php" enctype="multipart/form-data">

            <div class="input-group">
                <input type="text" name="firstName" id="first-name" placeholder="First Name">
                <label for="first-name">'.$GLOBALS["active_user"]["first_name"].'</label>
            </div>
            <div class="input-group">
                <input type="text" name="lastName" id="last-name" placeholder="Last Name">
                <label for="last-name">'.$GLOBALS["active_user"]["last_name"].'</label>
            </div>

            <div>
                <div>
                    <small class="custom-file-label" for="inputGroupFile">Upload a profile photo</small>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile" name="uploadPhoto">
                </div>
            </div>

            <input type="submit" class="btn-submit" value="Update" name="profileUpdate">
        </form>

        <p class="or">
        ---------- or ----------
        </p>

        <div class="profile-cancel-btn text-center">
            <a class="btn btn-primary" href="home.php" role="button" id="cancel-btn">Cancel</a>
        </div>';
?>