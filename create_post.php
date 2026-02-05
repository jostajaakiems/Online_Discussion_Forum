
<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id'];

    mysqli_query($conn,
        "INSERT INTO posts (user_id, title, content)
         VALUES ('$user_id','$title','$content')"
    );

    header("Location: dashboard.php");
    exit();
}
?>

<h2>Create Post</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Post title" required><br><br>
    <textarea name="content" placeholder="Write something..." required></textarea><br><br>
    <button type="submit" name="submit">Post</button>
</form>
