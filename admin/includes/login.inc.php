<?php
if($_SERVER["REQUEST_METHOD"] = "POST") {
    // Grab the submitted data from the form and assign to variables
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, 'UTF-8');

    // Link necessary files
    include "../classes/dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php";

    // Instantiate
    $login = new loginContr($email, $pwd);

    // invoke the method
    $login->loginUser();

    // Redirect to dashboard if login is successful
    header("location: ../dashboard.php");
}