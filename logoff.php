<?php
session_start();
session_destroy();               // Destroying all session details
header("Location: welcome.php"); // Redirecting To Home Page
?>