<?php
session_start();
include("db.php"); // hakikisha db.php iko sahihi

// Hakikisha user amelogin
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['submit'])) {

    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $content = mysqli_real_escape_string($conn, trim($_POST['content']));
    $user_id = $_SESSION['user_id'];

    // Validation
    if (empty($title) || empty($content)) {
        $message = "⚠️ Tafadhali jaza title na content.";
    } else {

        $sql = "INSERT INTO posts (user_id, title, content)
                VALUES ('$user_id', '$title', '$content')";

        if (mysqli_query($conn, $sql)) {
            $message = "✅ Post imewekwa kikamilifu.";
        } else {
            $message = "❌ Kosa limetokea, jaribu tena.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Create New Post</h2>

<!-- Message -->
<?php
if (!empty($message)) {
    echo "<p>$message</p>";
}
?>

<form method="post" action="">
    <label>Post Title</label><br>
    <input type="text" name="title" placeholder="Mfano: How to learn PHP?" style="width:300px;"><br><br>

    <label>Post Content</label><br>
    <textarea name="content" rows="5" cols="40" placeholder="Andika maelezo hapa..."></textarea><br><br>

    <button type="submit" name="submit">Post</button>
</form>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
