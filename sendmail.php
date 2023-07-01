<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = filter_input(INPUT_POST, "yourName", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "yourEmail", FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, "messageSubject", FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, "yourMessage", FILTER_SANITIZE_STRING);

    // Validate data
    if (empty($name)) {
        session_start();
        $_SESSION["formAlert"] = "Please enter your name.";
        header("location: contact.php");
        exit();
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        session_start();
        $_SESSION["formAlert"] = "Please enter your name.";
        header("location: contact.php");
        exit();
    }

    if (empty($subject)) {
        session_start();
        $_SESSION["formAlert"] = "Please enter your name.";
        header("location: contact.php");
        exit();
    }

    if (empty($message)) {
        session_start();
        $_SESSION["formAlert"] = "Please enter your name.";
        header("location: contact.php");
        exit();
    }

    // Verify reCAPTCHA response
    $recaptcha_response = $_POST['recaptcha_response'];
    $recaptcha_secret = '[key-goes-here]';

    // Make a POST request to the reCAPTCHA API
    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
    $recaptcha_data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response,
    ];

    $recaptcha_options = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($recaptcha_data),
            'header' => 'Content-Type: application/x-www-form-urlencoded'
        ],
    ];

    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_json = json_decode($recaptcha_result);

    // Check if reCAPTCHA verification was successful
    if (!$recaptcha_json->success) {
        session_start();
        $_SESSION['formAlert'] = "reCAPTCHA verification failed. Please try again.";
        header("location: contact.php");
        exit();
    }

    // send mail
    $to = "gakuseidesu@atypicalautodidactica.com";
    $headers = "From: $name <$email>" . "\r\n";
    $messageBody = "\n\n$message";

    if (mail($to, $subject, $messageBody, $headers)) {
        session_start();
        $_SESSION["formAlert"] = "Thank you for your message. We'll get back to you shortly.";
        header("location: contact.php");
        exit();
    } else {
        session_start();
        $_SESSION[formAlert] = "Oops! Something went wrong. Please try again.";
        header("location: contact.php");
        exit();
    }

}
