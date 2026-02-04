<?php
$conn = mysqli_connect("localhost", "root", "", "online_discussion_forum");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
