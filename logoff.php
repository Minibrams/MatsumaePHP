<?php
session_start();
session_destroy();               // Destroying all session details
header("Location: index.php"); // Redirecting To Home Page
?>