<?php
session_start();

// hakikisha user amelogin
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

<p>Select what you want to do:</p>

<ul>
    <li><a href="create_post.php">➕ Create New Post</a></li>
    <li><a href="view_posts.php">📄 View Posts</a></li>
    <li><a href="logout.php">🚪 Logout</a></li>
</ul>

</body>
</html>
