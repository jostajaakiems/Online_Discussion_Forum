<?php
session_start();
include "db.php";

$post_id = $_GET['id'];

$post = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT posts.*, users.username
     FROM posts JOIN users ON posts.user_id = users.user_id
     WHERE post_id='$post_id'")
);
?>

<h2><?php echo $post['title']; ?></h2>
<p><?php echo $post['content']; ?></p>
<small>By <?php echo $post['username']; ?></small>

<hr>

<h3>Comments</h3>

<?php
$comments = mysqli_query($conn,
    "SELECT comments.*, users.username
     FROM comments JOIN users ON comments.user_id = users.user_id
     WHERE post_id='$post_id'"
);

while ($c = mysqli_fetch_assoc($comments)) {
    echo "<p><b>{$c['username']}:</b> {$c['comment']}</p>";
}
?>

<hr>

<form method="POST">
    <textarea name="comment" required></textarea><br><br>
    <button name="send">Comment</button>
</form>

<?php
if (isset($_POST['send'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $uid = $_SESSION['user_id'];

    mysqli_query($conn,
        "INSERT INTO comments (post_id,user_id,comment)
         VALUES ('$post_id','$uid','$comment')"
    );

    header("Location: view_post.php?id=$post_id");
}
?>
