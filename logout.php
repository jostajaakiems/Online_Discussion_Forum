<?php
session_start();

// Ondoa data zote za session
session_unset();

// Vunja session kabisa
session_destroy();

// Rudisha user login page
header("Location: login.php");
exit();
