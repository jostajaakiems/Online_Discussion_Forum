<?php
session_start();
include("db.php");

// hakikisha user amelogin
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>All Posts</h2>

<a href="dashboard.php">⬅ Back to Dashboard</a>
<br><br>

<?php
$sql = "
    SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username
    FROM posts
    JOIN users ON posts.user_id = users.user_id
    ORDER BY posts.post_id DESC
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:15px; width:600px;'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small>Posted by <b>" . htmlspecialchars($row['username']) . "</b></small>";
        echo "</div>";
    }

} else {
    echo "<p>No posts available.</p>";
}
?>

</body>
</html>
