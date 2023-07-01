<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // grab submitted data from the form
    $userName = htmlspecialchars($_POST["userName"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, 'UTF-8');
    $pwdRepeat = htmlspecialchars($_POST["pwdRepeat"], ENT_QUOTES, 'UTF-8');

    // Link necessary files
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";

    // instantiate
    $signup = new SignupContr($userName, $email, $pwd, $pwdRepeat);

    // Sign up
    $signup->signupUser();

    // If signup is successful, redirect to login page
    header("location: ../login.php");
}