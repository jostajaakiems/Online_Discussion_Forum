<?php
session_start();
include("db.php");

/* ======================
   CHECK LOGIN
====================== */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* ======================
   CHECK POST ID
====================== */
if (!isset($_GET['post_id'])) {
    header("Location: view_posts.php");
    exit();
}

$post_id = (int) $_GET['post_id'];
$user_id = $_SESSION['user_id'];

/* ======================
   ADD COMMENT
====================== */
if (isset($_POST['add_comment'])) {
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

    if (!empty($comment_text)) {
        mysqli_query(
            $conn,
            "INSERT INTO comments (post_id, user_id, comment_text)
             VALUES ($post_id, $user_id, '$comment_text')"
        );
    }
}

/* ======================
   FETCH POST
====================== */
$post_sql = "
    SELECT posts.title, posts.content, posts.created_at, users.username
    FROM posts
    JOIN users ON posts.user_id = users.user_id
    WHERE posts.post_id = $post_id
";

$post_result = mysqli_query($conn, $post_sql);

if (mysqli_num_rows($post_result) === 0) {
    echo "Post not found";
    exit();
}

$post = mysqli_fetch_assoc($post_result);

/* ======================
   FETCH COMMENTS
====================== */
$comments_sql = "
    SELECT comments.comment_text, comments.created_at, users.username
    FROM comments
    JOIN users ON comments.user_id = users.user_id
    WHERE comments.post_id = $post_id
    ORDER BY comments.comment_id DESC
";

$comments_result = mysqli_query($conn, $comments_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="nav">
        <a href="view_posts.php">⬅ Back to Posts</a>
    </div>

    <h2><?php echo htmlspecialchars($post['title']); ?></h2>

    <div class="single-post">
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        <small>
            Posted by <b><?php echo htmlspecialchars($post['username']); ?></b>
            on <?php echo date("d M Y", strtotime($post['created_at'])); ?>
        </small>
    </div>

    <h3>Comments</h3>

    <?php if (mysqli_num_rows($comments_result) > 0): ?>
        <?php while ($c = mysqli_fetch_assoc($comments_result)): ?>
            <div class="comment">
                <p><?php echo nl2br(htmlspecialchars($c['comment_text'])); ?></p>
                <small>
                    By <b><?php echo htmlspecialchars($c['username']); ?></b>
                    on <?php echo date("d M Y H:i", strtotime($c['created_at'])); ?>
                </small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>

    <h3>Add Comment</h3>

    <form method="POST">
        <textarea name="comment_text" rows="4" required></textarea><br><br>
        <button type="submit" name="add_comment">Post Comment</button>
    </form>

</div>

</body>
</html>
