
<?php
session_start();
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

<div class="header">
    <h2>Online Discussion Forum</h2>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <div class="card">
        <h3>Welcome, <?php echo $_SESSION['username']; ?> 👋</h3>
        <p>You are successfully logged in.</p>
    </div>
</div>
<?php
include "db.php";
$result = mysqli_query($conn,
    "SELECT posts.*, users.username
     FROM posts
     JOIN users ON posts.user_id = users.user_id
     ORDER BY post_id DESC"
);

while ($row = mysqli_fetch_assoc($result)) {
?>
<div class="card">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['content']; ?></p>
    <small>Posted by <?php echo $row['username']; ?></small><br>
    <a href="view_post.php?id=<?php echo $row['post_id']; ?>">View comments</a>
</div>
<?php } ?>

</body>
</html>
