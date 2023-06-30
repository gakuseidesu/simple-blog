<?php
session_start();

// Check if user is logged in. If not, then redirect to login
if(!isset($_SESSION["isLoggedInToSimpleBlog"]) && $_SESSION["isLoggedInToSimpleBlog"] != "true") {
    header("Location: login.php");
    exit();
}