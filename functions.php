<?php

function dbconnect() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "web1_project_sonet";
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        echo "Connection to database failed!".$conn->connect_error;
    }

    return $conn;
}

function fetchCurrentUser() {

    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE users.email='$email'");
        while ($row = mysqli_fetch_array($query)) {
            $GLOBALS["user_id"] = $row["id"];
            $GLOBALS["first_name"] = $row["first_name"];
            $GLOBALS["last_name"] = $row["last_name"];
            $GLOBALS["email"] = $row["email"];
        }
    }
}

function fetchPosts() {
    $conn = dbconnect();
    $query = mysqli_query($conn, "SELECT * FROM posts AS p JOIN users AS u ON p.user_id = u.id;");

    while($row = $query->fetch_assoc()) {
        $posts[] = $row;
    }
    
    return $posts;
}

?>