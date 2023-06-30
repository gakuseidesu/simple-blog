<?php

session_start();
session_unset();
session_destroy();

// send user to login page with no errors
header("location: ../login.php");